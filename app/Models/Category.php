<?php

class FreshRSS_Category extends Minz_Model {

	/**
	 * Normal
	 * @var int
	 */
	const KIND_NORMAL = 0;

	/**
	 * Category tracking a third-party Dynamic OPML
	 * @var int
	 */
	const KIND_DYNAMIC_OPML = 2;

	const TTL_DEFAULT = 0;

	/**
	 * @var int
	 */
	private $id = 0;
	/** @var int */
	private $kind = 0;
	private $name;
	private $nbFeeds = -1;
	private $nbNotRead = -1;
	/** @var array<FreshRSS_Feed>|null */
	private $feeds = null;
	private $hasFeedsWithError = false;
	private $attributes = [];
	/** @var int */
	private $lastUpdate = 0;
	/** @var bool */
	private $error = false;

	public function __construct(string $name = '', $feeds = null) {
		$this->_name($name);
		if (isset($feeds)) {
			$this->_feeds($feeds);
			$this->nbFeeds = 0;
			$this->nbNotRead = 0;
			foreach ($feeds as $feed) {
				$this->nbFeeds++;
				$this->nbNotRead += $feed->nbNotRead();
				$this->hasFeedsWithError |= $feed->inError();
			}
		}
	}

	public function id(): int {
		return $this->id;
	}
	public function kind(): int {
		return $this->kind;
	}
	public function name(): string {
		return $this->name;
	}
	public function lastUpdate(): int {
		return $this->lastUpdate;
	}
	public function _lastUpdate(int $value) {
		$this->lastUpdate = $value;
	}
	public function inError(): bool {
		return $this->error;
	}
	public function _error($value) {
		$this->error = (bool)$value;
	}
	public function isDefault(): bool {
		return $this->id == FreshRSS_CategoryDAO::DEFAULTCATEGORYID;
	}
	public function nbFeeds(): int {
		if ($this->nbFeeds < 0) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$this->nbFeeds = $catDAO->countFeed($this->id());
		}

		return $this->nbFeeds;
	}
	public function nbNotRead(): int {
		if ($this->nbNotRead < 0) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$this->nbNotRead = $catDAO->countNotRead($this->id());
		}

		return $this->nbNotRead;
	}

	/** @return array<FreshRSS_Feed> */
	public function feeds(): array {
		if ($this->feeds === null) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$this->feeds = $feedDAO->listByCategory($this->id());
			$this->nbFeeds = 0;
			$this->nbNotRead = 0;
			foreach ($this->feeds as $feed) {
				$this->nbFeeds++;
				$this->nbNotRead += $feed->nbNotRead();
				$this->hasFeedsWithError |= $feed->inError();
			}

			usort($this->feeds, function ($a, $b) {
				return strnatcasecmp($a->name(), $b->name());
			});
		}

		return $this->feeds;
	}

	public function hasFeedsWithError() {
		return $this->hasFeedsWithError;
	}

	public function attributes($key = '') {
		if ($key == '') {
			return $this->attributes;
		} else {
			return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
		}
	}

	public function _id($id) {
		$this->id = intval($id);
		if ($id == FreshRSS_CategoryDAO::DEFAULTCATEGORYID) {
			$this->_name(_t('gen.short.default_category'));
		}
	}

	public function _kind(int $kind) {
		$this->kind = $kind;
	}

	public function _name($value) {
		$this->name = mb_strcut(trim($value), 0, 255, 'UTF-8');
	}
	/** @param array<FreshRSS_Feed>|FreshRSS_Feed $values */
	public function _feeds($values) {
		if (!is_array($values)) {
			$values = array($values);
		}

		$this->feeds = $values;
	}

	/**
	 * To manually add feeds to this category (not committing to database).
	 * @param FreshRSS_Feed $feed
	 */
	public function addFeed($feed) {
		if ($this->feeds === null) {
			$this->feeds = [];
		}
		$this->feeds[] = $feed;
	}

	public function _attributes($key, $value) {
		if ('' == $key) {
			if (is_string($value)) {
				$value = json_decode($value, true);
			}
			if (is_array($value)) {
				$this->attributes = $value;
			}
		} elseif (null === $value) {
			unset($this->attributes[$key]);
		} else {
			$this->attributes[$key] = $value;
		}
	}

	public static function cacheFilename(string $url, array $attributes): string {
		$simplePie = customSimplePie($attributes);
		$filename = $simplePie->get_cache_filename($url);
		return CACHE_PATH . '/' . $filename . '.opml.xml';
	}

	public function refreshDynamicOpml(): bool {
		$url = $this->attributes('opml_url');
		if ($url == '') {
			return false;
		}
		$ok = true;
		$attributes = [];	//TODO
		$cachePath = self::cacheFilename($url, $attributes);
		$opml = httpGet($url, $cachePath, 'opml', $attributes);
		if ($opml == '') {
			Minz_Log::warning('Error getting dynamic OPML for category ' . $this->id() . '! ' .
				SimplePie_Misc::url_remove_credentials($url));
			$ok = false;
		} else {
			$dryRunCategory = new FreshRSS_Category();
			$importService = new FreshRSS_Import_Service();
			$importService->importOpml($opml, $dryRunCategory, true, true);
			if ($importService->lastStatus()) {
				$feedDAO = FreshRSS_Factory::createFeedDao();

				/** @var array<string,FreshRSS_Feed> */
				$dryRunFeeds = [];
				foreach ($dryRunCategory->feeds() as $dryRunFeed) {
					$dryRunFeeds[$dryRunFeed->url()] = $dryRunFeed;
				}

				/** @var array<string,FreshRSS_Feed> */
				$existingFeeds = [];
				foreach ($this->feeds() as $existingFeed) {
					$existingFeeds[$existingFeed->url()] = $existingFeed;
					if (empty($dryRunFeeds[$existingFeed->url()])) {
						// The feed does not exist in the new dynamic OPML, so mute (disable) that feed
						$existingFeed->_mute(true);
						$ok &= ($feedDAO->updateFeed($existingFeed->id(), [
							'ttl' => $existingFeed->ttl(true),
						]) !== false);
					}
				}

				foreach ($dryRunCategory->feeds() as $dryRunFeed) {
					if (empty($existingFeeds[$dryRunFeed->url()])) {
						// The feed does not exist in the current category, so add that feed
						$dryRunFeed->_categoryId($this->id());
						$ok &= ($feedDAO->addFeedObject($dryRunFeed) !== false);
					} else {
						$existingFeed = $existingFeeds[$dryRunFeed->url()];
						if ($existingFeed->mute()) {
							// The feed already exists in the current category but was muted (disabled), so unmute (enable) again
							$existingFeed->_mute(false);
							$ok &= ($feedDAO->updateFeed($existingFeed->id(), [
								'ttl' => $existingFeed->ttl(true),
							]) !== false);
						}
					}
				}
			} else {
				$ok = false;
				Minz_Log::warning('Error loading dynamic OPML for category ' . $this->id() . '! ' .
					SimplePie_Misc::url_remove_credentials($url));
			}
		}

		$catDAO = FreshRSS_Factory::createCategoryDao();
		$catDAO->updateLastUpdate($this->id(), !$ok);

		return $ok;
	}
}

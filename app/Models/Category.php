<?php

class FreshRSS_Category extends Minz_Model {

	/**
	 * Normal
	 */
	public const KIND_NORMAL = 0;

	/**
	 * Category tracking a third-party Dynamic OPML
	 */
	public const KIND_DYNAMIC_OPML = 2;

	private int $id = 0;
	private int $kind = 0;
	private string $name;
	private int $nbFeeds = -1;
	private int $nbNotRead = -1;
	/** @var array<FreshRSS_Feed>|null */
	private ?array $feeds = null;
	/** @var bool|int */
	private $hasFeedsWithError = false;
	/** @var array<string,mixed> */
	private array $attributes = [];
	private int $lastUpdate = 0;
	private bool $error = false;

	/**
	 * @param array<FreshRSS_Feed>|null $feeds
	 */
	public function __construct(string $name = '', ?array $feeds = null) {
		$this->_name($name);
		if ($feeds !== null) {
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
	/** @return string HTML-encoded name of the category */
	public function name(): string {
		return $this->name;
	}
	public function lastUpdate(): int {
		return $this->lastUpdate;
	}
	public function _lastUpdate(int $value): void {
		$this->lastUpdate = $value;
	}
	public function inError(): bool {
		return $this->error;
	}

	/** @param bool|int $value */
	public function _error($value): void {
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

	/**
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public function nbNotRead(): int {
		if ($this->nbNotRead < 0) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$this->nbNotRead = $catDAO->countNotRead($this->id());
		}

		return $this->nbNotRead;
	}

	/**
	 * @return array<FreshRSS_Feed>
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
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

			$this->sortFeeds();
		}

		return $this->feeds ?? [];
	}

	public function hasFeedsWithError(): bool {
		return (bool)($this->hasFeedsWithError);
	}

	/**
	 * @phpstan-return ($key is non-empty-string ? mixed : array<string,mixed>)
	 * @return array<string,mixed>|mixed|null
	 */
	public function attributes(string $key = '') {
		if ($key === '') {
			return $this->attributes;
		} else {
			return $this->attributes[$key] ?? null;
		}
	}

	public function _id(int $id): void {
		$this->id = $id;
		if ($id === FreshRSS_CategoryDAO::DEFAULTCATEGORYID) {
			$this->_name(_t('gen.short.default_category'));
		}
	}

	public function _kind(int $kind): void {
		$this->kind = $kind;
	}

	public function _name(string $value): void {
		$this->name = mb_strcut(trim($value), 0, FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE, 'UTF-8');
	}

	/** @param array<FreshRSS_Feed>|FreshRSS_Feed $values */
	public function _feeds($values): void {
		if (!is_array($values)) {
			$values = [$values];
		}

		$this->feeds = $values;
		$this->sortFeeds();
	}

	/**
	 * To manually add feeds to this category (not committing to database).
	 */
	public function addFeed(FreshRSS_Feed $feed): void {
		if ($this->feeds === null) {
			$this->feeds = [];
		}
		$this->feeds[] = $feed;

		$this->sortFeeds();
	}

	/** @param string|array<mixed>|bool|int|null $value Value, not HTML-encoded */
	public function _attributes(string $key, $value): void {
		if ('' === $key) {
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

	/**
	 * @param array<string> $attributes
	 * @throws FreshRSS_Context_Exception
	 */
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
			$importService->importOpml($opml, $dryRunCategory, true);
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

		return (bool)$ok;
	}

	private function sortFeeds(): void {
		if ($this->feeds === null) {
			return;
		}
		usort($this->feeds, static function (FreshRSS_Feed $a, FreshRSS_Feed $b) {
			return strnatcasecmp($a->name(), $b->name());
		});
	}
}

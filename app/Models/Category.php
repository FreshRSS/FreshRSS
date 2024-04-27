<?php
declare(strict_types=1);

class FreshRSS_Category extends Minz_Model {
	use FreshRSS_AttributesTrait, FreshRSS_FilterActionsTrait;

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
	private int $lastUpdate = 0;
	private bool $error = false;

	/**
	 * @param array<FreshRSS_Feed>|null $feeds
	 */
	public function __construct(string $name = '', int $id = 0, ?array $feeds = null) {
		$this->_id($id);
		$this->_name($name);
		if ($feeds !== null) {
			$this->_feeds($feeds);
			$this->nbFeeds = 0;
			$this->nbNotRead = 0;
			foreach ($feeds as $feed) {
				$feed->_category($this);
				$this->nbFeeds++;
				$this->nbNotRead += $feed->nbNotRead();
				$this->hasFeedsWithError |= ($feed->inError() && !$feed->mute());
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

	/** @return array<int,mixed> */
	public function curlOptions(): array {
		return [];	// TODO (e.g., credentials for Dynamic OPML)
	}

	/**
	 * @return array<int,FreshRSS_Feed>
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
				$this->hasFeedsWithError |= ($feed->inError() && !$feed->mute());
			}
			$this->sortFeeds();
		}
		return $this->feeds ?? [];
	}

	public function hasFeedsWithError(): bool {
		return (bool)($this->hasFeedsWithError);
	}

	public function _id(int $id): void {
		$this->id = $id;
		if ($id === FreshRSS_CategoryDAO::DEFAULTCATEGORYID) {
			$this->name = _t('gen.short.default_category');
		}
	}

	public function _kind(int $kind): void {
		$this->kind = $kind;
	}

	public function _name(string $value): void {
		if ($this->id !== FreshRSS_CategoryDAO::DEFAULTCATEGORYID) {
			$this->name = mb_strcut(trim($value), 0, FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE, 'UTF-8');
		}
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
		$feed->_category($this);
		$this->feeds[] = $feed;
		$this->sortFeeds();
	}

	/**
	 * @throws FreshRSS_Context_Exception
	 */
	public function cacheFilename(string $url): string {
		$simplePie = customSimplePie($this->attributes(), $this->curlOptions());
		$filename = $simplePie->get_cache_filename($url);
		return CACHE_PATH . '/' . $filename . '.opml.xml';
	}

	public function refreshDynamicOpml(): bool {
		$url = $this->attributeString('opml_url');
		if ($url == null) {
			return false;
		}
		$ok = true;
		$cachePath = $this->cacheFilename($url);
		$opml = httpGet($url, $cachePath, 'opml', $this->attributes(), $this->curlOptions());
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
						$dryRunFeed->_category($this);
						$ok &= ($feedDAO->addFeedObject($dryRunFeed) !== false);
						$existingFeeds[$dryRunFeed->url()] = $dryRunFeed;
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
		uasort($this->feeds, static function (FreshRSS_Feed $a, FreshRSS_Feed $b) {
			return strnatcasecmp($a->name(), $b->name());
		});
	}

	/**
	 * Access cached feed
	 * @param array<FreshRSS_Category> $categories
	 */
	public static function findFeed(array $categories, int $feed_id): ?FreshRSS_Feed {
		foreach ($categories as $category) {
			foreach ($category->feeds() as $feed) {
				if ($feed->id() === $feed_id) {
					$feed->_category($category);	// Should already be done; just to be safe
					return $feed;
				}
			}
		}
		return null;
	}

	/**
	 * Access cached feeds
	 * @param array<FreshRSS_Category> $categories
	 * @return array<int,FreshRSS_Feed>
	 */
	public static function findFeeds(array $categories): array {
		$result = [];
		foreach ($categories as $category) {
			foreach ($category->feeds() as $feed) {
				$result[$feed->id()] = $feed;
			}
		}
		return $result;
	}

	/**
	 * @param array<FreshRSS_Category> $categories
	 */
	public static function countUnread(array $categories, int $minPriority = 0): int {
		$n = 0;
		foreach ($categories as $category) {
			foreach ($category->feeds() as $feed) {
				if ($feed->priority() >= $minPriority) {
					$n += $feed->nbNotRead();
				}
			}
		}
		return $n;
	}
}

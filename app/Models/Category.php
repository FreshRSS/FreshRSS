<?php
declare(strict_types=1);

namespace FreshRss\Models;

use FreshRss\Exceptions\ContextException;
use FreshRss\Minz\ConfigurationNamespaceException;
use FreshRss\Minz\Log;
use FreshRss\Minz\Model;
use FreshRss\Minz\PDOConnectionException;
use FreshRss\Services\ImportService;
use FreshRss\Utils\HttpUtil;

class Category extends Model {
	use AttributesTrait, FilterActionsTrait;

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
	/** Number of unread articles in feeds with visibility Feed::PRIORITY_FEED */
	private int $nbNotRead = -1;
	/** @var array<int,Feed>|null where the key is the feed ID */
	private ?array $feeds = null;
	private bool|int $hasFeedsWithError = false;
	private int $lastUpdate = 0;
	private bool $error = false;

	/**
	 * @param array<Feed>|null $feeds
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
				if ($feed->priority() > Feed::PRIORITY_HIDDEN) {
					$this->nbNotRead += $feed->nbNotRead();
					$this->hasFeedsWithError |= ($feed->inError() && !$feed->mute());
				}
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

	/**
	 * @param int|numeric-string $value
	 * 32-bit systems provide a string and will fail in year 2038
	 */
	public function _lastUpdate(int|string $value): void {
		$this->lastUpdate = (int)$value;
	}

	public function inError(): bool {
		return $this->error;
	}

	public function _error(bool|int $value): void {
		$this->error = (bool)$value;
	}
	public function isDefault(): bool {
		return $this->id == CategoryDAO::DEFAULTCATEGORYID;
	}
	public function nbFeeds(): int {
		if ($this->nbFeeds < 0) {
			$catDAO = Factory::createCategoryDao();
			$this->nbFeeds = $catDAO->countFeed($this->id());
		}

		return $this->nbFeeds;
	}

	/**
	 * @throws ConfigurationNamespaceException
	 * @throws PDOConnectionException
	 */
	public function nbNotRead(int $minPriority = Feed::PRIORITY_FEED): int {
		if ($this->nbNotRead > 0 && $minPriority === Feed::PRIORITY_FEED) {
			return $this->nbNotRead;
		}
		if ($this->feeds === null) {
			$catDAO = Factory::createCategoryDao();
			$nb = $catDAO->countNotRead($this->id(), $minPriority);
			if ($minPriority === Feed::PRIORITY_FEED) {
				$this->nbNotRead = $nb;
			}
			return $nb;
		}
		$nb = 0;
		foreach ($this->feeds as $feed) {
			if ($feed->priority() >= $minPriority) {
				$nb += $feed->nbNotRead();
			}
		}
		return $nb;
	}

	/** @return array<int,mixed> */
	public function curlOptions(): array {
		return [];	// TODO (e.g., credentials for Dynamic OPML)
	}

	public function showUnreadCount(): bool {
		return $this->attributeBoolean('show_unread_count') ??
			(Context::userConf()->show_unread_count === 'all');
	}

	/**
	 * @return array<int,Feed> where the key is the feed ID
	 * @throws ConfigurationNamespaceException
	 * @throws PDOConnectionException
	 */
	public function feeds(): array {
		if ($this->feeds === null) {
			$feedDAO = Factory::createFeedDao();
			$this->feeds = $feedDAO->listByCategory($this->id());
			$this->nbFeeds = 0;
			$this->nbNotRead = 0;
			foreach ($this->feeds as $feed) {
				$this->nbFeeds++;
				if ($feed->priority() > Feed::PRIORITY_HIDDEN) {
					$this->nbNotRead += $feed->nbNotRead();
					$this->hasFeedsWithError |= ($feed->inError() && !$feed->mute());
				}
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
		if ($id === CategoryDAO::DEFAULTCATEGORYID) {
			$this->name = _t('gen.short.default_category');
		}
	}

	public function _kind(int $kind): void {
		$this->kind = $kind;
	}

	public function _name(string $value): void {
		if ($this->id !== CategoryDAO::DEFAULTCATEGORYID) {
			$this->name = mb_strcut(trim($value), 0, DatabaseDAO::LENGTH_INDEX_UNICODE, 'UTF-8');
		}
	}

	/** @param array<Feed>|Feed $values */
	public function _feeds(array|Feed $values): void {
		if (!is_array($values)) {
			$values = [$values];
		}
		$this->feeds = array_values($values);
		$this->sortFeeds();
	}

	public function defaultSort(): ?string {
		return $this->attributeString('defaultSort');
	}
	public function defaultOrder(): ?string {
		return $this->attributeString('defaultOrder');
	}

	/**
	 * To manually add feeds to this category (not committing to database).
	 */
	public function addFeed(Feed $feed): void {
		if ($this->feeds === null) {
			$this->feeds = [];
		}
		$feed->_category($this);
		if ($feed->id() === 0) {
			// Feeds created on a dry run do not have an ID
			$this->feeds[] = $feed;
		} else {
			$this->feeds[$feed->id()] = $feed;
		}
		$this->sortFeeds();
	}

	/**
	 * @throws ContextException
	 */
	public function cacheFilename(string $url): string {
		$simplePie = new SimplePieCustom($this->attributes(), $this->curlOptions());
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
		$opml = HttpUtil::httpGet($url, $cachePath, 'opml', $this->attributes(), $this->curlOptions())['body'];
		if ($opml == '') {
			Log::warning('Error getting dynamic OPML for category ' . $this->id() . '! ' .
				\SimplePie\Misc::url_remove_credentials($url));
			$ok = false;
		} else {
			$dryRunCategory = new Category();
			$importService = new ImportService();
			$importService->importOpml($opml, $dryRunCategory, true);
			if ($importService->lastStatus()) {
				$feedDAO = Factory::createFeedDao();
				$limits = Context::systemConf()->limits;
				$maxFeeds = (int)($limits['max_feeds'] ?? 0);
				$nbFeeds = $maxFeeds > 0 ? $feedDAO->count() : 0;

				/** @var array<string,Feed> */
				$dryRunFeeds = [];
				foreach ($dryRunCategory->feeds() as $dryRunFeed) {
					$dryRunFeeds[$dryRunFeed->url()] = $dryRunFeed;
				}

				/** @var array<string,Feed> */
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
						if ($maxFeeds > 0 && $nbFeeds >= $maxFeeds) {
							// Respect the per-user maximum number of feeds
							Log::warning(_t('feedback.sub.feed.over_max', $maxFeeds) .
								' (dynamic OPML category ' . $this->id() . ')');
							$ok = false;
							break;
						}
						$dryRunFeed->_category($this);
						if ($feedDAO->addFeedObject($dryRunFeed) === false) {
							$ok = false;
						} else {
							$nbFeeds++;
						}
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
				Log::warning('Error loading dynamic OPML for category ' . $this->id() . '! ' .
					\SimplePie\Misc::url_remove_credentials($url));
			}
		}

		$catDAO = Factory::createCategoryDao();
		if ($ok) {
			$catDAO->updateLastUpdate($this->id());
		} else {
			$catDAO->updateLastError($this->id());
		}

		return (bool)$ok;
	}

	private function sortFeeds(): void {
		if ($this->feeds === null) {
			return;
		}
		uasort($this->feeds, static fn(Feed $a, Feed $b): int => Context::localeCompare($a->name(), $b->name()));
	}

	/**
	 * Access cached feed
	 * @param array<Category> $categories
	 */
	public static function findFeed(array $categories, int $feed_id): ?Feed {
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
	 * @param array<Category> $categories
	 * @return array<int,Feed> where the key is the feed ID
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
	 * @param array<Category> $categories
	 */
	public static function countUnread(array $categories, int $minPriority = Feed::PRIORITY_FEED): int {
		$n = 0;
		foreach ($categories as $category) {
			$n += $category->nbNotRead($minPriority);
		}
		return $n;
	}
}

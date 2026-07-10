<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Exceptions\FeedException;
use FreshRss\Exceptions\ZipException;
use FreshRss\Exceptions\ZipMissingException;
use FreshRss\Minz\ConfigurationNamespaceException;
use FreshRss\Minz\Error;
use FreshRss\Minz\ExtensionManager;
use FreshRss\Minz\HookType;
use FreshRss\Minz\Log;
use FreshRss\Minz\PDOConnectionException;
use FreshRss\Minz\Request;
use FreshRss\Minz\User;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\Category;
use FreshRss\Models\CategoryDAO;
use FreshRss\Models\Context;
use FreshRss\Models\Entry;
use FreshRss\Models\EntryDAO;
use FreshRss\Models\Factory;
use FreshRss\Models\Feed;
use FreshRss\Models\FeedDAO;
use FreshRss\Models\SimplePieCustom;
use FreshRss\Models\View;
use FreshRss\Services\ExportService;
use FreshRss\Services\ImportService;

/**
 * Controller to handle every import and export actions.
 */
class ImportExportController extends ActionController {

	private EntryDAO $entryDAO;

	private FeedDAO $feedDAO;

	private CategoryDAO $categoryDAO;

	/**
	 * This action is called before every other action in that class. It is
	 * the common boilerplate for every action. It is triggered by the
	 * underlying framework.
	 */
	#[\Override]
	public function firstAction(): void {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		$this->entryDAO = Factory::createEntryDao();
		$this->feedDAO = Factory::createFeedDao();
		$this->categoryDAO = Factory::createCategoryDao();
	}

	/**
	 * This action displays the main page for import / export system.
	 */
	public function indexAction(): void {
		$this->view->categories = array_filter(
			$this->categoryDAO->listCategories(),
			static fn(Category $category): bool => !empty($category->feeds()),
		);
		$this->view->feedCount = array_sum(array_map(static fn(Category $category): int => count($category->feeds()), $this->view->categories));
		View::prependTitle(_t('sub.import_export.title') . ' · ');
		$this->listSqliteArchives();
	}

	private static function megabytes(string $size_str): float|int|string {
		return match (substr($size_str, -1)) {
			'M', 'm' => (int)$size_str,
			'K', 'k' => (int)$size_str / 1024,
			'G', 'g' => (int)$size_str * 1024,
			default => $size_str,
		};
	}

	private static function minimumMemory(int|string $mb): void {
		$mb = (int)$mb;
		$ini = self::megabytes(ini_get('memory_limit') ?: '0');
		if ($ini < $mb) {
			ini_set('memory_limit', $mb . 'M');
		}
	}

	/**
	 * @throws ZipException
	 * @throws ZipMissingException
	 * @throws ConfigurationNamespaceException
	 * @throws PDOConnectionException
	 */
	public function importFile(string $name, string $path, ?string $username = null): bool {
		self::minimumMemory(256);

		$this->entryDAO = Factory::createEntryDao($username);
		$this->feedDAO = Factory::createFeedDao($username);
		$this->categoryDAO = Factory::createCategoryDao($username);

		$type_file = self::guessFileType($name);

		$list_files = [
			'opml' => [],
			'json_starred' => [],
			'json_feed' => [],
			'ttrss_starred' => [],
		];

		// We try to list all files according to their type
		$list = [];
		if ('zip' === $type_file && extension_loaded('zip')) {
			$zip = new \ZipArchive();
			$result = $zip->open($path);
			if (true !== $result) {
				// zip_open cannot open file: something is wrong
				throw new ZipException($result);
			}
			for ($i = 0; $i < $zip->numFiles; $i++) {
				if ($zip->getNameIndex($i) === false) {
					continue;
				}
				$type_zipfile = self::guessFileType($zip->getNameIndex($i));
				if ('unknown' !== $type_zipfile) {
					$list_files[$type_zipfile][] = $zip->getFromIndex($i);
				}
			}
			$zip->close();
		} elseif ('zip' === $type_file) {
			// ZIP extension is not loaded
			throw new ZipMissingException();
		} elseif ('txt' === $type_file) {
			$contents = file_get_contents($path);
			if (is_string($contents)) {
				$list_files['opml'][] = self::txtToOpml($contents);
			}
		} elseif ('unknown' !== $type_file) {
			$list_files[$type_file][] = file_get_contents($path);
		}

		// Import file contents.
		// OPML first(so categories and feeds are imported)
		// Starred articles then so the "favourite" status is already set
		// And finally all other files.
		$ok = true;

		$importService = new ImportService($username);

		foreach ($list_files['opml'] as $opml_file) {
			if ($opml_file === false) {
				continue;
			}
			$importService->importOpml($opml_file);
			if (!$importService->lastStatus()) {
				$ok = false;
				if (Context::$isCli) {
					fwrite(STDERR, 'FreshRSS error during OPML import' . "\n");
				} else {
					Log::warning('Error during OPML import');
				}
			}
		}
		foreach ($list_files['json_starred'] as $article_file) {
			if (!is_string($article_file) || !$this->importJson($article_file, true)) {
				$ok = false;
				if (Context::$isCli) {
					fwrite(STDERR, 'FreshRSS error during JSON stars import' . "\n");
				} else {
					Log::warning('Error during JSON stars import');
				}
			}
		}
		foreach ($list_files['json_feed'] as $article_file) {
			if (!is_string($article_file) || !$this->importJson($article_file)) {
				$ok = false;
				if (Context::$isCli) {
					fwrite(STDERR, 'FreshRSS error during JSON feeds import' . "\n");
				} else {
					Log::warning('Error during JSON feeds import');
				}
			}
		}
		foreach ($list_files['ttrss_starred'] as $article_file) {
			$json = is_string($article_file) ? $this->ttrssXmlToJson($article_file) : false;
			if ($json === false || !$this->importJson($json, true)) {
				$ok = false;
				if (Context::$isCli) {
					fwrite(STDERR, 'FreshRSS error during TT-RSS articles import' . "\n");
				} else {
					Log::warning('Error during TT-RSS articles import');
				}
			}
		}

		return $ok;
	}

	/**
	 * This action handles import action.
	 *
	 * It must be reached by a POST request.
	 *
	 * Parameter is:
	 *   - file (default: nothing!)
	 * Available file types are: zip, json or xml.
	 */
	public function importAction(): void {
		if (!Request::isPost()) {
			Request::forward(['c' => 'importExport', 'a' => 'index'], true);
		}

		$file = $_FILES['file'] ?? null;
		$status_file = is_array($file) ? $file['error'] ?? -1 : -1;

		if (!is_array($file) || $status_file !== 0 || !is_string($file['name'] ?? null) || !is_string($file['tmp_name'] ?? null)) {
			Log::warning('File cannot be uploaded. Error code: ' . (is_numeric($status_file) ? $status_file : -1));
			Request::bad(_t('feedback.import_export.file_cannot_be_uploaded'), [ 'c' => 'importExport', 'a' => 'index' ]);
			return;
		}

		if (function_exists('set_time_limit')) {
			@set_time_limit(300);
		}

		$error = false;
		try {
			$error = !$this->importFile($file['name'], $file['tmp_name']);
		} catch (ZipMissingException) {
			Request::bad(
				_t('feedback.import_export.no_zip_extension'),
				['c' => 'importExport', 'a' => 'index']
			);
		} catch (ZipException $ze) {
			Log::warning('ZIP archive cannot be imported. Error code: ' . $ze->zipErrorCode());
			Request::bad(
				_t('feedback.import_export.zip_error'),
				['c' => 'importExport', 'a' => 'index']
			);
		}

		// And finally, we get import status and redirect to the home page
		$content_notif = $error === true ? _t('feedback.import_export.feeds_imported_with_errors') : _t('feedback.import_export.feeds_imported');
		Request::good(
			$content_notif,
			showNotification: Context::userConf()->good_notification_timeout > 0
		);
	}

	/**
	 * This method tries to guess the file type based on its name.
	 *
	 * It is a *very* basic guess file type function. Only based on filename.
	 * That could be improved but should be enough for what we have to do.
	 */
	private static function guessFileType(string $filename): string {
		if (str_ends_with($filename, '.zip')) {
			return 'zip';
		} elseif (str_ends_with($filename, '.txt')) {
			return 'txt';
		} elseif (stripos($filename, 'opml') !== false) {
			return 'opml';
		} elseif (str_ends_with($filename, '.json')) {
			if (str_contains($filename, 'starred')) {
				return 'json_starred';
			} else {
				return 'json_feed';
			}
		} elseif (str_ends_with($filename, '.xml')) {
			if (preg_match('/Tiny|tt-?rss/i', $filename)) {
				return 'ttrss_starred';
			} else {
				return 'opml';
			}
		}
		return 'unknown';
	}

	/**
	 * Wraps a newline-separated list of feed URLs into a minimal OPML document
	 * so it can be imported through the existing OPML pipeline.
	 */
	private static function txtToOpml(string $contents): string {
		$utf8BOM = "\xEF\xBB\xBF";
		$contents = preg_replace('/^' . $utf8BOM . '/', '', $contents) ?? $contents;
		$outlines = '';
		foreach (preg_split('/\R/', $contents) ?: [] as $line) {
			$url = trim($line);
			if ($url === '' || str_starts_with($url, '#') || str_starts_with($url, '<')) {
				continue;
			}
			if (filter_var($url, FILTER_VALIDATE_URL) === false) {
				$message = 'TXT import: skipping invalid URL “' . $url . '”';
				if (Context::$isCli) {
					fwrite(STDERR, $message . "\n");
				} else {
					Log::warning($message);
				}
				continue;
			}
			$escaped = htmlspecialchars($url, ENT_COMPAT | ENT_XML1, 'UTF-8');
			$outlines .= '<outline type="rss" text="' . $escaped . '" xmlUrl="' . $escaped . '" />' . "\n";
		}
		return '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
			. '<opml version="2.0"><body>' . "\n"
			. $outlines
			. '</body></opml>' . "\n";
	}

	private function ttrssXmlToJson(string $xml): string|false {
		$table = (array)simplexml_load_string($xml, options: LIBXML_NOBLANKS | LIBXML_NOCDATA);
		$table['items'] = $table['article'] ?? [];
		if (!is_array($table['items'])) {
			$table['items'] = [];
		}
		unset($table['article']);
		for ($i = count($table['items']) - 1; $i >= 0; $i--) {
			$item = (array)($table['items'][$i]);
			$item = array_filter($item, static fn($v) =>
				// Filter out empty properties, potentially reported as empty objects
				(is_string($v) && trim($v) !== '') || !empty($v));
			$item['updated'] = is_string($item['updated'] ?? null) ? strtotime($item['updated']) : '';
			$item['published'] = $item['updated'];
			$item['content'] = ['content' => $item['content'] ?? ''];
			$item['categories'] = is_string($item['tag_cache'] ?? null) ? [$item['tag_cache']] : [];
			if (!empty($item['marked'])) {
				$item['categories'][] = 'user/-/state/com.google/starred';
			}
			if (!empty($item['published'])) {
				$item['categories'][] = 'user/-/state/com.google/broadcast';
			}
			if (is_string($item['label_cache'] ?? null)) {
				$labels_cache = json_decode($item['label_cache'], true);
				if (is_array($labels_cache)) {
					foreach ($labels_cache as $label_cache) {
						if (is_array($label_cache) && !empty($label_cache[1]) && is_string($label_cache[1])) {
							$item['categories'][] = 'user/-/label/' . trim($label_cache[1]);
						}
					}
				}
			}
			$item['alternate'] = [['href' => $item['link'] ?? '']];
			$item['origin'] = [
				'title' => $item['feed_title'] ?? '',
				'feedUrl' => $item['feed_url'] ?? '',
			];
			$item['id'] = $item['guid'] ?? ($item['feed_url'] ?? $item['published']);
			$item['guid'] = $item['id'];
			$table['items'][$i] = $item;
		}
		return json_encode($table);
	}

	/**
	 * This method import a JSON-based file (Google Reader format).
	 *
	 * $article_file the JSON file content.
	 * true if articles from the file must be starred.
	 * @return bool false if an error occurred, true otherwise.
	 * @throws ConfigurationNamespaceException
	 * @throws PDOConnectionException
	 */
	private function importJson(string $article_file, bool $starred = false): bool {
		$article_object = json_decode($article_file, true);
		if (!is_array($article_object)) {
			if (Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error trying to import a non-JSON file' . "\n");
			} else {
				Log::warning('Try to import a non-JSON file');
			}
			return false;
		}
		$items = $article_object['items'] ?? $article_object;
		if (!is_array($items)) {
			$items = [];
		}

		$mark_as_read = Context::userConf()->mark_when['reception'] ? 1 : 0;

		$error = false;
		$article_to_feed = [];

		$nb_feeds = count($this->feedDAO->listFeeds());
		$newFeedGuids = [];
		$limits = Context::systemConf()->limits;

		// First, we check feeds of articles are in DB (and add them if needed).
		foreach ($items as &$item) {
			if (!is_array($item)) {
				continue;
			}
			if (!is_string($item['guid'] ?? null) && is_string($item['id'] ?? null)) {
				$item['guid'] = $item['id'];
			}
			if (!is_string($item['guid'] ?? null)) {
				continue;
			}
			if (!is_array($item['origin'] ?? null)) {
				$item['origin'] = [];
			}
			if (!is_string($item['origin']['title'] ?? null) || trim($item['origin']['title']) === '') {
				$item['origin']['title'] = 'Import';
			}
			if (is_string($item['origin']['feedUrl'] ?? null)) {
				$feedUrl = $item['origin']['feedUrl'];
			} elseif (is_string($item['origin']['streamId'] ?? null) && str_starts_with($item['origin']['streamId'], 'feed/')) {
				$feedUrl = substr($item['origin']['streamId'], 5);	//Google Reader
				$item['origin']['feedUrl'] = $feedUrl;
			} elseif (is_string($item['origin']['htmlUrl'] ?? null)) {
				$feedUrl = $item['origin']['htmlUrl'];
			} else {
				$feedUrl = 'http://import.localhost/import.xml';
				$item['origin']['feedUrl'] = $feedUrl;
				$item['origin']['disable'] = 'true';
			}
			$feed = new Feed($feedUrl);
			$feed = $this->feedDAO->searchByUrl($feed->url());

			if ($feed === null) {
				// Feed does not exist in DB,we should to try to add it.
				if ((!Context::$isCli) && ($nb_feeds >= $limits['max_feeds'])) {
					// Oops, no more place!
					Log::warning(_t('feedback.sub.feed.over_max', $limits['max_feeds']));
				} else {
					$origin = array_filter($item['origin'], fn($value, $key): bool => is_string($key) && is_string($value), ARRAY_FILTER_USE_BOTH);
					$feed = $this->addFeedJson($origin);
				}

				if ($feed === null) {
					// Still null? It means something went wrong.
					$error = true;
				} else {
					$nb_feeds++;
				}
			}

			if ($feed !== null) {
				$article_to_feed[$item['guid']] = $feed->id();
				if (!isset($newFeedGuids['f_' . $feed->id()])) {
					$newFeedGuids['f_' . $feed->id()] = [];
				}
				$newFeedGuids['f_' . $feed->id()][] = safe_ascii($item['guid']);
			}
		}

		$tagDAO = Factory::createTagDao();
		$labels = Context::labels();
		$knownLabels = [];
		foreach ($labels as $label) {
			$knownLabels[$label->name()]['id'] = $label->id();
			$knownLabels[$label->name()]['articles'] = [];
		}
		unset($labels);

		// For each feed, check existing GUIDs already in database.
		$existingHashForGuids = [];
		foreach ($newFeedGuids as $feedId => $newGuids) {
			$existingHashForGuids[$feedId] = $this->entryDAO->listHashForFeedGuids((int)substr($feedId, 2), $newGuids);
		}
		unset($newFeedGuids);

		// Then, articles are imported.
		$newGuids = [];
		$this->entryDAO->beginTransaction();
		foreach ($items as &$item) {
			if (!is_array($item) || empty($item['guid']) || !is_string($item['guid']) || empty($article_to_feed[$item['guid']])) {
				// Related feed does not exist for this entry, do nothing.
				continue;
			}

			$feed_id = $article_to_feed[$item['guid']];
			$author = is_string($item['author'] ?? null) ? $item['author'] : '';
			$is_starred = null; // null is used to preserve the current state if that item exists and is already starred
			$is_read = null;
			$tags = is_array($item['categories'] ?? null) ? $item['categories'] : [];
			$labels = [];
			for ($i = count($tags) - 1; $i >= 0; $i--) {
				$tag = $tags[$i];
				if (!is_string($tag)) {
					unset($tags[$i]);
					continue;
				}
				$tag = trim($tag);
				if (preg_match('%^user/[A-Za-z0-9_-]+/%', $tag)) {
					if (preg_match('%^user/[A-Za-z0-9_-]+/state/com.google/starred$%', $tag)) {
						$is_starred = true;
					} elseif (preg_match('%^user/[A-Za-z0-9_-]+/state/com.google/read$%', $tag)) {
						$is_read = true;
					} elseif (preg_match('%^user/[A-Za-z0-9_-]+/state/com.google/unread$%', $tag)) {
						$is_read = false;
					} elseif (preg_match('%^user/[A-Za-z0-9_-]+/label/\s*(?P<tag>.+?)\s*$%', $tag, $matches)) {
						$labels[] = $matches['tag'];
					}
					unset($tags[$i]);
				}
			}
			$tags = array_values(array_filter($tags, 'is_string'));
			if ($starred && !$is_starred) {
				//If the article has no label, mark it as starred (old format)
				$is_starred = empty($labels);
			}
			if ($is_read === null) {
				$is_read = $mark_as_read;
			}

			if (is_array($item['alternate']) && is_array($item['alternate'][0] ?? null) && is_string($item['alternate'][0]['href'] ?? null)) {
				$url = $item['alternate'][0]['href'];
			} elseif (is_string($item['url'] ?? null)) {
				$url = $item['url'];	//FeedBin
			} else {
				$url = '';
			}

			$title = is_string($item['title'] ?? null) ? $item['title'] : $url;

			if (is_array($item['content'] ?? null) && is_string($item['content']['content'] ?? null)) {
				$content = $item['content']['content'];
			} elseif (is_array($item['summary']) && is_string($item['summary']['content'] ?? null)) {
				$content = $item['summary']['content'];
			} elseif (is_string($item['content'] ?? null)) {
				$content = $item['content'];	//FeedBin
			} else {
				$content = '';
			}
			$content = SimplePieCustom::sanitizeHTML($content, $url);

			if (is_int($item['published'] ?? null) || is_string($item['published'] ?? null)) {
				$published = (string)$item['published'];
			} elseif (is_int($item['timestampUsec'] ?? null) || is_string($item['timestampUsec'] ?? null)) {
				$published = substr((string)$item['timestampUsec'], 0, -6);
			} elseif (is_int($item['updated'] ?? null) || is_string($item['updated'] ?? null)) {
				$published = (string)$item['updated'];
			} else {
				$published = '0';
			}
			if (!ctype_digit($published)) {
				$published = (string)(strtotime($published) ?: 0);
			}
			if (strlen($published) > 10) {	// Milliseconds, e.g. Feedly
				$published = substr($published, 0, -3);
				if (!is_numeric($published)) {
					$published = '0';	// For PHPStan
				}
			}

			$entry = new Entry(
				$feed_id, $item['guid'], $title, $author,
				$content, $url, $published, $is_read, $is_starred
			);
			$entry->_id(uTimeString());
			$entry->_tags($tags);

			if (isset($newGuids[$entry->guid()])) {
				continue;	//Skip subsequent articles with same GUID
			}
			$newGuids[$entry->guid()] = true;

			$entry = ExtensionManager::callHook(HookType::EntryBeforeInsert, $entry);
			if (!($entry instanceof Entry)) {
				// An extension has returned a null value, there is nothing to insert.
				continue;
			}

			if (isset($existingHashForGuids['f_' . $feed_id][$entry->guid()])) {
				$entry = ExtensionManager::callHook(HookType::EntryBeforeUpdate, $entry);
				if (!($entry instanceof Entry)) {
					// An extension has returned a null value, there is nothing to insert.
					continue;
				}

				$ok = $this->entryDAO->updateEntry($entry->toArray());
			} else {
				$entry->_lastSeen(time());

				$entry = ExtensionManager::callHook(HookType::EntryBeforeAdd, $entry);
				if (!($entry instanceof Entry)) {
					// An extension has returned a null value, there is nothing to insert.
					continue;
				}

				$ok = $this->entryDAO->addEntry($entry->toArray());
			}

			foreach ($labels as $labelName) {
				if (empty($knownLabels[$labelName]['id'])) {
					$labelId = $tagDAO->addTag(['name' => $labelName]);
					$knownLabels[$labelName]['id'] = $labelId;
					$knownLabels[$labelName]['articles'] = [];
				}
				$knownLabels[$labelName]['articles'][] = [
					//'id' => $entry->id(),	//ID changes after commitNewEntries()
					'id_feed' => $entry->feedId(),
					'guid' => $entry->guid(),
				];
			}

			$error |= ($ok === false);
		}
		$this->entryDAO->commit();

		$this->entryDAO->beginTransaction();
		$this->entryDAO->commitNewEntries();
		$this->feedDAO->updateCachedValues();
		$this->entryDAO->commit();

		$this->entryDAO->beginTransaction();
		foreach ($knownLabels as $labelName => $knownLabel) {
			$labelId = $knownLabel['id'];
			if (!$labelId) {
				continue;
			}
			foreach ($knownLabel['articles'] as $article) {
				$entryId = $this->entryDAO->searchIdByGuid($article['id_feed'], $article['guid']);
				if ($entryId != null) {
					$tagDAO->tagEntry($labelId, $entryId);
				} else {
					Log::warning('Could not add label "' . $labelName . '" to entry "' . $article['guid'] . '" in feed ' . $article['id_feed']);
				}
			}
		}
		$this->entryDAO->commit();

		return !$error;
	}

	/**
	 * This method import a JSON-based feed (Google Reader format).
	 *
	 * @param array<string,string> $origin represents a feed.
	 * @return Feed|null if feed is in database at the end of the process, else null.
	 */
	private function addFeedJson(array $origin): ?Feed {
		$return = null;
		if (!empty($origin['feedUrl'])) {
			$url = $origin['feedUrl'];
		} elseif (!empty($origin['htmlUrl'])) {
			$url = $origin['htmlUrl'];
		} else {
			return null;
		}
		if (!empty($origin['htmlUrl'])) {
			$website = $origin['htmlUrl'];
		} elseif (!empty($origin['feedUrl'])) {
			$website = $origin['feedUrl'];
		} else {
			$website = '';
		}
		$name = empty($origin['title']) ? $website : $origin['title'];

		$cat_id = CategoryDAO::DEFAULTCATEGORYID;
		$cat_name = trim($origin['category'] ?? '');
		if ($cat_name !== '') {
			$new_cat = $this->categoryDAO->searchByName($cat_name);
			$cat_id = $new_cat?->id() ?: $this->categoryDAO->addCategory(['name' => $cat_name]) ?: CategoryDAO::DEFAULTCATEGORYID;
		}

		try {
			// Create a Feed object and add it in database.
			$feed = new Feed($url);
			$feed->_categoryId($cat_id);
			$feed->_name($name);
			$feed->_website($website);
			if (!empty($origin['disable'])) {
				$feed->_mute(true);
			}

			// Call the extension hook
			$feed = ExtensionManager::callHook(HookType::FeedBeforeInsert, $feed);
			if ($feed instanceof Feed) {
				// addFeedObject checks if feed is already in DB so nothing else to
				// check here.
				$id = $this->feedDAO->addFeedObject($feed);

				if ($id !== false) {
					$feed->_id($id);
					$return = $feed;
				}
			}
		} catch (FeedException $e) {
			if (Context::$isCli) {
				fwrite(STDERR, 'FreshRSS error during JSON feed import: ' . $e->getMessage() . "\n");
			} else {
				Log::warning($e->getMessage());
			}
		}

		return $return;
	}

	/**
	 * This action handles export action.
	 *
	 * This action must be reached by a POST request.
	 *
	 * Parameters are:
	 *   - export_opml (default: false)
	 *   - export_starred (default: false)
	 *   - export_labelled (default: false)
	 *   - export_feeds (default: []) a list of feed ids
	 */
	public function exportAction(): void {
		if (!Request::isPost()) {
			Request::forward(['c' => 'importExport', 'a' => 'index'], true);
			return;
		}

		$username = User::name() ?? '_';
		$export_service = new ExportService($username);

		$export_opml = Request::paramBoolean('export_opml');
		$export_starred = Request::paramBoolean('export_starred');
		$export_labelled = Request::paramBoolean('export_labelled');
		/** @var array<numeric-string> */
		$export_feeds = Request::paramArray('export_feeds');
		$max_number_entries = 50;

		$exported_files = [];

		if ($export_opml) {
			[$filename, $content] = $export_service->generateOpml();
			$exported_files[$filename] = $content;
		}

		// Starred and labelled entries are merged in the same `starred` file
		// to avoid duplication of content.
		if ($export_starred && $export_labelled) {
			[$filename, $content] = $export_service->generateStarredEntries('ST');
			$exported_files[$filename] = $content;
		} elseif ($export_starred) {
			[$filename, $content] = $export_service->generateStarredEntries('S');
			$exported_files[$filename] = $content;
		} elseif ($export_labelled) {
			[$filename, $content] = $export_service->generateStarredEntries('T');
			$exported_files[$filename] = $content;
		}

		foreach ($export_feeds as $feed_id) {
			$result = $export_service->generateFeedEntries((int)$feed_id, $max_number_entries);
			if ($result === null) {
				// It means the actual feed_id doesn’t correspond to any existing feed
				continue;
			}

			[$filename, $content] = $result;
			$exported_files[$filename] = $content;
		}

		$nb_files = count($exported_files);
		if ($nb_files <= 0) {
			// There’s nothing to do, there are no files to export
			Request::forward(['c' => 'importExport', 'a' => 'index'], true);
			return;
		}

		if ($nb_files === 1) {
			// If we only have one file, we just export it as it is
			$filename = key($exported_files);
			$content = $exported_files[$filename];
		} else {
			// More files? Let’s compress them in a Zip archive
			if (!extension_loaded('zip')) {
				// Oops, there is no ZIP extension!
				Request::bad(
					_t('feedback.import_export.export_no_zip_extension'),
					['c' => 'importExport', 'a' => 'index']
				);
				return;
			}

			[$filename, $content] = $export_service->zip($exported_files);
		}

		if (!is_string($content)) {
			Request::bad(_t('feedback.import_export.zip_error'), ['c' => 'importExport', 'a' => 'index']);
			return;
		}

		$content_type = self::filenameToContentType($filename);
		header('Content-Type: ' . $content_type);
		header('Content-disposition: attachment; filename="' . $filename . '"');

		$this->view->_layout(null);
		$this->view->content = $content;
	}

	/**
	 * Return the Content-Type corresponding to a filename.
	 *
	 * If the type of the filename is not supported, it returns
	 * `application/octet-stream` by default.
	 */
	private static function filenameToContentType(string $filename): string {
		$filetype = self::guessFileType($filename);
		return match ($filetype) {
			'zip' => 'application/zip',
			'opml' => 'application/xml; charset=utf-8',
			'json_starred', 'json_feed' => 'application/json; charset=utf-8',
			default => 'application/octet-stream',
		};
	}

	private const REGEX_SQLITE_FILENAME = '/^(?![.-])[0-9a-zA-Z_.@ #&()~\-]{1,128}\.sqlite$/';

	private function listSqliteArchives(): void {
		$this->view->sqliteArchives = [];
		$files = glob(USERS_PATH . '/' . User::name() . '/*.sqlite', GLOB_NOSORT) ?: [];
		foreach ($files as $file) {
			$archive = [
				'name' => basename($file),
				'size' => @filesize($file),
				'mtime' => @filemtime($file),
			];
			if ($archive['size'] != false && $archive['mtime'] != false && preg_match(self::REGEX_SQLITE_FILENAME, $archive['name'])) {
				$this->view->sqliteArchives[] = $archive;
			}
		}
		// Sort by time, newest first:
		usort($this->view->sqliteArchives, static fn(array $a, array $b): int => $b['mtime'] <=> $a['mtime']);
	}

	public function sqliteAction(): void {
		if (!Request::isPost()) {
			Request::forward(['c' => 'importExport', 'a' => 'index'], true);
		}
		$sqlite = Request::paramString('sqlite');
		if (!preg_match(self::REGEX_SQLITE_FILENAME, $sqlite)) {
			Error::error(404);
			return;
		}
		$path = USERS_PATH . '/' . User::name() . '/' . $sqlite;
		if (!file_exists($path) || @filesize($path) == false || @filemtime($path) == false) {
			Error::error(404);
			return;
		}

		$this->view->sqlitePath = $path;
		$this->view->sqliteName = basename($path);
		if ($this->view->sqliteName === 'db.sqlite') {
			$username = User::name() ?? '_';
			$date = date('Y-m-d_H-i-s', filemtime($path) ?: time());	// @phpstan-ignore ternary.alwaysTrue (for additional safety)
			$this->view->sqliteName = 'freshrss_' . $username . '_' . $date . '_db.sqlite';
		}
		$this->view->_layout(null);
	}
}

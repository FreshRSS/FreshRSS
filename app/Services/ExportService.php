<?php

/**
 * Provide useful methods to generate files to export.
 */
class FreshRSS_Export_Service {
	/** @var string */
	private $username;

	/** @var FreshRSS_CategoryDAO */
	private $categoryDao;

	/** @var FreshRSS_FeedDAO */
	private $feedDao;

	/** @var FreshRSS_EntryDAO */
	private $entryDao;

	/** @var FreshRSS_TagDAO */
	private $tagDao;

	/**
	 * Initialize the service for the given user.
	 *
	 * @param string $username
	 */
	public function __construct($username) {
		$this->username = $username;

		$this->categoryDao = FreshRSS_Factory::createCategoryDao($username);
		$this->feedDao = FreshRSS_Factory::createFeedDao($username);
		$this->entryDao = FreshRSS_Factory::createEntryDao($username);
		$this->tagDao = FreshRSS_Factory::createTagDao();
	}

	/**
	 * Generate OPML file content.
	 *
	 * @return array First item is the filename, second item is the content
	 */
	public function generateOpml() {
		require_once(LIB_PATH . '/lib_opml.php');

		$view = new Minz_View();
		$day = date('Y-m-d');
		$categories = [];

		foreach ($this->categoryDao->listCategories() as $key => $category) {
			$categories[$key]['name'] = $category->name();
			$categories[$key]['feeds'] = $this->feedDao->listByCategory($category->id());
		}

		$view->categories = $categories;

		return [
			"feeds_{$day}.opml.xml",
			$view->helperToString('export/opml')
		];
	}

	/**
	 * Generate the starred and labelled entries file content.
	 *
	 * Both starred and labelled entries are put into a "starred" file, that's
	 * why there is only one method for both.
	 *
	 * @param string $type must be one of:
	 *     'S' (starred/favourite),
	 *     'T' (taggued/labelled),
	 *     'ST' (starred or labelled)
	 *
	 * @return array First item is the filename, second item is the content
	 */
	public function generateStarredEntries($type) {
		$view = new Minz_View();
		$view->categories = $this->categoryDao->listCategories();
		$day = date('Y-m-d');

		$view->list_title = _t('sub.import_export.starred_list');
		$view->type = 'starred';
		$view->entriesId = $this->entryDao->listIdsWhere(
			$type, '', FreshRSS_Entry::STATE_ALL, 'ASC', -1
		);
		$view->entryIdsTagNames = $this->tagDao->getEntryIdsTagNames($view->entriesId);
		// The following is a streamable query, i.e. must be last
		$view->entriesRaw = $this->entryDao->listWhereRaw(
			$type, '', FreshRSS_Entry::STATE_ALL, 'ASC', -1
		);

		return [
			"starred_{$day}.json",
			$view->helperToString('export/articles')
		];
	}

	/**
	 * Generate the entries file content for the given feed.
	 *
	 * @param integer $feed_id
	 * @param integer $max_number_entries
	 *
	 * @return array|null First item is the filename, second item is the content.
	 *                    It also can return null if the feed doesn't exist.
	 */
	public function generateFeedEntries($feed_id, $max_number_entries) {
		$feed = $this->feedDao->searchById($feed_id);
		if (!$feed) {
			return null;
		}

		$view = new Minz_View();
		$view->categories = $this->categoryDao->listCategories();
		$view->feed = $feed;
		$day = date('Y-m-d');
		$filename = "feed_{$day}_" . $feed->category() . '_' . $feed->id() . '.json';

		$view->list_title = _t('sub.import_export.feed_list', $feed->name());
		$view->type = 'feed/' . $feed->id();
		$view->entriesId = $this->entryDao->listIdsWhere(
			'f', $feed->id(), FreshRSS_Entry::STATE_ALL, 'ASC', $max_number_entries
		);
		$view->entryIdsTagNames = $this->tagDao->getEntryIdsTagNames($view->entriesId);
		// The following is a streamable query, i.e. must be last
		$view->entriesRaw = $this->entryDao->listWhereRaw(
			'f', $feed->id(), FreshRSS_Entry::STATE_ALL, 'ASC', $max_number_entries
		);

		return [
			$filename,
			$view->helperToString('export/articles')
		];
	}

	/**
	 * Generate the entries file content for all the feeds.
	 *
	 * @param integer $max_number_entries
	 *
	 * @return array Keys are filenames and values are contents.
	 */
	public function generateAllFeedEntries($max_number_entries) {
		$feed_ids = $this->feedDao->listFeedsIds();

		$exported_files = [];
		foreach ($feed_ids as $feed_id) {
			$result = $this->generateFeedEntries($feed_id, $max_number_entries);
			if (!$result) {
				continue;
			}

			list($filename, $content) = $result;
			$exported_files[$filename] = $content;
		}

		return $exported_files;
	}

	/**
	 * Compress several files in a Zip file.
	 *
	 * @param array $files where first item is the filename, second item is the content
	 *
	 * @return array First item is the zip filename, second item is the zip content
	 */
	public function zip($files) {
		$day = date('Y-m-d');
		$zip_filename = 'freshrss_' . $this->username . '_' . $day . '_export.zip';

		// From https://stackoverflow.com/questions/1061710/php-zip-files-on-the-fly
		$zip_file = @tempnam('/tmp', 'zip');
		$zip_archive = new ZipArchive();
		$zip_archive->open($zip_file, ZipArchive::OVERWRITE);

		foreach ($files as $filename => $content) {
			$zip_archive->addFromString($filename, $content);
		}

		$zip_archive->close();

		$content = file_get_contents($zip_file);

		unlink($zip_file);

		return [
			$zip_filename,
			$content,
		];
	}

	/**
	 * Export of stream of entries to the Google Reader API format.
	 */
	public function entriesToGReaderItems($entries, $urlAsStreamId = true) {
		require_once(LIB_PATH . '/lib_greader.php');

		$arrayFeedCategoryNames = $this->feedDao->arrayFeedCategoryNames();

		$entryIdsTagNames = $this->tagDao->getEntryIdsTagNames(null);
		if ($entryIdsTagNames == false) {
			$entryIdsTagNames = [];
		}

		foreach ($entries as $entry) {
			$f_id = $entry->feed();
			if (isset($arrayFeedCategoryNames[$f_id])) {
				$c_name = $arrayFeedCategoryNames[$f_id]['c_name'];
				$f_name = $arrayFeedCategoryNames[$f_id]['name'];
				$f_url = $arrayFeedCategoryNames[$f_id]['url'];
				$f_website = $arrayFeedCategoryNames[$f_id]['website'];
			} else {
				$c_name = '_';
				$f_name = '_';
				$f_url = '_';
				$f_website = '_';
			}
			$item = [
				'id' => 'tag:google.com,2005:reader/item/' . dec2hex($entry->id()),	//64-bit hexa http://code.google.com/p/google-reader-api/wiki/ItemId
				'crawlTimeMsec' => substr($entry->dateAdded(true, true), 0, -3),
				'timestampUsec' => '' . $entry->dateAdded(true, true),
				'published' => $entry->date(true),
				'title' => escapeToUnicodeAlternative($entry->title(), false),
				'summary' => [ 'content' => $entry->content() ],
				'canonical' => [
					[ 'href' => htmlspecialchars_decode($entry->link(), ENT_QUOTES) ],
				],
				'alternate' => [
					[ 'href' => htmlspecialchars_decode($entry->link(), ENT_QUOTES) ],
				],
				'categories' => [
					'user/-/state/com.google/reading-list',
					'user/-/label/' . htmlspecialchars_decode($c_name, ENT_QUOTES),
				],
				'origin' => [
					'streamId' => 'feed/' . $urlAsStreamId ? htmlspecialchars_decode($f_url, ENT_QUOTES) : $f_id,
					'title' => escapeToUnicodeAlternative($f_name, true),
					'htmlUrl' => htmlspecialchars_decode($f_website, ENT_QUOTES),
				],
			];
			foreach ($entry->enclosures() as $enclosure) {
				if (!empty($enclosure['url']) && !empty($enclosure['type'])) {
					$media = [
							'href' => $enclosure['url'],
							'type' => $enclosure['type'],
						];
					if (!empty($enclosure['length'])) {
						$media['length'] = intval($enclosure['length']);
					}
					$item['enclosure'][] = $media;
				}
			}
			$author = $entry->authors(true);
			$author = trim($author, '; ');
			if ($author != '') {
				$item['author'] = escapeToUnicodeAlternative($author, false);
			}
			if ($entry->isRead()) {
				$item['categories'][] = 'user/-/state/com.google/read';
			}
			if ($entry->isFavorite()) {
				$item['categories'][] = 'user/-/state/com.google/starred';
			}
			$tagNames = isset($entryIdsTagNames['e_' . $entry->id()]) ? $entryIdsTagNames['e_' . $entry->id()] : [];
			foreach ($tagNames as $tagName) {
				$item['categories'][] = 'user/-/label/' . htmlspecialchars_decode($tagName, ENT_QUOTES);
			}
			foreach ($entry->tags() as $tagName) {
				$item['categories'][] = htmlspecialchars_decode($tagName, ENT_QUOTES);
			}

			yield $item;
		}
	}

}

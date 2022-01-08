<?php

/**
 * Provide useful methods to generate files to export.
 */
class FreshRSS_Export_Service {
	/** @var string */
	private $username;

	/** @var FreshRSS_CategoryDAO */
	private $category_dao;

	/** @var FreshRSS_FeedDAO */
	private $feed_dao;

	/** @var FreshRSS_EntryDAO */
	private $entry_dao;

	/** @var FreshRSS_TagDAO */
	private $tag_dao;

	/**
	 * Initialize the service for the given user.
	 *
	 * @param string $username
	 */
	public function __construct($username) {
		$this->username = $username;

		$this->category_dao = FreshRSS_Factory::createCategoryDao($username);
		$this->feed_dao = FreshRSS_Factory::createFeedDao($username);
		$this->entry_dao = FreshRSS_Factory::createEntryDao($username);
		$this->tag_dao = FreshRSS_Factory::createTagDao();
	}

	/**
	 * Generate OPML file content.
	 *
	 * @return array First item is the filename, second item is the content
	 */
	public function generateOpml() {
		require_once(LIB_PATH . '/lib_opml.php');

		$view = new FreshRSS_View();
		$day = date('Y-m-d');
		$categories = [];

		foreach ($this->category_dao->listCategories() as $key => $category) {
			$categories[$key]['name'] = $category->name();
			$categories[$key]['feeds'] = $this->feed_dao->listByCategory($category->id());
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
	 * Both starred and labelled entries are put into a "starred" file, that’s
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
		$view = new FreshRSS_View();
		$view->categories = $this->category_dao->listCategories();
		$day = date('Y-m-d');

		$view->list_title = _t('sub.import_export.starred_list');
		$view->type = 'starred';
		$view->entriesId = $this->entry_dao->listIdsWhere(
			$type, '', FreshRSS_Entry::STATE_ALL, 'ASC', -1
		);
		$view->entryIdsTagNames = $this->tag_dao->getEntryIdsTagNames($view->entriesId);
		// The following is a streamable query, i.e. must be last
		$view->entriesRaw = $this->entry_dao->listWhereRaw(
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
	 *                    It also can return null if the feed doesn’t exist.
	 */
	public function generateFeedEntries($feed_id, $max_number_entries) {
		$feed = $this->feed_dao->searchById($feed_id);
		if (!$feed) {
			return null;
		}

		$view = new FreshRSS_View();
		$view->categories = $this->category_dao->listCategories();
		$view->feed = $feed;
		$day = date('Y-m-d');
		$filename = "feed_{$day}_" . $feed->category() . '_' . $feed->id() . '.json';

		$view->list_title = _t('sub.import_export.feed_list', $feed->name());
		$view->type = 'feed/' . $feed->id();
		$view->entriesId = $this->entry_dao->listIdsWhere(
			'f', $feed->id(), FreshRSS_Entry::STATE_ALL, 'ASC', $max_number_entries
		);
		$view->entryIdsTagNames = $this->tag_dao->getEntryIdsTagNames($view->entriesId);
		// The following is a streamable query, i.e. must be last
		$view->entriesRaw = $this->entry_dao->listWhereRaw(
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
		$feed_ids = $this->feed_dao->listFeedsIds();

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
}

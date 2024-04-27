<?php
declare(strict_types=1);

/**
 * Provide useful methods to generate files to export.
 */
class FreshRSS_Export_Service {

	private string $username;

	private FreshRSS_CategoryDAO $category_dao;

	private FreshRSS_FeedDAO $feed_dao;

	private FreshRSS_EntryDAO $entry_dao;

	private FreshRSS_TagDAO $tag_dao;

	public const FRSS_NAMESPACE = 'https://freshrss.org/opml';
	public const TYPE_HTML_XPATH = 'HTML+XPath';
	public const TYPE_XML_XPATH = 'XML+XPath';
	public const TYPE_RSS_ATOM = 'rss';
	public const TYPE_JSON_DOTPATH = 'JSON+DotPath';	// Legacy 1.24.0-dev
	public const TYPE_JSON_DOTNOTATION = 'JSON+DotNotation';
	public const TYPE_JSONFEED = 'JSONFeed';

	/**
	 * Initialize the service for the given user.
	 */
	public function __construct(string $username) {
		$this->username = $username;

		$this->category_dao = FreshRSS_Factory::createCategoryDao($username);
		$this->feed_dao = FreshRSS_Factory::createFeedDao($username);
		$this->entry_dao = FreshRSS_Factory::createEntryDao($username);
		$this->tag_dao = FreshRSS_Factory::createTagDao();
	}

	/**
	 * Generate OPML file content.
	 * @return array{0:string,1:string} First item is the filename, second item is the content
	 */
	public function generateOpml(): array {
		$view = new FreshRSS_View();
		$day = date('Y-m-d');
		$view->categories = $this->category_dao->listCategories(true, true) ?: [];
		$view->excludeMutedFeeds = false;

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
	 * @phpstan-param 'S'|'T'|'ST' $type
	 * @param string $type must be one of:
	 *     'S' (starred/favourite),
	 *     'T' (taggued/labelled),
	 *     'ST' (starred or labelled)
	 * @return array{0:string,1:string} First item is the filename, second item is the content
	 */
	public function generateStarredEntries(string $type): array {
		$view = new FreshRSS_View();
		$view->categories = $this->category_dao->listCategories(true) ?: [];
		$day = date('Y-m-d');

		$view->list_title = _t('sub.import_export.starred_list');
		$view->type = 'starred';
		$entriesId = $this->entry_dao->listIdsWhere($type, 0, FreshRSS_Entry::STATE_ALL, 'ASC', -1) ?? [];
		$view->entryIdsTagNames = $this->tag_dao->getEntryIdsTagNames($entriesId);
		// The following is a streamable query, i.e. must be last
		$view->entries = $this->entry_dao->listWhere(
			$type, 0, FreshRSS_Entry::STATE_ALL, 'ASC', -1
		);

		return [
			"starred_{$day}.json",
			$view->helperToString('export/articles')
		];
	}

	/**
	 * Generate the entries file content for the given feed.
	 * @param int $feed_id
	 * @param int $max_number_entries
	 * @return array{0:string,1:string}|null First item is the filename, second item is the content.
	 *                    It also can return null if the feed doesn’t exist.
	 */
	public function generateFeedEntries(int $feed_id, int $max_number_entries): ?array {
		$view = new FreshRSS_View();
		$view->categories = $this->category_dao->listCategories(true) ?: [];

		$feed = FreshRSS_Category::findFeed($view->categories, $feed_id);
		if ($feed === null) {
			return null;
		}
		$view->feed = $feed;

		$day = date('Y-m-d');
		$filename = "feed_{$day}_" . $feed->categoryId() . '_' . $feed->id() . '.json';

		$view->list_title = _t('sub.import_export.feed_list', $feed->name());
		$view->type = 'feed/' . $feed->id();
		$entriesId = $this->entry_dao->listIdsWhere(
			'f', $feed->id(), FreshRSS_Entry::STATE_ALL, 'ASC', $max_number_entries
		) ?? [];
		$view->entryIdsTagNames = $this->tag_dao->getEntryIdsTagNames($entriesId);
		// The following is a streamable query, i.e. must be last
		$view->entries = $this->entry_dao->listWhere(
			'f', $feed->id(), FreshRSS_Entry::STATE_ALL, 'ASC', $max_number_entries
		);

		return [
			$filename,
			$view->helperToString('export/articles')
		];
	}

	/**
	 * Generate the entries file content for all the feeds.
	 * @param int $max_number_entries
	 * @return array<string,string> Keys are filenames and values are contents.
	 */
	public function generateAllFeedEntries(int $max_number_entries): array {
		$feed_ids = $this->feed_dao->listFeedsIds();

		$exported_files = [];
		foreach ($feed_ids as $feed_id) {
			$result = $this->generateFeedEntries($feed_id, $max_number_entries);
			if (!$result) {
				continue;
			}

			[$filename, $content] = $result;
			$exported_files[$filename] = $content;
		}

		return $exported_files;
	}

	/**
	 * Compress several files in a Zip file.
	 * @param array<string,string> $files where the key is the filename, the value is the content
	 * @return array{0:string,1:string|false} First item is the zip filename, second item is the zip content
	 */
	public function zip(array $files): array {
		$day = date('Y-m-d');
		$zip_filename = 'freshrss_' . $this->username . '_' . $day . '_export.zip';

		// From https://stackoverflow.com/questions/1061710/php-zip-files-on-the-fly
		$zip_file = tempnam(TMP_PATH, 'zip');
		if ($zip_file == false) {
			return [$zip_filename, false];
		}
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

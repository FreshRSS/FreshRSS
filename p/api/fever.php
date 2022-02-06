<?php
/**
 * Fever API for FreshRSS
 * Version 0.1
 * Author: Kevin Papst / https://github.com/kevinpapst
 * Documentation: https://feedafever.com/api
 *
 * Inspired by:
 * TinyTinyRSS Fever API plugin @dasmurphy
 * See https://github.com/dasmurphy/tinytinyrss-fever-plugin
 */

// ================================================================================================
// BOOTSTRAP FreshRSS
require(__DIR__ . '/../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
FreshRSS_Context::initSystem();

// check if API is enabled globally
if (!FreshRSS_Context::$system_conf->api_enabled) {
	Minz_Log::warning('Fever API: serviceUnavailable() ' . debugInfo(), API_LOG);
	header('HTTP/1.1 503 Service Unavailable');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Service Unavailable!');
}

Minz_Session::init('FreshRSS', true);
// ================================================================================================

// <Debug>
$ORIGINAL_INPUT = file_get_contents('php://input', false, null, 0, 1048576);

/**
 * @return string
 */
function debugInfo() {
	if (function_exists('getallheaders')) {
		$ALL_HEADERS = getallheaders();
	} else {	//nginx	http://php.net/getallheaders#84262
		$ALL_HEADERS = array();
		foreach ($_SERVER as $name => $value) {
			if (substr($name, 0, 5) === 'HTTP_') {
				$ALL_HEADERS[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
	}
	global $ORIGINAL_INPUT;
	return print_r(
		array(
			'date' => date('c'),
			'headers' => $ALL_HEADERS,
			'_SERVER' => $_SERVER,
			'_GET' => $_GET,
			'_POST' => $_POST,
			'_COOKIE' => $_COOKIE,
			'INPUT' => $ORIGINAL_INPUT
		), true);
}

//Minz_Log::debug('----------------------------------------------------------------', API_LOG);
//Minz_Log::debug(debugInfo(), API_LOG);
// </Debug>

class FeverDAO extends Minz_ModelPdo
{
	protected function bindParamArray(string $prefix, array $values, array &$bindArray): string {
		$str = '';
		for ($i = 0; $i < count($values); $i++) {
			$str .= ':' . $prefix . $i . ',';
			$bindArray[$prefix . $i] = $values[$i];
		}
		return rtrim($str, ',');
	}

	/**
	 * @return FreshRSS_Entry[]
	 */
	public function findEntries(array $feed_ids, array $entry_ids, string $max_id, string $since_id) {
		$values = array();
		$order = '';
		$entryDAO = FreshRSS_Factory::createEntryDao();

		$sql = 'SELECT id, guid, title, author, '
			. ($entryDAO->isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content')
			. ', link, date, is_read, is_favorite, id_feed '
			. 'FROM `_entry` WHERE';

		if (!empty($entry_ids)) {
			$bindEntryIds = $this->bindParamArray('id', $entry_ids, $values);
			$sql .= " id IN($bindEntryIds)";
		} elseif ($max_id != '') {
			$sql .= ' id < :id';
			$values[':id'] = $max_id;
			$order = ' ORDER BY id DESC';
		} elseif ($since_id != '') {
			$sql .= ' id > :id';
			$values[':id'] = $since_id;
			$order = ' ORDER BY id ASC';
		} else {
			$sql .= ' 1=1';
		}

		if (!empty($feed_ids)) {
			$bindFeedIds = $this->bindParamArray('feed', $feed_ids, $values);
			$sql .= " AND id_feed IN($bindFeedIds)";
		}

		$sql .= $order;
		$sql .= ' LIMIT 50';

		$stm = $this->pdo->prepare($sql);
		$stm->execute($values);
		$result = $stm->fetchAll(PDO::FETCH_ASSOC);

		$entries = array();
		foreach ($result as $dao) {
			$entries[] = FreshRSS_EntryDAO::daoToEntry($dao);
		}

		return $entries;
	}
}

/**
 * Class FeverAPI
 */
class FeverAPI
{
	const API_LEVEL = 3;
	const STATUS_OK = 1;
	const STATUS_ERR = 0;

	/**
	 * @var FreshRSS_EntryDAO
	 */
	private $entryDAO = null;

	/**
	 * @var FreshRSS_FeedDAO
	 */
	private $feedDAO = null;

	/**
	 * Authenticate the user
	 *
	 * API Password sent from client is the result of the md5 sum of
	 * your FreshRSS "username:your-api-password" combination
	 */
	private function authenticate(): bool {
		FreshRSS_Context::$user_conf = null;
		Minz_Session::_param('currentUser');
		$feverKey = empty($_POST['api_key']) ? '' : substr(trim($_POST['api_key']), 0, 128);
		if (ctype_xdigit($feverKey)) {
			$feverKey = strtolower($feverKey);
			$username = @file_get_contents(DATA_PATH . '/fever/.key-' . sha1(FreshRSS_Context::$system_conf->salt) . '-' . $feverKey . '.txt', false);
			if ($username != false) {
				$username = trim($username);
				FreshRSS_Context::initUser($username);
				if (FreshRSS_Context::$user_conf != null && $feverKey === FreshRSS_Context::$user_conf->feverKey && FreshRSS_Context::$user_conf->enabled) {
					Minz_Translate::init(FreshRSS_Context::$user_conf->language);
					$this->entryDAO = FreshRSS_Factory::createEntryDao();
					$this->feedDAO = FreshRSS_Factory::createFeedDao();
					return true;
				} else {
					Minz_Translate::init();
				}
				Minz_Log::error('Fever API: Reset API password for user: ' . $username, API_LOG);
				Minz_Log::error('Fever API: Please reset your API password!');
				Minz_Session::_param('currentUser');
			}
			Minz_Log::warning('Fever API: wrong credentials! ' . $feverKey, API_LOG);
		}
		return false;
	}

	public function isAuthenticatedApiUser(): bool {
		$this->authenticate();

		if (FreshRSS_Context::$user_conf !== null) {
			return true;
		}

		return false;
	}

	/**
	 * This does all the processing, since the fever api does not have a specific variable that specifies the operation
	 * @throws Exception
	 */
	public function process(): array {
		$response_arr = array();

		if (!$this->isAuthenticatedApiUser()) {
			throw new Exception('No user given or user is not allowed to access API');
		}

		if (isset($_REQUEST['groups'])) {
			$response_arr['groups'] = $this->getGroups();
			$response_arr['feeds_groups'] = $this->getFeedsGroup();
		}

		if (isset($_REQUEST['feeds'])) {
			$response_arr['feeds'] = $this->getFeeds();
			$response_arr['feeds_groups'] = $this->getFeedsGroup();
		}

		if (isset($_REQUEST['favicons'])) {
			$response_arr['favicons'] = $this->getFavicons();
		}

		if (isset($_REQUEST['items'])) {
			$response_arr['total_items'] = $this->getTotalItems();
			$response_arr['items'] = $this->getItems();
		}

		if (isset($_REQUEST['links'])) {
			$response_arr['links'] = $this->getLinks();
		}

		if (isset($_REQUEST['unread_item_ids'])) {
			$response_arr['unread_item_ids'] = $this->getUnreadItemIds();
		}

		if (isset($_REQUEST['saved_item_ids'])) {
			$response_arr['saved_item_ids'] = $this->getSavedItemIds();
		}

		$id = isset($_REQUEST['id']) ? '' . $_REQUEST['id'] : '';
		if (isset($_REQUEST['mark'], $_REQUEST['as'], $_REQUEST['id']) && ctype_digit($id)) {
			$method_name = 'set' . ucfirst($_REQUEST['mark']) . 'As' . ucfirst($_REQUEST['as']);
			$allowedMethods = array(
				'setFeedAsRead', 'setGroupAsRead', 'setItemAsRead',
				'setItemAsSaved', 'setItemAsUnread', 'setItemAsUnsaved'
			);
			if (in_array($method_name, $allowedMethods)) {
				switch (strtolower($_REQUEST['mark'])) {
					case 'item':
						$this->{$method_name}($id);
						break;
					case 'feed':
					case 'group':
						$before = $_REQUEST['before'] ?? '';
						$this->{$method_name}($id, $before);
						break;
				}

				switch ($_REQUEST['as']) {
					case 'read':
					case 'unread':
						$response_arr['unread_item_ids'] = $this->getUnreadItemIds();
						break;

					case 'saved':
					case 'unsaved':
						$response_arr['saved_item_ids'] = $this->getSavedItemIds();
						break;
				}
			}
		}

		return $response_arr;
	}

	/**
	 * Returns the complete JSON, with 'api_version' and status as 'auth'.
	 */
	public function wrap(int $status, array $reply = array()): string {
		$arr = array('api_version' => self::API_LEVEL, 'auth' => $status);

		if ($status === self::STATUS_OK) {
			$arr['last_refreshed_on_time'] = $this->lastRefreshedOnTime();
			$arr = array_merge($arr, $reply);
		}

		return json_encode($arr);
	}

	/**
	 * every authenticated method includes last_refreshed_on_time
	 */
	protected function lastRefreshedOnTime(): int {
		$lastUpdate = 0;

		$entries = $this->feedDAO->listFeedsOrderUpdate(-1, 1);
		$feed = current($entries);

		if (!empty($feed)) {
			$lastUpdate = $feed->lastUpdate();
		}

		return $lastUpdate;
	}

	protected function getFeeds(): array {
		$feeds = array();
		$myFeeds = $this->feedDAO->listFeeds();

		/** @var FreshRSS_Feed $feed */
		foreach ($myFeeds as $feed) {
			$feeds[] = array(
				'id' => $feed->id(),
				'favicon_id' => $feed->id(),
				'title' => escapeToUnicodeAlternative($feed->name(), true),
				'url' => htmlspecialchars_decode($feed->url(), ENT_QUOTES),
				'site_url' => htmlspecialchars_decode($feed->website(), ENT_QUOTES),
				'is_spark' => 0, // unsupported
				'last_updated_on_time' => $feed->lastUpdate(),
			);
		}

		return $feeds;
	}

	protected function getGroups(): array {
		$groups = array();

		$categoryDAO = FreshRSS_Factory::createCategoryDao();
		$categories = $categoryDAO->listCategories(false, false);

		/** @var FreshRSS_Category $category */
		foreach ($categories as $category) {
			$groups[] = array(
				'id' => $category->id(),
				'title' => escapeToUnicodeAlternative($category->name(), true),
			);
		}

		return $groups;
	}

	protected function getFavicons(): array {
		$favicons = array();
		$salt = FreshRSS_Context::$system_conf->salt;
		$myFeeds = $this->feedDAO->listFeeds();

		/** @var FreshRSS_Feed $feed */
		foreach ($myFeeds as $feed) {

			$id = hash('crc32b', $salt . $feed->url());
			$filename = DATA_PATH . '/favicons/' . $id . '.ico';
			if (!file_exists($filename)) {
				continue;
			}

			$favicons[] = array(
				'id' => $feed->id(),
				'data' => image_type_to_mime_type(exif_imagetype($filename)) . ';base64,' . base64_encode(file_get_contents($filename))
			);
		}

		return $favicons;
	}

	/**
	 * @return int|false
	 */
	protected function getTotalItems() {
		return $this->entryDAO->count();
	}

	protected function getFeedsGroup(): array {
		$groups = array();
		$ids = array();
		$myFeeds = $this->feedDAO->listFeeds();

		/** @var FreshRSS_Feed $feed */
		foreach ($myFeeds as $feed) {
			$ids[$feed->category()][] = $feed->id();
		}

		foreach($ids as $category => $feedIds) {
			$groups[] = array(
				'group_id' => $category,
				'feed_ids' => implode(',', $feedIds)
			);
		}

		return $groups;
	}

	/**
	 * AFAIK there is no 'hot links' alternative in FreshRSS
	 */
	protected function getLinks(): array {
		return array();
	}

	/**
	 * @param array $ids
	 */
	protected function entriesToIdList(array $ids = array()): string {
		return implode(',', array_values($ids));
	}

	protected function getUnreadItemIds(): string {
		$entries = $this->entryDAO->listIdsWhere('a', '', FreshRSS_Entry::STATE_NOT_READ, 'ASC', 0);
		return $this->entriesToIdList($entries);
	}

	/**
	 * @return string
	 */
	protected function getSavedItemIds() {
		$entries = $this->entryDAO->listIdsWhere('a', '', FreshRSS_Entry::STATE_FAVORITE, 'ASC', 0);
		return $this->entriesToIdList($entries);
	}

	/**
	 * @return integer|false
	 */
	protected function setItemAsRead($id) {
		return $this->entryDAO->markRead($id, true);
	}

	/**
	 * @return integer|false
	 */
	protected function setItemAsUnread($id) {
		return $this->entryDAO->markRead($id, false);
	}

	/**
	 * @return integer|false
	 */
	protected function setItemAsSaved($id) {
		return $this->entryDAO->markFavorite($id, true);
	}

	/**
	 * @return integer|false
	 */
	protected function setItemAsUnsaved($id) {
		return $this->entryDAO->markFavorite($id, false);
	}

	protected function getItems(): array {
		$feed_ids = array();
		$entry_ids = array();
		$max_id = '';
		$since_id = '';

		if (isset($_REQUEST['feed_ids']) || isset($_REQUEST['group_ids'])) {
			if (isset($_REQUEST['feed_ids'])) {
				$feed_ids = explode(',', $_REQUEST['feed_ids']);
			}

			if (isset($_REQUEST['group_ids'])) {
				$categoryDAO = FreshRSS_Factory::createCategoryDao();
				$group_ids = explode(',', $_REQUEST['group_ids']);
				foreach ($group_ids as $id) {
					/** @var FreshRSS_Category $category */
					$category = $categoryDAO->searchById($id);	//TODO: Transform to SQL query without loop! Consider FreshRSS_CategoryDAO::listCategories(true)
					/** @var FreshRSS_Feed $feed */
					$feeds = [];
					foreach ($category->feeds() as $feed) {
						$feeds[] = $feed->id();
					}
				}

				$feed_ids = array_unique($feeds);
			}
		}

		if (isset($_REQUEST['max_id'])) {
			// use the max_id argument to request the previous $item_limit items
			$max_id = '' . $_REQUEST['max_id'];
			if (!ctype_digit($max_id)) {
				$max_id = '';
			}
		} elseif (isset($_REQUEST['with_ids'])) {
			$entry_ids = explode(',', $_REQUEST['with_ids']);
		} elseif (isset($_REQUEST['since_id'])) {
			// use the since_id argument to request the next $item_limit items
			$since_id = '' . $_REQUEST['since_id'];
			if (!ctype_digit($since_id)) {
				$since_id = '';
			}
		}

		$items = array();

		$feverDAO = new FeverDAO();
		$entries = $feverDAO->findEntries($feed_ids, $entry_ids, $max_id, $since_id);

		// Load list of extensions and enable the "system" ones.
		Minz_ExtensionManager::init();

		foreach ($entries as $item) {
			/** @var FreshRSS_Entry $entry */
			$entry = Minz_ExtensionManager::callHook('entry_before_display', $item);
			if ($entry == null) {
				continue;
			}
			$items[] = array(
				'id' => '' . $entry->id(),
				'feed_id' => $entry->feed(false),
				'title' => escapeToUnicodeAlternative($entry->title(), false),
				'author' => escapeToUnicodeAlternative(trim($entry->authors(true), '; '), false),
				'html' => $entry->content(),
				'url' => htmlspecialchars_decode($entry->link(), ENT_QUOTES),
				'is_saved' => $entry->isFavorite() ? 1 : 0,
				'is_read' => $entry->isRead() ? 1 : 0,
				'created_on_time' => $entry->date(true),
			);
		}

		return $items;
	}

	/**
	 * TODO replace by a dynamic fetch for id <= $before timestamp
	 */
	protected function convertBeforeToId(string $beforeTimestamp): string {
		return $beforeTimestamp == '0' ? '0' : $beforeTimestamp . '000000';
	}

	/**
	 * @return integer|false
	 */
	protected function setFeedAsRead(string $id, string $before) {
		$before = $this->convertBeforeToId($before);
		return $this->entryDAO->markReadFeed(intval($id), $before);
	}

	/**
	 * @return integer|false
	 */
	protected function setGroupAsRead(string $id, string $before) {
		$before = $this->convertBeforeToId($before);

		// special case to mark all items as read
		if ($id == '0') {
			return $this->entryDAO->markReadEntries($before);
		}

		return $this->entryDAO->markReadCat(intval($id), $before);
	}
}

// ================================================================================================
// refresh is not allowed yet, probably we find a way to support it later
if (isset($_REQUEST['refresh'])) {
	Minz_Log::warning('Fever API: Refresh items - notImplemented()', API_LOG);
	header('HTTP/1.1 501 Not Implemented');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Not Implemented!');
}

// Start the Fever API handling
$handler = new FeverAPI();

header('Content-Type: application/json; charset=UTF-8');

if (!$handler->isAuthenticatedApiUser()) {
	echo $handler->wrap(FeverAPI::STATUS_ERR, array());
} else {
	echo $handler->wrap(FeverAPI::STATUS_OK, $handler->process());
}

<?php
/**
 * Fever API for FreshRSS
 * Version 0.1
 * Author: Kevin Papst / https://github.com/kevinpapst
 *
 * Inspired by:
 * TinyTinyRSS Fever API plugin @dasmurphy
 * See https://github.com/dasmurphy/tinytinyrss-fever-plugin
 */

// refresh is not allowed yet, probably we find a way to support it later
if (isset($_REQUEST["refresh"])) {
	header('HTTP/1.1 405 Method Not Allowed', true, 405);
	exit;
}

// ================================================================================================
// BOOTSTRAP FreshRSS
require(__DIR__ . '/../../constants.php');
require(LIB_PATH . '/lib_rss.php');    //Includes class autoloader
Minz_Configuration::register('system', DATA_PATH . '/config.php', FRESHRSS_PATH . '/config.default.php');

// check if API is enabled globally
FreshRSS_Context::$system_conf = Minz_Configuration::get('system');
if (!FreshRSS_Context::$system_conf->api_enabled) {
	Minz_Log::warning('serviceUnavailable() ' . debugInfo(), API_LOG);
	header('HTTP/1.1 503 Service Unavailable');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Service Unavailable!');
}

ini_set('session.use_cookies', '0');
register_shutdown_function('session_destroy');
Minz_Session::init('FreshRSS');
// ================================================================================================

// this allows to overwrite the FeverAPI for special clients
if (!function_exists('createFeverApiInstance')) {
	function createFeverApiInstance() {
		return new FeverAPI();
	}
}

class FeverAPI_EntryDAO extends FreshRSS_EntryDAO
{
	/**
	 * @return []
	 */
	public function countFever()
	{
		$values = array(
			'total' => 0,
			'min' => 0,
			'max' => 0,
		);
		$sql = 'SELECT COUNT(id) as `total`, MIN(id) as `min`, MAX(id) as `max` FROM `' . $this->prefix . 'entry`';
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$result = $stm->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($result[0])) {
			$values = $result[0];
		}

		return $values;
	}

	/**
	 * TODO this is ugly
	 */
	protected function bindParamArray($prefix, $values, &$bindArray)
	{
		$str = "";
		foreach ($values as $index => $value) {
			$str .= ":".$prefix.$index.",";
			$bindArray[$prefix.$index] = $value;
		}
		return rtrim($str, ",");
	}

	/**
	 * @param array $feed_ids
	 * @param array $entry_ids
	 * @param int|null $max_id
	 * @param int|null $since_id
	 * @return FreshRSS_Entry[]
	 */
	public function findEntries(array $feed_ids, array $entry_ids, $max_id, $since_id)
	{
		$values = array();
		$order = '';

		$sql = 'SELECT id, guid, title, author, '
			. ($this->isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content')
			. ', link, date, is_read, is_favorite, id_feed, tags '
			. 'FROM `' . $this->prefix . 'entry` WHERE';

		if (!empty($entry_ids)) {
			$bindEntryIds = $this->bindParamArray("id", $entry_ids, $values);
			$sql .= " id IN($bindEntryIds)";
		} else if (!empty($max_id)) {
			$sql .= ' id < :id';
			$values[':id'] = $max_id;
			$order = ' ORDER BY id DESC';
		} else {
			$sql .= ' id > :id';
			$values[':id'] = $since_id;
			$order = ' ORDER BY id ASC';
		}

		if (!empty($feed_ids)) {
			$bindFeedIds = $this->bindParamArray("feed", $feed_ids, $values);
			$sql .= " AND id_feed IN($bindFeedIds)";
		}

		$sql .= $order;
		$sql .= $this->getSelectLimit($max_id, $since_id);

		$stm = $this->bd->prepare($sql);
		$stm->execute($values);
		$result = $stm->fetchAll(PDO::FETCH_ASSOC);

		$entries = array();
		foreach ($result as $dao) {
			$entries[] = self::daoToEntry($dao);
		}

		return $entries;
	}

	/**
	 * Can be overwritten to support clients that misbehave when using the API.
	 *
	 * @param $max_id
	 * @param $since_id
	 * @return string
	 */
	protected function getSelectLimit($max_id, $since_id)
	{
		return ' LIMIT 50';
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
	 * FeverAPI constructor executes authentication and initialization.
	 */
	public function __construct()
	{
		$this->authenticate();
	}

	/**
	 * Authenticate the user
	 *
	 * API Password sent from client is the result of the md5 sum of
	 * your FreshRSS "username:your-api-password" combination
	 */
	private function authenticate()
	{
		FreshRSS_Context::$user_conf = null;
		Minz_Session::_param('currentUser');
		$feverKey = empty($_POST['api_key']) ? '' : substr(trim($_POST['api_key']), 0, 128);
		if (ctype_xdigit($feverKey)) {
			$feverKey = strtolower($feverKey);
			$username = @file_get_contents(DATA_PATH . '/fever/.key-' . sha1(FreshRSS_Context::$system_conf->salt) . '-' . $feverKey . '.txt', false);
			if ($username != false) {
				$username = trim($username);
				//Check that it is not an old forgotten key
				$reverseKey = @file_get_contents(DATA_PATH . '/fever/.user-' . sha1(FreshRSS_Context::$system_conf->salt) . '-' . $username . '.txt', false);
				$reverseKey = $reverseKey == false ? '' : trim($reverseKey);
				if ($feverKey === $reverseKey && FreshRSS_user_Controller::checkUsername($username)) {
					FreshRSS_Context::$user_conf = get_user_configuration($username);
					if (FreshRSS_Context::$user_conf != null) {
						Minz_Session::_param('currentUser', $username);
					}
				}
			}
		}
	}

	/**
	 * @return bool
	 */
	public function isAuthenticatedApiUser()
	{
		if (FreshRSS_Context::$user_conf !== null) {
			return true;
		}

		return false;
	}

	/**
	 * @return FreshRSS_FeedDAO
	 */
	protected function getDaoForFeeds()
	{
		return new FreshRSS_FeedDAO();
	}

	/**
	 * @return FreshRSS_CategoryDAO
	 */
	protected function getDaoForCategories()
	{
		return new FreshRSS_CategoryDAO();
	}

	/**
	 * @return FeverAPI_EntryDAO
	 */
	protected function getDaoForEntries()
	{
		return new FeverAPI_EntryDAO();
	}

	/**
	 * this does all the processing, since the fever api does not have a specific variable that specifies the operation
	 */
	public function process()
	{
		$response_arr = array();

		if (!$this->isAuthenticatedApiUser()) {
			throw new Exception('No user given or user is not allowed to access API');
		}

		if (isset($_REQUEST["groups"])) {
			$response_arr["groups"] = $this->getGroups();
			$response_arr["feeds_groups"] = $this->getFeedsGroup();
		}

		if (isset($_REQUEST["feeds"])) {
			$response_arr["feeds"] = $this->getFeeds();
			$response_arr["feeds_groups"] = $this->getFeedsGroup();
		}

		if (isset($_REQUEST["favicons"])) {
			$response_arr["favicons"] = $this->getFavicons();
		}

		if (isset($_REQUEST["items"])) {
			$response_arr["total_items"] = $this->getTotalItems();
			$response_arr["items"] = $this->getItems();
		}

		if (isset($_REQUEST["links"])) {
			$response_arr["links"] = $this->getLinks();
		}

		if (isset($_REQUEST["unread_item_ids"])) {
			$response_arr["unread_item_ids"] = $this->getUnreadItemIds();
		}

		if (isset($_REQUEST["saved_item_ids"])) {
			$response_arr["saved_item_ids"] = $this->getSavedItemIds();
		}

		if (isset($_REQUEST["mark"], $_REQUEST["as"], $_REQUEST["id"]) && is_numeric($_REQUEST["id"])) {
			$method_name = "set" . ucfirst($_REQUEST["mark"]) . "As" . ucfirst($_REQUEST["as"]);
			if (method_exists($this, $method_name)) {
				$id = intval($_REQUEST["id"]);
				switch (strtolower($_REQUEST["mark"])) {
					case 'item':
						$this->{$method_name}($id);
						break;
					case 'feed':
					case 'group':
						$before = (isset($_REQUEST["before"])) ? $_REQUEST["before"] : null;
						$this->{$method_name}($id, $before);
						break;
				}

				switch ($_REQUEST["as"]) {
					case "read":
					case "unread":
						$response_arr["unread_item_ids"] = $this->getUnreadItemIds();
						break;

					case 'saved':
					case 'unsaved':
						$response_arr["saved_item_ids"] = $this->getSavedItemIds();
						break;
				}
			}
		}

		return $response_arr;
	}

	/**
	 * Returns the complete JSON, with 'api_version' and status as 'auth'.
	 *
	 * @param int $status
	 * @param array $reply
	 * @return string
	 */
	public function wrap($status, array $reply = array())
	{
		$arr = array('api_version' => self::API_LEVEL, 'auth' => $status);

		if ($status === self::STATUS_OK) {
			$arr['last_refreshed_on_time'] = (string) $this->lastRefreshedOnTime();
			$arr = array_merge($arr, $reply);
		}

		return json_encode($arr);
	}

	/**
	 * every authenticated method includes last_refreshed_on_time
	 *
	 * @return int
	 */
	protected function lastRefreshedOnTime()
	{
		$lastUpdate = 0;

		$dao = $this->getDaoForFeeds();
		$entries = $dao->listFeedsOrderUpdate(-1, 1);
		$feed = current($entries);

		if (!empty($feed)) {
			$lastUpdate = $feed->lastUpdate();
		}

		return $lastUpdate;
	}

	/**
	 * @return array
	 */
	protected function getFeeds()
	{
		$feeds = array();

		$dao = $this->getDaoForFeeds();
		$myFeeds = $dao->listFeeds();

		/** @var FreshRSS_Feed $feed */
		foreach ($myFeeds as $feed) {
			$feeds[] = array(
				"id" => $feed->id(),
				"favicon_id" => $feed->id(),
				"title" => $feed->name(),
				"url" => $feed->url(),
				"site_url" => $feed->website(),
				"is_spark" => 0, // unsupported
				"last_updated_on_time" => $feed->lastUpdate()
			);
		}

		return $feeds;
	}

	/**
	 * @return array
	 */
	protected function getGroups()
	{
		$groups = array();

		$dao = $this->getDaoForCategories();
		$categories = $dao->listCategories(false, false);

		/** @var FreshRSS_Category $category */
		foreach ($categories as $category) {
			$groups[] = array(
				'id' => $category->id(),
				'title' => $category->name()
			);
		}

		return $groups;
	}

	/**
	 * @return array
	 */
	protected function getFavicons()
	{
		$favicons = array();

		$dao = $this->getDaoForFeeds();
		$myFeeds = $dao->listFeeds();

		$salt = FreshRSS_Context::$system_conf->salt;

		/** @var FreshRSS_Feed $feed */
		foreach ($myFeeds as $feed) {

			$id = hash('crc32b', $salt . $feed->url());
			$filename = DATA_PATH . '/favicons/' . $id . '.ico';
			if (!file_exists($filename)) {
				continue;
			}

			$favicons[] = array(
				"id" => $feed->id(),
				"data" => image_type_to_mime_type(exif_imagetype($filename)) . ";base64," . base64_encode(file_get_contents($filename))
			);
		}

		return $favicons;
	}

	/**
	 * @return int
	 */
	protected function getTotalItems()
	{
		$total_items = 0;

		$dao = $this->getDaoForEntries();
		$result = $dao->countFever();

		if (!empty($result)) {
			$total_items = $result['total'];
		}

		return $total_items;
	}

	/**
	 * @return array
	 */
	protected function getFeedsGroup()
	{
		$groups = array();
		$ids = array();

		$dao = $this->getDaoForFeeds();
		$myFeeds = $dao->listFeeds();

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
	 * @return array
	 */
	protected function getLinks()
	{
		return array();
	}

	/**
	 * @param array $ids
	 * @return string
	 */
	protected function entriesToIdList($ids = array())
	{
		return implode(',', array_values($ids));
	}

	/**
	 * @return string
	 */
	protected function getUnreadItemIds()
	{
		$dao = $this->getDaoForEntries();
		$entries = $dao->listIdsWhere('a', '', FreshRSS_Entry::STATE_NOT_READ, 'ASC', PHP_INT_MAX);
		return $this->entriesToIdList($entries);
	}

	/**
	 * @return string
	 */
	protected function getSavedItemIds()
	{
		$dao = $this->getDaoForEntries();
		$entries = $dao->listIdsWhere('a', '', FreshRSS_Entry::STATE_FAVORITE, 'ASC', PHP_INT_MAX);
		return $this->entriesToIdList($entries);
	}

	protected function setItemAsRead($id)
	{
		$dao = $this->getDaoForEntries();
		$dao->markRead($id, true);
	}

	protected function setItemAsUnread($id)
	{
		$dao = $this->getDaoForEntries();
		$dao->markRead($id, false);
	}

	protected function setItemAsSaved($id)
	{
		$dao = $this->getDaoForEntries();
		$dao->markFavorite($id, true);
	}

	protected function setItemAsUnsaved($id)
	{
		$dao = $this->getDaoForEntries();
		$dao->markFavorite($id, false);
	}

	/**
	 * @return array
	 */
	protected function getItems()
	{
		$feed_ids = array();
		$entry_ids = array();
		$max_id = null;
		$since_id = null;

		if (isset($_REQUEST["feed_ids"]) || isset($_REQUEST["group_ids"])) {
			if (isset($_REQUEST["feed_ids"])) {
				$feed_ids = explode(",", $_REQUEST["feed_ids"]);
			}

			$dao = $this->getDaoForCategories();
			if (isset($_REQUEST["group_ids"])) {
				$group_ids = explode(",", $_REQUEST["group_ids"]);
				foreach ($group_ids as $id) {
					/** @var FreshRSS_Category $category */
					$category = $dao->searchById($id);
					/** @var FreshRSS_Feed $feed */
					foreach ($category->feeds() as $feed) {
						$feeds[] = $feed->id();
					}
				}

				$feed_ids = array_unique($feeds);
			}
		}

		if (isset($_REQUEST["max_id"])) {
			// use the max_id argument to request the previous $item_limit items
			if (is_numeric($_REQUEST["max_id"])) {
				$max = ($_REQUEST["max_id"] > 0) ? intval($_REQUEST["max_id"]) : 0;
				if ($max) {
					$max_id = $max;
				}
			}
		} else if (isset($_REQUEST["with_ids"])) {
			$entry_ids = explode(",", $_REQUEST["with_ids"]);
		} else {
			// use the since_id argument to request the next $item_limit items
			$since_id = isset($_REQUEST["since_id"]) && is_numeric($_REQUEST["since_id"]) ? intval($_REQUEST["since_id"]) : 0;
		}

		$items = array();

		$dao = $this->getDaoForEntries();
		$entries = $dao->findEntries($feed_ids, $entry_ids, $max_id, $since_id);

		// Load list of extensions and enable the "system" ones.
		Minz_ExtensionManager::init();

		foreach($entries as $item) {
			$entry = Minz_ExtensionManager::callHook('entry_before_display', $item);
			if (is_null($entry)) {
				continue;
			}
			$items[] = array(
				"id" => $entry->id(),
				"feed_id" => $entry->feed(false),
				"title" => $entry->title(),
				"author" => $entry->author(),
				"html" => $entry->content(),
				"url" => $entry->link(),
				"is_saved" => $entry->isFavorite() ? 1 : 0,
				"is_read" => $entry->isRead() ? 1 : 0,
				"created_on_time" => $entry->date(true)
			);
		}

		return $items;
	}

	/**
	 * TODO replace by a dynamic fetch for id <= $before timestamp
	 *
	 * @param int $beforeTimestamp
	 * @return int
	 */
	protected function convertBeforeToId($beforeTimestamp)
	{
		// if before is zero, set it to now so feeds all items are read from before this point in time
		if ($beforeTimestamp == 0) {
			$before = time();
		}
		$before = PHP_INT_MAX;

		return $before;
	}

	protected function setFeedAsRead($id, $before)
	{
		$before = $this->convertBeforeToId($before);
		$dao = $this->getDaoForEntries();
		return $dao->markReadFeed($id, $before);
	}

	protected function setGroupAsRead($id, $before)
	{
		$dao = $this->getDaoForEntries();

		// special case to mark all items as read
		if ($id === 0) {
			$result = $dao->countFever();

			if (!empty($result)) {
				return $dao->markReadEntries($result['max']);
			}
		}

		$before = $this->convertBeforeToId($before);
		return $dao->markReadCat($id, $before);
	}
}

// ================================================================================================
// Start the Fever API handling
$handler = createFeverApiInstance();

header("Content-Type: application/json; charset=UTF-8");

if (!$handler->isAuthenticatedApiUser()) {
	echo $handler->wrap(FeverAPI::STATUS_ERR, array());
} else {
	echo $handler->wrap(FeverAPI::STATUS_OK, $handler->process());
}

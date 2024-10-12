<?php
declare(strict_types=1);

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
if (!FreshRSS_Context::hasSystemConf() || !FreshRSS_Context::systemConf()->api_enabled) {
	Minz_Log::warning('Fever API: service unavailable!');
	Minz_Log::debug('Fever API: serviceUnavailable() ' . debugInfo(), API_LOG);
	header('HTTP/1.1 503 Service Unavailable');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Service Unavailable!');
}

Minz_Session::init('FreshRSS', true);
// ================================================================================================

// <Debug>
$ORIGINAL_INPUT = file_get_contents('php://input', false, null, 0, 1_048_576) ?: '';;

function debugInfo(): string {
	if (function_exists('getallheaders')) {
		$ALL_HEADERS = getallheaders();
	} else {	//nginx	http://php.net/getallheaders#84262
		$ALL_HEADERS = [];
		foreach ($_SERVER as $name => $value) {
			if (substr($name, 0, 5) === 'HTTP_') {
				$ALL_HEADERS[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
	}
	global $ORIGINAL_INPUT;
	$log = sensitive_log([
			'date' => date('c'),
			'headers' => $ALL_HEADERS,
			'_SERVER' => $_SERVER,
			'_GET' => $_GET,
			'_POST' => $_POST,
			'_COOKIE' => $_COOKIE,
			'INPUT' => $ORIGINAL_INPUT,
		]);
	return print_r($log, true);
}

//Minz_Log::debug('----------------------------------------------------------------', API_LOG);
//Minz_Log::debug(debugInfo(), API_LOG);
// </Debug>

final class FeverDAO extends Minz_ModelPdo
{
	/**
	 * @param array<string|int> $values
	 * @param array<string,string|int> $bindArray
	 */
	private function bindParamArray(string $prefix, array $values, array &$bindArray): string {
		$str = '';
		for ($i = 0; $i < count($values); $i++) {
			$str .= ':' . $prefix . $i . ',';
			$bindArray[$prefix . $i] = $values[$i];
		}
		return rtrim($str, ',');
	}

	/**
	 * @param array<string|int> $feed_ids
	 * @param array<string> $entry_ids
	 * @return FreshRSS_Entry[]
	 */
	public function findEntries(array $feed_ids, array $entry_ids, string $max_id, string $since_id): array {
		$values = [];
		$order = '';
		$entryDAO = FreshRSS_Factory::createEntryDao();

		$sql = 'SELECT id, guid, title, author, '
			. ($entryDAO::isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content')
			. ', link, date, is_read, is_favorite, id_feed, attributes '
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
		if ($stm !== false && $stm->execute($values)) {
			$result = $stm->fetchAll(PDO::FETCH_ASSOC);

			$entries = [];
			foreach ($result as $dao) {
				$entries[] = FreshRSS_Entry::fromArray($dao);
			}

			return $entries;
		}
		return [];
	}
}

/**
 * Class FeverAPI
 */
final class FeverAPI
{
	public const API_LEVEL = 3;
	public const STATUS_OK = 1;
	public const STATUS_ERR = 0;

	private FreshRSS_EntryDAO $entryDAO;

	private FreshRSS_FeedDAO $feedDAO;

	/**
	 * Authenticate the user
	 *
	 * API Password sent from client is the result of the md5 sum of
	 * your FreshRSS "username:your-api-password" combination
	 */
	private function authenticate(): bool {
		FreshRSS_Context::clearUserConf();
		Minz_User::change();
		$feverKey = empty($_POST['api_key']) ? '' : substr(trim($_POST['api_key']), 0, 128);
		if (ctype_xdigit($feverKey)) {
			$feverKey = strtolower($feverKey);
			$username = @file_get_contents(DATA_PATH . '/fever/.key-' . sha1(FreshRSS_Context::systemConf()->salt) . '-' . $feverKey . '.txt', false);
			if ($username != false) {
				$username = trim($username);
				FreshRSS_Context::initUser($username);
				if ($feverKey === FreshRSS_Context::userConf()->feverKey && FreshRSS_Context::userConf()->enabled) {
					Minz_Translate::init(FreshRSS_Context::userConf()->language);
					$this->entryDAO = FreshRSS_Factory::createEntryDao();
					$this->feedDAO = FreshRSS_Factory::createFeedDao();
					return true;
				} else {
					Minz_Translate::init();
				}
				Minz_Log::error('Fever API: Reset API password for user: ' . $username, API_LOG);
				Minz_Log::error('Fever API: Please reset your API password!');
				Minz_User::change();
			}
			Minz_Log::warning('Fever API: wrong credentials! ' . $feverKey, API_LOG);
		}
		return false;
	}

	public function isAuthenticatedApiUser(): bool {
		$this->authenticate();
		return FreshRSS_Context::hasUserConf();
	}

	/**
	 * This does all the processing, since the fever api does not have a specific variable that specifies the operation
	 * @return array<string,mixed>
	 * @throws Exception
	 */
	public function process(): array {
		$response_arr = [];

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

		if (isset($_REQUEST['mark'], $_REQUEST['as'], $_REQUEST['id']) && ctype_digit($_REQUEST['id'])) {
			$id = (string)$_REQUEST['id'];
			$before = (int)($_REQUEST['before'] ?? '0');
			switch (strtolower($_REQUEST['mark'])) {
				case 'item':
					switch ($_REQUEST['as']) {
						case 'read':
							$this->setItemAsRead($id);
							break;
						case 'saved':
							$this->setItemAsSaved($id);
							break;
						case 'unread':
							$this->setItemAsUnread($id);
							break;
						case 'unsaved':
							$this->setItemAsUnsaved($id);
							break;
					}
					break;
				case 'feed':
					switch ($_REQUEST['as']) {
						case 'read':
							$this->setFeedAsRead((int)$id, $before);
							break;
					}
					break;
				case 'group':
					switch ($_REQUEST['as']) {
						case 'read':
							$this->setGroupAsRead((int)$id, $before);
							break;
					}
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

		return $response_arr;
	}

	/**
	 * Returns the complete JSON, with 'api_version' and status as 'auth'.
	 * @param array<string,mixed> $reply
	 */
	public function wrap(int $status, array $reply = []): string {
		$arr = ['api_version' => self::API_LEVEL, 'auth' => $status];

		if ($status === self::STATUS_OK) {
			$arr['last_refreshed_on_time'] = $this->lastRefreshedOnTime();
			$arr = array_merge($arr, $reply);
		}

		return json_encode($arr) ?: '';
	}

	/**
	 * every authenticated method includes last_refreshed_on_time
	 */
	private function lastRefreshedOnTime(): int {
		$lastUpdate = 0;

		$entries = $this->feedDAO->listFeedsOrderUpdate(-1, 1);
		$feed = current($entries);

		if (!empty($feed)) {
			$lastUpdate = $feed->lastUpdate();
		}

		return $lastUpdate;
	}

	/** @return array<array<string,string|int>> */
	private function getFeeds(): array {
		$feeds = [];
		$myFeeds = $this->feedDAO->listFeeds();

		/** @var FreshRSS_Feed $feed */
		foreach ($myFeeds as $feed) {
			$feeds[] = [
				'id' => $feed->id(),
				'favicon_id' => $feed->id(),
				'title' => escapeToUnicodeAlternative($feed->name(), true),
				'url' => htmlspecialchars_decode($feed->url(), ENT_QUOTES),
				'site_url' => htmlspecialchars_decode($feed->website(), ENT_QUOTES),
				'is_spark' => 0,
				// unsupported
				'last_updated_on_time' => $feed->lastUpdate(),
			];
		}

		return $feeds;
	}

	/** @return array<array<string,int|string>> */
	private function getGroups(): array {
		$groups = [];

		$categoryDAO = FreshRSS_Factory::createCategoryDao();
		$categories = $categoryDAO->listCategories(false, false) ?: [];

		foreach ($categories as $category) {
			$groups[] = [
				'id' => $category->id(),
				'title' => escapeToUnicodeAlternative($category->name(), true)
			];
		}

		return $groups;
	}

	/** @return array<array<string,int|string>> */
	private function getFavicons(): array {
		if (!FreshRSS_Context::hasSystemConf()) {
			return [];
		}

		require_once(LIB_PATH . '/favicons.php');

		$favicons = [];
		$salt = FreshRSS_Context::systemConf()->salt;
		$myFeeds = $this->feedDAO->listFeeds();

		foreach ($myFeeds as $feed) {
			$id = hash('crc32b', $salt . $feed->url());
			$filename = DATA_PATH . '/favicons/' . $id . '.ico';
			if (!file_exists($filename)) {
				continue;
			}

			$favicons[] = [
				'id' => $feed->id(),
				'data' => contentType($filename) . ';base64,' . base64_encode(file_get_contents($filename) ?: '')
			];
		}

		return $favicons;
	}

	private function getTotalItems(): int {
		return $this->entryDAO->count();
	}

	/**
	 * @return array<array<string,int|string>>
	 */
	private function getFeedsGroup(): array {
		$groups = [];
		$ids = [];
		$myFeeds = $this->feedDAO->listFeeds();

		foreach ($myFeeds as $feed) {
			$ids[$feed->categoryId()][] = $feed->id();
		}

		foreach ($ids as $category => $feedIds) {
			$groups[] = [
				'group_id' => $category,
				'feed_ids' => implode(',', $feedIds)
			];
		}

		return $groups;
	}

	/**
	 * AFAIK there is no 'hot links' alternative in FreshRSS
	 * @return array<string>
	 */
	private function getLinks(): array {
		return [];
	}

	/**
	 * @param array<numeric-string> $ids
	 */
	private function entriesToIdList(array $ids = []): string {
		return implode(',', array_values($ids));
	}

	private function getUnreadItemIds(): string {
		$entries = $this->entryDAO->listIdsWhere('a', 0, FreshRSS_Entry::STATE_NOT_READ, 'ASC', 0) ?? [];
		return $this->entriesToIdList($entries);
	}

	private function getSavedItemIds(): string {
		$entries = $this->entryDAO->listIdsWhere('a', 0, FreshRSS_Entry::STATE_FAVORITE, 'ASC', 0) ?? [];
		return $this->entriesToIdList($entries);
	}

	/**
	 * @param numeric-string $id
	 * @return int|false
	 */
	private function setItemAsRead(string $id) {
		return $this->entryDAO->markRead($id, true);
	}

	/**
	 * @param numeric-string $id
	 * @return int|false
	 */
	private function setItemAsUnread(string $id) {
		return $this->entryDAO->markRead($id, false);
	}

	/**
	 * @param numeric-string $id
	 * @return int|false
	 */
	private function setItemAsSaved(string $id) {
		return $this->entryDAO->markFavorite($id, true);
	}

	/**
	 * @param numeric-string $id
	 * @return int|false
	 */
	private function setItemAsUnsaved(string $id) {
		return $this->entryDAO->markFavorite($id, false);
	}

	/** @return array<array<string,string|int>> */
	private function getItems(): array {
		$feed_ids = [];
		$entry_ids = [];
		$max_id = '';
		$since_id = '';

		if (isset($_REQUEST['feed_ids']) || isset($_REQUEST['group_ids'])) {
			if (isset($_REQUEST['feed_ids'])) {
				$feed_ids = explode(',', $_REQUEST['feed_ids']);
			}

			if (isset($_REQUEST['group_ids'])) {
				$categoryDAO = FreshRSS_Factory::createCategoryDao();
				$group_ids = explode(',', $_REQUEST['group_ids']);
				$feeds = [];
				foreach ($group_ids as $id) {
					$category = $categoryDAO->searchById((int)$id);	//TODO: Transform to SQL query without loop! Consider FreshRSS_CategoryDAO::listCategories(true)
					if ($category == null) {
						continue;
					}
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

		$items = [];

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
			$items[] = [
				'id' => $entry->id(),
				'feed_id' => $entry->feedId(),
				'title' => escapeToUnicodeAlternative($entry->title(), false),
				'author' => escapeToUnicodeAlternative(trim($entry->authors(true), '; '), false),
				'html' => $entry->content(), 'url' => htmlspecialchars_decode($entry->link(), ENT_QUOTES),
				'is_saved' => $entry->isFavorite() ? 1 : 0,
				'is_read' => $entry->isRead() ? 1 : 0,
				'created_on_time' => $entry->date(true),
			];
		}

		return $items;
	}

	/**
	 * TODO replace by a dynamic fetch for id <= $before timestamp
	 * @return numeric-string
	 */
	private function convertBeforeToId(int $beforeTimestamp): string {
		return $beforeTimestamp == 0 ? '0' : $beforeTimestamp . '000000';
	}

	/**
	 * @return int|false
	 */
	private function setFeedAsRead(int $id, int $before) {
		$before = $this->convertBeforeToId($before);
		return $this->entryDAO->markReadFeed($id, $before);
	}

	/**
	 * @return int|false
	 */
	private function setGroupAsRead(int $id, int $before) {
		$before = $this->convertBeforeToId($before);

		// special case to mark all items as read
		if ($id == 0) {
			return $this->entryDAO->markReadEntries($before);
		}

		return $this->entryDAO->markReadCat($id, $before);
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
	echo $handler->wrap(FeverAPI::STATUS_ERR, []);
} else {
	echo $handler->wrap(FeverAPI::STATUS_OK, $handler->process());
}

<?php
/**
== Description ==
Server-side API compatible with Google Reader API layer 2
	for the FreshRSS project http://freshrss.org

== Credits ==
* 2014-02: Released by Alexandre Alapetite http://alexandre.alapetite.fr
	under GNU AGPL 3 license http://www.gnu.org/licenses/agpl-3.0.html

== Documentation ==
* http://code.google.com/p/pyrfeed/wiki/GoogleReaderAPI
* http://web.archive.org/web/20130718025427/http://undoc.in/
* http://ranchero.com/downloads/GoogleReaderAPI-2009.pdf
* http://code.google.com/p/google-reader-api/w/list
* http://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2/
* https://github.com/noinnion/newsplus/blob/master/extensions/GoogleReaderCloneExtension/src/com/noinnion/android/newsplus/extension/google_reader/GoogleReaderClient.java
* https://github.com/ericmann/gReader-Library/blob/master/greader.class.php
* https://github.com/devongovett/reader
* https://github.com/theoldreader/api
*/

define('TEMP_PASSWORD', 'temp123');	//Change to another ASCII password
define('TEMP_AUTH', 'XtofqkkOkCULRLH8');	//Change to another random ASCII auth

require('../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

$ORIGINAL_INPUT = file_get_contents('php://input');
$ALL_HEADERS = getallheaders();

$debugInfo = array('date' => date('c'), 'headers' => $ALL_HEADERS, '_SERVER' => $_SERVER, '_GET' => $_GET, '_POST' => $_POST, '_COOKIE' => $_COOKIE, 'INPUT' => $ORIGINAL_INPUT);

if (PHP_INT_SIZE < 8) {	//32-bit
	function dec2hex($dec) {
		return str_pad(gmp_strval(gmp_init($dec, 10), 16), 16, '0', STR_PAD_LEFT);
	}
	function hex2dec($hex) {
		return gmp_strval(gmp_init($hex, 16), 10);
	}
} else {	//64-bit
	function dec2hex($dec) {	//http://code.google.com/p/google-reader-api/wiki/ItemId
		return str_pad(dechex($dec), 16, '0', STR_PAD_LEFT);
	}
	function hex2dec($hex) {
		return hexdec($hex);
	}
}

function headerVariable($headerName, $varName) {
	global $ALL_HEADERS;
	if (empty($ALL_HEADERS[$headerName])) {
		return null;
	}
	parse_str($ALL_HEADERS[$headerName], $pairs);
	//logMe('headerVariable(' . $headerName . ') => ' . print_r($pairs, true));
	return isset($pairs[$varName]) ? $pairs[$varName] : null;
}

function multiplePosts($name) {	//https://bugs.php.net/bug.php?id=51633
	global $ORIGINAL_INPUT;
	$inputs = explode('&', $ORIGINAL_INPUT);
	$result = array();
	$prefix = $name . '=';
	$prefixLength = strlen($prefix);
	foreach ($inputs as $input) {
		if (strpos($input, $prefix) === 0) {
			$result[] = urldecode(substr($input, $prefixLength));
		}
	}
	return $result;
}

class MyPDO extends Minz_ModelPdo {
	function prepare($sql) {
		return $this->bd->prepare(str_replace('%_', $this->prefix, $sql));
	}
}

function logMe($text) {
	file_put_contents(LOG_PATH . '/api.log', $text, FILE_APPEND);
}

function badRequest() {
	logMe("badRequest()\n");
	header('HTTP/1.1 400 Bad Request');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Bad Request!');
}

function unauthorized() {
	logMe("unauthorized()\n");
	header('HTTP/1.1 401 Unauthorized');
	header('Content-Type: text/plain; charset=UTF-8');
	header('Google-Bad-Token: true');
	die('Unauthorized!');
}

function notImplemented() {
	logMe("notImplemented()\n");
	header('HTTP/1.1 501 Not Implemented');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Not Implemented!');
}

function serviceUnavailable() {
	logMe("serviceUnavailable()\n");
	header('HTTP/1.1 503 Service Unavailable');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Service Unavailable!');
}

function checkCompatibility() {
	logMe("checkCompatibility()\n");
	header('Content-Type: text/plain; charset=UTF-8');
	$ok = true;
	$ok &= function_exists('getallheaders');
	echo $ok ? 'PASS' : 'FAIL';
	exit();
}

function authorizationToUser() {
	$headerAuth = headerVariable('Authorization', 'GoogleLogin_auth');	//Input is 'GoogleLogin auth', but PHP replaces spaces by '_'	http://php.net/language.variables.external
	if ($headerAuth != '') {
		$headerAuthX = explode('/', $headerAuth, 2);
		if ((count($headerAuthX) === 2) && ($headerAuthX[1] === TEMP_AUTH)) {
			$user = $headerAuthX[0];
			if (ctype_alnum($user)) {
				return $user;
			}
		}
	}
	return null;
}

function clientLogin($email, $pass) {	//http://web.archive.org/web/20130604091042/http://undoc.in/clientLogin.html
	logMe('clientLogin(' . $email . ")\n");
	if ($pass !== TEMP_PASSWORD) {
		unauthorized();
	}
	header('Content-Type: text/plain; charset=UTF-8');
	$auth = $email . '/' . TEMP_AUTH;
	echo 'SID=', $auth, "\n",
		'Auth=', $auth, "\n";
	exit();
}

function token($user) {
//http://blog.martindoms.com/2009/08/15/using-the-google-reader-api-part-1/	https://github.com/ericmann/gReader-Library/blob/master/greader.class.php
	logMe('token('. $user . ")\n");
	$token = 'ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ01234';	//Must have 57 characters...
	echo $token, "\n";
	exit();
}

function checkToken($user, $token) {
//http://code.google.com/p/google-reader-api/wiki/ActionToken
	logMe('checkToken(' . $token . ")\n");
	if ($token === 'ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ01234') {
		return true;
	}
	unauthorized();
}

function tagList() {
	logMe("tagList()\n");
	header('Content-Type: application/json; charset=UTF-8');

	$pdo = new MyPDO();
	$stm = $pdo->prepare('SELECT c.name FROM `%_category` c');
	$stm->execute();
	$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);

	$tags = array(
		array('id' => 'user/-/state/com.google/starred'),
		//array('id' => 'user/-/state/com.google/broadcast', 'sortid' => '2'),
	);

	foreach ($res as $cName) {
		$tags[] = array(
			'id' => 'user/-/label/' . $cName,
			//'sortid' => $cName,
		);
	}

	echo json_encode(array('tags' => $tags)), "\n";
	exit();
}

function subscriptionList() {
	logMe("subscriptionList()\n");
	header('Content-Type: application/json; charset=UTF-8');

	$pdo = new MyPDO();
	$stm = $pdo->prepare('SELECT f.id, f.name, f.url, f.website, c.id as c_id, c.name as c_name FROM `%_feed` f
		INNER JOIN `%_category` c ON c.id = f.category');
	$stm->execute();
	$res = $stm->fetchAll(PDO::FETCH_ASSOC);

	$subscriptions = array();

	foreach ($res as $line) {
		$subscriptions[] = array(
			'id' => 'feed/' . $line['id'],
			'title' => $line['name'],
			'categories' => array(
				array(
					'id' => 'user/-/label/' . $line['c_name'],
					'label' => $line['c_name'],
				),
			),
			//'sortid' => $line['name'],
			//'firstitemmsec' => 0,
			'url' => $line['url'],
			'htmlUrl' => $line['website'],
			//'iconUrl' => '',
		);
	}

	echo json_encode(array('subscriptions' => $subscriptions)), "\n";
	exit();
}

function unreadCount() {
	logMe("unreadCount()\n");
	header('Content-Type: application/json; charset=UTF-8');

	$pdo = new MyPDO();
	$stm = $pdo->prepare('SELECT f.id, f.lastUpdate, f.cache_nbUnreads FROM `%_feed` f');
	$stm->execute();
	$res = $stm->fetchAll(PDO::FETCH_ASSOC);

	$unreadcounts = array();
	$totalUnreads = 0;
	$totalLastUpdate = 0;
	foreach ($res as $line) {
		$nbUnreads = $line['cache_nbUnreads'];
		$totalUnreads += $nbUnreads;
		$lastUpdate = $line['lastUpdate'];
		if ($totalLastUpdate < $lastUpdate) {
			$totalLastUpdate = $lastUpdate;
		}
		$unreadcounts[] = array(
			'id' => 'feed/' . $line['id'],
			'count' => $nbUnreads,
			'newestItemTimestampUsec' => $lastUpdate . '000000',
		);
	}

	$unreadcounts[] = array(
		'id' => 'user/-/state/com.google/reading-list',
		'count' => $totalUnreads,
		'newestItemTimestampUsec' => $totalLastUpdate . '000000',
	);

	echo json_encode(array(
		'max' => $totalUnreads,
		'unreadcounts' => $unreadcounts,
	)), "\n";
	exit();
}

function streamContents($path, $include_target, $start_time, $count, $order, $exclude_target)
{//http://code.google.com/p/pyrfeed/wiki/GoogleReaderAPI	http://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2/#feed
	logMe('streamContents(' . $include_target . ")\n");
	header('Content-Type: application/json; charset=UTF-8');

	$feedDAO = new FreshRSS_FeedDAO();
	$arrayFeedCategoryNames = $feedDAO->arrayCategoryNames();

	switch ($path) {
		case 'reading-list':
			$type = 'A';
			break;
		case 'starred':
			$type = 's';
			break;
		case 'feed':
			$type = 'f';
			break;
		case 'label':
			$type = 'c';
			$categoryDAO = new FreshRSS_CategoryDAO();
			$cat = $categoryDAO->searchByName($include_target);
			$include_target = $cat == null ? -1 : $cat->id();
			break;
		default:
			$type = 'A';
			break;
	}

	switch ($exclude_target) {
		case 'user/-/state/com.google/read':
			$state = 'not_read';
			break;
		default:
			$state = 'all';
			break;
	}

	$entryDAO = new FreshRSS_EntryDAO();
	$entries = $entryDAO->listWhere($type, $include_target, $state, $order === 'o' ? 'ASC' : 'DESC', $count, '', '', $start_time);

	$items = array();
	foreach ($entries as $entry) {
		$f_id = $entry->feed();
		$c_name = isset($arrayFeedCategoryNames[$f_id]) ? $arrayFeedCategoryNames[$f_id] : '_';
		$item = array(
			'id' => /*'tag:google.com,2005:reader/item/' .*/ dec2hex($entry->id()),	//64-bit hexa http://code.google.com/p/google-reader-api/wiki/ItemId
			'crawlTimeMsec' => substr($entry->id(), 0, -3),
			'published' => $entry->date(true),
			'title' => $entry->title(),
			'summary' => array('content' => $entry->content()),
			'alternate' => array(
				array('href' => $entry->link()),
			),
			'categories' => array(
				'user/-/state/com.google/reading-list',
				'user/-/label/' . $c_name,
			),
			'origin' => array(
				'streamId' => 'feed/' . $f_id,
				//'title' => $line['f_name'],
				//'htmlUrl' => $line['f_website'],
			),
		);
		if ($entry->author() != '') {
			$item['author'] = $entry->author();
		}
		if ($entry->isRead()) {
			$item['categories'][] = 'user/-/state/com.google/read';
		}
		if ($entry->isFavorite()) {
			$item['categories'][] = 'user/-/state/com.google/starred';
		}
		$items[] = $item;
	}

	echo json_encode(array(
		'id' => 'user/-/state/com.google/reading-list',
		'updated' => time(),
		'items' => $items,
	)), "\n";
	exit();
}

function streamContentsItemsIds($streamId, $start_time, $count, $order, $exclude_target)
{//http://code.google.com/p/google-reader-api/wiki/ApiStreamItemsIds	http://code.google.com/p/pyrfeed/wiki/GoogleReaderAPI	http://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2/#feed
	logMe('streamContentsItemsIds(' . $streamId . ")\n");

	$type = 'A';
	$id = '';
	if ($streamId === 'user/-/state/com.google/reading-list') {
		$type = 'A';
	} elseif ('user/-/state/com.google/starred') {
		$type = 's';
	} elseif (strpos($streamId, 'feed/') === 0) {
		$type = 'f';
		$id = basename($streamId);
	} elseif (strpos($streamId, 'user/-/label/') === 0) {
		$type = 'c';
		$c_name = basename($streamId);
		$categoryDAO = new FreshRSS_CategoryDAO();
		$cat = $categoryDAO->searchByName($c_name);
		$id = $cat == null ? -1 : $cat->id();
	}

	switch ($exclude_target) {
		case 'user/-/state/com.google/read':
			$state = 'not_read';
			break;
		default:
			$state = 'all';
			break;
	}

	$entryDAO = new FreshRSS_EntryDAO();
	$entries = $entryDAO->listWhere($type, $id, $state, $order === 'o' ? 'ASC' : 'DESC', $count, '', '', $start_time);

	$itemRefs = array();
	foreach ($entries as $entry) {
		$f_id = $entry->feed();
		$itemRefs[] = array(
			'id' => $entry->id(),	//64-bit decimal
			//'timestampUsec' => $entry->dateAdded(true),
			/*'directStreamIds' => array(
				'feed/' . $entry->feed()
			),*/
		);
	}

	echo json_encode(array(
		'itemRefs' => $itemRefs,
	)), "\n";
	exit();
}

function editTag($e_ids, $a, $r) {
	logMe("editTag()\n");
	$entryDAO = new FreshRSS_EntryDAO();

	foreach ($e_ids as $e_id) {	//TODO: User WHERE...IN
		$e_id = hex2dec(basename($e_id));	//Strip prefix 'tag:google.com,2005:reader/item/'
		switch ($a) {
			case 'user/-/state/com.google/read':
				$entryDAO->markRead($e_id, true);
				break;
			case 'user/-/state/com.google/starred':
				$entryDAO->markFavorite($e_id, true);
				break;
			/*case 'user/-/state/com.google/tracking-kept-unread':
				break;
			case 'user/-/state/com.google/like':
				break;
			case 'user/-/state/com.google/broadcast':
				break;*/
		}
		switch ($r) {
			case 'user/-/state/com.google/read':
				$entryDAO->markRead($e_id, false);
				break;
			case 'user/-/state/com.google/starred':
				$entryDAO->markFavorite($e_id, false);
				break;
		}
	}

	echo 'OK';
	exit();
}

function markAllAsRead($streamId, $olderThanId) {
	logMe('markAllAsRead(' . $streamId . ")\n");
	$entryDAO = new FreshRSS_EntryDAO();
	if (strpos($streamId, 'feed/') === 0) {
		$f_id = basename($streamId);
		$entryDAO->markReadFeed($f_id, $olderThanId);
	} elseif (strpos($streamId, 'user/-/label/') === 0) {
		$c_name = basename($streamId);
		$entryDAO->markReadCatName($c_name, $olderThanId);
	} elseif ($streamId === 'user/-/state/com.google/reading-list') {
		$entryDAO->markReadEntries($olderThanId, false, -1);
	}

	echo 'OK';
	exit();
}

logMe('----------------------------------------------------------------'."\n");
logMe(print_r($debugInfo, true));

$pathInfo = empty($_SERVER['PATH_INFO']) ? '/Error' : urldecode($_SERVER['PATH_INFO']);
$pathInfos = explode('/', $pathInfo);

logMe('pathInfos => ' . print_r($pathInfos, true));

Minz_Configuration::init();

if (!Minz_Configuration::apiEnabled()) {
	serviceUnavailable();
}

Minz_Session::init('FreshRSS');

$user = authorizationToUser();
$conf = null;

logMe('User => ' . $user . "\n");

if ($user != null) {
	try {
		$conf = new FreshRSS_Configuration($user);
	} catch (Exception $e) {
		logMe($e->getMessage());
		$user = null;
		badRequest();
	}
}

Minz_Session::_param('currentUser', $user);

if (count($pathInfos) < 3) {
	badRequest();
}
elseif ($pathInfos[1] === 'accounts') {
	if (($pathInfos[2] === 'ClientLogin') && isset($_REQUEST['Email']) && isset($_REQUEST['Passwd']))
		clientLogin($_REQUEST['Email'], $_REQUEST['Passwd']);
}
elseif ($pathInfos[1] === 'reader' && $pathInfos[2] === 'api' && isset($pathInfos[3]) && $pathInfos[3] === '0' && isset($pathInfos[4])) {
	if ($user == null) {
		unauthorized();
	}
	$timestamp = isset($_GET['ck']) ? intval($_GET['ck']) : 0;	//ck=[unix timestamp] : Use the current Unix time here, helps Google with caching.
	switch ($pathInfos[4]) {
		case 'stream':
			$exclude_target = isset($_GET['xt']) ? $_GET['xt'] : '';	//xt=[exclude target] : Used to exclude certain items from the feed. For example, using xt=user/-/state/com.google/read will exclude items that the current user has marked as read, or xt=feed/[feedurl] will exclude items from a particular feed (obviously not useful in this request, but xt appears in other listing requests).
			$count = isset($_GET['n']) ? intval($_GET['n']) : 20;	//n=[integer] : The maximum number of results to return.
			$order = isset($_GET['r']) ? $_GET['r'] : 'd';	//r=[d|n|o] : Sort order of item results. d or n gives items in descending date order, o in ascending order.
			$start_time = isset($_GET['ot']) ? intval($_GET['ot']) : 0;	//ot=[unix timestamp] : The time from which you want to retrieve items. Only items that have been crawled by Google Reader after this time will be returned.
			if (isset($pathInfos[5]) && $pathInfos[5] === 'contents' && isset($pathInfos[6]) && isset($pathInfos[7])) {
				if ($pathInfos[6] === 'feed') {
					$include_target = $pathInfos[7];
					StreamContents($pathInfos[6], $include_target, $start_time, $count, $order, $exclude_target);
				} elseif ($pathInfos[6] === 'user' && isset($pathInfos[8]) && isset($pathInfos[9])) {
					if ($pathInfos[8] === 'state') {
						if ($pathInfos[9] === 'com.google' && isset($pathInfos[10])) {
							if ($pathInfos[10] === 'reading-list' || $pathInfos[10] === 'starred') {
								$include_target = '';
								streamContents($pathInfos[10], $include_target, $start_time, $count, $order, $exclude_target);
							}
						}
					} elseif ($pathInfos[8] === 'label') {
						$include_target = $pathInfos[9];
						streamContents($pathInfos[8], $include_target, $start_time, $count, $order, $exclude_target);
					}
				}
			} elseif ($pathInfos[5] === 'items') {
				if ($pathInfos[6] === 'ids' && isset($_GET['s'])) {
					$streamId = $_GET['s'];	//StreamId for which to fetch the item IDs. The parameter may be repeated to fetch the item IDs from multiple streams at once (more efficient from a backend perspective than multiple requests).
					streamContentsItemsIds($streamId, $start_time, $count, $order, $exclude_target);
				}
			}
			break;
		case 'tag':
			if (isset($pathInfos[5]) && $pathInfos[5] === 'list') {
				$output = isset($_GET['output']) ? $_GET['output'] : '';
				if ($output !== 'json') notImplemented();
				tagList($_GET['output']);
			}
			break;
		case 'subscription':
			if (isset($pathInfos[5]) && $pathInfos[5] === 'list') {
				$output = isset($_GET['output']) ? $_GET['output'] : '';
				if ($output !== 'json') notImplemented();
				subscriptionList($_GET['output']);
			}
			break;
		case 'unread-count':
			$output = isset($_GET['output']) ? $_GET['output'] : '';
			if ($output !== 'json') notImplemented();
			$all = isset($_GET['all']) ? $_GET['all'] : '';
			unreadCount($all);
			break;
		case 'edit-tag':	//http://blog.martindoms.com/2010/01/20/using-the-google-reader-api-part-3/
			$token = isset($_POST['T']) ? trim($_POST['T']) : '';
			checkToken($user, $token);
			$a = isset($_POST['a']) ? $_POST['a'] : '';	//Add:	user/-/state/com.google/read	user/-/state/com.google/starred
			$r = isset($_POST['r']) ? $_POST['r'] : '';	//Remove:	user/-/state/com.google/read	user/-/state/com.google/starred
			$e_ids = multiplePosts('i');	//item IDs
			editTag($e_ids, $a, $r);
			break;
		case 'mark-all-as-read':
			$token = isset($_POST['T']) ? trim($_POST['T']) : '';
			checkToken($user, $token);
			$streamId = $_POST['s'];	//StreamId
			$ts = isset($_POST['ts']) ? $_POST['ts'] : '0';	//Older than timestamp in nanoseconds
			if (!ctype_digit($ts)) {
				$ts = '0';
			}
			markAllAsRead($streamId, $ts);
			break;
		case 'token':
			Token($user);
			break;
	}
} elseif ($pathInfos[1] === 'check' && $pathInfos[2] === 'compatibility') {
	checkCompatibility();
}

badRequest();

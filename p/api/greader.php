<?php
/**
== Description ==
Server-side API compatible with Google Reader API layer 2
	for the FreshRSS project https://freshrss.org

== Credits ==
* 2014-03: Released by Alexandre Alapetite https://alexandre.alapetite.fr
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

require(__DIR__ . '/../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

$ORIGINAL_INPUT = file_get_contents('php://input', false, null, 0, 1048576);

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
	$header = '';
	$upName = 'HTTP_' . strtoupper($headerName);
	if (isset($_SERVER[$upName])) {
		$header = $_SERVER[$upName];
	} elseif (isset($_SERVER['REDIRECT_' . $upName])) {
		$header = $_SERVER['REDIRECT_' . $upName];
	} elseif (function_exists('getallheaders')) {
		$ALL_HEADERS = getallheaders();
		if (isset($ALL_HEADERS[$headerName])) {
			$header = $ALL_HEADERS[$headerName];
		}
	}
	parse_str($header, $pairs);
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

function badRequest() {
	Minz_Log::warning('badRequest() ' . debugInfo(), API_LOG);
	header('HTTP/1.1 400 Bad Request');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Bad Request!');
}

function unauthorized() {
	Minz_Log::warning('unauthorized() ' . debugInfo(), API_LOG);
	header('HTTP/1.1 401 Unauthorized');
	header('Content-Type: text/plain; charset=UTF-8');
	header('Google-Bad-Token: true');
	die('Unauthorized!');
}

function notImplemented() {
	Minz_Log::warning('notImplemented() ' . debugInfo(), API_LOG);
	header('HTTP/1.1 501 Not Implemented');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Not Implemented!');
}

function serviceUnavailable() {
	Minz_Log::warning('serviceUnavailable() ' . debugInfo(), API_LOG);
	header('HTTP/1.1 503 Service Unavailable');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Service Unavailable!');
}

function checkCompatibility() {
	Minz_Log::warning('checkCompatibility() ' . debugInfo(), API_LOG);
	header('Content-Type: text/plain; charset=UTF-8');
	if (PHP_INT_SIZE < 8 && !function_exists('gmp_init')) {
		die('FAIL 64-bit or GMP extension!');
	}
	if ((!array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) &&	//Apache mod_rewrite trick should be fine
		(!array_key_exists('REDIRECT_HTTP_AUTHORIZATION', $_SERVER)) &&	//Apache mod_rewrite with FCGI
		(empty($_SERVER['SERVER_SOFTWARE']) || (stripos($_SERVER['SERVER_SOFTWARE'], 'nginx') === false)) &&	//nginx should be fine
		(empty($_SERVER['SERVER_SOFTWARE']) || (stripos($_SERVER['SERVER_SOFTWARE'], 'lighttpd') === false)) &&	//lighttpd should be fine
		((!function_exists('getallheaders')) || (stripos(php_sapi_name(), 'cgi') !== false))) {	//Main problem is Apache/CGI mode
		die('FAIL getallheaders! (probably)');
	}
	echo 'PASS';
	exit();
}

function authorizationToUser() {
	$headerAuth = headerVariable('Authorization', 'GoogleLogin_auth');	//Input is 'GoogleLogin auth', but PHP replaces spaces by '_'	http://php.net/language.variables.external
	if ($headerAuth != '') {
		$headerAuthX = explode('/', $headerAuth, 2);
		if (count($headerAuthX) === 2) {
			$user = $headerAuthX[0];
			if (FreshRSS_user_Controller::checkUsername($user)) {
				FreshRSS_Context::$user_conf = get_user_configuration($user);
				if (FreshRSS_Context::$user_conf == null) {
					Minz_Log::warning('Invalid API user ' . $user . ': configuration cannot be found.');
					unauthorized();
				}
				if ($headerAuthX[1] === sha1(FreshRSS_Context::$system_conf->salt . $user . FreshRSS_Context::$user_conf->apiPasswordHash)) {
					return $user;
				} else {
					Minz_Log::warning('Invalid API authorisation for user ' . $user . ': ' . $headerAuthX[1], API_LOG);
					Minz_Log::warning('Invalid API authorisation for user ' . $user . ': ' . $headerAuthX[1]);
					unauthorized();
				}
			} else {
				badRequest();
			}
		}
	}
	return '';
}

function clientLogin($email, $pass) {	//http://web.archive.org/web/20130604091042/http://undoc.in/clientLogin.html
	if (ctype_alnum($email)) {
		if (!function_exists('password_verify')) {
			include_once(LIB_PATH . '/password_compat.php');
		}

		FreshRSS_Context::$user_conf = get_user_configuration($email);
		if (FreshRSS_Context::$user_conf == null) {
			Minz_Log::warning('Invalid API user ' . $email . ': configuration cannot be found.');
			unauthorized();
		}

		if (FreshRSS_Context::$user_conf->apiPasswordHash != '' && password_verify($pass, FreshRSS_Context::$user_conf->apiPasswordHash)) {
			header('Content-Type: text/plain; charset=UTF-8');
			$auth = $email . '/' . sha1(FreshRSS_Context::$system_conf->salt . $email . FreshRSS_Context::$user_conf->apiPasswordHash);
			echo 'SID=', $auth, "\n",
				'Auth=', $auth, "\n";
			exit();
		} else {
			Minz_Log::warning('Password API mismatch for user ' . $email);
			unauthorized();
		}
	} else {
		badRequest();
	}
	die();
}

function token($conf) {
//http://blog.martindoms.com/2009/08/15/using-the-google-reader-api-part-1/
//https://github.com/ericmann/gReader-Library/blob/master/greader.class.php
	$user = Minz_Session::param('currentUser', '_');
	//Minz_Log::debug('token('. $user . ')', API_LOG);	//TODO: Implement real token that expires
	$token = str_pad(sha1(FreshRSS_Context::$system_conf->salt . $user . $conf->apiPasswordHash), 57, 'Z');	//Must have 57 characters
	echo $token, "\n";
	exit();
}

function checkToken($conf, $token) {
//http://code.google.com/p/google-reader-api/wiki/ActionToken
	$user = Minz_Session::param('currentUser', '_');
	if ($user !== '_' && $token == '') {
		return true;	//FeedMe	//TODO: Check security consequences
	}
	if ($token === str_pad(sha1(FreshRSS_Context::$system_conf->salt . $user . $conf->apiPasswordHash), 57, 'Z')) {
		return true;
	}
	Minz_Log::warning('Invalid POST token: ' . $token, API_LOG);
	unauthorized();
}

function userInfo() {	//https://github.com/theoldreader/api#user-info
	$user = Minz_Session::param('currentUser', '_');
	exit(json_encode(array(
			'userId' => $user,
			'userName' => $user,
			'userProfileId' => $user,
			'userEmail' => FreshRSS_Context::$user_conf->mail_login,
		)));
}

function tagList() {
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
	header('Content-Type: application/json; charset=UTF-8');

	$pdo = new MyPDO();
	$stm = $pdo->prepare('SELECT f.id, f.name, f.url, f.website, c.id as c_id, c.name as c_name FROM `%_feed` f
		INNER JOIN `%_category` c ON c.id = f.category AND f.priority >= :priority_normal');
	$stm->execute(array(':priority_normal' => FreshRSS_Feed::PRIORITY_NORMAL));
	$res = $stm->fetchAll(PDO::FETCH_ASSOC);

	$salt = FreshRSS_Context::$system_conf->salt;
	$faviconsUrl = Minz_Url::display('/f.php?', '', true);
	$faviconsUrl = str_replace('/api/greader.php/reader/api/0/subscription', '', $faviconsUrl);	//Security if base_url is not set properly
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
			'iconUrl' => $faviconsUrl . hash('crc32b', $salt . $line['url']),
		);
	}

	echo json_encode(array('subscriptions' => $subscriptions)), "\n";
	exit();
}

function subscriptionEdit($streamNames, $titles, $action, $add = '', $remove = '') {
	//https://github.com/mihaip/google-reader-api/blob/master/wiki/ApiSubscriptionEdit.wiki
	switch ($action) {
		case 'subscribe':
		case 'unsubscribe':
		case 'edit':
			break;
		default:
			badRequest();
	}
	$addCatId = 0;
	$categoryDAO = null;
	if ($add != '' || $remove != '') {
		$categoryDAO = new FreshRSS_CategoryDAO();
	}
	$c_name = '';
	if ($add != '' && strpos($add, 'user/') === 0) {	//user/-/label/Example ; user/username/label/Example
		if (strpos($add, 'user/-/label/') === 0) {
			$c_name = substr($add, 13);
		} else {
			$user = Minz_Session::param('currentUser', '_');
			$prefix = 'user/' . $user . '/label/';
			if (strpos($add, $prefix) === 0) {
				$c_name = substr($add, strlen($prefix));
			} else {
				$c_name = '';
			}
		}
		$cat = $categoryDAO->searchByName($c_name);
		$addCatId = $cat == null ? 0 : $cat->id();
	} else if ($remove != '' && strpos($remove, 'user/-/label/')) {
		$addCatId = 1;	//Default category
	}
	$feedDAO = FreshRSS_Factory::createFeedDao();
	if (!is_array($streamNames) || count($streamNames) < 1) {
		badRequest();
	}
	for ($i = count($streamNames) - 1; $i >= 0; $i--) {
		$streamName = $streamNames[$i];	//feed/http://example.net/sample.xml	;	feed/338
		if (strpos($streamName, 'feed/') === 0) {
			$streamName = substr($streamName, 5);
			$feedId = 0;
			if (ctype_digit($streamName)) {
				if ($action === 'subscribe') {
					continue;
				}
				$feedId = $streamName;
			} else {
				$feed = $feedDAO->searchByUrl($streamName);
				$feedId = $feed == null ? -1 : $feed->id();
			}
			$title = isset($titles[$i]) ? $titles[$i] : '';
			switch ($action) {
				case 'subscribe':
					if ($feedId <= 0) {
						$http_auth = '';	//TODO
						try {
							$feed = FreshRSS_feed_Controller::addFeed($streamName, $title, $addCatId, $c_name, $http_auth);
							continue;
						} catch (Exception $e) {
							Minz_Log::error('subscriptionEdit error subscribe: ' . $e->getMessage(), API_LOG);
						}
					}
					badRequest();
					break;
				case 'unsubscribe':
					if (!($feedId > 0 && FreshRSS_feed_Controller::deleteFeed($feedId))) {
						badRequest();
					}
					break;
				case 'edit':
					if ($feedId > 0) {
						if ($addCatId > 0 || $c_name != '') {
							FreshRSS_feed_Controller::moveFeed($feedId, $addCatId, $c_name);
						}
						if ($title != '') {
							FreshRSS_feed_Controller::renameFeed($feedId, $title);
						}
					} else {
						badRequest();
					}
					break;
			}
		}
	}
	exit('OK');
}

function quickadd($url) {
	try {
		$feed = FreshRSS_feed_Controller::addFeed($url);
		exit(json_encode(array(
				'numResults' => 1,
				'streamId' => $feed->id(),
			)));
	} catch (Exception $e) {
		Minz_Log::error('quickadd error: ' . $e->getMessage(), API_LOG);
		die(json_encode(array(
				'numResults' => 0,
				'error' => $e->getMessage(),
			)));
	}
}

function unreadCount() {	//http://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2/#unread-count
	header('Content-Type: application/json; charset=UTF-8');

	$totalUnreads = 0;
	$totalLastUpdate = 0;

	$categoryDAO = new FreshRSS_CategoryDAO();
	foreach ($categoryDAO->listCategories(true, true) as $cat) {
		$catLastUpdate = 0;
		foreach ($cat->feeds() as $feed) {
			$lastUpdate = $feed->lastUpdate();
			$unreadcounts[] = array(
				'id' => 'feed/' . $feed->id(),
				'count' => $feed->nbNotRead(),
				'newestItemTimestampUsec' => $lastUpdate . '000000',
			);
			if ($catLastUpdate < $lastUpdate) {
				$catLastUpdate = $lastUpdate;
			}
		}
		$unreadcounts[] = array(
			'id' => 'user/-/label/' . $cat->name(),
			'count' => $cat->nbNotRead(),
			'newestItemTimestampUsec' => $catLastUpdate . '000000',
		);
		$totalUnreads += $cat->nbNotRead();
		if ($totalLastUpdate < $catLastUpdate) {
			$totalLastUpdate = $catLastUpdate;
		}
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

function entriesToArray($entries) {
	$items = array();
	foreach ($entries as $entry) {
		$f_id = $entry->feed();
		if (isset($arrayFeedCategoryNames[$f_id])) {
			$c_name = $arrayFeedCategoryNames[$f_id]['c_name'];
			$f_name = $arrayFeedCategoryNames[$f_id]['name'];
		} else {
			$c_name = '_';
			$f_name = '_';
		}
		$item = array(
			'id' => /*'tag:google.com,2005:reader/item/' .*/ dec2hex($entry->id()),	//64-bit hexa http://code.google.com/p/google-reader-api/wiki/ItemId
			'crawlTimeMsec' => substr($entry->id(), 0, -3),
			'timestampUsec' => '' . $entry->id(),	//EasyRSS
			'published' => $entry->date(true),
			'title' => $entry->title(),
			'summary' => array('content' => $entry->content()),
			'alternate' => array(
				array('href' => htmlspecialchars_decode($entry->link(), ENT_QUOTES)),
			),
			'categories' => array(
				'user/-/state/com.google/reading-list',
				'user/-/label/' . $c_name,
			),
			'origin' => array(
				'streamId' => 'feed/' . $f_id,
				'title' => $f_name,	//EasyRSS
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
	return $items;
}

function streamContents($path, $include_target, $start_time, $count, $order, $exclude_target, $continuation) {
//http://code.google.com/p/pyrfeed/wiki/GoogleReaderAPI
//http://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2/#feed
	header('Content-Type: application/json; charset=UTF-8');

	$feedDAO = FreshRSS_Factory::createFeedDao();
	$arrayFeedCategoryNames = $feedDAO->arrayFeedCategoryNames();

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
			$state = FreshRSS_Entry::STATE_NOT_READ;
			break;
		case 'user/-/state/com.google/unread':
			$state = FreshRSS_Entry::STATE_READ;
			break;
		default:
			$state = FreshRSS_Entry::STATE_ALL;
			break;
	}

	if ($continuation != '') {
		$count++;	//Shift by one element
	}

	$entryDAO = FreshRSS_Factory::createEntryDao();
	$entries = $entryDAO->listWhere($type, $include_target, $state, $order === 'o' ? 'ASC' : 'DESC', $count, $continuation, new FreshRSS_Search(''), $start_time);

	$items = entriesToArray($entries);

	if ($continuation != '') {
		array_shift($items);	//Discard first element that was already sent in the previous response
		$count--;
	}

	$response = array(
		'id' => 'user/-/state/com.google/reading-list',
		'updated' => time(),
		'items' => $items,
	);
	if (count($entries) >= $count) {
		$entry = end($entries);
		if ($entry != false) {
			$response['continuation'] = $entry->id();
		}
	}

	echo json_encode($response), "\n";
	exit();
}

function streamContentsItemsIds($streamId, $start_time, $count, $order, $exclude_target, $continuation) {
//http://code.google.com/p/google-reader-api/wiki/ApiStreamItemsIds
//http://code.google.com/p/pyrfeed/wiki/GoogleReaderAPI
//http://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2/#feed
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
		$c_name = substr($streamId, 13);
		$categoryDAO = new FreshRSS_CategoryDAO();
		$cat = $categoryDAO->searchByName($c_name);
		$id = $cat == null ? -1 : $cat->id();
	}

	switch ($exclude_target) {
		case 'user/-/state/com.google/read':
			$state = FreshRSS_Entry::STATE_NOT_READ;
			break;
		default:
			$state = FreshRSS_Entry::STATE_ALL;
			break;
	}

	if ($continuation != '') {
		$count++;	//Shift by one element
	}

	$entryDAO = FreshRSS_Factory::createEntryDao();
	$ids = $entryDAO->listIdsWhere($type, $id, $state, $order === 'o' ? 'ASC' : 'DESC', $count, $continuation, new FreshRSS_Search(''), $start_time);

	if ($continuation != '') {
		array_shift($ids);	//Discard first element that was already sent in the previous response
		$count--;
	}

	if (empty($ids)) {	//For News+ bug https://github.com/noinnion/newsplus/issues/84#issuecomment-57834632
		$ids[] = 0;
	}
	$itemRefs = array();
	foreach ($ids as $id) {
		$itemRefs[] = array(
			'id' => $id,	//64-bit decimal
		);
	}

	$response = array(
		'itemRefs' => $itemRefs,
	);
	if (count($ids) >= $count) {
		$id = end($ids);
		if ($id != false) {
			$response['continuation'] = $id;
		}
	}

	echo json_encode($response), "\n";
	exit();
}

function streamContentsItems($e_ids, $order) {
	header('Content-Type: application/json; charset=UTF-8');

	foreach ($e_ids as $i => $e_id) {
		$e_ids[$i] = hex2dec(basename($e_id));	//Strip prefix 'tag:google.com,2005:reader/item/'
	}

	$entryDAO = FreshRSS_Factory::createEntryDao();
	$entries = $entryDAO->listByIds($e_ids, $order === 'o' ? 'ASC' : 'DESC');

	$items = entriesToArray($entries);

	$response = array(
		'id' => 'user/-/state/com.google/reading-list',
		'updated' => time(),
		'items' => $items,
	);

	echo json_encode($response), "\n";
	exit();
}

function editTag($e_ids, $a, $r) {
	foreach ($e_ids as $i => $e_id) {
		$e_ids[$i] = hex2dec(basename($e_id));	//Strip prefix 'tag:google.com,2005:reader/item/'
	}

	$entryDAO = FreshRSS_Factory::createEntryDao();

	switch ($a) {
		case 'user/-/state/com.google/read':
			$entryDAO->markRead($e_ids, true);
			break;
		case 'user/-/state/com.google/starred':
			$entryDAO->markFavorite($e_ids, true);
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
			$entryDAO->markRead($e_ids, false);
			break;
		case 'user/-/state/com.google/starred':
			$entryDAO->markFavorite($e_ids, false);
			break;
	}

	exit('OK');
}

function renameTag($s, $dest) {
	if ($s != '' && strpos($s, 'user/-/label/') === 0 &&
		$dest != '' &&  strpos($dest, 'user/-/label/') === 0) {
		$s = substr($s, 13);
		$categoryDAO = new FreshRSS_CategoryDAO();
		$cat = $categoryDAO->searchByName($s);
		if ($cat != null) {
			$dest = substr($dest, 13);
			$categoryDAO->updateCategory($cat->id(), array('name' => $dest));
			exit('OK');
		}
	}
	badRequest();
}

function disableTag($s) {
	if ($s != '' && strpos($s, 'user/-/label/') === 0) {
		$s = substr($s, 13);
		$categoryDAO = new FreshRSS_CategoryDAO();
		$cat = $categoryDAO->searchByName($s);
		if ($cat != null) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$feedDAO->changeCategory($cat->id(), 0);
			if ($cat->id() > 1) {
				$categoryDAO->deleteCategory($cat->id());
			}
			exit('OK');
		}
	}
	badRequest();
}

function markAllAsRead($streamId, $olderThanId) {
	$entryDAO = FreshRSS_Factory::createEntryDao();
	if (strpos($streamId, 'feed/') === 0) {
		$f_id = basename($streamId);
		$entryDAO->markReadFeed($f_id, $olderThanId);
	} elseif (strpos($streamId, 'user/-/label/') === 0) {
		$c_name = substr($streamId, 13);
		$categoryDAO = new FreshRSS_CategoryDAO();
		$cat = $categoryDAO->searchByName($c_name);
		$entryDAO->markReadCat($cat === null ? -1 : $cat->id(), $olderThanId);
	} elseif ($streamId === 'user/-/state/com.google/reading-list') {
		$entryDAO->markReadEntries($olderThanId, false, -1);
	}

	exit('OK');
}

//Minz_Log::debug('----------------------------------------------------------------', API_LOG);
//Minz_Log::debug(debugInfo(), API_LOG);

$pathInfo = empty($_SERVER['PATH_INFO']) ? '/Error' : urldecode($_SERVER['PATH_INFO']);
$pathInfos = explode('/', $pathInfo);

Minz_Configuration::register('system',
	DATA_PATH . '/config.php',
	FRESHRSS_PATH . '/config.default.php');
FreshRSS_Context::$system_conf = Minz_Configuration::get('system');
if (!FreshRSS_Context::$system_conf->api_enabled) {
	serviceUnavailable();
}

Minz_Session::init('FreshRSS');

$user = authorizationToUser();
FreshRSS_Context::$user_conf = null;
if ($user !== '') {
	FreshRSS_Context::$user_conf = get_user_configuration($user);
}

Minz_Session::_param('currentUser', $user);

if (count($pathInfos) < 3) {
	badRequest();
} elseif ($pathInfos[1] === 'accounts') {
	if (($pathInfos[2] === 'ClientLogin') && isset($_REQUEST['Email']) && isset($_REQUEST['Passwd'])) {
		clientLogin($_REQUEST['Email'], $_REQUEST['Passwd']);
	}
} elseif ($pathInfos[1] === 'reader' && $pathInfos[2] === 'api' && isset($pathInfos[3]) && $pathInfos[3] === '0' && isset($pathInfos[4])) {
	if ($user == '') {
		unauthorized();
	}
	$timestamp = isset($_GET['ck']) ? intval($_GET['ck']) : 0;	//ck=[unix timestamp] : Use the current Unix time here, helps Google with caching.
	switch ($pathInfos[4]) {
		case 'stream':
			/* xt=[exclude target] : Used to exclude certain items from the feed.
			 * For example, using xt=user/-/state/com.google/read will exclude items
			 * that the current user has marked as read, or xt=feed/[feedurl] will
			 * exclude items from a particular feed (obviously not useful in this
			 * request, but xt appears in other listing requests). */
			$exclude_target = isset($_GET['xt']) ? $_GET['xt'] : '';
			$count = isset($_GET['n']) ? intval($_GET['n']) : 20;	//n=[integer] : The maximum number of results to return.
			$order = isset($_GET['r']) ? $_GET['r'] : 'd';	//r=[d|n|o] : Sort order of item results. d or n gives items in descending date order, o in ascending order.
			/* ot=[unix timestamp] : The time from which you want to retrieve
			 * items. Only items that have been crawled by Google Reader after
			 * this time will be returned. */
			$start_time = isset($_GET['ot']) ? intval($_GET['ot']) : 0;
			/* Continuation token. If a StreamContents response does not represent
			 * all items in a timestamp range, it will have a continuation attribute.
			 * The same request can be re-issued with the value of that attribute put
			 * in this parameter to get more items */
			$continuation = isset($_GET['c']) ? trim($_GET['c']) : '';
			if (!ctype_digit($continuation)) {
				$continuation = '';
			}
			if (isset($pathInfos[5]) && $pathInfos[5] === 'contents' && isset($pathInfos[6])) {
				if (isset($pathInfos[7])) {
					if ($pathInfos[6] === 'feed') {
						$include_target = $pathInfos[7];
						StreamContents($pathInfos[6], $include_target, $start_time, $count, $order, $exclude_target, $continuation);
					} elseif ($pathInfos[6] === 'user' && isset($pathInfos[8]) && isset($pathInfos[9])) {
						if ($pathInfos[8] === 'state') {
							if ($pathInfos[9] === 'com.google' && isset($pathInfos[10])) {
								if ($pathInfos[10] === 'reading-list' || $pathInfos[10] === 'starred') {
									$include_target = '';
									streamContents($pathInfos[10], $include_target, $start_time, $count, $order, $exclude_target, $continuation);
								}
							}
						} elseif ($pathInfos[8] === 'label') {
							$include_target = $pathInfos[9];
							streamContents($pathInfos[8], $include_target, $start_time, $count, $order, $exclude_target, $continuation);
						}
					}
				} else {	//EasyRSS
					$include_target = '';
					streamContents('reading-list', $include_target, $start_time, $count, $order, $exclude_target, $continuation);
				}
			} elseif ($pathInfos[5] === 'items') {
				if ($pathInfos[6] === 'ids' && isset($_GET['s'])) {
					/* StreamId for which to fetch the item IDs. The parameter may
					 * be repeated to fetch the item IDs from multiple streams at once
					 * (more efficient from a backend perspective than multiple requests). */
					$streamId = $_GET['s'];
					streamContentsItemsIds($streamId, $start_time, $count, $order, $exclude_target, $continuation);
				} else if ($pathInfos[6] === 'contents' && isset($_POST['i'])) {	//FeedMe
					$e_ids = multiplePosts('i');	//item IDs
					streamContentsItems($e_ids, $order);
				}
			}
			break;
		case 'tag':
			if (isset($pathInfos[5]) && $pathInfos[5] === 'list') {
				$output = isset($_GET['output']) ? $_GET['output'] : '';
				if ($output !== 'json') notImplemented();
				tagList($output);
			}
			break;
		case 'subscription':
			if (isset($pathInfos[5])) {
				switch ($pathInfos[5]) {
					case 'list':
						$output = isset($_GET['output']) ? $_GET['output'] : '';
						if ($output !== 'json') notImplemented();
						subscriptionList($_GET['output']);
						break;
					case 'edit':
						if (isset($_REQUEST['s']) && isset($_REQUEST['ac'])) {
							//StreamId to operate on. The parameter may be repeated to edit multiple subscriptions at once
							$streamNames = empty($_POST['s']) && isset($_GET['s']) ? array($_GET['s']) : multiplePosts('s');
							/* Title to use for the subscription. For the `subscribe` action,
							 * if not specified then the feed's current title will be used. Can
							 * be used with the `edit` action to rename a subscription */
							$titles = empty($_POST['t']) && isset($_GET['t']) ? array($_GET['t']) : multiplePosts('t');
							$action = $_REQUEST['ac'];	//Action to perform on the given StreamId. Possible values are `subscribe`, `unsubscribe` and `edit`
							$add = isset($_REQUEST['a']) ? $_REQUEST['a'] : '';	//StreamId to add the subscription to (generally a user label)
							$remove = isset($_REQUEST['r']) ? $_REQUEST['r'] : '';	//StreamId to remove the subscription from (generally a user label)
							subscriptionEdit($streamNames, $titles, $action, $add, $remove);
						}
						break;
					case 'quickadd':	//https://github.com/theoldreader/api
						if (isset($_GET['quickadd'])) {
							quickadd($_GET['quickadd']);
						}
						break;
				}
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
			checkToken(FreshRSS_Context::$user_conf, $token);
			$a = isset($_POST['a']) ? $_POST['a'] : '';	//Add:	user/-/state/com.google/read	user/-/state/com.google/starred
			$r = isset($_POST['r']) ? $_POST['r'] : '';	//Remove:	user/-/state/com.google/read	user/-/state/com.google/starred
			$e_ids = multiplePosts('i');	//item IDs
			editTag($e_ids, $a, $r);
			break;
		case 'rename-tag':	//https://github.com/theoldreader/api
			$token = isset($_POST['T']) ? trim($_POST['T']) : '';
			checkToken(FreshRSS_Context::$user_conf, $token);
			$s = isset($_POST['s']) ? $_POST['s'] : '';	//user/-/label/Folder
			$dest = isset($_POST['dest']) ? $_POST['dest'] : '';	//user/-/label/NewFolder
			renameTag($s, $dest);
			break;
		case 'disable-tag':	//https://github.com/theoldreader/api
			$token = isset($_POST['T']) ? trim($_POST['T']) : '';
			checkToken(FreshRSS_Context::$user_conf, $token);
			$s_s = multiplePosts('s');
			foreach ($s_s as $s) {
				disableTag($s);	//user/-/label/Folder
			}
			break;
		case 'mark-all-as-read':
			$token = isset($_POST['T']) ? trim($_POST['T']) : '';
			checkToken(FreshRSS_Context::$user_conf, $token);
			$streamId = $_POST['s'];	//StreamId
			$ts = isset($_POST['ts']) ? $_POST['ts'] : '0';	//Older than timestamp in nanoseconds
			if (!ctype_digit($ts)) {
				$ts = '0';
			}
			markAllAsRead($streamId, $ts);
			break;
		case 'token':
			token(FreshRSS_Context::$user_conf);
			break;
		case 'user-info':
			userInfo();
			break;
	}
} elseif ($pathInfos[1] === 'check' && $pathInfos[2] === 'compatibility') {
	checkCompatibility();
}

badRequest();

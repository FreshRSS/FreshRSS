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
* https://www.inoreader.com/developers/
* https://feedhq.readthedocs.io/en/latest/api/index.html
* https://github.com/bazqux/bazqux-api
*/

require(__DIR__ . '/../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
require_once(LIB_PATH . '/lib_greader.php');

$ORIGINAL_INPUT = file_get_contents('php://input', false, null, 0, 1048576);

define('JSON_OPTIONS', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

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
		die('FAIL 64-bit or GMP extension! Wrong PHP configuration.');
	}
	$headerAuth = headerVariable('Authorization', 'GoogleLogin_auth');
	if ($headerAuth == '') {
		die('FAIL get HTTP Authorization header! Wrong Web server configuration.');
	}
	echo 'PASS';
	exit();
}

function authorizationToUser() {
	//Input is 'GoogleLogin auth', but PHP replaces spaces by '_'	http://php.net/language.variables.external
	$headerAuth = headerVariable('Authorization', 'GoogleLogin_auth');
	if ($headerAuth != '') {
		$headerAuthX = explode('/', $headerAuth, 2);
		if (count($headerAuthX) === 2) {
			$user = $headerAuthX[0];
			if (FreshRSS_user_Controller::checkUsername($user)) {
				FreshRSS_Context::initUser($user);
				if (FreshRSS_Context::$user_conf == null) {
					Minz_Log::warning('Invalid API user ' . $user . ': configuration cannot be found.');
					unauthorized();
				}
				if (!FreshRSS_Context::$user_conf->enabled) {
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
	if (FreshRSS_user_Controller::checkUsername($email)) {
		FreshRSS_Context::initUser($email);
		if (FreshRSS_Context::$user_conf == null) {
			Minz_Log::warning('Invalid API user ' . $email . ': configuration cannot be found.');
			unauthorized();
		}

		if (FreshRSS_Context::$user_conf->apiPasswordHash != '' && password_verify($pass, FreshRSS_Context::$user_conf->apiPasswordHash)) {
			header('Content-Type: text/plain; charset=UTF-8');
			$auth = $email . '/' . sha1(FreshRSS_Context::$system_conf->salt . $email . FreshRSS_Context::$user_conf->apiPasswordHash);
			echo 'SID=', $auth, "\n",
				'LSID=null', "\n",	//Vienna RSS
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
	if ($user !== '_' && (	//TODO: Check security consequences
		$token == '' || //FeedMe
		$token === 'x')) { //Reeder
		return true;
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
		), JSON_OPTIONS));
}

function tagList() {
	header('Content-Type: application/json; charset=UTF-8');

	$tags = array(
		array('id' => 'user/-/state/com.google/starred'),
		//array('id' => 'user/-/state/com.google/broadcast', 'sortid' => '2'),
	);

	$categoryDAO = FreshRSS_Factory::createCategoryDao();
	$categories = $categoryDAO->listCategories(true, false);
	foreach ($categories as $cat) {
		$tags[] = array(
			'id' => 'user/-/label/' . htmlspecialchars_decode($cat->name(), ENT_QUOTES),
			//'sortid' => $cat->name(),
			'type' => 'folder',	//Inoreader
		);
	}

	$tagDAO = FreshRSS_Factory::createTagDao();
	$labels = $tagDAO->listTags(true);
	foreach ($labels as $label) {
		$tags[] = array(
			'id' => 'user/-/label/' . htmlspecialchars_decode($label->name(), ENT_QUOTES),
			//'sortid' => $label->name(),
			'type' => 'tag',	//Inoreader
			'unread_count' => $label->nbUnread(),	//Inoreader
		);
	}

	echo json_encode(array('tags' => $tags), JSON_OPTIONS), "\n";
	exit();
}

function subscriptionExport() {
	$user = Minz_Session::param('currentUser', '_');
	$export_service = new FreshRSS_Export_Service($user);
	list($filename, $content) = $export_service->generateOpml();
	header('Content-Type: application/xml; charset=UTF-8');
	header('Content-disposition: attachment; filename="' . $filename . '"');
	echo $content;
	exit();
}

function subscriptionImport($opml) {
	$user = Minz_Session::param('currentUser', '_');
	$importService = new FreshRSS_Import_Service($user);
	$ok = $importService->importOpml($opml);
	if ($ok) {
		list($nbUpdatedFeeds, $feed, $nbNewArticles) = FreshRSS_feed_Controller::actualizeFeed(0, '', true);
		invalidateHttpCache($user);
		exit('OK');
	} else {
		badRequest();
	}
}

function subscriptionList() {
	header('Content-Type: application/json; charset=UTF-8');

	$salt = FreshRSS_Context::$system_conf->salt;
	$faviconsUrl = Minz_Url::display('/f.php?', '', true);
	$faviconsUrl = str_replace('/api/greader.php/reader/api/0/subscription', '', $faviconsUrl);	//Security if base_url is not set properly
	$subscriptions = array();

	$categoryDAO = FreshRSS_Factory::createCategoryDao();
	foreach ($categoryDAO->listCategories(true, true) as $cat) {
		foreach ($cat->feeds() as $feed) {
			$subscriptions[] = [
				'id' => 'feed/' . $feed->id(),
				'title' => escapeToUnicodeAlternative($feed->name(), true),
				'categories' => [
					[
						'id' => 'user/-/label/' . htmlspecialchars_decode($cat->name(), ENT_QUOTES),
						'label' => htmlspecialchars_decode($cat->name(), ENT_QUOTES),
					],
				],
				//'sortid' => $feed->name(),
				//'firstitemmsec' => 0,
				'url' => htmlspecialchars_decode($feed->url(), ENT_QUOTES),
				'htmlUrl' => htmlspecialchars_decode($feed->website(), ENT_QUOTES),
				'iconUrl' => $faviconsUrl . hash('crc32b', $salt . $feed->url()),
			];
		}
	}

	echo json_encode(array('subscriptions' => $subscriptions), JSON_OPTIONS), "\n";
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
		$categoryDAO = FreshRSS_Factory::createCategoryDao();
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
		$c_name = htmlspecialchars($c_name, ENT_COMPAT, 'UTF-8');
		$cat = $categoryDAO->searchByName($c_name);
		$addCatId = $cat == null ? 0 : $cat->id();
	} elseif ($remove != '' && strpos($remove, 'user/-/label/') === 0) {
		$addCatId = 1;	//Default category
	}
	$feedDAO = FreshRSS_Factory::createFeedDao();
	if (!is_array($streamNames) || count($streamNames) < 1) {
		badRequest();
	}
	for ($i = count($streamNames) - 1; $i >= 0; $i--) {
		$streamUrl = $streamNames[$i];	//feed/http://example.net/sample.xml	;	feed/338
		if (strpos($streamUrl, 'feed/') === 0) {
			$streamUrl = preg_replace('%^(feed/)+%', '', $streamUrl);
			$feedId = 0;
			if (ctype_digit($streamUrl)) {
				if ($action === 'subscribe') {
					continue;
				}
				$feedId = $streamUrl;
			} else {
				$streamUrl = htmlspecialchars($streamUrl, ENT_COMPAT, 'UTF-8');
				$feed = $feedDAO->searchByUrl($streamUrl);
				$feedId = $feed == null ? -1 : $feed->id();
			}
			$title = isset($titles[$i]) ? $titles[$i] : '';
			$title = htmlspecialchars($title, ENT_COMPAT, 'UTF-8');
			switch ($action) {
				case 'subscribe':
					if ($feedId <= 0) {
						$http_auth = '';
						try {
							$feed = FreshRSS_feed_Controller::addFeed($streamUrl, $title, $addCatId, $c_name, $http_auth);
							continue 2;
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
		$url = htmlspecialchars($url, ENT_COMPAT, 'UTF-8');
		if (substr($url, 0, 5) === 'feed/') {
			$url = substr($url, 5);
		}
		$feed = FreshRSS_feed_Controller::addFeed($url);
		exit(json_encode(array(
				'numResults' => 1,
				'query' => $feed->url(),
				'streamId' => 'feed/' . $feed->id(),
				'streamName' => $feed->name(),
			), JSON_OPTIONS));
	} catch (Exception $e) {
		Minz_Log::error('quickadd error: ' . $e->getMessage(), API_LOG);
		die(json_encode(array(
				'numResults' => 0,
				'error' => $e->getMessage(),
			), JSON_OPTIONS));
	}
}

function unreadCount() {	//http://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2/#unread-count
	header('Content-Type: application/json; charset=UTF-8');

	$totalUnreads = 0;
	$totalLastUpdate = 0;

	$categoryDAO = FreshRSS_Factory::createCategoryDao();
	$feedDAO = FreshRSS_Factory::createFeedDao();
	$feedsNewestItemUsec = $feedDAO->listFeedsNewestItemUsec();

	foreach ($categoryDAO->listCategories(true, true) as $cat) {
		$catLastUpdate = 0;
		foreach ($cat->feeds() as $feed) {
			$lastUpdate = isset($feedsNewestItemUsec['f_' . $feed->id()]) ? $feedsNewestItemUsec['f_' . $feed->id()] : 0;
			$unreadcounts[] = array(
				'id' => 'feed/' . $feed->id(),
				'count' => $feed->nbNotRead(),
				'newestItemTimestampUsec' => '' . $lastUpdate,
			);
			if ($catLastUpdate < $lastUpdate) {
				$catLastUpdate = $lastUpdate;
			}
		}
		$unreadcounts[] = array(
			'id' => 'user/-/label/' . htmlspecialchars_decode($cat->name(), ENT_QUOTES),
			'count' => $cat->nbNotRead(),
			'newestItemTimestampUsec' => '' . $catLastUpdate,
		);
		$totalUnreads += $cat->nbNotRead();
		if ($totalLastUpdate < $catLastUpdate) {
			$totalLastUpdate = $catLastUpdate;
		}
	}

	$tagDAO = FreshRSS_Factory::createTagDao();
	$tagsNewestItemUsec = $tagDAO->listTagsNewestItemUsec();
	foreach ($tagDAO->listTags(true) as $label) {
		$lastUpdate = isset($tagsNewestItemUsec['t_' . $label->id()]) ? $tagsNewestItemUsec['t_' . $label->id()] : 0;
		$unreadcounts[] = array(
			'id' => 'user/-/label/' . htmlspecialchars_decode($label->name(), ENT_QUOTES),
			'count' => $label->nbUnread(),
			'newestItemTimestampUsec' => '' . $lastUpdate,
		);
	}

	$unreadcounts[] = array(
		'id' => 'user/-/state/com.google/reading-list',
		'count' => $totalUnreads,
		'newestItemTimestampUsec' => '' . $totalLastUpdate,
	);

	echo json_encode(array(
		'max' => $totalUnreads,
		'unreadcounts' => $unreadcounts,
	), JSON_OPTIONS), "\n";
	exit();
}

function entriesToGReaderItems($entries) {

	function entryFilter($entries) {
		foreach ($entries as $entry) {
			$entry = Minz_ExtensionManager::callHook('entry_before_display', $entry);
			if ($entry != null) {
				yield $entry;
			}
		}
	}

	$export_service = new FreshRSS_Export_Service($username);
	return $export_service->entriesToGReaderItems(entryFilter($entries), false);
}

function streamContentsFilters($type, $streamId, $filter_target, $exclude_target, $start_time, $stop_time) {
	switch ($type) {
		case 'f':	//feed
			if ($streamId != '' && !ctype_digit($streamId)) {
				$feedDAO = FreshRSS_Factory::createFeedDao();
				$streamId = htmlspecialchars($streamId, ENT_COMPAT, 'UTF-8');
				$feed = $feedDAO->searchByUrl($streamId);
				$streamId = $feed == null ? -1 : $feed->id();
			}
			break;
		case 'c':	//category or label
			$categoryDAO = FreshRSS_Factory::createCategoryDao();
			$streamId = htmlspecialchars($streamId, ENT_COMPAT, 'UTF-8');
			$cat = $categoryDAO->searchByName($streamId);
			if ($cat != null) {
				$type = 'c';
				$streamId = $cat->id();
			} else {
				$tagDAO = FreshRSS_Factory::createTagDao();
				$tag = $tagDAO->searchByName($streamId);
				if ($tag != null) {
					$type = 't';
					$streamId = $tag->id();
				} else {
					$type = 'A';
					$streamId = -1;
				}
			}
			break;
	}

	switch ($filter_target) {
		case 'user/-/state/com.google/read':
			$state = FreshRSS_Entry::STATE_READ;
			break;
		case 'user/-/state/com.google/unread':
			$state = FreshRSS_Entry::STATE_NOT_READ;
			break;
		case 'user/-/state/com.google/starred':
			$state = FreshRSS_Entry::STATE_FAVORITE;
			break;
		default:
			$state = FreshRSS_Entry::STATE_ALL;
			break;
	}

	switch ($exclude_target) {
		case 'user/-/state/com.google/read':
			$state &= FreshRSS_Entry::STATE_NOT_READ;
			break;
		case 'user/-/state/com.google/unread':
			$state &= FreshRSS_Entry::STATE_READ;
			break;
		case 'user/-/state/com.google/starred':
			$state &= FreshRSS_Entry::STATE_NOT_FAVORITE;
			break;
	}

	$searches = new FreshRSS_BooleanSearch('');
	if ($start_time != '') {
		$search = new FreshRSS_Search('');
		$search->setMinDate($start_time);
		$searches->add($search);
	}
	if ($stop_time != '') {
		$search = new FreshRSS_Search('');
		$search->setMaxDate($stop_time);
		$searches->add($search);
	}

	return array($type, $streamId, $state, $searches);
}

function streamContents($path, $include_target, $start_time, $stop_time, $count, $order, $filter_target, $exclude_target, $continuation) {
//http://code.google.com/p/pyrfeed/wiki/GoogleReaderAPI
//http://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2/#feed
	header('Content-Type: application/json; charset=UTF-8');

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
			break;
		default:
			$type = 'A';
			break;
	}

	list($type, $include_target, $state, $searches) = streamContentsFilters($type, $include_target, $filter_target, $exclude_target, $start_time, $stop_time);

	if ($continuation != '') {
		$count++;	//Shift by one element
	}

	$entryDAO = FreshRSS_Factory::createEntryDao();
	$entries = $entryDAO->listWhere($type, $include_target, $state, $order === 'o' ? 'ASC' : 'DESC', $count, $continuation, $searches);

	$items = entriesToGReaderItems($entries);
	$items = iterator_to_array($items);	//TODO: Improve

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
			$response['continuation'] = '' . $entry->id();
		}
	}

	echo json_encode($response, JSON_OPTIONS), "\n";
	exit();
}

function streamContentsItemsIds($streamId, $start_time, $stop_time, $count, $order, $filter_target, $exclude_target, $continuation) {
//http://code.google.com/p/google-reader-api/wiki/ApiStreamItemsIds
//http://code.google.com/p/pyrfeed/wiki/GoogleReaderAPI
//http://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2/#feed
	$type = 'A';
	$id = '';
	if ($streamId === 'user/-/state/com.google/reading-list') {
		$type = 'A';
	} elseif ($streamId === 'user/-/state/com.google/starred') {
		$type = 's';
	} elseif (strpos($streamId, 'feed/') === 0) {
		$type = 'f';
		$streamId = substr($streamId, 5);
	} elseif (strpos($streamId, 'user/-/label/') === 0) {
		$type = 'c';
		$streamId = substr($streamId, 13);
	}

	list($type, $id, $state, $searches) = streamContentsFilters($type, $streamId, $filter_target, $exclude_target, $start_time, $stop_time);

	if ($continuation != '') {
		$count++;	//Shift by one element
	}

	$entryDAO = FreshRSS_Factory::createEntryDao();
	$ids = $entryDAO->listIdsWhere($type, $id, $state, $order === 'o' ? 'ASC' : 'DESC', $count, $continuation, $searches);

	if ($continuation != '') {
		array_shift($ids);	//Discard first element that was already sent in the previous response
		$count--;
	}

	if (empty($ids) && isset($_GET['client']) && $_GET['client'] === 'newsplus') {
		$ids[] = 0;	//For News+ bug https://github.com/noinnion/newsplus/issues/84#issuecomment-57834632
	}
	$itemRefs = array();
	foreach ($ids as $id) {
		$itemRefs[] = array(
			'id' => '' . $id,	//64-bit decimal
		);
	}

	$response = array(
		'itemRefs' => $itemRefs,
	);
	if (count($ids) >= $count) {
		$id = end($ids);
		if ($id != false) {
			$response['continuation'] = '' . $id;
		}
	}

	echo json_encode($response, JSON_OPTIONS), "\n";
	exit();
}

function streamContentsItems($e_ids, $order) {
	header('Content-Type: application/json; charset=UTF-8');

	foreach ($e_ids as $i => $e_id) {
		// https://feedhq.readthedocs.io/en/latest/api/terminology.html#items
		if (!ctype_digit($e_id) || $e_id[0] === '0') {
			$e_ids[$i] = hex2dec(basename($e_id));	//Strip prefix 'tag:google.com,2005:reader/item/'
		}
	}

	$entryDAO = FreshRSS_Factory::createEntryDao();
	$entries = $entryDAO->listByIds($e_ids, $order === 'o' ? 'ASC' : 'DESC');

	$items = entriesToGReaderItems($entries);
	$items = iterator_to_array($entries);	//TODO: Improve

	$response = array(
		'id' => 'user/-/state/com.google/reading-list',
		'updated' => time(),
		'items' => $items,
	);

	echo json_encode($response, JSON_OPTIONS), "\n";
	exit();
}

function editTag($e_ids, $a, $r) {
	foreach ($e_ids as $i => $e_id) {
		if (!ctype_digit($e_id) || $e_id[0] === '0') {
			$e_ids[$i] = hex2dec(basename($e_id));	//Strip prefix 'tag:google.com,2005:reader/item/'
		}
	}

	$entryDAO = FreshRSS_Factory::createEntryDao();
	$tagDAO = FreshRSS_Factory::createTagDao();

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
		default:
			$tagName = '';
			if (strpos($a, 'user/-/label/') === 0) {
				$tagName = substr($a, 13);
			} else {
				$user = Minz_Session::param('currentUser', '_');
				$prefix = 'user/' . $user . '/label/';
				if (strpos($a, $prefix) === 0) {
					$tagName = substr($a, strlen($prefix));
				}
			}
			if ($tagName != '') {
				$tagName = htmlspecialchars($tagName, ENT_COMPAT, 'UTF-8');
				$tag = $tagDAO->searchByName($tagName);
				if ($tag == null) {
					$tagDAO->addTag(array('name' => $tagName));
					$tag = $tagDAO->searchByName($tagName);
				}
				if ($tag != null) {
					foreach ($e_ids as $e_id) {
						$tagDAO->tagEntry($tag->id(), $e_id, true);
					}
				}
			}
			break;
	}
	switch ($r) {
		case 'user/-/state/com.google/read':
			$entryDAO->markRead($e_ids, false);
			break;
		case 'user/-/state/com.google/starred':
			$entryDAO->markFavorite($e_ids, false);
			break;
		default:
			if (strpos($r, 'user/-/label/') === 0) {
				$tagName = substr($r, 13);
				$tagName = htmlspecialchars($tagName, ENT_COMPAT, 'UTF-8');
				$tag = $tagDAO->searchByName($tagName);
				if ($tag != null) {
					foreach ($e_ids as $e_id) {
						$tagDAO->tagEntry($tag->id(), $e_id, false);
					}
				}
			}
			break;
	}

	exit('OK');
}

function renameTag($s, $dest) {
	if ($s != '' && strpos($s, 'user/-/label/') === 0 &&
		$dest != '' && strpos($dest, 'user/-/label/') === 0) {
		$s = substr($s, 13);
		$s = htmlspecialchars($s, ENT_COMPAT, 'UTF-8');
		$dest = substr($dest, 13);
		$dest = htmlspecialchars($dest, ENT_COMPAT, 'UTF-8');

		$categoryDAO = FreshRSS_Factory::createCategoryDao();
		$cat = $categoryDAO->searchByName($s);
		if ($cat != null) {
			$categoryDAO->updateCategory($cat->id(), array('name' => $dest));
			exit('OK');
		} else {
			$tagDAO = FreshRSS_Factory::createTagDao();
			$tag = $tagDAO->searchByName($s);
			if ($tag != null) {
				$tagDAO->updateTag($tag->id(), array('name' => $dest));
				exit('OK');
			}
		}
	}
	badRequest();
}

function disableTag($s) {
	if ($s != '' && strpos($s, 'user/-/label/') === 0) {
		$s = substr($s, 13);
		$s = htmlspecialchars($s, ENT_COMPAT, 'UTF-8');
		$categoryDAO = FreshRSS_Factory::createCategoryDao();
		$cat = $categoryDAO->searchByName($s);
		if ($cat != null) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$feedDAO->changeCategory($cat->id(), 0);
			if ($cat->id() > 1) {
				$categoryDAO->deleteCategory($cat->id());
			}
			exit('OK');
		} else {
			$tagDAO = FreshRSS_Factory::createTagDao();
			$tag = $tagDAO->searchByName($s);
			if ($tag != null) {
				$tagDAO->deleteTag($tag->id());
				exit('OK');
			}
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
		$c_name = htmlspecialchars($c_name, ENT_COMPAT, 'UTF-8');
		$categoryDAO = FreshRSS_Factory::createCategoryDao();
		$cat = $categoryDAO->searchByName($c_name);
		if ($cat != null) {
			$entryDAO->markReadCat($cat->id(), $olderThanId);
		} else {
			$tagDAO = FreshRSS_Factory::createTagDao();
			$tag = $tagDAO->searchByName($c_name);
			if ($tag != null) {
				$entryDAO->markReadTag($tag->id(), $olderThanId);
			}
		}
	} elseif ($streamId === 'user/-/state/com.google/reading-list') {
		$entryDAO->markReadEntries($olderThanId, false, -1);
	}

	exit('OK');
}

$pathInfo = '';
if (empty($_SERVER['PATH_INFO'])) {
	if (!empty($_SERVER['ORIG_PATH_INFO'])) {
		// Compatibility https://php.net/reserved.variables.server
		$pathInfo = $_SERVER['ORIG_PATH_INFO'];
	}
} else {
	$pathInfo = $_SERVER['PATH_INFO'];
}
$pathInfo = urldecode($pathInfo);
$pathInfo = preg_replace('%^(/api)?(/greader\.php)?%', '', $pathInfo);	//Discard common errors
if ($pathInfo == '') {
	exit('OK');
}
$pathInfos = explode('/', $pathInfo);
if (count($pathInfos) < 3) {
	badRequest();
}

FreshRSS_Context::initSystem();

//Minz_Log::debug('----------------------------------------------------------------', API_LOG);
//Minz_Log::debug(debugInfo(), API_LOG);

if (!FreshRSS_Context::$system_conf->api_enabled) {
	serviceUnavailable();
} elseif ($pathInfos[1] === 'check' && $pathInfos[2] === 'compatibility') {
	checkCompatibility();
}

Minz_Session::init('FreshRSS', true);

if ($pathInfos[1] !== 'accounts') {
	authorizationToUser();
}
if (FreshRSS_Context::$user_conf != null) {
	Minz_Translate::init(FreshRSS_Context::$user_conf->language);
	Minz_ExtensionManager::init();
	Minz_ExtensionManager::enableByList(FreshRSS_Context::$user_conf->extensions_enabled);
} else {
	Minz_Translate::init();
}

if ($pathInfos[1] === 'accounts') {
	if (($pathInfos[2] === 'ClientLogin') && isset($_REQUEST['Email']) && isset($_REQUEST['Passwd'])) {
		clientLogin($_REQUEST['Email'], $_REQUEST['Passwd']);
	}
} elseif ($pathInfos[1] === 'reader' && $pathInfos[2] === 'api' && isset($pathInfos[3]) && $pathInfos[3] === '0' && isset($pathInfos[4])) {
	if (Minz_Session::param('currentUser', '') == '') {
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
			$filter_target = isset($_GET['it']) ? $_GET['it'] : '';
			//n=[integer] : The maximum number of results to return.
			$count = isset($_GET['n']) ? intval($_GET['n']) : 20;
			//r=[d|n|o] : Sort order of item results. d or n gives items in descending date order, o in ascending order.
			$order = isset($_GET['r']) ? $_GET['r'] : 'd';
			/* ot=[unix timestamp] : The time from which you want to retrieve
			 * items. Only items that have been crawled by Google Reader after
			 * this time will be returned. */
			$start_time = isset($_GET['ot']) ? intval($_GET['ot']) : 0;
			$stop_time = isset($_GET['nt']) ? intval($_GET['nt']) : 0;
			/* Continuation token. If a StreamContents response does not represent
			 * all items in a timestamp range, it will have a continuation attribute.
			 * The same request can be re-issued with the value of that attribute put
			 * in this parameter to get more items */
			$continuation = isset($_GET['c']) ? trim($_GET['c']) : '';
			if (!ctype_digit($continuation)) {
				$continuation = '';
			}
			if (isset($pathInfos[5]) && $pathInfos[5] === 'contents') {
				if (!isset($pathInfos[6]) && isset($_GET['s'])) {
					// Compatibility BazQux API https://github.com/bazqux/bazqux-api#fetching-streams
					$streamIdInfos = explode('/', $_GET['s']);
					foreach ($streamIdInfos as $streamIdInfo) {
						$pathInfos[] = $streamIdInfo;
					}
				}
				if (isset($pathInfos[6]) && isset($pathInfos[7])) {
					if ($pathInfos[6] === 'feed') {
						$include_target = $pathInfos[7];
						if ($include_target != '' && !ctype_digit($include_target)) {
							$include_target = empty($_SERVER['REQUEST_URI']) ? '' : $_SERVER['REQUEST_URI'];
							if (preg_match('#/reader/api/0/stream/contents/feed/([A-Za-z0-9\'!*()%$_.~+-]+)#', $include_target, $matches) && isset($matches[1])) {
								$include_target = urldecode($matches[1]);
							} else {
								$include_target = '';
							}
						}
						streamContents($pathInfos[6], $include_target, $start_time, $stop_time, $count, $order, $filter_target, $exclude_target, $continuation);
					} elseif ($pathInfos[6] === 'user' && isset($pathInfos[8]) && isset($pathInfos[9])) {
						if ($pathInfos[8] === 'state') {
							if ($pathInfos[9] === 'com.google' && isset($pathInfos[10])) {
								if ($pathInfos[10] === 'reading-list' || $pathInfos[10] === 'starred') {
									$include_target = '';
									streamContents($pathInfos[10], $include_target, $start_time, $stop_time, $count, $order,
										$filter_target, $exclude_target, $continuation);
								}
							}
						} elseif ($pathInfos[8] === 'label') {
							$include_target = $pathInfos[9];
							streamContents($pathInfos[8], $include_target, $start_time, $stop_time, $count, $order, $filter_target, $exclude_target, $continuation);
						}
					}
				} else {	//EasyRSS, FeedMe
					$include_target = '';
					streamContents('reading-list', $include_target, $start_time, $stop_time, $count, $order, $filter_target, $exclude_target, $continuation);
				}
			} elseif ($pathInfos[5] === 'items') {
				if ($pathInfos[6] === 'ids' && isset($_GET['s'])) {
					/* StreamId for which to fetch the item IDs. The parameter may
					 * be repeated to fetch the item IDs from multiple streams at once
					 * (more efficient from a backend perspective than multiple requests). */
					$streamId = $_GET['s'];
					streamContentsItemsIds($streamId, $start_time, $stop_time, $count, $order, $filter_target, $exclude_target, $continuation);
				} elseif ($pathInfos[6] === 'contents' && isset($_POST['i'])) {	//FeedMe
					$e_ids = multiplePosts('i');	//item IDs
					streamContentsItems($e_ids, $order);
				}
			}
			break;
		case 'tag':
			if (isset($pathInfos[5]) && $pathInfos[5] === 'list') {
				$output = isset($_GET['output']) ? $_GET['output'] : '';
				if ($output !== 'json') notImplemented();
				tagList();
			}
			break;
		case 'subscription':
			if (isset($pathInfos[5])) {
				switch ($pathInfos[5]) {
					case 'export':
						subscriptionExport();
						break;
					case 'import':
						if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && $ORIGINAL_INPUT != '') {
							subscriptionImport($ORIGINAL_INPUT);
						}
						break;
					case 'list':
						$output = isset($_GET['output']) ? $_GET['output'] : '';
						if ($output !== 'json') notImplemented();
						subscriptionList();
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
						if (isset($_REQUEST['quickadd'])) {
							quickadd($_REQUEST['quickadd']);
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
}

badRequest();

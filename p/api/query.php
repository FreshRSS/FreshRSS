<?php
declare(strict_types=1);
require(__DIR__ . '/../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

Minz_Request::init();

$token = Minz_Request::paramString('t');
if (!ctype_alnum($token)) {
	header('HTTP/1.1 422 Unprocessable Entity');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Invalid token `t`!' . $token);
}

$format = Minz_Request::paramString('f');
if (!in_array($format, ['atom', 'html', 'opml', 'rss'], true)) {
	header('HTTP/1.1 422 Unprocessable Entity');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Invalid format `f`!');
}

$user = Minz_Request::paramString('user');
if (!FreshRSS_user_Controller::checkUsername($user)) {
	header('HTTP/1.1 422 Unprocessable Entity');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Invalid user!');
}

Minz_Session::init('FreshRSS', true);

FreshRSS_Context::initSystem();
if (!FreshRSS_Context::hasSystemConf() || !FreshRSS_Context::systemConf()->api_enabled) {
	header('HTTP/1.1 503 Service Unavailable');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Service Unavailable!');
}

FreshRSS_Context::initUser($user);
if (!FreshRSS_Context::hasUserConf()) {
	usleep(rand(100, 10000));	//Primitive mitigation of scanning for users
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/plain; charset=UTF-8');
	die('User not found!');
} else {
	usleep(rand(20, 200));
}

Minz_Translate::init(FreshRSS_Context::userConf()->language);
Minz_ExtensionManager::init();
Minz_ExtensionManager::enableByList(FreshRSS_Context::userConf()->extensions_enabled, 'user');

$query = null;
foreach (FreshRSS_Context::userConf()->queries as $raw_query) {
	if (!empty($raw_query['token']) && $raw_query['token'] === $token) {
		$query = new FreshRSS_UserQuery($raw_query, FreshRSS_Context::categories(), FreshRSS_Context::labels());
		Minz_Request::_param('get', $query->getGet());
		Minz_Request::_param('order', $query->getOrder());
		Minz_Request::_param('state', $query->getState());

		$search = $query->getSearch()->getRawInput();
		// Note: we disallow references to user queries in public user search to avoid sniffing internal user queries
		$userSearch = new FreshRSS_BooleanSearch(Minz_Request::paramString('search'), 0, 'AND', false);
		if ($userSearch->getRawInput() !== '') {
			$search .= ' (' . $userSearch->getRawInput() . ')';
		}
		Minz_Request::_param('search', $search);
		break;
	}
}
if ($query === null) {
	usleep(rand(100, 10000));
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/plain; charset=UTF-8');
	die('User query not found!');
}

$view = new FreshRSS_View();

try {
	FreshRSS_Context::updateUsingRequest(false);
	$view->entries = FreshRSS_index_Controller::listEntriesByContext();
} catch (Minz_Exception $e) {
	Minz_Error::error(400, 'Bad user query!');
	die();
}

$get = FreshRSS_Context::currentGet(true);
$type = (string)$get[0];
$id = (int)$get[1];

switch ($type) {
	case 'c':	// Category
		$cat = FreshRSS_Context::categories()[$id] ?? null;
		if ($cat === null) {
			Minz_Error::error(404, "Category {$id} not found!");
			die();
		}
		$view->categories = [ $cat->id() => $cat ];
		break;
	case 'f':	// Feed
		$feed = FreshRSS_Category::findFeed(FreshRSS_Context::categories(), $id);
		if ($feed === null) {
			Minz_Error::error(404, "Feed {$id} not found!");
			die();
		}
		$view->feeds = [ $feed->id() => $feed ];
		$view->categories = [];
		break;
	default:
		$view->categories = FreshRSS_Context::categories();
		break;
}

$view->disable_aside = true;
$view->excludeMutedFeeds = true;
$view->internal_rendering = true;
$view->html_url = $query->sharedUrlHtml();
$view->opml_url = $query->sharedUrlOpml();
$view->rss_url = $query->sharedUrlRss();
$view->rss_title = $query->getName();
if ($query->getName() != '') {
	FreshRSS_View::_title($query->getName());
}

if (in_array($format, ['rss', 'atom'], true)) {
	header('Content-Type: application/rss+xml; charset=utf-8');
	$view->_layout(null);
	$view->_path('index/rss.phtml');
} elseif ($format === 'opml') {
	if ($view->opml_url == '') {
		Minz_Error::error(404, 'OPML not allowed for this user query!');
		die();
	} else {
		header('Content-Type: application/xml; charset=utf-8');
		$view->_layout(null);
		$view->_path('index/opml.phtml');
	}
} else {
	$view->_layout('simple');
	$view->_path('index/html.phtml');
}

$view->build();

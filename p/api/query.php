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
if (!in_array($format, ['atom', 'greader', 'html', 'json', 'opml', 'rss'], true)) {
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
if (!FreshRSS_Context::hasUserConf() || !FreshRSS_Context::userConf()->enabled) {
	usleep(rand(100, 10000));	//Primitive mitigation of scanning for users
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/plain; charset=UTF-8');
	die('User not found!');
} else {
	usleep(rand(20, 200));
}

if (!file_exists(DATA_PATH . '/no-cache.txt')) {
	require(LIB_PATH . '/http-conditional.php');
	$dateLastModification = max(
		FreshRSS_UserDAO::ctime($user),
		FreshRSS_UserDAO::mtime($user),
		@filemtime(DATA_PATH . '/config.php') ?: 0
	);
	// TODO: Consider taking advantage of $feedMode, only for monotonous queries {all, categories, feeds} and not dynamic ones {read/unread, favourites, user labels}
	if (httpConditional($dateLastModification ?: time(), 0, 0, false, PHP_COMPRESSION, false)) {
		exit();	//No need to send anything
	}
}

Minz_Translate::init(FreshRSS_Context::userConf()->language);
Minz_ExtensionManager::init();
Minz_ExtensionManager::enableByList(FreshRSS_Context::userConf()->extensions_enabled, 'user');

$query = null;
$userSearch = null;
foreach (FreshRSS_Context::userConf()->queries as $raw_query) {
	if (!empty($raw_query['token']) && $raw_query['token'] === $token) {
		switch ($format) {
			case 'atom':
			case 'greader':
			case 'html':
			case 'json':
			case 'rss':
				if (empty($raw_query['shareRss'])) {
					continue 2;
				}
				break;
			case 'opml':
				if (empty($raw_query['shareOpml'])) {
					continue 2;
				}
				break;
			default:
				continue 2;
		}
		$query = new FreshRSS_UserQuery($raw_query, FreshRSS_Context::categories(), FreshRSS_Context::labels());
		Minz_Request::_param('get', $query->getGet());
		if (Minz_Request::paramString('order') === '') {
			Minz_Request::_param('order', $query->getOrder());
		}
		Minz_Request::_param('state', (string)$query->getState());

		$search = $query->getSearch()->getRawInput();
		// Note: we disallow references to user queries in public user search to avoid sniffing internal user queries
		$userSearch = new FreshRSS_BooleanSearch(Minz_Request::paramString('search'), 0, 'AND', false);
		if ($userSearch->getRawInput() !== '') {
			if ($search === '') {
				$search = $userSearch->getRawInput();
			} else {
				$search .= ' (' . $userSearch->getRawInput() . ')';
			}
		}
		Minz_Request::_param('search', $search);
		break;
	}
}
if ($query === null || $userSearch === null) {
	usleep(rand(100, 10000));
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/plain; charset=UTF-8');
	die('User query not found!');
}

$view = new FreshRSS_View();

try {
	FreshRSS_Context::updateUsingRequest(false);
	Minz_Request::_param('search', $userSearch->getRawInput());	// Restore user search
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
$view->userQuery = $query;
$view->html_url = $query->sharedUrlHtml();
$view->rss_url = $query->sharedUrlRss();
$view->rss_title = $query->getName();
$view->image_url = $query->getImageUrl();
$view->description = $query->getDescription() ?: _t('index.feed.rss_of', $view->rss_title);
if ($query->getName() != '') {
	FreshRSS_View::_title($query->getName());
}
FreshRSS_Context::systemConf()->allow_anonymous = true;

header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Max-Age: 600');
header('Cache-Control: public, max-age=60');
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
	header('HTTP/1.1 204 No Content');
	exit();
}

if (in_array($format, ['rss', 'atom'], true)) {
	header('Content-Type: application/rss+xml; charset=utf-8');
	$view->_layout(null);
	$view->_path('index/rss.phtml');
} elseif (in_array($format, ['greader', 'json'], true)) {
	header('Content-Type: application/json; charset=utf-8');
	$view->_layout(null);
	$view->type = 'query/' . $token;
	$view->list_title = $query->getName();
	$view->entryIdsTagNames = [];	// Do not export user labels for privacy
	$view->_path('helpers/export/articles.phtml');
} elseif ($format === 'opml') {
	if (!$query->safeForOpml()) {
		Minz_Error::error(404, 'OPML not allowed for this user query!');
		die();
	}
	header('Content-Type: application/xml; charset=utf-8');
	$view->_layout(null);
	$view->_path('index/opml.phtml');
} else {
	$view->_layout('layout');
	$view->_path('index/html.phtml');
}

$view->build();

<?php
declare(strict_types=1);

use FreshRss\Controllers\IndexController;
use FreshRss\Controllers\UserController;
use FreshRss\Minz\ExtensionManager;
use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Minz\Translate;
use FreshRss\Models\BooleanSearch;
use FreshRss\Models\Category;
use FreshRss\Models\Context;
use FreshRss\Models\Factory;
use FreshRss\Models\UserDAO;
use FreshRss\Models\UserQuery;
use FreshRss\Models\View;

header('X-Content-Type-Options: nosniff');

require dirname(__DIR__, 2) . '/constants.php';
require LIB_PATH . '/lib_rss.php';	//Includes class autoloader

Request::init();

$token = Request::paramString('t', plaintext: true);
if (!ctype_alnum($token)) {
	header('HTTP/1.1 422 Unprocessable Entity');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Invalid token `t`!' . $token);
}

$format = Request::paramString('f', plaintext: true);
if (!in_array($format, ['atom', 'greader', 'html', 'json', 'opml', 'rss'], true)) {
	header('HTTP/1.1 422 Unprocessable Entity');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Invalid format `f`!');
}

$user = Request::paramString('user', plaintext: true);
if (!UserController::checkUsername($user)) {
	header('HTTP/1.1 422 Unprocessable Entity');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Invalid user!');
}

Session::init('FreshRSS', true);

Context::initSystem();
if (!Context::hasSystemConf() || !Context::systemConf()->api_enabled) {
	header('HTTP/1.1 503 Service Unavailable');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Service Unavailable!');
}

if (($_SERVER['PATH_INFO'] ?? $_SERVER['ORIG_PATH_INFO'] ?? '') !== '') {
	// Do not allow trailing slashes
	header('HTTP/1.1 400 Bad Request');
	die('Invalid path!');
}

Context::initUser($user);
if (!Context::hasUserConf() || !Context::userConf()->enabled) {
	usleep(rand(100, 10000));	//Primitive mitigation of scanning for users
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/plain; charset=UTF-8');
	die('User not found!');
} else {
	usleep(rand(20, 200));
}

require LIB_PATH . '/http-conditional.php';
$dateLastModification = max(
	UserDAO::ctime($user),
	UserDAO::mtime($user),
	@filemtime(DATA_PATH . '/config.php') ?: 0
);
// TODO: Consider taking advantage of $feedMode, only for monotonous queries {all, categories, feeds} and not dynamic ones {read/unread, favourites, user labels}
if (!file_exists(DATA_PATH . '/no-cache.txt') && httpConditional($dateLastModification ?: time(), 0, 0, false, PHP_COMPRESSION, false)) {
	exit();	//No need to send anything
}

Translate::init(Context::userConf()->language);
ExtensionManager::init();
ExtensionManager::enableByList(Context::userConf()->extensions_enabled, 'user');

$query = null;
$userSearch = null;
foreach (Context::userConf()->queries as $raw_query) {
	if (!empty($raw_query['token']) && hash_equals($raw_query['token'], $token)) {
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
		$query = new UserQuery($raw_query, Context::categories(), Context::labels());
		Request::_param('get', $query->getGet());
		if (Request::paramString('order', plaintext: true) === '') {
			Request::_param('order', $query->getOrder());
		}
		Request::_param('state', (string)$query->getState());

		$search = $query->getSearch()->toString();
		// Note: we disallow references to user queries in public user search to avoid sniffing internal user queries
		$userSearch = new BooleanSearch(Request::paramString('search', plaintext: true), 0, 'AND', allowUserQueries: false);
		if ($userSearch->toString() !== '') {
			if ($search === '') {
				$search = $userSearch->toString();
			} else {
				$search .= ' (' . $userSearch->toString() . ')';
			}
		}
		Request::_param('search', $search);
		break;
	}
}
if ($query === null || $userSearch === null) {
	usleep(rand(100, 10000));
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/plain; charset=UTF-8');
	die('User query not found!');
}

$view = new View();

try {
	Context::updateUsingRequest(false);
	$view->entries = IndexController::listEntriesByContext();
	if (!$view->entries->valid()) {	// Init the generator to consume the aggregated search and catch potential exceptions
		$view->entries = new EmptyIterator();
	}
	Request::_param('search', $userSearch->toString());	// Restore user search for display and exports
	Context::$search = $userSearch;	// Restore user search for display and exports
} catch (\FreshRss\Minz\Exception) {
	\FreshRss\Minz\Error::error(400, 'Bad user query!');
	die();
}

$get = Context::currentGet(true);
$type = (string)$get[0];
$id = (int)$get[1];

switch ($type) {
	case 'c':	// Category
		$cat = Context::categories()[$id] ?? null;
		if ($cat === null) {
			\FreshRss\Minz\Error::error(404, "Category {$id} not found!");
			die();
		}
		$view->categories = [$cat->id() => $cat];
		break;
	case 'f':	// Feed
		$feed = Category::findFeed(Context::categories(), $id);
		if ($feed === null) {
			\FreshRss\Minz\Error::error(404, "Feed {$id} not found!");
			die();
		}
		$view->feeds = [$id => $feed];
		$view->categories = [];
		break;
	default:
		$view->categories = Context::categories();
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
$view->publishLabelsInsteadOfTags = $query->publishLabelsInsteadOfTags();
$view->entryIdsTagNames = [];
if ($view->publishLabelsInsteadOfTags && in_array($format, ['rss', 'atom'], true)) {
	$entries = iterator_to_array($view->entries, preserve_keys: false);	// TODO: Optimise: avoid iterator_to_array if possible
	$view->entries = $entries;
	if (!empty($entries)) {
		$tagDAO = Factory::createTagDao();
		$view->entryIdsTagNames = $tagDAO->getEntryIdsTagNames($entries);
	}
}
if ($query->getName() != '') {
	View::_title($query->getName());
}
Context::systemConf()->allow_anonymous = true;

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
	header("Content-Security-Policy: default-src 'none'; sandbox; frame-ancestors " .
		(Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'"));
	$view->_layout(null);
	$view->_path('index/rss.phtml');
} elseif (in_array($format, ['greader', 'json'], true)) {
	header('Content-Type: application/json; charset=utf-8');
	header("Content-Security-Policy: default-src 'none'; sandbox; frame-ancestors " .
		(Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'"));
	$view->_layout(null);
	$view->type = 'query/' . $token;
	$view->list_title = $query->getName();
	$view->entryIdsTagNames = [];	// Do not export user labels for privacy
	$view->_path('helpers/export/articles.phtml');
} elseif ($format === 'opml') {
	if (!$query->safeForOpml()) {
		\FreshRss\Minz\Error::error(404, 'OPML not allowed for this user query!');
		die();
	}
	header('Content-Type: application/xml; charset=utf-8');
	header("Content-Security-Policy: default-src 'none'; sandbox; frame-ancestors " .
		(Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'"));
	$view->_layout(null);
	$view->_path('index/opml.phtml');
} else {
	header("Content-Security-Policy: default-src 'self'; frame-src *; img-src * data:; media-src *; frame-ancestors " .
		(Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'"));
	$view->_layout('layout');
	$view->_path('index/html.phtml');
}

$view->build();

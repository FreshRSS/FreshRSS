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
if (!in_array($format, ['atom', 'html', 'rss'], true)) {
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

$found = false;
foreach (FreshRSS_Context::userConf()->queries as $raw_query) {
	if (!empty($raw_query['token']) && $raw_query['token'] === $token) {
		Minz_Request::_param('a', $raw_query['get'] ?? '');
		Minz_Request::_param('order', $raw_query['order'] ?? '');
		Minz_Request::_param('search', $raw_query['search'] ?? '');
		Minz_Request::_param('state', $raw_query['state'] ?? 0);
		$found = true;
		break;
	}
}
if (!$found) {
	usleep(rand(100, 10000));
	header('HTTP/1.1 404 Not Found');
	header('Content-Type: text/plain; charset=UTF-8');
	die('User query not found!');
}

$view = new FreshRSS_View();
$view->_layout(null);
$view->internal_rendering = true;

try {
	FreshRSS_Context::updateUsingRequest(false);
	$view->entries = FreshRSS_index_Controller::listEntriesByContext();
} catch (FreshRSS_Context_Exception $e) {
	header('HTTP/1.1 400 Bad Request');
	header('Content-Type: text/plain; charset=UTF-8');
	die('Bad user query!');
}

if (in_array($format, ['rss', 'atom'], true)) {
	header('Content-Type: application/rss+xml; charset=utf-8');
	$view->_path('index/rss.phtml');
} elseif ($format === 'html') {
	$view->_path('index/html.phtml');
	// TODO
}

echo $view->renderToString();

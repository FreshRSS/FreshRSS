<?php
require('../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

define('MAX_PAYLOAD', 3145728);

header('Content-Type: text/plain; charset=UTF-8');

function logMe($text) {
	file_put_contents(USERS_PATH . '/_/log_pshb.txt', date('c') . "\t" . $text . "\n", FILE_APPEND);
}

$ORIGINAL_INPUT = file_get_contents('php://input', false, null, -1, MAX_PAYLOAD);

logMe(print_r(array('_GET' => $_GET, '_POST' => $_POST, 'INPUT' => $ORIGINAL_INPUT), true));

$secret = isset($_GET['s']) ? substr($_GET['s'], 0, 128) : '';
if (!ctype_xdigit($secret)) {
	header('HTTP/1.1 422 Unprocessable Entity');
	die('Invalid feed secret format!');
}
chdir(PSHB_PATH);
$canonical64 = @file_get_contents('secrets/' . $secret . '.txt');
if ($canonical64 === false) {
	header('HTTP/1.1 404 Not Found');
	logMe('Feed secret not found!: ' . $secret);
	die('Feed secret not found!');
}
$canonical64 = trim($canonical64);
if (!preg_match('/^[A-Za-z0-9_-]+$/D', $canonical64)) {
	header('HTTP/1.1 500 Internal Server Error');
	logMe('Invalid secret reference!: ' . $canonical64);
	die('Invalid secret reference!');
}
$secret2 = @file_get_contents('feeds/' . $canonical64 . '/secret.txt');
if ($secret2 === false) {
	header('HTTP/1.1 404 Not Found');
	//@unlink('secrets/' . $secret . '.txt');
	logMe('Feed reverse secret not found!: ' . $canonical64);
	die('Feed reverse secret not found!');
}
if ($secret !== $secret2) {
	header('HTTP/1.1 500 Internal Server Error');
	logMe('Invalid secret cross-check!: ' . $secret);
	die('Invalid secret cross-check!');
}
chdir('feeds/' . $canonical64);
$users = glob('*/*.txt', GLOB_NOSORT);
if (empty($users)) {
	header('HTTP/1.1 410 Gone');
	logMe('Nobody is subscribed to this feed anymore!: ' . $canonical64);
	die('Nobody is subscribed to this feed anymore!');
}

if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] === 'subscribe') {
	//TODO: hub_lease_seconds
	exit(isset($_REQUEST['hub_challenge']) ? $_REQUEST['hub_challenge'] : '');
}

Minz_Configuration::register('system', DATA_PATH . '/config.php', DATA_PATH . '/config.default.php');
$system_conf = Minz_Configuration::get('system');
$system_conf->auth_type = 'none';	// avoid necessity to be logged in (not saved!)
Minz_Translate::init('en');
Minz_Request::_param('ajax', true);
$feedController = new FreshRSS_feed_Controller();

$simplePie = customSimplePie();
$simplePie->set_raw_data($ORIGINAL_INPUT);
$simplePie->init();
unset($ORIGINAL_INPUT);

$links = $simplePie->get_links('self');
$self = isset($links[0]) ? $links[0] : null;

if ($self !== base64url_decode($canonical64)) {
	header('HTTP/1.1 422 Unprocessable Entity');
	logMe('Self URL does not match registered canonical URL!: ' . $self);
	die('Self URL does not match registered canonical URL!');
}
Minz_Request::_param('url', $self);

$nb = 0;
foreach ($users as $userLine) {
	$userLine = strtr($userLine, '\\', '/');
	$userInfos = explode('/', $userLine);
	$feedUrl = isset($userInfos[0]) ? base64url_decode($userInfos[0]) : '';
	$username = isset($userInfos[1]) ? basename($userInfos[1], '.txt') : '';
	if (!file_exists(USERS_PATH . '/' . $username . '/config.php')) {
		break;
	}

	try {
		Minz_Session::_param('currentUser', $username);
		Minz_Configuration::register('user',
		                             join_path(USERS_PATH, $username, 'config.php'),
		                             join_path(USERS_PATH, '_', 'config.default.php'));
		FreshRSS_Context::init();
		if ($feedController->actualizeAction($simplePie) > 0) {
			$nb++;
		}
	} catch (Exception $e) {
		logMe($e->getMessage());
	}
}

$simplePie->__destruct();
unset($simplePie);

if ($nb === 0) {
	header('HTTP/1.1 410 Gone');
	logMe('Nobody is subscribed to this feed anymore after all!: ' . $self);
	die('Nobody is subscribed to this feed anymore after all!');
}

logMe($self . ' done: ' . $nb);
exit('Done: ' . $nb . "\n");

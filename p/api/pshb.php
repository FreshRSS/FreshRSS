<?php
require('../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

define('MAX_PAYLOAD', 3145728);

header('Content-Type: text/plain; charset=UTF-8');

function logMe($text) {
	file_put_contents(USERS_PATH . '/_/log_pshb.txt', date('c') . "\t" . $text . "\n", FILE_APPEND);
}

$ORIGINAL_INPUT = file_get_contents('php://input', false, null, -1, MAX_PAYLOAD);

//logMe(print_r(array('_SERVER' => $_SERVER, '_GET' => $_GET, '_POST' => $_POST, 'INPUT' => $ORIGINAL_INPUT), true));

$key = isset($_GET['k']) ? substr($_GET['k'], 0, 128) : '';
if (!ctype_xdigit($key)) {
	header('HTTP/1.1 422 Unprocessable Entity');
	die('Invalid feed key format!');
}
chdir(PSHB_PATH);
$canonical64 = @file_get_contents('keys/' . $key . '.txt');
if ($canonical64 === false) {
	header('HTTP/1.1 404 Not Found');
	logMe('Error: Feed key not found!: ' . $key);
	die('Feed key not found!');
}
$canonical64 = trim($canonical64);
if (!preg_match('/^[A-Za-z0-9_-]+$/D', $canonical64)) {
	header('HTTP/1.1 500 Internal Server Error');
	logMe('Error: Invalid key reference!: ' . $canonical64);
	die('Invalid key reference!');
}
$hubFile = @file_get_contents('feeds/' . $canonical64 . '/!hub.json');
if ($hubFile === false) {
	header('HTTP/1.1 404 Not Found');
	//@unlink('keys/' . $key . '.txt');
	logMe('Error: Feed info not found!: ' . $canonical64);
	die('Feed info not found!');
}
$hubJson = json_decode($hubFile, true);
if (!$hubJson || empty($hubJson['key']) || $hubJson['key'] !== $key) {
	header('HTTP/1.1 500 Internal Server Error');
	logMe('Error: Invalid key cross-check!: ' . $key);
	die('Invalid key cross-check!');
}
chdir('feeds/' . $canonical64);
$users = glob('*.txt', GLOB_NOSORT);
if (empty($users)) {
	header('HTTP/1.1 410 Gone');
	logMe('Error: Nobody is subscribed to this feed anymore!: ' . $canonical64);
	die('Nobody is subscribed to this feed anymore!');
}

if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] === 'subscribe') {
	$leaseSeconds = empty($_REQUEST['hub_lease_seconds']) ? 0 : intval($_REQUEST['hub_lease_seconds']);
	if ($leaseSeconds > 60) {
		$hubJson['lease_end'] = time() + $leaseSeconds;
	} else {
		unset($hubJson['lease_end']);
	}
	$hubJson['lease_start'] = time();
	if (!isset($hubJson['error'])) {
		$hubJson['error'] = true;	//Do not assume that PubSubHubbub works until the first successul push
	}
	file_put_contents('./!hub.json', json_encode($hubJson));
	exit(isset($_REQUEST['hub_challenge']) ? $_REQUEST['hub_challenge'] : '');
}

if ($ORIGINAL_INPUT == '') {
	header('HTTP/1.1 422 Unprocessable Entity');
	die('Missing XML payload!');
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
	//header('HTTP/1.1 422 Unprocessable Entity');
	logMe('Warning: Self URL [' . $self . '] does not match registered canonical URL!: ' . base64url_decode($canonical64));
	//die('Self URL does not match registered canonical URL!');
	$self = base64url_decode($canonical64);
}
Minz_Request::_param('url', $self);

$nb = 0;
foreach ($users as $userFilename) {
	$username = basename($userFilename, '.txt');
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
		logMe('Error: ' . $e->getMessage());
	}
}

$simplePie->__destruct();
unset($simplePie);

if ($nb === 0) {
	header('HTTP/1.1 410 Gone');
	logMe('Error: Nobody is subscribed to this feed anymore after all!: ' . $self);
	die('Nobody is subscribed to this feed anymore after all!');
} elseif (!empty($hubJson['error'])) {
	$hubJson['error'] = false;
	file_put_contents('./!hub.json', json_encode($hubJson));
}

logMe('PubSubHubbub ' . $self . ' done: ' . $nb);
exit('Done: ' . $nb . "\n");

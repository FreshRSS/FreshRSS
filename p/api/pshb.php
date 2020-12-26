<?php
require(__DIR__ . '/../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader

const MAX_PAYLOAD = 3145728;

header('Content-Type: text/plain; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

$ORIGINAL_INPUT = file_get_contents('php://input', false, null, 0, MAX_PAYLOAD);

Minz\Configuration::register('system', DATA_PATH . '/config.php', FRESHRSS_PATH . '/config.default.php');
$system_conf = Minz\Configuration::get('system');
$system_conf->auth_type = 'none';	// avoid necessity to be logged in (not saved!)

//Minz\Log::debug(print_r(array('_SERVER' => $_SERVER, '_GET' => $_GET, '_POST' => $_POST, 'INPUT' => $ORIGINAL_INPUT), true), PSHB_LOG);

$key = isset($_GET['k']) ? substr($_GET['k'], 0, 128) : '';
if (!ctype_xdigit($key)) {
	header('HTTP/1.1 422 Unprocessable Entity');
	die('Invalid feed key format!');
}
chdir(PSHB_PATH);
$canonical64 = @file_get_contents('keys/' . $key . '.txt');
if ($canonical64 === false) {
	if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] === 'unsubscribe') {
		Minz\Log::warning('Warning: Accept unknown unsubscribe', PSHB_LOG);
		header('Connection: close');
		exit(isset($_REQUEST['hub_challenge']) ? $_REQUEST['hub_challenge'] : '');
	}
	header('HTTP/1.1 404 Not Found');
	Minz\Log::warning('Warning: Feed key not found!: ' . $key, PSHB_LOG);
	die('Feed key not found!');
}
$canonical64 = trim($canonical64);
if (!preg_match('/^[A-Za-z0-9_-]+$/D', $canonical64)) {
	header('HTTP/1.1 500 Internal Server Error');
	Minz\Log::error('Error: Invalid key reference!: ' . $canonical64, PSHB_LOG);
	die('Invalid key reference!');
}
$hubFile = @file_get_contents('feeds/' . $canonical64 . '/!hub.json');
if ($hubFile === false) {
	header('HTTP/1.1 404 Not Found');
	unlink('keys/' . $key . '.txt');
	Minz\Log::error('Error: Feed info not found!: ' . $canonical64, PSHB_LOG);
	die('Feed info not found!');
}
$hubJson = json_decode($hubFile, true);
if (!$hubJson || empty($hubJson['key']) || $hubJson['key'] !== $key) {
	header('HTTP/1.1 500 Internal Server Error');
	Minz\Log::error('Error: Invalid key cross-check!: ' . $key, PSHB_LOG);
	die('Invalid key cross-check!');
}
chdir('feeds/' . $canonical64);
$users = glob('*.txt', GLOB_NOSORT);
if (empty($users)) {
	header('HTTP/1.1 410 Gone');
	$url = base64url_decode($canonical64);
	Minz\Log::warning('Warning: Nobody subscribes to this feed anymore!: ' . $url, PSHB_LOG);
	unlink('../../keys/' . $key . '.txt');
	Minz\Configuration::register('system',
		DATA_PATH . '/config.php',
		FRESHRSS_PATH . '/config.default.php');
	FreshRSS_Context::$system_conf = Minz\Configuration::get('system');
	$feed = new FreshRSS_Feed($url);
	$feed->pubSubHubbubSubscribe(false);
	unlink('!hub.json');
	chdir('..');
	recursive_unlink($canonical64);
	die('Nobody subscribes to this feed anymore!');
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
		$hubJson['error'] = true;	//Do not assume that WebSub works until the first successul push
	}
	file_put_contents('./!hub.json', json_encode($hubJson));
	header('Connection: close');
	exit(isset($_REQUEST['hub_challenge']) ? $_REQUEST['hub_challenge'] : '');
}

if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] === 'unsubscribe') {
	if (empty($hubJson['lease_end']) || $hubJson['lease_end'] < time()) {
		header('Connection: close');
		exit(isset($_REQUEST['hub_challenge']) ? $_REQUEST['hub_challenge'] : '');
	} else {
		header('HTTP/1.1 422 Unprocessable Entity');
		die('We did not ask to unsubscribe!');
	}
}

if ($ORIGINAL_INPUT == '') {
	header('HTTP/1.1 422 Unprocessable Entity');
	die('Missing XML payload!');
}

$simplePie = customSimplePie();
$simplePie->set_raw_data($ORIGINAL_INPUT);
$simplePie->init();
unset($ORIGINAL_INPUT);

$links = $simplePie->get_links('self');
$self = isset($links[0]) ? $links[0] : null;

if ($self !== base64url_decode($canonical64)) {
	//header('HTTP/1.1 422 Unprocessable Entity');
	Minz\Log::warning('Warning: Self URL [' . $self . '] does not match registered canonical URL!: ' . base64url_decode($canonical64), PSHB_LOG);
	//die('Self URL does not match registered canonical URL!');
	$self = base64url_decode($canonical64);
}

Minz\ExtensionManager::init();
Minz\Translate::init();

$nb = 0;
foreach ($users as $userFilename) {
	$username = basename($userFilename, '.txt');
	if (!file_exists(USERS_PATH . '/' . $username . '/config.php')) {
		Minz\Log::warning('Warning: Removing broken user link: ' . $username . ' for ' . $self, PSHB_LOG);
		unlink($userFilename);
		continue;
	}

	try {
		Minz\Session::_param('currentUser', $username);
		Minz\Configuration::register('user',
		                             join_path(USERS_PATH, $username, 'config.php'),
		                             join_path(FRESHRSS_PATH, 'config-user.default.php'));
		new Minz\ModelPdo($username);	//TODO: FIXME: Quick-fix while waiting for a better FreshRSS() constructor/init
		FreshRSS_Context::init();
		if (FreshRSS_Context::$user_conf != null) {
			Minz\ExtensionManager::enableByList(FreshRSS_Context::$user_conf->extensions_enabled);
			Minz\Translate::reset(FreshRSS_Context::$user_conf->language);
		}

		if (!FreshRSS_Context::$user_conf->enabled) {
			Minz\Log::warning('FreshRSS skip disabled user ' . $username);
			continue;
		}

		list($updated_feeds, $feed, $nb_new_articles) = FreshRSS_feed_Controller::actualizeFeed(0, $self, false, $simplePie);
		if ($updated_feeds > 0 || $feed != false) {
			$nb++;
		} else {
			Minz\Log::warning('Warning: User ' . $username . ' does not subscribe anymore to ' . $self, PSHB_LOG);
			unlink($userFilename);
		}
	} catch (Exception $e) {
		Minz\Log::error('Error: ' . $e->getMessage() . ' for user ' . $username . ' and feed ' . $self, PSHB_LOG);
	}
}

$simplePie->__destruct();	//http://simplepie.org/wiki/faq/i_m_getting_memory_leaks
unset($simplePie);

if ($nb === 0) {
	header('HTTP/1.1 410 Gone');
	Minz\Log::warning('Warning: Nobody subscribes to this feed anymore after all!: ' . $self, PSHB_LOG);
	die('Nobody subscribes to this feed anymore after all!');
} elseif (!empty($hubJson['error'])) {
	$hubJson['error'] = false;
	file_put_contents('./!hub.json', json_encode($hubJson));
}

Minz\Log::notice('WebSub ' . $self . ' done: ' . $nb, PSHB_LOG);
exit('Done: ' . $nb . "\n");

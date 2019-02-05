<?php
if (php_sapi_name() !== 'cli') {
	die('FreshRSS error: This PHP script may only be invoked from command line!');
}

require(__DIR__ . '/../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
require(LIB_PATH . '/lib_install.php');

Minz_Configuration::register('system',
	DATA_PATH . '/config.php',
	FRESHRSS_PATH . '/config.default.php');
FreshRSS_Context::$system_conf = Minz_Configuration::get('system');
Minz_Translate::init('en');

FreshRSS_Context::$isCli = true;

function fail($message) {
	fwrite(STDERR, $message . "\n");
	die(1);
}

function cliInitUser($username) {
	if (!FreshRSS_user_Controller::checkUsername($username)) {
		fail('FreshRSS error: invalid username: ' . $username . "\n");
	}

	$usernames = listUsers();
	if (!in_array($username, $usernames)) {
		fail('FreshRSS error: user not found: ' . $username . "\n");
	}

	FreshRSS_Context::$user_conf = get_user_configuration($username);
	if (FreshRSS_Context::$user_conf == null) {
		fail('FreshRSS error: invalid configuration for user: ' . $username . "\n");
	}
	new Minz_ModelPdo($username);

	return $username;
}

function accessRights() {
	echo '• Remember to re-apply the appropriate access rights, such as:' , "\n",
		"\t", 'sudo chown -R :www-data . && sudo chmod -R g+r . && sudo chmod -R g+w ./data/', "\n";
}

function done($ok = true) {
	fwrite(STDERR, 'Result: ' . ($ok ? 'success' : 'fail') . "\n");
	exit($ok ? 0 : 1);
}

function performRequirementCheck($databaseType) {
	$requirements = checkRequirements($databaseType);
	if ($requirements['all'] !== 'ok') {
		$message = 'FreshRSS install failed requirements:' . "\n";
		foreach ($requirements as $requirement => $check) {
			if ($check !== 'ok' && !in_array($requirement, array('all', 'pdo', 'message'))) {
				$message .= '• ' . $requirement . "\n";
			}
		}
		if (!empty($requirements['message'])) {
			$message .= '• ' . $requirements['message'] . "\n";
		}
		fail($message);
	}
}

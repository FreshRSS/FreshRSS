<?php
if (php_sapi_name() !== 'cli') {
	die('FreshRSS error: This PHP script may only be invoked from command line!');
}

const REGEX_INPUT_OPTIONS = '/^--/';
const REGEX_PARAM_OPTIONS = '/:*$/';

require(__DIR__ . '/../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
require(LIB_PATH . '/lib_install.php');

Minz_Session::init('FreshRSS', true);
FreshRSS_Context::initSystem();
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

	if (!FreshRSS_Context::initUser($username)) {
		fail('FreshRSS error: invalid configuration for user: ' . $username . "\n");
	}

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

function getLongOptions($options, $regex) {
	$longOptions = array_filter($options, function($a) use ($regex) {
		return preg_match($regex, $a);
	});
	return array_map(function($a) use ($regex) {
		return preg_replace($regex, '', $a);
	}, $longOptions);
}

function validateOptions($input, $params) {
	$sanitizeInput = getLongOptions($input, REGEX_INPUT_OPTIONS);
	$sanitizeParams = getLongOptions($params, REGEX_PARAM_OPTIONS);
	$unknownOptions = array_diff($sanitizeInput, $sanitizeParams);

	if (0 === count($unknownOptions)) {
		return true;
	}

	fwrite(STDERR, sprintf("FreshRSS error: unknown options: %s\n", implode (', ', $unknownOptions)));
	return false;
}

<?php

define('PACKAGE_URL', 'https://codeload.github.com/marienfressinaud/FreshRSS/zip/0.9.2');
$DIRS_TO_CHECK = array(
	DATA_PATH,
	DATA_PATH . '/cache',
	DATA_PATH . '/favicons',
	DATA_PATH . '/log',
	DATA_PATH . '/persona',
	DATA_PATH . '/tokens',
);


function fix_configuration($conf) {
	$all = 0;
	$not_read = 2;
	$strict = 16;

	// Update to >= 0.9.2
	switch ($conf->default_view){
	case $not_read:
		$conf->_default_view('adaptive');
		break;
	case $all:
		$conf->_default_view('all');
		break;
	case $strict + $not_read:
		$conf->_default_view('unread');
		break;
	default:
		// Nothing to do, configuration is ok
	}

	$conf->save();
}


// Apply the update by replacing old version of FreshRSS by the new one.
function apply_update() {
	// First, do a backup.
	$res = remove_data_backup();
	if (!$res) {
		return 'can\'t remove backup of ' . DATA_PATH;
	}
	$res = data_backup();
	if (!$res) {
		return 'can\'t do a backup of ' . DATA_PATH;
	}

	// For each directory, we check it exists, dir/index.html exists and we can
	// write inside.
	foreach ($DIRS_TO_CHECK as $dir) {
		$res = check_directory($dir);
		if (!$res) {
			return '`' . $dir . '` does not exist or FreshRSS cannot write inside';
		}
	}

	// Get the FRSS package.
	$res = save_package(PACKAGE_URL);
	if (!$res) {
		return 'can\'t save package ' . PACKAGE_URL;
	}

	// Deploy it on the server.
	$res = deploy_package();
	if (!$res) {
		return 'can\'t deploy update package';
	}

	// And clean package files.
	$res = clean_package();
	if (!$res) {
		return 'can\'t clean update package';
	}

	// Finally, we fix configuration if needed for each user.
	// First, we HAVE to reload the configuration file
	runkit_import(APP_PATH . '/Models/Configuration.php');
	$error = '';
	for (listUsers() as $username) {
		try {
			$conf = new FreshRSS_Configuration($username);
			$res = fix_configuration($conf);
			if (!$res) {
				$error .= 'can\'t fix configuration for ' . $username . "\n";
			}
		} catch(Minz_Exception $e) {
			$error .= 'can\'t fix user ' . $username . "\n";
		}
	}
	if ($error != '') {
		return $error;
	}

	return true;
}


function need_info_update() {
	return false;
}


function save_info_update() {

}


function ask_info_update() {

}

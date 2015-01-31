<?php

define('PACKAGE_URL', 'https://codeload.github.com/FreshRSS/FreshRSS/zip/1.1.0');


// Fix system configuration (>= 0.9.4)
function fix_system_config() {
	$filename = DATA_PATH . '/config.php';

	if (!is_writable($filename)) {
		@chmod($filename, 0774);
	}

	$config = include($filename);

	if (!is_array($config)) {
		return false;
	}

	if (!isset($config['general'])) {
		// No general array? It means config is already fine.
		return true;
	}

	$general = $config['general'];
	$config['environment'] = $general['environment'];
	$config['salt'] = $general['salt'];
	$config['base_url'] = $general['base_url'];
	$config['title'] = $general['title'];
	$config['default_user'] = $general['default_user'];
	$config['allow_anonymous'] = $general['allow_anonymous'];
	$config['allow_anonymous_refresh'] = $general['allow_anonymous_refresh'];
	$config['auth_type'] = $general['auth_type'];
	$config['api_enabled'] = $general['api_enabled'];
	$config['unsafe_autologin_enabled'] = $general['unsafe_autologin_enabled'];

	unset($config['general']);
	return file_put_contents($filename,
	                         "<?php\nreturn " . var_export($config, true) . ';',
	                         LOCK_EX) !== false;
}


// Fix user configuration file (>= 0.9.2)
function fix_configuration($conf) {
	$all = 0;
	$not_read = 2;
	$strict = 16;

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

	return true;
}


// Move user data for a given user (>= 0.9.4)
function move_user_data($username) {
	// Create the user path if needed.
	$user_path = DATA_PATH . '/users/' . $username;
	if (!file_exists($user_path)) {
		$res = @mkdir($user_path);
		if (!$res) {
			return false;
		}
	}

	// And we check the user dir is writable
	if (!is_writable($user_path)) {
		$res = @chmod($user_path, 0775);
		if (!$res) {
			return false;
		}
	}

	$filenames = array(
		DATA_PATH . '/' . $username . '_user.php' => $user_path . '/config.php',
		DATA_PATH . '/' . $username . '.sqlite' => $user_path . '/db.sqlite',
		DATA_PATH . '/log/' . $username . '.log' => $user_path . '/log.txt',
	);

	// Move list of files one by one.
	$is_error = false;
	foreach ($filenames as $old_name => $new_name) {
		if (file_exists($new_name)) {
			// We already have the new file so we just check old name does not
			// exist and try to remove it if it is.
			if (file_exists($old_name)) {
				@unlink($old_name);
			}
		} else {
			// Move old file to new file
			$res = rename($old_name, $new_name);
			if (!$res && file_exists($old_name)) {
				$is_error = true;
			}
		}
	}

	return !$is_error;
}


// Apply the update by replacing old version of FreshRSS by the new one.
function apply_update() {
	$dirs_to_check = array(
		DATA_PATH,
		DATA_PATH . '/cache',
		DATA_PATH . '/favicons',
		DATA_PATH . '/persona',
		DATA_PATH . '/tokens',
		DATA_PATH . '/users',
		DATA_PATH . '/users/_',
		FRESHRSS_PATH . '/extensions',
	);

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
	foreach ($dirs_to_check as $dir) {
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

	if (FRESHRSS_VERSION === '0.9.4') {
		// We are already ok!
		continue;
	}

	// Fix the system config
	$res = fix_system_config();
	if (!$res) {
		return 'can\'t fix system configuration';
	}

	// Finally, we fix configuration if needed for each user.
	$error = '';
	foreach (listUsers() as $username) {
		try {
			$conf = new FreshRSS_Configuration($username);
			$res = fix_configuration($conf);
			if (!$res) {
				$error .= 'can\'t fix configuration for ' . $username . "\n";
			}
		} catch(Minz_Exception $e) {
			$error .= 'can\'t fix user ' . $username . "\n";
		}

		// In the same loop, we move user data
		$res = move_user_data($username);
		if (!$res) {
			$error .= 'can\'t move user data for ' . $username . "\n";
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

function do_post_update() {
	$ok = true;
	return $ok;
}


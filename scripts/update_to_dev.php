<?php

define('PACKAGE_URL', 'https://codeload.github.com/marienfressinaud/FreshRSS/zip/dev');
$DIRS_TO_CHECK = array(
	DATA_PATH,
	DATA_PATH . '/cache',
	DATA_PATH . '/favicons',
	DATA_PATH . '/log',
	DATA_PATH . '/persona',
	DATA_PATH . '/tokens',
);


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

	return true;
}


// Nothing to ask for 0.8-dev
function need_info_update() {
	return false;
}


function save_info_update() {

}


function ask_info_update() {

}

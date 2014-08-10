<?php

define('PACKAGE_URL', 'https://github.com/marienfressinaud/FreshRSS/archive/0.7.3.zip');


function apply_update() {
	$res = remove_data_backup();
	if (!$res) {
		return 'can\'t remove backup of ' . DATA_PATH;
	}

	$res = data_backup();
	if (!$res) {
		return 'can\'t do a backup of ' . DATA_PATH;
	}

	$res = save_package(PACKAGE_URL);
	if (!$res) {
		return 'can\'t save package ' . PACKAGE_URL;
	}

	$res = deploy_package();
	if (!$res) {
		return 'can\'t deploy update package';
	}

	$res = clean_package();
	if (!$res) {
		return 'can\'t clean update package';
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

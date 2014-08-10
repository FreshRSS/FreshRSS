<?php

define('PACKAGE_PATHNAME', DATA_PATH . '/update_package');


// Delete a file tree (from http://php.net/rmdir#110489)
function del_tree($dir) {
	if (!is_dir($dir)) {
		return true;
	}

	$files = array_diff(scandir($dir), array('.', '..'));
	foreach ($files as $filename) {
		$filename = $dir . '/' . $filename;
		if (is_dir($filename)) {
			@chmod($filename, 0777);
			del_tree($filename);
		} else {
			unlink($filename);
		}
	}

	return rmdir($dir);
}


// Do a recursive copy (from http://fr2.php.net/manual/en/function.copy.php#91010)
function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);

    return true;
} 


// Remove previous backup of data.
function remove_data_backup() {
	return del_tree(DATA_PATH . '.back');
}


// Create a backup of data.
function data_backup() {
	$from = DATA_PATH;
	$to = $from .'.back';

	if (file_exists($from)) {
		return recurse_copy($from, $to);
	}

	return false;
}


// Save and unzip FreshRSS package.
function save_package($url) {
	// Download first package at $url.
	$zip_filename = PACKAGE_PATHNAME . '.zip';
	$zip_file = fopen($zip_filename, 'w+');
	$c = curl_init($url);
	curl_setopt($c, CURLOPT_HEADER, false);
	curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($c, CURLOPT_FILE, $zip_file);
	curl_exec($c);

	$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
	curl_close($c);
	fclose($zip_file);

	if ($status !== 200) {
		return false;
	}

	// And unzip package in PACKAGE_PATHNAME (should be under DATA_PATHNAME).
	$zip = new ZipArchive;
	if ($zip->open($zip_filename) === false) {
		return false;
	}
	$zip->extractTo(PACKAGE_PATHNAME);
	$zip->close();
	@unlink($zip_filename);

	return true;
}


// Deploy FreshRSS package by replacing old version by the new one.
function deploy_package() {
	$base_pathname = array_pop(array_diff(scandir(PACKAGE_PATHNAME),
	                                      array('.', '..')));
	$base_pathname = PACKAGE_PATHNAME . '/' . $base_pathname;

	// Remove old version.
	del_tree(APP_PATH);
	del_tree(LIB_PATH);
	del_tree(PUBLIC_PATH);
	unlink(FRESHRSS_PATH . '/constants.php');

	// Copy FRSS package at the good place.
	recurse_copy($base_pathname . '/app', APP_PATH);
	recurse_copy($base_pathname . '/lib', LIB_PATH);
	recurse_copy($base_pathname . '/p', PUBLIC_PATH);
	copy($base_pathname . '/constants.php', FRESHRSS_PATH . '/constants.php');

	return true;
}


// Remove files of FRSS package.
function clean_package() {
	return del_tree(PACKAGE_PATHNAME);
}


// NOTE: don't remove this close tag!
?>

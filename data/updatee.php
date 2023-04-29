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
function recurse_copy($src, $dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while (false !== ($file = readdir($dir))) {
		if (($file != '.') && ($file != '..')) {
			if (is_dir($src . '/' . $file)) {
				recurse_copy($src . '/' . $file, $dst . '/' . $file);
			} else {
				copy($src . '/' . $file, $dst . '/' . $file);
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


// Check if a directory exists and if it is writable.
function check_directory($dir) {
	if (!file_exists($dir)) {
		$res = @mkdir($dir, 0775);
		if (!$res) {
			return false;
		}
	}

	if (!is_writable($dir)) {
		$res = chmod($dir, 0775);
		if (!$res) {
			return false;
		}
	}

	$index = $dir . '/index.html';
	$data = <<<EOF
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB" lang="en-GB">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Refresh" content="0; url=/" />
<title>Redirection</title>
<meta name="robots" content="noindex" />
</head>

<body>
<p><a href="/">Redirection</a></p>
</body>
</html>
EOF;
	if (!file_exists($index)) {
		@file_put_contents($index, $data);
	}

	return true;
}


// Save and unzip FreshRSS package.
function save_package($url) {
	// First, download package from $url.
	$zip_filename = PACKAGE_PATHNAME . '.zip';
	$zip_file = fopen($zip_filename, 'w+');
	$c = curl_init($url);
	curl_setopt($c, CURLOPT_HEADER, false);
	curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
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


// Move custom themes to not delete them
function save_custom_themes($destination) {
	$themes_base_dir = PUBLIC_PATH . '/themes';
	$themes_dirs = array_diff(scandir($themes_base_dir), array('.', '..'));
	foreach ($themes_dirs as $theme_dir) {
		if (!preg_match('/^xTheme-/i', $theme_dir)) {
			continue;
		}

		$old_theme_path = $themes_base_dir . '/' . $theme_dir;
		$new_theme_path = $destination . '/' . $theme_dir;
		recurse_copy($old_theme_path, $new_theme_path);
	}
}


// Deploy FreshRSS package by replacing old version by the new one.
function deploy_package() {
	$base_pathname = array_pop(array_diff(scandir(PACKAGE_PATHNAME),
										  array('.', '..')));
	$base_pathname = PACKAGE_PATHNAME . '/' . $base_pathname;

	save_custom_themes($base_pathname . '/p/themes');

	// Remove old version.
	del_tree(APP_PATH);
	del_tree(LIB_PATH);
	del_tree(PUBLIC_PATH);
	del_tree(FRESHRSS_PATH . '/cli');
	unlink(FRESHRSS_PATH . '/constants.php');
	unlink(DATA_PATH . '/shares.php');

	// Copy FRSS package at the good place.
	recurse_copy($base_pathname . '/app', APP_PATH);
	recurse_copy($base_pathname . '/lib', LIB_PATH);
	recurse_copy($base_pathname . '/p', PUBLIC_PATH);
	recurse_copy($base_pathname . '/cli', FRESHRSS_PATH . '/cli');
	copy($base_pathname . '/constants.php', FRESHRSS_PATH . '/constants.php');
	copy($base_pathname . '/data/shares.php', DATA_PATH . '/shares.php');
	// These functions can fail because config.default.php has been introduced
	// in the 0.9.4 version.
	@copy($base_pathname . '/data/config.default.php',
		  DATA_PATH . '/config.default.php');
	@copy($base_pathname . '/data/users/_/config.default.php',
		  DATA_PATH . '/users/_/config.default.php');
	// These functions can fail because files have been moved in the 1.7.0
	// version.
	@copy($base_pathname . '/config.default.php',
		  FRESHRSS_PATH . '/config.default.php');
	@copy($base_pathname . '/config-user.default.php',
		  FRESHRSS_PATH . '/config-user.default.php');

	if (function_exists('opcache_reset')) {
		opcache_reset();
	}
	return true;
}


// Remove files of FRSS package.
function clean_package() {
	return del_tree(PACKAGE_PATHNAME);
}


// NOTE: don't remove this close tag!
?>
<?php

define('PACKAGE_URL', 'https://codeload.github.com/FreshRSS/FreshRSS/zip/edge');


// Apply the update by replacing old version of FreshRSS by the new one.
function apply_update() {
	$dirs_to_check = array(
		DATA_PATH,
		DATA_PATH . '/cache',
		DATA_PATH . '/favicons',
		DATA_PATH . '/persona',
		DATA_PATH . '/PubSubHubbub',
		DATA_PATH . '/PubSubHubbub/feeds',
		DATA_PATH . '/PubSubHubbub/keys',
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

function do_post_update() {
	$ok = true;
	return $ok;
}

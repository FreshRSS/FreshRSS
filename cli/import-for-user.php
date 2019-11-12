#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$params = array(
	'user:',
	'filename:',
);

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user']) || empty($options['filename'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username --filename /path/to/file.ext");
}

$username = cliInitUser($options['user']);

$filename = $options['filename'];
if (!is_readable($filename)) {
	fail('FreshRSS error: file is not readable “' . $filename . '”');
}

echo 'FreshRSS importing ZIP/OPML/JSON for user “', $username, "”…\n";

$importController = new importExport_Controller();

$ok = false;
try {
	$ok = $importController->importFile($filename, $filename, $username);
} catch (ZipMissing_Exception $zme) {
	fail('FreshRSS error: Lacking php-zip extension!');
} catch (Zip_Exception $ze) {
	fail('FreshRSS error: ZIP archive cannot be imported! Error code: ' . $ze->zipErrorCode());
}
invalidateHttpCache($username);

done($ok);

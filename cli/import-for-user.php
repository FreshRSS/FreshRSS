#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$options = getopt('', array(
		'user:',
		'filename:',
	));

if (empty($options['user']) || empty($options['filename'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username --filename /path/to/file.ext");
}

$username = cliInitUser($options['user']);

$filename = $options['filename'];
if (!is_readable($filename)) {
	fail('FreshRSS error: file is not readable “' . $filename . '”');
}

echo 'FreshRSS importing ZIP/OPML/JSON for user “', $username, "”…\n";

$importController = new FreshRSS_importExport_Controller();

$ok = false;
try {
	$ok = $importController->importFile($filename, $filename, $username);
} catch (FreshRSS_ZipMissing_Exception $zme) {
	fail('FreshRSS error: Lacking php-zip extension!');
} catch (FreshRSS_Zip_Exception $ze) {
	fail('FreshRSS error: ZIP archive cannot be imported! Error code: ' . $ze->zipErrorCode());
}
invalidateHttpCache($username);

done($ok);

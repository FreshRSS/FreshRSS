#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$params = array(
	'user:',
	'max-feed-entries:',
);

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username ( --max-feed-entries 100 ) > /path/to/file.zip");
}

$username = cliInitUser($options['user']);

fwrite(STDERR, 'FreshRSS exporting ZIP for user “' . $username . "”…\n");

$importController = new FreshRSS_importExport_Controller();

$ok = false;
$number_entries = empty($options['max-feed-entries']) ? 100 : intval($options['max-feed-entries']);
try {
	$ok = $importController->exportFile($username, true, true, true, true, $number_entries);
} catch (FreshRSS_ZipMissing_Exception $zme) {
	fail('FreshRSS error: Lacking php-zip extension!');
}
invalidateHttpCache($username);

done($ok);

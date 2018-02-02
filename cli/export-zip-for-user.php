#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$options = getopt('', array(
		'user:',
		'max-feed-entries:',
	));

if (empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username ( --max-feed-entries 100 ) > /path/to/file.zip");
}

$username = cliInitUser($options['user']);

fwrite(STDERR, 'FreshRSS exporting ZIP for user “' . $username . "”…\n");

$importController = new FreshRSS_importExport_Controller();

$ok = false;
try {
	$ok = $importController->exportFile(true, true, true,
		empty($options['max-feed-entries']) ? 100 : intval($options['max-feed-entries']),
		$username);
} catch (FreshRSS_ZipMissing_Exception $zme) {
	fail('FreshRSS error: Lacking php-zip extension!');
}
invalidateHttpCache($username);

done($ok);

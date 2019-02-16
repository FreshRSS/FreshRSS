#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$options = getopt('', array(
		'user:',
	));

if (empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username > /path/to/file.opml.xml");
}

$username = cliInitUser($options['user']);

fwrite(STDERR, 'FreshRSS exporting OPML for user “' . $username . "”…\n");

$importController = new FreshRSS_importExport_Controller();

$ok = false;
$ok = $importController->exportFile(true, false, false, array(), 0, $username);

invalidateHttpCache($username);

done($ok);

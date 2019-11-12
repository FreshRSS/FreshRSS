#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$params = array(
	'user:',
);

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username > /path/to/file.opml.xml");
}

$username = cliInitUser($options['user']);

fwrite(STDERR, 'FreshRSS exporting OPML for user “' . $username . "”…\n");

$importController = new importExport_Controller();

$ok = false;
$ok = $importController->exportFile(true, false, false, array(), 0, $username);

invalidateHttpCache($username);

done($ok);

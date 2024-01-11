#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$parameters = array(
	'long' => array(
		'user' => ':',
		'filename' => ':',
	),
	'short' => array(),
	'deprecated' => array(),
);

$options = parseCliParams($parameters);

if (!empty($options['invalid'])
	|| empty($options['valid']['user']) || empty($options['valid']['filename'])
	|| !is_string($options['valid']['user']) || !is_string($options['valid']['filename'])
) {
	fail('Usage: ' . basename(__FILE__) . " --user username --filename /path/to/file.ext");
}

$username = cliInitUser($options['valid']['user']);

$filename = $options['valid']['filename'];
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

#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

final class ImportForUserDefinition extends CommandLineParser {
	public string $user;
	public string $filename;

	public function __construct() {
		$this->addRequiredOption('user', (new Option('user')));
		$this->addRequiredOption('filename', (new Option('filename')));
		parent::__construct();
	}
}

$options = new ImportForUserDefinition();

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

$username = cliInitUser($options->user);
$filename = $options->filename;

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

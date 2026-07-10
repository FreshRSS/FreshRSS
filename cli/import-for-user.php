#!/usr/bin/env php
<?php
declare(strict_types=1);

use FreshRss\Controllers\ImportExportController;
use FreshRss\Exceptions\ZipException;
use FreshRss\Exceptions\ZipMissingException;
use FreshRss\Models\Context;

require __DIR__ . '/_cli.php';

performRequirementCheck(Context::systemConf()->db['type'] ?? '');

$cliOptions = new class extends CliOptionsParser {
	public string $user;
	public string $filename;

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		$this->addRequiredOption('filename', (new CliOption('filename')));
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

$username = cliInitUser($cliOptions->user);
$filename = $cliOptions->filename;

if (!is_readable($filename)) {
	fail('FreshRSS error: file is not readable “' . $filename . '”');
}

echo 'FreshRSS importing ZIP/OPML/JSON/TXT for user “', $username, "”…\n";

$importController = new ImportExportController();

$ok = false;
try {
	$ok = $importController->importFile($filename, $filename, $username);
} catch (ZipMissingException) {
	fail('FreshRSS error: Lacking php-zip extension!');
} catch (ZipException $ze) {
	fail('FreshRSS error: ZIP archive cannot be imported! Error code: ' . $ze->zipErrorCode());
}
invalidateHttpCache($username);

done($ok);

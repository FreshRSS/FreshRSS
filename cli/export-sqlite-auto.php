#!/usr/bin/env php
<?php
declare(strict_types=1);
require __DIR__ . '/_cli.php';

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$cliOptions = new class extends CliOptionsParser {
	public bool $quiet;

	public function __construct() {
		$this->addOption('quiet', (new CliOption('quiet', 'q'))->withValueNone());
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

$config = FreshRSS_Context::systemConf()->auto_sqlite_export;
$enabled = !empty($config['enabled']);
$retention = max(1, (int)($config['retention'] ?? 7));
$verbose = !$cliOptions->quiet;

if (!$enabled) {
	if ($verbose) {
		echo "FreshRSS automatic SQLite export is disabled (see `auto_sqlite_export.enabled` in `data/config.php`).\n";
	}
	exit(0);
}

$ok = true;
$timestamp = gmdate('Ymd\THis\Z');

foreach (FreshRSS_user_Controller::listUsers() as $username) {
	$username = cliInitUser($username);
	$exportDir = DATA_PATH . '/users/' . $username . '/sqlite-backups';
	if (!is_dir($exportDir) && !@mkdir($exportDir, 0755, true)) {
		fwrite(STDERR, "FreshRSS error: unable to create export directory: {$exportDir}\n");
		$ok = false;
		continue;
	}

	$filename = $exportDir . '/' . $timestamp . '.sqlite';

	if ($verbose) {
		echo 'FreshRSS automatic SQLite export for user “', $username, '” -> ', $filename, "\n";
	}

	$databaseDAO = FreshRSS_Factory::createDatabaseDAO($username);
	$exported = $databaseDAO->dbCopy($filename, FreshRSS_DatabaseDAO::SQLITE_EXPORT, false, $verbose);
	$ok = $ok && $exported;

	if (!$exported) {
		continue;
	}

	$existing = glob($exportDir . '/*.sqlite') ?: [];
	if (count($existing) > $retention) {
		sort($existing);
		$toDelete = array_slice($existing, 0, count($existing) - $retention);
		foreach ($toDelete as $old) {
			if (@unlink($old)) {
				if ($verbose) {
					echo "Pruned old export: {$old}\n";
				}
			} else {
				fwrite(STDERR, "FreshRSS warning: failed to prune old export: {$old}\n");
			}
		}
	}
}

done($ok);

#!/usr/bin/env php
<?php
declare(strict_types=1);
require __DIR__ . '/_cli.php';

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$cliOptions = new class extends CliOptionsParser {
	public string $user;

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

$username = cliInitUser($cliOptions->user);

echo 'FreshRSS purging old entries for user “', $username, "”…\n";

$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
$databaseDAO->minorDbMaintenance();

$feedDAO = FreshRSS_Factory::createFeedDao();
$feeds = $feedDAO->listFeeds();

$nb_total = 0;
$feedDAO->beginTransaction();
foreach ($feeds as $feed) {
	$nb_total += ($feed->cleanOldEntries() ?: 0);
}
$feedDAO->updateCachedValues();
$feedDAO->commit();

invalidateHttpCache($username);

echo "FreshRSS purged {$nb_total} old entries for {$username}\n";

done(true);

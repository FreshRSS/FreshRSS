#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

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

Minz_ExtensionManager::callHookVoid('freshrss_user_maintenance');

fwrite(STDERR, 'FreshRSS actualizing user “' . $username . "”…\n");

$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
$databaseDAO->minorDbMaintenance();
Minz_ExtensionManager::callHookVoid('freshrss_user_maintenance');

FreshRSS_feed_Controller::commitNewEntries();
$feedDAO = FreshRSS_Factory::createFeedDao();
$feedDAO->updateCachedValues();

$result = FreshRSS_category_Controller::refreshDynamicOpmls();
if (!empty($result['errors'])) {
	$errors = $result['errors'];
	fwrite(STDERR, "FreshRSS error refreshing $errors dynamic OPMLs!\n");
}
if (!empty($result['successes'])) {
	$successes = $result['successes'];
	echo "FreshRSS refreshed $successes dynamic OPMLs for $username\n";
}

[$nbUpdatedFeeds, , $nbNewArticles] = FreshRSS_feed_Controller::actualizeFeedsAndCommit();

echo "FreshRSS actualized $nbUpdatedFeeds feeds for $username ($nbNewArticles new articles)\n";

invalidateHttpCache($username);

done($nbUpdatedFeeds > 0);

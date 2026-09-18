#!/usr/bin/env php
<?php
declare(strict_types=1);
require __DIR__ . '/_cli.php';

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

$cliOptions = new class extends CliOptionsParser {
	public string $user;
	public string $feedId = '';

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		$this->addOption('feedId', (new CliOption('feed-id')));
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}

$username = cliInitUser($cliOptions->user);

$feedId = null;
if ($cliOptions->feedId !== '') {
	$feedId = filter_var($cliOptions->feedId, FILTER_VALIDATE_INT, [
		'options' => ['min_range' => 1],
	]);
	if ($feedId === false) {
		fail('FreshRSS error: Invalid feed ID: ' . $cliOptions->feedId . "\n");
	}
}

Minz_ExtensionManager::callHookVoid(Minz_HookType::FreshrssUserMaintenance);

fwrite(STDERR, 'FreshRSS actualizing user “' . $username . "”…\n");

$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
$databaseDAO->minorDbMaintenance();
Minz_ExtensionManager::callHookVoid(Minz_HookType::FreshrssUserMaintenance);

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

[$nbUpdatedFeeds, , $nbNewArticles] = FreshRSS_feed_Controller::actualizeFeedsAndCommit($feedId);

echo "FreshRSS actualized $nbUpdatedFeeds feeds for $username ($nbNewArticles new articles)\n";

invalidateHttpCache($username);

done($nbUpdatedFeeds > 0);

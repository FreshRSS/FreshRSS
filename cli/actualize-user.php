#!/usr/bin/env php
<?php
declare(strict_types=1);

use FreshRss\Controllers\CategoryController;
use FreshRss\Controllers\FeedController;
use FreshRss\Minz\ExtensionManager;
use FreshRss\Minz\HookType;
use FreshRss\Models\Context;
use FreshRss\Models\Factory;

require __DIR__ . '/_cli.php';

performRequirementCheck(Context::systemConf()->db['type'] ?? '');

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
	if (!is_int($feedId)) {
		fail('FreshRSS error: Invalid feed ID: ' . $cliOptions->feedId . "\n");
	}
}

ExtensionManager::callHookVoid(HookType::FreshrssUserMaintenance);

fwrite(STDERR, 'FreshRSS actualizing user “' . $username . "”…\n");

$databaseDAO = Factory::createDatabaseDAO();
$databaseDAO->minorDbMaintenance();
ExtensionManager::callHookVoid(HookType::FreshrssUserMaintenance);

FeedController::commitNewEntries();
$feedDAO = Factory::createFeedDao();
$feedDAO->updateCachedValues();

$result = CategoryController::refreshDynamicOpmls();
if (!empty($result['errors'])) {
	$errors = $result['errors'];
	fwrite(STDERR, "FreshRSS error refreshing $errors dynamic OPMLs!\n");
}
if (!empty($result['successes'])) {
	$successes = $result['successes'];
	echo "FreshRSS refreshed $successes dynamic OPMLs for $username\n";
}

[$nbUpdatedFeeds, , $nbNewArticles] = FeedController::actualizeFeedsAndCommit($feedId);

echo "FreshRSS actualized $nbUpdatedFeeds feeds for $username ($nbNewArticles new articles)\n";

invalidateHttpCache($username);

done($nbUpdatedFeeds > 0);

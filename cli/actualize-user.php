#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::systemConf()->db['type'] ?? '');

class ActualizeUserDefinition {
	/** @var array<string,string> $errors */
	public array $errors = [];
	public string $usage;
	public string $user;
}

$parser = new CommandLineParser();

$parser->addRequiredOption('user', (new Option('user')));

$options = $parser->parse(ActualizeUserDefinition::class);

if (!empty($options->errors)) {
	fail('FreshRSS error: ' . array_shift($options->errors) . "\n" . $options->usage);
}

$username = cliInitUser($options->user);

Minz_ExtensionManager::callHookVoid('freshrss_user_maintenance');

fwrite(STDERR, 'FreshRSS actualizing user “' . $username . "”…\n");

$result = FreshRSS_category_Controller::refreshDynamicOpmls();
if (!empty($result['errors'])) {
	$errors = $result['errors'];
	fwrite(STDERR, "FreshRSS error refreshing $errors dynamic OPMLs!\n");
}
if (!empty($result['successes'])) {
	$successes = $result['successes'];
	echo "FreshRSS refreshed $successes dynamic OPMLs for $username\n";
}

[$nbUpdatedFeeds, , $nbNewArticles] = FreshRSS_feed_Controller::actualizeFeeds();
if ($nbNewArticles > 0) {
	FreshRSS_feed_Controller::commitNewEntries();
}

echo "FreshRSS actualized $nbUpdatedFeeds feeds for $username ($nbNewArticles new articles)\n";

invalidateHttpCache($username);

done($nbUpdatedFeeds > 0);

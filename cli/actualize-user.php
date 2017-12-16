#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$options = getopt('', array(
		'user:',
	));

if (empty($options['user'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username");
}

$username = cliInitUser($options['user']);

fwrite(STDERR, 'FreshRSS actualizing user “' . $username . "”…\n");

list($nbUpdatedFeeds, $feed, $nbNewArticles) = FreshRSS_feed_Controller::actualizeFeed(0, '', true);

echo "FreshRSS actualized $nbUpdatedFeeds feeds for $username ($nbNewArticles new articles)\n";

invalidateHttpCache($username);

done($nbUpdatedFeeds > 0);

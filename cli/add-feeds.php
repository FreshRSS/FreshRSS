#!/usr/bin/env php
# import feeds from a file
# Assume you installed FreshRSS at /usr/share/FreshRSS and the directory is writable
# Usage: sudo ./cli/add-feeds.php --user jetnews --filename feeds13.url

<?php
require(__DIR__ . '/_cli.php');

performRequirementCheck(FreshRSS_Context::$system_conf->db['type']);

$params = array(
	'user:',
	'filename:',
);

$options = getopt('', $params);

if (!validateOptions($argv, $params) || empty($options['user']) || empty($options['filename'])) {
	fail('Usage: ' . basename(__FILE__) . " --user username --filename /path/to/file.ext");
}

$username = cliInitUser($options['user']);

$filename = $options['filename'];
if (!is_readable($filename)) {
	fail('FreshRSS error: file is not readable “' . $filename . '”');
}

echo 'FreshRSS importing $filename for user “', $username, "”…\n";

// [jv] so we're able to read the file
// [jv] we'll add each feed

$addFeedController = new FreshRSS_feed_Controller();
$attributes = array(
	'ssl_verify' => null,
	'timeout' => null,
	'curl_params' => null,
);

$fp = @fopen($filename, "r");
$ok = true;
if ($fp) {
	while (($url = fgets($fp, 4096)) !== false) {
		echo $url;
		try {
			$feed = $addFeedController->addFeed($url, $title = '', $cat_id = 0, $new_cat_name = '', $http_auth = '', $attributes = array(), $kind = FreshRSS_Feed::KIND_RSS);
		} catch (FreshRSS_BadUrl_Exception $e) {
			// Given url was not a valid url!
			Minz_Log::warning($e->getMessage());
		} catch (FreshRSS_Feed_Exception $e) {
			// Something went bad (timeout, server not found, etc.)
			Minz_Log::warning($e->getMessage());
		} catch (Minz_FileNotExistException $e) {
			// Cache directory doesn’t exist!
			Minz_Log::error($e->getMessage());
		} catch (FreshRSS_AlreadySubscribed_Exception $e) {
			Minz_Log::error($e->getMessage());
		} catch (FreshRSS_FeedNotAdded_Exception $e) {
			Minz_Log::error($e->getMessage());
		}
	}
	if (!feof($fp)) {
		echo "Error: unexpected fgets() fail\n";
		$ok = false;
	}
	fclose($fp);
}
// invalidateHttpCache($username);
        
done($ok);

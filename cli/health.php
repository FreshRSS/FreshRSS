#!/usr/bin/env php
<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
	echo 'Error: This script may only be invoked from command line!', PHP_EOL;
	die(2);
}

$options = getopt('', ['url::', 'connect_timeout::', 'timeout::']);
$address = is_string($options['url'] ?? null) ? $options['url'] : 'http://localhost/i/';
$ch = curl_init($address);
if ($ch === false) {
	fwrite(STDERR, 'Error: Failed to initialize cURL!' . PHP_EOL);
	die(3);
}
curl_setopt_array($ch, [
	CURLOPT_CONNECTTIMEOUT => is_numeric($options['connect_timeout'] ?? null) ? (int)$options['connect_timeout'] : 3,
	CURLOPT_TIMEOUT => is_numeric($options['timeout'] ?? null) ? (int)$options['timeout'] : 5,
	CURLOPT_ENCODING => '',	//Enable all encodings
	CURLOPT_HTTPHEADER => [
		'Connection: close',
	],
	CURLOPT_RETURNTRANSFER => true,
]);
$content = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode !== 200 || !is_string($content) || !str_contains($content, 'jsonVars') || !str_contains($content, '</html>')) {
	die(1);
}

#!/usr/bin/env php
<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
	echo 'Error: This script may only be invoked from command line!', PHP_EOL;
	die(3);
}

$options = getopt('', ['url::', 'connect_timeout::', 'timeout::']);
$address = is_string($options['url'] ?? null) ? $options['url'] : 'http://localhost/api/';
$ch = curl_init($address);
if ($ch === false) {
	fwrite(STDERR, 'Error: Failed to initialize cURL!' . PHP_EOL);
	die(4);
}
curl_setopt_array($ch, [
	CURLOPT_CONNECTTIMEOUT => is_numeric($options['connect_timeout'] ?? null) ? (int)$options['connect_timeout'] : 3,
	CURLOPT_TIMEOUT => is_numeric($options['timeout'] ?? null) ? (int)$options['timeout'] : 5,
	CURLOPT_ACCEPT_ENCODING => '',	//Enable all encodings
	CURLOPT_HTTPHEADER => [
		'Connection: close',
	],
	CURLOPT_RETURNTRANSFER => true,
]);
$content = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode !== 200 || !is_string($content)) {
	die(1);
}

$content = rtrim($content, "\n\r");
if (!str_starts_with($content, '<!DOCTYPE html>') || !str_ends_with($content, '</html>') || !str_contains($content, '/scripts/api.js')) {
	die(2);
}

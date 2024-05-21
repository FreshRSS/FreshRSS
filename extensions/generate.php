#!/usr/bin/env php
<?php

// ------------------- //
// Prepare environment //
// ------------------- //
const VERSION = 0.1;
const TYPE_GIT = 'git';
$tempFolder = './third-party/';

$extensions = [];
$gitRepositories = [];
if (file_exists($tempFolder)) {
	// TODO: Improve by keeping git copy if possible (e.g. fetch + reset)
	exec("rm -rf -- {$tempFolder}");
}

// --------------------------------------------------------------- //
// Parse the repositories.json file to extract extension locations //
// --------------------------------------------------------------- //
try {
	$repositories = json_decode(file_get_contents('repositories.json') ?: '', true, 512, JSON_THROW_ON_ERROR);
	if (!is_array($repositories)) {
		throw new ParseError('Not an array!');
	}
} catch (Exception $exception) {
	echo 'The repositories.json file is not a valid JSON file.', PHP_EOL;
	exit(1);
}

foreach ($repositories as $repository) {
	if (null === $url = ($repository['url'] ?? null)) {
		continue;
	}
	if (TYPE_GIT === ($repository['type'] ?? null)) {
		$gitRepositories[sha1($url)] = $url;
	}
}

// ---------------------------------------- //
// Clone git repository to extract metadata //
// ---------------------------------------- //
foreach ($gitRepositories as $key => $gitRepository) {
	echo 'Processing ', $gitRepository, ' repository', PHP_EOL;
	exec("GIT_TERMINAL_PROMPT=0 git clone --quiet --single-branch --depth 1 --no-tags {$gitRepository} {$tempFolder}/{$key}");

	unset($metadataFiles);
	exec("find {$tempFolder}/{$key} -iname metadata.json", $metadataFiles);
	foreach ($metadataFiles as $metadataFile) {
		try {
			$metadata = json_decode(file_get_contents($metadataFile) ?: '', true, 512, JSON_THROW_ON_ERROR);
			if (!is_array($metadata)) {
				throw new ParseError('Not an array!');
			}
			$directory = basename(dirname($metadataFile));
			$metadata['url'] = $gitRepository;
			$metadata['version'] = strval($metadata['version']);
			$metadata['method'] = TYPE_GIT;
			$metadata['directory'] = ($directory === sha1($gitRepository)) ? '.' : $directory;
			$extensions[] = $metadata;
		} catch (Exception $exception) {
			continue;
		}
	}
}

// --------------- //
// Generate output //
// --------------- //
usort($extensions, function ($a, $b) {
	return $a['name'] <=> $b['name'];
});
$output = [
	'version' => VERSION,
	'extensions' => $extensions,
];
try {
	file_put_contents('extensions.json', json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) . PHP_EOL);

	echo PHP_EOL;
	echo \count($extensions), ' extensions found.', PHP_EOL;
} catch (Exception $exception) {
	echo 'The extensions.json file can not be generated.', PHP_EOL;
	exit(1);
}

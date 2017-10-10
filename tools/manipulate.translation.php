<?php

$options = getopt("h");

if (array_key_exists('h', $options)) {
	help();
}

if (1 === $argc || 4 < $argc) {
	help();
}

require_once __DIR__ . '/I18nFile.php';

$i18nFile = new I18nFile();
$i18nData = $i18nFile->load();

switch ($argv[1]) {
	case 'add_language' :
		$i18nData->addLanguage($argv[2]);
		break;
	case 'add_key' :
		if (3 === $argc) {
			help();
		}
		$i18nData->addKey($argv[2], $argv[3]);
		break;
	case 'duplicate_key' :
		$i18nData->duplicateKey($argv[2]);
		break;
	case 'delete_key' :
		$i18nData->removeKey($argv[2]);
		break;
	default :
		help();
}

if ($i18nData->hasChanged()) {
	$i18nFile->dump($i18nData);
}

/**
 * Output help message.
 */
function help() {
	$help = <<<HELP
NAME
	%s

SYNOPSIS
	php %s [OPTION] [OPERATION] [KEY] [VALUE]

DESCRIPTION
	Manipulate translation files. Available operations are 
	Check if translation files have missing keys or missing translations.

	-h	display this help and exit.

OPERATION
	add_language
		add a new language by duplicating the referential. This operation
		needs only a KEY.

	add_key	add a new key in the referential. This operation needs a KEY and
		a VALUE.

	duplicate_key
		duplicate a referential key in other languages. This operation
		needs only a KEY.

	delete_key
		delete a referential key from all languages. This operation needs
		only a KEY.

HELP;
	$file = str_replace(__DIR__ . '/', '', __FILE__);
	echo sprintf($help, $file, $file);
	exit;
}

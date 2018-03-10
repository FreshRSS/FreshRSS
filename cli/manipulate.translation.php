<?php

$options = getopt("a:hk:l:v:");

if (array_key_exists('h', $options)) {
	help();
}

if (!array_key_exists('a', $options)) {
	error('You need to specify the action to perform.');
}

require_once __DIR__ . '/i18n/I18nFile.php';

$i18nFile = new I18nFile();
$i18nData = $i18nFile->load();

switch ($options['a']) {
	case 'add' :
		if (array_key_exists('k', $options) && array_key_exists('v', $options) && array_key_exists('l', $options)) {
			$i18nData->addValue($options['k'], $options['v'], $options['l']);
		} elseif (array_key_exists('k', $options) && array_key_exists('v', $options)) {
			$i18nData->addKey($options['k'], $options['v']);
		} elseif (array_key_exists('l', $options)) {
			$i18nData->addLanguage($options['l']);
		} else {
			error('You need to specify a valid set of options.');
		}
		break;
	case 'delete' :
		if (array_key_exists('k', $options)) {
			$i18nData->removeKey($options['k']);
		} else {
			error('You need to specify the key to delete.');
		}
		break;
	case 'duplicate' :
		if (array_key_exists('k', $options)) {
			$i18nData->duplicateKey($options['k']);
		} else {
			error('You need to specify the key to duplicate');
		}
		break;
	case 'format' :
		$i18nFile->dump($i18nData);
		break;
	default :
		help();
}

if ($i18nData->hasChanged()) {
	$i18nFile->dump($i18nData);
}

/**
 * Output error message.
 */
function error($message) {
	$error = <<<ERROR
WARNING
	%s\n\n
ERROR;
	echo sprintf($error, $message);
	help();
}

/**
 * Output help message.
 */
function help() {
	$help = <<<HELP
NAME
	%1\$s

SYNOPSIS
	php %1\$s [OPTIONS]

DESCRIPTION
	Manipulate translation files.

	-a=ACTION
		select the action to perform. Available actions are add, delete,
		duplicate, and format. This option is mandatory.
	-k=KEY	select the key to work on.
	-v=VAL	select the value to set.
	-l=LANG	select the language to work on.
	-h	display this help and exit.

EXEMPLE
Exemple 1: add a language. It adds a new language by duplicating the referential.
	php %1\$s -a add -l my_lang

Exemple 2: add a new key. It adds the key in the referential.
	php %1\$s -a add -k my_key -v my_value

Exemple 3: add a new value. It adds a new value for the selected key in the selected language.
	php %1\$s -a add -k my_key -v my_value -l my_lang

Exemple 4: delete a key. It deletes the selected key in every languages.
	php %1\$s -a delete -k my_key

Exemple 5: duplicate a key. It duplicates the key from the referential in every languages.
	php %1\$s -a duplicate -k my_key

Exemple 6: format i18n files.
	php %1\$s -a format

HELP;
	$file = str_replace(__DIR__ . '/', '', __FILE__);
	echo sprintf($help, $file);
	exit;
}

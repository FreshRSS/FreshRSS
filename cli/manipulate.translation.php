#!/usr/bin/env php
<?php

require_once __DIR__ . '/i18n/I18nData.php';
require_once __DIR__ . '/i18n/I18nFile.php';
require_once __DIR__ . '/i18n/I18nIgnoreFile.php';

$options = getopt("a:hk:l:o:rv:");

if (array_key_exists('h', $options)) {
	help();
}

if (!array_key_exists('a', $options)) {
	error('You need to specify the action to perform.');
}

$data = new I18nFile();
$ignore = new I18nIgnoreFile();
$i18nData = new I18nData($data->load(), $ignore->load());

switch ($options['a']) {
	case 'add' :
		if (array_key_exists('k', $options) && array_key_exists('v', $options) && array_key_exists('l', $options)) {
			$i18nData->addValue($options['k'], $options['v'], $options['l']);
		} elseif (array_key_exists('k', $options) && array_key_exists('v', $options)) {
			$i18nData->addKey($options['k'], $options['v']);
		} elseif (array_key_exists('l', $options)) {
			$reference = null;
			if (array_key_exists('o', $options) && is_string($options['o'])) {
				$reference = $options['o'];
			}
			$i18nData->addLanguage($options['l'], $reference);
		} else {
			error('You need to specify a valid set of options.');
			exit;
		}
		break;
	case 'delete' :
		if (array_key_exists('k', $options)) {
			$i18nData->removeKey($options['k']);
		} else {
			error('You need to specify the key to delete.');
			exit;
		}
		break;
	case 'exist':
		if (array_key_exists('k', $options)) {
			$key = $options['k'];
			if ($i18nData->isKnown($key)) {
				echo "The '{$key}' key is known.\n\n";
			} else {
				echo "The '{$key}' key is unknown.\n\n";
			}
		} else {
			error('You need to specify the key to check.');
			exit;
		}
		break;
	case 'format' :
		break;
	case 'ignore' :
		if (array_key_exists('l', $options) && array_key_exists('k', $options)) {
			$i18nData->ignore($options['k'], $options['l'], array_key_exists('r', $options));
		} else {
			error('You need to specify a valid set of options.');
			exit;
		}
		break;
	case 'ignore_unmodified' :
		if (array_key_exists('l', $options)) {
			$i18nData->ignore_unmodified($options['l'], array_key_exists('r', $options));
		} else {
			error('You need to specify a valid set of options.');
			exit;
		}
		break;
	default :
		help();
		exit;
}

$data->dump($i18nData->getData());
$ignore->dump($i18nData->getIgnore());

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
		exist, format, and ignore. This option is mandatory.
	-k=KEY	select the key to work on.
	-v=VAL	select the value to set.
	-l=LANG	select the language to work on.
	-h	display this help and exit.
	-r revert the action (only for ignore action)
	-o=LANG select the origin language (only for add language action)

EXEMPLE
Exemple 1: add a language. It adds a new language by duplicating the referential.
	php %1\$s -a add -l my_lang
	php %1\$s -a add -l my_lang -o ref_lang

Exemple 2: add a new key. It adds the key for all supported languages.
	php %1\$s -a add -k my_key -v my_value

Exemple 3: add a new value. It adds a new value for the selected key in the selected language.
	php %1\$s -a add -k my_key -v my_value -l my_lang

Exemple 4: delete a key. It deletes the selected key from all supported languages.
	php %1\$s -a delete -k my_key

Exemple 5: format i18n files.
	php %1\$s -a format

Exemple 6: ignore a key. It adds the key in the ignore file to mark it as translated.
	php %1\$s -a ignore -k my_key -l my_lang

Exemple 7: revert ignore a key. It removes the key from the ignore file.
	php %1\$s -a ignore -r -k my_key -l my_lang

Exemple 8: ignore all unmodified keys. It adds all modified keys in the ignore file to mark it as translated.
	php %1\$s -a ignore_unmodified -l my_lang

Exemple 9: revert ignore of all unmodified keys. It removes the unmodified keys from the ignore file.  Warning, this will also revert keys added individually.
	php %1\$s -a ignore_unmodified -r -l my_lang

Exemple 10: check if a key exist.
	php %1\$s -a exist -k my_key\n\n

HELP;
	$file = str_replace(__DIR__ . '/', '', __FILE__);
	echo sprintf($help, $file);
	exit;
}

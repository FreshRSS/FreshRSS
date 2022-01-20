#!/usr/bin/env php
<?php

require_once __DIR__ . '/i18n/I18nData.php';
require_once __DIR__ . '/i18n/I18nFile.php';

$options = getopt("a:hk:l:o:rv:");

if (array_key_exists('h', $options)) {
	help();
}

if (!array_key_exists('a', $options)) {
	error('You need to specify the action to perform.');
}

$data = new I18nFile();
$i18nData = new I18nData($data->load());

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
	$file = str_replace(__DIR__ . '/', '', __FILE__);
	echo <<<HELP
NAME
	$file

SYNOPSIS
	php $file [OPTIONS]

DESCRIPTION
	Manipulate translation files.

	-a=ACTION
		select the action to perform. Available actions are add, delete,
		exist, format, ignore, and ignore_unmodified. This option is mandatory.
	-k=KEY	select the key to work on.
	-v=VAL	select the value to set.
	-l=LANG	select the language to work on.
	-h	display this help and exit.
	-r revert the action (only for ignore action)
	-o=LANG select the origin language (only for add language action)

EXAMPLES
Example 1: add a language. It adds a new language by duplicating the referential.
	php $file -a add -l my_lang
	php $file -a add -l my_lang -o ref_lang

Example 2: add a new key. It adds the key for all supported languages.
	php $file -a add -k my_key -v my_value

Example 3: add a new value. It adds a new value for the selected key in the selected language.
	php $file -a add -k my_key -v my_value -l my_lang

Example 4: delete a key. It deletes the selected key from all supported languages.
	php $file -a delete -k my_key

Example 5: format i18n files.
	php $file -a format

Example 6: ignore a key. It adds the key in the ignore file to mark it as translated.
	php $file -a ignore -k my_key -l my_lang

Example 7: revert ignore a key. It removes the key from the ignore file.
	php $file -a ignore -r -k my_key -l my_lang

Example 8: ignore all unmodified keys. It adds all modified keys in the ignore file to mark it as translated.
	php $file -a ignore_unmodified -l my_lang

Example 9: revert ignore of all unmodified keys. It removes the unmodified keys from the ignore file.  Warning, this will also revert keys added individually.
	php $file -a ignore_unmodified -r -l my_lang

Example 10: check if a key exist.
	php $file -a exist -k my_key\n\n

HELP;
}

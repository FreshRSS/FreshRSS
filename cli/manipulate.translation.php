#!/usr/bin/env php
<?php
declare(strict_types=1);
require_once __DIR__ . '/_cli.php';
require_once __DIR__ . '/i18n/I18nData.php';
require_once __DIR__ . '/i18n/I18nFile.php';
require_once __DIR__ . '/../constants.php';

$parameters = [
	'long' => [
		'action' => ':',
		'help' => '',
		'key' => ':',
		'language' => ':',
		'origin-language' => ':',
		'revert' => '',
		'value' => ':',
	],
	'short' => [
		'action' => 'a',
		'help' => 'h',
		'key' => 'k',
		'language' => 'l',
		'origin-language' => 'o',
		'revert' => 'r',
		'value' => 'v',
	],
	'deprecated' => [],
];

$options = parseCliParams($parameters);

if (!empty($options['invalid']) || array_key_exists('help', $options['valid'])) {
	manipulateHelp();
	exit();
}

if (!array_key_exists('action', $options['valid'])) {
	error('You need to specify the action to perform.');
}

$data = new I18nFile();
$i18nData = new I18nData($data->load());

switch ($options['valid']['action']) {
	case 'add' :
		if (array_key_exists('key', $options['valid']) && array_key_exists('value', $options['valid']) && array_key_exists('language', $options['valid'])) {
			$i18nData->addValue($options['valid']['key'], $options['valid']['value'], $options['valid']['language']);
		} elseif (array_key_exists('key', $options['valid']) && array_key_exists('value', $options['valid'])) {
			$i18nData->addKey($options['valid']['key'], $options['valid']['value']);
		} elseif (array_key_exists('language', $options['valid'])) {
			$reference = null;
			if (array_key_exists('origin-language', $options['valid'])) {
				$reference = $options['valid']['origin-language'];
			}
			$i18nData->addLanguage($options['valid']['language'], $reference);
		} else {
			error('You need to specify a valid set of options.');
			exit;
		}
		break;
	case 'delete' :
		if (array_key_exists('key', $options['valid'])) {
			$i18nData->removeKey($options['valid']['key']);
		} else {
			error('You need to specify the key to delete.');
			exit;
		}
		break;
	case 'exist':
		if (array_key_exists('key', $options['valid'])) {
			$key = $options['valid']['key'];
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
		if (array_key_exists('language', $options['valid']) && array_key_exists('key', $options['valid'])) {
			$i18nData->ignore($options['valid']['key'], $options['valid']['language'], array_key_exists('revert', $options['valid']));
		} else {
			error('You need to specify a valid set of options.');
			exit;
		}
		break;
	case 'ignore_unmodified' :
		if (array_key_exists('language', $options['valid'])) {
			$i18nData->ignore_unmodified($options['valid']['language'], array_key_exists('revert', $options['valid']));
		} else {
			error('You need to specify a valid set of options.');
			exit;
		}
		break;
	default :
		manipulateHelp();
		exit;
}

$data->dump($i18nData->getData());

/**
 * Output error message.
 */
function error(string $message): void {
	$error = <<<ERROR
WARNING
	%s\n\n
ERROR;
	echo sprintf($error, $message);
	manipulateHelp();
}

/**
 * Output help message.
 */
function manipulateHelp(): void {
	$file = str_replace(__DIR__ . '/', '', __FILE__);
	echo <<<HELP
NAME
	$file

SYNOPSIS
	php $file [OPTIONS]

DESCRIPTION
	Manipulate translation files.

	-a, --action=ACTION
				select the action to perform. Available actions are add, delete,
				exist, format, ignore, and ignore_unmodified. This option is mandatory.
	-k, --key=KEY		select the key to work on.
	-v, --value=VAL		select the value to set.
	-l, --language=LANG	select the language to work on.
	-h, --help		display this help and exit.
	-r, --revert		revert the action (only for ignore action)
	-o, origin-language=LANG
				select the origin language (only for add language action)

EXAMPLES
Example 1:	add a language. It adds a new language by duplicating the referential.
	php $file -a add -l my_lang
	php $file -a add -l my_lang -o ref_lang

Example 2:	add a new key. It adds the key for all supported languages.
	php $file -a add -k my_key -v my_value

Example 3:	add a new value. It adds a new value for the selected key in the selected language.
	php $file -a add -k my_key -v my_value -l my_lang

Example 4:	delete a key. It deletes the selected key from all supported languages.
	php $file -a delete -k my_key

Example 5:	format i18n files.
	php $file -a format

Example 6:	ignore a key. Adds IGNORE comment to the key in the selected language, marking it as translated.
	php $file -a ignore -k my_key -l my_lang

Example 7:	revert ignore a key. Removes IGNORE comment from the key in the selected language.
	php $file -a ignore -r -k my_key -l my_lang

Example 8:	ignore all unmodified keys. Adds IGNORE comments to all unmodified keys in the selected language, marking them as translated.
	php $file -a ignore_unmodified -l my_lang

Example 9:	revert ignore on all unmodified keys. Removes IGNORE comments from all unmodified keys in the selected language.
		Warning: will also revert individually added unmodified keys.
	php $file -a ignore_unmodified -r -l my_lang

Example 10:	check if a key exist.
	php $file -a exist -k my_key\n\n

HELP;
}

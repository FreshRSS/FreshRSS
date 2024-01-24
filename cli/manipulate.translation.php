#!/usr/bin/env php
<?php
declare(strict_types=1);
require_once __DIR__ . '/_cli.php';
require_once __DIR__ . '/i18n/I18nData.php';
require_once __DIR__ . '/i18n/I18nFile.php';
require_once __DIR__ . '/../constants.php';

$data = new I18nFile();
$i18nData = new I18nData($data->load());

/** @var array<string,array{'getopt':string,'required':bool,'short':string,'deprecated':string,'read':callable,
 * 'validators':array<callable>}> $parameters */
$parameters = [
	'action' => [
		'getopt' => ':',
		'required' => true,
		'short' => 'a',
		'validators' => [
			validateOneOf(['add', 'delete', 'exist', 'format', 'ignore', 'ignore_unmodified'], 'translation action'),
		]
	],
	'help' => [
		'getopt' => '',
		'required' => false,
		'short' => 'h',
	],
	'key' => [
		'getopt' => ':',
		'required' => false,
		'short' => 'k',
	],
	'language' => [
		'getopt' => ':',
		'required' => false,
		'short' => 'l',
		'validators' => [
			validateOneOf($i18nData->getAvailableLanguages(), 'language setting', 'an iso 639-1 code for a supported language')
		],
	],
	'origin-language' => [
		'getopt' => ':',
		'required' => false,
		'short' => 'o',
		'validators' => [
			validateOneOf($i18nData->getAvailableLanguages(), 'origin language', 'an iso 639-1 code for a supported language')
		],
	],
	'revert' => [
		'getopt' => '',
		'required' => false,
		'short' => 'r',
	],
	'value' => [
		'getopt' => ':',
		'required' => false,
		'short' => 'v',
	],
];

$options = parseAndValidateCliParams($parameters);

$error = empty($options['invalid']) ? 0 : 1;
if (key_exists('help', $options['valid']) || $error) {
	$error ? fwrite(STDERR, "\nFreshRSS error: " . current($options['invalid']) . "\n\n") : '';
	manipulateHelp($error);
}

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
	manipulateHelp(1);
}

/**
 * Output help message.
 */
function manipulateHelp(int $exitCode = 0): void {
	$file = str_replace(__DIR__ . '/', '', __FILE__);

	echo <<<HELP
NAME
	$file

SYNOPSIS
	php $file [OPTIONS]

DESCRIPTION
	Manipulate translation files.

	-a, --action=<action>
		sets the action to perform.
		---
		options:
			- add
			- delete
			- exist
			- format
			- ignore
			- ignore_unmodified
		---

	[-k, --key=<key>]
		sets the key to work on.

	[-v, --value=<value>]
		sets the value to use.

	[-l, --language=<language>]
		sets the language to work on.

	[-h, --help]
		display this help and exit.

	[-r, --revert]
		revert the action (only used with the ignore action)

	[-o, --origin-language=<language>]
		sets the origin language (only used with the add language action)

EXAMPLES
Example 1:	add a language. Adds a new language by duplicating the reference language.
	php $file -a add -l my_lang
	php $file -a add -l my_lang -o ref_lang

Example 2:	add a new key. Adds a key to all supported languages.
	php $file -a add -k my_key -v my_value

Example 3:	add a new value. Sets a new value for the selected key in the selected language.
	php $file -a add -k my_key -v my_value -l my_lang

Example 4:	delete a key. Deletes the selected key from all supported languages.
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
		Warning: will also revert individually added IGNOREs on unmodified keys.
	php $file -a ignore_unmodified -r -l my_lang

Example 10:	check if a key exist.
	php $file -a exist -k my_key

HELP;
	exit($exitCode);
}

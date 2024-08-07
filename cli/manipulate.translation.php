#!/usr/bin/env php
<?php
declare(strict_types=1);
require_once __DIR__ . '/_cli.php';
require_once __DIR__ . '/i18n/I18nData.php';
require_once __DIR__ . '/i18n/I18nFile.php';
require_once __DIR__ . '/../constants.php';

$cliOptions = new class extends CliOptionsParser {
	public string $action;
	public string $key;
	public string $value;
	public string $language;
	public string $originLanguage;
	public string $revert;
	public string $help;

	public function __construct() {
		$this->addRequiredOption('action', (new CliOption('action', 'a')));
		$this->addOption('key', (new CliOption('key', 'k')));
		$this->addOption('value', (new CliOption('value', 'v')));
		$this->addOption('language', (new CliOption('language', 'l')));
		$this->addOption('originLanguage', (new CliOption('origin-language', 'o')));
		$this->addOption('revert', (new CliOption('revert', 'r'))->withValueNone());
		$this->addOption('help', (new CliOption('help', 'h'))->withValueNone());
		parent::__construct();
	}
};

if (!empty($cliOptions->errors)) {
	fail('FreshRSS error: ' . array_shift($cliOptions->errors) . "\n" . $cliOptions->usage);
}
if (isset($cliOptions->help)) {
	manipulateHelp();
}

$data = new I18nFile();
$i18nData = new I18nData($data->load());

switch ($cliOptions->action) {
	case 'add':
		if (isset($cliOptions->key) && isset($cliOptions->value) && isset($cliOptions->language)) {
			$i18nData->addValue($cliOptions->key, $cliOptions->value, $cliOptions->language);
		} elseif (isset($cliOptions->key) && isset($cliOptions->value)) {
			$i18nData->addKey($cliOptions->key, $cliOptions->value);
		} elseif (isset($cliOptions->language)) {
			$reference = null;
			if (isset($cliOptions->originLanguage)) {
				$reference = $cliOptions->originLanguage;
			}
			$i18nData->addLanguage($cliOptions->language, $reference);
		} else {
			error('You need to specify a valid set of options.');
			exit;
		}
		break;
	case 'delete':
		if (isset($cliOptions->key)) {
			$i18nData->removeKey($cliOptions->key);
		} else {
			error('You need to specify the key to delete.');
			exit;
		}
		break;
	case 'exist':
		if (isset($cliOptions->key)) {
			$key = $cliOptions->key;
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
	case 'format':
		break;
	case 'ignore':
		if (isset($cliOptions->language) && isset($cliOptions->key)) {
			$i18nData->ignore($cliOptions->key, $cliOptions->language, isset($cliOptions->revert));
		} else {
			error('You need to specify a valid set of options.');
			exit;
		}
		break;
	case 'ignore_unmodified':
		if (isset($cliOptions->language)) {
			$i18nData->ignore_unmodified($cliOptions->language, isset($cliOptions->revert));
		} else {
			error('You need to specify a valid set of options.');
			exit;
		}
		break;
	default:
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
		Warning: will also revert individually added IGNORE(s) on unmodified keys.
	php $file -a ignore_unmodified -r -l my_lang

Example 10:	check if a key exist.
	php $file -a exist -k my_key

HELP;
	exit();
}

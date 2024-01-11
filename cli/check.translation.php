#!/usr/bin/env php
<?php
declare(strict_types=1);
require_once __DIR__ . '/_cli.php';
require_once __DIR__ . '/i18n/I18nCompletionValidator.php';
require_once __DIR__ . '/i18n/I18nData.php';
require_once __DIR__ . '/i18n/I18nFile.php';
require_once __DIR__ . '/i18n/I18nUsageValidator.php';
require_once __DIR__ . '/../constants.php';

$i18nFile = new I18nFile();
$i18nData = new I18nData($i18nFile->load());

$parameters = array(
	'long' => array(
		'display-result' => '',
		'help' => '',
		'language' => ':',
		'display-report' => '',
	),
	'short' => array(
		'display-result' => 'd',
		'help' => 'h',
		'language' => 'l',
		'display-report' => 'r',
	),
	'deprecated' => array(),
);

$options = parseCliParams($parameters);

if (!empty($options['invalid']) || array_key_exists('help', $options['valid'])) {
	checkHelp();
}

if (array_key_exists('language', $options['valid'])) {
	$languages = array($options['valid']['language']);
} else {
	$languages = $i18nData->getAvailableLanguages();
}
$displayResults = array_key_exists('display-result', $options['valid']);
$displayReport = array_key_exists('display-report', $options['valid']);

$isValidated = true;
$result = [];
$report = [];

foreach ($languages as $language) {
	if ($language === $i18nData::REFERENCE_LANGUAGE) {
		$i18nValidator = new I18nUsageValidator($i18nData->getReferenceLanguage(), findUsedTranslations());
	} else {
		$i18nValidator = new I18nCompletionValidator($i18nData->getReferenceLanguage(), $i18nData->getLanguage($language));
	}
	$isValidated = $i18nValidator->validate() && $isValidated;

	$report[$language] = sprintf('%-5s - %s', $language, $i18nValidator->displayReport());
	$result[$language] = $i18nValidator->displayResult();
}

if ($displayResults) {
	foreach ($result as $lang => $value) {
		echo 'Language: ', $lang, PHP_EOL;
		print_r($value);
		echo PHP_EOL;
	}
}

if ($displayReport) {
	foreach ($report as $value) {
		echo $value;
	}
}

if (!$isValidated) {
	exit(1);
}

/**
 * Find used translation keys in the project
 *
 * Iterates through all php and phtml files in the whole project and extracts all
 * translation keys used.
 *
 * @return array<string>
 */
function findUsedTranslations(): array {
	$directory = new RecursiveDirectoryIterator(__DIR__ . '/..');
	$iterator = new RecursiveIteratorIterator($directory);
	$regex = new RegexIterator($iterator, '/^.+\.(php|phtml)$/i', RecursiveRegexIterator::GET_MATCH);
	$usedI18n = [];
	foreach (array_keys(iterator_to_array($regex)) as $file) {
		$fileContent = file_get_contents($file);
		if ($fileContent === false) {
			continue;
		}
		preg_match_all('/_t\([\'"](?P<strings>[^\'"]+)[\'"]/', $fileContent, $matches);
		$usedI18n = array_merge($usedI18n, $matches['strings']);
	}
	return $usedI18n;
}

/**
 * Output help message.
 * @return never
 */
function checkHelp() {
	$file = str_replace(__DIR__ . '/', '', __FILE__);

	echo <<<HELP
NAME
	$file

SYNOPSIS
	php $file [OPTION]...

DESCRIPTION
	Check if translation files have missing keys or missing translations.

	-d, --display-result	display results.
	-h,	--help				display this help and exit.
	-l, --language=LANG		filter by LANG.
	-r, --display-report	display completion report.

HELP;
	exit;
}

#!/usr/bin/env php
<?php
declare(strict_types=1);

require_once __DIR__ . '/_cli.php';
require_once __DIR__ . '/i18n/I18nCompletionValidator.php';
require_once __DIR__ . '/i18n/I18nData.php';
require_once __DIR__ . '/i18n/I18nFile.php';
require_once __DIR__ . '/i18n/I18nUsageValidator.php';
require_once __DIR__ . '/../constants.php';

 /** @var array<string,array{'getopt':string,'required':bool,'default':string,'short':string,'deprecated':string,
 * 'read':callable,'validators':array<callable>}> $parameters */
$parameters = [
	'display-result' => [
		'getopt' => '',
		'required' => false,
		'short' => 'd',
	],
	'help' => [
		'getopt' => '',
		'required' => false,
		'short' => 'h',
	],
	'language' => [
		'getopt' => ':',
		'required' => false,
		'short' => 'l',
		'validators' => [
			validateOneOf(listLanguages(), 'language setting', 'an iso 639-1 code for a supported language')
		],
	],
	'display-report' => [
		'getopt' => '',
		'required' => false,
		'short' => 'r',
	],
];

$options = parseAndValidateCliParams($parameters);

$error = empty($options['invalid']) ? 0 : 1;
if (key_exists('help', $options['valid']) || $error) {
	$error ? fwrite(STDERR, "\nFreshRSS error: " . current($options['invalid']) . "\n\n") : '';
	checkHelp($error);
}

$i18nFile = new I18nFile();
$i18nData = new I18nData($i18nFile->load());

if (array_key_exists('language', $options['valid'])) {
	$languages = [$options['valid']['language']];
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
function checkHelp(int $exitCode = 0) {
	$file = str_replace(__DIR__ . '/', '', __FILE__);

	echo <<<HELP
NAME
	$file

SYNOPSIS
	php $file [OPTION]...

DESCRIPTION
	Check if translation files have missing keys or missing translations.

	[-d, --display-result]
		displays results.

	[-h, --help]
		displays this help text.

	[-l, --language=<language>]
		filters by <language>.

	[-r, --display-report]
		displays completion report.

HELP;
	exit($exitCode);
}

#!/usr/bin/env php
<?php

require_once __DIR__ . '/i18n/I18nCompletionValidator.php';
require_once __DIR__ . '/i18n/I18nData.php';
require_once __DIR__ . '/i18n/I18nFile.php';
require_once __DIR__ . '/i18n/I18nUsageValidator.php';

$i18nFile = new I18nFile();
$i18nData = new I18nData($i18nFile->load());

$options = getopt("dhl:r");

if (array_key_exists('h', $options)) {
	help();
}
if (array_key_exists('l', $options)) {
	$languages = array($options['l']);
} else {
	$languages = $i18nData->getAvailableLanguages();
}
$displayResults = array_key_exists('d', $options);
$displayReport = array_key_exists('r', $options);

$isValidated = true;
$result = array();
$report = array();

foreach ($languages as $language) {
	if ($language === $i18nData::REFERENCE_LANGUAGE) {
		$i18nValidator = new I18nUsageValidator($i18nData->getReferenceLanguage(), findUsedTranslations());
		$isValidated = $i18nValidator->validate() && $isValidated;
	} else {
		$i18nValidator = new I18nCompletionValidator($i18nData->getReferenceLanguage(), $i18nData->getLanguage($language));
		$isValidated = $i18nValidator->validate() && $isValidated;
	}

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
 * @return array
 */
function findUsedTranslations() {
	$directory = new RecursiveDirectoryIterator(__DIR__ . '/..');
	$iterator = new RecursiveIteratorIterator($directory);
	$regex = new RegexIterator($iterator, '/^.+\.(php|phtml)$/i', RecursiveRegexIterator::GET_MATCH);
	$usedI18n = array();
	foreach (array_keys(iterator_to_array($regex)) as $file) {
		$fileContent = file_get_contents($file);
		preg_match_all('/_t\([\'"](?P<strings>[^\'"]+)[\'"]/', $fileContent, $matches);
		$usedI18n = array_merge($usedI18n, $matches['strings']);
	}
	return $usedI18n;
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
	php $file [OPTION]...

DESCRIPTION
	Check if translation files have missing keys or missing translations.

	-d	display results.
	-h	display this help and exit.
	-l=LANG	filter by LANG.
	-r	display completion report.

HELP;
	exit;
}

<?php

$options = getopt("dhl:r");

$ignore = include __DIR__ . '/translation.ignore.php';

if (array_key_exists('h', $options)) {
	help();
}
if (array_key_exists('l', $options)) {
	$langPattern = sprintf('/%s/', $options['l']);
} else {
	$langPattern = '/*/';
}
$displayErrors = array_key_exists('d', $options);
$displayReport = array_key_exists('r', $options);

$i18nPath = __DIR__ . '/../app/i18n/';
$errors = array();
$report = array();

foreach (glob($i18nPath . 'en/*.php') as $i18nFileReference) {
	$en = flatten(include $i18nFileReference);
	foreach (glob(str_replace('/en/', $langPattern, $i18nFileReference)) as $i18nFile) {
		preg_match('#(?P<lang>[^/]+)/(?P<file>[^/]*.php)#', $i18nFile, $matches);
		$lang = $matches['lang'];
		$file = $matches['file'];
		if ('en' === $lang) {
			continue;
		}
		if (!array_key_exists($lang, $report)) {
			$report[$lang]['total'] = 0;
			$report[$lang]['errors'] = 0;
		}
		$i18n = flatten(include $i18nFile);
		foreach ($en as $key => $value) {
			$report[$lang]['total'] ++;
			if (array_key_exists($lang, $ignore) && array_key_exists($file, $ignore[$lang]) && in_array($key, $ignore[$lang][$file])) {
				continue;
			}
			if (!array_key_exists($key, $i18n)) {
				$errors[$lang][$file][] = sprintf('Missing key %s', $key);
				$report[$lang]['errors'] ++;
				continue;
			}
			if ($i18n[$key] === $value) {
				$errors[$lang][$file][] = sprintf('Untranslated key %s - %s', $key, $value);
				$report[$lang]['errors'] ++;
				continue;
			}
		}
	}
}

if ($displayErrors) {
	foreach ($errors as $lang => $value) {
		echo 'Language: ', $lang, PHP_EOL;
		foreach ($value as $file => $messages) {
			echo '    - File: ', $file, PHP_EOL;
			foreach ($messages as $message) {
				echo '        - ', $message, PHP_EOL;
			}
		}
		echo PHP_EOL;
	}
}

if ($displayReport) {
	foreach ($report as $lang => $value) {
		$completion = ($value['total'] - $value['errors']) / $value['total'] * 100;
		echo sprintf('Translation for %-5s is %5.1f%% complete.', $lang, $completion), PHP_EOL;
	}
}

if (!empty($errors)) {
	exit(1);
}

/**
 * Flatten an array of translation
 *
 * @param array $translation
 * @param string $prependKey
 * @return array
 */
function flatten($translation, $prependKey = '') {
	$a = array();

	if ('' !== $prependKey) {
		$prependKey .= '.';
	}

	foreach ($translation as $key => $value) {
		if (is_array($value)) {
			$a += flatten($value, $prependKey . $key);
		} else {
			$a[$prependKey . $key] = $value;
		}
	}

	return $a;
}

/**
 * Output help message.
 */
function help() {
	$help = <<<HELP
NAME
	%s

SYNOPSIS
	php %s [OPTION]...

DESCRIPTION
	Check if translation files have missing keys or missing translations.

	-d	display results.
	-h	display this help and exit.
	-l=LANG	filter by LANG.
	-r	display completion report.

HELP;
	$file = str_replace(__DIR__ . '/', '', __FILE__);
	echo sprintf($help, $file, $file);
	exit;
}

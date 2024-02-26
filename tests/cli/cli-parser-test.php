#!/usr/bin/env php
<?php
declare(strict_types=1);

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/CliOptionsParserTest.php');

$optionsClass = getenv('CLI_PARSER_TEST_OPTIONS_CLASS');
if (!is_string($optionsClass) || !class_exists($optionsClass)) {
	die('Invalid test static method!');
}

switch ($optionsClass) {
	case CliOptionsOptionalTest::class:
		$options = new CliOptionsOptionalTest();
		break;
	case CliOptionsOptionalAndRequiredTest::class:
		$options = new CliOptionsOptionalAndRequiredTest();
		break;
	default:
		die('Unknown test static method!');
}

echo serialize($options);

#!/usr/bin/env php
<?php
declare(strict_types=1);

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/CommandLineParserTest.php');

$optionsClass = getenv('CLI_PARSER_TEST_OPTIONS_CLASS');
if (!is_string($optionsClass) || !class_exists($optionsClass)) {
	die('Invalid test static method!');
}

switch ($optionsClass) {
	case 'OptionalOptionsDefinition':
		$options = new OptionalOptionsDefinition();
		break;
	case 'OptionalAndRequiredOptionsDefinition':
		$options = new OptionalAndRequiredOptionsDefinition();
		break;
	default:
		die('Unknown test static method!');
}

echo serialize($options);

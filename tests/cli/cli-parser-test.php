#!/usr/bin/env php
<?php
declare(strict_types=1);

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/CommandLineParserTest.php');

$static_method = getenv('CLI_PARSER_TEST_STATIC_METHOD');

// @phpstan-ignore-next-line
echo serialize(CommandLineParserTest::$static_method());

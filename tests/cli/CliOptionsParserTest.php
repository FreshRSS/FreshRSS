<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
require_once dirname(__DIR__, 2) . '/cli/CliOption.php';
require_once dirname(__DIR__, 2) . '/cli/CliOptionsParser.php';

final class CliOptionsOptionalTest extends CliOptionsParser {
	public string $string = '';
	public int $int = 0;
	public bool $bool = false;
	/** @var array<int,string> $arrayOfString */
	public array $arrayOfString = [];
	public string $defaultInput = '';
	public string $optionalValue = '';
	public bool $optionalValueWithDefault = false;
	public string $defaultInputAndOptionalValueWithDefault = '';
	public bool $flag = false;

	public function __construct() {
		$this->addOption('string', (new CliOption('string', 's'))->deprecatedAs('deprecated-string'));
		$this->addOption('int', (new CliOption('int', 'i'))->typeOfInt());
		$this->addOption('bool', (new CliOption('bool', 'b'))->typeOfBool());
		$this->addOption('arrayOfString', (new CliOption('array-of-string', 'a'))->typeOfArrayOfString());
		$this->addOption('defaultInput', (new CliOption('default-input', 'i')), 'default');
		$this->addOption('optionalValue', (new CliOption('optional-value', 'o'))->withValueOptional());
		$this->addOption('optionalValueWithDefault', (new CliOption('optional-value-with-default', 'd'))->withValueOptional('true')->typeOfBool());
		$this->addOption('defaultInputAndOptionalValueWithDefault',
			(new CliOption('default-input-and-optional-value-with-default', 'e'))->withValueOptional('optional'),
			'default'
		);
		$this->addOption('flag', (new CliOption('flag', 'f'))->withValueNone());
		parent::__construct();
	}
}

final class CliOptionsOptionalAndRequiredTest extends CliOptionsParser {
	public string $required = '';
	public string $string = '';
	public int $int = 0;
	public bool $bool = false;
	public bool $flag = false;

	public function __construct() {
		$this->addRequiredOption('required', new CliOption('required'));
		$this->addOption('string', new CliOption('string', 's'));
		$this->addOption('int', (new CliOption('int', 'i'))->typeOfInt());
		$this->addOption('bool', (new CliOption('bool', 'b'))->typeOfBool());
		$this->addOption('flag', (new CliOption('flag', 'f'))->withValueNone());
		parent::__construct();
	}
}

class CliOptionsParserTest extends TestCase {

	public static function testInvalidOptionSetWithValueReturnsError(): void {
		$result = self::runOptionalOptions('--invalid=invalid');
		self::assertSame(['invalid' => 'unknown option: invalid'], $result->errors);
	}

	public static function testInvalidOptionSetWithoutValueReturnsError(): void {
		$result = self::runOptionalOptions('--invalid');
		self::assertSame(['invalid' => 'unknown option: invalid'], $result->errors);
	}

	public static function testValidOptionSetWithValidValueAndInvalidOptionSetWithValueReturnsValueForValidOptionAndErrorForInvalidOption(): void {
		$result = self::runOptionalOptions('--string=string --invalid=invalid');
		self::assertSame('string', $result->string);
		self::assertSame(['invalid' => 'unknown option: invalid'], $result->errors);
	}

	public static function testOptionWithValueTypeOfStringSetOnceWithValidValueReturnsValueAsString(): void {
		$result = self::runOptionalOptions('--string=string');
		self::assertSame('string', $result->string);
	}

	public static function testOptionWithRequiredValueTypeOfIntSetOnceWithValidValueReturnsValueAsInt(): void {
		$result = self::runOptionalOptions('--int=111');
		self::assertSame(111, $result->int);
	}

	public static function testOptionWithRequiredValueTypeOfBoolSetOnceWithValidValueReturnsValueAsBool(): void {
		$result = self::runOptionalOptions('--bool=on');
		self::assertTrue($result->bool);
	}

	public static function testOptionWithValueTypeOfArrayOfStringSetOnceWithValidValueReturnsValueAsArrayOfString(): void {
		$result = self::runOptionalOptions('--array-of-string=string');
		self::assertSame(['string'], $result->arrayOfString);
	}

	public static function testOptionWithValueTypeOfStringSetMultipleTimesWithValidValueReturnsLastValueSetAsString(): void {
		$result = self::runOptionalOptions('--string=first --string=second');
		self::assertSame('second', $result->string);
	}

	public static function testOptionWithValueTypeOfIntSetMultipleTimesWithValidValueReturnsLastValueSetAsInt(): void {
		$result = self::runOptionalOptions('--int=111 --int=222');
		self::assertSame(222, $result->int);
	}

	public static function testOptionWithValueTypeOfBoolSetMultipleTimesWithValidValueReturnsLastValueSetAsBool(): void {
		$result = self::runOptionalOptions('--bool=on --bool=off');
		self::assertFalse($result->bool);
	}

	public static function testOptionWithValueTypeOfArrayOfStringSetMultipleTimesWithValidValueReturnsAllSetValuesAsArrayOfString(): void {
		$result = self::runOptionalOptions('--array-of-string=first --array-of-string=second');
		self::assertSame(['first', 'second'], $result->arrayOfString);
	}

	public static function testOptionWithValueTypeOfIntSetWithInvalidValueReturnsAnError(): void {
		$result = self::runOptionalOptions('--int=one');
		self::assertSame(['int' => 'invalid input: int must be an integer'], $result->errors);
	}

	public static function testOptionWithValueTypeOfBoolSetWithInvalidValuesReturnsAnError(): void {
		$result = self::runOptionalOptions('--bool=bad');
		self::assertSame(['bool' => 'invalid input: bool must be a boolean'], $result->errors);
	}

	public static function testOptionWithValueTypeOfIntSetMultipleTimesWithValidAndInvalidValuesReturnsLastValidValueSetAsIntAndError(): void {
		$result = self::runOptionalOptions('--int=111 --int=one --int=222 --int=two');
		self::assertSame(222, $result->int);
		self::assertSame(['int' => 'invalid input: int must be an integer'], $result->errors);
	}

	public static function testOptionWithValueTypeOfBoolSetMultipleTimesWithWithValidAndInvalidValuesReturnsLastValidValueSetAsBoolAndError(): void {
		$result = self::runOptionalOptions('--bool=on --bool=good --bool=off --bool=bad');
		self::assertFalse($result->bool);
		self::assertSame(['bool' => 'invalid input: bool must be a boolean'], $result->errors);
	}

	public static function testNotSetOptionWithDefaultInputReturnsDefaultInput(): void {
		$result = self::runOptionalOptions('');
		self::assertSame('default', $result->defaultInput);
	}

	public static function testOptionWithDefaultInputSetWithValidValueReturnsCorrectlyTypedValue(): void {
		$result = self::runOptionalOptions('--default-input=input');
		self::assertSame('input', $result->defaultInput);
	}

	public static function testOptionWithOptionalValueSetWithoutValueReturnsEmptyString(): void {
		$result = self::runOptionalOptions('--optional-value');
		self::assertSame('', $result->optionalValue);
	}

	public static function testOptionWithOptionalValueDefaultSetWithoutValueReturnsOptionalValueDefault(): void {
		$result = self::runOptionalOptions('--optional-value-with-default');
		self::assertTrue($result->optionalValueWithDefault);
	}

	public static function testNotSetOptionWithOptionalValueDefaultAndDefaultInputReturnsDefaultInput(): void {
		$result = self::runOptionalOptions('');
		self::assertSame('default', $result->defaultInputAndOptionalValueWithDefault);
	}

	public static function testOptionWithOptionalValueDefaultAndDefaultInputSetWithoutValueReturnsOptionalValueDefault(): void {
		$result = self::runOptionalOptions('--default-input-and-optional-value-with-default');
		self::assertSame('optional', $result->defaultInputAndOptionalValueWithDefault);
	}

	public static function testOptionWithFlag(): void {
		$result = self::runOptionalOptions('--flag');
		self::assertTrue($result->flag);
	}

	public static function testOptionWithNoFlag(): void {
		$result = self::runOptionalOptions('');
		self::assertFalse($result->flag);
	}

	public static function testRequiredOptionNotSetReturnsError(): void {
		$result = self::runOptionalAndRequiredOptions('');
		self::assertSame(['required' => 'invalid input: required cannot be empty'], $result->errors);
	}

	public static function testOptionSetWithDeprecatedAliasGeneratesDeprecationWarningAndReturnsValue(): void {
		$result = self::runCommandReadingStandardError('--deprecated-string=string');
		self::assertSame('FreshRSS deprecation warning: the CLI option(s): deprecated-string are deprecated ' .
				'and will be removed in a future release. Use: string instead',
			$result
		);

		$result = self::runOptionalOptions('--deprecated-string=string');
		self::assertSame('string', $result->string);
	}

	public static function testAlwaysReturnUsageMessageWithUsageInfoForAllOptions(): void {
		$result = self::runOptionalAndRequiredOptions('');
		self::assertSame('Usage: cli-parser-test.php --required=<required> [-s --string=<string>] [-i --int=<int>] [-b --bool=<bool>] [-f --flag]',
			$result->usage,
		);
	}

	private static function runOptionalOptions(string $cliOptions = ''): CliOptionsOptionalTest {
		$command = __DIR__ . '/cli-parser-test.php';
		$className = CliOptionsOptionalTest::class;

		$result = shell_exec("CLI_PARSER_TEST_OPTIONS_CLASS='$className' $command $cliOptions 2>/dev/null");
		$result = is_string($result) ? unserialize($result) : new CliOptionsOptionalTest();

		/** @var CliOptionsOptionalTest $result */
		return $result;
	}

	private static function runOptionalAndRequiredOptions(string $cliOptions = ''): CliOptionsOptionalAndRequiredTest {
		$command = __DIR__ . '/cli-parser-test.php';
		$className = CliOptionsOptionalAndRequiredTest::class;

		$result = shell_exec("CLI_PARSER_TEST_OPTIONS_CLASS='$className' $command $cliOptions 2>/dev/null");
		$result = is_string($result) ? unserialize($result) : new CliOptionsOptionalAndRequiredTest();

		/** @var CliOptionsOptionalAndRequiredTest $result */
		return $result;
	}

	private static function runCommandReadingStandardError(string $cliOptions = ''): string {
		$command = __DIR__ . '/cli-parser-test.php';
		$className = CliOptionsOptionalTest::class;

		$result = shell_exec("CLI_PARSER_TEST_OPTIONS_CLASS='$className' $command $cliOptions 2>&1");
		$result = is_string($result) ? explode("\n", $result) : '';

		return is_array($result) ? $result[0] : '';
	}
}

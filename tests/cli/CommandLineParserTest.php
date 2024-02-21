<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../cli/Option.php';
require_once __DIR__ . '/../../cli/CommandLineParser.php';

final class OptionalOptionsDefinition extends CommandLineParser {
	public string $string = '';
	public int $int = 0;
	public bool $bool = false;
	/** @var array<int,string> $arrayOfString */
	public array $arrayOfString = [];
	public string $defaultInput = '';
	public string $optionalValue = '';
	public bool $optionalValueWithDefault = false;
	public string $defaultInputAndOptionalValueWithDefault = '';

	public function __construct() {
		$this->addOption('string', (new Option('string', 's'))->deprecatedAs('deprecated-string'));
		$this->addOption('int', (new Option('int', 'i'))->typeOfInt());
		$this->addOption('bool', (new Option('bool', 'b'))->typeOfBool());
		$this->addOption('arrayOfString', (new Option('array-of-string', 'a'))->typeOfArrayOfString());
		$this->addOption('defaultInput', (new Option('default-input', 'i')), 'default');
		$this->addOption('optionalValue', (new Option('optional-value', 'o'))->withValueOptional());
		$this->addOption('optionalValueWithDefault', (new Option('optional-value-with-default', 'd'))->withValueOptional('true')->typeOfBool());
		$this->addOption('defaultInputAndOptionalValueWithDefault',
			(new Option('default-input-and-optional-value-with-default', 'e'))->withValueOptional('optional'),
			'default'
		);
		$this->addOption('flag', (new Option('flag', 'f'))->withValueNone());
		parent::__construct();
	}
}

final class OptionalAndRequiredOptionsDefinition extends CommandLineParser {
	public string $required = '';
	public string $string = '';
	public int $int = 0;
	public bool $bool = false;
	public string $flag = '';

	public function __construct() {
		$this->addRequiredOption('required', new Option('required'));
		$this->addOption('string', new Option('string', 's'));
		$this->addOption('int', (new Option('int', 'i'))->typeOfInt());
		$this->addOption('bool', (new Option('bool', 'b'))->typeOfBool());
		$this->addOption('flag', (new Option('flag', 'f'))->withValueNone());
		parent::__construct();
	}
}

class CommandLineParserTest extends TestCase {

	public function testInvalidOptionSetWithValueReturnsError(): void {
		$result = $this->runOptionalOptions('--invalid=invalid');

		self::assertEquals(['invalid' => 'unknown option: invalid'], $result->errors);
	}

	public function testInvalidOptionSetWithoutValueReturnsError(): void {
		$result = $this->runOptionalOptions('--invalid');

		self::assertEquals(['invalid' => 'unknown option: invalid'], $result->errors);
	}

	public function testValidOptionSetWithValidValueAndInvalidOptionSetWithValueReturnsValueForValidOptionAndErrorForInvalidOption(): void {
		$result = $this->runOptionalOptions('--string=string --invalid=invalid');

		self::assertEquals('string', $result->string);
		self::assertEquals(['invalid' => 'unknown option: invalid'], $result->errors);
	}

	public function testOptionWithValueTypeOfStringSetOnceWithValidValueReturnsValueAsString(): void {
		$result = $this->runOptionalOptions('--string=string');

		self::assertEquals('string', $result->string);
	}

	public function testOptionWithRequiredValueTypeOfIntSetOnceWithValidValueReturnsValueAsInt(): void {
		$result = $this->runOptionalOptions('--int=111');

		self::assertEquals(111, $result->int);
	}

	public function testOptionWithRequiredValueTypeOfBoolSetOnceWithValidValueReturnsValueAsBool(): void {
		$result = $this->runOptionalOptions('--bool=on');

		self::assertEquals(true, $result->bool);
	}

	public function testOptionWithValueTypeOfArrayOfStringSetOnceWithValidValueReturnsValueAsArrayOfString(): void {
		$result = $this->runOptionalOptions('--array-of-string=string');

		self::assertEquals(['string'], $result->arrayOfString);
	}

	public function testOptionWithValueTypeOfStringSetMultipleTimesWithValidValueReturnsLastValueSetAsString(): void {
		$result = $this->runOptionalOptions('--string=first --string=second');

		self::assertEquals('second', $result->string);
	}

	public function testOptionWithValueTypeOfIntSetMultipleTimesWithValidValueReturnsLastValueSetAsInt(): void {
		$result = $this->runOptionalOptions('--int=111 --int=222');

		self::assertEquals(222, $result->int);
	}

	public function testOptionWithValueTypeOfBoolSetMultipleTimesWithValidValueReturnsLastValueSetAsBool(): void {
		$result = $this->runOptionalOptions('--bool=on --bool=off');

		self::assertEquals(false, $result->bool);
	}

	public function testOptionWithValueTypeOfArrayOfStringSetMultipleTimesWithValidValueReturnsAllSetValuesAsArrayOfString(): void {
		$result = $this->runOptionalOptions('--array-of-string=first --array-of-string=second');

		self::assertEquals(['first', 'second'], $result->arrayOfString);
	}

	public function testOptionWithValueTypeOfIntSetWithInvalidValueReturnsAnError(): void {
		$result = $this->runOptionalOptions('--int=one');

		self::assertEquals(['int' => 'invalid input: int must be an integer'], $result->errors);
	}

	public function testOptionWithValueTypeOfBoolSetWithInvalidValuesReturnsAnError(): void {
		$result = $this->runOptionalOptions('--bool=bad');

		self::assertEquals(['bool' => 'invalid input: bool must be a boolean'], $result->errors);
	}

	public function testOptionWithValueTypeOfIntSetMultipleTimesWithValidAndInvalidValuesReturnsLastValidValueSetAsIntAndError(): void {
		$result = $this->runOptionalOptions('--int=111 --int=one --int=222 --int=two');

		self::assertEquals(222, $result->int);
		self::assertEquals(['int' => 'invalid input: int must be an integer'], $result->errors);
	}

	public function testOptionWithValueTypeOfBoolSetMultipleTimesWithWithValidAndInvalidValuesReturnsLastValidValueSetAsBoolAndError(): void {
		$result = $this->runOptionalOptions('--bool=on --bool=good --bool=off --bool=bad');

		self::assertEquals(false, $result->bool);
		self::assertEquals(['bool' => 'invalid input: bool must be a boolean'], $result->errors);
	}

	public function testNotSetOptionWithDefaultInputReturnsDefaultInput(): void {
		$result = $this->runOptionalOptions('');

		self::assertEquals('default', $result->defaultInput);
	}

	public function testOptionWithDefaultInputSetWithValidValueReturnsCorrectlyTypedValue(): void {
		$result = $this->runOptionalOptions('--default-input=input');

		self::assertEquals('input', $result->defaultInput);
	}

	public function testOptionWithOptionalValueSetWithoutValueReturnsEmptyString(): void {
		$result = $this->runOptionalOptions('--optional-value');

		self::assertEquals('', $result->optionalValue);
	}

	public function testOptionWithOptionalValueDefaultSetWithoutValueReturnsOptionalValueDefault(): void {
		$result = $this->runOptionalOptions('--optional-value-with-default');

		self::assertEquals(true, $result->optionalValueWithDefault);
	}

	public function testNotSetOptionWithOptionalValueDefaultAndDefaultInputReturnsDefaultInput(): void {
		$result = $this->runOptionalOptions('');

		self::assertEquals('default', $result->defaultInputAndOptionalValueWithDefault);
	}

	public function testOptionWithOptionalValueDefaultAndDefaultInputSetWithoutValueReturnsOptionalValueDefault(): void {
		$result = $this->runOptionalOptions('--default-input-and-optional-value-with-default');

		self::assertEquals('optional', $result->defaultInputAndOptionalValueWithDefault);
	}

	public function testRequiredOptionNotSetReturnsError(): void {
		$result = $this->runOptionalAndRequiredOptions('');

		self::assertEquals(['required' => 'invalid input: required cannot be empty'], $result->errors);
	}

	public function testOptionSetWithDeprecatedAliasGeneratesDeprecationWarningAndReturnsValue(): void {
		$result = $this->runCommandReadingStandardError('--deprecated-string=string');

		self::assertEquals('FreshRSS deprecation warning: the CLI option(s): deprecated-string are deprecated ' .
				'and will be removed in a future release. Use: string instead',
			$result
		);

		$result = $this->runOptionalOptions('--deprecated-string=string');

		self::assertEquals('string', $result->string);
	}

	public function testAlwaysReturnUsageMessageWithUsageInfoForAllOptions(): void {
		$result = $this->runOptionalAndRequiredOptions('');

		self::assertEquals('Usage: cli-parser-test.php --required=<required> [-s --string=<string>] [-i --int=<int>] [-b --bool=<bool>] [-f --flag]',
			$result->usage,
		);
	}

	public static function optionalOptions(): OptionalOptionsDefinition {
		return new OptionalOptionsDefinition();
	}

	public static function optionalAndRequiredOptions(): OptionalAndRequiredOptionsDefinition {
		return new OptionalAndRequiredOptionsDefinition();
	}

	private function runOptionalOptions(string $options = ''): OptionalOptionsDefinition {
		$command = __DIR__ . '/cli-parser-test.php';

		$result = shell_exec("CLI_PARSER_TEST_STATIC_METHOD='optionalOptions' $command $options 2>/dev/null");
		$result = is_string($result) ? unserialize($result) : new OptionalOptionsDefinition();

		/** @var OptionalOptionsDefinition $result */
		return $result;
	}

	private function runOptionalAndRequiredOptions(string $options = ''): OptionalAndRequiredOptionsDefinition {
		$command = __DIR__ . '/cli-parser-test.php';

		$result = shell_exec("CLI_PARSER_TEST_STATIC_METHOD='optionalAndRequiredOptions' $command $options 2>/dev/null");
		$result = is_string($result) ? unserialize($result) : new OptionalAndRequiredOptionsDefinition();

		/** @var OptionalAndRequiredOptionsDefinition $result */
		return $result;
	}

	private function runCommandReadingStandardError(string $options = ''): string {
		$command = __DIR__ . '/cli-parser-test.php';

		$result = shell_exec("CLI_PARSER_TEST_STATIC_METHOD='optionalOptions' $command $options 2>&1");
		$result = is_string($result) ? explode("\n", $result) : '';

		return is_array($result) ? $result[0] : '';
	}
}

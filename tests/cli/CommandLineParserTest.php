<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
require_once '/workspaces/FreshRSS/cli/Option.php';
require_once '/workspaces/FreshRSS/cli/CommandLineParser.php';

class CommandLineParserTest extends TestCase {

	public function testInvalidOptionSetWithValueReturnsError(): void {
		$result = $this->runCommand('optionalOptions', '--invalid=invalid');

		self::assertEquals(['invalid' => 'unknown option: invalid'], $result->errors);
	}

	public function testInvalidOptionSetWithoutValueReturnsError(): void {
		$result = $this->runCommand('optionalOptions', '--invalid');

		self::assertEquals(['invalid' => 'unknown option: invalid'], $result->errors);
	}

	public function testValidOptionSetWithValidValueAndInvalidOptionSetWithValueReturnsValueForValidOptionAndErrorForInvalidOption(): void {
		$result = $this->runCommand('optionalOptions', '--string=string --invalid=invalid');

		self::assertEquals('string', $result->string);
		self::assertEquals(['invalid' => 'unknown option: invalid'], $result->errors);
	}

	public function testOptionWithValueTypeOfStringSetOnceWithValidValueReturnsValueAsString(): void {
		$result = $this->runCommand('optionalOptions', '--string=string');

		self::assertEquals('string', $result->string);
	}

	public function testOptionWithRequiredValueTypeOfIntSetOnceWithValidValueReturnsValueAsInt(): void {
		$result = $this->runCommand('optionalOptions', '--int=111');

		self::assertEquals(111, $result->int);
	}

	public function testOptionWithRequiredValueTypeOfBoolSetOnceWithValidValueReturnsValueAsBool(): void {
		$result = $this->runCommand('optionalOptions', '--bool=on');

		self::assertEquals(true, $result->bool);
	}

	public function testOptionWithValueTypeOfArrayOfStringSetOnceWithValidValueReturnsValueAsArrayOfString(): void {
		$result = $this->runCommand('optionalOptions', '--array-of-string=string');

		self::assertEquals(['string'], $result->arrayOfString);
	}

	public function testOptionWithValueTypeOfStringSetMultipleTimesWithValidValueReturnsLastValueSetAsString(): void {
		$result = $this->runCommand('optionalOptions', '--string=first --string=second');

		self::assertEquals('second', $result->string);
	}

	public function testOptionWithValueTypeOfIntSetMultipleTimesWithValidValueReturnsLastValueSetAsInt(): void {
		$result = $this->runCommand('optionalOptions', '--int=111 --int=222');

		self::assertEquals(222, $result->int);
	}

	public function testOptionWithValueTypeOfBoolSetMultipleTimesWithValidValueReturnsLastValueSetAsBool(): void {
		$result = $this->runCommand('optionalOptions', '--bool=on --bool=off');

		self::assertEquals(false, $result->bool);
	}

	public function testOptionWithValueTypeOfArrayOfStringSetMultipleTimesWithValidValueReturnsAllSetValuesAsArrayOfString(): void {
		$result = $this->runCommand('optionalOptions', '--array-of-string=first --array-of-string=second');

		self::assertEquals(['first', 'second'], $result->arrayOfString);
	}

	public function testOptionWithValueTypeOfIntSetWithInvalidValueReturnsAnError(): void {
		$result = $this->runCommand('optionalOptions', '--int=one');

		self::assertEquals(['int' => 'invalid input: int must be an integer'], $result->errors);
	}

	public function testOptionWithValueTypeOfBoolSetWithInvalidValuesReturnsAnError(): void {
		$result = $this->runCommand('optionalOptions', '--bool=bad');

		self::assertEquals(['bool' => 'invalid input: bool must be a boolean'], $result->errors);
	}

	public function testOptionWithValueTypeOfIntSetMultipleTimesWithValidAndInvalidValuesReturnsLastValidValueSetAsIntAndError(): void {
		$result = $this->runCommand('optionalOptions', '--int=111 --int=one --int=222 --int=two');

		self::assertEquals(222, $result->int);
		self::assertEquals(['int' => 'invalid input: int must be an integer'], $result->errors);
	}

	public function testOptionWithValueTypeOfBoolSetMultipleTimesWithWithValidAndInvalidValuesReturnsLastValidValueSetAsBoolAndError(): void {
		$result = $this->runCommand('optionalOptions', '--bool=on --bool=good --bool=off --bool=bad');

		self::assertEquals(false, $result->bool);
		self::assertEquals(['bool' => 'invalid input: bool must be a boolean'], $result->errors);
	}

	public function testNotSetOptionWithDefaultInputReturnsDefaultInput(): void {
		$result = $this->runCommand('optionalOptions', '');

		self::assertEquals('default', $result->defaultInput);
	}

	public function testOptionWithDefaultInputSetWithValidValueReturnsCorrectlyTypedValue(): void {
		$result = $this->runCommand('optionalOptions', '--default-input=input');

		self::assertEquals('input', $result->defaultInput);
	}

	public function testOptionWithOptionalValueSetWithoutValueReturnsEmptyString(): void {
		$result = $this->runCommand('optionalOptions', '--optional-value');

		self::assertEquals('', $result->optionalValue);
	}

	public function testOptionWithOptionalValueDefaultSetWithoutValueReturnsOptionalValueDefault(): void {
		$result = $this->runCommand('optionalOptions', '--optional-value-with-default');

		self::assertEquals(true, $result->optionalValueWithDefault);
	}

	public function testNotSetOptionWithOptionalValueDefaultAndDefaultInputReturnsDefaultInput(): void {
		$result = $this->runCommand('optionalOptions', '');

		self::assertEquals('default', $result->defaultInputAndOptionalValueWithDefault);
	}

	public function testOptionWithOptionalValueDefaultAndDefaultInputSetWithoutValueReturnsOptionalValueDefault(): void {
		$result = $this->runCommand('optionalOptions', '--default-input-and-optional-value-with-default');

		self::assertEquals('optional', $result->defaultInputAndOptionalValueWithDefault);
	}

	public function testRequiredOptionNotSetReturnsError(): void {
		$result = $this->runCommand('optionalAndRequiredOptions', '');

		self::assertEquals(['required' => 'invalid input: required cannot be empty'], $result->errors);
	}

	public function testOptionSetWithDeprecatedAliasGeneratesDeprecationWarningAndReturnsValue(): void {
		$result = $this->runCommandReadingStandardError('optionalOptions', '--deprecated-string=string');

		self::assertEquals('FreshRSS deprecation warning: the CLI option(s): deprecated-string are deprecated ' .
				'and will be removed in a future release. Use: string instead',
			$result
		);

		$result = $this->runCommand('optionalOptions', '--deprecated-string=string');

		self::assertEquals('string', $result->string);
	}

	public function testAlwaysReturnUsageMessageWithUsageInfoForAllOptions(): void {
		$result = $this->runCommand('optionalAndRequiredOptions', '');

		self::assertEquals('Usage: cli-parser-test --required=<required> [-s --string=<string>] [-i --int=<int>] [-b --bool=<bool>] [-f --flag]',
			$result->usage,
		);
	}

	public static function optionalOptions(): stdClass {
		$parser = new CommandLineParser();
		$parser->addOption('string', (new Option('string', 's'))->deprecatedAs('deprecated-string'));
		$parser->addOption('int', (new Option('int', 'i'))->typeOfInt());
		$parser->addOption('bool', (new Option('bool', 'b'))->typeOfBool());
		$parser->addOption('arrayOfString', (new Option('array-of-string', 'a'))->typeOfArrayOfString());
		$parser->addOption('defaultInput', (new Option('default-input', 'i')), 'default');
		$parser->addOption('optionalValue', (new Option('optional-value', 'o'))->withValueOptional());
		$parser->addOption('optionalValueWithDefault', (new Option('optional-value-with-default', 'd'))->withValueOptional('true')->typeOfBool());
		$parser->addOption('defaultInputAndOptionalValueWithDefault',
			(new Option('default-input-and-optional-value-with-default', 'e'))->withValueOptional('optional'),
			'default'
		);
		$parser->addOption('flag', (new Option('flag', 'f'))->withValueNone());

		return $parser->parse(stdClass::class);
	}

	public static function optionalAndRequiredOptions(): stdClass {
		$parser = new CommandLineParser();
		$parser->addRequiredOption('required', new Option('required'));
		$parser->addOption('string', new Option('string', 's'));
		$parser->addOption('int', (new Option('int', 'i'))->typeOfInt());
		$parser->addOption('bool', (new Option('bool', 'b'))->typeOfBool());
		$parser->addOption('flag', (new Option('flag', 'f'))->withValueNone());

		return $parser->parse(stdClass::class);
	}

	private function runCommand(string $static_method, string $options = ''): stdClass {
		$command = __DIR__ . '/cli-parser-test';

		$result = shell_exec("CLI_PARSER_TEST_STATIC_METHOD='$static_method' $command $options 2>/dev/null");
		$result = is_string($result) ? unserialize($result) : '';

		/** @var stdClass $result */
		return $result;
	}

	private function runCommandReadingStandardError(string $static_method, string $options = ''): string {
		$command = __DIR__ . '/cli-parser-test';

		$result = shell_exec("CLI_PARSER_TEST_STATIC_METHOD='$static_method' $command $options 2>&1");
		$result = is_string($result) ? explode("\n", $result) : '';

		return is_array($result) ? $result[0] : '';
	}
}

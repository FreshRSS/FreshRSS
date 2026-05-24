<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2) . '/cli/CliOption.php';
require_once dirname(__DIR__, 2) . '/cli/CliOptionsParser.php';

final class UserConfigCliOptionsTest extends CliOptionsParser {
	public string $user;
	public string $key;
	public string $value;
	public bool $list;
	public bool $set;
	public bool $unset;
	public bool $valueStdin;
	public bool $force;
	public bool $showSecrets;

	public function __construct() {
		$this->addRequiredOption('user', (new CliOption('user')));
		$this->addOption('key', (new CliOption('key')));
		$this->addOption('value', (new CliOption('value')));
		$this->addOption('list', (new CliOption('list'))->withValueNone());
		$this->addOption('set', (new CliOption('set'))->withValueNone());
		$this->addOption('unset', (new CliOption('unset'))->withValueNone());
		$this->addOption('valueStdin', (new CliOption('value-stdin'))->withValueNone());
		$this->addOption('force', (new CliOption('force'))->withValueNone());
		$this->addOption('showSecrets', (new CliOption('show-secrets'))->withValueNone());
		parent::__construct();
	}
}

class UserConfigOptionsParserTest extends TestCase {

	public static function testUserIsRequired(): void {
		$result = self::runOptions('');
		self::assertArrayHasKey('user', $result->errors);
	}

	public static function testUserProvided(): void {
		$result = self::runOptions('--user=alice');
		self::assertEmpty($result->errors);
		self::assertSame('alice', $result->user);
	}

	public static function testListFlag(): void {
		$result = self::runOptions('--user=alice --list');
		self::assertTrue($result->list);
		self::assertFalse($result->set);
		self::assertFalse($result->unset);
	}

	public static function testShowSecretsFlag(): void {
		$result = self::runOptions('--user=alice --list --show-secrets');
		self::assertTrue($result->list);
		self::assertTrue($result->showSecrets);
	}

	public static function testSetFlagWithValue(): void {
		$result = self::runOptions('--user=alice --key=language --set --value=fr');
		self::assertTrue($result->set);
		self::assertFalse($result->list);
		self::assertFalse($result->unset);
		self::assertSame('language', $result->key);
		self::assertSame('fr', $result->value);
	}

	public static function testUnsetFlag(): void {
		$result = self::runOptions('--user=alice --key=language --unset');
		self::assertTrue($result->unset);
		self::assertFalse($result->set);
	}

	public static function testValueStdinFlag(): void {
		$result = self::runOptions('--user=alice --key=token --set --value-stdin');
		self::assertTrue($result->set);
		self::assertTrue($result->valueStdin);
	}

	public static function testForceFlag(): void {
		$result = self::runOptions('--user=alice --key=custom --set --value=hello --force');
		self::assertTrue($result->set);
		self::assertTrue($result->force);
	}

	public static function testGetKey(): void {
		$result = self::runOptions('--user=alice --key=language');
		self::assertEmpty($result->errors);
		self::assertSame('language', $result->key);
		self::assertFalse($result->set);
		self::assertFalse($result->unset);
		self::assertFalse($result->list);
	}

	public static function testUnknownOptionReturnsError(): void {
		$result = self::runOptions('--user=alice --unknown');
		self::assertArrayHasKey('unknown', $result->errors);
	}

	private static function runOptions(string $cliOptions = ''): UserConfigCliOptionsTest {
		$command = __DIR__ . '/cli-parser-test.php';
		$className = UserConfigCliOptionsTest::class;

		$result = shell_exec("CLI_PARSER_TEST_OPTIONS_CLASS='$className' $command $cliOptions 2>/dev/null");
		$result = is_string($result) ?
			unserialize($result, ['allowed_classes' => [UserConfigCliOptionsTest::class]]) :
			new UserConfigCliOptionsTest();

		/** @var UserConfigCliOptionsTest $result */
		return $result;
	}
}

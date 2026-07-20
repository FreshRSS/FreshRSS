<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class MigratorTest extends TestCase
{
	public static function testAddMigration(): void {
		$migrator = new Minz_Migrator();

		$migrator->addMigration('foo', fn() => true);

		$migrations = $migrator->migrations();
		self::assertArrayHasKey('foo', $migrations);
		$result = $migrations['foo']();
		self::assertTrue($result);
	}

	public static function testMigrationsIsSorted(): void {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('2_foo', fn() => true);
		$migrator->addMigration('10_foo', fn() => true);
		$migrator->addMigration('1_foo', fn() => true);
		$expected_versions = ['1_foo', '2_foo', '10_foo'];

		$migrations = $migrator->migrations();

		self::assertSame($expected_versions, array_keys($migrations));
	}

	public static function testSetAppliedVersions(): void {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', fn() => true);

		$migrator->setAppliedVersions(['foo']);

		self::assertSame(['foo'], $migrator->appliedVersions());
	}

	public static function testSetAppliedVersionsTrimArgument(): void {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', fn() => true);

		$migrator->setAppliedVersions(["foo\n"]);

		self::assertSame(['foo'], $migrator->appliedVersions());
	}

	public function testSetAppliedVersionsFailsIfMigrationDoesNotExist(): void {
		$this->expectException(DomainException::class);
		$this->expectExceptionMessage('foo migration does not exist.');

		$migrator = new Minz_Migrator();

		$migrator->setAppliedVersions(['foo']);
	}

	public static function testVersions(): void {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', fn() => true);
		$migrator->addMigration('bar', fn() => true);

		$versions = $migrator->versions();

		self::assertSame(['bar', 'foo'], $versions);
	}

	public static function testMigrate(): void {
		$migrator = new Minz_Migrator();
		$spy = false;
		$migrator->addMigration('foo', function () use (&$spy) {
			$spy = true;
			return true;
		});
		self::assertEmpty($migrator->appliedVersions());

		$result = $migrator->migrate();

		self::assertTrue($spy);
		self::assertSame(['foo'], $migrator->appliedVersions());
		self::assertSame([
			'foo' => true,
		], $result);
	}

	public static function testMigrateCallsMigrationsInSortedOrder(): void {
		$migrator = new Minz_Migrator();
		$spy_foo_1_is_called = false;
		$migrator->addMigration('2_foo', function () use (&$spy_foo_1_is_called) {
			return $spy_foo_1_is_called;
		});
		$migrator->addMigration('1_foo', function () use (&$spy_foo_1_is_called) {
			$spy_foo_1_is_called = true;
			return true;
		});

		$result = $migrator->migrate();

		self::assertSame(['1_foo', '2_foo'], $migrator->appliedVersions());
		self::assertSame([
			'1_foo' => true,
			'2_foo' => true,
		], $result);
	}

	public static function testMigrateDoesNotCallAppliedMigrations(): void {
		$migrator = new Minz_Migrator();
		$spy = false;
		$migrator->addMigration('1_foo', function () use (&$spy) {
			$spy = true;
			return true;
		});
		$migrator->setAppliedVersions(['1_foo']);

		$result = $migrator->migrate();

		self::assertFalse($spy);
		self::assertSame([], $result);
	}

	public static function testMigrateCallNonAppliedBetweenTwoApplied(): void {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('1_foo', fn() => true);
		$migrator->addMigration('2_foo', fn() => true);
		$migrator->addMigration('3_foo', fn() => true);
		$migrator->setAppliedVersions(['1_foo', '3_foo']);

		$result = $migrator->migrate();

		self::assertSame(['1_foo', '2_foo', '3_foo'], $migrator->appliedVersions());
		self::assertSame([
			'2_foo' => true,
		], $result);
	}

	public static function testMigrateWithMigrationReturningFalseDoesNotApplyVersion(): void {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('1_foo', fn() => true);
		$migrator->addMigration('2_foo', fn() => false);

		$result = $migrator->migrate();

		self::assertSame(['1_foo'], $migrator->appliedVersions());
		self::assertSame([
			'1_foo' => true,
			'2_foo' => false,
		], $result);
	}

	public static function testMigrateWithMigrationReturningFalseDoesNotExecuteNextMigrations(): void {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('1_foo', fn() => false);
		$spy = false;
		$migrator->addMigration('2_foo', function () use (&$spy) {
			$spy = true;
			return true;
		});

		$result = $migrator->migrate();

		self::assertEmpty($migrator->appliedVersions());
		self::assertFalse($spy);
		self::assertSame([
			'1_foo' => false,
		], $result);
	}

	public static function testMigrateWithFailingMigration(): void {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', function () {
			throw new \Exception('Oops, it failed.');
		});

		$result = $migrator->migrate();

		self::assertEmpty($migrator->appliedVersions());
		self::assertSame([
			'foo' => 'Oops, it failed.',
		], $result);
	}

	public static function testUpToDate(): void {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', fn() => true);
		$migrator->setAppliedVersions(['foo']);

		$upToDate = $migrator->upToDate();

		self::assertTrue($upToDate);
	}

	public static function testUpToDateIfRemainingMigration(): void {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('1_foo', fn() => true);
		$migrator->addMigration('2_foo', fn() => true);
		$migrator->setAppliedVersions(['2_foo']);

		$upToDate = $migrator->upToDate();

		self::assertFalse($upToDate);
	}

	public static function testUpToDateIfNoMigrations(): void {
		$migrator = new Minz_Migrator();

		$upToDate = $migrator->upToDate();

		self::assertTrue($upToDate);
	}

	public static function testConstructorLoadsDirectory(): void {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$migrator = new Minz_Migrator($migrations_path);
		$expected_versions = ['2019_12_22_FooBar', '2019_12_23_Baz'];

		$migrations = $migrator->migrations();

		self::assertSame($expected_versions, array_keys($migrations));
	}

	public static function testExecute(): void {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$applied_migrations_path = tempnam('/tmp', 'applied_migrations.txt');
		self::assertIsString($applied_migrations_path);
		$result = Minz_Migrator::execute($migrations_path, $applied_migrations_path);

		self::assertTrue($result);
		$versions = file_get_contents($applied_migrations_path);
		self::assertSame("2019_12_22_FooBar\n2019_12_23_Baz", $versions);
		@unlink($applied_migrations_path);
	}

	public static function testExecuteWithAlreadyAppliedMigration(): void {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$applied_migrations_path = tempnam('/tmp', 'applied_migrations.txt');
		self::assertIsString($applied_migrations_path);
		file_put_contents($applied_migrations_path, '2019_12_22_FooBar');

		$result = Minz_Migrator::execute($migrations_path, $applied_migrations_path);

		self::assertTrue($result);
		$versions = file_get_contents($applied_migrations_path);
		self::assertSame("2019_12_22_FooBar\n2019_12_23_Baz", $versions);
		@unlink($applied_migrations_path);
	}

	public static function testExecuteWithAppliedMigrationInDifferentOrder(): void {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$applied_migrations_path = tempnam('/tmp', 'applied_migrations.txt');
		self::assertIsString($applied_migrations_path);
		file_put_contents($applied_migrations_path, "2019_12_23_Baz\n2019_12_22_FooBar");

		$result = Minz_Migrator::execute($migrations_path, $applied_migrations_path);

		self::assertTrue($result);
		$versions = file_get_contents($applied_migrations_path);
		// if the order changes, it probably means the first versions comparison test doesn’t work anymore
		self::assertSame("2019_12_23_Baz\n2019_12_22_FooBar", $versions);
		@unlink($applied_migrations_path);
	}

	public static function testExecuteFailsIfVersionPathDoesNotExist(): void {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$applied_migrations_path = tempnam('/tmp', 'applied_migrations.txt');
		$expected_result = "Cannot open the {$applied_migrations_path} file";
		self::assertIsString($applied_migrations_path);
		unlink($applied_migrations_path);
		$result = Minz_Migrator::execute($migrations_path, $applied_migrations_path);

		self::assertSame($expected_result, $result);
		@unlink($applied_migrations_path);
	}

	public static function testExecuteFailsIfAMigrationIsFailing(): void {
		$migrations_path = TESTS_PATH . '/fixtures/migrations_with_failing/';
		$applied_migrations_path = tempnam('/tmp', 'applied_migrations.txt');
		$expected_result = 'A migration failed to be applied, please see previous logs.';
		self::assertIsString($applied_migrations_path);
		$result = Minz_Migrator::execute($migrations_path, $applied_migrations_path);
		self::assertIsString($result);
		[$result,] = explode("\n", $result, 2);

		self::assertSame($expected_result, $result);
		$versions = file_get_contents($applied_migrations_path);
		self::assertSame('2020_01_11_FooBar', $versions);
		@unlink($applied_migrations_path);
	}
}

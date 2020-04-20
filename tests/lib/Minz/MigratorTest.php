<?php

use PHPUnit\Framework\TestCase;

class Minz_MigratorTest extends TestCase
{
	public function testAddMigration() {
		$migrator = new Minz_Migrator();

		$migrator->addMigration('foo', function () {
			return true;
		});

		$migrations = $migrator->migrations();
		$this->assertArrayHasKey('foo', $migrations);
		$result = $migrations['foo']();
		$this->assertTrue($result);
	}

	public function testAddMigrationFailsIfUncallableMigration() {
		$this->expectException(BadFunctionCallException::class);
		$this->expectExceptionMessage('foo migration cannot be called.');

		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', null);
	}

	public function testMigrationsIsSorted() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('2_foo', function () {
			return true;
		});
		$migrator->addMigration('10_foo', function () {
			return true;
		});
		$migrator->addMigration('1_foo', function () {
			return true;
		});
		$expected_versions = ['1_foo', '2_foo', '10_foo'];

		$migrations = $migrator->migrations();

		$this->assertSame($expected_versions, array_keys($migrations));
	}

	public function testSetAppliedVersions() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', function () {
			return true;
		});

		$migrator->setAppliedVersions(['foo']);

		$this->assertSame(['foo'], $migrator->appliedVersions());
	}

	public function testSetAppliedVersionsTrimArgument() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', function () {
			return true;
		});

		$migrator->setAppliedVersions(["foo\n"]);

		$this->assertSame(['foo'], $migrator->appliedVersions());
	}

	public function testSetAppliedVersionsFailsIfMigrationDoesNotExist() {
		$this->expectException(DomainException::class);
		$this->expectExceptionMessage('foo migration does not exist.');

		$migrator = new Minz_Migrator();

		$migrator->setAppliedVersions(['foo']);
	}

	public function testVersions() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', function () {
			return true;
		});
		$migrator->addMigration('bar', function () {
			return true;
		});

		$versions = $migrator->versions();

		$this->assertSame(['bar', 'foo'], $versions);
	}

	public function testMigrate() {
		$migrator = new Minz_Migrator();
		$spy = false;
		$migrator->addMigration('foo', function () use (&$spy) {
			$spy = true;
			return true;
		});
		$this->assertEmpty($migrator->appliedVersions());

		$result = $migrator->migrate();

		$this->assertTrue($spy);
		$this->assertSame(['foo'], $migrator->appliedVersions());
		$this->assertSame([
			'foo' => true,
		], $result);
	}

	public function testMigrateCallsMigrationsInSortedOrder() {
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

		$this->assertSame(['1_foo', '2_foo'], $migrator->appliedVersions());
		$this->assertSame([
			'1_foo' => true,
			'2_foo' => true,
		], $result);
	}

	public function testMigrateDoesNotCallAppliedMigrations() {
		$migrator = new Minz_Migrator();
		$spy = false;
		$migrator->addMigration('1_foo', function () use (&$spy) {
			$spy = true;
			return true;
		});
		$migrator->setAppliedVersions(['1_foo']);

		$result = $migrator->migrate();

		$this->assertFalse($spy);
		$this->assertSame([], $result);
	}

	public function testMigrateCallNonAppliedBetweenTwoApplied() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('1_foo', function () {
			return true;
		});
		$migrator->addMigration('2_foo', function () {
			return true;
		});
		$migrator->addMigration('3_foo', function () {
			return true;
		});
		$migrator->setAppliedVersions(['1_foo', '3_foo']);

		$result = $migrator->migrate();

		$this->assertSame(['1_foo', '2_foo', '3_foo'], $migrator->appliedVersions());
		$this->assertSame([
			'2_foo' => true,
		], $result);
	}

	public function testMigrateWithMigrationReturningFalseDoesNotApplyVersion() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('1_foo', function () {
			return true;
		});
		$migrator->addMigration('2_foo', function () {
			return false;
		});

		$result = $migrator->migrate();

		$this->assertSame(['1_foo'], $migrator->appliedVersions());
		$this->assertSame([
			'1_foo' => true,
			'2_foo' => false,
		], $result);
	}

	public function testMigrateWithMigrationReturningFalseDoesNotExecuteNextMigrations() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('1_foo', function () {
			return false;
		});
		$spy = false;
		$migrator->addMigration('2_foo', function () use (&$spy) {
			$spy = true;
			return true;
		});

		$result = $migrator->migrate();

		$this->assertEmpty($migrator->appliedVersions());
		$this->assertFalse($spy);
		$this->assertSame([
			'1_foo' => false,
		], $result);
	}

	public function testMigrateWithFailingMigration() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', function () {
			throw new \Exception('Oops, it failed.');
		});

		$result = $migrator->migrate();

		$this->assertEmpty($migrator->appliedVersions());
		$this->assertSame([
			'foo' => 'Oops, it failed.',
		], $result);
	}

	public function testUpToDate() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', function () {
			return true;
		});
		$migrator->setAppliedVersions(['foo']);

		$upToDate = $migrator->upToDate();

		$this->assertTrue($upToDate);
	}

	public function testUpToDateIfRemainingMigration() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('1_foo', function () {
			return true;
		});
		$migrator->addMigration('2_foo', function () {
			return true;
		});
		$migrator->setAppliedVersions(['2_foo']);

		$upToDate = $migrator->upToDate();

		$this->assertFalse($upToDate);
	}

	public function testUpToDateIfNoMigrations() {
		$migrator = new Minz_Migrator();

		$upToDate = $migrator->upToDate();

		$this->assertTrue($upToDate);
	}

	public function testConstructorLoadsDirectory() {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$migrator = new Minz_Migrator($migrations_path);
		$expected_versions = ['2019_12_22_FooBar', '2019_12_23_Baz'];

		$migrations = $migrator->migrations();

		$this->assertSame($expected_versions, array_keys($migrations));
	}

	public function testExecute() {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$applied_migrations_path = tempnam('/tmp', 'applied_migrations.txt');

		$result = Minz_Migrator::execute($migrations_path, $applied_migrations_path);

		$this->assertTrue($result);
		$versions = file_get_contents($applied_migrations_path);
		$this->assertSame("2019_12_22_FooBar\n2019_12_23_Baz", $versions);
	}

	public function testExecuteWithAlreadyAppliedMigration() {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$applied_migrations_path = tempnam('/tmp', 'applied_migrations.txt');
		file_put_contents($applied_migrations_path, '2019_12_22_FooBar');

		$result = Minz_Migrator::execute($migrations_path, $applied_migrations_path);

		$this->assertTrue($result);
		$versions = file_get_contents($applied_migrations_path);
		$this->assertSame("2019_12_22_FooBar\n2019_12_23_Baz", $versions);
	}

	public function testExecuteFailsIfVersionPathDoesNotExist() {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$applied_migrations_path = tempnam('/tmp', 'applied_migrations.txt');
		$expected_result = "Cannot open the {$applied_migrations_path} file";
		unlink($applied_migrations_path);

		$result = Minz_Migrator::execute($migrations_path, $applied_migrations_path);

		$this->assertSame($expected_result, $result);
	}

	public function testExecuteFailsIfAMigrationIsFailing() {
		$migrations_path = TESTS_PATH . '/fixtures/migrations_with_failing/';
		$applied_migrations_path = tempnam('/tmp', 'applied_migrations.txt');
		$expected_result = 'A migration failed to be applied, please see previous logs';

		$result = Minz_Migrator::execute($migrations_path, $applied_migrations_path);

		$this->assertSame($expected_result, $result);
		$versions = file_get_contents($applied_migrations_path);
		$this->assertSame('2020_01_11_FooBar', $versions);
	}
}

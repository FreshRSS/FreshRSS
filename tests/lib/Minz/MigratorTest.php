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
		$expected_names = ['1_foo', '2_foo', '10_foo'];

		$migrations = $migrator->migrations();

		$this->assertSame($expected_names, array_keys($migrations));
	}

	public function testSetVersion() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', function () {
			return true;
		});

		$migrator->setVersion('foo');

		$this->assertSame('foo', $migrator->version());
	}

	public function testSetVersionTrimArgument() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', function () {
			return true;
		});

		$migrator->setVersion("foo\n");

		$this->assertSame('foo', $migrator->version());
	}

	public function testSetVersionFailsIfMigrationDoesNotExist() {
		$this->expectException(DomainException::class);
		$this->expectExceptionMessage('foo migration does not exist.');

		$migrator = new Minz_Migrator();

		$migrator->setVersion('foo');
	}

	public function testMigrate() {
		$migrator = new Minz_Migrator();
		$spy = false;
		$migrator->addMigration('foo', function () use (&$spy) {
			$spy = true;
			return true;
		});
		$this->assertNull($migrator->version());

		$result = $migrator->migrate();

		$this->assertTrue($spy);
		$this->assertSame('foo', $migrator->version());
		$this->assertSame([
			'foo' => true,
		], $result);
	}

	public function testMigrateCallsMigrationsInSortedOrder() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('2_foo', function () {
			return true;
		});
		$migrator->addMigration('1_foo', function () {
			return true;
		});

		$result = $migrator->migrate();

		$this->assertSame('2_foo', $migrator->version());
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
		$migrator->setVersion('1_foo');

		$result = $migrator->migrate();

		$this->assertFalse($spy);
		$this->assertSame([], $result);
	}

	public function testMigrateWithMigrationReturningFalseDoesNotChangeVersion() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('1_foo', function () {
			return true;
		});
		$migrator->addMigration('2_foo', function () {
			return false;
		});

		$result = $migrator->migrate();

		$this->assertSame('1_foo', $migrator->version());
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

		$this->assertNull($migrator->version());
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

		$this->assertNull($migrator->version());
		$this->assertSame([
			'foo' => 'Oops, it failed.',
		], $result);
	}

	public function testUpToDate() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', function () {
			return true;
		});
		$migrator->setVersion('foo');

		$upToDate = $migrator->upToDate();

		$this->assertTrue($upToDate);
	}

	public function testUpToDateRespectsOrder() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('2_foo', function () {
			return true;
		});
		$migrator->addMigration('1_foo', function () {
			return true;
		});
		$migrator->setVersion('2_foo');

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
		$migrator->setVersion('1_foo');

		$upToDate = $migrator->upToDate();

		$this->assertFalse($upToDate);
	}

	public function testUpToDateIfNoMigrations() {
		$migrator = new Minz_Migrator();

		$upToDate = $migrator->upToDate();

		$this->assertTrue($upToDate);
	}

	public function testLastVersion() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('foo', function () {
			return true;
		});

		$version = $migrator->lastVersion();

		$this->assertSame('foo', $version);
	}

	public function testLastVersionRespectsOrder() {
		$migrator = new Minz_Migrator();
		$migrator->addMigration('2_foo', function () {
			return true;
		});
		$migrator->addMigration('1_foo', function () {
			return true;
		});

		$version = $migrator->lastVersion();

		$this->assertSame('2_foo', $version);
	}

	public function testLastVersionIfNoMigrations() {
		$migrator = new Minz_Migrator();

		$version = $migrator->lastVersion();

		$this->assertNull($version);
	}

	public function testConstructorLoadsDirectory() {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$migrator = new Minz_Migrator($migrations_path);
		$expected_names = ['20191222_225420_FooBar', '20191222_225428_Baz'];

		$migrations = $migrator->migrations();

		$this->assertSame($expected_names, array_keys($migrations));
	}

	public function testExecute() {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$migrations_version_path = tempnam('/tmp', 'migrations_version.txt');

		$result = Minz_Migrator::execute($migrations_path, $migrations_version_path);

		$this->assertTrue($result);
		$version = file_get_contents($migrations_version_path);
		$this->assertSame('20191222_225428_Baz', $version);
	}

	public function testExecuteWithAlreadyAppliedMigration() {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$migrations_version_path = tempnam('/tmp', 'migrations_version.txt');
		file_put_contents($migrations_version_path, '20191222_225420_FooBar');

		$result = Minz_Migrator::execute($migrations_path, $migrations_version_path);

		$this->assertTrue($result);
		$version = file_get_contents($migrations_version_path);
		$this->assertSame('20191222_225428_Baz', $version);
	}

	public function testExecuteFailsIfVersionPathDoesNotExist() {
		$migrations_path = TESTS_PATH . '/fixtures/migrations/';
		$migrations_version_path = tempnam('/tmp', 'migrations_version.txt');
		$expected_result = $migrations_version_path . ' file does not exist';
		unlink($migrations_version_path);

		$result = Minz_Migrator::execute($migrations_path, $migrations_version_path);

		$this->assertSame($expected_result, $result);
	}

	public function testExecuteFailsIfAMigrationIsFailing() {
		$migrations_path = TESTS_PATH . '/fixtures/migrations_with_failing/';
		$migrations_version_path = tempnam('/tmp', 'migrations_version.txt');
		$expected_result = 'A migration failed to be applied, please see previous logs';

		$result = Minz_Migrator::execute($migrations_path, $migrations_version_path);

		$this->assertSame($expected_result, $result);
		$version = file_get_contents($migrations_version_path);
		$this->assertSame('20200111_225420_FooBar', $version);
	}
}

<?php

/**
 * The Minz_Migrator helps to migrate data (in a database or not) or the
 * architecture of a Minz application.
 *
 * @author Marien Fressinaud <dev@marienfressinaud.fr>
 * @license http://www.gnu.org/licenses/agpl-3.0.en.html AGPL
 */
class Minz_Migrator
{
	/** @var string[] */
	private $applied_versions;

	/** @var array */
	private $migrations = [];

	/**
	 * Execute a list of migrations, skipping versions indicated in a file
	 *
	 * @param string $migrations_path
	 * @param string $applied_migrations_path
	 *
	 * @throws BadFunctionCallException if a callback isn't callable.
	 * @throws DomainException if there is no migrations corresponding to the
	 *                         given version (can happen if version file has
	 *                         been modified, or migrations path cannot be
	 *                         read).
	 *
	 * @return boolean|string Returns true if execute succeeds to apply
	 *                        migrations, or a string if it fails.
	 */
	public static function execute($migrations_path, $applied_migrations_path) {
		$applied_migrations = @file_get_contents($applied_migrations_path);
		if ($applied_migrations === false) {
			return "Cannot open the {$applied_migrations_path} file";
		}
		$applied_migrations = array_filter(explode("\n", $applied_migrations));

		$migration_files = scandir($migrations_path);
		$migration_files = array_filter($migration_files, function ($filename) {
			return $filename[0] !== '.';
		});
		$migration_versions = array_map(function ($filename) {
			return basename($filename, '.php');
		}, $migration_files);

		// We apply a "low-cost" comparaison to avoid to include the migration
		// files at each run. It is equivalent to the upToDate method.
		if (count($applied_migrations) === count($migration_versions) &&
			empty(array_diff($applied_migrations, $migration_versions))) {
			// already at the latest version, so there is nothing more to do
			return true;
		}

		$lock_path = $applied_migrations_path . '.lock';
		if (!@mkdir($lock_path)) {
			// Someone is probably already executing the migrations (the folder
			// already exists).
			// We should probably return something else, but we don't want the
			// user to think there is an error (it's normal workflow), so let's
			// stick to this solution for now.
			// Another option would be to show him a maintenance page.
			Minz_Log::warning(
				'A request has been served while the application wasn’t up-to-date. '
				. 'Too many of these errors probably means a previous migration failed.'
			);
			return true;
		}

		$migrator = new self($migrations_path);
		if ($applied_migrations) {
			$migrator->setAppliedVersions($applied_migrations);
		}
		$results = $migrator->migrate();

		foreach ($results as $migration => $result) {
			if ($result === true) {
				$result = 'OK';
			} elseif ($result === false) {
				$result = 'KO';
			}

			Minz_Log::notice("Migration {$migration}: {$result}");
		}

		$applied_versions = implode("\n", $migrator->appliedVersions());
		$saved = file_put_contents($applied_migrations_path, $applied_versions);

		if (!@rmdir($lock_path)) {
			Minz_Log::error(
				'We weren’t able to unlink the migration executing folder, '
				. 'you might want to delete yourself: ' . $lock_path
			);
			// we don't return early because the migrations could have been
			// applied successfully. This file is not "critical" if not removed
			// and more errors will eventually appear in the logs.
		}

		if ($saved === false) {
			return "Cannot save the {$applied_migrations_path} file";
		}

		if (!$migrator->upToDate()) {
			// still not up to date? It means last migration failed.
			return trim('A migration failed to be applied, please see previous logs.' . "\n" . implode("\n", $results));
		}

		return true;
	}

	/**
	 * Create a Minz_Migrator instance. If directory is given, it'll load the
	 * migrations from it.
	 *
	 * All the files in the directory must declare a class named
	 * <app_name>_Migration_<filename> with a static `migrate` method.
	 *
	 * - <app_name> is the application name declared in the APP_NAME constant
	 * - <filename> is the migration file name, without the `.php` extension
	 *
	 * The files starting with a dot are ignored.
	 *
	 * @param string|null $directory
	 *
	 * @throws BadFunctionCallException if a callback isn't callable (i.e.
	 *                                  cannot call a migrate method).
	 */
	public function __construct($directory = null)
	{
		$this->applied_versions = [];

		if (!is_dir($directory)) {
			return;
		}

		foreach (scandir($directory) as $filename) {
			if ($filename[0] === '.') {
				continue;
			}

			$filepath = $directory . '/' . $filename;
			$migration_version = basename($filename, '.php');
			$migration_class = APP_NAME . "_Migration_" . $migration_version;
			$migration_callback = $migration_class . '::migrate';

			$include_result = @include_once($filepath);
			if (!$include_result) {
				Minz_Log::error(
					"{$filepath} migration file cannot be loaded.",
					ADMIN_LOG
				);
			}
			$this->addMigration($migration_version, $migration_callback);
		}
	}

	/**
	 * Register a migration into the migration system.
	 *
	 * @param string $version The version of the migration (be careful, migrations
	 *                        are sorted with the `strnatcmp` function)
	 * @param callback $callback The migration function to execute, it should
	 *                           return true on success and must return false
	 *                           on error
	 *
	 * @throws BadFunctionCallException if the callback isn't callable.
	 */
	public function addMigration($version, $callback)
	{
		if (!is_callable($callback)) {
			throw new BadFunctionCallException("{$version} migration cannot be called.");
		}

		$this->migrations[$version] = $callback;
	}

	/**
	 * Return the list of migrations, sorted with `strnatcmp`
	 *
	 * @see https://www.php.net/manual/en/function.strnatcmp.php
	 *
	 * @return array
	 */
	public function migrations()
	{
		$migrations = $this->migrations;
		uksort($migrations, 'strnatcmp');
		return $migrations;
	}

	/**
	 * Set the applied versions of the application.
	 *
	 * @param array<string> $versions
	 *
	 * @throws DomainException if there is no migrations corresponding to a version
	 */
	public function setAppliedVersions($versions)
	{
		foreach ($versions as $version) {
			$version = trim($version);
			if (!isset($this->migrations[$version])) {
				throw new DomainException("{$version} migration does not exist.");
			}
			$this->applied_versions[] = $version;
		}
	}

	/**
	 * @return string[]
	 */
	public function appliedVersions()
	{
		$versions = $this->applied_versions;
		usort($versions, 'strnatcmp');
		return $versions;
	}

	/**
	 * Return the list of available versions, sorted with `strnatcmp`
	 *
	 * @see https://www.php.net/manual/en/function.strnatcmp.php
	 *
	 * @return string[]
	 */
	public function versions()
	{
		$migrations = $this->migrations();
		return array_keys($migrations);
	}

	/**
	 * @return boolean Return true if the application is up-to-date, false
	 *                 otherwise. If no migrations are registered, it always
	 *                 returns true.
	 */
	public function upToDate()
	{
		// Counting versions is enough since we cannot apply a version which
		// doesn't exist (see setAppliedVersions method).
		return count($this->versions()) === count($this->applied_versions);
	}

	/**
	 * Migrate the system to the latest version.
	 *
	 * It only executes migrations AFTER the current version. If a migration
	 * returns false or fails, it immediatly stops the process.
	 *
	 * If the migration doesn't return false nor raise an exception, it is
	 * considered as successful. It is considered as good practice to return
	 * true on success though.
	 *
	 * @return array Return the results of each executed migration. If an
	 *               exception was raised in a migration, its result is set to
	 *               the exception message.
	 */
	public function migrate()
	{
		$result = [];
		foreach ($this->migrations() as $version => $callback) {
			if (in_array($version, $this->applied_versions)) {
				// the version is already applied so we skip this migration
				continue;
			}

			try {
				$migration_result = $callback();
				$result[$version] = $migration_result;
			} catch (Exception $e) {
				$migration_result = false;
				$result[$version] = $e->getMessage();
			}

			if ($migration_result === false) {
				break;
			}

			$this->applied_versions[] = $version;
		}

		return $result;
	}
}

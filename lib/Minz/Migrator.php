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
	/** @var string|null */
	private $version;

	/** @var array */
	private $migrations = [];

	/**
	 * Execute a list of migrations, starting from version indicated in a file
	 *
	 * @param string $migrations_path
	 * @param string $migrations_version_path
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
	public static function execute($migrations_path, $migrations_version_path) {
		if (!file_exists($migrations_version_path)) {
			return "{$migrations_version_path} file does not exist";
		}

		$migrations_version_file = fopen($migrations_version_path, 'r+');

		// we need a to acquire a lock to avoid multiple migrations at the same
		// time if several users try to access the application.
		if (!flock($migrations_version_file, LOCK_EX)) {
			return "Cannot get a lock on {$migrations_version_path} file";
		}

		$migrations_version_size = filesize($migrations_version_path);
		if ($migrations_version_size > 0) {
			$current_migration_version = fread(
				$migrations_version_file,
				$migrations_version_size
			);

			if ($current_migration_version === false) {
				flock($migrations_version_file, LOCK_UN);
				fclose($migrations_version_file);
				return "Cannot open the {$migrations_version_path} file";
			}
		} else {
			$current_migration_version = null;
		}

		$migrator = new self($migrations_path);
		if ($current_migration_version) {
			$migrator->setVersion($current_migration_version);
		}

		if ($migrator->upToDate()) {
			// already at the latest version, so there is nothing more to do
			flock($migrations_version_file, LOCK_UN);
			fclose($migrations_version_file);
			return true;
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

		$new_version = $migrator->version();
		ftruncate($migrations_version_file, 0);
		rewind($migrations_version_file);
		$saved = fwrite($migrations_version_file, $new_version);

		flock($migrations_version_file, LOCK_UN);
		fclose($migrations_version_file);

		if ($saved === false) {
			return "Cannot save the {$migrations_version_path} file ({$new_version})";
		}

		if (!$migrator->upToDate()) {
			// still not up to date? It means last migration failed.
			return 'A migration failed to be applied, please see previous logs';
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
		if (!is_dir($directory)) {
			return;
		}

		foreach (scandir($directory) as $filename) {
			if ($filename[0] === '.') {
				continue;
			}

			$filepath = $directory . '/' . $filename;
			$migration_name = basename($filename, '.php');
			$migration_class = APP_NAME . "_Migration_" . $migration_name;
			$migration_callback = $migration_class . '::migrate';

			$include_result = @include_once($filepath);
			if (!$include_result) {
				Minz_Log::error(
					"{$filepath} migration file cannot be loaded.",
					ADMIN_LOG
				);
			}
			$this->addMigration($migration_name, $migration_callback);
		}
	}

	/**
	 * Register a migration into the migration system.
	 *
	 * @param string $name The name of the migration (be careful, migrations
	 *                     are sorted with the `strnatcmp` function)
	 * @param callback $callback The migration function to execute, it should
	 *                           return true on success and must return false
	 *                           on error
	 *
	 * @throws BadFunctionCallException if the callback isn't callable.
	 */
	public function addMigration($name, $callback)
	{
		if (!is_callable($callback)) {
			throw new BadFunctionCallException("{$name} migration cannot be called.");
		}

		$this->migrations[$name] = $callback;
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
	 * Set the actual version of the application.
	 *
	 * @param string $version
	 *
	 * @throws DomainException if there is no migrations corresponding to the
	 *                         given version.
	 */
	public function setVersion($version)
	{
		$version = trim($version);
		if (!isset($this->migrations[$version])) {
			throw new DomainException("{$version} migration does not exist.");
		}

		$this->version = $version;
	}

	/**
	 * @return string|null
	 */
	public function version()
	{
		return $this->version;
	}

	/**
	 * @return string|null
	 */
	public function lastVersion()
	{
		$migrations = array_keys($this->migrations());
		if (!$migrations) {
			return null;
		}

		return end($migrations);
	}

	/**
	 * @return boolean Return true if the application is up-to-date, false
	 *                 otherwise. If no migrations are registered, it always
	 *                 returns true.
	 */
	public function upToDate()
	{
		return $this->version === $this->lastVersion();
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
		$apply_migrations = $this->version === null;
		foreach ($this->migrations() as $version => $migration) {
			if (!$apply_migrations) {
				$apply_migrations = $this->version === $version;
				continue;
			}

			try {
				$migration_result = $migration();
				$result[$version] = $migration_result;
			} catch (Exception $e) {
				$migration_result = false;
				$result[$version] = $e->getMessage();
			}

			if ($migration_result === false) {
				break;
			}

			$this->version = $version;
		}

		return $result;
	}
}

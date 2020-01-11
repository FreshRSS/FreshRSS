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

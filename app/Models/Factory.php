<?php
declare(strict_types=1);

class FreshRSS_Factory {

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createUserDao(?string $username = null): FreshRSS_UserDAO {
		return new FreshRSS_UserDAO($username);
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createCategoryDao(?string $username = null): FreshRSS_CategoryDAO {
		return match (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new FreshRSS_CategoryDAOSQLite($username),
			default => new FreshRSS_CategoryDAO($username),
		};
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createFeedDao(?string $username = null): FreshRSS_FeedDAO {
		return match (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new FreshRSS_FeedDAOSQLite($username),
			default => new FreshRSS_FeedDAO($username),
		};
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createEntryDao(?string $username = null): FreshRSS_EntryDAO {
		return match (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new FreshRSS_EntryDAOSQLite($username),
			'pgsql' => new FreshRSS_EntryDAOPGSQL($username),
			default => new FreshRSS_EntryDAO($username),
		};
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createTagDao(?string $username = null): FreshRSS_TagDAO {
		return match (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new FreshRSS_TagDAOSQLite($username),
			'pgsql' => new FreshRSS_TagDAOPGSQL($username),
			default => new FreshRSS_TagDAO($username),
		};
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createStatsDAO(?string $username = null): FreshRSS_StatsDAO {
		return match (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new FreshRSS_StatsDAOSQLite($username),
			'pgsql' => new FreshRSS_StatsDAOPGSQL($username),
			default => new FreshRSS_StatsDAO($username),
		};
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createDatabaseDAO(?string $username = null): FreshRSS_DatabaseDAO {
		return match (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new FreshRSS_DatabaseDAOSQLite($username),
			'pgsql' => new FreshRSS_DatabaseDAOPGSQL($username),
			default => new FreshRSS_DatabaseDAO($username),
		};
	}
}

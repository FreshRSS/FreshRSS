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
		switch (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			case 'sqlite':
				return new FreshRSS_CategoryDAOSQLite($username);
			default:
				return new FreshRSS_CategoryDAO($username);
		}
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createFeedDao(?string $username = null): FreshRSS_FeedDAO {
		switch (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			case 'sqlite':
				return new FreshRSS_FeedDAOSQLite($username);
			default:
				return new FreshRSS_FeedDAO($username);
		}
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createEntryDao(?string $username = null): FreshRSS_EntryDAO {
		switch (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			case 'sqlite':
				return new FreshRSS_EntryDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_EntryDAOPGSQL($username);
			default:
				return new FreshRSS_EntryDAO($username);
		}
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createTagDao(?string $username = null): FreshRSS_TagDAO {
		switch (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			case 'sqlite':
				return new FreshRSS_TagDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_TagDAOPGSQL($username);
			default:
				return new FreshRSS_TagDAO($username);
		}
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createStatsDAO(?string $username = null): FreshRSS_StatsDAO {
		switch (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			case 'sqlite':
				return new FreshRSS_StatsDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_StatsDAOPGSQL($username);
			default:
				return new FreshRSS_StatsDAO($username);
		}
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException|Minz_PDOConnectionException
	 */
	public static function createDatabaseDAO(?string $username = null): FreshRSS_DatabaseDAO {
		switch (FreshRSS_Context::systemConf()->db['type'] ?? '') {
			case 'sqlite':
				return new FreshRSS_DatabaseDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_DatabaseDAOPGSQL($username);
			default:
				return new FreshRSS_DatabaseDAO($username);
		}
	}
}

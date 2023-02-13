<?php

class FreshRSS_Factory {

	/**
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public static function createUserDao(?string $username = null): FreshRSS_UserDAO {
		return new FreshRSS_UserDAO($username);
	}

	/**
	 * @return FreshRSS_CategoryDAOSQLite|FreshRSS_CategoryDAO
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public static function createCategoryDao(?string $username = null) {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_CategoryDAOSQLite($username);
			default:
				return new FreshRSS_CategoryDAO($username);
		}
	}

	/**
	 * @return FreshRSS_FeedDAOSQLite|FreshRSS_FeedDAO
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public static function createFeedDao(?string $username = null) {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_FeedDAOSQLite($username);
			default:
				return new FreshRSS_FeedDAO($username);
		}
	}

	/**
	 * @return FreshRSS_EntryDAOSQLite|FreshRSS_EntryDAOPGSQL|FreshRSS_EntryDAO
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public static function createEntryDao(?string $username = null) {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_EntryDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_EntryDAOPGSQL($username);
			default:
				return new FreshRSS_EntryDAO($username);
		}
	}

	/**
	 * @return FreshRSS_TagDAOSQLite|FreshRSS_TagDAOPGSQL|FreshRSS_TagDAO
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public static function createTagDao(?string $username = null) {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_TagDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_TagDAOPGSQL($username);
			default:
				return new FreshRSS_TagDAO($username);
		}
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public static function createStatsDAO(?string $username = null): FreshRSS_StatsDAO {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_StatsDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_StatsDAOPGSQL($username);
			default:
				return new FreshRSS_StatsDAO($username);
		}
	}

	/**
	 * @return FreshRSS_DatabaseDAOSQLite|FreshRSS_DatabaseDAOPGSQL|FreshRSS_DatabaseDAO
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public static function createDatabaseDAO(?string $username = null) {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_DatabaseDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_DatabaseDAOPGSQL($username);
			default:
				return new FreshRSS_DatabaseDAO($username);
		}
	}

}

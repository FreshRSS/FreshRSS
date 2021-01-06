<?php

class FreshRSS_Factory {

	public static function createUserDao($username = null) {
		return new FreshRSS_UserDAO($username);
	}

	public static function createCategoryDao($username = null) {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_CategoryDAOSQLite($username);
			default:
				return new FreshRSS_CategoryDAO($username);
		}
	}

	public static function createFeedDao($username = null) {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_FeedDAOSQLite($username);
			default:
				return new FreshRSS_FeedDAO($username);
		}
	}

	public static function createEntryDao($username = null) {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_EntryDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_EntryDAOPGSQL($username);
			default:
				return new FreshRSS_EntryDAO($username);
		}
	}

	public static function createTagDao($username = null) {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_TagDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_TagDAOPGSQL($username);
			default:
				return new FreshRSS_TagDAO($username);
		}
	}

	public static function createStatsDAO($username = null) {
		switch (FreshRSS_Context::$system_conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_StatsDAOSQLite($username);
			case 'pgsql':
				return new FreshRSS_StatsDAOPGSQL($username);
			default:
				return new FreshRSS_StatsDAO($username);
		}
	}

	public static function createDatabaseDAO($username = null) {
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

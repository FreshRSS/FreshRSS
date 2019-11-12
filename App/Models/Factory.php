<?php

namespace Freshrss\Models;

class Factory {

	public static function createUserDao($username = null) {
		return new UserDAO($username);
	}

	public static function createCategoryDao($username = null) {
		$conf = Configuration::get('system');
		switch ($conf->db['type']) {
			case 'sqlite':
				return new CategoryDAOSQLite($username);
			default:
				return new CategoryDAO($username);
		}
	}

	public static function createFeedDao($username = null) {
		$conf = Configuration::get('system');
		switch ($conf->db['type']) {
			case 'sqlite':
				return new FeedDAOSQLite($username);
			default:
				return new FeedDAO($username);
		}
	}

	public static function createEntryDao($username = null) {
		$conf = Configuration::get('system');
		switch ($conf->db['type']) {
			case 'sqlite':
				return new EntryDAOSQLite($username);
			case 'pgsql':
				return new EntryDAOPGSQL($username);
			default:
				return new EntryDAO($username);
		}
	}

	public static function createTagDao($username = null) {
		$conf = Configuration::get('system');
		switch ($conf->db['type']) {
			case 'sqlite':
				return new TagDAOSQLite($username);
			case 'pgsql':
				return new TagDAOPGSQL($username);
			default:
				return new TagDAO($username);
		}
	}

	public static function createStatsDAO($username = null) {
		$conf = Configuration::get('system');
		switch ($conf->db['type']) {
			case 'sqlite':
				return new StatsDAOSQLite($username);
			case 'pgsql':
				return new StatsDAOPGSQL($username);
			default:
				return new StatsDAO($username);
		}
	}

	public static function createDatabaseDAO($username = null) {
		$conf = Configuration::get('system');
		switch ($conf->db['type']) {
			case 'sqlite':
				return new DatabaseDAOSQLite($username);
			case 'pgsql':
				return new DatabaseDAOPGSQL($username);
			default:
				return new DatabaseDAO($username);
		}
	}

}

<?php

class FreshRSS_Factory {

	public static function createFeedDao($username = null) {
		$conf = Minz_Configuration::get('system');
		switch ($conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_FeedDAOSQLite($username);
				break;
			default:
				return new FreshRSS_FeedDAO($username);
		}
	}


	public static function createEntryDao($username = null) {
		$conf = Minz_Configuration::get('system');
		switch ($conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_EntryDAOSQLite($username);
				break;
			case 'pgsql':
				return new FreshRSS_EntryDAOpgSQL($username);
				break;
			default:
				return new FreshRSS_EntryDAO($username);
		}
	}

	public static function createStatsDAO($username = null) {
		$conf = Minz_Configuration::get('system');
		switch ($conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_StatsDAOSQLite($username);
				break;
			case 'pgsql':
				return new FreshRSS_StatsDAOpgSQL($username);
				break;
			default:
				return new FreshRSS_StatsDAO($username);
		}
	}

	public static function createDatabaseDAO($username = null) {
		$conf = Minz_Configuration::get('system');
		switch ($conf->db['type']) {
			case 'sqlite':
				return new FreshRSS_DatabaseDAOSQLite($username);
				break;
			case 'pgsql':
				return new FreshRSS_DatabaseDAOpgSQL($username);
				break;
			default:
				return new FreshRSS_DatabaseDAO($username);
		}
	}

}

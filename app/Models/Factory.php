<?php

class FreshRSS_Factory {

	public static function createFeedDao($username = null) {
		$conf = Minz_Configuration::get('system');
		if ($conf->db['type'] === 'sqlite') {
			return new FreshRSS_FeedDAOSQLite($username);
		} else {
			return new FreshRSS_FeedDAO($username);
		}
	}

	public static function createEntryDao($username = null) {
		$conf = Minz_Configuration::get('system');
		if ($conf->db['type'] === 'sqlite') {
			return new FreshRSS_EntryDAOSQLite($username);
		} else {
			return new FreshRSS_EntryDAO($username);
		}
	}

	public static function createStatsDAO($username = null) {
		$conf = Minz_Configuration::get('system');
		if ($conf->db['type'] === 'sqlite') {
			return new FreshRSS_StatsDAOSQLite($username);
		} else {
			return new FreshRSS_StatsDAO($username);
		}
	}

	public static function createDatabaseDAO($username = null) {
		$conf = Minz_Configuration::get('system');
		if ($conf->db['type'] === 'sqlite') {
			return new FreshRSS_DatabaseDAOSQLite($username);
		} else {
			return new FreshRSS_DatabaseDAO($username);
		}
	}

}

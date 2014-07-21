<?php

class FreshRSS_Factory {

	public static function createFeedDao() {
		$db = Minz_Configuration::dataBase();
		if ($db['type'] === 'sqlite') {
			return new FreshRSS_FeedDAOSQLite();
		} else {
			return new FreshRSS_FeedDAO();
		}
	}

	public static function createEntryDao() {
		$db = Minz_Configuration::dataBase();
		if ($db['type'] === 'sqlite') {
			return new FreshRSS_EntryDAOSQLite();
		} else {
			return new FreshRSS_EntryDAO();
		}
	}

	public static function createStatsDAO() {
		$db = Minz_Configuration::dataBase();
		if ($db['type'] === 'sqlite') {
			return new FreshRSS_StatsDAOSQLite();
		} else {
			return new FreshRSS_StatsDAO();
		}
	}

}

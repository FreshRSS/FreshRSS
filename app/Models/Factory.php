<?php

class FreshRSS_Factory {

	public static function createEntryDao() {
		$db = Minz_Configuration::dataBase();
		if ($db['type'] === 'sqlite') {
			return new FreshRSS_EntryDAO_SQLite();
		} else {
			return new FreshRSS_EntryDAO();
		}
	}
}

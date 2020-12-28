<?php

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
 */

class Minz_PdoSqlite extends Minz_Pdo {
	public function __construct($dsn, $username = null, $passwd = null, $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->exec('PRAGMA foreign_keys = ON;');
	}

	public function dbType() {
		return 'sqlite';
	}

	public function lastInsertId($name = null) {
		return parent::lastInsertId();	//We discard the name, only used by PostgreSQL
	}
}

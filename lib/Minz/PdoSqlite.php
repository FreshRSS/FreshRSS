<?php

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
 */

class Minz_PdoSqlite extends Minz_Pdo {
	/** @param array<int,int|string|bool>|null $options */
	public function __construct(string $dsn, ?string $username = null, ?string $passwd = null, ?array $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->exec('PRAGMA foreign_keys = ON;');
	}

	public function dbType(): string {
		return 'sqlite';
	}

	/**
	 * @param string|null $name
	 * @return string|false
	 */
	#[\ReturnTypeWillChange]
	public function lastInsertId($name = null) {
		return parent::lastInsertId();	//We discard the name, only used by PostgreSQL
	}
}

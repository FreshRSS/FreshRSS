<?php

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
 */

class Minz_PdoPgsql extends Minz_Pdo {
	/** @param array<int,int|string|bool>|null $options */
	public function __construct(string $dsn, ?string $username = null, ?string $passwd = null, ?array $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->exec("SET NAMES 'UTF8';");
	}

	public function dbType(): string {
		return 'pgsql';
	}

	protected function preSql(string $statement): string {
		$statement = parent::preSql($statement);
		return str_replace(array('`', ' LIKE '), array('"', ' ILIKE '), $statement);
	}
}

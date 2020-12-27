<?php

namespace Minz\Pdo;

class PdoMysql extends AbstractPdo {
	public function __construct($dsn, $username = null, $passwd = null, $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
	}

	public function dbType() {
		return 'mysql';
	}

	public function lastInsertId($name = null) {
		return parent::lastInsertId();	//We discard the name, only used by PostgreSQL
	}
}

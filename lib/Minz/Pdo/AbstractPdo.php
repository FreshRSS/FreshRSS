<?php

namespace Minz\Pdo;

abstract class AbstractPdo extends \PDO {
	public function __construct($dsn, $username = null, $passwd = null, $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
	}

	abstract public function dbType();

	private $prefix = '';
	public function prefix() { return $this->prefix; }
	public function setPrefix($prefix) { $this->prefix = $prefix; }

	private function autoPrefix($sql) {
		return str_replace('`_', '`' . $this->prefix, $sql);
	}

	protected function preSql($statement) {
		if (preg_match('/^(?:UPDATE|INSERT|DELETE)/i', $statement)) {
			invalidateHttpCache();
		}
		return $this->autoPrefix($statement);
	}

	public function lastInsertId($name = null) {
		if ($name != null) {
			$name = $this->preSql($name);
		}
		return parent::lastInsertId($name);
	}

	public function prepare($statement, $driver_options = array()) {
		$statement = $this->preSql($statement);
		return parent::prepare($statement, $driver_options);
	}

	public function exec($statement) {
		$statement = $this->preSql($statement);
		return parent::exec($statement);
	}

	public function query($query, $fetch_mode = null, ...$fetch_mode_args) {
		$query = $this->preSql($query);
		return $fetch_mode ? parent::query($query, $fetch_mode, ...$fetch_mode_args) : parent::query($query);
	}
}

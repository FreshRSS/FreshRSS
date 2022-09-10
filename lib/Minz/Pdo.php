<?php

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
 */

abstract class Minz_Pdo extends PDO {
	public function __construct(string $dsn, $username = null, $passwd = null, $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}

	abstract public function dbType();

	private $prefix = '';
	public function prefix(): string {
		return $this->prefix;
	}
	public function setPrefix(string $prefix) {
		$this->prefix = $prefix;
	}

	private function autoPrefix(string $sql): string {
		return str_replace('`_', '`' . $this->prefix, $sql);
	}

	protected function preSql(string $statement): string {
		if (preg_match('/^(?:UPDATE|INSERT|DELETE)/i', $statement)) {
			invalidateHttpCache();
		}
		return $this->autoPrefix($statement);
	}

	// PHP8+: PDO::lastInsertId(?string $name = null): string|false
	#[\ReturnTypeWillChange]
	public function lastInsertId($name = null) {
		if ($name != null) {
			$name = $this->preSql($name);
		}
		return parent::lastInsertId($name);
	}

	// PHP8+: PDO::prepare(string $query, array $options = []): PDOStatement|false
	#[\ReturnTypeWillChange]
	public function prepare($statement, $driver_options = []) {
		$statement = $this->preSql($statement);
		return parent::prepare($statement, $driver_options);
	}

	// PHP8+: PDO::exec(string $statement): int|false
	#[\ReturnTypeWillChange]
	public function exec($statement) {
		$statement = $this->preSql($statement);
		return parent::exec($statement);
	}

	// PHP8+: PDO::query(string $query, ?int $fetchMode = null, mixed ...$fetchModeArgs): PDOStatement|false
	#[\ReturnTypeWillChange]
	public function query($query, $fetch_mode = null, ...$fetch_mode_args) {
		$query = $this->preSql($query);
		return $fetch_mode ? parent::query($query, $fetch_mode, ...$fetch_mode_args) : parent::query($query);
	}
}

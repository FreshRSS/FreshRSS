<?php

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
 */

abstract class Minz_Pdo extends PDO {
	/** @param array<int,int|string|bool>|null $options */
	public function __construct(string $dsn, ?string $username = null, ?string $passwd = null, ?array $options = null) {
		parent::__construct($dsn, $username, $passwd, $options);
		$this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}

	abstract public function dbType(): string;

	private string $prefix = '';
	public function prefix(): string {
		return $this->prefix;
	}
	public function setPrefix(string $prefix): void {
		$this->prefix = $prefix;
	}

	private function autoPrefix(string $sql): string {
		return str_replace('`_', '`' . $this->prefix, $sql);
	}

	protected function preSql(string $statement): string {
		if (preg_match('/^(?:UPDATE|INSERT|DELETE)/i', $statement) === 1) {
			invalidateHttpCache();
		}
		return $this->autoPrefix($statement);
	}

	// PHP8+: PDO::lastInsertId(?string $name = null): string|false
	/**
	 * @param string|null $name
	 * @return string|false
	 */
	#[\ReturnTypeWillChange]
	public function lastInsertId($name = null) {
		if ($name != null) {
			$name = $this->preSql($name);
		}
		return parent::lastInsertId($name);
	}

	// PHP8+: PDO::prepare(string $query, array $options = []): PDOStatement|false
	/**
	 * @param string $query
	 * @param array<int,string> $options
	 * @return PDOStatement|false
	 * @phpstan-ignore-next-line
	 */
	#[\ReturnTypeWillChange]
	public function prepare($query, $options = []) {
		$query = $this->preSql($query);
		return parent::prepare($query, $options);
	}

	// PHP8+: PDO::exec(string $statement): int|false
	/**
	 * @param string $statement
	 * @return int|false
	 */
	#[\ReturnTypeWillChange]
	public function exec($statement) {
		$statement = $this->preSql($statement);
		return parent::exec($statement);
	}

	/** @return PDOStatement|false */
	#[\ReturnTypeWillChange]
	public function query(string $query, ?int $fetch_mode = null, ...$fetch_mode_args) {
		$query = $this->preSql($query);
		return $fetch_mode === null ? parent::query($query) : parent::query($query, $fetch_mode, ...$fetch_mode_args);
	}
}

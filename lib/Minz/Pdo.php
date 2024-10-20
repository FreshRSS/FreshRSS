<?php
declare(strict_types=1);

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
 */

abstract class Minz_Pdo extends PDO {
	/**
	 * @param array<int,int|string|bool>|null $options
	 * @throws PDOException
	 */
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

	/**
	 * @throws PDOException if the attribute `PDO::ATTR_ERRMODE` is set to `PDO::ERRMODE_EXCEPTION`
	 */
	#[\Override]
	public function lastInsertId(?string $name = null): string|false {
		if ($name != null) {
			$name = $this->preSql($name);
		}
		return parent::lastInsertId($name);
	}

	/**
	 * @param array<int,string> $options
	 * @throws PDOException if the attribute `PDO::ATTR_ERRMODE` is set to `PDO::ERRMODE_EXCEPTION`
	 * @phpstan-ignore method.childParameterType, throws.unusedType
	 */
	#[\Override]
	public function prepare(string $query, array $options = []): PDOStatement|false {
		$query = $this->preSql($query);
		return parent::prepare($query, $options);
	}

	/**
	 * @throws PDOException if the attribute `PDO::ATTR_ERRMODE` is set to `PDO::ERRMODE_EXCEPTION`
	 * @phpstan-ignore throws.unusedType
	 */
	#[\Override]
	public function exec(string $statement): int|false {
		$statement = $this->preSql($statement);
		return parent::exec($statement);
	}

	/**
	 * @throws PDOException if the attribute `PDO::ATTR_ERRMODE` is set to `PDO::ERRMODE_EXCEPTION`
	 * @phpstan-ignore throws.unusedType
	 */
	#[\Override]
	public function query(string $query, ?int $fetch_mode = null, ...$fetch_mode_args): PDOStatement|false {
		$query = $this->preSql($query);
		return $fetch_mode === null ? parent::query($query) : parent::query($query, $fetch_mode, ...$fetch_mode_args);
	}
}

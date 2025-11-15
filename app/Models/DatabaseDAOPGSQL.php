<?php
declare(strict_types=1);

/**
 * This class is used to test database is well-constructed.
 */
class FreshRSS_DatabaseDAOPGSQL extends FreshRSS_DatabaseDAOSQLite {

	//PostgreSQL error codes
	public const UNDEFINED_COLUMN = '42703';
	public const UNDEFINED_TABLE = '42P01';

	#[\Override]
	public function tablesAreCorrect(): bool {
		$db = FreshRSS_Context::systemConf()->db;
		$sql = 'SELECT * FROM pg_catalog.pg_tables where tableowner=:tableowner';
		$res = $this->fetchAssoc($sql, [':tableowner' => $db['user']]);
		if ($res == null) {
			return false;
		}

		$tables = [
			$this->pdo->prefix() . 'category' => false,
			$this->pdo->prefix() . 'feed' => false,
			$this->pdo->prefix() . 'entry' => false,
			$this->pdo->prefix() . 'entrytmp' => false,
			$this->pdo->prefix() . 'tag' => false,
			$this->pdo->prefix() . 'entrytag' => false,
		];
		foreach ($res as $value) {
			$tables[array_pop($value)] = true;
		}

		return count(array_keys($tables, true, true)) === count($tables);
	}

	/** @return list<array{name:string,type:string,notnull:bool,default:mixed}> */
	#[\Override]
	public function getSchema(string $table): array {
		$sql = <<<'SQL'
SELECT column_name AS field, data_type AS type, column_default AS default, is_nullable AS null
FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :table_name
SQL;
		$res = $this->fetchAssoc($sql, [':table_name' => $this->pdo->prefix() . $table]);
		return $res == null ? [] : $this->listDaoToSchema($res);
	}

	/**
	 * @param array<string,string|int|bool|null> $dao
	 * @return array{'name':string,'type':string,'notnull':bool,'default':mixed}
	 */
	#[\Override]
	public function daoToSchema(array $dao): array {
		return [
			'name' => is_string($dao['field'] ?? null) ? $dao['field'] : '',
			'type' => is_string($dao['type'] ?? null) ? strtolower($dao['type']) : '',
			'notnull' => empty($dao['null']),
			'default' => is_scalar($dao['default'] ?? null) ? $dao['default'] : null,
		];
	}

	#[\Override]
	protected function selectVersion(): string {
		return $this->fetchValue('SELECT version()') ?? '';
	}

	#[\Override]
	public function size(bool $all = false): int {
		if ($all) {
			$db = FreshRSS_Context::systemConf()->db;
			$res = $this->fetchColumn('SELECT pg_database_size(:base)', 0, [':base' => $db['base']]);
		} else {
			$sql = <<<SQL
SELECT
pg_total_relation_size('`{$this->pdo->prefix()}category`') +
pg_total_relation_size('`{$this->pdo->prefix()}feed`') +
pg_total_relation_size('`{$this->pdo->prefix()}entry`') +
pg_total_relation_size('`{$this->pdo->prefix()}entrytmp`') +
pg_total_relation_size('`{$this->pdo->prefix()}tag`') +
pg_total_relation_size('`{$this->pdo->prefix()}entrytag`')
SQL;
			$res = $this->fetchColumn($sql, 0);
		}
		return (int)($res[0] ?? -1);
	}

	#[\Override]
	public function optimize(): bool {
		$ok = true;
		$tables = ['category', 'feed', 'entry', 'entrytmp', 'tag', 'entrytag'];

		foreach ($tables as $table) {
			$sql = 'VACUUM `_' . $table . '`';
			if ($this->pdo->exec($sql) === false) {
				$ok = false;
				$info = $this->pdo->errorInfo();
				Minz_Log::warning(__METHOD__ . ' error: ' . $sql . ' : ' . json_encode($info));
			}
		}
		return $ok;
	}
}

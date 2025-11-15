<?php
declare(strict_types=1);

/**
 * This class is used to test database is well-constructed (SQLite).
 */
class FreshRSS_DatabaseDAOSQLite extends FreshRSS_DatabaseDAO {

	#[\Override]
	public function tablesAreCorrect(): bool {
		$sql = "SELECT name FROM sqlite_master WHERE type='table'";
		$stm = $this->pdo->query($sql);
		$res = $stm !== false ? $stm->fetchAll(PDO::FETCH_ASSOC) : false;
		if ($res === false) {
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
			if (is_array($value) && is_string($value['name'] ?? null)) {
				$tables[$value['name']] = true;
			}
		}

		return count(array_keys($tables, true, true)) == count($tables);
	}

	/** @return list<array{name:string,type:string,notnull:bool,default:mixed}> */
	#[\Override]
	public function getSchema(string $table): array {
		$sql = 'PRAGMA table_info(' . $table . ')';
		$stm = $this->pdo->query($sql);
		if ($stm !== false && ($res = $stm->fetchAll(PDO::FETCH_ASSOC)) !== false) {
			/** @var list<array{name:string,type:string,notnull:bool,dflt_value:string|int|bool|null}> $res */
			return $this->listDaoToSchema($res);
		}
		return [];
	}

	#[\Override]
	public function entryIsCorrect(): bool {
		return $this->checkTable('entry', [
			'id', 'guid', 'title', 'author', 'content', 'link', 'date', 'lastSeen', 'hash', 'is_read', 'is_favorite', 'id_feed', 'tags',
		]);
	}

	#[\Override]
	public function entrytmpIsCorrect(): bool {
		return $this->checkTable('entrytmp', [
			'id', 'guid', 'title', 'author', 'content', 'link', 'date', 'lastSeen', 'hash', 'is_read', 'is_favorite', 'id_feed', 'tags'
		]);
	}

	/**
	 * @param array<string,string|int|bool|null> $dao
	 * @return array{'name':string,'type':string,'notnull':bool,'default':mixed}
	 */
	#[\Override]
	public function daoToSchema(array $dao): array {
		return [
			'name'    => is_string($dao['name'] ?? null) ? $dao['name'] : '',
			'type'    => is_string($dao['type'] ?? null) ? strtolower($dao['type']) : '',
			'notnull' => empty($dao['notnull']),
			'default' => is_scalar($dao['dflt_value'] ?? null) ? $dao['dflt_value'] : null,
		];
	}

	#[\Override]
	protected function selectVersion(): string {
		return $this->fetchValue('SELECT sqlite_version()') ?? '';
	}

	#[\Override]
	public function size(bool $all = false): int {
		$sum = 0;
		if ($all) {
			foreach (glob(DATA_PATH . '/users/*/db.sqlite') ?: [] as $filename) {
				$sum += (@filesize($filename) ?: 0);
			}
		} else {
			$sum = (@filesize(DATA_PATH . '/users/' . $this->current_user . '/db.sqlite') ?: 0);
		}
		return $sum;
	}

	#[\Override]
	public function optimize(): bool {
		$ok = $this->pdo->exec('VACUUM') !== false;
		if (!$ok) {
			$info = $this->pdo->errorInfo();
			Minz_Log::warning(__METHOD__ . ' error : ' . json_encode($info));
		}
		return $ok;
	}
}

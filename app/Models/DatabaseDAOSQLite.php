<?php

/**
 * This class is used to test database is well-constructed (SQLite).
 */
class FreshRSS_DatabaseDAOSQLite extends FreshRSS_DatabaseDAO {

	public function tablesAreCorrect(): bool {
		$sql = 'SELECT name FROM sqlite_master WHERE type="table"';
		$stm = $this->pdo->query($sql);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		$tables = array(
			$this->pdo->prefix() . 'category' => false,
			$this->pdo->prefix() . 'feed' => false,
			$this->pdo->prefix() . 'entry' => false,
			$this->pdo->prefix() . 'entrytmp' => false,
			$this->pdo->prefix() . 'tag' => false,
			$this->pdo->prefix() . 'entrytag' => false,
		);
		foreach ($res as $value) {
			$tables[$value['name']] = true;
		}

		return count(array_keys($tables, true, true)) == count($tables);
	}

	/** @return array<array<string,string|bool>> */
	public function getSchema(string $table): array {
		$sql = 'PRAGMA table_info(' . $table . ')';
		$stm = $this->pdo->query($sql);
		return $this->listDaoToSchema($stm->fetchAll(PDO::FETCH_ASSOC));
	}

	public function entryIsCorrect(): bool {
		return $this->checkTable('entry', array(
			'id', 'guid', 'title', 'author', 'content', 'link', 'date', 'lastSeen', 'hash', 'is_read',
			'is_favorite', 'id_feed', 'tags',
		));
	}

	public function entrytmpIsCorrect(): bool {
		return $this->checkTable('entrytmp', array(
			'id', 'guid', 'title', 'author', 'content', 'link', 'date', 'lastSeen', 'hash', 'is_read',
			'is_favorite', 'id_feed', 'tags',
		));
	}

	/**
	 * @param array<string,string> $dao
	 * @return array<string,string|bool>
	 */
	public function daoToSchema(array $dao): array {
		return [
			'name'    => $dao['name'],
			'type'    => strtolower($dao['type']),
			'notnull' => $dao['notnull'] === '1' ? true : false,
			'default' => $dao['dflt_value'],
		];
	}

	public function size(bool $all = false): int {
		$sum = 0;
		if ($all) {
			foreach (glob(DATA_PATH . '/users/*/db.sqlite') as $filename) {
				$sum += @filesize($filename);
			}
		} else {
			$sum = @filesize(DATA_PATH . '/users/' . $this->current_user . '/db.sqlite');
		}
		return intval($sum);
	}

	public function optimize(): bool {
		$ok = $this->pdo->exec('VACUUM') !== false;
		if (!$ok) {
			$info = $this->pdo->errorInfo();
			Minz_Log::warning(__METHOD__ . ' error : ' . json_encode($info));
		}
		return $ok;
	}
}

<?php
declare(strict_types=1);

class FreshRSS_EntryDAOSQLite extends FreshRSS_EntryDAO {

	public static function isCompressed(): bool {
		return false;
	}

	public static function hasNativeHex(): bool {
		return false;
	}

	protected static function sqlConcat(string $s1, string $s2): string {
		return $s1 . '||' . $s2;
	}

	public static function sqlHexDecode(string $x): string {
		return $x;
	}

	public static function sqlIgnoreConflict(string $sql): string {
		return str_replace('INSERT INTO ', 'INSERT OR IGNORE INTO ', $sql);
	}

	/** @param array<string|int> $errorInfo */
	protected function autoUpdateDb(array $errorInfo): bool {
		if ($tableInfo = $this->pdo->query("PRAGMA table_info('entry')")) {
			$columns = $tableInfo->fetchAll(PDO::FETCH_COLUMN, 1) ?: [];
			foreach (['attributes'] as $column) {
				if (!in_array($column, $columns, true)) {
					return $this->addColumn($column);
				}
			}
		}
		return false;
	}

	public function commitNewEntries(): bool {
		$sql = <<<'SQL'
DROP TABLE IF EXISTS `tmp`;
CREATE TEMP TABLE `tmp` AS
	SELECT id, guid, title, author, content, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags, attributes
	FROM `_entrytmp`
	ORDER BY date, id;
INSERT OR IGNORE INTO `_entry`
	(id, guid, title, author, content, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags, attributes)
	SELECT rowid + (SELECT MAX(id) - COUNT(*) FROM `tmp`) AS id,
	guid, title, author, content, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags, attributes
	FROM `tmp`
	ORDER BY date, id;
DELETE FROM `_entrytmp` WHERE id <= (SELECT MAX(id) FROM `tmp`);
DROP TABLE IF EXISTS `tmp`;
SQL;
		$hadTransaction = $this->pdo->inTransaction();
		if (!$hadTransaction) {
			$this->pdo->beginTransaction();
		}
		$result = $this->pdo->exec($sql) !== false;
		if (!$result) {
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($this->pdo->errorInfo()));
		}
		if (!$hadTransaction) {
			$this->pdo->commit();
		}
		return $result;
	}

	/**
	 * Toggle the read marker on one or more article.
	 * Then the cache is updated.
	 *
	 * @param string|array<string> $ids
	 * @param bool $is_read
	 * @return int|false affected rows
	 */
	public function markRead($ids, bool $is_read = true) {
		FreshRSS_UserDAO::touch();
		if (is_array($ids)) {	//Many IDs at once (used by API)
			//if (true) {	//Speed heuristics	//TODO: Not implemented yet for SQLite (so always call IDs one by one)
				$affected = 0;
				foreach ($ids as $id) {
					$affected += ($this->markRead($id, $is_read) ?: 0);
				}
				return $affected;
			//}
		} else {
			$this->pdo->beginTransaction();
			$sql = 'UPDATE `_entry` SET is_read=? WHERE id=? AND is_read=?';
			$values = [$is_read ? 1 : 0, $ids, $is_read ? 0 : 1];
			$stm = $this->pdo->prepare($sql);
			if (!($stm && $stm->execute($values))) {
				$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
				Minz_Log::error('SQL error ' . __METHOD__ . ' A ' . json_encode($info));
				$this->pdo->rollBack();
				return false;
			}
			$affected = $stm->rowCount();
			if ($affected > 0) {
				$sql = 'UPDATE `_feed` SET `cache_nbUnreads`=`cache_nbUnreads`' . ($is_read ? '-' : '+') . '1 '
				 . 'WHERE id=(SELECT e.id_feed FROM `_entry` e WHERE e.id=?)';
				$values = [$ids];
				$stm = $this->pdo->prepare($sql);
				if (!($stm && $stm->execute($values))) {
					$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
					Minz_Log::error('SQL error ' . __METHOD__ . ' B ' . json_encode($info));
					$this->pdo->rollBack();
					return false;
				}
			}
			$this->pdo->commit();
			return $affected;
		}
	}

	/**
	 * Mark all the articles in a tag as read.
	 * @param int $id tag ID, or empty for targeting any tag
	 * @param string $idMax max article ID
	 * @return int|false affected rows
	 */
	public function markReadTag($id = 0, string $idMax = '0', ?FreshRSS_BooleanSearch $filters = null, int $state = 0, bool $is_read = true) {
		FreshRSS_UserDAO::touch();
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadTag(0) is deprecated!');
		}

		$sql = 'UPDATE `_entry` '
			 . 'SET is_read = ? '
			 . 'WHERE is_read <> ? AND id <= ? AND '
			 . 'id IN (SELECT et.id_entry FROM `_entrytag` et '
			 . ($id == 0 ? '' : 'WHERE et.id_tag = ?')
			 . ')';
		$values = [$is_read ? 1 : 0, $is_read ? 1 : 0, $idMax];
		if ($id != 0) {
			$values[] = $id;
		}

		[$searchValues, $search] = $this->sqlListEntriesWhere('e.', $filters, $state);

		$stm = $this->pdo->prepare($sql . $search);
		if (!($stm && $stm->execute(array_merge($values, $searchValues)))) {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
		$affected = $stm->rowCount();
		if (($affected > 0) && (!$this->updateCacheUnreads(null, null))) {
			return false;
		}
		return $affected;
	}
}

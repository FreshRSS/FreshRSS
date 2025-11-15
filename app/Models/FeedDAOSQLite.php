<?php
declare(strict_types=1);

class FreshRSS_FeedDAOSQLite extends FreshRSS_FeedDAOPGSQL {

	#[\Override]
	public function sqlResetSequence(): bool {
		return true;	// Nothing to do for SQLite
	}

	/** @param array{0:string,1:int,2:string} $errorInfo */
	#[\Override]
	public function autoUpdateDb(array $errorInfo): bool {
		if (($tableInfo = $this->pdo->query("PRAGMA table_info('feed')")) !== false) {
			$columns = $tableInfo->fetchAll(PDO::FETCH_COLUMN, 1);
			foreach (['kind'] as $column) {
				if (!in_array($column, $columns, true)) {
					return $this->addColumn($column);
				}
			}
		}
		return false;
	}

	#[\Override]
	public function updateCachedValues(int ...$feedIds): int|false {
		// 2 sub-requests with FOREIGN KEY(e.id_feed), INDEX(e.is_read) faster than 1 request with GROUP BY or CASE
		$sql = <<<'SQL'
			UPDATE `_feed`
			SET `cache_nbEntries`=(SELECT COUNT(e1.id) FROM `_entry` e1 WHERE e1.id_feed=`_feed`.id),
				`cache_nbUnreads`=(SELECT COUNT(e2.id) FROM `_entry` e2 WHERE e2.id_feed=`_feed`.id AND e2.is_read=0)
		SQL;
		if (count($feedIds) > 0) {
			$sql .= ' WHERE id IN (' . str_repeat('?,', count($feedIds) - 1) . '?)';
		}
		$stm = $this->pdo->prepare($sql);
		if ($stm !== false && $stm->execute($feedIds)) {
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}
}

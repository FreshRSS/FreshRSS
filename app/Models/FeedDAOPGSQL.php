<?php
declare(strict_types=1);

class FreshRSS_FeedDAOPGSQL extends FreshRSS_FeedDAO {

	#[\Override]
	public function sqlResetSequence(): bool {
		$sql = <<<'SQL'
SELECT setval('`_feed_id_seq`', COALESCE(MAX(id), 0) + 1, false) FROM `_feed`
SQL;
		return $this->pdo->exec($sql) !== false;
	}

	#[\Override]
	public function updateCachedValues(int ...$feedIds): int|false {
		// Compatible PostgreSQL, SQLite, MySQL 8.0+, but not MariaDB as of version 12.2.
		if (empty($feedIds)) {
			$whereFeedIds = 'true';
			$whereEntryIdFeeds = 'true';
		} else {
			$whereFeedIds = 'id IN (' . str_repeat('?,', count($feedIds) - 1) . '?)';
			$whereEntryIdFeeds = 'id_feed IN (' . str_repeat('?,', count($feedIds) - 1) . '?)';
		}
		$sql = <<<SQL
			WITH entry_counts AS (
				SELECT
					id_feed,
					COUNT(*) AS total_entries,
					SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) AS unread_entries
				FROM `_entry`
				WHERE $whereEntryIdFeeds
				GROUP BY id_feed
			)
			UPDATE `_feed`
			SET `cache_nbEntries` = COALESCE((
					SELECT c.total_entries
					FROM entry_counts AS c
					WHERE c.id_feed = `_feed`.id
				), 0),
				`cache_nbUnreads` = COALESCE((
					SELECT c.unread_entries
					FROM entry_counts AS c
					WHERE c.id_feed = `_feed`.id
				), 0)
			WHERE $whereFeedIds
			SQL;
		$stm = $this->pdo->prepare($sql);
		if ($stm !== false && $stm->execute(array_merge($feedIds, $feedIds))) {
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}
}

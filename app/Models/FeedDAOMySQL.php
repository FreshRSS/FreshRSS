<?php
declare(strict_types=1);

class FreshRSS_FeedDAOMySQL extends FreshRSS_FeedDAO {

	#[\Override]
	public function updateCachedValues(int ...$feedIds): int|false {
		// Performance problem when using `WHERE id_feed IN (...)`, so cannot take advantage of `$feedIds` for now with MySQL / MariaDB
		$sql = <<<'SQL'
			UPDATE `_feed`
			JOIN (
				SELECT id_feed,
					COUNT(id) AS total_entries,
					SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) AS unread_entries
				FROM  `_entry`
				-- WHERE id_feed IN (...)
				GROUP BY id_feed
			) AS e2 ON `_feed`.id = e2.id_feed
			SET `_feed`.`cache_nbEntries` = e2.total_entries,
				`_feed`.`cache_nbUnreads` = e2.unread_entries
			-- WHERE `_feed`.id IN (...)
			SQL;
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

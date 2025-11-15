<?php
declare(strict_types=1);

class FreshRSS_FeedDAOMySQL extends FreshRSS_FeedDAO {

	#[\Override]
	public function updateCachedValues(int ...$feedIds): int|false {
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
					e.id_feed,
					COUNT(*) AS total_entries,
					SUM(CASE WHEN e.is_read = 0 THEN 1 ELSE 0 END) AS unread_entries
				FROM `_entry` AS e
				WHERE $whereEntryIdFeeds
				GROUP BY e.id_feed
			)
			UPDATE `_feed` AS f
			JOIN entry_counts AS c ON f.id = c.id_feed
			SET f.`cache_nbEntries` = COALESCE(c.total_entries, 0),
				f.`cache_nbUnreads` = COALESCE(c.unread_entries, 0)
			WHERE $whereFeedIds;
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

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
}

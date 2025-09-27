<?php
declare(strict_types=1);

class FreshRSS_TagDAOSQLite extends FreshRSS_TagDAO {

	#[\Override]
	public function sqlIgnore(): string {
		return 'OR IGNORE';
	}

	#[\Override]
	public function sqlResetSequence(): bool {
		$sql = <<<'SQL'
UPDATE sqlite_sequence SET seq = (SELECT COALESCE(MAX(id), 0) FROM `_tag`) WHERE name = '_tag'
SQL;
		return $this->pdo->exec($sql) !== false;
	}
}

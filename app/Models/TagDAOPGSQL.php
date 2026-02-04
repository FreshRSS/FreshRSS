<?php
declare(strict_types=1);

class FreshRSS_TagDAOPGSQL extends FreshRSS_TagDAO {

	#[\Override]
	public function sqlIgnore(): string {
		return '';	//TODO
	}

	#[\Override]
	public function sqlResetSequence(): bool {
		$sql = <<<'SQL'
SELECT setval('`_tag_id_seq`', COALESCE(MAX(id), 0) + 1, false) FROM `_tag`
SQL;
		return $this->pdo->exec($sql) !== false;
	}
}

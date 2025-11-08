<?php
declare(strict_types=1);

final class FreshRSS_CategoryDAOPGSQL extends FreshRSS_CategoryDAO {

	#[\Override]
	public function sqlResetSequence(): bool {
		$sql = <<<'SQL'
SELECT setval('`_category_id_seq`', COALESCE(MAX(id), 0) + 1, false) FROM `_category`
SQL;
		return $this->pdo->exec($sql) !== false;
	}
}

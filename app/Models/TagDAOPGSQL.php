<?php
declare(strict_types=1);

namespace FreshRss\Models;

class TagDAOPGSQL extends TagDAO {

	#[\Override]
	public static function sqlIgnoreConflict(string $sql): string {
		return rtrim($sql, ' ;') . ' ON CONFLICT DO NOTHING';
	}

	#[\Override]
	public function sqlResetSequence(): bool {
		$sql = <<<'SQL'
			SELECT setval('`_tag_id_seq`', COALESCE(MAX(id), 0) + 1, false) FROM `_tag`
			SQL;
		return $this->pdo->exec($sql) !== false;
	}
}

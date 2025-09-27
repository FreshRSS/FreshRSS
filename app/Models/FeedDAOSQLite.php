<?php
declare(strict_types=1);

class FreshRSS_FeedDAOSQLite extends FreshRSS_FeedDAO {

	#[\Override]
	public function sqlResetSequence(): bool {
		$sql = <<<'SQL'
UPDATE sqlite_sequence SET seq = (SELECT COALESCE(MAX(id), 0) FROM `_feed`) WHERE name = '_feed'
SQL;
		return $this->pdo->exec($sql) !== false;
	}

	/** @param array{0:string,1:int,2:string} $errorInfo */
	#[\Override]
	protected function autoUpdateDb(array $errorInfo): bool {
		if (($tableInfo = $this->pdo->query("PRAGMA table_info('feed')")) !== false) {
			$columns = $tableInfo->fetchAll(PDO::FETCH_COLUMN, 1);
			foreach (['attributes', 'kind'] as $column) {
				if (!in_array($column, $columns, true)) {
					return $this->addColumn($column);
				}
			}
		}
		return false;
	}
}

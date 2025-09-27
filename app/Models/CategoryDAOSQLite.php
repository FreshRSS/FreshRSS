<?php
declare(strict_types=1);

class FreshRSS_CategoryDAOSQLite extends FreshRSS_CategoryDAO {

	#[\Override]
	public function sqlResetSequence(): bool {
		$sql = <<<'SQL'
UPDATE sqlite_sequence SET seq = (SELECT COALESCE(MAX(id), 0) FROM `_category`) WHERE name = '_category'
SQL;
		return $this->pdo->exec($sql) !== false;
	}

	/** @param array{0:string,1:int,2:string} $errorInfo */
	#[\Override]
	protected function autoUpdateDb(array $errorInfo): bool {
		if (($tableInfo = $this->pdo->query("PRAGMA table_info('category')")) !== false) {
			$columns = $tableInfo->fetchAll(PDO::FETCH_COLUMN, 1);
			foreach (['kind', 'lastUpdate', 'error', 'attributes'] as $column) {
				if (!in_array($column, $columns, true)) {
					return $this->addColumn($column);
				}
			}
		}
		return false;
	}
}

<?php
declare(strict_types=1);

class FreshRSS_CategoryDAOSQLite extends FreshRSS_CategoryDAO {

	/** @param array<int|string> $errorInfo */
	#[\Override]
	protected function autoUpdateDb(array $errorInfo): bool {
		if ($tableInfo = $this->pdo->query("PRAGMA table_info('category')")) {
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

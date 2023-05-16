<?php

class FreshRSS_FeedDAOSQLite extends FreshRSS_FeedDAO {

	/** @param array<string> $errorInfo */
	protected function autoUpdateDb(array $errorInfo): bool {
		if ($tableInfo = $this->pdo->query("PRAGMA table_info('feed')")) {
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

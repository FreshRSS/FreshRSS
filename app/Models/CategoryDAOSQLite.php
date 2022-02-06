<?php

class FreshRSS_CategoryDAOSQLite extends FreshRSS_CategoryDAO {

	protected function autoUpdateDb(array $errorInfo) {
		if ($tableInfo = $this->pdo->query("PRAGMA table_info('category')")) {
			$columns = $tableInfo->fetchAll(PDO::FETCH_COLUMN, 1);
			foreach (['attributes'] as $column) {
				if (!in_array($column, $columns)) {
					return $this->addColumn($column);
				}
			}
		}
		return false;
	}

}

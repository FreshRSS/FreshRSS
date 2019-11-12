<?php

namespace Freshrss\Models;

class FeedDAOSQLite extends FreshRSS_FeedDAO {

	protected function autoUpdateDb($errorInfo) {
		if ($tableInfo = $this->pdo->query("PRAGMA table_info('feed')")) {
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

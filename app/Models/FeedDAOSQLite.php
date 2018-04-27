<?php

class FreshRSS_FeedDAOSQLite extends FreshRSS_FeedDAO {

	protected function autoUpdateDb($errorInfo) {
		if ($tableInfo = $this->bd->query("SELECT sql FROM sqlite_master where name='feed'")) {
			$showCreate = $tableInfo->fetchColumn();
			foreach (array('attributes') as $column) {
				if (stripos($showCreate, $column) === false) {
					return $this->addColumn($column);
				}
			}
		}
		return false;
	}

}

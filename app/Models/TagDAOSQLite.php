<?php

class FreshRSS_TagDAOSQLite extends FreshRSS_TagDAO {

	public function sqlIgnore() {
		return 'OR IGNORE';
	}

	protected function autoUpdateDb($errorInfo) {
		if ($tableInfo = $this->bd->query("SELECT sql FROM sqlite_master where name='tag'")) {
			$showCreate = $tableInfo->fetchColumn();
			if (stripos($showCreate, 'tag') === false) {
				return $this->createTagTable();	//v1.12.0
			}
		}
		return false;
	}

}

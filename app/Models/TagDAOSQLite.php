<?php

class FreshRSS_TagDAOSQLite extends FreshRSS_TagDAO {

	public function sqlIgnore(): string {
		return 'OR IGNORE';
	}

	/** @param array<string> $errorInfo */
	protected function autoUpdateDb(array $errorInfo): bool {
		if ($tableInfo = $this->pdo->query("SELECT sql FROM sqlite_master where name='tag'")) {
			$showCreate = $tableInfo->fetchColumn();
			if (stripos($showCreate, 'tag') === false) {
				return $this->createTagTable();	//v1.12.0
			}
		}
		return false;
	}

}

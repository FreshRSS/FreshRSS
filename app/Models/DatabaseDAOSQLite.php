<?php

/**
 * This class is used to test database is well-constructed (SQLite).
 */
class FreshRSS_DatabaseDAOSQLite extends FreshRSS_DatabaseDAO {
	public function tablesAreCorrect() {
		$sql = 'SELECT name FROM sqlite_master WHERE type="table"';
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		
		$tables = array(
			'category' => false,
			'feed' => false,
			'entry' => false,
		);
		foreach ($res as $value) {
			$tables[$value['name']] = true;
		}

		return count(array_keys($tables, true, true)) == count($tables);
	}

	public function getSchema($table) {
		$sql = 'PRAGMA table_info(' . $table . ')';
		$stm = $this->bd->prepare($sql);
		$stm->execute();

		return $this->listDaoToSchema($stm->fetchAll(PDO::FETCH_ASSOC));
	}

	public function entryIsCorrect() {
		return $this->checkTable('entry', array(
			'id', 'guid', 'title', 'author', 'content', 'link', 'date', 'is_read',
			'is_favorite', 'id_feed', 'tags'
		));
	}

	public function daoToSchema($dao) {
		return array(
			'name' => $dao['name'],
			'type' => strtolower($dao['type']),
			'notnull' => $dao['notnull'] === '1' ? true : false,
			'default' => $dao['dflt_value'],
		);
	}
}

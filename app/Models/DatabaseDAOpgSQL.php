<?php

/**
 * This class is used to test database is well-constructed.
 */
class FreshRSS_DatabaseDAOpgSQL extends Minz_ModelPdo {
	public function tablesAreCorrect() {
		$db = FreshRSS_Context::$system_conf->db;
		$dbowner = $db['user'];
		$sql = 'SELECT * FROM pg_catalog.pg_tables where tableowner=?';
		$stm = $this->bd->prepare($sql);
		$values = array($dbowner);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		
		$tables = array(
			$this->prefix . 'category' => false,
			$this->prefix . 'feed' => false,
			$this->prefix . 'entry' => false,
		);
		foreach ($res as $value) {
			$tables[array_pop($value)] = true;
		}

		return count(array_keys($tables, true, true)) == count($tables);
	}

	public function getSchema($table) {
		$sql = 'select column_name as field, data_type as type, column_default as default, is_nullable as null from INFORMATION_SCHEMA.COLUMNS where table_name = ?';
		$stm = $this->bd->prepare($sql);
		$stm->execute(array($this->prefix . $table));
		return $this->listDaoToSchema($stm->fetchAll(PDO::FETCH_ASSOC));
	}

	public function checkTable($table, $schema) {
		$columns = $this->getSchema($table);

		$ok = (count($columns) == count($schema));
		foreach ($columns as $c) {
			$ok &= in_array($c['name'], $schema);
		}

		return $ok;
	}

	public function categoryIsCorrect() {
		return $this->checkTable('category', array(
			'id', 'name'
		));
	}

	public function feedIsCorrect() {
		return $this->checkTable('feed', array(
			'id', 'url', 'category', 'name', 'website', 'description', 'lastUpdate',
			'priority', 'pathEntries', 'httpAuth', 'error', 'keep_history', 'ttl',
			'cache_nbEntries', 'cache_nbUnreads'
		));
	}

	public function entryIsCorrect() {
		return $this->checkTable('entry', array(
			'id', 'guid', 'title', 'author', 'content_bin', 'link', 'date', 'is_read',
			'is_favorite', 'id_feed', 'tags'
		));
	}

	public function daoToSchema($dao) {
		return array(
			'name' => $dao['field'],
			'type' => strtolower($dao['type']),
			'notnull' => (bool)$dao['null'],
			'default' => $dao['default'],
		);
	}

	public function listDaoToSchema($listDAO) {
		$list = array();

		foreach ($listDAO as $dao) {
			$list[] = $this->daoToSchema($dao);
		}

		return $list;
	}
}

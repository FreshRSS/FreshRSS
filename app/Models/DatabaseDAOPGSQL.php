<?php

/**
 * This class is used to test database is well-constructed.
 */
class FreshRSS_DatabaseDAOPGSQL extends FreshRSS_DatabaseDAOSQLite {

	//PostgreSQL error codes
	const UNDEFINED_COLUMN = '42703';
	const UNDEFINED_TABLE = '42P01';

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
			$this->prefix . 'entrytmp' => false,
			$this->prefix . 'tag' => false,
			$this->prefix . 'entrytag' => false,
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

	public function daoToSchema($dao) {
		return array(
			'name' => $dao['field'],
			'type' => strtolower($dao['type']),
			'notnull' => (bool)$dao['null'],
			'default' => $dao['default'],
		);
	}

	public function size($all = true) {
		$db = FreshRSS_Context::$system_conf->db;
		$sql = 'SELECT pg_size_pretty(pg_database_size(?))';
		$values = array($db['base']);
		$stm = $this->bd->prepare($sql);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return $res[0];
	}

	public function optimize() {
		$ok = true;
		$tables = array('category', 'feed', 'entry', 'entrytmp', 'tag', 'entrytag');

		foreach ($tables as $table) {
			$sql = 'VACUUM `' . $this->prefix . $table . '`';
			$stm = $this->bd->prepare($sql);
			$ok &= $stm != false;
			if ($stm) {
				$ok &= $stm->execute();
			}
		}
		return $ok;
	}
}

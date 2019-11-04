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
		$stm = $this->pdo->prepare($sql);
		$values = array($dbowner);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		$tables = array(
			$this->pdo->prefix() . 'category' => false,
			$this->pdo->prefix() . 'feed' => false,
			$this->pdo->prefix() . 'entry' => false,
			$this->pdo->prefix() . 'entrytmp' => false,
			$this->pdo->prefix() . 'tag' => false,
			$this->pdo->prefix() . 'entrytag' => false,
		);
		foreach ($res as $value) {
			$tables[array_pop($value)] = true;
		}

		return count(array_keys($tables, true, true)) == count($tables);
	}

	public function getSchema($table) {
		$sql = 'select column_name as field, data_type as type, column_default as default, is_nullable as null from INFORMATION_SCHEMA.COLUMNS where table_name = ?';
		$stm = $this->pdo->prepare($sql);
		$stm->execute(array($this->pdo->prefix() . $table));
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

	public function size($all = false) {
		if ($all) {
			$db = FreshRSS_Context::$system_conf->db;
			$sql = 'SELECT pg_database_size(:base)';
			$stm = $this->pdo->prepare($sql);
			$stm->bindParam(':base', $db['base']);
			$stm->execute();
		} else {
			$sql = "SELECT "
			     . "pg_total_relation_size('`{$this->pdo->prefix()}category`') + "
			     . "pg_total_relation_size('`{$this->pdo->prefix()}feed`') + "
			     . "pg_total_relation_size('`{$this->pdo->prefix()}entry`') + "
			     . "pg_total_relation_size('`{$this->pdo->prefix()}entrytmp`') + "
			     . "pg_total_relation_size('`{$this->pdo->prefix()}tag`') + "
			     . "pg_total_relation_size('`{$this->pdo->prefix()}entrytag`')";
			$stm = $this->pdo->query($sql);
		}
		if ($stm == false) {
			return 0;
		}
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return $res[0];
	}

	public function optimize() {
		$ok = true;
		$tables = array('category', 'feed', 'entry', 'entrytmp', 'tag', 'entrytag');

		foreach ($tables as $table) {
			$sql = 'VACUUM `_' . $table . '`';
			$ok &= ($this->pdo->exec($sql) !== false);
		}
		return $ok;
	}
}

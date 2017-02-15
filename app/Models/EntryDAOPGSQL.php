<?php

class FreshRSS_EntryDAOPGSQL extends FreshRSS_EntryDAOSQLite {

	public function sqlHexDecode($x) {
		return 'decode(' . $x . ", 'hex')";
	}

	public function sqlHexEncode($x) {
		return 'encode(' . $x . ", 'hex')";
	}

	protected function autoUpdateDb($errorInfo) {
		return false;
	}

	protected function addColumn($name) {
		return false;
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

}

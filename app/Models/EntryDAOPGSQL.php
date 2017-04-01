<?php

class FreshRSS_EntryDAOPGSQL extends FreshRSS_EntryDAOSQLite {

	public function sqlHexDecode($x) {
		return 'decode(' . $x . ", 'hex')";
	}

	public function sqlHexEncode($x) {
		return 'encode(' . $x . ", 'hex')";
	}

	protected function autoUpdateDb($errorInfo) {
		if (isset($errorInfo[0])) { 
			if ($errorInfo[0] === '42P01' && stripos($errorInfo[2], 'entrytmp') !== false) {	//undefined_table
				return $this->createEntryTempTable();
			}
		}
		return false;
	}

	protected function addColumn($name) {
		return false;
	}

	public function commitNewEntries() {
		$sql = 'DO $$
DECLARE
maxrank bigint := (SELECT MAX(id) FROM `' . $this->prefix . 'entrytmp`);
rank bigint := (SELECT maxrank - COUNT(*) FROM `' . $this->prefix . 'entrytmp`);
BEGIN
	INSERT INTO `' . $this->prefix . 'entry` (id, guid, title, author, content, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags)
		(SELECT rank + row_number() OVER(ORDER BY date) AS id, guid, title, author, content, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags FROM `' . $this->prefix . 'entrytmp` ORDER BY date);
	DELETE FROM `' . $this->prefix . 'entrytmp` WHERE id <= maxrank;
END $$;';
		$hadTransaction = $this->bd->inTransaction();
		if (!$hadTransaction) {
			$this->bd->beginTransaction();
		}
		$result = $this->bd->exec($sql) !== false;
		if (!$hadTransaction) {
			$this->bd->commit();
		}
		return $result;
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

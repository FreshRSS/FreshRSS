<?php

class FreshRSS_TagDAOSQLite extends FreshRSS_TagDAO {

	protected function autoUpdateDb($errorInfo) {
		if ($tableInfo = $this->bd->query("SELECT sql FROM sqlite_master where name='tag'")) {
			$showCreate = $tableInfo->fetchColumn();
			if (stripos($showCreate, 'tag') === false) {
				return $this->createTagTable();	//v1.12.0
			}
		}
		return false;
	}

	public function tagEntry($id_tag, $id_entry, $checked = true) {
		if ($checked) {
			$sql = 'INSERT OR IGNORE INTO `' . $this->prefix . 'entrytag`(id_tag, id_entry) VALUES(?, ?)';
		} else {
			$sql = 'DELETE FROM `' . $this->prefix . 'entrytag` WHERE id_tag=? AND id_entry=?';
		}
		$stm = $this->bd->prepare($sql);
		$values = array($id_tag, $id_entry);

		if ($stm && $stm->execute($values)) {
			return true;
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error tagEntry: ' . $info[2]);
			return false;
		}
	}

}

<?php

class FreshRSS_TagDAOPGSQL extends FreshRSS_TagDAO {

	public function tagEntry($id_tag, $id_entry, $set = true) {
		if ($set) {
			$sql = 'INSERT INTO `' . $this->prefix . 'entrytag`(id_tag, id_entry) VALUES(?, ?)';
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

<?php

class FreshRSS_EntryDAOSQLite extends FreshRSS_EntryDAO {

	public function markRead($ids, $is_read = true) {
		if (is_array($ids)) {	//Many IDs at once
			if (true) {	//Not supported yet in SQLite, so always call IDs one by one
				$affected = 0;
				foreach ($ids as $id) {
					$affected += $this->markRead($id, $is_read);
				}
				return $affected;
			}
		} else {
			$this->bd->beginTransaction();
			$sql = 'UPDATE `' . $this->prefix . 'entry` SET is_read=? WHERE id=? AND is_read<>?';
			$values = array($is_read ? 1 : 0, $ids, $is_read ? 1 : 0);
			$stm = $this->bd->prepare($sql);
			if (!($stm && $stm->execute ($values))) {
				$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
				Minz_Log::record('SQL error markRead 1: ' . $info[2], Minz_Log::ERROR);
				$this->bd->rollBack ();
				return false;
			}
			$affected = $stm->rowCount();
			if ($affected > 0) {
				$sql = 'UPDATE `' . $this->prefix . 'feed` SET cache_nbUnreads=cache_nbUnreads' . ($is_read ? '-' : '+') . '1 '
				 . 'WHERE id=(SELECT e.id_feed FROM `' . $this->prefix . 'entry` e WHERE e.id=?)';
				$values = array($ids);
				$stm = $this->bd->prepare($sql);
				if (!($stm && $stm->execute ($values))) {
					$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
					Minz_Log::record('SQL error markRead 2: ' . $info[2], Minz_Log::ERROR);
					$this->bd->rollBack ();
					return false;
				}
			}
			$this->bd->commit();
			return $affected;
		}
	}
}

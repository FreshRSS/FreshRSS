<?php

class FreshRSS_EntryDAOSQLite extends FreshRSS_EntryDAO {

	protected function sqlConcat($s1, $s2) {
		return $s1 . '||' . $s2;
	}

	protected function updateCacheUnreads($catId = false, $feedId = false) {
		$sql = 'UPDATE `' . $this->prefix . 'feed` '
		 . 'SET cache_nbUnreads=('
		 .	'SELECT COUNT(*) AS nbUnreads FROM `' . $this->prefix . 'entry` e '
		 .	'WHERE e.id_feed=`' . $this->prefix . 'feed`.id AND e.is_read=0) '
		 . 'WHERE 1';
		$values = array();
		if ($feedId !== false) {
			$sql .= ' AND id=?';
			$values[] = $feedId;
		}
		if ($catId !== false) {
			$sql .= ' AND category=?';
			$values[] = $catId;
		}
		$stm = $this->bd->prepare($sql);
		if ($stm && $stm->execute($values)) {
			return true;
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::record('SQL error updateCacheUnreads: ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function markRead($ids, $is_read = true) {
		if (is_array($ids)) {	//Many IDs at once (used by API)
			if (true) {	//Speed heuristics	//TODO: Not implemented yet for SQLite (so always call IDs one by one)
				$affected = 0;
				foreach ($ids as $id) {
					$affected += $this->markRead($id, $is_read);
				}
				return $affected;
			}
		} else {
			$this->bd->beginTransaction();
			$sql = 'UPDATE `' . $this->prefix . 'entry` SET is_read=? WHERE id=? AND is_read=?';
			$values = array($is_read ? 1 : 0, $ids, $is_read ? 0 : 1);
			$stm = $this->bd->prepare($sql);
			if (!($stm && $stm->execute($values))) {
				$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
				Minz_Log::record('SQL error markRead 1: ' . $info[2], Minz_Log::ERROR);
				$this->bd->rollBack();
				return false;
			}
			$affected = $stm->rowCount();
			if ($affected > 0) {
				$sql = 'UPDATE `' . $this->prefix . 'feed` SET cache_nbUnreads=cache_nbUnreads' . ($is_read ? '-' : '+') . '1 '
				 . 'WHERE id=(SELECT e.id_feed FROM `' . $this->prefix . 'entry` e WHERE e.id=?)';
				$values = array($ids);
				$stm = $this->bd->prepare($sql);
				if (!($stm && $stm->execute($values))) {
					$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
					Minz_Log::record('SQL error markRead 2: ' . $info[2], Minz_Log::ERROR);
					$this->bd->rollBack();
					return false;
				}
			}
			$this->bd->commit();
			return $affected;
		}
	}

	public function markReadEntries($idMax = 0, $onlyFavorites = false, $priorityMin = 0) {
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::record($nb . 'Calling markReadEntries(0) is deprecated!', Minz_Log::DEBUG);
		}

		$sql = 'UPDATE `' . $this->prefix . 'entry` SET is_read=1 WHERE is_read=0 AND id <= ?';
		if ($onlyFavorites) {
			$sql .= ' AND is_favorite=1';
		} elseif ($priorityMin >= 0) {
			$sql .= ' AND id_feed IN (SELECT f.id FROM `' . $this->prefix . 'feed` f WHERE f.priority > ' . intval($priorityMin) . ')';
		}
		$values = array($idMax);
		$stm = $this->bd->prepare($sql);
		if (!($stm && $stm->execute($values))) {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::record('SQL error markReadEntries: ' . $info[2], Minz_Log::ERROR);
			return false;
		}
		$affected = $stm->rowCount();
		if (($affected > 0) && (!$this->updateCacheUnreads(false, false))) {
			return false;
		}
		return $affected;
	}

	public function markReadCat($id, $idMax = 0) {
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::record($nb . 'Calling markReadCat(0) is deprecated!', Minz_Log::DEBUG);
		}

		$sql = 'UPDATE `' . $this->prefix . 'entry` '
			 . 'SET is_read=1 '
			 . 'WHERE is_read=0 AND id <= ? AND '
			 . 'id_feed IN (SELECT f.id FROM `' . $this->prefix . 'feed` f WHERE f.category=?)';
		$values = array($idMax, $id);
		$stm = $this->bd->prepare($sql);
		if (!($stm && $stm->execute($values))) {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::record('SQL error markReadCat: ' . $info[2], Minz_Log::ERROR);
			return false;
		}
		$affected = $stm->rowCount();
		if (($affected > 0) && (!$this->updateCacheUnreads($id, false))) {
			return false;
		}
		return $affected;
	}

	public function optimizeTable() {
		//TODO: Search for an equivalent in SQLite
	}

	public function size($all = false) {
		return @filesize(DATA_PATH . '/' . Minz_Session::param('currentUser', '_') . '.sqlite');
	}
}

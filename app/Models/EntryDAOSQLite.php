<?php

class FreshRSS_EntryDAOSQLite extends FreshRSS_EntryDAO {

	protected function autoAddColumn($errorInfo) {
		if (empty($errorInfo[0]) || $errorInfo[0] == '42S22') {	//ER_BAD_FIELD_ERROR
			if ($tableInfo = $this->bd->query("SELECT sql FROM sqlite_master where name='entry'")) {
				$showCreate = $tableInfo->fetchColumn();
				Minz_Log::debug('FreshRSS_EntryDAOSQLite::autoAddColumn: ' . $showCreate);
				foreach (array('lastSeen', 'hash') as $column) {
					if (stripos($showCreate, $column) === false) {
						return $this->addColumn($column);
					}
				}
			}
		}
		return false;
	}

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
			Minz_Log::error('SQL error updateCacheUnreads: ' . $info[2]);
			return false;
		}
	}

	/**
	 * Toggle the read marker on one or more article.
	 * Then the cache is updated.
	 *
	 * @todo change the way the query is build because it seems there is
	 * unnecessary code in here. For instance, the part with the str_repeat.
	 * @todo remove code duplication. It seems the code is basically the
	 * same if it is an array or not.
	 *
	 * @param integer|array $ids
	 * @param boolean $is_read
	 * @return integer affected rows
	 */
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
				Minz_Log::error('SQL error markRead 1: ' . $info[2]);
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
					Minz_Log::error('SQL error markRead 2: ' . $info[2]);
					$this->bd->rollBack();
					return false;
				}
			}
			$this->bd->commit();
			return $affected;
		}
	}

	/**
	 * Mark all entries as read depending on parameters.
	 * If $onlyFavorites is true, it is used when the user mark as read in
	 * the favorite pseudo-category.
	 * If $priorityMin is greater than 0, it is used when the user mark as
	 * read in the main feed pseudo-category.
	 * Then the cache is updated.
	 *
	 * If $idMax equals 0, a deprecated debug message is logged
	 *
	 * @todo refactor this method along with markReadCat and markReadFeed
	 * since they are all doing the same thing. I think we need to build a
	 * tool to generate the query instead of having queries all over the
	 * place. It will be reused also for the filtering making every thing
	 * separated.
	 *
	 * @param integer $idMax fail safe article ID
	 * @param boolean $onlyFavorites
	 * @param integer $priorityMin
	 * @return integer affected rows
	 */
	public function markReadEntries($idMax = 0, $onlyFavorites = false, $priorityMin = 0) {
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadEntries(0) is deprecated!');
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
			Minz_Log::error('SQL error markReadEntries: ' . $info[2]);
			return false;
		}
		$affected = $stm->rowCount();
		if (($affected > 0) && (!$this->updateCacheUnreads(false, false))) {
			return false;
		}
		return $affected;
	}

	/**
	 * Mark all the articles in a category as read.
	 * There is a fail safe to prevent to mark as read articles that are
	 * loaded during the mark as read action. Then the cache is updated.
	 *
	 * If $idMax equals 0, a deprecated debug message is logged
	 *
	 * @param integer $id category ID
	 * @param integer $idMax fail safe article ID
	 * @return integer affected rows
	 */
	public function markReadCat($id, $idMax = 0) {
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadCat(0) is deprecated!');
		}

		$sql = 'UPDATE `' . $this->prefix . 'entry` '
			 . 'SET is_read=1 '
			 . 'WHERE is_read=0 AND id <= ? AND '
			 . 'id_feed IN (SELECT f.id FROM `' . $this->prefix . 'feed` f WHERE f.category=?)';
		$values = array($idMax, $id);
		$stm = $this->bd->prepare($sql);
		if (!($stm && $stm->execute($values))) {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error markReadCat: ' . $info[2]);
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
		return @filesize(join_path(DATA_PATH, 'users', $this->current_user, 'db.sqlite'));
	}
}

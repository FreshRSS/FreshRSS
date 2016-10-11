<?php

class FreshRSS_EntryDAO extends Minz_ModelPdo implements FreshRSS_Searchable {

	public function isCompressed() {
		return parent::$sharedDbType === 'mysql';
	}

	public function hasNativeHex() {
		return parent::$sharedDbType !== 'sqlite';
	}

	public function sqlHexDecode($x) {
		return 'unhex(' . $x . ')';
	}

	public function sqlHexEncode($x) {
		return 'hex(' . $x . ')';
	}

	protected function addColumn($name) {
		Minz_Log::warning('FreshRSS_EntryDAO::addColumn: ' . $name);
		$hasTransaction = false;
		try {
			$stm = null;
			if ($name === 'lastSeen') {	//v1.1.1
				if (!$this->bd->inTransaction()) {
					$this->bd->beginTransaction();
					$hasTransaction = true;
				}
				$stm = $this->bd->prepare('ALTER TABLE `' . $this->prefix . 'entry` ADD COLUMN `lastSeen` INT(11) DEFAULT 0');
				if ($stm && $stm->execute()) {
					$stm = $this->bd->prepare('CREATE INDEX entry_lastSeen_index ON `' . $this->prefix . 'entry`(`lastSeen`);');	//"IF NOT EXISTS" does not exist in MySQL 5.7
					if ($stm && $stm->execute()) {
						if ($hasTransaction) {
							$this->bd->commit();
						}
						return true;
					}
				}
				if ($hasTransaction) {
					$this->bd->rollBack();
				}
			} elseif ($name === 'hash') {	//v1.1.1
				$stm = $this->bd->prepare('ALTER TABLE `' . $this->prefix . 'entry` ADD COLUMN hash BINARY(16)');
				return $stm && $stm->execute();
			}
		} catch (Exception $e) {
			Minz_Log::error('FreshRSS_EntryDAO::addColumn error: ' . $e->getMessage());
			if ($hasTransaction) {
				$this->bd->rollBack();
			}
		}
		return false;
	}

	private $triedUpdateToUtf8mb4 = false;

	protected function updateToUtf8mb4() {
		if ($this->triedUpdateToUtf8mb4) {
			return false;
		}
		$this->triedUpdateToUtf8mb4 = true;
		$db = FreshRSS_Context::$system_conf->db;
		if ($db['type'] === 'mysql') {
			include_once(APP_PATH . '/SQL/install.sql.mysql.php');
			if (defined('SQL_UPDATE_UTF8MB4')) {
				Minz_Log::warning('Updating MySQL to UTF8MB4...');
				$hadTransaction = $this->bd->inTransaction();
				if ($hadTransaction) {
					$this->bd->commit();
				}
				$ok = false;
				try {
					$sql = sprintf(SQL_UPDATE_UTF8MB4, $this->prefix, $db['base']);
					$stm = $this->bd->prepare($sql);
					$ok = $stm->execute();
				} catch (Exception $e) {
					Minz_Log::error('FreshRSS_EntryDAO::updateToUtf8mb4 error: ' . $e->getMessage());
				}
				if ($hadTransaction) {
					$this->bd->beginTransaction();
					//NB: Transaction not starting. Why? (tested on PHP 7.0.8-0ubuntu and MySQL 5.7.13-0ubuntu)
				}
				return $ok;
			}
		}
		return false;
	}

	protected function autoUpdateDb($errorInfo) {
		if (isset($errorInfo[0])) {
			if ($errorInfo[0] === '42S22') {	//ER_BAD_FIELD_ERROR
				//autoAddColumn
				foreach (array('lastSeen', 'hash') as $column) {
					if (stripos($errorInfo[2], $column) !== false) {
						return $this->addColumn($column);
					}
				}
			}
		}
		if (isset($errorInfo[1])) {
			if ($errorInfo[1] == '1366') {	//ER_TRUNCATED_WRONG_VALUE_FOR_FIELD
				return $this->updateToUtf8mb4();
			}
		}
		return false;
	}

	private $addEntryPrepared = null;

	public function addEntry($valuesTmp) {
		if ($this->addEntryPrepared === null) {
			$sql = 'INSERT INTO `' . $this->prefix . 'entry` (id, guid, title, author, '
			     . ($this->isCompressed() ? 'content_bin' : 'content')
			     . ', link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags) '
			     . 'VALUES(:id, :guid, :title, :author, '
			     . ($this->isCompressed() ? 'COMPRESS(:content)' : ':content')
			     . ', :link, :date, :last_seen, '
			     . $this->sqlHexDecode(':hash')
			     . ', :is_read, :is_favorite, :id_feed, :tags)';
			$this->addEntryPrepared = $this->bd->prepare($sql);
		}
		$this->addEntryPrepared->bindParam(':id', $valuesTmp['id']);
		$valuesTmp['guid'] = substr($valuesTmp['guid'], 0, 760);
		$this->addEntryPrepared->bindParam(':guid', $valuesTmp['guid']);
		$valuesTmp['title'] = substr($valuesTmp['title'], 0, 255);
		$this->addEntryPrepared->bindParam(':title', $valuesTmp['title']);
		$valuesTmp['author'] = substr($valuesTmp['author'], 0, 255);
		$this->addEntryPrepared->bindParam(':author', $valuesTmp['author']);
		$this->addEntryPrepared->bindParam(':content', $valuesTmp['content']);
		$valuesTmp['link'] = substr($valuesTmp['link'], 0, 1023);
		$this->addEntryPrepared->bindParam(':link', $valuesTmp['link']);
		$this->addEntryPrepared->bindParam(':date', $valuesTmp['date'], PDO::PARAM_INT);
		$valuesTmp['lastSeen'] = time();
		$this->addEntryPrepared->bindParam(':last_seen', $valuesTmp['lastSeen'], PDO::PARAM_INT);
		$valuesTmp['is_read'] = $valuesTmp['is_read'] ? 1 : 0;
		$this->addEntryPrepared->bindParam(':is_read', $valuesTmp['is_read'], PDO::PARAM_INT);
		$valuesTmp['is_favorite'] = $valuesTmp['is_favorite'] ? 1 : 0;
		$this->addEntryPrepared->bindParam(':is_favorite', $valuesTmp['is_favorite'], PDO::PARAM_INT);
		$this->addEntryPrepared->bindParam(':id_feed', $valuesTmp['id_feed'], PDO::PARAM_INT);
		$valuesTmp['tags'] = substr($valuesTmp['tags'], 0, 1023);
		$this->addEntryPrepared->bindParam(':tags', $valuesTmp['tags']);

		if ($this->hasNativeHex()) {
			$this->addEntryPrepared->bindParam(':hash', $valuesTmp['hash']);
		} else {
			$valuesTmp['hashBin'] = pack('H*', $valuesTmp['hash']);	//hex2bin() is PHP5.4+
			$this->addEntryPrepared->bindParam(':hash', $valuesTmp['hashBin']);
		}

		if ($this->addEntryPrepared && $this->addEntryPrepared->execute()) {
			return $this->bd->lastInsertId();
		} else {
			$info = $this->addEntryPrepared == null ? array(0 => '', 1 => '', 2 => 'syntax error') : $this->addEntryPrepared->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->addEntry($valuesTmp);
			} elseif ((int)($info[0] / 1000) !== 23) {	//Filter out "SQLSTATE Class code 23: Constraint Violation" because of expected duplicate entries
				Minz_Log::error('SQL error addEntry: ' . $info[0] . ': ' . $info[1] . ' ' . $info[2]
					. ' while adding entry in feed ' . $valuesTmp['id_feed'] . ' with title: ' . $valuesTmp['title']);
			}
			return false;
		}
	}

	private $updateEntryPrepared = null;

	public function updateEntry($valuesTmp) {
		if (!isset($valuesTmp['is_read'])) {
			$valuesTmp['is_read'] = null;
		}

		if ($this->updateEntryPrepared === null) {
			$sql = 'UPDATE `' . $this->prefix . 'entry` '
			     . 'SET title=:title, author=:author, '
			     . ($this->isCompressed() ? 'content_bin=COMPRESS(:content)' : 'content=:content')
			     . ', link=:link, date=:date, `lastSeen`=:last_seen, '
			     . 'hash=' . $this->sqlHexDecode(':hash')
			     . ', ' . ($valuesTmp['is_read'] === null ? '' : 'is_read=:is_read, ')
			     . 'tags=:tags '
			     . 'WHERE id_feed=:id_feed AND guid=:guid';
			$this->updateEntryPrepared = $this->bd->prepare($sql);
		}

		$valuesTmp['guid'] = substr($valuesTmp['guid'], 0, 760);
		$this->updateEntryPrepared->bindParam(':guid', $valuesTmp['guid']);
		$valuesTmp['title'] = substr($valuesTmp['title'], 0, 255);
		$this->updateEntryPrepared->bindParam(':title', $valuesTmp['title']);
		$valuesTmp['author'] = substr($valuesTmp['author'], 0, 255);
		$this->updateEntryPrepared->bindParam(':author', $valuesTmp['author']);
		$this->updateEntryPrepared->bindParam(':content', $valuesTmp['content']);
		$valuesTmp['link'] = substr($valuesTmp['link'], 0, 1023);
		$this->updateEntryPrepared->bindParam(':link', $valuesTmp['link']);
		$this->updateEntryPrepared->bindParam(':date', $valuesTmp['date'], PDO::PARAM_INT);
		$valuesTmp['lastSeen'] = time();
		$this->updateEntryPrepared->bindParam(':last_seen', $valuesTmp['lastSeen'], PDO::PARAM_INT);
		if ($valuesTmp['is_read'] !== null) {
			$this->updateEntryPrepared->bindParam(':is_read', $valuesTmp['is_read'] ? 1 : 0, PDO::PARAM_INT);
		}
		$this->updateEntryPrepared->bindParam(':id_feed', $valuesTmp['id_feed'], PDO::PARAM_INT);
		$valuesTmp['tags'] = substr($valuesTmp['tags'], 0, 1023);
		$this->updateEntryPrepared->bindParam(':tags', $valuesTmp['tags']);

		if ($this->hasNativeHex()) {
			$this->updateEntryPrepared->bindParam(':hash', $valuesTmp['hash']);
		} else {
			$valuesTmp['hashBin'] = pack('H*', $valuesTmp['hash']);	//hex2bin() is PHP5.4+
			$this->updateEntryPrepared->bindParam(':hash', $valuesTmp['hashBin']);
		}

		if ($this->updateEntryPrepared && $this->updateEntryPrepared->execute($values)) {
			return $this->bd->lastInsertId();
		} else {
			$info = $this->updateEntryPrepared == null ? array(0 => '', 1 => '', 2 => 'syntax error') : $this->updateEntryPrepared->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->updateEntry($valuesTmp);
			}
			Minz_Log::error('SQL error updateEntry: ' . $info[0] . ': ' . $info[1] . ' ' . $info[2]
				. ' while updating entry with GUID ' . $valuesTmp['guid'] . ' in feed ' . $valuesTmp['id_feed']);
			return false;
		}
	}

	/**
	 * Toggle favorite marker on one or more article
	 *
	 * @todo simplify the query by removing the str_repeat. I am pretty sure
	 * there is an other way to do that.
	 *
	 * @param integer|array $ids
	 * @param boolean $is_favorite
	 * @return false|integer
	 */
	public function markFavorite($ids, $is_favorite = true) {
		if (!is_array($ids)) {
			$ids = array($ids);
		}
		if (count($ids) < 1) {
			return 0;
		}
		$sql = 'UPDATE `' . $this->prefix . 'entry` '
		     . 'SET is_favorite=? '
		     . 'WHERE id IN (' . str_repeat('?,', count($ids) - 1). '?)';
		$values = array($is_favorite ? 1 : 0);
		$values = array_merge($values, $ids);
		$stm = $this->bd->prepare($sql);
		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error markFavorite: ' . $info[2]);
			return false;
		}
	}

	/**
	 * Update the unread article cache held on every feed details.
	 * Depending on the parameters, it updates the cache on one feed, on all
	 * feeds from one category or on all feeds.
	 *
	 * @todo It can use the query builder refactoring to build that query
	 *
	 * @param false|integer $catId category ID
	 * @param false|integer $feedId feed ID
	 * @return boolean
	 */
	protected function updateCacheUnreads($catId = false, $feedId = false) {
		$sql = 'UPDATE `' . $this->prefix . 'feed` f '
		 . 'LEFT OUTER JOIN ('
		 .	'SELECT e.id_feed, '
		 .	'COUNT(*) AS nbUnreads '
		 .	'FROM `' . $this->prefix . 'entry` e '
		 .	'WHERE e.is_read=0 '
		 .	'GROUP BY e.id_feed'
		 . ') x ON x.id_feed=f.id '
		 . 'SET f.`cache_nbUnreads`=COALESCE(x.nbUnreads, 0) '
		 . 'WHERE 1';
		$values = array();
		if ($feedId !== false) {
			$sql .= ' AND f.id=?';
			$values[] = $id;
		}
		if ($catId !== false) {
			$sql .= ' AND f.category=?';
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
			if (count($ids) < 6) {	//Speed heuristics
				$affected = 0;
				foreach ($ids as $id) {
					$affected += $this->markRead($id, $is_read);
				}
				return $affected;
			}

			$sql = 'UPDATE `' . $this->prefix . 'entry` '
				 . 'SET is_read=? '
				 . 'WHERE id IN (' . str_repeat('?,', count($ids) - 1). '?)';
			$values = array($is_read ? 1 : 0);
			$values = array_merge($values, $ids);
			$stm = $this->bd->prepare($sql);
			if (!($stm && $stm->execute($values))) {
				$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
				Minz_Log::error('SQL error markRead: ' . $info[2]);
				return false;
			}
			$affected = $stm->rowCount();
			if (($affected > 0) && (!$this->updateCacheUnreads(false, false))) {
				return false;
			}
			return $affected;
		} else {
			$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id '
				 . 'SET e.is_read=?,'
				 . 'f.`cache_nbUnreads`=f.`cache_nbUnreads`' . ($is_read ? '-' : '+') . '1 '
				 . 'WHERE e.id=? AND e.is_read=?';
			$values = array($is_read ? 1 : 0, $ids, $is_read ? 0 : 1);
			$stm = $this->bd->prepare($sql);
			if ($stm && $stm->execute($values)) {
				return $stm->rowCount();
			} else {
				$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
				Minz_Log::error('SQL error markRead: ' . $info[2]);
				return false;
			}
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
	public function markReadEntries($idMax = 0, $onlyFavorites = false, $priorityMin = 0, $filter = null, $state = 0) {
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadEntries(0) is deprecated!');
		}

		$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id '
			 . 'SET e.is_read=1 '
			 . 'WHERE e.is_read=0 AND e.id <= ?';
		if ($onlyFavorites) {
			$sql .= ' AND e.is_favorite=1';
		} elseif ($priorityMin >= 0) {
			$sql .= ' AND f.priority > ' . intval($priorityMin);
		}
		$values = array($idMax);

		list($searchValues, $search) = $this->sqlListEntriesWhere('e.', $filter, $state);

		$stm = $this->bd->prepare($sql . $search);
		if (!($stm && $stm->execute(array_merge($values, $searchValues)))) {
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
	public function markReadCat($id, $idMax = 0, $filter = null, $state = 0) {
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadCat(0) is deprecated!');
		}

		$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id '
			 . 'SET e.is_read=1 '
			 . 'WHERE f.category=? AND e.is_read=0 AND e.id <= ?';
		$values = array($id, $idMax);

		list($searchValues, $search) = $this->sqlListEntriesWhere('e.', $filter, $state);

		$stm = $this->bd->prepare($sql . $search);
		if (!($stm && $stm->execute(array_merge($values, $searchValues)))) {
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

	/**
	 * Mark all the articles in a feed as read.
	 * There is a fail safe to prevent to mark as read articles that are
	 * loaded during the mark as read action. Then the cache is updated.
	 *
	 * If $idMax equals 0, a deprecated debug message is logged
	 *
	 * @param integer $id_feed feed ID
	 * @param integer $idMax fail safe article ID
	 * @return integer affected rows
	 */
	public function markReadFeed($id_feed, $idMax = 0, $filter = null, $state = 0) {
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadFeed(0) is deprecated!');
		}
		$this->bd->beginTransaction();

		$sql = 'UPDATE `' . $this->prefix . 'entry` '
			 . 'SET is_read=1 '
			 . 'WHERE id_feed=? AND is_read=0 AND id <= ?';
		$values = array($id_feed, $idMax);

		list($searchValues, $search) = $this->sqlListEntriesWhere('', $filter, $state);

		$stm = $this->bd->prepare($sql . $search);
		if (!($stm && $stm->execute(array_merge($values, $searchValues)))) {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error markReadFeed: ' . $info[2] . ' with SQL: ' . $sql . $search);
			$this->bd->rollBack();
			return false;
		}
		$affected = $stm->rowCount();

		if ($affected > 0) {
			$sql = 'UPDATE `' . $this->prefix . 'feed` '
				 . 'SET `cache_nbUnreads`=`cache_nbUnreads`-' . $affected
				 . ' WHERE id=?';
			$values = array($id_feed);
			$stm = $this->bd->prepare($sql);
			if (!($stm && $stm->execute($values))) {
				$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
				Minz_Log::error('SQL error markReadFeed cache: ' . $info[2]);
				$this->bd->rollBack();
				return false;
			}
		}

		$this->bd->commit();
		return $affected;
	}

	public function searchByGuid($id_feed, $guid) {
		// un guid est unique pour un flux donné
		$sql = 'SELECT id, guid, title, author, '
		     . ($this->isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content')
		     . ', link, date, is_read, is_favorite, id_feed, tags '
		     . 'FROM `' . $this->prefix . 'entry` WHERE id_feed=? AND guid=?';
		$stm = $this->bd->prepare($sql);

		$values = array(
			$id_feed,
			$guid,
		);

		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$entries = self::daoToEntry($res);
		return isset($entries[0]) ? $entries[0] : null;
	}

	public function searchById($id) {
		$sql = 'SELECT id, guid, title, author, '
		     . ($this->isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content')
		     . ', link, date, is_read, is_favorite, id_feed, tags '
		     . 'FROM `' . $this->prefix . 'entry` WHERE id=?';
		$stm = $this->bd->prepare($sql);

		$values = array($id);

		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$entries = self::daoToEntry($res);
		return isset($entries[0]) ? $entries[0] : null;
	}

	protected function sqlConcat($s1, $s2) {
		return 'CONCAT(' . $s1 . ',' . $s2 . ')';	//MySQL
	}

	protected function sqlListEntriesWhere($alias = '', $filter = null, $state = FreshRSS_Entry::STATE_ALL, $order = 'DESC', $firstId = '', $date_min = 0) {
		$search = ' ';
		$values = array();
		if ($state & FreshRSS_Entry::STATE_NOT_READ) {
			if (!($state & FreshRSS_Entry::STATE_READ)) {
				$search .= 'AND ' . $alias . 'is_read=0 ';
			}
		}
		elseif ($state & FreshRSS_Entry::STATE_READ) {
			$search .= 'AND ' . $alias . 'is_read=1 ';
		}
		if ($state & FreshRSS_Entry::STATE_FAVORITE) {
			if (!($state & FreshRSS_Entry::STATE_NOT_FAVORITE)) {
				$search .= 'AND ' . $alias . 'is_favorite=1 ';
			}
		}
		elseif ($state & FreshRSS_Entry::STATE_NOT_FAVORITE) {
			$search .= 'AND ' . $alias . 'is_favorite=0 ';
		}

		switch ($order) {
			case 'DESC':
			case 'ASC':
				break;
			default:
				throw new FreshRSS_EntriesGetter_Exception('Bad order in Entry->listByType: [' . $order . ']!');
		}
		/*if ($firstId === '' && parent::$sharedDbType === 'mysql') {
			$firstId = $order === 'DESC' ? '9000000000'. '000000' : '0';	//MySQL optimization. TODO: check if this is needed again, after the filtering for old articles has been removed in 0.9-dev
		}*/
		if ($firstId !== '') {
			$search .= 'AND ' . $alias . 'id ' . ($order === 'DESC' ? '<=' : '>=') . $firstId . ' ';
		}
		if ($date_min > 0) {
			$search .= 'AND ' . $alias . 'id >= ' . $date_min . '000000 ';
		}
		if ($filter) {
			if ($filter->getIntitle()) {
				$search .= 'AND ' . $alias . 'title LIKE ? ';
				$values[] = "%{$filter->getIntitle()}%";
			}
			if ($filter->getInurl()) {
				$search .= 'AND CONCAT(' . $alias . 'link, ' . $alias . 'guid) LIKE ? ';
				$values[] = "%{$filter->getInurl()}%";
			}
			if ($filter->getAuthor()) {
				$search .= 'AND ' . $alias . 'author LIKE ? ';
				$values[] = "%{$filter->getAuthor()}%";
			}
			if ($filter->getMinDate()) {
				$search .= 'AND ' . $alias . 'id >= ? ';
				$values[] = "{$filter->getMinDate()}000000";
			}
			if ($filter->getMaxDate()) {
				$search .= 'AND ' . $alias . 'id <= ? ';
				$values[] = "{$filter->getMaxDate()}000000";
			}
			if ($filter->getMinPubdate()) {
				$search .= 'AND ' . $alias . 'date >= ? ';
				$values[] = $filter->getMinPubdate();
			}
			if ($filter->getMaxPubdate()) {
				$search .= 'AND ' . $alias . 'date <= ? ';
				$values[] = $filter->getMaxPubdate();
			}
			if ($filter->getTags()) {
				$tags = $filter->getTags();
				foreach ($tags as $tag) {
					$search .= 'AND ' . $alias . 'tags LIKE ? ';
					$values[] = "%{$tag}%";
				}
			}
			if ($filter->getSearch()) {
				$search_values = $filter->getSearch();
				foreach ($search_values as $search_value) {
					$search .= 'AND ' . $this->sqlconcat($alias . 'title', $this->isCompressed() ? 'UNCOMPRESS(' . $alias . 'content_bin)' : '' . $alias . 'content') . ' LIKE ? ';
					$values[] = "%{$search_value}%";
				}
			}
		}
		return array($values, $search);
	}

	private function sqlListWhere($type = 'a', $id = '', $state = FreshRSS_Entry::STATE_ALL, $order = 'DESC', $limit = 1, $firstId = '', $filter = '', $date_min = 0) {
		if (!$state) {
			$state = FreshRSS_Entry::STATE_ALL;
		}
		$where = '';
		$joinFeed = false;
		$values = array();
		switch ($type) {
		case 'a':
			$where .= 'f.priority > 0 ';
			$joinFeed = true;
			break;
		case 's':	//Deprecated: use $state instead
			$where .= 'e.is_favorite=1 ';
			break;
		case 'c':
			$where .= 'f.category=? ';
			$values[] = intval($id);
			$joinFeed = true;
			break;
		case 'f':
			$where .= 'e.id_feed=? ';
			$values[] = intval($id);
			break;
		case 'A':
			$where .= '1 ';
			break;
		default:
			throw new FreshRSS_EntriesGetter_Exception('Bad type in Entry->listByType: [' . $type . ']!');
		}

		list($searchValues, $search) = $this->sqlListEntriesWhere('e.', $filter, $state, $order, $firstId, $date_min);

		return array(array_merge($values, $searchValues),
			'SELECT e.id FROM `' . $this->prefix . 'entry` e '
			. ($joinFeed ? 'INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id ' : '')
			. 'WHERE ' . $where
			. $search
			. 'ORDER BY e.id ' . $order
			. ($limit > 0 ? ' LIMIT ' . $limit : ''));	//TODO: See http://explainextended.com/2009/10/23/mysql-order-by-limit-performance-late-row-lookups/
	}

	public function listWhere($type = 'a', $id = '', $state = FreshRSS_Entry::STATE_ALL, $order = 'DESC', $limit = 1, $firstId = '', $filter = '', $date_min = 0) {
		list($values, $sql) = $this->sqlListWhere($type, $id, $state, $order, $limit, $firstId, $filter, $date_min);

		$sql = 'SELECT e0.id, e0.guid, e0.title, e0.author, '
		     . ($this->isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content')
		     . ', e0.link, e0.date, e0.is_read, e0.is_favorite, e0.id_feed, e0.tags '
		     . 'FROM `' . $this->prefix . 'entry` e0 '
		     . 'INNER JOIN ('
		     . $sql
		     . ') e2 ON e2.id=e0.id '
		     . 'ORDER BY e0.id ' . $order;

		$stm = $this->bd->prepare($sql);
		$stm->execute($values);

		return self::daoToEntry($stm->fetchAll(PDO::FETCH_ASSOC));
	}

	public function listIdsWhere($type = 'a', $id = '', $state = FreshRSS_Entry::STATE_ALL, $order = 'DESC', $limit = 1, $firstId = '', $filter = '', $date_min = 0) {	//For API
		list($values, $sql) = $this->sqlListWhere($type, $id, $state, $order, $limit, $firstId, $filter, $date_min);

		$stm = $this->bd->prepare($sql);
		$stm->execute($values);

		return $stm->fetchAll(PDO::FETCH_COLUMN, 0);
	}

	public function listHashForFeedGuids($id_feed, $guids) {
		if (count($guids) < 1) {
			return array();
		}
		$sql = 'SELECT guid, ' . $this->sqlHexEncode('hash') . ' AS hex_hash FROM `' . $this->prefix . 'entry` WHERE id_feed=? AND guid IN (' . str_repeat('?,', count($guids) - 1). '?)';
		$stm = $this->bd->prepare($sql);
		$values = array($id_feed);
		$values = array_merge($values, $guids);
		if ($stm && $stm->execute($values)) {
			$result = array();
			$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rows as $row) {
				$result[$row['guid']] = $row['hex_hash'];
			}
			return $result;
		} else {
			$info = $stm == null ? array(0 => '', 1 => '', 2 => 'syntax error') : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->listHashForFeedGuids($id_feed, $guids);
			}
			Minz_Log::error('SQL error listHashForFeedGuids: ' . $info[0] . ': ' . $info[1] . ' ' . $info[2]
				. ' while querying feed ' . $id_feed);
			return false;
		}
	}

	public function updateLastSeen($id_feed, $guids, $mtime = 0) {
		if (count($guids) < 1) {
			return 0;
		}
		$sql = 'UPDATE `' . $this->prefix . 'entry` SET `lastSeen`=? WHERE id_feed=? AND guid IN (' . str_repeat('?,', count($guids) - 1). '?)';
		$stm = $this->bd->prepare($sql);
		if ($mtime <= 0) {
			$mtime = time();
		}
		$values = array($mtime, $id_feed);
		$values = array_merge($values, $guids);
		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(0 => '', 1 => '', 2 => 'syntax error') : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->updateLastSeen($id_feed, $guids);
			}
			Minz_Log::error('SQL error updateLastSeen: ' . $info[0] . ': ' . $info[1] . ' ' . $info[2]
				. ' while updating feed ' . $id_feed);
			return false;
		}
	}

	public function countUnreadRead() {
		$sql = 'SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id WHERE priority > 0'
		     . ' UNION SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id WHERE priority > 0 AND is_read=0';
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		$all = empty($res[0]) ? 0 : $res[0];
		$unread = empty($res[1]) ? 0 : $res[1];
		return array('all' => $all, 'unread' => $unread, 'read' => $all - $unread);
	}
	public function count($minPriority = null) {
		$sql = 'SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id';
		if ($minPriority !== null) {
			$sql = ' WHERE priority > ' . intval($minPriority);
		}
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return $res[0];
	}
	public function countNotRead($minPriority = null) {
		$sql = 'SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id WHERE is_read=0';
		if ($minPriority !== null) {
			$sql = ' AND priority > ' . intval($minPriority);
		}
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return $res[0];
	}

	public function countUnreadReadFavorites() {
		$sql = 'SELECT c FROM ('
		     .	'SELECT COUNT(id) AS c, 1 as o FROM `' . $this->prefix . 'entry` WHERE is_favorite=1 '
		     .	'UNION SELECT COUNT(id) AS c, 2 AS o FROM `' . $this->prefix . 'entry` WHERE is_favorite=1 AND is_read=0'
		     .	') u ORDER BY o';
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		$all = empty($res[0]) ? 0 : $res[0];
		$unread = empty($res[1]) ? 0 : $res[1];
		return array('all' => $all, 'unread' => $unread, 'read' => $all - $unread);
	}

	public function optimizeTable() {
		$sql = 'OPTIMIZE TABLE `' . $this->prefix . 'entry`';	//MySQL
		$stm = $this->bd->prepare($sql);
		if ($stm) {
			return $stm->execute();
		}
	}

	public function size($all = false) {
		$db = FreshRSS_Context::$system_conf->db;
		$sql = 'SELECT SUM(data_length + index_length) FROM information_schema.TABLES WHERE table_schema=?';	//MySQL
		$values = array($db['base']);
		if (!$all) {
			$sql .= ' AND table_name LIKE ?';
			$values[] = $this->prefix . '%';
		}
		$stm = $this->bd->prepare($sql);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return $res[0];
	}

	public static function daoToEntry($listDAO) {
		$list = array();

		if (!is_array($listDAO)) {
			$listDAO = array($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			$entry = new FreshRSS_Entry(
				$dao['id_feed'],
				$dao['guid'],
				$dao['title'],
				$dao['author'],
				$dao['content'],
				$dao['link'],
				$dao['date'],
				$dao['is_read'],
				$dao['is_favorite'],
				$dao['tags']
			);
			if (isset($dao['id'])) {
				$entry->_id($dao['id']);
			}
			$list[] = $entry;
		}

		unset($listDAO);

		return $list;
	}
}

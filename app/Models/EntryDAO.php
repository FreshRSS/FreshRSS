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

	//TODO: Move the database auto-updates to DatabaseDAO
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

	//TODO: Move the database auto-updates to DatabaseDAO
	protected function updateToUtf8mb4() {
		if ($this->triedUpdateToUtf8mb4) {
			return false;
		}
		$this->triedUpdateToUtf8mb4 = true;
		$db = FreshRSS_Context::$system_conf->db;
		if ($db['type'] === 'mysql') {
			include_once(APP_PATH . '/SQL/install.sql.mysql.php');
			if (defined('SQL_UPDATE_UTF8MB4')) {
				Minz_Log::warning('Updating MySQL to UTF8MB4...');	//v1.5.0
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

	//TODO: Move the database auto-updates to DatabaseDAO
	protected function createEntryTempTable() {
		$ok = false;
		$hadTransaction = $this->bd->inTransaction();
		if ($hadTransaction) {
			$this->bd->commit();
		}
		try {
			$db = FreshRSS_Context::$system_conf->db;
			require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');
			Minz_Log::warning('SQL CREATE TABLE entrytmp...');
			if (defined('SQL_CREATE_TABLE_ENTRYTMP')) {
				$sql = sprintf(SQL_CREATE_TABLE_ENTRYTMP, $this->prefix);
				$stm = $this->bd->prepare($sql);
				$ok = $stm && $stm->execute();
			} else {
				global $SQL_CREATE_TABLE_ENTRYTMP;
				$ok = !empty($SQL_CREATE_TABLE_ENTRYTMP);
				foreach ($SQL_CREATE_TABLE_ENTRYTMP as $instruction) {
					$sql = sprintf($instruction, $this->prefix);
					$stm = $this->bd->prepare($sql);
					$ok &= $stm && $stm->execute();
				}
			}
		} catch (Exception $e) {
			Minz_Log::error('FreshRSS_EntryDAO::createEntryTempTable error: ' . $e->getMessage());
		}
		if ($hadTransaction) {
			$this->bd->beginTransaction();
		}
		return $ok;
	}

	//TODO: Move the database auto-updates to DatabaseDAO
	protected function autoUpdateDb($errorInfo) {
		if (isset($errorInfo[0])) {
			if ($errorInfo[0] === FreshRSS_DatabaseDAO::ER_BAD_FIELD_ERROR) {
				//autoAddColumn
				foreach (array('lastSeen', 'hash') as $column) {
					if (stripos($errorInfo[2], $column) !== false) {
						return $this->addColumn($column);
					}
				}
			} elseif ($errorInfo[0] === FreshRSS_DatabaseDAO::ER_BAD_TABLE_ERROR) {
				if (stripos($errorInfo[2], 'tag') !== false) {
					$tagDAO = FreshRSS_Factory::createTagDao();
					return $tagDAO->createTagTable();	//v1.12.0
				} elseif (stripos($errorInfo[2], 'entrytmp') !== false) {
					return $this->createEntryTempTable();	//v1.7.0
				}
			}
		}
		if (isset($errorInfo[1])) {
			if ($errorInfo[1] == FreshRSS_DatabaseDAO::ER_TRUNCATED_WRONG_VALUE_FOR_FIELD) {
				return $this->updateToUtf8mb4();	//v1.5.0
			}
		}
		return false;
	}

	private $addEntryPrepared = null;

	public function addEntry($valuesTmp) {
		if ($this->addEntryPrepared == null) {
			$sql = 'INSERT INTO `' . $this->prefix . 'entrytmp` (id, guid, title, author, '
				. ($this->isCompressed() ? 'content_bin' : 'content')
				. ', link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags) '
				. 'VALUES(:id, :guid, :title, :author, '
				. ($this->isCompressed() ? 'COMPRESS(:content)' : ':content')
				. ', :link, :date, :last_seen, '
				. $this->sqlHexDecode(':hash')
				. ', :is_read, :is_favorite, :id_feed, :tags)';
			$this->addEntryPrepared = $this->bd->prepare($sql);
		}
		if ($this->addEntryPrepared) {
			$this->addEntryPrepared->bindParam(':id', $valuesTmp['id']);
			$valuesTmp['guid'] = substr($valuesTmp['guid'], 0, 760);
			$valuesTmp['guid'] = safe_ascii($valuesTmp['guid']);
			$this->addEntryPrepared->bindParam(':guid', $valuesTmp['guid']);
			$valuesTmp['title'] = mb_strcut($valuesTmp['title'], 0, 255, 'UTF-8');
			$this->addEntryPrepared->bindParam(':title', $valuesTmp['title']);
			$valuesTmp['author'] = mb_strcut($valuesTmp['author'], 0, 255, 'UTF-8');
			$this->addEntryPrepared->bindParam(':author', $valuesTmp['author']);
			$this->addEntryPrepared->bindParam(':content', $valuesTmp['content']);
			$valuesTmp['link'] = substr($valuesTmp['link'], 0, 1023);
			$valuesTmp['link'] = safe_ascii($valuesTmp['link']);
			$this->addEntryPrepared->bindParam(':link', $valuesTmp['link']);
			$this->addEntryPrepared->bindParam(':date', $valuesTmp['date'], PDO::PARAM_INT);
			$valuesTmp['lastSeen'] = time();
			$this->addEntryPrepared->bindParam(':last_seen', $valuesTmp['lastSeen'], PDO::PARAM_INT);
			$valuesTmp['is_read'] = $valuesTmp['is_read'] ? 1 : 0;
			$this->addEntryPrepared->bindParam(':is_read', $valuesTmp['is_read'], PDO::PARAM_INT);
			$valuesTmp['is_favorite'] = $valuesTmp['is_favorite'] ? 1 : 0;
			$this->addEntryPrepared->bindParam(':is_favorite', $valuesTmp['is_favorite'], PDO::PARAM_INT);
			$this->addEntryPrepared->bindParam(':id_feed', $valuesTmp['id_feed'], PDO::PARAM_INT);
			$valuesTmp['tags'] = mb_strcut($valuesTmp['tags'], 0, 1023, 'UTF-8');
			$this->addEntryPrepared->bindParam(':tags', $valuesTmp['tags']);

			if ($this->hasNativeHex()) {
				$this->addEntryPrepared->bindParam(':hash', $valuesTmp['hash']);
			} else {
				$valuesTmp['hashBin'] = hex2bin($valuesTmp['hash']);
				$this->addEntryPrepared->bindParam(':hash', $valuesTmp['hashBin']);
			}
		}
		if ($this->addEntryPrepared && $this->addEntryPrepared->execute()) {
			return true;
		} else {
			$info = $this->addEntryPrepared == null ? array(0 => '', 1 => '', 2 => 'syntax error') : $this->addEntryPrepared->errorInfo();
			if ($this->autoUpdateDb($info)) {
				$this->addEntryPrepared = null;
				return $this->addEntry($valuesTmp);
			} elseif ((int)((int)$info[0] / 1000) !== 23) {	//Filter out "SQLSTATE Class code 23: Constraint Violation" because of expected duplicate entries
				Minz_Log::error('SQL error addEntry: ' . $info[0] . ': ' . $info[1] . ' ' . $info[2]
					. ' while adding entry in feed ' . $valuesTmp['id_feed'] . ' with title: ' . $valuesTmp['title']);
			}
			return false;
		}
	}

	public function commitNewEntries() {
		$sql = 'SET @rank=(SELECT MAX(id) - COUNT(*) FROM `' . $this->prefix . 'entrytmp`); ' .	//MySQL-specific
			'INSERT IGNORE INTO `' . $this->prefix . 'entry`
				(
					id, guid, title, author, content_bin, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags
				) ' .
				'SELECT @rank:=@rank+1 AS id, guid, title, author, content_bin, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags
					FROM `' . $this->prefix . 'entrytmp`
					ORDER BY date; ' .
			'DELETE FROM `' . $this->prefix . 'entrytmp` WHERE id <= @rank;';
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
		$valuesTmp['title'] = mb_strcut($valuesTmp['title'], 0, 255, 'UTF-8');
		$this->updateEntryPrepared->bindParam(':title', $valuesTmp['title']);
		$valuesTmp['author'] = mb_strcut($valuesTmp['author'], 0, 255, 'UTF-8');
		$this->updateEntryPrepared->bindParam(':author', $valuesTmp['author']);
		$this->updateEntryPrepared->bindParam(':content', $valuesTmp['content']);
		$valuesTmp['link'] = substr($valuesTmp['link'], 0, 1023);
		$valuesTmp['link'] = safe_ascii($valuesTmp['link']);
		$this->updateEntryPrepared->bindParam(':link', $valuesTmp['link']);
		$this->updateEntryPrepared->bindParam(':date', $valuesTmp['date'], PDO::PARAM_INT);
		$valuesTmp['lastSeen'] = time();
		$this->updateEntryPrepared->bindParam(':last_seen', $valuesTmp['lastSeen'], PDO::PARAM_INT);
		if ($valuesTmp['is_read'] !== null) {
			$this->updateEntryPrepared->bindValue(':is_read', $valuesTmp['is_read'] ? 1 : 0, PDO::PARAM_INT);
		}
		$this->updateEntryPrepared->bindParam(':id_feed', $valuesTmp['id_feed'], PDO::PARAM_INT);
		$valuesTmp['tags'] = mb_strcut($valuesTmp['tags'], 0, 1023, 'UTF-8');
		$this->updateEntryPrepared->bindParam(':tags', $valuesTmp['tags']);

		if ($this->hasNativeHex()) {
			$this->updateEntryPrepared->bindParam(':hash', $valuesTmp['hash']);
		} else {
			$valuesTmp['hashBin'] = hex2bin($valuesTmp['hash']);
			$this->updateEntryPrepared->bindParam(':hash', $valuesTmp['hashBin']);
		}

		if ($this->updateEntryPrepared && $this->updateEntryPrepared->execute()) {
			return true;
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
		FreshRSS_UserDAO::touch();
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
			. 'SET f.`cache_nbUnreads`=COALESCE(x.nbUnreads, 0)';
		$hasWhere = false;
		$values = array();
		if ($feedId !== false) {
			$sql .= $hasWhere ? ' AND' : ' WHERE';
			$hasWhere = true;
			$sql .= ' f.id=?';
			$values[] = $feedId;
		}
		if ($catId !== false) {
			$sql .= $hasWhere ? ' AND' : ' WHERE';
			$hasWhere = true;
			$sql .= ' f.category=?';
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
		FreshRSS_UserDAO::touch();
		if (is_array($ids)) {	//Many IDs at once
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
	public function markReadEntries($idMax = 0, $onlyFavorites = false, $priorityMin = 0, $filters = null, $state = 0, $is_read = true) {
		FreshRSS_UserDAO::touch();
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadEntries(0) is deprecated!');
		}

		$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id '
			 . 'SET e.is_read=? '
			 . 'WHERE e.is_read <> ? AND e.id <= ?';
		if ($onlyFavorites) {
			$sql .= ' AND e.is_favorite=1';
		} elseif ($priorityMin >= 0) {
			$sql .= ' AND f.priority > ' . intval($priorityMin);
		}
		$values = array($is_read ? 1 : 0, $is_read ? 1 : 0, $idMax);

		list($searchValues, $search) = $this->sqlListEntriesWhere('e.', $filters, $state);

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
	public function markReadCat($id, $idMax = 0, $filters = null, $state = 0, $is_read = true) {
		FreshRSS_UserDAO::touch();
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadCat(0) is deprecated!');
		}

		$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id '
			 . 'SET e.is_read=? '
			 . 'WHERE f.category=? AND e.is_read <> ? AND e.id <= ?';
		$values = array($is_read ? 1 : 0, $id, $is_read ? 1 : 0, $idMax);

		list($searchValues, $search) = $this->sqlListEntriesWhere('e.', $filters, $state);

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
	public function markReadFeed($id_feed, $idMax = 0, $filters = null, $state = 0, $is_read = true) {
		FreshRSS_UserDAO::touch();
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadFeed(0) is deprecated!');
		}
		$this->bd->beginTransaction();

		$sql = 'UPDATE `' . $this->prefix . 'entry` '
			 . 'SET is_read=? '
			 . 'WHERE id_feed=? AND is_read <> ? AND id <= ?';
		$values = array($is_read ? 1 : 0, $id_feed, $is_read ? 1 : 0, $idMax);

		list($searchValues, $search) = $this->sqlListEntriesWhere('', $filters, $state);

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

	/**
	 * Mark all the articles in a tag as read.
	 * @param integer $id tag ID, or empty for targetting any tag
	 * @param integer $idMax max article ID
	 * @return integer affected rows
	 */
	public function markReadTag($id = '', $idMax = 0, $filters = null, $state = 0, $is_read = true) {
		FreshRSS_UserDAO::touch();
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadTag(0) is deprecated!');
		}

		$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'entrytag` et ON et.id_entry = e.id '
			 . 'SET e.is_read = ? '
			 . 'WHERE '
			 . ($id == '' ? '' : 'et.id_tag = ? AND ')
			 . 'e.is_read <> ? AND e.id <= ?';
		$values = array($is_read ? 1 : 0);
		if ($id != '') {
			$values[] = $id;
		}
		$values[] = $is_read ? 1 : 0;
		$values[] = $idMax;

		list($searchValues, $search) = $this->sqlListEntriesWhere('e.', $filters, $state);

		$stm = $this->bd->prepare($sql . $search);
		if (!($stm && $stm->execute(array_merge($values, $searchValues)))) {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error markReadTag: ' . $info[2]);
			return false;
		}
		$affected = $stm->rowCount();
		if (($affected > 0) && (!$this->updateCacheUnreads(false, false))) {
			return false;
		}
		return $affected;
	}

	public function cleanOldEntries($id_feed, $date_min, $keep = 15) {	//Remember to call updateCachedValue($id_feed) or updateCachedValues() just after
		$sql = 'DELETE FROM `' . $this->prefix . 'entry` '
		     . 'WHERE id_feed=:id_feed AND id<=:id_max '
		     . 'AND is_favorite=0 '	//Do not remove favourites
		     . 'AND `lastSeen` < (SELECT maxLastSeen FROM (SELECT (MAX(e3.`lastSeen`)-99) AS maxLastSeen FROM `' . $this->prefix . 'entry` e3 WHERE e3.id_feed=:id_feed) recent) '	//Do not remove the most newly seen articles, plus a few seconds of tolerance
		     . 'AND id NOT IN (SELECT id_entry FROM `' . $this->prefix . 'entrytag`) '	//Do not purge tagged entries
		     . 'AND id NOT IN (SELECT id FROM (SELECT e2.id FROM `' . $this->prefix . 'entry` e2 WHERE e2.id_feed=:id_feed ORDER BY id DESC LIMIT :keep) keep)';	//Double select: MySQL doesn't support 'LIMIT & IN/ALL/ANY/SOME subquery'
		$stm = $this->bd->prepare($sql);

		if ($stm) {
			$id_max = intval($date_min) . '000000';
			$stm->bindParam(':id_feed', $id_feed, PDO::PARAM_INT);
			$stm->bindParam(':id_max', $id_max, PDO::PARAM_STR);
			$stm->bindParam(':keep', $keep, PDO::PARAM_INT);
		}

		if ($stm && $stm->execute()) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(0 => '', 1 => '', 2 => 'syntax error') : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->cleanOldEntries($id_feed, $date_min, $keep);
			}
			Minz_Log::error('SQL error cleanOldEntries: ' . $info[2]);
			return false;
		}
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
		$entries = self::daoToEntries($res);
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
		$entries = self::daoToEntries($res);
		return isset($entries[0]) ? $entries[0] : null;
	}

	public function searchIdByGuid($id_feed, $guid) {
		$sql = 'SELECT id FROM `' . $this->prefix . 'entry` WHERE id_feed=? AND guid=?';
		$stm = $this->bd->prepare($sql);
		$values = array($id_feed, $guid);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return isset($res[0]) ? $res[0] : null;
	}

	protected function sqlConcat($s1, $s2) {
		return 'CONCAT(' . $s1 . ',' . $s2 . ')';	//MySQL
	}

	protected function sqlListEntriesWhere($alias = '', $filters = null, $state = FreshRSS_Entry::STATE_ALL, $order = 'DESC', $firstId = '', $date_min = 0) {
		$search = ' ';
		$values = array();
		if ($state & FreshRSS_Entry::STATE_NOT_READ) {
			if (!($state & FreshRSS_Entry::STATE_READ)) {
				$search .= 'AND ' . $alias . 'is_read=0 ';
			}
		} elseif ($state & FreshRSS_Entry::STATE_READ) {
			$search .= 'AND ' . $alias . 'is_read=1 ';
		}
		if ($state & FreshRSS_Entry::STATE_FAVORITE) {
			if (!($state & FreshRSS_Entry::STATE_NOT_FAVORITE)) {
				$search .= 'AND ' . $alias . 'is_favorite=1 ';
			}
		} elseif ($state & FreshRSS_Entry::STATE_NOT_FAVORITE) {
			$search .= 'AND ' . $alias . 'is_favorite=0 ';
		}

		switch ($order) {
			case 'DESC':
			case 'ASC':
				break;
			default:
				throw new FreshRSS_EntriesGetter_Exception('Bad order in Entry->listByType: [' . $order . ']!');
		}
		if ($firstId !== '') {
			$search .= 'AND ' . $alias . 'id ' . ($order === 'DESC' ? '<=' : '>=') . ' ? ';
			$values[] = $firstId;
		}
		if ($date_min > 0) {
			$search .= 'AND ' . $alias . 'id >= ? ';
			$values[] = $date_min . '000000';
		}
		if ($filters && count($filters->searches()) > 0) {
			$isOpen = false;
			foreach ($filters->searches() as $filter) {
				if ($filter == null) {
					continue;
				}
				$sub_search = '';
				if ($filter->getMinDate()) {
					$sub_search .= 'AND ' . $alias . 'id >= ? ';
					$values[] = "{$filter->getMinDate()}000000";
				}
				if ($filter->getMaxDate()) {
					$sub_search .= 'AND ' . $alias . 'id <= ? ';
					$values[] = "{$filter->getMaxDate()}000000";
				}
				if ($filter->getMinPubdate()) {
					$sub_search .= 'AND ' . $alias . 'date >= ? ';
					$values[] = $filter->getMinPubdate();
				}
				if ($filter->getMaxPubdate()) {
					$sub_search .= 'AND ' . $alias . 'date <= ? ';
					$values[] = $filter->getMaxPubdate();
				}

				if ($filter->getAuthor()) {
					foreach ($filter->getAuthor() as $author) {
						$sub_search .= 'AND ' . $alias . 'author LIKE ? ';
						$values[] = "%{$author}%";
					}
				}
				if ($filter->getIntitle()) {
					foreach ($filter->getIntitle() as $title) {
						$sub_search .= 'AND ' . $alias . 'title LIKE ? ';
						$values[] = "%{$title}%";
					}
				}
				if ($filter->getTags()) {
					foreach ($filter->getTags() as $tag) {
						$sub_search .= 'AND ' . $alias . 'tags LIKE ? ';
						$values[] = "%{$tag}%";
					}
				}
				if ($filter->getInurl()) {
					foreach ($filter->getInurl() as $url) {
						$sub_search .= 'AND CONCAT(' . $alias . 'link, ' . $alias . 'guid) LIKE ? ';
						$values[] = "%{$url}%";
					}
				}

				if ($filter->getNotAuthor()) {
					foreach ($filter->getNotAuthor() as $author) {
						$sub_search .= 'AND (NOT ' . $alias . 'author LIKE ?) ';
						$values[] = "%{$author}%";
					}
				}
				if ($filter->getNotIntitle()) {
					foreach ($filter->getNotIntitle() as $title) {
						$sub_search .= 'AND (NOT ' . $alias . 'title LIKE ?) ';
						$values[] = "%{$title}%";
					}
				}
				if ($filter->getNotTags()) {
					foreach ($filter->getNotTags() as $tag) {
						$sub_search .= 'AND (NOT ' . $alias . 'tags LIKE ?) ';
						$values[] = "%{$tag}%";
					}
				}
				if ($filter->getNotInurl()) {
					foreach ($filter->getNotInurl() as $url) {
						$sub_search .= 'AND (NOT CONCAT(' . $alias . 'link, ' . $alias . 'guid) LIKE ?) ';
						$values[] = "%{$url}%";
					}
				}

				if ($filter->getSearch()) {
					foreach ($filter->getSearch() as $search_value) {
						$sub_search .= 'AND ' . $this->sqlconcat($alias . 'title', $this->isCompressed() ? 'UNCOMPRESS(' . $alias . 'content_bin)' : '' . $alias . 'content') . ' LIKE ? ';
						$values[] = "%{$search_value}%";
					}
				}
				if ($filter->getNotSearch()) {
					foreach ($filter->getNotSearch() as $search_value) {
						$sub_search .= 'AND (NOT ' . $this->sqlconcat($alias . 'title', $this->isCompressed() ? 'UNCOMPRESS(' . $alias . 'content_bin)' : '' . $alias . 'content') . ' LIKE ?) ';
						$values[] = "%{$search_value}%";
					}
				}

				if ($sub_search != '') {
					if ($isOpen) {
						$search .= 'OR ';
					} else {
						$search .= 'AND (';
						$isOpen = true;
					}
					$search .= '(' . substr($sub_search, 4) . ') ';
				}
			}
			if ($isOpen) {
				$search .= ') ';
			}
		}
		return array($values, $search);
	}

	private function sqlListWhere($type = 'a', $id = '', $state = FreshRSS_Entry::STATE_ALL, $order = 'DESC', $limit = 1, $firstId = '', $filters = null, $date_min = 0) {
		if (!$state) {
			$state = FreshRSS_Entry::STATE_ALL;
		}
		$where = '';
		$joinFeed = false;
		$values = array();
		switch ($type) {
		case 'a':	//All PRIORITY_MAIN_STREAM
			$where .= 'f.priority > ' . FreshRSS_Feed::PRIORITY_NORMAL . ' ';
			break;
		case 'A':	//All except PRIORITY_ARCHIVED
			$where .= 'f.priority >= ' . FreshRSS_Feed::PRIORITY_NORMAL . ' ';
			break;
		case 's':	//Starred. Deprecated: use $state instead
			$where .= 'f.priority >= ' . FreshRSS_Feed::PRIORITY_NORMAL . ' ';
			$where .= 'AND e.is_favorite=1 ';
			break;
		case 'S':	//Starred
			$where .= 'e.is_favorite=1 ';
			break;
		case 'c':	//Category
			$where .= 'f.priority >= ' . FreshRSS_Feed::PRIORITY_NORMAL . ' ';
			$where .= 'AND f.category=? ';
			$values[] = intval($id);
			break;
		case 'f':	//Feed
			$where .= 'e.id_feed=? ';
			$values[] = intval($id);
			break;
		case 't':	//Tag
			$where .= 'et.id_tag=? ';
			$values[] = intval($id);
			break;
		case 'T':	//Any tag
			$where .= '1=1 ';
			break;
		case 'ST':	//Starred or tagged
			$where .= 'e.is_favorite=1 OR EXISTS (SELECT et2.id_tag FROM `' . $this->prefix . 'entrytag` et2 WHERE et2.id_entry = e.id) ';
			break;
		default:
			throw new FreshRSS_EntriesGetter_Exception('Bad type in Entry->listByType: [' . $type . ']!');
		}

		list($searchValues, $search) = $this->sqlListEntriesWhere('e.', $filters, $state, $order, $firstId, $date_min);

		return array(array_merge($values, $searchValues),
			'SELECT '
			. ($type === 'T' ? 'DISTINCT ' : '')
			. 'e.id FROM `' . $this->prefix . 'entry` e '
			. 'INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
			. ($type === 't' || $type === 'T' ? 'INNER JOIN `' . $this->prefix . 'entrytag` et ON et.id_entry = e.id ' : '')
			. 'WHERE ' . $where
			. $search
			. 'ORDER BY e.id ' . $order
			. ($limit > 0 ? ' LIMIT ' . intval($limit) : ''));	//TODO: See http://explainextended.com/2009/10/23/mysql-order-by-limit-performance-late-row-lookups/
	}

	public function listWhereRaw($type = 'a', $id = '', $state = FreshRSS_Entry::STATE_ALL, $order = 'DESC', $limit = 1, $firstId = '', $filters = null, $date_min = 0) {
		list($values, $sql) = $this->sqlListWhere($type, $id, $state, $order, $limit, $firstId, $filters, $date_min);

		$sql = 'SELECT e0.id, e0.guid, e0.title, e0.author, '
			. ($this->isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content')
			. ', e0.link, e0.date, e0.is_read, e0.is_favorite, e0.id_feed, e0.tags '
			. 'FROM `' . $this->prefix . 'entry` e0 '
			. 'INNER JOIN ('
			. $sql
			. ') e2 ON e2.id=e0.id '
			. 'ORDER BY e0.id ' . $order;

		$stm = $this->bd->prepare($sql);
		if ($stm && $stm->execute($values)) {
			return $stm;
		} else {
			$info = $stm == null ? array(0 => '', 1 => '', 2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error listWhereRaw: ' . $info[2]);
			return false;
		}
	}

	public function listWhere($type = 'a', $id = '', $state = FreshRSS_Entry::STATE_ALL, $order = 'DESC', $limit = 1, $firstId = '', $filters = null, $date_min = 0) {
		$stm = $this->listWhereRaw($type, $id, $state, $order, $limit, $firstId, $filters, $date_min);
		if ($stm) {
			return self::daoToEntries($stm->fetchAll(PDO::FETCH_ASSOC));
		} else {
			return false;
		}
	}

	public function listByIds($ids, $order = 'DESC') {
		if (count($ids) < 1) {
			return array();
		}

		$sql = 'SELECT id, guid, title, author, '
			. ($this->isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content')
			. ', link, date, is_read, is_favorite, id_feed, tags '
			. 'FROM `' . $this->prefix . 'entry` '
			. 'WHERE id IN (' . str_repeat('?,', count($ids) - 1). '?) '
			. 'ORDER BY id ' . $order;

		$stm = $this->bd->prepare($sql);
		$stm->execute($ids);
		return self::daoToEntries($stm->fetchAll(PDO::FETCH_ASSOC));
	}

	public function listIdsWhere($type = 'a', $id = '', $state = FreshRSS_Entry::STATE_ALL, $order = 'DESC', $limit = 1, $firstId = '', $filters = null) {	//For API
		list($values, $sql) = $this->sqlListWhere($type, $id, $state, $order, $limit, $firstId, $filters);

		$stm = $this->bd->prepare($sql);
		$stm->execute($values);

		return $stm->fetchAll(PDO::FETCH_COLUMN, 0);
	}

	public function listHashForFeedGuids($id_feed, $guids) {
		if (count($guids) < 1) {
			return array();
		}
		$guids = array_unique($guids);
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
		$sql = 'SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id WHERE f.priority > 0'
			. ' UNION SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id WHERE f.priority > 0 AND e.is_read=0';
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		rsort($res);
		$all = empty($res[0]) ? 0 : $res[0];
		$unread = empty($res[1]) ? 0 : $res[1];
		return array('all' => $all, 'unread' => $unread, 'read' => $all - $unread);
	}
	public function count($minPriority = null) {
		$sql = 'SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e';
		if ($minPriority !== null) {
			$sql .= ' INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id';
			$sql .= ' WHERE f.priority > ' . intval($minPriority);
		}
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return isset($res[0]) ? $res[0] : 0;
	}
	public function countNotRead($minPriority = null) {
		$sql = 'SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e';
		if ($minPriority !== null) {
			$sql .= ' INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed=f.id';
		}
		$sql .= ' WHERE e.is_read=0';
		if ($minPriority !== null) {
			$sql .= ' AND f.priority > ' . intval($minPriority);
		}
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return $res[0];
	}

	public function countUnreadReadFavorites() {
		$sql = <<<SQL
  SELECT c
    FROM (
         SELECT COUNT(e1.id) AS c
              , 1 AS o
           FROM `{$this->prefix}entry` AS e1
           JOIN `{$this->prefix}feed` AS f1 ON e1.id_feed = f1.id
          WHERE e1.is_favorite = 1
            AND f1.priority >= :priority_normal
         UNION
         SELECT COUNT(e2.id) AS c
              , 2 AS o
           FROM `{$this->prefix}entry` AS e2
           JOIN `{$this->prefix}feed` AS f2 ON e2.id_feed = f2.id
          WHERE e2.is_favorite = 1
            AND e2.is_read = 0
            AND f2.priority >= :priority_normal
         ) u
ORDER BY o
SQL;
		$stm = $this->bd->prepare($sql);
		$stm->execute(array(':priority_normal' => FreshRSS_Feed::PRIORITY_NORMAL));
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		rsort($res);
		$all = empty($res[0]) ? 0 : $res[0];
		$unread = empty($res[1]) ? 0 : $res[1];
		return array('all' => $all, 'unread' => $unread, 'read' => $all - $unread);
	}

	public static function daoToEntry($dao) {
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
				isset($dao['tags']) ? $dao['tags'] : ''
			);
		if (isset($dao['id'])) {
			$entry->_id($dao['id']);
		}
		return $entry;
	}

	private static function daoToEntries($listDAO) {
		$list = array();

		if (!is_array($listDAO)) {
			$listDAO = array($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			$list[] = self::daoToEntry($dao);
		}

		unset($listDAO);

		return $list;
	}
}

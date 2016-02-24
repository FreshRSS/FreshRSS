<?php

class FreshRSS_EntryDAOpgSQL extends FreshRSS_EntryDAO {

	protected function addColumn($name) {
		Minz_Log::debug('FreshRSS_EntryDAO::autoAddColumn: ' . $name);
		$hasTransaction = false;
		try {
			$stm = null;
			if ($name === 'lastSeen') {	//v1.1.1
				if (!$this->bd->inTransaction()) {
					$this->bd->beginTransaction();
					$hasTransaction = true;
				}
				$stm = $this->bd->prepare('ALTER TABLE "' . $this->prefix . 'entry" ADD COLUMN lastseen INT DEFAULT 0');
				if ($stm && $stm->execute()) {
					$stm = $this->bd->prepare('CREATE INDEX entry_lastSeen_index ON "' . $this->prefix . 'entry" (lastseen);');	//IF NOT EXISTSdoes not exist in MySQL 5.7
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
				$stm = $this->bd->prepare('ALTER TABLE "' . $this->prefix . 'entry" ADD COLUMN hash bytea');
				return $stm && $stm->execute();
			}
		} catch (Exception $e) {
			Minz_Log::debug('FreshRSS_EntryDAO::autoAddColumn error: ' . $e->getMessage());
			if ($hasTransaction) {
				$this->bd->rollBack();
			}
		}
		return false;
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
		//do nothing, done via triggers.
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
	public function markReadFeed($id_feed, $idMax = 0) {
		if ($idMax == 0) {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadFeed(0) is deprecated!');
		}
		$this->bd->beginTransaction();

		$sql = 'UPDATE "' . $this->prefix . 'entry" '
			 . 'SET is_read=:is_read '
			 . 'WHERE id_feed=:id_feed AND NOT is_read AND id <= :idmax';
		$values = array($id_feed, $idMax);
		$stm = $this->bd->prepare($sql);
		$stm->bindValue(':is_read', true, PDO::PARAM_BOOL);
		$stm->bindValue(':id_feed', $id_feed);
		$stm->bindValue(':idmax', $idMax);

		if (!($stm && $stm->execute())) {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error markReadFeed: ' . $info[2]);
			$this->bd->rollBack();
			return false;
		}
		$affected = $stm->rowCount();

		$this->bd->commit();
		return $affected;
	}

	public function listHashForFeedGuids($id_feed, $guids) {
		if (count($guids) < 1) {
			return array();
		}
		$sql = 'SELECT guid, hash AS hexHash FROM "' . $this->prefix . 'entry" WHERE id_feed=? AND guid IN (' . str_repeat('?,', count($guids) - 1). '?)';
		$stm = $this->bd->prepare($sql);
		$values = array($id_feed);
		$values = array_merge($values, $guids);
		if ($stm && $stm->execute($values)) {
			$result = array();
			$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rows as $row) {
				$result[$row['guid']] = $row['hexHash'];
			}
			return $result;
		} else {
			$info = $stm == null ? array(0 => '', 1 => '', 2 => 'syntax error') : $stm->errorInfo();
			if ($this->autoAddColumn($info)) {
				return $this->listHashForFeedGuids($id_feed, $guids);
			}
			Minz_Log::error('SQL error listHashForFeedGuids: ' . $info[0] . ': ' . $info[1] . ' ' . $info[2]
				. ' while querying feed ' . $id_feed);
			return false;
		}
	}

	public function optimizeTable() {
		//do nothing
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

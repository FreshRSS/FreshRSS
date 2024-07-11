<?php
declare(strict_types=1);

class FreshRSS_EntryDAO extends Minz_ModelPdo {

	public static function isCompressed(): bool {
		return true;
	}

	public static function hasNativeHex(): bool {
		return true;
	}

	protected static function sqlConcat(string $s1, string $s2): string {
		return 'CONCAT(' . $s1 . ',' . $s2 . ')';	//MySQL
	}

	public static function sqlHexDecode(string $x): string {
		return 'unhex(' . $x . ')';
	}

	public static function sqlHexEncode(string $x): string {
		return 'hex(' . $x . ')';
	}

	public static function sqlIgnoreConflict(string $sql): string {
		return str_replace('INSERT INTO ', 'INSERT IGNORE INTO ', $sql);
	}

	private function updateToMediumBlob(): bool {
		if ($this->pdo->dbType() !== 'mysql') {
			return false;
		}
		Minz_Log::warning('Update MySQL table to use MEDIUMBLOB...');

		$sql = <<<'SQL'
ALTER TABLE `_entry` MODIFY `content_bin` MEDIUMBLOB;
ALTER TABLE `_entrytmp` MODIFY `content_bin` MEDIUMBLOB;
SQL;
		try {
			$ok = $this->pdo->exec($sql) !== false;
		} catch (Exception $e) {
			$ok = false;
			Minz_Log::error(__method__ . ' error: ' . $e->getMessage());
		}
		return $ok;
	}

	protected function addColumn(string $name): bool {
		if ($this->pdo->inTransaction()) {
			$this->pdo->commit();
		}
		Minz_Log::warning(__method__ . ': ' . $name);
		try {
			if ($name === 'attributes') {	//v1.20.0
				$sql = <<<'SQL'
ALTER TABLE `_entry` ADD COLUMN attributes TEXT;
ALTER TABLE `_entrytmp` ADD COLUMN attributes TEXT;
SQL;
				return $this->pdo->exec($sql) !== false;
			}
		} catch (Exception $e) {
			Minz_Log::error(__method__ . ' error: ' . $e->getMessage());
		}
		return false;
	}

	//TODO: Move the database auto-updates to DatabaseDAO
	/** @param array<string|int> $errorInfo */
	protected function autoUpdateDb(array $errorInfo): bool {
		if (isset($errorInfo[0])) {
			if ($errorInfo[0] === FreshRSS_DatabaseDAO::ER_BAD_FIELD_ERROR || $errorInfo[0] === FreshRSS_DatabaseDAOPGSQL::UNDEFINED_COLUMN) {
				$errorLines = explode("\n", (string)$errorInfo[2], 2);	// The relevant column name is on the first line, other lines are noise
				foreach (['attributes'] as $column) {
					if (stripos($errorLines[0], $column) !== false) {
						return $this->addColumn($column);
					}
				}
			}
		}
		if (isset($errorInfo[1])) {
			// May be a string or an int
			if ($errorInfo[1] == FreshRSS_DatabaseDAO::ER_DATA_TOO_LONG) {
				if (stripos((string)$errorInfo[2], 'content_bin') !== false) {
					return $this->updateToMediumBlob();	//v1.15.0
				}
			}
		}
		return false;
	}

	/**
	 * @var PDOStatement|null|false
	 */
	private $addEntryPrepared = false;

	/** @param array{'id':string,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,'lastSeen':int,'hash':string,
	 *		'is_read':bool|int|null,'is_favorite':bool|int|null,'id_feed':int,'tags':string,'attributes'?:null|string|array<string,mixed>} $valuesTmp */
	public function addEntry(array $valuesTmp, bool $useTmpTable = true): bool {
		if ($this->addEntryPrepared == null) {
			$sql = static::sqlIgnoreConflict(
				'INSERT INTO `_' . ($useTmpTable ? 'entrytmp' : 'entry') . '` (id, guid, title, author, '
				. (static::isCompressed() ? 'content_bin' : 'content')
				. ', link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags, attributes) '
				. 'VALUES(:id, :guid, :title, :author, '
				. (static::isCompressed() ? 'COMPRESS(:content)' : ':content')
				. ', :link, :date, :last_seen, '
				. static::sqlHexDecode(':hash')
				. ', :is_read, :is_favorite, :id_feed, :tags, :attributes)');
			$this->addEntryPrepared = $this->pdo->prepare($sql);
		}
		if ($this->addEntryPrepared) {
			$this->addEntryPrepared->bindParam(':id', $valuesTmp['id']);
			$valuesTmp['guid'] = substr($valuesTmp['guid'], 0, 767);
			$valuesTmp['guid'] = safe_ascii($valuesTmp['guid']);
			$this->addEntryPrepared->bindParam(':guid', $valuesTmp['guid']);
			$valuesTmp['title'] = mb_strcut($valuesTmp['title'], 0, 8192, 'UTF-8');
			$valuesTmp['title'] = safe_utf8($valuesTmp['title']);
			$this->addEntryPrepared->bindParam(':title', $valuesTmp['title']);
			$valuesTmp['author'] = mb_strcut($valuesTmp['author'], 0, 1024, 'UTF-8');
			$valuesTmp['author'] = safe_utf8($valuesTmp['author']);
			$this->addEntryPrepared->bindParam(':author', $valuesTmp['author']);
			$valuesTmp['content'] = safe_utf8($valuesTmp['content']);
			$this->addEntryPrepared->bindParam(':content', $valuesTmp['content']);
			$valuesTmp['link'] = substr($valuesTmp['link'], 0, 16383);
			$valuesTmp['link'] = safe_ascii($valuesTmp['link']);
			$this->addEntryPrepared->bindParam(':link', $valuesTmp['link']);
			$this->addEntryPrepared->bindParam(':date', $valuesTmp['date'], PDO::PARAM_INT);
			if (empty($valuesTmp['lastSeen'])) {
				$valuesTmp['lastSeen'] = time();
			}
			$this->addEntryPrepared->bindParam(':last_seen', $valuesTmp['lastSeen'], PDO::PARAM_INT);
			$valuesTmp['is_read'] = $valuesTmp['is_read'] ? 1 : 0;
			$this->addEntryPrepared->bindParam(':is_read', $valuesTmp['is_read'], PDO::PARAM_INT);
			$valuesTmp['is_favorite'] = $valuesTmp['is_favorite'] ? 1 : 0;
			$this->addEntryPrepared->bindParam(':is_favorite', $valuesTmp['is_favorite'], PDO::PARAM_INT);
			$this->addEntryPrepared->bindParam(':id_feed', $valuesTmp['id_feed'], PDO::PARAM_INT);
			$valuesTmp['tags'] = mb_strcut($valuesTmp['tags'], 0, 2048, 'UTF-8');
			$valuesTmp['tags'] = safe_utf8($valuesTmp['tags']);
			$this->addEntryPrepared->bindParam(':tags', $valuesTmp['tags']);
			if (!isset($valuesTmp['attributes'])) {
				$valuesTmp['attributes'] = [];
			}
			$this->addEntryPrepared->bindValue(':attributes', is_string($valuesTmp['attributes']) ? $valuesTmp['attributes'] :
				json_encode($valuesTmp['attributes'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

			if (static::hasNativeHex()) {
				$this->addEntryPrepared->bindParam(':hash', $valuesTmp['hash']);
			} else {
				$valuesTmp['hashBin'] = hex2bin($valuesTmp['hash']);
				$this->addEntryPrepared->bindParam(':hash', $valuesTmp['hashBin']);
			}
		}
		if ($this->addEntryPrepared && $this->addEntryPrepared->execute()) {
			return true;
		} else {
			$info = $this->addEntryPrepared == null ? $this->pdo->errorInfo() : $this->addEntryPrepared->errorInfo();
			if ($this->autoUpdateDb($info)) {
				$this->addEntryPrepared = null;
				return $this->addEntry($valuesTmp);
			} elseif ((int)((int)$info[0] / 1000) !== 23) {	//Filter out "SQLSTATE Class code 23: Constraint Violation" because of expected duplicate entries
				Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info)
					. ' while adding entry in feed ' . $valuesTmp['id_feed'] . ' with title: ' . $valuesTmp['title']);
			}
			return false;
		}
	}

	public function commitNewEntries(): bool {
		$sql = <<<'SQL'
SET @rank=(SELECT MAX(id) - COUNT(*) FROM `_entrytmp`);

INSERT IGNORE INTO `_entry` (
	id, guid, title, author, content_bin, link, date, `lastSeen`,
	hash, is_read, is_favorite, id_feed, tags, attributes
)
SELECT @rank:=@rank+1 AS id, guid, title, author, content_bin, link, date, `lastSeen`, hash, is_read, is_favorite, id_feed, tags, attributes
FROM `_entrytmp`
ORDER BY date, id;

DELETE FROM `_entrytmp` WHERE id <= @rank;
SQL;
		$hadTransaction = $this->pdo->inTransaction();
		if (!$hadTransaction) {
			$this->pdo->beginTransaction();
		}
		$result = $this->pdo->exec($sql) !== false;
		if (!$hadTransaction) {
			$this->pdo->commit();
		}
		return $result;
	}

	private ?PDOStatement $updateEntryPrepared = null;

	/** @param array{'id':string,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,'lastSeen':int,'hash':string,
	 *		'is_read':bool|int|null,'is_favorite':bool|int|null,'id_feed':int,'tags':string,'attributes':array<string,mixed>} $valuesTmp */
	public function updateEntry(array $valuesTmp): bool {
		if (!isset($valuesTmp['is_read'])) {
			$valuesTmp['is_read'] = null;
		}
		if (!isset($valuesTmp['is_favorite'])) {
			$valuesTmp['is_favorite'] = null;
		}

		if ($this->updateEntryPrepared === null) {
			$sql = 'UPDATE `_entry` '
				. 'SET title=:title, author=:author, '
				. (static::isCompressed() ? 'content_bin=COMPRESS(:content)' : 'content=:content')
				. ', link=:link, date=:date, `lastSeen`=:last_seen'
				. ', hash=' . static::sqlHexDecode(':hash')
				. ', is_read=COALESCE(:is_read, is_read)'
				. ', is_favorite=COALESCE(:is_favorite, is_favorite)'
				. ', tags=:tags, attributes=:attributes '
				. 'WHERE id_feed=:id_feed AND guid=:guid';
			$this->updateEntryPrepared = $this->pdo->prepare($sql) ?: null;
		}
		if ($this->updateEntryPrepared) {
			$valuesTmp['guid'] = substr($valuesTmp['guid'], 0, 767);
			$valuesTmp['guid'] = safe_ascii($valuesTmp['guid']);
			$this->updateEntryPrepared->bindParam(':guid', $valuesTmp['guid']);
			$valuesTmp['title'] = mb_strcut($valuesTmp['title'], 0, 8192, 'UTF-8');
			$valuesTmp['title'] = safe_utf8($valuesTmp['title']);
			$this->updateEntryPrepared->bindParam(':title', $valuesTmp['title']);
			$valuesTmp['author'] = mb_strcut($valuesTmp['author'], 0, 1024, 'UTF-8');
			$valuesTmp['author'] = safe_utf8($valuesTmp['author']);
			$this->updateEntryPrepared->bindParam(':author', $valuesTmp['author']);
			$valuesTmp['content'] = safe_utf8($valuesTmp['content']);
			$this->updateEntryPrepared->bindParam(':content', $valuesTmp['content']);
			$valuesTmp['link'] = substr($valuesTmp['link'], 0, 16383);
			$valuesTmp['link'] = safe_ascii($valuesTmp['link']);
			$this->updateEntryPrepared->bindParam(':link', $valuesTmp['link']);
			$this->updateEntryPrepared->bindParam(':date', $valuesTmp['date'], PDO::PARAM_INT);
			$this->updateEntryPrepared->bindParam(':last_seen', $valuesTmp['lastSeen'], PDO::PARAM_INT);
			if ($valuesTmp['is_read'] === null) {
				$this->updateEntryPrepared->bindValue(':is_read', null, PDO::PARAM_NULL);
			} else {
				$this->updateEntryPrepared->bindValue(':is_read', $valuesTmp['is_read'] ? 1 : 0, PDO::PARAM_INT);
			}
			if ($valuesTmp['is_favorite'] === null) {
				$this->updateEntryPrepared->bindValue(':is_favorite', null, PDO::PARAM_NULL);
			} else {
				$this->updateEntryPrepared->bindValue(':is_favorite', $valuesTmp['is_favorite'] ? 1 : 0, PDO::PARAM_INT);
			}
			$this->updateEntryPrepared->bindParam(':id_feed', $valuesTmp['id_feed'], PDO::PARAM_INT);
			$valuesTmp['tags'] = mb_strcut($valuesTmp['tags'], 0, 2048, 'UTF-8');
			$valuesTmp['tags'] = safe_utf8($valuesTmp['tags']);
			$this->updateEntryPrepared->bindParam(':tags', $valuesTmp['tags']);
			if (!isset($valuesTmp['attributes'])) {
				$valuesTmp['attributes'] = [];
			}
			$this->updateEntryPrepared->bindValue(':attributes', is_string($valuesTmp['attributes']) ? $valuesTmp['attributes'] :
				json_encode($valuesTmp['attributes'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

			if (static::hasNativeHex()) {
				$this->updateEntryPrepared->bindParam(':hash', $valuesTmp['hash']);
			} else {
				$valuesTmp['hashBin'] = hex2bin($valuesTmp['hash']);
				$this->updateEntryPrepared->bindParam(':hash', $valuesTmp['hashBin']);
			}
		}

		if ($this->updateEntryPrepared && $this->updateEntryPrepared->execute()) {
			return true;
		} else {
			$info = $this->updateEntryPrepared == null ? $this->pdo->errorInfo() : $this->updateEntryPrepared->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->updateEntry($valuesTmp);
			}
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info)
				. ' while updating entry with GUID ' . $valuesTmp['guid'] . ' in feed ' . $valuesTmp['id_feed']);
			return false;
		}
	}

	/**
	 * Count the number of new entries in the temporary table (which have not yet been committed).
	 */
	public function countNewEntries(): int {
		$sql = <<<'SQL'
		SELECT COUNT(id) AS nb_entries FROM `_entrytmp`
		SQL;
		$res = $this->fetchColumn($sql, 0);
		return isset($res[0]) ? (int)$res[0] : -1;
	}

	/**
	 * Toggle favorite marker on one or more article
	 *
	 * @todo simplify the query by removing the str_repeat. I am pretty sure
	 * there is an other way to do that.
	 *
	 * @param numeric-string|array<numeric-string> $ids
	 * @return int|false
	 */
	public function markFavorite($ids, bool $is_favorite = true) {
		if (!is_array($ids)) {
			$ids = [$ids];
		}
		if (count($ids) < 1) {
			return 0;
		}
		FreshRSS_UserDAO::touch();
		if (count($ids) > FreshRSS_DatabaseDAO::MAX_VARIABLE_NUMBER) {
			// Split a query with too many variables parameters
			$affected = 0;
			$idsChunks = array_chunk($ids, FreshRSS_DatabaseDAO::MAX_VARIABLE_NUMBER);
			foreach ($idsChunks as $idsChunk) {
				$affected += ($this->markFavorite($idsChunk, $is_favorite) ?: 0);
			}
			return $affected;
		}
		$sql = 'UPDATE `_entry` '
			. 'SET is_favorite=? '
			. 'WHERE id IN (' . str_repeat('?,', count($ids) - 1) . '?)';
		$values = [$is_favorite ? 1 : 0];
		$values = array_merge($values, $ids);
		$stm = $this->pdo->prepare($sql);
		if ($stm !== false && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	/**
	 * Update the unread article cache held on every feed details.
	 * Depending on the parameters, it updates the cache on one feed, on all
	 * feeds from one category or on all feeds.
	 */
	protected function updateCacheUnreads(?int $catId = null, ?int $feedId = null): bool {
		// Help MySQL/MariaDB's optimizer with the query plan:
		$useIndex = $this->pdo->dbType() === 'mysql' ? 'USE INDEX (entry_feed_read_index)' : '';

		$sql = <<<SQL
UPDATE `_feed`
SET `cache_nbUnreads`=(
	SELECT COUNT(*) AS nbUnreads FROM `_entry` e {$useIndex}
	WHERE e.id_feed=`_feed`.id AND e.is_read=0)
SQL;
		$hasWhere = false;
		$values = [];
		if ($feedId != null) {
			$sql .= ' WHERE';
			$hasWhere = true;
			$sql .= ' id=?';
			$values[] = $feedId;
		}
		if ($catId != null) {
			$sql .= $hasWhere ? ' AND' : ' WHERE';
			$hasWhere = true;
			$sql .= ' category=?';
			$values[] = $catId;
		}
		$stm = $this->pdo->prepare($sql);
		if ($stm !== false && $stm->execute($values)) {
			return true;
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	/**
	 * Toggle the read marker on one or more article.
	 * Then the cache is updated.
	 *
	 * @param numeric-string|array<numeric-string> $ids
	 * @param bool $is_read
	 * @return int|false affected rows
	 */
	public function markRead($ids, bool $is_read = true) {
		if (is_array($ids)) {	//Many IDs at once
			if (count($ids) < 6) {	//Speed heuristics
				$affected = 0;
				foreach ($ids as $id) {
					$affected += ($this->markRead($id, $is_read) ?: 0);
				}
				return $affected;
			} elseif (count($ids) > FreshRSS_DatabaseDAO::MAX_VARIABLE_NUMBER) {
				// Split a query with too many variables parameters
				$affected = 0;
				$idsChunks = array_chunk($ids, FreshRSS_DatabaseDAO::MAX_VARIABLE_NUMBER);
				foreach ($idsChunks as $idsChunk) {
					$affected += ($this->markRead($idsChunk, $is_read) ?: 0);
				}
				return $affected;
			}

			FreshRSS_UserDAO::touch();
			$sql = 'UPDATE `_entry` '
				 . 'SET is_read=? '
				 . 'WHERE id IN (' . str_repeat('?,', count($ids) - 1) . '?)';
			$values = [$is_read ? 1 : 0];
			$values = array_merge($values, $ids);
			$stm = $this->pdo->prepare($sql);
			if (!($stm && $stm->execute($values))) {
				$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
				Minz_Log::error('SQL error ' . __METHOD__ . ' A ' . json_encode($info));
				return false;
			}
			$affected = $stm->rowCount();
			if (($affected > 0) && (!$this->updateCacheUnreads(null, null))) {
				return false;
			}
			return $affected;
		} else {
			FreshRSS_UserDAO::touch();
			$sql = 'UPDATE `_entry` e INNER JOIN `_feed` f ON e.id_feed=f.id '
				 . 'SET e.is_read=?,'
				 . 'f.`cache_nbUnreads`=f.`cache_nbUnreads`' . ($is_read ? '-' : '+') . '1 '
				 . 'WHERE e.id=? AND e.is_read=?';
			$values = [$is_read ? 1 : 0, $ids, $is_read ? 0 : 1];
			$stm = $this->pdo->prepare($sql);
			if ($stm !== false && $stm->execute($values)) {
				return $stm->rowCount();
			} else {
				$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
				Minz_Log::error('SQL error ' . __METHOD__ . ' B ' . json_encode($info));
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
	 * @param numeric-string $idMax fail safe article ID
	 * @return int|false affected rows
	 */
	public function markReadEntries(string $idMax = '0', bool $onlyFavorites = false, ?int $priorityMin = null, ?int $prioritMax = null,
		?FreshRSS_BooleanSearch $filters = null, int $state = 0, bool $is_read = true) {
		FreshRSS_UserDAO::touch();
		if ($idMax == '0') {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadEntries(0) is deprecated!');
		}

		$sql = 'UPDATE `_entry` SET is_read = ? WHERE is_read <> ? AND id <= ?';
		$values = [$is_read ? 1 : 0, $is_read ? 1 : 0, $idMax];
		if ($onlyFavorites) {
			$sql .= ' AND is_favorite=1';
		}
		if ($priorityMin !== null || $prioritMax !== null) {
			$sql .= ' AND id_feed IN (SELECT f.id FROM `_feed` f WHERE 1=1';
			if ($priorityMin !== null) {
				$sql .= ' AND f.priority >= ?';
				$values[] = $priorityMin;
			}
			if ($prioritMax !== null) {
				$sql .= ' AND f.priority < ?';
				$values[] = $prioritMax;
			}
			$sql .= ')';
		}

		[$searchValues, $search] = $this->sqlListEntriesWhere('', $filters, $state);

		$stm = $this->pdo->prepare($sql . $search);
		if (!($stm && $stm->execute(array_merge($values, $searchValues)))) {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
		$affected = $stm->rowCount();
		if (($affected > 0) && (!$this->updateCacheUnreads(null, null))) {
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
	 * @param int $id category ID
	 * @param numeric-string $idMax fail safe article ID
	 * @return int|false affected rows
	 */
	public function markReadCat(int $id, string $idMax = '0', ?FreshRSS_BooleanSearch $filters = null, int $state = 0, bool $is_read = true) {
		FreshRSS_UserDAO::touch();
		if ($idMax == '0') {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadCat(0) is deprecated!');
		}

		$sql = <<<'SQL'
UPDATE `_entry`
SET is_read = ?
WHERE is_read <> ? AND id <= ?
AND id_feed IN (SELECT f.id FROM `_feed` f WHERE f.category=?)
SQL;
		$values = [$is_read ? 1 : 0, $is_read ? 1 : 0, $idMax, $id];

		[$searchValues, $search] = $this->sqlListEntriesWhere('', $filters, $state);

		$stm = $this->pdo->prepare($sql . $search);
		if (!($stm && $stm->execute(array_merge($values, $searchValues)))) {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
		$affected = $stm->rowCount();
		if (($affected > 0) && (!$this->updateCacheUnreads($id, null))) {
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
	 * @param int $id_feed feed ID
	 * @param numeric-string $idMax fail safe article ID
	 * @return int|false affected rows
	 */
	public function markReadFeed(int $id_feed, string $idMax = '0', ?FreshRSS_BooleanSearch $filters = null, int $state = 0, bool $is_read = true) {
		FreshRSS_UserDAO::touch();
		if ($idMax == '0') {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadFeed(0) is deprecated!');
		}
		$hadTransaction = $this->pdo->inTransaction();
		if (!$hadTransaction) {
			$this->pdo->beginTransaction();
		}

		$sql = 'UPDATE `_entry` '
			 . 'SET is_read=? '
			 . 'WHERE id_feed=? AND is_read <> ? AND id <= ?';
		$values = [$is_read ? 1 : 0, $id_feed, $is_read ? 1 : 0, $idMax];

		[$searchValues, $search] = $this->sqlListEntriesWhere('', $filters, $state);

		$stm = $this->pdo->prepare($sql . $search);
		if (!($stm && $stm->execute(array_merge($values, $searchValues)))) {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info) . ' with SQL: ' . $sql . $search);
			$this->pdo->rollBack();
			return false;
		}
		$affected = $stm->rowCount();

		if ($affected > 0) {
			$sql = 'UPDATE `_feed` '
				 . 'SET `cache_nbUnreads`=`cache_nbUnreads`-' . $affected
				 . ' WHERE id=:id';
			$stm = $this->pdo->prepare($sql);
			if (!($stm !== false &&
				$stm->bindParam(':id', $id_feed, PDO::PARAM_INT) &&
				$stm->execute())) {
				$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
				Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
				$this->pdo->rollBack();
				return false;
			}
		}

		if (!$hadTransaction) {
			$this->pdo->commit();
		}
		return $affected;
	}

	/**
	 * Mark all the articles in a tag as read.
	 * @param int $id tag ID, or empty for targeting any tag
	 * @param numeric-string $idMax max article ID
	 * @return int|false affected rows
	 */
	public function markReadTag(int $id = 0, string $idMax = '0', ?FreshRSS_BooleanSearch $filters = null,
		int $state = 0, bool $is_read = true) {
		FreshRSS_UserDAO::touch();
		if ($idMax == '0') {
			$idMax = time() . '000000';
			Minz_Log::debug('Calling markReadTag(0) is deprecated!');
		}

		$sql = 'UPDATE `_entry` e INNER JOIN `_entrytag` et ON et.id_entry = e.id '
			 . 'SET e.is_read = ? '
			 . 'WHERE '
			 . ($id == 0 ? '' : 'et.id_tag = ? AND ')
			 . 'e.is_read <> ? AND e.id <= ?';
		$values = [$is_read ? 1 : 0];
		if ($id != 0) {
			$values[] = $id;
		}
		$values[] = $is_read ? 1 : 0;
		$values[] = $idMax;

		[$searchValues, $search] = $this->sqlListEntriesWhere('e.', $filters, $state);

		$stm = $this->pdo->prepare($sql . $search);
		if (!($stm && $stm->execute(array_merge($values, $searchValues)))) {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
		$affected = $stm->rowCount();
		if (($affected > 0) && (!$this->updateCacheUnreads(null, null))) {
			return false;
		}
		return $affected;
	}

	/**
	 * Remember to call updateCachedValues($id_feed) or updateCachedValues() just after.
	 * @param array<string,bool|int|string> $options
	 * @return int|false
	 */
	public function cleanOldEntries(int $id_feed, array $options = []) {
		$sql = 'DELETE FROM `_entry` WHERE id_feed = :id_feed1';	//No alias for MySQL / MariaDB
		$params = [];
		$params[':id_feed1'] = $id_feed;

		//==Exclusions==
		if (!empty($options['keep_favourites'])) {
			$sql .= ' AND is_favorite = 0';
		}
		if (!empty($options['keep_unreads'])) {
			$sql .= ' AND is_read = 1';
		}
		if (!empty($options['keep_labels'])) {
			$sql .= ' AND NOT EXISTS (SELECT 1 FROM `_entrytag` WHERE id_entry = id)';
		}
		if (!empty($options['keep_min']) && $options['keep_min'] > 0) {
			//Double SELECT for MySQL workaround ERROR 1093 (HY000)
			$sql .= ' AND `lastSeen` < (SELECT `lastSeen`'
				. ' FROM (SELECT e2.`lastSeen` FROM `_entry` e2 WHERE e2.id_feed = :id_feed2'
				. ' ORDER BY e2.`lastSeen` DESC LIMIT 1 OFFSET :keep_min) last_seen2)';
			$params[':id_feed2'] = $id_feed;
			$params[':keep_min'] = (int)$options['keep_min'];
		}
		//Keep at least the articles seen at the last refresh
		$sql .= ' AND `lastSeen` < (SELECT maxlastseen'
			. ' FROM (SELECT MAX(e3.`lastSeen`) AS maxlastseen FROM `_entry` e3 WHERE e3.id_feed = :id_feed3) last_seen3)';
		$params[':id_feed3'] = $id_feed;

		//==Inclusions==
		$sql .= ' AND (1=0';
		if (!empty($options['keep_period']) && is_string($options['keep_period'])) {
			$sql .= ' OR `lastSeen` < :max_last_seen';
			$now = new DateTime('now');
			$now->sub(new DateInterval($options['keep_period']));
			$params[':max_last_seen'] = $now->format('U');
		}
		if (!empty($options['keep_max']) && $options['keep_max'] > 0) {
			$sql .= ' OR `lastSeen` <= (SELECT `lastSeen`'
				. ' FROM (SELECT e4.`lastSeen` FROM `_entry` e4 WHERE e4.id_feed = :id_feed4'
				. ' ORDER BY e4.`lastSeen` DESC LIMIT 1 OFFSET :keep_max) last_seen4)';
			$params[':id_feed4'] = $id_feed;
			$params[':keep_max'] = (int)$options['keep_max'];
		}
		$sql .= ')';

		$stm = $this->pdo->prepare($sql);

		if ($stm !== false && $stm->execute($params)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->cleanOldEntries($id_feed, $options);
			}
			Minz_Log::error(__method__ . ' error:' . json_encode($info));
			return false;
		}
	}

	/** @return Traversable<array{'id':string,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,'lastSeen':int,
	 *		'hash':string,'is_read':bool,'is_favorite':bool,'id_feed':int,'tags':string,'attributes':?string}> */
	public function selectAll(?int $limit = null): Traversable {
		$content = static::isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content';
		$hash = static::sqlHexEncode('hash');
		$sql = <<<SQL
SELECT id, guid, title, author, {$content}, link, date, `lastSeen`, {$hash} AS hash, is_read, is_favorite, id_feed, tags, attributes
FROM `_entry`
SQL;
		if (is_int($limit) && $limit >= 0) {
			$sql .= ' ORDER BY id DESC LIMIT ' . $limit;
		}
		$stm = $this->pdo->query($sql);
		if ($stm != false) {
			while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
				/** @var array{'id':string,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,'lastSeen':int,
				 *	'hash':string,'is_read':bool,'is_favorite':bool,'id_feed':int,'tags':string,'attributes':?string} $row */
				yield $row;
			}
		} else {
			$info = $this->pdo->errorInfo();
			if ($this->autoUpdateDb($info)) {
				yield from $this->selectAll();
			} else {
				Minz_Log::error(__method__ . ' error: ' . json_encode($info));
			}
		}
	}

	public function searchByGuid(int $id_feed, string $guid): ?FreshRSS_Entry {
		$content = static::isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content';
		$hash = static::sqlHexEncode('hash');
		$sql = <<<SQL
SELECT id, guid, title, author, link, date, is_read, is_favorite, {$hash} AS hash, id_feed, tags, attributes, {$content}
FROM `_entry` WHERE id_feed=:id_feed AND guid=:guid
SQL;
		$res = $this->fetchAssoc($sql, [':id_feed' => $id_feed, ':guid' => $guid]);
		/** @var array<array{'id':string,'id_feed':int,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,
		 *		'is_read':int,'is_favorite':int,'tags':string,'attributes':?string}> $res */
		return isset($res[0]) ? FreshRSS_Entry::fromArray($res[0]) : null;
	}

	public function searchById(string $id): ?FreshRSS_Entry {
		$content = static::isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content';
		$hash = static::sqlHexEncode('hash');
		$sql = <<<SQL
SELECT id, guid, title, author, link, date, is_read, is_favorite, {$hash} AS hash, id_feed, tags, attributes, {$content}
FROM `_entry` WHERE id=:id
SQL;
		$res = $this->fetchAssoc($sql, [':id' => $id]);
		/** @var array<array{'id':string,'id_feed':int,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,
		 *		'is_read':int,'is_favorite':int,'tags':string,'attributes':?string}> $res */
		return isset($res[0]) ? FreshRSS_Entry::fromArray($res[0]) : null;
	}

	public function searchIdByGuid(int $id_feed, string $guid): ?string {
		$sql = 'SELECT id FROM `_entry` WHERE id_feed=:id_feed AND guid=:guid';
		$res = $this->fetchColumn($sql, 0, [':id_feed' => $id_feed, ':guid' => $guid]);
		return empty($res[0]) ? null : (string)($res[0]);
	}

	/** @return array{0:array<int|string>,1:string} */
	public static function sqlBooleanSearch(string $alias, FreshRSS_BooleanSearch $filters, int $level = 0): array {
		$search = '';
		$values = [];

		$isOpen = false;
		foreach ($filters->searches() as $filter) {
			if ($filter == null) {
				continue;
			}
			if ($filter instanceof FreshRSS_BooleanSearch) {
				// BooleanSearches are combined by AND (default) or OR (special case) operator and are recursive
				[$filterValues, $filterSearch] = self::sqlBooleanSearch($alias, $filter, $level + 1);
				$filterSearch = trim($filterSearch);

				if ($filterSearch !== '') {
					if ($search !== '') {
						$search .= $filter->operator();
					} elseif (in_array($filter->operator(), ['AND NOT', 'OR NOT'], true)) {
						// Special case if we start with a negation (there is already the default AND before)
						$search .= ' NOT';
					}
					$search .= ' (' . $filterSearch . ') ';
					$values = array_merge($values, $filterValues);
				}
				continue;
			}
			// Searches are combined by OR and are not recursive
			$sub_search = '';
			if ($filter->getEntryIds() !== null) {
				$sub_search .= 'AND ' . $alias . 'id IN (';
				foreach ($filter->getEntryIds() as $entry_id) {
					$sub_search .= '?,';
					$values[] = $entry_id;
				}
				$sub_search = rtrim($sub_search, ',');
				$sub_search .= ') ';
			}
			if ($filter->getNotEntryIds() !== null) {
				$sub_search .= 'AND ' . $alias . 'id NOT IN (';
				foreach ($filter->getNotEntryIds() as $entry_id) {
					$sub_search .= '?,';
					$values[] = $entry_id;
				}
				$sub_search = rtrim($sub_search, ',');
				$sub_search .= ') ';
			}

			if ($filter->getMinDate() !== null) {
				$sub_search .= 'AND ' . $alias . 'id >= ? ';
				$values[] = "{$filter->getMinDate()}000000";
			}
			if ($filter->getMaxDate() !== null) {
				$sub_search .= 'AND ' . $alias . 'id <= ? ';
				$values[] = "{$filter->getMaxDate()}000000";
			}
			if ($filter->getMinPubdate() !== null) {
				$sub_search .= 'AND ' . $alias . 'date >= ? ';
				$values[] = $filter->getMinPubdate();
			}
			if ($filter->getMaxPubdate() !== null) {
				$sub_search .= 'AND ' . $alias . 'date <= ? ';
				$values[] = $filter->getMaxPubdate();
			}

			//Negation of date intervals must be combined by OR
			if ($filter->getNotMinDate() !== null || $filter->getNotMaxDate() !== null) {
				$sub_search .= 'AND (';
				if ($filter->getNotMinDate() !== null) {
					$sub_search .= $alias . 'id < ?';
					$values[] = "{$filter->getNotMinDate()}000000";
					if ($filter->getNotMaxDate()) {
						$sub_search .= ' OR ';
					}
				}
				if ($filter->getNotMaxDate() !== null) {
					$sub_search .= $alias . 'id > ?';
					$values[] = "{$filter->getNotMaxDate()}000000";
				}
				$sub_search .= ') ';
			}
			if ($filter->getNotMinPubdate() !== null || $filter->getNotMaxPubdate() !== null) {
				$sub_search .= 'AND (';
				if ($filter->getNotMinPubdate() !== null) {
					$sub_search .= $alias . 'date < ?';
					$values[] = $filter->getNotMinPubdate();
					if ($filter->getNotMaxPubdate()) {
						$sub_search .= ' OR ';
					}
				}
				if ($filter->getNotMaxPubdate() !== null) {
					$sub_search .= $alias . 'date > ?';
					$values[] = $filter->getNotMaxPubdate();
				}
				$sub_search .= ') ';
			}

			if ($filter->getFeedIds() !== null) {
				$sub_search .= 'AND ' . $alias . 'id_feed IN (';
				foreach ($filter->getFeedIds() as $feed_id) {
					$sub_search .= '?,';
					$values[] = $feed_id;
				}
				$sub_search = rtrim($sub_search, ',');
				$sub_search .= ') ';
			}
			if ($filter->getNotFeedIds() !== null) {
				$sub_search .= 'AND ' . $alias . 'id_feed NOT IN (';
				foreach ($filter->getNotFeedIds() as $feed_id) {
					$sub_search .= '?,';
					$values[] = $feed_id;
				}
				$sub_search = rtrim($sub_search, ',');
				$sub_search .= ') ';
			}

			if ($filter->getLabelIds() !== null) {
				if ($filter->getLabelIds() === '*') {
					$sub_search .= 'AND EXISTS (SELECT et.id_tag FROM `_entrytag` et WHERE et.id_entry = ' . $alias . 'id) ';
				} else {
					$sub_search .= 'AND ' . $alias . 'id IN (SELECT et.id_entry FROM `_entrytag` et WHERE et.id_tag IN (';
					foreach ($filter->getLabelIds() as $label_id) {
						$sub_search .= '?,';
						$values[] = $label_id;
					}
					$sub_search = rtrim($sub_search, ',');
					$sub_search .= ')) ';
				}
			}
			if ($filter->getNotLabelIds() !== null) {
				if ($filter->getNotLabelIds() === '*') {
					$sub_search .= 'AND NOT EXISTS (SELECT et.id_tag FROM `_entrytag` et WHERE et.id_entry = ' . $alias . 'id) ';
				} else {
					$sub_search .= 'AND ' . $alias . 'id NOT IN (SELECT et.id_entry FROM `_entrytag` et WHERE et.id_tag IN (';
					foreach ($filter->getNotLabelIds() as $label_id) {
						$sub_search .= '?,';
						$values[] = $label_id;
					}
					$sub_search = rtrim($sub_search, ',');
					$sub_search .= ')) ';
				}
			}

			if ($filter->getLabelNames() !== null) {
				$sub_search .= 'AND ' . $alias . 'id IN (SELECT et.id_entry FROM `_entrytag` et, `_tag` t WHERE et.id_tag = t.id AND t.name IN (';
				foreach ($filter->getLabelNames() as $label_name) {
					$sub_search .= '?,';
					$values[] = $label_name;
				}
				$sub_search = rtrim($sub_search, ',');
				$sub_search .= ')) ';
			}
			if ($filter->getNotLabelNames() !== null) {
				$sub_search .= 'AND ' . $alias . 'id NOT IN (SELECT et.id_entry FROM `_entrytag` et, `_tag` t WHERE et.id_tag = t.id AND t.name IN (';
				foreach ($filter->getNotLabelNames() as $label_name) {
					$sub_search .= '?,';
					$values[] = $label_name;
				}
				$sub_search = rtrim($sub_search, ',');
				$sub_search .= ')) ';
			}

			if ($filter->getAuthor() !== null) {
				foreach ($filter->getAuthor() as $author) {
					$sub_search .= 'AND ' . $alias . 'author LIKE ? ';
					$values[] = "%{$author}%";
				}
			}
			if ($filter->getIntitle() !== null) {
				foreach ($filter->getIntitle() as $title) {
					$sub_search .= 'AND ' . $alias . 'title LIKE ? ';
					$values[] = "%{$title}%";
				}
			}
			if ($filter->getTags() !== null) {
				foreach ($filter->getTags() as $tag) {
					$sub_search .= 'AND ' . static::sqlConcat('TRIM(' . $alias . 'tags) ', " ' #'") . ' LIKE ? ';
					$values[] = "%{$tag} #%";
				}
			}
			if ($filter->getInurl() !== null) {
				foreach ($filter->getInurl() as $url) {
					$sub_search .= 'AND ' . $alias . 'link LIKE ? ';
					$values[] = "%{$url}%";
				}
			}

			if ($filter->getNotAuthor() !== null) {
				foreach ($filter->getNotAuthor() as $author) {
					$sub_search .= 'AND ' . $alias . 'author NOT LIKE ? ';
					$values[] = "%{$author}%";
				}
			}
			if ($filter->getNotIntitle() !== null) {
				foreach ($filter->getNotIntitle() as $title) {
					$sub_search .= 'AND ' . $alias . 'title NOT LIKE ? ';
					$values[] = "%{$title}%";
				}
			}
			if ($filter->getNotTags() !== null) {
				foreach ($filter->getNotTags() as $tag) {
					$sub_search .= 'AND ' . static::sqlConcat('TRIM(' . $alias . 'tags) ', " ' #'") . ' NOT LIKE ? ';
					$values[] = "%{$tag} #%";
				}
			}
			if ($filter->getNotInurl() !== null) {
				foreach ($filter->getNotInurl() as $url) {
					$sub_search .= 'AND ' . $alias . 'link NOT LIKE ? ';
					$values[] = "%{$url}%";
				}
			}

			if ($filter->getSearch() !== null) {
				foreach ($filter->getSearch() as $search_value) {
					if (static::isCompressed()) {	// MySQL-only
						$sub_search .= 'AND CONCAT(' . $alias . 'title, UNCOMPRESS(' . $alias . 'content_bin)) LIKE ? ';
						$values[] = "%{$search_value}%";
					} else {
						$sub_search .= 'AND (' . $alias . 'title LIKE ? OR ' . $alias . 'content LIKE ?) ';
						$values[] = "%{$search_value}%";
						$values[] = "%{$search_value}%";
					}
				}
			}
			if ($filter->getNotSearch() !== null) {
				foreach ($filter->getNotSearch() as $search_value) {
					if (static::isCompressed()) {	// MySQL-only
						$sub_search .= 'AND CONCAT(' . $alias . 'title, UNCOMPRESS(' . $alias . 'content_bin)) NOT LIKE ? ';
						$values[] = "%{$search_value}%";
					} else {
						$sub_search .= 'AND ' . $alias . 'title NOT LIKE ? AND ' . $alias . 'content NOT LIKE ? ';
						$values[] = "%{$search_value}%";
						$values[] = "%{$search_value}%";
					}
				}
			}

			if ($sub_search != '') {
				if ($isOpen) {
					$search .= ' OR ';
				} else {
					$isOpen = true;
				}
				// Remove superfluous leading 'AND '
				$search .= '(' . substr($sub_search, 4) . ')';
			}
		}

		return [ $values, $search ];
	}

	/**
	 * @param 'ASC'|'DESC' $order
	 * @return array{0:array<int|string>,1:string}
	 * @throws FreshRSS_EntriesGetter_Exception
	 */
	protected function sqlListEntriesWhere(string $alias = '', ?FreshRSS_BooleanSearch $filters = null,
			int $state = FreshRSS_Entry::STATE_ALL,
			string $order = 'DESC', string $firstId = '', int $date_min = 0): array {
		$search = ' ';
		$values = [];
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
			[$filterValues, $filterSearch] = self::sqlBooleanSearch($alias, $filters);
			$filterSearch = trim($filterSearch);
			if ($filterSearch !== '') {
				$search .= 'AND (' . $filterSearch . ') ';
				$values = array_merge($values, $filterValues);
			}
		}
		return [$values, $search];
	}

	/**
	 * @phpstan-param 'a'|'A'|'i'|'s'|'S'|'c'|'f'|'t'|'T'|'ST' $type
	 * @param int $id category/feed/tag ID
	 * @param 'ASC'|'DESC' $order
	 * @return array{0:array<int|string>,1:string}
	 * @throws FreshRSS_EntriesGetter_Exception
	 */
	private function sqlListWhere(string $type = 'a', int $id = 0, int $state = FreshRSS_Entry::STATE_ALL,
			string $order = 'DESC', int $limit = 1, int $offset = 0, string $firstId = '', ?FreshRSS_BooleanSearch $filters = null,
			int $date_min = 0): array {
		if (!$state) {
			$state = FreshRSS_Entry::STATE_ALL;
		}
		$where = '';
		$values = [];
		switch ($type) {
			case 'a':	//All PRIORITY_MAIN_STREAM
				$where .= 'f.priority >= ' . FreshRSS_Feed::PRIORITY_MAIN_STREAM . ' ';
				break;
			case 'A':	//All except PRIORITY_ARCHIVED
				$where .= 'f.priority > ' . FreshRSS_Feed::PRIORITY_ARCHIVED . ' ';
				break;
			case 'i':	//Priority important feeds
				$where .= 'f.priority >= ' . FreshRSS_Feed::PRIORITY_IMPORTANT . ' ';
				break;
			case 's':	//Starred. Deprecated: use $state instead
				$where .= 'f.priority > ' . FreshRSS_Feed::PRIORITY_ARCHIVED . ' ';
				$where .= 'AND e.is_favorite=1 ';
				break;
			case 'S':	//Starred
				$where .= 'e.is_favorite=1 ';
				break;
			case 'c':	//Category
				$where .= 'f.priority >= ' . FreshRSS_Feed::PRIORITY_CATEGORY . ' ';
				$where .= 'AND f.category=? ';
				$values[] = $id;
				break;
			case 'f':	//Feed
				$where .= 'e.id_feed=? ';
				$values[] = $id;
				break;
			case 't':	//Tag (label)
				$where .= 'et.id_tag=? ';
				$values[] = $id;
				break;
			case 'T':	//Any tag (label)
				$where .= '1=1 ';
				break;
			case 'ST':	//Starred or tagged (label)
				$where .= 'e.is_favorite=1 OR EXISTS (SELECT et2.id_tag FROM `_entrytag` et2 WHERE et2.id_entry = e.id) ';
				break;
			default:
				throw new FreshRSS_EntriesGetter_Exception('Bad type in Entry->listByType: [' . $type . ']!');
		}

		[$searchValues, $search] = $this->sqlListEntriesWhere('e.', $filters, $state, $order, $firstId, $date_min);

		return [array_merge($values, $searchValues), 'SELECT '
			. ($type === 'T' ? 'DISTINCT ' : '')
			. 'e.id FROM `_entry` e '
			. 'INNER JOIN `_feed` f ON e.id_feed = f.id '
			. ($type === 't' || $type === 'T' ? 'INNER JOIN `_entrytag` et ON et.id_entry = e.id ' : '')
			. 'WHERE ' . $where
			. $search
			. 'ORDER BY e.id ' . $order
			. ($limit > 0 ? ' LIMIT ' . $limit : '')	// http://explainextended.com/2009/10/23/mysql-order-by-limit-performance-late-row-lookups/
			. ($offset > 0 ? ' OFFSET ' . $offset : '')
		];
	}

	/**
	 * @phpstan-param 'a'|'A'|'s'|'S'|'i'|'c'|'f'|'t'|'T'|'ST' $type
	 * @param 'ASC'|'DESC' $order
	 * @param int $id category/feed/tag ID
	 * @return PDOStatement|false
	 * @throws FreshRSS_EntriesGetter_Exception
	 */
	private function listWhereRaw(string $type = 'a', int $id = 0, int $state = FreshRSS_Entry::STATE_ALL,
			string $order = 'DESC', int $limit = 1, int $offset = 0, string $firstId = '', ?FreshRSS_BooleanSearch $filters = null,
			int $date_min = 0) {
		[$values, $sql] = $this->sqlListWhere($type, $id, $state, $order, $limit, $offset, $firstId, $filters, $date_min);

		if ($order !== 'DESC' && $order !== 'ASC') {
			$order = 'DESC';
		}
		$content = static::isCompressed() ? 'UNCOMPRESS(e0.content_bin) AS content' : 'e0.content';
		$hash = static::sqlHexEncode('e0.hash');
		$sql = <<<SQL
SELECT e0.id, e0.guid, e0.title, e0.author, {$content}, e0.link, e0.date, {$hash} AS hash, e0.is_read, e0.is_favorite, e0.id_feed, e0.tags, e0.attributes
FROM `_entry` e0
INNER JOIN ({$sql}) e2 ON e2.id=e0.id
ORDER BY e0.id {$order}
SQL;
		$stm = $this->pdo->prepare($sql);
		if ($stm !== false && $stm->execute($values)) {
			return $stm;
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->listWhereRaw($type, $id, $state, $order, $limit, $offset, $firstId, $filters, $date_min);
			}
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	/**
	 * @phpstan-param 'a'|'A'|'s'|'S'|'i'|'c'|'f'|'t'|'T'|'ST' $type
	 * @param int $id category/feed/tag ID
	 * @param 'ASC'|'DESC' $order
	 * @return Traversable<FreshRSS_Entry>
	 * @throws FreshRSS_EntriesGetter_Exception
	 */
	public function listWhere(string $type = 'a', int $id = 0, int $state = FreshRSS_Entry::STATE_ALL,
			string $order = 'DESC', int $limit = 1, int $offset = 0, string $firstId = '',
			?FreshRSS_BooleanSearch $filters = null, int $date_min = 0): Traversable {
		$stm = $this->listWhereRaw($type, $id, $state, $order, $limit, $offset, $firstId, $filters, $date_min);
		if ($stm) {
			while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
				if (is_array($row)) {
					/** @var array{'id':string,'id_feed':int,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,
					 *		'hash':string,'is_read':int,'is_favorite':int,'tags':string,'attributes'?:?string} $row */
					yield FreshRSS_Entry::fromArray($row);
				}
			}
		}
	}

	/**
	 * @param array<numeric-string> $ids
	 * @param 'ASC'|'DESC' $order
	 * @return Traversable<FreshRSS_Entry>
	 */
	public function listByIds(array $ids, string $order = 'DESC'): Traversable {
		if (count($ids) < 1) {
			return;
		}
		if (count($ids) > FreshRSS_DatabaseDAO::MAX_VARIABLE_NUMBER) {
			// Split a query with too many variables parameters
			$idsChunks = array_chunk($ids, FreshRSS_DatabaseDAO::MAX_VARIABLE_NUMBER);
			foreach ($idsChunks as $idsChunk) {
				foreach ($this->listByIds($idsChunk, $order) as $entry) {
					yield $entry;
				}
			}
			return;
		}
		if ($order !== 'DESC' && $order !== 'ASC') {
			$order = 'DESC';
		}
		$content = static::isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content';
		$hash = static::sqlHexEncode('hash');
		$repeats = str_repeat('?,', count($ids) - 1) . '?';
		$sql = <<<SQL
SELECT id, guid, title, author, link, date, {$hash} AS hash, is_read, is_favorite, id_feed, tags, attributes, {$content}
FROM `_entry`
WHERE id IN ({$repeats})
ORDER BY id {$order}
SQL;
		$stm = $this->pdo->prepare($sql);
		if ($stm === false || !$stm->execute($ids)) {
			return;
		}
		while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			if (is_array($row)) {
				/** @var array{'id':string,'id_feed':int,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,
				 *		'hash':string,'is_read':int,'is_favorite':int,'tags':string,'attributes':?string} $row */
				yield FreshRSS_Entry::fromArray($row);
			}
		}
	}

	/**
	 * @phpstan-param 'a'|'A'|'s'|'S'|'c'|'f'|'t'|'T'|'ST' $type
	 * @param int $id category/feed/tag ID
	 * @param 'ASC'|'DESC' $order
	 * @return array<numeric-string>|null
	 * @throws FreshRSS_EntriesGetter_Exception
	 */
	public function listIdsWhere(string $type = 'a', int $id = 0, int $state = FreshRSS_Entry::STATE_ALL,
		string $order = 'DESC', int $limit = 1, int $offset = 0, string $firstId = '', ?FreshRSS_BooleanSearch $filters = null): ?array {

		[$values, $sql] = $this->sqlListWhere($type, $id, $state, $order, $limit, $offset, $firstId, $filters);
		$stm = $this->pdo->prepare($sql);
		if ($stm !== false && $stm->execute($values) && ($res = $stm->fetchAll(PDO::FETCH_COLUMN, 0)) !== false) {
			/** @var array<numeric-string> $res */
			return $res;
		}
		$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
		Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
		return null;
	}

	/**
	 * @param array<string> $guids
	 * @return array<string>|false
	 */
	public function listHashForFeedGuids(int $id_feed, array $guids) {
		$result = [];
		if (count($guids) < 1) {
			return $result;
		} elseif (count($guids) > FreshRSS_DatabaseDAO::MAX_VARIABLE_NUMBER) {
			// Split a query with too many variables parameters
			$guidsChunks = array_chunk($guids, FreshRSS_DatabaseDAO::MAX_VARIABLE_NUMBER);
			foreach ($guidsChunks as $guidsChunk) {
				$result += $this->listHashForFeedGuids($id_feed, $guidsChunk);
			}
			return $result;
		}
		$guids = array_unique($guids);
		$sql = 'SELECT guid, ' . static::sqlHexEncode('hash') .
			' AS hex_hash FROM `_entry` WHERE id_feed=? AND guid IN (' . str_repeat('?,', count($guids) - 1) . '?)';
		$stm = $this->pdo->prepare($sql);
		$values = [$id_feed];
		$values = array_merge($values, $guids);
		if ($stm !== false && $stm->execute($values)) {
			$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rows as $row) {
				$result[$row['guid']] = $row['hex_hash'];
			}
			return $result;
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->listHashForFeedGuids($id_feed, $guids);
			}
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info)
				. ' while querying feed ' . $id_feed);
			return false;
		}
	}

	/**
	 * @param array<string> $guids
	 * @return int|false The number of affected entries, or false if error
	 */
	public function updateLastSeen(int $id_feed, array $guids, int $mtime = 0) {
		if (count($guids) < 1) {
			return 0;
		} elseif (count($guids) > FreshRSS_DatabaseDAO::MAX_VARIABLE_NUMBER) {
			// Split a query with too many variables parameters
			$affected = 0;
			$guidsChunks = array_chunk($guids, FreshRSS_DatabaseDAO::MAX_VARIABLE_NUMBER);
			foreach ($guidsChunks as $guidsChunk) {
				$affected += ($this->updateLastSeen($id_feed, $guidsChunk, $mtime) ?: 0);
			}
			return $affected;
		}
		$sql = 'UPDATE `_entry` SET `lastSeen`=? WHERE id_feed=? AND guid IN (' . str_repeat('?,', count($guids) - 1) . '?)';
		$stm = $this->pdo->prepare($sql);
		if ($mtime <= 0) {
			$mtime = time();
		}
		$values = [$mtime, $id_feed];
		$values = array_merge($values, $guids);
		if ($stm !== false && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->updateLastSeen($id_feed, $guids);
			}
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info)
				. ' while updating feed ' . $id_feed);
			return false;
		}
	}

	/**
	 * Update (touch) the last seen attribute of the latest entries of a given feed.
	 * Useful when a feed is unchanged / cached.
	 * To be performed just before {@see FreshRSS_FeedDAO::updateLastUpdate()}
	 * @return int|false The number of affected entries, or false in case of error
	 */
	public function updateLastSeenUnchanged(int $id_feed, int $mtime = 0) {
		$sql = <<<'SQL'
UPDATE `_entry` SET `lastSeen` = :mtime
WHERE id_feed = :id_feed1 AND `lastSeen` = (
	SELECT `lastUpdate` FROM `_feed` f
	WHERE f.id = :id_feed2
)
SQL;
		$stm = $this->pdo->prepare($sql);
		if ($mtime <= 0) {
			$mtime = time();
		}
		if ($stm !== false &&
			$stm->bindValue(':mtime', $mtime, PDO::PARAM_INT) &&
			$stm->bindValue(':id_feed1', $id_feed, PDO::PARAM_INT) &&
			$stm->bindValue(':id_feed2', $id_feed, PDO::PARAM_INT) &&
			$stm->execute()) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info) . ' while updating feed ' . $id_feed);
			return false;
		}
	}

	/** @return array<string,int> */
	public function countUnreadRead(): array {
		$sql = <<<'SQL'
SELECT COUNT(e.id) AS count FROM `_entry` e
	INNER JOIN `_feed` f ON e.id_feed=f.id
	WHERE f.priority > 0
UNION
SELECT COUNT(e.id) AS count FROM `_entry` e
	INNER JOIN `_feed` f ON e.id_feed=f.id
	WHERE f.priority > 0 AND e.is_read=0
SQL;
		$res = $this->fetchColumn($sql, 0);
		if ($res === null) {
			return ['all' => -1, 'unread' => -1, 'read' => -1];
		}
		rsort($res);
		$all = (int)($res[0] ?? 0);
		$unread = (int)($res[1] ?? 0);
		return ['all' => $all, 'unread' => $unread, 'read' => $all - $unread];
	}

	public function count(?int $minPriority = null): int {
		$sql = 'SELECT COUNT(e.id) AS count FROM `_entry` e';
		$values = [];
		if ($minPriority !== null) {
			$sql .= ' INNER JOIN `_feed` f ON e.id_feed=f.id';
			$sql .= ' WHERE f.priority > :priority';
			$values[':priority'] = $minPriority;
		}
		$res = $this->fetchColumn($sql, 0, $values);
		return isset($res[0]) ? (int)($res[0]) : -1;
	}

	public function countNotRead(?int $minPriority = null): int {
		$sql = 'SELECT COUNT(e.id) AS count FROM `_entry` e';
		if ($minPriority !== null) {
			$sql .= ' INNER JOIN `_feed` f ON e.id_feed=f.id';
		}
		$sql .= ' WHERE e.is_read=0';
		$values = [];
		if ($minPriority !== null) {
			$sql .= ' AND f.priority > :priority';
			$values[':priority'] = $minPriority;
		}
		$res = $this->fetchColumn($sql, 0, $values);
		return isset($res[0]) ? (int)($res[0]) : -1;
	}

	/** @return array{'all':int,'read':int,'unread':int} */
	public function countUnreadReadFavorites(): array {
		$sql = <<<'SQL'
SELECT c FROM (
	SELECT COUNT(e1.id) AS c, 1 AS o
		FROM `_entry` AS e1
		JOIN `_feed` AS f1 ON e1.id_feed = f1.id
		WHERE e1.is_favorite = 1
		AND f1.priority >= :priority1
	UNION
	SELECT COUNT(e2.id) AS c, 2 AS o
		FROM `_entry` AS e2
		JOIN `_feed` AS f2 ON e2.id_feed = f2.id
		WHERE e2.is_favorite = 1
		AND e2.is_read = 0 AND f2.priority >= :priority2
	) u
ORDER BY o
SQL;
		//Binding a value more than once is not standard and does not work with native prepared statements (e.g. MySQL) https://bugs.php.net/bug.php?id=40417
		$res = $this->fetchColumn($sql, 0, [
			':priority1' => FreshRSS_Feed::PRIORITY_CATEGORY,
			':priority2' => FreshRSS_Feed::PRIORITY_CATEGORY,
		]);
		if ($res === null) {
			return ['all' => -1, 'unread' => -1, 'read' => -1];
		}

		rsort($res);
		$all = (int)($res[0] ?? 0);
		$unread = (int)($res[1] ?? 0);
		return ['all' => $all, 'unread' => $unread, 'read' => $all - $unread];
	}
}

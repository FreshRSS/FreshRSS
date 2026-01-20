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

	protected static function sqlLimitAll(): string {
		// https://dev.mysql.com/doc/refman/9.4/en/select.html
		return '18446744073709551615';	// Maximum unsigned BIGINT in MySQL, which neither supports ALL nor -1
	}

	public static function sqlLimit(int $limit = -1, int $offset = 0): string {
		if ($limit < 0 && $offset <= 0) {
			return '';
		}
		if ($limit < 1) {
			$limit = static::sqlLimitAll();
		}
		return "LIMIT {$limit} OFFSET {$offset}";
	}

	public static function sqlGreatest(string $a, string $b): string {
		return 'GREATEST(' . $a . ', ' . $b . ')';
	}

	public static function sqlRandom(): string {
		return 'RAND()';
	}

	/** @return array{pattern?:string,matchType?:string} */
	protected static function regexToSql(string $regex): array {
		if (preg_match('#^/(?P<pattern>.*)/(?P<matchType>[im]*)$#', $regex, $matches)) {
			return $matches;
		}
		return [];
	}

	/** @param list<int|string> $values */
	protected static function sqlRegex(string $expression, string $regex, array &$values): string {
		// The implementation of this function is solely for MySQL and MariaDB
		static $databaseDAOMySQL = null;
		if (!($databaseDAOMySQL instanceof FreshRSS_DatabaseDAO)) {
			$databaseDAOMySQL = new FreshRSS_DatabaseDAO();
		}

		$matches = static::regexToSql($regex);
		if (isset($matches['pattern'])) {
			$matchType = $matches['matchType'] ?? '';
			if ($databaseDAOMySQL->isMariaDB()) {
				if (str_contains($matchType, 'm')) {
					// multiline mode
					$matches['pattern'] = '(?m)' . $matches['pattern'];
				}
				if (str_contains($matchType, 'i')) {
					// case-insensitive match
					$matches['pattern'] = '(?i)' . $matches['pattern'];
				} else {
					$matches['pattern'] = '(?-i)' . $matches['pattern'];
				}
				$values[] = $matches['pattern'];
				return "{$expression} REGEXP ?";
			} else {	// MySQL
				if (!str_contains($matchType, 'i')) {
					// Case-sensitive matching
					$matchType .= 'c';
				}
				$values[] = $matches['pattern'];
				return "REGEXP_LIKE({$expression},?,'{$matchType}')";
			}
		}
		return '';
	}

	/** Register any needed SQL function for the query, e.g. application-defined functions for SQLite */
	protected function registerSqlFunctions(string $sql): void {
		// Nothing to do for MySQL
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
			Minz_Log::error(__METHOD__ . ' error: ' . $e->getMessage());
		}
		return $ok;
	}

	protected function addColumn(string $name): bool {
		if ($this->pdo->inTransaction()) {
			$this->pdo->commit();
		}
		Minz_Log::warning(__METHOD__ . ': ' . $name);
		require APP_PATH . '/SQL/install.sql.' . $this->pdo->dbType() . '.php';
		try {
			if ($name === 'attributes') {	//v1.20.0
				$sql = <<<'SQL'
ALTER TABLE `_entry` ADD COLUMN attributes TEXT;
ALTER TABLE `_entrytmp` ADD COLUMN attributes TEXT;
SQL;
				return $this->pdo->exec($sql) !== false;
			}
			if ($name === 'lastUserModified') {	//v1.28.0
				$sql = $GLOBALS['ALTER_TABLE_ENTRY_LAST_USER_MODIFIED'];
				if (!is_string($sql)) {
					throw new Exception('ALTER_TABLE_ENTRY_LAST_USER_MODIFIED is not a string!');
				}
				return $this->pdo->exec($sql) !== false;
			}
		} catch (Exception $e) {
			Minz_Log::error(__METHOD__ . ' error: ' . $e->getMessage());
		}
		return false;
	}

	//TODO: Move the database auto-updates to DatabaseDAO
	/** @param array{0:string,1:int,2:string} $errorInfo */
	protected function autoUpdateDb(array $errorInfo): bool {
		if (isset($errorInfo[0])) {
			if ($errorInfo[0] === FreshRSS_DatabaseDAO::ER_BAD_FIELD_ERROR || $errorInfo[0] === FreshRSS_DatabaseDAOPGSQL::UNDEFINED_COLUMN) {
				$errorLines = explode("\n", $errorInfo[2], 2);	// The relevant column name is on the first line, other lines are noise
				foreach (['attributes', 'lastUserModified'] as $column) {
					if (str_contains($errorLines[0], $column)) {
						return $this->addColumn($column);
					}
				}
			}
		}
		if (isset($errorInfo[1])) {
			// May be a string or an int
			if ($errorInfo[1] == FreshRSS_DatabaseDAO::ER_DATA_TOO_LONG) {
				if (str_contains($errorInfo[2], 'content_bin')) {
					return $this->updateToMediumBlob();	//v1.15.0
				}
			}
		}
		return false;
	}

	private PDOStatement|null|false $addEntryPrepared = null;

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
		if ($this->addEntryPrepared != false) {
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
		if ($this->addEntryPrepared != false && $this->addEntryPrepared->execute()) {
			return true;
		} else {
			$info = $this->addEntryPrepared == false ? $this->pdo->errorInfo() : $this->addEntryPrepared->errorInfo();
			/** @var array{id:string,guid:string,title:string,author:string,content:string,link:string,date:int,lastSeen:int,hash:string,
			 * 	is_read:bool|int|null,is_favorite:bool|int|null,id_feed:int,tags:string,attributes?:null|string|array<string,mixed>} $valuesTmp */
			/** @var array{0:string,1:int,2:string} $info */
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
			FROM `_entrytmp` etmp
			ORDER BY etmp.date, etmp.id;

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

	private PDOStatement|null|false $updateEntryPrepared = null;

	/**
	 * @param array{id:string,guid:string,title:string,author:string,content:string,link:string,
	 * 	date:int,lastSeen:int,lastUserModified?:int,hash:string,
	 * 	is_read:bool|int|null,is_favorite:bool|int|null,id_feed:int,tags:string,attributes:array<string,mixed>} $valuesTmp
	 */
	public function updateEntry(array $valuesTmp): bool {
		if (!isset($valuesTmp['is_read'])) {
			$valuesTmp['is_read'] = null;
		}
		if (!isset($valuesTmp['is_favorite'])) {
			$valuesTmp['is_favorite'] = null;
		}
		if (empty($valuesTmp['lastUserModified'])) {
			$valuesTmp['lastUserModified'] = 0;
		}

		if ($this->updateEntryPrepared == null) {
			$sql = 'UPDATE `_entry` '
				. 'SET title=:title, author=:author, '
				. (static::isCompressed() ? 'content_bin=COMPRESS(:content)' : 'content=:content')
				. ', link=:link, date=:date, `lastSeen`=:last_seen'
				. ', `lastUserModified`=' . static::sqlGreatest(':last_user_modified', '`lastUserModified`')
				. ', hash=' . static::sqlHexDecode(':hash')
				. ', is_read=COALESCE(:is_read, is_read)'
				. ', is_favorite=COALESCE(:is_favorite, is_favorite)'
				. ', tags=:tags, attributes=:attributes '
				. 'WHERE id_feed=:id_feed AND guid=:guid';
			$this->updateEntryPrepared = $this->pdo->prepare($sql);
		}
		if ($this->updateEntryPrepared != false) {
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
			$this->updateEntryPrepared->bindParam(':last_user_modified', $valuesTmp['lastUserModified'], PDO::PARAM_INT);
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

		if ($this->updateEntryPrepared != false && $this->updateEntryPrepared->execute()) {
			return true;
		} else {
			$info = $this->updateEntryPrepared == false ? $this->pdo->errorInfo() : $this->updateEntryPrepared->errorInfo();
			/** @var array{id:string,guid:string,title:string,author:string,content:string,link:string,
			 * 	date:int,lastSeen:int,lastUserModified:int,hash:string,
			 * 	is_read:bool|int|null,is_favorite:bool|int|null,id_feed:int,tags:string,attributes:array<string,mixed>} $valuesTmp */
			/** @var array{0:string,1:int,2:string} $info */
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
	 * @param numeric-string|list<numeric-string> $ids
	 */
	public function markFavorite(string|array $ids, bool $is_favorite = true): int|false {
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
			. 'SET is_favorite=?, `lastUserModified`=? '
			. 'WHERE id IN (' . str_repeat('?,', count($ids) - 1) . '?)';
		$values = [$is_favorite ? 1 : 0];
		$values[] = time();
		$values = array_merge($values, $ids);
		$stm = $this->pdo->prepare($sql);
		if ($stm !== false && $stm->execute($values)) {
			Minz_ExtensionManager::callHook(Minz_HookType::EntriesFavorite, $ids, $is_favorite);
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
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
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	/**
	 * Toggle the read marker on one or more article.
	 * Then the cache is updated.
	 *
	 * @param numeric-string|list<numeric-string> $ids
	 * @return int|false affected rows
	 */
	public function markRead(array|string $ids, bool $is_read = true): int|false {
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
				 . 'SET is_read=?, `lastUserModified`=? '
				 . 'WHERE is_read<>? AND id IN (' . str_repeat('?,', count($ids) - 1) . '?)';
			$values = [$is_read ? 1 : 0, time(), $is_read ? 1 : 0];
			$values = array_merge($values, $ids);
			$stm = $this->pdo->prepare($sql);
			if ($stm === false || !$stm->execute($values)) {
				$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
				/** @var array{0:string,1:int,2:string} $info */
				if ($this->autoUpdateDb($info)) {
					return $this->markRead($ids, $is_read);
				} else {
					Minz_Log::error('SQL error ' . __METHOD__ . ' A ' . json_encode($info));
					return false;
				}
			}
			$affected = $stm->rowCount();
			if (($affected > 0) && (!$this->updateCacheUnreads(null, null))) {
				return false;
			}
			return $affected;
		} else {
			FreshRSS_UserDAO::touch();
			$sql = 'UPDATE `_entry` e INNER JOIN `_feed` f ON e.id_feed=f.id '
				 . 'SET e.is_read=?,`lastUserModified`=?,'
				 . 'f.`cache_nbUnreads`=f.`cache_nbUnreads`' . ($is_read ? '-' : '+') . '1 '
				 . 'WHERE e.id=? AND e.is_read=?';
			$values = [$is_read ? 1 : 0, time(), $ids, $is_read ? 0 : 1];
			$stm = $this->pdo->prepare($sql);
			if ($stm !== false && $stm->execute($values)) {
				return $stm->rowCount();
			} else {
				$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
				/** @var array{0:string,1:int,2:string} $info */
				if ($this->autoUpdateDb($info)) {
					return $this->markRead($ids, $is_read);
				} else {
					Minz_Log::error('SQL error ' . __METHOD__ . ' B ' . json_encode($info));
					return false;
				}
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
	public function markReadEntries(string $idMax = '0', bool $onlyFavorites = false, ?int $priorityMin = null, ?int $priorityMax = null,
		?FreshRSS_BooleanSearch $filters = null, int $state = 0, bool $is_read = true) {
		FreshRSS_UserDAO::touch();
		if ($idMax == '0') {
			$idMax = uTimeString();
			Minz_Log::debug('Calling markReadEntries(0) is deprecated!');
		}

		$sql = 'UPDATE `_entry` SET is_read = ?, `lastUserModified`=? WHERE is_read <> ? AND id <= ?';
		$values = [$is_read ? 1 : 0, time(), $is_read ? 1 : 0, $idMax];
		if ($onlyFavorites) {
			$sql .= ' AND is_favorite=1';
		}
		if ($priorityMin !== null || $priorityMax !== null) {
			$sql .= ' AND id_feed IN (SELECT f.id FROM `_feed` f WHERE 1=1';
			if ($priorityMin !== null) {
				$sql .= ' AND f.priority >= ?';
				$values[] = $priorityMin;
			}
			if ($priorityMax !== null) {
				$sql .= ' AND f.priority < ?';
				$values[] = $priorityMax;
			}
			$sql .= ')';
		}

		[$searchValues, $search] = $this->sqlListEntriesWhere(alias: '', state: $state, filters: $filters);

		$stm = $this->pdo->prepare($sql . $search);
		if ($stm === false || !$stm->execute(array_merge($values, $searchValues))) {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
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
	public function markReadCat(int $id, string $idMax = '0', ?FreshRSS_BooleanSearch $filters = null, int $state = 0, bool $is_read = true): int|false {
		FreshRSS_UserDAO::touch();
		if ($idMax == '0') {
			$idMax = uTimeString();
			Minz_Log::debug('Calling markReadCat(0) is deprecated!');
		}

		$sql = <<<'SQL'
UPDATE `_entry`
SET is_read = ?, `lastUserModified` = ?
WHERE is_read <> ? AND id <= ?
AND id_feed IN (SELECT f.id FROM `_feed` f WHERE f.category=? AND f.priority >= ? AND f.priority < ?)
SQL;
		$values = [$is_read ? 1 : 0, time(), $is_read ? 1 : 0, $idMax, $id, FreshRSS_Feed::PRIORITY_CATEGORY, FreshRSS_Feed::PRIORITY_IMPORTANT];

		[$searchValues, $search] = $this->sqlListEntriesWhere(alias: '', state: $state, filters: $filters);

		$stm = $this->pdo->prepare($sql . $search);
		if ($stm === false || !$stm->execute(array_merge($values, $searchValues))) {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
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
	public function markReadFeed(int $id_feed, string $idMax = '0', ?FreshRSS_BooleanSearch $filters = null, int $state = 0, bool $is_read = true): int|false {
		FreshRSS_UserDAO::touch();
		if ($idMax == '0') {
			$idMax = uTimeString();
			Minz_Log::debug('Calling markReadFeed(0) is deprecated!');
		}
		$hadTransaction = $this->pdo->inTransaction();
		if (!$hadTransaction) {
			$this->pdo->beginTransaction();
		}

		$sql = 'UPDATE `_entry` '
			 . 'SET is_read=?, `lastUserModified`=? '
			 . 'WHERE id_feed=? AND is_read <> ? AND id <= ?';
		$values = [$is_read ? 1 : 0, time(), $id_feed, $is_read ? 1 : 0, $idMax];

		[$searchValues, $search] = $this->sqlListEntriesWhere(alias: '', state: $state, filters: $filters);

		$stm = $this->pdo->prepare($sql . $search);
		if ($stm === false || !$stm->execute(array_merge($values, $searchValues))) {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
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
				$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
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
			$idMax = uTimeString();
			Minz_Log::debug('Calling markReadTag(0) is deprecated!');
		}

		$sql = 'UPDATE `_entry` e INNER JOIN `_entrytag` et ON et.id_entry = e.id '
			 . 'SET e.is_read = ?, `lastUserModified` = ? '
			 . 'WHERE '
			 . ($id == 0 ? '' : 'et.id_tag = ? AND ')
			 . 'e.is_read <> ? AND e.id <= ?';
		$values = [$is_read ? 1 : 0, time()];
		if ($id != 0) {
			$values[] = $id;
		}
		$values[] = $is_read ? 1 : 0;
		$values[] = $idMax;

		[$searchValues, $search] = $this->sqlListEntriesWhere(alias: 'e.', state: $state, filters: $filters);

		$stm = $this->pdo->prepare($sql . $search);
		if ($stm === false || !$stm->execute(array_merge($values, $searchValues))) {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
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
	 */
	public function cleanOldEntries(int $id_feed, array $options = []): int|false {
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
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			/** @var array{0:string,1:int,2:string} $info */
			if ($this->autoUpdateDb($info)) {
				return $this->cleanOldEntries($id_feed, $options);
			}
			Minz_Log::error(__METHOD__ . ' error:' . json_encode($info));
			return false;
		}
	}

	/**
	 * @param 'ASC'|'DESC' $order
	 * @return Traversable<array{id:string,guid:string,title:string,author:string,content:string,link:string,
	 * 	date:int,lastSeen:int,lastUserModified:int,
	 *	hash:string,is_read:bool,is_favorite:bool,id_feed:int,tags:string,attributes:?string}>
	 */
	public function selectAll(string $order = 'ASC', int $limit = -1, int $offset = 0): Traversable {
		$content = static::isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content';
		$hash = static::sqlHexEncode('hash');
		$order = in_array($order, ['ASC', 'DESC'], true) ? $order : 'ASC';
		$sqlLimit = static::sqlLimit($limit, $offset);
		$sql = <<<SQL
SELECT id, guid, title, author, {$content}, link, date, `lastSeen`, `lastUserModified`, {$hash} AS hash, is_read, is_favorite, id_feed, tags, attributes
FROM `_entry`
ORDER BY id {$order} {$sqlLimit}
SQL;
		$stm = $this->pdo->query($sql);
		if ($stm !== false) {
			while (is_array($row = $stm->fetch(PDO::FETCH_ASSOC))) {
				/** @var array{id:string,guid:string,title:string,author:string,content:string,link:string,date:int,lastSeen:int,lastUserModified:int,
				 *	hash:string,is_read:bool,is_favorite:bool,id_feed:int,tags:string,attributes:?string} $row */
				yield $row;
			}
		} else {
			$info = $this->pdo->errorInfo();
			/** @var array{0:string,1:int,2:string} $info */
			if ($this->autoUpdateDb($info)) {
				yield from $this->selectAll($order, $limit, $offset);
			} else {
				Minz_Log::error(__METHOD__ . ' error: ' . json_encode($info));
			}
		}
	}

	public function searchByGuid(int $id_feed, string $guid): ?FreshRSS_Entry {
		$content = static::isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content';
		$contentLength = 'LENGTH(' . (static::isCompressed() ? 'content_bin' : 'content') . ') AS content_length';
		$hash = static::sqlHexEncode('hash');
		$sql = <<<SQL
SELECT id, guid, title, author, {$content}, link, date, `lastSeen`, `lastUserModified`, {$hash} AS hash, is_read, is_favorite, id_feed, tags, attributes,
	{$contentLength}
FROM `_entry` WHERE id_feed=:id_feed AND guid=:guid
SQL;
		$res = $this->fetchAssoc($sql, [':id_feed' => $id_feed, ':guid' => $guid]);
		/** @var list<array{id:string,id_feed:int,guid:string,title:string,author:string,content:string,link:string,date:int,
		 * 		is_read:int,is_favorite:int,tags:string,attributes:?string,content_length:int}> $res */
		return isset($res[0]) ? FreshRSS_Entry::fromArray($res[0]) : null;
	}

	public function searchById(string $id): ?FreshRSS_Entry {
		$content = static::isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content';
		$contentLength = 'LENGTH(' . (static::isCompressed() ? 'content_bin' : 'content') . ') AS content_length';
		$hash = static::sqlHexEncode('hash');
		$sql = <<<SQL
SELECT id, guid, title, author, {$content}, link, date, `lastSeen`, `lastUserModified`, {$hash} AS hash, is_read, is_favorite, id_feed, tags, attributes,
	{$contentLength}
FROM `_entry` WHERE id=:id
SQL;
		$res = $this->fetchAssoc($sql, [':id' => $id]);
		/** @var list<array{id:string,id_feed:int,guid:string,title:string,author:string,content:string,link:string,date:int,
		 * 		is_read:int,is_favorite:int,tags:string,attributes:?string,content_length:int}> $res */
		return isset($res[0]) ? FreshRSS_Entry::fromArray($res[0]) : null;
	}

	public function searchIdByGuid(int $id_feed, string $guid): ?string {
		$sql = 'SELECT id FROM `_entry` WHERE id_feed=:id_feed AND guid=:guid';
		$res = $this->fetchColumn($sql, 0, [':id_feed' => $id_feed, ':guid' => $guid]);
		return empty($res[0]) ? null : (string)($res[0]);
	}

	/** @return array{0:list<int|string>,1:string} */
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
			if ($filter->getMinUserdate() !== null) {
				$sub_search .= 'AND ' . $alias . '`lastUserModified` >= ? ';
				$values[] = $filter->getMinUserdate();
			}
			if ($filter->getMaxUserdate() !== null) {
				$sub_search .= 'AND ' . $alias . '`lastUserModified` <= ? ';
				$values[] = $filter->getMaxUserdate();
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
			if ($filter->getNotMinUserdate() !== null || $filter->getNotMaxUserdate() !== null) {
				$sub_search .= 'AND (';
				if ($filter->getNotMinUserdate() !== null) {
					$sub_search .= $alias . '`lastUserModified` < ?';
					$values[] = $filter->getNotMinUserdate();
					if ($filter->getNotMaxUserdate()) {
						$sub_search .= ' OR ';
					}
				}
				if ($filter->getNotMaxUserdate() !== null) {
					$sub_search .= $alias . '`lastUserModified` > ?';
					$values[] = $filter->getNotMaxUserdate();
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

			if ($filter->getCategoryIds() !== null) {
				$sub_search .= 'AND ' . $alias . 'id_feed IN (SELECT f.id FROM `_feed` f WHERE f.category IN (';
				foreach ($filter->getCategoryIds() as $category_id) {
					$sub_search .= '?,';
					$values[] = $category_id;
				}
				$sub_search = rtrim($sub_search, ',');
				$sub_search .= ')) ';
			}
			if ($filter->getNotCategoryIds() !== null) {
				$sub_search .= 'AND ' . $alias . 'id_feed NOT IN (SELECT f.id FROM `_feed` f WHERE f.category IN (';
				foreach ($filter->getNotCategoryIds() as $category_id) {
					$sub_search .= '?,';
					$values[] = $category_id;
				}
				$sub_search = rtrim($sub_search, ',');
				$sub_search .= ')) ';
			}

			if ($filter->getLabelIds() !== null) {
				foreach ($filter->getLabelIds() as $label_ids) {
					if ($label_ids === '*') {
						$sub_search .= 'AND EXISTS (SELECT et.id_tag FROM `_entrytag` et WHERE et.id_entry = ' . $alias . 'id) ';
					} else {
						$sub_search .= 'AND ' . $alias . 'id IN (SELECT et.id_entry FROM `_entrytag` et WHERE et.id_tag IN (';
						foreach ($label_ids as $label_id) {
							$sub_search .= '?,';
							$values[] = $label_id;
						}
						$sub_search = rtrim($sub_search, ',');
						$sub_search .= ')) ';
					}
				}
			}
			if ($filter->getNotLabelIds() !== null) {
				foreach ($filter->getNotLabelIds() as $label_ids) {
					if ($label_ids === '*') {
						$sub_search .= 'AND NOT EXISTS (SELECT et.id_tag FROM `_entrytag` et WHERE et.id_entry = ' . $alias . 'id) ';
					} else {
						$sub_search .= 'AND ' . $alias . 'id NOT IN (SELECT et.id_entry FROM `_entrytag` et WHERE et.id_tag IN (';
						foreach ($label_ids as $label_id) {
							$sub_search .= '?,';
							$values[] = $label_id;
						}
						$sub_search = rtrim($sub_search, ',');
						$sub_search .= ')) ';
					}
				}
			}

			if ($filter->getLabelNames() !== null) {
				foreach ($filter->getLabelNames() as $label_names) {
					$sub_search .= 'AND ' . $alias . 'id IN (SELECT et.id_entry FROM `_entrytag` et, `_tag` t WHERE et.id_tag = t.id AND t.name IN (';
					foreach ($label_names as $label_name) {
						$sub_search .= '?,';
						$values[] = $label_name;
					}
					$sub_search = rtrim($sub_search, ',');
					$sub_search .= ')) ';
				}
			}
			if ($filter->getNotLabelNames() !== null) {
				foreach ($filter->getNotLabelNames() as $label_names) {
					$sub_search .= 'AND ' . $alias . 'id NOT IN (SELECT et.id_entry FROM `_entrytag` et, `_tag` t WHERE et.id_tag = t.id AND t.name IN (';
					foreach ($label_names as $label_name) {
						$sub_search .= '?,';
						$values[] = $label_name;
					}
					$sub_search = rtrim($sub_search, ',');
					$sub_search .= ')) ';
				}
			}

			if ($filter->getAuthor() !== null) {
				foreach ($filter->getAuthor() as $author) {
					$sub_search .= 'AND ' . $alias . 'author LIKE ? ';
					$values[] = "%{$author}%";
				}
			}
			if ($filter->getAuthorRegex() !== null) {
				foreach ($filter->getAuthorRegex() as $author) {
					$sub_search .= 'AND ' . static::sqlRegex("REPLACE({$alias}author, ';', '\n')", $author, $values) . ' ';
				}
			}
			if ($filter->getIntitle() !== null) {
				foreach ($filter->getIntitle() as $title) {
					$sub_search .= 'AND ' . $alias . 'title LIKE ? ';
					$values[] = "%{$title}%";
				}
			}
			if ($filter->getIntitleRegex() !== null) {
				foreach ($filter->getIntitleRegex() as $title) {
					$sub_search .= 'AND ' . static::sqlRegex($alias . 'title', $title, $values) . ' ';
				}
			}
			if ($filter->getIntext() !== null) {
				if (static::isCompressed()) {	// MySQL-only
					foreach ($filter->getIntext() as $content) {
						$sub_search .= "AND UNCOMPRESS({$alias}content_bin) LIKE ? ";
						$values[] = "%{$content}%";
					}
				} else {
					foreach ($filter->getIntext() as $content) {
						$sub_search .= 'AND ' . $alias . 'content LIKE ? ';
						$values[] = "%{$content}%";
					}
				}
			}
			if ($filter->getIntextRegex() !== null) {
				if (static::isCompressed()) {	// MySQL-only
					foreach ($filter->getIntextRegex() as $content) {
						$sub_search .= 'AND ' . static::sqlRegex("UNCOMPRESS({$alias}content_bin)", $content, $values) . ') ';
					}
				} else {
					foreach ($filter->getIntextRegex() as $content) {
						$sub_search .= 'AND ' . static::sqlRegex($alias . 'content', $content, $values) . ' ';
					}
				}
			}
			if ($filter->getTags() !== null) {
				foreach ($filter->getTags() as $tag) {
					$sub_search .= 'AND ' . static::sqlConcat('TRIM(' . $alias . 'tags) ', " ' #'") . ' LIKE ? ';
					$values[] = "%{$tag} #%";
				}
			}
			if ($filter->getTagsRegex() !== null) {
				foreach ($filter->getTagsRegex() as $tag) {
					$sub_search .= 'AND ' . static::sqlRegex("REPLACE(REPLACE({$alias}tags, ' #', '#'), '#', '\n')", $tag, $values) . ' ';
				}
			}
			if ($filter->getInurl() !== null) {
				foreach ($filter->getInurl() as $url) {
					$sub_search .= 'AND ' . $alias . 'link LIKE ? ';
					$values[] = "%{$url}%";
				}
			}
			if ($filter->getInurlRegex() !== null) {
				foreach ($filter->getInurlRegex() as $url) {
					$sub_search .= 'AND ' . static::sqlRegex($alias . 'link', $url, $values) . ' ';
				}
			}

			if ($filter->getNotAuthor() !== null) {
				foreach ($filter->getNotAuthor() as $author) {
					$sub_search .= 'AND ' . $alias . 'author NOT LIKE ? ';
					$values[] = "%{$author}%";
				}
			}
			if ($filter->getNotAuthorRegex() !== null) {
				foreach ($filter->getNotAuthorRegex() as $author) {
					$sub_search .= 'AND NOT ' . static::sqlRegex("REPLACE({$alias}author, ';', '\n')", $author, $values) . ' ';
				}
			}
			if ($filter->getNotIntitle() !== null) {
				foreach ($filter->getNotIntitle() as $title) {
					$sub_search .= 'AND ' . $alias . 'title NOT LIKE ? ';
					$values[] = "%{$title}%";
				}
			}
			if ($filter->getNotIntitleRegex() !== null) {
				foreach ($filter->getNotIntitleRegex() as $title) {
					$sub_search .= 'AND NOT ' . static::sqlRegex($alias . 'title', $title, $values) . ' ';
				}
			}
			if ($filter->getNotIntext() !== null) {
				if (static::isCompressed()) {	// MySQL-only
					foreach ($filter->getNotIntext() as $content) {
						$sub_search .= "AND UNCOMPRESS({$alias}content_bin) NOT LIKE ? ";
						$values[] = "%{$content}%";
					}
				} else {
					foreach ($filter->getNotIntext() as $content) {
						$sub_search .= 'AND ' . $alias . 'content NOT LIKE ? ';
						$values[] = "%{$content}%";
					}
				}
			}
			if ($filter->getNotIntextRegex() !== null) {
				if (static::isCompressed()) {	// MySQL-only
					foreach ($filter->getNotIntextRegex() as $content) {
						$sub_search .= 'AND NOT ' . static::sqlRegex("UNCOMPRESS({$alias}content_bin)", $content, $values) . ') ';
					}
				} else {
					foreach ($filter->getNotIntextRegex() as $content) {
						$sub_search .= 'AND NOT ' . static::sqlRegex($alias . 'content', $content, $values) . ' ';
					}
				}
			}
			if ($filter->getNotTags() !== null) {
				foreach ($filter->getNotTags() as $tag) {
					$sub_search .= 'AND ' . static::sqlConcat('TRIM(' . $alias . 'tags) ', " ' #'") . ' NOT LIKE ? ';
					$values[] = "%{$tag} #%";
				}
			}
			if ($filter->getNotTagsRegex() !== null) {
				foreach ($filter->getNotTagsRegex() as $tag) {
					$sub_search .= 'AND NOT ' . static::sqlRegex("REPLACE(REPLACE({$alias}tags, ' #', '#'), '#', '\n')", $tag, $values) . ' ';
				}
			}
			if ($filter->getNotInurl() !== null) {
				foreach ($filter->getNotInurl() as $url) {
					$sub_search .= 'AND ' . $alias . 'link NOT LIKE ? ';
					$values[] = "%{$url}%";
				}
			}
			if ($filter->getNotInurlRegex() !== null) {
				foreach ($filter->getNotInurlRegex() as $url) {
					$sub_search .= 'AND NOT ' . static::sqlRegex($alias . 'link', $url, $values) . ' ';
				}
			}

			if ($filter->getSearch() !== null) {
				foreach ($filter->getSearch() as $search_value) {
					if (static::isCompressed()) {	// MySQL-only
						$sub_search .= "AND CONCAT({$alias}title, '\\n', UNCOMPRESS({$alias}content_bin)) LIKE ? ";
						$values[] = "%{$search_value}%";
					} else {
						$sub_search .= 'AND (' . $alias . 'title LIKE ? OR ' . $alias . 'content LIKE ?) ';
						$values[] = "%{$search_value}%";
						$values[] = "%{$search_value}%";
					}
				}
			}
			if ($filter->getSearchRegex() !== null) {
				foreach ($filter->getSearchRegex() as $search_value) {
					if (static::isCompressed()) {	// MySQL-only
						$sub_search .= 'AND (' . static::sqlRegex($alias . 'title', $search_value, $values) .
							' OR ' . static::sqlRegex("UNCOMPRESS({$alias}content_bin)", $search_value, $values) . ') ';
					} else {
						$sub_search .= 'AND (' . static::sqlRegex($alias . 'title', $search_value, $values) .
							' OR ' . static::sqlRegex($alias . 'content', $search_value, $values) . ') ';
					}
				}
			}
			if ($filter->getNotSearch() !== null) {
				foreach ($filter->getNotSearch() as $search_value) {
					if (static::isCompressed()) {	// MySQL-only
						$sub_search .= "AND CONCAT({$alias}title, '\\n', UNCOMPRESS({$alias}content_bin)) NOT LIKE ? ";
						$values[] = "%{$search_value}%";
					} else {
						$sub_search .= 'AND ' . $alias . 'title NOT LIKE ? AND ' . $alias . 'content NOT LIKE ? ';
						$values[] = "%{$search_value}%";
						$values[] = "%{$search_value}%";
					}
				}
			}
			if ($filter->getNotSearchRegex() !== null) {
				foreach ($filter->getNotSearchRegex() as $search_value) {
					if (static::isCompressed()) {	// MySQL-only
						$sub_search .= 'AND NOT ' . static::sqlRegex($alias . 'title', $search_value, $values) .
							' ANT NOT ' . static::sqlRegex("UNCOMPRESS({$alias}content_bin)", $search_value, $values) . ' ';
					} else {
						$sub_search .= 'AND NOT ' . static::sqlRegex($alias . 'title', $search_value, $values) .
							' AND NOT ' . static::sqlRegex($alias . 'content', $search_value, $values) . ' ';
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
	 * @param numeric-string $id_min
	 * @param numeric-string $id_max
	 * @param 'id'|'c.name'|'date'|'f.name'|'link'|'title'|'rand'|'lastUserModified'|'length' $sort
	 * @param 'ASC'|'DESC' $order
	 * @param numeric-string $continuation_id
	 * @param list<string|int> $continuation_values
	 * @return array{0:list<int|string>,1:string}
	 */
	protected function sqlListEntriesWhere(string $alias = '', int $state = FreshRSS_Entry::STATE_ALL, ?FreshRSS_BooleanSearch $filters = null,
		string $id_min = '0', string $id_max = '0', string $sort = 'id', string $order = 'DESC',
		string $continuation_id = '0', array $continuation_values = []): array {
		$search = ' ';
		$values = [];
		if ($state & FreshRSS_Entry::STATE_ANDS) {
			if ($state & FreshRSS_Entry::STATE_NOT_READ) {
				if (!($state & FreshRSS_Entry::STATE_READ)) {
					$search .= 'AND (' . $alias . 'is_read=0) ';
				}
			} elseif ($state & FreshRSS_Entry::STATE_READ) {
				$search .= 'AND (' . $alias . 'is_read=1) ';
			}
			if ($state & FreshRSS_Entry::STATE_FAVORITE) {
				if (!($state & FreshRSS_Entry::STATE_NOT_FAVORITE)) {
					$search .= 'AND (' . $alias . 'is_favorite=1) ';
				}
			} elseif ($state & FreshRSS_Entry::STATE_NOT_FAVORITE) {
				$search .= 'AND (' . $alias . 'is_favorite=0) ';
			}
		}
		if ($state & FreshRSS_Entry::STATE_ORS) {
			if (trim($search) === '') {
				$search = 'AND (1=0) ';
			}
			if ($state & FreshRSS_Entry::STATE_OR_NOT_READ) {
				$search = rtrim($search, ') ');
				$search .= ' OR ' . $alias . 'is_read=0) ';
			}
			if ($state & FreshRSS_Entry::STATE_OR_FAVORITE) {
				$search = rtrim($search, ') ');
				$search .= ' OR ' . $alias . 'is_favorite=1) ';
			}
		}

		if (!ctype_digit($id_min)) {
			$id_min = '0';
		}
		if (!ctype_digit($id_max)) {
			$id_max = '0';
		}
		if (!ctype_digit($continuation_id)) {
			$continuation_id = '0';
		}

		if ($continuation_id !== '0' && $sort === 'id') {
			if ($order === 'ASC') {
				$id_min = $id_min === '0' ? $continuation_id : max($id_min, $continuation_id);
			} else {
				$id_max = $id_max === '0' ? $continuation_id : min($id_max, $continuation_id);
			}
		}

		if ($id_max !== '0') {
			$search .= 'AND ' . $alias . 'id <= ? ';
			$values[] = $id_max;
		}
		if ($id_min !== '0') {
			$search .= 'AND ' . $alias . 'id >= ? ';
			$values[] = $id_min;
		}

		if ($continuation_id !== '0' && in_array($sort, ['c.name', 'date', 'f.name', 'link', 'title', 'lastUserModified', 'length'], true)) {
			$sign = $order === 'ASC' ? '>' : '<';
			$orderBy = match ($sort) {
				'c.name' => 'c.name',
				'f.name' => 'f.name',
				'lastUserModified' => $alias . '`lastUserModified`',
				'length' => 'LENGTH(' . $alias . (static::isCompressed() ? 'content_bin' : 'content') . ')',
				default => $alias . $sort,
			};
			// Keyset pagination (Compatibility syntax due to poor performance of tuple syntax in MySQL https://bugs.mysql.com/bug.php?id=104128)
			if ($sort === 'c.name') {
				// Includes a secondary sort by feed name
				$search .= "AND ((c.name {$sign} ?) OR (c.name = ? AND f.name {$sign} ?) OR (c.name = ? AND f.name = ? AND {$alias}id {$sign}= ?)) ";
				$values[] = $continuation_values[0];
				$values[] = $continuation_values[0];
				$values[] = $continuation_values[1];
				$values[] = $continuation_values[0];
				$values[] = $continuation_values[1];
				$values[] = $continuation_id;
			} else {
				$search .= "AND ({$orderBy} {$sign} ? OR ({$orderBy} = ? AND {$alias}id {$sign}= ?)) ";
				$values[] = $continuation_values[0];
				$values[] = $continuation_values[0];
				$values[] = $continuation_id;
			}
		}

		if ($filters !== null && count($filters->searches()) > 0) {
			[$filterValues, $filterSearch] = self::sqlBooleanSearch($alias, $filters);
			$filterSearch = trim($filterSearch);
			if ($filterSearch !== '') {
				$search .= 'AND (' . $filterSearch . ') ';
				$values = array_merge($values, $filterValues);
				$this->registerSqlFunctions($search);
			}
		}
		return [$values, $search];
	}

	/**
	 * @param 'a'|'A'|'c'|'f'|'i'|'s'|'S'|'ST'|'t'|'T'|'Z' $type
	 * @param int $id category/feed/tag ID
	 * @param numeric-string $id_min
	 * @param numeric-string $id_max
	 * @param 'id'|'c.name'|'date'|'f.name'|'link'|'title'|'rand'|'lastUserModified'|'length' $sort
	 * @param 'ASC'|'DESC' $order
	 * @param numeric-string $continuation_id
	 * @param list<string|int> $continuation_values
	 * @return array{0:list<int|string>,1:string}
	 * @throws FreshRSS_EntriesGetter_Exception
	 */
	private function sqlListWhere(string $type = 'a', int $id = 0, int $state = FreshRSS_Entry::STATE_ALL, ?FreshRSS_BooleanSearch $filters = null,
			string $id_min = '0', string $id_max = '0', string $sort = 'id', string $order = 'DESC',
			string $continuation_id = '0', array $continuation_values = [], int $limit = 1, int $offset = 0): array {
		if (!$state) {
			$state = FreshRSS_Entry::STATE_ALL;
		}
		$where = '';
		$values = [];
		switch ($type) {
			case 'a':	// All PRIORITY_MAIN_STREAM
				$where .= 'f.priority >= ' . FreshRSS_Feed::PRIORITY_MAIN_STREAM . ' ';
				break;
			case 'A':	// All except PRIORITY_HIDDEN
				$where .= 'f.priority >= ' . FreshRSS_Feed::PRIORITY_FEED . ' ';
				break;
			case 'Z':	// All including PRIORITY_HIDDEN
				$where .= 'f.priority >= ' . FreshRSS_Feed::PRIORITY_HIDDEN . ' ';
				break;
			case 'i':	// Priority important feeds
				$where .= 'f.priority >= ' . FreshRSS_Feed::PRIORITY_IMPORTANT . ' ';
				break;
			case 's':	//Starred. Deprecated: use $state instead
				$where .= 'f.priority > ' . FreshRSS_Feed::PRIORITY_HIDDEN . ' ';
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

		$order = in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC';
		$sort = in_array($sort, ['id', 'c.name', 'date', 'f.name', 'link', 'title', 'rand', 'lastUserModified', 'length'], true) ? $sort : 'id';
		$orderBy = match ($sort) {
			'c.name' => 'c.name',
			'f.name' => 'f.name',
			'lastUserModified' => 'e.`lastUserModified`',
			'length' => 'LENGTH(e.' . (static::isCompressed() ? 'content_bin' : 'content') . ')',
			'rand' => static::sqlRandom(),
			default => 'e.' . $sort,
		};
		[$searchValues, $search] = $this->sqlListEntriesWhere(alias: 'e.', state: $state, filters: $filters, id_min: $id_min, id_max: $id_max,
			sort: $sort, order: $order, continuation_id: $continuation_id, continuation_values: $continuation_values);

		// Help MySQL/MariaDB's optimizer with the query plan:
		$useEntryIndex = $this->pdo->dbType() === 'mysql' ? 'USE INDEX (entry_feed_read_index) ' : '';

		return [array_merge($values, $searchValues), 'SELECT '
			. ($type === 'T' ? 'DISTINCT ' : '')
			. 'e.id'
			. ($type === 'T' && $sort !== 'id' ? ', ' . $orderBy : '') // SELECT DISTINCT, ORDER BY expressions must appear in SELECT
			. ' FROM `_entry` e ' . $useEntryIndex
			. 'INNER JOIN `_feed` f ON f.id = e.id_feed '
			. ($sort === 'c.name' ? 'INNER JOIN `_category` c ON c.id = f.category ' : '')
			. ($type === 't' || $type === 'T' ? 'INNER JOIN `_entrytag` et ON et.id_entry = e.id ' : '')
			. 'WHERE ' . $where
			. $search
			. 'ORDER BY ' . $orderBy . ' ' . $order
			. ($sort === 'c.name' ? ', f.name ' . $order : '')	// Secondary sort
			. ($sort === 'id' ? '' : ', e.id ' . $order)	// For keyset pagination
			. ($limit > 0 ? ' LIMIT ' . $limit : '')	// http://explainextended.com/2009/10/23/mysql-order-by-limit-performance-late-row-lookups/
			. ($offset > 0 ? ' OFFSET ' . $offset : '')
		];
	}

	/**
	 * @param 'a'|'A'|'c'|'f'|'i'|'s'|'S'|'ST'|'t'|'T'|'Z' $type
	 * @param int $id category/feed/tag ID
	 * @param numeric-string $id_min
	 * @param numeric-string $id_max
	 * @param 'id'|'c.name'|'date'|'f.name'|'link'|'title'|'rand'|'lastUserModified'|'length' $sort
	 * @param 'ASC'|'DESC' $order
	 * @param numeric-string $continuation_id
	 * @param list<string|int> $continuation_values
	 * @throws FreshRSS_EntriesGetter_Exception
	 */
	private function listWhereRaw(string $type = 'a', int $id = 0, int $state = FreshRSS_Entry::STATE_ALL, ?FreshRSS_BooleanSearch $filters = null,
		string $id_min = '0', string $id_max = '0', string $sort = 'id', string $order = 'DESC',
		string $continuation_id = '0', array $continuation_values = [], int $limit = 1, int $offset = 0): PDOStatement|false {
		$order = in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC';
		$sort = in_array($sort, ['id', 'c.name', 'date', 'f.name', 'link', 'title', 'rand', 'lastUserModified', 'length'], true) ? $sort : 'id';

		[$values, $sql] = $this->sqlListWhere($type, $id, $state, $filters, id_min: $id_min, id_max: $id_max, sort: $sort, order: $order,
			continuation_id: $continuation_id, continuation_values: $continuation_values, limit: $limit, offset: $offset);

		$orderBy = match ($sort) {
			'c.name' => 'c0.name',
			'f.name' => 'f0.name',
			'lastUserModified' => 'e0.`lastUserModified`',
			'length' => 'LENGTH(e0.' . (static::isCompressed() ? 'content_bin' : 'content') . ')',
			'rand' => static::sqlRandom(),
			default => 'e0.' . $sort,
		};
		$content = static::isCompressed() ? 'UNCOMPRESS(e0.content_bin) AS content' : 'e0.content';
		$hash = static::sqlHexEncode('e0.hash');
		$sql = <<<SQL
SELECT e0.id, e0.guid, e0.title, e0.author, {$content}, e0.link,
	e0.date, e0.`lastSeen`, e0.`lastUserModified`, {$hash} AS hash, e0.is_read, e0.is_favorite, e0.id_feed, e0.tags, e0.attributes
FROM `_entry` e0 INNER JOIN ({$sql}) e2 ON e2.id=e0.id
SQL;
		if ($sort === 'f.name' || $sort === 'c.name') {
			$sql .= ' INNER JOIN `_feed` f0 ON f0.id = e0.id_feed ';
		}
		if ($sort === 'c.name') {
			$sql .= ' INNER JOIN `_category` c0 ON c0.id = f0.category ';
		}
		$sql .= ' ORDER BY ' . $orderBy . ' ' . $order;
		if ($sort === 'c.name') {
			$sql .= ', f0.name ' . $order;	// Secondary sort
		}
		if ($sort !== 'id') {
			// For keyset pagination
			$sql .= ', e0.id ' . $order;
		}
		$stm = $this->pdo->prepare($sql);
		if ($stm !== false && $stm->execute($values)) {
			return $stm;
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			/** @var array{0:string,1:int,2:string} $info */
			if ($this->autoUpdateDb($info)) {
				return $this->listWhereRaw($type, $id, $state, $filters, id_min: $id_min, id_max: $id_max, sort: $sort, order: $order,
					continuation_id: $continuation_id, continuation_values: $continuation_values, limit: $limit, offset: $offset);
			}
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	/**
	 * @param 'a'|'A'|'c'|'f'|'i'|'s'|'S'|'ST'|'t'|'T'|'Z' $type
	 * @param int $id category/feed/tag ID
	 * @param numeric-string $id_min
	 * @param numeric-string $id_max
	 * @param 'id'|'c.name'|'date'|'f.name'|'link'|'title'|'rand'|'lastUserModified'|'length' $sort
	 * @param 'ASC'|'DESC' $order
	 * @param numeric-string $continuation_id
	 * @param list<string|int> $continuation_values
	 * @return Traversable<FreshRSS_Entry>
	 * @throws FreshRSS_EntriesGetter_Exception
	 */
	public function listWhere(string $type = 'a', int $id = 0, int $state = FreshRSS_Entry::STATE_ALL, ?FreshRSS_BooleanSearch $filters = null,
			string $id_min = '0', string $id_max = '0', string $sort = 'id', string $order = 'DESC',
			string $continuation_id = '0', array $continuation_values = [], int $limit = 1, int $offset = 0): Traversable {
		$stm = $this->listWhereRaw($type, $id, $state, $filters, id_min: $id_min, id_max: $id_max, sort: $sort, order: $order,
			continuation_id: $continuation_id, continuation_values: $continuation_values, limit: $limit, offset: $offset);
		if ($stm !== false) {
			while (is_array($row = $stm->fetch(PDO::FETCH_ASSOC))) {
				/** @var array{'id':string,'id_feed':int,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,
				 *		'hash':string,'is_read':int,'is_favorite':int,'tags':string,'attributes'?:?string} $row */
				yield FreshRSS_Entry::fromArray($row);
			}
		}
	}

	/**
	 * For API.
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
				foreach ($this->listByIds($idsChunk, order: $order) as $entry) {
					yield $entry;
				}
			}
			return;
		}
		$order = in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC';
		$content = static::isCompressed() ? 'UNCOMPRESS(content_bin) AS content' : 'content';
		$hash = static::sqlHexEncode('hash');
		$repeats = str_repeat('?,', count($ids) - 1) . '?';
		$sql = <<<SQL
SELECT id, guid, title, author, link, date, {$hash} AS hash, is_read, is_favorite, id_feed, tags, attributes, {$content}, `lastUserModified`
FROM `_entry`
WHERE id IN ({$repeats})
ORDER BY id {$order}
SQL;
		$stm = $this->pdo->prepare($sql);
		if ($stm === false || !$stm->execute($ids)) {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return;
		}
		while (is_array($row = $stm->fetch(PDO::FETCH_ASSOC))) {
			/** @var array{'id':string,'id_feed':int,'guid':string,'title':string,'author':string,'content':string,'link':string,'date':int,
			 *		'hash':string,'is_read':int,'is_favorite':int,'tags':string,'attributes':?string} $row */
			yield FreshRSS_Entry::fromArray($row);
		}
	}

	/**
	 * @param 'a'|'A'|'c'|'f'|'i'|'s'|'S'|'ST'|'t'|'T'|'Z' $type
	 * @param int $id category/feed/tag ID
	 * @param numeric-string $id_min
	 * @param numeric-string $id_max
	 * @param 'ASC'|'DESC' $order
	 * @param numeric-string $continuation_id
	 * @param list<string|int> $continuation_values
	 * @return list<numeric-string>|null
	 * @throws FreshRSS_EntriesGetter_Exception
	 */
	public function listIdsWhere(string $type = 'a', int $id = 0, int $state = FreshRSS_Entry::STATE_ALL, ?FreshRSS_BooleanSearch $filters = null,
		string $id_min = '0', string $id_max = '0', string $order = 'DESC',
		string $continuation_id = '0', array $continuation_values = [], int $limit = 1, int $offset = 0): ?array {
		[$values, $sql] = $this->sqlListWhere($type, $id, $state, $filters, id_min: $id_min, id_max: $id_max, order: $order,
			continuation_id: $continuation_id, continuation_values: $continuation_values, limit: $limit, offset: $offset);
		$stm = $this->pdo->prepare($sql);
		if ($stm !== false && $stm->execute($values)) {
			/** @var list<int|numeric-string> $res */
			$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
			$res = array_map('strval', $res);
			/** @var list<numeric-string> $res */
			return $res;
		}
		$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
		Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
		return null;
	}

	/**
	 * @param array<string> $guids
	 * @return array<string,string> guid => hash
	 */
	public function listHashForFeedGuids(int $id_feed, array $guids): array {
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
				/** @var array{guid:string,hex_hash:string} $row */
				$result[$row['guid']] = $row['hex_hash'];
			}
			return $result;
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info)
				. ' while querying feed ' . $id_feed);
			return [];
		}
	}

	/**
	 * @param array<string> $guids
	 * @return int|false The number of affected entries, or false if error
	 */
	public function updateLastSeen(int $id_feed, array $guids, int $mtime = 0): int|false {
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

		// Reduce MySQL deadlock probability by ensuring consistent lock ordering
		$orderBy = $this->pdo->dbType() === 'mysql' ? ' ORDER BY id DESC' : '';

		$sql = 'UPDATE `_entry` ' .
			'SET `lastSeen`=? WHERE id_feed=? AND guid IN (' . str_repeat('?,', count($guids) - 1) . '?)' .
			$orderBy;
		$stm = $this->pdo->prepare($sql);
		if ($mtime <= 0) {
			$mtime = time();
		}
		$values = [$mtime, $id_feed];
		$values = array_merge($values, $guids);
		if ($stm !== false && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
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
	public function updateLastSeenUnchanged(int $id_feed, int $mtime = 0): int|false {
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
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info) . ' while updating feed ' . $id_feed);
			return false;
		}
	}

	/** @return array{all:int,unread:int,read:int,favorites:int} */
	public function countAsStates(?int $minPriority = null): array {
		$values = [];
		$sql = <<<'SQL'
			SELECT
				COUNT(*) AS total,
				COUNT(CASE WHEN e.is_read = 0 THEN 1 END) AS unread,
				COUNT(CASE WHEN e.is_favorite = 1 THEN 1 END) AS favorites
			FROM `_entry` e
			SQL;
		if ($minPriority !== null) {
			$sql .= <<<'SQL'
			INNER JOIN `_feed` f ON e.id_feed = f.id
			WHERE f.priority > :priority
			SQL;
			$values[':priority'] = $minPriority;
		}
		$res = $this->fetchAssoc($sql, $values);
		if ($res === null || !isset($res[0])) {
			return ['all' => -1, 'unread' => -1, 'read' => -1, 'favorites' => -1];
		}
		$all = (int)($res[0]['total'] ?? 0);
		$unread = (int)($res[0]['unread'] ?? 0);
		$favorites = (int)($res[0]['favorites'] ?? 0);
		return ['all' => $all, 'unread' => $unread, 'read' => $all - $unread, 'favorites' => $favorites];
	}

	public function count(?int $minPriority = null): int {
		$sql = 'SELECT COUNT(*) AS count FROM `_entry` e';
		$values = [];
		if ($minPriority !== null) {
			$sql .= ' INNER JOIN `_feed` f ON e.id_feed=f.id';
			$sql .= ' WHERE f.priority > :priority';
			$values[':priority'] = $minPriority;
		}
		$res = $this->fetchColumn($sql, 0, $values);
		return isset($res[0]) ? (int)($res[0]) : -1;
	}

	/** @return array{'all':int,'read':int,'unread':int} */
	public function countUnreadReadFavorites(): array {
		$sql = <<<'SQL'
			SELECT
				COUNT(*) AS total,
				COUNT(CASE WHEN e.is_read = 0 THEN 1 END) AS unread
			FROM `_entry` e
			JOIN `_feed` f ON e.id_feed = f.id
			WHERE e.is_favorite = 1 AND f.priority > :priority
			SQL;
		$res = $this->fetchAssoc($sql, [':priority' => FreshRSS_Feed::PRIORITY_HIDDEN]);
		if ($res === null || !isset($res[0])) {
			return ['all' => -1, 'unread' => -1, 'read' => -1];
		}
		$all = (int)($res[0]['total'] ?? 0);
		$unread = (int)($res[0]['unread'] ?? 0);
		return ['all' => $all, 'unread' => $unread, 'read' => $all - $unread];
	}
}

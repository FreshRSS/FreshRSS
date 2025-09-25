<?php
declare(strict_types=1);

class FreshRSS_FeedDAO extends Minz_ModelPdo {

	protected function addColumn(string $name): bool {
		if ($this->pdo->inTransaction()) {
			$this->pdo->commit();
		}
		Minz_Log::warning(__METHOD__ . ': ' . $name);
		try {
			if ($name === 'kind') {	//v1.20.0
				return $this->pdo->exec('ALTER TABLE `_feed` ADD COLUMN kind SMALLINT DEFAULT 0') !== false;
			}
		} catch (Exception $e) {
			Minz_Log::error(__METHOD__ . ' error: ' . $e->getMessage());
		}
		return false;
	}

	/** @param array{0:string,1:int,2:string} $errorInfo */
	protected function autoUpdateDb(array $errorInfo): bool {
		if (isset($errorInfo[0])) {
			if ($errorInfo[0] === FreshRSS_DatabaseDAO::ER_BAD_FIELD_ERROR || $errorInfo[0] === FreshRSS_DatabaseDAOPGSQL::UNDEFINED_COLUMN) {
				$errorLines = explode("\n", $errorInfo[2], 2);	// The relevant column name is on the first line, other lines are noise
				foreach (['kind'] as $column) {
					if (str_contains($errorLines[0], $column)) {
						return $this->addColumn($column);
					}
				}
			}
		}
		return false;
	}

	/**
	 * @param array{url:string,kind:int,category:int,name:string,website:string,description:string,lastUpdate:int,priority?:int,
	 * 	pathEntries?:string,httpAuth:string,error:int|bool,ttl?:int,attributes?:string|array<string|mixed>} $valuesTmp
	 */
	public function addFeed(array $valuesTmp): int|false {
		$sql = 'INSERT INTO `_feed` (url, kind, category, name, website, description, `lastUpdate`, priority, `pathEntries`, `httpAuth`, error, ttl, attributes)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$stm = $this->pdo->prepare($sql);

		$valuesTmp['url'] = safe_ascii($valuesTmp['url']);
		$valuesTmp['website'] = safe_ascii($valuesTmp['website']);
		if (!isset($valuesTmp['pathEntries'])) {
			$valuesTmp['pathEntries'] = '';
		}
		if (!isset($valuesTmp['attributes'])) {
			$valuesTmp['attributes'] = [];
		}

		$values = [
			$valuesTmp['url'],
			$valuesTmp['kind'] ?? FreshRSS_Feed::KIND_RSS,
			$valuesTmp['category'],
			mb_strcut(trim($valuesTmp['name']), 0, FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE, 'UTF-8'),
			$valuesTmp['website'],
			sanitizeHTML($valuesTmp['description'], ''),
			$valuesTmp['lastUpdate'],
			isset($valuesTmp['priority']) ? (int)$valuesTmp['priority'] : FreshRSS_Feed::PRIORITY_MAIN_STREAM,
			mb_strcut($valuesTmp['pathEntries'], 0, 4096, 'UTF-8'),
			base64_encode($valuesTmp['httpAuth']),
			isset($valuesTmp['error']) ? (int)$valuesTmp['error'] : 0,
			isset($valuesTmp['ttl']) ? (int)$valuesTmp['ttl'] : FreshRSS_Feed::TTL_DEFAULT,
			is_string($valuesTmp['attributes']) ? $valuesTmp['attributes'] : json_encode($valuesTmp['attributes'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
		];

		if ($stm !== false && $stm->execute($values)) {
			$feedId = $this->pdo->lastInsertId('`_feed_id_seq`');
			return $feedId === false ? false : (int)$feedId;
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			/** @var array{0:string,1:int,2:string} $info */
			if ($this->autoUpdateDb($info)) {
				return $this->addFeed($valuesTmp);
			}
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	public function addFeedObject(FreshRSS_Feed $feed): int|false {
		// Add feed only if we don’t find it in DB
		$feed_search = $this->searchByUrl($feed->url());
		if ($feed_search === null) {
			$values = [
				'id' => $feed->id(),
				'url' => $feed->url(),
				'kind' => $feed->kind(),
				'category' => $feed->categoryId(),
				'name' => $feed->name(true),
				'website' => $feed->website(),
				'description' => $feed->description(),
				'priority' => $feed->priority(),
				'lastUpdate' => 0,
				'error' => false,
				'pathEntries' => $feed->pathEntries(),
				'httpAuth' => $feed->httpAuth(),
				'ttl' => $feed->ttl(true),
				'attributes' => $feed->attributes(),
			];

			$id = $this->addFeed($values);
			if ($id) {
				$feed->_id($id);
				$feed->faviconPrepare();
			}

			return $id;
		} else {
			// The feed already exists so make sure it is not muted
			$feed->_ttl($feed_search->ttl());
			$feed->_mute(false);

			// Merge existing and import attributes
			$existingAttributes = $feed_search->attributes();
			$importAttributes = $feed->attributes();
			$mergedAttributes = array_replace_recursive($existingAttributes, $importAttributes);
			$mergedAttributes = array_filter($mergedAttributes, 'is_string', ARRAY_FILTER_USE_KEY);
			$feed->_attributes($mergedAttributes);

			// Update some values of the existing feed using the import
			$values = [
				'kind' => $feed->kind(),
				'name' => $feed->name(true),
				'website' => $feed->website(),
				'description' => $feed->description(),
				'pathEntries' => $feed->pathEntries(),
				'ttl' => $feed->ttl(true),
				'attributes' => $feed->attributes(),
			];

			if (!$this->updateFeed($feed_search->id(), $values)) {
				return false;
			}

			return $feed_search->id();
		}
	}

	/**
	 * @param array{'url'?:string,'kind'?:int,'category'?:int,'name'?:string,'website'?:string,'description'?:string,'lastUpdate'?:int,'priority'?:int,
	 * 	'pathEntries'?:string,'httpAuth'?:string,'error'?:int,'ttl'?:int,'attributes'?:string|array<string,mixed>} $valuesTmp $valuesTmp
	 */
	public function updateFeed(int $id, array $valuesTmp): bool {
		$values = [];
		$originalValues = $valuesTmp;
		if (isset($valuesTmp['name'])) {
			$valuesTmp['name'] = mb_strcut(trim($valuesTmp['name']), 0, FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE, 'UTF-8');
		}
		if (isset($valuesTmp['url'])) {
			$valuesTmp['url'] = safe_ascii($valuesTmp['url']);
		}
		if (isset($valuesTmp['website'])) {
			$valuesTmp['website'] = safe_ascii($valuesTmp['website']);
		}

		$set = '';
		foreach ($valuesTmp as $key => $v) {
			$set .= '`' . $key . '`=?, ';

			if ($key === 'httpAuth') {
				$valuesTmp[$key] = base64_encode($v);
			} elseif ($key === 'attributes') {
				$valuesTmp[$key] = is_string($valuesTmp[$key]) ? $valuesTmp[$key] : json_encode($valuesTmp[$key], JSON_UNESCAPED_SLASHES);
			}
		}
		$set = substr($set, 0, -2);

		$sql = 'UPDATE `_feed` SET ' . $set . ' WHERE id=?';
		$stm = $this->pdo->prepare($sql);

		foreach ($valuesTmp as $v) {
			$values[] = $v;
		}
		$values[] = $id;

		if ($stm !== false && $stm->execute($values)) {
			return true;
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			/** @var array{0:string,1:int,2:string} $info */
			if ($this->autoUpdateDb($info)) {
				return $this->updateFeed($id, $originalValues);
			}
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info) . ' for feed ' . $id);
			return false;
		}
	}

	/**
	 * @param non-empty-string $key
	 * @param string|array<mixed>|bool|int|null $value
	 */
	public function updateFeedAttribute(FreshRSS_Feed $feed, string $key, $value): bool {
		$feed->_attribute($key, $value);
		return $this->updateFeed(
			$feed->id(),
			['attributes' => $feed->attributes()]
		);
	}

	/**
	 * @see updateCachedValues()
	 */
	public function updateLastUpdate(int $id, bool $inError = false, int $mtime = 0): int|false {
		$sql = 'UPDATE `_feed` SET `lastUpdate`=?, error=? WHERE id=?';
		$values = [
			$mtime <= 0 ? time() : $mtime,
			$inError ? 1 : 0,
			$id,
		];
		$stm = $this->pdo->prepare($sql);

		if ($stm !== false && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::warning(__METHOD__ . ' error: ' . $sql . ' : ' . json_encode($info));
			return false;
		}
	}

	public function mute(int $id, bool $value = true): int|false {
		$sql = 'UPDATE `_feed` SET ttl=' . ($value ? '-' : '') . 'ABS(ttl) WHERE id=' . intval($id);
		return $this->pdo->exec($sql);
	}

	public function changeCategory(int $idOldCat, int $idNewCat): int|false {
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$newCat = $catDAO->searchById($idNewCat);
		if ($newCat === null) {
			$newCat = $catDAO->getDefault();
		}
		if ($newCat === null) {
			return false;
		}

		$sql = 'UPDATE `_feed` SET category=? WHERE category=?';
		$stm = $this->pdo->prepare($sql);

		$values = [
			$newCat->id(),
			$idOldCat,
		];

		if ($stm !== false && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	public function deleteFeed(int $id): int|false {
		$sql = 'DELETE FROM `_feed` WHERE id=?';
		$stm = $this->pdo->prepare($sql);

		$values = [$id];

		if ($stm !== false && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	/**
	 * @param bool|null $muted to include only muted feeds
	 * @param bool|null $errored to include only errored feeds
	 */
	public function deleteFeedByCategory(int $id, ?bool $muted = null, ?bool $errored = null): int|false {
		$sql = 'DELETE FROM `_feed` WHERE category=?';
		if ($muted) {
			$sql .= ' AND ttl < 0';
		}
		if ($errored) {
			$sql .= ' AND error <> 0';
		}
		$stm = $this->pdo->prepare($sql);

		$values = [$id];

		if ($stm !== false && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	/** @return Traversable<array{id:int,url:string,kind:int,category:int,name:string,website:string,description:string,lastUpdate:int,priority?:int,
	 * 	pathEntries?:string,httpAuth:string,error:int|bool,ttl?:int,attributes?:string}> */
	public function selectAll(): Traversable {
		$sql = <<<'SQL'
SELECT id, url, kind, category, name, website, description, `lastUpdate`,
	priority, `pathEntries`, `httpAuth`, error, ttl, attributes
FROM `_feed`
SQL;
		$stm = $this->pdo->query($sql);
		if ($stm !== false) {
			while (is_array($row = $stm->fetch(PDO::FETCH_ASSOC))) {
				/** @var array{id:int,url:string,kind:int,category:int,name:string,website:string,description:string,lastUpdate:int,priority?:int,
				 *	pathEntries?:string,httpAuth:string,error:int,ttl?:int,attributes?:string} $row */
				yield $row;
			}
		} else {
			$info = $this->pdo->errorInfo();
			/** @var array{0:string,1:int,2:string} $info */
			if ($this->autoUpdateDb($info)) {
				yield from $this->selectAll();
			} else {
				Minz_Log::error(__METHOD__ . ' error: ' . json_encode($info));
			}
		}
	}

	public function searchById(int $id): ?FreshRSS_Feed {
		$sql = 'SELECT * FROM `_feed` WHERE id=:id';
		$res = $this->fetchAssoc($sql, [':id' => $id]);
		if (!is_array($res)) {
			return null;
		}
		/** @var list<array{id:int,url:string,kind:int,category:int,name:string,website:string,description:string,lastUpdate:int,priority:int,
		 * 	pathEntries:string,httpAuth:string,error:int,ttl:int,attributes?:string,cache_nbUnreads:int,cache_nbEntries:int}> $res */
		$feeds = self::daoToFeeds($res);
		return $feeds[$id] ?? null;
	}

	public function searchByUrl(string $url): ?FreshRSS_Feed {
		$sql = 'SELECT * FROM `_feed` WHERE url=:url';
		$res = $this->fetchAssoc($sql, [':url' => $url]);
		if (!is_array($res)) {
			return null;
		}
		/** @var list<array{id:int,url:string,kind:int,category:int,name:string,website:string,description:string,lastUpdate:int,priority:int,
		 * 	pathEntries:string,httpAuth:string,error:int,ttl:int,attributes?:string,cache_nbUnreads:int,cache_nbEntries:int}> $res */
		return empty($res[0]) ? null : (current(self::daoToFeeds($res)) ?: null);
	}

	/** @return list<int> */
	public function listFeedsIds(): array {
		$sql = 'SELECT id FROM `_feed`';
		/** @var list<int> $res */
		$res = $this->fetchColumn($sql, 0) ?? [];
		return $res;
	}

	/** @return array<int,FreshRSS_Feed> where the key is the feed ID */
	public function listFeeds(): array {
		$sql = 'SELECT * FROM `_feed` ORDER BY name';
		$res = $this->fetchAssoc($sql);
		if (!is_array($res)) {
			return [];
		}
		/** @var list<array{id:int,url:string,kind:int,category:int,name:string,website:string,description:string,lastUpdate:int,priority:int,
		 * 	pathEntries:string,httpAuth:string,error:int,ttl:int,attributes?:string,cache_nbUnreads:int,cache_nbEntries:int}> $res */
		return self::daoToFeeds($res);
	}

	/** @return array<string,string> */
	public function listFeedsNewestItemUsec(?int $id_feed = null): array {
		$sql = 'SELECT id_feed, MAX(id) as newest_item_us FROM `_entry` ';
		if ($id_feed === null) {
			$sql .= 'GROUP BY id_feed';
		} else {
			$sql .= 'WHERE id_feed=' . intval($id_feed);
		}
		$res = $this->fetchAssoc($sql);
		/** @var list<array{id_feed:int,newest_item_us:string}>|null $res */
		if ($res === null) {
			return [];
		}
		$newestItemUsec = [];
		foreach ($res as $line) {
			$newestItemUsec['f_' . $line['id_feed']] = $line['newest_item_us'];
		}
		return $newestItemUsec;
	}

	/**
	 * @param int $defaultCacheDuration Use -1 to return all feeds, without filtering them by TTL.
	 * @return array<int,FreshRSS_Feed> where the key is the feed ID
	 */
	public function listFeedsOrderUpdate(int $defaultCacheDuration = 3600, int $limit = 0): array {
		$sql = 'SELECT * FROM `_feed` '
			. ($defaultCacheDuration < 0 ? '' : 'WHERE ttl >= ' . FreshRSS_Feed::TTL_DEFAULT
				. ' AND `lastUpdate` < (' . (time() + 60)
				. '-(CASE WHEN ttl=' . FreshRSS_Feed::TTL_DEFAULT . ' THEN ' . intval($defaultCacheDuration) . ' ELSE ttl END)) ')
			. 'ORDER BY `lastUpdate` '
			. ($limit < 1 ? '' : 'LIMIT ' . intval($limit));
		$stm = $this->pdo->query($sql);
		if ($stm !== false && ($res = $stm->fetchAll(PDO::FETCH_ASSOC)) !== false) {
			/** @var list<array{id?:int,url?:string,kind?:int,category?:int,name?:string,website?:string,description?:string,lastUpdate?:int,priority?:int,
			 * pathEntries?:string,httpAuth?:string,error?:int,ttl?:int,attributes?:string,cache_nbUnreads?:int,cache_nbEntries?:int}> $res */
			return self::daoToFeeds($res);
		} else {
			$info = $this->pdo->errorInfo();
			/** @var array{0:string,1:int,2:string} $info */
			if ($this->autoUpdateDb($info)) {
				return $this->listFeedsOrderUpdate($defaultCacheDuration, $limit);
			}
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return [];
		}
	}

	/** @return list<string> */
	public function listTitles(int $id, int $limit = 0): array {
		$sql = 'SELECT title FROM `_entry` WHERE id_feed=:id_feed ORDER BY id DESC'
			. ($limit < 1 ? '' : ' LIMIT ' . intval($limit));
		$res = $this->fetchColumn($sql, 0, [':id_feed' => $id]) ?? [];
		/** @var list<string> $res */
		return $res;
	}

	/**
	 * @param bool|null $muted to include only muted feeds
	 * @param bool|null $errored to include only errored feeds
	 * @return array<int,FreshRSS_Feed> where the key is the feed ID
	 */
	public function listByCategory(int $cat, ?bool $muted = null, ?bool $errored = null): array {
		$sql = 'SELECT * FROM `_feed` WHERE category=:category';
		if ($muted) {
			$sql .= ' AND ttl < 0';
		}
		if ($errored) {
			$sql .= ' AND error <> 0';
		}
		$res = $this->fetchAssoc($sql, [':category' => $cat]);
		if (!is_array($res)) {
			return [];
		}
		/** @var list<array{id:int,url:string,kind:int,category:int,name:string,website:string,description:string,lastUpdate:int,priority:int,
		 * 	pathEntries:string,httpAuth:string,error:int,ttl:int,attributes?:string,cache_nbUnreads:int,cache_nbEntries:int}> $res */
		$feeds = self::daoToFeeds($res);
		uasort($feeds, static fn(FreshRSS_Feed $a, FreshRSS_Feed $b) => strnatcasecmp($a->name(), $b->name()));
		return $feeds;
	}

	public function countEntries(int $id): int {
		$sql = 'SELECT COUNT(*) AS count FROM `_entry` WHERE id_feed=:id_feed';
		$res = $this->fetchColumn($sql, 0, ['id_feed' => $id]);
		return isset($res[0]) ? (int)($res[0]) : -1;
	}

	public function countNotRead(int $id): int {
		$sql = 'SELECT COUNT(*) AS count FROM `_entry` WHERE id_feed=:id_feed AND is_read=0';
		$res = $this->fetchColumn($sql, 0, ['id_feed' => $id]);
		return isset($res[0]) ? (int)($res[0]) : -1;
	}

	/**
	 * Update cached values for selected feeds, or all feeds if no feed ID is provided.
	 */
	public function updateCachedValues(int ...$feedIds): int|false {
		//2 sub-requests with FOREIGN KEY(e.id_feed), INDEX(e.is_read) faster than 1 request with GROUP BY or CASE
		$sql = <<<SQL
UPDATE `_feed`
SET `cache_nbEntries`=(SELECT COUNT(e1.id) FROM `_entry` e1 WHERE e1.id_feed=`_feed`.id),
	`cache_nbUnreads`=(SELECT COUNT(e2.id) FROM `_entry` e2 WHERE e2.id_feed=`_feed`.id AND e2.is_read=0)
SQL;
		if (count($feedIds) > 0) {
			$sql .= ' WHERE id IN (' . str_repeat('?,', count($feedIds) - 1) . '?)';
		}
		$stm = $this->pdo->prepare($sql);
		if ($stm !== false && $stm->execute($feedIds)) {
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	/**
	 * Remember to call updateCachedValues() after calling this function
	 * @return int|false number of lines affected or false in case of error
	 */
	public function markAsReadMaxUnread(int $id, int $n): int|false {
		//Double SELECT for MySQL workaround ERROR 1093 (HY000)
		$sql = <<<'SQL'
UPDATE `_entry` SET is_read=1
WHERE id_feed=:id_feed1 AND is_read=0 AND id <= (SELECT e3.id FROM (
	SELECT e2.id FROM `_entry` e2
	WHERE e2.id_feed=:id_feed2 AND e2.is_read=0
	ORDER BY e2.id DESC
	LIMIT 1
	OFFSET :limit) e3)
SQL;

		if (($stm = $this->pdo->prepare($sql)) !== false &&
			$stm->bindParam(':id_feed1', $id, PDO::PARAM_INT) &&
			$stm->bindParam(':id_feed2', $id, PDO::PARAM_INT) &&
			$stm->bindParam(':limit', $n, PDO::PARAM_INT) &&
			$stm->execute()) {
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	/**
	 * Remember to call updateCachedValues() after calling this function
	 * @return int|false number of lines affected or false in case of error
	 */
	public function markAsReadNotSeen(int $id, int $minLastSeen): int|false {
		$sql = <<<'SQL'
UPDATE `_entry` SET is_read=1
WHERE id_feed=:id_feed AND is_read=0 AND (`lastSeen` + 10 < :min_last_seen)
SQL;

		if (($stm = $this->pdo->prepare($sql)) !== false &&
			$stm->bindValue(':id_feed', $id, PDO::PARAM_INT) &&
			$stm->bindValue(':min_last_seen', $minLastSeen, PDO::PARAM_INT) &&
			$stm->execute()) {
			return $stm->rowCount();
		} else {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			return false;
		}
	}

	public function truncate(int $id): int|false {
		$sql = 'DELETE FROM `_entry` WHERE id_feed=:id';
		$stm = $this->pdo->prepare($sql);
		$this->pdo->beginTransaction();
		if (!($stm !== false &&
			$stm->bindParam(':id', $id, PDO::PARAM_INT) &&
			$stm->execute())) {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			$this->pdo->rollBack();
			return false;
		}
		$affected = $stm->rowCount();

		$sql = 'UPDATE `_feed` SET `cache_nbEntries`=0, `cache_nbUnreads`=0, `lastUpdate`=0 WHERE id=:id';
		$stm = $this->pdo->prepare($sql);
		if (!($stm !== false &&
			$stm->bindParam(':id', $id, PDO::PARAM_INT) &&
			$stm->execute())) {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . json_encode($info));
			$this->pdo->rollBack();
			return false;
		}

		$this->pdo->commit();
		return $affected;
	}

	public function purge(): bool {
		$sql = 'DELETE FROM `_entry`';
		$stm = $this->pdo->prepare($sql);
		$this->pdo->beginTransaction();
		if ($stm === false || !$stm->execute()) {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . ' A ' . json_encode($info));
			$this->pdo->rollBack();
			return false;
		}

		$sql = 'UPDATE `_feed` SET `cache_nbEntries` = 0, `cache_nbUnreads` = 0';
		$stm = $this->pdo->prepare($sql);
		if ($stm === false || !$stm->execute()) {
			$info = $stm === false ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error('SQL error ' . __METHOD__ . ' B ' . json_encode($info));
			$this->pdo->rollBack();
			return false;
		}

		return $this->pdo->commit();
	}

	/**
	 * @param array<array{id?:int,url?:string,kind?:int,category?:int,name?:string,website?:string,description?:string,lastUpdate?:int,priority?:int,
	 * 	pathEntries?:string,httpAuth?:string,error?:int|bool,ttl?:int,attributes?:string,cache_nbUnreads?:int,cache_nbEntries?:int}> $listDAO
	 * @return array<int,FreshRSS_Feed> where the key is the feed ID
	 */
	public static function daoToFeeds(array $listDAO, ?int $catID = null): array {
		$list = [];

		foreach ($listDAO as $dao) {
			if (!is_string($dao['name'] ?? null)) {
				continue;
			}
			if ($catID === null) {
				$category = is_numeric($dao['category'] ?? null) ? (int)$dao['category'] : 0;
			} else {
				$category = $catID;
			}

			$myFeed = new FreshRSS_Feed($dao['url'] ?? '', false);
			$myFeed->_kind($dao['kind'] ?? FreshRSS_Feed::KIND_RSS);
			$myFeed->_categoryId($category);
			$myFeed->_name($dao['name']);
			$myFeed->_website($dao['website'] ?? '', false);
			$myFeed->_description($dao['description'] ?? '');
			$myFeed->_lastUpdate($dao['lastUpdate'] ?? 0);
			$myFeed->_priority($dao['priority'] ?? 10);
			$myFeed->_pathEntries($dao['pathEntries'] ?? '');
			$myFeed->_httpAuth(base64_decode($dao['httpAuth'] ?? '', true) ?: '');
			$myFeed->_error($dao['error'] ?? 0);
			$myFeed->_ttl($dao['ttl'] ?? FreshRSS_Feed::TTL_DEFAULT);
			$myFeed->_attributes($dao['attributes'] ?? '');
			$myFeed->_nbNotRead($dao['cache_nbUnreads'] ?? -1);
			$myFeed->_nbEntries($dao['cache_nbEntries'] ?? -1);
			if (isset($dao['id'])) {
				$myFeed->_id($dao['id']);
			}
			$list[$myFeed->id()] = $myFeed;
		}

		return $list;
	}

	public function count(): int {
		$sql = 'SELECT COUNT(e.id) AS count FROM `_feed` e';
		$stm = $this->pdo->query($sql);
		if ($stm === false) {
			return -1;
		}
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		return is_numeric($res[0] ?? null) ? (int)$res[0] : 0;
	}
}

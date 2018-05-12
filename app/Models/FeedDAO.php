<?php

class FreshRSS_FeedDAO extends Minz_ModelPdo implements FreshRSS_Searchable {

	protected function addColumn($name) {
		Minz_Log::warning('FreshRSS_FeedDAO::addColumn: ' . $name);
		try {
			if ($name === 'attributes') {	//v1.11.0
				$stm = $this->bd->prepare('ALTER TABLE `' . $this->prefix . 'feed` ADD COLUMN attributes TEXT');
				return $stm && $stm->execute();
			}
		} catch (Exception $e) {
			Minz_Log::error('FreshRSS_FeedDAO::addColumn error: ' . $e->getMessage());
		}
		return false;
	}

	protected function autoUpdateDb($errorInfo) {
		if (isset($errorInfo[0])) {
			if ($errorInfo[0] === '42S22' || $errorInfo[0] === '42703') {	//ER_BAD_FIELD_ERROR (Mysql), undefined_column (PostgreSQL)
				foreach (array('attributes') as $column) {
					if (stripos($errorInfo[2], $column) !== false) {
						return $this->addColumn($column);
					}
				}
			}
		}
		return false;
	}

	public function addFeed($valuesTmp) {
		$sql = '
			INSERT INTO `' . $this->prefix . 'feed`
				(
					url,
					category,
					name,
					website,
					description,
					`lastUpdate`,
					priority,
					`httpAuth`,
					error,
					keep_history,
					ttl,
					attributes
				)
				VALUES
				(?, ?, ?, ?, ?, ?, 10, ?, 0, ?, ?, ?)';
		$stm = $this->bd->prepare($sql);

		$valuesTmp['url'] = safe_ascii($valuesTmp['url']);
		$valuesTmp['website'] = safe_ascii($valuesTmp['website']);

		$values = array(
			substr($valuesTmp['url'], 0, 511),
			$valuesTmp['category'],
			substr($valuesTmp['name'], 0, 255),
			substr($valuesTmp['website'], 0, 255),
			substr($valuesTmp['description'], 0, 1023),
			$valuesTmp['lastUpdate'],
			base64_encode($valuesTmp['httpAuth']),
			FreshRSS_Feed::KEEP_HISTORY_DEFAULT,
			FreshRSS_Feed::TTL_DEFAULT,
			isset($valuesTmp['attributes']) ? json_encode($valuesTmp['attributes']) : '',
		);

		if ($stm && $stm->execute($values)) {
			return $this->bd->lastInsertId('"' . $this->prefix . 'feed_id_seq"');
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->addFeed($valuesTmp);
			}
			Minz_Log::error('SQL error addFeed: ' . $info[2]);
			return false;
		}
	}

	public function addFeedObject($feed) {
		// TODO: not sure if we should write this method in DAO since DAO
		// should not be aware about feed class

		// Add feed only if we don't find it in DB
		$feed_search = $this->searchByUrl($feed->url());
		if (!$feed_search) {
			$values = array(
				'id' => $feed->id(),
				'url' => $feed->url(),
				'category' => $feed->category(),
				'name' => $feed->name(),
				'website' => $feed->website(),
				'description' => $feed->description(),
				'lastUpdate' => 0,
				'httpAuth' => $feed->httpAuth(),
				'attributes' => $feed->attributes(),
			);

			$id = $this->addFeed($values);
			if ($id) {
				$feed->_id($id);
				$feed->faviconPrepare();
			}

			return $id;
		}

		return $feed_search->id();
	}

	public function updateFeed($id, $valuesTmp) {
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
				$valuesTmp[$key] = json_encode($v);
			}
		}
		$set = substr($set, 0, -2);

		$sql = 'UPDATE `' . $this->prefix . 'feed` SET ' . $set . ' WHERE id=?';
		$stm = $this->bd->prepare($sql);

		foreach ($valuesTmp as $v) {
			$values[] = $v;
		}
		$values[] = $id;

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->updateFeed($id, $valuesTmp);
			}
			Minz_Log::error('SQL error updateFeed: ' . $info[2] . ' for feed ' . $id);
			return false;
		}
	}

	public function updateFeedAttribute($feed, $key, $value) {
		if ($feed instanceof FreshRSS_Feed) {
			$feed->_attributes($key, $value);
			return $this->updateFeed(
					$feed->id(),
					array('attributes' => $feed->attributes())
				);
		}
		return false;
	}

	public function updateLastUpdate($id, $inError = false, $mtime = 0) {	//See also updateCachedValue()
		$sql = 'UPDATE `' . $this->prefix . 'feed` '
		     . 'SET `lastUpdate`=?, error=? '
		     . 'WHERE id=?';
		$values = array(
			$mtime <= 0 ? time() : $mtime,
			$inError ? 1 : 0,
			$id,
		);
		$stm = $this->bd->prepare($sql);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error updateLastUpdate: ' . $info[2]);
			return false;
		}
	}

	public function changeCategory($idOldCat, $idNewCat) {
		$catDAO = new FreshRSS_CategoryDAO();
		$newCat = $catDAO->searchById($idNewCat);
		if (!$newCat) {
			$newCat = $catDAO->getDefault();
		}

		$sql = 'UPDATE `' . $this->prefix . 'feed` SET category=? WHERE category=?';
		$stm = $this->bd->prepare($sql);

		$values = array(
			$newCat->id(),
			$idOldCat
		);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error changeCategory: ' . $info[2]);
			return false;
		}
	}

	public function deleteFeed($id) {
		$sql = 'DELETE FROM `' . $this->prefix . 'feed` WHERE id=?';
		$stm = $this->bd->prepare($sql);

		$values = array($id);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error deleteFeed: ' . $info[2]);
			return false;
		}
	}
	public function deleteFeedByCategory($id) {
		$sql = 'DELETE FROM `' . $this->prefix . 'feed` WHERE category=?';
		$stm = $this->bd->prepare($sql);

		$values = array($id);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error deleteFeedByCategory: ' . $info[2]);
			return false;
		}
	}

	public function searchById($id) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` WHERE id=?';
		$stm = $this->bd->prepare($sql);

		$values = array($id);

		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$feed = self::daoToFeed($res);

		if (isset($feed[$id])) {
			return $feed[$id];
		} else {
			return null;
		}
	}
	public function searchByUrl($url) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` WHERE url=?';
		$stm = $this->bd->prepare($sql);

		$values = array($url);

		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$feed = current(self::daoToFeed($res));

		if (isset($feed) && $feed !== false) {
			return $feed;
		} else {
			return null;
		}
	}

	public function listFeedsIds() {
		$sql = 'SELECT id FROM `' . $this->prefix . 'feed`';
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		return $stm->fetchAll(PDO::FETCH_COLUMN, 0);
	}

	public function listFeeds() {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` ORDER BY name';
		$stm = $this->bd->prepare($sql);
		$stm->execute();

		return self::daoToFeed($stm->fetchAll(PDO::FETCH_ASSOC));
	}

	public function arrayFeedCategoryNames() {	//For API
		$sql = 'SELECT f.id, f.name, c.name as c_name FROM `' . $this->prefix . 'feed` f '
		     . 'INNER JOIN `' . $this->prefix . 'category` c ON c.id = f.category';
		$stm = $this->bd->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);
		$feedCategoryNames = array();
		foreach ($res as $line) {
			$feedCategoryNames[$line['id']] = array(
				'name' => $line['name'],
				'c_name' => $line['c_name'],
			);
		}
		return $feedCategoryNames;
	}

	/**
	 * Use $defaultCacheDuration == -1 to return all feeds, without filtering them by TTL.
	 */
	public function listFeedsOrderUpdate($defaultCacheDuration = 3600, $limit = 0) {
		$this->updateTTL();
		$sql = 'SELECT id, url, name, website, `lastUpdate`, `pathEntries`, `httpAuth`, keep_history, ttl, attributes '
		     . 'FROM `' . $this->prefix . 'feed` '
		     . ($defaultCacheDuration < 0 ? '' : 'WHERE ttl >= ' . FreshRSS_Feed::TTL_DEFAULT
		     . ' AND `lastUpdate` < (' . (time() + 60) . '-(CASE WHEN ttl=' . FreshRSS_Feed::TTL_DEFAULT . ' THEN ' . intval($defaultCacheDuration) . ' ELSE ttl END)) ')
		     . 'ORDER BY `lastUpdate` '
		     . ($limit < 1 ? '' : 'LIMIT ' . intval($limit));
		$stm = $this->bd->prepare($sql);
		if ($stm && $stm->execute()) {
			return self::daoToFeed($stm->fetchAll(PDO::FETCH_ASSOC));
		} else {
			$info = $stm == null ? array(0 => '', 1 => '', 2 => 'syntax error') : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->listFeedsOrderUpdate($defaultCacheDuration);
			}
			Minz_Log::error('SQL error listFeedsOrderUpdate: ' . $info[2]);
			return array();
		}
	}

	public function listByCategory($cat) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` WHERE category=? ORDER BY name';
		$stm = $this->bd->prepare($sql);

		$values = array($cat);

		$stm->execute($values);

		return self::daoToFeed($stm->fetchAll(PDO::FETCH_ASSOC));
	}

	public function countEntries($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'entry` WHERE id_feed=?';
		$stm = $this->bd->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countNotRead($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'entry` WHERE id_feed=? AND is_read=0';
		$stm = $this->bd->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function updateCachedValue($id) {	//For multiple feeds, call updateCachedValues()
		$sql = 'UPDATE `' . $this->prefix . 'feed` '	//2 sub-requests with FOREIGN KEY(e.id_feed), INDEX(e.is_read) faster than 1 request with GROUP BY or CASE
		     . 'SET `cache_nbEntries`=(SELECT COUNT(e1.id) FROM `' . $this->prefix . 'entry` e1 WHERE e1.id_feed=`' . $this->prefix . 'feed`.id),'
		     . '`cache_nbUnreads`=(SELECT COUNT(e2.id) FROM `' . $this->prefix . 'entry` e2 WHERE e2.id_feed=`' . $this->prefix . 'feed`.id AND e2.is_read=0) '
		     . 'WHERE id=?';
		$values = array($id);
		$stm = $this->bd->prepare($sql);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error updateCachedValue: ' . $info[2]);
			return false;
		}
	}

	public function updateCachedValues() {	//For one single feed, call updateCachedValue($id)
		$sql = 'UPDATE `' . $this->prefix . 'feed` '
		     . 'SET `cache_nbEntries`=(SELECT COUNT(e1.id) FROM `' . $this->prefix . 'entry` e1 WHERE e1.id_feed=`' . $this->prefix . 'feed`.id),'
		     . '`cache_nbUnreads`=(SELECT COUNT(e2.id) FROM `' . $this->prefix . 'entry` e2 WHERE e2.id_feed=`' . $this->prefix . 'feed`.id AND e2.is_read=0)';
		$stm = $this->bd->prepare($sql);
		if ($stm && $stm->execute()) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error updateCachedValues: ' . $info[2]);
			return false;
		}
	}

	public function truncate($id) {
		$sql = 'DELETE FROM `' . $this->prefix . 'entry` WHERE id_feed=?';
		$stm = $this->bd->prepare($sql);
		$values = array($id);
		$this->bd->beginTransaction();
		if (!($stm && $stm->execute($values))) {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error truncate: ' . $info[2]);
			$this->bd->rollBack();
			return false;
		}
		$affected = $stm->rowCount();

		$sql = 'UPDATE `' . $this->prefix . 'feed` '
			 . 'SET `cache_nbEntries`=0, `cache_nbUnreads`=0 WHERE id=?';
		$values = array($id);
		$stm = $this->bd->prepare($sql);
		if (!($stm && $stm->execute($values))) {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error truncate: ' . $info[2]);
			$this->bd->rollBack();
			return false;
		}

		$this->bd->commit();
		return $affected;
	}

	public static function daoToFeed($listDAO, $catID = null) {
		$list = array();

		if (!is_array($listDAO)) {
			$listDAO = array($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			if (!isset($dao['name'])) {
				continue;
			}
			if (isset($dao['id'])) {
				$key = $dao['id'];
			}
			if ($catID === null) {
				$category = isset($dao['category']) ? $dao['category'] : 0;
			} else {
				$category = $catID;
			}

			$myFeed = new FreshRSS_Feed(isset($dao['url']) ? $dao['url'] : '', false);
			$myFeed->_category($category);
			$myFeed->_name($dao['name']);
			$myFeed->_website(isset($dao['website']) ? $dao['website'] : '', false);
			$myFeed->_description(isset($dao['description']) ? $dao['description'] : '');
			$myFeed->_lastUpdate(isset($dao['lastUpdate']) ? $dao['lastUpdate'] : 0);
			$myFeed->_priority(isset($dao['priority']) ? $dao['priority'] : 10);
			$myFeed->_pathEntries(isset($dao['pathEntries']) ? $dao['pathEntries'] : '');
			$myFeed->_httpAuth(isset($dao['httpAuth']) ? base64_decode($dao['httpAuth']) : '');
			$myFeed->_error(isset($dao['error']) ? $dao['error'] : 0);
			$myFeed->_keepHistory(isset($dao['keep_history']) ? $dao['keep_history'] : FreshRSS_Feed::KEEP_HISTORY_DEFAULT);
			$myFeed->_ttl(isset($dao['ttl']) ? $dao['ttl'] : FreshRSS_Feed::TTL_DEFAULT);
			$myFeed->_attributes('', isset($dao['attributes']) ? $dao['attributes'] : '');
			$myFeed->_nbNotRead(isset($dao['cache_nbUnreads']) ? $dao['cache_nbUnreads'] : 0);
			$myFeed->_nbEntries(isset($dao['cache_nbEntries']) ? $dao['cache_nbEntries'] : 0);
			if (isset($dao['id'])) {
				$myFeed->_id($dao['id']);
			}
			$list[$key] = $myFeed;
		}

		return $list;
	}

	public function updateTTL() {
		$sql = <<<SQL
UPDATE `{$this->prefix}feed`
   SET ttl = :new_value
 WHERE ttl = :old_value
SQL;
		$stm = $this->bd->prepare($sql);
		if (!($stm && $stm->execute(array(':new_value' => FreshRSS_Feed::TTL_DEFAULT, ':old_value' => -2)))) {
			$sql2 = 'ALTER TABLE `' . $this->prefix . 'feed` ADD COLUMN ttl INT NOT NULL DEFAULT ' . FreshRSS_Feed::TTL_DEFAULT;	//v0.7.3
			$stm = $this->bd->prepare($sql2);
			$stm->execute();
		} else {
			$stm->execute(array(':new_value' => -3600, ':old_value' => -1));
		}
	}
}

<?php

namespace Freshrss\Models;

class FeedDAO extends ModelPdo implements FreshRSS_Searchable {

	protected function addColumn($name) {
		Log::warning(__method__ . ': ' . $name);
		try {
			if ($name === 'attributes') {	//v1.11.0
				return $this->pdo->exec('ALTER TABLE `_feed` ADD COLUMN attributes TEXT') !== false;
			}
		} catch (Exception $e) {
			Log::error(__method__ . ' error: ' . $e->getMessage());
		}
		return false;
	}

	protected function autoUpdateDb($errorInfo) {
		if (isset($errorInfo[0])) {
			if ($errorInfo[0] === DatabaseDAO::ER_BAD_FIELD_ERROR || $errorInfo[0] === FreshRSS_DatabaseDAOPGSQL::UNDEFINED_COLUMN) {
				foreach (['attributes'] as $column) {
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
			INSERT INTO `_feed`
				(
					url,
					category,
					name,
					website,
					description,
					`lastUpdate`,
					priority,
					`pathEntries`,
					`httpAuth`,
					error,
					ttl,
					attributes
				)
				VALUES
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$stm = $this->pdo->prepare($sql);

		$valuesTmp['url'] = safe_ascii($valuesTmp['url']);
		$valuesTmp['website'] = safe_ascii($valuesTmp['website']);
		if (!isset($valuesTmp['pathEntries'])) {
			$valuesTmp['pathEntries'] = '';
		}
		if (!isset($valuesTmp['attributes'])) {
			$valuesTmp['attributes'] = [];
		}

		$values = array(
			substr($valuesTmp['url'], 0, 511),
			$valuesTmp['category'],
			mb_strcut(trim($valuesTmp['name']), 0, DatabaseDAO::LENGTH_INDEX_UNICODE, 'UTF-8'),
			substr($valuesTmp['website'], 0, 255),
			mb_strcut($valuesTmp['description'], 0, 1023, 'UTF-8'),
			$valuesTmp['lastUpdate'],
			isset($valuesTmp['priority']) ? intval($valuesTmp['priority']) : Feed::PRIORITY_MAIN_STREAM,
			mb_strcut($valuesTmp['pathEntries'], 0, 511, 'UTF-8'),
			base64_encode($valuesTmp['httpAuth']),
			isset($valuesTmp['error']) ? intval($valuesTmp['error']) : 0,
			isset($valuesTmp['ttl']) ? intval($valuesTmp['ttl']) : Feed::TTL_DEFAULT,
			is_string($valuesTmp['attributes']) ? $valuesTmp['attributes'] : json_encode($valuesTmp['attributes'], JSON_UNESCAPED_SLASHES),
		);

		if ($stm && $stm->execute($values)) {
			return $this->pdo->lastInsertId('`_feed_id_seq`');
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->addFeed($valuesTmp);
			}
			Log::error('SQL error addFeed: ' . $info[2]);
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
			if ($feed->mute() || (
				Context::$user_conf != null &&	//When creating a new user
				$feed->ttl() != Context::$user_conf->ttl_default)) {
				$values['ttl'] = $feed->ttl() * ($feed->mute() ? -1 : 1);
			}

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
		if (isset($valuesTmp['name'])) {
			$valuesTmp['name'] = mb_strcut(trim($valuesTmp['name']), 0, DatabaseDAO::LENGTH_INDEX_UNICODE, 'UTF-8');
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

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->updateFeed($id, $valuesTmp);
			}
			Log::error('SQL error updateFeed: ' . $info[2] . ' for feed ' . $id);
			return false;
		}
	}

	public function updateFeedAttribute($feed, $key, $value) {
		if ($feed instanceof Feed) {
			$feed->_attributes($key, $value);
			return $this->updateFeed(
					$feed->id(),
					array('attributes' => $feed->attributes())
				);
		}
		return false;
	}

	public function updateLastUpdate($id, $inError = false, $mtime = 0) {	//See also updateCachedValue()
		$sql = 'UPDATE `_feed` '
		     . 'SET `lastUpdate`=?, error=? '
		     . 'WHERE id=?';
		$values = array(
			$mtime <= 0 ? time() : $mtime,
			$inError ? 1 : 0,
			$id,
		);
		$stm = $this->pdo->prepare($sql);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Log::error('SQL error updateLastUpdate: ' . $info[2]);
			return false;
		}
	}

	public function changeCategory($idOldCat, $idNewCat) {
		$catDAO = Factory::createCategoryDao();
		$newCat = $catDAO->searchById($idNewCat);
		if (!$newCat) {
			$newCat = $catDAO->getDefault();
		}

		$sql = 'UPDATE `_feed` SET category=? WHERE category=?';
		$stm = $this->pdo->prepare($sql);

		$values = array(
			$newCat->id(),
			$idOldCat
		);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Log::error('SQL error changeCategory: ' . $info[2]);
			return false;
		}
	}

	public function deleteFeed($id) {
		$sql = 'DELETE FROM `_feed` WHERE id=?';
		$stm = $this->pdo->prepare($sql);

		$values = array($id);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Log::error('SQL error deleteFeed: ' . $info[2]);
			return false;
		}
	}
	public function deleteFeedByCategory($id) {
		$sql = 'DELETE FROM `_feed` WHERE category=?';
		$stm = $this->pdo->prepare($sql);

		$values = array($id);

		if ($stm && $stm->execute($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Log::error('SQL error deleteFeedByCategory: ' . $info[2]);
			return false;
		}
	}

	public function selectAll() {
		$sql = 'SELECT id, url, category, name, website, description, `lastUpdate`, priority, '
		     . '`pathEntries`, `httpAuth`, error, ttl, attributes '
		     . 'FROM `_feed`';
		$stm = $this->pdo->query($sql);
		while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			yield $row;
		}
	}

	public function searchById($id) {
		$sql = 'SELECT * FROM `_feed` WHERE id=?';
		$stm = $this->pdo->prepare($sql);

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
		$sql = 'SELECT * FROM `_feed` WHERE url=?';
		$stm = $this->pdo->prepare($sql);

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
		$sql = 'SELECT id FROM `_feed`';
		$stm = $this->pdo->query($sql);
		return $stm->fetchAll(PDO::FETCH_COLUMN, 0);
	}

	public function listFeeds() {
		$sql = 'SELECT * FROM `_feed` ORDER BY name';
		$stm = $this->pdo->query($sql);
		return self::daoToFeed($stm->fetchAll(PDO::FETCH_ASSOC));
	}

	public function arrayFeedCategoryNames() {	//For API
		$sql = 'SELECT f.id, f.name, c.name as c_name FROM `_feed` f '
		     . 'INNER JOIN `_category` c ON c.id = f.category';
		$stm = $this->pdo->query($sql);
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
		$sql = 'SELECT id, url, name, website, `lastUpdate`, `pathEntries`, `httpAuth`, ttl, attributes '
		     . 'FROM `_feed` '
		     . ($defaultCacheDuration < 0 ? '' : 'WHERE ttl >= ' . Feed::TTL_DEFAULT
		     . ' AND `lastUpdate` < (' . (time() + 60)
			 . '-(CASE WHEN ttl=' . Feed::TTL_DEFAULT . ' THEN ' . intval($defaultCacheDuration) . ' ELSE ttl END)) ')
		     . 'ORDER BY `lastUpdate` '
		     . ($limit < 1 ? '' : 'LIMIT ' . intval($limit));
		$stm = $this->pdo->query($sql);
		if ($stm !== false) {
			return self::daoToFeed($stm->fetchAll(PDO::FETCH_ASSOC));
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			if ($this->autoUpdateDb($info)) {
				return $this->listFeedsOrderUpdate($defaultCacheDuration);
			}
			Log::error('SQL error listFeedsOrderUpdate: ' . $info[2]);
			return array();
		}
	}

	public function listByCategory($cat) {
		$sql = 'SELECT * FROM `_feed` WHERE category=? ORDER BY name';
		$stm = $this->pdo->prepare($sql);

		$values = array($cat);

		$stm->execute($values);

		return self::daoToFeed($stm->fetchAll(PDO::FETCH_ASSOC));
	}

	public function countEntries($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `_entry` WHERE id_feed=?';
		$stm = $this->pdo->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countNotRead($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `_entry` WHERE id_feed=? AND is_read=0';
		$stm = $this->pdo->prepare($sql);
		$values = array($id);
		$stm->execute($values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function updateCachedValues($id = null) {
		//2 sub-requests with FOREIGN KEY(e.id_feed), INDEX(e.is_read) faster than 1 request with GROUP BY or CASE
		$sql = 'UPDATE `_feed` '
		     . 'SET `cache_nbEntries`=(SELECT COUNT(e1.id) FROM `_entry` e1 WHERE e1.id_feed=`_feed`.id),'
		     . '`cache_nbUnreads`=(SELECT COUNT(e2.id) FROM `_entry` e2 WHERE e2.id_feed=`_feed`.id AND e2.is_read=0)'
		     . ($id != null ? ' WHERE id=:id' : '');
		$stm = $this->pdo->prepare($sql);
		if ($id != null) {
			$stm->bindParam(':id', $id, PDO::PARAM_INT);
		}

		if ($stm && $stm->execute()) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Log::error('SQL error updateCachedValue: ' . $info[2]);
			return false;
		}
	}

	public function truncate($id) {
		$sql = 'DELETE FROM `_entry` WHERE id_feed=:id';
		$stm = $this->pdo->prepare($sql);
		$stm->bindParam(':id', $id, PDO::PARAM_INT);
		$this->pdo->beginTransaction();
		if (!($stm && $stm->execute())) {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Log::error('SQL error truncate: ' . $info[2]);
			$this->pdo->rollBack();
			return false;
		}
		$affected = $stm->rowCount();

		$sql = 'UPDATE `_feed` '
			 . 'SET `cache_nbEntries`=0, `cache_nbUnreads`=0 WHERE id=:id';
		$stm = $this->pdo->prepare($sql);
		$stm->bindParam(':id', $id, PDO::PARAM_INT);
		if (!($stm && $stm->execute())) {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Log::error('SQL error truncate: ' . $info[2]);
			$this->pdo->rollBack();
			return false;
		}

		$this->pdo->commit();
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

			$myFeed = new Feed(isset($dao['url']) ? $dao['url'] : '', false);
			$myFeed->_category($category);
			$myFeed->_name($dao['name']);
			$myFeed->_website(isset($dao['website']) ? $dao['website'] : '', false);
			$myFeed->_description(isset($dao['description']) ? $dao['description'] : '');
			$myFeed->_lastUpdate(isset($dao['lastUpdate']) ? $dao['lastUpdate'] : 0);
			$myFeed->_priority(isset($dao['priority']) ? $dao['priority'] : 10);
			$myFeed->_pathEntries(isset($dao['pathEntries']) ? $dao['pathEntries'] : '');
			$myFeed->_httpAuth(isset($dao['httpAuth']) ? base64_decode($dao['httpAuth']) : '');
			$myFeed->_error(isset($dao['error']) ? $dao['error'] : 0);
			$myFeed->_ttl(isset($dao['ttl']) ? $dao['ttl'] : Feed::TTL_DEFAULT);
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
		$sql = 'UPDATE `_feed` SET ttl=:new_value WHERE ttl=:old_value';
		$stm = $this->pdo->prepare($sql);
		if (!($stm && $stm->execute(array(':new_value' => Feed::TTL_DEFAULT, ':old_value' => -2)))) {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
			Log::error('SQL warning updateTTL 1: ' . $info[2] . ' ' . $sql);

			$sql2 = 'ALTER TABLE `_feed` ADD COLUMN ttl INT NOT NULL DEFAULT ' . Feed::TTL_DEFAULT;	//v0.7.3
			$stm = $this->pdo->query($sql2);
			if ($stm === false) {
				$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
				Log::error('SQL error updateTTL 2: ' . $info[2] . ' ' . $sql2);
			}
		} else {
			$stm->execute(array(':new_value' => -3600, ':old_value' => -1));
		}
	}
}

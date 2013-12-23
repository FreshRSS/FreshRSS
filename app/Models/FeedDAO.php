<?php

class FreshRSS_FeedDAO extends Minz_ModelPdo {
	public function addFeed ($valuesTmp) {
		$sql = 'INSERT INTO `' . $this->prefix . 'feed` (url, category, name, website, description, lastUpdate, priority, httpAuth, error, keep_history) VALUES(?, ?, ?, ?, ?, ?, 10, ?, 0, 0)';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			substr($valuesTmp['url'], 0, 511),
			$valuesTmp['category'],
			substr($valuesTmp['name'], 0, 255),
			substr($valuesTmp['website'], 0, 255),
			substr($valuesTmp['description'], 0, 1023),
			$valuesTmp['lastUpdate'],
			base64_encode ($valuesTmp['httpAuth']),
		);

		if ($stm && $stm->execute ($values)) {
			return $this->bd->lastInsertId();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function updateFeed ($id, $valuesTmp) {
		$set = '';
		foreach ($valuesTmp as $key => $v) {
			$set .= $key . '=?, ';

			if ($key == 'httpAuth') {
				$valuesTmp[$key] = base64_encode ($v);
			}
		}
		$set = substr ($set, 0, -2);

		$sql = 'UPDATE `' . $this->prefix . 'feed` SET ' . $set . ' WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		foreach ($valuesTmp as $v) {
			$values[] = $v;
		}
		$values[] = $id;

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function updateLastUpdate ($id, $inError = 0) {
		$sql = 'UPDATE `' . $this->prefix . 'feed` f '	//2 sub-requests with FOREIGN KEY(e.id_feed), INDEX(e.is_read) faster than 1 request with GROUP BY or CASE
		     . 'SET f.cache_nbEntries=(SELECT COUNT(e1.id) FROM `' . $this->prefix . 'entry` e1 WHERE e1.id_feed=f.id),'
		     . 'f.cache_nbUnreads=(SELECT COUNT(e2.id) FROM `' . $this->prefix . 'entry` e2 WHERE e2.id_feed=f.id AND e2.is_read=0),'
		     . 'lastUpdate=?, error=? '
		     . 'WHERE f.id=?';

		$stm = $this->bd->prepare ($sql);

		$values = array (
			time (),
			$inError,
			$id,
		);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function changeCategory ($idOldCat, $idNewCat) {
		$catDAO = new FreshRSS_CategoryDAO ();
		$newCat = $catDAO->searchById ($idNewCat);
		if (!$newCat) {
			$newCat = $catDAO->getDefault ();
		}

		$sql = 'UPDATE `' . $this->prefix . 'feed` SET category=? WHERE category=?';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$newCat->id (),
			$idOldCat
		);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function deleteFeed ($id) {
		/*//For MYISAM (MySQL 5.5-) without FOREIGN KEY
		$sql = 'DELETE FROM `' . $this->prefix . 'entry` WHERE id_feed=?';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		if (!($stm && $stm->execute ($values))) {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}*/

		$sql = 'DELETE FROM `' . $this->prefix . 'feed` WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}
	public function deleteFeedByCategory ($id) {
		/*//For MYISAM (MySQL 5.5-) without FOREIGN KEY
		$sql = 'DELETE FROM `' . $this->prefix . 'entry` e '
		     . 'INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
		     . 'WHERE f.category=?';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		if (!($stm && $stm->execute ($values))) {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}*/

		$sql = 'DELETE FROM `' . $this->prefix . 'feed` WHERE category=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function searchById ($id) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$feed = self::daoToFeed ($res);

		if (isset ($feed[$id])) {
			return $feed[$id];
		} else {
			return false;
		}
	}
	public function searchByUrl ($url) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` WHERE url=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($url);

		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$feed = current (self::daoToFeed ($res));

		if (isset ($feed)) {
			return $feed;
		} else {
			return false;
		}
	}

	public function listFeeds () {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` ORDER BY name';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return self::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function listFeedsOrderUpdate () {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` ORDER BY lastUpdate';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return self::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function listByCategory ($cat) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` WHERE category=? ORDER BY name';
		$stm = $this->bd->prepare ($sql);

		$values = array ($cat);

		$stm->execute ($values);

		return self::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function countEntries ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'entry` WHERE id_feed=?';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
	public function countNotRead ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'entry` WHERE id_feed=? AND is_read=0';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
	public function updateCachedValues () {	//For one single feed, call updateLastUpdate($id)
		$sql = 'UPDATE `' . $this->prefix . 'feed` f '
		     . 'INNER JOIN ('
		     .	'SELECT e.id_feed, '
		     .	'COUNT(CASE WHEN e.is_read = 0 THEN 1 END) AS nbUnreads, '
		     .	'COUNT(e.id) AS nbEntries '
		     .	'FROM `' . $this->prefix . 'entry` e '
		     .	'GROUP BY e.id_feed'
		     . ') x ON x.id_feed=f.id '
		     . 'SET f.cache_nbEntries=x.nbEntries, f.cache_nbUnreads=x.nbUnreads';
		$stm = $this->bd->prepare ($sql);

		$values = array ($feed_id);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function truncate ($id) {
		$sql = 'DELETE e.* FROM `' . $this->prefix . 'entry` e WHERE e.id_feed=?';
		$stm = $this->bd->prepare($sql);
		$values = array($id);
		$this->bd->beginTransaction ();
		if (!($stm && $stm->execute ($values))) {
				$info = $stm->errorInfo();
				Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
				$this->bd->rollBack ();
				return false;
			}
		$affected = $stm->rowCount();

		$sql = 'UPDATE `' . $this->prefix . 'feed` f '
			 . 'SET f.cache_nbEntries=0, f.cache_nbUnreads=0 WHERE f.id=?';
		$values = array ($id);
		$stm = $this->bd->prepare ($sql);
		if (!($stm && $stm->execute ($values))) {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			$this->bd->rollBack ();
			return false;
		}

		$this->bd->commit ();
		return $affected;
	}

	public function cleanOldEntries ($id, $date_min, $keep = 15) {	//Remember to call updateLastUpdate($id) just after
		$sql = 'DELETE e.* FROM `' . $this->prefix . 'entry` e '
		     . 'WHERE e.id_feed = :id_feed AND e.id <= :id_max AND e.is_favorite = 0 AND e.id NOT IN '
		     . '(SELECT id FROM (SELECT e2.id FROM `' . $this->prefix . 'entry` e2 WHERE e2.id_feed = :id_feed ORDER BY id DESC LIMIT :keep) keep)';	//Double select because of: MySQL doesn't yet support 'LIMIT & IN/ALL/ANY/SOME subquery'
		$stm = $this->bd->prepare ($sql);

		$id_max = intval($date_min) . '000000';

		$stm->bindParam(':id_feed', $id, PDO::PARAM_INT);
		$stm->bindParam(':id_max', $id_max, PDO::PARAM_INT);
		$stm->bindParam(':keep', $keep, PDO::PARAM_INT);

		if ($stm && $stm->execute ()) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public static function daoToFeed ($listDAO, $catID = null) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			if (!isset ($dao['name'])) {
				continue;
			}
			if (isset ($dao['id'])) {
				$key = $dao['id'];
			}

			$myFeed = new FreshRSS_Feed (isset($dao['url']) ? $dao['url'] : '', false);
			$myFeed->_category ($catID === null ? $dao['category'] : $catID);
			$myFeed->_name ($dao['name']);
			$myFeed->_website ($dao['website'], false);
			$myFeed->_description (isset($dao['description']) ? $dao['description'] : '');
			$myFeed->_lastUpdate (isset($dao['lastUpdate']) ? $dao['lastUpdate'] : 0);
			$myFeed->_priority ($dao['priority']);
			$myFeed->_pathEntries (isset($dao['pathEntries']) ? $dao['pathEntries'] : '');
			$myFeed->_httpAuth (isset($dao['httpAuth']) ? base64_decode ($dao['httpAuth']) : '');
			$myFeed->_error ($dao['error']);
			$myFeed->_keepHistory (isset($dao['keep_history']) ? $dao['keep_history'] : '');
			$myFeed->_nbNotRead ($dao['cache_nbUnreads']);
			$myFeed->_nbEntries ($dao['cache_nbEntries']);
			if (isset ($dao['id'])) {
				$myFeed->_id ($dao['id']);
			}
			$list[$key] = $myFeed;
		}

		return $list;
	}
}

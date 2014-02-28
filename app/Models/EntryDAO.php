<?php

class FreshRSS_EntryDAO extends Minz_ModelPdo {
	public function addEntry ($valuesTmp) {
		$sql = 'INSERT INTO `' . $this->prefix . 'entry`(id, guid, title, author, content_bin, link, date, is_read, is_favorite, id_feed, tags) '
		     . 'VALUES(?, ?, ?, ?, COMPRESS(?), ?, ?, ?, ?, ?, ?)';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$valuesTmp['id'],
			substr($valuesTmp['guid'], 0, 760),
			substr($valuesTmp['title'], 0, 255),
			substr($valuesTmp['author'], 0, 255),
			$valuesTmp['content'],
			substr($valuesTmp['link'], 0, 1023),
			$valuesTmp['date'],
			$valuesTmp['is_read'] ? 1 : 0,
			$valuesTmp['is_favorite'] ? 1 : 0,
			$valuesTmp['id_feed'],
			substr($valuesTmp['tags'], 0, 1023),
		);

		if ($stm && $stm->execute ($values)) {
			return $this->bd->lastInsertId();
		} else {
			$info = $stm->errorInfo();
			if ((int)($info[0] / 1000) !== 23) {	//Filter out "SQLSTATE Class code 23: Constraint Violation" because of expected duplicate entries
				Minz_Log::record ('SQL error ' . $info[0] . ': ' . $info[1] . ' ' . $info[2]
				. ' while adding entry in feed ' . $valuesTmp['id_feed'] . ' with title: ' . $valuesTmp['title'], Minz_Log::ERROR);
			} /*else {
				Minz_Log::record ('SQL error ' . $info[0] . ': ' . $info[1] . ' ' . $info[2]
				. ' while adding entry in feed ' . $valuesTmp['id_feed'] . ' with title: ' . $valuesTmp['title'], Minz_Log::DEBUG);
			}*/
			return false;
		}
	}

	public function markFavorite ($id, $is_favorite = true) {
		$sql = 'UPDATE `' . $this->prefix . 'entry` e '
		     . 'SET e.is_favorite = ? '
		     . 'WHERE e.id=?';
		$values = array ($is_favorite ? 1 : 0, $id);
		$stm = $this->bd->prepare ($sql);
		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}
	public function markRead ($id, $is_read = true) {
		$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
		     . 'SET e.is_read = ?,'
		     . 'f.cache_nbUnreads=f.cache_nbUnreads' . ($is_read ? '-' : '+') . '1 '
		     . 'WHERE e.id=?';
		$values = array ($is_read ? 1 : 0, $id);
		$stm = $this->bd->prepare ($sql);
		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}
	public function markReadEntries ($idMax = 0, $onlyFavorites = false, $priorityMin = 0) {
		if ($idMax == 0) {
			$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
			     . 'SET e.is_read = 1, f.cache_nbUnreads=0 '
			     . 'WHERE e.is_read = 0';
			if ($onlyFavorites) {
				$sql .= ' AND e.is_favorite = 1';
			} elseif ($priorityMin >= 0) {
				$sql .= ' AND f.priority > ' . intval($priorityMin);
			}
			$stm = $this->bd->prepare ($sql);
			if ($stm && $stm->execute ()) {
				return $stm->rowCount();
			} else {
				$info = $stm->errorInfo();
				Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
				return false;
			}
		} else {
			$this->bd->beginTransaction ();

			$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
			     . 'SET e.is_read = 1 '
			     . 'WHERE e.is_read = 0 AND e.id <= ?';
			if ($onlyFavorites) {
				$sql .= ' AND e.is_favorite = 1';
			} elseif ($priorityMin >= 0) {
				$sql .= ' AND f.priority > ' . intval($priorityMin);
			}
			$values = array ($idMax);
			$stm = $this->bd->prepare ($sql);
			if (!($stm && $stm->execute ($values))) {
				$info = $stm->errorInfo();
				Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
				$this->bd->rollBack ();
				return false;
			}
			$affected = $stm->rowCount();

			if ($affected > 0) {
				$sql = 'UPDATE `' . $this->prefix . 'feed` f '
			     . 'LEFT OUTER JOIN ('
			     .	'SELECT e.id_feed, '
			     .	'COUNT(*) AS nbUnreads '
			     .	'FROM `' . $this->prefix . 'entry` e '
			     .	'WHERE e.is_read = 0 '
			     .	'GROUP BY e.id_feed'
			     . ') x ON x.id_feed=f.id '
			     . 'SET f.cache_nbUnreads=COALESCE(x.nbUnreads, 0)';
				$stm = $this->bd->prepare ($sql);
				if (!($stm && $stm->execute ())) {
					$info = $stm->errorInfo();
					Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
					$this->bd->rollBack ();
					return false;
				}
			}

			$this->bd->commit ();
			return $affected;
		}
	}

	public function markReadCat ($id, $idMax = 0) {
		if ($idMax == 0) {
			$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
			     . 'SET e.is_read = 1, f.cache_nbUnreads=0 '
			     . 'WHERE f.category = ? AND e.is_read = 0';
			$values = array ($id);
			$stm = $this->bd->prepare ($sql);
			if ($stm && $stm->execute ($values)) {
				return $stm->rowCount();
			} else {
				$info = $stm->errorInfo();
				Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
				return false;
			}
		} else {
			$this->bd->beginTransaction ();

			$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
			     . 'SET e.is_read = 1 '
			     . 'WHERE f.category = ? AND e.is_read = 0 AND e.id <= ?';
			$values = array ($id, $idMax);
			$stm = $this->bd->prepare ($sql);
			if (!($stm && $stm->execute ($values))) {
				$info = $stm->errorInfo();
				Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
				$this->bd->rollBack ();
				return false;
			}
			$affected = $stm->rowCount();

			if ($affected > 0) {
				$sql = 'UPDATE `' . $this->prefix . 'feed` f '
			     . 'LEFT OUTER JOIN ('
			     .	'SELECT e.id_feed, '
			     .	'COUNT(*) AS nbUnreads '
			     .	'FROM `' . $this->prefix . 'entry` e '
			     .	'WHERE e.is_read = 0 '
			     .	'GROUP BY e.id_feed'
			     . ') x ON x.id_feed=f.id '
			     . 'SET f.cache_nbUnreads=COALESCE(x.nbUnreads, 0) '
			     . 'WHERE f.category = ?';
				$values = array ($id);
				$stm = $this->bd->prepare ($sql);
				if (!($stm && $stm->execute ($values))) {
					$info = $stm->errorInfo();
					Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
					$this->bd->rollBack ();
					return false;
				}
			}

			$this->bd->commit ();
			return $affected;
		}
	}

	public function markReadCatName($name, $idMax = 0) {
		if ($idMax == 0) {
			$sql = 'UPDATE `' . $this->prefix . 'entry` e '
			     . 'INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
			     . 'INNER JOIN `' . $this->prefix . 'category` c ON c.id = f.category '
			     . 'SET e.is_read = 1, f.cache_nbUnreads=0 '
			     . 'WHERE c.name = ?';
			$values = array($name);
			$stm = $this->bd->prepare($sql);
			if ($stm && $stm->execute($values)) {
				return $stm->rowCount();
			} else {
				$info = $stm->errorInfo();
				Minz_Log::record('SQL error : ' . $info[2], Minz_Log::ERROR);
				return false;
			}
		} else {
			$this->bd->beginTransaction();

			$sql = 'UPDATE `' . $this->prefix . 'entry` e '
			     . 'INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
			     . 'INNER JOIN `' . $this->prefix . 'category` c ON c.id = f.category '
			     . 'SET e.is_read = 1 '
			     . 'WHERE c.name = ? AND e.id <= ?';
			$values = array($name, $idMax);
			$stm = $this->bd->prepare($sql);
			if (!($stm && $stm->execute($values))) {
				$info = $stm->errorInfo();
				Minz_Log::record('SQL error : ' . $info[2], Minz_Log::ERROR);
				$this->bd->rollBack();
				return false;
			}
			$affected = $stm->rowCount();

			if ($affected > 0) {
				$sql = 'UPDATE `' . $this->prefix . 'feed` f '
			     . 'LEFT OUTER JOIN ('
			     .	'SELECT e.id_feed, '
			     .	'COUNT(*) AS nbUnreads '
			     .	'FROM `' . $this->prefix . 'entry` e '
			     .	'WHERE e.is_read = 0 '
			     .	'GROUP BY e.id_feed'
			     . ') x ON x.id_feed=f.id '
			     . 'INNER JOIN `' . $this->prefix . 'category` c ON c.id = f.category '
			     . 'SET f.cache_nbUnreads=COALESCE(x.nbUnreads, 0) '
			     . 'WHERE c.name = ?';
				$values = array($name);
				$stm = $this->bd->prepare($sql);
				if (!($stm && $stm->execute($values))) {
					$info = $stm->errorInfo();
					Minz_Log::record('SQL error : ' . $info[2], Minz_Log::ERROR);
					$this->bd->rollBack();
					return false;
				}
			}

			$this->bd->commit();
			return $affected;
		}
	}

	public function markReadFeed ($id, $idMax = 0) {
		if ($idMax == 0) {
			$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
			     . 'SET e.is_read = 1, f.cache_nbUnreads=0 '
			     . 'WHERE f.id=? AND e.is_read = 0';
			$values = array ($id);
			$stm = $this->bd->prepare ($sql);
			if ($stm && $stm->execute ($values)) {
				return $stm->rowCount();
			} else {
				$info = $stm->errorInfo();
				Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
				return false;
			}
		} else {
			$this->bd->beginTransaction ();

			$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
			     . 'SET e.is_read = 1 '
			     . 'WHERE f.id=? AND e.is_read = 0 AND e.id <= ?';
			$values = array ($id, $idMax);
			$stm = $this->bd->prepare ($sql);
			if (!($stm && $stm->execute ($values))) {
				$info = $stm->errorInfo();
				Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
				$this->bd->rollBack ();
				return false;
			}
			$affected = $stm->rowCount();

			if ($affected > 0) {
				$sql = 'UPDATE `' . $this->prefix . 'feed` f '
				     . 'SET f.cache_nbUnreads=f.cache_nbUnreads-' . $affected
				     . ' WHERE f.id=?';
				$values = array ($id);
				$stm = $this->bd->prepare ($sql);
				if (!($stm && $stm->execute ($values))) {
					$info = $stm->errorInfo();
					Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
					$this->bd->rollBack ();
					return false;
				}
			}

			$this->bd->commit ();
			return $affected;
		}
	}

	public function searchByGuid ($feed_id, $id) {
		// un guid est unique pour un flux donné
		$sql = 'SELECT id, guid, title, author, UNCOMPRESS(content_bin) AS content, link, date, is_read, is_favorite, id_feed, tags '
		     . 'FROM `' . $this->prefix . 'entry` WHERE id_feed=? AND guid=?';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$feed_id,
			$id
		);

		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$entries = self::daoToEntry ($res);
		return isset ($entries[0]) ? $entries[0] : null;
	}

	public function searchById ($id) {
		$sql = 'SELECT id, guid, title, author, UNCOMPRESS(content_bin) AS content, link, date, is_read, is_favorite, id_feed, tags '
		     . 'FROM `' . $this->prefix . 'entry` WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$entries = self::daoToEntry ($res);
		return isset ($entries[0]) ? $entries[0] : null;
	}

	public function listWhere($type = 'a', $id = '', $state = 'all', $order = 'DESC', $limit = 1, $firstId = '', $filter = '', $date_min = 0, $keepHistoryDefault = 0) {
		$where = '';
		$joinFeed = false;
		$values = array();
		switch ($type) {
			case 'a':
				$where .= 'f.priority > 0 ';
				$joinFeed = true;
				break;
			case 's':
				$where .= 'e1.is_favorite = 1 ';
				break;
			case 'c':
				$where .= 'f.category = ? ';
				$values[] = intval($id);
				$joinFeed = true;
				break;
			case 'f':
				$where .= 'e1.id_feed = ? ';
				$values[] = intval($id);
				break;
			case 'A':
				$where .= '1 ';
				break;
			default:
				throw new FreshRSS_EntriesGetter_Exception ('Bad type in Entry->listByType: [' . $type . ']!');
		}
		switch ($state) {
			case 'all':
				break;
			case 'not_read':
				$where .= 'AND e1.is_read = 0 ';
				break;
			case 'read':
				$where .= 'AND e1.is_read = 1 ';
				break;
			case 'favorite':
				$where .= 'AND e1.is_favorite = 1 ';
				break;
			default:
				throw new FreshRSS_EntriesGetter_Exception ('Bad state in Entry->listByType: [' . $state . ']!');
		}
		switch ($order) {
			case 'DESC':
			case 'ASC':
				break;
			default:
				throw new FreshRSS_EntriesGetter_Exception ('Bad order in Entry->listByType: [' . $order . ']!');
		}
		if ($firstId !== '') {
			$where .= 'AND e1.id ' . ($order === 'DESC' ? '<=' : '>=') . $firstId . ' ';
		}
		if (($date_min > 0) && ($type !== 's')) {
			$where .= 'AND (e1.id >= ' . $date_min . '000000 OR e1.is_read = 0 OR e1.is_favorite = 1 OR (f.keep_history <> 0';
			if (intval($keepHistoryDefault) === 0) {
				$where .= ' AND f.keep_history <> -2';	//default
			}
			$where .= ')) ';
			$joinFeed = true;
		}
		$search = '';
		if ($filter !== '') {
			$filter = trim($filter);
			$filter = addcslashes($filter, '\\%_');
			if (stripos($filter, 'intitle:') === 0) {
				$filter = substr($filter, strlen('intitle:'));
				$intitle = true;
			} else {
				$intitle = false;
			}
			if (stripos($filter, 'inurl:') === 0) {
				$filter = substr($filter, strlen('inurl:'));
				$inurl = true;
			} else {
				$inurl = false;
			}
			if (stripos($filter, 'author:') === 0) {
				$filter = substr($filter, strlen('author:'));
				$author = true;
			} else {
				$author = false;
			}
			$terms = array_unique(explode(' ', $filter));
			sort($terms);	//Put #tags first
			foreach ($terms as $word) {
				$word = trim($word);
				if (strlen($word) > 0) {
					if ($intitle) {
						$search .= 'AND e1.title LIKE ? ';
						$values[] = '%' . $word .'%';
					} elseif ($inurl) {
						$search .= 'AND CONCAT(e1.link, e1.guid) LIKE ? ';
						$values[] = '%' . $word .'%';
					} elseif ($author) {
						$search .= 'AND e1.author LIKE ? ';
						$values[] = '%' . $word .'%';
					} else {
						if ($word[0] === '#' && isset($word[1])) {
							$search .= 'AND e1.tags LIKE ? ';
							$values[] = '%' . $word .'%';
						} else {
							$search .= 'AND CONCAT(e1.title, UNCOMPRESS(e1.content_bin)) LIKE ? ';
							$values[] = '%' . $word .'%';
						}
					}
				}
			}
		}

		$sql = 'SELECT e.id, e.guid, e.title, e.author, UNCOMPRESS(e.content_bin) AS content, e.link, e.date, e.is_read, e.is_favorite, e.id_feed, e.tags '
		     . 'FROM `' . $this->prefix . 'entry` e '
		     . 'INNER JOIN (SELECT e1.id FROM `' . $this->prefix . 'entry` e1 '
			     . ($joinFeed ? 'INNER JOIN `' . $this->prefix . 'feed` f ON e1.id_feed = f.id ' : '')
			     . 'WHERE ' . $where
			     . $search
			     . 'ORDER BY e1.id ' . $order
			     . ($limit > 0 ? ' LIMIT ' . $limit : '')	//TODO: See http://explainextended.com/2009/10/23/mysql-order-by-limit-performance-late-row-lookups/
		     . ') e2 ON e2.id = e.id '
		     . 'ORDER BY e.id ' . $order;

		$stm = $this->bd->prepare ($sql);
		$stm->execute ($values);

		return self::daoToEntry ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function listLastGuidsByFeed($id, $n) {
		$sql = 'SELECT guid FROM `' . $this->prefix . 'entry` WHERE id_feed=? ORDER BY id DESC LIMIT ' . intval($n);
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		return $stm->fetchAll (PDO::FETCH_COLUMN, 0);
	}

	public function countUnreadRead () {
		$sql = 'SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id WHERE priority > 0'
		     . ' UNION SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id WHERE priority > 0 AND is_read = 0';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_COLUMN, 0);
		$all = empty($res[0]) ? 0 : $res[0];
		$unread = empty($res[1]) ? 0 : $res[1];
		return array('all' => $all, 'unread' => $unread, 'read' => $all - $unread);
	}
	public function count ($minPriority = null) {
		$sql = 'SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id';
		if ($minPriority !== null) {
			$sql = ' WHERE priority > ' . intval($minPriority);
		}
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_COLUMN, 0);
		return $res[0];
	}
	public function countNotRead ($minPriority = null) {
		$sql = 'SELECT COUNT(e.id) AS count FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id WHERE is_read = 0';
		if ($minPriority !== null) {
			$sql = ' AND priority > ' . intval($minPriority);
		}
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_COLUMN, 0);
		return $res[0];
	}

	public function countUnreadReadFavorites () {
		$sql = 'SELECT COUNT(id) FROM `' . $this->prefix . 'entry` WHERE is_favorite=1'
		     . ' UNION SELECT COUNT(id) FROM `' . $this->prefix . 'entry` WHERE is_favorite=1 AND is_read = 0';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_COLUMN, 0);
		$all = empty($res[0]) ? 0 : $res[0];
		$unread = empty($res[1]) ? 0 : $res[1];
		return array('all' => $all, 'unread' => $unread, 'read' => $all - $unread);
	}

	public function optimizeTable() {
		$sql = 'OPTIMIZE TABLE `' . $this->prefix . 'entry`';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
	}

	public static function daoToEntry ($listDAO) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			$entry = new FreshRSS_Entry (
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
			if (isset ($dao['id'])) {
				$entry->_id ($dao['id']);
			}
			$list[] = $entry;
		}

		unset ($listDAO);

		return $list;
	}
}

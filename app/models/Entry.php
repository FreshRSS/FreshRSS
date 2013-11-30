<?php

class Entry extends Model {

	private $id = 0;
	private $guid;
	private $title;
	private $author;
	private $content;
	private $link;
	private $date;
	private $is_read;
	private $is_favorite;
	private $feed;
	private $tags;

	public function __construct ($feed = '', $guid = '', $title = '', $author = '', $content = '',
	                             $link = '', $pubdate = 0, $is_read = false, $is_favorite = false) {
		$this->_guid ($guid);
		$this->_title ($title);
		$this->_author ($author);
		$this->_content ($content);
		$this->_link ($link);
		$this->_date ($pubdate);
		$this->_isRead ($is_read);
		$this->_isFavorite ($is_favorite);
		$this->_feed ($feed);
		$this->_tags (array ());
	}

	public function id () {
		return $this->id;
	}
	public function guid () {
		return $this->guid;
	}
	public function title () {
		return $this->title;
	}
	public function author () {
		if (is_null ($this->author)) {
			return '';
		} else {
			return $this->author;
		}
	}
	public function content () {
		return $this->content;
	}
	public function link () {
		return $this->link;
	}
	public function date ($raw = false) {
		if ($raw) {
			return $this->date;
		} else {
			return timestamptodate ($this->date);
		}
	}
	public function dateAdded ($raw = false) {
		$date = intval(substr($this->id, 0, -6));
		if ($raw) {
			return $date;
		} else {
			return timestamptodate ($date);
		}
	}
	public function isRead () {
		return $this->is_read;
	}
	public function isFavorite () {
		return $this->is_favorite;
	}
	public function feed ($object = false) {
		if ($object) {
			$feedDAO = new FeedDAO ();
			return $feedDAO->searchById ($this->feed);
		} else {
			return $this->feed;
		}
	}
	public function tags ($inString = false) {
		if ($inString) {
			if (!empty ($this->tags)) {
				return '#' . implode(' #', $this->tags);
			} else {
				return '';
			}
		} else {
			return $this->tags;
		}
	}

	public function _id ($value) {
		$this->id = $value;
	}
	public function _guid ($value) {
		$this->guid = $value;
	}
	public function _title ($value) {
		$this->title = $value;
	}
	public function _author ($value) {
		$this->author = $value;
	}
	public function _content ($value) {
		$this->content = $value;
	}
	public function _link ($value) {
		$this->link = $value;
	}
	public function _date ($value) {
		if (is_int (intval ($value))) {
			$this->date = $value;
		} else {
			$this->date = time ();
		}
	}
	public function _isRead ($value) {
		$this->is_read = $value;
	}
	public function _isFavorite ($value) {
		$this->is_favorite = $value;
	}
	public function _feed ($value) {
		$this->feed = $value;
	}
	public function _tags ($value) {
		if (!is_array ($value)) {
			$value = array ($value);
		}

		foreach ($value as $key => $t) {
			if (!$t) {
				unset ($value[$key]);
			}
		}

		$this->tags = $value;
	}

	public function isDay ($day) {
		$date = $this->dateAdded(true);
		$today = strtotime('today');
		$yesterday = $today - 86400;

		if ($day === Days::TODAY &&
		    $date >= $today && $date < $today + 86400) {
			return true;
		} elseif ($day === Days::YESTERDAY &&
		    $date >= $yesterday && $date < $yesterday + 86400) {
			return true;
		} elseif ($day === Days::BEFORE_YESTERDAY && $date < $yesterday) {
			return true;
		} else {
			return false;
		}
	}

	public function loadCompleteContent($pathEntries) {
		// Gestion du contenu
		// On cherche à récupérer les articles en entier... même si le flux ne le propose pas
		if ($pathEntries) {
			$entryDAO = new EntryDAO();
			$entry = $entryDAO->searchByGuid($this->feed, $this->guid);

			if($entry) {
				// l'article existe déjà en BDD, en se contente de recharger ce contenu
				$this->content = $entry->content();
			} else {
				try {
					// l'article n'est pas en BDD, on va le chercher sur le site
					$this->content = get_content_by_parsing(
						$this->link(), $pathEntries
					);
				} catch (Exception $e) {
					// rien à faire, on garde l'ancien contenu (requête a échoué)
				}
			}
		}
	}

	public function toArray () {
		return array (
			'id' => $this->id (),
			'guid' => $this->guid (),
			'title' => $this->title (),
			'author' => $this->author (),
			'content' => $this->content (),
			'link' => $this->link (),
			'date' => $this->date (true),
			'is_read' => $this->isRead (),
			'is_favorite' => $this->isFavorite (),
			'id_feed' => $this->feed (),
			'tags' => $this->tags (true),
		);
	}
}

class EntryDAO extends Model_pdo {
	public function addEntry ($valuesTmp) {
		$sql = 'INSERT INTO `' . $this->prefix . 'entry`(id, guid, title, author, content_bin, link, date, is_read, is_favorite, id_feed, tags) '
		     . 'VALUES(CAST(? * 1000000 AS SIGNED INTEGER), ?, ?, ?, COMPRESS(?), ?, ?, ?, ?, ?, ?)';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$valuesTmp['id'],
			substr($valuesTmp['guid'], 0, 760),
			substr($valuesTmp['title'], 0, 255),
			substr($valuesTmp['author'], 0, 255),
			$valuesTmp['content'],
			substr($valuesTmp['link'], 0, 1023),
			$valuesTmp['date'],
			$valuesTmp['is_read'],
			$valuesTmp['is_favorite'],
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
	public function markReadEntries ($idMax = 0) {
		if ($idMax === 0) {
			$sql = 'UPDATE `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
			     . 'SET e.is_read = 1, f.cache_nbUnreads=0 '
			     . 'WHERE e.is_read = 0 AND f.priority > 0';
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
			     . 'WHERE e.is_read = 0 AND e.id <= ? AND f.priority > 0';
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
		if ($idMax === 0) {
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
	public function markReadFeed ($id, $idMax = 0) {
		if ($idMax === 0) {
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

	public function cleanOldEntries ($date_min) {
		$sql = 'DELETE e.* FROM `' . $this->prefix . 'entry` e INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
		     . 'WHERE e.id <= ? AND e.is_favorite = 0 AND f.keep_history = 0';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$date_min . '000000'
		);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
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
		list ($entry, $next) = HelperEntry::daoToEntry ($res);

		if (isset ($entry[0])) {
			return $entry[0];
		} else {
			return false;
		}
	}

	public function searchById ($id) {
		$sql = 'SELECT id, guid, title, author, UNCOMPRESS(content_bin) AS content, link, date, is_read, is_favorite, id_feed, tags '
		     . 'FROM `' . $this->prefix . 'entry` WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		list ($entry, $next) = HelperEntry::daoToEntry ($res);

		if (isset ($entry[0])) {
			return $entry[0];
		} else {
			return false;
		}
	}

	private function listWhere ($where, $state, $order, $limitFromId = '', $limitCount = '', $values = array ()) {
		if ($state === 'not_read') {
			$where .= ' AND is_read = 0';
		} elseif ($state === 'read') {
			$where .= ' AND is_read = 1';
		}
		if (!empty($limitFromId)) {
			$where .= ' AND e.id ' . ($order === 'low_to_high' ? '<=' : '>=') . $limitFromId;
		}

		if ($order === 'low_to_high') {
			$order = ' DESC';
		} else {
			$order = '';
		}

		$sql = 'SELECT e.id, e.guid, e.title, e.author, UNCOMPRESS(e.content_bin) AS content, e.link, e.date, e.is_read, e.is_favorite, e.id_feed, e.tags '
		     . 'FROM `' . $this->prefix . 'entry` e '
		     . 'INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id ' . $where
		     . ' ORDER BY e.id' . $order;

		if (empty($limitCount)) {
			$limitCount = 20000;	//TODO: FIXME: Hack temporaire en attendant la recherche côté base-de-données
		}
		//if (!empty($limitCount)) {
			$sql .= ' LIMIT ' . ($limitCount + 2);	//TODO: See http://explainextended.com/2009/10/23/mysql-order-by-limit-performance-late-row-lookups/
		//}

		$stm = $this->bd->prepare ($sql);
		$stm->execute ($values);

		return HelperEntry::daoToEntry ($stm->fetchAll (PDO::FETCH_ASSOC));
	}
	public function listEntries ($state, $order = 'high_to_low', $limitFromId = '', $limitCount = '') {
		return $this->listWhere ('WHERE priority > 0', $state, $order, $limitFromId, $limitCount);
	}
	public function listFavorites ($state, $order = 'high_to_low', $limitFromId = '', $limitCount = '') {
		return $this->listWhere ('WHERE is_favorite = 1', $state, $order, $limitFromId, $limitCount);
	}
	public function listByCategory ($cat, $state, $order = 'high_to_low', $limitFromId = '', $limitCount = '') {
		return $this->listWhere ('WHERE category = ?', $state, $order, $limitFromId, $limitCount, array ($cat));
	}
	public function listByFeed ($feed, $state, $order = 'high_to_low', $limitFromId = '', $limitCount = '') {
		return $this->listWhere ('WHERE id_feed = ?', $state, $order, $limitFromId, $limitCount, array ($feed));
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
}

class HelperEntry {
	public static $nb = 1;
	public static $first = '';

	public static $filter = array (
		'words' => array (),
		'tags' => array (),
	);

	public static function daoToEntry ($listDAO) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		$count = 0;
		$first_is_found = false;
		$break_after = false;
		$next = '';
		foreach ($listDAO as $key => $dao) {
			$dao['tags'] = preg_split('/[\s#]/', $dao['tags']);

			if (self::tagsMatchEntry ($dao) &&
			    self::searchMatchEntry ($dao)) {
				if ($break_after) {
					$next = $dao['id'];
					break;
				}
				if ($first_is_found || $dao['id'] == self::$first || self::$first == '') {
					$list[$key] = self::createEntry ($dao);

					$count++;
					$first_is_found = true;	//TODO: Update: Now done in SQL
				}
				if ($count >= self::$nb) {
					$break_after = true;
				}
			}
		}

		unset ($listDAO);

		return array ($list, $next);
	}

	private static function createEntry ($dao) {
		$entry = new Entry (
			$dao['id_feed'],
			$dao['guid'],
			$dao['title'],
			$dao['author'],
			$dao['content'],
			$dao['link'],
			$dao['date'],
			$dao['is_read'],
			$dao['is_favorite']
		);

		$entry->_tags ($dao['tags']);

		if (isset ($dao['id'])) {
			$entry->_id ($dao['id']);
		}

		return $entry;
	}

	private static function tagsMatchEntry ($dao) {
		$tags = self::$filter['tags'];
		foreach ($tags as $tag) {
			if (!in_array ($tag, $dao['tags'])) {
				return false;
			}
		}

		return true;
	}
	private static function searchMatchEntry ($dao) {
		$words = self::$filter['words'];

		foreach ($words as $word) {
			$word = strtolower ($word);
			if (strpos (strtolower ($dao['title']), $word) === false &&
			    strpos (strtolower ($dao['content']), $word) === false &&
			    strpos (strtolower ($dao['link']), $word) === false) {
				return false;
			}
		}

		return true;
	}
}

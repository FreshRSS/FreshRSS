<?php

class Entry extends Model {

	private $id = null;
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
		if(is_null($this->id)) {
			return small_hash ($this->guid . Configuration::selApplication ());
		} else {
			return $this->id;
		}
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
		$date = getdate ();
		$today = mktime (0, 0, 0, $date['mon'], $date['mday'], $date['year']);
		$yesterday = $today - 86400;

		if ($day == Days::TODAY &&
		    $this->date >= $today && $this->date < $today + 86400) {
			return true;
		} elseif ($day == Days::YESTERDAY &&
		    $this->date >= $yesterday && $this->date < $yesterday + 86400) {
			return true;
		} elseif ($day == Days::BEFORE_YESTERDAY && $this->date < $yesterday) {
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
			'tags' => $this->tags (true)
		);
	}
}

class EntryDAO extends Model_pdo {
	public function addEntry ($valuesTmp) {
		$sql = 'INSERT INTO ' . $this->prefix . 'entry(id, guid, title, author, content, link, date, is_read, is_favorite, id_feed, tags) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$valuesTmp['id'],
			$valuesTmp['guid'],
			$valuesTmp['title'],
			$valuesTmp['author'],
			base64_encode (gzdeflate (serialize ($valuesTmp['content']))),
			$valuesTmp['link'],
			$valuesTmp['date'],
			$valuesTmp['is_read'],
			$valuesTmp['is_favorite'],
			$valuesTmp['id_feed'],
			$valuesTmp['tags'],
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			if ((int)($info[0] / 1000) !== 23) {	//Filter out "SQLSTATE Class code 23: Constraint Violation" because of expected duplicate entries
				Minz_Log::record ('SQL error ' . $info[0] . ': ' . $info[1] . ' ' . $info[2], Minz_Log::NOTICE);	//TODO: Consider adding a Minz_Log::DEBUG level
			}
			return false;
		}
	}

	public function updateEntry ($id, $valuesTmp) {
		if (isset ($valuesTmp['content'])) {
			$valuesTmp['content'] = base64_encode (gzdeflate (serialize ($valuesTmp['content'])));
		}

		$set = '';
		foreach ($valuesTmp as $key => $v) {
			$set .= $key . '=?, ';
		}
		$set = substr ($set, 0, -2);

		$sql = 'UPDATE ' . $this->prefix . 'entry SET ' . $set . ' WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		foreach ($valuesTmp as $v) {
			$values[] = $v;
		}
		$values[] = $id;

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function markReadEntries ($read, $dateMax = 0) {
		$sql = 'UPDATE ' . $this->prefix . 'entry e INNER JOIN ' . $this->prefix . 'feed f ON e.id_feed = f.id SET is_read = ? WHERE priority > 0';

		$values = array ($read);
		if ($dateMax > 0) {
			$sql .= ' AND date < ?';
			$values[] = $dateMax;
		}

		$stm = $this->bd->prepare ($sql);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}
	public function markReadCat ($id, $read, $dateMax = 0) {
		$sql = 'UPDATE ' . $this->prefix . 'entry e INNER JOIN ' . $this->prefix . 'feed f ON e.id_feed = f.id SET is_read = ? WHERE category = ?';

		$values = array ($read, $id);
		if ($dateMax > 0) {
			$sql .= ' AND date < ?';
			$values[] = $dateMax;
		}

		$stm = $this->bd->prepare ($sql);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}
	public function markReadFeed ($id, $read, $dateMax = 0) {
		$sql = 'UPDATE ' . $this->prefix . 'entry SET is_read = ? WHERE id_feed = ?';

		$values = array ($read, $id);
		if ($dateMax > 0) {
			$sql .= ' AND date < ?';
			$values[] = $dateMax;
		}

		$stm = $this->bd->prepare ($sql);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function updateEntries ($valuesTmp) {
		if (isset ($valuesTmp['content'])) {
			$valuesTmp['content'] = base64_encode (gzdeflate (serialize ($valuesTmp['content'])));
		}

		$set = '';
		foreach ($valuesTmp as $key => $v) {
			$set .= $key . '=?, ';
		}
		$set = substr ($set, 0, -2);

		$sql = 'UPDATE ' . $this->prefix . 'entry SET ' . $set;
		$stm = $this->bd->prepare ($sql);

		foreach ($valuesTmp as $v) {
			$values[] = $v;
		}

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function cleanOldEntries ($nb_month) {
		$date = 60 * 60 * 24 * 30 * $nb_month;
		$sql = 'DELETE e.* FROM ' . $this->prefix . 'entry e INNER JOIN ' . $this->prefix . 'feed f ON e.id_feed = f.id WHERE e.date <= ? AND e.is_favorite = 0 AND f.keep_history = 0';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			time () - $date
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function searchByGuid ($feed_id, $id) {
		// un guid est unique pour un flux donné
		$sql = 'SELECT * FROM ' . $this->prefix . 'entry WHERE id_feed=? AND guid=?';
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
		$sql = 'SELECT * FROM ' . $this->prefix . 'entry WHERE id=?';
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
		if ($state == 'not_read') {
			$where .= ' AND is_read = 0';
		} elseif ($state == 'read') {
			$where .= ' AND is_read = 1';
		}
		if (!empty($limitFromId)) {	//TODO: Consider using LPAD(e.date, 11)	//CONCAT is for cases when many entries have the same date
			$where .= ' AND CONCAT(e.date, e.id) ' . ($order === 'low_to_high' ? '<=' : '>=') . ' (SELECT CONCAT(s.date, s.id) FROM ' . $this->prefix . 'entry s WHERE s.id = "' . $limitFromId . '")';
		}

		if ($order == 'low_to_high') {
			$order = ' DESC';
		} else {
			$order = '';
		}

		$sql = 'SELECT e.* FROM ' . $this->prefix . 'entry e'
		     . ' INNER JOIN  ' . $this->prefix . 'feed f ON e.id_feed = f.id' . $where
		     . ' ORDER BY e.date' . $order . ', e.id' . $order;

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
		return $this->listWhere (' WHERE priority > 0', $state, $order, $limitFromId, $limitCount);
	}
	public function listFavorites ($state, $order = 'high_to_low', $limitFromId = '', $limitCount = '') {
		return $this->listWhere (' WHERE is_favorite = 1', $state, $order, $limitFromId, $limitCount);
	}
	public function listPublic ($state, $order = 'high_to_low', $limitFromId = '', $limitCount = '') {
		return $this->listWhere (' WHERE is_public = 1', $state, $order, $limitFromId, $limitCount);
	}
	public function listByCategory ($cat, $state, $order = 'high_to_low', $limitFromId = '', $limitCount = '') {
		return $this->listWhere (' WHERE category = ?', $state, $order, $limitFromId, $limitCount, array ($cat));
	}
	public function listByFeed ($feed, $state, $order = 'high_to_low', $limitFromId = '', $limitCount = '') {
		return $this->listWhere (' WHERE id_feed = ?', $state, $order, $limitFromId, $limitCount, array ($feed));
	}

	public function countUnreadRead () {
		$sql = 'SELECT is_read, COUNT(*) AS count FROM ' . $this->prefix . 'entry e INNER JOIN ' . $this->prefix . 'feed f ON e.id_feed = f.id WHERE priority > 0 GROUP BY is_read';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		$readUnread = array('unread' => 0, 'read' => 0);
		foreach ($res as $line) {
			switch (intval($line['is_read'])) {
				case 0: $readUnread['unread'] = intval($line['count']); break;
				case 1: $readUnread['read'] = intval($line['count']); break;
			}
		}
		return $readUnread;
	}
	public function count () {	//Deprecated: use countUnreadRead() instead
		$unreadRead = $this->countUnreadRead ();	//This makes better use of caching
		return $unreadRead['unread'] + $unreadRead['read'];
	}
	public function countNotRead () {	//Deprecated: use countUnreadRead() instead
		$unreadRead = $this->countUnreadRead ();	//This makes better use of caching
		return $unreadRead['unread'];
	}

	public function countUnreadReadFavorites () {
		$sql = 'SELECT is_read, COUNT(*) AS count FROM ' . $this->prefix . 'entry WHERE is_favorite=1 GROUP BY is_read';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$readUnread = array('unread' => 0, 'read' => 0);
		foreach ($res as $line) {
			switch (intval($line['is_read'])) {
				case 0: $readUnread['unread'] = intval($line['count']); break;
				case 1: $readUnread['read'] = intval($line['count']); break;
			}
		}
		return $readUnread;
	}

	public function countFavorites () {	//Deprecated: use countUnreadReadFavorites() instead
		$unreadRead = $this->countUnreadReadFavorites ();	//This makes better use of caching
		return $unreadRead['unread'] + $unreadRead['read'];
	}

	public function optimizeTable() {
		$sql = 'OPTIMIZE TABLE ' . $this->prefix . 'entry';
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
			$dao['content'] = unserialize (gzinflate (base64_decode ($dao['content'])));
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

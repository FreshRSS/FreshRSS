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
	private $is_public;
	private $feed;
	private $tags;
	private $notes;
	private $lastUpdate;

	public function __construct ($feed = '', $guid = '', $title = '', $author = '', $content = '',
	                             $link = '', $pubdate = 0, $is_read = false, $is_favorite = false,
	                             $is_public = false) {
		$this->_guid ($guid);
		$this->_title ($title);
		$this->_author ($author);
		$this->_content ($content);
		$this->_link ($link);
		$this->_date ($pubdate);
		$this->_isRead ($is_read);
		$this->_isFavorite ($is_favorite);
		$this->_isPublic ($is_public);
		$this->_feed ($feed);
		$this->_lastUpdate ($pubdate);
		$this->_notes ('');
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
	public function isPublic () {
		return $this->is_public;
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
	public function notes ($raw = true, $parse_tags = true) {
		if ($raw) {
			return $this->notes;
		} else {
			if($parse_tags) {
				return parse_tags (bbdecode ($this->notes));
			} else {
				return bbdecode ($this->notes);
			}
		}
	}
	public function lastUpdate ($raw = false) {
		if ($raw) {
			return $this->lastUpdate;
		} else {
			return timestamptodate ($this->lastUpdate);
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
	public function _isPublic ($value) {
		$this->is_public = $value;
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
	public function _notes ($value) {
		$this->notes = $value;
	}
	public function _lastUpdate ($value) {
		if (is_int (intval ($value))) {
			$this->lastUpdate = $value;
		} else {
			$this->lastUpdate = $this->date (true);
		}
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
			'is_public' => $this->isPublic (),
			'id_feed' => $this->feed (),
			'lastUpdate' => $this->lastUpdate (true),
			'tags' => $this->tags (true),
			'annotation' => $this->notes ()
		);
	}
}

class EntryDAO extends Model_pdo {
	public function addEntry ($valuesTmp) {
		$sql = 'INSERT INTO entry(id, guid, title, author, content, link, date, is_read, is_favorite, is_public, id_feed, lastUpdate, tags) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
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
			$valuesTmp['is_public'],
			$valuesTmp['id_feed'],
			$valuesTmp['lastUpdate'],
			$valuesTmp['tags'],
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Log::record ('SQL error : ' . $info[2], Log::NOTICE);
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

		$sql = 'UPDATE entry SET ' . $set . ' WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		foreach ($valuesTmp as $v) {
			$values[] = $v;
		}
		$values[] = $id;

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Log::record ('SQL error : ' . $info[2], Log::ERROR);
			return false;
		}
	}

	public function markReadEntries ($read, $dateMax) {
		$sql = 'UPDATE entry e INNER JOIN feed f ON e.id_feed = f.id SET is_read = ? WHERE date < ? AND priority > 0';
		$stm = $this->bd->prepare ($sql);

		$values = array ($read, $dateMax);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Log::record ('SQL error : ' . $info[2], Log::ERROR);
			return false;
		}
	}
	public function markReadCat ($id, $read, $dateMax) {
		$sql = 'UPDATE entry e INNER JOIN feed f ON e.id_feed = f.id SET is_read = ? WHERE category = ? AND date < ?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($read, $id, $dateMax);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Log::record ('SQL error : ' . $info[2], Log::ERROR);
			return false;
		}
	}
	public function markReadFeed ($id, $read, $dateMax) {
		$sql = 'UPDATE entry SET is_read = ? WHERE id_feed = ? AND date < ?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($read, $id, $dateMax);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Log::record ('SQL error : ' . $info[2], Log::ERROR);
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

		$sql = 'UPDATE entry SET ' . $set;
		$stm = $this->bd->prepare ($sql);

		foreach ($valuesTmp as $v) {
			$values[] = $v;
		}

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Log::record ('SQL error : ' . $info[2], Log::ERROR);
			return false;
		}
	}

	public function cleanOldEntries ($nb_month) {
		$date = 60 * 60 * 24 * 30 * $nb_month;
		$sql = 'DELETE FROM entry WHERE date <= ? AND is_favorite = 0 AND annotation = ""';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			time () - $date
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Log::record ('SQL error : ' . $info[2], Log::ERROR);
			return false;
		}
	}

	public function searchByGuid ($feed_id, $id) {
		// un guid est unique pour un flux donné
		$sql = 'SELECT * FROM entry WHERE id_feed=? AND guid=?';
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
		$sql = 'SELECT * FROM entry WHERE id=?';
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

	public function listWhere ($where, $state, $order, $values = array ()) {
		if ($state == 'not_read') {
			$where .= ' AND is_read = 0';
		} elseif ($state == 'read') {
			$where .= ' AND is_read = 1';
		}

		if ($order == 'low_to_high') {
			$order = ' DESC';
		} else {
			$order = '';
		}

		$sql = 'SELECT e.* FROM entry e'
		     . ' INNER JOIN feed f ON e.id_feed = f.id' . $where
		     . ' ORDER BY date' . $order;
		$stm = $this->bd->prepare ($sql);
		$stm->execute ($values);

		return HelperEntry::daoToEntry ($stm->fetchAll (PDO::FETCH_ASSOC));
	}
	public function listEntries ($state, $order = 'high_to_low') {
		return $this->listWhere (' WHERE priority > 0', $state, $order);
	}
	public function listFavorites ($state, $order = 'high_to_low') {
		return $this->listWhere (' WHERE is_favorite = 1', $state, $order);
	}
	public function listPublic ($state, $order = 'high_to_low') {
		return $this->listWhere (' WHERE is_public = 1', $state, $order);
	}
	public function listByCategory ($cat, $state, $order = 'high_to_low') {
		return $this->listWhere (' WHERE category = ?', $state, $order, array ($cat));
	}
	public function listByFeed ($feed, $state, $order = 'high_to_low') {
		return $this->listWhere (' WHERE id_feed = ?', $state, $order, array ($feed));
	}

	public function count () {
		$sql = 'SELECT COUNT(*) AS count FROM entry e INNER JOIN feed f ON e.id_feed = f.id WHERE priority > 0';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
	public function countNotRead () {
		$sql = 'SELECT COUNT(*) AS count FROM entry e INNER JOIN feed f ON e.id_feed = f.id WHERE is_read=0 AND priority > 0';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countNotReadByFeed ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM entry WHERE is_read = 0 AND id_feed = ?';
		$stm = $this->bd->prepare ($sql);
		$stm->execute (array ($id));
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countNotReadByCat ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM entry e INNER JOIN feed f ON e.id_feed = f.id WHERE is_read=0 AND category = ?';
		$stm = $this->bd->prepare ($sql);
		$stm->execute (array ($id));
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countNotReadFavorites () {
		$sql = 'SELECT COUNT(*) AS count FROM entry WHERE is_read=0 AND is_favorite=1';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
	public function countFavorites () {
		$sql = 'SELECT COUNT(*) AS count FROM entry WHERE is_favorite=1';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function optimizeTable() {
		$sql = 'OPTIMIZE TABLE entry';
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
					$first_is_found = true;
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
			$dao['is_favorite'],
			$dao['is_public']
		);

		$entry->_notes ($dao['annotation']);
		$entry->_lastUpdate ($dao['lastUpdate']);
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
			    strpos (strtolower ($dao['link']), $word) === false &&
			    strpos (strtolower ($dao['annotation']), $word) === false) {
				return false;
			}
		}

		return true;
	}
}

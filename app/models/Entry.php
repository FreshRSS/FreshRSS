<?php

class Entry extends Model {
	private $guid;
	private $title;
	private $author;
	private $content;
	private $link;
	private $date;
	private $is_read;
	private $is_favorite;
	private $feed;
	
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
	}
	
	public function id () {
		return small_hash ($this->guid . Configuration::selApplication ());
	}
	public function guid () {
		return $this->guid;
	}
	public function title () {
		return $this->title;
	}
	public function author () {
		return $this->author;
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
		$this->date = $value;
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
}

class EntryDAO extends Model_pdo {
	public function addEntry ($valuesTmp) {
		$sql = 'INSERT INTO entry (id, guid, title, author, content, link, date, is_read, is_favorite, id_feed) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$valuesTmp['id'],
			$valuesTmp['guid'],
			$valuesTmp['title'],
			$valuesTmp['author'],
			$valuesTmp['content'],
			$valuesTmp['link'],
			$valuesTmp['date'],
			$valuesTmp['is_read'],
			$valuesTmp['is_favorite'],
			$valuesTmp['id_feed'],
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateEntry ($id, $valuesTmp) {
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
			return false;
		}
	}
	
	public function updateEntries ($valuesTmp) {
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
			return false;
		}
	}
	
	public function cleanOldEntries ($nb_month) {
		$date = 60 * 60 * 24 * 30 * $nb_month;
		$sql = 'DELETE FROM entry WHERE date <= ? AND is_favorite = 0';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			time () - $date
		);
		
		if ($stm && $stm->execute ($values)) {
			return true;
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
		$entry = HelperEntry::daoToEntry ($res);
		
		if (isset ($entry[0])) {
			return $entry[0];
		} else {
			return false;
		}
	}
	
	public function listEntries ($mode, $order = 'high_to_low') {
		$where = '';
		if ($mode == 'not_read') {
			$where = ' WHERE is_read=0';
		}
		
		if ($order == 'low_to_high') {
			$order = ' DESC';
		} else {
			$order = '';
		}
		
		$sql = 'SELECT * FROM entry' . $where . ' ORDER BY date' . $order;
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return HelperEntry::daoToEntry ($stm->fetchAll (PDO::FETCH_ASSOC));
	}
	
	public function listFavorites ($mode, $order = 'high_to_low') {
		$where = ' WHERE is_favorite=1';
		if ($mode == 'not_read') {
			$where .= ' AND is_read=0';
		}
		
		if ($order == 'low_to_high') {
			$order = ' DESC';
		} else {
			$order = '';
		}
		
		$sql = 'SELECT * FROM entry' . $where . ' ORDER BY date' . $order;
		$stm = $this->bd->prepare ($sql);
		
		$stm->execute ();

		return HelperEntry::daoToEntry ($stm->fetchAll (PDO::FETCH_ASSOC));
	}
	
	public function listByCategory ($cat, $mode, $order = 'high_to_low') {
		$where = ' WHERE category=?';
		if ($mode == 'not_read') {
			$where .= ' AND is_read=0';
		}
		
		if ($order == 'low_to_high') {
			$order = ' DESC';
		} else {
			$order = '';
		}
		
		$sql = 'SELECT * FROM entry e INNER JOIN feed f ON e.id_feed = f.id' . $where . ' ORDER BY date' . $order;
		
		$stm = $this->bd->prepare ($sql);
		
		$values = array ($cat);
		
		$stm->execute ($values);

		return HelperEntry::daoToEntry ($stm->fetchAll (PDO::FETCH_ASSOC));
	}
	
	public function count () {
		$sql = 'SELECT COUNT(*) AS count FROM entry';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
	
	public function countNotRead () {
		$sql = 'SELECT COUNT(*) AS count FROM entry WHERE is_read=0';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		
		return $res[0]['count'];
	}
}

class HelperEntry {
	public static function daoToEntry ($listDAO, $mode = 'all', $favorite = false) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			if (($mode != 'not_read' || !$dao['is_read'])
			 && ($favorite == false || $dao['is_favorite'])) {
				$list[$key] = new Entry (
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
			}
		}

		return $list;
	}
}

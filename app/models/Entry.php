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
			base64_encode (gzdeflate (serialize ($valuesTmp['content']))),
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

		$sql = 'SELECT COUNT(*) AS count FROM entry' . $where;
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$this->nbItems = $res[0]['count'];

		$deb = ($this->currentPage - 1) * $this->nbItemsPerPage;
		$fin = $this->nbItemsPerPage;

		$sql = 'SELECT * FROM entry' . $where
		     . ' ORDER BY date' . $order
		     . ' LIMIT ' . $deb . ', ' . $fin;
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

		$sql = 'SELECT COUNT(*) AS count FROM entry' . $where;
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$this->nbItems = $res[0]['count'];

		if($this->nbItemsPerPage < 0) {
			$sql = 'SELECT * FROM entry' . $where
			     . ' ORDER BY date' . $order;
		} else {
			$deb = ($this->currentPage - 1) * $this->nbItemsPerPage;
			$fin = $this->nbItemsPerPage;

			$sql = 'SELECT * FROM entry' . $where
			     . ' ORDER BY date' . $order
			     . ' LIMIT ' . $deb . ', ' . $fin;
		}
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

		$sql = 'SELECT COUNT(*) AS count FROM entry e INNER JOIN feed f ON e.id_feed = f.id' . $where;
		$stm = $this->bd->prepare ($sql);
		$values = array ($cat);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$this->nbItems = $res[0]['count'];

		$deb = ($this->currentPage - 1) * $this->nbItemsPerPage;
		$fin = $this->nbItemsPerPage;
		$sql = 'SELECT e.* FROM entry e INNER JOIN feed f ON e.id_feed = f.id' . $where
		     . ' ORDER BY date' . $order
		     . ' LIMIT ' . $deb . ', ' . $fin;

		$stm = $this->bd->prepare ($sql);

		$values = array ($cat);

		$stm->execute ($values);

		return HelperEntry::daoToEntry ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function listByFeed ($feed, $mode, $order = 'high_to_low') {
		$where = ' WHERE id_feed=?';
		if ($mode == 'not_read') {
			$where .= ' AND is_read=0';
		}

		if ($order == 'low_to_high') {
			$order = ' DESC';
		} else {
			$order = '';
		}

		$sql = 'SELECT COUNT(*) AS count FROM entry' . $where;
		$stm = $this->bd->prepare ($sql);
		$values = array ($feed);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$this->nbItems = $res[0]['count'];

		$deb = ($this->currentPage - 1) * $this->nbItemsPerPage;
		$fin = $this->nbItemsPerPage;
		$sql = 'SELECT * FROM entry e' . $where
		     . ' ORDER BY date' . $order
		     . ' LIMIT ' . $deb . ', ' . $fin;

		$stm = $this->bd->prepare ($sql);

		$values = array ($feed);

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

	public function countFavorites () {
		$sql = 'SELECT COUNT(*) AS count FROM entry WHERE is_favorite=1';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	// gestion de la pagination directement via le DAO
	private $nbItemsPerPage = 1;
	private $currentPage = 1;
	private $nbItems = 0;
	public function _nbItemsPerPage ($value) {
		$this->nbItemsPerPage = $value;
	}
	public function _currentPage ($value) {
		$this->currentPage = $value;
	}

	public function getPaginator ($entries) {
		$paginator = new Paginator ($entries);
		$paginator->_nbItems ($this->nbItems);
		$paginator->_nbItemsPerPage ($this->nbItemsPerPage);
		$paginator->_currentPage ($this->currentPage);

		return $paginator;
	}
}

class HelperEntry {
	public static function daoToEntry ($listDAO, $mode = 'all', $favorite = false) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			$list[$key] = new Entry (
				$dao['id_feed'],
				$dao['guid'],
				$dao['title'],
				$dao['author'],
				unserialize (gzinflate (base64_decode ($dao['content']))),
				$dao['link'],
				$dao['date'],
				$dao['is_read'],
				$dao['is_favorite']
			);

			if (isset ($dao['id'])) {
				$list[$key]->_id ($dao['id']);
			}
		}

		return $list;
	}
}

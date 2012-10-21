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
	
	public function __construct ($guid = '', $title = '', $author = '', $content = '',
	                             $link = '', $pubdate = 0, $is_read = false, $is_favorite = false) {
		$this->_guid ($guid);
		$this->_title ($title);
		$this->_author ($author);
		$this->_content ($content);
		$this->_link ($link);
		$this->_date ($pubdate);
		$this->_isRead ($is_read);
		$this->_isFavorite ($is_favorite);
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
}

class EntryDAO extends Model_array {
	public function __construct () {
		parent::__construct (PUBLIC_PATH . '/data/db/Entries.array.php');
	}
	
	public function addEntry ($values) {
		$id = $values['id'];
		unset ($values['id']);
	
		if (!isset ($this->array[$id])) {
			$this->array[$id] = array ();
		
			foreach ($values as $key => $value) {
				$this->array[$id][$key] = $value;
			}
		
			$this->writeFile ($this->array);
		} else {
			return false;
		}
	}
	
	public function updateEntry ($id, $values) {
		foreach ($values as $key => $value) {
			$this->array[$id][$key] = $value;
		}
		
		$this->writeFile($this->array);
	}
	
	public function searchById ($id) {
		$list = HelperEntry::daoToEntry ($this->array);
		
		if (isset ($list[$id])) {
			return $list[$id];
		} else {
			return false;
		}
	}
	
	public function listEntries () {
		$list = $this->array;
		
		if (!is_array ($list)) {
			$list = array ();
		}
		
		return HelperEntry::daoToEntry ($list);
	}
	
	public function listNotReadEntries () {
		$list = $this->array;
		$list_not_read = array ();
		
		if (!is_array ($list)) {
			$list = array ();
		}
		
		foreach ($list as $key => $entry) {
			if (!$entry['is_read']) {
				$list_not_read[$key] = $entry;
			}
		}
		
		return HelperEntry::daoToEntry ($list_not_read);
	}
	
	public function count () {
		return count ($this->array);
	}
}

class HelperEntry {
	public static function daoToEntry ($listDAO) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			$list[$key] = new Entry (
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

		return $list;
	}
}

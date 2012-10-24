<?php

class Feed extends Model {
	private $url;
	private $category = '';
	private $entries = null;
	private $name = '';
	private $website = '';
	private $description = '';
	
	public function __construct ($url) {
		$this->_url ($url);
	}
	
	public function id () {
		return small_hash ($this->url . Configuration::selApplication ());
	}
	public function url () {
		return $this->url;
	}
	public function category () {
		return $this->category;
	}
	public function entries () {
		if (!is_null ($this->entries)) {
			return $this->entries;
		} else {
			return array ();
		}
	}
	public function name () {
		return $this->name;
	}
	public function website () {
		return $this->website;
	}
	public function description () {
		return $this->description;
	}
	
	public function _url ($value) {
		if (!is_null ($value) && filter_var ($value, FILTER_VALIDATE_URL)) {
			$this->url = $value;
		} else {
			throw new Exception ();
		}
	}
	public function _category ($value) {
		$this->category = $value;
	}
	public function _name ($value) {
		$this->name = $value;
	}
	public function _website ($value) {
		$this->website = $value;
	}
	public function _description ($value) {
		$this->description = $value;
	}
	
	public function load () {
		if (!is_null ($this->url)) {
			$feed = new SimplePie ();
			$feed->set_feed_url ($this->url);
			$feed->set_cache_location (CACHE_PATH);
			$feed->init ();
			
			$title = $feed->get_title ();
			$this->loadEntries ($feed);
			$this->_name (!is_null ($title) ? $title : $this->url);
			$this->_website ($feed->get_link ());
			$this->_description ($feed->get_description ());
		}
	}
	private function loadEntries ($feed) {
		$entries = array ();
			
		foreach ($feed->get_items () as $item) {
			$title = $item->get_title ();
			$author = $item->get_author ();
			$content = $item->get_content ();
			$link = $item->get_permalink ();
			$date = strtotime ($item->get_date ());
	
			$entry = new Entry (
				$this->id (),
				$item->get_id (),
				!is_null ($title) ? $title : '',
				!is_null ($author) ? $author->name : '',
				!is_null ($content) ? $content : '',
				!is_null ($link) ? $link : '',
				$date ? $date : time ()
			);
		
			$entries[$entry->id ()] = $entry;
		}
	
		$this->entries = $entries;
	}
}

class FeedDAO extends Model_pdo {
	public function addFeed ($valuesTmp) {
		$sql = 'INSERT INTO feed (id, url, category, name, website, description) VALUES(?, ?, ?, ?, ?, ?)';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$valuesTmp['id'],
			$valuesTmp['url'],
			$valuesTmp['category'],
			$valuesTmp['name'],
			$valuesTmp['website'],
			$valuesTmp['description'],
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function updateFeed ($id, $valuesTmp) {
		$set = '';
		foreach ($valuesTmp as $key => $v) {
			$set .= $key . '=?, ';
		}
		$set = substr ($set, 0, -2);
		
		$sql = 'UPDATE feed SET ' . $set . ' WHERE id=?';
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
	
	public function searchById ($id) {
		$sql = 'SELECT * FROM feed WHERE id=?';
		$stm = $this->bd->prepare ($sql);
		
		$values = array ($id);
		
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$feed = HelperFeed::daoToFeed ($res);
		
		if (isset ($feed[0])) {
			return $feed[0];
		} else {
			return false;
		}
	}
	
	public function listFeeds () {
		$sql = 'SELECT * FROM feed';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}
	
	public function listByCategory ($cat) {
		$sql = 'SELECT * FROM feed WHERE category=?';
		$stm = $this->bd->prepare ($sql);
		
		$values = array ($cat);
		
		$stm->execute ($values);

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}
	
	public function count () {
		$sql = 'SELECT COUNT(*) AS count FROM feed';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
}

class HelperFeed {
	public static function daoToFeed ($listDAO) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			$list[$key] = new Feed ($dao['url']);
			$list[$key]->_category ($dao['category']);
			$list[$key]->_name ($dao['name']);
			$list[$key]->_website ($dao['website']);
			$list[$key]->_description ($dao['description']);
		}

		return $list;
	}
}

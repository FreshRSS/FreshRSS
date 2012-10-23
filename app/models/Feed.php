<?php

class Feed extends Model {
	private $url;
	private $category = '';
	private $entries_list = array ();
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
	public function entries ($list = true) {
		if ($list) {
			return $this->entries_list;
		} elseif (!is_null ($this->entries)) {
			return $this->entries;
		} else {
			return false;
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
	public function _entries ($value) {
		if (!is_array ($value)) {
			$value = array ($value);
		}
		
		$this->entries_list = $value;
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

class FeedDAO extends Model_array {
	public function __construct () {
		parent::__construct (PUBLIC_PATH . '/data/db/Feeds.array.php');
	}
	
	public function addFeed ($values) {
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
	
	public function updateFeed ($id, $values) {
		foreach ($values as $key => $value) {
			$this->array[$id][$key] = $value;
		}
		
		$this->writeFile($this->array);
	}
	
	public function searchById ($id) {
		$list = HelperFeed::daoToFeed ($this->array);
		
		if (isset ($list[$id])) {
			return $list[$id];
		} else {
			return false;
		}
	}
	
	public function listFeeds () {
		$list = $this->array;
		
		if (!is_array ($list)) {
			$list = array ();
		}
		
		return HelperFeed::daoToFeed ($list);
	}
	
	public function listByCategory ($cat) {
		$list = array ();
		
		foreach ($this->array as $key => $feed) {
			if ($feed['category'] == $cat) {
				$list[$key] = $feed;
			}
		}
		
		return HelperFeed::daoToFeed ($list);
	}
	
	public function count () {
		return count ($this->array);
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
			$list[$key]->_entries ($dao['entries']);
			$list[$key]->_name ($dao['name']);
			$list[$key]->_website ($dao['website']);
			$list[$key]->_description ($dao['description']);
		}

		return $list;
	}
}

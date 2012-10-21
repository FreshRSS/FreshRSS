<?php

class Feed extends Model {
	private $url;
	private $categories;
	private $entries_list;
	
	public function __construct ($url = null) {
		$this->_url ($url);
		$this->_categories (array ());
		$this->_entries (array ());
	}
	
	public function id () {
		return small_hash ($this->url . Configuration::selApplication ());
	}
	public function url () {
		return $this->url;
	}
	public function categories () {
		return $this->categories;
	}
	public function entries () {
		return $this->entries_list;
	}
	
	public function _url ($value) {
		if (!is_null ($value) && filter_var ($value, FILTER_VALIDATE_URL)) {
			$this->url = $value;
		} else {
			throw new Exception ();
		}
	}
	public function _categories ($value) {
		if (!is_array ($value)) {
			$value = array ($value);
		}
		
		$this->categories = $value;
	}
	public function _entries ($value) {
		if (!is_array ($value)) {
			$value = array ($value);
		}
		
		$this->entries_list = $value;
	}
	
	public function loadEntries () {
		if (!is_null ($this->url)) {
			$feed = new SimplePie ();
			$feed->set_feed_url ($this->url);
			$feed->set_cache_location (CACHE_PATH);
			$feed->init ();
			
			$entries = array ();
    			if ($feed->data) {
    				foreach ($feed->get_items () as $item) {
    					$title = $item->get_title ();
    					$author = $item->get_author ();
    					$content = $item->get_content ();
    					$link = $item->get_permalink ();
    					$date = strtotime ($item->get_date ());
    				
    					$entry = new Entry (
    						$item->get_id (),
    						!is_null ($title) ? $title : '',
    						!is_null ($author) ? $author->name : '',
    						!is_null ($content) ? $content : '',
    						!is_null ($link) ? $link : '',
    						$date ? $date : time ()
    					);
    					
    					$entries[$entry->id ()] = $entry;
        			}
				
				return $entries;
			} else {
				return false;
			}
		} else {
			return false;
		}
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
	
	public function listFeeds () {
		$list = $this->array;
		
		if (!is_array ($list)) {
			$list = array ();
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
			$list[$key]->_categories ($dao['categories']);
			$list[$key]->_entries ($dao['entries']);
		}

		return $list;
	}
}

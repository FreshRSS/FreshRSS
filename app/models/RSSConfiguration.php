<?php

class RSSConfiguration extends Model {
	private $posts_per_page;
	private $default_view;
	private $display_posts;
	private $sort_order;
	
	public function __construct () {
		$confDAO = new RSSConfigurationDAO ();
		$this->_postsPerPage ($confDAO->posts_per_page);
		$this->_defaultView ($confDAO->default_view);
		$this->_displayPosts ($confDAO->display_posts);
		$this->_sortOrder ($confDAO->sort_order);
	}
	
	public function postsPerPage () {
		return $this->posts_per_page;
	}
	public function defaultView () {
		return $this->default_view;
	}
	public function displayPosts () {
		return $this->display_posts;
	}
	public function sortOrder () {
		return $this->sort_order;
	}
	
	public function _postsPerPage ($value) {
		if (is_int ($value)) {
			$this->posts_per_page = $value;
		} else {
			$this->posts_per_page = 10;
		}
	}
	public function _defaultView ($value) {
		if ($value == 'not_read') {
			$this->default_view = 'not_read';
		} else {
			$this->default_view = 'all';
		}
	}
	public function _displayPosts ($value) {
		if ($value == 'yes') {
			$this->display_posts = 'yes';
		} else {
			$this->display_posts = 'no';
		}
	}
	public function _sortOrder ($value) {
		if ($value == 'high_to_low') {
			$this->sort_order = 'high_to_low';
		} else {
			$this->sort_order = 'low_to_high';
		}
	}
}

class RSSConfigurationDAO extends Model_array {
	public $posts_per_page = 10;
	public $default_view = 'all';
	public $display_posts = 'no';
	public $sort_order = 'low_to_high';

	public function __construct () {
		parent::__construct (PUBLIC_PATH . '/data/db/Configuration.array.php');
		
		if (isset ($this->array['posts_per_page'])) {
			$this->posts_per_page = $this->array['posts_per_page'];
		}
		if (isset ($this->array['default_view'])) {
			$this->default_view = $this->array['default_view'];
		}
		if (isset ($this->array['display_posts'])) {
			$this->display_posts = $this->array['display_posts'];
		}
		if (isset ($this->array['sort_order'])) {
			$this->sort_order = $this->array['sort_order'];
		}
	}
	
	public function save ($values) {
		$this->array[0] = array ();
	
		foreach ($values as $key => $value) {
			$this->array[0][$key] = $value;
		}
	
		$this->writeFile($this->array);
	}
}

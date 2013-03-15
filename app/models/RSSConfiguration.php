<?php

class RSSConfiguration extends Model {
	private $posts_per_page;
	private $default_view;
	private $display_posts;
	private $sort_order;
	private $old_entries;
	private $shortcuts = array ();
	private $mail_login = '';
	
	public function __construct () {
		$confDAO = new RSSConfigurationDAO ();
		$this->_postsPerPage ($confDAO->posts_per_page);
		$this->_defaultView ($confDAO->default_view);
		$this->_displayPosts ($confDAO->display_posts);
		$this->_sortOrder ($confDAO->sort_order);
		$this->_oldEntries ($confDAO->old_entries);
		$this->_shortcuts ($confDAO->shortcuts);
		$this->_mailLogin ($confDAO->mail_login);
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
	public function oldEntries () {
		return $this->old_entries;
	}
	public function shortcuts () {
		return $this->shortcuts;
	}
	public function mailLogin () {
		return $this->mail_login;
	}
	
	public function _postsPerPage ($value) {
		if (is_int (intval ($value))) {
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
	public function _oldEntries ($value) {
		if (is_int (intval ($value))) {
			$this->old_entries = $value;
		} else {
			$this->old_entries = 3;
		}
	}
	public function _shortcuts ($values) {
		foreach ($values as $key => $value) {
			$this->shortcuts[$key] = $value;
		}
	}
	public function _mailLogin ($value) {
		if (filter_var ($value, FILTER_VALIDATE_EMAIL)) {
			$this->mail_login = $value;
		} elseif ($value == false) {
			$this->mail_login = false;
		}
	}
}

class RSSConfigurationDAO extends Model_array {
	public $posts_per_page = 10;
	public $default_view = 'all';
	public $display_posts = 'no';
	public $sort_order = 'low_to_high';
	public $old_entries = 3;
	public $shortcuts = array (
		'mark_read' => 'r',
		'mark_favorite' => 'f',
		'go_website' => 'space',
		'next_entry' => 'j',
		'prev_entry' => 'k',
		'next_page' => 'right',
		'prev_page' => 'left',
	);
	public $mail_login = '';

	public function __construct () {
		parent::__construct (PUBLIC_PATH . '/data/Configuration.array.php');
		
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
		if (isset ($this->array['old_entries'])) {
			$this->old_entries = $this->array['old_entries'];
		}
		if (isset ($this->array['shortcuts'])) {
			$this->shortcuts = $this->array['shortcuts'];
		}
		if (isset ($this->array['mail_login'])) {
			$this->mail_login = $this->array['mail_login'];
		}
	}
	
	public function update ($values) {
		foreach ($values as $key => $value) {
			$this->array[$key] = $value;
		}
	
		$this->writeFile($this->array);
	}
}

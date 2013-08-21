<?php

class RSSConfiguration extends Model {
	private $available_languages = array (
		'en' => 'English',
		'fr' => 'Français',
	);
	private $language;
	private $posts_per_page;
	private $view_mode;
	private $default_view;
	private $display_posts;
	private $lazyload;
	private $sort_order;
	private $old_entries;
	private $shortcuts = array ();
	private $mail_login = '';
	private $mark_when = array ();
	private $url_shaarli = '';
	private $theme;
	private $anon_access;
	private $token;
	private $auto_load_more;
	
	public function __construct () {
		$confDAO = new RSSConfigurationDAO ();
		$this->_language ($confDAO->language);
		$this->_postsPerPage ($confDAO->posts_per_page);
		$this->_viewMode ($confDAO->view_mode);
		$this->_defaultView ($confDAO->default_view);
		$this->_displayPosts ($confDAO->display_posts);
		$this->_lazyload ($confDAO->lazyload);
		$this->_sortOrder ($confDAO->sort_order);
		$this->_oldEntries ($confDAO->old_entries);
		$this->_shortcuts ($confDAO->shortcuts);
		$this->_mailLogin ($confDAO->mail_login);
		$this->_markWhen ($confDAO->mark_when);
		$this->_urlShaarli ($confDAO->url_shaarli);
		$this->_theme ($confDAO->theme);
		$this->_anonAccess ($confDAO->anon_access);
		$this->_token ($confDAO->token);
		$this->_autoLoadMore ($confDAO->auto_load_more);
	}
	
	public function availableLanguages () {
		return $this->available_languages;
	}
	public function language () {
		return $this->language;
	}
	public function postsPerPage () {
		return $this->posts_per_page;
	}
	public function viewMode () {
		return $this->view_mode;
	}
	public function defaultView () {
		return $this->default_view;
	}
	public function displayPosts () {
		return $this->display_posts;
	}
	public function lazyload () {
		return $this->lazyload;
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
	public function markWhen () {
		return $this->mark_when;
	}
	public function markWhenArticle () {
		return $this->mark_when['article'];
	}
	public function markWhenSite () {
		return $this->mark_when['site'];
	}
	public function markWhenScroll () {
		return $this->mark_when['scroll'];
	}
	public function urlShaarli () {
		return $this->url_shaarli;
	}
	public function theme () {
		return $this->theme;
	}
	public function anonAccess () {
		return $this->anon_access;
	}
	public function token () {
		return $this->token;
	}
	public function autoLoadMore () {
		return $this->autoLoadMore;
	}

	public function _language ($value) {
		if (!isset ($this->available_languages[$value])) {
			$value = 'en';
		}
		$this->language = $value;
	}
	public function _postsPerPage ($value) {
		if (is_int (intval ($value)) && $value > 0) {
			$this->posts_per_page = $value;
		} else {
			$this->posts_per_page = 10;
		}
	}
	public function _viewMode ($value) {
		if ($value == 'global' || $value == 'reader') {
			$this->view_mode = $value;
		} else {
			$this->view_mode = 'normal';
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
	public function _lazyload ($value) {
		if ($value == 'no') {
			$this->lazyload = 'no';
		} else {
			$this->lazyload = 'yes';
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
		if (is_int (intval ($value)) && $value > 0) {
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
	public function _markWhen ($values) {
		if(!isset($values['article'])) {
			$values['article'] = 'yes';
		}
		if(!isset($values['site'])) {
			$values['site'] = 'yes';
		}
		if(!isset($values['scroll'])) {
			$values['scroll'] = 'yes';
		}

		$this->mark_when['article'] = $values['article'];
		$this->mark_when['site'] = $values['site'];
		$this->mark_when['scroll'] = $values['scroll'];
	}
	public function _urlShaarli ($value) {
		$this->url_shaarli = '';
		if (filter_var ($value, FILTER_VALIDATE_URL)) {
			$this->url_shaarli = $value;
		}
	}
	public function _theme ($value) {
		$this->theme = $value;
	}
	public function _anonAccess ($value) {
		if ($value == 'yes') {
			$this->anon_access = 'yes';
		} else {
			$this->anon_access = 'no';
		}
	}
	public function _token ($value) {
		$this->token = $value;
	}
	public function _autoLoadMore ($value) {
		if ($value == 'yes') {
			$this->auto_load_more = 'yes';
		} else {
			$this->auto_load_more = 'no';
		}
	}
}

class RSSConfigurationDAO extends Model_array {
	public $language = 'en';
	public $posts_per_page = 20;
	public $view_mode = 'normal';
	public $default_view = 'not_read';
	public $display_posts = 'no';
	public $lazyload = 'yes';
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
	public $mark_when = array (
		'article' => 'yes',
		'site' => 'yes',
		'scroll' => 'no'
	);
	public $url_shaarli = '';
	public $theme = 'default';
	public $anon_access = 'no';
	public $token = '';
	public $auto_load_more = 'no';

	public function __construct () {
		parent::__construct (PUBLIC_PATH . '/data/Configuration.array.php');

		// TODO : simplifier ce code, une boucle for() devrait suffir !
		if (isset ($this->array['language'])) {
			$this->language = $this->array['language'];
		}
		if (isset ($this->array['posts_per_page'])) {
			$this->posts_per_page = $this->array['posts_per_page'];
		}
		if (isset ($this->array['view_mode'])) {
			$this->view_mode = $this->array['view_mode'];
		}
		if (isset ($this->array['default_view'])) {
			$this->default_view = $this->array['default_view'];
		}
		if (isset ($this->array['display_posts'])) {
			$this->display_posts = $this->array['display_posts'];
		}
		if (isset ($this->array['lazyload'])) {
			$this->lazyload = $this->array['lazyload'];
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
		if (isset ($this->array['mark_when'])) {
			$this->mark_when = $this->array['mark_when'];
		}
		if (isset ($this->array['url_shaarli'])) {
			$this->url_shaarli = $this->array['url_shaarli'];
		}
		if (isset ($this->array['theme'])) {
			$this->theme = $this->array['theme'];
		}
		if (isset ($this->array['anon_access'])) {
			$this->anon_access = $this->array['anon_access'];
		}
		if (isset ($this->array['token'])) {
			$this->token = $this->array['token'];
		}
		if (isset ($this->array['auto_load_more'])) {
			$this->auto_load_more = $this->array['auto_load_more'];
		}
	}
	
	public function update ($values) {
		foreach ($values as $key => $value) {
			$this->array[$key] = $value;
		}
	
		$this->writeFile($this->array);
	}
}

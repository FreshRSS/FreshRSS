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
	private $onread_jump_next;
	private $lazyload;
	private $sort_order;
	private $old_entries;
	private $shortcuts = array ();
	private $mail_login = '';
	private $mark_when = array ();
	private $sharing = array ();
	private $theme;
	private $anon_access;
	private $token;
	private $auto_load_more;
	private $topline_read;
	private $topline_favorite;
	private $topline_date;
	private $topline_link;
	private $bottomline_read;
	private $bottomline_favorite;
	private $bottomline_sharing;
	private $bottomline_tags;
	private $bottomline_date;
	private $bottomline_link;

	public function __construct () {
		$confDAO = new RSSConfigurationDAO ();
		$this->_language ($confDAO->language);
		$this->_postsPerPage ($confDAO->posts_per_page);
		$this->_viewMode ($confDAO->view_mode);
		$this->_defaultView ($confDAO->default_view);
		$this->_displayPosts ($confDAO->display_posts);
		$this->_onread_jump_next ($confDAO->onread_jump_next);
		$this->_lazyload ($confDAO->lazyload);
		$this->_sortOrder ($confDAO->sort_order);
		$this->_oldEntries ($confDAO->old_entries);
		$this->_shortcuts ($confDAO->shortcuts);
		$this->_mailLogin ($confDAO->mail_login);
		$this->_markWhen ($confDAO->mark_when);
		$this->_sharing ($confDAO->sharing);
		$this->_theme ($confDAO->theme);
		RSSThemes::setThemeId ($confDAO->theme);
		$this->_anonAccess ($confDAO->anon_access);
		$this->_token ($confDAO->token);
		$this->_autoLoadMore ($confDAO->auto_load_more);
		$this->_topline_read ($confDAO->topline_read);
		$this->_topline_favorite ($confDAO->topline_favorite);
		$this->_topline_date ($confDAO->topline_date);
		$this->_topline_link ($confDAO->topline_link);
		$this->_bottomline_read ($confDAO->bottomline_read);
		$this->_bottomline_favorite ($confDAO->bottomline_favorite);
		$this->_bottomline_sharing ($confDAO->bottomline_sharing);
		$this->_bottomline_tags ($confDAO->bottomline_tags);
		$this->_bottomline_date ($confDAO->bottomline_date);
		$this->_bottomline_link ($confDAO->bottomline_link);
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
	public function onread_jump_next () {
		return $this->onread_jump_next;
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
	public function sharing ($key = false) {
		if ($key === false) {
			return $this->sharing;
		} elseif (isset ($this->sharing[$key])) {
			return $this->sharing[$key];
		}
		return false;
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
		return $this->auto_load_more;
	}
	public function toplineRead () {
		return $this->topline_read;
	}
	public function toplineFavorite () {
		return $this->topline_favorite;
	}
	public function toplineDate () {
		return $this->topline_date;
	}
	public function toplineLink () {
		return $this->topline_link;
	}
	public function bottomlineRead () {
		return $this->bottomline_read;
	}
	public function bottomlineFavorite () {
		return $this->bottomline_favorite;
	}
	public function bottomlineSharing () {
		return $this->bottomline_sharing;
	}
	public function bottomlineTags () {
		return $this->bottomline_tags;
	}
	public function bottomlineDate () {
		return $this->bottomline_date;
	}
	public function bottomlineLink () {
		return $this->bottomline_link;
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
	public function _onread_jump_next ($value) {
		if ($value == 'no') {
			$this->onread_jump_next = 'no';
		} else {
			$this->onread_jump_next = 'yes';
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
	public function _sharing ($values) {
		$are_url = array ('shaarli', 'poche', 'diaspora');
		foreach ($values as $key => $value) {
			if (in_array($key, $are_url)) {
				$is_url = (
					filter_var ($value, FILTER_VALIDATE_URL) ||
					(version_compare(PHP_VERSION, '5.3.3', '<') &&
						(strpos($value, '-') > 0) &&
						($value === filter_var($value, FILTER_SANITIZE_URL)))
				);  //PHP bug #51192

				if (!$is_url) {
					$value = '';
				}
			} elseif(!is_bool ($value)) {
				$value = true;
			}

			$this->sharing[$key] = $value;
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
	public function _topline_read ($value) {
		$this->topline_read = $value === 'yes';
	}
	public function _topline_favorite ($value) {
		$this->topline_favorite = $value === 'yes';
	}
	public function _topline_date ($value) {
		$this->topline_date = $value === 'yes';
	}
	public function _topline_link ($value) {
		$this->topline_link = $value === 'yes';
	}
	public function _bottomline_read ($value) {
		$this->bottomline_read = $value === 'yes';
	}
	public function _bottomline_favorite ($value) {
		$this->bottomline_favorite = $value === 'yes';
	}
	public function _bottomline_sharing ($value) {
		$this->bottomline_sharing = $value === 'yes';
	}
	public function _bottomline_tags ($value) {
		$this->bottomline_tags = $value === 'yes';
	}
	public function _bottomline_date ($value) {
		$this->bottomline_date = $value === 'yes';
	}
	public function _bottomline_link ($value) {
		$this->bottomline_link = $value === 'yes';
	}
}

class RSSConfigurationDAO extends Model_array {
	public $language = 'en';
	public $posts_per_page = 20;
	public $view_mode = 'normal';
	public $default_view = 'not_read';
	public $display_posts = 'no';
	public $onread_jump_next = 'yes';
	public $lazyload = 'yes';
	public $sort_order = 'low_to_high';
	public $old_entries = 3;
	public $shortcuts = array (
		'mark_read' => 'r',
		'mark_favorite' => 'f',
		'go_website' => 'space',
		'next_entry' => 'j',
		'prev_entry' => 'k',
		'collapse_entry' => 'c',
		'load_more' => 'm'
	);
	public $mail_login = '';
	public $mark_when = array (
		'article' => 'yes',
		'site' => 'yes',
		'scroll' => 'no'
	);
	public $sharing = array (
		'shaarli' => '',
		'poche' => '',
		'diaspora' => '',
		'twitter' => true,
		'g+' => true,
		'facebook' => true,
		'email' => true,
		'print' => true
	);
	public $theme = 'default';
	public $anon_access = 'no';
	public $token = '';
	public $auto_load_more = 'no';
	public $topline_read = 'yes';
	public $topline_favorite = 'yes';
	public $topline_date = 'yes';
	public $topline_link = 'yes';
	public $bottomline_read = 'yes';
	public $bottomline_favorite = 'yes';
	public $bottomline_sharing = 'yes';
	public $bottomline_tags = 'yes';
	public $bottomline_date = 'yes';
	public $bottomline_link = 'yes';

	public function __construct () {
		parent::__construct (DATA_PATH . '/' . Configuration::currentUser () . '_user.php');

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
		if (isset ($this->array['onread_jump_next'])) {
			$this->onread_jump_next = $this->array['onread_jump_next'];
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
			$this->shortcuts = array_merge (
				$this->shortcuts, $this->array['shortcuts']
			);
		}
		if (isset ($this->array['mail_login'])) {
			$this->mail_login = $this->array['mail_login'];
		}
		if (isset ($this->array['mark_when'])) {
			$this->mark_when = $this->array['mark_when'];
		}
		if (isset ($this->array['sharing'])) {
			$this->sharing = array_merge (
				$this->sharing, $this->array['sharing']
			);
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

		if (isset ($this->array['topline_read'])) {
			$this->topline_read = $this->array['topline_read'];
		}
		if (isset ($this->array['topline_favorite'])) {
			$this->topline_favorite = $this->array['topline_favorite'];
		}
		if (isset ($this->array['topline_date'])) {
			$this->topline_date = $this->array['topline_date'];
		}
		if (isset ($this->array['topline_link'])) {
			$this->topline_link = $this->array['topline_link'];
		}
		if (isset ($this->array['bottomline_read'])) {
			$this->bottomline_read = $this->array['bottomline_read'];
		}
		if (isset ($this->array['bottomline_favorite'])) {
			$this->bottomline_favorite = $this->array['bottomline_favorite'];
		}
		if (isset ($this->array['bottomline_sharing'])) {
			$this->bottomline_sharing = $this->array['bottomline_sharing'];
		}
		if (isset ($this->array['bottomline_tags'])) {
			$this->bottomline_tags = $this->array['bottomline_tags'];
		}
		if (isset ($this->array['bottomline_date'])) {
			$this->bottomline_date = $this->array['bottomline_date'];
		}
		if (isset ($this->array['bottomline_link'])) {
			$this->bottomline_link = $this->array['bottomline_link'];
		}
	}

	public function update ($values) {
		foreach ($values as $key => $value) {
			$this->array[$key] = $value;
		}

		$this->writeFile($this->array);
		invalidateHttpCache();
	}
}

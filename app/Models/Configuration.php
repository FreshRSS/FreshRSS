<?php

class FreshRSS_Configuration extends Minz_Model {
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
		$confDAO = new FreshRSS_ConfigurationDAO ();
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
		FreshRSS_Themes::setThemeId ($confDAO->theme);
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
	public function markUponReception () {
		return $this->mark_when['reception'];
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
		$value = intval($value);
		$this->posts_per_page = $value > 0 ? $value : 10;
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
		$this->sort_order = $value === 'ASC' ? 'ASC' : 'DESC';
	}
	public function _oldEntries ($value) {
		if (ctype_digit ($value) && $value > 0) {
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
		if(!isset($values['reception'])) {
			$values['reception'] = 'no';
		}

		$this->mark_when['article'] = $values['article'];
		$this->mark_when['site'] = $values['site'];
		$this->mark_when['scroll'] = $values['scroll'];
		$this->mark_when['reception'] = $values['reception'];
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

<?php

class FreshRSS_ConfigurationDAO extends Minz_ModelArray {
	public $language = 'en';
	public $posts_per_page = 20;
	public $view_mode = 'normal';
	public $default_view = 'not_read';
	public $display_posts = 'no';
	public $onread_jump_next = 'yes';
	public $lazyload = 'yes';
	public $sort_order = 'DESC';
	public $old_entries = 3;
	public $keep_history_default = 0;
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
		'scroll' => 'no',
		'reception' => 'no'
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
	public $token = '';
	public $auto_load_more = 'yes';
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

	public function __construct ($nameFile = '') {
		if (empty($nameFile)) {
			$nameFile = DATA_PATH . '/' . Minz_Configuration::currentUser () . '_user.php';
		}
		parent::__construct ($nameFile);

		// TODO : simplifier ce code, une boucle for() devrait suffire !
		if (isset ($this->array['language'])) {
			$this->language = $this->array['language'];
		}
		if (isset ($this->array['posts_per_page'])) {
			$this->posts_per_page = intval($this->array['posts_per_page']);
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
			$this->old_entries = intval($this->array['old_entries']);
		}
		if (isset ($this->array['keep_history_default'])) {
			$this->keep_history_default = intval($this->array['keep_history_default']);
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

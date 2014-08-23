<?php

class FreshRSS_Configuration {
	private $filename;

	private $data = array(
		'language' => 'en',
		'old_entries' => 3,
		'keep_history_default' => 0,
		'ttl_default' => 3600,
		'mail_login' => '',
		'token' => '',
		'passwordHash' => '',	//CRYPT_BLOWFISH
		'apiPasswordHash' => '',	//CRYPT_BLOWFISH
		'posts_per_page' => 20,
		'view_mode' => 'normal',
		'default_view' => FreshRSS_Entry::STATE_NOT_READ,
		'auto_load_more' => true,
		'display_posts' => false,
		'display_categories' => false,
		'hide_read_feeds' => true,
		'onread_jump_next' => true,
		'lazyload' => true,
		'sticky_post' => true,
		'reading_confirm' => false,
		'sort_order' => 'DESC',
		'anon_access' => false,
		'mark_when' => array(
			'article' => true,
			'site' => true,
			'scroll' => false,
			'reception' => false,
		),
		'theme' => 'Origine',
		'content_width' => 'thin',
		'shortcuts' => array(
			'mark_read' => 'r',
			'mark_favorite' => 'f',
			'go_website' => 'space',
			'next_entry' => 'j',
			'prev_entry' => 'k',
			'first_entry' => 'home',
			'last_entry' => 'end',
			'collapse_entry' => 'c',
			'load_more' => 'm',
			'auto_share' => 's',
			'focus_search' => 'a',
		),
		'topline_read' => true,
		'topline_favorite' => true,
		'topline_date' => true,
		'topline_link' => true,
		'bottomline_read' => true,
		'bottomline_favorite' => true,
		'bottomline_sharing' => true,
		'bottomline_tags' => true,
		'bottomline_date' => true,
		'bottomline_link' => true,
		'sharing' => array(),
		'queries' => array(),
	);

	private $available_languages = array(
		'en' => 'English',
		'fr' => 'Français',
	);

	private $shares;

	public function __construct($user) {
		$this->filename = DATA_PATH . DIRECTORY_SEPARATOR . $user . '_user.php';

		$data = @include($this->filename);
		if (!is_array($data)) {
			throw new Minz_PermissionDeniedException($this->filename);
		}

		foreach ($data as $key => $value) {
			if (isset($this->data[$key])) {
				$function = '_' . $key;
				$this->$function($value);
			}
		}
		$this->data['user'] = $user;

		$this->shares = DATA_PATH . DIRECTORY_SEPARATOR . 'shares.php';

		$shares = @include($this->shares);
		if (!is_array($shares)) {
			throw new Minz_PermissionDeniedException($this->shares);
		}

		$this->data['shares'] = $shares;
	}

	public function save() {
		@rename($this->filename, $this->filename . '.bak.php');
		unset($this->data['shares']); // Remove shares because it is not intended to be stored in user configuration
		if (file_put_contents($this->filename, "<?php\n return " . var_export($this->data, true) . ';', LOCK_EX) === false) {
			throw new Minz_PermissionDeniedException($this->filename);
		}
		if (function_exists('opcache_invalidate')) {
			opcache_invalidate($this->filename);	//Clear PHP 5.5+ cache for include
		}
		invalidateHttpCache();
		return true;
	}

	public function __get($name) {
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		} else {
			$trace = debug_backtrace();
			trigger_error('Undefined FreshRSS_Configuration->' . $name . 'in ' . $trace[0]['file'] . ' line ' . $trace[0]['line'], E_USER_NOTICE);	//TODO: Use Minz exceptions
			return null;
		}
	}

	public function availableLanguages() {
		return $this->available_languages;
	}

	public function _language($value) {
		if (!isset($this->available_languages[$value])) {
			$value = 'en';
		}
		$this->data['language'] = $value;
	}
	public function _posts_per_page ($value) {
		$value = intval($value);
		$this->data['posts_per_page'] = $value > 0 ? $value : 10;
	}
	public function _view_mode ($value) {
		if ($value === 'global' || $value === 'reader') {
			$this->data['view_mode'] = $value;
		} else {
			$this->data['view_mode'] = 'normal';
		}
	}
	public function _default_view ($value) {
		$this->data['default_view'] = $value === FreshRSS_Entry::STATE_ALL ? FreshRSS_Entry::STATE_ALL : FreshRSS_Entry::STATE_NOT_READ;
	}
	public function _display_posts ($value) {
		$this->data['display_posts'] = ((bool)$value) && $value !== 'no';
	}
	public function _display_categories ($value) {
		$this->data['display_categories'] = ((bool)$value) && $value !== 'no';
	}
	public function _hide_read_feeds($value) {
		$this->data['hide_read_feeds'] = (bool)$value;
	}
	public function _onread_jump_next ($value) {
		$this->data['onread_jump_next'] = ((bool)$value) && $value !== 'no';
	}
	public function _lazyload ($value) {
		$this->data['lazyload'] = ((bool)$value) && $value !== 'no';
	}
	public function _sticky_post($value) {
		$this->data['sticky_post'] = ((bool)$value) && $value !== 'no';
	}
	public function _reading_confirm($value) {
		$this->data['reading_confirm'] = ((bool)$value) && $value !== 'no';
	}
	public function _sort_order ($value) {
		$this->data['sort_order'] = $value === 'ASC' ? 'ASC' : 'DESC';
	}
	public function _old_entries($value) {
		$value = intval($value);
		$this->data['old_entries'] = $value > 0 ? $value : 3;
	}
	public function _keep_history_default($value) {
		$value = intval($value);
		$this->data['keep_history_default'] = $value >= -1 ? $value : 0;
	}
	public function _ttl_default($value) {
		$value = intval($value);
		$this->data['ttl_default'] = $value >= -1 ? $value : 3600;
	}
	public function _shortcuts ($values) {
		foreach ($values as $key => $value) {
			if (isset($this->data['shortcuts'][$key])) {
				$this->data['shortcuts'][$key] = $value;
			}
		}
	}
	public function _passwordHash ($value) {
		$this->data['passwordHash'] = ctype_graph($value) && (strlen($value) >= 60) ? $value : '';
	}
	public function _apiPasswordHash ($value) {
		$this->data['apiPasswordHash'] = ctype_graph($value) && (strlen($value) >= 60) ? $value : '';
	}
	public function _mail_login ($value) {
		$value = filter_var($value, FILTER_VALIDATE_EMAIL);
		if ($value) {
			$this->data['mail_login'] = $value;
		} else {
			$this->data['mail_login'] = '';
		}
	}
	public function _anon_access ($value) {
		$this->data['anon_access'] = ((bool)$value) && $value !== 'no';
	}
	public function _mark_when ($values) {
		foreach ($values as $key => $value) {
			if (isset($this->data['mark_when'][$key])) {
				$this->data['mark_when'][$key] = ((bool)$value) && $value !== 'no';
			}
		}
	}
	public function _sharing ($values) {
		$this->data['sharing'] = array();
		foreach ($values as $value) {
			if (!is_array($value)) {
				continue;
			}

			// Verify URL and add default value when needed
			if (isset($value['url'])) {
				$is_url = (
					filter_var ($value['url'], FILTER_VALIDATE_URL) ||
					(version_compare(PHP_VERSION, '5.3.3', '<') &&
						(strpos($value, '-') > 0) &&
						($value === filter_var($value, FILTER_SANITIZE_URL)))
				);  //PHP bug #51192
				if (!$is_url) {
					continue;
				}
			} else {
				$value['url'] = null;
			}

			// Add a default name
			if (empty($value['name'])) {
				$value['name'] = $value['type'];
			}

			$this->data['sharing'][] = $value;
		}
	}
	public function _queries ($values) {
		$this->data['queries'] = array();
		foreach ($values as $value) {
			$value = array_filter($value);
			$params = $value;
			unset($params['name']);
			unset($params['url']);
			$value['url'] = Minz_Url::display(array('params' => $params));

			$this->data['queries'][] = $value;
		}
	}
	public function _theme($value) {
		$this->data['theme'] = $value;
	}
	public function _content_width($value) {
		if ($value === 'medium' ||
				$value === 'large' ||
				$value === 'no_limit') {
			$this->data['content_width'] = $value;
		} else {
			$this->data['content_width'] = 'thin';
		}
	}
	public function _token($value) {
		$this->data['token'] = $value;
	}
	public function _auto_load_more($value) {
		$this->data['auto_load_more'] = ((bool)$value) && $value !== 'no';
	}
	public function _topline_read($value) {
		$this->data['topline_read'] = ((bool)$value) && $value !== 'no';
	}
	public function _topline_favorite($value) {
		$this->data['topline_favorite'] = ((bool)$value) && $value !== 'no';
	}
	public function _topline_date($value) {
		$this->data['topline_date'] = ((bool)$value) && $value !== 'no';
	}
	public function _topline_link($value) {
		$this->data['topline_link'] = ((bool)$value) && $value !== 'no';
	}
	public function _bottomline_read($value) {
		$this->data['bottomline_read'] = ((bool)$value) && $value !== 'no';
	}
	public function _bottomline_favorite($value) {
		$this->data['bottomline_favorite'] = ((bool)$value) && $value !== 'no';
	}
	public function _bottomline_sharing($value) {
		$this->data['bottomline_sharing'] = ((bool)$value) && $value !== 'no';
	}
	public function _bottomline_tags($value) {
		$this->data['bottomline_tags'] = ((bool)$value) && $value !== 'no';
	}
	public function _bottomline_date($value) {
		$this->data['bottomline_date'] = ((bool)$value) && $value !== 'no';
	}
	public function _bottomline_link($value) {
		$this->data['bottomline_link'] = ((bool)$value) && $value !== 'no';
	}
}

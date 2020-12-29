<?php

class FreshRSS_ConfigurationSetter {
	/**
	 * Return if the given key is supported by this setter.
	 * @param $key the key to test.
	 * @return true if the key is supported, false else.
	 */
	public function support($key) {
		$name_setter = '_' . $key;
		return is_callable(array($this, $name_setter));
	}

	/**
	 * Set the given key in data with the current value.
	 * @param $data an array containing the list of all configuration data.
	 * @param $key the key to update.
	 * @param $value the value to set.
	 */
	public function handle(&$data, $key, $value) {
		$name_setter = '_' . $key;
		call_user_func_array(array($this, $name_setter), array(&$data, $value));
	}

	/**
	 * A helper to set boolean values.
	 *
	 * @param $value the tested value.
	 * @return true if value is true and different from no, false else.
	 */
	private function handleBool($value) {
		return ((bool)$value) && $value !== 'no';
	}

	/**
	 * The (long) list of setters for user configuration.
	 */
	private function _apiPasswordHash(&$data, $value) {
		$data['apiPasswordHash'] = ctype_graph($value) && (strlen($value) >= 60) ? $value : '';
	}

	private function _content_width(&$data, $value) {
		$value = strtolower($value);
		if (!in_array($value, array('thin', 'medium', 'large', 'no_limit'))) {
			$value = 'thin';
		}

		$data['content_width'] = $value;
	}

	private function _default_state(&$data, $value) {
		$data['default_state'] = (int)$value;
	}

	private function _default_view(&$data, $value) {
		switch ($value) {
		case 'all':
			$data['default_view'] = $value;
			$data['default_state'] = (FreshRSS_Entry::STATE_READ + FreshRSS_Entry::STATE_NOT_READ);
			break;
		case 'adaptive':
		case 'unread':
		default:
			$data['default_view'] = $value;
			$data['default_state'] = FreshRSS_Entry::STATE_NOT_READ;
		}
	}

	// It works for system config too!
	private function _extensions_enabled(&$data, $value) {
		if (!is_array($value)) {
			$value = array($value);
		}
		$data['extensions_enabled'] = $value;
	}

	private function _html5_notif_timeout(&$data, $value) {
		$value = intval($value);
		$data['html5_notif_timeout'] = $value >= 0 ? $value : 0;
	}

	// It works for system config too!
	private function _language(&$data, $value) {
		$value = strtolower($value);
		$languages = Minz_Translate::availableLanguages();
		if (!in_array($value, $languages)) {
			$value = 'en';
		}
		$data['language'] = $value;
	}

	private function _passwordHash(&$data, $value) {
		$data['passwordHash'] = ctype_graph($value) && (strlen($value) >= 60) ? $value : '';
	}

	private function _posts_per_page(&$data, $value) {
		$value = intval($value);
		$data['posts_per_page'] = $value > 0 ? $value : 10;
	}

	private function _queries(&$data, $values) {
		$data['queries'] = array();
		foreach ($values as $value) {
			if ($value instanceof FreshRSS_UserQuery) {
				$data['queries'][] = $value->toArray();
			} elseif (is_array($value)) {
				$data['queries'][] = $value;
			}
		}
	}

	private function _sharing(&$data, $values) {
		$data['sharing'] = array();
		foreach ($values as $value) {
			if (!is_array($value)) {
				continue;
			}

			// Verify URL and add default value when needed
			if (isset($value['url'])) {
				$is_url = checkUrl($value['url']);
				if (!$is_url) {
					continue;
				}
			} else {
				$value['url'] = null;
			}

			$data['sharing'][] = $value;
		}
	}

	private function _shortcuts(&$data, $values) {
		if (!is_array($values)) {
			return;
		}

		$data['shortcuts'] = $values;
	}

	private function _sort_order(&$data, $value) {
		$data['sort_order'] = $value === 'ASC' ? 'ASC' : 'DESC';
	}

	private function _ttl_default(&$data, $value) {
		$value = intval($value);
		$data['ttl_default'] = $value > FreshRSS_Feed::TTL_DEFAULT ? $value : 3600;
	}

	private function _view_mode(&$data, $value) {
		$value = strtolower($value);
		if (!in_array($value, array('global', 'normal', 'reader'))) {
			$value = 'normal';
		}
		$data['view_mode'] = $value;
	}

	/**
	 * A list of boolean setters.
	 */
	private function _anon_access(&$data, $value) {
		$data['anon_access'] = $this->handleBool($value);
	}

	private function _auto_load_more(&$data, $value) {
		$data['auto_load_more'] = $this->handleBool($value);
	}

	private function _auto_remove_article(&$data, $value) {
		$data['auto_remove_article'] = $this->handleBool($value);
	}

	private function _mark_updated_article_unread(&$data, $value) {
		$data['mark_updated_article_unread'] = $this->handleBool($value);
	}

	private function _show_nav_buttons(&$data, $value) {
		$data['show_nav_buttons'] = $this->handleBool($value);
	}

	private function _show_fav_unread(&$data, $value) {
		$data['show_fav_unread'] = $this->handleBool($value);
	}

	private function _display_categories(&$data, $value) {
		if (!in_array($value, [ 'active', 'remember', 'all', 'none' ], true)) {
			$value = $value === true ? 'all' : 'active';
		}
		$data['display_categories'] = $value;
	}

	private function _display_posts(&$data, $value) {
		$data['display_posts'] = $this->handleBool($value);
	}

	private function _hide_read_feeds(&$data, $value) {
		$data['hide_read_feeds'] = $this->handleBool($value);
	}

	private function _sides_close_article(&$data, $value) {
		$data['sides_close_article'] = $this->handleBool($value);
	}

	private function _lazyload(&$data, $value) {
		$data['lazyload'] = $this->handleBool($value);
	}

	private function _mark_when(&$data, $values) {
		foreach ($values as $key => $value) {
			$data['mark_when'][$key] = $this->handleBool($value);
		}
	}

	private function _onread_jump_next(&$data, $value) {
		$data['onread_jump_next'] = $this->handleBool($value);
	}

	private function _reading_confirm(&$data, $value) {
		$data['reading_confirm'] = $this->handleBool($value);
	}

	private function _sticky_post(&$data, $value) {
		$data['sticky_post'] = $this->handleBool($value);
	}

	private function _bottomline_date(&$data, $value) {
		$data['bottomline_date'] = $this->handleBool($value);
	}
	private function _bottomline_favorite(&$data, $value) {
		$data['bottomline_favorite'] = $this->handleBool($value);
	}
	private function _bottomline_link(&$data, $value) {
		$data['bottomline_link'] = $this->handleBool($value);
	}
	private function _bottomline_read(&$data, $value) {
		$data['bottomline_read'] = $this->handleBool($value);
	}
	private function _bottomline_sharing(&$data, $value) {
		$data['bottomline_sharing'] = $this->handleBool($value);
	}
	private function _bottomline_tags(&$data, $value) {
		$data['bottomline_tags'] = $this->handleBool($value);
	}

	private function _topline_date(&$data, $value) {
		$data['topline_date'] = $this->handleBool($value);
	}
	private function _topline_favorite(&$data, $value) {
		$data['topline_favorite'] = $this->handleBool($value);
	}
	private function _topline_link(&$data, $value) {
		$data['topline_link'] = $this->handleBool($value);
	}
	private function _topline_read(&$data, $value) {
		$data['topline_read'] = $this->handleBool($value);
	}
	private function _topline_display_authors(&$data, $value) {
		$data['topline_display_authors'] = $this->handleBool($value);
	}

	/**
	 * The (not so long) list of setters for system configuration.
	 */
	private function _allow_anonymous(&$data, $value) {
		$data['allow_anonymous'] = $this->handleBool($value) && FreshRSS_Auth::accessNeedsAction();
	}

	private function _allow_anonymous_refresh(&$data, $value) {
		$data['allow_anonymous_refresh'] = $this->handleBool($value) && $data['allow_anonymous'];
	}

	private function _api_enabled(&$data, $value) {
		$data['api_enabled'] = $this->handleBool($value);
	}

	private function _auth_type(&$data, $value) {
		$value = strtolower($value);
		if (!in_array($value, array('form', 'http_auth', 'none'))) {
			$value = 'none';
		}
		$data['auth_type'] = $value;
		$this->_allow_anonymous($data, $data['allow_anonymous']);
	}

	private function _db(&$data, $value) {
		if (!isset($value['type'])) {
			return;
		}

		switch ($value['type']) {
		case 'mysql':
		case 'pgsql':
			if (empty($value['host']) ||
					empty($value['user']) ||
					empty($value['base']) ||
					!isset($value['password'])) {
				return;
			}

			$data['db']['type'] = $value['type'];
			$data['db']['host'] = $value['host'];
			$data['db']['user'] = $value['user'];
			$data['db']['base'] = $value['base'];
			$data['db']['password'] = $value['password'];
			$data['db']['prefix'] = isset($value['prefix']) ? $value['prefix'] : '';
			break;
		case 'sqlite':
			$data['db']['type'] = $value['type'];
			$data['db']['host'] = '';
			$data['db']['user'] = '';
			$data['db']['base'] = '';
			$data['db']['password'] = '';
			$data['db']['prefix'] = '';
			break;
		default:
			return;
		}
	}

	private function _default_user(&$data, $value) {
		$user_list = listUsers();
		if (in_array($value, $user_list)) {
			$data['default_user'] = $value;
		}
	}

	private function _environment(&$data, $value) {
		$value = strtolower($value);
		if (!in_array($value, array('silent', 'development', 'production'))) {
			$value = 'production';
		}
		$data['environment'] = $value;
	}

	private function _limits(&$data, $values) {
		$max_small_int = 16384;
		$limits_keys = array(
			'cookie_duration' => array(
				'min' => 0,
			),
			'cache_duration' => array(
				'min' => 0,
			),
			'timeout' => array(
				'min' => 0,
			),
			'max_inactivity' => array(
				'min' => 0,
			),
			'max_feeds' => array(
				'min' => 0,
				'max' => $max_small_int,
			),
			'max_categories' => array(
				'min' => 0,
				'max' => $max_small_int,
			),
			'max_registrations' => array(
				'min' => 0,
			),
		);

		foreach ($values as $key => $value) {
			if (!isset($limits_keys[$key])) {
				continue;
			}

			$value = intval($value);
			$limits = $limits_keys[$key];
			if ((!isset($limits['min']) || $value >= $limits['min']) &&
				(!isset($limits['max']) || $value <= $limits['max'])
			) {
				$data['limits'][$key] = $value;
			}
		}
	}

	private function _unsafe_autologin_enabled(&$data, $value) {
		$data['unsafe_autologin_enabled'] = $this->handleBool($value);
	}

	private function _auto_update_url(&$data, $value) {
		if (!$value) {
			return;
		}

		$data['auto_update_url'] = $value;
	}

	private function _force_email_validation(&$data, $value) {
		$data['force_email_validation'] = $this->handleBool($value);
	}
}

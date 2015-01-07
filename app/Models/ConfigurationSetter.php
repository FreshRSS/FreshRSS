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
	 * The (long) list of setters.
	 */
	private function _apiPasswordHash(&$data, $value) {
		$data['apiPasswordHash'] = ctype_graph($value) && (strlen($value) >= 60) ? $value : '';
	}

	private function _content_width(&$data, $value) {
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
			$data['default_state'] = (FreshRSS_Entry::STATE_READ +
			                          FreshRSS_Entry::STATE_NOT_READ);
			break;
		case 'adaptive':
		case 'unread':
		default:
			$data['default_view'] = $value;
			$data['default_state'] = FreshRSS_Entry::STATE_NOT_READ;
		}
	}

	private function _html5_notif_timeout(&$data, $value) {
		$value = intval($value);
		$data['html5_notif_timeout'] = $value >= 0 ? $value : 0;
	}

	private function _keep_history_default(&$data, $value) {
		$value = intval($value);
		$data['keep_history_default'] = $value >= -1 ? $value : 0;
	}

	private function _language(&$data, $value) {
		$languages = Minz_Translate::availableLanguages();
		if (!isset($languages[$value])) {
			$value = 'en';
		}
		$data['language'] = $value;
	}

	private function _mail_login(&$data, $value) {
		$value = filter_var($value, FILTER_VALIDATE_EMAIL);
		$data['mail_login'] = $value ? $value : '';
	}

	private function _old_entries(&$data, $value) {
		$value = intval($value);
		$data['old_entries'] = $value > 0 ? $value : 3;
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
			$value = array_filter($value);
			$params = $value;
			unset($params['name']);
			unset($params['url']);
			$value['url'] = Minz_Url::display(array('params' => $params));
			$data['queries'][] = $value;
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
				$is_url = (
					filter_var($value['url'], FILTER_VALIDATE_URL) ||
					(version_compare(PHP_VERSION, '5.3.3', '<') &&
						(strpos($value, '-') > 0) &&
						($value === filter_var($value, FILTER_SANITIZE_URL)))
				); //PHP bug #51192
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
		foreach ($values as $key => $value) {
			if (isset($data['shortcuts'][$key])) {
				$data['shortcuts'][$key] = $value;
			}
		}
	}

	private function _sort_order(&$data, $value) {
		$data['sort_order'] = $value === 'ASC' ? 'ASC' : 'DESC';
	}

	private function _ttl_default(&$data, $value) {
		$value = intval($value);
		$data['ttl_default'] = $value >= -1 ? $value : 3600;
	}

	private function _view_mode(&$data, $value) {
		if (!in_array($value, array('global', 'normal', 'reader'))) {
			$value = 'normal';
		}
		$data['view_mode'] =  $value;
	}

	/**
	 * A list of boolean setters.
	 */
	private function handleBool($value) {
		return ((bool)$value) && $value !== 'no';
	}

	private function _anon_access(&$data, $value) {
		$data['anon_access'] = $this->handleBool($value);
	}

	private function _auto_load_more(&$data, $value) {
		$data['auto_load_more'] = $this->handleBool($value);
	}

	private function _auto_remove_article(&$data, $value) {
		$data['auto_remove_article'] = $this->handleBool($value);
	}

	private function _display_categories(&$data, $value) {
		$data['display_categories'] = $this->handleBool($value);
	}

	private function _display_posts(&$data, $value) {
		$data['display_posts'] = $this->handleBool($value);
	}

	private function _hide_read_feeds(&$data, $value) {
		$data['hide_read_feeds'] = $this->handleBool($value);
	}

	private function _lazyload(&$data, $value) {
		$data['lazyload'] = $this->handleBool($value);
	}

	private function _mark_when(&$data, $values) {
		foreach ($values as $key => $value) {
			if (isset($data['mark_when'][$key])) {
				$data['mark_when'][$key] = $this->handleBool($value);
			}
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
}

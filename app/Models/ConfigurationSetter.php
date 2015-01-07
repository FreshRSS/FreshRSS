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
	private function _language(&$data, $value) {
		$languages = Minz_Translate::availableLanguages();
		if (!isset($languages[$value])) {
			$value = 'en';
		}
		$data['language'] = $value;
	}

	private function _posts_per_page(&$data, $value) {
		$value = intval($value);
		$data['posts_per_page'] = $value > 0 ? $value : 10;
	}

	private function _view_mode(&$data, $value) {
		if (!in_array($value, array('global', 'normal', 'reader'))) {
			$value = 'normal';
		}
		$data['view_mode'] =  $value;
	}
}

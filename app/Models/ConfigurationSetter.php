<?php

class FreshRSS_ConfigurationSetter {
	private $setters = array(
		'language' => '_language',
		'posts_per_page' => '_posts_per_page',
		'view_mode' => '_view_mode',
	);

	public function handle($key, $value) {
		if (isset($this->setters[$key])) {
			$value = call_user_func(array($this, $this->setters[$key]), $value);
		}
		return $value;
	}

	private function _language($value) {
		$languages = Minz_Translate::availableLanguages();
		if (!isset($languages[$value])) {
			$value = 'en';
		}

		return $value;
	}

	private function _posts_per_page($value) {
		$value = intval($value);
		return $value > 0 ? $value : 10;
	}

	private function _view_mode($value) {
		if (!in_array($value, array('global', 'normal', 'reader'))) {
			$value = 'normal';
		}
		return $value;
	}
}

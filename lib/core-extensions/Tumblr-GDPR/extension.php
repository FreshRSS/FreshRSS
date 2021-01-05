<?php

class TumblrGdprExtension extends Minz_Extension {
	public function install() {
		return true;
	}

	public function uninstall() {
		return true;
	}

	public function handleConfigureAction() {
	}

	public function init() {
		$this->registerHook('simplepie_before_init', array('TumblrGdprExtension', 'curlHook'));
	}

	public static function curlHook($simplePie, $feed) {
		if (preg_match('#^https?://[a-zA-Z_0-9-]+.tumblr.com/#i', $feed->url())) {
			$simplePie->set_useragent(FRESHRSS_USERAGENT . ' like Baiduspider');
		}
	}
}

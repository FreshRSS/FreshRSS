<?php

class TumblrGdprExtension extends Minz_Extension {
	public function init(): void {
		$this->registerHook('simplepie_before_init', array('TumblrGdprExtension', 'curlHook'));
	}

	public static function curlHook(SimplePie $simplePie, FreshRSS_Feed $feed): void {
		if (preg_match('#^https?://[a-zA-Z_0-9-]+.tumblr.com/#i', $feed->url())) {
			$simplePie->set_useragent(FRESHRSS_USERAGENT . ' like Baiduspider');
		}
	}
}

<?php
class GoogleGroupsExtension extends Minz_Extension {
	public function install() {
		return true;
	}

	public function uninstall() {
		return true;
	}

	public function handleConfigureAction() {
	}

	public function init() {
		$this->registerHook('check_url_before_add', array('GoogleGroupsExtension', 'findFeed'));
	}

	public static function findFeed($url) {
		return preg_replace('%^(https?://groups.google.com/forum)/#!forum/(.+)$%i', '$1/feed/$2/msgs/rss.xml', $url);
	}
}

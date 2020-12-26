<?php
class GoogleGroupsExtension extends Minz\Extension {
	public function init() {
		$this->registerHook('check_url_before_add', array('GoogleGroupsExtension', 'findFeed'));
	}

	public static function findFeed($url) {
		return preg_replace('%^(https?://groups.google.com/forum)/#!forum/(.+)$%i', '$1/feed/$2/msgs/rss.xml', $url);
	}
}

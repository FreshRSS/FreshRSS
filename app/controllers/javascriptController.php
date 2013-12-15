<?php

class FreshRSS_javascript_Controller extends Minz_ActionController {
	public function firstAction () {
		$this->view->_useLayout (false);
		header('Content-type: text/javascript');
	}

	public function actualizeAction () {
		$feedDAO = new FreshRSS_FeedDAO ();
		$this->view->feeds = $feedDAO->listFeeds ();
	}
}

<?php

class javascriptController extends ActionController {
	public function firstAction () {
		$this->view->_useLayout (false);
		header('Content-type: text/javascript');
	}

	public function actualizeAction () {
		$feedDAO = new FeedDAO ();
		$this->view->feeds = $feedDAO->listFeeds ();
	}
}

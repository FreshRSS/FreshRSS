<?php

class FreshRSS_javascript_Controller extends Minz_ActionController {
	public function firstAction () {
		$this->view->_useLayout (false);
	}

	public function actualizeAction () {
		header('Content-Type: text/javascript; charset=UTF-8');
		$feedDAO = new FreshRSS_FeedDAO ();
		$this->view->feeds = $feedDAO->listFeeds ();
	}

	public function nbUnreadsPerFeedAction() {
		header('Content-Type: application/json; charset=UTF-8');
		$catDAO = new FreshRSS_CategoryDAO();
		$this->view->categories = $catDAO->listCategories(true, false);
	}
}

<?php

class configureController extends ActionController {
	public function categorizeAction () {
	
	}
	
	public function fluxAction () {
	
	}
	
	public function displayAction () {
		if (Request::isPost ()) {
			$nb = Request::param ('posts_per_page', 10);
			$view = Request::param ('default_view', 'all');
			$display = Request::param ('display_posts', 'no');
		
			$this->view->conf->_postsPerPage (intval ($nb));
			$this->view->conf->_defaultView ($view);
			$this->view->conf->_displayPosts ($display);
		
			$values = array (
				'posts_per_page' => $this->view->conf->postsPerPage (),
				'default_view' => $this->view->conf->defaultView (),
				'display_posts' => $this->view->conf->displayPosts ()
			);
		
			$confDAO = new RSSConfigurationDAO ();
			$confDAO->save ($values);
			Session::_param ('conf', $this->view->conf);
		}
	}
}

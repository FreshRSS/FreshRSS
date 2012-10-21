<?php

class indexController extends ActionController {
	public function indexAction () {
		$entryDAO = new EntryDAO ();
		
		$mode = Session::param ('mode', $this->view->conf->defaultView ());
		if ($mode == 'not_read') {
			$entries = $entryDAO->listNotReadEntries ();
		} elseif ($mode == 'all') {
			$entries = $entryDAO->listEntries ();
		}
		
		usort ($entries, 'sortEntriesByDate');
		
		//gestion pagination
		$page = Request::param ('page', 1);
		$this->view->entryPaginator = new Paginator ($entries);
		$this->view->entryPaginator->_nbItemsPerPage ($this->view->conf->postsPerPage ());
		$this->view->entryPaginator->_currentPage ($page);
	}
	
	public function changeModeAction () {
		$mode = Request::param ('mode');
		
		if ($mode == 'not_read') {
			Session::_param ('mode', 'not_read');
		} else {
			Session::_param ('mode', 'all');
		}
		
		Request::forward (array (), true);
	}
}

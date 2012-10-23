<?php

class indexController extends ActionController {
	public function indexAction () {
		$entryDAO = new EntryDAO ();
		$catDAO = new CategoryDAO ();
		
		$mode = Session::param ('mode', $this->view->conf->defaultView ());
		$get = Request::param ('get');
		
		// Récupère les flux par catégorie, favoris ou tous
		if ($get == 'favoris') {
			$entries = $entryDAO->listFavorites ($mode);
		} elseif ($get != false) {
			$entries = $entryDAO->listByCategory ($get, $mode);
		}
		
		// Cas où on ne choisie ni catégorie ni les favoris
		// ou si la catégorie ne correspond à aucune
		if (!isset ($entries)) {
			$entries = $entryDAO->listEntries ($mode);
		}
		
		// Tri par date
		if ($this->view->conf->sortOrder () == 'high_to_low') {
			usort ($entries, 'sortReverseEntriesByDate');
		} else {
			usort ($entries, 'sortEntriesByDate');
		}
		
		// Gestion pagination
		$page = Request::param ('page', 1);
		$this->view->entryPaginator = new Paginator ($entries);
		$this->view->entryPaginator->_nbItemsPerPage ($this->view->conf->postsPerPage ());
		$this->view->entryPaginator->_currentPage ($page);
		
		$this->view->cat_aside = $catDAO->listCategories ();
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

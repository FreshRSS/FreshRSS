<?php
  
class rssController extends ActionController {
	public function firstAction() {
		header('Content-Type: text/xml');
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		$this->view->_useLayout (false);
	}

	public function publicAction () {
		$entryDAO = new EntryDAO ();
		$entryDAO->_nbItemsPerPage (-1);

		$items = $entryDAO->listPublic ('low_to_high');

		try {
			$page = Request::param('page', 1);
			$nb = Request::param('nb', 15);
			$this->view->itemPaginator = new Paginator($items);
			$this->view->itemPaginator->_nbItemsPerPage($nb);
			$this->view->itemPaginator->_currentPage($page);
		} catch(CurrentPagePaginationException $e) {
			Error::error(
				404,
				array('error' => array('La page que vous cherchez n\'existe pas'))
			);
		}
	}

	public function getNbNotReadAction() {
	}
}

<?php

class entryController extends ActionController {
	public function firstAction () {
		$ajax = Request::param ('ajax');
		if ($ajax) {
			$this->view->_useLayout (false);
		}
	}
	public function lastAction () {
		$ajax = Request::param ('ajax');
		if (!$ajax) {
			Request::forward (array (), true);
		} else {
			Request::_param ('ajax');
		}
	}

	public function readAction () {
		$id = Request::param ('id');
		$is_read = Request::param ('is_read');
		
		if ($is_read) {
			$is_read = true;
		} else {
			$is_read = false;
		}
		
		$values = array (
			'is_read' => $is_read,
		);
		
		$entryDAO = new EntryDAO ();
		if ($id == false) {
			$entryDAO->updateEntries ($values);
		} else {
			$entryDAO->updateEntry ($id, $values);
		}
	}
	
	public function bookmarkAction () {
		$id = Request::param ('id');
		$is_fav = Request::param ('is_favorite');
		
		if ($is_fav) {
			$is_fav = true;
		} else {
			$is_fav = false;
		}
		
		$entryDAO = new EntryDAO ();
		if ($id != false) {
			$entry = $entryDAO->searchById ($id);
			
			if ($entry != false) {
				$values = array (
					'is_favorite' => $is_fav,
				);
			
				$entryDAO->updateEntry ($entry->id (), $values);
			}
		}
	}
}

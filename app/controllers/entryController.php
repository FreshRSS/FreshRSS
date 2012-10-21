<?php

class entryController extends ActionController {
	public function readAction () {
		$id = Request::param ('id');
		$is_read = Request::param ('is_read');
		
		if ($is_read) {
			$is_read = true;
		} else {
			$is_read = false;
		}
		
		$entryDAO = new EntryDAO ();
		if ($id == false) {
			$entries = $entryDAO->listNotReadEntries ();
		} else {
			$entry = $entryDAO->searchById ($id);
			$entries = $entry !== false ? array ($entry) : array ();
		}
		
		foreach ($entries as $entry) {
			$values = array (
				'is_read' => $is_read,
			);
			
			$entryDAO->updateEntry ($entry->id (), $values);
		}
		
		Request::forward (array (), true);
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
		
		Request::forward (array (), true);
	}
}

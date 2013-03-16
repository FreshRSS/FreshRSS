<?php

class entryController extends ActionController {
	public function firstAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array ('Vous n\'avez pas le droit d\'accéder à cette page'))
			);
		}
		
		$ajax = Request::param ('ajax');
		if ($ajax) {
			$this->view->_useLayout (false);
		}
	}
	public function lastAction () {
		$ajax = Request::param ('ajax');
		if (!$ajax) {
			Request::forward (array (
				'c' => 'index',
				'a' => 'index',
				'params' => $this->params
			), true);
		} else {
			Request::_param ('ajax');
		}
	}

	public function readAction () {
		$id = Request::param ('id');
		$is_read = Request::param ('is_read');
		$get = Request::param ('get');
		
		if ($is_read) {
			$is_read = true;
		} else {
			$is_read = false;
		}
		
		$entryDAO = new EntryDAO ();
		if ($id == false) {
			if (!$get) {
				$entryDAO->markReadEntries ($is_read);
			} else {
				$typeGet = $get[0];
				$get = substr ($get, 2);

				if ($typeGet == 'c') {
					$entryDAO->markReadCat ($get, $is_read);
					$this->params = array ('get' => 'c_' . $get);
				} elseif ($typeGet == 'f') {
					$entryDAO->markReadFeed ($get, $is_read);
					$this->params = array ('get' => 'f_' . $get);
				}
			}
			
			// notif
			$notif = array (
				'type' => 'good',
				'content' => 'Les flux ont été marqués comme lu'
			);
			Session::_param ('notification', $notif);
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

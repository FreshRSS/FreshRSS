<?php

class configureController extends ActionController {
	public function categorizeAction () {
		$catDAO = new CategoryDAO ();
		
		if (Request::isPost ()) {
			$cats = Request::param ('categories', array ());
			$ids = Request::param ('ids', array ());
			$newCat = Request::param ('new_category');
			
			foreach ($cats as $key => $name) {
				if (strlen ($name) > 0) {
					$cat = new Category ($name);
					$values = array (
						'name' => $cat->name (),
						'color' => $cat->color ()
					);
					$catDAO->updateCategory ($ids[$key], $values);
				} else {
					$catDAO->deleteCategory ($ids[$key]);
				}
			}
			
			if ($newCat != false) {
				$cat = new Category ($newCat);
				$values = array (
					'id' => $cat->id (),
					'name' => $cat->name (),
					'color' => $cat->color ()
				);
				$catDAO->addCategory ($values);
			}
			
		}
		
		$this->view->categories = $catDAO->listCategories ();
	}
	
	public function fluxAction () {
		$feedDAO = new FeedDAO ();
		$this->view->feeds = $feedDAO->listFeeds ();
		
		$id = Request::param ('id');
		
		$this->view->flux = false;
		if ($id != false) {
			$this->view->flux = $feedDAO->searchById ($id);
			
			$catDAO = new CategoryDAO ();
			$this->view->categories = $catDAO->listCategories ();
			
			if (Request::isPost () && $this->view->flux) {
				$cat = Request::param ('category');
				$values = array (
					'category' => $cat
				);
				$feedDAO->updateFeed ($id, $values);
				
				$this->view->flux->_category ($cat);
			}
		}
	}
	
	public function displayAction () {
		if (Request::isPost ()) {
			$nb = Request::param ('posts_per_page', 10);
			$view = Request::param ('default_view', 'all');
			$display = Request::param ('display_posts', 'no');
			$sort = Request::param ('sort_order', 'low_to_high');
			$old = Request::param ('old_entries', 3);
		
			$this->view->conf->_postsPerPage (intval ($nb));
			$this->view->conf->_defaultView ($view);
			$this->view->conf->_displayPosts ($display);
			$this->view->conf->_sortOrder ($sort);
			$this->view->conf->_oldEntries ($old);
		
			$values = array (
				'posts_per_page' => $this->view->conf->postsPerPage (),
				'default_view' => $this->view->conf->defaultView (),
				'display_posts' => $this->view->conf->displayPosts (),
				'sort_order' => $this->view->conf->sortOrder (),
				'old_entries' => $this->view->conf->oldEntries (),
			);
		
			$confDAO = new RSSConfigurationDAO ();
			$confDAO->update ($values);
			Session::_param ('conf', $this->view->conf);
		}
	}
	
	public function importExportAction () {
		$this->view->req = Request::param ('q');
		
		if ($this->view->req == 'export') {
			View::_title ('feeds_opml.xml');
			
			$this->view->_useLayout (false);
			header('Content-type: text/xml');
			
			$feedDAO = new FeedDAO ();
			$catDAO = new CategoryDAO ();
			
			$list = array ();
			foreach ($catDAO->listCategories () as $key => $cat) {
				$list[$key]['name'] = $cat->name ();
				$list[$key]['feeds'] = $feedDAO->listByCategory ($cat->id ());
			}
			
			$this->view->categories = $list;
		} elseif ($this->view->req == 'import' && Request::isPost ()) {
			if ($_FILES['file']['error'] == 0) {
				list ($categories, $feeds) = opml_import (file_get_contents ($_FILES['file']['tmp_name']));
				
				Request::_param ('q', 'null');
				Request::_param ('categories', $categories);
				Request::_param ('feeds', $feeds);
				Request::forward (array ('c' => 'feed', 'a' => 'massiveImport'));
			}
		}
	}
	
	public function shortcutAction () {
		$list_keys = array ('a', 'b', 'backspace', 'c', 'd', 'delete', 'down', 'e', 'end', 'enter',
		                    'escape', 'f', 'g', 'h', 'i', 'insert', 'j', 'k', 'l', 'left',
		                    'm', 'n', 'o', 'p', 'page_down', 'page_up', 'q', 'r', 'return', 'right',
		                    's', 'space', 't', 'tab', 'u', 'up', 'v', 'w', 'x', 'y',
		                    'z', '0', '1', '2', '3', '4', '5', '6', '7', '8',
		                    '9', 'f1', 'f2', 'f3', 'f4', 'f5', 'f6', 'f7', 'f8', 'f9',
		                    'f10', 'f11', 'f12');
		$this->view->list_keys = $list_keys;
		$list_names = array ('mark_read', 'mark_favorite', 'go_website', 'next_entry',
		                     'prev_entry', 'next_page', 'prev_page');
		
		if (Request::isPost ()) {
			$shortcuts = Request::param ('shortcuts');
			$shortcuts_ok = array ();
			
			foreach ($shortcuts as $key => $value) {
				if (in_array ($key, $list_names)
				 && in_array ($value, $list_keys)) {
					$shortcuts_ok[$key] = $value;
				}
			}
			
			$this->view->conf->_shortcuts ($shortcuts_ok);
			
			$values = array (
				'shortcuts' => $this->view->conf->shortcuts ()
			);
			
			$confDAO = new RSSConfigurationDAO ();
			$confDAO->update ($values);
			Session::_param ('conf', $this->view->conf);
		}
	}
}

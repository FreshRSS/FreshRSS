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
			
			$catDAO->save ();
			
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
		
			$this->view->conf->_postsPerPage (intval ($nb));
			$this->view->conf->_defaultView ($view);
			$this->view->conf->_displayPosts ($display);
			$this->view->conf->_sortOrder ($sort);
		
			$values = array (
				'posts_per_page' => $this->view->conf->postsPerPage (),
				'default_view' => $this->view->conf->defaultView (),
				'display_posts' => $this->view->conf->displayPosts (),
				'sort_order' => $this->view->conf->sortOrder ()
			);
		
			$confDAO = new RSSConfigurationDAO ();
			$confDAO->save ($values);
			Session::_param ('conf', $this->view->conf);
		}
	}
}

<?php

class FreshRSS_configure_Controller extends Minz_ActionController {
	public function firstAction() {
		if (!$this->view->loginOk) {
			Minz_Error::error(
				403,
				array('error' => array(Minz_Translate::t('access_denied')))
			);
		}

		$catDAO = new FreshRSS_CategoryDAO();
		$catDAO->checkDefault();
	}

	public function categorizeAction() {
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$catDAO = new FreshRSS_CategoryDAO();
		$defaultCategory = $catDAO->getDefault();
		$defaultId = $defaultCategory->id();

		if (Minz_Request::isPost()) {
			$cats = Minz_Request::param('categories', array());
			$ids = Minz_Request::param('ids', array());
			$newCat = trim(Minz_Request::param('new_category', ''));

			foreach ($cats as $key => $name) {
				if (strlen($name) > 0) {
					$cat = new FreshRSS_Category($name);
					$values = array(
						'name' => $cat->name(),
					);
					$catDAO->updateCategory($ids[$key], $values);
				} elseif ($ids[$key] != $defaultId) {
					$feedDAO->changeCategory($ids[$key], $defaultId);
					$catDAO->deleteCategory($ids[$key]);
				}
			}

			if ($newCat != '') {
				$cat = new FreshRSS_Category($newCat);
				$values = array(
					'id' => $cat->id(),
					'name' => $cat->name(),
				);

				if ($catDAO->searchByName($newCat) == null) {
					$catDAO->addCategory($values);
				}
			}
			invalidateHttpCache();

			$notif = array(
				'type' => 'good',
				'content' => Minz_Translate::t('categories_updated')
			);
			Minz_Session::_param('notification', $notif);

			Minz_Request::forward(array('c' => 'configure', 'a' => 'categorize'), true);
		}

		$this->view->categories = $catDAO->listCategories(false);
		$this->view->defaultCategory = $catDAO->getDefault();
		$this->view->feeds = $feedDAO->listFeeds();

		Minz_View::prependTitle(Minz_Translate::t('categories_management') . ' · ');
	}

	public function feedAction() {
		$catDAO = new FreshRSS_CategoryDAO();
		$this->view->categories = $catDAO->listCategories(false);

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeeds();

		$id = Minz_Request::param('id');
		if ($id == false && !empty($this->view->feeds)) {
			$id = current($this->view->feeds)->id();
		}

		$this->view->flux = false;
		if ($id != false) {
			$this->view->flux = $this->view->feeds[$id];

			if (!$this->view->flux) {
				Minz_Error::error(
					404,
					array('error' => array(Minz_Translate::t('page_not_found')))
				);
			} else {
				if (Minz_Request::isPost() && $this->view->flux) {
					$user = Minz_Request::param('http_user', '');
					$pass = Minz_Request::param('http_pass', '');

					$httpAuth = '';
					if ($user != '' || $pass != '') {
						$httpAuth = $user . ':' . $pass;
					}

					$cat = intval(Minz_Request::param('category', 0));

					$values = array(
						'name' => Minz_Request::param('name', ''),
						'description' => sanitizeHTML(Minz_Request::param('description', '', true)),
						'website' => Minz_Request::param('website', ''),
						'url' => Minz_Request::param('url', ''),
						'category' => $cat,
						'pathEntries' => Minz_Request::param('path_entries', ''),
						'priority' => intval(Minz_Request::param('priority', 0)),
						'httpAuth' => $httpAuth,
						'keep_history' => intval(Minz_Request::param('keep_history', -2)),
						'ttl' => intval(Minz_Request::param('ttl', -2)),
					);

					if ($feedDAO->updateFeed($id, $values)) {
						$this->view->flux->_category($cat);
						$this->view->flux->faviconPrepare();
						$notif = array(
							'type' => 'good',
							'content' => Minz_Translate::t('feed_updated')
						);
					} else {
						$notif = array(
							'type' => 'bad',
							'content' => Minz_Translate::t('error_occurred_update')
						);
					}
					invalidateHttpCache();

					Minz_Session::_param('notification', $notif);
					Minz_Request::forward(array('c' => 'configure', 'a' => 'feed', 'params' => array('id' => $id)), true);
				}

				Minz_View::prependTitle(Minz_Translate::t('rss_feed_management') . ' — ' . $this->view->flux->name() . ' · ');
			}
		} else {
			Minz_View::prependTitle(Minz_Translate::t('rss_feed_management') . ' · ');
		}
	}

	public function displayAction() {
		if (Minz_Request::isPost()) {
			$this->view->conf->_language(Minz_Request::param('language', 'en'));
			$themeId = Minz_Request::param('theme', '');
			if ($themeId == '') {
				$themeId = FreshRSS_Themes::defaultTheme;
			}
			$this->view->conf->_theme($themeId);
			$this->view->conf->_content_width(Minz_Request::param('content_width', 'thin'));
			$this->view->conf->_topline_read(Minz_Request::param('topline_read', false));
			$this->view->conf->_topline_favorite(Minz_Request::param('topline_favorite', false));
			$this->view->conf->_topline_date(Minz_Request::param('topline_date', false));
			$this->view->conf->_topline_link(Minz_Request::param('topline_link', false));
			$this->view->conf->_bottomline_read(Minz_Request::param('bottomline_read', false));
			$this->view->conf->_bottomline_favorite(Minz_Request::param('bottomline_favorite', false));
			$this->view->conf->_bottomline_sharing(Minz_Request::param('bottomline_sharing', false));
			$this->view->conf->_bottomline_tags(Minz_Request::param('bottomline_tags', false));
			$this->view->conf->_bottomline_date(Minz_Request::param('bottomline_date', false));
			$this->view->conf->_bottomline_link(Minz_Request::param('bottomline_link', false));
			$this->view->conf->save();

			Minz_Session::_param('language', $this->view->conf->language);
			Minz_Translate::reset();
			invalidateHttpCache();

			$notif = array(
				'type' => 'good',
				'content' => Minz_Translate::t('configuration_updated')
			);
			Minz_Session::_param('notification', $notif);

			Minz_Request::forward(array('c' => 'configure', 'a' => 'display'), true);
		}

		$this->view->themes = FreshRSS_Themes::get();

		Minz_View::prependTitle(Minz_Translate::t('display_configuration') . ' · ');
	}

	public function readingAction() {
		if (Minz_Request::isPost()) {
			$this->view->conf->_posts_per_page(Minz_Request::param('posts_per_page', 10));
			$this->view->conf->_view_mode(Minz_Request::param('view_mode', 'normal'));
			$this->view->conf->_default_view((int)Minz_Request::param('default_view', FreshRSS_Entry::STATE_ALL));
			$this->view->conf->_auto_load_more(Minz_Request::param('auto_load_more', false));
			$this->view->conf->_display_posts(Minz_Request::param('display_posts', false));
			$this->view->conf->_onread_jump_next(Minz_Request::param('onread_jump_next', false));
			$this->view->conf->_lazyload(Minz_Request::param('lazyload', false));
			$this->view->conf->_sticky_post(Minz_Request::param('sticky_post', false));
			$this->view->conf->_reading_confirm(Minz_Request::param('reading_confirm', false));
			$this->view->conf->_sort_order(Minz_Request::param('sort_order', 'DESC'));
			$this->view->conf->_mark_when(array(
				'article' => Minz_Request::param('mark_open_article', false),
				'site' => Minz_Request::param('mark_open_site', false),
				'scroll' => Minz_Request::param('mark_scroll', false),
				'reception' => Minz_Request::param('mark_upon_reception', false),
			));
			$this->view->conf->save();

			Minz_Session::_param('language', $this->view->conf->language);
			Minz_Translate::reset();
			invalidateHttpCache();

			$notif = array(
				'type' => 'good',
				'content' => Minz_Translate::t('configuration_updated')
			);
			Minz_Session::_param('notification', $notif);

			Minz_Request::forward(array('c' => 'configure', 'a' => 'reading'), true);
		}

		Minz_View::prependTitle(Minz_Translate::t('reading_configuration') . ' · ');
	}

	public function sharingAction() {
		if (Minz_Request::isPost()) {
			$params = Minz_Request::params();
			$this->view->conf->_sharing($params['share']);
			$this->view->conf->save();
			invalidateHttpCache();

			$notif = array(
				'type' => 'good',
				'content' => Minz_Translate::t('configuration_updated')
			);
			Minz_Session::_param('notification', $notif);

			Minz_Request::forward(array('c' => 'configure', 'a' => 'sharing'), true);
		}

		Minz_View::prependTitle(Minz_Translate::t('sharing') . ' · ');
	}

	public function shortcutAction() {
		$list_keys = array('a', 'b', 'backspace', 'c', 'd', 'delete', 'down', 'e', 'end', 'enter',
		                    'escape', 'f', 'g', 'h', 'home', 'i', 'insert', 'j', 'k', 'l', 'left',
		                    'm', 'n', 'o', 'p', 'page_down', 'page_up', 'q', 'r', 'return', 'right',
		                    's', 'space', 't', 'tab', 'u', 'up', 'v', 'w', 'x', 'y',
		                    'z', '0', '1', '2', '3', '4', '5', '6', '7', '8',
		                    '9', 'f1', 'f2', 'f3', 'f4', 'f5', 'f6', 'f7', 'f8', 'f9',
		                    'f10', 'f11', 'f12');
		$this->view->list_keys = $list_keys;

		if (Minz_Request::isPost()) {
			$shortcuts = Minz_Request::param('shortcuts');
			$shortcuts_ok = array();

			foreach ($shortcuts as $key => $value) {
				if (in_array($value, $list_keys)) {
					$shortcuts_ok[$key] = $value;
				}
			}

			$this->view->conf->_shortcuts($shortcuts_ok);
			$this->view->conf->save();
			invalidateHttpCache();

			$notif = array(
				'type' => 'good',
				'content' => Minz_Translate::t('shortcuts_updated')
			);
			Minz_Session::_param('notification', $notif);

			Minz_Request::forward(array('c' => 'configure', 'a' => 'shortcut'), true);
		}

		Minz_View::prependTitle(Minz_Translate::t('shortcuts') . ' · ');
	}

	public function usersAction() {
		Minz_View::prependTitle(Minz_Translate::t('users') . ' · ');
	}

	public function archivingAction() {
		if (Minz_Request::isPost()) {
			$old = Minz_Request::param('old_entries', 3);
			$keepHistoryDefault = Minz_Request::param('keep_history_default', 0);
			$ttlDefault = Minz_Request::param('ttl_default', -2);

			$this->view->conf->_old_entries($old);
			$this->view->conf->_keep_history_default($keepHistoryDefault);
			$this->view->conf->_ttl_default($ttlDefault);
			$this->view->conf->save();
			invalidateHttpCache();

			$notif = array(
				'type' => 'good',
				'content' => Minz_Translate::t('configuration_updated')
			);
			Minz_Session::_param('notification', $notif);

			Minz_Request::forward(array('c' => 'configure', 'a' => 'archiving'), true);
		}

		Minz_View::prependTitle(Minz_Translate::t('archiving_configuration') . ' · ');

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$this->view->nb_total = $entryDAO->count();
		$this->view->size_user = $entryDAO->size();

		if (Minz_Configuration::isAdmin(Minz_Session::param('currentUser', '_'))) {
			$this->view->size_total = $entryDAO->size(true);
		}
	}
	
	public function queriesAction() {
		if (Minz_Request::isPost()) {
			$queries = Minz_Request::param('queries', array());

			foreach ($queries as $key => $query) {
				if (!$query['name']) {
					$query['name'] = Minz_Translate::t('query_number', $key + 1);
				}
			}
			$this->view->conf->_queries($queries);
			$this->view->conf->save();

			$notif = array(
				'type' => 'good',
				'content' => Minz_Translate::t('configuration_updated')
			);
			Minz_Session::_param('notification', $notif);

			Minz_Request::forward(array('c' => 'configure', 'a' => 'queries'), true);
		} else {
			$this->view->query_get = array();
			foreach ($this->view->conf->queries as $key => $query) {
				if (!isset($query['get'])) {
					continue;
				}

				switch ($query['get'][0]) {
				case 'c':
					$dao = new FreshRSS_CategoryDAO();
					$category = $dao->searchById(substr($query['get'], 2));
					$this->view->query_get[$key] = array(
						'type' => 'category',
						'name' => $category->name(),
					);
					break;
				case 'f':
					$dao = FreshRSS_Factory::createFeedDao();
					$feed = $dao->searchById(substr($query['get'], 2));
					$this->view->query_get[$key] = array(
						'type' => 'feed',
						'name' => $feed->name(),
					);
					break;
				case 's':
					$this->view->query_get[$key] = array(
						'type' => 'favorite',
						'name' => 'favorite',
					);
					break;
				case 'a':
					$this->view->query_get[$key] = array(
						'type' => 'all',
						'name' => 'all',
					);
					break;
				}
			}
		}

		Minz_View::prependTitle(Minz_Translate::t('queries') . ' · ');
	}
	
	public function addQueryAction() {
		$queries = $this->view->conf->queries;
		$query = Minz_Request::params();
		$query['name'] = Minz_Translate::t('query_number', count($queries) + 1);
		unset($query['output']);
		unset($query['token']);
		$queries[] = $query;
		$this->view->conf->_queries($queries);
		$this->view->conf->save();

		// Minz_Request::forward(array('params' => $query), true);
		Minz_Request::forward(array('c' => 'configure', 'a' => 'queries'), true);
	}
}

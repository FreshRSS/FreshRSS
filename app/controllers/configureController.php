<?php

class configureController extends ActionController {
	public function firstAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Error::error (
				403,
				array ('error' => array (Translate::t ('access_denied')))
			);
		}

		$catDAO = new CategoryDAO ();
		$catDAO->checkDefault ();
	}

	public function categorizeAction () {
		$feedDAO = new FeedDAO ();
		$catDAO = new CategoryDAO ();
		$catDAO->checkDefault ();
		$defaultCategory = $catDAO->getDefault ();
		$defaultId = $defaultCategory->id ();

		if (Request::isPost ()) {
			$cats = Request::param ('categories', array ());
			$ids = Request::param ('ids', array ());
			$newCat = trim (Request::param ('new_category', ''));

			foreach ($cats as $key => $name) {
				if (strlen ($name) > 0) {
					$cat = new Category ($name);
					$values = array (
						'name' => $cat->name (),
						'color' => $cat->color ()
					);
					$catDAO->updateCategory ($ids[$key], $values);
				} elseif ($ids[$key] != $defaultId) {
					$feedDAO->changeCategory ($ids[$key], $defaultId);
					$catDAO->deleteCategory ($ids[$key]);
				}
			}

			if ($newCat != '') {
				$cat = new Category ($newCat);
				$values = array (
					'id' => $cat->id (),
					'name' => $cat->name (),
					'color' => $cat->color ()
				);

				if ($catDAO->searchByName ($newCat) == false) {
					$catDAO->addCategory ($values);
				}
			}

			// notif
			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('categories_updated')
			);
			Session::_param ('notification', $notif);

			Request::forward (array ('c' => 'configure', 'a' => 'categorize'), true);
		}

		$this->view->categories = $catDAO->listCategories (false);
		$this->view->defaultCategory = $catDAO->getDefault ();
		$this->view->feeds = $feedDAO->listFeeds ();
		$this->view->flux = false;

		View::prependTitle (Translate::t ('categories_management') . ' - ');
	}

	public function feedAction () {
		$catDAO = new CategoryDAO ();
		$this->view->categories = $catDAO->listCategories (false);

		$feedDAO = new FeedDAO ();
		$this->view->feeds = $feedDAO->listFeeds ();

		$id = Request::param ('id');
		if ($id == false && !empty ($this->view->feeds)) {
			$id = current ($this->view->feeds)->id ();
		}

		$this->view->flux = false;
		if ($id != false) {
			$this->view->flux = $this->view->feeds[$id];

			if (!$this->view->flux) {
				Error::error (
					404,
					array ('error' => array (Translate::t ('page_not_found')))
				);
			} else {
				if (Request::isPost () && $this->view->flux) {
					$name = Request::param ('name', '');
					$description = Request::param('description', '');
					$website = Request::param('website', '');
					$url = Request::param('url', '');
					$hist = Request::param ('keep_history', 'no');
					$cat = Request::param ('category', 0);
					$path = Request::param ('path_entries', '');
					$priority = Request::param ('priority', 0);
					$user = Request::param ('http_user', '');
					$pass = Request::param ('http_pass', '');

					$keep_history = false;
					if ($hist == 'yes') {
						$keep_history = true;
					}

					$httpAuth = '';
					if ($user != '' || $pass != '') {
						$httpAuth = $user . ':' . $pass;
					}

					$values = array (
						'name' => $name,
						'description' => $description,
						'website' => $website,
						'url' => $url,
						'category' => $cat,
						'pathEntries' => $path,
						'priority' => $priority,
						'httpAuth' => $httpAuth,
						'keep_history' => $keep_history
					);

					if ($feedDAO->updateFeed ($id, $values)) {
						$this->view->flux->_category ($cat);

						$notif = array (
							'type' => 'good',
							'content' => Translate::t ('feed_updated')
						);
					} else {
						$notif = array (
							'type' => 'bad',
							'content' => Translate::t ('error_occurred_update')
						);
					}

					Session::_param ('notification', $notif);
					Request::forward (array ('c' => 'configure', 'a' => 'feed', 'params' => array ('id' => $id)), true);
				}

				View::prependTitle (Translate::t ('rss_feed_management') . ' - ' . $this->view->flux->name () . ' - ');
			}
		} else {
			View::prependTitle (Translate::t ('rss_feed_management') . ' - ');
		}
	}

	public function displayAction () {
		if (Request::isPost ()) {
			$current_token = $this->view->conf->token ();

			$language = Request::param ('language', 'en');
			$nb = Request::param ('posts_per_page', 10);
			$mode = Request::param ('view_mode', 'normal');
			$view = Request::param ('default_view', 'all');
			$auto_load_more = Request::param ('auto_load_more', 'no');
			$display = Request::param ('display_posts', 'no');
			$onread_jump_next = Request::param ('onread_jump_next', 'no');
			$lazyload = Request::param ('lazyload', 'no');
			$sort = Request::param ('sort_order', 'low_to_high');
			$old = Request::param ('old_entries', 3);
			$mail = Request::param ('mail_login', false);
			$anon = Request::param ('anon_access', 'no');
			$token = Request::param ('token', $current_token);
			$openArticle = Request::param ('mark_open_article', 'no');
			$openSite = Request::param ('mark_open_site', 'no');
			$scroll = Request::param ('mark_scroll', 'no');
			$theme = Request::param ('theme', 'default');
			$topline_read = Request::param ('topline_read', 'no');
			$topline_favorite = Request::param ('topline_favorite', 'no');
			$topline_date = Request::param ('topline_date', 'no');
			$topline_link = Request::param ('topline_link', 'no');
			$bottomline_read = Request::param ('bottomline_read', 'no');
			$bottomline_favorite = Request::param ('bottomline_favorite', 'no');
			$bottomline_sharing = Request::param ('bottomline_sharing', 'no');
			$bottomline_tags = Request::param ('bottomline_tags', 'no');
			$bottomline_date = Request::param ('bottomline_date', 'no');
			$bottomline_link = Request::param ('bottomline_link', 'no');

			$this->view->conf->_language ($language);
			$this->view->conf->_postsPerPage (intval ($nb));
			$this->view->conf->_viewMode ($mode);
			$this->view->conf->_defaultView ($view);
			$this->view->conf->_autoLoadMore ($auto_load_more);
			$this->view->conf->_displayPosts ($display);
			$this->view->conf->_onread_jump_next ($onread_jump_next);
			$this->view->conf->_lazyload ($lazyload);
			$this->view->conf->_sortOrder ($sort);
			$this->view->conf->_oldEntries ($old);
			$this->view->conf->_mailLogin ($mail);
			$this->view->conf->_anonAccess ($anon);
			$this->view->conf->_token ($token);
			$this->view->conf->_markWhen (array (
				'article' => $openArticle,
				'site' => $openSite,
				'scroll' => $scroll,
			));
			$this->view->conf->_theme ($theme);
			$this->view->conf->_topline_read ($topline_read);
			$this->view->conf->_topline_favorite ($topline_favorite);
			$this->view->conf->_topline_date ($topline_date);
			$this->view->conf->_topline_link ($topline_link);
			$this->view->conf->_bottomline_read ($bottomline_read);
			$this->view->conf->_bottomline_favorite ($bottomline_favorite);
			$this->view->conf->_bottomline_sharing ($bottomline_sharing);
			$this->view->conf->_bottomline_tags ($bottomline_tags);
			$this->view->conf->_bottomline_date ($bottomline_date);
			$this->view->conf->_bottomline_link ($bottomline_link);

			$values = array (
				'language' => $this->view->conf->language (),
				'posts_per_page' => $this->view->conf->postsPerPage (),
				'view_mode' => $this->view->conf->viewMode (),
				'default_view' => $this->view->conf->defaultView (),
				'auto_load_more' => $this->view->conf->autoLoadMore (),
				'display_posts' => $this->view->conf->displayPosts (),
				'onread_jump_next' => $this->view->conf->onread_jump_next (), 
				'lazyload' => $this->view->conf->lazyload (),
				'sort_order' => $this->view->conf->sortOrder (),
				'old_entries' => $this->view->conf->oldEntries (),
				'mail_login' => $this->view->conf->mailLogin (),
				'anon_access' => $this->view->conf->anonAccess (),
				'token' => $this->view->conf->token (),
				'mark_when' => $this->view->conf->markWhen (),
				'theme' => $this->view->conf->theme (),
				'topline_read' => $this->view->conf->toplineRead () ? 'yes' : 'no',
				'topline_favorite' => $this->view->conf->toplineFavorite () ? 'yes' : 'no',
				'topline_date' => $this->view->conf->toplineDate () ? 'yes' : 'no',
				'topline_link' => $this->view->conf->toplineLink () ? 'yes' : 'no',
				'bottomline_read' => $this->view->conf->bottomlineRead () ? 'yes' : 'no',
				'bottomline_favorite' => $this->view->conf->bottomlineFavorite () ? 'yes' : 'no',
				'bottomline_sharing' => $this->view->conf->bottomlineSharing () ? 'yes' : 'no',
				'bottomline_tags' => $this->view->conf->bottomlineTags () ? 'yes' : 'no',
				'bottomline_date' => $this->view->conf->bottomlineDate () ? 'yes' : 'no',
				'bottomline_link' => $this->view->conf->bottomlineLink () ? 'yes' : 'no',
			);

			$confDAO = new RSSConfigurationDAO ();
			$confDAO->update ($values);
			Session::_param ('conf', $this->view->conf);
			Session::_param ('mail', $this->view->conf->mailLogin ());

			Session::_param ('language', $this->view->conf->language ());
			Translate::reset ();

			// notif
			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('configuration_updated')
			);
			Session::_param ('notification', $notif);

			Request::forward (array ('c' => 'configure', 'a' => 'display'), true);
		}

		$this->view->themes = RSSThemes::get();

		View::prependTitle (Translate::t ('general_and_reading_management') . ' - ');

		$entryDAO = new EntryDAO ();
		$this->view->nb_total = $entryDAO->count ();
	}

	public function sharingAction () {
		if (Request::isPost ()) {
			$urlShaarli = Request::param ('shaarli', '');

			$this->view->conf->_urlShaarli ($urlShaarli);

			$values = array (
				'url_shaarli' => $this->view->conf->urlShaarli ()
			);

			$confDAO = new RSSConfigurationDAO ();
			$confDAO->update ($values);
			Session::_param ('conf', $this->view->conf);

			// notif
			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('configuration_updated')
			);
			Session::_param ('notification', $notif);

			Request::forward (array ('c' => 'configure', 'a' => 'sharing'), true);
		}

		View::prependTitle (Translate::t ('sharing_management') . ' - ');

		$entryDAO = new EntryDAO ();
		$this->view->nb_total = $entryDAO->count ();
	}

	public function importExportAction () {
		$catDAO = new CategoryDAO ();
		$this->view->categories = $catDAO->listCategories ();

		$this->view->req = Request::param ('q');

		if ($this->view->req == 'export') {
			View::_title ('freshrss_feeds.opml');

			$this->view->_useLayout (false);
			header('Content-Type: application/xml; charset=utf-8');
			header('Content-disposition: attachment; filename=freshrss_feeds.opml');

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
				// on parse le fichier OPML pour récupérer les catégories et les flux associés
				try {
					list ($categories, $feeds) = opml_import (
						file_get_contents ($_FILES['file']['tmp_name'])
					);

					// On redirige vers le controller feed qui va se charger d'insérer les flux en BDD
					// les flux sont mis au préalable dans des variables de Request
					Request::_param ('q', 'null');
					Request::_param ('categories', $categories);
					Request::_param ('feeds', $feeds);
					Request::forward (array ('c' => 'feed', 'a' => 'massiveImport'));
				} catch (OpmlException $e) {
					Minz_Log::record ($e->getMessage (), Minz_Log::WARNING);

					$notif = array (
						'type' => 'bad',
						'content' => Translate::t ('bad_opml_file')
					);
					Session::_param ('notification', $notif);

					Request::forward (array (
						'c' => 'configure',
						'a' => 'importExport'
					), true);
				}
			}
		}

		$feedDAO = new FeedDAO ();
		$this->view->feeds = $feedDAO->listFeeds ();

		// au niveau de la vue, permet de ne pas voir un flux sélectionné dans la liste
		$this->view->flux = false;

		View::prependTitle (Translate::t ('import_export_opml') . ' - ');
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
		                     'prev_entry', 'next_page', 'prev_page', 'collapse_entry');

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

			// notif
			$notif = array (
				'type' => 'good',
				'content' => Translate::t ('shortcuts_updated')
			);
			Session::_param ('notification', $notif);

			Request::forward (array ('c' => 'configure', 'a' => 'shortcut'), true);
		}

		View::prependTitle (Translate::t ('shortcuts_management') . ' - ');
	}
}

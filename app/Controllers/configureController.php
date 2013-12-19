<?php

class FreshRSS_configure_Controller extends Minz_ActionController {
	public function firstAction () {
		if (login_is_conf ($this->view->conf) && !is_logged ()) {
			Minz_Error::error (
				403,
				array ('error' => array (Minz_Translate::t ('access_denied')))
			);
		}

		$catDAO = new FreshRSS_CategoryDAO ();
		$catDAO->checkDefault ();
	}

	public function categorizeAction () {
		$feedDAO = new FreshRSS_FeedDAO ();
		$catDAO = new FreshRSS_CategoryDAO ();
		$catDAO->checkDefault ();
		$defaultCategory = $catDAO->getDefault ();
		$defaultId = $defaultCategory->id ();

		if (Minz_Request::isPost ()) {
			$cats = Minz_Request::param ('categories', array ());
			$ids = Minz_Request::param ('ids', array ());
			$newCat = trim (Minz_Request::param ('new_category', ''));

			foreach ($cats as $key => $name) {
				if (strlen ($name) > 0) {
					$cat = new FreshRSS_Category ($name);
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
				$cat = new FreshRSS_Category ($newCat);
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
				'content' => Minz_Translate::t ('categories_updated')
			);
			Minz_Session::_param ('notification', $notif);

			Minz_Request::forward (array ('c' => 'configure', 'a' => 'categorize'), true);
		}

		$this->view->categories = $catDAO->listCategories (false);
		$this->view->defaultCategory = $catDAO->getDefault ();
		$this->view->feeds = $feedDAO->listFeeds ();
		$this->view->flux = false;

		Minz_View::prependTitle (Minz_Translate::t ('categories_management') . ' - ');
	}

	public function feedAction () {
		$catDAO = new FreshRSS_CategoryDAO ();
		$this->view->categories = $catDAO->listCategories (false);

		$feedDAO = new FreshRSS_FeedDAO ();
		$this->view->feeds = $feedDAO->listFeeds ();

		$id = Minz_Request::param ('id');
		if ($id == false && !empty ($this->view->feeds)) {
			$id = current ($this->view->feeds)->id ();
		}

		$this->view->flux = false;
		if ($id != false) {
			$this->view->flux = $this->view->feeds[$id];

			if (!$this->view->flux) {
				Minz_Error::error (
					404,
					array ('error' => array (Minz_Translate::t ('page_not_found')))
				);
			} else {
				if (Minz_Request::isPost () && $this->view->flux) {
					$name = Minz_Request::param ('name', '');
					$description = Minz_Request::param('description', '');
					$website = Minz_Request::param('website', '');
					$url = Minz_Request::param('url', '');
					$hist = Minz_Request::param ('keep_history', 'no');
					$cat = Minz_Request::param ('category', 0);
					$path = Minz_Request::param ('path_entries', '');
					$priority = Minz_Request::param ('priority', 0);
					$user = Minz_Request::param ('http_user', '');
					$pass = Minz_Request::param ('http_pass', '');

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
							'content' => Minz_Translate::t ('feed_updated')
						);
					} else {
						$notif = array (
							'type' => 'bad',
							'content' => Minz_Translate::t ('error_occurred_update')
						);
					}

					Minz_Session::_param ('notification', $notif);
					Minz_Request::forward (array ('c' => 'configure', 'a' => 'feed', 'params' => array ('id' => $id)), true);
				}

				Minz_View::prependTitle (Minz_Translate::t ('rss_feed_management') . ' - ' . $this->view->flux->name () . ' - ');
			}
		} else {
			Minz_View::prependTitle (Minz_Translate::t ('rss_feed_management') . ' - ');
		}
	}

	public function displayAction () {
		if (Minz_Request::isPost ()) {
			$current_token = $this->view->conf->token ();

			$language = Minz_Request::param ('language', 'en');
			$nb = Minz_Request::param ('posts_per_page', 10);
			$mode = Minz_Request::param ('view_mode', 'normal');
			$view = Minz_Request::param ('default_view', 'a');
			$auto_load_more = Minz_Request::param ('auto_load_more', 'no');
			$display = Minz_Request::param ('display_posts', 'no');
			$onread_jump_next = Minz_Request::param ('onread_jump_next', 'no');
			$lazyload = Minz_Request::param ('lazyload', 'no');
			$sort = Minz_Request::param ('sort_order', 'DESC');
			$old = Minz_Request::param ('old_entries', 3);
			$mail = Minz_Request::param ('mail_login', false);
			$anon = Minz_Request::param ('anon_access', 'no');
			$token = Minz_Request::param ('token', $current_token);
			$openArticle = Minz_Request::param ('mark_open_article', 'no');
			$openSite = Minz_Request::param ('mark_open_site', 'no');
			$scroll = Minz_Request::param ('mark_scroll', 'no');
			$reception = Minz_Request::param ('mark_upon_reception', 'no');
			$theme = Minz_Request::param ('theme', 'default');
			$topline_read = Minz_Request::param ('topline_read', 'no');
			$topline_favorite = Minz_Request::param ('topline_favorite', 'no');
			$topline_date = Minz_Request::param ('topline_date', 'no');
			$topline_link = Minz_Request::param ('topline_link', 'no');
			$bottomline_read = Minz_Request::param ('bottomline_read', 'no');
			$bottomline_favorite = Minz_Request::param ('bottomline_favorite', 'no');
			$bottomline_sharing = Minz_Request::param ('bottomline_sharing', 'no');
			$bottomline_tags = Minz_Request::param ('bottomline_tags', 'no');
			$bottomline_date = Minz_Request::param ('bottomline_date', 'no');
			$bottomline_link = Minz_Request::param ('bottomline_link', 'no');

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
				'reception' => $reception,
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

			$confDAO = new FreshRSS_ConfigurationDAO ();
			$confDAO->update ($values);
			Minz_Session::_param ('conf', $this->view->conf);
			Minz_Session::_param ('mail', $this->view->conf->mailLogin ());

			Minz_Session::_param ('language', $this->view->conf->language ());
			Minz_Translate::reset ();

			// notif
			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('configuration_updated')
			);
			Minz_Session::_param ('notification', $notif);

			Minz_Request::forward (array ('c' => 'configure', 'a' => 'display'), true);
		}

		$this->view->themes = FreshRSS_Themes::get();

		Minz_View::prependTitle (Minz_Translate::t ('general_and_reading_management') . ' - ');

		$entryDAO = new FreshRSS_EntryDAO ();
		$this->view->nb_total = $entryDAO->count ();
		$this->view->size_total = $entryDAO->size ();
	}

	public function sharingAction () {
		if (Minz_Request::isPost ()) {
			$this->view->conf->_sharing (array (
				'shaarli' => Minz_Request::param ('shaarli', ''),
				'poche' => Minz_Request::param ('poche', ''),
				'diaspora' => Minz_Request::param ('diaspora', ''),
				'twitter' => Minz_Request::param ('twitter', 'no') === 'yes',
				'g+' => Minz_Request::param ('g+', 'no') === 'yes',
				'facebook' => Minz_Request::param ('facebook', 'no') === 'yes',
				'email' => Minz_Request::param ('email', 'no') === 'yes',
				'print' => Minz_Request::param ('print', 'no') === 'yes'
			));

			$confDAO = new FreshRSS_ConfigurationDAO ();
			$confDAO->update ($this->view->conf->sharing ());
			Minz_Session::_param ('conf', $this->view->conf);

			// notif
			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('configuration_updated')
			);
			Minz_Session::_param ('notification', $notif);

			Minz_Request::forward (array ('c' => 'configure', 'a' => 'sharing'), true);
		}

		Minz_View::prependTitle (Minz_Translate::t ('sharing_management') . ' - ');

		$entryDAO = new FreshRSS_EntryDAO ();
		$this->view->nb_total = $entryDAO->count ();
	}

	public function importExportAction () {
		$catDAO = new FreshRSS_CategoryDAO ();
		$this->view->categories = $catDAO->listCategories ();

		$this->view->req = Minz_Request::param ('q');

		if ($this->view->req == 'export') {
			Minz_View::_title ('freshrss_feeds.opml');

			$this->view->_useLayout (false);
			header('Content-Type: application/xml; charset=utf-8');
			header('Content-disposition: attachment; filename=freshrss_feeds.opml');

			$feedDAO = new FreshRSS_FeedDAO ();
			$catDAO = new FreshRSS_CategoryDAO ();

			$list = array ();
			foreach ($catDAO->listCategories () as $key => $cat) {
				$list[$key]['name'] = $cat->name ();
				$list[$key]['feeds'] = $feedDAO->listByCategory ($cat->id ());
			}

			$this->view->categories = $list;
		} elseif ($this->view->req == 'import' && Minz_Request::isPost ()) {
			if ($_FILES['file']['error'] == 0) {
				// on parse le fichier OPML pour récupérer les catégories et les flux associés
				try {
					list ($categories, $feeds) = opml_import (
						file_get_contents ($_FILES['file']['tmp_name'])
					);

					// On redirige vers le controller feed qui va se charger d'insérer les flux en BDD
					// les flux sont mis au préalable dans des variables de Request
					Minz_Request::_param ('q', 'null');
					Minz_Request::_param ('categories', $categories);
					Minz_Request::_param ('feeds', $feeds);
					Minz_Request::forward (array ('c' => 'feed', 'a' => 'massiveImport'));
				} catch (FreshRSS_Opml_Exception $e) {
					Minz_Log::record ($e->getMessage (), Minz_Log::WARNING);

					$notif = array (
						'type' => 'bad',
						'content' => Minz_Translate::t ('bad_opml_file')
					);
					Minz_Session::_param ('notification', $notif);

					Minz_Request::forward (array (
						'c' => 'configure',
						'a' => 'importExport'
					), true);
				}
			}
		}

		$feedDAO = new FreshRSS_FeedDAO ();
		$this->view->feeds = $feedDAO->listFeeds ();

		// au niveau de la vue, permet de ne pas voir un flux sélectionné dans la liste
		$this->view->flux = false;

		Minz_View::prependTitle (Minz_Translate::t ('import_export_opml') . ' - ');
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
		                     'prev_entry', 'next_page', 'prev_page', 'collapse_entry',
		                     'load_more');

		if (Minz_Request::isPost ()) {
			$shortcuts = Minz_Request::param ('shortcuts');
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

			$confDAO = new FreshRSS_ConfigurationDAO ();
			$confDAO->update ($values);
			Minz_Session::_param ('conf', $this->view->conf);

			// notif
			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('shortcuts_updated')
			);
			Minz_Session::_param ('notification', $notif);

			Minz_Request::forward (array ('c' => 'configure', 'a' => 'shortcut'), true);
		}

		Minz_View::prependTitle (Minz_Translate::t ('shortcuts_management') . ' - ');
	}
}

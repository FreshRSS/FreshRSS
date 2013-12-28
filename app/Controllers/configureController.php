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
					$user = Minz_Request::param ('http_user', '');
					$pass = Minz_Request::param ('http_pass', '');

					$httpAuth = '';
					if ($user != '' || $pass != '') {
						$httpAuth = $user . ':' . $pass;
					}

					$values = array (
						'name' => Minz_Request::param ('name', ''),
						'description' => sanitizeHTML(Minz_Request::param('description', '', true)),
						'website' => Minz_Request::param('website', ''),
						'url' => Minz_Request::param('url', ''),
						'category' => intval(Minz_Request::param ('category', 0)),
						'pathEntries' => Minz_Request::param ('path_entries', ''),
						'priority' => intval(Minz_Request::param ('priority', 0)),
						'httpAuth' => $httpAuth,
						'keep_history' => intval(Minz_Request::param ('keep_history', -2)),
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
		if (Minz_Request::isPost()) {
			$this->view->conf->_language(Minz_Request::param('language', 'en'));
			$this->view->conf->_posts_per_page(Minz_Request::param('posts_per_page', 10));
			$this->view->conf->_view_mode(Minz_Request::param('view_mode', 'normal'));
			$this->view->conf->_default_view (Minz_Request::param('default_view', 'a'));
			$this->view->conf->_auto_load_more(Minz_Request::param('auto_load_more', false));
			$this->view->conf->_display_posts(Minz_Request::param('display_posts', false));
			$this->view->conf->_onread_jump_next(Minz_Request::param('onread_jump_next', false));
			$this->view->conf->_lazyload (Minz_Request::param('lazyload', false));
			$this->view->conf->_sort_order(Minz_Request::param('sort_order', 'DESC'));
			$this->view->conf->_mark_when (array(
				'article' => Minz_Request::param('mark_open_article', false),
				'site' => Minz_Request::param('mark_open_site', false),
				'scroll' => Minz_Request::param('mark_scroll', false),
				'reception' => Minz_Request::param('mark_upon_reception', false),
			));
			$this->view->conf->_theme(Minz_Request::param('theme', 'default'));
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

			Minz_Session::_param ('mail', $this->view->conf->mail_login);

			Minz_Session::_param ('language', $this->view->conf->language);
			Minz_Translate::reset ();

			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('configuration_updated')
			);
			Minz_Session::_param ('notification', $notif);

			Minz_Request::forward (array ('c' => 'configure', 'a' => 'display'), true);
		}

		$this->view->themes = FreshRSS_Themes::get();

		Minz_View::prependTitle (Minz_Translate::t ('reading_configuration') . ' - ');
	}

	public function sharingAction () {
		if (Minz_Request::isPost ()) {
			$this->view->conf->_sharing (array(
				'shaarli' => Minz_Request::param ('shaarli', false),
				'poche' => Minz_Request::param ('poche', false),
				'diaspora' => Minz_Request::param ('diaspora', false),
				'twitter' => Minz_Request::param ('twitter', false),
				'g+' => Minz_Request::param ('g+', false),
				'facebook' => Minz_Request::param ('facebook', false),
				'email' => Minz_Request::param ('email', false),
				'print' => Minz_Request::param ('print', false),
			));
			$this->view->conf->save();

			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('configuration_updated')
			);
			Minz_Session::_param ('notification', $notif);

			Minz_Request::forward (array ('c' => 'configure', 'a' => 'sharing'), true);
		}

		Minz_View::prependTitle (Minz_Translate::t ('sharing_management') . ' - ');
	}

	public function importExportAction () {
		require_once(LIB_PATH . '/lib_opml.php');
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

		if (Minz_Request::isPost ()) {
			$shortcuts = Minz_Request::param ('shortcuts');
			$shortcuts_ok = array ();

			foreach ($shortcuts as $key => $value) {
				if (in_array($value, $list_keys)) {
					$shortcuts_ok[$key] = $value;
				}
			}

			$this->view->conf->_shortcuts ($shortcuts_ok);
			$this->view->conf->save();

			$notif = array (
				'type' => 'good',
				'content' => Minz_Translate::t ('shortcuts_updated')
			);
			Minz_Session::_param ('notification', $notif);

			Minz_Request::forward (array ('c' => 'configure', 'a' => 'shortcut'), true);
		}

		Minz_View::prependTitle (Minz_Translate::t ('shortcuts_management') . ' - ');
	}

	public function usersAction() {
		if (Minz_Request::isPost()) {
			$ok = true;
			$current_token = $this->view->conf->token;

			$mail = Minz_Request::param('mail_login', false);
			$token = Minz_Request::param('token', $current_token);

			$this->view->conf->_mail_login($mail);
			$this->view->conf->_token($token);
			$ok &= $this->view->conf->save();

			Minz_Session::_param('mail', $this->view->conf->mail_login);

			if (Minz_Configuration::isAdmin()) {
				$anon = (Minz_Request::param('anon_access', false));
				$anon = ((bool)$anon) && ($anon !== 'no');
				if ($anon != Minz_Configuration::allowAnonymous()) {
					Minz_Configuration::_allowAnonymous($anon);
					$ok &= Minz_Configuration::writeFile();
				}
			}

			//TODO: use $ok
			$notif = array(
				'type' => 'good',
				'content' => Minz_Translate::t('configuration_updated')
			);
			Minz_Session::_param('notification', $notif);

			Minz_Request::forward(array('c' => 'configure', 'a' => 'users'), true);
		}

		Minz_View::prependTitle(Minz_Translate::t ('users') . ' - ');
	}

	public function archivingAction () {
		if (Minz_Request::isPost()) {
			$old = Minz_Request::param('old_entries', 3);
			$keepHistoryDefault = Minz_Request::param('keep_history_default', 0);

			$this->view->conf->_old_entries($old);
			$this->view->conf->_keep_history_default($keepHistoryDefault);
			$this->view->conf->save();

			$notif = array(
				'type' => 'good',
				'content' => Minz_Translate::t('configuration_updated')
			);
			Minz_Session::_param('notification', $notif);

			Minz_Request::forward(array('c' => 'configure', 'a' => 'archiving'), true);
		}

		Minz_View::prependTitle(Minz_Translate::t('archiving_configuration') . ' - ');

		$entryDAO = new FreshRSS_EntryDAO();
		$this->view->nb_total = $entryDAO->count();
		$this->view->size_total = $entryDAO->size();
	}
}

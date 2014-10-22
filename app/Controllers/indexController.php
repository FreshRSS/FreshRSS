<?php

/**
 * This class handles main actions of FreshRSS.
 */
class FreshRSS_index_Controller extends Minz_ActionController {

	public function indexAction() {
		// TODO: update the context with information from request.
		// TODO: then, in dedicated action, get corresponding entries

		$prefered_output = FreshRSS_Context::$conf->view_mode;
		Minz_Request::forward(array(
			'c' => 'index',
			'a' => $prefered_output
		));

		return;

		// On récupère les différents éléments de filtrage
		$this->view->state = Minz_Request::param('state', FreshRSS_Context::$conf->default_view);
		$state_param = Minz_Request::param('state', null);
		$filter = Minz_Request::param('search', '');
		$this->view->order = $order = Minz_Request::param('order', FreshRSS_Context::$conf->sort_order);
		$nb = Minz_Request::param('nb', FreshRSS_Context::$conf->posts_per_page);
		$first = Minz_Request::param('next', '');

		$ajax_request = Minz_Request::param('ajax', false);
		if ($output === 'reader') {
			$nb = max(1, round($nb / 2));
		}

		if ($this->view->state === FreshRSS_Entry::STATE_NOT_READ) {	//Any unread article in this category at all?
			switch ($getType) {
			case 'a':
				$hasUnread = $this->view->nb_not_read > 0;
				break;
			case 's':
				// This is deprecated. The favorite button does not exist anymore
				$hasUnread = $this->view->nb_favorites['unread'] > 0;
				break;
			case 'c':
				$hasUnread = (!isset($this->view->cat_aside[$getId]) ||
				              $this->view->cat_aside[$getId]->nbNotRead() > 0);
				break;
			case 'f':
				$myFeed = FreshRSS_CategoryDAO::findFeed($this->view->cat_aside, $getId);
				$hasUnread = ($myFeed === null) || ($myFeed->nbNotRead() > 0);
				break;
			default:
				$hasUnread = true;
				break;
			}
			if (!$hasUnread && ($state_param === null)) {
				$this->view->state = FreshRSS_Entry::STATE_ALL;
			}
		}

		$this->view->today = @strtotime('today');

		try {
			$entries = $entryDAO->listWhere($getType, $getId, $this->view->state, $order, $nb + 1, $first, $filter);

			// Si on a récupéré aucun article "non lus"
			// on essaye de récupérer tous les articles
			if ($this->view->state === FreshRSS_Entry::STATE_NOT_READ && empty($entries) && ($state_param === null) && ($filter == '')) {
				Minz_Log::debug('Conflicting information about nbNotRead!');
				$feedDAO = FreshRSS_Factory::createFeedDao();
				try {
					$feedDAO->updateCachedValues();
				} catch (Exception $ex) {
					Minz_Log::notice('Failed to automatically correct nbNotRead! ' + $ex->getMessage());
				}
				$this->view->state = FreshRSS_Entry::STATE_ALL;
				$entries = $entryDAO->listWhere($getType, $getId, $this->view->state, $order, $nb, $first, $filter);
			}
			Minz_Request::_param('state', $this->view->state);

			if (count($entries) <= $nb) {
				$this->view->nextId  = '';
			} else {	//We have more elements for pagination
				$lastEntry = array_pop($entries);
				$this->view->nextId  = $lastEntry->id();
			}

			$this->view->entries = $entries;
		} catch (FreshRSS_EntriesGetter_Exception $e) {
			Minz_Log::notice($e->getMessage());
			Minz_Error::error(404);
		}
	}

	/**
	 * This action displays the normal view of FreshRSS.
	 */
	public function normalAction() {
		if (!FreshRSS_Auth::hasAccess() && !Minz_Configuration::allowAnonymous()) {
			Minz_Request::forward(array('c' => 'auth', 'a' => 'login'));
			return;
		}

		try {
			$this->updateContext();
		} catch (Minz_Exception $e) {
			Minz_Error::error(404);
		}

		$this->view->categories = FreshRSS_Context::$categories;

		$title = FreshRSS_Context::$name;
		if (FreshRSS_Context::$get_unread > 0) {
			$title = '(' . FreshRSS_Context::$get_unread . ') · ' . $title;
		}
		Minz_View::prependTitle($title . ' · ');
	}

	/**
	 * This action displays the global view of FreshRSS.
	 */
	public function globalAction() {
		if (!FreshRSS_Auth::hasAccess() && !Minz_Configuration::allowAnonymous()) {
			Minz_Request::forward(array('c' => 'auth', 'a' => 'login'));
			return;
		}

		Minz_View::appendScript(Minz_Url::display('/scripts/global_view.js?' . @filemtime(PUBLIC_PATH . '/scripts/global_view.js')));

		try {
			$this->updateContext();
		} catch (Minz_Exception $e) {
			Minz_Error::error(404);
		}

		$this->view->categories = FreshRSS_Context::$categories;

		Minz_View::prependTitle(_t('gen.title.global_view') . ' · ');
	}

	/**
	 * This action displays the RSS feed of FreshRSS.
	 */
	public function rssAction() {
		$token = FreshRSS_Context::$conf->token;
		$token_param = Minz_Request::param('token', '');
		$token_is_ok = ($token != '' && $token === $token_param);

		// Check if user has access.
		if (!FreshRSS_Auth::hasAccess() &&
				!Minz_Configuration::allowAnonymous() &&
				!$token_is_ok) {
			Minz_Error::error(403);
		}

		try {
			$this->updateContext();
		} catch (Minz_Exception $e) {
			Minz_Error::error(404);
		}

		// No layout for RSS output.
		$this->view->rss_title = FreshRSS_Context::$name . ' | ' . Minz_View::title();
		$this->view->_useLayout(false);
		header('Content-Type: application/rss+xml; charset=utf-8');
	}

	/**
	 * This action updates the Context object by using request parameters.
	 */
	private function updateContext() {
		FreshRSS_Context::_get(Minz_Request::param('get', 'a'));
	}

	/**
	 * This action displays the about page of FreshRSS.
	 */
	public function aboutAction() {
		Minz_View::prependTitle(_t('about') . ' · ');
	}

	/**
	 * This action displays logs of FreshRSS for the current user.
	 */
	public function logsAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		Minz_View::prependTitle(_t('logs') . ' · ');

		if (Minz_Request::isPost()) {
			FreshRSS_LogDAO::truncate();
		}

		$logs = FreshRSS_LogDAO::lines();	//TODO: ask only the necessary lines

		//gestion pagination
		$page = Minz_Request::param('page', 1);
		$this->view->logsPaginator = new Minz_Paginator($logs);
		$this->view->logsPaginator->_nbItemsPerPage(50);
		$this->view->logsPaginator->_currentPage($page);
	}
}

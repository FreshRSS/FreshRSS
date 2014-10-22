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

		try {
			$entries = $this->listByContext();

			if (count($entries) > FreshRSS_Context::$number) {
				// We have more elements for pagination
				$last_entry = array_pop($entries);
				FreshRSS_Context::$next_id = $last_entry->id();
			}

			$this->view->entries = $entries;
		} catch (FreshRSS_EntriesGetter_Exception $e) {
			Minz_Log::notice($e->getMessage());
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

		try {
			$this->view->entries = $this->listByContext();
		} catch (FreshRSS_EntriesGetter_Exception $e) {
			Minz_Log::notice($e->getMessage());
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

		FreshRSS_Context::$state |= Minz_Request::param(
			'state', FreshRSS_Context::$conf->default_view
		);
		if (FreshRSS_Context::$state & FreshRSS_Entry::STATE_NOT_READ &&
				FreshRSS_Context::$get_unread <= 0) {
			FreshRSS_Context::$state |= FreshRSS_Entry::STATE_READ;
		}

		FreshRSS_Context::$search = Minz_Request::param('search', '');
		FreshRSS_Context::$order = Minz_Request::param(
			'order', FreshRSS_Context::$conf->sort_order
		);
		FreshRSS_Context::$number = Minz_Request::param(
			'nb', FreshRSS_Context::$conf->posts_per_page
		);
		FreshRSS_Context::$first_id = Minz_Request::param('next', '');
	}

	private function listByContext() {
		$entryDAO = FreshRSS_Factory::createEntryDao();

		$get = FreshRSS_Context::currentGet(true);
		if (count($get) > 1) {
			$type = $get[0];
			$id = $get[1];
		} else {
			$type = $get;
			$id = '';
		}

		return $entryDAO->listWhere(
			$type, $id, FreshRSS_Context::$state, FreshRSS_Context::$order,
			FreshRSS_Context::$number + 1, FreshRSS_Context::$first_id,
			FreshRSS_Context::$search
		);
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

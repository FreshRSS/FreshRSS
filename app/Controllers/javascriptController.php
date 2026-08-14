<?php
declare(strict_types=1);

class FreshRSS_javascript_Controller extends FreshRSS_ActionController {

	/**
	 * @var FreshRSS_ViewJavascript
	 * @phpstan-ignore property.phpDocType
	 */
	protected $view;

	public function __construct() {
		parent::__construct(FreshRSS_ViewJavascript::class);
	}

	#[\Override]
	public function firstAction(): void {
		$this->view->_layout(null);
	}

	public function actualizeAction(): void {
		if (!FreshRSS_Auth::hasAccess() && !(
			FreshRSS_Context::systemConf()->allow_anonymous
			&& FreshRSS_Context::systemConf()->allow_anonymous_refresh
			)) {
			Minz_Error::error(403);
			return;
		}

		header('Content-Type: application/json; charset=UTF-8');
		Minz_Session::_param('actualize_feeds', false);

		$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
		$databaseDAO->minorDbMaintenance();
		Minz_ExtensionManager::callHookVoid(Minz_HookType::FreshrssUserMaintenance);

		$catDAO = FreshRSS_Factory::createCategoryDao();
		$this->view->categories = $catDAO->listCategoriesOrderUpdate(FreshRSS_Context::userConf()->dynamic_opml_ttl_default);

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeedsOrderUpdate(FreshRSS_Context::userConf()->ttl_default);

		// When the refresh button is used from a feed or category view, limit the
		// batch to the feeds visible in that view.
		$get = Minz_Request::paramString('get');
		if (preg_match('/^c_(\d+)$/', $get, $matches)) {
			$category = $this->view->categories[(int)$matches[1]] ?? null;
			if ($category !== null) {
				$this->view->categories = [$category->id() => $category];
				// Filter feeds to keep only those from the selected category, preserving the order
				$this->view->feeds = array_filter($this->view->feeds, static fn(FreshRSS_Feed $feed) => $feed->category() === $category->id());
			}
		} elseif (preg_match('/^f_(\d+)$/', $get, $matches)) {
			$feed = $feedDAO->searchById((int)$matches[1]);
			$this->view->categories = [];
			$this->view->feeds = $feed === null ? [] : [$feed->id() => $feed];
		}
	}

	public function nbUnreadsPerFeedAction(): void {
		if (!FreshRSS_Auth::hasAccess() && !FreshRSS_Context::systemConf()->allow_anonymous) {
			Minz_Error::error(403);
			return;
		}

		header('Content-Type: application/json; charset=UTF-8');
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$this->view->categories = $catDAO->listCategories(prePopulateFeeds: true, details: false);
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tags = $tagDAO->listTags(precounts: true);
	}

	// For Web-form login

	public function nonceAction(): void {
		header('Content-Type: application/json; charset=UTF-8');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s \\G\\M\\T'));
		header('Expires: 0');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');

		$user = Minz_Request::paramString('user');
		if ($user === '') {
			Minz_Error::error(400);
			return;
		}
		$user_conf = FreshRSS_UserConfiguration::getForUser($user);
		$this->view->nonce = hash('sha256', FreshRSS_Context::systemConf()->salt . $user . random_bytes(32));
		Minz_Session::_param('nonce', $this->view->nonce);
		if ($user_conf !== null) {
			$s = $user_conf->passwordHash;
			if (strlen($s) >= 60) {
				// CRYPT_BLOWFISH Salt: "$2a$", a two digit cost parameter, "$", and 22 characters from the alphabet "./0-9A-Za-z".
				$this->view->salt1 = substr($s, 0, 29);
				return;	// Success
			}
		} else {
			Minz_Log::notice('Nonce failure due to invalid username! ' . $user);
		}
		// Failure: Return static random data for given username.
		$salt = substr(str_replace('+', '.', base64_encode(hash('sha256', FreshRSS_Context::systemConf()->salt . $user))), 0, 22);
		$this->view->salt1 = substr(crypt('failure', '$2y$09$' . $salt), 0, 29);
	}
}

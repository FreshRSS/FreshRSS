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
		if (!FreshRSS_Auth::hasAccess() && !FreshRSS_Auth::allowAnonymousRefresh()) {
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
		if (!FreshRSS_Auth::hasAccess() && !FreshRSS_Auth::allowAnonymous()) {
			Minz_Error::error(403);
			return;
		}

		header('Content-Type: application/json; charset=UTF-8');
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$this->view->categories = $catDAO->listCategories(prePopulateFeeds: true, details: false);
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tags = $tagDAO->listTags(precounts: true);
	}
}

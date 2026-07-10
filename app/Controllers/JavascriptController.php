<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Minz\Error;
use FreshRss\Minz\ExtensionManager;
use FreshRss\Minz\HookType;
use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\Context;
use FreshRss\Models\Factory;
use FreshRss\Models\Feed;
use FreshRss\Models\ViewJavascript;

class JavascriptController extends ActionController {

	/**
	 * @var ViewJavascript
	 * @phpstan-ignore property.phpDocType
	 */
	protected $view;

	public function __construct() {
		parent::__construct(ViewJavascript::class);
	}

	#[\Override]
	public function firstAction(): void {
		$this->view->_layout(null);
	}

	public function actualizeAction(): void {
		if (!Auth::hasAccess() && !Auth::allowAnonymousRefresh()) {
			Error::error(403);
			return;
		}

		header('Content-Type: application/json; charset=UTF-8');
		Session::_param('actualize_feeds', false);

		$databaseDAO = Factory::createDatabaseDAO();
		$databaseDAO->minorDbMaintenance();
		ExtensionManager::callHookVoid(HookType::FreshrssUserMaintenance);

		$catDAO = Factory::createCategoryDao();
		$this->view->categories = $catDAO->listCategoriesOrderUpdate(Context::userConf()->dynamic_opml_ttl_default);

		$feedDAO = Factory::createFeedDao();
		$this->view->feeds = $feedDAO->listFeedsOrderUpdate(Context::userConf()->ttl_default);

		// When the refresh button is used from a feed or category view, limit the
		// batch to the feeds visible in that view.
		$get = Request::paramString('get');
		if (preg_match('/^c_(\d+)$/', $get, $matches)) {
			$category = $this->view->categories[(int)$matches[1]] ?? null;
			if ($category !== null) {
				$this->view->categories = [$category->id() => $category];
				// Filter feeds to keep only those from the selected category, preserving the order
				$this->view->feeds = array_filter($this->view->feeds, static fn(Feed $feed) => $feed->category() === $category->id());
			}
		} elseif (preg_match('/^f_(\d+)$/', $get, $matches)) {
			$feed = $feedDAO->searchById((int)$matches[1]);
			$this->view->categories = [];
			$this->view->feeds = $feed === null ? [] : [$feed->id() => $feed];
		}
	}

	public function nbUnreadsPerFeedAction(): void {
		if (!Auth::hasAccess() && !Auth::allowAnonymous()) {
			Error::error(403);
			return;
		}

		header('Content-Type: application/json; charset=UTF-8');
		$catDAO = Factory::createCategoryDao();
		$this->view->categories = $catDAO->listCategories(prePopulateFeeds: true, details: false);
		$tagDAO = Factory::createTagDao();
		$this->view->tags = $tagDAO->listTags(precounts: true);
	}
}

<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Minz\Error;
use FreshRss\Minz\Exception;
use FreshRss\Minz\ExtensionManager;
use FreshRss\Minz\HookType;
use FreshRss\Minz\Log;
use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\Context;
use FreshRss\Models\Factory;
use FreshRss\Models\Feed;
use FreshRss\Models\UserConfiguration;
use FreshRss\Models\ViewJavascript;
use FreshRss\Utils\PasswordUtil;

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
		if (!Auth::hasAccess() && !(
			Context::systemConf()->allow_anonymous
			&& Context::systemConf()->allow_anonymous_refresh
			)) {
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
		if (!Auth::hasAccess() && !Context::systemConf()->allow_anonymous) {
			Error::error(403);
			return;
		}

		header('Content-Type: application/json; charset=UTF-8');
		$catDAO = Factory::createCategoryDao();
		$this->view->categories = $catDAO->listCategories(prePopulateFeeds: true, details: false);
		$tagDAO = Factory::createTagDao();
		$this->view->tags = $tagDAO->listTags(precounts: true);
	}

	//For Web-form login

	/**
	 * @throws \Exception
	 */
	public function nonceAction(): void {
		header('Content-Type: application/json; charset=UTF-8');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s \\G\\M\\T'));
		header('Expires: 0');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');

		$user = Request::paramString('user');
		if ($user === '') {
			Error::error(400);
			return;
		}
		$user_conf = UserConfiguration::getForUser($user);
		if ($user_conf !== null) {
			try {
				$s = $user_conf->passwordHash;
				if (strlen($s) >= 60) {
					//CRYPT_BLOWFISH Salt: "$2a$", a two digit cost parameter, "$", and 22 characters from the alphabet "./0-9A-Za-z".
					$this->view->salt1 = substr($s, 0, 29);
					$this->view->nonce = hash('sha256', Context::systemConf()->salt . $user . random_bytes(32));
					Session::_param('nonce', $this->view->nonce);
					return;	//Success
				}
			} catch (Exception $me) {
				Log::warning('Nonce failure: ' . $me->getMessage());
			}
		} else {
			Log::notice('Nonce failure due to invalid username! ' . $user);
		}
		//Failure: Return random data.
		$this->view->salt1 = sprintf('$2a$%02d$', PasswordUtil::BCRYPT_COST);
		$alphabet = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		for ($i = 22; $i > 0; $i--) {
			$this->view->salt1 .= $alphabet[random_int(0, 63)];
		}
		$this->view->nonce = hash('sha256', 'failure' . rand());
		Session::_param('nonce', $this->view->nonce);
	}
}

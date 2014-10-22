<?php

/**
 * The context object handles the current configuration file and different
 * useful functions associated to the current view state.
 */
class FreshRSS_Context {
	public static $conf = null;
	public static $categories = array();

	public static $name = '';

	public static $total_unread = 0;
	public static $total_starred = array(
		'all' => 0,
		'read' => 0,
		'unread' => 0,
	);

	public static $get_unread = 0;
	public static $current_get = array(
		'all' => false,
		'starred' => false,
		'feed' => false,
		'category' => false,
	);

	public static $state = 0;
	public static $order = 'DESC';
	public static $number = 0;
	public static $search = '';
	public static $first_id = '';
	public static $next_id = '';

	public static function init() {
		// Init configuration.
		$current_user = Minz_Session::param('currentUser');
		try {
			self::$conf = new FreshRSS_Configuration($current_user);
		} catch(Minz_Exception $e) {
			Minz_Log::error('Cannot load configuration file of user `' . $current_user . '`');
			die($e->getMessage());
		}

		// Init i18n.
		Minz_Session::_param('language', self::$conf->language);
		Minz_Translate::init();

		$catDAO = new FreshRSS_CategoryDAO();
		$entryDAO = FreshRSS_Factory::createEntryDao();

		self::$categories = $catDAO->listCategories();

		// Update number of read / unread variables.
		self::$total_starred = $entryDAO->countUnreadReadFavorites();
		self::$total_unread = FreshRSS_CategoryDAO::CountUnreads(self::$categories, 1);
	}

	public static function isStateEnabled($state) {
		return self::$state & $state;
	}

	public static function getRevertState($state) {
		if (self::$state & $state) {
			return self::$state & ~$state;
		} else {
			return self::$state | $state;
		}
	}

	public static function _get($get) {
		$type = $get[0];
		$id = substr($get, 2);
		$nb_unread = 0;

		switch($type) {
		case 'a':
			self::$current_get['all'] = true;
			self::$name = _t('your_rss_feeds');
			self::$get_unread = self::$total_unread;
			break;
		case 's':
			self::$current_get['starred'] = true;
			self::$name = _t('your_favorites');
			self::$get_unread = self::$total_starred['unread'];

			// Update state if favorite is not yet enabled.
			self::$state = self::$state | FreshRSS_Entry::STATE_FAVORITE;
			break;
		case 'f':
			self::$current_get['feed'] = $id;

			$feed = FreshRSS_CategoryDAO::findFeed(self::$categories, $id);
			if ($feed === null) {
				$feedDAO = FreshRSS_Factory::createFeedDao();
				$feed = $feedDAO->searchById($id);

				if (!$feed) {
					throw new FreshRSS_Context_Exception('Invalid feed: ' . $id);
				}
			}

			self::$name = $feed->name();
			self::$get_unread = $feed->nbNotRead();
			break;
		case 'c':
			self::$current_get['category'] = $id;
			if (!isset(self::$categories[$id])) {
				$catDAO = new FreshRSS_CategoryDAO();
				$cat = $catDAO->searchById($id);

				if (!$cat) {
					throw new FreshRSS_Context_Exception('Invalid category: ' . $id);
				}
			} else {
				$cat = self::$categories[$id];
			}

			self::$name = $cat->name();
			self::$get_unread = $cat->nbNotRead();
			break;
		default:
			throw new FreshRSS_Context_Exception('Invalid getter: ' . $get);
		}
	}

	public static function currentGet($array = false) {
		if (self::$current_get['all']) {
			return 'a';
		} elseif (self::$current_get['starred']) {
			return 's';
		} elseif (self::$current_get['feed']) {
			if ($array) {
				return array('f', self::$current_get['feed']);
			} else {
				return 'f_' . self::$current_get['feed'];
			}
		} elseif (self::$current_get['category']) {
			if ($array) {
				return array('c', self::$current_get['category']);
			} else {
				return 'c_' . self::$current_get['category'];
			}
		}
	}

	public static function isCurrentGet($get) {
		$type = $get[0];
		$id = substr($get, 2);

		switch($type) {
		case 'a':
			return self::$current_get['all'];
		case 's':
			return self::$current_get['starred'];
		case 'f':
			return self::$current_get['feed'] === $id;
		case 'c':
			return self::$current_get['category'] === $id;
		default:
			return false;
		}
	}

	public static function nextStep() {
		// TODO: fix this method.
		return array(
			'get' => 'a',
			'idMax' => (time() - 1) . '000000'
		);
	}
}

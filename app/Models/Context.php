<?php

/**
 * The context object handles the current configuration file and different
 * useful functions associated to the current view state.
 */
class FreshRSS_Context {
	public static $user_conf = null;
	public static $system_conf = null;
	public static $categories = array();

	public static $name = '';
	public static $description = '';

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
	public static $next_get = 'a';

	public static $state = 0;
	public static $order = 'DESC';
	public static $number = 0;
	public static $search;
	public static $first_id = '';
	public static $next_id = '';
	public static $id_max = '';
	public static $sinceHours = 0;

	public static $isCli = false;

	/**
	 * Initialize the context.
	 *
	 * Set the correct configurations and $categories variables.
	 */
	public static function init() {
		// Init configuration.
		self::$system_conf = Minz_Configuration::get('system');
		self::$user_conf = Minz_Configuration::get('user');
	}

	/**
	 * Returns if the current state includes $state parameter.
	 */
	public static function isStateEnabled($state) {
		return self::$state & $state;
	}

	/**
	 * Returns the current state with or without $state parameter.
	 */
	public static function getRevertState($state) {
		if (self::$state & $state) {
			return self::$state & ~$state;
		} else {
			return self::$state | $state;
		}
	}

	/**
	 * Return the current get as a string or an array.
	 *
	 * If $array is true, the first item of the returned value is 'f' or 'c' and
	 * the second is the id.
	 */
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

	/**
	 * Return true if the current request targets a feed (and not a category or all articles), false otherwise.
	 */
	public static function isFeed() {
		return self::$current_get['feed'] != false;
	}

	/**
	 * Return true if $get parameter correspond to the $current_get attribute.
	 */
	public static function isCurrentGet($get) {
		$type = $get[0];
		$id = substr($get, 2);

		switch($type) {
		case 'a':
			return self::$current_get['all'];
		case 's':
			return self::$current_get['starred'];
		case 'f':
			return self::$current_get['feed'] == $id;
		case 'c':
			return self::$current_get['category'] == $id;
		default:
			return false;
		}
	}

	/**
	 * Set the current $get attribute.
	 *
	 * Valid $get parameter are:
	 *   - a
	 *   - s
	 *   - f_<feed id>
	 *   - c_<category id>
	 *
	 * $name and $get_unread attributes are also updated as $next_get
	 * Raise an exception if id or $get is invalid.
	 */
	public static function _get($get) {
		$type = $get[0];
		$id = substr($get, 2);
		$nb_unread = 0;

		if (empty(self::$categories)) {
			$catDAO = new FreshRSS_CategoryDAO();
			self::$categories = $catDAO->listCategories();
		}

		switch($type) {
		case 'a':
			self::$current_get['all'] = true;
			self::$name = _t('index.feed.title');
			self::$description = self::$system_conf->meta_description;
			self::$get_unread = self::$total_unread;
			break;
		case 's':
			self::$current_get['starred'] = true;
			self::$name = _t('index.feed.title_fav');
			self::$description = self::$system_conf->meta_description;
			self::$get_unread = self::$total_starred['unread'];

			// Update state if favorite is not yet enabled.
			self::$state = self::$state | FreshRSS_Entry::STATE_FAVORITE;
			break;
		case 'f':
			// We try to find the corresponding feed. When allowing robots, always retrieve the full feed including description
			$feed = FreshRSS_Context::$system_conf->allow_robots ? null : FreshRSS_CategoryDAO::findFeed(self::$categories, $id);
			if ($feed === null) {
				$feedDAO = FreshRSS_Factory::createFeedDao();
				$feed = $feedDAO->searchById($id);

				if (!$feed) {
					throw new FreshRSS_Context_Exception('Invalid feed: ' . $id);
				}
			}

			self::$current_get['feed'] = $id;
			self::$current_get['category'] = $feed->category();
			self::$name = $feed->name();
			self::$description = $feed->description();
			self::$get_unread = $feed->nbNotRead();
			break;
		case 'c':
			// We try to find the corresponding category.
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

		self::_nextGet();
	}

	/**
	 * Set the value of $next_get attribute.
	 */
	private static function _nextGet() {
		$get = self::currentGet();
		// By default, $next_get == $get
		self::$next_get = $get;

		if (empty(self::$categories)) {
			$catDAO = new FreshRSS_CategoryDAO();
			self::$categories = $catDAO->listCategories();
		}

		if (self::$user_conf->onread_jump_next && strlen($get) > 2) {
			$another_unread_id = '';
			$found_current_get = false;
			switch ($get[0]) {
			case 'f':
				// We search the next feed with at least one unread article in
				// same category as the currend feed.
				foreach (self::$categories as $cat) {
					if ($cat->id() != self::$current_get['category']) {
						// We look into the category of the current feed!
						continue;
					}

					foreach ($cat->feeds() as $feed) {
						if ($feed->id() == self::$current_get['feed']) {
							// Here is our current feed! Fine, the next one will
							// be a potential candidate.
							$found_current_get = true;
							continue;
						}

						if ($feed->nbNotRead() > 0) {
							$another_unread_id = $feed->id();
							if ($found_current_get) {
								// We have found our current feed and now we
								// have an feed with unread articles. Leave the
								// loop!
								break;
							}
						}
					}
					break;
				}

				// If no feed have been found, next_get is the current category.
				self::$next_get = empty($another_unread_id) ? 'c_' . self::$current_get['category'] : 'f_' . $another_unread_id;
				break;
			case 'c':
				// We search the next category with at least one unread article.
				foreach (self::$categories as $cat) {
					if ($cat->id() == self::$current_get['category']) {
						// Here is our current category! Next one could be our
						// champion if it has unread articles.
						$found_current_get = true;
						continue;
					}

					if ($cat->nbNotRead() > 0) {
						$another_unread_id = $cat->id();
						if ($found_current_get) {
							// Unread articles and the current category has
							// already been found? Leave the loop!
							break;
						}
					}
				}

				// No unread category? The main stream will be our destination!
				self::$next_get = empty($another_unread_id) ? 'a' : 'c_' . $another_unread_id;
				break;
			}
		}
	}

	/**
	 * Determine if the auto remove is available in the current context.
	 * This feature is available if:
	 *   - it is activated in the configuration
	 *   - the "read" state is not enable
	 *   - the "unread" state is enable
	 *
	 * @return boolean
	 */
	public static function isAutoRemoveAvailable() {
		if (!self::$user_conf->auto_remove_article) {
			return false;
		}
		if (self::isStateEnabled(FreshRSS_Entry::STATE_READ)) {
			return false;
		}
		if (!self::isStateEnabled(FreshRSS_Entry::STATE_NOT_READ)) {
			return false;
		}
		return true;
	}

	/**
	 * Determine if the "sticky post" option is enabled. It can be enable
	 * by the user when it is selected in the configuration page or by the
	 * application when the context allows to auto-remove articles when they
	 * are read.
	 *
	 * @return boolean
	 */
	public static function isStickyPostEnabled() {
		if (self::$user_conf->sticky_post) {
			return true;
		}
		if (self::isAutoRemoveAvailable()) {
			return true;
		}
		return false;
	}

}

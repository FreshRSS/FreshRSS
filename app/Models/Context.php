<?php

/**
 * The context object handles the current configuration file and different
 * useful functions associated to the current view state.
 */
final class FreshRSS_Context {

	public static ?FreshRSS_UserConfiguration $user_conf = null;
	public static ?FreshRSS_SystemConfiguration $system_conf = null;
	/**
	 * @var array<int,FreshRSS_Category>
	 */
	public static array $categories = [];
	/**
	 * @var array<int,FreshRSS_Tag>
	 */
	public static array $tags = [];
	public static string $name = '';
	public static string $description = '';
	public static int $total_unread = 0;

	/** @var array{'all':int,'read':int,'unread':int} */
	public static array $total_starred = [
		'all' => 0,
		'read' => 0,
		'unread' => 0,
	];

	public static int $get_unread = 0;

	/** @var array{'all':bool,'starred':bool,'feed':int|false,'category':int|false,'tag':int|false,'tags':bool} */
	public static array $current_get = [
		'all' => false,
		'starred' => false,
		'feed' => false,
		'category' => false,
		'tag' => false,
		'tags' => false,
	];

	public static string $next_get = 'a';
	public static int $state = 0;
	/**
	 * @phpstan-var 'ASC'|'DESC'
	 */
	public static string $order = 'DESC';
	public static int $number = 0;
	public static FreshRSS_BooleanSearch $search;
	public static string $first_id = '';
	public static string $next_id = '';
	public static string $id_max = '';
	public static int $sinceHours = 0;
	public static bool $isCli = false;

	/**
	 * Initialize the context for the global system.
	 */
	public static function initSystem(bool $reload = false): FreshRSS_SystemConfiguration {
		if ($reload || FreshRSS_Context::$system_conf == null) {
			//TODO: Keep in session what we need instead of always reloading from disk
			FreshRSS_Context::$system_conf = FreshRSS_SystemConfiguration::init(DATA_PATH . '/config.php', FRESHRSS_PATH . '/config.default.php');
		}
		return FreshRSS_Context::$system_conf;
	}

	/**
	 * Initialize the context for the current user.
	 * @throws Minz_ConfigurationParamException
	 */
	public static function initUser(string $username = '', bool $userMustExist = true): ?FreshRSS_UserConfiguration {
		FreshRSS_Context::$user_conf = null;
		if (!isset($_SESSION)) {
			Minz_Session::init('FreshRSS');
		}

		Minz_Session::lock();
		if ($username == '') {
			$username = Minz_User::name() ?? '';
		}
		if (($username === Minz_User::INTERNAL_USER || FreshRSS_user_Controller::checkUsername($username)) &&
			(!$userMustExist || FreshRSS_user_Controller::userExists($username))) {
			try {
				//TODO: Keep in session what we need instead of always reloading from disk
				FreshRSS_Context::$user_conf = FreshRSS_UserConfiguration::init(
					USERS_PATH . '/' . $username . '/config.php',
					FRESHRSS_PATH . '/config-user.default.php');

				Minz_User::change($username);
			} catch (Exception $ex) {
				Minz_Log::warning($ex->getMessage(), USERS_PATH . '/_/' . LOG_FILENAME);
			}
		}
		if (FreshRSS_Context::$user_conf == null) {
			Minz_Session::_params([
				'loginOk' => false,
				Minz_User::CURRENT_USER => false,
			]);
		}
		Minz_Session::unlock();

		if (FreshRSS_Context::$user_conf == null) {
			return null;
		}

		FreshRSS_Context::$search = new FreshRSS_BooleanSearch('');

		//Legacy
		$oldEntries = (int)FreshRSS_Context::$user_conf->param('old_entries', 0);
		$keepMin = (int)FreshRSS_Context::$user_conf->param('keep_history_default', -5);
		if ($oldEntries > 0 || $keepMin > -5) {	//Freshrss < 1.15
			$archiving = FreshRSS_Context::$user_conf->archiving;
			$archiving['keep_max'] = false;
			if ($oldEntries > 0) {
				$archiving['keep_period'] = 'P' . $oldEntries . 'M';
			}
			if ($keepMin > 0) {
				$archiving['keep_min'] = $keepMin;
			} elseif ($keepMin == -1) {	//Infinite
				$archiving['keep_period'] = false;
				$archiving['keep_min'] = false;
			}
			FreshRSS_Context::$user_conf->archiving = $archiving;
		}

		//Legacy < 1.16.1
		if (!in_array(FreshRSS_Context::$user_conf->display_categories, [ 'active', 'remember', 'all', 'none' ], true)) {
			FreshRSS_Context::$user_conf->display_categories = FreshRSS_Context::$user_conf->display_categories === true ? 'all' : 'active';
		}

		return FreshRSS_Context::$user_conf;
	}

	/**
	 * This action updates the Context object by using request parameters.
	 *
	 * Parameters are:
	 *   - state (default: conf->default_view)
	 *   - search (default: empty string)
	 *   - order (default: conf->sort_order)
	 *   - nb (default: conf->posts_per_page)
	 *   - next (default: empty string)
	 *   - hours (default: 0)
	 * @throws FreshRSS_Context_Exception
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public static function updateUsingRequest(): void {
		if (empty(self::$categories)) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			self::$categories = $catDAO->listSortedCategories();
		}

		// Update number of read / unread variables.
		$entryDAO = FreshRSS_Factory::createEntryDao();
		self::$total_starred = $entryDAO->countUnreadReadFavorites();
		self::$total_unread = FreshRSS_CategoryDAO::countUnread(
			self::$categories, 1
		);

		self::_get(Minz_Request::paramString('get') ?: 'a');

		self::$state = Minz_Request::paramInt('state') ?: self::$user_conf->default_state;
		$state_forced_by_user = Minz_Request::paramString('state') !== '';
		if (!$state_forced_by_user && !self::isStateEnabled(FreshRSS_Entry::STATE_READ)) {
			if (self::$user_conf->default_view === 'all') {
				self::$state |= FreshRSS_Entry::STATE_ALL;
			} elseif (self::$user_conf->default_view === 'adaptive' && self::$get_unread <= 0) {
				self::$state |= FreshRSS_Entry::STATE_READ;
			}
			if (self::$user_conf->show_fav_unread &&
					(self::isCurrentGet('s') || self::isCurrentGet('T') || self::isTag())) {
				self::$state |= FreshRSS_Entry::STATE_READ;
			}
		}

		self::$search = new FreshRSS_BooleanSearch(Minz_Request::paramString('search'));
		$order = Minz_Request::paramString('order') ?: self::$user_conf->sort_order;
		self::$order = in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC';
		self::$number = Minz_Request::paramInt('nb') ?: self::$user_conf->posts_per_page;
		if (self::$number > self::$user_conf->max_posts_per_rss) {
			self::$number = max(
				self::$user_conf->max_posts_per_rss,
				self::$user_conf->posts_per_page);
		}
		self::$first_id = Minz_Request::paramString('next');
		self::$sinceHours = Minz_Request::paramInt('hours');
	}

	/**
	 * Returns if the current state includes $state parameter.
	 */
	public static function isStateEnabled(int $state): int {
		return self::$state & $state;
	}

	/**
	 * Returns the current state with or without $state parameter.
	 */
	public static function getRevertState(int $state): int {
		if (self::$state & $state) {
			return self::$state & ~$state;
		}
		return self::$state | $state;
	}

	/**
	 * Return the current get as a string or an array.
	 *
	 * If $array is true, the first item of the returned value is 'f' or 'c' or 't' and the second is the id.
	 * @phpstan-return ($asArray is true ? array{'a'|'c'|'f'|'s'|'t'|'T',bool|int} : string)
	 * @return string|array{string,bool|int}
	 */
	public static function currentGet(bool $asArray = false) {
		if (self::$current_get['all']) {
			return $asArray ? ['a', true] : 'a';
		} elseif (self::$current_get['starred']) {
			return $asArray ? ['s', true] : 's';
		} elseif (self::$current_get['feed']) {
			if ($asArray) {
				return ['f', self::$current_get['feed']];
			} else {
				return 'f_' . self::$current_get['feed'];
			}
		} elseif (self::$current_get['category']) {
			if ($asArray) {
				return ['c', self::$current_get['category']];
			} else {
				return 'c_' . self::$current_get['category'];
			}
		} elseif (self::$current_get['tag']) {
			if ($asArray) {
				return ['t', self::$current_get['tag']];
			} else {
				return 't_' . self::$current_get['tag'];
			}
		} elseif (self::$current_get['tags']) {
			return $asArray ? ['T', true] : 'T';
		}
		return '';
	}

	/**
	 * @return bool true if the current request targets all feeds (main view), false otherwise.
	 */
	public static function isAll(): bool {
		return self::$current_get['all'] != false;
	}

	/**
	 * @return bool true if the current request targets a category, false otherwise.
	 */
	public static function isCategory(): bool {
		return self::$current_get['category'] != false;
	}

	/**
	 * @return bool true if the current request targets a feed (and not a category or all articles), false otherwise.
	 */
	public static function isFeed(): bool {
		return self::$current_get['feed'] != false;
	}

	/**
	 * @return bool true if the current request targets a tag (though not all tags), false otherwise.
	 */
	public static function isTag(): bool {
		return self::$current_get['tag'] != false;
	}

	/**
	 * @return bool whether $get parameter corresponds to the $current_get attribute.
	 */
	public static function isCurrentGet(string $get): bool {
		$type = substr($get, 0, 1);
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
		case 't':
			return self::$current_get['tag'] == $id;
		case 'T':
			return self::$current_get['tags'] || self::$current_get['tag'];
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
	 *   - t_<tag id>
	 *
	 * $name and $get_unread attributes are also updated as $next_get
	 * Raise an exception if id or $get is invalid.
	 * @throws FreshRSS_Context_Exception
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public static function _get(string $get): void {
		$type = $get[0];
		$id = (int)substr($get, 2);

		if (empty(self::$categories)) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
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
				if ($feed === null) {
					throw new FreshRSS_Context_Exception('Invalid feed: ' . $id);
				}
			}
			self::$current_get['feed'] = $id;
			self::$current_get['category'] = $feed->categoryId();
			self::$name = $feed->name();
			self::$description = $feed->description();
			self::$get_unread = $feed->nbNotRead();
			break;
		case 'c':
			// We try to find the corresponding category.
			self::$current_get['category'] = $id;
			if (!isset(self::$categories[$id])) {
				$catDAO = FreshRSS_Factory::createCategoryDao();
				$cat = $catDAO->searchById($id);
				if ($cat === null) {
					throw new FreshRSS_Context_Exception('Invalid category: ' . $id);
				}
				//self::$categories[$id] = $cat;
			} else {
				$cat = self::$categories[$id];
			}
			self::$name = $cat->name();
			self::$get_unread = $cat->nbNotRead();
			break;
		case 't':
			// We try to find the corresponding tag.
			self::$current_get['tag'] = $id;
			if (!isset(self::$tags[$id])) {
				$tagDAO = FreshRSS_Factory::createTagDao();
				$tag = $tagDAO->searchById($id);
				if ($tag === null) {
					throw new FreshRSS_Context_Exception('Invalid tag: ' . $id);
				}
				//self::$tags[$id] = $tag;
			} else {
				$tag = self::$tags[$id];
			}
			self::$name = $tag->name();
			self::$get_unread = $tag->nbUnread();
			break;
		case 'T':
			$tagDAO = FreshRSS_Factory::createTagDao();
			self::$current_get['tags'] = true;
			self::$name = _t('index.menu.tags');
			self::$get_unread = $tagDAO->countNotRead();
			break;
		default:
			throw new FreshRSS_Context_Exception('Invalid getter: ' . $get);
		}

		self::_nextGet();
	}

	/**
	 * Set the value of $next_get attribute.
	 */
	private static function _nextGet(): void {
		$get = self::currentGet();
		// By default, $next_get == $get
		self::$next_get = $get;

		if (empty(self::$categories)) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			self::$categories = $catDAO->listCategories();
		}

		if (self::$user_conf->onread_jump_next && strlen($get) > 2) {
			$another_unread_id = '';
			$found_current_get = false;
			switch ($get[0]) {
			case 'f':
				// We search the next unread feed with the following priorities: next in same category, or previous in same category, or next, or previous.
				foreach (self::$categories as $cat) {
					$sameCat = false;
					foreach ($cat->feeds() as $feed) {
						if ($found_current_get) {
							if ($feed->nbNotRead() > 0) {
								$another_unread_id = $feed->id();
								break 2;
							}
						} elseif ($feed->id() == self::$current_get['feed']) {
							$found_current_get = true;
						} elseif ($feed->nbNotRead() > 0) {
							$another_unread_id = $feed->id();
							$sameCat = true;
						}
					}
					if ($found_current_get && $sameCat) {
						break;
					}
				}

				// If there is no more unread feed, show main stream
				self::$next_get = $another_unread_id == '' ? 'a' : 'f_' . $another_unread_id;
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

				// If there is no more unread category, show main stream
				self::$next_get = $another_unread_id == '' ? 'a' : 'c_' . $another_unread_id;
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
	 */
	public static function isAutoRemoveAvailable(): bool {
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
	 */
	public static function isStickyPostEnabled(): bool {
		if (self::$user_conf->sticky_post) {
			return true;
		}
		if (self::isAutoRemoveAvailable()) {
			return true;
		}
		return false;
	}

	public static function defaultTimeZone(): string {
		$timezone = ini_get('date.timezone');
		return $timezone != false ? $timezone : 'UTC';
	}
}

<?php
declare(strict_types=1);

/**
 * The context object handles the current configuration file and different
 * useful functions associated to the current view state.
 */
final class FreshRSS_Context {

	/** @var array<int,FreshRSS_Category> where the key is the category ID */
	private static array $categories = [];
	/** @var array<int,FreshRSS_Tag> where the key is the label ID */
	private static array $tags = [];
	public static string $name = '';
	public static string $description = '';
	public static int $total_unread = 0;
	public static int $total_important_unread = 0;

	/** @var array{all:int,read:int,unread:int} */
	public static array $total_starred = [
		'all' => 0,
		'read' => 0,
		'unread' => 0,
	];

	public static int $get_unread = 0;

	/** @var array{all:bool,A:bool,starred:bool,important:bool,feed:int|false,category:int|false,tag:int|false,tags:bool,Z:bool} */
	public static array $current_get = [
		'all' => false,
		'A' => false,
		'starred' => false,
		'important' => false,
		'feed' => false,
		'category' => false,
		'tag' => false,
		'tags' => false,
		'Z' => false,
	];

	public static string $next_get = 'a';
	public static int $state = 0;
	/** @var 'ASC'|'DESC' */
	public static string $order = 'DESC';
	/** @var 'id'|'c.name'|'date'|'f.name'|'link'|'title'|'rand' */
	public static string $sort = 'id';
	public static int $number = 0;
	public static int $offset = 0;
	public static FreshRSS_BooleanSearch $search;
	/** @var numeric-string */
	public static string $continuation_id = '0';
	/** @var numeric-string */
	public static string $id_max = '0';
	public static int $sinceHours = 0;
	public static bool $isCli = false;

	/**
	 * @access private
	 * @deprecated Will be made `private`; use `FreshRSS_Context::systemConf()` instead.
	 */
	public static ?FreshRSS_SystemConfiguration $system_conf = null;
	/**
	 * @access private
	 * @deprecated Will be made `private`; use `FreshRSS_Context::userConf()` instead.
	 */
	public static ?FreshRSS_UserConfiguration $user_conf = null;

	/**
	 * Initialize the context for the global system.
	 */
	public static function initSystem(bool $reload = false): void {
		if ($reload || FreshRSS_Context::$system_conf === null) {
			//TODO: Keep in session what we need instead of always reloading from disk
			FreshRSS_Context::$system_conf = FreshRSS_SystemConfiguration::init(DATA_PATH . '/config.php', FRESHRSS_PATH . '/config.default.php');
		}
	}

	/**
	 * @throws FreshRSS_Context_Exception
	 */
	public static function &systemConf(): FreshRSS_SystemConfiguration {
		if (FreshRSS_Context::$system_conf === null) {
			throw new FreshRSS_Context_Exception('System configuration not initialised!');
		}
		return FreshRSS_Context::$system_conf;
	}

	public static function hasSystemConf(): bool {
		return FreshRSS_Context::$system_conf !== null;
	}

	/**
	 * Initialize the context for the current user.
	 */
	public static function initUser(string $username = '', bool $userMustExist = true): void {
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
			return;
		}

		FreshRSS_Context::$search = new FreshRSS_BooleanSearch('');

		//Legacy
		$oldEntries = FreshRSS_Context::$user_conf->attributeInt('old_entries') ?? 0;
		$keepMin = FreshRSS_Context::$user_conf->attributeInt('keep_history_default') ?? -5;
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
	}

	/**
	 * @throws FreshRSS_Context_Exception
	 */
	public static function &userConf(): FreshRSS_UserConfiguration {
		if (FreshRSS_Context::$user_conf === null) {
			throw new FreshRSS_Context_Exception('User configuration not initialised!');
		}
		return FreshRSS_Context::$user_conf;
	}

	public static function hasUserConf(): bool {
		return FreshRSS_Context::$user_conf !== null;
	}

	public static function clearUserConf(): void {
		FreshRSS_Context::$user_conf = null;
	}

	/** @return array<int,FreshRSS_Category> where the key is the category ID */
	public static function categories(): array {
		if (empty(self::$categories)) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			self::$categories = $catDAO->listSortedCategories(prePopulateFeeds: true, details: false);
		}
		return self::$categories;
	}

	/** @return array<int,FreshRSS_Feed> where the key is the feed ID */
	public static function feeds(): array {
		return FreshRSS_Category::findFeeds(self::categories());
	}

	/** @return array<int,FreshRSS_Tag> where the key is the label ID */
	public static function labels(bool $precounts = false): array {
		if (empty(self::$tags) || $precounts) {
			$tagDAO = FreshRSS_Factory::createTagDao();
			self::$tags = $tagDAO->listTags($precounts);
		}
		return self::$tags;
	}

	/**
	 * This action updates the Context object by using request parameters.
	 *
	 * HTTP GET request parameters are:
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
	public static function updateUsingRequest(bool $computeStatistics): void {
		if ($computeStatistics && self::$total_unread === 0) {
			// Update number of read / unread variables.
			$entryDAO = FreshRSS_Factory::createEntryDao();
			self::$total_starred = $entryDAO->countUnreadReadFavorites();
			self::$total_unread = FreshRSS_Category::countUnread(self::categories(), FreshRSS_Feed::PRIORITY_MAIN_STREAM);
			self::$total_important_unread = FreshRSS_Category::countUnread(self::categories(), FreshRSS_Feed::PRIORITY_IMPORTANT);
		}

		self::_get(Minz_Request::paramString('get') ?: 'a');

		self::$state = Minz_Request::paramInt('state') ?: FreshRSS_Context::userConf()->default_state;
		$state_forced_by_user = Minz_Request::paramString('state', true) !== '';
		if (!$state_forced_by_user) {
			if (FreshRSS_Context::userConf()->show_fav_unread && (self::isCurrentGet('s') || self::isCurrentGet('T') || self::isTag())) {
				self::$state = FreshRSS_Entry::STATE_NOT_READ | FreshRSS_Entry::STATE_READ;
			} elseif (FreshRSS_Context::userConf()->default_view === 'all') {
				self::$state = FreshRSS_Entry::STATE_NOT_READ | FreshRSS_Entry::STATE_READ;
			} elseif (FreshRSS_Context::userConf()->default_view === 'unread_or_favorite') {
				self::$state = FreshRSS_Entry::STATE_OR_NOT_READ | FreshRSS_Entry::STATE_OR_FAVORITE;
			} elseif (FreshRSS_Context::userConf()->default_view === 'adaptive' && self::$get_unread <= 0) {
				self::$state = FreshRSS_Entry::STATE_NOT_READ | FreshRSS_Entry::STATE_READ;
			}
		}

		self::$search = new FreshRSS_BooleanSearch(Minz_Request::paramString('search'));
		$order = Minz_Request::paramString('order', true) ?: FreshRSS_Context::userConf()->sort_order;
		self::$order = in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC';
		$sort = Minz_Request::paramString('sort', true) ?: FreshRSS_Context::userConf()->sort;
		self::$sort = in_array($sort, ['id', 'c.name', 'date', 'f.name', 'link', 'title', 'rand'], true) ? $sort : 'id';
		self::$number = Minz_Request::paramInt('nb') ?: FreshRSS_Context::userConf()->posts_per_page;
		if (self::$number > FreshRSS_Context::userConf()->max_posts_per_rss) {
			self::$number = max(
				FreshRSS_Context::userConf()->max_posts_per_rss,
				FreshRSS_Context::userConf()->posts_per_page);
		}
		self::$offset = Minz_Request::paramInt('offset');
		$id_max = Minz_Request::paramString('idMax', true);
		self::$id_max = ctype_digit($id_max) ? $id_max : '0';
		$continuation_id = Minz_Request::paramString('cid', true);
		self::$continuation_id = ctype_digit($continuation_id) ? $continuation_id : '0';
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
	 * @phpstan-return ($asArray is true ? array{'a'|'A'|'c'|'f'|'i'|'s'|'t'|'T'|'Z',bool|int} : string)
	 * @return string|array{string,bool|int}
	 */
	public static function currentGet(bool $asArray = false): string|array {
		if (self::$current_get['all']) {
			return $asArray ? ['a', true] : 'a';
		} elseif (self::$current_get['A']) {
			return $asArray ? ['A', true] : 'A';
		} elseif (self::$current_get['important']) {
			return $asArray ? ['i', true] : 'i';
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
		} elseif (self::$current_get['Z']) {
			return $asArray ? ['Z', true] : 'Z';
		}
		return '';
	}

	/**
	 * @return bool true if the current request targets all feeds (main view), false otherwise.
	 */
	public static function isAll(): bool {
		return self::$current_get['all'] != false;
	}

	public static function isAllAndCategories(): bool {
		return self::$current_get['A'] != false;
	}

	public static function isAllAndArchived(): bool {
		return self::$current_get['Z'] != false;
	}

	/**
	 * @return bool true if the current request targets important feeds, false otherwise.
	 */
	public static function isImportant(): bool {
		return self::$current_get['important'] != false;
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

		return match ($type) {
			'a' => self::$current_get['all'],
			'A' => self::$current_get['A'],
			'i' => self::$current_get['important'],
			's' => self::$current_get['starred'],
			'f' => self::$current_get['feed'] == $id,
			'c' => self::$current_get['category'] == $id,
			't' => self::$current_get['tag'] == $id,
			'T' => self::$current_get['tags'] || self::$current_get['tag'],
			'Z' => self::$current_get['Z'],
			default => false,
		};
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
			$details = $type === 'f'; 	// Load additional feed details in the case of feed view
			self::$categories = $catDAO->listCategories(prePopulateFeeds: true, details: $details);
		}

		switch ($type) {
			case 'a':	// All PRIORITY_MAIN_STREAM
				self::$current_get['all'] = true;
				self::$description = FreshRSS_Context::systemConf()->meta_description;
				self::$get_unread = self::$total_unread;
				break;
			case 'A':	// All except PRIORITY_ARCHIVED
				self::$current_get['A'] = true;
				self::$description = FreshRSS_Context::systemConf()->meta_description;
				self::$get_unread = self::$total_unread;
				break;
			case 'Z':	// All including PRIORITY_ARCHIVED
				self::$current_get['Z'] = true;
				self::$name = _t('index.feed.title');
				self::$description = FreshRSS_Context::systemConf()->meta_description;
				self::$get_unread = self::$total_unread;
				break;
			case 'i':	// Priority important feeds
				self::$current_get['important'] = true;
				self::$name = _t('index.menu.important');
				self::$description = FreshRSS_Context::systemConf()->meta_description;
				self::$get_unread = self::$total_unread;
				break;
			case 's':
				self::$current_get['starred'] = true;
				self::$name = _t('index.feed.title_fav');
				self::$description = FreshRSS_Context::systemConf()->meta_description;
				self::$get_unread = self::$total_starred['unread'];
				// Update state if favorite is not yet enabled.
				self::$state = self::$state | FreshRSS_Entry::STATE_FAVORITE;
				break;
			case 'f':
				// We try to find the corresponding feed. When allowing robots, always retrieve the full feed including description
				$feed = FreshRSS_Context::systemConf()->allow_robots ? null : FreshRSS_Category::findFeed(self::$categories, $id);
				if ($feed === null) {
					throw new FreshRSS_Context_Exception('Invalid feed: ' . $id);
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
				$cat = null;
				foreach (self::$categories as $category) {
					if ($category->id() === $id) {
						$cat = $category;
						break;
					}
				}
				if ($cat === null) {
					throw new FreshRSS_Context_Exception('Invalid category: ' . $id);
				}
				self::$name = $cat->name();
				self::$get_unread = $cat->nbNotRead();
				break;
			case 't':
				// We try to find the corresponding tag.
				self::$current_get['tag'] = $id;
				$tag = null;
				foreach (self::$tags as $t) {
					if ($t->id() === $id) {
						$tag = $t;
						break;
					}
				}
				if ($tag === null) {
					$tagDAO = FreshRSS_Factory::createTagDao();
					$tag = $tagDAO->searchById($id);
					if ($tag === null) {
						throw new FreshRSS_Context_Exception('Invalid tag: ' . $id);
					}
				}
				self::$name = $tag->name();
				self::$get_unread = $tag->nbUnread();
				break;
			case 'T':
				$tagDAO = FreshRSS_Factory::createTagDao();
				self::$current_get['tags'] = true;
				self::$name = _t('index.menu.mylabels');
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
			self::$categories = $catDAO->listCategories(prePopulateFeeds: true);
		}

		if (FreshRSS_Context::userConf()->onread_jump_next && strlen($get) > 2) {
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
				case 't':
					// We can't know what the next unread tag is because entries can be in multiple tags
					// so marking all entries in a tag can indirectly mark all entries in multiple tags.
					// Default is to return to the current tag, so mark it as next_get = 'a' instead when
					// userconf -> onread_jump_next so the readAction knows to jump to the next unread
					// tag.
					self::$next_get = 'a';
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
		return FreshRSS_Context::userConf()->auto_remove_article && !self::isStateEnabled(FreshRSS_Entry::STATE_READ) &&
			(self::isStateEnabled(FreshRSS_Entry::STATE_NOT_READ) || self::isStateEnabled(FreshRSS_Entry::STATE_OR_NOT_READ));
	}

	/**
	 * Determine if the "sticky post" option is enabled. It can be enable
	 * by the user when it is selected in the configuration page or by the
	 * application when the context allows to auto-remove articles when they
	 * are read.
	 */
	public static function isStickyPostEnabled(): bool {
		if (FreshRSS_Context::userConf()->sticky_post) {
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

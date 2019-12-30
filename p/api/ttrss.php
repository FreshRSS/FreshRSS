<?php

require('../../constants.php');
require(LIB_PATH . '/lib_rss.php');  // Includes class autoloader


class MyPDO extends Minz_ModelPdo {
	public $pdo;
}


class FreshAPI_TTRSS {
	const API_LEVEL = 11;

	const STATUS_OK = 0;
	const STATUS_ERR = 1;

	private $seq = 0;
	private $user = '';
	private $method = 'index';
	private $params = array();

	public function __construct($params) {
		$this->seq = isset($params['seq']) ? $params['seq'] : 0;
		$this->user = Minz_Session::param('currentUser', '');
		if (!FreshRSS_user_Controller::checkUsername($this->user)) {
			$this->user = '';
		}
		$this->method = $params['op'];
		$this->params = $params;

		FreshRSS_Context::$system_conf = Minz_Configuration::get('system');

		if ($this->user != '') {
			FreshRSS_Context::$user_conf = get_user_configuration($this->user);
			Minz_Translate::init(FreshRSS_Context::$user_conf->language);
		} else {
			FreshRSS_Context::$user_conf = null;
			Minz_Translate::init();
		}
	}

	public function param($param, $default = false) {
		if (isset($this->params[$param])) {
			return $this->params[$param];
		} else {
			return $default;
		}
	}

	public function good($reply) {
		$this->response($reply, self::STATUS_OK);
	}

	public function bad($reply) {
		$this->response($reply, self::STATUS_ERR);
	}

	private function response($reply, $status) {
		header('Content-Type: text/json; charset=utf-8');
		$result = json_encode(array(
			'seq' => $this->seq,
			'status' => $status,
			'content' => $reply,
		));

		// Minz_Log::debug($result, API_LOG);
		print($result);
		exit();
	}

	public function handle() {
		if (!FreshRSS_Context::$system_conf->api_enabled) {
			$this->bad([ 'error' => 'API_DISABLED' ]);
		} elseif ($this->user == '' && !in_array($this->method, [ 'login', 'isloggedin' ])) {
			$this->bad(['error' => 'NOT_LOGGED_IN']);
		} else {
			switch ($this->method) {
				case 'isloggedin': $this->isloggedin(); break;
				case 'login': $this->login(); break;

				case 'catchupFeed': $this->catchupFeed(); break;
				case 'getApiLevel': $this->getApiLevel(); break;
				case 'getCategories': $this->getCategories(); break;
				case 'getCounters': $this->getCounters(); break;
				case 'getFeedTree': $this->getFeedTree(); break;
				case 'getFeeds': $this->getFeeds(); break;
				case 'getHeadlines': $this->getHeadlines(); break;
				case 'getUnread': $this->getUnread(); break;
				case 'getVersion': $this->getVersion(); break;
				case 'logout': $this->logout(); break;
				case 'updateArticle': $this->updateArticle(); break;

				case 'getArticle':
				case 'getConfig':
				case 'getLabels':
				case 'getPref':
				case 'setArticleLabel':
				case 'shareToPublish':
				case 'subscribeToFeed':
				case 'unsubscribeFeed':
				case 'updateFeed':
					Minz_Log::warning('TTRSS API: ' . $this->method . ' not implemented', API_LOG);
					$this->bad(['error' => 'NOT_IMPLEMENTED']);
					break;

				default:
					Minz_Log::warning('TTRSS API: ' . $this->method . '() method does not exist', API_LOG);
					$this->bad(['error' => 'INVALID_METHOD']);
					break;
			}
		}
	}

	private function auth_user($username, $password) {
		$user_conf = get_user_configuration($username);
		if ($user_conf == null) {
			return false;
		}

		if ($user_conf->apiPasswordHash != '' &&
				password_verify($password, $user_conf->apiPasswordHash)) {
			Minz_Session::_param('currentUser', $username);
			return true;
		} else {
			return false;
		}
	}

	public function getApiLevel() {
		$this->good([ 'level' => self::API_LEVEL ]);
	}

	public function getVersion() {
		$this->good([ 'version' => FRESHRSS_VERSION ]);
	}

	public function login() {
		$username = $this->param('user');
		$password = $this->param('password');
		$password_base64 = base64_decode($this->param('password'));

		if ($this->auth_user($username, $password) ||
				$this->auth_user($username, $password_base64)) {
			$this->good(array(
				'session_id' => session_id(),
				'api_level' => self::API_LEVEL,
			));
		} else {
			Minz_Log::warning('TTRSS API: invalid user login: ' . $username, API_LOG);
			$this->bad([ 'error' => 'LOGIN_ERROR' ]);
		}
	}

	public function logout() {
		Minz_Session::_param('currentUser');
		$this->good([ 'status' => 'OK' ]);
	}

	public function isLoggedIn() {
		$this->good([ 'status' => $this->user !== '' ]);
	}

	public function getCategories() {
		$unread_only = $this->param('unread_only', false);
		$include_empty = $this->param('include_empty', true);
		// $enable_nested = $this->param('enable_nested', true);  // not supported

		$catDAO = new FreshRSS_CategoryDAO();
		$categories = $catDAO->listCategories(true, false);

		$response = array();
		foreach ($categories as $cat) {
			if ($unread_only && $cat->nbNotRead() <= 0 ||
					!$include_empty && $cat->nbFeed() <= 0) {
				continue;
			}
			$response[] = array(
				'id' => $cat->id(),
				'title' => $cat->name(),
				'unread' => $cat->nbNotRead(),
			);
		}

		$this->good($response);
	}

	public function getFeeds() {
		$cat_id = $this->param('cat_id');
		$unread_only = $this->param('unread_only', false);
		$limit = (int)$this->param('limit', -1);
		$offset = (int)$this->param('offset', -1);
		// $include_nested = $this->param('include_nested', false) === true;  // not supported

		$sql_values = array();

		$sql_where = '';
		if ($cat_id >= 0) {
			// special ids are not supported (yet?)
			$sql_where = ' WHERE f.category = ?';
			$sql_values[] = $cat_id;
		}

		$sql_limit = '';
		if ($limit >= 0 && $offset >= 0) {
			$sql_limit = ' LIMIT ? OFFSET ?';
			$sql_values[] = $limit;
			$sql_values[] = $offset;
		}

		$model = new MyPDO();
		$sql = 'SELECT f.id, f.name, f.url, f.category, f.cache_nbUnreads AS unread, f.lastUpdate'
		     . ' FROM `_feed` f'
		     . $sql_where
		     . $sql_limit;
		$stm = $model->pdo->prepare($sql);
		$stm->execute($sql_values);
		$res = $stm->fetchAll(PDO::FETCH_ASSOC);

		$feeds = array();
		foreach ($res as $feed) {
			if ($unread_only && $feed['unread'] <= 0) {
				continue;
			}

			$feeds[] = [
				'id' => $feed['id'],
				'title' => $feed['name'],
				'feed_url' => $feed['url'],
				'unread' => $feed['unread'],
				'has_icon' => true,
				'cat_id' => $feed['category'],
				'last_updated' => $feed['lastUpdate'],
			];
		}

		$this->good($feeds);
	}

	public function getHeadlines() {
		$feed_id = $this->param('feed_id');
		if ($feed_id === false) {
			$this->bad([ 'error' => 'INCORRECT_USAGE' ]);
		}

		$limit = min(200, (int)$this->param('limit', 200));
		$offset = (int)$this->param('skip', 0);
		$is_cat = $this->param('is_cat', true);
		$show_excerpt = $this->param('show_excerpt', false);
		$show_content = $this->param('show_content', true);
		$view_mode = $this->param('view_mode', 'all_articles');
		$since_id = $this->param('since_id', '');
		$order_by = $this->param('order_by', 'feed_dates');
		$search = $this->param('search', '');
		// $filter = $this->param('filter');  // not supported
		// $include_attachments = $this->param('include_attachments');  // not supported
		// $include_nested = $this->param('include_nested');  // not supported
		// $force_update = $this->param('force_update', false);  // not supported
		// $sanitize = $this->param('sanitize', true);  // not supported
		// $has_sandbox = $this->param('has_sandbox', false);  // not supported
		// $search_mode = $this->param('search_mode', 'all_feeds');  // not supported
		// $match_on = $this->param('match_on');  // not supported

		// Get the current state
		$state = 0;
		switch ($view_mode) {
		case 'unread':
		case 'adaptive':
			$state = FreshRSS_Entry::STATE_NOT_READ;
			break;
		case 'marked':
			$state = FreshRSS_Entry::STATE_FAVORITE;
			break;
		case 'updated':  // not supported
		case 'all_articles':
		default:
			$state = FreshRSS_Entry::STATE_ALL;
		}

		// Get the current type
		$id = '';
		$type = 'A';
		switch ($feed_id) {
		case 0:  // archived (not supported)
		case -1:  // starred
			$type = 's';
			break;
		case -2:  // published (not supported)
		case -3:  // fresh (not supported)
		case -4:  // all articles
			// nothing to do
			break;
		default:
			// if ($is_cat) {
			// 	$type = 'c';
			// } else {
			// 	$type = 'f';
			// }
			$type = 'f';
			$id = $feed_id;
		}

		// Get the order
		$order = 'DESC';
		if ($order_by === 'date_reverse') {
			$order = 'ASC';
		}

		// Fix the limit: since we don't have any mechanism of offset in
		// listWhere, it will be done in PHP. Limit has to be increased by
		// the value of offset.
		$limit += $offset;

		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feeds = $feedDAO->listFeeds();

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$entries = $entryDAO->listWhere($type, $id, $state, $order, $limit, $since_id, $search, $since_id);

		$headlines = array();
		$nb_items = 0;
		foreach ($entries as $entry) {
			if ($nb_items < $offset) {
				$nb_items++;
				continue;
			}

			$f_id = $entry->feed();
			$feed = isset($feeds[$f_id]) ? $feeds[$f_id] : null;
			if ($feed == null) {
				continue;
			}
			$line = array(
				'id' => $entry->id(),
				'unread' => !$entry->isRead(),
				'marked' => !!$entry->isFavorite(),
				'published' => true,
				'updated' => $entry->date(true),
				'is_updated' => false,
				'title' => $entry->title(),
				'link' => $entry->link(),
				'tags' => $entry->tags(),
				'author' => $entry->author(),
				'feed_id' => $feed->id(),
				'feed_title' => $feed->name(),
			);

			if ($show_excerpt) {
				// @todo add a facultative max char in content method to get
				// an exerpt.
				$line['excerpt'] = $entry->content();
			}

			if ($show_content) {
				$line['content'] = $entry->content();
			}

			$headlines[] = $line;
		}

		$this->good($headlines);
	}

	public function updateArticle() {
		$article_ids = $this->param('article_ids', '');
		$mode = $this->param('mode');  // 0 set to false, 1 set to true,
		                               // 2 toggle but not supported.
		$field = $this->param('field');
		// $data = $this->param('data');  // not supported

		$article_ids = explode(',', $article_ids);
		$entryDAO = FreshRSS_Factory::createEntryDao();
		$number_article_updated = 0;
		switch ($field) {
		case 0:  // starred
			$number_article_updated = $entryDAO->markFavorite($article_ids, $mode);
			break;
		case 2:  // unread
			$number_article_updated = $entryDAO->markRead($article_ids, !$mode);
			break;
		case 1:  // published (not supported)
		case 3:  // article note (not supported)
		default:
			// nothing to do
		}

		$this->good(array(
			'status' => 'OK',
			'updated' => $number_article_updated,
		));
	}

	public function catchupFeed() {
		$id = $this->param('feed_id');
		$is_cat = $this->param('is_cat', true);

		$entryDAO = FreshRSS_Factory::createEntryDao();
		switch ($id) {
		case -1:  // starred
			$entryDAO->markReadEntries(0, true);
			break;
		case -4:  // all articles
			$entryDAO->markReadEntries();
			break;
		case 0:  // archived (not supported)
		case -2:  // published (not supported)
		case -3:  // fresh (not supported)
			break;
		default:
			// if ($is_cat) {
			// 	$entryDAO->markReadCat($id);
			// } else {
			// 	$entryDAO->markReadFeed($id);
			// }
			$entryDAO->markReadFeed($id);
		}

		$this->good([ 'status' => 'OK' ]);
	}

	public function getCounters() {
		$categoryDAO = new FreshRSS_CategoryDAO();
		$counters = array();
		$total_unreads = 0;

		// Get feed unread counters
		$categories = $categoryDAO->listCategories(true, true);
		foreach ($categories as $cat) {
			foreach ($cat->feeds() as $feed) {
				$counters[] = array(
					'id' => $feed->id(),
					'counter' => $feed->nbNotRead(),
				);
			}

			$total_unreads += $cat->nbNotRead();
		}

		// Get global unread counter
		$counters[] = array(
			'id' => 'global-unread',
			'counter' => $total_unreads,
		);

		// Get favorite unread counter
		$entryDAO = FreshRSS_Factory::createEntryDao();
		$fav_counters = $entryDAO->countUnreadReadFavorites();
		$counters[] = array(
			'id' => -1,
			'counter' => $fav_counters['unread'],
		);

		$this->good($counters);
	}

	public function getFeedTree() {
		$include_empty = $this->param('include_empty', true);
		$tree = array(
			'identifier' => 'id',
			'label' => 'name',
			'items' => array(),
		);

		$categoryDAO = new FreshRSS_CategoryDAO();
		$categories = $categoryDAO->listCategories(true, true);
		foreach ($categories as $cat) {
			$tree_cat = array(
				'id' => 'CAT:' . $cat->id(),
				'name' => $cat->name(),
				'unread' => $cat->nbNotRead(),
				'type' => 'category',
				'bare_id' => $cat->id(),
				'items' => array(),
			);

			foreach ($cat->feeds() as $feed) {
				$tree_cat['items'][] = array(
					'id' => 'FEED:' . $feed->id(),
					'name' => $feed->name(),
					'unread' => $feed->nbNotRead(),
					'type' => 'feed',
					'error' => $feed->inError(),
					'updated' => $feed->lastUpdate(),
					'bare_id' => $feed->id(),
				);
			}

			if (count($tree_cat['items']) > 0 || $include_empty) {
				$tree['items'][] = $tree_cat;
			}
		}

		$this->good([ 'categories' => $tree ]);
	}

	public function getUnread() {
		$entryDAO = FreshRSS_Factory::createEntryDao();
		$this->good([ 'unread' => $entryDAO->countNotRead() ]);
	}
}


Minz_Configuration::register('system',
                             DATA_PATH . '/config.php',
                             FRESHRSS_PATH . '/config.default.php');

$input = file_get_contents('php://input', false, null, 0, 1048576);
// Minz_Log::debug($input, API_LOG);
$input = json_decode($input, true);

if (isset($input['sid'])) {
	session_id($input['sid']);
}

Minz_Session::init('FreshRSS');

$api = new FreshAPI_TTRSS($input);
$api->handle();

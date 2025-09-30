<?php
declare(strict_types=1);

/**
== Description ==
Server-side API compatible with Google Reader API layer 2
	for the FreshRSS project https://freshrss.org

== Credits ==
* 2014-03: Released by Alexandre Alapetite https://alexandre.alapetite.fr
	under GNU AGPL 3 license http://www.gnu.org/licenses/agpl-3.0.html

== Documentation ==
* https://code.google.com/archive/p/pyrfeed/wikis/GoogleReaderAPI.wiki
* https://web.archive.org/web/20130718025427/http://undoc.in/
* http://ranchero.com/downloads/GoogleReaderAPI-2009.pdf
* https://github.com/mihaip/google-reader-api
* https://web.archive.org/web/20210126113527/https://blog.martindoms.com/2009/08/15/using-the-google-reader-api-part-1
* https://github.com/noinnion/newsplus/blob/master/extensions/GoogleReaderCloneExtension/src/com/noinnion/android/newsplus/extension/google_reader/GoogleReaderClient.java
* https://github.com/ericmann/gReader-Library/blob/master/greader.class.php
* https://github.com/devongovett/reader
* https://github.com/theoldreader/api
* https://www.inoreader.com/developers/
* https://feedhq.readthedocs.io/en/latest/api/index.html
* https://github.com/bazqux/bazqux-api
*/

require dirname(__DIR__, 2) . '/constants.php';
require LIB_PATH . '/lib_rss.php';	//Includes class autoloader

header("Content-Security-Policy: default-src 'none'; frame-ancestors 'none'; sandbox");
header('X-Content-Type-Options: nosniff');

if (PHP_INT_SIZE < 8) {	//32-bit
	/** @return numeric-string */
	function hex2dec(string $hex): string {
		if (!ctype_xdigit($hex)) return '0';
		$result = gmp_strval(gmp_init($hex, 16), 10);
		/** @var numeric-string $result */
		return $result;
	}
} else {	//64-bit
	/** @return numeric-string */
	function hex2dec(string $hex): string {
		if (!ctype_xdigit($hex)) {
			return '0';
		}
		return '' . hexdec($hex);
	}
}

const JSON_OPTIONS = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

function headerVariable(string $headerName, string $varName): string {
	$header = '';
	$upName = 'HTTP_' . strtoupper($headerName);
	if (is_string($_SERVER[$upName] ?? null)) {
		$header = '' . $_SERVER[$upName];
	} elseif (is_string($_SERVER['REDIRECT_' . $upName] ?? null)) {
		$header = '' . $_SERVER['REDIRECT_' . $upName];
	} elseif (function_exists('getallheaders')) {
		$ALL_HEADERS = getallheaders();
		if (is_string($ALL_HEADERS[$headerName] ?? null)) {
			$header = '' . $ALL_HEADERS[$headerName];
		}
	}
	parse_str($header, $pairs);
	if (empty($pairs[$varName])) {
		return '';
	}
	return is_string($pairs[$varName]) ? $pairs[$varName] : '';
}

final class GReaderAPI {

	private static string $ORIGINAL_INPUT = '';

	/** @return list<string> */
	private static function multiplePosts(string $name): array {
		//https://bugs.php.net/bug.php?id=51633
		$inputs = explode('&', self::$ORIGINAL_INPUT);
		$result = [];
		$prefix = $name . '=';
		$prefixLength = strlen($prefix);
		foreach ($inputs as $input) {
			if (str_starts_with($input, $prefix)) {
				$result[] = urldecode(substr($input, $prefixLength));
			}
		}
		return $result;
	}

	private static function debugInfo(): string {
		if (function_exists('getallheaders')) {
			$ALL_HEADERS = getallheaders();
		} else {	//nginx	http://php.net/getallheaders#84262
			$ALL_HEADERS = [];
			foreach ($_SERVER as $name => $value) {
				if (is_string($name) && str_starts_with($name, 'HTTP_')) {
					$ALL_HEADERS[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
				}
			}
		}
		$log = sensitive_log([
				'date' => date('c'),
				'headers' => $ALL_HEADERS,
				'_SERVER' => $_SERVER,
				'_GET' => $_GET,
				'_POST' => $_POST,
				'_COOKIE' => $_COOKIE,
				'INPUT' => self::$ORIGINAL_INPUT,
			]);
		return print_r($log, true);
	}

	private static function noContent(): never {
		header('HTTP/1.1 204 No Content');
		exit();
	}

	private static function badRequest(): never {
		Minz_Log::warning(__METHOD__, API_LOG);
		Minz_Log::debug(__METHOD__ . ' ' . self::debugInfo(), API_LOG);
		header('HTTP/1.1 400 Bad Request');
		header('Content-Type: text/plain; charset=UTF-8');
		die('Bad Request!');
	}

	private static function unauthorized(): never {
		Minz_Log::warning(__METHOD__, API_LOG);
		Minz_Log::debug(__METHOD__ . ' ' . self::debugInfo(), API_LOG);
		header('HTTP/1.1 401 Unauthorized');
		header('Content-Type: text/plain; charset=UTF-8');
		header('Google-Bad-Token: true');
		die('Unauthorized!');
	}

	private static function internalServerError(): never {
		Minz_Log::warning(__METHOD__, API_LOG);
		Minz_Log::debug(__METHOD__ . ' ' . self::debugInfo(), API_LOG);
		header('HTTP/1.1 500 Internal Server Error');
		header('Content-Type: text/plain; charset=UTF-8');
		die('Internal Server Error!');
	}

	private static function notImplemented(): never {
		Minz_Log::warning(__METHOD__, API_LOG);
		Minz_Log::debug(__METHOD__ . ' ' . self::debugInfo(), API_LOG);
		header('HTTP/1.1 501 Not Implemented');
		header('Content-Type: text/plain; charset=UTF-8');
		die('Not Implemented!');
	}

	private static function serviceUnavailable(): never {
		Minz_Log::warning(__METHOD__, API_LOG);
		Minz_Log::debug(__METHOD__ . ' ' . self::debugInfo(), API_LOG);
		header('HTTP/1.1 503 Service Unavailable');
		header('Content-Type: text/plain; charset=UTF-8');
		die('Service Unavailable!');
	}

	private static function checkCompatibility(): never {
		Minz_Log::warning(__METHOD__, API_LOG);
		Minz_Log::debug(__METHOD__ . ' ' . self::debugInfo(), API_LOG);
		header('Content-Type: text/plain; charset=UTF-8');
		if (PHP_INT_SIZE < 8 && !function_exists('gmp_init')) {
			die('FAIL 64-bit or GMP extension! Wrong PHP configuration.');
		}
		$headerAuth = headerVariable('Authorization', 'GoogleLogin_auth');
		if ($headerAuth == '') {
			die('FAIL get HTTP Authorization header! Wrong Web server configuration.');
		}
		echo 'PASS';
		exit();
	}

	private static function authorizationToUser(): string {
		//Input is 'GoogleLogin auth', but PHP replaces spaces by '_'	http://php.net/language.variables.external
		$headerAuth = headerVariable('Authorization', 'GoogleLogin_auth');
		if ($headerAuth != '') {
			$headerAuthX = explode('/', $headerAuth, 2);
			if (count($headerAuthX) === 2) {
				$user = $headerAuthX[0];
				if (FreshRSS_user_Controller::checkUsername($user)) {
					FreshRSS_Context::initUser($user);
					if (!FreshRSS_Context::hasUserConf() || !FreshRSS_Context::hasSystemConf()) {
						Minz_Log::warning('Invalid API user ' . $user . ': configuration cannot be found.');
						self::unauthorized();
					}
					if (!FreshRSS_Context::userConf()->enabled) {
						Minz_Log::warning('Invalid API user ' . $user . ': configuration cannot be found.');
						self::unauthorized();
					}
					if ($headerAuthX[1] === sha1(FreshRSS_Context::systemConf()->salt . $user . FreshRSS_Context::userConf()->apiPasswordHash)) {
						return $user;
					} else {
						Minz_Log::warning('Invalid API authorisation for user ' . $user);
						self::unauthorized();
					}
				} else {
					self::badRequest();
				}
			}
		}
		return '';
	}

	private static function clientLogin(string $email, string $pass): never {
		//https://web.archive.org/web/20130604091042/http://undoc.in/clientLogin.html
		if (FreshRSS_user_Controller::checkUsername($email)) {
			FreshRSS_Context::initUser($email);
			if (!FreshRSS_Context::hasUserConf() || !FreshRSS_Context::hasSystemConf()) {
				Minz_Log::warning('Invalid API user ' . $email . ': configuration cannot be found.');
				self::unauthorized();
			}

			if (FreshRSS_Context::userConf()->apiPasswordHash != '' && password_verify($pass, FreshRSS_Context::userConf()->apiPasswordHash)) {
				header('Content-Type: text/plain; charset=UTF-8');
				$auth = $email . '/' . sha1(FreshRSS_Context::systemConf()->salt . $email . FreshRSS_Context::userConf()->apiPasswordHash);
				echo 'SID=', $auth, "\n",
					'LSID=null', "\n",	//Vienna RSS
					'Auth=', $auth, "\n";
				exit();
			} else {
				Minz_Log::warning('Password API mismatch for user ' . $email);
				self::unauthorized();
			}
		} else {
			self::badRequest();
		}
	}

	private static function token(?FreshRSS_UserConfiguration $conf): never {
		// https://web.archive.org/web/20210126113527/https://blog.martindoms.com/2009/08/15/using-the-google-reader-api-part-1
		// https://github.com/ericmann/gReader-Library/blob/master/greader.class.php
		$user = Minz_User::name();
		if ($user === null || $conf === null || !FreshRSS_Context::hasSystemConf()) {
			self::unauthorized();
		}
		//Minz_Log::debug('token('. $user . ')', API_LOG);	//TODO: Implement real token that expires
		$token = str_pad(sha1(FreshRSS_Context::systemConf()->salt . $user . $conf->apiPasswordHash), 57, 'Z');	//Must have 57 characters
		echo $token, "\n";
		exit();
	}

	private static function checkToken(?FreshRSS_UserConfiguration $conf, string $token): bool {
		// https://github.com/mihaip/google-reader-api/blob/master/wiki/ActionToken.wiki
		$user = Minz_User::name();
		if ($user === null || $conf === null || !FreshRSS_Context::hasSystemConf()) {
			self::unauthorized();
		}
		if ($user !== Minz_User::INTERNAL_USER && (	//TODO: Check security consequences
			$token === '' || //FeedMe
			$token === 'x')) { //Reeder
			return true;
		}
		if ($token === str_pad(sha1(FreshRSS_Context::systemConf()->salt . $user . $conf->apiPasswordHash), 57, 'Z')) {
			return true;
		}
		Minz_Log::warning('Invalid POST token: ' . $token, API_LOG);
		self::unauthorized();
	}

	private static function userInfo(): never {
		//https://github.com/theoldreader/api#user-info
		if (!FreshRSS_Context::hasUserConf()) {
			self::unauthorized();
		}
		$user = Minz_User::name();
		exit(json_encode([
			'userId' => $user,
			'userName' => $user,
			'userProfileId' => $user,
			'userEmail' => FreshRSS_Context::userConf()->mail_login,
		], JSON_OPTIONS));
	}

	private static function tagList(): never {
		header('Content-Type: application/json; charset=UTF-8');

		$tags = [
			['id' => 'user/-/state/com.google/starred'],
			// ['id' => 'user/-/state/com.google/broadcast', 'sortid' => '2']
		];
		$categoryDAO = FreshRSS_Factory::createCategoryDao();
		$categories = $categoryDAO->listCategories(prePopulateFeeds: false, details: false);
		foreach ($categories as $cat) {
			$tags[] = [
				'id' => 'user/-/label/' . htmlspecialchars_decode($cat->name(), ENT_QUOTES),
				//'sortid' => $cat->name(),
				'type' => 'folder',	//Inoreader
			];
		}

		$tagDAO = FreshRSS_Factory::createTagDao();
		$labels = $tagDAO->listTags(precounts: true);
		foreach ($labels as $label) {
			$tags[] = [
				'id' => 'user/-/label/' . htmlspecialchars_decode($label->name(), ENT_QUOTES),
				//'sortid' => $label->name(),
				'type' => 'tag',	//Inoreader
				'unread_count' => $label->nbUnread(),	//Inoreader
			];
		}

		echo json_encode(['tags' => $tags], JSON_OPTIONS), "\n";
		exit();
	}

	private static function subscriptionExport(): never {
		$user = Minz_User::name() ?? Minz_User::INTERNAL_USER;
		$export_service = new FreshRSS_Export_Service($user);
		[$filename, $content] = $export_service->generateOpml();
		header('Content-Type: application/xml; charset=UTF-8');
		header('Content-disposition: attachment; filename="' . $filename . '"');
		echo $content;
		exit();
	}

	private static function subscriptionImport(string $opml): never {
		$user = Minz_User::name() ?? Minz_User::INTERNAL_USER;
		$importService = new FreshRSS_Import_Service($user);
		$importService->importOpml($opml);
		if ($importService->lastStatus()) {
			FreshRSS_feed_Controller::actualizeFeedsAndCommit();
			invalidateHttpCache($user);
			exit('OK');
		} else {
			self::badRequest();
		}
	}

	private static function subscriptionList(): never {
		if (!FreshRSS_Context::hasSystemConf()) {
			self::internalServerError();
		}
		header('Content-Type: application/json; charset=UTF-8');
		$subscriptions = [];

		$categoryDAO = FreshRSS_Factory::createCategoryDao();
		foreach ($categoryDAO->listCategories(prePopulateFeeds: true, details: true) as $cat) {
			foreach ($cat->feeds() as $feed) {
				if ($feed->priority() <= FreshRSS_Feed::PRIORITY_HIDDEN) {
					continue;
				}
				$subscriptions[] = [
					'id' => 'feed/' . $feed->id(),
					'title' => escapeToUnicodeAlternative($feed->name(), true),
					'categories' => [
						[
							'id' => 'user/-/label/' . htmlspecialchars_decode($cat->name(), ENT_QUOTES),
							'label' => htmlspecialchars_decode($cat->name(), ENT_QUOTES),
						],
					],
					//'sortid' => $feed->name(),
					//'firstitemmsec' => 0,
					'url' => htmlspecialchars_decode($feed->url(), ENT_QUOTES),
					'htmlUrl' => htmlspecialchars_decode($feed->website(), ENT_QUOTES),
					'iconUrl' => str_replace(
						'/api/greader.php/reader/api/0/subscription', '',	// Security if base_url is not set properly
						$feed->favicon(absolute: true)),
				];
			}
		}

		echo json_encode(['subscriptions' => $subscriptions], JSON_OPTIONS), "\n";
		exit();
	}

	/**
	 * @param list<string> $streamNames StreamId(s) to operate on. The parameter may be repeated to edit multiple subscriptions at once
	 * @param list<string> $titles Title(s) to use for the subscription(s). Each title is associated with the corresponding streamName
	 * @param string $action 'subscribe'|'unsubscribe'|'edit'
	 * @param string $add StreamId to add the subscription(s) to (generally a category)
	 * @param string $remove StreamId to remove the subscription(s) from (generally a category)
	 */
	private static function subscriptionEdit(array $streamNames, array $titles, string $action, string $add = '', string $remove = ''): never {
		// https://github.com/mihaip/google-reader-api/blob/master/wiki/ApiSubscriptionEdit.wiki
		if (count($streamNames) < 1) {
			self::badRequest();
		}
		switch ($action) {
			case 'subscribe':
			case 'unsubscribe':
			case 'edit':
				break;
			default:
				self::badRequest();
		}

		$addCatId = 0;
		if (str_starts_with($add, 'user/')) {	// user/-/label/Example ; user/username/label/Example
			if (str_starts_with($add, 'user/-/label/')) {
				$c_name = substr($add, 13);
			} else {
				$prefix = 'user/' . Minz_User::name() . '/label/';
				if (str_starts_with($add, $prefix)) {
					$c_name = substr($add, strlen($prefix));
				} else {
					$c_name = '';
				}
			}
			$c_name = htmlspecialchars($c_name, ENT_COMPAT, 'UTF-8');
			if (in_array($c_name, ['', 'Uncategorized', _t('gen.short.default_category')], true)) {
				$addCatId = FreshRSS_CategoryDAO::DEFAULTCATEGORYID;
			} else {
				$categoryDAO = FreshRSS_Factory::createCategoryDao();
				$cat = $categoryDAO->searchByName($c_name);
				$addCatId = $cat === null ? 0 : $cat->id();
				if ($addCatId === 0) {
					$addCatId = $categoryDAO->addCategory(['name' => $c_name]) ?: FreshRSS_CategoryDAO::DEFAULTCATEGORYID;
				}
			}
		} elseif (str_starts_with($remove, 'user/-/label/')) {
			$addCatId = FreshRSS_CategoryDAO::DEFAULTCATEGORYID;
		}

		$feedDAO = FreshRSS_Factory::createFeedDao();
		for ($i = count($streamNames) - 1; $i >= 0; $i--) {
			$streamUrl = $streamNames[$i];	//feed/http://example.net/sample.xml	;	feed/338
			if (str_starts_with($streamUrl, 'feed/')) {
				$streamUrl = '' . preg_replace('%^(feed/)+%', '', $streamUrl);
				$feedId = 0;
				if (is_numeric($streamUrl)) {
					if ($action === 'subscribe') {
						continue;
					}
					$feedId = (int)$streamUrl;
				} else {
					$streamUrl = htmlspecialchars($streamUrl, ENT_COMPAT, 'UTF-8');
					$feed = $feedDAO->searchByUrl($streamUrl);
					$feedId = $feed == null ? -1 : $feed->id();
				}
				$title = $titles[$i] ?? '';
				$title = htmlspecialchars($title, ENT_COMPAT, 'UTF-8');
				switch ($action) {
					case 'subscribe':
						if ($feedId <= 0) {
							$http_auth = '';
							try {
								FreshRSS_feed_Controller::addFeed($streamUrl, $title, $addCatId, '', $http_auth);
								continue 2;
							} catch (Exception $e) {
								Minz_Log::error('subscriptionEdit error subscribe: ' . $e->getMessage(), API_LOG);
							}
						}
						self::badRequest();
						// Always exits
					case 'unsubscribe':
						if (!($feedId > 0 && FreshRSS_feed_Controller::deleteFeed($feedId))) {
							self::badRequest();
						}
						break;
					case 'edit':
						if ($feedId > 0) {
							if ($addCatId > 0) {
								FreshRSS_feed_Controller::moveFeed($feedId, $addCatId);
							}
							if ($title != '') {
								FreshRSS_feed_Controller::renameFeed($feedId, $title);
							}
						} else {
							self::badRequest();
						}
						break;
				}
			}
		}
		exit('OK');
	}

	private static function quickadd(string $url): never {
		try {
			$url = htmlspecialchars($url, ENT_COMPAT, 'UTF-8');
			if (str_starts_with($url, 'feed/')) {
				$url = substr($url, 5);
			}
			$feed = FreshRSS_feed_Controller::addFeed($url);
			exit(json_encode([
					'numResults' => 1,
					'query' => $feed->url(),
					'streamId' => 'feed/' . $feed->id(),
					'streamName' => $feed->name(),
				], JSON_OPTIONS));
		} catch (Exception $e) {
			Minz_Log::error('quickadd error: ' . $e->getMessage(), API_LOG);
			die(json_encode([
					'numResults' => 0,
					'error' => $e->getMessage(),
				], JSON_OPTIONS));
		}
	}

	private static function unreadCount(): never {
		// https://web.archive.org/web/20210126115837/https://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2#unread-count
		header('Content-Type: application/json; charset=UTF-8');

		$totalUnreads = 0;
		$totalLastUpdate = 0;

		$categoryDAO = FreshRSS_Factory::createCategoryDao();
		$feedDAO = FreshRSS_Factory::createFeedDao();
		$feedsNewestItemUsec = $feedDAO->listFeedsNewestItemUsec();
		$unreadcounts = [];
		foreach ($categoryDAO->listCategories(prePopulateFeeds: true, details: true) as $cat) {
			$catLastUpdate = 0;
			foreach ($cat->feeds() as $feed) {
				if ($feed->priority() <= FreshRSS_Feed::PRIORITY_HIDDEN) {
					continue;
				}
				$lastUpdate = $feedsNewestItemUsec['f_' . $feed->id()] ?? 0;
				$unreadcounts[] = [
					'id' => 'feed/' . $feed->id(),
					'count' => $feed->nbNotRead(),
					'newestItemTimestampUsec' => '' . $lastUpdate,
				];
				if ($catLastUpdate < $lastUpdate) {
					$catLastUpdate = $lastUpdate;
				}
			}
			$unreadcounts[] = [
				'id' => 'user/-/label/' . htmlspecialchars_decode($cat->name(), ENT_QUOTES),
				'count' => $cat->nbNotRead(),
				'newestItemTimestampUsec' => '' . $catLastUpdate,
			];
			$totalUnreads += $cat->nbNotRead();
			if ($totalLastUpdate < $catLastUpdate) {
				$totalLastUpdate = $catLastUpdate;
			}
		}

		$tagDAO = FreshRSS_Factory::createTagDao();
		$tagsNewestItemUsec = $tagDAO->listTagsNewestItemUsec();
		foreach ($tagDAO->listTags(precounts: true) as $label) {
			$lastUpdate = $tagsNewestItemUsec['t_' . $label->id()] ?? 0;
			$unreadcounts[] = [
				'id' => 'user/-/label/' . htmlspecialchars_decode($label->name(), ENT_QUOTES),
				'count' => $label->nbUnread(),
				'newestItemTimestampUsec' => '' . $lastUpdate,
			];
		}

		$unreadcounts[] = [
			'id' => 'user/-/state/com.google/reading-list',
			'count' => $totalUnreads,
			'newestItemTimestampUsec' => '' . $totalLastUpdate,
		];

		echo json_encode([
			'max' => $totalUnreads,
			'unreadcounts' => $unreadcounts,
		], JSON_OPTIONS), "\n";
		exit();
	}

	/**
	 * @param list<FreshRSS_Entry> $entries
	 * @return list<array<string,mixed>>
	 */
	private static function entriesToArray(array $entries): array {
		if (empty($entries)) {
			return [];
		}
		$catDAO = FreshRSS_Factory::createCategoryDao();
		$categories = $catDAO->listCategories(prePopulateFeeds: true);

		$tagDAO = FreshRSS_Factory::createTagDao();
		$entryIdsTagNames = $tagDAO->getEntryIdsTagNames($entries);

		$items = [];
		foreach ($entries as $item) {
			/** @var FreshRSS_Entry|null $entry */
			$entry = Minz_ExtensionManager::callHook(Minz_HookType::EntryBeforeDisplay, $item);
			if ($entry === null) {
				continue;
			}

			$feed = FreshRSS_Category::findFeed($categories, $entry->feedId());
			if ($feed === null) {
				continue;
			}
			$entry->_feed($feed);

			$items[] = $entry->toGReader('compat', $entryIdsTagNames['e_' . $entry->id()] ?? []);
		}
		return $items;
	}

	/**
	 * @param 'A'|'c'|'f'|'s' $type
	 * @return array{'A'|'c'|'f'|'s'|'t',int,int,FreshRSS_BooleanSearch}
	 */
	private static function streamContentsFilters(string $type, int|string $streamId,
		string $filter_target, string $exclude_target, int $start_time, int $stop_time): array {
		switch ($type) {
			case 'f':	//feed
				if ($streamId != '' && is_string($streamId) && !is_numeric($streamId)) {
					$feedDAO = FreshRSS_Factory::createFeedDao();
					$streamId = htmlspecialchars($streamId, ENT_COMPAT, 'UTF-8');
					$feed = $feedDAO->searchByUrl($streamId);
					$streamId = $feed === null ? -1 : $feed->id();
				}
				break;
			case 'c':	//category or label
				$categoryDAO = FreshRSS_Factory::createCategoryDao();
				$streamId = htmlspecialchars((string)$streamId, ENT_COMPAT, 'UTF-8');
				$cat = $categoryDAO->searchByName($streamId);
				if ($cat !== null) {
					$streamId = $cat->id();
				} else {
					$tagDAO = FreshRSS_Factory::createTagDao();
					$tag = $tagDAO->searchByName($streamId);
					if ($tag !== null) {
						$type = 't';
						$streamId = $tag->id();
					} else {
						$streamId = -1;
					}
				}
				break;
		}
		$streamId = is_numeric($streamId) ? (int)$streamId : 0;

		$state = match ($filter_target) {
			'user/-/state/com.google/read' => FreshRSS_Entry::STATE_READ,
			'user/-/state/com.google/unread' => FreshRSS_Entry::STATE_NOT_READ,
			'user/-/state/com.google/starred' => FreshRSS_Entry::STATE_FAVORITE,
			default => FreshRSS_Entry::STATE_ALL,
		};

		switch ($exclude_target) {
			case 'user/-/state/com.google/read':
				$state &= FreshRSS_Entry::STATE_NOT_READ;
				break;
			case 'user/-/state/com.google/unread':
				$state &= FreshRSS_Entry::STATE_READ;
				break;
			case 'user/-/state/com.google/starred':
				$state &= FreshRSS_Entry::STATE_NOT_FAVORITE;
				break;
		}

		$searches = new FreshRSS_BooleanSearch('');
		if ($start_time !== 0) {
			$search = new FreshRSS_Search('');
			$search->setMinDate($start_time);
			$searches->add($search);
		}
		if ($stop_time !== 0) {
			$search = new FreshRSS_Search('');
			$search->setMaxDate($stop_time);
			$searches->add($search);
		}

		return [$type, $streamId, $state, $searches];
	}

	/**
	 * @param numeric-string $continuation
	 */
	private static function streamContents(string $path, string $include_target, int $start_time, int $stop_time, int $count,
		string $order, string $filter_target, string $exclude_target, string $continuation): never {
		// https://code.google.com/archive/p/pyrfeed/wikis/GoogleReaderAPI.wiki
		// https://web.archive.org/web/20210126115837/https://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2#feed
		header('Content-Type: application/json; charset=UTF-8');

		$type = match ($path) {
			'starred' => 's',
			'feed' => 'f',
			'label' => 'c',
			'reading-list' => 'A',	// All except PRIORITY_HIDDEN
			default => 'A',
		};

		[$type, $include_target, $state, $searches] =
			self::streamContentsFilters($type, $include_target, $filter_target, $exclude_target, $start_time, $stop_time);

		if ($continuation !== '0') {
			$count++;	//Shift by one element
		}

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$entries = $entryDAO->listWhere($type, $include_target, $state, $searches,
			order: $order === 'o' ? 'ASC' : 'DESC',
			continuation_id: $continuation,
			limit: $count);
		$entries = array_values(iterator_to_array($entries));	//TODO: Improve

		$items = self::entriesToArray($entries);

		if ($continuation !== '0') {
			array_shift($items);	//Discard first element that was already sent in the previous response
			$count--;
		}

		$response = [
			'id' => 'user/-/state/com.google/reading-list',
			'updated' => time(),
			'items' => $items,
		];
		if (count($entries) >= $count) {
			$entry = end($entries);
			if ($entry != false) {
				$response['continuation'] = '' . $entry->id();
			}
		}
		unset($entries, $entryDAO, $items);
		gc_collect_cycles();
		echoJson($response, 2);	// $optimisationDepth=2 as we are interested in being memory efficient for {"items":[...]}
		exit();
	}

	/**
	 * @param numeric-string $continuation
	 */
	private static function streamContentsItemsIds(string $streamId, int $start_time, int $stop_time, int $count,
		string $order, string $filter_target, string $exclude_target, string $continuation): never {
		// https://github.com/mihaip/google-reader-api/blob/master/wiki/ApiStreamItemsIds.wiki
		// https://code.google.com/archive/p/pyrfeed/wikis/GoogleReaderAPI.wiki
		// https://web.archive.org/web/20210126115837/https://blog.martindoms.com/2009/10/16/using-the-google-reader-api-part-2#feed
		$type = 'A';
		if ($streamId === 'user/-/state/com.google/reading-list') {
			$type = 'A';
			$streamId = '';
		} elseif ($streamId === 'user/-/state/com.google/starred') {
			$type = 's';
			$streamId = '';
		} elseif ($streamId === 'user/-/state/com.google/read') {
			$filter_target = $streamId;
			$type = 'A';
			$streamId = '';
		} elseif ($streamId === 'user/-/state/com.google/unread') {
			$filter_target = $streamId;
			$type = 'A';
			$streamId = '';
		} elseif (str_starts_with($streamId, 'feed/')) {
			$type = 'f';
			$streamId = substr($streamId, 5);
		} elseif (str_starts_with($streamId, 'user/-/label/')) {
			$type = 'c';
			$streamId = substr($streamId, 13);
		}

		[$type, $id, $state, $searches] = self::streamContentsFilters($type, $streamId, $filter_target, $exclude_target, $start_time, $stop_time);

		if ($continuation !== '0') {
			$count++;	//Shift by one element
		}

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$ids = $entryDAO->listIdsWhere($type, $id, $state, $searches,
			order: $order === 'o' ? 'ASC' : 'DESC',
			continuation_id: $continuation,
			limit: $count);
		if ($ids === null) {
			self::internalServerError();
		}

		if ($continuation !== '0') {
			array_shift($ids);	//Discard first element that was already sent in the previous response
			$count--;
		}

		if (empty($ids) && isset($_GET['client']) && $_GET['client'] === 'newsplus') {
			$ids = [ 0 ];	//For News+ bug https://github.com/noinnion/newsplus/issues/84#issuecomment-57834632
		}
		$itemRefs = [];
		foreach ($ids as $entryId) {
			$itemRefs[] = [
				'id' => '' . $entryId,	//64-bit decimal
			];
		}

		$response = [
			'itemRefs' => $itemRefs,
		];
		if (count($ids) >= $count) {
			$entryId = end($ids);
			if ($entryId != false) {
				$response['continuation'] = '' . $entryId;
			}
		}

		echo json_encode($response, JSON_OPTIONS), "\n";
		exit();
	}

	/**
	 * @param list<string> $e_ids
	 */
	private static function streamContentsItems(array $e_ids, string $order): never {
		header('Content-Type: application/json; charset=UTF-8');

		foreach ($e_ids as $i => $e_id) {
			// https://feedhq.readthedocs.io/en/latest/api/terminology.html#items
			if (!ctype_digit($e_id) || $e_id[0] === '0') {
				$e_ids[$i] = hex2dec(basename($e_id));	//Strip prefix 'tag:google.com,2005:reader/item/'
			}
		}
		/** @var list<numeric-string> $e_ids */

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$entries = $entryDAO->listByIds($e_ids, order: $order === 'o' ? 'ASC' : 'DESC');
		$entries = array_values(iterator_to_array($entries));	//TODO: Improve

		$items = self::entriesToArray($entries);

		$response = [
			'id' => 'user/-/state/com.google/reading-list',
			'updated' => time(),
			'items' => $items,
		];
		unset($entries, $entryDAO, $items);
		gc_collect_cycles();
		echoJson($response, 2);	// $optimisationDepth=2 as we are interested in being memory efficient for {"items":[...]}
		exit();
	}

	/**
	 * @param list<string> $e_ids IDs of the items to edit
	 * @param list<string> $as tags to add to all the listed items
	 * @param list<string> $rs tags to remove from all the listed items
	 */
	private static function editTag(array $e_ids, array $as, array $rs): never {
		foreach ($e_ids as $i => $e_id) {
			if (!ctype_digit($e_id) || $e_id[0] === '0') {
				$e_ids[$i] = hex2dec(basename($e_id));	//Strip prefix 'tag:google.com,2005:reader/item/'
			}
		}
		/** @var list<numeric-string> $e_ids */

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$tagDAO = FreshRSS_Factory::createTagDao();

		foreach ($as as $a) {
			switch ($a) {
				case 'user/-/state/com.google/read':
					$entryDAO->markRead($e_ids, true);
					break;
				case 'user/-/state/com.google/starred':
					$entryDAO->markFavorite($e_ids, true);
					break;
				case 'user/-/state/com.google/broadcast':
				case 'user/-/state/com.google/like':
				case 'user/-/state/com.google/tracking-kept-unread':
					// Not supported
					break;
				default:
					$tagName = '';
					if (str_starts_with($a, 'user/-/label/')) {
						$tagName = substr($a, 13);
					} else {
						$user = Minz_User::name() ?? '';
						$prefix = 'user/' . $user . '/label/';
						if (str_starts_with($a, $prefix)) {
							$tagName = substr($a, strlen($prefix));
						}
					}
					if ($tagName !== '') {
						$tagName = htmlspecialchars($tagName, ENT_COMPAT, 'UTF-8');
						$tag = $tagDAO->searchByName($tagName);
						if ($tag === null) {
							$tagDAO->addTag(['name' => $tagName]);
							$tag = $tagDAO->searchByName($tagName);
						}
						if ($tag !== null) {
							foreach ($e_ids as $e_id) {
								$tagDAO->tagEntry($tag->id(), $e_id, true);
							}
						}
					}
					break;
			}
		}

		foreach ($rs as $r) {
			switch ($r) {
				case 'user/-/state/com.google/read':
					$entryDAO->markRead($e_ids, false);
					break;
				case 'user/-/state/com.google/starred':
					$entryDAO->markFavorite($e_ids, false);
					break;
				case 'user/-/state/com.google/broadcast':
				case 'user/-/state/com.google/like':
				case 'user/-/state/com.google/tracking-kept-unread':
					// Not supported
					break;
				default:
					if (str_starts_with($r, 'user/-/label/')) {
						$tagName = substr($r, 13);
						$tagName = htmlspecialchars($tagName, ENT_COMPAT, 'UTF-8');
						$tag = $tagDAO->searchByName($tagName);
						if ($tag !== null) {
							foreach ($e_ids as $e_id) {
								$tagDAO->tagEntry($tag->id(), $e_id, false);
							}
						}
					}
					break;
			}
		}

		exit('OK');
	}

	private static function renameTag(string $s, string $dest): never {
		if (str_starts_with($s, 'user/-/label/') && str_starts_with($dest, 'user/-/label/')) {
			$s = substr($s, 13);
			$s = htmlspecialchars($s, ENT_COMPAT, 'UTF-8');
			$dest = substr($dest, 13);
			$dest = htmlspecialchars($dest, ENT_COMPAT, 'UTF-8');

			$categoryDAO = FreshRSS_Factory::createCategoryDao();
			$cat = $categoryDAO->searchByName($s);
			if ($cat != null) {
				$categoryDAO->updateCategory($cat->id(), [
					'name' => $dest, 'kind' => $cat->kind(), 'attributes' => $cat->attributes()
				]);
				exit('OK');
			} else {
				$tagDAO = FreshRSS_Factory::createTagDao();
				$tag = $tagDAO->searchByName($s);
				if ($tag != null) {
					$tagDAO->updateTagName($tag->id(), $dest);
					exit('OK');
				}
			}
		}
		self::badRequest();
	}

	private static function disableTag(string $s): never {
		if (str_starts_with($s, 'user/-/label/')) {
			$s = substr($s, 13);
			$s = htmlspecialchars($s, ENT_COMPAT, 'UTF-8');
			$categoryDAO = FreshRSS_Factory::createCategoryDao();
			$cat = $categoryDAO->searchByName($s);
			if ($cat != null) {
				$feedDAO = FreshRSS_Factory::createFeedDao();
				$feedDAO->changeCategory($cat->id(), 0);
				if ($cat->id() > FreshRSS_CategoryDAO::DEFAULTCATEGORYID) {
					$categoryDAO->deleteCategory($cat->id());
				}
				exit('OK');
			} else {
				$tagDAO = FreshRSS_Factory::createTagDao();
				$tag = $tagDAO->searchByName($s);
				if ($tag != null) {
					$tagDAO->deleteTag($tag->id());
					exit('OK');
				}
			}
		}
		self::badRequest();
	}

	/**
	 * @param numeric-string $olderThanId
	 */
	private static function markAllAsRead(string $streamId, string $olderThanId): never {
		$entryDAO = FreshRSS_Factory::createEntryDao();
		if (str_starts_with($streamId, 'feed/')) {
			$f_id = basename($streamId);
			if (!is_numeric($f_id)) {
				self::badRequest();
			}
			$f_id = (int)$f_id;
			$entryDAO->markReadFeed($f_id, $olderThanId);
		} elseif (str_starts_with($streamId, 'user/-/label/')) {
			$c_name = substr($streamId, 13);
			$c_name = htmlspecialchars($c_name, ENT_COMPAT, 'UTF-8');
			$categoryDAO = FreshRSS_Factory::createCategoryDao();
			$cat = $categoryDAO->searchByName($c_name);
			if ($cat != null) {
				$entryDAO->markReadCat($cat->id(), $olderThanId);
			} else {
				$tagDAO = FreshRSS_Factory::createTagDao();
				$tag = $tagDAO->searchByName($c_name);
				if ($tag != null) {
					$entryDAO->markReadTag($tag->id(), $olderThanId);
				} else {
					self::badRequest();
				}
			}
		} elseif ($streamId === 'user/-/state/com.google/reading-list') {
			$entryDAO->markReadEntries($olderThanId, onlyFavorites: false);
		} elseif ($streamId === 'user/-/state/com.google/starred') {
			$entryDAO->markReadEntries($olderThanId, onlyFavorites: true);
		} elseif ($streamId === 'user/-/state/com.google/read') {
			$entryDAO->markReadEntries($olderThanId, state: FreshRSS_Entry::STATE_READ);
		} elseif ($streamId === 'user/-/state/com.google/unread') {
			$entryDAO->markReadEntries($olderThanId, state: FreshRSS_Entry::STATE_NOT_READ);
		} else {
			self::badRequest();
		}
		exit('OK');
	}

	public static function parse(): never {
		header('Access-Control-Allow-Headers: Authorization');
		header('Access-Control-Allow-Methods: GET, POST');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Max-Age: 600');
		if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
			self::noContent();
		}

		$pathInfo = '';
		if (empty($_SERVER['PATH_INFO']) || !is_string($_SERVER['PATH_INFO'])) {
			if (!empty($_SERVER['ORIG_PATH_INFO']) && is_string($_SERVER['ORIG_PATH_INFO'])) {
				// Compatibility https://php.net/reserved.variables.server
				$pathInfo = $_SERVER['ORIG_PATH_INFO'];
			}
		} else {
			$pathInfo = $_SERVER['PATH_INFO'];
		}
		$pathInfo = rawurldecode($pathInfo);
		$pathInfo = '' . preg_replace('%^(/api)?(/greader\.php)?%', '', $pathInfo);	//Discard common errors
		if ($pathInfo == '' && empty($_SERVER['QUERY_STRING'])) {
			exit('OK');
		}
		$pathInfos = explode('/', $pathInfo);
		if (count($pathInfos) < 3) {
			self::badRequest();
		}

		FreshRSS_Context::initSystem();

		//Minz_Log::debug('----------------------------------------------------------------', API_LOG);
		//Minz_Log::debug(self::debugInfo(), API_LOG);

		if (!FreshRSS_Context::hasSystemConf() || !FreshRSS_Context::systemConf()->api_enabled) {
			self::serviceUnavailable();
		} elseif ($pathInfos[1] === 'check' && $pathInfos[2] === 'compatibility') {
			self::checkCompatibility();
		}

		Minz_Session::init('FreshRSS', true);

		if ($pathInfos[1] !== 'accounts') {
			self::authorizationToUser();
		}
		if (FreshRSS_Context::hasUserConf()) {
			Minz_Translate::init(FreshRSS_Context::userConf()->language);
			Minz_ExtensionManager::init();
			Minz_ExtensionManager::enableByList(FreshRSS_Context::userConf()->extensions_enabled, 'user');
		} else {
			Minz_Translate::init();
		}

		self::$ORIGINAL_INPUT = file_get_contents('php://input', false, null, 0, 1048576) ?: '';

		if ($pathInfos[1] === 'accounts') {
			if (($pathInfos[2] === 'ClientLogin') && is_string($_REQUEST['Email'] ?? null) && is_string($_REQUEST['Passwd'] ?? null)) {
				self::clientLogin($_REQUEST['Email'], $_REQUEST['Passwd']);
			}
		} elseif (isset($pathInfos[3], $pathInfos[4]) && $pathInfos[1] === 'reader' && $pathInfos[2] === 'api' && $pathInfos[3] === '0') {
			if (Minz_User::name() === null) {
				self::unauthorized();
			}
			// ck=[unix timestamp]: Use the current Unix time here, helps Google with caching
			$timestamp = is_numeric($_GET['ck'] ?? null) ? (int)$_GET['ck'] : 0;
			switch ($pathInfos[4]) {
				case 'stream':
					/**
					 * xt=[exclude target]: Used to exclude certain items from the feed.
					 * For example, using xt=user/-/state/com.google/read will exclude items
					 * that the current user has marked as read, or xt=feed/[feedurl] will
					 * exclude items from a particular feed (obviously not useful in this request,
					 * but xt appears in other listing requests).
					 */
					$exclude_target = is_string($_GET['xt'] ?? null) ? $_GET['xt'] : '';
					$filter_target = is_string($_GET['it'] ?? null) ? $_GET['it'] : '';
					//n=[integer] : The maximum number of results to return.
					$count = is_numeric($_GET['n'] ?? null) ? (int)$_GET['n'] : 20;
					//r=[d|n|o] : Sort order of item results. d or n gives items in descending date order, o in ascending order.
					$order = is_string($_GET['r'] ?? null) ? $_GET['r'] : 'd';
					/**
					 * ot=[unix timestamp] : The time from which you want to retrieve items.
					 * Only items that have been crawled by Google Reader after this time will be returned.
					 */
					$start_time = is_numeric($_GET['ot'] ?? null) ? (int)$_GET['ot'] : 0;
					$stop_time = is_numeric($_GET['nt'] ?? null) ? (int)$_GET['nt'] : 0;
					/**
					 * Continuation token. If a StreamContents response does not represent
					 * all items in a timestamp range, it will have a continuation attribute.
					 * The same request can be re-issued with the value of that attribute put
					 * in this parameter to get more items
					 */
					$continuation = is_string($_GET['c'] ?? null) ? trim($_GET['c']) : '';
					if (!ctype_digit($continuation)) {
						$continuation = '0';
					}
					if (isset($pathInfos[5]) && $pathInfos[5] === 'contents') {
						if (!isset($pathInfos[6]) && is_string($_GET['s'] ?? null)) {
							// Compatibility BazQux API https://github.com/bazqux/bazqux-api#fetching-streams
							$streamIdInfos = explode('/', $_GET['s']);
							foreach ($streamIdInfos as $streamIdInfo) {
								$pathInfos[] = $streamIdInfo;
							}
						}
						if (isset($pathInfos[6], $pathInfos[7])) {
							if ($pathInfos[6] === 'feed') {
								$include_target = $pathInfos[7];
								if ($include_target !== '' && !is_numeric($include_target)) {
									$include_target = empty($_SERVER['REQUEST_URI']) || !is_string($_SERVER['REQUEST_URI']) ? '' : $_SERVER['REQUEST_URI'];
									if (preg_match('#/reader/api/0/stream/contents/feed/([A-Za-z0-9\'!*()%$_.~+-]+)#', $include_target, $matches) === 1) {
										$include_target = urldecode($matches[1]);
									} else {
										$include_target = '';
									}
								}
								self::streamContents($pathInfos[6], $include_target, $start_time, $stop_time,
									$count, $order, $filter_target, $exclude_target, $continuation);
							} elseif (isset($pathInfos[8], $pathInfos[9]) && $pathInfos[6] === 'user') {
								if ($pathInfos[8] === 'state') {
									if ($pathInfos[9] === 'com.google' && isset($pathInfos[10])) {
										if ($pathInfos[10] === 'reading-list' || $pathInfos[10] === 'starred') {
											$include_target = '';
											self::streamContents($pathInfos[10], $include_target, $start_time, $stop_time, $count, $order,
												$filter_target, $exclude_target, $continuation);
										}
									}
								} elseif ($pathInfos[8] === 'label') {
									$include_target = empty($_SERVER['REQUEST_URI']) || !is_string($_SERVER['REQUEST_URI']) ? '' : $_SERVER['REQUEST_URI'];
									if (preg_match('#/reader/api/0/stream/contents/user/[^/+]/label/([A-Za-z0-9\'!*()%$_.~+-]+)#', $include_target, $matches)) {
										$include_target = urldecode($matches[1]);
									} else {
										$include_target = $pathInfos[9];
									}
									self::streamContents($pathInfos[8], $include_target, $start_time, $stop_time,
										$count, $order, $filter_target, $exclude_target, $continuation);
								}
							}
						} else {	//EasyRSS, FeedMe
							$include_target = '';
							self::streamContents('reading-list', $include_target, $start_time, $stop_time,
								$count, $order, $filter_target, $exclude_target, $continuation);
						}
					} elseif ($pathInfos[5] === 'items') {
						if ($pathInfos[6] === 'ids' && is_string($_GET['s'] ?? null)) {
							// StreamId for which to fetch the item IDs.
							// TODO: support multiple streams
							$streamId = $_GET['s'];
							self::streamContentsItemsIds($streamId, $start_time, $stop_time, $count, $order, $filter_target, $exclude_target, $continuation);
						} elseif ($pathInfos[6] === 'contents' && isset($_POST['i'])) {	//FeedMe
							$e_ids = self::multiplePosts('i');	//item IDs
							self::streamContentsItems($e_ids, $order);
						}
					}
					break;
				case 'tag':
					if (isset($pathInfos[5]) && $pathInfos[5] === 'list') {
						$output = $_GET['output'] ?? '';
						if ($output !== 'json') self::notImplemented();
						self::tagList();
					}
					break;
				case 'subscription':
					if (isset($pathInfos[5])) {
						switch ($pathInfos[5]) {
							case 'export':
								self::subscriptionExport();
								// Always exits
							case 'import':
								if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && self::$ORIGINAL_INPUT != '') {
									self::subscriptionImport(self::$ORIGINAL_INPUT);
								}
								break;
							case 'list':
								$output = $_GET['output'] ?? '';
								if ($output !== 'json') self::notImplemented();
								self::subscriptionList();
								// Always exits
							case 'edit':
								if (isset($_REQUEST['s'], $_REQUEST['ac'])) {
									// StreamId to operate on. The parameter may be repeated to edit multiple subscriptions at once
									$streamNames = empty($_POST['s']) && is_string($_GET['s'] ?? null) ? [$_GET['s']] : self::multiplePosts('s');
									/* Title to use for the subscription. For the `subscribe` action,
									* if not specified then the feed’s current title will be used. Can
									* be used with the `edit` action to rename a subscription */
									$titles = empty($_POST['t']) && is_string($_GET['t'] ?? null) ? [$_GET['t']] : self::multiplePosts('t');
									// Action to perform on the given StreamId. Possible values are `subscribe`, `unsubscribe` and `edit`
									$action = is_string($_REQUEST['ac'] ?? null) ? $_REQUEST['ac'] : '';
									// StreamId to add the subscription to (generally a user label)
									// (in FreshRSS, we do not support repeated values since a feed can only be in one category)
									$add = is_string($_REQUEST['a'] ?? null) ? $_REQUEST['a'] : '';
									// StreamId to remove the subscription from (generally a user label) (in FreshRSS, we do not support repeated values)
									$remove = is_string($_REQUEST['r'] ?? null) ? $_REQUEST['r'] : '';
									self::subscriptionEdit($streamNames, $titles, $action, $add, $remove);
								}
								break;
							case 'quickadd':	//https://github.com/theoldreader/api
								if (is_string($_REQUEST['quickadd'] ?? null)) {
									self::quickadd($_REQUEST['quickadd']);
								}
								break;
						}
					}
					break;
				case 'unread-count':
					$output = $_GET['output'] ?? '';
					if ($output !== 'json') self::notImplemented();
					self::unreadCount();
					// Always exits
				case 'edit-tag':	// https://web.archive.org/web/20200616071132/https://blog.martindoms.com/2010/01/20/using-the-google-reader-api-part-3
					$token = is_string($_POST['T'] ?? null) ? trim($_POST['T']) : '';
					self::checkToken(FreshRSS_Context::userConf(), $token);
					// Add (Can be repeated to add multiple tags at once):	user/-/state/com.google/read	user/-/state/com.google/starred
					$as = self::multiplePosts('a');
					// Remove (Can be repeated to remove multiple tags at once):	user/-/state/com.google/read	user/-/state/com.google/starred
					$rs = self::multiplePosts('r');
					$e_ids = self::multiplePosts('i');	//item IDs
					self::editTag($e_ids, $as, $rs);
					// Always exits
				case 'rename-tag':	//https://github.com/theoldreader/api
					$token = is_string($_POST['T'] ?? null) ? trim($_POST['T']) : '';
					self::checkToken(FreshRSS_Context::userConf(), $token);
					$s = is_string($_POST['s'] ?? null) ? trim($_POST['s']) : '';	//user/-/label/Folder
					$dest = is_string($_POST['dest'] ?? null) ? trim($_POST['dest']) : '';	//user/-/label/NewFolder
					self::renameTag($s, $dest);
					// Always exits
				case 'disable-tag':	//https://github.com/theoldreader/api
					$token = is_string($_POST['T'] ?? null) ? trim($_POST['T']) : '';
					self::checkToken(FreshRSS_Context::userConf(), $token);
					$s_s = self::multiplePosts('s');
					foreach ($s_s as $s) {
						self::disableTag($s);	//user/-/label/Folder
					}
					// Always exits
				case 'mark-all-as-read':
					$token = is_string($_POST['T'] ?? null) ? trim($_POST['T']) : '';
					self::checkToken(FreshRSS_Context::userConf(), $token);
					$streamId = is_string($_POST['s'] ?? null) ? trim($_POST['s']) : '';
					$ts = is_string($_POST['ts'] ?? null) ? trim($_POST['ts']) : '0';	//Older than timestamp in nanoseconds
					if (!ctype_digit($ts)) {
						self::badRequest();
					}
					self::markAllAsRead($streamId, $ts);
					// Always exits
				case 'token':
					self::token(FreshRSS_Context::userConf());
					// Always exits
				case 'user-info':
					self::userInfo();
					// Always exits
			}
		}

		self::badRequest();
	}
}

GReaderAPI::parse();

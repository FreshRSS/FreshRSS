<?php

class Feed extends Model {
	private $id = 0;
	private $url;
	private $category = 1;
	private $nbEntries = -1;
	private $nbNotRead = -1;
	private $entries = null;
	private $name = '';
	private $website = '';
	private $description = '';
	private $lastUpdate = 0;
	private $priority = 10;
	private $pathEntries = '';
	private $httpAuth = '';
	private $error = false;
	private $keep_history = false;

	public function __construct ($url, $validate=true) {
		if ($validate) {
			$this->_url ($url);
		} else {
			$this->url = $url;
		}
	}

	public function id () {
		return $this->id;
	}
	public function url () {
		return $this->url;
	}
	public function category () {
		return $this->category;
	}
	public function entries () {
		if (!is_null ($this->entries)) {
			return $this->entries;
		} else {
			return array ();
		}
	}
	public function name () {
		return $this->name;
	}
	public function website () {
		return $this->website;
	}
	public function description () {
		return $this->description;
	}
	public function lastUpdate () {
		return $this->lastUpdate;
	}
	public function priority () {
		return $this->priority;
	}
	public function pathEntries () {
		return $this->pathEntries;
	}
	public function httpAuth ($raw = true) {
		if ($raw) {
			return $this->httpAuth;
		} else {
			$pos_colon = strpos ($this->httpAuth, ':');
			$user = substr ($this->httpAuth, 0, $pos_colon);
			$pass = substr ($this->httpAuth, $pos_colon + 1);

			return array (
				'username' => $user,
				'password' => $pass
			);
		}
	}
	public function inError () {
		return $this->error;
	}
	public function keepHistory () {
		return $this->keep_history;
	}
	public function nbEntries () {
		if ($this->nbEntries < 0) {
			$feedDAO = new FeedDAO ();
			$this->nbEntries = $feedDAO->countEntries ($this->id ());
		}

		return $this->nbEntries;
	}
	public function nbNotRead () {
		if ($this->nbNotRead < 0) {
			$feedDAO = new FeedDAO ();
			$this->nbNotRead = $feedDAO->countNotRead ($this->id ());
		}

		return $this->nbNotRead;
	}
	public function faviconPrepare() {
		$file = DATA_PATH . '/favicons/' . $this->id () . '.txt';
		if (!file_exists ($file)) {
			$t = $this->website;
			if (empty($t)) {
				$t = $this->url;
			}
			file_put_contents($file, $t);
		}
	}
	public static function faviconDelete($id) {
		$path = DATA_PATH . '/favicons/' . $id;
		@unlink($path . '.ico');
		@unlink($path . '.txt');
	}
	public function favicon () {
		return Url::display ('/f.php?' . $this->id ());
	}

	public function _id ($value) {
		$this->id = $value;
	}
	public function _url ($value, $validate=true) {
		if ($validate) {
			$value = checkUrl($value);
		}
		if (empty ($value)) {
			throw new BadUrlException ($value);
		}
		$this->url = $value;
	}
	public function _category ($value) {
		$this->category = $value;
	}
	public function _name ($value) {
		if (is_null ($value)) {
			$value = '';
		}
		$this->name = $value;
	}
	public function _website ($value, $validate=true) {
		if ($validate) {
			$value = checkUrl($value);
		}
		if (empty ($value)) {
			$value = '';
		}
		$this->website = $value;
	}
	public function _description ($value) {
		if (is_null ($value)) {
			$value = '';
		}
		$this->description = $value;
	}
	public function _lastUpdate ($value) {
		$this->lastUpdate = $value;
	}
	public function _priority ($value) {
		$this->priority = ctype_digit ($value) ? intval ($value) : 10;
	}
	public function _pathEntries ($value) {
		$this->pathEntries = $value;
	}
	public function _httpAuth ($value) {
		$this->httpAuth = $value;
	}
	public function _error ($value) {
		if ($value) {
			$value = true;
		} else {
			$value = false;
		}
		$this->error = $value;
	}
	public function _keepHistory ($value) {
		if ($value) {
			$value = true;
		} else {
			$value = false;
		}
		$this->keep_history = $value;
	}
	public function _nbNotRead ($value) {
		$this->nbNotRead = ctype_digit ($value) ? intval ($value) : -1;
	}
	public function _nbEntries ($value) {
		$this->nbEntries = ctype_digit ($value) ? intval ($value) : -1;
	}

	public function load () {
		if (!is_null ($this->url)) {
			if (CACHE_PATH === false) {
				throw new FileNotExistException (
					'CACHE_PATH',
					MinzException::ERROR
				);
			} else {
				$feed = new SimplePie ();
				$feed->set_useragent(Translate::t ('freshrss') . '/' . FRESHRSS_VERSION . ' (' . PHP_OS . '; ' . FRESHRSS_WEBSITE . ') ' . SIMPLEPIE_NAME . '/' . SIMPLEPIE_VERSION);
				$url = htmlspecialchars_decode ($this->url, ENT_QUOTES);
				if ($this->httpAuth != '') {
					$url = preg_replace ('#((.+)://)(.+)#', '${1}' . $this->httpAuth . '@${3}', $url);
				}

				$feed->set_feed_url ($url);
				$feed->set_cache_location (CACHE_PATH);
				$feed->set_cache_duration(1500);
				$feed->strip_htmltags (array (
					'base', 'blink', 'body', 'doctype', 'embed',
					'font', 'form', 'frame', 'frameset', 'html',
					'input', 'marquee', 'meta', 'noscript',
					'object', 'param', 'plaintext', 'script', 'style',
				));
				$feed->strip_attributes(array_merge($feed->strip_attributes, array(
					'autoplay', 'onload', 'onunload', 'onclick', 'ondblclick', 'onmousedown', 'onmouseup',
					'onmouseover', 'onmousemove', 'onmouseout', 'onfocus', 'onblur',
					'onkeypress', 'onkeydown', 'onkeyup', 'onselect', 'onchange', 'seamless')));
				$feed->add_attributes(array(
					'img' => array('lazyload' => ''),	//http://www.w3.org/TR/resource-priorities/
					'audio' => array('preload' => 'none'),
					'iframe' => array('postpone' => '', 'sandbox' => 'allow-scripts allow-same-origin'),
					'video' => array('postpone' => '', 'preload' => 'none'),
				));
				$feed->set_url_replacements(array(
					'a' => 'href',
					'area' => 'href',
					'audio' => 'src',
					'blockquote' => 'cite',
					'del' => 'cite',
					'form' => 'action',
					'iframe' => 'src',
					'img' => array(
						'longdesc',
						'src'
					),
					'input' => 'src',
					'ins' => 'cite',
					'q' => 'cite',
					'source' => 'src',
					'track' => 'src',
					'video' => array(
						'poster',
						'src',
					),
				));
				$feed->init ();

				if ($feed->error ()) {
					throw new FeedException ($feed->error . ' [' . $url . ']');
				}

				// si on a utilisé l'auto-discover, notre url va avoir changé
				$subscribe_url = $feed->subscribe_url ();
				if (!is_null ($subscribe_url) && $subscribe_url != $this->url) {
					if ($this->httpAuth != '') {
						// on enlève les id si authentification HTTP
						$subscribe_url = preg_replace ('#((.+)://)((.+)@)(.+)#', '${1}${5}', $subscribe_url);
					}
					$this->_url ($subscribe_url);
				}

				$title = $feed->get_title ();
				$this->_name (!is_null ($title) ? $title : $this->url);

				$this->_website ($feed->get_link ());
				$this->_description ($feed->get_description ());

				// et on charge les articles du flux
				$this->loadEntries ($feed);
			}
		}
	}
	private function loadEntries ($feed) {
		$entries = array ();

		foreach ($feed->get_items () as $item) {
			$title = html_only_entity_decode (strip_tags ($item->get_title ()));
			$author = $item->get_author ();
			$link = $item->get_permalink ();
			$date = @strtotime ($item->get_date ());

			// gestion des tags (catégorie == tag)
			$tags_tmp = $item->get_categories ();
			$tags = array ();
			if (!is_null ($tags_tmp)) {
				foreach ($tags_tmp as $tag) {
					$tags[] = html_only_entity_decode ($tag->get_label ());
				}
			}

			$content = html_only_entity_decode ($item->get_content ());

			$elinks = array();
			foreach ($item->get_enclosures() as $enclosure) {
				$elink = $enclosure->get_link();
				if (array_key_exists($elink, $elinks)) continue;
				$elinks[$elink] = '1';
				$mime = strtolower($enclosure->get_type());
				if (strpos($mime, 'image/') === 0) {
					$content .= '<br /><img src="' . $elink . '" alt="" />';
				}
			}

			$entry = new Entry (
				$this->id (),
				$item->get_id (),
				!is_null ($title) ? $title : '',
				!is_null ($author) ? html_only_entity_decode ($author->name) : '',
				!is_null ($content) ? $content : '',
				!is_null ($link) ? $link : '',
				$date ? $date : time ()
			);
			$entry->_tags ($tags);
			// permet de récupérer le contenu des flux tronqués
			$entry->loadCompleteContent($this->pathEntries());

			$entries[] = $entry;
		}

		$this->entries = $entries;
	}
}

class FeedDAO extends Model_pdo {
	public function addFeed ($valuesTmp) {
		$sql = 'INSERT INTO `' . $this->prefix . 'feed` (url, category, name, website, description, lastUpdate, priority, httpAuth, error, keep_history) VALUES(?, ?, ?, ?, ?, ?, 10, ?, 0, 0)';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			substr($valuesTmp['url'], 0, 511),
			$valuesTmp['category'],
			substr($valuesTmp['name'], 0, 255),
			substr($valuesTmp['website'], 0, 255),
			substr($valuesTmp['description'], 0, 1023),
			$valuesTmp['lastUpdate'],
			base64_encode ($valuesTmp['httpAuth']),
		);

		if ($stm && $stm->execute ($values)) {
			return $this->bd->lastInsertId();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function updateFeed ($id, $valuesTmp) {
		$set = '';
		foreach ($valuesTmp as $key => $v) {
			$set .= $key . '=?, ';

			if ($key == 'httpAuth') {
				$valuesTmp[$key] = base64_encode ($v);
			}
		}
		$set = substr ($set, 0, -2);

		$sql = 'UPDATE `' . $this->prefix . 'feed` SET ' . $set . ' WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		foreach ($valuesTmp as $v) {
			$values[] = $v;
		}
		$values[] = $id;

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function updateLastUpdate ($id, $inError = 0) {
		$sql = 'UPDATE `' . $this->prefix . 'feed` f '	//2 sub-requests with FOREIGN KEY(e.id_feed), INDEX(e.is_read) faster than 1 request with GROUP BY or CASE
		     . 'SET f.cache_nbEntries=(SELECT COUNT(e1.id) FROM `' . $this->prefix . 'entry` e1 WHERE e1.id_feed=f.id),'
		     . 'f.cache_nbUnreads=(SELECT COUNT(e2.id) FROM `' . $this->prefix . 'entry` e2 WHERE e2.id_feed=f.id AND e2.is_read=0),'
		     . 'lastUpdate=?, error=? '
		     . 'WHERE f.id=?';

		$stm = $this->bd->prepare ($sql);

		$values = array (
			time (),
			$inError,
			$id,
		);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function changeCategory ($idOldCat, $idNewCat) {
		$catDAO = new CategoryDAO ();
		$newCat = $catDAO->searchById ($idNewCat);
		if (!$newCat) {
			$newCat = $catDAO->getDefault ();
		}

		$sql = 'UPDATE `' . $this->prefix . 'feed` SET category=? WHERE category=?';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$newCat->id (),
			$idOldCat
		);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function deleteFeed ($id) {
		/*//For MYISAM (MySQL 5.5-) without FOREIGN KEY
		$sql = 'DELETE FROM `' . $this->prefix . 'entry` WHERE id_feed=?';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		if (!($stm && $stm->execute ($values))) {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}*/

		$sql = 'DELETE FROM `' . $this->prefix . 'feed` WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}
	public function deleteFeedByCategory ($id) {
		/*//For MYISAM (MySQL 5.5-) without FOREIGN KEY
		$sql = 'DELETE FROM `' . $this->prefix . 'entry` e '
		     . 'INNER JOIN `' . $this->prefix . 'feed` f ON e.id_feed = f.id '
		     . 'WHERE f.category=?';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		if (!($stm && $stm->execute ($values))) {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}*/

		$sql = 'DELETE FROM `' . $this->prefix . 'feed` WHERE category=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function searchById ($id) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$feed = HelperFeed::daoToFeed ($res);

		if (isset ($feed[$id])) {
			return $feed[$id];
		} else {
			return false;
		}
	}
	public function searchByUrl ($url) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` WHERE url=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($url);

		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$feed = current (HelperFeed::daoToFeed ($res));

		if (isset ($feed)) {
			return $feed;
		} else {
			return false;
		}
	}

	public function listFeeds () {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` ORDER BY name';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function listFeedsOrderUpdate () {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` ORDER BY lastUpdate';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function listByCategory ($cat) {
		$sql = 'SELECT * FROM `' . $this->prefix . 'feed` WHERE category=? ORDER BY name';
		$stm = $this->bd->prepare ($sql);

		$values = array ($cat);

		$stm->execute ($values);

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function countEntries ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'entry` WHERE id_feed=?';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
	public function countNotRead ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM `' . $this->prefix . 'entry` WHERE id_feed=? AND is_read=0';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
	public function updateCachedValues () {	//For one single feed, call updateLastUpdate($id)
		$sql = 'UPDATE `' . $this->prefix . 'feed` f '
		     . 'INNER JOIN ('
		     .	'SELECT e.id_feed, '
		     .	'COUNT(CASE WHEN e.is_read = 0 THEN 1 END) AS nbUnreads, '
		     .	'COUNT(e.id) AS nbEntries '
		     .	'FROM `' . $this->prefix . 'entry` e '
		     .	'GROUP BY e.id_feed'
		     . ') x ON x.id_feed=f.id '
		     . 'SET f.cache_nbEntries=x.nbEntries, f.cache_nbUnreads=x.nbUnreads';
		$stm = $this->bd->prepare ($sql);

		$values = array ($feed_id);

		if ($stm && $stm->execute ($values)) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function truncate ($id) {
		$sql = 'DELETE e.* FROM `' . $this->prefix . 'entry` e WHERE e.id_feed=?';
		$stm = $this->bd->prepare($sql);
		$values = array($id);
		$this->bd->beginTransaction ();
		if (!($stm && $stm->execute ($values))) {
				$info = $stm->errorInfo();
				Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
				$this->bd->rollBack ();
				return false;
			}
		$affected = $stm->rowCount();

		$sql = 'UPDATE `' . $this->prefix . 'feed` f '
			 . 'SET f.cache_nbEntries=0, f.cache_nbUnreads=0 WHERE f.id=?';
		$values = array ($id);
		$stm = $this->bd->prepare ($sql);
		if (!($stm && $stm->execute ($values))) {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			$this->bd->rollBack ();
			return false;
		}

		$this->bd->commit ();
		return $affected;
	}

	public function cleanOldEntries ($id, $date_min, $keep = 15) {	//Remember to call updateLastUpdate($id) just after
		$sql = 'DELETE e.* FROM `' . $this->prefix . 'entry` e '
		     . 'WHERE e.id_feed = :id_feed AND e.id <= :id_max AND e.is_favorite = 0 AND e.id NOT IN '
		     . '(SELECT id FROM (SELECT e2.id FROM `' . $this->prefix . 'entry` e2 WHERE e2.id_feed = :id_feed ORDER BY id DESC LIMIT :keep) keep)';	//Double select because of: MySQL doesn't yet support 'LIMIT & IN/ALL/ANY/SOME subquery'
		$stm = $this->bd->prepare ($sql);

		$id_max = intval($date_min) . '000000';

		$stm->bindParam(':id_feed', $id, PDO::PARAM_INT);
		$stm->bindParam(':id_max', $id_max, PDO::PARAM_INT);
		$stm->bindParam(':keep', $keep, PDO::PARAM_INT);

		if ($stm && $stm->execute ()) {
			return $stm->rowCount();
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}
}

class HelperFeed {
	public static function daoToFeed ($listDAO, $catID = null) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			if (!isset ($dao['name'])) {
				continue;
			}
			if (isset ($dao['id'])) {
				$key = $dao['id'];
			}

			$myFeed = new Feed (isset($dao['url']) ? $dao['url'] : '', false);
			$myFeed->_category ($catID === null ? $dao['category'] : $catID);
			$myFeed->_name ($dao['name']);
			$myFeed->_website ($dao['website'], false);
			$myFeed->_description (isset($dao['description']) ? $dao['description'] : '');
			$myFeed->_lastUpdate (isset($dao['lastUpdate']) ? $dao['lastUpdate'] : 0);
			$myFeed->_priority ($dao['priority']);
			$myFeed->_pathEntries (isset($dao['pathEntries']) ? $dao['pathEntries'] : '');
			$myFeed->_httpAuth (isset($dao['httpAuth']) ? base64_decode ($dao['httpAuth']) : '');
			$myFeed->_error ($dao['error']);
			$myFeed->_keepHistory (isset($dao['keep_history']) ? $dao['keep_history'] : '');
			$myFeed->_nbNotRead ($dao['cache_nbUnreads']);
			$myFeed->_nbEntries ($dao['cache_nbEntries']);
			if (isset ($dao['id'])) {
				$myFeed->_id ($dao['id']);
			}
			$list[$key] = $myFeed;
		}

		return $list;
	}
}

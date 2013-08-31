<?php

class Feed extends Model {
	private $id = null;
	private $url;
	private $category = '000000';
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

	public function __construct ($url) {
		$this->_url ($url);
	}

	public function id () {
		if(is_null($this->id)) {
			return small_hash ($this->url . Configuration::selApplication ());
		} else {
			return $this->id;
		}
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
		$feedDAO = new FeedDAO ();
		return $feedDAO->countEntries ($this->id ());
	}
	public function nbNotRead () {
		$feedDAO = new FeedDAO ();
		return $feedDAO->countNotRead ($this->id ());
	}
	public function favicon () {
		$file = '/data/favicons/' . $this->id () . '.ico';

		$favicon_url = Url::display ($file);
		if (!file_exists (PUBLIC_PATH . $file)) {
			$favicon_url = dowload_favicon ($this->website (), $this->id ());
		}

		return $favicon_url;
	}

	public function _id ($value) {
		$this->id = $value;
	}
	public function _url ($value) {
		if (!is_null ($value) && !preg_match ('#^https?://#', $value)) {
			$value = 'http://' . $value;
		}

		if (!is_null ($value) && filter_var ($value, FILTER_VALIDATE_URL)) {
			$this->url = $value;
		} else {
			throw new BadUrlException ($value);
		}
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
	public function _website ($value) {
		if (is_null ($value)) {
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
		if (!is_int (intval ($value))) {
			$value = 10;
		}
		$this->priority = $value;
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

	public function load () {
		if (!is_null ($this->url)) {
			if (CACHE_PATH === false) {
				throw new FileNotExistException (
					'CACHE_PATH',
					MinzException::ERROR
				);
			} else {
				$feed = new SimplePie ();
				$url = str_replace ('&amp;', '&', $this->url);
				if ($this->httpAuth != '') {
					$url = preg_replace ('#((.+)://)(.+)#', '${1}' . $this->httpAuth . '@${3}', $url);
				}

				$feed->set_feed_url ($url);
				$feed->set_cache_location (CACHE_PATH);
				$feed->strip_htmltags (array (
					'base', 'blink', 'body', 'doctype',
					'font', 'form', 'frame', 'frameset', 'html',
					'input', 'marquee', 'meta', 'noscript',
					'param', 'script', 'style'
				));
				$feed->init ();

				if ($feed->error ()) {
					throw new FeedException ($feed->error);
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
			$title = $item->get_title ();
			$title = preg_replace('#<a(.+)>(.+)</a>#', '\\2', $title);
			$title = htmlentities($title);
			$author = $item->get_author ();
			$link = $item->get_permalink ();
			$date = strtotime ($item->get_date ());

			// gestion des tags (catégorie == tag)
			$tags_tmp = $item->get_categories ();
			$tags = array ();
			if (!is_null ($tags_tmp)) {
				foreach ($tags_tmp as $tag) {
					$tags[] = $tag->get_label ();
				}
			}

			$content = $item->get_content ();

			$entry = new Entry (
				$this->id (),
				$item->get_id (),
				!is_null ($title) ? $title : '',
				!is_null ($author) ? $author->name : '',
				!is_null ($content) ? $content : '',
				!is_null ($link) ? $link : '',
				$date ? $date : time ()
			);
			$entry->_tags ($tags);
			// permet de récupérer le contenu des flux tronqués
			$entry->loadCompleteContent($this->pathEntries());

			$entries[$entry->id ()] = $entry;
		}

		$this->entries = $entries;
	}
}

class FeedDAO extends Model_pdo {
	public function addFeed ($valuesTmp) {
		$sql = 'INSERT INTO ' . $this->prefix . 'feed (id, url, category, name, website, description, lastUpdate, priority, httpAuth, error, keep_history) VALUES(?, ?, ?, ?, ?, ?, ?, 10, ?, 0, 0)';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$valuesTmp['id'],
			$valuesTmp['url'],
			$valuesTmp['category'],
			$valuesTmp['name'],
			$valuesTmp['website'],
			$valuesTmp['description'],
			$valuesTmp['lastUpdate'],
			base64_encode ($valuesTmp['httpAuth']),
		);

		if ($stm && $stm->execute ($values)) {
			return true;
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

		$sql = 'UPDATE ' . $this->prefix . 'feed SET ' . $set . ' WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		foreach ($valuesTmp as $v) {
			$values[] = $v;
		}
		$values[] = $id;

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function updateLastUpdate ($id) {
		$sql = 'UPDATE ' . $this->prefix . 'feed SET lastUpdate=?, error=0 WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			time (),
			$id
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function isInError ($id) {
		$sql = 'UPDATE ' . $this->prefix . 'feed SET error=1 WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$id
		);

		if ($stm && $stm->execute ($values)) {
			return true;
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

		$sql = 'UPDATE ' . $this->prefix . 'feed SET category=? WHERE category=?';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$newCat->id (),
			$idOldCat
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function deleteFeed ($id) {
		$sql = 'DELETE FROM ' . $this->prefix . 'feed WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}
	public function deleteFeedByCategory ($id) {
		$sql = 'DELETE FROM ' . $this->prefix . 'feed WHERE category=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function searchById ($id) {
		$sql = 'SELECT * FROM ' . $this->prefix . 'feed WHERE id=?';
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
		$sql = 'SELECT * FROM ' . $this->prefix . 'feed WHERE url=?';
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
		$sql = 'SELECT * FROM ' . $this->prefix . 'feed ORDER BY name';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function listFeedsOrderUpdate () {
		$sql = 'SELECT * FROM ' . $this->prefix . 'feed ORDER BY lastUpdate';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function listByCategory ($cat) {
		$sql = 'SELECT * FROM ' . $this->prefix . 'feed WHERE category=? ORDER BY name';
		$stm = $this->bd->prepare ($sql);

		$values = array ($cat);

		$stm->execute ($values);

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function count () {
		$sql = 'SELECT COUNT(*) AS count FROM ' . $this->prefix . 'feed';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countEntries ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM ' . $this->prefix . 'entry WHERE id_feed=?';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
	public function countNotRead ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM ' . $this->prefix . 'entry WHERE is_read=0 AND id_feed=?';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
}

class HelperFeed {
	public static function daoToFeed ($listDAO) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			if (isset ($dao['id'])) {
				$key = $dao['id'];
			}

			$list[$key] = new Feed ($dao['url']);
			$list[$key]->_category ($dao['category']);
			$list[$key]->_name ($dao['name']);
			$list[$key]->_website ($dao['website']);
			$list[$key]->_description ($dao['description']);
			$list[$key]->_lastUpdate ($dao['lastUpdate']);
			$list[$key]->_priority ($dao['priority']);
			$list[$key]->_pathEntries ($dao['pathEntries']);
			$list[$key]->_httpAuth (base64_decode ($dao['httpAuth']));
			$list[$key]->_error ($dao['error']);
			$list[$key]->_keepHistory ($dao['keep_history']);

			if (isset ($dao['id'])) {
				$list[$key]->_id ($dao['id']);
			}
		}

		return $list;
	}
}

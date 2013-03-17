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
	private $pathEntries = '';
	private $httpAuth = '';

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
	public function pathEntries () {
		return $this->pathEntries;
	}
	public function httpAuth () {
		return $this->httpAuth;
	}
	public function nbEntries () {
		$feedDAO = new FeedDAO ();
		return $feedDAO->countEntries ($this->id ());
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
			throw new Exception ();
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
	public function _pathEntries ($value) {
		$this->pathEntries = $value;
	}
	public function _httpAuth ($value) {
		$this->httpAuth = $value;
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
				$feed->set_feed_url ($this->url);
				$feed->set_cache_location (CACHE_PATH);
				$feed->init ();

				$subscribe_url = $feed->subscribe_url ();
				if (!is_null ($subscribe_url) && $subscribe_url != $this->url) {
					$this->_url ($subscribe_url);
				}
				$title = $feed->get_title ();
				$this->_name (!is_null ($title) ? $title : $this->url);
				$this->_website ($feed->get_link ());
				$this->_description ($feed->get_description ());
				$this->loadEntries ($feed);
			}
		}
	}
	private function loadEntries ($feed) {
		$entries = array ();

		foreach ($feed->get_items () as $item) {
			$title = $item->get_title ();
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

			// Gestion du contenu
			// On cherche à récupérer les articles en entier... même si le flux ne le propose pas
			$path = $this->pathEntries ();
			if ($path) {
				try {
					$content = get_content_by_parsing ($item->get_permalink (), $path);
				} catch (Exception $e) {
					$content = $item->get_content ();
				}
			} else {
				$content = $item->get_content ();
			}

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

			$entries[$entry->id ()] = $entry;
		}

		$this->entries = $entries;
	}
}

class FeedDAO extends Model_pdo {
	public function addFeed ($valuesTmp) {
		$sql = 'INSERT INTO feed (id, url, category, name, website, description, lastUpdate) VALUES(?, ?, ?, ?, ?, ?, ?)';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$valuesTmp['id'],
			$valuesTmp['url'],
			$valuesTmp['category'],
			$valuesTmp['name'],
			$valuesTmp['website'],
			$valuesTmp['description'],
			$valuesTmp['lastUpdate'],
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			return false;
		}
	}

	public function updateFeed ($id, $valuesTmp) {
		$set = '';
		foreach ($valuesTmp as $key => $v) {
			$set .= $key . '=?, ';
		}
		$set = substr ($set, 0, -2);

		$sql = 'UPDATE feed SET ' . $set . ' WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		foreach ($valuesTmp as $v) {
			$values[] = $v;
		}
		$values[] = $id;

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			return false;
		}
	}

	public function updateLastUpdate ($id) {
		$sql = 'UPDATE feed SET lastUpdate=? WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			time (),
			$id
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteFeed ($id) {
		$sql = 'DELETE FROM feed WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			return false;
		}
	}

	public function searchById ($id) {
		$sql = 'SELECT * FROM feed WHERE id=?';
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

	public function listFeeds () {
		$sql = 'SELECT * FROM feed ORDER BY name';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function listFeedsOrderUpdate () {
		$sql = 'SELECT * FROM feed ORDER BY lastUpdate';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function listByCategory ($cat) {
		$sql = 'SELECT * FROM feed WHERE category=? ORDER BY name';
		$stm = $this->bd->prepare ($sql);

		$values = array ($cat);

		$stm->execute ($values);

		return HelperFeed::daoToFeed ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function count () {
		$sql = 'SELECT COUNT(*) AS count FROM feed';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countEntries ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM entry WHERE id_feed=?';
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
			$list[$key]->_pathEntries ($dao['pathEntries']);
			$list[$key]->_httpAuth ($dao['httpAuth']);

			if (isset ($dao['id'])) {
				$list[$key]->_id ($dao['id']);
			}
		}

		return $list;
	}
}

<?php

class Category extends Model {
	private $id = false;
	private $name;
	private $color;
	private $nbFeed = -1;
	private $nbNotRead = -1;
	private $feeds = null;

	public function __construct ($name = '', $color = '#0062BE', $feeds = null) {
		$this->_name ($name);
		$this->_color ($color);
		if (!empty($feeds)) {
			$this->_feeds ($feeds);
			$this->nbFeed = 0;
			$this->nbNotRead = 0;
			foreach ($feeds as $feed) {
				$this->nbFeed++;
				$this->nbNotRead += $feed->nbNotRead ();
			}
		}
	}

	public function id () {
		if (!$this->id) {
			return small_hash ($this->name . time () . Configuration::selApplication ());
		} else {
			return $this->id;
		}
	}
	public function name () {
		return $this->name;
	}
	public function color () {
		return $this->color;
	}
	public function nbFeed () {
		if ($this->nbFeed < 0) {
		$catDAO = new CategoryDAO ();
			$this->nbFeed = $catDAO->countFeed ($this->id ());
		}

		return $this->nbFeed;
	}
	public function nbNotRead () {
		if ($this->nbNotRead < 0) {
		$catDAO = new CategoryDAO ();
			$this->nbNotRead = $catDAO->countNotRead ($this->id ());
		}

		return $this->nbNotRead;
	}
	public function feeds () {
		if (is_null ($this->feeds)) {
			$feedDAO = new FeedDAO ();
			$this->feeds = $feedDAO->listByCategory ($this->id ());
			$this->nbFeed = 0;
			$this->nbNotRead = 0;
			foreach ($this->feeds as $feed) {
				$this->nbFeed++;
				$this->nbNotRead += $feed->nbNotRead ();
			}
		}

		return $this->feeds;
	}

	public function _id ($value) {
		$this->id = $value;
	}
	public function _name ($value) {
		$this->name = $value;
	}
	public function _color ($value) {
		if (preg_match ('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $value)) {
			$this->color = $value;
		} else {
			$this->color = '#0062BE';
		}
	}
	public function _feeds ($values) {
		if (!is_array ($values)) {
			$values = array ($values);
		}

		$this->feeds = $values;
	}
}

class CategoryDAO extends Model_pdo {
	public function addCategory ($valuesTmp) {
		$sql = 'INSERT INTO ' . $this->prefix . 'category (id, name, color) VALUES(?, ?, ?)';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$valuesTmp['id'],
			$valuesTmp['name'],
			$valuesTmp['color'],
		);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function updateCategory ($id, $valuesTmp) {
		$sql = 'UPDATE ' . $this->prefix . 'category SET name=?, color=? WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array (
			$valuesTmp['name'],
			$valuesTmp['color'],
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

	public function deleteCategory ($id) {
		$sql = 'DELETE FROM ' . $this->prefix . 'category WHERE id=?';
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
		$sql = 'SELECT * FROM ' . $this->prefix . 'category WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$cat = HelperCategory::daoToCategory ($res);

		if (isset ($cat[0])) {
			return $cat[0];
		} else {
			return false;
		}
	}
	public function searchByName ($name) {
		$sql = 'SELECT * FROM ' . $this->prefix . 'category WHERE name=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($name);

		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$cat = HelperCategory::daoToCategory ($res);

		if (isset ($cat[0])) {
			return $cat[0];
		} else {
			return false;
		}
	}

	public function listCategories ($prePopulateFeeds = true) {
		if ($prePopulateFeeds) {
			$sql = 'SELECT c.id as c_id, c.name as c_name, c.color as c_color, count(e.id) as nbNotRead, f.* '
			     . 'FROM  ' . $this->prefix . 'category c '
			     . 'LEFT OUTER JOIN ' . $this->prefix . 'feed f ON f.category = c.id '
			     . 'LEFT OUTER JOIN  ' . $this->prefix . 'entry e ON e.id_feed = f.id AND e.is_read = 0 '
			     . 'GROUP BY f.id '
			     . 'ORDER BY c.name, f.name';
			$stm = $this->bd->prepare ($sql);
			$stm->execute ();
			return HelperCategory::daoToCategoryPrepopulated ($stm->fetchAll (PDO::FETCH_ASSOC));
		} else {
			$sql = 'SELECT * FROM ' . $this->prefix . 'category ORDER BY name';
			$stm = $this->bd->prepare ($sql);
			$stm->execute ();
			return HelperCategory::daoToCategory ($stm->fetchAll (PDO::FETCH_ASSOC));
		}
	}

	public function getDefault () {
		$sql = 'SELECT * FROM ' . $this->prefix . 'category WHERE id="000000"';
		$stm = $this->bd->prepare ($sql);

		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);
		$cat = HelperCategory::daoToCategory ($res);

		if (isset ($cat[0])) {
			return $cat[0];
		} else {
			return false;
		}
	}
	public function checkDefault () {
		$def_cat = $this->searchById ('000000');

		if ($def_cat === false) {
			$cat = new Category (Translate::t ('default_category'));
			$cat->_id ('000000');

			$values = array (
				'id' => $cat->id (),
				'name' => $cat->name (),
				'color' => $cat->color ()
			);

			$this->addCategory ($values);
		}
	}

	public function count () {
		$sql = 'SELECT COUNT(*) AS count FROM ' . $this->prefix . 'category';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countFeed ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM ' . $this->prefix . 'feed WHERE category=?';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countNotRead ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM ' . $this->prefix . 'entry e INNER JOIN ' . $this->prefix . 'feed f ON e.id_feed = f.id WHERE category=? AND e.is_read=0';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
}

class HelperCategory {
	public static function findFeed($categories, $feed_id) {
		foreach ($categories as $category) {
			foreach ($category->feeds () as $feed) {
				if ($feed->id () === $feed_id) {
					return $feed;
				}
			}
		}
		return null;
	}

	public static function daoToCategoryPrepopulated ($listDAO) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		$previousLine = null;
		$feedsDao = array();
		foreach ($listDAO as $line) {
			if ($previousLine['c_id'] != null && $line['c_id'] !== $previousLine['c_id']) {
				// End of the current category, we add it to the $list
				$cat = new Category (
					$previousLine['c_name'],
					$previousLine['c_color'],
					HelperFeed::daoToFeed ($feedsDao)
				);
				$cat->_id ($previousLine['c_id']);
				$list[] = $cat;

				$feedsDao = array();  //Prepare for next category
			}

			$previousLine = $line;
			$feedsDao[] = $line;
		}

		// add the last category
		if ($previousLine != null) {
			$cat = new Category (
				$previousLine['c_name'],
				$previousLine['c_color'],
				HelperFeed::daoToFeed ($feedsDao)
			);
			$cat->_id ($previousLine['c_id']);
			$list[] = $cat;
		}

		return $list;
	}

	public static function daoToCategory ($listDAO) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			$cat = new Category (
				$dao['name'],
				$dao['color']
			);
			$cat->_id ($dao['id']);
			$list[$key] = $cat;
		}

		return $list;
	}
}

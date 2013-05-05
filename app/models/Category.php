<?php

class Category extends Model {
	private $id = false;
	private $name;
	private $color;
	private $feeds = null;

	public function __construct ($name = '', $color = '#0062BE') {
		$this->_name ($name);
		$this->_color ($color);
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
		$catDAO = new CategoryDAO ();
		return $catDAO->countFeed ($this->id ());
	}
	public function nbNotRead () {
		$catDAO = new CategoryDAO ();
		return $catDAO->countNotRead ($this->id ());
	}
	public function feeds () {
		if (is_null ($this->feeds)) {
			$feedDAO = new FeedDAO ();
			return $feedDAO->listByCategory ($this->id ());
		} else {
			return $this->feeds;
		}
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
		$sql = 'INSERT INTO category (id, name, color) VALUES(?, ?, ?)';
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
			Log::record ('SQL error : ' . $info[2], Log::ERROR);
			return false;
		}
	}

	public function updateCategory ($id, $valuesTmp) {
		$sql = 'UPDATE category SET name=?, color=? WHERE id=?';
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
			Log::record ('SQL error : ' . $info[2], Log::ERROR);
			return false;
		}
	}

	public function deleteCategory ($id) {
		$sql = 'DELETE FROM category WHERE id=?';
		$stm = $this->bd->prepare ($sql);

		$values = array ($id);

		if ($stm && $stm->execute ($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Log::record ('SQL error : ' . $info[2], Log::ERROR);
			return false;
		}
	}

	public function searchById ($id) {
		$sql = 'SELECT * FROM category WHERE id=?';
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
		$sql = 'SELECT * FROM category WHERE name=?';
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

	public function listCategories () {
		$sql = 'SELECT * FROM category ORDER BY name';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return HelperCategory::daoToCategory ($stm->fetchAll (PDO::FETCH_ASSOC));
	}

	public function getDefault () {
		$sql = 'SELECT * FROM category WHERE id="000000"';
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

		if (!$def_cat) {
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
		$sql = 'SELECT COUNT(*) AS count FROM category';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countFeed ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM feed WHERE category=?';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}

	public function countNotRead ($id) {
		$sql = 'SELECT COUNT(*) AS count FROM entry e INNER JOIN feed f ON e.id_feed = f.id WHERE category=? AND e.is_read=0';
		$stm = $this->bd->prepare ($sql);
		$values = array ($id);
		$stm->execute ($values);
		$res = $stm->fetchAll (PDO::FETCH_ASSOC);

		return $res[0]['count'];
	}
}

class HelperCategory {
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

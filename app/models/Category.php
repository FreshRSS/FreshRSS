<?php

class Category extends Model {
	private $id = false;
	private $name;
	private $color;
	
	public function __construct ($name = '', $color = '#0062BE') {
		$this->_name ($name);
		$this->_color ($color);
	}
	
	public function id () {
		if (!$this->id) {
			return small_hash ($this->name . Configuration::selApplication ());
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
	
	public function listCategories () {
		$sql = 'SELECT * FROM category ORDER BY name';
		$stm = $this->bd->prepare ($sql);
		$stm->execute ();

		return HelperCategory::daoToCategory ($stm->fetchAll (PDO::FETCH_ASSOC));
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

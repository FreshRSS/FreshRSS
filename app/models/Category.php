<?php

class Category extends Model {
	private $id;
	private $name;
	private $color;
	
	public function __construct ($name = '', $color = '#0062BE') {
		$this->_name ($name);
		$this->_color ($color);
	}
	
	public function id () {
		return small_hash ($this->name . Configuration::selApplication ());
	}
	public function name () {
		return $this->name;
	}
	public function color () {
		return $this->color;
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

class CategoryDAO extends Model_array {
	public function __construct () {
		parent::__construct (PUBLIC_PATH . '/data/db/Categories.array.php');
	}
	
	public function addCategory ($values) {
		$id = $values['id'];
		unset ($values['id']);
	
		if (!isset ($this->array[$id])) {
			$this->array[$id] = array ();
		
			foreach ($values as $key => $value) {
				$this->array[$id][$key] = $value;
			}
		} else {
			return false;
		}
	}
	
	public function updateCategory ($id, $values) {
		foreach ($values as $key => $value) {
			$this->array[$id][$key] = $value;
		}
	}
	
	public function deleteCategory ($id) {
		if (isset ($this->array[$id])) {
			unset ($this->array[$id]);
		}
	}
	
	public function searchById ($id) {
		$list = HelperCategory::daoToCategory ($this->array);
		
		if (isset ($list[$id])) {
			return $list[$id];
		} else {
			return false;
		}
	}
	
	public function listCategories () {
		$list = $this->array;
		
		if (!is_array ($list)) {
			$list = array ();
		}
		
		return HelperCategory::daoToCategory ($list);
	}
	
	public function count () {
		return count ($this->array);
	}
	
	public function save () {
		$this->writeFile ($this->array);
	}
}

class HelperCategory {
	public static function daoToCategory ($listDAO) {
		$list = array ();

		if (!is_array ($listDAO)) {
			$listDAO = array ($listDAO);
		}

		foreach ($listDAO as $key => $dao) {
			$list[$key] = new Category (
				$dao['name'],
				$dao['color']
			);
		}

		return $list;
	}
}

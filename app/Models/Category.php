<?php

class FreshRSS_Category extends Minz_Model {
	private $id = 0;
	private $name;
	private $nbFeed = -1;
	private $nbNotRead = -1;
	private $feeds = null;
	private $hasFeedsWithError = false;
	private $isDefault = false;
	private $attributes = [];

	public function __construct($name = '', $feeds = null) {
		$this->_name($name);
		if (isset($feeds)) {
			$this->_feeds($feeds);
			$this->nbFeed = 0;
			$this->nbNotRead = 0;
			foreach ($feeds as $feed) {
				$this->nbFeed++;
				$this->nbNotRead += $feed->nbNotRead();
				$this->hasFeedsWithError |= $feed->inError();
			}
		}
	}

	public function id() {
		return $this->id;
	}
	public function name() {
		return $this->name;
	}
	public function isDefault() {
		return $this->isDefault;
	}
	public function nbFeed() {
		if ($this->nbFeed < 0) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$this->nbFeed = $catDAO->countFeed($this->id());
		}

		return $this->nbFeed;
	}
	public function nbNotRead() {
		if ($this->nbNotRead < 0) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$this->nbNotRead = $catDAO->countNotRead($this->id());
		}

		return $this->nbNotRead;
	}
	public function feeds() {
		if ($this->feeds === null) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$this->feeds = $feedDAO->listByCategory($this->id());
			$this->nbFeed = 0;
			$this->nbNotRead = 0;
			foreach ($this->feeds as $feed) {
				$this->nbFeed++;
				$this->nbNotRead += $feed->nbNotRead();
				$this->hasFeedsWithError |= $feed->inError();
			}
		}

		return $this->feeds;
	}

	public function hasFeedsWithError() {
		return $this->hasFeedsWithError;
	}

	public function attributes($key = '') {
		if ($key == '') {
			return $this->attributes;
		} else {
			return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
		}
	}

	public function _id($id) {
		$this->id = $id;
		if ($id == FreshRSS_CategoryDAO::DEFAULTCATEGORYID) {
			$this->_name(_t('gen.short.default_category'));
		}
	}
	public function _name($value) {
		$this->name = trim($value);
	}
	public function _isDefault($value) {
		$this->isDefault = $value;
	}
	public function _feeds($values) {
		if (!is_array($values)) {
			$values = array($values);
		}

		$this->feeds = $values;
	}

	public function _attributes($key, $value) {
		if ('' == $key) {
			if (is_string($value)) {
				$value = json_decode($value, true);
			}
			if (is_array($value)) {
				$this->attributes = $value;
			}
		} elseif (null === $value) {
			unset($this->attributes[$key]);
		} else {
			$this->attributes[$key] = $value;
		}
	}
}

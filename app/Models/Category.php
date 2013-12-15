<?php

class FreshRSS_Category extends Minz_Model {
	private $id = 0;
	private $name;
	private $color;
	private $nbFeed = -1;
	private $nbNotRead = -1;
	private $feeds = null;

	public function __construct ($name = '', $color = '#0062BE', $feeds = null) {
		$this->_name ($name);
		$this->_color ($color);
		if (isset ($feeds)) {
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
		return $this->id;
	}
	public function name () {
		return $this->name;
	}
	public function color () {
		return $this->color;
	}
	public function nbFeed () {
		if ($this->nbFeed < 0) {
			$catDAO = new FreshRSS_CategoryDAO ();
			$this->nbFeed = $catDAO->countFeed ($this->id ());
		}

		return $this->nbFeed;
	}
	public function nbNotRead () {
		if ($this->nbNotRead < 0) {
			$catDAO = new FreshRSS_CategoryDAO ();
			$this->nbNotRead = $catDAO->countNotRead ($this->id ());
		}

		return $this->nbNotRead;
	}
	public function feeds () {
		if (is_null ($this->feeds)) {
			$feedDAO = new FreshRSS_FeedDAO ();
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

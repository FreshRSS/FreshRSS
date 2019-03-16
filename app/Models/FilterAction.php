<?php

class FreshRSS_FilterAction {

	private $booleanSearch = null;
	private $actions = null;

	private function __construct($booleanSearch, $actions) {
		$this->$booleanSearch = $booleanSearch;
		$this->$actions = $actions;
	}

	public function booleanSearch() {
		return $this->$booleanSearch;
	}

	public function actions() {
		return $this->$actions;
	}

	public static function fromJSON($json) {
		if (!empty($json['search']) && !empty($json['actions']) && is_array($json['actions'])) {
			return new FreshRSS_FilterAction(new FreshRSS_BooleanSearch($json['search']), $json['actions']);
		}
		return null;
	}
}

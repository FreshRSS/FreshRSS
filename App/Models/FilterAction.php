<?php

namespace Freshrss\Models;

class FilterAction {

	private $booleanSearch = null;
	private $actions = null;

	private function __construct($booleanSearch, $actions) {
		$this->booleanSearch = $booleanSearch;
		$this->_actions($actions);
	}

	public function booleanSearch() {
		return $this->booleanSearch;
	}

	public function actions() {
		return $this->actions;
	}

	public function _actions($actions) {
		if (is_array($actions)) {
			$this->actions = array_unique($actions);
		} else {
			$this->actions = null;
		}
	}

	public function toJSON() {
		if (is_array($this->actions) && $this->booleanSearch != null) {
			return array(
					'search' => $this->booleanSearch->getRawInput(),
					'actions' => $this->actions,
				);
		}
		return '';
	}

	public static function fromJSON($json) {
		if (!empty($json['search']) && !empty($json['actions']) && is_array($json['actions'])) {
			return new FilterAction(new FreshRSS_BooleanSearch($json['search']), $json['actions']);
		}
		return null;
	}
}

<?php
declare(strict_types=1);

namespace FreshRss\Models;

class FilterAction {

	/** @var list<string>|null */
	private ?array $actions = null;

	/** @param array<string> $actions */
	private function __construct(private readonly BooleanSearch $booleanSearch, array $actions) {
		$this->_actions($actions);
	}

	public function booleanSearch(): BooleanSearch {
		return $this->booleanSearch;
	}

	/** @return list<string> */
	public function actions(): array {
		return $this->actions ?? [];
	}

	/** @param array<string> $actions */
	public function _actions(?array $actions): void {
		if (is_array($actions)) {
			$this->actions = array_values(array_unique($actions));
		} else {
			$this->actions = null;
		}
	}

	/** @return array{search?:string,actions?:array<string>} */
	public function toJSON(): array {
		if (is_array($this->actions) && $this->booleanSearch != null) {
			return [
				'search' => $this->booleanSearch->toString(expandUserQueries: false),
				'actions' => $this->actions,
			];
		}
		return [];
	}

	/** @param array|mixed|null $json */
	public static function fromJSON($json): ?FilterAction {
		if (is_array($json) && !empty($json['search']) && is_string($json['search']) &&
			!empty($json['actions']) && is_array($json['actions']) && is_array_values_string($json['actions'])) {
			return new FilterAction(new BooleanSearch($json['search']), $json['actions']);
		}
		return null;
	}
}

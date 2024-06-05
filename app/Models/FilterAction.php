<?php
declare(strict_types=1);

class FreshRSS_FilterAction {

	private FreshRSS_BooleanSearch $booleanSearch;
	/** @var array<string>|null */
	private ?array $actions = null;

	/** @param array<string> $actions */
	private function __construct(FreshRSS_BooleanSearch $booleanSearch, array $actions) {
		$this->booleanSearch = $booleanSearch;
		$this->_actions($actions);
	}

	public function booleanSearch(): FreshRSS_BooleanSearch {
		return $this->booleanSearch;
	}

	/** @return array<string> */
	public function actions(): array {
		return $this->actions ?? [];
	}

	/** @param array<string> $actions */
	public function _actions(?array $actions): void {
		if (is_array($actions)) {
			$this->actions = array_unique($actions);
		} else {
			$this->actions = null;
		}
	}

	/** @return array{'search'?:string,'actions'?:array<string>} */
	public function toJSON(): array {
		if (is_array($this->actions) && $this->booleanSearch != null) {
			return [
				'search' => $this->booleanSearch->getRawInput(),
				'actions' => $this->actions,
			];
		}
		return [];
	}

	/** @param array|mixed|null $json */
	public static function fromJSON($json): ?FreshRSS_FilterAction {
		if (is_array($json) && !empty($json['search']) && !empty($json['actions']) && is_array($json['actions'])) {
			return new FreshRSS_FilterAction(new FreshRSS_BooleanSearch($json['search']), $json['actions']);
		}
		return null;
	}
}

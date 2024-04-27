<?php
declare(strict_types=1);

/**
 * Logic to apply filter actions (for feeds, categories, user configuration...).
 */
trait FreshRSS_FilterActionsTrait {

	/** @var array<FreshRSS_FilterAction>|null $filterActions */
	private ?array $filterActions = null;

	/**
	 * @return array<FreshRSS_FilterAction>
	 */
	private function filterActions(): array {
		if (empty($this->filterActions)) {
			$this->filterActions = [];
			$filters = $this->attributeArray('filters') ?? [];
			foreach ($filters as $filter) {
				$filterAction = FreshRSS_FilterAction::fromJSON($filter);
				if ($filterAction != null) {
					$this->filterActions[] = $filterAction;
				}
			}
		}
		return $this->filterActions;
	}

	/**
	 * @param array<FreshRSS_FilterAction>|null $filterActions
	 */
	private function _filterActions(?array $filterActions): void {
		$this->filterActions = $filterActions;
		if ($this->filterActions !== null && !empty($this->filterActions)) {
			$this->_attribute('filters', array_map(static function (?FreshRSS_FilterAction $af) {
					return $af == null ? null : $af->toJSON();
				}, $this->filterActions));
		} else {
			$this->_attribute('filters', null);
		}
	}

	/** @return array<FreshRSS_BooleanSearch> */
	public function filtersAction(string $action): array {
		$action = trim($action);
		if ($action == '') {
			return [];
		}
		$filters = [];
		$filterActions = $this->filterActions();
		for ($i = count($filterActions) - 1; $i >= 0; $i--) {
			$filterAction = $filterActions[$i];
			if (in_array($action, $filterAction->actions(), true)) {
				$filters[] = $filterAction->booleanSearch();
			}
		}
		return $filters;
	}

	/**
	 * @param array<string> $filters
	 */
	public function _filtersAction(string $action, array $filters): void {
		$action = trim($action);
		if ($action === '') {
			return;
		}
		$filters = array_unique(array_map('trim', $filters), SORT_STRING);
		$filterActions = $this->filterActions();

		//Check existing filters
		for ($i = count($filterActions) - 1; $i >= 0; $i--) {
			$filterAction = $filterActions[$i];
			if ($filterAction == null || !is_array($filterAction->actions()) ||
				$filterAction->booleanSearch() == null || trim($filterAction->booleanSearch()->getRawInput()) == '') {
				array_splice($filterActions, $i, 1);
				continue;
			}
			$actions = $filterAction->actions();
			//Remove existing rules with same action
			for ($j = count($actions) - 1; $j >= 0; $j--) {
				if ($actions[$j] === $action) {
					array_splice($actions, $j, 1);
				}
			}
			//Update existing filter with new action
			for ($k = count($filters) - 1; $k >= 0; $k --) {
				$filter = $filters[$k];
				if ($filter === $filterAction->booleanSearch()->getRawInput()) {
					$actions[] = $action;
					array_splice($filters, $k, 1);
				}
			}
			//Save result
			if (empty($actions)) {
				array_splice($filterActions, $i, 1);
			} else {
				$filterAction->_actions($actions);
			}
		}

		//Add new filters
		for ($k = count($filters) - 1; $k >= 0; $k --) {
			$filter = $filters[$k];
			if ($filter != '') {
				$filterAction = FreshRSS_FilterAction::fromJSON([
					'search' => $filter,
					'actions' => [$action],
				]);
				if ($filterAction != null) {
					$filterActions[] = $filterAction;
				}
			}
		}

		if (empty($filterActions)) {
			$filterActions = null;
		}
		$this->_filterActions($filterActions);
	}

	/**
	 * @param bool $applyLabel Parameter by reference, which will be set to true if the callers needs to apply a label to the article entry.
	 */
	public function applyFilterActions(FreshRSS_Entry $entry, ?bool &$applyLabel = null): void {
		$applyLabel = false;
		foreach ($this->filterActions() as $filterAction) {
			if ($entry->matches($filterAction->booleanSearch())) {
				foreach ($filterAction->actions() as $action) {
					switch ($action) {
						case 'read':
							if (!$entry->isRead()) {
								$entry->_isRead(true);
								Minz_ExtensionManager::callHook('entry_auto_read', $entry, 'filter');
							}
							break;
						case 'star':
							if (!$entry->isUpdated()) {
								// Do not apply to updated articles, to avoid overruling a user manual action
								$entry->_isFavorite(true);
							}
							break;
						case 'label':
							if (!$entry->isUpdated()) {
								// Do not apply to updated articles, to avoid overruling a user manual action
								$applyLabel = true;
							}
							break;
					}
				}
			}
		}
	}
}

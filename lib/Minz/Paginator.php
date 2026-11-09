<?php
declare(strict_types=1);

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Licensed under AGPL3 <https://www.gnu.org/licenses/>
*/

/**
 * The Minz_Paginator is used to handle paging
 */
class Minz_Paginator {
	/**
	 * @var list<Minz_Model> array of items to display or manage
	 */
	private array $items = [];

	/**
	 * Number of items per page
	 */
	private int $itemsPerPage = 10;

	/**
	 * Current page
	 */
	private int $currentPage = 1;

	/**
	 * Total number of pages
	 */
	private int $pageCount = 1;

	/**
	 * Number of items
	 */
	private int $itemCount = 0;

	/**
	 * Constructor
	 * @param list<Minz_Model> $items the items to manage
	 */
	public function __construct(array $items) {
		$this->_items($items);
		$this->_itemCount(count($this->items(true)));
		$this->_itemsPerPage($this->itemsPerPage);
		$this->_currentPage($this->currentPage);
	}

	/**
	 * Renders the pagination
	 * @param string $view name of the view file located in /app/views/helpers/
	 * @param string $getter name of the `$_GET` parameter used for pagination
	 */
	public function render(string $view, string $getter = 'page'): void {
		$view = APP_PATH . '/views/helpers/' . $view;

		if (file_exists($view)) {
			include $view;
		}
	}

	/**
	 * Finds the page containing a given item
	 * @param Minz_Model $item the item to find
	 * @return int|false the page containing the item, false if not found
	 */
	public function pageByItem(Minz_Model $item): int|false {
		$i = 0;

		do {
			if ($item === $this->items[$i]) {
				return (int)(ceil(($i + 1) / $this->itemsPerPage));
			}
			$i++;
		} while ($i < $this->itemCount());

		return false;
	}

	/**
	 * Search the position (index) of a given element
	 * @param Minz_Model $item the element to search
	 * @return int|false the position of the element, or false if not found
	 */
	public function positionByItem(Minz_Model $item): int|false {
		$i = 0;

		do {
			if ($item === $this->items[$i]) {
				return $i;
			}
			$i++;
		} while ($i < $this->itemCount());

		return false;
	}

	/**
	 * Gets the item at a given position
	 * @param int $pos the position of the item
	 * @return Minz_Model item at $pos (last item if $pos < 0, first if $pos >= count($items))
	 */
	public function itemByPosition(int $pos): Minz_Model {
		if ($pos < 0) {
			$pos = $this->itemCount() - 1;
		}
		if ($pos >= count($this->items)) {
			$pos = 0;
		}

		return $this->items[$pos];
	}

	/**
	 * Getters
	 */
	/**
	 * @param bool $all if true, returns all items without applying pagination
	 * @return list<Minz_Model>
	 */
	public function items(bool $all = false): array {
		$array = [];
		$itemCount = $this->itemCount();

		if ($itemCount <= $this->itemsPerPage || $all) {
			$array = $this->items;
		} else {
			$begin = ($this->currentPage - 1) * $this->itemsPerPage;
			$counter = 0;
			$i = 0;

			foreach ($this->items as $item) {
				if ($i >= $begin) {
					$array[] = $item;
					$counter++;
				}
				if ($counter >= $this->itemsPerPage) {
					break;
				}
				$i++;
			}
		}

		return $array;
	}
	public function itemsPerPage(): int {
		return $this->itemsPerPage;
	}
	public function currentPage(): int {
		return $this->currentPage;
	}
	public function pageCount(): int {
		return $this->pageCount;
	}
	public function itemCount(): int {
		return $this->itemCount;
	}

	/**
	 * Setters
	 */
	/** @param list<Minz_Model> $items */
	public function _items(?array $items): void {
		$this->items = $items ?? [];
		$this->_pageCount();
	}
	public function _itemsPerPage(int $itemsPerPage): void {
		if ($itemsPerPage > $this->itemCount()) {
			$itemsPerPage = $this->itemCount();
		}
		if ($itemsPerPage < 0) {
			$itemsPerPage = 0;
		}

		$this->itemsPerPage = $itemsPerPage;
		$this->_pageCount();
	}
	public function _currentPage(int $page): void {
		if ($page < 1 || ($page > $this->pageCount && $this->pageCount > 0)) {
			throw new Minz_CurrentPagePaginationException($page);
		}

		$this->currentPage = $page;
	}
	private function _pageCount(): void {
		if ($this->itemsPerPage > 0) {
			$this->pageCount = (int)ceil($this->itemCount() / $this->itemsPerPage);
		}
	}
	public function _itemCount(int $value): void {
		$this->itemCount = $value;
	}
}

<?php
declare(strict_types=1);

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Minz_Paginator is used to handle paging
 */
class Minz_Paginator {
	/**
	 * @var array<Minz_Model> tableau des éléments à afficher/gérer
	 */
	private array $items = [];

	/**
	 * le nombre d'éléments par page
	 */
	private int $nbItemsPerPage = 10;

	/**
	 * page actuelle à gérer
	 */
	private int $currentPage = 1;

	/**
	 * le nombre de pages de pagination
	 */
	private int $nbPage = 1;

	/**
	 * le nombre d'éléments
	 */
	private int $nbItems = 0;

	/**
	 * Constructeur
	 * @param array<Minz_Model> $items les éléments à gérer
	 */
	public function __construct(array $items) {
		$this->_items($items);
		$this->_nbItems(count($this->items(true)));
		$this->_nbItemsPerPage($this->nbItemsPerPage);
		$this->_currentPage($this->currentPage);
	}

	/**
	 * Permet d'afficher la pagination
	 * @param string $view nom du fichier de vue situé dans /app/views/helpers/
	 * @param string $getteur variable de type $_GET[] permettant de retrouver la page
	 */
	public function render(string $view, string $getteur = 'page'): void {
		$view = APP_PATH . '/views/helpers/' . $view;

		if (file_exists($view)) {
			include($view);
		}
	}

	/**
	 * Permet de retrouver la page d'un élément donné
	 * @param Minz_Model $item l'élément à retrouver
	 * @return int|false la page à laquelle se trouve l’élément, false si non trouvé
	 */
	public function pageByItem($item) {
		$i = 0;

		do {
			if ($item == $this->items[$i]) {
				return (int)(ceil(($i + 1) / $this->nbItemsPerPage));
			}
			$i++;
		} while ($i < $this->nbItems());

		return false;
	}

	/**
	 * Search the position (index) of a given element
	 * @param Minz_Model $item the element to search
	 * @return int|false the position of the element, or false if not found
	 */
	public function positionByItem($item) {
		$i = 0;

		do {
			if ($item == $this->items[$i]) {
				return $i;
			}
			$i++;
		} while ($i < $this->nbItems());

		return false;
	}

	/**
	 * Permet de récupérer un item par sa position
	 * @param int $pos la position de l'élément
	 * @return Minz_Model item situé à $pos (dernier item si $pos<0, 1er si $pos>=count($items))
	 */
	public function itemByPosition(int $pos): Minz_Model {
		if ($pos < 0) {
			$pos = $this->nbItems() - 1;
		}
		if ($pos >= count($this->items)) {
			$pos = 0;
		}

		return $this->items[$pos];
	}

	/**
	 * GETTEURS
	 */
	/**
	 * @param bool $all si à true, retourne tous les éléments sans prendre en compte la pagination
	 * @return array<Minz_Model>
	 */
	public function items(bool $all = false): array {
		$array = array ();
		$nbItems = $this->nbItems();

		if ($nbItems <= $this->nbItemsPerPage || $all) {
			$array = $this->items;
		} else {
			$begin = ($this->currentPage - 1) * $this->nbItemsPerPage;
			$counter = 0;
			$i = 0;

			foreach ($this->items as $key => $item) {
				if ($i >= $begin) {
					$array[$key] = $item;
					$counter++;
				}
				if ($counter >= $this->nbItemsPerPage) {
					break;
				}
				$i++;
			}
		}

		return $array;
	}
	public function nbItemsPerPage(): int {
		return $this->nbItemsPerPage;
	}
	public function currentPage(): int {
		return $this->currentPage;
	}
	public function nbPage(): int {
		return $this->nbPage;
	}
	public function nbItems(): int {
		return $this->nbItems;
	}

	/**
	 * SETTEURS
	 */
	/** @param array<Minz_Model> $items */
	public function _items(?array $items): void {
		$this->items = $items ?? [];
		$this->_nbPage();
	}
	public function _nbItemsPerPage(int $nbItemsPerPage): void {
		if ($nbItemsPerPage > $this->nbItems()) {
			$nbItemsPerPage = $this->nbItems();
		}
		if ($nbItemsPerPage < 0) {
			$nbItemsPerPage = 0;
		}

		$this->nbItemsPerPage = $nbItemsPerPage;
		$this->_nbPage();
	}
	public function _currentPage(int $page): void {
		if ($page < 1 || ($page > $this->nbPage && $this->nbPage > 0)) {
			throw new Minz_CurrentPagePaginationException($page);
		}

		$this->currentPage = $page;
	}
	private function _nbPage(): void {
		if ($this->nbItemsPerPage > 0) {
			$this->nbPage = (int)ceil($this->nbItems() / $this->nbItemsPerPage);
		}
	}
	public function _nbItems(int $value): void {
		$this->nbItems = $value;
	}
}

<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Paginator permet de gérer la pagination de l'application facilement
 */
class Minz_Paginator {
	/**
	 * @var array<Minz_Model> tableau des éléments à afficher/gérer
	 */
	private $items = array ();

	/**
	 * @var int le nombre d'éléments par page
	 */
	private $nbItemsPerPage = 10;

	/**
	 * @var int page actuelle à gérer
	 */
	private $currentPage = 1;

	/**
	 * @var int le nombre de pages de pagination
	 */
	private $nbPage = 1;

	/**
	 * @var int le nombre d'éléments
	 */
	private $nbItems = 0;

	/**
	 * Constructeur
	 * @param array<Minz_Model> $items les éléments à gérer
	 */
	public function __construct ($items) {
		$this->_items ($items);
		$this->_nbItems (count ($this->items (true)));
		$this->_nbItemsPerPage ($this->nbItemsPerPage);
		$this->_currentPage ($this->currentPage);
	}

	/**
	 * Permet d'afficher la pagination
	 * @param string $view nom du fichier de vue situé dans /app/views/helpers/
	 * @param int $getteur variable de type $_GET[] permettant de retrouver la page
	 */
	public function render ($view, $getteur) {
		$view = APP_PATH . '/views/helpers/' . $view;

		if (file_exists ($view)) {
			include ($view);
		}
	}

	/**
	 * Permet de retrouver la page d'un élément donné
	 * @param Minz_Model $item l'élément à retrouver
	 * @return float|false la page à laquelle se trouve l’élément, false si non trouvé
	 */
	public function pageByItem ($item) {
		$i = 0;

		do {
			if ($item == $this->items[$i]) {
				return ceil(($i + 1) / $this->nbItemsPerPage);
			}
			$i++;
		} while ($i < $this->nbItems());

		return false;
	}

	/**
	 * Permet de retrouver la position d'un élément donné (à partir de 0)
	 * @param Minz_Model $item l'élément à retrouver
	 * @return float|false la position à laquelle se trouve l’élément, false si non trouvé
	 */
	public function positionByItem ($item) {
		$i = 0;

		do {
			if ($item == $this->items[$i]) {
				return $i;
			}
			$i++;
		} while ($i < $this->nbItems ());

		return false;
	}

	/**
	 * Permet de récupérer un item par sa position
	 * @param int $pos la position de l'élément
	 * @return mixed item situé à $pos (dernier item si $pos<0, 1er si $pos>=count($items))
	 */
	public function itemByPosition ($pos) {
		if ($pos < 0) {
			$pos = $this->nbItems () - 1;
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
	public function items ($all = false) {
		$array = array ();
		$nbItems = $this->nbItems ();

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
	public function nbItemsPerPage () {
		return $this->nbItemsPerPage;
	}
	public function currentPage () {
		return $this->currentPage;
	}
	public function nbPage () {
		return $this->nbPage;
	}
	public function nbItems () {
		return $this->nbItems;
	}

	/**
	 * SETTEURS
	 */
	public function _items ($items) {
		if (is_array ($items)) {
			$this->items = $items;
		}

		$this->_nbPage ();
	}
	public function _nbItemsPerPage ($nbItemsPerPage) {
		if ($nbItemsPerPage > $this->nbItems ()) {
			$nbItemsPerPage = $this->nbItems ();
		}
		if ($nbItemsPerPage < 0) {
			$nbItemsPerPage = 0;
		}

		$this->nbItemsPerPage = $nbItemsPerPage;
		$this->_nbPage ();
	}
	public function _currentPage ($page) {
		if ($page < 1 || ($page > $this->nbPage && $this->nbPage > 0)) {
			throw new Minz_CurrentPagePaginationException($page);
		}

		$this->currentPage = $page;
	}
	private function _nbPage () {
		if ($this->nbItemsPerPage > 0) {
			$this->nbPage = (int)ceil($this->nbItems() / $this->nbItemsPerPage);
		}
	}
	public function _nbItems ($value) {
		$this->nbItems = $value;
	}
}

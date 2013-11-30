<?php

// Un système de pagination beaucoup plus simple que Paginator
// mais mieux adapté à nos besoins
class RSSPaginator {
	private $items = array ();
	private $next = '';

	public function __construct ($items, $next) {
		$this->items = $items;
		$this->next = $next;
	}

	public function isEmpty () {
		return empty ($this->items);
	}

	public function items () {
		return $this->items;
	}

	public function next () {
		return $this->next;
	}

	public function peek () {
		return isset($this->items[0]) ? $this->items[0] : null;
	}

	public function render ($view, $getteur) {
		$view = APP_PATH . '/views/helpers/'.$view;

		if (file_exists ($view)) {
			include ($view);
		}
	}
}

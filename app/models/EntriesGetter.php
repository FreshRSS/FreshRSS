<?php

class EntriesGetter {
	private $type = array (
		'type' => 'all',
		'id' => 'all'
	);
	private $state = 'all';
	private $filter = array (
		'words' => array (),
		'tags' => array (),
	);
	private $order = 'high_to_low';
	private $entries = array ();

	private $nb = 1;
	private $first = '';
	private $next = '';

	public function __construct ($type, $state, $filter, $order, $nb, $first = '') {
		$this->_type ($type);
		$this->_state ($state);
		$this->_filter ($filter);
		$this->_order ($order);
		$this->nb = $nb;
		$this->first = $first;
	}

	public function type () {
		return $this->type;
	}
	public function state () {
		return $this->state;
	}
	public function filter () {
		return $this->filter;
	}
	public function order () {
		return $this->order;
	}
	public function entries () {
		return $this->entries;
	}

	public function _type ($value) {
		if (!is_array ($value) ||
		    !isset ($value['type']) ||
		    !isset ($value['id'])) {
			throw new EntriesGetterException ('Bad type line ' . __LINE__ . ' in file ' . __FILE__);
		}

		$type = $value['type'];
		$id = $value['id'];

		if ($type != 'all' && $type != 'favoris' && $type != 'public' && $type != 'c' && $type != 'f') {
			throw new EntriesGetterException ('Bad type line ' . __LINE__ . ' in file ' . __FILE__);
		}

		if (($type == 'all' || $type == 'favoris' || $type == 'public') &&
		    ($type != $id)) {
			throw new EntriesGetterException ('Bad type line ' . __LINE__ . ' in file ' . __FILE__);
		}

		$this->type = $value;
	}
	public function _state ($value) {
		if ($value != 'all' && $value != 'not_read' && $value != 'read') {
			throw new EntriesGetterException ('Bad state line ' . __LINE__ . ' in file ' . __FILE__);
		}

		$this->state = $value;
	}
	public function _filter ($value) {
		$value = trim ($value);
		$terms = explode (' ', $value);

		foreach ($terms as $word) {
			if (!empty ($word) && $word[0] == '#' && isset ($word[1])) {
				$tag = substr ($word, 1);
				$this->filter['tags'][$tag] = $tag;
			} elseif (!empty ($word)) {
				$this->filter['words'][$word] = $word;
			}
		}
	}
	public function _order ($value) {
		if ($value != 'high_to_low' && $value != 'low_to_high') {
			throw new EntriesGetterException ('Bad order line ' . __LINE__ . ' in file ' . __FILE__);
		}

		$this->order = $value;
	}

	public function execute () {
		$entryDAO = new EntryDAO ();

		HelperEntry::$nb = $this->nb;
		HelperEntry::$first = $this->first;
		HelperEntry::$filter = $this->filter;

		switch ($this->type['type']) {
		case 'all':
			list ($this->entries, $this->next) = $entryDAO->listEntries (
				$this->state,
				$this->order
			);
			break;
		case 'favoris':
			list ($this->entries, $this->next) = $entryDAO->listFavorites (
				$this->state,
				$this->order
			);
			break;
		case 'public':
			list ($this->entries, $this->next) = $entryDAO->listPublic (
				$this->state,
				$this->order
			);
			break;
		case 'c':
			list ($this->entries, $this->next) = $entryDAO->listByCategory (
				$this->type['id'],
				$this->state,
				$this->order
			);
			break;
		case 'f':
			list ($this->entries, $this->next) = $entryDAO->listByFeed (
				$this->type['id'],
				$this->state,
				$this->order
			);
			break;
		default:
			throw new EntriesGetterException ('Bad type line ' . __LINE__ . ' in file ' . __FILE__);
		}
	}

	public function getPaginator () {
		$paginator = new RSSPaginator ($this->entries, $this->next);

		return $paginator;
	}
}

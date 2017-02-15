<?php

class FreshRSS_Entry extends Minz_Model {
	const STATE_READ = 1;
	const STATE_NOT_READ = 2;
	const STATE_ALL = 3;
	const STATE_FAVORITE = 4;
	const STATE_NOT_FAVORITE = 8;

	private $id = 0;
	private $guid;
	private $title;
	private $author;
	private $content;
	private $link;
	private $date;
	private $hash = null;
	private $is_read;	//Nullable boolean
	private $is_favorite;
	private $feed;
	private $tags;

	public function __construct($feed = '', $guid = '', $title = '', $author = '', $content = '',
	                            $link = '', $pubdate = 0, $is_read = false, $is_favorite = false, $tags = '') {
		$this->_guid($guid);
		$this->_title($title);
		$this->_author($author);
		$this->_content($content);
		$this->_link($link);
		$this->_date($pubdate);
		$this->_isRead($is_read);
		$this->_isFavorite($is_favorite);
		$this->_feed($feed);
		$this->_tags(preg_split('/[\s#]/', $tags));
	}

	public function id() {
		return $this->id;
	}
	public function guid() {
		return $this->guid;
	}
	public function title() {
		return $this->title;
	}
	public function author() {
		return $this->author === null ? '' : $this->author;
	}
	public function content() {
		return $this->content;
	}
	public function link() {
		return $this->link;
	}
	public function date($raw = false) {
		if ($raw) {
			return $this->date;
		} else {
			return timestamptodate($this->date);
		}
	}
	public function dateAdded($raw = false) {
		$date = intval(substr($this->id, 0, -6));
		if ($raw) {
			return $date;
		} else {
			return timestamptodate($date);
		}
	}
	public function isRead() {
		return $this->is_read;
	}
	public function isFavorite() {
		return $this->is_favorite;
	}
	public function feed($object = false) {
		if ($object) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			return $feedDAO->searchById($this->feed);
		} else {
			return $this->feed;
		}
	}
	public function tags($inString = false) {
		if ($inString) {
			return empty($this->tags) ? '' : '#' . implode(' #', $this->tags);
		} else {
			return $this->tags;
		}
	}

	public function hash() {
		if ($this->hash === null) {
			//Do not include $this->date because it may be automatically generated when lacking
			$this->hash = md5($this->link . $this->title . $this->author . $this->content . $this->tags(true));
		}
		return $this->hash;
	}

	public function _id($value) {
		$this->id = $value;
	}
	public function _guid($value) {
		$this->guid = $value;
	}
	public function _title($value) {
		$this->hash = null;
		$this->title = $value;
	}
	public function _author($value) {
		$this->hash = null;
		$this->author = $value;
	}
	public function _content($value) {
		$this->hash = null;
		$this->content = $value;
	}
	public function _link($value) {
		$this->hash = null;
		$this->link = $value;
	}
	public function _date($value) {
		$this->hash = null;
		$value = intval($value);
		$this->date = $value > 1 ? $value : time();
	}
	public function _isRead($value) {
		$this->is_read = $value === null ? null : (bool)$value;
	}
	public function _isFavorite($value) {
		$this->is_favorite = $value;
	}
	public function _feed($value) {
		$this->feed = $value;
	}
	public function _tags($value) {
		$this->hash = null;
		if (!is_array($value)) {
			$value = array($value);
		}

		foreach ($value as $key => $t) {
			if (!$t) {
				unset($value[$key]);
			}
		}

		$this->tags = $value;
	}

	public function isDay($day, $today) {
		$date = $this->dateAdded(true);
		switch ($day) {
		case FreshRSS_Days::TODAY:
			$tomorrow = $today + 86400;
			return $date >= $today && $date < $tomorrow;
		case FreshRSS_Days::YESTERDAY:
			$yesterday = $today - 86400;
			return $date >= $yesterday && $date < $today;
		case FreshRSS_Days::BEFORE_YESTERDAY:
			$yesterday = $today - 86400;
			return $date < $yesterday;
		default:
			return false;
		}
	}

	public function loadCompleteContent($pathEntries) {
		// Gestion du contenu
		// On cherche à récupérer les articles en entier... même si le flux ne le propose pas
		if ($pathEntries) {
			$entryDAO = FreshRSS_Factory::createEntryDao();
			$entry = $entryDAO->searchByGuid($this->feed, $this->guid);

			if ($entry) {
				// l'article existe déjà en BDD, en se contente de recharger ce contenu
				$this->content = $entry->content();
			} else {
				try {
					// l'article n'est pas en BDD, on va le chercher sur le site
					$this->content = get_content_by_parsing(
						htmlspecialchars_decode($this->link(), ENT_QUOTES), $pathEntries
					);
				} catch (Exception $e) {
					// rien à faire, on garde l'ancien contenu(requête a échoué)
				}
			}
		}
	}

	public function toArray() {
		return array(
			'id' => $this->id(),
			'guid' => $this->guid(),
			'title' => $this->title(),
			'author' => $this->author(),
			'content' => $this->content(),
			'link' => $this->link(),
			'date' => $this->date(true),
			'hash' => $this->hash(),
			'is_read' => $this->isRead(),
			'is_favorite' => $this->isFavorite(),
			'id_feed' => $this->feed(),
			'tags' => $this->tags(true),
		);
	}
}

<?php

class FreshRSS_Category extends Minz_Model {

	/**
	 * Normal
	 * @var int
	 */
	const KIND_NORMAL = 0;

	/**
	 * Category tracking a third-party Dynamic OPML
	 * @var int
	 */
	const KIND_DYNAMIC_OPML = 2;

	/**
	 * @var int
	 */
	private $id = 0;
	/** @var int */
	private $kind = 0;
	private $name;
	private $nbFeeds = -1;
	private $nbNotRead = -1;
	private $feeds = null;
	private $hasFeedsWithError = false;
	private $attributes = [];

	public function __construct(string $name = '', $feeds = null) {
		$this->_name($name);
		if (isset($feeds)) {
			$this->_feeds($feeds);
			$this->nbFeeds = 0;
			$this->nbNotRead = 0;
			foreach ($feeds as $feed) {
				$this->nbFeeds++;
				$this->nbNotRead += $feed->nbNotRead();
				$this->hasFeedsWithError |= $feed->inError();
			}
		}
	}

	public function id(): int {
		return $this->id;
	}
	public function kind(): int {
		return $this->kind;
	}
	public function name(): string {
		return $this->name;
	}
	public function isDefault(): bool {
		return $this->id == FreshRSS_CategoryDAO::DEFAULTCATEGORYID;
	}
	public function nbFeeds(): int {
		if ($this->nbFeeds < 0) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$this->nbFeeds = $catDAO->countFeed($this->id());
		}

		return $this->nbFeeds;
	}
	public function nbNotRead(): int {
		if ($this->nbNotRead < 0) {
			$catDAO = FreshRSS_Factory::createCategoryDao();
			$this->nbNotRead = $catDAO->countNotRead($this->id());
		}

		return $this->nbNotRead;
	}

	/** @return array<FreshRSS_Feed> */
	public function feeds(): array {
		if ($this->feeds === null) {
			$feedDAO = FreshRSS_Factory::createFeedDao();
			$this->feeds = $feedDAO->listByCategory($this->id());
			$this->nbFeeds = 0;
			$this->nbNotRead = 0;
			foreach ($this->feeds as $feed) {
				$this->nbFeeds++;
				$this->nbNotRead += $feed->nbNotRead();
				$this->hasFeedsWithError |= $feed->inError();
			}

			usort($this->feeds, function ($a, $b) {
				return strnatcasecmp($a->name(), $b->name());
			});
		}

		return $this->feeds;
	}

	public function hasFeedsWithError() {
		return $this->hasFeedsWithError;
	}

	public function attributes($key = '') {
		if ($key == '') {
			return $this->attributes;
		} else {
			return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
		}
	}

	public function _id($id) {
		$this->id = intval($id);
		if ($id == FreshRSS_CategoryDAO::DEFAULTCATEGORYID) {
			$this->_name(_t('gen.short.default_category'));
		}
	}

	public function _kind(int $kind) {
		$this->kind = $kind;
	}

	public function _name($value) {
		$this->name = mb_strcut(trim($value), 0, 255, 'UTF-8');
	}
	public function _feeds($values) {
		if (!is_array($values)) {
			$values = array($values);
		}

		$this->feeds = $values;
	}

	public function _attributes($key, $value) {
		if ('' == $key) {
			if (is_string($value)) {
				$value = json_decode($value, true);
			}
			if (is_array($value)) {
				$this->attributes = $value;
			}
		} elseif (null === $value) {
			unset($this->attributes[$key]);
		} else {
			$this->attributes[$key] = $value;
		}
	}

	public function refreshDynamicOpml() {
		// TODO
	}
}

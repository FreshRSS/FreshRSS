<?php

/**
 * Manage the reading modes in FreshRSS.
 */
class FreshRSS_ReadingMode {

	/**
	 * @var string
	 */
	protected $id;
	/**
	 * @var string
	 */
	protected $name;
	/**
	 * @var string
	 */
	protected $title;
	/**
	 * @var string[]
	 */
	protected $urlParams;
	/**
	 * @var bool
	 */
	protected $isActive = false;

	/**
	 * ReadingMode constructor.
	 * @param string $id
	 * @param string $title
	 * @param string[] $urlParams
	 * @param bool $active
	 */
	public function __construct($id, $title, $urlParams, $active) {
		$this->id = $id;
		$this->name = _i($id);
		$this->title = $title;
		$this->urlParams = $urlParams;
		$this->isActive = $active;
	}

	/**
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return FreshRSS_ReadingMode
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return FreshRSS_ReadingMode
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrlParams() {
		return $this->urlParams;
	}

	/**
	 * @param string $urlParams
	 * @return FreshRSS_ReadingMode
	 */
	public function setUrlParams($urlParams) {
		$this->urlParams = $urlParams;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isActive() {
		return $this->isActive;
	}

	/**
	 * @param bool $isActive
	 * @return FreshRSS_ReadingMode
	 */
	public function setIsActive($isActive) {
		$this->isActive = $isActive;
		return $this;
	}

	/**
	 * Returns the built-in reading modes.
	 * return ReadingMode[]
	 */
	public static function getReadingModes() {
		$actualView = Minz_Request::actionName();
		$defaultCtrl = Minz_Request::defaultControllerName();
		$isDefaultCtrl = Minz_Request::controllerName() === $defaultCtrl;
		$urlOutput = Minz_Request::currentRequest();

		$readingModes = array(
			new FreshRSS_ReadingMode(
				"view-normal",
				_t('index.menu.normal_view'),
				array_merge($urlOutput, array('c' => $defaultCtrl, 'a' => 'normal')),
				($isDefaultCtrl && $actualView === 'normal')
			),
			new FreshRSS_ReadingMode(
				"view-global",
				_t('index.menu.global_view'),
				array_merge($urlOutput, array('c' => $defaultCtrl, 'a' => 'global')),
				($isDefaultCtrl && $actualView === 'global')
			),
			new FreshRSS_ReadingMode(
				"view-reader",
				_t('index.menu.reader_view'),
				array_merge($urlOutput, array('c' => $defaultCtrl, 'a' => 'reader')),
				($isDefaultCtrl && $actualView === 'reader')
			),
			
			new FreshRSS_ReadingMode(
				"view-contextview",
				_t('index.menu.contextview_view'),
				array_merge($urlOutput, array('c' => $defaultCtrl, 'a' => 'contextview')),
				($isDefaultCtrl && $actualView === 'contextview')
			),
		);

		return $readingModes;
	}
}

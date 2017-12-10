<?php

/**
 * Manage the reading modes in FreshRSS.
 */
class FreshRSS_ReadingMode {

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
	 * @param string $name
	 * @param string $title
	 * @param string[] $urlParams
	 * @param bool $active
	 */
	public function __construct($name, $title, $urlParams, $active) {
		$this->name = $name;
		$this->title = $title;
		$this->urlParams = $urlParams;
		$this->isActive = $active;
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
		$isDefaultCtrl = Minz_Request::controllerName() == $defaultCtrl;
		$urlOutput = Minz_Request::currentRequest();

		$readingModes = array(
			new FreshRSS_ReadingMode(
				_i("view-normal"),
				_t('index.menu.normal_view'),
				array_merge($urlOutput, array('c' => $defaultCtrl, 'a' => 'normal')),
				($isDefaultCtrl && $actualView === 'normal')
			),
			new FreshRSS_ReadingMode(
				_i("view-global"),
				_t('index.menu.global_view'),
				array_merge($urlOutput, array('c' => $defaultCtrl, 'a' => 'global')),
				($isDefaultCtrl && $actualView === 'global')
			),
			new FreshRSS_ReadingMode(
				_i("view-reader"),
				_t('index.menu.reader_view'),
				array_merge($urlOutput, array('c' => $defaultCtrl, 'a' => 'reader')),
				($isDefaultCtrl && $actualView === 'reader')
			),
		);

		return $readingModes;
	}
}

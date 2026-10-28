<?php
declare(strict_types=1);

/**
 * Manage the reading modes in FreshRSS.
 */
class FreshRSS_ReadingMode {

	protected string $name;

	/**
	 * ReadingMode constructor.
	 * @param array{c:string,a:string,params:array<string,mixed>} $urlParams
	 */
	public function __construct(protected string $id, protected string $title, protected array $urlParams, protected bool $isActive) {
		$this->name = _i($this->id);
	}

	public function getId(): string {
		return $this->id;
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name): FreshRSS_ReadingMode {
		$this->name = $name;
		return $this;
	}

	public function getTitle(): string {
		return $this->title;
	}

	public function setTitle(string $title): FreshRSS_ReadingMode {
		$this->title = $title;
		return $this;
	}

	/** @return array{c:string,a:string,params:array<string,mixed>} */
	public function getUrlParams(): array {
		return $this->urlParams;
	}

	/** @param array{c:string,a:string,params:array<string,mixed>} $urlParams */
	public function setUrlParams(array $urlParams): FreshRSS_ReadingMode {
		$this->urlParams = $urlParams;
		return $this;
	}

	public function isActive(): bool {
		return $this->isActive;
	}

	public function setIsActive(bool $isActive): FreshRSS_ReadingMode {
		$this->isActive = $isActive;
		return $this;
	}

	/**
	 * @return list<FreshRSS_ReadingMode> the built-in reading modes
	 */
	public static function getReadingModes(): array {
		$actualView = Minz_Request::actionName();
		$defaultCtrl = Minz_Request::defaultControllerName();
		$isDefaultCtrl = Minz_Request::controllerName() === $defaultCtrl;
		$urlOutput = Minz_Request::currentRequest();

		$readingModes = [
			new FreshRSS_ReadingMode(
				"view-normal",
				_t('index.menu.normal_view'),
				array_merge($urlOutput, ['c' => $defaultCtrl, 'a' => 'normal']),
				($isDefaultCtrl && $actualView === 'normal')
			),
			new FreshRSS_ReadingMode(
				"view-global",
				_t('index.menu.global_view'),
				array_merge($urlOutput, ['c' => $defaultCtrl, 'a' => 'global']),
				($isDefaultCtrl && $actualView === 'global')
			),
			new FreshRSS_ReadingMode(
				"view-reader",
				_t('index.menu.reader_view'),
				array_merge($urlOutput, ['c' => $defaultCtrl, 'a' => 'reader']),
				($isDefaultCtrl && $actualView === 'reader')
			)
		];

		return $readingModes;
	}
}

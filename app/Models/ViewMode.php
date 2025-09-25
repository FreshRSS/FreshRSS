<?php
declare(strict_types=1);

/**
 * Represents a view mode option for the reading configuration
 */
final class FreshRSS_ViewMode {
	private string $id;
	private string $name;
	private string $controller;
	private string $action;

	public function __construct(string $id, string $name, string $controller = 'index', string $action = '') {
		$this->id = $id;
		$this->name = $name;
		$this->controller = $controller;
		$this->action = $action ?: $id;
	}

	public function id(): string {
		return $this->id;
	}

	public function name(): string {
		return $this->name;
	}

	public function controller(): string {
		return $this->controller;
	}

	public function action(): string {
		return $this->action;
	}

	/**
	 * @return array<string,FreshRSS_ViewMode> Mode ID => FreshRSS_ViewMode
	 */
	public static function getDefaultModes(): array {
		return [
			'normal' => new self(id: 'normal', name: _t('conf.reading.view.normal'), controller: 'index', action: 'normal'),
			'reader' => new self(id: 'reader', name: _t('conf.reading.view.reader'), controller: 'index', action: 'reader'),
			'global' => new self(id: 'global', name: _t('conf.reading.view.global'), controller: 'index', action: 'global'),
		];
	}

	/**
	 * @return array<string,FreshRSS_ViewMode> Mode ID => FreshRSS_ViewMode
	 */
	public static function getAllModes(): array {
		$modes = self::getDefaultModes();

		// Allow extensions to add their own view modes
		$extensionModes = Minz_ExtensionManager::callHook('view_modes', []);
		if (is_array($extensionModes)) {
			foreach ($extensionModes as $mode) {
				if ($mode instanceof FreshRSS_ViewMode) {
					$modes[$mode->id()] = $mode;
				}
			}
		}

		return $modes;
	}
}

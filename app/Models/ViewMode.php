<?php
declare(strict_types=1);

namespace FreshRss\Models;

use FreshRss\Minz\ExtensionManager;
use FreshRss\Minz\HookType;

/**
 * Represents a view mode option for the reading configuration
 */
final class ViewMode {
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
	 * @return array<string,ViewMode> Mode ID => ViewMode
	 */
	public static function getDefaultModes(): array {
		return [
			'normal' => new self(id: 'normal', name: _t('conf.reading.view.normal'), controller: 'index', action: 'normal'),
			'reader' => new self(id: 'reader', name: _t('conf.reading.view.reader'), controller: 'index', action: 'reader'),
			'global' => new self(id: 'global', name: _t('conf.reading.view.global'), controller: 'index', action: 'global'),
		];
	}

	/**
	 * @return array<string,ViewMode> Mode ID => ViewMode
	 */
	public static function getAllModes(): array {
		$modes = self::getDefaultModes();

		// Allow extensions to add their own view modes
		$extensionModes = ExtensionManager::callHook(HookType::ViewModes, []);
		if (is_array($extensionModes)) {
			foreach ($extensionModes as $mode) {
				if ($mode instanceof ViewMode) {
					$modes[$mode->id()] = $mode;
				}
			}
		}

		return $modes;
	}
}

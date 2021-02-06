<?php

class FreshRSS_Themes extends Minz_Model {
	public static $defaultTheme = 'Origine';
	private static $alts = [
		'add' => '✚',
		'add-white' => '✚',
		'all' => '☰',
		'bookmark' => '★',
		'bookmark-add' => '✚',
		'category' => '☷',
		'category-white' => '☷',
		'close' => '❌',
		'configure' => '⚙',
		'down' => '▽',
		'favorite' => '★',
		'help' => 'ⓘ',
		'icon' => '⊚',
		'import' => '⤓',
		'key' => '⚿',
		'label' => '🏷️',
		'link' => '↗',
		'login' => '🔒',
		'logout' => '🔓',
		'look' => '👁',
		'next' => '⏩',
		'non-starred' => '☆',
		'prev' => '⏪',
		'read' => '☑',
		'refresh' => '🔃',	//↻
		'rss' => '☄',
		'search' => '🔍',
		'share' => '♺',
		'starred' => '★',
		'stats' => '%',
		'tag' => '⚐',
		'unread' => '☐',
		'up' => '△',
		'view-global' => '☷',
		'view-normal' => '☰',
		'view-reader' => '☕',
	];
	private static $iconPaths = [];

	/**
	 * @return array of Minz_ThemeExtension
	 */
	public static function get() {
		$themes = Minz_ExtensionManager::listThemes(true);
		ksort($themes);

		return $themes;
	}

	/**
	 * @return bool
	 */
	public static function isAvailable(string $theme) {
		$themes = Minz_ExtensionManager::listThemes(true);
		return array_key_exists($theme, $themes);
	}

	public static function load(string $theme) {
		if (null === $theme = Minz_ExtensionManager::findExtension($theme)) {
			return;
		}

		foreach (self::$alts as $key => $value) {
			self::$iconPaths[$key] = Minz_Url::display("/themes/icons/{$key}.svg");
		}
		foreach ($theme->getIconFiles() as $key => $value) {
			self::$iconPaths[$key] = $value;
		}

		return $theme;
	}

	/**
	 * @return string
	 */
	public static function alt(string $name) {
		return isset($name) ? self::$alts[$name] : '';
	}

	/**
	 * @return bool
	 */
	private static function isIconSupported(string $iconName) {
		return array_key_exists($iconName, self::$alts);
	}

	/**
	 * @return string
	 */
	public static function icon(string $name, $urlOnly = false, $altOnly = false) {
		if (!self::isIconSupported($name)) {
			return '';
		}

		$url = self::$iconPaths[$name];
		if ($urlOnly) {
			return $url;
		}

		$altValue = self::$alts[$name];
		return "<img class=\"icon\" src=\"{$url}\" alt=\"{$altValue}\" />";
	}
}

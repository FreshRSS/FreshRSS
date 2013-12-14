<?php

class RSSThemes extends Model {
	private static $themesUrl = '/themes/';
	private static $defaultIconsUrl = '/themes/icons/';

	public static function get() {
		$themes_list = array_diff(
			scandir(PUBLIC_PATH . self::$themesUrl),
			array('..', '.')
		);

		$list = array();
		foreach ($themes_list as $theme_dir) {
			$theme = self::get_infos($theme_dir);
			if ($theme) {
				$list[$theme_dir] = $theme;
			}
		}
		return $list;
	}

	public static function get_infos($theme_id) {
		$theme_dir = PUBLIC_PATH . self::$themesUrl . $theme_id ;
		if (is_dir($theme_dir)) {
			$json_filename = $theme_dir . '/metadata.json';
			if (file_exists($json_filename)) {
				$content = file_get_contents($json_filename);
				$res = json_decode($content, true);
				if ($res && isset($res['files']) && is_array($res['files'])) {
					$res['path'] = $theme_id;
					return $res;
				}
			}
		}
		return false;
	}

	private static $themeIconsUrl;
	private static $themeIcons;

	public static function setThemeId($theme_id) {
		self::$themeIconsUrl = self::$themesUrl . $theme_id . '/icons/';
		self::$themeIcons = is_dir(PUBLIC_PATH . self::$themeIconsUrl) ? array_fill_keys(array_diff(
			scandir(PUBLIC_PATH . self::$themeIconsUrl),
			array('..', '.')
		), 1) : array();
	}

	public static function icon($name, $urlOnly = false) {
		static $alts = array(
			'add' => '✚',
			'all' => '☰',
			'bookmark' => '★',
			'category' => '☷',
			'category-white' => '☷',
			'close' => '❌',
			'configure' => '⚙',
			'down' => '▽',
			'favorite' => '★',
			'help' => 'ⓘ',
			'link' => '↗',
			'login' => '🔒',
			'logout' => '🔓',
			'next' => '⏩',
			'non-starred' => '☆',
			'prev' => '⏪',
			'read' => '☑',
			'unread' => '☐',
			'refresh' => '🔃',	//↻
			'search' => '🔍',
			'share' => '♺',
			'starred' => '★',
			'tag' => '⚐',
			'up' => '△',
		);
		if (!isset($alts[$name])) {
			return '';
		}

		$url = $name . '.svg';
		$url = isset(self::$themeIcons[$url]) ? (self::$themeIconsUrl . $url) :
			(self::$defaultIconsUrl . $url);

		return $urlOnly ? Url::display($url) :
			'<img class="icon" src="' . Url::display($url) . '" alt="' . $alts[$name] . '" />';
	}
}

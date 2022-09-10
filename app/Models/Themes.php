<?php

class FreshRSS_Themes extends Minz_Model {
	private static $themesUrl = '/themes/';
	private static $defaultIconsUrl = '/themes/icons/';
	public static $defaultTheme = 'Origine';

	public static function getList() {
		return array_values(array_diff(
			scandir(PUBLIC_PATH . self::$themesUrl),
			array('..', '.')
		));
	}

	public static function get() {
		$themes_list = self::getList();
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
		$theme_dir = PUBLIC_PATH . self::$themesUrl . $theme_id;
		if (is_dir($theme_dir)) {
			$json_filename = $theme_dir . '/metadata.json';
			if (file_exists($json_filename)) {
				$content = file_get_contents($json_filename);
				$res = json_decode($content, true);
				if ($res &&
						!empty($res['name']) &&
						isset($res['files']) &&
						is_array($res['files'])) {
					$res['id'] = $theme_id;
					return $res;
				}
			}
		}
		return false;
	}

	private static $themeIconsUrl;
	private static $themeIcons;

	public static function load($theme_id) {
		$infos = self::get_infos($theme_id);
		if (!$infos) {
			if ($theme_id !== self::$defaultTheme) {	//Fall-back to default theme
				return self::load(self::$defaultTheme);
			}
			$themes_list = self::getList();
			if (!empty($themes_list)) {
				if ($theme_id !== $themes_list[0]) {	//Fall-back to first theme
					return self::load($themes_list[0]);
				}
			}
			return false;
		}
		self::$themeIconsUrl = self::$themesUrl . $theme_id . '/icons/';
		self::$themeIcons = is_dir(PUBLIC_PATH . self::$themeIconsUrl) ? array_fill_keys(array_diff(
			scandir(PUBLIC_PATH . self::$themeIconsUrl),
			array('..', '.')
		), 1) : array();
		return $infos;
	}

	public static function title($name) {
		static $titles = [
			'opml-dyn' => 'sub.category.dynamic_opml',
		];
		return $titles[$name] ?? '';
	}

	public static function alt($name) {
		static $alts = array(
			'add' => '➕',	//✚
			'all' => '☰',
			'bookmark' => '✨',	//★
			'bookmark-add' => '➕',	//✚
			'bookmark-tag' => '📑',
			'category' => '🗂️',	//☷
			'close' => '❌',
			'configure' => '⚙️',
			'debug' => '🐛',
			'down' => '🔽',	//▽
			'error' => '❌',
			'favorite' => '⭐',	//★
			'FreshRSS-logo' => '⊚',
			'help' => 'ℹ️',	//ⓘ
			'icon' => '⊚',
			'key' => '🔑',	//⚿
			'label' => '🏷️',
			'link' => '↗️',	//↗
			'look' => '👀',	//👁
			'login' => '🔒',
			'logout' => '🔓',
			'next' => '⏩',
			'non-starred' => '☆',
			'notice' => 'ℹ️',	//ⓘ
			'opml-dyn' => '🗲',
			'prev' => '⏪',
			'read' => '☑️',	//☑
			'rss' => '📣',	//☄
			'unread' => '🔲',	//☐
			'refresh' => '🔃',	//↻
			'search' => '🔍',
			'share' => '♻️',	//♺
			'sort-down' => '⬇️',	//↓
			'sort-up' => '⬆️',	//↑
			'starred' => '⭐',	//★
			'stats' => '📈',	//%
			'tag' => '🔖',	//⚐
			'up' => '🔼',	//△
			'view-normal' => '📰',	//☰
			'view-global' => '📖',	//☷
			'view-reader' => '📜',
			'warning' => '⚠️',	//△
		);
		return isset($name) ? $alts[$name] : '';
	}

	// TODO: Change for enum in PHP 8.1+
	const ICON_DEFAULT = 0;
	const ICON_IMG = 1;
	const ICON_URL = 2;
	const ICON_EMOJI = 3;

	public static function icon(string $name, int $type = self::ICON_DEFAULT): string {
		$alt = self::alt($name);
		if ($alt == '') {
			return '';
		}

		$url = $name . '.svg';
		$url = isset(self::$themeIcons[$url]) ? (self::$themeIconsUrl . $url) : (self::$defaultIconsUrl . $url);

		$title = self::title($name);
		if ($title != '') {
			$title = ' title="' . _t($title) . '"';
		}

		if ($type == self::ICON_DEFAULT) {
			if ((FreshRSS_Context::$user_conf && FreshRSS_Context::$user_conf->icons_as_emojis) ||
				// default to emoji alternate for some icons
				in_array($name, [ 'opml-dyn' ])) {
				$type = self::ICON_EMOJI;
			} else {
				$type = self::ICON_IMG;
			}
		}

		switch ($type) {
			case self::ICON_URL:
				return Minz_Url::display($url);
			case self::ICON_IMG:
				return '<img class="icon" src="' . Minz_Url::display($url) . '" loading="lazy" alt="' . $alt . '"' . $title . ' />';
			case self::ICON_EMOJI:
			default:
				return '<span class="icon"' . $title . '>' . $alt . '</span>';
		}
	}
}

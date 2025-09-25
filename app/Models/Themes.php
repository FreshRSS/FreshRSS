<?php
declare(strict_types=1);

class FreshRSS_Themes extends Minz_Model {

	private static string $themesUrl = '/themes/';
	private static string $defaultIconsUrl = '/themes/icons/';
	public static string $defaultTheme = 'Origine';

	/** @return list<string> */
	public static function getList(): array {
		return array_values(array_diff(
			scandir(PUBLIC_PATH . self::$themesUrl) ?: [],
			['..', '.']
		));
	}

	public static function exists(string $theme_id): bool {
		$theme_dir = PUBLIC_PATH . self::$themesUrl . $theme_id;
		return str_replace(['..', '/', DIRECTORY_SEPARATOR], '', $theme_id) === $theme_id
			&& file_exists($theme_dir . '/metadata.json');
	}

	/** @return array<string,array{id:string,name:string,author:string,description:string,version:float|string,files:array<string>,theme-color?:string|array{dark?:string,light?:string,default?:string}}> */
	public static function get(): array {
		$themes_list = self::getList();
		$list = [];
		foreach ($themes_list as $theme_dir) {
			$theme_id = rawurlencode($theme_dir);
			$theme = self::get_infos($theme_id);
			if (is_array($theme) && trim($theme['name']) !== '') {
				$list[$theme_id] = $theme;
			}
		}
		return $list;
	}

	/**
	 * @param string $theme_id is the rawurlencode'd theme directory name
	 * @return false|array{id:string,name:string,author:string,description:string,version:float|string,files:array<string>,theme-color?:string|array{dark?:string,light?:string,default?:string}}
	 */
	public static function get_infos(string $theme_id): array|false {
		$theme_dir = PUBLIC_PATH . self::$themesUrl . rawurldecode($theme_id);
		if (is_dir($theme_dir)) {
			$json_filename = $theme_dir . '/metadata.json';
			if (file_exists($json_filename)) {
				$content = file_get_contents($json_filename) ?: '';
				$res = json_decode($content, true);
				if (is_array($res)) {
					$result = [
						'id' => $theme_id,
						'name' => is_string($res['name'] ?? null) ? $res['name'] : '',
						'author' => is_string($res['author'] ?? null) ? $res['author'] : '',
						'description' => is_string($res['description'] ?? null) ? $res['description'] : '',
						'version' => is_string($res['version'] ?? null) || is_numeric($res['version'] ?? null) ? $res['version'] : '0',
						'files' => is_array($res['files']) && is_array_values_string($res['files']) ? array_values($res['files']) : [],
						'theme-color' => is_string($res['theme-color'] ?? null) ? $res['theme-color'] : '',
					];
					if (empty($result['theme-color']) && is_array($res['theme-color'])) {
						$result['theme-color'] = [
							'dark' => is_string($res['theme-color']['dark'] ?? null) ? $res['theme-color']['dark'] : '',
							'light' => is_string($res['theme-color']['light'] ?? null) ? $res['theme-color']['light'] : '',
							'default' => is_string($res['theme-color']['default'] ?? null) ? $res['theme-color']['default'] : '',
						];
					}
					$result = Minz_Helper::htmlspecialchars_utf8($result);
					return $result;
				}
			}
		}
		return false;
	}

	private static string $themeIconsUrl;
	/** @var array<string,int> */
	private static array $themeIcons;

	/**
	 * @return false|array{id:string,name:string,author:string,description:string,version:float|string,files:array<string>,theme-color?:string|array{dark?:string,light?:string,default?:string}}
	 */
	public static function load(string $theme_id): array|false {
		$infos = self::get_infos($theme_id);
		if (empty($infos)) {
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
			scandir(PUBLIC_PATH . self::$themeIconsUrl) ?: [],
			['..', '.']
		), 1) : [];
		return $infos;
	}

	public static function title(string $name): string {
		$titles = [
			'opml-dyn' => 'sub.category.dynamic_opml',
		];
		return $titles[$name] ?? '';
	}

	public static function alt(string $name): string {
		$alts = [
			'add' => '➕',	//✚
			'all' => '☰',
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
			'important' => '📌',
			'key' => '🔑',	//⚿
			'label' => '🏷️',
			'link' => '↗️',	//↗
			'look' => '👀',	//👁
			'login' => '🔒',
			'logout' => '🔓',
			'next' => '⏩',
			'non-starred' => '☆',
			'notice' => 'ℹ️',	//ⓘ
			'opml-dyn' => '⚡',
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
		];
		return $alts[$name] ?? '';
	}

	// TODO: Change for enum in PHP 8.1+
	public const ICON_DEFAULT = 0;
	public const ICON_IMG = 1;
	public const ICON_URL = 2;
	public const ICON_EMOJI = 3;

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
			if ((FreshRSS_Context::hasUserConf() && FreshRSS_Context::userConf()->icons_as_emojis)
				// default to emoji alternate for some icons
			) {
				$type = self::ICON_EMOJI;
			} else {
				$type = self::ICON_IMG;
			}
		}

		return match ($type) {
			self::ICON_URL => Minz_Url::display($url),
			self::ICON_IMG => '<img class="icon" src="' . Minz_Url::display($url) . '" loading="lazy" alt="' . $alt . '"' . $title . ' />',
			self::ICON_EMOJI, =>  '<span class="icon"' . $title . '>' . $alt . '</span>',
			default => '<span class="icon"' . $title . '>' . $alt . '</span>',
		};
	}
}

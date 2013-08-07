<?php

class RSSThemes extends Model {
	private static $themes_dir = '/themes';

	private static $list = array();

	public static function init() {
		$basedir = PUBLIC_PATH . self::$themes_dir;

		$themes_list = array_diff(
			scandir($basedir),
			array('..', '.')
		);

		foreach ($themes_list as $theme_dir) {
			$json_filename = $basedir . '/' . $theme_dir . '/metadata.json';
			if(file_exists($json_filename)) {
				$content = file_get_contents($json_filename);
				$res = json_decode($content, true);

				if($res &&
					isset($res['name']) &&
					isset($res['author']) &&
					isset($res['description']) &&
					isset($res['version'])) {
					$theme = $res;
					$theme['path'] = $theme_dir;
					self::$list[] = $theme;
				}
			}
		}
	}

	public static function get() {
		return self::$list;
	}
}
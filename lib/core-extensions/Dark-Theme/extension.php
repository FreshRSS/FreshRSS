<?php

class DarkThemeExtension extends Minz_ThemeExtension {
	protected $icons = [
		'icon',
	];

	protected function getCssFiles() {
		return [
			'_template.css',
			'dark.css',
		];
	}
}

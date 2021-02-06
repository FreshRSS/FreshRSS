<?php

class AlternativeDarkThemeExtension extends Minz_ThemeExtension {
	protected $icons = [
		'icon',
	];

	protected function getCssFiles() {
		return [
			'_template.css',
			'adark.css',
		];
	}
}

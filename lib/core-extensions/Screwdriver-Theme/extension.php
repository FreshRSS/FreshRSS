<?php

class ScrewdriverThemeExtension extends Minz_ThemeExtension {
	protected $icons = [
		'bookmark',
		'favicon',
		'icon',
		'read',
		'starred',
		'unread',
	];

	protected function getCssFiles() {
		return [
			'_template.css',
			'screwdriver.css',
		];
	}
}

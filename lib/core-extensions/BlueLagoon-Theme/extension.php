<?php

class BlueLagoonThemeExtension extends Minz_ThemeExtension {
	protected $icons = [
		'bookmark',
		'favicon',
		'icon',
		'non-starred',
		'read',
		'starred',
		'unread',
	];

	protected function getCssFiles() {
		return [
			'_template.css',
			'BlueLagoon.css',
		];
	}
}

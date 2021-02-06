<?php

class FlatThemeExtension extends Minz_ThemeExtension {
	protected $icons = [
		'add',
		'all',
		'category',
		'close',
		'configure',
		'down',
		'icon',
		'key',
		'next',
		'prev',
		'refresh',
		'rss',
		'search',
		'up',
		'view-global',
		'view-normal',
		'view-reader',
	];

	protected function getCssFiles() {
		return [
			'_template.css',
			'flat.css',
		];
	}
}

<?php

class SwageThemeExtension extends Minz_ThemeExtension {
	protected $icons = [
		'add',
		'all',
		'bookmark-add',
		'bookmark',
		'category',
		'configure',
		'down',
		'error',
		'icon',
		'import',
		'next',
		'non-starred',
		'prev',
		'read',
		'refresh',
		'rss',
		'starred',
		'unread',
		'up',
		'view-global',
		'view-normal',
		'view-reader',
	];

	protected function getCssFiles() {
		return [
			'_template.css',
			'swage.css',
		];
	}
}

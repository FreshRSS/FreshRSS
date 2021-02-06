<?php

class MapcoThemeExtension extends Minz_ThemeExtension {
	protected $icons = [
		'cog',
		'cog-white',
		'down',
		'down-white',
		'icon',
		'link',
		'link-white',
		'magnifier',
		'more',
		'non-starred',
		'non-starred-white',
		'read-grey',
		'read',
		'read-white',
		'refresh',
		'rss',
		'rss-white',
		'starred',
		'starred-white',
		'tick-color',
		'tick',
		'tick-white',
		'unread-grey',
		'unread',
		'unread-white',
		'up',
		'up-white',
		'view-global',
		'view-global-white',
		'view-list',
		'view-list-white',
		'view-reader',
		'view-reader-white',
	];

	protected function getCssFiles() {
		return [
			'_template.css',
			'mapco.css',
		];
	}
}

<?php

class PafatThemeExtension extends Minz_ThemeExtension {
	protected $icons = [
		'all',
		'bookmark',
		'down',
		'icon',
		'link',
		'login',
		'logout',
		'next',
		'non-starred',
		'prev',
		'read',
		'share',
		'starred',
		'tag',
		'unread',
		'up',
	];

	protected function getCssFiles() {
		return [
			'_template.css',
			'pafat.css',
		];
	}
}

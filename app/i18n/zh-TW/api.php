<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

return array(
	'information' => array(
		'address' => '您的 API 位址:',
		'output' => array(
			'encoding-support' => '⚠️ 警告: 無 <code>%2F</code> 支援，有些用戶端可能不起作用！',
			'invalid-configuration' => '⚠️ 警告: ./data/config.php 可能含有無效的基礎 URL',
			'pass' => '✔️ 通過',
			'unknown-error' => '❌ 未知錯誤',
		),
		'test' => array(
			'fever' => 'Fever API 配置測試:',
			'greader' => 'Google Reader API 配置測試:',
		),
		'title' => array(
			'_' => 'FreshRSS API 端點',
			'extension' => '擴充功能 API',
			'fever' => 'Fever 相容 API',
			'greader' => 'Google Reader 相容 API',
		),
	),
);

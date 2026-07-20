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
		'address' => '你的 API 地址：',
		'output' => array(
			'encoding-support' => '⚠️ 警告：<code>%2F</code> 支持缺失，部分客户端可能无法正常工作!',
			'invalid-configuration' => '⚠️ 警告：./data/config.php 中可能存在无效的 base URL',	// DIRTY
			'pass' => '✔️ 通过',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Fever API 配置测试：',
			'greader' => 'Google Reader API 配置测试',
		),
		'title' => array(
			'_' => 'FreshRSS API 端点',	// DIRTY
			'extension' => '供拓展使用的 API',
			'fever' => 'Fever 兼容的 API',
			'greader' => 'Google Reader 兼容的 API',
		),
	),
);

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
		'address' => 'APIアドレス：',
		'output' => array(
			'encoding-support' => '⚠️ 警告：<code>%2F</code>に対応していないため、一部のクライアントが動作しない可能性があります',
			'invalid-configuration' => '⚠️ 警告：<code>./data/config.php</code>内のベースURLが無効な可能性があります。',
			'pass' => '✔️ 成功',
			'unknown-error' => '❌ エラー：',
		),
		'test' => array(
			'fever' => 'Fever API設定テスト：',
			'greader' => 'Google Reader API設定テスト：',
		),
		'title' => array(
			'_' => 'FreshRSS APIエンドポイント',
			'extension' => '拡張機能向けAPI',
			'fever' => 'Fever互換API',
			'greader' => 'Google Reader互換API',
		),
	),
);

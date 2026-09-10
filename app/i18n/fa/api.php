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
		'address' => 'نشانی API شما:',
		'output' => array(
			'encoding-support' => '⚠️ هشدار: پشتیبانی از <code>%2F</code> وجود ندارد؛ ممکن است برخی کلاینت‌ها کار نکنند!',
			'invalid-configuration' => '⚠️ هشدار: احتمالاً نشانی پایه در ./data/config.php نامعتبر است',
			'pass' => '✔️ قبول',
			'unknown-error' => '❌ خطای ناشناخته',
		),
		'test' => array(
			'fever' => 'آزمون پیکربندی API سازگار با Fever:',
			'greader' => 'آزمون پیکربندی API سازگار با Google Reader:',
		),
		'title' => array(
			'_' => 'نقاط پایانی API در FreshRSS',
			'extension' => 'API برای افزونه‌ها',
			'fever' => 'API سازگار با Fever',
			'greader' => 'API سازگار با Google Reader',
		),
	),
);

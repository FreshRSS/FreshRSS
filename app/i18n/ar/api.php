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
		'address' => 'عنوان API الخاص بك:',
		'output' => array(
			'encoding-support' => '⚠️ تحذير: لا يوجد دعم لـ <code>%2F</code>، قد لا تعمل بعض العملاء!',
			'invalid-configuration' => '⚠️ تحذير: من المحتمل أن يكون عنوان URL الأساسي غير صالح في ./data/config.php',
			'pass' => '✔️ ناجح',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'اختبار إعدادات Fever API:',
			'greader' => 'اختبار إعدادات Google Reader API:',
		),
		'title' => array(
			'_' => 'نقاط نهاية FreshRSS API',
			'extension' => 'API للإضافات',
			'fever' => 'API المتوافق مع Fever',
			'greader' => 'API المتوافق مع Google Reader',
		),
	),
);

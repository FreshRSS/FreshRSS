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
		'address' => 'API ünvanınız:',
		'output' => array(
			'encoding-support' => '⚠️ XƏBƏRDARLIQ: <code>%2F</code> dəstəyi yoxdur, bəzi klientlər işləməyə bilər!',
			'invalid-configuration' => '⚠️ XƏBƏRDARLIQ: ./data/config.php içində ehtimal olunan yanlış baza URL-i',
			'pass' => '✔️ KEÇDİ',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Fever API konfiqurasiya testi:',
			'greader' => 'Google Reader API konfiqurasiya testi:',
		),
		'title' => array(
			'_' => 'FreshRSS API son nöqtələri',
			'extension' => 'Genişlənmələr üçün API',
			'fever' => 'Fever ilə uyğun API',
			'greader' => 'Google Reader ilə uyğun API',
		),
	),
);

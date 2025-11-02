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
		'address' => 'Адреса вашого API:',
		'output' => array(
			'encoding-support' => '⚠️ УВАГА: бракує підтримки <code>%2F</code>, деякі клієнти можуть не працювати!',
			'invalid-configuration' => '⚠️ УВАГА: ймовірно хибна базова URL-адреса в ./data/config.php',
			'pass' => '✔️ УСПІХ',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Перевірка налаштування Fever API:',
			'greader' => 'Перевірка налаштування Google Reader API:',
		),
		'title' => array(
			'_' => 'Ендпойнти API FreshRSS',
			'extension' => 'API для розширень',
			'fever' => 'API, сумісне з Fever',
			'greader' => 'API, сумісне з Google Reader',
		),
	),
);

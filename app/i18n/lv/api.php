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
		'address' => 'Jūsu API adrese:',
		'output' => array(
			'encoding-support' => '⚠️ BRĪDINĀJUMS: nav <code>%2F</code> atbalsta, daži klienti var nedarboties!',
			'invalid-configuration' => '⚠️ BRĪDINĀJUMS: iespējams, nederīgs bāzes URL failā ./data/config.php',
			'pass' => '✔️ IZDEVĀS',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Fever API konfigurācijas tests:',
			'greader' => 'Google Reader API konfigurācijas tests:',
		),
		'title' => array(
			'_' => 'FreshRSS API galapunkti',
			'extension' => 'API paplašinājumiem',
			'fever' => 'Ar Fever saderīga API',
			'greader' => 'Ar Google Reader saderīga API',
		),
	),
);

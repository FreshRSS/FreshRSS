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
		'address' => 'Η διεύθυνση του API σας:',
		'output' => array(
			'encoding-support' => '⚠️ ΠΡΟΕΙΔΟΠΟΙΗΣΗ: δεν υπάρχει υποστήριξη για <code>%2F</code>, ορισμένοι πελάτες μπορεί να μην λειτουργούν!',
			'invalid-configuration' => '⚠️ ΠΡΟΕΙΔΟΠΟΙΗΣΗ: Πιθανώς μη έγκυρο βασικό URL στο ./data/config.php',
			'pass' => '✔️ OK',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Δοκιμή διαμόρφωσης Fever API:',
			'greader' => 'Δοκιμή διαμόρφωσης Google Reader API:',
		),
		'title' => array(
			'_' => 'Τερματικά σημεία FreshRSS API',
			'extension' => 'API για επεκτάσεις',
			'fever' => 'Συμβατό API με Fever',
			'greader' => 'Συμβατό API με Google Reader',
		),
	),
);

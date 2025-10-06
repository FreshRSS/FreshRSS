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
		'address' => 'API-osoitteesi:',	// DIRTY
		'output' => array(
			'encoding-support' => '⚠️ VAROITUS: <code>%2F</code>-tukea ei ole. Jotkin sovellukset eivät ehkä toimi.',	// DIRTY
			'invalid-configuration' => '⚠️ VAROITUS: Virheellinen URL-pääosoite määritetty tiedostossa ./data/config.php',	// DIRTY
			'pass' => '✔️ EI VIRHEITÄ',	// DIRTY
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Fever API:n määritystesti:',	// DIRTY
			'greader' => 'Google Reader API:n määritystesti:',	// DIRTY
		),
		'title' => array(
			'_' => 'FreshRSS API -päätepisteet',	// DIRTY
			'extension' => 'Laajennusten API',	// DIRTY
			'fever' => 'Fever-yhteensopiva API',	// DIRTY
			'greader' => 'Google Reader -yhteensopiva API',	// DIRTY
		),
	),
);

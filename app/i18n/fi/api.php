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
		'address' => 'API-osoitteesi:',	// TODO
		'output' => array(
			'encoding-support' => '⚠️ VAROITUS: <code>%2F</code>-tukea ei ole. Jotkin sovellukset eivät ehkä toimi.',	// TODO
			'invalid-configuration' => '⚠️ VAROITUS: Virheellinen URL-pääosoite määritetty tiedostossa ./data/config.php',	// TODO
			'pass' => '✔️ EI VIRHEITÄ',	// TODO
			'unknown-error' => '❌ ',	// TODO
		),
		'test' => array(
			'fever' => 'Fever API:n määritystesti:',	// TODO
			'greader' => 'Google Reader API:n määritystesti:',	// TODO
		),
		'title' => array(
			'_' => 'FreshRSS API -päätepisteet',	// TODO
			'extension' => 'Laajennusten API',	// TODO
			'fever' => 'Fever-yhteensopiva API',	// TODO
			'greader' => 'Google Reader -yhteensopiva API',	// TODO
		),
	),
);

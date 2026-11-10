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
		'address' => 'Uw API-adres:',
		'output' => array(
			'encoding-support' => '⚠️ WAARSCHUWING: geen ondersteuning voor <code>%2F</code>, sommige clients werken mogelijk niet!',
			'invalid-configuration' => '⚠️ WAARSCHUWING: Waarschijnlijk ongeldige basis-URL in ./data/config.php',
			'pass' => '✔️ OK',
			'unknown-error' => '❌ Onbekende fout',
		),
		'test' => array(
			'fever' => 'Fever-API configuratietest:',
			'greader' => 'Google Reader-API configuratietest:',
		),
		'title' => array(
			'_' => 'FreshRSS API-eindpunten',
			'extension' => 'API voor extensies',
			'fever' => 'Fever-compatibele API',
			'greader' => 'Google Reader-compatibele API',
		),
	),
);

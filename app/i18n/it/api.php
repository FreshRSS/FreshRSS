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
		'address' => 'Il tuo indirizzo per le API:',
		'output' => array(
			'encoding-support' => '⚠️ ATTENZIONE: nessun supporto per <code>%2F</code>, alcuni client potrebbero non funzionare!',
			'invalid-configuration' => '⚠️ ATTENZIONE: Probabile invalida configurazione "base URL" in ./data/config.php',
			'pass' => '✔️ SUPERATO',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Test di configurazione per Fever API:',
			'greader' => 'Test di configurazione per Google Reader API',
		),
		'title' => array(
			'_' => 'FreshRSS API endpoints',	// IGNORE
			'extension' => 'API per le estensioni',
			'fever' => 'API compatibile con Fever',
			'greader' => 'API compatibile con Google Reader',
		),
	),
);

<?php

/******************************************************************************/
/* Each entry of that file can be associated with a comment to indicate its   */
/* state. When there is no comment, it means the entry is fully translated.   */
/* The recognized comments are (comment matching is case-insensitive):        */
/*   + TODO: the entry has never been translated.                             */
/*   + DIRTY: the entry has been translated but needs to be updated.          */
/*   + IGNORE: the entry does not need to be translated.                      */
/* When a comment is not recognized, it is discarded.                         */
/******************************************************************************/

return array(
	'information' => array(
		'address' => 'API-Adresse:',
		'output' => array(
			'encoding-support' => '⚠️ WARNUNG: Kein <code>%2F</code> support, Einige Clients/Apps funktionieren ggf. nicht!',
			'invalid-configuration' => '⚠️ WARNUNG: Die Base URL in ./data/config.php könnte ungültig sein',
			'pass' => '✔️ OK',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Prüfung der Fever API Einstellungen:',
			'greader' => 'Prüfung der Google Reader API Einstellungen:',
		),
		'title' => array(
			'_' => 'FreshRSS API-Endpoints',
			'extension' => 'API für Erweiterungen',
			'fever' => 'Fever kompatible API',
			'greader' => 'Google Reader kompatible API',
		),
	),
);

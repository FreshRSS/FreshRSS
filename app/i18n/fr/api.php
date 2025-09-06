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
		'address' => 'Adresse de votre API :',
		'output' => array(
			'encoding-support' => '⚠️ WARN: no <code>%2F</code> support, some clients might not work!',	// TODO
			'invalid-configuration' => '⚠️ WARN: Probable invalid base URL in ./data/config.php',	// TODO
			'pass' => '✔️ PASS',	// TODO
			'unknown-error' => '❌ ',	// TODO
		),
		'test' => array(
			'fever' => 'Test de configuration de l’API Fever :',
			'greader' => 'Test de configuration de l’API Google Reader :',
		),
		'title' => array(
			'_' => 'API de FreshRSS',
			'extension' => 'API des extensions',
			'fever' => 'API compatible avec l’API Fever',
			'greader' => 'API compatible avec l’API Google Reader',
		),
	),
);

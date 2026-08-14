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
		'address' => 'Jūsų API adresas:',
		'output' => array(
			'encoding-support' => '⚠️ ĮSPĖJIMAS: nėra <code>%2F</code> palaikymo, kai kurios programos gali neveikti!',
			'invalid-configuration' => '⚠️ ĮSPĖJIMAS: tikėtina neteisinga bazinė nuoroda (base URL) faile ./data/config.php',
			'pass' => '✔️ GERAI',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Fever API konfigūracijos patikra:',
			'greader' => 'Google Reader API konfigūracijos patikra:',
		),
		'title' => array(
			'_' => 'FreshRSS API prieigos taškai',
			'extension' => 'API plėtiniams',
			'fever' => 'Su Fever suderinama API',
			'greader' => 'Su Google Reader suderinama API',
		),
	),
);

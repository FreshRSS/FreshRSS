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
		'address' => 'Twój adres API:',
		'output' => array(
			'encoding-support' => '⚠️ UWAGA: brak wsparcia dla <code>%2F</code>, niektóre aplikacje mogą nie działać!',
			'invalid-configuration' => '⚠️ UWAGA: Prawdopodobnie nieprawidłowy bazowy URL w ./data/config.php',
			'pass' => '✔️ OK',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Test konfiguracji Fever API:',
			'greader' => 'Test konfiguracji Google Reader API:',
		),
		'title' => array(
			'_' => 'Endpointy API FreshRSS',
			'extension' => 'API dla rozszerzeń',
			'fever' => 'API kompatybilne z Fever',
			'greader' => 'API kompatybilne z Google Reader',
		),
	),
);

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
		'address' => 'Az API címed:',
		'output' => array(
			'encoding-support' => '⚠️ FIGYELMEZTETÉS: nincs <code>%2F</code> támogatás, néhány kliens lehet hogy nem fog működni!',
			'invalid-configuration' => '⚠️ FIGYELMEZTETÉS: Az alap URL a <kbd>./data/config.php</kbd> fájlban lehet hogy hibásan van beállítva',
			'pass' => '✔️ OK',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Fever API konfiguráció teszt:',
			'greader' => 'Google Reader API konfiguráció teszt:',
		),
		'title' => array(
			'_' => 'FreshRSS API végpontok',
			'extension' => 'API a bővítményekhez',
			'fever' => 'Fever kompatibilis API',
			'greader' => 'Google Reader kompatibilis API',
		),
	),
);

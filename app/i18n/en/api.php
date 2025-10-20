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
		'address' => 'Your API address:',
		'output' => array(
			'encoding-support' => '⚠️ WARN: no <code>%2F</code> support, some clients might not work!',	// TODO
			'invalid-configuration' => '⚠️ WARN: Probable invalid base URL in ./data/config.php',	// TODO
			'pass' => '✔️ PASS',	// TODO
			'unknown-error' => '❌ ',	// TODO
		),
		'test' => array(
			'fever' => 'Fever API configuration test:',
			'greader' => 'Google Reader API configuration test:',
		),
		'title' => array(
			'_' => 'FreshRSS API endpoints',
			'extension' => 'API for extensions',
			'fever' => 'Fever compatible API',
			'greader' => 'Google Reader compatible API',
		),
	),
);

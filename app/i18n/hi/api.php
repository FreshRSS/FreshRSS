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
		'address' => 'आपका API पता:',
		'output' => array(
			'encoding-support' => '⚠️ चेतावनी: <code>%2F</code> सपोर्ट नहीं है, कुछ क्लाइंट शायद काम न करें!',
			'invalid-configuration' => '⚠️ चेतावनी: ./data/config.php में बेस URL शायद अमान्य है',
			'pass' => '✔️ सफल',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Fever API कॉन्फ़िगरेशन टेस्ट:',
			'greader' => 'Google Reader API कॉन्फ़िगरेशन टेस्ट:',
		),
		'title' => array(
			'_' => 'FreshRSS API एंडपॉइंट',
			'extension' => 'एक्सटेंशन के लिए API',
			'fever' => 'Fever-संगत API',
			'greader' => 'Google Reader-संगत API',
		),
	),
);

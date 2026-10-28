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
		'address' => 'Alamat API Anda:',
		'output' => array(
			'encoding-support' => '⚠️ PERINGATAN: tidak ada dukungan <code>%2F</code>, beberapa klien mungkin tidak berfungsi!',
			'invalid-configuration' => '⚠️ PERINGATAN: Kemungkinan URL dasar tidak valid di ./data/config.php',
			'pass' => '✔️ BERHASIL',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Uji konfigurasi API Fever:',
			'greader' => 'Uji konfigurasi API Google Reader:',
		),
		'title' => array(
			'_' => 'Endpoint API FreshRSS',
			'extension' => 'API untuk ekstensi',
			'fever' => 'API kompatibel Fever',
			'greader' => 'API kompatibel Google Reader',
		),
	),
);

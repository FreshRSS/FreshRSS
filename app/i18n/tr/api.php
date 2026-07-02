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
		'address' => 'API adresiniz:',	
		'output' => array(
			'encoding-support' => '⚠️ DİKKAT: <code>%2F</code> desteği yoktur, bazı istemciler çalışmayabilir!',
			'invalid-configuration' => '⚠️ DİKKAT: Olası geçersiz temel URL ./data/config.php',	
			'pass' => '✔️ BAŞARILI',	
			'unknown-error' => '❌ Bilinmeyen hata ',
		),
		'test' => array(
			'fever' => 'Fever API konfigürasyon testi:',	
			'greader' => 'Google Reader API konfigürasyon testi:',	
		),
		'title' => array(
			'_' => 'FreshRSS API uç noktaları',	
			'extension' => 'Uzantılar için API',	
			'fever' => 'Fever ile uyumlu API',	
			'greader' => 'Google Reader ile uyumlu API',	
		),
	),
);

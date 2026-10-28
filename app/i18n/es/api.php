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
		'address' => 'Tu dirección de la API:',
		'output' => array(
			'encoding-support' => '⚠️ ADVERTENCIA: no hay soporte para <code>%2F</code>, ¡algunos clientes podrían no funcionar!',
			'invalid-configuration' => '⚠️ ADVERTENCIA: La URL base en ./data/config.php es probablemente incorrecta.',
			'pass' => '✔️ APROBADO',
			'unknown-error' => '❌',
		),
		'test' => array(
			'fever' => 'Prueba de configuración de la API Fever:',
			'greader' => 'Prueba de configuración de la API Google Reader:',
		),
		'title' => array(
			'_' => 'API FreshRSS',
			'extension' => 'API para extensiones',
			'fever' => 'API compatible con Fever',
			'greader' => 'API compatible con Google Reader',
		),
	),
);

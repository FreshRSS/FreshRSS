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
		'address' => 'Адрас API:',
		'output' => array(
			'encoding-support' => '⚠️ УВАГА: няма падтрымкі <code>%2F</code>, некаторыя кліенты могуць не працаваць!',
			'invalid-configuration' => '⚠️ УВАГА: верагодна, няправільны базавы URL-адрас у ./data/config.php',
			'pass' => '✔️ ПРАЙШОЎ',
			'unknown-error' => '❌',
		),
		'test' => array(
			'fever' => 'Праверка канфігурацыі Fever API:',
			'greader' => 'Праверка канфігурацыі Google Reader API:',
		),
		'title' => array(
			'_' => 'Кропкі доступу FreshRSS API',
			'extension' => 'API для пашырэнняў',
			'fever' => 'API, сумяшчальны з Fever',
			'greader' => 'API, сумяшчальны з Google Reader',
		),
	),
);

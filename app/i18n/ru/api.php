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
		'address' => 'Ваш адрес API:',
		'output' => array(
			'encoding-support' => '⚠️ ПРЕДУПРЕЖДЕНИЕ: нет поддержки <code>%2F</code>, некоторые клиенты могут не работать!',
			'invalid-configuration' => '⚠️ ПРЕДУПРЕЖДЕНИЕ: Вероятно, неверный базовый URL в ./data/config.php',
			'pass' => '✔️ УСПЕШНО',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Тест конфигурации API Fever:',
			'greader' => 'Тест конфигурации API Google Reader:',
		),
		'title' => array(
			'_' => 'API-точки FreshRSS',
			'extension' => 'API для расширений',
			'fever' => 'API, совместимый с Fever',
			'greader' => 'API, совместимый с Google Reader',
		),
	),
);

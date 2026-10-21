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
		'address' => 'O seu endereço de API:',
		'output' => array(
			'encoding-support' => '⚠️ AVISO: sem suporte para <code>%2F</code>, alguns clientes poderão não funcionar!',
			'invalid-configuration' => '⚠️ AVISO: URL base provavelmente inválido em ./data/config.php',
			'pass' => '✔️ SUCESSO',
			'unknown-error' => '❌ ',
		),
		'test' => array(
			'fever' => 'Teste de configuração da API Fever:',
			'greader' => 'Teste de configuração da API Google Reader:',
		),
		'title' => array(
			'_' => 'Pontos de acesso da API do FreshRSS',
			'extension' => 'API para extensões',
			'fever' => 'API compatível com Fever',
			'greader' => 'API compatível com Google Reader',
		),
	),
);

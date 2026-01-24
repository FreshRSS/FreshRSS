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
		'address' => 'Seu endereço de API:',
		'output' => array(
			'encoding-support' => '⚠️ WARN: Sem suporte para <code>%2F</code>, alguns clientes podem não funcionar!',
			'invalid-configuration' => '⚠️ WARN: URL base provavelmente inválida em ./data/config.php',
			'pass' => '✔️ Sucesso',
			'unknown-error' => '❌ ',	// IGNORE
		),
		'test' => array(
			'fever' => 'Teste de configuração da API Fever:',
			'greader' => 'Teste de configuração da API do Google Reader:',
		),
		'title' => array(
			'_' => 'Endpoints da API do FreshRSS',
			'extension' => 'API para extensões',
			'fever' => 'API compatível com Fever',
			'greader' => 'API compatível com Google Reader',
		),
	),
);

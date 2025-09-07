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
	'action' => array(
		'finish' => 'Instalação completa',
		'fix_errors_before' => 'Por favor resolva os erros antes de ir para o próximo passo.',
		'keep_install' => 'Mantenha as configurações anteriores',
		'next_step' => 'Vá para o próximo passo',
		'reinstall' => 'Reinstale o FreshRSS',
	),
	'bdd' => array(
		'_' => 'base de dados',
		'conf' => array(
			'_' => 'Configuração da base de dados',
			'ko' => 'Verifique as informações do seu base de dados.',
			'ok' => 'Configurações do base de dados foram salvas.',
		),
		'host' => 'Host',	// IGNORE
		'password' => 'Senha do base de dados',
		'prefix' => 'Prefixo da tabela',
		'type' => 'Tipo do base de dados',
		'username' => 'Utilizador do base de dados',
	),
	'check' => array(
		'_' => 'Verificações',
		'already_installed' => 'Verificamos que o FreshRSS já está instalado!',
		'cache' => array(
			'nok' => 'Verifique as permissões no diretório <em>%s</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório cache estão corretos.',
		),
		'ctype' => array(
			'nok' => 'Não foi possível encontrar uma biblioteca necessária para verificação do tipo de caractere (php-ctype).',
			'ok' => 'Tem a biblioteca necessária para verificação do tipo de caractere (ctype).',
		),
		'curl' => array(
			'nok' => 'Não foi possível encontrar a biblioteca cURL (php-curl).',
			'ok' => 'Tem a biblioteca cURL.',
		),
		'data' => array(
			'nok' => 'Verifique as permissões no diretório <em>%s</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório data estão corretos.',
		),
		'dom' => array(
			'nok' => 'Não foi possível encontrar uma biblioteca necessária para navegar pelo DOM (php-xml).',
			'ok' => 'Tem a biblioteca necessária para navegar pelo DOM.',
		),
		'favicons' => array(
			'nok' => 'Verifique as permissões no diretório <em>%s</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório favicons estão corretos.',
		),
		'fileinfo' => array(
			'nok' => 'Não foi possível encontrar a biblioteca fileinfo do PHP (fileinfo).',
			'ok' => 'Tem a biblioteca fileinfo.',
		),
		'json' => array(
			'nok' => 'Não foi possível encontrar JSON (php-json).',
			'ok' => 'Tem a extensão JSON.',
		),
		'mbstring' => array(
			'nok' => 'Não foi possível encontrar a biblioteca recomendada para o Unicode (mbstring).',
			'ok' => 'Tem a biblioteca recomendada para o Unicode (mbstring).',
		),
		'pcre' => array(
			'nok' => 'Não foi possível encontrar uma biblioteca necessário para expressões regulares (php-pcre).',
			'ok' => 'Tem a biblioteca necessária para expressões regulares (php-pcre).',
		),
		'pdo' => array(
			'nok' => 'Não foi encontrado o PDO ou um dos drivers suportados (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Tem o PDO e ao menos um dos drivers suportados (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'A versão do PHP é %s mas FreshRSS requer ao menos a versão %s.',
			'ok' => 'A versão do PHP é %s, que é compatível com o FreshRSS.',
		),
		'reload' => 'Verifique novamente',
		'tmp' => array(
			'nok' => 'Verifiquei as permissões no diretório <em>%s</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'As permissões para o diretório temporário estão certas.',
		),
		'unknown_process_username' => 'Desconhecido',
		'users' => array(
			'nok' => 'Verifiquei as permissões no diretório <em>%s</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório users estão corretos.',
		),
		'xml' => array(
			'nok' => 'Não foi possível encontrar a biblioteca necessária para parse o XML.',
			'ok' => 'Tem a biblioteca necessária para parse o XML.',
		),
	),
	'conf' => array(
		'_' => 'Configurações gerais',
		'ok' => 'Configurações gerais foram salvas.',
	),
	'congratulations' => 'Parabéns!',
	'default_user' => array(
		'_' => 'Utilizador padrão',
		'max_char' => 'máximo de 16 caracteres alfanuméricos',
	),
	'fix_errors_before' => 'Por favor solucione os erros antes de ir para o próximo passo.',
	'javascript_is_better' => 'O FreshRSS é mais agradável com o JavaScript ativo',
	'js' => array(
		'confirm_reinstall' => 'Vai perder suas configurações anteriores ao reinstalar o FreshRSS. Confirma que pretende continuar?',
	),
	'language' => array(
		'_' => 'Idioma',
		'choose' => 'Escolha o idioma para o FreshRSS',
		'defined' => 'O idioma foi definido.',
	),
	'missing_applied_migrations' => 'Algo de errado ocorreu; Tem que criar um arquivo vazio <em>%s</em> manualmente.',
	'ok' => 'O processo de instalação foi um sucesso.',
	'session' => array(
		'nok' => 'O servidor parece ter sido configurado incorretamente para os cookies necessários para sessões PHP!',
	),
	'step' => 'passo %d',
	'steps' => 'Passos',
	'this_is_the_end' => 'Este é o final',
	'title' => 'Instalação · FreshRSS',
);

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
	'action' => array(
		'finish' => 'Instalação concluída',
		'fix_errors_before' => 'Por favor, resolva os erros antes de avançar para o passo seguinte.',
		'keep_install' => 'Manter as configurações anteriores',
		'next_step' => 'Avançar para o passo seguinte',
		'reinstall' => 'Reinstalar o FreshRSS',
	),
	'bdd' => array(
		'_' => 'base de dados',
		'conf' => array(
			'_' => 'Configuração da base de dados',
			'ko' => 'Verifique as informações da sua base de dados.',
			'ok' => 'As configurações da base de dados foram guardadas.',
		),
		'host' => 'Host',	// IGNORE
		'password' => 'Palavra-passe da base de dados',
		'prefix' => 'Prefixo da tabela',
		'type' => 'Tipo de base de dados',
		'username' => 'Utilizador da base de dados',
	),
	'check' => array(
		'_' => 'Verificações',
		'already_installed' => 'Verificámos que o FreshRSS já está instalado!',
		'cache' => array(
			'nok' => 'Verifique as permissões no diretório <em>%s</em>. O servidor HTTP deve ter permissões de escrita nesta pasta.',
			'ok' => 'As permissões no diretório cache estão corretas.',
		),
		'ctype' => array(
			'nok' => 'Não foi possível encontrar a biblioteca necessária para verificação do tipo de caráter (php-ctype).',
			'ok' => 'Tem a biblioteca necessária para verificação do tipo de caráter (ctype).',
		),
		'curl' => array(
			'nok' => 'Não foi possível encontrar a biblioteca cURL (php-curl).',
			'ok' => 'Tem a biblioteca cURL.',
		),
		'data' => array(
			'nok' => 'Verifique as permissões no diretório <em>%s</em>. O servidor HTTP deve ter permissões de escrita nesta pasta.',
			'ok' => 'As permissões no diretório data estão corretas.',
		),
		'database-connection' => array(
			'nok' => 'Erro de ligação à base de dados.',
			'ok' => 'A ligação à base de dados está boa.',
		),
		'database-table' => array(
			'nok' => 'A tabela da base de dados "%s" está incompleta.',
			'ok' => 'A tabela da base de dados "%s" está boa.',
		),
		'database-tables' => array(
			'nok' => 'Faltam algumas tabelas na base de dados.',
			'ok' => 'Todas as tabelas da base de dados existem.',
		),
		'database-title' => 'Base de dados',
		'docroot' => array(
			'nok' => 'A raiz do documento do seu servidor web não parece apontar para a pasta <code>./p/</code>. Outras pastas, como <code>./data/</code>, poderão estar publicamente acessíveis.',
			'ok' => 'A raiz do documento do seu servidor web aponta corretamente para a pasta <code>./p/</code>.',
		),
		'dom' => array(
			'nok' => 'Não foi possível encontrar a biblioteca necessária para navegar pelo DOM (php-xml).',
			'ok' => 'Tem a biblioteca necessária para navegar pelo DOM.',
		),
		'favicons' => array(
			'nok' => 'Verifique as permissões no diretório <em>%s</em>. O servidor HTTP deve ter permissões de escrita nesta pasta.',
			'ok' => 'As permissões no diretório favicons estão corretas.',
		),
		'fileinfo' => array(
			'nok' => 'Não foi possível encontrar a biblioteca fileinfo do PHP (fileinfo).',
			'ok' => 'Tem a biblioteca fileinfo.',
		),
		'files' => 'Instalação de ficheiros',
		'gmp' => array(
			'nok' => 'Não é possível encontrar a extensão GMP necessária para PHP de 32 bits (pacote php-gmp).',
			'ok' => 'Tem a extensão GMP necessária para PHP de 32 bits.',
		),
		'intl' => array(
			'nok' => 'Não é possível encontrar a biblioteca recomendada php-intl para internacionalização.',
			'ok' => 'Tem a biblioteca recomendada php-intl para internacionalização.',
		),
		'json' => array(
			'nok' => 'Não foi possível encontrar JSON (php-json).',
			'ok' => 'Tem a extensão JSON.',
		),
		'mbstring' => array(
			'nok' => 'Não foi possível encontrar a biblioteca recomendada para Unicode (mbstring).',
			'ok' => 'Tem a biblioteca recomendada para Unicode (mbstring).',
		),
		'pcre' => array(
			'nok' => 'Não foi possível encontrar a biblioteca necessária para expressões regulares (php-pcre).',
			'ok' => 'Tem a biblioteca necessária para expressões regulares (php-pcre).',
		),
		'pdo-mysql' => array(
			'nok' => 'Não é possível encontrar o controlador PDO necessário para MySQL/MariaDB.',
		),
		'pdo-pgsql' => array(
			'nok' => 'Não é possível encontrar o controlador PDO necessário para PostgreSQL.',
		),
		'pdo-sqlite' => array(
			'nok' => 'Não é possível encontrar o controlador PDO para SQLite.',
			'ok' => 'Tem o controlador PDO para SQLite.',
		),
		'pdo' => array(
			'nok' => 'Não foi encontrado o PDO ou nenhum dos controladores suportados (pdo_sqlite, pdo_pgsql, pdo_mysql).',
			'ok' => 'Tem o PDO e pelo menos um dos controladores suportados (pdo_sqlite, pdo_pgsql, pdo_mysql).',
		),
		'php' => array(
			'_' => 'Instalação do PHP',
			'nok' => 'A versão do PHP é a %s, mas o FreshRSS requer pelo menos a versão %s.',
			'ok' => 'A versão do PHP é a %s, que é compatível com o FreshRSS.',
		),
		'reload' => 'Verificar novamente',
		'tmp' => array(
			'nok' => 'Verifique as permissões no diretório <em>%s</em>. O servidor HTTP deve ter permissões de escrita nesta pasta.',
			'ok' => 'As permissões para o diretório temporário estão corretas.',
		),
		'tokens' => array(
			'nok' => 'Verifique as permissões no diretório <em>./data/tokens</em>. O servidor HTTP deve ter permissões de escrita nesta pasta.',
			'ok' => 'As permissões no diretório tokens estão corretas.',
		),
		'unknown_process_username' => 'Desconhecido',
		'users' => array(
			'nok' => 'Verifique as permissões no diretório <em>%s</em>. O servidor HTTP deve ter permissões de escrita nesta pasta.',
			'ok' => 'As permissões no diretório users estão corretas.',
		),
		'xml' => array(
			'nok' => 'Não foi possível encontrar a biblioteca necessária para analisar XML.',
			'ok' => 'Tem a biblioteca necessária para analisar XML.',
		),
		'zip' => array(
			'nok' => 'Não foi possível localizar a extensão ZIP (php-zip).',
			'ok' => 'Tem a extensão ZIP.',
		),
	),
	'conf' => array(
		'_' => 'Configurações gerais',
		'ok' => 'As configurações gerais foram guardadas.',
	),
	'congratulations' => 'Parabéns!',
	'default_user' => array(
		'_' => 'Utilizador predefinido',
		'max_char' => '1-39 caracteres: letras, dígitos e <code>. _ @ -</code>',
	),
	'fix_errors_before' => 'Por favor, resolva os erros antes de avançar para o passo seguinte.',
	'javascript_is_better' => 'O FreshRSS é mais agradável com o JavaScript ativo',
	'js' => array(
		'confirm_reinstall' => 'Irá perder as suas configurações anteriores ao reinstalar o FreshRSS. Confirma que pretende continuar?',
	),
	'language' => array(
		'_' => 'Idioma',
		'choose' => 'Escolha o idioma para o FreshRSS',
		'defined' => 'O idioma foi definido.',
	),
	'missing_applied_migrations' => 'Algo correu mal; tem de criar um ficheiro vazio <em>%s</em> manualmente.',
	'ok' => 'O processo de instalação foi um sucesso.',
	'session' => array(
		'nok' => 'O servidor parece ter sido configurado incorretamente para os cookies necessários para as sessões PHP!',
	),
	'step' => 'passo %d',
	'steps' => 'Passos',
	'this_is_the_end' => 'Este é o fim',
	'title' => 'Instalação · FreshRSS',
);

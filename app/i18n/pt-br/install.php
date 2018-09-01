<?php

return array(
	'action' => array(
		'finish' => 'Instalação completa',
		'fix_errors_before' => 'Por favor resolva os erros antes de ir para o próximo passo.',
		'keep_install' => 'Mantenha as configurações anteriores',
		'next_step' => 'Vá para o próximo passo',
		'reinstall' => 'Reinstale o FreshRSS',
	),
	'auth' => array(
		'form' => 'Formulário web(tradicional, necessita JavaScript)',
		'http' => 'HTTP (Para usuários avançados com HTTPS)',
		'none' => 'None (perigoso)',
		'password_form' => 'Senha<br /><small>(Para o método do login pelo formulário)</small>',
		'password_format' => 'Ao menos 7 caracteres',
		'type' => 'Método de autenticação',
	),
	'bdd' => array(
		'_' => 'Banco de dados',
		'conf' => array(
			'_' => 'Configuração do banco de dados',
			'ko' => 'Verifique as informações do seu banco de dados.',
			'ok' => 'Configurações do banco de dados foram salvas.',
		),
		'host' => 'Host',
		'prefix' => 'Prefixo da tabela',
		'password' => 'Senha do banco de dados',
		'type' => 'Tipo do banco de dados',
		'username' => 'Usuário do banco de dados',
	),
	'check' => array(
		'_' => 'Verificações',
		'already_installed' => 'Verificamos que o FreshRSS já está instalado!',
		'cache' => array(
			'nok' => 'Verifique as permissões no diretório <em>./data/cache</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório cache estão corretos.',
		),
		'ctype' => array(
			'nok' => 'Não foi possível encontrar uma biblioteca necessária para verificação do tipo de caractere (php-ctype).',
			'ok' => 'Você tem a biblioteca necessária para verificação do tipo de caractere (ctype).',
		),
		'curl' => array(
			'nok' => 'Não foi possível encontrar a biblioteca cURL (php-curl).',
			'ok' => 'Você tem a biblioteca cURL.',
		),
		'data' => array(
			'nok' => 'Verifique as permissões no diretório <em>./data</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório data estão corretos.',
		),
		'dom' => array(
			'nok' => 'Não foi possível encontrar uma biblioteca necessária para navegar pelo DOM (php-xml).',
			'ok' => 'Você tem a biblioteca necessária para navegar pelo DOM.',
		),
		'favicons' => array(
			'nok' => 'Verifique as permissões no diretório <em>./data/favicons</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório favicons estão corretos.',
		),
		'fileinfo' => array(
			'nok' => 'Não foi possível encontrar a biblioteca fileinfo do PHP (fileinfo).',
			'ok' => 'Você tem a biblioteca fileinfo.',
		),
		'http_referer' => array(
			'nok' => 'Por favor verifique se você não está alterando seu HTTP REFERER.',
			'ok' => 'Seu HTTP REFERER é conhecido e corresponde ao seu servidor.',
		),
		'json' => array(
			'nok' => 'Não foi possível encontrar JSON (php-json).',
			'ok' => 'Você tem a extensão JSON.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	//TODO
			'ok' => 'You have the recommended library mbstring for Unicode.',	//TODO
		),
		'minz' => array(
			'nok' => 'Não foi possível encontrar o framework Minz.',
			'ok' => 'Você tem o framework Minz.',
		),
		'pcre' => array(
			'nok' => 'Não foi possível encontrar uma biblioteca necessário para expressões regulares (php-pcre).',
			'ok' => 'Você tem a biblioteca necessária para expressões regulares (php-pcre).',
		),
		'pdo' => array(
			'nok' => 'Não foi encontrado o PDO ou um dos drivers suportados (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Você tem o PDO e ao menos um dos drivers suportados (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'Sua versão do PHP é %s mas FreshRSS requer ao menos a versão %s.',
			'ok' => 'Sua versão do PHP é %s, que é compatível com o FreshRSS.',
		),
		'users' => array(
			'nok' => 'Verifiquei as permissões no diretório <em>./data/users</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório users estão corretos.',
		),
		'xml' => array(
			'nok' => 'Não foi possível encontrar a biblioteca necessária para parse o XML.',
			'ok' => 'Você tem a biblioteca necessária para parse o XML.',
		),
	),
	'conf' => array(
		'_' => 'Configurações gerais',
		'ok' => 'Configurações gerais foram salvas.',
	),
	'congratulations' => 'Parabéns!',
	'default_user' => 'Usuário do usuário padrão <small>(máximo de 16 caracteres alphanumericos)</small>',
	'delete_articles_after' => 'Remover artigos depois',
	'fix_errors_before' => 'Por favor solucione os erros antes de ir para o próximo passo.',
	'javascript_is_better' => 'FreshRSS é mais agradável com o JavaScript ativo',
	'js' => array(
		'confirm_reinstall' => 'Você irá perder suas configurações anteriores ao reinstalar o FreshRSS. Você está certo que deseja continuar?',
	),
	'language' => array(
		'_' => 'Idioma',
		'choose' => 'Escolhar o idioma para o FreshRSS',
		'defined' => 'Idioma foi definido.',
	),
	'not_deleted' => 'Algo deu errado; você deve deletar o arquivo <em>%s</em> manualmente.',
	'ok' => 'O processo de instalação foi um sucesso.',
	'step' => 'passo %d',
	'steps' => 'Passos',
	'title' => 'Instalação · FreshRSS',
	'this_is_the_end' => 'Este é o final',
);

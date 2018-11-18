<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Permitir a leitura anónima dos artidos pelo usuário padrão (%s)',
		'allow_anonymous_refresh' => 'Permitir atualização anónima dos artigos',
		'api_enabled' => 'Permitir acesso à <abbr>API</abbr> <small>(Necessáiro para aplicativos móveis)</small>',
		'form' => 'Formulário Web(traditional, Necessita de JavaScript)',
		'http' => 'HTTP (Para usuários avançados com HTTPS)',
		'none' => 'Nenhum (Perigoso)',
		'title' => 'Autenticação',
		'title_reset' => 'Reset autenticação',
		'token' => 'Token de autenticação ',
		'token_help' => 'Permitir acesso a saída RSS para o usuário padrão sem autenticação',
		'type' => 'Método de autenticação',
		'unsafe_autologin' => 'Permitir login automática insegura usando o seguinte formato: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Verifique as permissões no diretório <em>./data/cache</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório cache estão corretos.',
		),
		'categories' => array(
			'nok' => 'Tabela Category está configurada incorretamente.',
			'ok' => 'Tabela Category está ok.',
		),
		'connection' => array(
			'nok' => 'Conexão ao banco de dados não pode ser estabelecida.',
			'ok' => 'Conexão ao banco de dados está ok.',
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
		'database' => 'Instalação do banco de dados',
		'dom' => array(
			'nok' => 'Não foi possível encontrar uma biblioteca necessária para navegar pelo DOM (php-xml).',
			'ok' => 'Você tem a biblioteca necessária para navegar pelo DOM.',
		),
		'entries' => array(
			'nok' => 'Tabela Entry está configurada incorretamente.',
			'ok' => 'Tabela Entry está ok.',
		),
		'favicons' => array(
			'nok' => 'Verifique as permissões no diretório <em>./data/favicons</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório favicons estão corretos.',
		),
		'feeds' => array(
			'nok' => 'Tabela Feed está configurada incorretamente.',
			'ok' => 'Tabela Feed está ok.',
		),
		'fileinfo' => array(
			'nok' => 'Não foi possível encontrar a biblioteca fileinfo do PHP (fileinfo).',
			'ok' => 'Você tem a biblioteca fileinfo.',
		),
		'files' => 'Instalação de arquivos',
		'json' => array(
			'nok' => 'Não foi possível encontrar JSON (php-json).',
			'ok' => 'Você tem a extensão JSON.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	//TODO - Translation
			'ok' => 'You have the recommended library mbstring for Unicode.',	//TODO - Translation
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
			'_' => 'Instação do PHP',
			'nok' => 'Sua versão do PHP é %s mas FreshRSS requer ao menos a versão %s.',
			'ok' => 'Sua versão do PHP é %s, que é compatível com o FreshRSS.',
		),
		'tables' => array(
			'nok' => 'Há uma ou mais tabelas inexistentes no banco de dados.',
			'ok' => 'As tabelas apropriadas existem no banco de dados.',
		),
		'title' => 'Verificação de instalação',
		'tokens' => array(
			'nok' => 'Verifique as permissões no diretório <em>./data/tokens</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório tokens estão corretos.',
		),
		'users' => array(
			'nok' => 'Verifiquei as permissões no diretório <em>./data/users</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório users estão corretos.',
		),
		'zip' => array(
			'nok' => 'Não foi possível localizar a extensão ZIP (php-zip).',
			'ok' => 'Você tem a extensão ZIP.',
		),
	),
	'extensions' => array(
		'author' => 'Author',	//TODO - Translation
		'community' => 'Available community extensions',	//TODO - Translation
		'description' => 'Description',	//TODO - Translation
		'disabled' => 'Desabilitado',
		'empty_list' => 'Não há extensões instaladas',
		'enabled' => 'Habilitada',
		'latest' => 'Installed',	//TODO - Translation
		'name' => 'Name',	//TODO - Translation
		'no_configure_view' => 'Esta extensão não pode ser configurada.',
		'system' => array(
			'_' => 'Extensões do sistema',
			'no_rights' => 'Extensões do sistema (Você não tem direitos para isto)',
		),
		'title' => 'Extensões',
		'update' => 'Update available',	//TODO - Translation
		'user' => 'Extensões do usuário',
		'version' => 'Version',	//TODO - Translation
	),
	'stats' => array(
		'_' => 'Estatísticas',
		'all_feeds' => 'Todos os feeds',
		'category' => 'Categoria',
		'entry_count' => 'Contagem de entrada',
		'entry_per_category' => 'Entradas por categoria',
		'entry_per_day' => 'Entradas por dia (últimos 30 dias)',
		'entry_per_day_of_week' => 'Por dia da semana(média: %.2f mensagens)',
		'entry_per_hour' => 'Por hora (média: %.2f mensagens)',
		'entry_per_month' => 'Por mês(média: %.2f mensagens)',
		'entry_repartition' => 'Repartição de entradas',
		'feed' => 'Feed',
		'feed_per_category' => 'Feeds por categoria',
		'idle' => 'Feeds inativos',
		'main' => 'Estatísticas principais',
		'main_stream' => 'Stream principal',
		'menu' => array(
			'idle' => 'Feeds inativos',
			'main' => 'Estatísticas principais',
			'repartition' => 'Repartição de artigos',
		),
		'no_idle' => 'Não há nenhum feed inativo!',
		'number_entries' => '%d artigos',
		'percent_of_total' => '%% do total',
		'repartition' => 'Repartição de artigos',
		'status_favorites' => 'Favoritos',
		'status_read' => 'Lido',
		'status_total' => 'Total',
		'status_unread' => 'Não lidos',
		'title' => 'Estatísticas',
		'top_feed' => 'Top10 feeds',
	),
	'system' => array(
		'_' => 'Configuração do sistema',
		'auto-update-url' => 'URL do servidor para atualização automática',
		'instance-name' => 'Nome da instância',
		'max-categories' => 'Limite de categorias por usuário',
		'max-feeds' => 'Limite de Feeds por usuário',
		'cookie-duration' => array(
			'help' => 'in seconds', // @todo translate
			'number' => 'Duration to keep logged in', // @todo translate
		),
		'registration' => array(
			'help' => '0 significa que não há limite para a conta',
			'number' => 'Máximo número de contas',
		),
	),
	'update' => array(
		'_' => 'Atualização do sistema',
		'apply' => 'Aplicar',
		'check' => 'Buscar por novas atualizações',
		'current_version' => 'Sua versão do FreshRSS é %s.',
		'last' => 'Última verificação: %s',
		'none' => 'Nenhuma atualização para se aplicar',
		'title' => 'Sistema de atualização',
	),
	'user' => array(
		'articles_and_size' => '%s artigos (%s)',
		'create' => 'Criar novo usuário',
		'delete_users' => 'Delete user',	//TODO - Translation
		'language' => 'Idioma',
		'number' => 'Há %d conta criada',
		'numbers' => 'Há %d contas criadas',
		'password_form' => 'Senha<br /><small>(para o login pelo método do formulário)</small>',
		'password_format' => 'Ao menos 7 caracteres',
		'selected' => 'Selected user',	//TODO - Translation
		'title' => 'Gerenciar usuários',
		'update_users' => 'Update user',	//TODO - Translation
		'user_list' => 'Lista de usuários',
		'username' => 'Usuário',
		'users' => 'Usuários',
	),
);

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
	'auth' => array(
		'allow_anonymous' => 'Permitir a leitura anónima dos artigos pelo usuário padrão (%s)',
		'allow_anonymous_refresh' => 'Permitir atualização anónima dos artigos',
		'api_enabled' => 'Permitir acesso à <abbr>API</abbr> <small>(Necessáiro para aplicativos móveis)</small>',
		'form' => 'Formulário Web(tradicional, Necessita de JavaScript)',
		'http' => 'HTTP (Para usuários avançados com HTTPS)',
		'none' => 'Nenhum (Perigoso)',
		'title' => 'Autenticação',
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
			'nok' => 'Não foi possível encontrar a biblioteca recomendada para Unicode (mbstring).',
			'ok' => 'Você tem a biblioteca recomendada para Unicode (mbstring).',
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
		'author' => 'Autor',
		'community' => 'Extensões da comunidade disponíveis',
		'description' => 'Descrição',
		'disabled' => 'Desabilitado',
		'empty_list' => 'Não há extensões instaladas',
		'enabled' => 'Habilitada',
		'latest' => 'Instalado',
		'name' => 'Nome',
		'no_configure_view' => 'Esta extensão não pode ser configurada.',
		'system' => array(
			'_' => 'Extensões do sistema',
			'no_rights' => 'Extensões do sistema (Você não tem direitos para isto)',
		),
		'title' => 'Extensões',
		'update' => 'Atualização disponível',
		'user' => 'Extensões do usuário',
		'version' => 'Versão',
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
		'feed' => 'Feed',	// IGNORE
		'feed_per_category' => 'Feeds por categoria',
		'idle' => 'Feeds inativos',
		'main' => 'Estatísticas principais',
		'main_stream' => 'Stream principal',
		'no_idle' => 'Não há nenhum feed inativo!',
		'number_entries' => '%d artigos',
		'percent_of_total' => '% do total',
		'repartition' => 'Repartição de artigos',
		'status_favorites' => 'Favoritos',
		'status_read' => 'Lido',
		'status_total' => 'Total',	// IGNORE
		'status_unread' => 'Não lidos',
		'title' => 'Estatísticas',
		'top_feed' => 'Top10 feeds',
	),
	'system' => array(
		'_' => 'Configuração do sistema',
		'auto-update-url' => 'URL do servidor para atualização automática',
		'base-url' => array(
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		),
		'cookie-duration' => array(
			'help' => 'em segundos',
			'number' => 'Manter seção ativa durante',
		),
		'force_email_validation' => 'Força verificação do endereço de email',
		'instance-name' => 'Nome da instância',
		'max-categories' => 'Limite de categorias por usuário',
		'max-feeds' => 'Limite de Feeds por usuário',
		'registration' => array(
			'number' => 'Máximo número de contas',
			'select' => array(
				'label' => 'Formulário de Registro',
				'option' => array(
					'noform' => 'Desativado: Sem formulário de registro',
					'nolimit' => 'Atividado: Sem limites de contas',
					'setaccountsnumber' => 'Definir o máximo de número de contas',
				),
			),
			'status' => array(
				'disabled' => 'Formulário desabilitado',
				'enabled' => 'Formulário habilitado',
			),
			'title' => 'Formulário de Cadastro de Usuário',
		),
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => array(
			'disabled' => 'is not given',	// TODO
			'enabled' => '<a href="./?a=tos">is enabled</a>',	// TODO
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">enable the Terms of Service</a>',	// TODO
		),
	),
	'update' => array(
		'_' => 'Atualização do sistema',
		'apply' => 'Aplicar',
		'changelog' => 'Changelog',	// TODO
		'check' => 'Buscar por novas atualizações',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => 'Sua versão',
		'last' => 'Última verificação',
		'loading' => 'Updating…',	// TODO
		'none' => 'Nenhuma atualização para se aplicar',
		'releaseChannel' => array(
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		),
		'title' => 'Sistema de atualização',
		'viaGit' => 'Update via git and Github.com started',	// TODO
	),
	'user' => array(
		'admin' => 'Administrador',
		'article_count' => 'Artigos',
		'back_to_manage' => '← Voltar para à lista de usuários',
		'create' => 'Criar novo usuário',
		'database_size' => 'Tamanho do banco de dados',
		'email' => 'Endereço de email',
		'enabled' => 'Habilitado',
		'feed_count' => 'Feeds',	// IGNORE
		'is_admin' => 'É administrador',
		'language' => 'Idioma',
		'last_user_activity' => 'Última Atividade do Usuário',
		'list' => 'Lista de usuários',
		'number' => 'Há %d conta criada',
		'numbers' => 'Há %d contas criadas',
		'password_form' => 'Senha<br /><small>(para o login pelo método do formulário)</small>',
		'password_format' => 'Ao menos 7 caracteres',
		'title' => 'Gerenciar usuários',
		'username' => 'Usuário',
	),
);

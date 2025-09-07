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
		'allow_anonymous' => 'Permitir a leitura anônima dos artigos pelo utilizador padrão (%s)',
		'allow_anonymous_refresh' => 'Permitir atualização anônima dos artigos',
		'api_enabled' => 'Permitir acesso à <abbr>API</abbr> <small>(É preciso para aplicações móveis e partilha pesquisas personalizadas)</small>',
		'form' => 'Formulário Web(tradicional, Necessita de JavaScript)',
		'http' => 'HTTP (advanced: managed by Web server, OIDC, SSO…)',	// TODO
		'none' => 'Nenhum (Perigoso)',
		'title' => 'Autenticação',
		'token' => 'Token de autenticação principal',
		'token_help' => 'Permite acesso a todos as saídas RSS do utilizador bem como atualização dos feeds sem autenticação:',
		'type' => 'Método de autenticação',
		'unsafe_autologin' => 'Permitir login automático inseguro usando o seguinte formato: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Verifique as permissões no diretório <em>./data/cache</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório cache estão corretos.',
		),
		'categories' => array(
			'nok' => 'Tabela Categoria está configurada incorretamente.',
			'ok' => 'Tabela Categoria está ok.',
		),
		'connection' => array(
			'nok' => 'Ligação ao banco de dados não pode ser estabelecida.',
			'ok' => 'Ligação ao banco de dados está correcta.',
		),
		'ctype' => array(
			'nok' => 'Não foi possível encontrar uma biblioteca necessária para verificação do tipo de caractere (php-ctype).',
			'ok' => 'A biblioteca necessária para verificação do tipo de caractere (ctype).Foi Encontrada',
		),
		'curl' => array(
			'nok' => 'Não foi possível encontrar a biblioteca cURL (php-curl).',
			'ok' => 'Tem a biblioteca cURL.',
		),
		'data' => array(
			'nok' => 'Verifique as permissões no diretório <em>./data</em>. O servidor HTTP deve ter direitos para escrever dentro desta pasta.',
			'ok' => 'Permissões no diretório data estão corretos.',
		),
		'database' => 'Instalação do banco de dados',
		'dom' => array(
			'nok' => 'Não foi possível encontrar uma biblioteca necessária para navegar pelo DOM (php-xml).',
			'ok' => 'Tem a biblioteca necessária para navegar pelo DOM.',
		),
		'entries' => array(
			'nok' => 'Tabela entradas está configurada incorretamente.',
			'ok' => 'Tabela entradas está correcta.',
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
			'ok' => 'Tem a biblioteca fileinfo.',
		),
		'files' => 'Instalação de arquivos',
		'json' => array(
			'nok' => 'Não foi possível encontrar JSON (php-json).',
			'ok' => 'Tem a extensão JSON.',
		),
		'mbstring' => array(
			'nok' => 'Não foi possível encontrar a biblioteca recomendada para Unicode (mbstring).',
			'ok' => 'Tem a biblioteca recomendada para Unicode (mbstring).',
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
			'_' => 'Instação do PHP',
			'nok' => 'A versão do PHP é %s mas FreshRSS requer ao menos a versão %s.',
			'ok' => 'A versão do PHP é %s, que é compatível com o FreshRSS.',
		),
		'tables' => array(
			'nok' => 'Há uma ou mais tabelas inexistentes no banco de dados.',
			'ok' => 'As tabelas apropriadas existem no base de dados.',
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
			'ok' => 'Tem a extensão ZIP.',
		),
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Extensões da comunidade disponíveis',
		'description' => 'Descrição',
		'disabled' => 'Desactivado',
		'empty_list' => 'Não existem extensões instaladas',
		'empty_list_help' => 'Check the logs to determine the reason behind the empty extension list.',	// TODO
		'enabled' => 'Habilitada',
		'latest' => 'Instalado',
		'name' => 'Nome',
		'no_configure_view' => 'Esta extensão não pode ser configurada.',
		'system' => array(
			'_' => 'Extensões do sistema',
			'no_rights' => 'Extensões do sistema (Não tem permissões para isto)',
		),
		'title' => 'Extensões',
		'update' => 'Atualização disponível',
		'user' => 'Extensões do utilizador',
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
		'overview' => 'Overview',	// TODO
		'percent_of_total' => '% do total',
		'repartition' => 'Repartição de artigos: %s',
		'status_favorites' => 'Favoritos',
		'status_read' => 'Lido',
		'status_total' => 'Total',	// IGNORE
		'status_unread' => 'Não lidos',
		'title' => 'Estatísticas',
		'top_feed' => 'Top10 Feeds',
	),
	'system' => array(
		'_' => 'Configuração do sistema',
		'auto-update-url' => 'URL do servidor para atualização automática',
		'base-url' => array(
			'_' => 'URL Base',
			'recommendation' => 'Recomendação automática: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => 'em segundos',
			'number' => 'Manter seção ativa durante',
		),
		'force_email_validation' => 'Força verificação do endereço de email',
		'instance-name' => 'Nome da instância',
		'max-categories' => 'Limite de categorias por utilizador',
		'max-feeds' => 'Limite de Feeds por utilizador',
		'registration' => array(
			'number' => 'Máximo número de contas',
			'select' => array(
				'label' => 'Formulário de Registro',
				'option' => array(
					'noform' => 'Desativado: Sem formulário de registro',
					'nolimit' => 'Ativado: Sem limites de contas',
					'setaccountsnumber' => 'Definir o máximo número de contas',
				),
			),
			'status' => array(
				'disabled' => 'Formulário desabilitado',
				'enabled' => 'Formulário activado',
			),
			'title' => 'Formulário de registo de utilizador',
		),
		'sensitive-parameter' => 'Parâmetro sensível. Edite manualmente em <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'não fornecido',
			'enabled' => '<a href="./?a=tos">está ativado</a>',
			'help' => 'Como <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">habilitar os Termos de Serviço</a>',
		),
		'websub' => array(
			'help' => 'Sobre <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => 'Atualização do sistema',
		'apply' => 'Aplicar',
		'changelog' => 'Registo de alterações',
		'check' => 'Pesquisar por novas atualizações',
		'copiedFromURL' => 'update.php copiado de %s para ./data',
		'current_version' => 'Versão',
		'last' => 'Última verificação',
		'loading' => 'A fazer atualização…',
		'none' => 'Nenhuma atualização disponivel',
		'releaseChannel' => array(
			'_' => 'Canal de Release',
			'edge' => 'Release contínua (“edge”)',
			'latest' => 'Release estável (“latest”)',
		),
		'title' => 'Sistema de atualização',
		'viaGit' => 'Atualização via git e GitHub.com iniciada',
	),
	'user' => array(
		'admin' => 'Administrador',
		'article_count' => 'Artigos',
		'back_to_manage' => '← Voltar para à lista de utilizadores',
		'create' => 'Criar novo utilizador',
		'database_size' => 'Tamanho do banco de dados',
		'email' => 'Endereço de email',
		'enabled' => 'Activado',
		'feed_count' => 'Feeds',	// IGNORE
		'is_admin' => 'É administrador',
		'language' => 'Idioma',
		'last_user_activity' => 'Última Atividade do utilizador',
		'list' => 'Lista de utilizadors',
		'number' => 'Há %d conta criada',
		'numbers' => 'Há %d contas criadas',
		'password_form' => 'Senha<br /><small>(para o login pelo método do formulário)</small>',
		'password_format' => 'Ao menos 7 caracteres',
		'title' => 'Gerir utilizadores',
		'username' => 'utilizador',
	),
);

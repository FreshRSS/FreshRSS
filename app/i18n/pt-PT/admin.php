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
	'auth' => array(
		'allow_anonymous' => 'Permitir a leitura anónima dos artigos pelo utilizador predefinido (%s)',
		'allow_anonymous_refresh' => 'Permitir atualização anónima dos artigos',
		'api_enabled' => 'Permitir acesso à <abbr>API</abbr> <small>(Necessário para aplicações móveis e partilha de pesquisas personalizadas)</small>',
		'form' => 'Formulário web (tradicional, requer JavaScript)',
		'http' => 'HTTP (avançado: gerido pelo servidor web, OIDC, SSO…)',
		'none' => 'Nenhum (Perigoso)',
		'title' => 'Autenticação',
		'token' => 'Token de autenticação principal',
		'token_help' => 'Permite acesso a todas as saídas RSS do utilizador, bem como a atualização dos feeds sem autenticação:',
		'type' => 'Método de autenticação',
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Extensões da comunidade disponíveis',
		'description' => 'Descrição',
		'disabled' => 'Desativado',
		'empty_list' => 'Não existem extensões instaladas',
		'empty_list_help' => 'Verifique os registos para determinar o motivo da lista de extensões vazia.',
		'enabled' => 'Ativado',
		'is_compatible' => 'É compatível',
		'latest' => 'Instalado',
		'name' => 'Nome',
		'no_configure_view' => 'Esta extensão não pode ser configurada.',
		'system' => array(
			'_' => 'Extensões do sistema',
			'no_rights' => 'Extensões do sistema (não tem permissões para isto)',
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
		'date_published' => 'Data de publicação',
		'date_received' => 'Data de receção',
		'entry_count' => 'Contagem de entradas',
		'entry_per_category' => 'Entradas por categoria',
		'entry_per_day' => 'Entradas por dia (últimos 30 dias)',
		'entry_per_day_of_week' => 'Por dia da semana (média: %.2f mensagens)',
		'entry_per_hour' => 'Por hora (média: %.2f mensagens)',
		'entry_per_month' => 'Por mês (média: %.2f mensagens)',
		'entry_repartition' => 'Repartição de entradas',
		'feed' => 'Feed',	// IGNORE
		'feed_per_category' => 'Feeds por categoria',
		'idle' => 'Feeds inativos',
		'main' => 'Estatísticas principais',
		'main_stream' => 'Stream principal',
		'nb_unreads' => 'Número de artigos não lidos',
		'no_idle' => 'Não há nenhum feed inativo!',
		'number_entries' => '%d artigos',
		'overview' => 'Visão geral',
		'percent_of_total' => '% do total',
		'repartition' => 'Repartição de artigos: %s',
		'status_favorites' => 'Favoritos',
		'status_read' => 'Lido',
		'status_total' => 'Total',	// IGNORE
		'status_unread' => 'Não lidos',
		'title' => 'Estatísticas',
		'top_feed' => 'Top 10 de Feeds',
		'unread_dates' => 'Datas com mais artigos não lidos',
	),
	'system' => array(
		'_' => 'Configuração do sistema',
		'auto-update-url' => 'URL do servidor para atualização automática',
		'base-url' => array(
			'_' => 'URL Base',
			'recommendation' => 'Recomendação automática: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Mensagem caso os registos estejam encerrados',
		'cookie-duration' => array(
			'help' => 'em segundos',
			'number' => 'Manter sessão ativa durante',
		),
		'default_closed_registration_message' => 'Este servidor não aceita novos registos de momento.',
		'force_email_validation' => 'Forçar verificação do endereço de email',
		'instance-name' => 'Nome da instância',
		'internal-host-allowlist' => array(
			'_' => 'Lista de permissões de anfitriões internos',
			'help' => 'Uma entrada por linha:<ul><li>Um <code>host:port</code>. Por exemplo, <code>127.0.0.1:8080</code> ou <code>rss-bridge:80</code></li><li>Uma notação CIDR. Por exemplo, <code>0.0.0.0/0</code> para permitir qualquer IPv4, <code>::/0</code> para permitir qualquer IPv6</li><li>Um <code>*</code> para permitir qualquer anfitrião (inseguro)</li></ul>',
		),
		'max-categories' => 'Limite de categorias por utilizador',
		'max-feeds' => 'Limite de feeds por utilizador',
		'override-by-env-var' => 'Esta definição é definida pela variável de ambiente <kbd>%s</kbd>.',
		'password_reset' => array(
			'_' => 'Allow password reset by email',	// TODO
			'help' => 'Requires the form authentication, a working mailer, and <code>base_url</code> to be set in <code>data/config.php</code>.',	// TODO
		),
		'registration' => array(
			'number' => 'Número máximo de contas',
			'select' => array(
				'label' => 'Formulário de registo',
				'option' => array(
					'noform' => 'Desativado: sem formulário de registo',
					'nolimit' => 'Ativado: sem limite de contas',
					'setaccountsnumber' => 'Definir o número máximo de contas',
				),
			),
			'status' => array(
				'disabled' => 'Formulário desativado',
				'enabled' => 'Formulário ativado',
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
		'check' => 'Procurar novas atualizações',
		'copiedFromURL' => 'update.php copiado de %s para ./data',
		'current_version' => 'Versão',
		'last' => 'Última verificação',
		'loading' => 'A atualizar…',
		'none' => 'Nenhuma atualização disponível',
		'releaseChannel' => array(
			'_' => 'Canal de lançamento',
			'edge' => 'Lançamento contínuo (“edge”)',
			'latest' => 'Lançamento estável (“latest”)',
		),
		'title' => 'Sistema de atualização',
		'viaGit' => 'Atualização via git e GitHub.com iniciada',
	),
	'user' => array(
		'admin' => 'Administrador',
		'article_count' => 'Artigos',
		'back_to_manage' => '← Voltar para a lista de utilizadores',
		'create' => 'Criar novo utilizador',
		'database_size' => 'Tamanho da base de dados',
		'email' => 'Endereço de email',
		'enabled' => 'Ativado',
		'feed_count' => 'Feeds',	// IGNORE
		'is_admin' => 'É administrador',
		'language' => 'Idioma',
		'last_user_activity' => 'Última atividade do utilizador',
		'list' => 'Lista de utilizadores',
		'number' => 'Existe %d conta criada',
		'numbers' => 'Existem %d contas criadas',
		'password_form' => 'Palavra-passe<br /><small>(para o início de sessão pelo método de formulário)</small>',
		'password_format' => 'Pelo menos 7 caracteres',
		'title' => 'Gerir utilizadores',
		'username' => 'utilizador',
	),
);

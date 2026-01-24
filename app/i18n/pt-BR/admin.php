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
		'allow_anonymous' => 'Permitir a leitura anônima dos artigos pelo usuário padrão (%s)',
		'allow_anonymous_refresh' => 'Permitir atualização anônima dos artigos',
		'api_enabled' => 'Permitir acesso à <abbr>API</abbr> <small>(Necessário para aplicativos móveis e compartilhamento de consultas de usuários)</small>',
		'form' => 'Formulário Web(tradicional, Necessita de JavaScript)',
		'http' => 'HTTP (avançado: gerenciado por servidor web, OIDC, SSO…)',
		'none' => 'Nenhum (Perigoso)',
		'title' => 'Autenticação',
		'token' => 'Token de autenticação principal',
		'token_help' => 'Permite acesso a todos as saídas RSS do usuário bem como atualização dos feeds sem autenticação:',
		'type' => 'Método de autenticação',
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Extensões da comunidade disponíveis',
		'description' => 'Descrição',
		'disabled' => 'Desabilitado',
		'empty_list' => 'Não há extensões instaladas',
		'empty_list_help' => 'Verifique os registros para determinar o motivo da lista de extensões estar vazia.',
		'enabled' => 'Habilitada',
		'is_compatible' => 'É compatível',
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
		'date_published' => 'Data de publicação',
		'date_received' => 'Data de recebimento',
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
		'top_feed' => 'Top10 Feeds',
		'unread_dates' => 'Datas com mais artigos não lidos',
	),
	'system' => array(
		'_' => 'Configuração do sistema',
		'auto-update-url' => 'URL do servidor para atualização automática',
		'base-url' => array(
			'_' => 'URL Base',
			'recommendation' => 'Recomendação automática: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => 'em segundos',
			'number' => 'Manter seção ativa durante',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
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
					'nolimit' => 'Ativado: Sem limites de contas',
					'setaccountsnumber' => 'Definir o máximo número de contas',
				),
			),
			'status' => array(
				'disabled' => 'Formulário desabilitado',
				'enabled' => 'Formulário habilitado',
			),
			'title' => 'Formulário de Cadastro de Usuário',
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
		'changelog' => 'Registro de alterações',
		'check' => 'Buscar por novas atualizações',
		'copiedFromURL' => 'update.php copiado de %s para ./data',
		'current_version' => 'Sua versão',
		'last' => 'Última verificação',
		'loading' => 'Atualizando…',
		'none' => 'Nenhuma atualização para se aplicar',
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

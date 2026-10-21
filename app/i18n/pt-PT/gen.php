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
		'actualize' => 'Atualizar feeds',
		'add' => 'Adicionar',
		'back_to_rss_feeds' => '← Voltar para os seus feeds RSS',
		'cancel' => 'Cancelar',
		'close' => 'Fechar',
		'create' => 'Criar',
		'delete_all_feeds' => 'Eliminar todos os feeds',
		'delete_errored_feeds' => 'Eliminar feeds com erros',
		'delete_muted_feeds' => 'Eliminar feeds silenciados',
		'demote' => 'Despromover',
		'disable' => 'Desativar',
		'download' => 'Transferir',
		'empty' => 'Vazio',
		'enable' => 'Ativar',
		'export' => 'Exportar',
		'filter' => 'Filtrar',
		'import' => 'Importar',
		'load_default_shortcuts' => 'Carregar atalhos predefinidos',
		'manage' => 'Gerir',
		'mark_read' => 'Marcar como lido',
		'menu' => array(
			'open' => 'Abrir menu',
		),
		'nav_buttons' => array(
			'next' => 'Artigo seguinte',
			'prev' => 'Artigo anterior',
			'up' => 'Ir para cima',
		),
		'open_url' => 'Abrir URL',
		'promote' => 'Promover',
		'purge' => 'Limpar',
		'refresh_opml' => 'Atualizar OPML',
		'remove' => 'Remover',
		'rename' => 'Renomear',
		'see_website' => 'Ver site',
		'submit' => 'Enviar',
		'truncate' => 'Apagar todos os artigos',
		'update' => 'Atualizar',
	),
	'auth' => array(
		'accept_tos' => 'Aceito os <a href="%s">Termos de serviço</a>.',
		'email' => 'Endereço de email',
		'keep_logged_in' => 'Manter sessão iniciada durante <small>(%s dias)</small>',
		'login' => 'Entrar',
		'logout' => 'Sair',
		'password' => array(
			'_' => 'Palavra-passe',
			'format' => '<small>Pelo menos 7 caracteres</small>',
		),
		'reauth' => array(
			'header' => 'É necessária reautenticação',
			'tip' => 'Não lhe será pedido para iniciar sessão novamente durante <u>%d minutos</u>',
			'title' => 'Reautenticação',
		),
		'registration' => array(
			'_' => 'Nova conta',
			'ask' => 'Criar nova conta?',
			'title' => 'Criação de conta',
		),
		'username' => array(
			'_' => 'Utilizador',
			'format' => '<small>1-39 caracteres: letras, dígitos e <code>. _ @ -</code></small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\b\\r\\i\\l',
		'Aug' => '\\A\\g\\o\\s\\t\\o',
		'Dec' => '\\D\\e\\z\\e\\m\\b\\r\\o',
		'Feb' => '\\F\\e\\v\\e\\r\\e\\i\\r\\o',
		'Jan' => '\\J\\a\\n\\e\\i\\r\\o',
		'Jul' => '\\J\\u\\l\\h\\o',
		'Jun' => '\\J\\u\\n\\h\\o',
		'Mar' => '\\M\\a\\r\\ç\\o',
		'May' => '\\M\\a\\i\\o',
		'Nov' => '\\N\\o\\v\\e\\m\\b\\r\\o',
		'Oct' => '\\O\\u\\t\\u\\b\\r\\o',
		'Sep' => '\\S\\e\\t\\e\\m\\b\\r\\o',
		'apr' => 'abr',
		'april' => 'Abr',
		'aug' => 'ago',
		'august' => 'Ago',
		'before_yesterday' => 'Antes de ontem',
		'dec' => 'dez',
		'december' => 'Dez',
		'feb' => 'fev',
		'february' => 'Fev',
		'format_date' => 'j \\d\\e %s \\d\\e Y',
		'format_date_hour' => 'j \\d\\e %s \\d\\e Y\\, H\\:i',
		'fri' => 'Sex',
		'jan' => 'jan',
		'january' => 'Jan',
		'jul' => 'jul',
		'july' => 'Jul',
		'jun' => 'jun',
		'june' => 'Jun',
		'last_2_year' => 'Últimos dois anos',
		'last_3_month' => 'Últimos três meses',
		'last_3_year' => 'Últimos três anos',
		'last_5_year' => 'Últimos cinco anos',
		'last_6_month' => 'Últimos seis meses',
		'last_month' => 'Último mês',
		'last_week' => 'Última semana',
		'last_year' => 'Último ano',
		'mar' => 'mar',
		'march' => 'Mar',
		'may' => 'Mai',
		'may_' => 'Mai',
		'mon' => 'Seg',
		'month' => 'meses',
		'nov' => 'nov',
		'november' => 'Nov',
		'oct' => 'out',
		'october' => 'Out',
		'sat' => 'Sáb',
		'sep' => 'set',
		'september' => 'Set',
		'sun' => 'Dom',
		'thu' => 'Qui',
		'today' => 'Hoje',
		'tue' => 'Ter',
		'wed' => 'Qua',
		'yesterday' => 'Ontem',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Sobre o FreshRSS',
	),
	'interval' => array(
		'day' => array(
			0 => 'há %d dia',
			1 => 'há %d dias',
		),
		'hour' => array(
			0 => 'há %d hora',
			1 => 'há %d horas',
		),
		'justnow' => 'agora mesmo',
		'minute' => array(
			0 => 'há %d minuto',
			1 => 'há %d minutos',
		),
		'month' => array(
			0 => 'há %d mês',
			1 => 'há %d meses',
		),
		'second' => array(
			0 => 'há %d segundo',
			1 => 'há %d segundos',
		),
		'year' => array(
			0 => 'há %d ano',
			1 => 'há %d anos',
		),
	),
	'js' => array(
		'category_empty' => 'Categoria vazia',
		'confirm_action' => 'Tem a certeza de que deseja efetuar esta ação? Não poderá ser revertida!',
		'confirm_action_feed_cat' => 'Tem a certeza de que deseja efetuar esta ação? Irá perder os favoritos e as pesquisas personalizadas. Não poderá ser revertida!',
		'confirm_exit_slider' => 'Tem a certeza de que pretende descartar as definições não guardadas?',
		'feedback' => array(
			'body_new_articles' => array(
				0 => 'Há %d novo artigo para ler no FreshRSS.',
				1 => 'Há %d novos artigos para ler no FreshRSS.',
			),
			'body_unread_articles' => array(
				0 => '(não lido: %d)',
				1 => '(não lidos: %d)',
			),
			'request_failed' => 'Um pedido falhou, isto poderá ter sido causado por problemas de ligação à internet.',
			'title_new_articles' => 'FreshRSS: novos artigos!',
		),
		'labels_empty' => 'Sem rótulos',
		'new_article' => 'Há novos artigos disponíveis, clique para atualizar a página.',
		'should_be_activated' => 'O JavaScript precisa de estar ativo',
		'unsafe_csp_header' => 'O cabeçalho CSP em utilização não é seguro e o FreshRSS pode estar vulnerável a ataques XSS. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Consultar a documentação</a>',
	),
	'lang' => array(
		'az' => 'Azərbaycanca',	// IGNORE
		'be' => 'Беларуская',	// IGNORE
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lt' => 'Lietuvių',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Sobre',
		'account' => 'Conta',
		'admin' => 'Administração',
		'advanced_search' => 'Pesquisa avançada',
		'archiving' => 'Arquivar',
		'authentication' => 'Autenticação',
		'check_install' => 'Verificação de instalação',
		'configuration' => 'Configuração',
		'display' => 'Visualização',
		'extensions' => 'Extensões',
		'logs' => 'Logs',	// IGNORE
		'privacy' => 'Privacidade',
		'queries' => 'Consultas de utilizador',
		'reading' => 'Leitura',
		'search' => 'Procurar por palavras ou #tags',
		'search_help' => 'Consulte a documentação para <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">parâmetros de pesquisa avançados</a>',
		'sharing' => 'Partilhar',
		'shortcuts' => 'Atalhos',
		'stats' => 'Estatísticas',
		'system' => 'Configuração do sistema',
		'update' => 'Atualização',
		'user_management' => 'Gestão de utilizadores',
		'user_profile' => 'Perfil',
	),
	'period' => array(
		'days' => 'dias',
		'hours' => 'horas',
		'months' => 'meses',
		'weeks' => 'semanas',
		'years' => 'anos',
	),
	'readme' => array(
		'contribute' => 'contribute',	// IGNORE
		'language' => 'Language',	// IGNORE
		'translated' => 'Progress',	// IGNORE
	),
	'search' => array(
		'advanced_search_help' => 'Este formulário ajuda a construir consultas de pesquisa, mas as consultas manuais são ainda mais poderosas.',
		'authors' => 'Autores',
		'categories' => 'Categorias',
		'content' => 'Conteúdo',
		'date_from' => 'De',
		'date_modified' => 'Data de modificação do servidor',
		'date_past' => 'No passado',
		'date_published' => 'Data de publicação',
		'date_range' => 'Intervalo de datas',
		'date_received' => 'Data de receção',
		'date_to' => 'Até',
		'date_user' => 'Data de modificação do utilizador',
		'feeds' => 'Feeds',	// IGNORE
		'free_text' => 'Texto livre',
		'free_text_help' => 'Pesquisar tanto no título como no conteúdo',
		'full_documentation' => 'Ver a <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">documentação completa de pesquisa</a>',
		'labels' => 'Os meus rótulos',
		'multiple_help' => 'Selecionar um ou mais (manter premido <kbd>Ctrl</kbd> ou <kbd>Cmd</kbd>)',
		'sources' => 'Fontes',
		'tags' => 'Tags de artigos',
		'text' => 'Pesquisa de texto',
		'text_help' => 'Múltiplas linhas são combinadas por um <i>ou</i> lógico. Também suporta <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">expressões regulares</a>.',
		'text_placeholder' => 'Palavra-chave',
		'title' => 'Título',
		'url' => 'URL',	// IGNORE
		'user_queries' => 'Consultas de utilizador',
	),
	'share' => array(
		'Known' => 'Sites no Known',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Área de transferência',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'email-webmail-firefox-fix' => 'Email (webmail - correção para o Firefox)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkace' => 'LinkAce',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'nextcloud-bookmarks' => 'Marcadores Nextcloud',
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'print' => 'Imprimir',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'X (Twitter)',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Partilha web (API)',
		'whatsapp' => 'WhatsApp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Atenção!',
		'blank_to_disable' => 'Deixar em branco para desativar',
		'by_author' => 'Por:',
		'by_default' => 'Por predefinição',
		'damn' => 'Droga!',
		'default_category' => 'Sem categoria',
		'no' => 'Não',
		'not_applicable' => 'Não aplicável',
		'ok' => 'Ok!',	// IGNORE
		'or' => 'ou',
		'yes' => 'Sim',
	),
	'stream' => array(
		'load_more' => 'Carregar mais artigos',
		'mark_all_read' => 'Marcar todos como lidos',
		'nothing_to_load' => 'Não existem mais artigos',
	),
);

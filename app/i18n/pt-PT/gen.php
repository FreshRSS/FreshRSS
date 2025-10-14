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
		'back_to_rss_feeds' => '← Volte para o seu feeds RSS',
		'cancel' => 'Cancelar',
		'close' => 'Close',	// TODO
		'create' => 'Criar',
		'delete_all_feeds' => 'Delete all feeds',	// TODO
		'delete_errored_feeds' => 'Delete feeds with errors',	// TODO
		'delete_muted_feeds' => 'Excluir feeds silenciados',
		'demote' => 'Despromover',
		'disable' => 'Desactivar',
		'download' => 'Download',	// TODO
		'empty' => 'Vazio',
		'enable' => 'Activar',
		'export' => 'Exportar',
		'filter' => 'Filtrar',
		'import' => 'Importar',
		'load_default_shortcuts' => 'Carregar mais atalhos',
		'manage' => 'Gerir',
		'mark_read' => 'Marcar como lido',
		'menu' => array(
			'open' => 'Open menu',	// TODO
		),
		'nav_buttons' => array(
			'next' => 'Next article',	// TODO
			'prev' => 'Previous article',	// TODO
			'up' => 'Go up',	// TODO
		),
		'open_url' => 'Abrir URL',
		'promote' => 'Promover',
		'purge' => 'Limpar',
		'refresh_opml' => 'Atualizar OPML',
		'remove' => 'Remover',
		'rename' => 'Renomear',
		'see_website' => 'Ver o site',
		'submit' => 'Enviar',
		'truncate' => 'Apagar todos os artigos',
		'update' => 'Atualizar',
	),
	'auth' => array(
		'accept_tos' => 'Eu aceito os <a href="%s">Termos de serviço</a>.',
		'email' => 'Endereço de e-mail',
		'keep_logged_in' => 'Mantenha-se ligado por <small>(%s days)</small>',
		'login' => 'Entrar',
		'logout' => 'Sair',
		'password' => array(
			'_' => 'Senha',
			'format' => '<small>Pelo menos 7 caracteres</small>',
		),
		'reauth' => array(
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
		),
		'registration' => array(
			'_' => 'Nova conta',
			'ask' => 'Criar novoa conta?',
			'title' => 'Criação de conta',
		),
		'username' => array(
			'_' => 'Utilizador',
			'format' => '<small>Máximo 16 caracteres alphanumericos</small>',
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
		'last_month' => 'Últimos mês',
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
		'sat' => 'Sab',
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
		'about' => 'Sobre FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Categoria vazia',
		'confirm_action' => 'Tem certeza que deseja efetuar esta ação? Ela não poderá ser revertida!',
		'confirm_action_feed_cat' => 'Tem certeza que deseja efetuar esta ação ? vai perder favoritos e pesquisas personalizadas. Não poderá ser revertida!',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => 'Há %%d novos artigos para ler no FreshRSS.',
			'body_unread_articles' => '(não lido: %%d)',
			'request_failed' => 'Uma solicitação falhou, isto pode ter sido causado por problemas de ligação a internet.',
			'title_new_articles' => 'FreshRSS: novos artigos!',
		),
		'labels_empty' => 'No labels',	// TODO
		'new_article' => 'Há novos artigos disponíveis, clique para atualizar a página.',
		'should_be_activated' => 'O JavaScript precisa estar ativo',
		'unsafe_csp_header' => 'The CSP header in use is unsafe and FreshRSS may be vulnerable to XSS attacks. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">See documentation</a>',	// TODO
	),
	'lang' => array(
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
		'advanced_search' => 'Advanced Search',	// TODO
		'archiving' => 'Arquivar',
		'authentication' => 'Autenticação',
		'check_install' => 'Verificação de instalação',
		'configuration' => 'Configuração',
		'display' => 'Visualização',
		'extensions' => 'Extensões',
		'logs' => 'Logs',	// IGNORE
		'privacy' => 'Privacy',	// TODO
		'queries' => 'Queries de utilizador',
		'reading' => 'Leitura',
		'search' => 'Procurar por palavras ou #tags',
		'search_help' => 'See documentation for advanced <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">search parameters</a>',	// TODO
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
		'advanced_search_help' => 'This form helps construct search queries, but manual queries are even more powerful.',	// TODO
		'authors' => 'Authors',	// TODO
		'categories' => 'Categories',	// TODO
		'content' => 'Content',	// TODO
		'date_from' => 'From',	// TODO
		'date_past' => 'In the past',	// TODO
		'date_published' => 'Publication Date',	// TODO
		'date_range' => 'Date Range',	// TODO
		'date_received' => 'Received Date',	// TODO
		'date_to' => 'To',	// TODO
		'feeds' => 'Feeds',	// TODO
		'free_text' => 'Free Text',	// TODO
		'free_text_help' => 'Search both in title and content',	// TODO
		'full_documentation' => 'View <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">full search documentation</a>',	// TODO
		'labels' => 'My Labels',	// TODO
		'multiple_help' => 'Select one or more (hold <kbd>Ctrl</kbd> or <kbd>Cmd</kbd>)',	// TODO
		'sources' => 'Sources',	// TODO
		'tags' => 'Article Tags',	// TODO
		'text' => 'Text Search',	// TODO
		'text_help' => 'Multiple lines are combined by a logical <i>or</i>. Also supports <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">regular expressions</a>.',	// TODO
		'text_placeholder' => 'Keyword',	// TODO
		'title' => 'Title',	// TODO
		'url' => 'URL',	// TODO
		'user_queries' => 'User Queries',	// TODO
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
		'email' => 'E-mail',
		'email-webmail-firefox-fix' => 'Email (webmail - correção para o Firefox)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Imprimir',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Sistemas-compartilhados (API)',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Atenção!',
		'blank_to_disable' => 'Deixe em branco para desativar',
		'by_author' => 'Por:',
		'by_default' => 'Por padrão',
		'damn' => 'Buumm!',
		'default_category' => 'Sem categoria',
		'no' => 'Não',
		'not_applicable' => 'Não disponível',
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

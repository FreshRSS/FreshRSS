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
		'actualize' => 'Actualizar flux',
		'add' => 'Ajustar',
		'back_to_rss_feeds' => '← Tornar a vòstres fluxes RSS',
		'cancel' => 'Anullar',
		'close' => 'Close',	// TODO
		'create' => 'Crear',
		'delete_all_feeds' => 'Delete all feeds',	// TODO
		'delete_errored_feeds' => 'Delete feeds with errors',	// TODO
		'delete_muted_feeds' => 'Suprimir los flux muts',
		'demote' => 'Retrogradar',
		'disable' => 'Desactivar',
		'download' => 'Download',	// TODO
		'empty' => 'Voidar',
		'enable' => 'Activar',
		'export' => 'Exportar',
		'filter' => 'Filtre',
		'import' => 'Importar',
		'load_default_shortcuts' => 'Cargar los acorchis per defaut',
		'manage' => 'Gerir',
		'mark_read' => 'Marcar coma legit',
		'menu' => array(
			'open' => 'Open menu',	// TODO
		),
		'nav_buttons' => array(
			'next' => 'Next article',	// TODO
			'prev' => 'Previous article',	// TODO
			'up' => 'Go up',	// TODO
		),
		'open_url' => 'Dobrir l’URL',
		'promote' => 'Promòure',
		'purge' => 'Purgar',
		'refresh_opml' => 'Refrescar OPML',
		'remove' => 'Levar',
		'rename' => 'Renomenar',
		'see_website' => 'Veire lo site',
		'submit' => 'Mandar',
		'truncate' => 'Suprimir totes los articles',
		'update' => 'Actualizar',
	),
	'auth' => array(
		'accept_tos' => 'Accepti las <a href="%s">condicions d’utilizacion</a>.',
		'email' => 'Adreça de corrièl',
		'keep_logged_in' => 'Demorar connectat <small>(%s jorns) </small>',
		'login' => 'Connexion',
		'logout' => 'Se desconnectar',
		'password' => array(
			'_' => 'Senhal',
			'format' => '<small>Almens 7 caractèrs</small>',
		),
		'reauth' => array(
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
		),
		'registration' => array(
			'_' => 'Compte nòu',
			'ask' => 'Crear un compte?',
			'title' => 'Creacion de compte',
		),
		'username' => array(
			'_' => 'Nom d’utilizaire',
			'format' => '<small>16 caractèrs alfanumerics maximum</small>',
		),
	),
	'date' => array(
		'Apr' => '\\a\\b\\r\\i\\a\\l',
		'Aug' => '\\a\\g\\o\\s\\t',
		'Dec' => '\\d\\e\\c\\e\\m\\b\\r\\e',
		'Feb' => '\\f\\e\\b\\r\\i\\è\\r',
		'Jan' => '\\g\\e\\n\\i\\è\\r',
		'Jul' => '\\j\\u\\l\\h\\e\\t',
		'Jun' => '\\j\\u\\n\\h',
		'Mar' => '\\m\\a\\r\\ç',
		'May' => '\\m\\a\\i',
		'Nov' => '\\n\\o\\v\\e\\m\\b\\r\\e',
		'Oct' => '\\o\\c\\t\\ò\\b\\r\\e',
		'Sep' => '\\s\\e\\t\\e\\m\\b\\r\\e',
		'apr' => 'abr.',
		'april' => 'abrial',
		'aug' => 'agost',
		'august' => 'agost',
		'before_yesterday' => 'Anterior a ièr',
		'dec' => 'dec.',
		'december' => 'decembre',
		'feb' => 'feb.',
		'february' => 'febrièr',
		'format_date' => 'j \\d\\e %s \\d\\e Y',
		'format_date_hour' => 'j \\d\\e %s \\d\\e Y \\a H\\:i',
		'fri' => 'dv',
		'jan' => 'gen.',
		'january' => 'genièr',
		'jul' => 'julh',
		'july' => 'julhet',
		'jun' => 'junh',
		'june' => 'junh',
		'last_2_year' => 'Dempuèi las darrièras doas annadas',
		'last_3_month' => 'Dempuèi los darrièrs tres meses',
		'last_3_year' => 'Dempuèi las darrièras tres annadas',
		'last_5_year' => 'Dempuèi las darrièras cinc annadas',
		'last_6_month' => 'Dempuèi los darrièrs sièis meses',
		'last_month' => 'Dempuèi lo mes passat',
		'last_week' => 'Dempuèi la setmana passada',
		'last_year' => 'Dempuèi l’annada passada',
		'mar' => 'març',
		'march' => 'març',
		'may' => 'mai',
		'may_' => 'mai',
		'mon' => 'dl',
		'month' => 'meses',
		'nov' => 'nov.',
		'november' => 'novembre',
		'oct' => 'oct.',
		'october' => 'octòbre',
		'sat' => 'ds',
		'sep' => 'set.',
		'september' => 'setembre',
		'sun' => 'dg',
		'thu' => 'dj',
		'today' => 'Uèi',
		'tue' => 'dm',
		'wed' => 'Dc',
		'yesterday' => 'Ièr',
	),
	'dir' => 'ltr',	// IGNORE
	'flag' => '🏴󠁦󠁲󠁯󠁣󠁣󠁿',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'A prepaus de FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Categoria voida',
		'confirm_action' => 'Volètz vertadièrament contunhar ? Aquesta accion se pòt pas anullar !',
		'confirm_action_feed_cat' => 'Volètz vertadièrament contunhar ? Perdretz los favorits e filtres ligats. Aquesta accion se pòt pas anullar !',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => 'I a %%d nòus articles per legir sus FreshRSS.',
			'body_unread_articles' => '(unread: %%d)',	// TODO
			'request_failed' => 'Una requèsta a fach meuca, aquò pòt venir d’un problèma de connexion Internet.',
			'title_new_articles' => 'FreshRSS : nòus articles !',
		),
		'labels_empty' => 'No labels',	// TODO
		'new_article' => 'I a d’articles nòus disponibles, clicatz per actualizar la pagina.',
		'should_be_activated' => 'JavaScript deu èsser activat',
		'unsafe_csp_header' => 'The CSP header in use is unsafe and FreshRSS may be vulnerable to XSS attacks. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">See documentation</a>',	// TODO
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
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
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'pt-pt' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
		'zh-tw' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'A prepaus',
		'account' => 'Compte',
		'admin' => 'Administracion',	// IGNORE
		'archiving' => 'Archivar',
		'authentication' => 'Autentificacion',
		'check_install' => 'Verificacion de l’installacion',
		'configuration' => 'Configuracion',	// IGNORE
		'display' => 'Afichatge',
		'extensions' => 'Extensions',	// IGNORE
		'logs' => 'Jornals d’audit',	// IGNORE
		'privacy' => 'Privacy',	// TODO
		'queries' => 'Filtres utilizaire',
		'reading' => 'Lectura',
		'search' => 'Recercar de mots o d’#etiquetas',
		'search_help' => 'See documentation for advanced <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">search parameters</a>',	// TODO
		'sharing' => 'Partatge',
		'shortcuts' => 'Acorchis',
		'stats' => 'Estatisticas',
		'system' => 'Configuracion sistèma',
		'update' => 'Mesa a jorn',
		'user_management' => 'Gestion dels utilizaires',
		'user_profile' => 'Perfil',
	),
	'period' => array(
		'days' => 'jorns',
		'hours' => 'oras',
		'months' => 'meses',
		'weeks' => 'setmanas',
		'years' => 'ans',
	),
	'share' => array(
		'Known' => 'Sites basats sus Known',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Quicha-papiers.',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Corrièl',
		'email-webmail-firefox-fix' => 'Email (webmail - fix for Firefox)',	// TODO
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
		'web-sharing-api' => 'System sharing',	// TODO
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Atencion !',
		'blank_to_disable' => 'Daissar void per desactivar',
		'by_author' => 'Per : ',
		'by_default' => 'Per defaut',
		'damn' => 'Zut !',
		'default_category' => 'Pas triat',
		'no' => 'Non',
		'not_applicable' => 'Pas disponible',
		'ok' => 'Òc-ben !',
		'or' => 'o',
		'yes' => 'Òc',
	),
	'stream' => array(
		'load_more' => 'Cargar mai d’articles',
		'mark_all_read' => 'O marcar tot coma legit',
		'nothing_to_load' => 'I a pas mai d’articles',
	),
);

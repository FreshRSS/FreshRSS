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
		'actualize' => 'Aktualizovat kanály',
		'add' => 'Přidat',
		'back_to_rss_feeds' => '← Jít zpět na vaše kanály RSS',
		'cancel' => 'Zrušit',
		'close' => 'Close',	// TODO
		'create' => 'Vytvořit',
		'delete_all_feeds' => 'Delete all feeds',	// TODO
		'delete_errored_feeds' => 'Delete feeds with errors',	// TODO
		'delete_muted_feeds' => 'Odstranění ztlumených zdrojů',
		'demote' => 'Snížit úroveň',
		'disable' => 'Zakázat',
		'download' => 'Download',	// TODO
		'empty' => 'Vyprázdnit',
		'enable' => 'Povolit',
		'export' => 'Exportovat',
		'filter' => 'Filtrovat',
		'import' => 'Importovat',
		'load_default_shortcuts' => 'Načíst výchozí zkratky',
		'manage' => 'Spravovat',
		'mark_read' => 'Označit jako přečtené',
		'menu' => array(
			'open' => 'Open menu',	// TODO
		),
		'nav_buttons' => array(
			'next' => 'Next article',	// TODO
			'prev' => 'Previous article',	// TODO
			'up' => 'Go up',	// TODO
		),
		'open_url' => 'Otevřít adresu URL',
		'promote' => 'Zvýšit úroveň',
		'purge' => 'Vymazat',
		'refresh_opml' => 'Aktualizovat OPML',
		'remove' => 'Odebrat',
		'rename' => 'Přejmenovat',
		'see_website' => 'Zobrazit webovou stránku',
		'submit' => 'Odeslat',
		'truncate' => 'Odstranit všechny články',
		'update' => 'Aktualizovat',
	),
	'auth' => array(
		'accept_tos' => 'Přijímám <a href="%s">Podmínky služby</a>.',
		'email' => 'E-mail',
		'keep_logged_in' => 'Zapamatovat přihlášení <small>(%s dní)</small>',
		'login' => 'Přihlásit se',
		'logout' => 'Odhlásit se',
		'password' => array(
			'_' => 'Heslo',
			'format' => '<small>Alespoň 7 znaků</small>',
		),
		'reauth' => array(
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
		),
		'registration' => array(
			'_' => 'Nový účet',
			'ask' => 'Vytvořit účet?',
			'title' => 'Vytvoření účtu',
		),
		'username' => array(
			'_' => 'Uživatelské jméno',
			'format' => '<small>Maximálně 16 alfanumerických znaků</small>',
		),
	),
	'date' => array(
		'Apr' => '\\D\\u\\b\\e\\n',
		'Aug' => '\\S\\r\\p\\e\\n',
		'Dec' => '\\P\\r\\o\\s\\i\\n\\e\\c',
		'Feb' => '\\Ú\\n\\o\\r',
		'Jan' => '\\L\\e\\d\\e\\n',
		'Jul' => '\\Č\\e\\r\\v\\e\\n\\e\\c',
		'Jun' => '\\Č\\e\\r\\v\\e\\n',
		'Mar' => '\\B\\ř\\e\\z\\e\\n',
		'May' => '\\K\\v\\ě\\t\\e\\n',
		'Nov' => '\\L\\i\\s\\t\\o\\p\\a\\d',
		'Oct' => '\\Ř\\í\\j\\e\\n',
		'Sep' => '\\Z\\á\\ř\\í',
		'apr' => 'dub',
		'april' => 'Duben',
		'aug' => 'srp',
		'august' => 'Srpen',
		'before_yesterday' => 'Předevčírem',
		'dec' => 'pro',
		'december' => 'Prosinec',
		'feb' => 'úno',
		'february' => 'Únor',
		'format_date' => 'j\\. %s Y',	// IGNORE
		'format_date_hour' => 'j\\. %s Y \\v H\\:i',	// IGNORE
		'fri' => 'Pá',
		'jan' => 'led',
		'january' => 'Leden',
		'jul' => 'čvn',
		'july' => 'Červenec',
		'jun' => 'čer',
		'june' => 'Červen',
		'last_2_year' => 'Poslední dva roky',
		'last_3_month' => 'Poslední tři měsíce',
		'last_3_year' => 'Poslední tři roky',
		'last_5_year' => 'Posledních pět let',
		'last_6_month' => 'Posledních šest měsíců',
		'last_month' => 'Poslední měsíc',
		'last_week' => 'Poslední týden',
		'last_year' => 'Poslední rok',
		'mar' => 'bře',
		'march' => 'Březen',
		'may' => 'Květen',
		'may_' => 'Kvě',
		'mon' => 'Po',
		'month' => 'měsíce',
		'nov' => 'lis',
		'november' => 'Listopad',
		'oct' => 'říj',
		'october' => 'Říjen',
		'sat' => 'So',
		'sep' => 'zář',
		'september' => 'Září',
		'sun' => 'Ne',
		'thu' => 'Čt',
		'today' => 'Dnes',
		'tue' => 'Út',
		'wed' => 'St',
		'yesterday' => 'Včera',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'O FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Prázdná kategorie',
		'confirm_action' => 'Opravdu chcete provést tuto akci? Toto nelze zrušit!',
		'confirm_action_feed_cat' => 'Opravdu chcete provést tuto akci? Přijdete o související oblíbené položky a uživatelské dotazy. Toto nelze zrušit!',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => 'Ve FreshRSS je %%d nových článků k přečtení.',
			'body_unread_articles' => '(nepřečtené: %%d)',
			'request_failed' => 'Požadavek selhal, to může být způsobeno problémy s připojení k internetu.',
			'title_new_articles' => 'FreshRSS: nové články!',
		),
		'labels_empty' => 'Žádné štítky',
		'new_article' => 'Jsou dostupné nové články, klikněte pro obnovení stránky.',
		'should_be_activated' => 'JavaScript musí být povolen',
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
		'about' => 'O aplikaci',
		'account' => 'Účet',
		'admin' => 'Administrace',
		'advanced_search' => 'Advanced Search',	// TODO
		'archiving' => 'Archivace',
		'authentication' => 'Ověřování',
		'check_install' => 'Kontrola instalace',
		'configuration' => 'Nastavení',
		'display' => 'Zobrazení',
		'extensions' => 'Rozšíření',
		'logs' => 'Protokoly',
		'privacy' => 'Privacy',	// TODO
		'queries' => 'Uživatelské dotazy',
		'reading' => 'Čtení',
		'search' => 'Hledat slova nebo #štítky',
		'search_help' => 'Podívejte se na dokumentaci pro pokročilé parametry <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">parametry vyhledávání</a>',
		'sharing' => 'Sdílení',
		'shortcuts' => 'Zkratky',
		'stats' => 'Statistika',
		'system' => 'Nastavení systému',
		'update' => 'Aktualizace',
		'user_management' => 'Správa uživatelů',
		'user_profile' => 'Profil',
	),
	'period' => array(
		'days' => 'dní',
		'hours' => 'hodin',
		'months' => 'měsíců',
		'weeks' => 'týdnů',
		'years' => 'let',
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
		'Known' => 'Známé základní stránky',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Schránka',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-mail',
		'email-webmail-firefox-fix' => 'E-mail (webmail - oprava pro Firefox)',
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
		'print' => 'Tisknout',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Sdílení systému',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Upozornění!',
		'blank_to_disable' => 'Ponechte prázdné pro zakázání',
		'by_author' => 'Od:',
		'by_default' => 'Výchozí',
		'damn' => 'Sakra!',
		'default_category' => 'Nezařazeno',
		'no' => 'Ne',
		'not_applicable' => 'Nedostupné',
		'ok' => 'Dobře!',
		'or' => 'nebo',
		'yes' => 'Ano',
	),
	'stream' => array(
		'load_more' => 'Načíst více článků',
		'mark_all_read' => 'Označit vše jako přečtené',
		'nothing_to_load' => 'Nejsou zde žádné další články',
	),
);

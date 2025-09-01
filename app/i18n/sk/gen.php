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
		'actualize' => 'Aktualizovať kanály',
		'add' => 'Pridať',
		'back_to_rss_feeds' => '← Späť na vaše RSS kanály',
		'cancel' => 'Zrušiť',
		'close' => 'Close',	// TODO
		'create' => 'Vytvoriť',
		'delete_all_feeds' => 'Delete all feeds',	// TODO
		'delete_errored_feeds' => 'Delete feeds with errors',	// TODO
		'delete_muted_feeds' => 'Vymazať stíšené kanály',
		'demote' => 'Degradovať',
		'disable' => 'Zakázať',
		'download' => 'Download',	// TODO
		'empty' => 'Vyprázdniť',
		'enable' => 'Povoliť',
		'export' => 'Exportovať',
		'filter' => 'Filtrovať',
		'import' => 'Importovať',
		'load_default_shortcuts' => 'Načítať prednastavené klávesové skratky',
		'manage' => 'Spravovať',
		'mark_read' => 'Označiť ako prečítané',
		'menu' => array(
			'open' => 'Open menu',	// TODO
		),
		'nav_buttons' => array(
			'next' => 'Next article',	// TODO
			'prev' => 'Previous article',	// TODO
			'up' => 'Go up',	// TODO
		),
		'open_url' => 'Otvoriť URL',
		'promote' => 'Podporiť',
		'purge' => 'Vymazať',
		'refresh_opml' => 'Obnoviť OPML',
		'remove' => 'Odstrániť',
		'rename' => 'Premenovať',
		'see_website' => 'Zobraziť webovú stránku',
		'submit' => 'Poslať',
		'truncate' => 'Vymazať všetky články',
		'update' => 'Aktualizovať',
	),
	'auth' => array(
		'accept_tos' => 'Prijímam <a href="%s">Podmienky služby</a>.',
		'email' => 'E-mailová adresa',
		'keep_logged_in' => 'Zostať prihlásený <small>(počet dní: %s)</small>',
		'login' => 'Prihlásiť',
		'logout' => 'Odhlásiť',
		'password' => array(
			'_' => 'Heslo',
			'format' => '<small>Najmenej 7 znakov</small>',
		),
		'reauth' => array(
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
		),
		'registration' => array(
			'_' => 'Nový účet',
			'ask' => 'Vytvoriť účet?',
			'title' => 'Vytvorenie účtu',
		),
		'username' => array(
			'_' => 'Používateľské meno',
			'format' => '<small>Maximálne 16 alfanumerických znakov</small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\í\\l',
		'Aug' => '\\A\\u\\g\\u\\s\\t',	// IGNORE
		'Dec' => '\\D\\e\\c\\e\\m\\b\\e\\r',	// IGNORE
		'Feb' => '\\F\\e\\b\\r\\u\\á\\r',
		'Jan' => '\\J\\a\\n\\u\\á\\r',
		'Jul' => '\\J\\ú\\l',
		'Jun' => '\\J\\ú\\n',
		'Mar' => '\\M\\a\\r\\e\\c',
		'May' => '\\M\\á\\j',
		'Nov' => '\\N\\o\\v\\e\\m\\b\\e\\r',	// IGNORE
		'Oct' => '\\O\\k\\t\\ó\\b\\e\\r',
		'Sep' => '\\S\\e\\p\\t\\e\\m\\b\\e\\r',	// IGNORE
		'apr' => 'Apr.',	// IGNORE
		'april' => 'Apríl',
		'aug' => 'Aug.',	// IGNORE
		'august' => 'August',	// IGNORE
		'before_yesterday' => 'Predvčerom',
		'dec' => 'Dec.',	// IGNORE
		'december' => 'December',	// IGNORE
		'feb' => 'Feb.',	// IGNORE
		'february' => 'Február',
		'format_date' => '%s j\\<\\s\\u\\p\\>S\\<\\/\\s\\u\\p\\> Y',	// IGNORE
		'format_date_hour' => '%s j\\<\\s\\u\\p\\>S\\<\\/\\s\\u\\p\\> Y \\a\\t H\\:i',	// IGNORE
		'fri' => 'Pi',
		'jan' => 'Jan.',	// IGNORE
		'january' => 'Január',
		'jul' => 'Júl',
		'july' => 'Júl',
		'jun' => 'Jún',
		'june' => 'Jún',
		'last_2_year' => 'Posledné 2 roky',
		'last_3_month' => 'Posledné 3 mesiace',
		'last_3_year' => 'Posledné 3 roky',
		'last_5_year' => 'Posledných 5 rokov',
		'last_6_month' => 'Posledných 6 mesiacov',
		'last_month' => 'Posledný mesiac',
		'last_week' => 'Posledný týždeň',
		'last_year' => 'Posledný rok',
		'mar' => 'Mar.',	// IGNORE
		'march' => 'Marec',
		'may' => 'Máj',
		'may_' => 'Máj',
		'mon' => 'Po',
		'month' => 'mesiace',
		'nov' => 'Nov.',	// IGNORE
		'november' => 'November',	// IGNORE
		'oct' => 'Okt.',
		'october' => 'Október',
		'sat' => 'So',
		'sep' => 'Sept.',	// IGNORE
		'september' => 'September',	// IGNORE
		'sun' => 'Ne',
		'thu' => 'Št',
		'today' => 'Dnes',
		'tue' => 'Ut',
		'wed' => 'St',
		'yesterday' => 'Včera',
	),
	'dir' => 'ltr',	// IGNORE
	'flag' => '🇸🇰',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'O FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Prázdna kategória',
		'confirm_action' => 'Určite chcete vykonať túto akciu? Zmeny budú nezvratné!',
		'confirm_action_feed_cat' => 'Určite chcete vykonať túto akciu? Prídete o súvisiace obľúbené a používateľské dopyty. Zmeny budú nezvratné!',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => 'Počet nových článkov v čítačke FreshRSS: %%d',
			'body_unread_articles' => '(neprečítané: %%d)',
			'request_failed' => 'Nepodarilo sa spracovať váš dopyt, pravdepodobne kvôli problému s pripojením do internetu.',
			'title_new_articles' => 'FreshRSS: nové články!',
		),
		'labels_empty' => 'Žiadne štítky',
		'new_article' => 'Našli sa nové články. Kliknite na obnovenie stránky.',
		'should_be_activated' => 'Musíte povoliť JavaScript',
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
		'about' => 'O FreshRSS',
		'account' => 'Konto',
		'admin' => 'Administrácia',
		'archiving' => 'Archivácia',
		'authentication' => 'Prihlásenie',
		'check_install' => 'Kontrola inštalácie',
		'configuration' => 'Nastavenia',
		'display' => 'Zobrazenie',
		'extensions' => 'Rozšírenia',
		'logs' => 'Záznamy',
		'privacy' => 'Privacy',	// TODO
		'queries' => 'Používateľské dopyty',
		'reading' => 'Čítanie',
		'search' => 'Hľadajte slová alebo #značky',
		'search_help' => 'See documentation for advanced <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">search parameters</a>',	// TODO
		'sharing' => 'Zdieľanie',
		'shortcuts' => 'Skratky',
		'stats' => 'Štatistiky',
		'system' => 'Nastavenie systému',
		'update' => 'Aktualizácia',
		'user_management' => 'Spravovať používateľov',
		'user_profile' => 'Profil',
	),
	'period' => array(
		'days' => 'dni',
		'hours' => 'hodiny',
		'months' => 'mesiace',
		'weeks' => 'týždne',
		'years' => 'roky',
	),
	'share' => array(
		'Known' => 'Stránky založené na Known',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Schránka',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-mail',	// IGNORE
		'email-webmail-firefox-fix' => 'Email (webmail - oprava pre Firefox)',
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
		'print' => 'Print',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Systémové zdieľanie',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Upozornenie!',
		'blank_to_disable' => 'Ak chcete zakázať, ponechajte prázdne',
		'by_author' => 'Od:',
		'by_default' => 'Prednastavené',
		'damn' => 'Sakra!',
		'default_category' => 'Bez kategórie',
		'no' => 'Nie',
		'not_applicable' => 'Nie je k dispozícii',
		'ok' => 'OK',
		'or' => 'alebo',
		'yes' => 'Áno',
	),
	'stream' => array(
		'load_more' => 'Načítať viac článkov',
		'mark_all_read' => 'Označiť všetko prečítané',
		'nothing_to_load' => 'Žiadne nové články',
	),
);

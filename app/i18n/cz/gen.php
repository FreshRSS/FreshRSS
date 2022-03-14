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
		'actualize' => 'Aktualizovat kanály',
		'add' => 'Přidat',
		'back' => '← Jít zpět',
		'back_to_rss_feeds' => '← Jít zpět na vaše kanály RSS',
		'cancel' => 'Zrušit',
		'create' => 'Vytvořit',
		'demote' => 'Snížit úroveň',
		'disable' => 'Zakázat',
		'empty' => 'Vyprázdnit',
		'enable' => 'Povolit',
		'export' => 'Exportovat',
		'filter' => 'Filtrovat',
		'import' => 'Importovat',
		'load_default_shortcuts' => 'Načíst výchozí zkratky',
		'manage' => 'Spravovat',
		'mark_read' => 'Označit jako přečtené',
		'open_url' => 'Open URL',	// TODO
		'promote' => 'Zvýšit úroveň',
		'purge' => 'Vymazat',
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
		'feedback' => array(
			'body_new_articles' => 'Ve FreshRSS je %%d nových článků k přečtení.',
			'body_unread_articles' => '(unread: %%d)',	// TODO
			'request_failed' => 'Požadavek selhal, to může být způsobeno problémy s připojení k internetu.',
			'title_new_articles' => 'FreshRSS: nové články!',
		),
		'new_article' => 'Jsou dostupné nové články, klikněte pro obnovení stránky.',
		'should_be_activated' => 'JavaScript musí být povolen',
	),
	'lang' => array(
		'cz' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'O aplikaci',
		'account' => 'Účet',
		'admin' => 'Administrace',
		'archiving' => 'Archivace',
		'authentication' => 'Ověřování',
		'check_install' => 'Kontrola instalace',
		'configuration' => 'Nastavení',
		'display' => 'Zobrazení',
		'extensions' => 'Rozšíření',
		'logs' => 'Protokoly',
		'queries' => 'Uživatelské dotazy',
		'reading' => 'Čtení',
		'search' => 'Hledat slova nebo #štítky',
		'sharing' => 'Sdílení',
		'shortcuts' => 'Zkratky',
		'stats' => 'Statistika',
		'system' => 'Nastavení systému',
		'update' => 'Aktualizace',
		'user_management' => 'Správa uživatelů',
		'user_profile' => 'Profil',
	),
	'pagination' => array(
		'first' => 'První',
		'last' => 'Poslední',
		'next' => 'Další',
		'previous' => 'Předchozí',
	),
	'period' => array(
		'days' => 'dní',
		'hours' => 'hodin',
		'months' => 'měsíců',
		'weeks' => 'týdnů',
		'years' => 'let',
	),
	'share' => array(
		'Known' => 'Známé základní stránky',
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Schránka',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-mail',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// TODO
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Tisknout',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// TODO
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'Wallabag v1',
		'wallabagv2' => 'Wallabag v2',
		'whatsapp' => 'Whatsapp',	// TODO
		'xing' => 'Xing',	// TODO
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

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
		'actualize' => 'Aktualizovat',
		'add' => 'Add',	// TODO
		'back' => '← Go back',	// TODO
		'back_to_rss_feeds' => '← Zpět na seznam RSS kanálů',
		'cancel' => 'Zrušit',
		'create' => 'Vytvořit',
		'demote' => 'Demote',	// TODO
		'disable' => 'Zakázat',
		'empty' => 'Vyprázdnit',
		'enable' => 'Povolit',
		'export' => 'Export',	// TODO
		'filter' => 'Filtrovat',
		'import' => 'Import',	// TODO
		'load_default_shortcuts' => 'Load default shortcuts',	// TODO
		'manage' => 'Spravovat',
		'mark_read' => 'Označit jako přečtené',
		'promote' => 'Promote',	// TODO
		'purge' => 'Purge',	// TODO
		'remove' => 'Odstranit',
		'rename' => 'Rename',	// TODO
		'see_website' => 'Navštívit WWW stránku',
		'submit' => 'Odeslat',
		'truncate' => 'Smazat všechny články',
		'update' => 'Update',	// TODO
	),
	'auth' => array(
		'accept_tos' => 'I accept the <a href="%s">Terms of Service</a>.',	// TODO
		'email' => 'Email',
		'keep_logged_in' => 'Zapamatovat přihlášení <small>(%s dny)</small>',
		'login' => 'Login',	// TODO
		'logout' => 'Odhlášení',
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
			'_' => 'Uživatel',
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
		'april' => 'Dub',
		'aug' => 'srp',
		'august' => 'Srp',
		'before_yesterday' => 'Předevčírem',
		'dec' => 'pro',
		'december' => 'Pro',
		'feb' => 'úno',
		'february' => 'Úno',
		'format_date' => 'j\\. %s Y',	// IGNORE
		'format_date_hour' => 'j\\. %s Y \\v H\\:i',	// IGNORE
		'fri' => 'Pá',
		'jan' => 'led',
		'january' => 'Led',
		'jul' => 'čvn',
		'july' => 'Čvn',
		'jun' => 'čer',
		'june' => 'Čer',
		'last_2_year' => 'Last two years',	// TODO
		'last_3_month' => 'Minulé tři měsíce',
		'last_3_year' => 'Last three years',	// TODO
		'last_5_year' => 'Last five years',	// TODO
		'last_6_month' => 'Minulých šest měsíců',
		'last_month' => 'Minulý měsíc',
		'last_week' => 'Minulý týden',
		'last_year' => 'Minulý rok',
		'mar' => 'bře',
		'march' => 'Bře',
		'may' => 'Květen',
		'may_' => 'Kvě',
		'mon' => 'Po',
		'month' => 'měsíce',
		'nov' => 'lis',
		'november' => 'Lis',
		'oct' => 'říj',
		'october' => 'Říj',
		'sat' => 'So',
		'sep' => 'zář',
		'september' => 'Zář',
		'sun' => 'Ne',
		'thu' => 'Čt',
		'today' => 'Dnes',
		'tue' => 'Út',
		'wed' => 'St',
		'yesterday' => 'Včera',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// TODO
		'about' => 'O FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Prázdná kategorie',
		'confirm_action' => 'Jste si jist, že chcete provést tuto akci? Změny nelze vrátit zpět!',
		'confirm_action_feed_cat' => 'Jste si jist, že chcete provést tuto akci? Přijdete o související oblíbené položky a uživatelské dotazy. Změny nelze vrátit zpět!',
		'feedback' => array(
			'body_new_articles' => 'Je %%d nových článků k přečtení v FreshRSS.',
			'request_failed' => 'Požadavek selhal, což může být způsobeno problémy s připojení k internetu.',
			'title_new_articles' => 'FreshRSS: nové články!',
		),
		'new_article' => 'Jsou k dispozici nové články, stránku obnovíte kliknutím zde.',
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
		'account' => 'Account',	// TODO
		'admin' => 'Administrace',
		'archiving' => 'Archivace',
		'authentication' => 'Přihlášení',
		'check_install' => 'Ověření instalace',
		'configuration' => 'Nastavení',
		'display' => 'Zobrazení',
		'extensions' => 'Rozšíření',
		'logs' => 'Logy',
		'queries' => 'Uživatelské dotazy',
		'reading' => 'Čtení',
		'search' => 'Hledat výraz nebo #tagy',
		'sharing' => 'Sdílení',
		'shortcuts' => 'Zkratky',
		'stats' => 'Statistika',
		'system' => 'System configuration',	// TODO
		'update' => 'Aktualizace',
		'user_management' => 'Správa uživatelů',
		'user_profile' => 'Profil',
	),
	'pagination' => array(
		'first' => 'První',
		'last' => 'Poslední',
		'load_more' => 'Načíst více článků',
		'mark_all_read' => 'Označit vše jako přečtené',
		'next' => 'Další',
		'nothing_to_load' => 'Žádné nové články',
		'previous' => 'Předchozí',
	),
	'period' => array(
		'days' => 'days',	// TODO
		'hours' => 'hours',	// TODO
		'months' => 'months',	// TODO
		'weeks' => 'weeks',	// TODO
		'years' => 'years',	// TODO
	),
	'share' => array(
		'Known' => 'Known based sites',	// TODO
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Clipboard',	// TODO
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// TODO
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Tisk',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
	),
	'short' => array(
		'attention' => 'Upozornění!',
		'blank_to_disable' => 'Zakázat - ponechte prázdné',
		'by_author' => 'Od:',
		'by_default' => 'Výchozí',
		'damn' => 'Sakra!',
		'default_category' => 'Nezařazeno',
		'no' => 'Ne',
		'not_applicable' => 'Not available',	// TODO
		'ok' => 'Okay!',	// TODO
		'or' => 'nebo',
		'yes' => 'Ano',
	),
);

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
		'actualize' => 'Feeds actualiseren',
		'add' => 'Toevoegen',
		'back' => '← Terug',
		'back_to_rss_feeds' => '← Ga terug naar je RSS feeds',
		'cancel' => 'Annuleren',
		'create' => 'Opslaan',
		'demote' => 'Degraderen',
		'disable' => 'Uitzetten',
		'empty' => 'Leeg',
		'enable' => 'Aanzetten',
		'export' => 'Exporteren',
		'filter' => 'Filteren',
		'import' => 'Importeren',
		'load_default_shortcuts' => 'Standaardshortcuts laden',
		'manage' => 'Beheren',
		'mark_read' => 'Markeer als gelezen',
		'promote' => 'Bevorderen',
		'purge' => 'Zuiveren',
		'remove' => 'Verwijderen',
		'rename' => 'Hernoemen',
		'see_website' => 'Bekijk website',
		'submit' => 'Opslaan',
		'truncate' => 'Verwijder alle artikelen',
		'update' => 'Updaten',
	),
	'auth' => array(
		'accept_tos' => 'Ik accepteer de <a href="%s">gebruiksvoorwaarden</a>.',
		'email' => 'Email adres',
		'keep_logged_in' => 'Ingelogd blijven voor <small>(%s dagen)</small>',
		'login' => 'Log in',
		'logout' => 'Log uit',
		'password' => array(
			'_' => 'Wachtwoord',
			'format' => '<small>Ten minste 7 tekens</small>',
		),
		'registration' => array(
			'_' => 'Nieuw account',
			'ask' => 'Maak een account?',
			'title' => 'Account maken',
		),
		'username' => array(
			'_' => 'Gebruikersnaam',
			'format' => '<small>Maximaal 16 alfanumerieke tekens</small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\i\\l',	// IGNORE
		'Aug' => '\\A\\u\\g\\u\\s\\t\\u\\s',
		'Dec' => '\\D\\e\\c\\e\\m\\b\\e\\r',	// IGNORE
		'Feb' => '\\F\\e\\b\\r\\u\\a\\r\\i',
		'Jan' => '\\J\\a\\n\\u\\a\\r\\i',
		'Jul' => '\\J\\u\\l\\i',
		'Jun' => '\\J\\u\\n\\i',
		'Mar' => '\\M\\a\\a\\r\\t',
		'May' => '\\M\\e\\i',
		'Nov' => '\\N\\o\\v\\e\\m\\b\\e\\r',	// IGNORE
		'Oct' => '\\O\\k\\t\\o\\b\\e\\r',
		'Sep' => '\\S\\e\\p\\t\\e\\m\\b\\e\\r',	// IGNORE
		'apr' => 'apr',
		'april' => 'Apr',
		'aug' => 'aug',
		'august' => 'Aug',
		'before_yesterday' => 'Ouder',
		'dec' => 'dec',
		'december' => 'Dec',
		'feb' => 'feb',
		'february' => 'Feb',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\o\\m H\\:i',	// IGNORE
		'fri' => 'Vr',
		'jan' => 'jan',
		'january' => 'Jan',
		'jul' => 'jul',
		'july' => 'Jul',
		'jun' => 'jun',
		'june' => 'Jun',
		'last_2_year' => 'Afgelopen twee jaar',
		'last_3_month' => 'Afgelopen drie maanden',
		'last_3_year' => 'Afgelopen drie jaar',
		'last_5_year' => 'Afgelopen vijf jaar',
		'last_6_month' => 'Afgelopen zes maanden',
		'last_month' => 'Vorige maand',
		'last_week' => 'Vorige week',
		'last_year' => 'Vorig jaar',
		'mar' => 'mrt',
		'march' => 'Mrt',
		'may' => 'Mei',
		'may_' => 'Mei',
		'mon' => 'Ma',
		'month' => 'maanden',
		'nov' => 'nov',
		'november' => 'Nov',
		'oct' => 'okt',
		'october' => 'Okt',
		'sat' => 'Za',
		'sep' => 'sep',
		'september' => 'Sep',
		'sun' => 'Zo',
		'thu' => 'Do',
		'today' => 'Vandaag',
		'tue' => 'Di',
		'wed' => 'Wo',
		'yesterday' => 'Gisteren',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Over FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Lege categorie',
		'confirm_action' => 'Weet u zeker dat u dit wilt doen? Het kan niet ongedaan worden gemaakt!',
		'confirm_action_feed_cat' => 'Weet u zeker dat u dit wilt doen? U verliest alle gereleteerde favorieten en gebruikers informatie. Het kan niet ongedaan worden gemaakt!',
		'feedback' => array(
			'body_new_articles' => 'Er zijn %%d nieuwe artikelen om te lezen op FreshRSS.',
			'request_failed' => 'Een opdracht is mislukt, mogelijk door Internet verbindings problemen.',
			'title_new_articles' => 'FreshRSS: nieuwe artikelen!',
		),
		'new_article' => 'Er zijn nieuwe artikelen beschikbaar. Klik om de pagina te vernieuwen.',
		'should_be_activated' => 'JavaScript moet aanstaan',
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
		'about' => 'Over',
		'account' => 'Account',	// IGNORE
		'admin' => 'Administratie',
		'archiving' => 'Archiveren',
		'authentication' => 'Authenticatie',
		'check_install' => 'Installatiecontrole',
		'configuration' => 'Configuratie',
		'display' => 'Opmaak',
		'extensions' => 'Uitbreidingen',
		'logs' => 'Log boeken',
		'queries' => 'Gebruikers informatie',
		'reading' => 'Lezen',
		'search' => 'Zoek woorden of #labels',
		'sharing' => 'Delen',
		'shortcuts' => 'Snelle toegang',
		'stats' => 'Statistieken',
		'system' => 'Systeemconfiguratie',
		'update' => 'Versiecontrole',
		'user_management' => 'Gebruikersbeheer',
		'user_profile' => 'Profiel',
	),
	'pagination' => array(
		'first' => 'Eerste',
		'last' => 'Laatste',
		'load_more' => 'Laad meer artikelen',
		'mark_all_read' => 'Markeer alle als gelezen',
		'next' => 'Volgende',
		'nothing_to_load' => 'Er zijn geen artikelen meer',
		'previous' => 'Vorige',
	),
	'period' => array(
		'days' => 'dagen',
		'hours' => 'uren',
		'months' => 'maanden',
		'weeks' => 'weken',
		'years' => 'jaren',
	),
	'share' => array(
		'Known' => 'Known-gebaseerde sites',
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Klembord',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Print',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
	),
	'short' => array(
		'attention' => 'Attentie!',
		'blank_to_disable' => 'Laat leeg om uit te zetten',
		'by_author' => 'Door:',
		'by_default' => 'Door standaard',
		'damn' => 'Potverdorie!',
		'default_category' => 'Niet ingedeeld',
		'no' => 'Nee',
		'not_applicable' => 'Niet aanwezig',
		'ok' => 'Ok!',	// IGNORE
		'or' => 'of',
		'yes' => 'Ja',
	),
);

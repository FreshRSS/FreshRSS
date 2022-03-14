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
		'actualize' => 'Feeds aktualisieren',
		'add' => 'Hinzufügen',
		'back' => '← Zurück',
		'back_to_rss_feeds' => '← Zurück zu Ihren RSS-Feeds gehen',
		'cancel' => 'Abbrechen',
		'create' => 'Erstellen',
		'demote' => 'Zurückstufen',
		'disable' => 'Deaktivieren',
		'empty' => 'Leeren',
		'enable' => 'Aktivieren',
		'export' => 'Exportieren',
		'filter' => 'Filtern',
		'import' => 'Importieren',
		'load_default_shortcuts' => 'Standard-Kürzel laden',
		'manage' => 'Verwalten',
		'mark_read' => 'Als gelesen markieren',
		'open_url' => 'URL öffnen',
		'promote' => 'Hochstufen',
		'purge' => 'Bereinigen',
		'remove' => 'Entfernen',
		'rename' => 'Umbenennen',
		'see_website' => 'Website ansehen',
		'submit' => 'Speichern',
		'truncate' => 'Alle Artikel löschen',
		'update' => 'Aktualisieren',
	),
	'auth' => array(
		'accept_tos' => 'Ich akzeptiere die <a href="%s">Nutzungsbedingungen</a>.',
		'email' => 'E-Mail-Adresse',
		'keep_logged_in' => 'Eingeloggt bleiben <small>(%s Tage)</small>',
		'login' => 'Anmelden',
		'logout' => 'Abmelden',
		'password' => array(
			'_' => 'Passwort',
			'format' => '<small>mindestens 7 Zeichen</small>',
		),
		'registration' => array(
			'_' => 'Neuer Account',
			'ask' => 'Erstelle einen Account?',
			'title' => 'Accounterstellung',
		),
		'username' => array(
			'_' => 'Nutzername',
			'format' => '<small>Maximal 16 alphanumerische Zeichen</small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\i\\l',	// IGNORE
		'Aug' => '\\A\\u\\g\\u\\s\\t',	// IGNORE
		'Dec' => '\\D\\e\\z\\e\\m\\b\\e\\r',
		'Feb' => '\\F\\e\\b\\r\\u\\a\\r',
		'Jan' => '\\J\\a\\n\\u\\a\\r',
		'Jul' => '\\J\\u\\l\\i',
		'Jun' => '\\J\\u\\n\\i',
		'Mar' => '\\M\\ä\\r\\z',
		'May' => '\\M\\a\\i',
		'Nov' => '\\N\\o\\v\\e\\m\\b\\e\\r',	// IGNORE
		'Oct' => '\\O\\k\\t\\o\\b\\e\\r',
		'Sep' => '\\S\\e\\p\\t\\e\\m\\b\\e\\r',	// IGNORE
		'apr' => 'Apr',
		'april' => 'April',	// IGNORE
		'aug' => 'Aug',
		'august' => 'August',	// IGNORE
		'before_yesterday' => 'Ältere Beiträge',
		'dec' => 'Dez',
		'december' => 'Dezember',
		'feb' => 'Feb',
		'february' => 'Februar',
		'format_date' => 'd\\. %s Y',
		'format_date_hour' => 'd\\. %s Y \\u\\m H\\:i',
		'fri' => 'Fr',
		'jan' => 'Jan',
		'january' => 'Januar',
		'jul' => 'Jul',
		'july' => 'Juli',
		'jun' => 'Jun',
		'june' => 'Juni',
		'last_2_year' => 'Letzte 2 Jahre',
		'last_3_month' => 'Letzte 3 Monate',
		'last_3_year' => 'Letzte 3 Jahre',
		'last_5_year' => 'Letzte 5 Jahre',
		'last_6_month' => 'Letzte 6 Monate',
		'last_month' => 'Letzter Monat',
		'last_week' => 'Letzte Woche',
		'last_year' => 'Letztes Jahr',
		'mar' => 'Mär',
		'march' => 'März',
		'may' => 'Mai',
		'may_' => 'Mai',
		'mon' => 'Mo',
		'month' => 'Monat(en)',
		'nov' => 'Nov',
		'november' => 'November',	// IGNORE
		'oct' => 'Okt',
		'october' => 'Oktober',
		'sat' => 'Sa',
		'sep' => 'Sep',
		'september' => 'September',	// IGNORE
		'sun' => 'So',
		'thu' => 'Do',
		'today' => 'Heute',
		'tue' => 'Di',
		'wed' => 'Mi',
		'yesterday' => 'Gestern',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Über FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Kategorie leeren',
		'confirm_action' => 'Sind Sie sicher, dass Sie diese Aktion durchführen wollen? Diese Aktion kann nicht abgebrochen werden!',
		'confirm_action_feed_cat' => 'Sind Sie sicher, dass Sie diese Aktion durchführen wollen? Sie werden zugehörige Favoriten und Benutzerabfragen verlieren. Dies kann nicht abgebrochen werden!',
		'feedback' => array(
			'body_new_articles' => 'Es gibt %%d neue Artikel zum Lesen auf FreshRSS.',
			'body_unread_articles' => '(Ungelesen: %%d)',
			'request_failed' => 'Eine Anfrage ist fehlgeschlagen, dies könnte durch Probleme mit der Internetverbindung verursacht worden sein.',
			'title_new_articles' => 'FreshRSS: neue Artikel!',
		),
		'new_article' => 'Es gibt neue verfügbare Artikel. Klicken Sie, um die Seite zu aktualisieren.',
		'should_be_activated' => 'JavaScript muss aktiviert sein',
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
		'about' => 'Über',
		'account' => 'Account',	// IGNORE
		'admin' => 'Administration',	// IGNORE
		'archiving' => 'Archivierung',
		'authentication' => 'Authentifizierung',
		'check_install' => 'Installationsüberprüfung',
		'configuration' => 'Konfiguration',
		'display' => 'Anzeige',
		'extensions' => 'Erweiterungen',
		'logs' => 'Protokolle',
		'queries' => 'Benutzerabfragen',
		'reading' => 'Lesen',
		'search' => 'Suche Worte oder #Tags',
		'sharing' => 'Teilen',
		'shortcuts' => 'Tastaturkürzel',
		'stats' => 'Statistiken',
		'system' => 'Systemeinstellungen',
		'update' => 'Aktualisieren',
		'user_management' => 'Benutzer verwalten',
		'user_profile' => 'Profil',
	),
	'pagination' => array(
		'first' => 'Erste',
		'last' => 'Letzte',
		'next' => 'Nächste',
		'previous' => 'Vorherige',
	),
	'period' => array(
		'days' => 'Tage',
		'hours' => 'Stunden',
		'months' => 'Monate',
		'weeks' => 'Wochen',
		'years' => 'Jahre',
	),
	'share' => array(
		'Known' => 'Known-Seite (https://withknown.com)',
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Zwischenablage',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-Mail',
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
		'print' => 'Drucken',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// TODO
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'whatsapp' => 'Whatsapp',	// TODO
		'xing' => 'Xing',	// TODO
	),
	'short' => array(
		'attention' => 'Achtung!',
		'blank_to_disable' => 'Zum Deaktivieren frei lassen',
		'by_author' => 'Von:',
		'by_default' => 'standardmäßig',
		'damn' => 'Verdammt!',
		'default_category' => 'Unkategorisiert',
		'no' => 'Nein',
		'not_applicable' => 'Nicht verfügbar',
		'ok' => 'OK!',
		'or' => 'oder',
		'yes' => 'Ja',
	),
	'stream' => array(
		'load_more' => 'Weitere Artikel laden',
		'mark_all_read' => 'Alle als gelesen markieren',
		'nothing_to_load' => 'Es gibt keine weiteren Artikel',
	),
);

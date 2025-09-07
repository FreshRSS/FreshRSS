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
		'back_to_rss_feeds' => '← Zurück zu Ihren RSS-Feeds gehen',
		'cancel' => 'Abbrechen',
		'close' => 'Schließen',
		'create' => 'Erstellen',
		'delete_all_feeds' => 'Alle Feeds löschen',
		'delete_errored_feeds' => 'Feeds mit Fehlern löschen',
		'delete_muted_feeds' => 'Lösche stumm gestellte Feeds',
		'demote' => 'Zurückstufen',
		'disable' => 'Deaktivieren',
		'download' => 'Download',	// IGNORE
		'empty' => 'Leeren',
		'enable' => 'Aktivieren',
		'export' => 'Exportieren',
		'filter' => 'Filtern',
		'import' => 'Importieren',
		'load_default_shortcuts' => 'Standard-Kürzel laden',
		'manage' => 'Verwalten',
		'mark_read' => 'Als gelesen markieren',
		'menu' => array(
			'open' => 'Menü öffnen',
		),
		'nav_buttons' => array(
			'next' => 'Nächster Artikel',
			'prev' => 'Vorheriger Artikel',
			'up' => 'Nach oben',
		),
		'open_url' => 'URL öffnen',
		'promote' => 'Hochstufen',
		'purge' => 'Bereinigen',
		'refresh_opml' => 'OPML erneut laden',
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
		'reauth' => array(
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
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
	'flag' => '🇩🇪',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Über FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Kategorie leeren',
		'confirm_action' => 'Sind Sie sicher, dass Sie diese Aktion durchführen wollen? Diese Aktion kann nicht abgebrochen werden!',
		'confirm_action_feed_cat' => 'Sind Sie sicher, dass Sie diese Aktion durchführen wollen? Sie werden zugehörige Favoriten und Benutzerabfragen verlieren. Dies kann nicht abgebrochen werden!',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => 'Es gibt %%d neue Artikel zum Lesen auf FreshRSS.',
			'body_unread_articles' => '(Ungelesen: %%d)',
			'request_failed' => 'Eine Anfrage ist fehlgeschlagen, dies könnte durch Probleme mit der Internetverbindung verursacht worden sein.',
			'title_new_articles' => 'FreshRSS: neue Artikel!',
		),
		'labels_empty' => 'Keine Labels',
		'new_article' => 'Es gibt neue verfügbare Artikel. Klicken Sie, um die Seite zu aktualisieren.',
		'should_be_activated' => 'JavaScript muss aktiviert sein',
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
		'about' => 'Info',
		'account' => 'Account',	// IGNORE
		'admin' => 'Administration',	// IGNORE
		'archiving' => 'Archivierung',
		'authentication' => 'Authentifizierung',
		'check_install' => 'Installationsüberprüfung',
		'configuration' => 'Konfiguration',
		'display' => 'Anzeige',
		'extensions' => 'Erweiterungen',
		'logs' => 'Protokolle',
		'privacy' => 'Privatsphäre',
		'queries' => 'Benutzerabfragen',
		'reading' => 'Lesen',
		'search' => 'Suche Worte oder #Tags',
		'search_help' => 'Siehe Dokumentation zu den <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">Suchparametern</a>',
		'sharing' => 'Teilen',
		'shortcuts' => 'Tastaturkürzel',
		'stats' => 'Statistiken',
		'system' => 'Systemeinstellungen',
		'update' => 'Aktualisieren',
		'user_management' => 'Benutzer verwalten',
		'user_profile' => 'Profil',
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
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Zwischenablage',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-Mail',
		'email-webmail-firefox-fix' => 'E-Mail (Webmail - Fix für Firefox)',
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
		'print' => 'Drucken',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Teilen (Systemstandard)',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
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

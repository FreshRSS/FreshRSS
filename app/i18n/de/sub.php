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
	'api' => array(
		'documentation' => 'Kopieren Sie die folgende URL, um sie in einem externen Tool zu verwenden.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Ziehen Sie diese Schaltfläche auf Ihre Lesezeichen-Symbolleiste oder klicken Sie mit der rechten Maustaste darauf und wählen Sie "Als Lesezeichen hinzufügen". Klicken Sie dann auf einer beliebigen Seite, die Sie abonnieren möchten, auf die Schaltfläche "Abonnieren".',
		'label' => 'Abonnieren',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Kategorie',
		'add' => 'Kategorie hinzufügen',
		'archiving' => 'Archivierung',
		'empty' => 'Leere Kategorie',
		'information' => 'Information',	// IGNORE
		'position' => 'Reihenfolge',
		'position_help' => 'Steuert die Kategoriesortierung',
		'title' => 'Titel',
	),
	'feed' => array(
		'add' => 'Einen RSS-Feed hinzufügen',
		'advanced' => 'Erweitert',
		'archiving' => 'Archivierung',
		'auth' => array(
			'configuration' => 'Anmelden',
			'help' => 'Die Verbindung erlaubt Zugriff auf HTTP-geschützte RSS-Feeds',
			'http' => 'HTTP-Authentifizierung',
			'password' => 'HTTP-Passwort',
			'username' => 'HTTP-Nutzername',
		),
		'clear_cache' => 'Nicht cachen (für defekte Feeds)',
		'content_action' => array(
			'_' => 'Behandlung von Feed-Inhalt beim Herunterladen von Artikelinhalt',
			'append' => 'Artikelinhalt nach Feed-Inhalt hinzufügen',
			'prepend' => 'Artikelinhalt vor Feed-Inhalt hinzufügen',
			'replace' => 'Artikelinhalt ersetzt Feed-Inhalt (Standard)',
		),
		'css_cookie' => 'Verwende Cookies beim Herunterladen des Feed-Inhalts mit CSS-Filtern',
		'css_cookie_help' => 'Beispiel: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Ruft bei gekürzten RSS-Feeds den vollständigen Artikelinhalt ab (Achtung, benötigt mehr Zeit!)',
		'css_path' => 'CSS-Selektor des Artikelinhaltes auf der Original-Webseite',
		'description' => 'Beschreibung',
		'empty' => 'Dieser Feed ist leer. Bitte stellen Sie sicher, dass er noch gepflegt wird.',
		'error' => 'Dieser Feed ist auf ein Problem gestoßen. Bitte stellen Sie sicher, dass er immer lesbar ist und aktualisieren Sie ihn dann.',
		'filteractions' => array(
			'_' => 'Filteraktionen',
			'help' => 'Ein Suchfilter pro Zeile',
		),
		'information' => 'Information',	// IGNORE
		'keep_min' => 'Minimale Anzahl an Artikeln, die behalten wird',
		'maintenance' => array(
			'clear_cache' => 'Zwischenspeicher leeren',
			'clear_cache_help' => 'Zwischenspeicher für diesen Feed leeren.',
			'reload_articles' => 'Artikel neuladen',
			'reload_articles_help' => 'Artikel neuladen und komplette Inhalte holen, wenn ein Selektor festgelegt wurde.',
			'title' => 'Wartung',
		),
		'moved_category_deleted' => 'Wenn Sie eine Kategorie entfernen, werden deren Feeds automatisch in die Kategorie <em>%s</em> eingefügt.',
		'mute' => 'Stumm schalten',
		'no_selected' => 'Kein Feed ausgewählt.',
		'number_entries' => '%d Artikel',
		'priority' => array(
			'_' => 'Sichtbarkeit',
			'archived' => 'Nicht anzeigen (archiviert)',
			'main_stream' => 'In Haupt-Feeds zeigen',
			'normal' => 'Zeige in eigener Kategorie',
		),
		'proxy' => 'Verwende einen Proxy, um den Feed abzuholen',
		'proxy_help' => 'Wähle ein Protokoll (z.B. SOCKS5) und einen Proxy mit Port (z.B. <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Quellcode anzeigen',
			'show_rendered' => 'Inhalt anzeigen',
		),
		'show' => array(
			'all' => 'Alle Feeds zeigen',
			'error' => 'Nur Feeds mit Fehlern zeigen',
		),
		'showing' => array(
			'error' => 'Nur Feeds mit Fehlern zeigen',
		),
		'ssl_verify' => 'Überprüfe SSL Sicherheit',
		'stats' => 'Statistiken',
		'think_to_add' => 'Sie können Feeds hinzufügen.',
		'timeout' => 'Zeitlimit in Sekunden',
		'title' => 'Titel',
		'title_add' => 'Einen RSS-Feed hinzufügen',
		'ttl' => 'Aktualisiere automatisch nicht öfter als',
		'url' => 'Feed-URL',
		'useragent' => 'Browser User Agent für den Abruf des Feeds verwenden',
		'useragent_help' => 'Beispiel: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Überprüfen Sie die Gültigkeit des Feeds',
		'website' => 'Webseiten-URL',
		'websub' => 'Sofortbenachrichtigung mit WebSub',
	),
	'import_export' => array(
		'export' => 'Exportieren',
		'export_labelled' => 'Artikel mit Labeln exportieren',
		'export_opml' => 'Liste der Feeds exportieren (OPML)',
		'export_starred' => 'Ihre Favoriten exportieren',
		'feed_list' => 'Liste von %s Artikeln',
		'file_to_import' => 'Zu importierende Datei<br />(OPML, JSON oder ZIP)',
		'file_to_import_no_zip' => 'Zu importierende Datei<br />(OPML oder JSON)',
		'import' => 'Importieren',
		'starred_list' => 'Liste der Lieblingsartikel',
		'title' => 'Importieren / Exportieren',
	),
	'menu' => array(
		'add' => 'Feed oder Kategorie hinzufügen',
		'import_export' => 'Importieren / Exportieren',
		'label_management' => 'Labelverwaltung',
		'stats' => array(
			'idle' => 'Inaktive Feeds',
			'main' => 'Haupt-Statistiken',
			'repartition' => 'Artikel-Verteilung',
		),
		'subscription_management' => 'Abonnementverwaltung',
		'subscription_tools' => 'Abonnement-Tools',
	),
	'tag' => array(
		'name' => 'Name',	// IGNORE
		'new_name' => 'Neuer Name',
		'old_name' => 'Alter Name',
	),
	'title' => array(
		'_' => 'Abonnementverwaltung',
		'add' => 'Feed oder Kategorie hinzufügen',
		'add_category' => 'Kategorie hinzufügen',
		'add_feed' => 'Feed hinzufügen',
		'add_label' => 'Label hinzufügen',
		'delete_label' => 'Label löschen',
		'feed_management' => 'Verwaltung der RSS-Feeds',
		'rename_label' => 'Label umbenennen',
		'subscription_tools' => 'Abonnement-Tools',
	),
);

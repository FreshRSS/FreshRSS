<?php

return array(
	'add' => 'Feed and category creation has been moved <a href=\'%s\'>here</a>. It is also accessible from the menu on the left and from the ✚ icon available on the main page.',	// TODO - Translation
	'api' => array(
		'documentation' => 'Kopieren Sie die folgende URL, um sie in einem externen Tool zu verwenden.',
		'title' => 'API',	// TODO - Translation
	),
	'bookmarklet' => array(
		'documentation' => 'Ziehen Sie diese Schaltfläche auf Ihre Lesezeichen-Symbolleiste oder klicken Sie mit der rechten Maustaste darauf und wählen Sie "Als Lesezeichen hinzufügen". Klicken Sie dann auf einer beliebigen Seite, die Sie abonnieren möchten, auf die Schaltfläche "Abonnieren".',
		'label' => 'Abonnieren',
		'title' => 'Bookmarklet',	// TODO - Translation
	),
	'category' => array(
		'_' => 'Kategorie',
		'add' => 'Eine Kategorie hinzufügen',
		'archiving' => 'Archivierung',
		'empty' => 'Leere Kategorie',
		'information' => 'Information',	// TODO - Translation
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
		'css_help' => 'Ruft gekürzte RSS-Feeds ab (Achtung, benötigt mehr Zeit!)',
		'css_path' => 'Pfad zur CSS-Datei des Artikels auf der Original-Webseite',
		'description' => 'Beschreibung',
		'empty' => 'Dieser Feed ist leer. Bitte stellen Sie sicher, dass er noch gepflegt wird.',
		'error' => 'Dieser Feed ist auf ein Problem gestoßen. Bitte stellen Sie sicher, dass er immer lesbar ist und aktualisieren Sie ihn dann.',
		'filteractions' => array(
			'_' => 'Filteraktionen',
			'help' => 'Ein Suchfilter pro Zeile',
		),
		'information' => 'Information',	// TODO - Translation
		'keep_min' => 'Minimale Anzahl an Artikeln, die behalten wird',
		'maintenance' => array(
			'clear_cache' => 'Clear cache',	// TODO - Translation
			'clear_cache_help' => 'Clear the cache for this feed.',	// TODO - Translation
			'reload_articles' => 'Reload articles',	// TODO - Translation
			'reload_articles_help' => 'Reload articles and fetch complete content if a selector is defined.',	// TODO - Translation
			'title' => 'Maintenance',	// TODO - Translation
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
		'selector_preview' => array(
			'show_raw' => 'Show source code',	// TODO - Translation
			'show_rendered' => 'Show content',	// TODO - Translation
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
		'validator' => 'Überprüfen Sie die Gültigkeit des Feeds',
		'website' => 'Webseiten-URL',
		'websub' => 'Sofortbenachrichtigung mit WebSub',
	),
	'firefox' => array(
		'documentation' => 'Folge den <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">hier</a> beschriebenen Schritten um FreshRSS zu Deiner Firefox RSS-Reader Liste hinzuzufügen.',
		'obsolete_63' => 'Seit Version 63 hat Firefox die Möglichkeit entfernt, Dienste hinzuzufügen, die keine eigenständigen Anwendungen sind.',
		'title' => 'Firefox RSS-Reader',
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
		'add' => 'Add a feed/a category',	// TODO - Translation
		'add_feed' => 'Add a feed',	// TODO - Translation
		'bookmark' => 'Abonnieren (FreshRSS-Lesezeichen)',
		'import_export' => 'Importieren / Exportieren',
		'subscription_management' => 'Abonnementverwaltung',
		'subscription_tools' => 'Abonnement-Tools',
	),
	'title' => array(
		'_' => 'Abonnementverwaltung',
		'add' => 'Add a feed/a category',	// TODO - Translation
		'add_category' => 'Add a category',	// TODO - Translation
		'add_feed' => 'Add a feed',	// TODO - Translation
		'feed_management' => 'Verwaltung der RSS-Feeds',
		'subscription_tools' => 'Abonnement-Tools',
	),
);

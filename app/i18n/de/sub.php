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
		'documentation' => 'Ziehen Sie diese Schaltfläche auf Ihre Lesezeichen-Symbolleiste oder klicken Sie mit der rechten Maustaste darauf und wählen Sie „Als Lesezeichen hinzufügen“. Klicken Sie dann auf einer beliebigen Seite, die Sie abonnieren möchten, auf die Schaltfläche „Abonnieren“.',
		'label' => 'Abonnieren',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Kategorie',
		'add' => 'Kategorie hinzufügen',
		'archiving' => 'Archivierung',
		'dynamic_opml' => array(
			'_' => 'Dynamisches OPML',
			'help' => 'URL zu einer <a href="http://opml.org/" target="_blank">OPML Datei</a>, um die Kategorie dynamisch mit Feeds zu befüllen',
		),
		'empty' => 'Leere Kategorie',
		'information' => 'Information',	// IGNORE
		'opml_url' => 'OPML-Datei URL',
		'position' => 'Reihenfolge',
		'position_help' => 'Steuert die Kategoriesortierung',
		'title' => 'Titel',
	),
	'feed' => array(
		'accept_cookies' => 'Cookies zulassen',
		'accept_cookies_help' => 'Erlaubt dem Feed-Server das Setzen von Cookies (wird nur für die Dauer der Anfrage im Speicher gehalten)',
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
		'css_path_filter' => array(
			'_' => 'CSS-Selector für die Elemente, die entfernt werden sollen',
			'help' => 'CSS-Selector könnte eine Liste sein, wie z.B.: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Beschreibung',
		'empty' => 'Dieser Feed ist leer. Bitte stellen Sie sicher, dass er noch gepflegt wird.',
		'error' => 'Dieser Feed ist auf ein Problem gestoßen. Bitte stellen Sie sicher, dass er immer lesbar ist und aktualisieren Sie ihn dann.',
		'filteractions' => array(
			'_' => 'Filteraktionen',
			'help' => 'Ein Suchfilter pro Zeile. Operatoren <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">siehe Dokumentation</a>.',
		),
		'information' => 'Information',	// IGNORE
		'keep_min' => 'Minimale Anzahl an Artikeln, die behalten wird',
		'kind' => array(
			'_' => 'Art der Feed-Quelle',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Webseite scannen)',
				'feed_title' => array(
					'_' => 'Feed Title',
					'help' => 'Beispiel: <code>//title</code> oder ein statischer Text: <code>"Mein eigener Feed"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> ist eine standardisierte Query-Sprache für fortgeschrittene Nutzer und wird von FreshRSS genutzt, um die Webseite abzuscannen.',
				'item' => array(
					'_' => 'News <strong>Artikel</strong> finden<br /><small>(Sehr wichtig)</small>',
					'help' => 'Beispiel: <code>//div[@class="news-artikel"]</code>',
				),
				'item_author' => array(
					'_' => 'Artikel-Autor:in',
					'help' => 'Kann auch ein statischer Text sein: <code>"Unbekannt"</code>',
				),
				'item_categories' => 'Artikel-(Hash)Tags',
				'item_content' => array(
					'_' => 'Artikelinhalt',
					'help' => 'Beispiel, um den vollen Artikel zu nehmen: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'Artikel-Vorschaubild',
					'help' => 'Beispiel: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Benutzerdefiniertes Datum/Zeit-Format',
					'help' => 'Optional. Ein Format unterstützt von <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, wie zum Beispiel <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'Artikel-Datum',
					'help' => 'Das Ergebnis wird durch <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a> geparst',
				),
				'item_title' => array(
					'_' => 'Artikel-Titel',
					'help' => 'Insbesondere <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> nutzen, wie z.B. <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'Eindeutige ID des Artikels',
					'help' => 'Optional. Beispiel: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'Link zum Artikel (URL)',
					'help' => 'Beispiel: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (relativ zum Artikel) für:',
				'xpath' => 'XPath für:',
			),
			'rss' => 'RSS / Atom (Standard)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Zwischenspeicher leeren',
			'clear_cache_help' => 'Zwischenspeicher für diesen Feed leeren.',
			'reload_articles' => 'Artikel neuladen',
			'reload_articles_help' => 'Artikel neuladen und kompletten Inhalt laden, wenn ein Selektor festgelegt wurde.',
			'title' => 'Wartung',
		),
		'max_http_redir' => 'Max HTTP Umleitungen',
		'max_http_redir_help' => '0 oder leeres Feld = deaktiviert; -1 für unendlich viele Umleitungen',
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
		'add_dynamic_opml' => 'dynamisches OPML hinzufügen',
		'add_feed' => 'Feed hinzufügen',
		'add_label' => 'Label hinzufügen',
		'delete_label' => 'Label löschen',
		'feed_management' => 'Verwaltung der RSS-Feeds',
		'rename_label' => 'Label umbenennen',
		'subscription_tools' => 'Abonnement-Tools',
	),
);

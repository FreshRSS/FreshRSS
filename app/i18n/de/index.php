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
	'about' => array(
		'_' => 'Info',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Systemumgebung',
				'browser' => 'Browser',	// IGNORE
				'database' => 'Datenbank',
				'server_software' => 'Serversoftware',
				'version_curl' => 'cURL-Version',
				'version_frss' => 'FreshRSS-Version',
				'version_php' => 'PHP-Version',
			),
		),
		'bugs_reports' => 'Fehlerberichte',
		'documentation' => 'Dokumentation',
		'freshrss_description' => 'FreshRSS ist ein selbst hostbarer RSS-Aggregator und -Reader. Damit können Sie mehrere Nachrichten-Websites auf einen Blick lesen und verfolgen, ohne von einer Website zur nächsten wechseln zu müssen. FreshRSS ist leichtgewichtig, konfigurierbar und benutzerfreundlich.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">auf GitHub</a>',
		'license' => 'Lizenz',
		'project_website' => 'Projekt-Website',
		'title' => 'Info',
		'version' => 'Version',	// IGNORE
	),
	'feed' => array(
		'empty' => 'Keine Artikel vorhanden.',
		'published' => array(
			'_' => 'Veröffentlicht',
			'future' => 'In Zukunft veröffentlicht',
			'today' => 'Heute veröffentlicht',
			'yesterday' => 'Gestern veröffentlicht',
		),
		'received' => array(
			'_' => 'Empfangen',
			'today' => 'Heute empfangen',
			'yesterday' => 'Gestern empfangen',
		),
		'rss_of' => 'RSS-Feed von %s',
		'title' => 'Haupt-Feeds',
		'title_fav' => 'Favoriten',
		'title_global' => 'Globale Ansicht',
		'userModified' => array(
			'_' => 'Vom Benutzer geändert',
			'today' => 'Heute vom Benutzer geändert',
			'yesterday' => 'Gestern vom Benutzer geändert',
		),
	),
	'log' => array(
		'_' => 'Protokolle',
		'clear' => 'Protokolle leeren',
		'empty' => 'Protokolldatei ist leer.',
		'title' => 'Protokolle',
	),
	'menu' => array(
		'about' => 'Über FreshRSS',
		'before_one_day' => 'Vor einem Tag',
		'before_one_week' => 'Vor einer Woche',
		'bookmark_query' => 'Aktuelle Abfrage speichern',
		'favorites' => 'Favoriten (%s)',
		'global_view' => 'Globale Ansicht',
		'important' => 'Wichtige Feeds',
		'main_stream' => 'Haupt-Feeds',
		'mark_all_read' => 'Alle als gelesen markieren',
		'mark_cat_read' => 'Kategorie als gelesen markieren',
		'mark_feed_read' => 'Feed als gelesen markieren',
		'mark_selection_unread' => 'Auswahl als ungelesen markieren',
		'mylabels' => 'Meine Labels',
		'non-starred' => 'Nicht-Favoriten zeigen',
		'normal_view' => 'Normale Ansicht',
		'queries' => 'Benutzerabfragen',
		'read' => 'Gelesene zeigen',
		'reader_view' => 'Lese-Ansicht',
		'rss_view' => 'RSS-Feed',
		'search_short' => 'Suchen',
		'sort' => array(
			'asc' => 'Aufsteigend',
			'c' => array(
				'name_asc' => 'Kategorie, Feed-Titel A→Z',
				'name_desc' => 'Kategorie, Feed-Titel Z→A',
			),
			'date_asc' => 'Veröffentlichungsdatum 1→9',
			'date_desc' => 'Veröffentlichungsdatum 9→1',
			'desc' => 'Absteigend',
			'f' => array(
				'name_asc' => 'Feed-Titel A→Z',
				'name_desc' => 'Feed-Titel Z→A',
			),
			'id_asc' => 'Älteste zuerst',
			'id_desc' => 'Neueste zuerst',
			'length_asc' => 'Inhaltslänge 1→9',
			'length_desc' => 'Inhaltslänge 9→1',
			'link_asc' => 'Link A→Z',	// IGNORE
			'link_desc' => 'Link Z→A',	// IGNORE
			'primary' => array(
				'_' => 'Sortierkriterium',
				'help' => 'In den meisten Fällen wird aus Gründen der Konsistenz und Leistung die Sortierung nach dem <em>Empfangsdatum</em> empfohlen.',
			),
			'rand' => 'Zufällige Reihenfolge',
			'secondary' => array(
				'_' => 'Zusätzliches Sortierkritiserium',
				'help' => 'Nur relevant, wenn das Hauptsortierkriterium Kategorien oder Feed-Titel sind.',
			),
			'title_asc' => 'Titel A→Z',
			'title_desc' => 'Titel Z→A',
			'user_modified_asc' => 'Vom Benutzer geändert 1→9',
			'user_modified_desc' => 'Vom Benutzer geändert 9→1',
		),
		'starred' => 'Favoriten zeigen',
		'stats' => 'Statistiken',
		'subscription' => 'Abonnementverwaltung',
		'unread' => 'Ungelesene anzeigen',
	),
	'share' => 'Teilen',
	'tag' => array(
		'related' => 'Hashtags',
	),
	'tos' => array(
		'title' => 'Nutzungsbedingungen',
	),
);

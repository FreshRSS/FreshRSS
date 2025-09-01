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
	'about' => array(
		'_' => 'Info',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Systemumgebung',
				'browser' => 'Browser',	// IGNORE
				'database' => 'Datenbank',
				'server_software' => 'Serversoftware',
				'version_curl' => 'cURL version',	// TODO
				'version_frss' => 'FreshRSS-Version',
				'version_php' => 'PHP-Version',
			),
		),
		'bugs_reports' => 'Fehlerberichte',
		'documentation' => 'Handbuch',
		'freshrss_description' => 'FreshRSS ist ein RSS-Feedsaggregator zum selbst hosten. Er ist leicht und einfach zu handhaben und gleichzeitig ein leistungsstarkes und konfigurierbares Werkzeug.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">auf GitHub</a>',
		'license' => 'Lizenz',
		'project_website' => 'Projekt-Website',
		'title' => 'Info',
		'version' => 'Version',	// IGNORE
	),
	'feed' => array(
		'empty' => 'Es gibt keinen Artikel zum Anzeigen.',
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => 'RSS-Feed von %s',
		'title' => 'Haupt-Feeds',
		'title_fav' => 'Favoriten',
		'title_global' => 'Globale Ansicht',
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
		'newer_first' => 'Neuere zuerst',
		'non-starred' => 'Alle außer Favoriten zeigen',
		'normal_view' => 'Normale Ansicht',
		'older_first' => 'Ältere zuerst',
		'queries' => 'Benutzerabfragen',
		'read' => 'Nur gelesene zeigen',
		'reader_view' => 'Lese-Ansicht',
		'rss_view' => 'RSS-Feed',
		'search_short' => 'Suchen',
		'sort' => array(
			'_' => 'Sorting criteria',	// TODO
			'c' => array(
				'name_asc' => 'Category, feed titles A→Z',	// TODO
				'name_desc' => 'Category, feed titles Z→A',	// TODO
			),
			'date_asc' => 'Publication date 1→9',	// TODO
			'date_desc' => 'Publication date 9→1',	// TODO
			'f' => array(
				'name_asc' => 'Feed title A→Z',	// TODO
				'name_desc' => 'Feed title Z→A',	// TODO
			),
			'id_asc' => 'Freshly received last',	// TODO
			'id_desc' => 'Freshly received first',	// TODO
			'link_asc' => 'Link A→Z',	// TODO
			'link_desc' => 'Link Z→A',	// TODO
			'rand' => 'Random order',	// TODO
			'title_asc' => 'Title A→Z',	// TODO
			'title_desc' => 'Title Z→A',	// TODO
		),
		'starred' => 'Nur Favoriten zeigen',
		'stats' => 'Statistiken',
		'subscription' => 'Abonnementverwaltung',
		'unread' => 'Nur ungelesene zeigen',
	),
	'share' => 'Teilen',
	'tag' => array(
		'related' => 'Hashtags',
	),
	'tos' => array(
		'title' => 'Nutzungsbedingungen',
	),
);

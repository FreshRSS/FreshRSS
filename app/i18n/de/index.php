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
		'_' => 'Über',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bugs_reports' => 'Fehlerberichte',
		'credits' => 'Mitwirkende',
		'credits_content' => 'Einige Designelemente stammen von <a href="http://twitter.github.io/bootstrap/">Bootstrap</a>, obwohl FreshRSS dieses Framework nicht nutzt. <a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">Icons</a> stammen vom <a href="https://www.gnome.org/">GNOME project</a>. <em>Open Sans</em> Font wurde von <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a> erstellt. FreshRSS basiert auf <a href="https://framagit.org/marienfressinaud/MINZ">Minz</a>, einem PHP-Framework.',
		'documentation' => 'Handbuch',
		'freshrss_description' => 'FreshRSS ist ein RSS-Feedsaggregator zum selbst hosten. Er ist leicht und einfach zu handhaben und gleichzeitig ein leistungsstarkes und konfigurierbares Werkzeug.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">auf Github</a>',
		'license' => 'Lizenz',
		'project_website' => 'Projekt-Website',
		'title' => 'Über',
		'version' => 'Version',	// IGNORE
	),
	'feed' => array(
		'empty' => 'Es gibt keinen Artikel zum Anzeigen.',
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
		'important' => 'Important feeds',	// TODO
		'main_stream' => 'Haupt-Feeds',
		'mark_all_read' => 'Alle als gelesen markieren',
		'mark_cat_read' => 'Kategorie als gelesen markieren',
		'mark_feed_read' => 'Feed als gelesen markieren',
		'mark_selection_unread' => 'Auswahl als ungelesen markieren',
		'newer_first' => 'Neuere zuerst',
		'non-starred' => 'Alle außer Favoriten zeigen',
		'normal_view' => 'Normale Ansicht',
		'older_first' => 'Ältere zuerst',
		'queries' => 'Benutzerabfragen',
		'read' => 'Nur gelesene zeigen',
		'reader_view' => 'Lese-Ansicht',
		'rss_view' => 'RSS-Feed',
		'search_short' => 'Suchen',
		'starred' => 'Nur Favoriten zeigen',
		'stats' => 'Statistiken',
		'subscription' => 'Abonnementverwaltung',
		'tags' => 'Meine Labels',
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

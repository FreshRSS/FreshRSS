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
		'_' => 'O serwisie',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bugs_reports' => 'Zgłaszanie problemów',
		'credits' => 'Uznanie autorstwa',
		'credits_content' => 'Niektóre elementy designu pochodzą z <a href="http://twitter.github.io/bootstrap/">Bootstrapa</a>, przy czym FreshRSS nie używa tego frameworku. <a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">Ikony</a> zostały pierwotnie stworzone dla <a href="https://www.gnome.org/">projektu GNOME</a>. Font <em>Open Sans</em> jest autorstwa <a href="https://fonts.google.com/specimen/Open+Sans">Steve’a Mattesona</a>. FreshRSS opiera się na <a href="https://framagit.org/marienfressinaud/MINZ">Minz</a>, frameworku PHP.',
		'documentation' => 'Documentation',	// TODO
		'freshrss_description' => 'FreshRSS jest agregatorem kanałów RSS przeznaczonym do zainstalowania na własnym serwerze. Jest lekki i łatwy do schowania w kieszeni, pozostając przy tym potężnym i konfigurowalnym narzędziem.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">na Githubie</a>',
		'license' => 'Licencja',
		'project_website' => 'Strona projektu',
		'title' => 'O serwisie',
		'version' => 'Wersja',
	),
	'feed' => array(
		'empty' => 'Brak wiadomości do wyświetlenia.',
		'rss_of' => 'Kanał RSS: %s',
		'title' => 'Kanał główny',
		'title_fav' => 'Ulubione',
		'title_global' => 'Widok globalny',
	),
	'log' => array(
		'_' => 'Dziennik',
		'clear' => 'Usuń wpisy z dziennika',
		'empty' => 'Dziennik jest pusty',
		'title' => 'Dziennik',
	),
	'menu' => array(
		'about' => 'O serwisie FreshRSS',
		'before_one_day' => 'Starsze niż dzień',
		'before_one_week' => 'Starsze niż tydzień',
		'bookmark_query' => 'Zapisz bieżące zapytanie',
		'favorites' => 'Ulubione (%s)',
		'global_view' => 'Widok globalny',
		'important' => 'Important feeds',	// TODO
		'main_stream' => 'Kanał główny',
		'mark_all_read' => 'Oznacz wszystkie jako przeczytane',
		'mark_cat_read' => 'Oznacz kategorię jako przeczytaną',
		'mark_feed_read' => 'Oznacz kanał jako przeczytany',
		'mark_selection_unread' => 'Oznacz wiadomości jako nieprzeczytane',
		'newer_first' => 'Najpierw najnowsze',
		'non-starred' => 'Pokaż wiadomości, które nie są ulubione',
		'normal_view' => 'Widok normalny',
		'older_first' => 'Najpierw najstarsze',
		'queries' => 'Zapisane wyszukiwania',
		'read' => 'Pokaż przeczytane',
		'reader_view' => 'Widok czytania',
		'rss_view' => 'Kanał RSS',
		'search_short' => 'Szukaj',
		'starred' => 'Pokaż ulubione',
		'stats' => 'Statystyki',
		'subscription' => 'Zarządzanie subskrypcjami',
		'tags' => 'Własne etykiety',
		'unread' => 'Pokaż nieprzeczytane',
	),
	'share' => 'Podaj dalej',
	'tag' => array(
		'related' => 'Tagi',
	),
	'tos' => array(
		'title' => 'Warunki użytkowania',
	),
);

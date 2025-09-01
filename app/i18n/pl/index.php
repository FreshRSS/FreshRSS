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
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Informacje o serwerze',
				'browser' => 'Przeglądarka',
				'database' => 'Baza danych',
				'server_software' => 'Oprogramowanie serwera',
				'version_curl' => 'Wersja biblioteki cURL',
				'version_frss' => 'Wersja FreshRSS',
				'version_php' => 'Wersja PHP',
			),
		),
		'bugs_reports' => 'Zgłaszanie błędów',
		'documentation' => 'Dokumentacja',
		'freshrss_description' => 'FreshRSS to agregator i czytnik RSS, który można hostować samodzielnie. Pozwala na szybkie śledzenie i czytanie wielu stron informacyjnych bez potrzeby przechodzenia z jednej strony na drugą. FreshRSS jest lekki, konfigurowalny i łatwy w użyciu.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">na GitHubie</a>',
		'license' => 'Licencja',
		'project_website' => 'Strona projektu',
		'title' => 'O serwisie',
		'version' => 'Wersja',
	),
	'feed' => array(
		'empty' => 'Brak wiadomości do wyświetlenia.',
		'received' => array(
			'before_yesterday' => 'Otrzymane przedwczoraj',
			'today' => 'Otrzymane dzisiaj',
			'yesterday' => 'Otrzymane wczoraj',
		),
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
		'about' => 'O oprogramowaniu FreshRSS',
		'before_one_day' => 'Starsze niż dzień',
		'before_one_week' => 'Starsze niż tydzień',
		'bookmark_query' => 'Zapisz bieżące zapytanie',
		'favorites' => 'Ulubione (%s)',
		'global_view' => 'Widok globalny',
		'important' => 'Ważne kanały',
		'main_stream' => 'Kanał główny',
		'mark_all_read' => 'Oznacz wszystkie jako przeczytane',
		'mark_cat_read' => 'Oznacz kategorię jako przeczytaną',
		'mark_feed_read' => 'Oznacz kanał jako przeczytany',
		'mark_selection_unread' => 'Oznacz wiadomości jako nieprzeczytane',
		'mylabels' => 'Własne etykiety',
		'newer_first' => 'Najpierw najnowsze',
		'non-starred' => 'Pokaż wiadomości, które nie są ulubione',
		'normal_view' => 'Widok normalny',
		'older_first' => 'Najpierw najstarsze',
		'queries' => 'Zapisane zapytania',
		'read' => 'Pokaż przeczytane',
		'reader_view' => 'Widok czytania',
		'rss_view' => 'Kanał RSS',
		'search_short' => 'Szukaj',
		'sort' => array(
			'_' => 'Kryteria sortowania',
			'c' => array(
				'name_asc' => 'Tytuł kategorii i kanału A→Z',
				'name_desc' => 'Tytuł kategorii i kanału Z→A',
			),
			'date_asc' => 'Data publikacji 1→9',
			'date_desc' => 'Data publikacji 9→1',
			'f' => array(
				'name_asc' => 'Tytuł kanału A→Z',
				'name_desc' => 'Tytuł kanału Z→A',
			),
			'id_asc' => 'Najpożniej otrzymane',
			'id_desc' => 'Najwcześniej otrzymane',
			'link_asc' => 'Odnośnik A→Z',
			'link_desc' => 'Odnośnik Z→A',
			'rand' => 'Losowa kolejność',
			'title_asc' => 'Tytuł A→Z',
			'title_desc' => 'Tytuł Z→A',
		),
		'starred' => 'Pokaż ulubione',
		'stats' => 'Statystyki',
		'subscription' => 'Zarządzanie subskrypcjami',
		'unread' => 'Pokaż nieprzeczytane',
	),
	'share' => 'Udostępnij',
	'tag' => array(
		'related' => 'Tagi',
	),
	'tos' => array(
		'title' => 'Warunki użytkowania',
	),
);

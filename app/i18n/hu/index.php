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
		'_' => 'Névjegy',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Rendszer információ',
				'browser' => 'Böngésző',
				'database' => 'Adatbázis',
				'server_software' => 'Szerver szoftver',
				'version_curl' => 'cURL version',	// TODO
				'version_frss' => 'FreshRSS verzió',
				'version_php' => 'PHP verzió',
			),
		),
		'bugs_reports' => 'Hiba jelentések',
		'documentation' => 'Dokumentáció',
		'freshrss_description' => 'A FreshRSS egy saját magunk által host-olható RSS hírgyűjtő és olvasó. Lehetővé teszi hogy kövess és olvass sok híroldalt egy pillantás alatt anélkül hogy mindegyiket meglátogatnád egyesével. A FreshRSS könnyű, gyors, jól konfigurálható, és könnyen használható.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">GitHub-on</a>',
		'license' => 'Licenc',
		'project_website' => 'Projekt weboldal',
		'title' => 'Névjegy',
		'version' => 'Verzió',
	),
	'feed' => array(
		'empty' => 'Nincs megjeleníthető cikk.',
		'received' => array(
			'before_yesterday' => 'Tegnapelőtt fogadva',
			'today' => 'Ma fogadva',
			'yesterday' => 'Tegnap fogadva',
		),
		'rss_of' => 'RSS hírforrás %s',
		'title' => 'Minden cikk',
		'title_fav' => 'Kedvencek',
		'title_global' => 'Globális nézet',
	),
	'log' => array(
		'_' => 'Log-ok',
		'clear' => 'Log-ok törlése',
		'empty' => 'Log fájl üres',
		'title' => 'Log-ok',
	),
	'menu' => array(
		'about' => 'FreshRSS névjegy',
		'before_one_day' => 'Egy napnál régebbiek',
		'before_one_week' => 'Egy hétnél régebbiek',
		'bookmark_query' => 'Jelenlegi lekérdezés könyvjelzőzése',
		'favorites' => 'Kedvencek (%s)',
		'global_view' => 'Globális nézet',
		'important' => 'Fontos hírforrások',
		'main_stream' => 'Minden cikk',
		'mark_all_read' => 'Minden megjelölése olvasottként',
		'mark_cat_read' => 'Kategória megjelölése olvasottként',
		'mark_feed_read' => 'Hírforrás megjelölése olvasottként',
		'mark_selection_unread' => 'Kijelöltek olvasatlanná tétele',
		'mylabels' => 'Címkék',
		'newer_first' => 'Újabbak elöl',
		'non-starred' => 'Nem kedvencek megjelenítése',
		'normal_view' => 'Normál nézet',
		'older_first' => 'Régebbiek elöl',
		'queries' => 'Felhasználói lekérdezések',
		'read' => 'Olvasottak megjelenítése',
		'reader_view' => 'Olvasó nézet',
		'rss_view' => 'RSS hírforrás',
		'search_short' => 'Keresés',
		'sort' => array(
			'_' => 'Rendezési sorrend',
			'c' => array(
				'name_asc' => 'Category, feed titles A→Z',	// TODO
				'name_desc' => 'Category, feed titles Z→A',	// TODO
			),
			'date_asc' => 'Kiadás dátuma 1→9',
			'date_desc' => 'Kiadás dátuma 9→1',
			'f' => array(
				'name_asc' => 'Feed title A→Z',	// TODO
				'name_desc' => 'Feed title Z→A',	// TODO
			),
			'id_asc' => 'Frissen fogadott utoljára',
			'id_desc' => 'Frissen fogadott először',
			'link_asc' => 'Link A→Z',	// TODO
			'link_desc' => 'Link Z→A',	// TODO
			'rand' => 'Véletlen sorrend',
			'title_asc' => 'Cím A→Z',
			'title_desc' => 'Cím Z→A',
		),
		'starred' => 'Kedvencek megjelenítése',
		'stats' => 'Statisztika',
		'subscription' => 'Hírforrások kezelése',
		'unread' => 'Olvasatlanok megjelenítése',
	),
	'share' => 'Megosztás',
	'tag' => array(
		'related' => 'Cikk címkék',
	),
	'tos' => array(
		'title' => 'Szolgáltatási feltételek',
	),
);

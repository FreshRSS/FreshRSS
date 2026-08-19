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
		'_' => 'Névjegy',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Rendszer információ',
				'browser' => 'Böngésző',
				'database' => 'Adatbázis',
				'server_software' => 'Szerver szoftver',
				'version_curl' => 'cURL verzió',
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
		'published' => array(
			'_' => 'Közzétéve',
			'beforeLastYear' => 'Published before last year',	// TODO
			'earlierThisMonth' => 'Published earlier this month',	// TODO
			'earlierThisYear' => 'Published earlier this year',	// TODO
			'future' => 'A jövőben közzétéve',
			'lastMonth' => 'Published last month',	// TODO
			'lastYear' => 'Published last year',	// TODO
			'today' => 'Ma közzétéve',
			'yesterday' => 'Tegnap közzétéve',
		),
		'received' => array(
			'_' => 'Beérkezett',
			'beforeLastYear' => 'Received before last year',	// TODO
			'earlierThisMonth' => 'Received earlier this month',	// TODO
			'earlierThisYear' => 'Received earlier this year',	// TODO
			'future' => 'Received in the future',	// TODO
			'lastMonth' => 'Received last month',	// TODO
			'lastYear' => 'Received last year',	// TODO
			'today' => 'Ma beérkezett',
			'yesterday' => 'Tegnap beérkezett',
		),
		'rss_of' => 'RSS hírforrás %s',
		'title' => 'Minden cikk',
		'title_fav' => 'Kedvencek',
		'title_global' => 'Globális nézet',
		'userModified' => array(
			'_' => 'Felhasználó által módosítva',
			'beforeLastYear' => 'Modified by user before last year',	// TODO
			'earlierThisMonth' => 'Modified by user earlier this month',	// TODO
			'earlierThisYear' => 'Modified by user earlier this year',	// TODO
			'future' => 'Modified by user in the future',	// TODO
			'lastMonth' => 'Modified by user last month',	// TODO
			'lastYear' => 'Modified by user last year',	// TODO
			'today' => 'Felhasználó által módosítva ma',
			'yesterday' => 'Felhasználó által módosítva tegnap',
		),
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
		'non-starred' => 'Nem kedvencek megjelenítése',
		'normal_view' => 'Normál nézet',
		'queries' => 'Felhasználói lekérdezések',
		'read' => 'Olvasottak megjelenítése',
		'reader_view' => 'Olvasó nézet',
		'rss_view' => 'RSS hírforrás',
		'search_short' => 'Keresés',
		'sort' => array(
			'asc' => 'Növekvő',
			'c' => array(
				'name_asc' => 'Kategória, feed címek A→Z',
				'name_desc' => 'Kategória, feed címek Z→A',
			),
			'date_asc' => 'Kiadás dátuma 1→9',
			'date_desc' => 'Kiadás dátuma 9→1',
			'desc' => 'Csökkenő',
			'f' => array(
				'name_asc' => 'Feed cím A→Z',
				'name_desc' => 'Feed cím Z→A',
			),
			'id_asc' => 'Frissen fogadott utoljára',
			'id_desc' => 'Frissen fogadott először',
			'length_asc' => 'Tartalom hossza 1→9',
			'length_desc' => 'Tartalom hossza 9→1',
			'link_asc' => 'Link A→Z',	// IGNORE
			'link_desc' => 'Link Z→A',	// IGNORE
			'primary' => array(
				'_' => 'Rendezési feltétel',
				'help' => 'A <em>fogadás</em> dátuma szerinti rendezés javasolt a legtöbb esetben a következetesség és a teljesítmény érdekében',
			),
			'rand' => 'Véletlen sorrend',
			'secondary' => array(
				'_' => 'Másodlagos rendezési feltétel',
				'help' => 'Csak akkor releváns, ha az elsődleges rendezési feltétel a kategóriák vagy a hírfolyamok címei',
			),
			'title_asc' => 'Cím A→Z',
			'title_desc' => 'Cím Z→A',
			'user_modified_asc' => 'Felhasználói módosítás 1→9',
			'user_modified_desc' => 'Felhasználói módosítás 9→1',
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

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
		'bugs_reports' => 'Hiba jelentések',
		'credits' => 'Credits',	// IGNORE
		'credits_content' => 'Néhány dizájn elem a <a href="http://twitter.github.io/bootstrap/">Bootstrap</a> segítségével működik, habár a FreshRSS nem használja ezt a framework-öt. Az <a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">Ikonok</a> a <a href="https://www.gnome.org/">GNOME projekt-ből származnak</a>. <em>Open Sans</em> betűtípust készítette <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a>. FreshRSS a <a href="https://framagit.org/marienfressinaud/MINZ">Minz</a> PHP keretrendszeren alapul.',
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
		'mark_all_read' => 'Legyen mind olvasott',
		'mark_cat_read' => 'Kategória megjelölése olvasottként',
		'mark_feed_read' => 'Hírforrás megjelölése olvasottként',
		'mark_selection_unread' => 'Kijelöltek olvasatlanná tétele',
		'newer_first' => 'Újabbak elöl',
		'non-starred' => 'Nem kedvencek megjelenítése',
		'normal_view' => 'Normál nézet',
		'older_first' => 'Régebbiek elöl',
		'queries' => 'Felhasználói lekérdezések',
		'read' => 'Olvasottak megjelenítése',
		'reader_view' => 'Olvasó nézet',
		'rss_view' => 'RSS hírforrás megnyitása',
		'search_short' => 'Keresés',
		'starred' => 'Kedvencek megjelenítése',
		'stats' => 'Statisztika',
		'subscription' => 'Hírforrások kezelése',
		'tags' => 'Címkék',
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

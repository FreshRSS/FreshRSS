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
		'_' => 'O FreshRSS',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bugs_reports' => 'Nahlásiť chybu',
		'credits' => 'Poďakovanie',
		'credits_content' => 'Niektoré časti vzhľadu pochádzajú z <a href="http://twitter.github.io/bootstrap/">Bootstrap</a>u, aj keď FreshRSS tento framework nepoužíva. <a href="https://git.gnome.org/browse/gnome-icon-theme-symbolic">Ikony</a> sú z <a href="https://www.gnome.org/">GNOME project</a>. Font <em>Open Sans</em> zabezpečil <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a>. FreshRSS je založený na PHP frameworku <a href="https://github.com/marienfressinaud/MINZ">Minz</a>.',
		'freshrss_description' => 'FreshRSS je čítačka RSS kanálov, ktorú môžete nasadiť na vlastný server podobne ako <a href="http://tontof.net/kriss/feed/">Kriss Feed</a> alebo <a href="https://github.com/LeedRSS/Leed">Leed</a>. Ide o jednoduchý a zároveň dobre nastaviteľný nástroj.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">na Github</a>e',
		'license' => 'Licencia',
		'project_website' => 'Webová stránka projektu',
		'title' => 'O FreshRSS',
		'version' => 'Verzia',
	),
	'feed' => array(
		'add' => 'Môžete pridať kanály.',
		'empty' => 'Žiadne články.',
		'rss_of' => 'RSS kanál pre %s',
		'title' => 'Všetky kanály',
		'title_fav' => 'Obľúbené',
		'title_global' => 'Prehľad',
	),
	'log' => array(
		'_' => 'Záznamy',
		'clear' => 'Vymazať záznamy',
		'empty' => 'Súbor záznamu je prázdny',
		'title' => 'Záznamy',
	),
	'menu' => array(
		'about' => 'O FreshRSS',
		'before_one_day' => 'Pred 1 dňom',
		'before_one_week' => 'Pred 1 týždňom',
		'bookmark_query' => 'Pridať aktuálny dopyt do obľúbených',
		'favorites' => 'Obľúbené (%s)',
		'global_view' => 'Prehľad',
		'main_stream' => 'Všetky kanály',
		'mark_all_read' => 'Označiť všetko ako prečítané',
		'mark_cat_read' => 'Označiť kategóriu ako prečítanú',
		'mark_feed_read' => 'Označiť kanál ako prečítaný',
		'mark_selection_unread' => 'Označiť označené ako prečítané',
		'newer_first' => 'Novšie hore',
		'non-starred' => 'Zobraziť všetko okrem obľúbených',
		'normal_view' => 'Základné zobrazenie',
		'older_first' => 'Staršie hore',
		'queries' => 'Používateľské dopyty',
		'read' => 'Zobraziť prečítané',
		'reader_view' => 'Zobrazenie na čítanie',
		'rss_view' => 'RSS kanál',
		'search_short' => 'Hľadať',
		'starred' => 'Zobraziť obľúbené',
		'stats' => 'Štatistiky',
		'subscription' => 'Správca odberov',
		'tags' => 'Moje nálepky',
		'unread' => 'Zobraziť neprečítané',
	),
	'share' => 'Zdieľať',
	'tag' => array(
		'related' => 'Značky článku',
	),
	'tos' => array(
		'title' => 'Podmienky služby',
	),
);

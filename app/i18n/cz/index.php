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
		'_' => 'O aplikaci',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bugs_reports' => 'Hlášení chyb',
		'credits' => 'Poděkování',
		'credits_content' => 'Některé designové prvky pocházejí z <a href="http://twitter.github.io/bootstrap/">Bootstrap</a>, FreshRSS ale tuto platformu nevyužívá. <a href="https://git.gnome.org/browse/gnome-icon-theme-symbolic">Ikony</a> pocházejí z <a href="https://www.gnome.org/">projektu GNOME</a>. Písmo <em>Open Sans</em> vytvořil <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a>. FreshRSS je založeno na PHP framework <a href="https://github.com/marienfressinaud/MINZ">Minz</a>.',
		'freshrss_description' => 'FreshRSS je čtečka kanálů RSS určená k provozu na vlastním serveru, podobná <a href="http://tontof.net/kriss/feed/">Kriss Feed</a> nebo <a href="https://github.com/LeedRSS/Leed">Leed</a>. Je to nenáročný a jednoduchý, zároveň ale mocný a konfigurovatelný nástroj.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">na Github</a>',
		'license' => 'Licence',
		'project_website' => 'Webová stránka projektu',
		'title' => 'O aplikaci',
		'version' => 'Verze',
	),
	'feed' => array(
		'add' => 'Přidejte nějaké kanály.',
		'empty' => 'Nejsou žádné články k zobrazení.',
		'rss_of' => 'Kanál RSS %s',
		'title' => 'Hlavní kanál',
		'title_fav' => 'Oblíbené',
		'title_global' => 'Zobrazení přehledu',
	),
	'log' => array(
		'_' => 'Protokoly',
		'clear' => 'Vymazat protokoly',
		'empty' => 'Soubor protokolu je prázdný',
		'title' => 'Protokoly',
	),
	'menu' => array(
		'about' => 'O FreshRSS',
		'before_one_day' => 'Starší než jeden den',
		'before_one_week' => 'Starší než jeden týden',
		'bookmark_query' => 'Uložit aktuální dotaz do záložek',
		'favorites' => 'Oblíbené (%s)',
		'global_view' => 'Zobrazení přehledu',
		'main_stream' => 'Hlavní kanál',
		'mark_all_read' => 'Označit vše jako přečtené',
		'mark_cat_read' => 'Označit kategorii jako přečtenou',
		'mark_feed_read' => 'Označit kanál jako přečtený',
		'mark_selection_unread' => 'Označit výběr jako nepřečtený',
		'newer_first' => 'Nejdříve novější',
		'non-starred' => 'Zobrazit neoblíbené',
		'normal_view' => 'Normální zobrazení',
		'older_first' => 'Nejdříve nejstarší',
		'queries' => 'Uživatelské dotazy',
		'read' => 'Zobrazit přečtené',
		'reader_view' => 'Zobrazení pro čtení',
		'rss_view' => 'Kanál RSS',
		'search_short' => 'Hledat',
		'starred' => 'Zobrazit oblíbené',
		'stats' => 'Statistika',
		'subscription' => 'Správa odběrů',
		'tags' => 'Mé popisky',
		'unread' => 'Zobrazit nepřečtené',
	),
	'share' => 'Sdílet',
	'tag' => array(
		'related' => 'Štítky článků',
	),
	'tos' => array(
		'title' => 'Podmínky služby',
	),
);

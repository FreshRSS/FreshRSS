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
		'bugs_reports' => 'Hlášení chyb',
		'credits' => 'Poděkování',
		'credits_content' => 'Některé designové prvky pocházejí z <a href="http://twitter.github.io/bootstrap/">Bootstrap</a>, FreshRSS ale tuto platformu nevyužívá. <a href="https://git.gnome.org/browse/gnome-icon-theme-symbolic">Ikony</a> pocházejí z <a href="https://www.gnome.org/">GNOME projektu</a>. Font <em>Open Sans</em> vytvořil <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a>. FreshRSS je založen na PHP framework <a href="https://github.com/marienfressinaud/MINZ">Minz</a>.',
		'freshrss_description' => 'FreshRSS je čtečka RSS kanálů určená k provozu na vlastním serveru, podobná <a href="http://tontof.net/kriss/feed/">Kriss Feed</a> nebo <a href="https://github.com/LeedRSS/Leed">Leed</a>. Je to nenáročný a jednoduchý, zároveň ale mocný a konfigurovatelný nástroj.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">na Github</a>',
		'license' => 'Licence',
		'project_website' => 'Stránka projektu',
		'title' => 'O FreshRSS',
		'version' => 'Verze',
	),
	'feed' => array(
		'add' => 'Můžete přidat kanály.',
		'empty' => 'Žádné články k zobrazení.',
		'rss_of' => 'RSS kanál %s',
		'title' => 'Všechny kanály',
		'title_fav' => 'Oblíbené',
		'title_global' => 'Přehled',
	),
	'log' => array(
		'_' => 'Logy',
		'clear' => 'Vymazat logy',
		'empty' => 'Log je prázdný',
		'title' => 'Logy',
	),
	'menu' => array(
		'about' => 'O FreshRSS',
		'before_one_day' => 'Den nazpět',
		'before_one_week' => 'Před týdnem',
		'bookmark_query' => 'Bookmark current query',	// TODO
		'favorites' => 'Oblíbené (%s)',
		'global_view' => 'Přehled',
		'main_stream' => 'Všechny kanály',
		'mark_all_read' => 'Označit vše jako přečtené',
		'mark_cat_read' => 'Označit kategorii jako přečtenou',
		'mark_feed_read' => 'Označit kanál jako přečtený',
		'mark_selection_unread' => 'Mark selection as unread',	// TODO
		'newer_first' => 'Nové nejdříve',
		'non-starred' => 'Zobrazit vše vyjma oblíbených',
		'normal_view' => 'Normální',
		'older_first' => 'Nejstarší nejdříve',
		'queries' => 'Uživatelské dotazy',
		'read' => 'Zobrazovat přečtené',
		'reader_view' => 'Čtení',
		'rss_view' => 'RSS kanál',
		'search_short' => 'Hledat',
		'starred' => 'Zobrazit oblíbené',
		'stats' => 'Statistika',
		'subscription' => 'Správa subskripcí',
		'tags' => 'My labels',	// TODO
		'unread' => 'Zobrazovat nepřečtené',
	),
	'share' => 'Sdílet',
	'tag' => array(
		'related' => 'Související tagy',
	),
	'tos' => array(
		'title' => 'Terms of Service',	// TODO
	),
);

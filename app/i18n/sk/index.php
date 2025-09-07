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
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'System information',	// TODO
				'browser' => 'Browser',	// TODO
				'database' => 'Database',	// TODO
				'server_software' => 'Server software',	// TODO
				'version_curl' => 'cURL version',	// TODO
				'version_frss' => 'FreshRSS version',	// TODO
				'version_php' => 'PHP version',	// TODO
			),
		),
		'bugs_reports' => 'Nahlásiť chybu',
		'documentation' => 'Dokumentácia',
		'freshrss_description' => 'FreshRSS je čítačka RSS kanálov, ktorú môžete nasadiť na vlastný server. Ide o jednoduchý a zároveň dobre nastaviteľný nástroj.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">na GitHub</a>e',
		'license' => 'Licencia',
		'project_website' => 'Webová stránka projektu',
		'title' => 'O FreshRSS',
		'version' => 'Verzia',
	),
	'feed' => array(
		'empty' => 'Žiadne články.',
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
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
		'important' => 'Dôležité kanály',
		'main_stream' => 'Všetky kanály',
		'mark_all_read' => 'Označiť všetko ako prečítané',
		'mark_cat_read' => 'Označiť kategóriu ako prečítanú',
		'mark_feed_read' => 'Označiť kanál ako prečítaný',
		'mark_selection_unread' => 'Označiť označené ako prečítané',
		'mylabels' => 'Moje nálepky',
		'newer_first' => 'Novšie hore',
		'non-starred' => 'Zobraziť všetko okrem obľúbených',
		'normal_view' => 'Základné zobrazenie',
		'older_first' => 'Staršie hore',
		'queries' => 'Používateľské dopyty',
		'read' => 'Zobraziť prečítané',
		'reader_view' => 'Zobrazenie na čítanie',
		'rss_view' => 'RSS kanál',
		'search_short' => 'Hľadať',
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
		'starred' => 'Zobraziť obľúbené',
		'stats' => 'Štatistiky',
		'subscription' => 'Správca odberov',
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

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
		'_' => 'Tietoja',
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
		'bugs_reports' => 'Virheraportit',
		'documentation' => 'Ohjeet',
		'freshrss_description' => 'FreshRSS on itse asennettava RSS-syötteiden luku- ja hallintaohjelma. Sen avulla voit helposti lukea ja seurata useita uutissivustoja yhdessä näkymässä, eikä sinun tarvitse siirtyä sivustolta toiselle. FreshRSS on kevyt, muokattavissa ja helppokäyttöinen.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">GitHubissa</a>',
		'license' => 'Käyttöoikeus',
		'project_website' => 'Projektin sivusto',
		'title' => 'Tietoja',
		'version' => 'Versio',
	),
	'feed' => array(
		'empty' => 'Näytettäviä artikkeleita ei ole.',
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => 'Sivuston %s RSS-syöte',
		'title' => 'Pääsyötevirta',
		'title_fav' => 'Suosikit',
		'title_global' => 'Yleisnäkymä',
	),
	'log' => array(
		'_' => 'Lokit',
		'clear' => 'Tyhjennä lokit',
		'empty' => 'Lokitiedosto on tyhjä',
		'title' => 'Lokit',
	),
	'menu' => array(
		'about' => 'Tietoja FreshRSS-sovelluksesta',
		'before_one_day' => 'Vanhemmat kuin yksi päivä',
		'before_one_week' => 'Vanhemmat kuin yksi viikko',
		'bookmark_query' => 'Tallenna tämä kysely kirjanmerkiksi',
		'favorites' => 'Suosikit (%s)',
		'global_view' => 'Yleisnäkymä',
		'important' => 'Tärkeät syötteet',
		'main_stream' => 'Pääsyötevirta',
		'mark_all_read' => 'Merkitse kaikki luetuiksi',
		'mark_cat_read' => 'Merkitse luokka luetuksi',
		'mark_feed_read' => 'Merkitse syöte luetuksi',
		'mark_selection_unread' => 'Merkitse valitut lukemattomiksi',
		'mylabels' => 'Omat tunnisteet',
		'newer_first' => 'Uusin ensin',
		'non-starred' => 'Näytä muut kuin suosikit',
		'normal_view' => 'Tavallinen näkymä',
		'older_first' => 'Vanhin ensin',
		'queries' => 'Käyttäjän tekemät kyselyt',
		'read' => 'Näytä luetut',
		'reader_view' => 'Lukunäkymä',
		'rss_view' => 'RSS-syöte',
		'search_short' => 'Haku',
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
		'starred' => 'Näytä suosikit',
		'stats' => 'Tilastot',
		'subscription' => 'Tilausten hallinta',
		'unread' => 'Näytä lukemattomat',
	),
	'share' => 'Jaa',
	'tag' => array(
		'related' => 'Artikkelin tunnisteet',
	),
	'tos' => array(
		'title' => 'Käyttöehdot',
	),
);

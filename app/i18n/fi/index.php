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
		'_' => 'Tietoja',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Järjestelmän tiedot',
				'browser' => 'Selain',
				'database' => 'Tietokanta',
				'server_software' => 'Palvelinohjelmisto',
				'version_curl' => 'cURL-versio',
				'version_frss' => 'FreshRSS-versio',
				'version_php' => 'PHP-versio',
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
		'published' => array(
			'_' => 'Published',	// TODO
			'future' => 'Published in the future',	// TODO
			'today' => 'Published today',	// TODO
			'yesterday' => 'Published yesterday',	// TODO
		),
		'received' => array(
			'_' => 'Received',	// TODO
			'today' => 'Saapuneet tänään',
			'yesterday' => 'Saapuneet eilen',
		),
		'rss_of' => 'Sivuston %s RSS-syöte',
		'title' => 'Pääsyötevirta',
		'title_fav' => 'Suosikit',
		'title_global' => 'Yleisnäkymä',
		'userModified' => array(
			'_' => 'Modified by user',	// TODO
			'today' => 'Modified by user today',	// TODO
			'yesterday' => 'Modified by user yesterday',	// TODO
		),
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
		'non-starred' => 'Näytä muut kuin suosikit',
		'normal_view' => 'Tavallinen näkymä',
		'queries' => 'Käyttäjän tekemät kyselyt',
		'read' => 'Näytä luetut',
		'reader_view' => 'Lukunäkymä',
		'rss_view' => 'RSS-syöte',
		'search_short' => 'Haku',
		'sort' => array(
			'asc' => 'Ascending',	// TODO
			'c' => array(
				'name_asc' => 'Luokka, syötteiden otsikot A→Ö',
				'name_desc' => 'Luokka, syötteiden otsikot Ö→A',
			),
			'date_asc' => 'Julkaisupäivä 1→9',
			'date_desc' => 'Julkaisupäivä 9→1',
			'desc' => 'Descending',	// TODO
			'f' => array(
				'name_asc' => 'Syötteen otsikko A→Ö',
				'name_desc' => 'Syötteen otsikko Ö→A',
			),
			'id_asc' => 'Uusimmat viimeisenä',
			'id_desc' => 'Uusimmat ensimmäisenä',
			'length_asc' => 'Content length 1→9',	// TODO
			'length_desc' => 'Content length 9→1',	// TODO
			'link_asc' => 'Linkki A→Ö',
			'link_desc' => 'Linkki Ö→A',
			'primary' => array(
				'_' => 'Sorting criterion',	// TODO
				'help' => 'Sorting by <em>received</em> date is recommended in most cases, for consistency and performance',	// TODO
			),
			'rand' => 'Satunnainen järjestys',
			'secondary' => array(
				'_' => 'Secondary sorting criterion',	// TODO
				'help' => 'Only relevant when the primary sorting criterion is categories or feeds titles',	// TODO
			),
			'title_asc' => 'Otsikko A→Ö',
			'title_desc' => 'Otsikko Ö→A',
			'user_modified_asc' => 'Käyttäjä muokannut 1→9',
			'user_modified_desc' => 'Käyttäjä muokannut 9→1',
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

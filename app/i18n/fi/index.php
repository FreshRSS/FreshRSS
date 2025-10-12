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
		'received' => array(
			'before_yesterday' => 'Saapuneet aikaisemmin kuin eilen',
			'today' => 'Saapuneet tänään',
			'yesterday' => 'Saapuneet eilen',
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
			'_' => 'Lajitteluehdot',
			'c' => array(
				'name_asc' => 'Luokka, syötteiden otsikot A→Ö',
				'name_desc' => 'Luokka, syötteiden otsikot Ö→A',
			),
			'date_asc' => 'Julkaisupäivä 1→9',
			'date_desc' => 'Julkaisupäivä 9→1',
			'f' => array(
				'name_asc' => 'Syötteen otsikko A→Ö',
				'name_desc' => 'Syötteen otsikko Ö→A',
			),
			'id_asc' => 'Uusimmat viimeisenä',
			'id_desc' => 'Uusimmat ensimmäisenä',
			'link_asc' => 'Linkki A→Ö',
			'link_desc' => 'Linkki Ö→A',
			'rand' => 'Satunnainen järjestys',
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

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
		'_' => 'Par vietni',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Sistēmas informācija',
				'browser' => 'Pārlūkprogramma',
				'database' => 'Datubāze',
				'server_software' => 'Servera programmatūra',
				'version_curl' => 'cURL versija',
				'version_frss' => 'FreshRSS versija',
				'version_php' => 'PHP versija',
			),
		),
		'bugs_reports' => 'Ziņojumi par kļūdām',
		'documentation' => 'Dokumentācija',
		'freshrss_description' => 'FreshRSS ir paš-hostējams RSS agregators un lasītājs. Tas ļauj jums lasīt un sekot līdzi vairākām ziņu vietnēm vienā mirklī, bez nepieciešamības pārvietoties no vienas vietnes uz citu. FreshRSS ir viegls, konfigurējams un viegli lietojams.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">GitHubā</a>',
		'license' => 'Licenze',
		'project_website' => 'Projekta mājaslapa',
		'title' => 'Par vietni',
		'version' => 'Versija',
	),
	'feed' => array(
		'empty' => 'Nav neviena raksta, ko parādīt.',
		'published' => array(
			'_' => 'Publicēts',
			'future' => 'Publicēts nākotnē',
			'today' => 'Publicēts šodien',
			'yesterday' => 'Publicēts vakar',
		),
		'received' => array(
			'_' => 'Saņemts',
			'today' => 'Saņemts šodien',
			'yesterday' => 'Saņemts vakar',
		),
		'rss_of' => 'RSS plūsma %s',
		'title' => 'Galvenā plūsma',
		'title_fav' => 'Mīļākie',
		'title_global' => 'Globālais skats',
		'userModified' => array(
			'_' => 'Modificējis lietotājs',
			'today' => 'Lietotājs modificējis šodien',
			'yesterday' => 'Lietotājs modificējis vakar',
		),
	),
	'log' => array(
		'_' => 'Žurnāli',
		'clear' => 'Iztīrīt žurnālus',
		'empty' => 'Žurnālu fails ir tukšs',
		'title' => 'Žurnāli',
	),
	'menu' => array(
		'about' => 'Par FreshRSS',
		'before_one_day' => 'Vecāks par vienu dienu',
		'before_one_week' => 'Vecāks par vienu nedēļu',
		'bookmark_query' => 'Pievienot grāmatzīmi pašreizējam pieprasījumam',
		'favorites' => 'Mīļākie (%s)',
		'global_view' => 'Globālais skats',
		'important' => 'Svarīgās barotnes',
		'main_stream' => 'Galvenā plūsma',
		'mark_all_read' => 'Atzīmēt visus kā izlasītus',
		'mark_cat_read' => 'Atzīmēt kategoriju kā izlasītu',
		'mark_feed_read' => 'Atzīmēt barotni kā izlasītu',
		'mark_selection_unread' => 'Atzīmēt izvēlni kā izlasītu',
		'mylabels' => 'Manas birkas',
		'non-starred' => 'Rādīt neiecienītākos',
		'normal_view' => 'Parastais skats',
		'queries' => 'Lietotāja pieprasījumi',
		'read' => 'Rādīt izlasītos',
		'reader_view' => 'Lasīšanas skats',
		'rss_view' => 'RSS barotne',
		'search_short' => 'Meklēt',
		'sort' => array(
			'asc' => 'Augoši',
			'c' => array(
				'name_asc' => 'Kategorijas, barotņu virsraksti A→Z',
				'name_desc' => 'Kategorijas, barotņu virsraksti Z→A',
			),
			'date_asc' => 'Publicēšanas datums 1→9',
			'date_desc' => 'Publicēšanas datums 9→1',
			'desc' => 'Dilstoši',
			'f' => array(
				'name_asc' => 'Barotnes virsraksts A→Z',
				'name_desc' => 'Barotnes virsraksts Z→A',
			),
			'id_asc' => 'Tikko saņemtie pēdējie',
			'id_desc' => 'Tikko saņemtie pirmie',
			'length_asc' => 'Satura garums 1→9',
			'length_desc' => 'Satura garums 9→1',
			'link_asc' => 'Saite A→Z',
			'link_desc' => 'Saite Z→A',
			'primary' => array(
				'_' => 'Šķirošanas kritērijs',
				'help' => 'Šķirošana pēc <em>saņemšanas</em> datuma ir ieteicama lielākajā daļā gadījumu, lai nodrošinātu konsekvenci un veiktspēju',
			),
			'rand' => 'Nejaušā secībā',
			'secondary' => array(
				'_' => 'Sekundārais šķirošanas kritērijs',
				'help' => 'Atbilstoši tikai tad, ja galvenais šķirošanas kritērijs ir kategorijas vai barotņu virsraksti',
			),
			'title_asc' => 'Virsraksts A→Z',
			'title_desc' => 'Virsraksts Z→A',
			'user_modified_asc' => 'Lietotāja mainīts 1→9',
			'user_modified_desc' => 'Lietotāja mainīts 9→1',
		),
		'starred' => 'Rādīt mīļākos',
		'stats' => 'Statistika',
		'subscription' => 'Abonementa pārvalde',
		'unread' => 'Rādīt neizlasītos',
	),
	'share' => 'Dalīties',
	'tag' => array(
		'related' => 'Raksta birkas',
	),
	'tos' => array(
		'title' => 'Pakalpojumu sniegšanas noteikumi',
	),
);

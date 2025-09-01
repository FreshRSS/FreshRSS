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
		'_' => 'Par vietni',
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
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => 'RSS plūsma %s',
		'title' => 'Galvenā plūsma',
		'title_fav' => 'Mīļākie',
		'title_global' => 'Globālais skats',
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
		'important' => 'Important feeds',	// TODO
		'main_stream' => 'Galvenā plūsma',
		'mark_all_read' => 'Atzīmēt visus kā izlasītus',
		'mark_cat_read' => 'Atzīmēt kategoriju kā izlasītu',
		'mark_feed_read' => 'Atzīmēt barotni kā izlasītu',
		'mark_selection_unread' => 'Atzīmēt izvēlni kā izlasītu',
		'mylabels' => 'Manas birkas',
		'newer_first' => 'Sākumā jaunākos',
		'non-starred' => 'Rādīt neiecienītākos',
		'normal_view' => 'Parastais skats',
		'older_first' => 'Sākumā vecākos',
		'queries' => 'Lietotāja pieprasījumi',
		'read' => 'Rādīt izlasītos',
		'reader_view' => 'Lasīšanas skats',
		'rss_view' => 'RSS barotne',
		'search_short' => 'Meklēt',
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

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
		'bugs_reports' => 'Ziņojumi par kļūdām',
		'credits' => 'Kredīti',
		'credits_content' => 'Daži dizaina elementi nāk no <a href="http://twitter.github.io/bootstrap/">Bootstrap</a>, lai gan FreshRSS neizmanto šo ietvaru. <a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">Ikonas</a> ir no <a href="https://www.gnome.org/">GNOME projekta</a>. <em>Open Sans</em> fontu policiju ir izveidojis <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a>. FreshRSS pamatā ir PHP ietvarstruktūra <a href="https://framagit.org/marienfressinaud/MINZ">Minz</a>.',
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
		'newer_first' => 'Sākumā jaunākos',
		'non-starred' => 'Rādīt neiecienītākos',
		'normal_view' => 'Parastais skats',
		'older_first' => 'Sākumā vecākos',
		'queries' => 'Lietotāja pieprasījumi',
		'read' => 'Rādīt izlasītos',
		'reader_view' => 'Lasīšanas skats',
		'rss_view' => 'RSS barotne',
		'search_short' => 'Meklēt',
		'starred' => 'Rādīt mīļākos',
		'stats' => 'Statistika',
		'subscription' => 'Abonementa pārvalde',
		'tags' => 'Manas birkas',
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

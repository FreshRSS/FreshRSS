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
		'_' => 'A prepaus',
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
		'bugs_reports' => 'Senhalament de problèmas',
		'documentation' => 'Documentation',	// TODO
		'freshrss_description' => 'FreshRSS es un agregador de fluxes RSS per l’auto-albergar tal. Sa tòca es d’èsser leugièr e de bon utilizar de prima abòrd mas tanben d’èsser potent e parametrable.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">sus GitHub</a>',
		'license' => 'Licéncia',
		'project_website' => 'Site del projècte',
		'title' => 'A prepaus',
		'version' => 'Version',	// IGNORE
	),
	'feed' => array(
		'empty' => 'I a pas cap de flux de mostrar.',
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => 'Flux RSS de %s',
		'title' => 'Flux màger',
		'title_fav' => 'Favorits',
		'title_global' => 'Vista generala',
	),
	'log' => array(
		'_' => 'Jornals d’audit',	// IGNORE
		'clear' => 'Escafar los jornals',
		'empty' => 'Los jornals son voids',
		'title' => 'Jornals d’audit',	// IGNORE
	),
	'menu' => array(
		'about' => 'A prepaus de FreshRSS',
		'before_one_day' => '1 jorn en arrièr',
		'before_one_week' => '1 setmana en arrièr',
		'bookmark_query' => 'Marcar aquesta requèsta',
		'favorites' => 'Favorits (%s)',
		'global_view' => 'Vista generala',
		'important' => 'Important feeds',	// TODO
		'main_stream' => 'Flux màger',
		'mark_all_read' => 'O marcar tot coma legit',
		'mark_cat_read' => 'Marcar la categoria coma legida',
		'mark_feed_read' => 'Marcar lo flux coma legit',
		'mark_selection_unread' => 'Marcar la seleccion coma pas legida',
		'mylabels' => 'Mas etiquetas',
		'newer_first' => 'Mai recents en primièr',
		'non-starred' => 'Mostrar los pas favorits',
		'normal_view' => 'Vista normala',
		'older_first' => 'Mai ancians en primièr',
		'queries' => 'Filtres utilizaire',
		'read' => 'Mostrar los legits',
		'reader_view' => 'Vista lectura',
		'rss_view' => 'Flux RSS',
		'search_short' => 'Recercar',
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
		'starred' => 'Mostrar los favorits',
		'stats' => 'Estatisticas',
		'subscription' => 'Gestion dels abonaments',
		'unread' => 'Mostar los pas legits',
	),
	'share' => 'Partejar',
	'tag' => array(
		'related' => 'Etiquetas ligadas',
	),
	'tos' => array(
		'title' => 'Condicions d’utilizacion',
	),
);

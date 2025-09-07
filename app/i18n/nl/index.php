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
		'_' => 'Over',
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
		'bugs_reports' => 'Rapporteer fouten',
		'documentation' => 'Documentatie',
		'freshrss_description' => 'FreshRSS is een RSS-feed aggregator om zelf te hosten. Het gebruikt weinig systeembronnen en is makkelijk te beheren terwijl het een krachtig en makkelijk te configureren programma is.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">op GitHub</a>',
		'license' => 'Licentie',
		'project_website' => 'Projectwebsite',
		'title' => 'Over',
		'version' => 'Versie',	// IGNORE
	),
	'feed' => array(
		'empty' => 'Er is geen artikel om te laten zien.',
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => 'RSS-feed van %s',
		'title' => 'Overzicht',
		'title_fav' => 'Favorieten',
		'title_global' => 'Globale weergave',
	),
	'log' => array(
		'_' => 'Log bestanden',
		'clear' => 'Leeg de log bestanden',
		'empty' => 'Log bestand is leeg',
		'title' => 'Log bestanden',
	),
	'menu' => array(
		'about' => 'Over FreshRSS',
		'before_one_day' => 'Ouder dan een dag',
		'before_one_week' => 'Ouder dan een week',
		'bookmark_query' => 'Huidige query opslaan',
		'favorites' => 'Favorieten (%s)',
		'global_view' => 'Globale weergave',
		'important' => 'Belangrijke feeds',
		'main_stream' => 'Overzicht',
		'mark_all_read' => 'Markeer alles als gelezen',
		'mark_cat_read' => 'Markeer categorie als gelezen',
		'mark_feed_read' => 'Markeer feed als gelezen',
		'mark_selection_unread' => 'Markeer selectie als ongelezen',
		'mylabels' => 'Mijn labels',
		'newer_first' => 'Nieuwste eerst',
		'non-starred' => 'Laat alles zien behalve favorieten',
		'normal_view' => 'Normale weergave',
		'older_first' => 'Oudste eerst',
		'queries' => 'Gebruikers queries',
		'read' => 'Laat alleen gelezen zien',
		'reader_view' => 'Lees modus',
		'rss_view' => 'RSS-feed',
		'search_short' => 'Zoeken',
		'sort' => array(
			'_' => 'Sorteercriteria',
			'c' => array(
				'name_asc' => 'Categorie, feedtitels A→Z',
				'name_desc' => 'Categorie, feedtitels Z→A',
			),
			'date_asc' => 'Publicatiedatum 1→9',
			'date_desc' => 'Publicatiedatum 9→1',
			'f' => array(
				'name_asc' => 'Feedtitel A→Z',
				'name_desc' => 'Feedtitel Z→A',
			),
			'id_asc' => 'Nieuw ontvangen laatst',
			'id_desc' => 'Nieuw ontvangen eerst',
			'link_asc' => 'Link A→Z',	// IGNORE
			'link_desc' => 'Link Z→A',	// IGNORE
			'rand' => 'Willekeurige volgorde',
			'title_asc' => 'Titel A→Z',
			'title_desc' => 'Titel Z→A',
		),
		'starred' => 'Laat alleen favorieten zien',
		'stats' => 'Statistieken',
		'subscription' => 'Abonnementen beheer',
		'unread' => 'Laat alleen ongelezen zien',
	),
	'share' => 'Delen',
	'tag' => array(
		'related' => 'Verwante labels',
	),
	'tos' => array(
		'title' => 'Gebruiksvoorwaarden',
	),
);

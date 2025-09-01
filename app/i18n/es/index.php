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
		'_' => 'Acerca de',
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
		'bugs_reports' => 'Informe de fallos',
		'documentation' => 'Documentación',
		'freshrss_description' => 'FreshRSS es un agregador de fuentes RSS de alojamiento privado. Es una herramienta potente, pero ligera y fácil de usar y configurar.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">en GitHub</a>',
		'license' => 'Licencia',
		'project_website' => 'Web del proyecto',
		'title' => 'Acerca de',
		'version' => 'Versión',
	),
	'feed' => array(
		'empty' => 'No hay artículos a mostrar.',
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => 'Fuente RSS de %s',
		'title' => 'Salida Principal',
		'title_fav' => 'Favoritos',
		'title_global' => 'Vista global',
	),
	'log' => array(
		'_' => 'Registros',
		'clear' => 'Limpiar registros',
		'empty' => 'El archivo de registro está vacío',
		'title' => 'Registros',
	),
	'menu' => array(
		'about' => 'Acerca de FreshRSS',
		'before_one_day' => 'Con más de 1 día',
		'before_one_week' => 'Con más de una semana',
		'bookmark_query' => 'Marcar consulta actual',
		'favorites' => 'Favoritos (%s)',
		'global_view' => 'Vista Global',
		'important' => 'Fuentes importantes',
		'main_stream' => 'Salida Principal',
		'mark_all_read' => 'Marcar todo como leído',
		'mark_cat_read' => 'Marcar categoría como leída',
		'mark_feed_read' => 'Marcar fuente como leída',
		'mark_selection_unread' => 'Marcar la selección como no leída',
		'mylabels' => 'Mis etiquetas',
		'newer_first' => 'Nuevos primero',
		'non-starred' => 'Mostrar todos menos los favoritos',
		'normal_view' => 'Vista normal',
		'older_first' => 'Más antiguos primero',
		'queries' => 'Peticiones de usuario',
		'read' => 'Mostrar solo los leídos',
		'reader_view' => 'Vista de lectura',
		'rss_view' => 'Fuente RSS',
		'search_short' => 'Buscar',
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
		'starred' => 'Mostrar solo los favoritos',
		'stats' => 'Estadísticas',
		'subscription' => 'Administración de suscripciones',
		'unread' => 'Mostrar solo no leídos',
	),
	'share' => 'Compartir',
	'tag' => array(
		'related' => 'Etiquetas relacionadas',
	),
	'tos' => array(
		'title' => 'Términos de servicio',
	),
);

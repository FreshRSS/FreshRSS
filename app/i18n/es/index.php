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
		'_' => 'Acerca de',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Información del sistema',
				'browser' => 'Navegador',
				'database' => 'Base de datos',
				'server_software' => 'Programas del servidor',
				'version_curl' => 'Versión de cURL',
				'version_frss' => 'Versión de FreshRSS',
				'version_php' => 'Versión de PHP',
			),
		),
		'bugs_reports' => 'Informe de fallos',
		'documentation' => 'Documentación',
		'freshrss_description' => 'FreshRSS es un agregador de fuentes RSS de alojamiento privado. Es una herramienta potente, pero ligera y fácil de usar y configurar.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">en GitHub</a>',
		'license' => 'Licencia',
		'project_website' => 'Página del proyecto',
		'title' => 'Acerca de',
		'version' => 'Versión',
	),
	'feed' => array(
		'empty' => 'No hay artículos a mostrar.',
		'published' => array(
			'_' => 'Publicado',
			'future' => 'Publicado en el futuro',
			'today' => 'Publicado hoy',
			'yesterday' => 'Publicado ayer',
		),
		'received' => array(
			'_' => 'Recibido',
			'today' => 'Recibido hoy',
			'yesterday' => 'Recibido ayer',
		),
		'rss_of' => 'Fuente RSS de %s',
		'title' => 'Bandeja principal',
		'title_fav' => 'Favoritos',
		'title_global' => 'Vista global',
		'userModified' => array(
			'_' => 'Modificado por usuario',
			'today' => 'Modificado por usuario hoy',
			'yesterday' => 'Modificado por usuario ayer',
		),
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
		'bookmark_query' => 'Guardar vista actual',
		'favorites' => 'Favoritos (%s)',
		'global_view' => 'Vista global',
		'important' => 'Fuentes importantes',
		'main_stream' => 'Bandeja principal',
		'mark_all_read' => 'Marcar todo como leído',
		'mark_cat_read' => 'Marcar categoría como leída',
		'mark_feed_read' => 'Marcar fuente como leída',
		'mark_selection_unread' => 'Marcar la selección como no leída',
		'mylabels' => 'Mis etiquetas',
		'non-starred' => 'Mostrar todos menos los favoritos',
		'normal_view' => 'Vista normal',
		'queries' => 'Búsquedas de usuario',
		'read' => 'Mostrar solo los leídos',
		'reader_view' => 'Vista de lectura',
		'rss_view' => 'Fuente RSS',
		'search_short' => 'Buscar',
		'sort' => array(
			'asc' => 'Ascending',	// TODO
			'c' => array(
				'name_asc' => 'Categoría, títulos de fuentes A→Z',
				'name_desc' => 'Categoría, títulos de fuentes Z→A',
			),
			'date_asc' => 'Fecha de publicación 1→9',
			'date_desc' => 'Fecha de publicación 9→1',
			'desc' => 'Descending',	// TODO
			'f' => array(
				'name_asc' => 'Título de fuente A→Z',
				'name_desc' => 'Título de fuente Z→A',
			),
			'id_asc' => 'Recién recibido último',
			'id_desc' => 'Recién recibido primero',
			'length_asc' => 'Longitud de contenido 1→9',
			'length_desc' => 'Longitud de contenido 9→1',
			'link_asc' => 'Enlace A→Z',
			'link_desc' => 'Enlace Z→A',
			'primary' => array(
				'_' => 'Sorting criterion',	// TODO
				'help' => 'Sorting by <em>received</em> date is recommended in most cases, for consistency and performance',	// TODO
			),
			'rand' => 'Orden aleatorio',
			'secondary' => array(
				'_' => 'Secondary sorting criterion',	// TODO
				'help' => 'Only relevant when the primary sorting criterion is categories or feeds titles',	// TODO
			),
			'title_asc' => 'Título A→Z',
			'title_desc' => 'Título Z→A',
			'user_modified_asc' => 'Modificado por usuario 1→9',
			'user_modified_desc' => 'Modificado por usuario 9→1',
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

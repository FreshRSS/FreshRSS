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
		'bugs_reports' => 'Informe de fallos',
		'credits' => 'Créditos',
		'credits_content' => 'Aunque FreshRSS no usa ese entorno, algunos elementos del diseño están obtenidos de <a href="http://twitter.github.io/bootstrap/">Bootstrap</a>. Los <a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">Iconos</a> han sido obtenidos del <a href="https://www.gnome.org/">proyecto GNOME</a>. La fuente <em>Open Sans</em> es una creación de <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a>. FreshRSS usa el entorno PHP <a href="https://framagit.org/marienfressinaud/MINZ">Minz</a>.',
		'documentation' => 'Documentacion',
		'freshrss_description' => 'FreshRSS es un agregador de fuentes RSS de alojamiento privado. Es una herramienta potente, pero ligera y fácil de usar y configurar.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">en GitHub</a>',
		'license' => 'Licencia',
		'project_website' => 'Web del proyecto',
		'title' => 'Acerca de',
		'version' => 'Versión',
	),
	'feed' => array(
		'empty' => 'No hay artículos a mostrar.',
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
		'important' => 'Feeds importantes',
		'main_stream' => 'Salida Principal',
		'mark_all_read' => 'Marcar todo como leído',
		'mark_cat_read' => 'Marcar categoría como leída',
		'mark_feed_read' => 'Marcar fuente como leída',
		'mark_selection_unread' => 'Marcar la selección como no leída',
		'newer_first' => 'Nuevos primero',
		'non-starred' => 'Mostrar todos menos los favoritos',
		'normal_view' => 'Vista normal',
		'older_first' => 'Más antiguos primero',
		'queries' => 'Peticiones de usuario',
		'read' => 'Mostrar solo los leídos',
		'reader_view' => 'Vista de lectura',
		'rss_view' => 'Fuente RSS',
		'search_short' => 'Buscar',
		'starred' => 'Mostrar solo los favoritos',
		'stats' => 'Estadísticas',
		'subscription' => 'Administración de suscripciones',
		'tags' => 'Mis etiquetas',
		'unread' => 'Mostar solo no leídos',
	),
	'share' => 'Compartir',
	'tag' => array(
		'related' => 'Etiquetas relacionadas',
	),
	'tos' => array(
		'title' => 'Términos de servicio',
	),
);

<?php

return array(
	'archiving' => array(
		'_' => 'Archivo',
		'delete_after' => 'Eliminar artículos tras',
		'exception' => 'Purge exception',	// TODO - Translation
		'help' => 'Hay más opciones disponibles en los ajustes de la fuente',
		'keep_favourites' => 'Never delete favourites',	// TODO - Translation
		'keep_labels' => 'Never delete labels',	// TODO - Translation
		'keep_max' => 'Maximum number of articles to keep',	// TODO - Translation
		'keep_min_by_feed' => 'Número mínimo de artículos a conservar por fuente',
		'keep_period' => 'Maximum age of articles to keep',	// TODO - Translation
		'keep_unreads' => 'Never delete unread articles',	// TODO - Translation
		'maintenance' => 'Maintenance',	// TODO - Translation
		'optimize' => 'Optimizar la base de datos',
		'optimize_help' => 'Ejecuta la optimización de vez en cuando para reducir el tamaño de la base de datos',
		'policy' => 'Purge policy',	// TODO - Translation
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',	// TODO - Translation
		'purge_now' => 'Limpiar ahora',
		'title' => 'Archivo',
		'ttl' => 'No actualizar automáticamente más de',
	),
	'display' => array(
		'_' => 'Visualización',
		'icon' => array(
			'bottom_line' => 'Línea inferior',
			'display_authors' => 'Authors',	// TODO - Translation
			'entry' => 'Iconos de artículos',
			'publication_date' => 'Fecha de publicación',
			'related_tags' => 'Etiquetas relacionadas',
			'sharing' => 'Compartir',
			'top_line' => 'Línea superior',
		),
		'language' => 'Idioma',
		'notif_html5' => array(
			'seconds' => 'segundos (0 significa sin límite de espera)',
			'timeout' => 'Notificación de fin de espera HTML5',
		),
		'show_nav_buttons' => 'Show the navigation buttons',	// TODO - Translation
		'theme' => 'Tema',
		'title' => 'Visualización',
		'width' => array(
			'content' => 'Ancho de contenido',
			'large' => 'Grande',
			'medium' => 'Mediano',
			'no_limit' => 'Sin límite',
			'thin' => 'Estrecho',
		),
	),
	'profile' => array(
		'_' => 'Administración de perfiles',
		'api' => 'API management',	// TODO - Translation
		'delete' => array(
			'_' => 'Borrar cuenta',
			'warn' => 'Tu cuenta y todos los datos asociados serán eliminados.',
		),
		'email' => 'Correo electrónico',
		'password_api' => 'Contraseña API <br /><small>(para apps móviles, por ej.)</small>',
		'password_form' => 'Contraseña<br /><small>(para el método de identificación por formulario web)</small>',
		'password_format' => 'Mínimo de 7 caracteres',
		'title' => 'Perfil',
	),
	'query' => array(
		'_' => 'Consultas de usuario',
		'deprecated' => 'Esta consulta ya no es válida. La categoría referenciada o fuente ha sido eliminada.',
		'display' => 'Display user query results',	// TODO - Translation
		'filter' => 'Filtro aplicado:',
		'get_all' => 'Mostrar todos los artículos',
		'get_category' => 'Mostrar la categoría "%s"',
		'get_favorite' => 'Mostrar artículos favoritos',
		'get_feed' => 'Mostrar fuente "%s"',
		'name' => 'Name',	// TODO - Translation
		'no_filter' => 'Sin filtro',
		'none' => 'Todavía no has creado ninguna consulta de usuario.',
		'number' => 'Consulta n° %d',
		'order_asc' => 'Mostrar primero los artículos más antiguos',
		'order_desc' => 'Mostrar primero los artículos más recientes',
		'remove' => 'Remove user query',	// TODO - Translation
		'search' => 'Buscar "%s"',
		'state_0' => 'Mostrar todos los artículos',
		'state_1' => 'Mostrar artículos leídos',
		'state_2' => 'Mostrar artículos pendientes',
		'state_3' => 'Mostrar todos los artículos',
		'state_4' => 'Mostrar artículos favoritos',
		'state_5' => 'Mostrar artículos favoritos leídos',
		'state_6' => 'Mostrar artículos favoritos pendientes',
		'state_7' => 'Mostrar artículos favoritos',
		'state_8' => 'Mostrar artículos no favoritos',
		'state_9' => 'Mostrar artículos no favoritos leídos',
		'state_10' => 'Mostrar artículos no favoritos pendientes',
		'state_11' => 'Mostrar artículos no favoritos',
		'state_12' => 'Mostrar todos los artículos',
		'state_13' => 'Mostrar artículos leídos',
		'state_14' => 'Mostrar artículos sin leer',
		'state_15' => 'Mostrar todos los artículos',
		'title' => 'Consultas de usuario',
		'url' => 'URL',	// TODO - Translation
	),
	'reading' => array(
		'_' => 'Lectura',
		'after_onread' => 'Tras “marcar todo como leído”,',
		'always_show_favorites' => 'Show all articles in favourites by default',	// TODO - Translation
		'articles_per_page' => 'Número de artículos por página',
		'auto_load_more' => 'Cargar más artículos al final de la página',
		'auto_remove_article' => 'Ocultar artículos tras la lectura',
		'confirm_enabled' => 'Mostrar ventana de confirmación al usar la función “marcar todos como leídos”',
		'display_articles_unfolded' => 'Mostrar los artículos expandidos por defecto',
		'display_categories_unfolded' => 'Categories to unfold',	// TODO - Translation
		'hide_read_feeds' => 'Ocultar categorías & fuentes sin artículos no leídos (no funciona con la configuración "Mostrar todos los artículos")',
		'img_with_lazyload' => 'Usar el modo de "carga perezosa" para las imágenes',
		'jump_next' => 'saltar al siguiente archivo sin leer emparentado (fuente o categoría)',
		'mark_updated_article_unread' => 'Marcar artículos actualizados como no leídos',
		'number_divided_when_reader' => 'Dividido en 2 en la vista de lectura.',
		'read' => array(
			'article_open_on_website' => 'cuando el artículo se abra en su web original',
			'article_viewed' => 'cuando se muestre el artículo',
			'scroll' => 'durante el desplazamiento',
			'upon_reception' => 'al recibir el artículo',
			'when' => 'Marcar el artículo como leído…',
		),
		'show' => array(
			'_' => 'Artículos a mostrar',
			'active_category' => 'Active category',	// TODO - Translation
			'adaptive' => 'Ajustar la visualización',
			'all_articles' => 'Mostrar todos los artículos',
			'all_categories' => 'All categories',	// TODO - Translation
			'no_category' => 'No category',	// TODO - Translation
			'remember_categories' => 'Remember open categories',	// TODO - Translation
			'unread' => 'Mostrar solo pendientes',
		),
		'sides_close_article' => 'Pinchar fuera del área de texto del artículo lo cerrará',
		'sort' => array(
			'_' => 'Orden',
			'newer_first' => 'Nuevos primero',
			'older_first' => 'Antiguos primero',
		),
		'sticky_post' => 'Pegar el artículo a la parte superior al abrirlo',
		'title' => 'Lectura',
		'view' => array(
			'default' => 'Vista por defecto',
			'global' => 'Vista Global',
			'normal' => 'Vista Normal',
			'reader' => 'Vista de Lectura',
		),
	),
	'sharing' => array(
		'_' => 'Compartir',
		'add' => 'Add a sharing method',	// TODO - Translation
		'blogotext' => 'Blogotext',	// TODO - Translation
		'diaspora' => 'Diaspora*',	// TODO - Translation
		'email' => 'Email',	// TODO - Translation
		'facebook' => 'Facebook',	// TODO - Translation
		'more_information' => 'Más información',
		'print' => 'Print',	// TODO - Translation
		'remove' => 'Remove sharing method',	// TODO - Translation
		'shaarli' => 'Shaarli',	// TODO - Translation
		'share_name' => 'Compartir nombre a mostrar',
		'share_url' => 'Compatir URL a usar',
		'title' => 'Compartir',
		'twitter' => 'Twitter',	// TODO - Translation
		'wallabag' => 'wallabag',	// TODO - Translation
	),
	'shortcut' => array(
		'_' => 'Atajos de teclado',
		'article_action' => 'Acciones de artículo',
		'auto_share' => 'Compartir',
		'auto_share_help' => 'Si solo hay un modo para compartir, ese será el que se use. En caso contrario los modos quedarán accesibles por su numeración.',
		'close_dropdown' => 'Cerrar menús',
		'collapse_article' => 'Contraer',
		'first_article' => 'Saltar al primer artículo',
		'focus_search' => 'Acceso a la casilla de búsqueda',
		'global_view' => 'Switch to global view',	// TODO - Translation
		'help' => 'Mostrar documentación',
		'javascript' => 'JavaScript debe estar activado para poder usar atajos de teclado',
		'last_article' => 'Saltar al último artículo',
		'load_more' => 'Cargar más artículos',
		'mark_favorite' => 'Marcar como favorito',
		'mark_read' => 'Marcar como leído',
		'navigation' => 'Navegación',
		'navigation_help' => 'Con el modificador <kbd>⇧ Mayúsculas</kbd> es posible usar los atajos de teclado en las fuentes.<br/>Con el modificador <kbd>Alt ⎇</kbd> es posible aplicar los atajos de teclado en las categorías.',
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',	// TODO - Translation
		'next_article' => 'Saltar al siguiente artículo',
		'normal_view' => 'Switch to normal view',	// TODO - Translation
		'other_action' => 'Otras acciones',
		'previous_article' => 'Saltar al artículo anterior',
		'reading_view' => 'Switch to reading view',	// TODO - Translation
		'rss_view' => 'Open RSS view in a new tab',	// TODO - Translation
		'see_on_website' => 'Ver en la web original',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',	// TODO - Translation
		'skip_next_article' => 'Focus next without opening',	// TODO - Translation
		'skip_previous_article' => 'Focus previous without opening',	// TODO - Translation
		'title' => 'Atajos de teclado',
		'toggle_media' => 'Play/pause media',	// TODO - Translation
		'user_filter' => 'Acceso a filtros de usuario',
		'user_filter_help' => 'Si solo hay un filtro de usuario, ese será el que se use. En caso contrario, los filtros están accesibles por su númeración.',
		'views' => 'Views',	// TODO - Translation
	),
	'user' => array(
		'articles_and_size' => '%s artículos (%s)',
		'current' => 'Usuario actual',
		'is_admin' => 'es administrador',
		'users' => 'Usuarios',
	),
);

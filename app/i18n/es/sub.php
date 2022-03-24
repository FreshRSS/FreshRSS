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
	'api' => array(
		'documentation' => 'Copie la siguiente URL para usarla dentro de una herramienta externa.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Arrastre este botón a la barra de herramientas de marcadores o haga clic derecho en él y elija "Marcar este enlace". Luego haga clic en el botón "Suscribirse" en cualquier página a la que desee suscribirse.',
		'label' => 'Subscribirse',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Categoría',
		'add' => 'Añadir categoría',
		'archiving' => 'Archivo',
		'empty' => 'Vaciar categoría',
		'information' => 'Información',
		'position' => 'Posición de visualización',
		'position_help' => 'Para controlar el orden de clasificación de categorías',
		'title' => 'Título',
	),
	'feed' => array(
		'add' => 'Añadir fuente RSS',
		'advanced' => 'Avanzado',
		'archiving' => 'Archivo',
		'auth' => array(
			'configuration' => 'Identificación',
			'help' => 'Permitir acceso a fuentes RSS protegidas con HTTP',
			'http' => 'Identificación HTTP',
			'password' => 'Contraseña HTTP',
			'username' => 'Nombre de usuario HTTP',
		),
		'clear_cache' => 'Borrar siempre la memoria caché',
		'content_action' => array(
			'_' => 'Acción de contenido al obtener el contenido del artículo',
			'append' => 'Agregar después del contenido existente',
			'prepend' => 'Agregar antes del contenido existente',
			'replace' => 'Reemplazar contenido existente',
		),
		'css_cookie' => 'Usar cookies al obtener el contenido del artículo',
		'css_cookie_help' => 'Ejemplo: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Recibir fuentes RSS truncadas (aviso, ¡necesita más tiempo!)',
		'css_path' => 'Ruta a la CSS de los artículos en la web original',
		'description' => 'Descripción',
		'empty' => 'La fuente está vacía. Por favor, verifica que siga activa.',
		'error' => 'Hay un problema con esta fuente. Por favor, veritica que esté disponible y prueba de nuevo.',
		'filteractions' => array(
			'_' => 'Filtrar acciones',
			'help' => 'Escribir un filtro de búsqueda por línea.',
		),
		'information' => 'Información',
		'keep_min' => 'Número mínimo de artículos a conservar',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>//title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'Example: <code>//div[@class="news-item"]</code>',	// TODO
				),
				'item_author' => array(
					'_' => 'item author',	// TODO
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',	// TODO
				),
				'item_categories' => 'items tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Example to take the full item: <code>.</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>descendant::img/@src</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => array(
					'_' => 'item title',	// TODO
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> like <code>descendant::h2</code>',	// TODO
				),
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>descendant::a/@href</code>',	// TODO
				),
				'relative' => 'XPath (relative to item) for:',	// TODO
				'xpath' => 'XPath for:',	// TODO
			),
			'rss' => 'RSS / Atom (default)',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'Borrar caché',
			'clear_cache_help' => 'Borrar la memoria caché de esta fuente.',
			'reload_articles' => 'Recargar artículos',
			'reload_articles_help' => 'Vuelva a cargar artículos y obtenga contenido completo si se define un selector.',
			'title' => 'Mantenimiento',
		),
		'moved_category_deleted' => 'Al borrar una categoría todas sus fuentes pasan automáticamente a la categoría <em>%s</em>.',
		'mute' => 'silenciar',
		'no_selected' => 'No hay funentes seleccionadas.',
		'number_entries' => '%d artículos',
		'priority' => array(
			'_' => 'Visibilidad',
			'archived' => 'No mostrar (archivado)',
			'main_stream' => 'Mostrar en salida principal',
			'normal' => 'Mostrar en su categoría',
		),
		'proxy' => 'Establecer un proxy para obtener esta fuente',
		'proxy_help' => 'Seleccione un protocolo (e.g: SOCKS5) e introduzca la dirección del proxy (e.g: <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Mostrar código fuente',
			'show_rendered' => 'Mostrar contenido',
		),
		'show' => array(
			'all' => 'Mostrar todos los feeds',
			'error' => 'Mostrar solo feeds con errores',
		),
		'showing' => array(
			'error' => 'Mostrar solo feeds con errores',
		),
		'ssl_verify' => 'Verificar la seguridad SSL',
		'stats' => 'Estadísticas',
		'think_to_add' => 'Puedes añadir fuentes.',
		'timeout' => 'Tiempo de espera en segundos',
		'title' => 'Título',
		'title_add' => 'Añadir fuente RSS',
		'ttl' => 'No actualizar de forma automática con una frecuencia mayor a',
		'url' => 'URL de la fuente',
		'useragent' => 'Selecciona el agente de usario por recuperar la fuente',
		'useragent_help' => 'Ejemplo: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Verifica la validez de la fuente',
		'website' => 'Web de la URL',
		'websub' => 'Notificación inmedaiata con WebSub',
	),
	'import_export' => array(
		'export' => 'Exportar',
		'export_labelled' => 'Exporta tus artículos etiquetados',
		'export_opml' => 'Exportar la lista de fuentes (OPML)',
		'export_starred' => 'Exportar tus favoritos',
		'feed_list' => 'Lista de %s artículos',
		'file_to_import' => 'Archivo a importar<br />(OPML, JSON o ZIP)',
		'file_to_import_no_zip' => 'Archivo a importar<br />(OPML o JSON)',
		'import' => 'Importar',
		'starred_list' => 'Lista de artículos favoritos',
		'title' => 'Importar / exportar',
	),
	'menu' => array(
		'add' => 'Agregar un feed o una categoría',
		'import_export' => 'Importar / exportar',
		'label_management' => 'Gestión de etiquetas',
		'stats' => array(
			'idle' => 'Fuentes inactivas',
			'main' => 'Estadísticas principañes',
			'repartition' => 'Reparto de artículos',
		),
		'subscription_management' => 'Administración de suscripciones',
		'subscription_tools' => 'Herramientas de suscripción',
	),
	'tag' => array(
		'name' => 'Nombre',
		'new_name' => 'Nuevo nombre',
		'old_name' => 'Nombre antiguo',
	),
	'title' => array(
		'_' => 'Administración de suscripciones',
		'add' => 'Agregar un feed o una categoría',
		'add_category' => 'Agregar una categoría',
		'add_feed' => 'Añadir un feed',
		'add_label' => 'Añadir una etiqueta',
		'delete_label' => 'Eliminar una etiqueta',
		'feed_management' => 'Administración de fuentes RSS',
		'rename_label' => 'Cambiar el nombre de una etiqueta',
		'subscription_tools' => 'Herramientas de suscripción',
	),
);

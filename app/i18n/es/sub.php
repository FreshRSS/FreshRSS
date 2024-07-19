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
		'documentation' => 'Arrastre este botón a la barra de herramientas de marcadores o haga clic derecho en él y elija “Marcar este enlace”. Luego haga clic en el botón “Suscribirse” en cualquier página a la que desee suscribirse.',
		'label' => 'Subscribirse',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Categoría',
		'add' => 'Añadir categoría',
		'archiving' => 'Archivo',
		'dynamic_opml' => array(
			'_' => 'OPML dinámico',
			'help' => 'Provee la URL a un <a href=http://opml.org/ target="_blank">archivo OPML</a> para llenar dinámicamente esta categoría con fuentes',
		),
		'empty' => 'Vaciar categoría',
		'expand' => 'Expandir categoría',
		'information' => 'Información',
		'open' => 'Abrir categoría',
		'opml_url' => 'URL del OPML',
		'position' => 'Posición de visualización',
		'position_help' => 'Para controlar el orden de clasificación de categorías',
		'title' => 'Título',
	),
	'feed' => array(
		'accept_cookies' => 'Aceptar cookies',
		'accept_cookies_help' => 'Permitir que el servidor de fuentes configure las cookies (guardadas en memoria únicamente para el tiempo de vida de la solicitud)',
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
			'append' => 'Añadir después del contenido existente',
			'prepend' => 'Añadir antes del contenido existente',
			'replace' => 'Reemplazar contenido existente',
		),
		'css_cookie' => 'Usar cookies al obtener el contenido del artículo',
		'css_cookie_help' => 'Ejemplo: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Recibir fuentes RSS truncadas (aviso, ¡necesita más tiempo!)',
		'css_path' => 'Ruta a la CSS de los artículos en la web original',
		'css_path_filter' => array(
			'_' => 'Selector CSS de los elementos a remover',
			'help' => 'Un selector CSS puede ser una lista, por ejemplo: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Descripción',
		'empty' => 'La fuente está vacía. Por favor, verifica que siga activa.',
		'error' => 'Hay un problema con esta fuente. Por favor, verifica que esté disponible y prueba de nuevo.',
		'export-as-opml' => array(
			'download' => 'Descargar',
			'help' => 'archivo XML (data subset. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">See documentation</a>)',	// DIRTY
			'label' => 'Exportar como OPML',
		),
		'filteractions' => array(
			'_' => 'Filtrar acciones',
			'help' => 'Escribir un filtro de búsqueda por línea. Ver <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">documentación de operadores de búsqueda</a>.',
		),
		'information' => 'Información',
		'keep_min' => 'Número mínimo de artículos a conservar',
		'kind' => array(
			'_' => 'Tipo de origen de la fuente',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'Título de la fuente',
					'help' => 'Ejemplo: <code>//título</code> o un texto estático: <code>"Mi fuente personalizada"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> es un lenguaje de consulta estándar para usuarios avanzados, el cual FreshRSS soporta para habilitar Web scraping',
				'item' => array(
					'_' => 'encontrando <strong>noticias</strong> <br /><small>(más importante)</small>',
					'help' => 'Ejemplo: <code>//div[@class="elemento-noticias"]</code>',
				),
				'item_author' => array(
					'_' => 'author del elemento',
					'help' => 'También puede ser un texto estático. Ejemplo: <code>"Anónimo"</code>',
				),
				'item_categories' => 'etiquetas del elemento',
				'item_content' => array(
					'_' => 'contenido del elemento',
					'help' => 'Ejemplo para tomar el elemento completo: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'miniatura del elemento',
					'help' => 'Ejemplo: <code>descendiente::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Formato personalizado de fecha y hora',
					'help' => 'Opcional. Un formato compatible con <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> como <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'fecha del elemento',
					'help' => 'El resultado será analizado por <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'título del elemento',
					'help' => 'Usar en particular el <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">eje XPath</a> <code>descendiente::</code> como <code>descendiente::h2</code>',
				),
				'item_uid' => array(
					'_' => 'ID único del elemento',
					'help' => 'Opcional. Ejemplo: <code>descendente::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'enlace del elemento (URL)',
					'help' => 'Ejemplo: <code>descendente::a/@href</code>',
				),
				'relative' => 'XPath (relativo al elemento) para:',
				'xpath' => 'XPath para:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (notación de punto)',
				'feed_title' => array(
					'_' => 'título de la fuente',
					'help' => 'Ejemplo: <code>meta.title</code> o texto estático: <code>"Fuente personalizada"</code>',
				),
				'help' => 'Un punto JSON anotado utiliza puntos entre objetos y corchetes para matrices (ejemplo: <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'buscando nuevos <strong>items</strong><br /><small>(más importante)</small>',
					'help' => 'Ruta JSON a la matriz que contiene los elementos, ejemplo: <code>newsItems</code>',
				),
				'item_author' => 'autor del item',
				'item_categories' => 'etiquetas del item',
				'item_content' => array(
					'_' => 'contenido del item',
					'help' => 'Clave bajo la cual se encuentra el contenido, ejemplo: <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'miniatura del item',
					'help' => 'Ejemplo: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'fecha/hora personalizada',
					'help' => 'Opcional. Formato soportado por <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> como <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'fecha del item',
					'help' => 'El resultado será analizado por <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'título del item',
				'item_uid' => 'ID único del item',
				'item_uri' => array(
					'_' => 'enlace del item (URL)',
					'help' => 'Ejemplo: <code>permalink</code>',
				),
				'json' => 'notación de punto por:',
				'relative' => 'ruta de notación con puntos (relativa al elemento) para:',
			),
			'jsonfeed' => 'Fuente JSON',
			'rss' => 'RSS / Atom (por defecto)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Borrar caché',
			'clear_cache_help' => 'Borrar la memoria caché de esta fuente.',
			'reload_articles' => 'Recargar artículos',
			'reload_articles_help' => 'Vuelve a cargar artículos y obtiene contenido completo si se define un selector.',
			'title' => 'Mantenimiento',
		),
		'max_http_redir' => 'Máximas redirecciones HTTP',
		'max_http_redir_help' => 'Escribir 0 o dejarlo en blanco para deshabilitar, -1 para redirecciones ilimitadas',
		'method' => array(
			'_' => 'HTTP Method',	// IGNORE
		),
		'method_help' => 'La carga útil del POST tiene soporte automático para <code>application/x-www-form-urlencoded</code> y <code>application/json</code>',
		'method_postparams' => 'Carga útil para POST',
		'moved_category_deleted' => 'Al borrar una categoría todas sus fuentes pasan automáticamente a la categoría <em>%s</em>.',
		'mute' => array(
			'_' => 'silenciar',
			'state_is_muted' => 'Esta fuente está silenciada',
		),
		'no_selected' => 'No hay fuentes seleccionadas.',
		'number_entries' => '%d artículos',
		'open_feed' => 'Fuente abierta %s',
		'priority' => array(
			'_' => 'Visibilidad',
			'archived' => 'No mostrar (archivado)',
			'category' => 'Mostrar en su categoría',
			'important' => 'Mostrar en fuentes importantes',
			'main_stream' => 'Mostrar en salida principal',
		),
		'proxy' => 'Establecer un proxy para obtener esta fuente',
		'proxy_help' => 'Seleccione un protocolo (e.g: SOCKS5) e introduzca la dirección del proxy (e.g: <kbd>127.0.0.1:1080</kbd> o <kbd>username:password@127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Mostrar código fuente',
			'show_rendered' => 'Mostrar contenido',
		),
		'show' => array(
			'all' => 'Mostrar todas las fuentes',
			'error' => 'Mostrar solo fuentes con errores',
		),
		'showing' => array(
			'error' => 'Mostrar solo fuentes con errores',
		),
		'ssl_verify' => 'Verificar la seguridad SSL',
		'stats' => 'Estadísticas',
		'think_to_add' => 'Puedes añadir fuentes.',
		'timeout' => 'Tiempo de espera en segundos',
		'title' => 'Título',
		'title_add' => 'Añadir fuente RSS',
		'ttl' => 'No actualizar de forma automática con una frecuencia mayor a',
		'url' => 'URL de la fuente',
		'useragent' => 'Selecciona el agente de usuario por recuperar la fuente',
		'useragent_help' => 'Ejemplo: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Verifica la validez de la fuente',
		'website' => 'Web de la URL',
		'websub' => 'Notificación inmediata con WebSub',
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
		'add' => 'Añadir una fuente o categoría',
		'import_export' => 'Importar / exportar',
		'label_management' => 'Gestión de etiquetas',
		'stats' => array(
			'idle' => 'Fuentes inactivas',
			'main' => 'Estadísticas principales',
			'repartition' => 'Reparto de artículos',
		),
		'subscription_management' => 'Administración de suscripciones',
		'subscription_tools' => 'Herramientas de suscripción',
	),
	'tag' => array(
		'auto_label' => 'Añadir esta etiqueta a nuevos artículos',
		'name' => 'Nombre',
		'new_name' => 'Nuevo nombre',
		'old_name' => 'Nombre antiguo',
	),
	'title' => array(
		'_' => 'Administración de suscripciones',
		'add' => 'Añadir una fuente o categoría',
		'add_category' => 'Añadir una categoría',
		'add_dynamic_opml' => 'Agrega un OPML dinámico',
		'add_feed' => 'Añadir una fuente',
		'add_label' => 'Añadir una etiqueta',
		'delete_label' => 'Eliminar una etiqueta',
		'feed_management' => 'Administración de fuentes RSS',
		'rename_label' => 'Cambiar el nombre de una etiqueta',
		'subscription_tools' => 'Herramientas de suscripción',
	),
);

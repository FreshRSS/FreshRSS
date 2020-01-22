<?php

return array(
	'api' => array(
		'documentation' => 'Copy the following URL to use it within an external tool.',	// TODO - Translation
		'title' => 'API',	// TODO - Translation
	),
	'bookmarklet' => array(
		'documentation' => 'Drag this button to your bookmarks toolbar or right-click it and choose "Bookmark This Link". Then click "Subscribe" button in any page you want to subscribe to.',	// TODO - Translation
		'label' => 'Subscribe',	// TODO - Translation
		'title' => 'Bookmarklet',	// TODO - Translation
	),
	'category' => array(
		'add' => 'Añadir a la categoría',
		'archiving' => 'Archivo',
		'empty' => 'Vaciar categoría',
		'information' => 'Información',
		'new' => 'Nueva categoría',
		'position' => 'Display position',	// TODO - Translation
		'position_help' => 'To control category sort order',	// TODO - Translation
		'title' => 'Título',
		'_' => 'Categoría',
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
		'clear_cache' => 'Always clear cache',	// TODO - Translation
		'css_help' => 'Recibir fuentes RSS truncadas (aviso, ¡necesita más tiempo!)',
		'css_path' => 'Ruta a la CSS de los artículos en la web original',
		'description' => 'Descripción',
		'empty' => 'La fuente está vacía. Por favor, verifica que siga activa.',
		'error' => 'Hay un problema con esta fuente. Por favor, veritica que esté disponible y prueba de nuevo.',
		'filteractions' => array(
			'help' => 'Write one search filter per line.',	// TODO - Translation
			'_' => 'Filter actions',	// TODO - Translation
		),
		'information' => 'Información',
		'keep_min' => 'Número mínimo de artículos a conservar',
		'maintenance' => array(
			'clear_cache' => 'Clear cache',	// TODO - Translation
			'clear_cache_help' => 'Clear the cache of this feed on disk',	// TODO - Translation
			'reload_articles' => 'Reload articles',	// TODO - Translation
			'reload_articles_help' => 'Reload articles and fetch complete content',	// TODO - Translation
			'title' => 'Maintenance',	// TODO - Translation
		),
		'moved_category_deleted' => 'Al borrar una categoría todas sus fuentes pasan automáticamente a la categoría <em>%s</em>.',
		'mute' => 'mute',	// TODO - Translation
		'no_selected' => 'No hay funentes seleccionadas.',
		'number_entries' => '%d artículos',
		'priority' => array(
			'archived' => 'Do not show (archived)',	// TODO - Translation
			'main_stream' => 'Mostrar en salida principal',
			'normal' => 'Show in its category',	// TODO - Translation
			'_' => 'Visibility',	// TODO - Translation
		),
		'selector_preview' => array(
			'show_raw' => 'Show source',	// TODO - Translation
			'show_rendered' => 'Show content',	// TODO - Translation
		),
		'show' => array(
			'all' => 'Show all feeds',	// TODO - Translation
			'error' => 'Show only feeds with error',	// TODO - Translation
		),
		'showing' => array(
			'error' => 'Showing only feeds with error',	// TODO - Translation
		),
		'ssl_verify' => 'Verify SSL security',	// TODO - Translation
		'stats' => 'Estadísticas',
		'think_to_add' => 'Puedes añadir fuentes.',
		'timeout' => 'Timeout in seconds',	// TODO - Translation
		'title' => 'Título',
		'title_add' => 'Añadir fuente RSS',
		'ttl' => 'No actualizar de forma automática con una frecuencia mayor a',
		'url' => 'URL de la fuente',
		'validator' => 'Verifica la validez de la fuente',
		'website' => 'Web de la URL',
		'websub' => 'Notificación inmedaiata con WebSub',
	),
	'firefox' => array(
		'documentation' => 'Follow the steps described <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">here</a> to add FreshRSS to Firefox feed reader list.',	// TODO - Translation
		'obsolete_63' => 'From version 63 and onwards, Firefox has removed the ability to add your own subscription services that are not standalone programs.',	// TODO - Translation
		'title' => 'Firefox feed reader',	// TODO - Translation
	),
	'import_export' => array(
		'export' => 'Exportar',
		'export_labelled' => 'Export your labelled articles',	// TODO - Translation
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
		'bookmark' => 'Suscribirse (favorito FreshRSS)',
		'import_export' => 'Importar / exportar',
		'subscription_management' => 'Administración de suscripciones',
		'subscription_tools' => 'Subscription tools',	// TODO - Translation
	),
	'title' => array(
		'feed_management' => 'Administración de fuentes RSS',
		'subscription_tools' => 'Subscription tools',	// TODO - Translation
		'_' => 'Administración de suscripciones',
	),
);

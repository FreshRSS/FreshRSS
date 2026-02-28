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
	'action' => array(
		'actualize' => 'Actualizar fuentes',
		'add' => 'Añadir',
		'back_to_rss_feeds' => '← regresar a tus fuentes RSS',
		'cancel' => 'Cancelar',
		'close' => 'Cerrar',
		'create' => 'Crear',
		'delete_all_feeds' => 'Eliminar todas las fuentes',
		'delete_errored_feeds' => 'Eliminar fuentes con errores',
		'delete_muted_feeds' => 'Eliminar fuentes silenciadas',
		'demote' => 'Degradar',
		'disable' => 'Desactivar',
		'download' => 'Descargar',
		'empty' => 'Vaciar',
		'enable' => 'Activar',
		'export' => 'Exportar',
		'filter' => 'Filtrar',
		'import' => 'Importar',
		'load_default_shortcuts' => 'Cargar accesos directos predeterminados',
		'manage' => 'Administrar',
		'mark_read' => 'Marcar como leído',
		'menu' => array(
			'open' => 'Abrir menú',
		),
		'nav_buttons' => array(
			'next' => 'Siguiente artículo',
			'prev' => 'Anterior artículo',
			'up' => 'Ir arriba',
		),
		'open_url' => 'Abrir URL',
		'promote' => 'Promover',
		'purge' => 'Eliminar',
		'refresh_opml' => 'Actualizar OPML',
		'remove' => 'Borrar',
		'rename' => 'Cambiar el nombre a',
		'see_website' => 'Ver página',
		'submit' => 'Enviar',
		'truncate' => 'Borrar todos los artículos',
		'update' => 'Actualizar',
	),
	'auth' => array(
		'accept_tos' => 'Acepto los <a href="%s">Términos de Servicio</a>.',
		'email' => 'Correo electrónico',
		'keep_logged_in' => 'Mantenerme identificado <small>(%s días)</small>',
		'login' => 'Conectar',
		'logout' => 'Desconectar',
		'password' => array(
			'_' => 'Contraseña',
			'format' => '<small>Mínimo de 7 caracteres</small>',
		),
		'reauth' => array(
			'header' => 'Se requiere reautenticación',
			'tip' => 'No se te pedirá que inicies sesión de nuevo durante <u>%d minutos</u>',
			'title' => 'Reautenticación',
		),
		'registration' => array(
			'_' => 'Nueva cuenta',
			'ask' => '¿Crear una cuenta?',
			'title' => 'Creación de cuenta',
		),
		'username' => array(
			'_' => 'Nombre de usuario',
			'format' => '<small>Máximo 16 caracteres alfanuméricos</small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\b\\r\\i\\l',
		'Aug' => '\\A\\g\\o\\s\\t\\o',
		'Dec' => '\\D\\i\\c\\i\\e\\m\\b\\r\\e',
		'Feb' => '\\F\\e\\b\\r\\e\\r\\o',
		'Jan' => '\\E\\n\\e\\r\\o',
		'Jul' => '\\J\\u\\l\\i\\o',
		'Jun' => '\\J\\u\\n\\i\\o',
		'Mar' => '\\M\\a\\r\\z\\o',
		'May' => '\\M\\a\\y\\o',
		'Nov' => '\\N\\o\\v\\i\\e\\m\\b\\r\\e',
		'Oct' => '\\O\\c\\t\\u\\b\\r\\e',
		'Sep' => '\\S\\e\\p\\t\\i\\e\\m\\b\\r\\e',
		'apr' => 'abr',
		'april' => 'abril',
		'aug' => 'ago',
		'august' => 'agosto',
		'before_yesterday' => 'anteayer',
		'dec' => 'dic',
		'december' => 'diciembre',
		'feb' => 'feb',
		'february' => 'febrero',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\a\\t H\\:i',	// IGNORE
		'fri' => 'vie',
		'jan' => 'ene',
		'january' => 'ene',
		'jul' => 'jul',
		'july' => 'julio',
		'jun' => 'jun',
		'june' => 'junio',
		'last_2_year' => 'últimos dos años',
		'last_3_month' => 'últimos tres meses',
		'last_3_year' => 'últimos tres años',
		'last_5_year' => 'últimos cinco años',
		'last_6_month' => 'últimos seis meses',
		'last_month' => 'mes pasado',
		'last_week' => 'semana pasada',
		'last_year' => 'año pasado',
		'mar' => 'mar',
		'march' => 'marzo',
		'may' => 'mayo',
		'may_' => 'may',
		'mon' => 'lun',
		'month' => 'mes',
		'nov' => 'nov',
		'november' => 'noviembre',
		'oct' => 'oct',
		'october' => 'octubre',
		'sat' => 'sab',
		'sep' => 'sep',
		'september' => 'septiembre',
		'sun' => 'dom',
		'thu' => 'jue',
		'today' => 'hoy',
		'tue' => 'mar',
		'wed' => 'mié',
		'yesterday' => 'ayer',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Acerca de FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Vaciar categoría',
		'confirm_action' => '¿Seguro que quieres hacerlo? No hay marcha atrás…',
		'confirm_action_feed_cat' => '¿Seguro que quieres hacerlo? Perderás todos los favoritos relacionados y las búsquedas de usuario. ¡Y no hay marcha atrás!',
		'confirm_exit_slider' => '¿Estás seguro de que quieres descartar los cambios no guardados?',
		'feedback' => array(
			'body_new_articles' => 'Hay %%d nuevos artículos para leer en FreshRSS.',
			'body_unread_articles' => '(No leídos: %%d)',
			'request_failed' => 'La petición ha fallado. Puede ser debido a problemas de conexión a internet.',
			'title_new_articles' => 'FreshRSS: ¡nuevos artículos!',
		),
		'labels_empty' => 'Sin etiquetas',
		'new_article' => 'Hay nuevos artículos disponibles. Pincha para refrescar la página.',
		'should_be_activated' => 'JavaScript debe estar activado',
		'unsafe_csp_header' => 'La cabecera CSP en uso no es segura y FreshRSS puede ser vulnerable a ataques XSS. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Ver documentación</a>',
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Acerca de',
		'account' => 'Cuenta',
		'admin' => 'Administración',
		'advanced_search' => 'Búsqueda avanzada',
		'archiving' => 'Archivo',
		'authentication' => 'Identificación',
		'check_install' => 'Verificación de instalación',
		'configuration' => 'Configuración',
		'display' => 'Visualización',
		'extensions' => 'Extensiones',
		'logs' => 'Registros',
		'privacy' => 'Privacidad',
		'queries' => 'Vistas de usuario',
		'reading' => 'Lectura',
		'search' => 'Buscar palabras o #etiquetas',
		'search_help' => 'Consulte la documentación sobre <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">parámetros de búsqueda</a>',
		'sharing' => 'Compartir',
		'shortcuts' => 'Atajos',
		'stats' => 'Estadísticas',
		'system' => 'Configuración del sistema',
		'update' => 'Actualización',
		'user_management' => 'Administrar usuarios',
		'user_profile' => 'Perfil',
	),
	'period' => array(
		'days' => 'días',
		'hours' => 'horas',
		'months' => 'meses',
		'weeks' => 'semanas',
		'years' => 'años',
	),
	'readme' => array(
		'contribute' => 'contribute',	// IGNORE
		'language' => 'Language',	// IGNORE
		'translated' => 'Progress',	// IGNORE
	),
	'search' => array(
		'advanced_search_help' => 'Este formulario ayuda a construir consultas de búsqueda, pero las consultas manuales son aún más potentes.',
		'authors' => 'Autores',
		'categories' => 'Categorías',
		'content' => 'Contenido',
		'date_from' => 'Desde',
		'date_past' => 'En el pasado',
		'date_published' => 'Fecha de publicación',
		'date_range' => 'Rango de fechas',
		'date_received' => 'Fecha de recepción',
		'date_to' => 'Hasta',
		'date_user' => 'Fecha de modificación del usuario',
		'feeds' => 'Fuentes',
		'free_text' => 'Texto libre',
		'free_text_help' => 'Buscar tanto en el título como en el contenido',
		'full_documentation' => 'Ver <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">documentación completa de búsqueda</a>',
		'labels' => 'Mis etiquetas',
		'multiple_help' => 'Selecciona uno o más (mantén presionado <kbd>Ctrl</kbd> o <kbd>Cmd</kbd>)',
		'sources' => 'Fuentes',
		'tags' => 'Etiquetas de artículos',
		'text' => 'Búsqueda de texto',
		'text_help' => 'Las líneas múltiples se combinan mediante un <i>or</i> lógico. También admite <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">expresiones regulares</a>.',
		'text_placeholder' => 'Palabra clave',
		'title' => 'Título',
		'url' => 'URL',	// IGNORE
		'user_queries' => 'Vistas de usuario',
	),
	'share' => array(
		'Known' => 'Sitios basados en conocidos',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Portapapeles',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'email-webmail-firefox-fix' => 'Email (Email Web - corrección para Firefox)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'print' => 'Imprimir',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Web Sharing API',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => '¡Aviso!',
		'blank_to_disable' => 'Deja en blanco para desactivar',
		'by_author' => 'Por:',
		'by_default' => 'Por defecto',
		'damn' => '¡Córcholis!',
		'default_category' => 'Sin categorizar',
		'no' => 'No',	// IGNORE
		'not_applicable' => 'No disponible',
		'ok' => '¡Vale!',
		'or' => 'o',
		'yes' => 'Sí',
	),
	'stream' => array(
		'load_more' => 'Cargar más artículos',
		'mark_all_read' => 'Marcar todo como leído',
		'nothing_to_load' => 'No hay más artículos',
	),
);

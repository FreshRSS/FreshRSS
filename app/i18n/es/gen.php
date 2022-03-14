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
	'action' => array(
		'actualize' => 'Actualizar fuentes',
		'add' => 'Añadir',
		'back' => '← Volver',
		'back_to_rss_feeds' => '← regresar a tus fuentes RSS',
		'cancel' => 'Cancelar',
		'create' => 'Crear',
		'demote' => 'Degradar',
		'disable' => 'Desactivar',
		'empty' => 'Vaciar',
		'enable' => 'Activar',
		'export' => 'Exportar',
		'filter' => 'Filtrar',
		'import' => 'Importar',
		'load_default_shortcuts' => 'Cargar accesos directos predeterminados',
		'manage' => 'Administrar',
		'mark_read' => 'Marcar como leído',
		'promote' => 'Promover',
		'purge' => 'Eliminar',
		'remove' => 'Borrar',
		'rename' => 'Cambiar el nombre a',
		'see_website' => 'Ver web',
		'submit' => 'Enviar',
		'truncate' => 'Borrar todos los artículos',
		'update' => 'Actualizar',
	),
	'auth' => array(
		'accept_tos' => 'Acpeto los <a href="%s">Terminos de Servicio</a>.',
		'email' => 'Correo electrónico',
		'keep_logged_in' => 'Mantenerme identificado <small>(%s días)</small>',
		'login' => 'Conectar',
		'logout' => 'Desconectar',
		'password' => array(
			'_' => 'Contraseña',
			'format' => '<small>Mínimo de 7 caracteres</small>',
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
		'before_yesterday' => 'Anteayer',
		'dec' => 'dic',
		'december' => 'diciembre',
		'feb' => 'feb',
		'february' => 'febrero',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\a\\t H\\:i',	// IGNORE
		'fri' => 'Vie',
		'jan' => 'ene',
		'january' => 'ene',
		'jul' => 'jul',
		'july' => 'julio',
		'jun' => 'jun',
		'june' => 'junio',
		'last_2_year' => 'Últimos dos años',
		'last_3_month' => 'Últimos tres meses',
		'last_3_year' => 'Últimos tres años',
		'last_5_year' => 'Últimos cinco años',
		'last_6_month' => 'Últimos seis meses',
		'last_month' => 'Mes pasado',
		'last_week' => 'Semana pasada',
		'last_year' => 'Año pasado',
		'mar' => 'mar',
		'march' => 'marzo',
		'may' => 'mayo',
		'may_' => 'may',
		'mon' => 'Lun',
		'month' => 'meses',
		'nov' => 'nov',
		'november' => 'noviembre',
		'oct' => 'oct',
		'october' => 'octubre',
		'sat' => 'Sab',
		'sep' => 'sep',
		'september' => 'septiembre',
		'sun' => 'Dom',
		'thu' => 'Jue',
		'today' => 'Hoy',
		'tue' => 'Mar',
		'wed' => 'Mie',
		'yesterday' => 'Ayer',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Acerca de FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Vaciar categoría',
		'confirm_action' => '¿Seguyro que quieres hacerlo? No hay marcha atrás…',
		'confirm_action_feed_cat' => '¿Seguro que quieres hacerlo? Perderás todos los favoritos relacionados y las peticiones de usuario. ¡Y no hay marcha atrás!',
		'feedback' => array(
			'body_new_articles' => 'Hay %%d nuevos artículos para leer en FreshRSS.',
			'body_unread_articles' => '(unread: %%d)',	// TODO
			'request_failed' => 'La petición ha fallado. Puede ser debido a problemas de conexión a internet.',
			'title_new_articles' => 'FreshRSS: ¡Nuevos artículos!',
		),
		'new_article' => 'Hay nuevos artículos disponibles. Pincha para refrescar la página.',
		'should_be_activated' => 'JavaScript debe estar activado',
	),
	'lang' => array(
		'cz' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Acerca de',
		'account' => 'Cuenta',
		'admin' => 'Administración',
		'archiving' => 'Archivo',
		'authentication' => 'Identificación',
		'check_install' => 'Verificación de instalación',
		'configuration' => 'Configuración',
		'display' => 'Visualización',
		'extensions' => 'Extensiones',
		'logs' => 'Registros',
		'queries' => 'Peticiones de usuario',
		'reading' => 'Lectura',
		'search' => 'Buscar palabras o #etiquetas',
		'sharing' => 'Compartir',
		'shortcuts' => 'Atajos',
		'stats' => 'Estadísticas',
		'system' => 'Configuración del sistema',
		'update' => 'Actualización',
		'user_management' => 'Administrar usuarios',
		'user_profile' => 'Perfil',
	),
	'pagination' => array(
		'first' => 'Primero',
		'last' => 'Último',
		'next' => 'Siguiente',
		'previous' => 'Anterior',
	),
	'period' => array(
		'days' => 'dias',
		'hours' => 'horas',
		'months' => 'meses',
		'weeks' => 'semanas',
		'years' => 'años',
	),
	'share' => array(
		'Known' => 'Sitios basados en conocidos',
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Portapapeles',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// TODO
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Imprimir',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// TODO
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'whatsapp' => 'Whatsapp',	// TODO
		'xing' => 'Xing',	// TODO
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

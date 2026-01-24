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
	'auth' => array(
		'allow_anonymous' => 'Permitir la lectura anónima de los artículos del usuario por defecto (%s)',
		'allow_anonymous_refresh' => 'Permitir la actualización anónima de los artículos',
		'api_enabled' => 'Concederle acceso a la <abbr>API</abbr> <small>(necesario para apps de móvil and sharing user queries)</small>',	// DIRTY
		'form' => 'Formulario Web (el más habitual, requiere JavaScript)',
		'http' => 'HTTP (advanced: managed by Web server, OIDC, SSO…)',	// TODO
		'none' => 'Ninguno (peligroso)',
		'title' => 'Identificación',
		'token' => 'Token de autentificación Master',
		'token_help' => 'Permite el acceso a todas las salidas RSS del usuario así como la actualización de fuentes sin autenticación:',
		'type' => 'Método de identificación',
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Extensiones de comunidad disponibles',
		'description' => 'Descripción',
		'disabled' => 'Desactivado',
		'empty_list' => 'No hay extensiones instaladas',
		'empty_list_help' => 'Check the logs to determine the reason behind the empty extension list.',	// TODO
		'enabled' => 'Activado',
		'is_compatible' => 'Is compatible',	// TODO
		'latest' => 'Instalado',
		'name' => 'Nombre',
		'no_configure_view' => 'Esta extensión no puede ser configurada.',
		'system' => array(
			'_' => 'Sistema de extensiones',
			'no_rights' => 'Sistema de extensiones (careces de los permisos necesarios)',
		),
		'title' => 'Extensiones',
		'update' => 'Actualización disponible',
		'user' => 'Extensiones de usuario',
		'version' => 'Versión',
	),
	'stats' => array(
		'_' => 'Estadísticas',
		'all_feeds' => 'Todas las fuentes',
		'category' => 'Categoría',
		'date_published' => 'Publication date',	// TODO
		'date_received' => 'Received date',	// TODO
		'entry_count' => 'Cómputo total',
		'entry_per_category' => 'Entradas por categoría',
		'entry_per_day' => 'Entradas por día (últimos 30 días)',
		'entry_per_day_of_week' => 'Por día de la semana (media: %.2f mensajes)',
		'entry_per_hour' => 'Por hora (media: %.2f mensajes)',
		'entry_per_month' => 'Por mes (media: %.2f mensajes)',
		'entry_repartition' => 'Reparto de entradas',
		'feed' => 'Fuente',
		'feed_per_category' => 'Fuentes por categoría',
		'idle' => 'Fuentes inactivas',
		'main' => 'Estadísticas principales',
		'main_stream' => 'Salida principal',
		'nb_unreads' => 'Number of unread articles',	// TODO
		'no_idle' => 'No hay fuentes inactivas',
		'number_entries' => '%d artículos',
		'overview' => 'Overview',	// TODO
		'percent_of_total' => '% del total',
		'repartition' => 'Reparto de artículos: %s',
		'status_favorites' => 'Favoritos',
		'status_read' => 'Leídos',
		'status_total' => 'Total',	// IGNORE
		'status_unread' => 'Pendientes',
		'title' => 'Estadísticas',
		'top_feed' => 'Las 10 fuentes más activas',
		'unread_dates' => 'Dates with most unread articles',	// TODO
	),
	'system' => array(
		'_' => 'Configuración del sistema',
		'auto-update-url' => 'URL de auto-actualización',
		'base-url' => array(
			'_' => 'URL Base',
			'recommendation' => 'Recomendación automática: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => 'en segundos',
			'number' => 'Duración para mantenerse conectado',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
		'force_email_validation' => 'Forzar la validación de direcciones de correo electrónico',
		'instance-name' => 'Nombre de la fuente',
		'max-categories' => 'Límite de categorías por usuario',
		'max-feeds' => 'Límite de fuentes por usuario',
		'registration' => array(
			'number' => 'Número máximo de cuentas',
			'select' => array(
				'label' => 'Formulario de registro',
				'option' => array(
					'noform' => 'Deshabilitado: Sin formulario de registro',
					'nolimit' => 'Habilitado: Sin límite de cuentas',
					'setaccountsnumber' => 'Establece el número máximo de cuentas',
				),
			),
			'status' => array(
				'disabled' => 'Formulario deshabilitado',
				'enabled' => 'Formulario habilitado',
			),
			'title' => 'Formulario de registro del usuario',
		),
		'sensitive-parameter' => 'Parámetro sensible. Lo puedes editar manualmente en <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'no se proporciona',
			'enabled' => '<a href="./?a=tos">está activado</a>',
			'help' => 'Cómo <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">activar las Condiciones de servicio</a>',
		),
		'websub' => array(
			'help' => 'Acerca de <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => 'Actualizar sistema',
		'apply' => 'Aplicar',
		'changelog' => 'Changelog',	// IGNORE
		'check' => 'Buscar actualizaciones',
		'copiedFromURL' => 'update.php copiado desde %s a ./data',
		'current_version' => 'Dispones de la versión',
		'last' => 'Última comprobación',
		'loading' => 'Actualizando…',
		'none' => 'No hay actualizaciones disponibles',
		'releaseChannel' => array(
			'_' => 'Canal de publicación',
			'edge' => 'Publicación en marcha (“edge”)',
			'latest' => 'Publicación estable (“latest”)',
		),
		'title' => 'Actualizar sistema',
		'viaGit' => 'Actualización vía git and GitHub.com comenzada',
	),
	'user' => array(
		'admin' => 'Administrador',
		'article_count' => 'Artículos',
		'back_to_manage' => '← Volver a la lista de usuarios',
		'create' => 'Crear nuevo usuario',
		'database_size' => 'Tamaño de la base de datos',
		'email' => 'Dirección de correo electrónico',
		'enabled' => 'Permitido',
		'feed_count' => 'Fuentes',
		'is_admin' => 'Es admin',
		'language' => 'Idioma',
		'last_user_activity' => 'Última actividad del usuario',
		'list' => 'Lista de usuarios',
		'number' => 'Hay %d cuenta creada',
		'numbers' => 'Hay %d cuentas creadas',
		'password_form' => 'Contraseña<br /><small>(para el método de identificación por formulario web)</small>',
		'password_format' => 'Mínimo de 7 caracteres',
		'title' => 'Administrar usuarios',
		'username' => 'Nombre de usuario',
	),
);

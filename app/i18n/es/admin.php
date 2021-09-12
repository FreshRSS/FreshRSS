<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Permitir la lectura anónima de los artículos del usuario por defecto (%s)',
		'allow_anonymous_refresh' => 'Permitir la actualización anónima de los artículos',
		'api_enabled' => 'Concederle acceso a la <abbr>API</abbr> <small>(necesario para apps de móvil)</small>',
		'form' => 'Formulario Web (el más habitual, requiere JavaScript)',
		'http' => 'HTTP (para usuarios avanzados con HTTPS)',
		'none' => 'Ninguno (peligroso)',
		'title' => 'Identificación',
		'token' => 'Clave de identificación',
		'token_help' => 'Permite el acceso a la salida RSS del usuario por defecto sin necesidad de identificación:',
		'type' => 'Método de identificación',
		'unsafe_autologin' => 'Permite la identificación automática insegura usando el formato: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Comprueba los permisos en el directorio <em>./data/cache</em> . El servidor HTTP debe contar con permiso de escritura',
			'ok' => 'Los permisos en el cache son correctos.',
		),
		'categories' => array(
			'nok' => 'La tabla Categorías está configurada de forma incorrecta.',
			'ok' => 'La tabla Categorías está correcta.',
		),
		'connection' => array(
			'nok' => 'No se pudo establecer una conexión con la base de datos.',
			'ok' => 'La conexión con la base de datos es correcta.',
		),
		'ctype' => array(
			'nok' => 'No se puedo encontrar la librería necesaria para compropbar el tipo de caracteres (php-ctype).',
			'ok' => 'Dispones de la librería necesaria para la verificación del tipo de caracteres (ctype).',
		),
		'curl' => array(
			'nok' => 'No se pudo encontrar la librería cURL (paquete php-curl).',
			'ok' => 'Dispones de la librería cURL.',
		),
		'data' => array(
			'nok' => 'Comprueba los permisos en el directorio <em>./data</em>. El servidor HTTP debe contar con permisos de escritura.',
			'ok' => 'Los permisos en el directorio data son correctos.',
		),
		'database' => 'Instalación de la base de datos',
		'dom' => array(
			'nok' => 'No se ha podido localizar la librería necesaria para explorar el DOM (paquete php-xml).',
			'ok' => 'Dispones de la librería necesaria para explorar el DOM.',
		),
		'entries' => array(
			'nok' => 'La tabla de entrada no está configurada correctamente.',
			'ok' => 'La tabla de entrada está correcta.',
		),
		'favicons' => array(
			'nok' => 'Comprueba los permisos en el directorio <em>./data/favicons</em>. El servidor HTTP debe contar con permisos de escritura.',
			'ok' => 'Los permisos en el directorio favicons son correctos.',
		),
		'feeds' => array(
			'nok' => 'La tabla Feed está configurada de forma incorrecta.',
			'ok' => 'La tabla Feed está correcta.',
		),
		'fileinfo' => array(
			'nok' => 'No se ha podido localizar la librería PHP fileinfo (paquete fileinfo).',
			'ok' => 'Dispones de la librería fileinfo.',
		),
		'files' => 'Instalación de Archivos',
		'json' => array(
			'nok' => 'No se ha podido localizar JSON (paquete php-json).',
			'ok' => 'Dispones de la extensión JSON.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended mbstring library for Unicode.',	// TODO - Translation
			'ok' => 'You have the recommended mbstring library for Unicode.',	// TODO - Translation
		),
		'pcre' => array(
			'nok' => 'No se ha podido localizar la librería para las expresiones regulares (php-pcre).',
			'ok' => 'Dispones de la librería necesaria para expresiones regulares (PCRE).',
		),
		'pdo' => array(
			'nok' => 'No se ha podido localiar PDO o uno de los controladores compatibles (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Dispones de PDO y, al menos, de uno de los controladores compatibles (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'Instalación PHP',
			'nok' => 'Dispones de la versión PHP %s pero FreshRSS requiere de, al menos, la versión %s.',
			'ok' => 'Dispones de la versión PHP %s, que es compatible con FreshRSS.',
		),
		'tables' => array(
			'nok' => 'Falta al menos una tabla en la base de datos.',
			'ok' => 'Todas las tablas necesarias están disponibles en la base de datos.',
		),
		'title' => 'Verificación de instalación',
		'tokens' => array(
			'nok' => 'Comprueba los permisos en el directorio <em>./data/tokens</em>. El servidor HTTP debe contar con permisos de escritura.',
			'ok' => 'Los permisos en el directorio de tokens de identificación son correctos.',
		),
		'users' => array(
			'nok' => 'Comprueba los permisos en el directorio <em>./data/users</em>. El servidor HTTP debe contar con permisos de escritura.',
			'ok' => 'Los permisos en el directorio users son correctos.',
		),
		'zip' => array(
			'nok' => 'No se ha podido localizar la extensión ZIP (paquete php-zip).',
			'ok' => 'Dispones de la extensión ZIP.',
		),
	),
	'extensions' => array(
		'author' => 'Author',	// TODO - Translation
		'community' => 'Available community extensions',	// TODO - Translation
		'description' => 'Description',	// TODO - Translation
		'disabled' => 'Desactivado',
		'empty_list' => 'No hay extensiones instaladas',
		'enabled' => 'Activado',
		'latest' => 'Installed',	// TODO - Translation
		'name' => 'Name',	// TODO - Translation
		'no_configure_view' => 'Esta extensión no puede ser configurada.',
		'system' => array(
			'_' => 'Sistema de extensiones',
			'no_rights' => 'Sistema de extensiones (careces de los permisos necesarios)',
		),
		'title' => 'Extensiones',
		'update' => 'Update available',	// TODO - Translation
		'user' => 'Extensiones de usuario',
		'version' => 'Version',	// TODO - Translation
	),
	'stats' => array(
		'_' => 'Estadísticas',
		'all_feeds' => 'Todas las fuentes',
		'category' => 'Categoría',
		'entry_count' => 'Cómputo total',
		'entry_per_category' => 'Entradas por categoría',
		'entry_per_day' => 'Entradas por día (últimos 30 días)',
		'entry_per_day_of_week' => 'Por día de la semana (mnedia: %.2f mensajes)',
		'entry_per_hour' => 'Por hora (media: %.2f mensajes)',
		'entry_per_month' => 'Por mes (media: %.2f mensajes)',
		'entry_repartition' => 'Reparto de entradas',
		'feed' => 'Fuente',
		'feed_per_category' => 'Fuentes por categoría',
		'idle' => 'Fuentes inactivas',
		'main' => 'Estadísticas principales',
		'main_stream' => 'Salida principal',
		'no_idle' => 'No hay fuentes inactivas',
		'number_entries' => '%d artículos',
		'percent_of_total' => '%% del total',
		'repartition' => 'Reprto de artículos',
		'status_favorites' => 'Favoritos',
		'status_read' => 'Leídos',
		'status_total' => 'Total',	// TODO - Translation
		'status_unread' => 'Pendientes',
		'title' => 'Estadísticas',
		'top_feed' => 'Las 10 fuentes más activas',
	),
	'system' => array(
		'_' => 'Configuración del sistema',
		'auto-update-url' => 'URL de auto-actualización',
		'cookie-duration' => array(
			'help' => 'in seconds',	// TODO - Translation
			'number' => 'Duration to keep logged in',	// TODO - Translation
		),
		'force_email_validation' => 'Force email address validation',	// TODO - Translation
		'instance-name' => 'Nombre de la fuente',
		'max-categories' => 'Límite de categorías por usuario',
		'max-feeds' => 'Límite de fuentes por usuario',
		'registration' => array(
			'help' => '0 significa que no hay límite en la cuenta',
			'number' => 'Número máximo de cuentas',
		),
	),
	'update' => array(
		'_' => 'Actualizar sistema',
		'apply' => 'Aplicar',
		'check' => 'Buscar actualizaciones',
		'current_version' => 'Dispones de la versión %s de FreshRSS.',
		'last' => 'Última comprobación: %s',
		'none' => 'No hay actualizaciones disponibles',
		'title' => 'Actualizar sistema',
	),
	'user' => array(
		'admin' => 'Administrator',	// TODO - Translation
		'article_count' => 'Articles',	// TODO - Translation
		'back_to_manage' => '← Return to user list',	// TODO - Translation
		'create' => 'Crear nuevo usuario',
		'database_size' => 'Database size',	// TODO - Translation
		'email' => 'Email address',	// TODO - Translation
		'enabled' => 'Enabled',	// TODO - Translation
		'feed_count' => 'Feeds',	// TODO - Translation
		'is_admin' => 'Is admin',	// TODO - Translation
		'language' => 'Idioma',
		'last_user_activity' => 'Last user activity',	// TODO - Translation
		'list' => 'User list',	// TODO - Translation
		'number' => 'Hay %d cuenta creada',
		'numbers' => 'Hay %d cuentas creadas',
		'password_form' => 'Contraseña<br /><small>(para el método de identificación por formulario web)</small>',
		'password_format' => 'Mínimo de 7 caracteres',
		'title' => 'Administrar usuarios',
		'username' => 'Nombre de usuario',
	),
);

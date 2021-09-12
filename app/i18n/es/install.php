<?php

return array(
	'action' => array(
		'finish' => 'Completar instalación',
		'fix_errors_before' => 'Por favor, soluciona los errores detectados antes de continuar con el siguiente paso.',
		'keep_install' => 'Conservar la configuración anterior',
		'next_step' => 'Ir al siguiente paso',
		'reinstall' => 'Reinstalar FreshRSS',
	),
	'auth' => array(
		'form' => 'Formulario Web (método más habitual, requiere JavaScript)',
		'http' => 'HTTP (para usuarios avanzados con HTTPS)',
		'none' => 'Ninguna (peligroso)',
		'password_form' => 'Contraseña<br /><small>(para el método de acceso mediante formulario web)</small>',
		'password_format' => 'Al menos 7 caracteres',
		'type' => 'Método de identificación',
	),
	'bdd' => array(
		'_' => 'Base de datos',
		'conf' => array(
			'_' => 'Configuración de la base de datos',
			'ko' => 'Verificar la información de tu base de datos.',
			'ok' => 'La configuración de la base de datos ha sido guardada.',
		),
		'host' => 'Servidor',
		'password' => 'Contraseña de la base de datos',
		'prefix' => 'Prefijo de la tabla',
		'type' => 'Tipo de base de datos',
		'username' => 'Nombre de usuario de la base de datos',
	),
	'check' => array(
		'_' => 'Verificaciones',
		'already_installed' => '¡FreshRSS ya está instalado!',
		'cache' => array(
			'nok' => 'Comprueba los permisos en el directorio <em>%s</em>. El servidor HTTP debe contar con permisos de escritura.',
			'ok' => 'Los permisos del directorio cache son correctos.',
		),
		'ctype' => array(
			'nok' => 'No se ha podido localizar la librería para la verificación del tipo de caracteres (php-ctype).',
			'ok' => 'Cuentas con la librería necesaria para la verificación del tipo de caracteres (ctype).',
		),
		'curl' => array(
			'nok' => 'No se ha podido localizar la librería cURL (paquete php-curl).',
			'ok' => 'Dispones de la librería cURL.',
		),
		'data' => array(
			'nok' => 'Comprueba los permisos del directorio <em>%s</em>. El servidor HTTP debe contar con permisos de escritura.',
			'ok' => 'Los permisos del directorio data son correctos.',
		),
		'dom' => array(
			'nok' => 'No se ha podido localizar la librería necesaria para explorar la DOM.',
			'ok' => 'Dispones de la librería necesaria para explorar la DOM.',
		),
		'favicons' => array(
			'nok' => 'Verifica los permisos en el directorio <em>%s</em>. El servidor HTTP debe contar con permisos de escritura.',
			'ok' => 'Los permisos del directorio favicons son correctos.',
		),
		'fileinfo' => array(
			'nok' => 'No se ha podido localizar la librería PHP fileinfo (paquete fileinfo).',
			'ok' => 'Dispones de la librería fileinfo.',
		),
		'json' => array(
			'nok' => 'No se ha podido localizar la librería para procesar JSON.',
			'ok' => 'Dispones de la librería recomendada para procesar JSON.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// TODO - Translation
			'ok' => 'You have the recommended library mbstring for Unicode.',	// TODO - Translation
		),
		'pcre' => array(
			'nok' => 'No se ha podido encontrar la librería necesaria para las expresiones regulares (php-pcre).',
			'ok' => 'Dispones de la librería necesaria para las expresiones regulares (PCRE).',
		),
		'pdo' => array(
			'nok' => 'No se ha podido localizar PDO o uno de los controladores compatibles (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Dispones de PDO y al menos uno de los controladores compatibles (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'Dispones de la versión PHP %s, pero FreshRSS necesita de, al menos, la versión %s.',
			'ok' => 'Dispones de la versión PHP %s, que es compatible con FreshRSS.',
		),
		'reload' => 'Revisar otra vez',
		'tmp' => array(
			'nok' => 'Revisa los permisos en el directorio <em>%s</em>. El servidor HTTP debe contar con permisos de escritura.',
			'ok' => 'Permissions on the temp directory are good.',	// TODO - Translation
		),
		'unknown_process_username' => 'unknown',	// TODO - Translation
		'users' => array(
			'nok' => 'Revisa los permisos en el directorio <em>%s</em>. El servidor HTTP debe contar con permisos de escritura.',
			'ok' => 'Los permisos en el directorio users son correctos.',
		),
		'xml' => array(
			'nok' => 'No se ha podido localizar la librería necesaria para procesar XML.',
			'ok' => 'Dispones de la librería necesaria para procesar XML.',
		),
	),
	'conf' => array(
		'_' => 'Configuración general',
		'ok' => 'La configuración general se ha guardado.',
	),
	'congratulations' => '¡Enhorabuena!',
	'default_user' => 'Nombre de usuario para el usuario por defecto <small>(máximo de 16 caracteres alfanuméricos)</small>',
	'fix_errors_before' => 'Por favor, soluciona los errores detectados antes de proceder con el siguiente paso.',
	'javascript_is_better' => 'FreshRSS funciona mejor con JavaScript activado',
	'js' => array(
		'confirm_reinstall' => 'Al reinstalar FreshRSS perderás cualquier configuración anterior. ¿Seguro que quieres continuar?',
	),
	'language' => array(
		'_' => 'Idioma',
		'choose' => 'Selecciona el idioma para FreshRSS',
		'defined' => 'Idioma seleccionado.',
	),
	'missing_applied_migrations' => 'Something went wrong; you should create an empty file <em>%s</em> manually.',	// TODO - Translation
	'ok' => 'La instalación se ha completado correctamente.',
	'session' => array(
		'nok' => 'The web server seems to be incorrectly configured for cookies required for PHP sessions!',	// TODO - Translation
	),
	'step' => 'paso %d',
	'steps' => 'Pasos',
	'this_is_the_end' => '¡Terminamos!',
	'title' => 'Instalación · FreshRSS',
);

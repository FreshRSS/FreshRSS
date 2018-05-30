<?php

return array(
	'admin' => array(
		'optimization_complete' => 'Optimimización completada',
	),
	'access' => array(
		'denied' => 'No dispones de permiso para acceder a esta página',
		'not_found' => 'La página que buscas no existe',
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'Hubo un problema durante la configuración del sistema de idenfificación. Por favor, inténtalo más tarde.',
			'set' => 'El formulario será desde ahora tu sistema de identificación por defecto.',
		),
		'login' => array(
			'invalid' => 'Identificación incorrecta',
			'success' => 'Conexión',
		),
		'logout' => array(
			'success' => 'Desconexión',
		),
		'no_password_set' => 'Esta opción no está disponible porque no se ha definido una contraseña de administrador.',
	),
	'conf' => array(
		'error' => 'Hubo un error durante el guardado de la configuración.',
		'query_created' => 'Se ha creado la petición "%s".',
		'shortcuts_updated' => 'Se han actualizado los atajos de teclado',
		'updated' => 'Se ha actualizado la configuración',
	),
	'extensions' => array(
		'already_enabled' => '%s ya está activado',
		'disable' => array(
			'ko' => '%s no se puede desactivar. <a href="%s">Revisa el registro de FreshRSS</a> para más información.',
			'ok' => '%s ha quedado desactivado',
		),
		'enable' => array(
			'ko' => '%s no se puede activar. <a href="%s">Revisa el registro de FreshRSS</a> para más información.',
			'ok' => '%s ha quedado activado',
		),
		'no_access' => 'No tienes acceso a %s',
		'not_enabled' => '%s no está activado',
		'not_found' => '%s no existe',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'La extensión ZIP no está disponible en tu servidor. Por favor, exporta estos archivos uno a uno.',
		'feeds_imported' => 'Se han importado tus fuentes y quedarán actualizadas',
		'feeds_imported_with_errors' => 'Se importaron tus fuentes; pero hubo algunos errores',
		'file_cannot_be_uploaded' => 'No es posible enviar el archivo',
		'no_zip_extension' => 'La extensión ZIP no está disponible en tu servidor.',
		'zip_error' => 'Hubo un error durante la importación ZIP.',
	),
	'sub' => array(
		'actualize' => 'Actualización',
		'category' => array(
			'created' => 'Se ha creado la categoría %s.',
			'deleted' => 'Se ha eliminado la categoría.',
			'emptied' => 'Se ha vaciado la categoría',
			'error' => 'No es posible actualizar la categoría',
			'name_exists' => 'Ya existe una categoría con ese nombre.',
			'no_id' => 'Debes especificar la id de la categoría.',
			'no_name' => '¡El nombre de la categoría no puede dejarse en blanco!.',
			'not_delete_default' => '¡No puedes borrar la categoría por defecto!',
			'not_exist' => 'La categoría no existe',
			'over_max' => 'Has alcanzado el límite de categorías (%d)',
			'updated' => 'La categoría se ha actualizado.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> ha sido actualizada',
			'actualizeds' => 'Las fuentes RSS se han actualizado',
			'added' => 'Fuente RSS agregada <em>%s</em>',
			'already_subscribed' => 'Ya estás suscrito a <em>%s</em>',
			'deleted' => 'Fuente eliminada',
			'error' => 'No es posible actualizar la fuente',
			'internal_problem' => 'No ha sido posible agregar la fuente RSS. <a href="%s">Revisa el registro de FreshRSS </a> para más información.', // @todo
			'invalid_url' => 'La URL <em>%s</em> es inválida',
			'marked_read' => 'Fuentes marcadas como leídas',
			'n_actualized' => 'Se han actualiado %d fuentes',
			'n_entries_deleted' => 'Se han eliminado %d artículos',
			'no_refresh' => 'No hay fuente a actualizar…',
			'not_added' => '<em>%s</em> no ha podido se añadida',
			'over_max' => 'Has alcanzado tu límite de fuentes (%d)',
			'updated' => 'Fuente actualizada',
		),
		'purge_completed' => 'Limpieza completada (se han eliminado %d artículos)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS se va a actualizar a la <strong>versión %s</strong>.',
		'error' => 'Hubo un error durante el proceso de actualización: %s',
		'file_is_nok' => 'Disponible la nueva <strong>versión %s</strong>. Sin embargo, debes revisar los permisos en el directorio <em>%s</em>. El servidor HTTP debe contar con permisos de escritura',
		'finished' => '¡Actualización completada!',
		'none' => 'No hay actualizaciones para procesar',
		'server_not_found' => 'No se ha podido conectar con el servidor de actualizaciones. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Se ha creado el usuario %s',
			'error' => 'No se ha podido crear al usuario %s',
		),
		'deleted' => array(
			'_' => 'El usuario %s ha sido eliminado',
			'error' => 'El usuario %s no ha podido ser eliminado',
		),
		'updated' => array(
			'_' => 'User %s has been updated', // TODO
			'error' => 'User %s has not been updated', // TODO
		),
	),
	'profile' => array(
		'error' => 'Tu perfil no puede ser modificado',
		'updated' => 'Tu perfil ha sido modificado',
	),
);

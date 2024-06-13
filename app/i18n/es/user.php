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
	'email' => array(
		'feedback' => array(
			'invalid' => 'Esta dirección de correo electrónico no es válida.',
			'required' => 'Se requiere una dirección de correo electrónico.',
		),
		'validation' => array(
			'change_email' => 'Puedes cambiar tu dirección de correo electrónico <a href="%s">en la página de perfil</a>.',
			'email_sent_to' => 'Te enviamos un correo electrónico a <strong>%s</strong>. Siga sus instrucciones para validar su dirección.',
			'feedback' => array(
				'email_failed' => 'No pudimos enviarle un correo electrónico debido a un error de configuración del servidor.',
				'email_sent' => 'Se ha enviado un correo electrónico a su dirección.',
				'error' => 'Error en la validación de la dirección de correo electrónico.',
				'ok' => 'Esta dirección de correo electrónico ha sido validada.',
				'unnecessary' => 'Esta dirección de correo electrónico ya fue validada.',
				'wrong_token' => 'Esta dirección de correo electrónico no se pudo validar debido a un token incorrecto.',
			),
			'need_to' => 'Debe validar su dirección de correo electrónico antes de poder usar %s.',
			'resend_email' => 'Volver a enviar el correo electrónico',
			'title' => 'Validación de direcciones de correo electrónico',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Acabas de registrarte en %s, pero aún necesitas validar tu dirección de correo electrónico. Para eso, solo sigue el enlace:',
			'title' => 'Necesitas validar tu cuenta',
			'welcome' => 'Bienvenido %s,',
		),
	),
	'password' => array(
		'invalid' => 'La contraseña no es válida.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Debe aceptar los Términos de Servicio para poder registrarse.',
		),
	),
	'username' => array(
		'invalid' => 'Este nombre de usuario no es válido.',
		'taken' => 'Se toma este nombre de usuario, %s.',
	),
);

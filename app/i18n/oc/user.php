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

return [
	'email' => [
		'feedback' => [
			'invalid' => 'L’adreça electronica es invalida.',
			'required' => 'L’adreça electronica es requesida.',
		],
		'validation' => [
			'change_email' => 'Podètz cambiar l’adreça electronica <a href="%s">sus la pagina de perfil</a>.',
			'email_sent_to' => 'Vos avèm enviat un corrièl a <strong>%s</strong>, mercés de seguir las consignas per validar l’adreça electronica.',
			'feedback' => [
				'email_failed' => 'Avèm pas pogut vos enviar un corrièl a causa d’una marrida configuracion del servidor.',
				'email_sent' => 'Avèm enviat un corrièl a vòstra adreça.',
				'error' => 'Fracàs de la validacion de l’adreça electronica.',
				'ok' => 'L’adreça electronica es estada validada.',
				'unnecessary' => 'L’adreça es ja estada validada.',
				'wrong_token' => 'Fracàs de la validacion de l’adreça a causa d’un marrit geton.',
			],
			'need_to' => 'Devèètz validar vòstra adreça electronica abans de poder utilizar %s.',
			'resend_email' => 'Tornar enviar lo corrièl',
			'title' => 'Validacion de l’adreça electronica',
		],
	],
	'mailer' => [
		'email_need_validation' => [
			'body' => 'Venètz de vos marcar sus %s mas vos cal encara validar l’adreça electronica. Per aquò far, seguissètz lo ligam :',
			'title' => 'Vos cal validar vòstra adreça electronica',
			'welcome' => 'La benvenguda %s,',
		],
	],
	'password' => [
		'invalid' => 'Lo senhal es invalid.',
	],
	'tos' => [
		'feedback' => [
			'invalid' => 'Vos cal acceptar las condicions d’utilizacion per poder vos inscriure.',
		],
	],
	'username' => [
		'invalid' => 'Lo nom d’utilizaire es invalid.',
		'taken' => 'Lo nm d’utilizaire %s es pres.',
	],
];

<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'L’adreça electronica es invalida.',
			'required' => 'L’adreça electronica es requesida.',
		),
		'validation' => array(
			'change_email' => 'Podètz cambiar l’adreça electronica <a href="%s">sus la pagina de perfil</a>.',
			'email_sent_to' => 'Vos avèm enviat un corrièl a <strong>%s</strong>, mercés de seguir las consignas per validar l’adreça electronica.',
			'feedback' => array(
				'email_failed' => 'Avèm pas pogut vos enviar un corrièl a causa d’una marrida configuracion del servidor.',
				'email_sent' => 'Avèm enviat un corrièl a vòstra adreça.',
				'error' => 'Fracàs de la validacion de l’adreça electronica.',
				'ok' => 'L’adreça electronica es estada validada.',
				'unneccessary' => 'L’adreça es ja estada validada.',
				'wrong_token' => 'Fracàs de la validacion de l’adreça a causa d’un marrit geton.',
			),
			'need_to' => 'Devèètz validar vòstra adreça electronica abans de poder utilizar %s.',
			'resend_email' => 'Tornar enviar lo corrièl',
			'title' => 'Validacion de l’adreça electronica',
		),
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'You must accept the Terms of Service to be able to register.', // TODO - Translation
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'title' => 'Vos cal validar vòstra adreça electronica',
			'welcome' => 'La benvenguda %s,',
			'body' => 'Venètz de vos marcar sus %s mas vos cal encara validar l’adreça electronica. Per aquò far, seguissètz lo ligam :',
		),
	),
);

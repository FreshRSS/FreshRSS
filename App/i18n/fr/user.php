<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'L’adresse email est invalide.',
			'required' => 'L’adresse email est requise.',
		),
		'validation' => array(
			'change_email' => 'Vous pouvez changer votre adresse email <a href="%s">dans votre profil</a>.',
			'email_sent_to' => 'Nous venons d’envoyer un email à <strong>%s</strong>, veuillez suivre ses indications pour valider votre adresse.',
			'feedback' => array(
				'email_failed' => 'Nous n’avons pas pu vous envoyer d’email à cause d’une mauvaise configuration du serveur.',
				'email_sent' => 'Un email a été envoyé à votre adresse.',
				'error' => 'L’adresse email n’a pas pu être validée.',
				'ok' => 'L’adresse email a été validée.',
				'unnecessary' => 'L’adresse email a déjà été validée.',
				'wrong_token' => 'L’adresse email n’a pas pu être validée à cause d’un mauvais token.',
			),
			'need_to' => 'Vous devez valider votre adresse email avant de pouvoir utiliser %s.',
			'resend_email' => 'Renvoyer l’email',
			'title' => 'Validation de l’adresse email',
		),
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Vous devez accepter les conditions générales d’utilisation pour pouvoir vous inscrire.',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'title' => 'Vous devez valider votre compte',
			'welcome' => 'Bienvenue %s,',
			'body' => 'Vous venez de vous inscrire sur %s mais vous devez encore valider votre adresse email. Pour cela, veuillez cliquer sur ce lien :',
		),
	),
);

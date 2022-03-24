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
			'invalid' => 'L’adresse électronique est invalide.',
			'required' => 'L’adresse électronique est requise.',
		),
		'validation' => array(
			'change_email' => 'Vous pouvez changer votre adresse électronique <a href="%s">dans votre profil</a>.',
			'email_sent_to' => 'Nous venons d’envoyer un email à <strong>%s</strong>, veuillez suivre ses indications pour valider votre adresse.',
			'feedback' => array(
				'email_failed' => 'Nous n’avons pas pu vous envoyer d’email à cause d’une mauvaise configuration du serveur.',
				'email_sent' => 'Un email a été envoyé à votre adresse.',
				'error' => 'L’adresse électronique n’a pas pu être validée.',
				'ok' => 'L’adresse électronique a été validée.',
				'unnecessary' => 'L’adresse électronique a déjà été validée.',
				'wrong_token' => 'L’adresse électronique n’a pas pu être validée à cause d’un mauvais token.',
			),
			'need_to' => 'Vous devez valider votre adresse électronique avant de pouvoir utiliser %s.',
			'resend_email' => 'Renvoyer l’email',
			'title' => 'Validation de l’adresse électronique',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Vous venez de vous inscrire sur %s mais vous devez encore valider votre adresse électronique. Pour cela, veuillez cliquer sur ce lien :',
			'title' => 'Vous devez valider votre compte',
			'welcome' => 'Bienvenue %s,',
		),
	),
	'password' => array(
		'invalid' => 'Le mot de passe est invalide.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Vous devez accepter les conditions générales d’utilisation pour pouvoir vous inscrire.',
		),
	),
	'username' => array(
		'invalid' => 'Le nom d’utilisateur est invalide.',
		'taken' => 'Le nom d’utilisateur %s est pris.',
	),
);

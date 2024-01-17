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
			'invalid' => 'E-Mail-Adresse ungültig',
			'required' => 'E-Mail-Adresse ist ein Pflichtfeld',
		],
		'validation' => [
			'change_email' => 'Sie können Ihre E-Mail-Adresse auf Ihrem <a href="%s">Profil</a> ändern.',
			'email_sent_to' => 'Wir haben Ihnen eine E-Mail an <strong>%s</strong> gesendet. Bitte folgen Sie den Anweisungen um Ihre E-Mail-Adresse zu verifizieren.',
			'feedback' => [
				'email_failed' => 'Wir konnten Ihnen aufgrund einer Fehlkonfiguration des Servers keine E-Mail schicken.',
				'email_sent' => 'Wir haben Ihnen eine E-Mail geschickt.',
				'error' => 'Die E-Mail Adresse konnte nicht verifiziert werden.',
				'ok' => 'Die E-Mail-Adresse wurde verifiziert',
				'unnecessary' => 'Die E-Mail-Adresse wurde bereits verifiziert.',
				'wrong_token' => 'Die E-Mail-Adresse konnte aufgrund eines ungültigen Sicherheitstokens nicht verifiziert werden.',
			],
			'need_to' => 'Sie müssen zuerst Ihre E-Mail-Adresse verifizieren, bevor Sie %s nutzen können.',
			'resend_email' => 'E-Mail erneut versenden',
			'title' => 'E-Mail Adressvalidierung',
		],
	],
	'mailer' => [
		'email_need_validation' => [
			'body' => 'Sie haben Sich gerade bei %s registriert und müssen nun nur noch Ihre E-Mail-Adresse verifizieren. Bitte klicken Sie hier:',
			'title' => 'Sie müssen Ihr Konto verifizieren',
			'welcome' => 'Willkommen, %s,',
		],
	],
	'password' => [
		'invalid' => 'Das Passwort ist ungültig.',
	],
	'tos' => [
		'feedback' => [
			'invalid' => 'Sie müssen die Nutzungsbedingungen akzeptieren um sich zu registrieren.',
		],
	],
	'username' => [
		'invalid' => 'Der Benutzername ist ungültig.',
		'taken' => 'Der Benutzername %s wird bereits verwendet.',
	],
];

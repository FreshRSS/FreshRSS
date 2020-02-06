<?php

return array(
	'already_exists' => 'The user %s already exists.',	// TODO - Translation
	'email' => array(
		'feedback' => array(
			'invalid' => 'E-Mail-Adresse ungültig',
			'required' => 'E-Mail ist ein Pflichtfeld',
		),
		'validation' => array(
			'change_email' => 'Sie können Ihre E-Mail Adresse auf Ihrem <a href="%s">Profil</a> ändern.',
			'email_sent_to' => 'Wir haben Ihnen eine E-Mail an <strong>%s</strong> gesendet. Bitte folgen Sie den Anweisungen um Ihre E-Mail Adresse zu verifizieren.',
			'feedback' => array(
				'email_failed' => 'Wir konnten Ihnen aufgrund einer Fehlkonfiguration des Servers keine E-Mail schicken.',
				'email_sent' => 'Wir haben Ihnen eine E-Mail geschickt.',
				'error' => 'Die E-Mail Adresse konnte nicht veifiziert werden.',
				'ok' => 'Die E-Mail Adresse wurde verifiziert',
				'unneccessary' => 'Die E-Mail Adresse wurde bereits verifiziert.',
				'wrong_token' => 'Die E-Mail Adresse konnte aufgrund eines ungültigen Sicherheitstokens nicht verifiziert werden.',
			),
			'need_to' => 'Sie müssen zuerst Ihre E-Mail Adresse verifizieren, bevor Sie %s nutzen können.',
			'resend_email' => 'E-Mail erneut versenden',
			'title' => 'E-Mail Adressvalidierung',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Sie haben Sich gerade bei %s registriert und müssen nun nur noch Ihre E-Mail Adresse verifizieren. Bitte klicken Sie hier:',
			'title' => 'Sie müssen Ihr Konto verifizieren',
			'welcome' => 'Willkommen, %s,',
		),
	),
	'password' => array(
		'invalid' => 'The password is invalid.',	// TODO - Translation
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Sie müssen die Nutzungsbedingungen akzeptieren um sich zu registrieren.',
		),
	),
	'username' => array(
		'invalid' => 'The username is invalid.',	// TODO - Translation
	),
);

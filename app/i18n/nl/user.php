<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'Het emailadres is niet geldig.',
			'required' => 'Het emailadres is vereist.',
		),
		'validation' => array(
			'change_email' => 'Het emailadres kan worden gewijzigd <a href="%s">op de profielpagina</a>.',
			'email_sent_to' => 'Er is een email verzonden naar <strong>%s</strong>. Volg de instructies om het emailadres te valideren.',
			'feedback' => array(
				'email_failed' => 'Er kon geen email worden verzonden vanwege een incorrecte configuratie van de server.',
				'email_sent' => 'Er is een email naar het adres verzonden.',
				'error' => 'Het emailadres kon niet worden gevalideerd.',
				'ok' => 'Het emailadres is gevalideerd.',
				'unneccessary' => 'Het emailadres is al eerder gevalideerd.',
				'wrong_token' => 'Het emailadres kon niet worden gevalideerd vanwege een fout token.',
			),
			'need_to' => 'Het emailadres %1 moet worden gevalideerd voordat het kan worden gebruikt.',
			'resend_email' => 'Email opnieuw sturen',
			'title' => 'Emailadresvalidatie',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Je hebt je net geregistreerd op %s, maar je moet je email nog valideren. Volg daarvoor de link:',
			'title' => 'Je account moet worden gevalideerd',
			'welcome' => 'Welkom %s,',
		),
	),
	'password' => array(
		'invalid' => 'The password is invalid.',	// TODO - Translation
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'De gebruiksvoorwaarden moeten worden geaccepteerd om te kunnen registeren.',
		),
	),
	'username' => array(
		'invalid' => 'The username is invalid.',	// TODO - Translation
		'taken' => 'The username %s is taken.',	// TODO - Translation
	),
);

<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'Ten adres e-mailowy jest niepoprawny.',
			'required' => 'Wymagane jest podanie adresu e-mail.',
		),
		'validation' => array(
			'change_email' => 'You can change your email address <a href="%s">on the profile page</a>.',	// TODO - Translation
			'email_sent_to' => 'We sent you an email at <strong>%s</strong>. Please follow its instructions to validate your address.',	// TODO - Translation
			'feedback' => array(
				'email_failed' => 'We couldn’t send you an email because of a server configuration error.',	// TODO - Translation
				'email_sent' => 'An email has been sent to your address.',	// TODO - Translation
				'error' => 'Email address validation failed.',	// TODO - Translation
				'ok' => 'This email address has been validated.',	// TODO - Translation
				'unneccessary' => 'This email address was already validated.',	// TODO - Translation
				'wrong_token' => 'This email address failed to be validated due to a wrong token.',	// TODO - Translation
			),
			'need_to' => 'You need to validate your email address before being able to use %s.',	// TODO - Translation
			'resend_email' => 'Resend the email',	// TODO - Translation
			'title' => 'Email address validation',	// TODO - Translation
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'You’ve just registered on %s, but you still need to validate your email address. For that, just follow the link:',	// TODO - Translation
			'title' => 'You need to validate your account',	// TODO - Translation
			'welcome' => 'Welcome %s,',	// TODO - Translation
		),
	),
	'password' => array(
		'invalid' => 'The password is invalid.',	// TODO - Translation
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'You must accept the Terms of Service to be able to register.',	// TODO - Translation
		),
	),
	'username' => array(
		'invalid' => 'This username is invalid.',	// TODO - Translation
		'taken' => 'This username, %s, is taken.',	// TODO - Translation
	),
);

<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'This email address is invalid.',
			'required' => 'An email address is required.',
		),
		'validation' => array(
			'change_email' => 'You can change your email address <a href="%s">on the profile page</a>.',
			'email_sent_to' => 'We sent you an email at <strong>%s</strong>, please follow its instructions to validate your address.',
			'feedback' => array(
				'email_failed' => 'We couldn’t send you an email because of a server configuration error.',
				'email_sent' => 'An email has been sent to your address.',
				'error' => 'This email address validation failed.',
				'ok' => 'This email address has been validated.',
				'unneccessary' => 'This email address was already validated.',
				'wrong_token' => 'This email address failed to be validated due to a wrong token.',
			),
			'need_to' => 'You need to validate your email address before being able to use %s.',
			'resend_email' => 'Resend the email',
			'title' => 'Email address validation',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'You’ve just registered on %s, but you still need to validate your email address. For that, just follow the link:',
			'title' => 'You need to validate your account',
			'welcome' => 'Welcome %s,',
		),
	),
	'password' => array(
		'invalid' => 'The password is invalid.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'You must accept the Terms of Service to be able to register.',
		),
	),
	'username' => array(
		'invalid' => 'This username is invalid.',
		'taken' => 'This username, %s, is taken.',
	),
);

<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'The email address is invalid.',
			'required' => 'The email address is required.',
		),
		'validation' => array(
			'change_email' => 'You can change your email address <a href="%s">on the profile page</a>.',
			'email_sent_to' => 'We sent you an email at <strong>%s</strong>, please follow its indications to validate your address.',
			'feedback' => array(
				'email_failed' => 'We couldn’t send you an email because of a misconfiguration of the server.',
				'email_sent' => 'An email has been sent to your address.',
				'error' => 'The email address failed to be validated.',
				'ok' => 'The email address has been validated.',
				'unneccessary' => 'The email address was already validated.',
				'wrong_token' => 'The email address failed to be validated due to a wrong token.',
			),
			'need_to' => 'You need to validate your email address before being able to use %s.',
			'resend_email' => 'Resend the email',
			'title' => 'Email address validation',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'title' => 'You need to validate your account',
			'welcome' => 'Welcome %s,',
			'body' => 'You’ve just registered on %s but you still need to validate your email. For that, just follow the link:',
		),
	),
);

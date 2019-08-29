<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'The email address is invalid.', //TODO - Translation
			'required' => 'The email address is required.', //TODO - Translation
		),
		'validation' => array(
			'change_email' => 'You can change your email address <a href="%s">on the profile page</a>.', //TODO - Translation
			'email_sent_to' => 'We sent you an email at <strong>%s</strong>, please follow its indications to validate your address.', //TODO - Translation
			'feedback' => array(
				'email_failed' => 'We couldn’t send you an email because of a misconfiguration of the server.', //TODO - Translation
				'email_sent' => 'An email has been sent to your address.', //TODO - Translation
				'error' => 'The email address failed to be validated.', //TODO - Translation
				'ok' => 'The email address has been validated.', //TODO - Translation
				'unneccessary' => 'The email address was already validated.', //TODO - Translation
				'wrong_token' => 'The email address failed to be validated due to a wrong token.', //TODO - Translation
			),
			'need_to' => 'You need to validate your email address before being able to use %s.', //TODO - Translation
			'resend_email' => 'Resend the email', //TODO - Translation
			'title' => 'Email address validation', //TODO - Translation
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'title' => 'You need to validate your account', //TODO - Translation
			'welcome' => 'Welcome %s,', //TODO - Translation
			'body' => 'You’ve just registered on %s but you still need to validate your email. For that, just follow the link:', //TODO - Translation
		),
	),
);

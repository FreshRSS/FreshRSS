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
			'invalid' => 'This email address is invalid.',
			'required' => 'An email address is required.',
		],
		'validation' => [
			'change_email' => 'You can change your email address <a href="%s">on the profile page</a>.',
			'email_sent_to' => 'We sent you an email at <strong>%s</strong>. Please follow its instructions to validate your address.',
			'feedback' => [
				'email_failed' => 'We couldn’t send you an email because of a server configuration error.',
				'email_sent' => 'An email has been sent to your address.',
				'error' => 'Email address validation failed.',
				'ok' => 'This email address has been validated.',
				'unnecessary' => 'This email address was already validated.',
				'wrong_token' => 'This email address failed to be validated due to a wrong token.',
			],
			'need_to' => 'You need to validate your email address before being able to use %s.',
			'resend_email' => 'Resend the email',
			'title' => 'Email address validation',
		],
	],
	'mailer' => [
		'email_need_validation' => [
			'body' => 'You’ve just registered on %s, but you still need to validate your email address. For that, just follow the link:',
			'title' => 'You need to validate your account',
			'welcome' => 'Welcome %s,',
		],
	],
	'password' => [
		'invalid' => 'The password is invalid.',
	],
	'tos' => [
		'feedback' => [
			'invalid' => 'You must accept the Terms of Service to be able to register.',
		],
	],
	'username' => [
		'invalid' => 'This username is invalid.',
		'taken' => 'This username, %s, is taken.',
	],
];

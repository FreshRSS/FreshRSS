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
			'invalid' => 'This email address is invalid.',	// IGNORE
			'required' => 'An email address is required.',	// IGNORE
		),
		'validation' => array(
			'change_email' => 'You can change your email address <a href="%s">on the profile page</a>.',	// IGNORE
			'email_sent_to' => 'We sent you an email at <strong>%s</strong>. Please follow its instructions to validate your address.',	// IGNORE
			'feedback' => array(
				'email_failed' => 'We couldn’t send you an email because of a server configuration error.',	// IGNORE
				'email_sent' => 'An email has been sent to your address.',	// IGNORE
				'error' => 'Email address validation failed.',	// IGNORE
				'ok' => 'This email address has been validated.',	// IGNORE
				'unnecessary' => 'This email address was already validated.',	// IGNORE
				'wrong_token' => 'This email address failed to be validated due to a wrong token.',	// IGNORE
			),
			'need_to' => 'You need to validate your email address before being able to use %s.',	// IGNORE
			'resend_email' => 'Resend the email',	// IGNORE
			'title' => 'Email address validation',	// IGNORE
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'You’ve just registered on %s, but you still need to validate your email address. For that, just follow the link:',	// IGNORE
			'title' => 'You need to validate your account',	// IGNORE
			'welcome' => 'Welcome %s,',	// IGNORE
		),
	),
	'password' => array(
		'invalid' => 'The password is invalid.',	// IGNORE
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'You must accept the Terms of Service to be able to register.',	// IGNORE
		),
	),
	'username' => array(
		'invalid' => 'This username is invalid.',	// IGNORE
		'taken' => 'This username, %s, is taken.',	// IGNORE
	),
);

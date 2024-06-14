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
			'invalid' => 'Neplatná e-mailová adresa.',
			'required' => 'E-mailová adresa je povinná.',
		),
		'validation' => array(
			'change_email' => 'E-mailovú adresu môžete zmeniť <a href="%s">na stránke profilu</a>.',
			'email_sent_to' => 'Poslali sme Vám e-mail na adresu <strong>%s</strong>. Prosím, overete Vašu e-mailovú adresu podľa pokynov v e-maile.',
			'feedback' => array(
				'email_failed' => 'E-mail sa nepodarilo odoslať. Server je chybne nastavený.',
				'email_sent' => 'Práve vám bol odoslaný e-mail na vašeu adresu.',
				'error' => 'Nepodarilo sa overiť Vašu e-mailovú adresu.',
				'ok' => 'E-mailová adresa úspešne overená.',
				'unnecessary' => 'Táto e-mailová adresa už bola overená.',
				'wrong_token' => 'Túto e-mailovú adresu sa nepodarilo overiť. Neplatný token.',
			),
			'need_to' => 'Aby ste mohli používať %s, musíte najskôr overiť Vašu e-mailovú adresu',
			'resend_email' => 'Znovu poslať e-mail',
			'title' => 'Overenie e-mailovej adresy',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Práve ste sa zaregistrovali na %s, ale stále ešte musíte overiť Vašu e-mailovú adresu. Kliknite na odkaz::',
			'title' => 'Overte si Vaše konto',
			'welcome' => 'Vitajte %s,',
		),
	),
	'password' => array(
		'invalid' => 'Neplatné heslo.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Aby ste sa mohli zaregistrovať, musíte najskôr súhlasiť s podmienkami služby.',
		),
	),
	'username' => array(
		'invalid' => 'Toto používateľské meno je neplatné.',
		'taken' => 'Používateľské meno %s sa už používa.',
	),
);

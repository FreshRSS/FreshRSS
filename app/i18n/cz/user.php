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
			'invalid' => 'Tato e-mailová adresa je neplatná.',
			'required' => 'Je vyžadována e-mailová adresa.',
		),
		'validation' => array(
			'change_email' => 'Svou e-mailovou adresu můžete změnit <a href="%s">na stránce profilu</a>.',
			'email_sent_to' => 'Odeslali jsme vám e-mail na <strong>%s</strong>. Postupujte podle jeho pokynů pro ověření vaší adresy.',
			'feedback' => array(
				'email_failed' => 'Nemohli jsme vám odeslat e-mail kvůli chybně nastavenému serveru.',
				'email_sent' => 'Na vaši adresu byl odeslán e-mail.',
				'error' => 'Ověření e-mailové adresy selhalo.',
				'ok' => 'Tato e-mailová adresa byla ověřena.',
				'unnecessary' => 'Tato e-mailová adresa již byla ověřena.',
				'wrong_token' => 'Tuto e-mailovou adresu se nepodařilo ověřit kvůli špatnému tokenu.',
			),
			'need_to' => 'Než budete moci používat %s, musíte ověřit svou e-mailovou adresu.',
			'resend_email' => 'Znovu odeslat e-mail',
			'title' => 'Ověření e-mailové adresy',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Právě jste se zaregistrovali na %s, ale ještě musíte ověřit svou e-mailovou adresu. Přejděte na následující odkaz:',
			'title' => 'Musíte ověřit svůj účet',
			'welcome' => 'Vítejt, %s,',
		),
	),
	'password' => array(
		'invalid' => 'Heslo je neplatné.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Musíte přijmout Podmínky služby, abyste se mohli zaregistrovat.',
		),
	),
	'username' => array(
		'invalid' => 'Toto uživatelské jméno je neplatné.',
		'taken' => 'Toto uživatelské jméno, %s, je zabráno.',
	),
);

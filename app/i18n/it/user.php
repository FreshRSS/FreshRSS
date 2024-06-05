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
			'invalid' => 'Questo indirizzo email non è valido.',
			'required' => 'L’indirizzo email è obbligatorio.',
		),
		'validation' => array(
			'change_email' => 'Puoi cambiare il tuo indirizzo email <a href="%s">nella tua pagina profilo</a>.',
			'email_sent_to' => 'Ti abbiamo inviato un’email all’indirizzo <strong>%s</strong>. Segui le istruzioni indicate per validare il tuo indirizzo.',
			'feedback' => array(
				'email_failed' => 'Non è stato possibile inviare l’email a causa di un errore nella configurazione del server.',
				'email_sent' => 'È stata inviata un’email al tuo indirizzo.',
				'error' => 'La validazione dell’indirizzo email è fallita.',
				'ok' => 'Questo indirizzo email è stato validato.',
				'unnecessary' => 'Questo indirizzo email è già stato validato.',
				'wrong_token' => 'Questo indirizzo email non è stato validato a causa di un token errato.',
			),
			'need_to' => 'Devi validare la tua email prima di poter utilizzare %s.',
			'resend_email' => 'Invia nuovamente l’email',
			'title' => 'Validazione dell’indirizzo email',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Ti sei appena registrato su %s, ma devi ancora validare il tuo indirizzo email. Per fare ciò, segui il link:',
			'title' => 'Devi validare il tuo account',
			'welcome' => 'Benvenuto %s,',
		),
	),
	'password' => array(
		'invalid' => 'La password non è valida.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Devi accettare i termini e condizioni del servizio per poterti registrare.',
		),
	),
	'username' => array(
		'invalid' => 'Questo nome utente non è valido.',
		'taken' => 'Questo nome utente, %s, è già stato utilizzato.',
	),
);

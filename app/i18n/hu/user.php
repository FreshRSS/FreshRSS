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
			'invalid' => 'Érvénytelen email cím.',
			'required' => 'Email cím megadása kötelező.',
		],
		'validation' => [
			'change_email' => 'Megváltoztathatod az email címed <a href="%s">a profil lapon</a>.',
			'email_sent_to' => 'Email-t küldtünk neked a <strong>%s</strong> címre. Kövesd a leírást hogy visszaigazolhasd a címedet.',
			'feedback' => [
				'email_failed' => 'Nem tudtunk email-t küldeni neked egy szerver konfigurációs hiba miatt.',
				'email_sent' => 'Egy email lett elküldve a címedre.',
				'error' => 'Email cím visszaigazolás sikertelen.',
				'ok' => 'Az email cím visszaigazolása megtörtént.',
				'unnecessary' => 'Ez az email cím már visszaigazolásra került.',
				'wrong_token' => 'Az email cím visszaigazolása nem sikerült egy hibás token miatt.',
			],
			'need_to' => 'Vissza kell igazolnod az email címed mielőtt használhatnád %s.',
			'resend_email' => 'Email újraküldése',
			'title' => 'Email cím visszaigazolás',
		],
	],
	'mailer' => [
		'email_need_validation' => [
			'body' => 'Épp most regisztráltál a %s -re, de még vissza kell igazolnod az email címed. Ehhez csak kövesd a linket:',
			'title' => 'Vissza kell igazolnod a fiókod',
			'welcome' => 'Üdv %s,',
		],
	],
	'password' => [
		'invalid' => 'Érvénytelen jelszó.',
	],
	'tos' => [
		'feedback' => [
			'invalid' => 'El kell fogadnod a Szolgáltatási feltételeket hogy regisztrálhass.',
		],
	],
	'username' => [
		'invalid' => 'Érvénytelen felhasználónév.',
		'taken' => 'Ez a felhasználónév, %s, már foglalt.',
	],
];

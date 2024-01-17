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
			'invalid' => 'Ten adres e-mailowy jest niepoprawny.',
			'required' => 'Wymagane jest podanie adresu e-mail.',
		],
		'validation' => [
			'change_email' => 'Możesz zmienić używany adres e-mail w <a href="%s">ustawieniach swojego profilu</a>.',
			'email_sent_to' => 'Na adres e-mail <strong>%s</strong> została wysłana wiadomość zawierająca instrukcję weryfikacji. Prosimy się z nią zapoznać.',
			'feedback' => [
				'email_failed' => 'Nie udało się wysłać wiadomości e-mail z powodu błędu konfiguracji serwera.',
				'email_sent' => 'Wiadomośc e-mail została wysłana na podany adres.',
				'error' => 'Weryfikacja adresu poczty e-mail nie powiodła się.',
				'ok' => 'Adres poczty e-mail został potwierdzony.',
				'unnecessary' => 'Podany adres poczty e-mail został już wcześniej potwierdzony.',
				'wrong_token' => 'Nie udało się zweryfikować adresu poczty e-mail z powodu niewłaściwego tokena.',
			],
			'need_to' => 'Musisz zweryfikować swój adres e-mail zanim będziesz mógł zacząć używać serwis %s.',
			'resend_email' => 'Wyślij ponownie wiadomość e-mail',
			'title' => 'Potwierdzenie adresu e-mail',
		],
	],
	'mailer' => [
		'email_need_validation' => [
			'body' => 'Właśnie zarejestrowałeś się w serwisie %s. Aby uzyskać pełen dostęp musisz jeszcze potwierdzić ważność swojego adresu e-mail. Możesz to zrobić klikając na niniejszy odnośnik:',
			'title' => 'Musisz zweryfikować swoje konto',
			'welcome' => 'Cześć, %s,',
		],
	],
	'password' => [
		'invalid' => 'Hasło nie jest prawidłowe.',
	],
	'tos' => [
		'feedback' => [
			'invalid' => 'Aby się zarejestrować, należy zgodzić się na Warunki użytkowania.',
		],
	],
	'username' => [
		'invalid' => 'Ta nazwa użytkownika nie jest prawidłowa.',
		'taken' => 'Użytkownik %s już istnieje.',
	],
];

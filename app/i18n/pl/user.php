<?php

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'Ten adres e-mailowy jest niepoprawny.',
			'required' => 'Wymagane jest podanie adresu e-mail.',
		),
		'validation' => array(
			'change_email' => 'Możesz zmienić używany adres e-mail w <a href="%s">ustawieniach swojego profilu</a>.',
			'email_sent_to' => 'Na adres e-mail <strong>%s</strong> została wysłana wiadomość zawierająca instrukcję weryfikacji. Prosimy się z nią zapoznać.',
			'feedback' => array(
				'email_failed' => 'Nie udało się wysłać wiadomości e-mail z powodu błędu konfiguracji serwera.',
				'email_sent' => 'Wiadomośc e-mail została wysłana na podany adres.',
				'error' => 'Weryfikacja adresu poczty e-mail nie powiodła się.',
				'ok' => 'Adres poczty e-mail został potwierdzony.',
				'unnecessary' => 'Podany adres poczty e-mail został już wcześniej potwierdzony.',
				'wrong_token' => 'Nie udało się zweryfikować adresu poczty e-mail z powodu niewłaściwego tokena.',
			),
			'need_to' => 'Musisz zweryfikować swój adres e-mail zanim będziesz mógł zacząć używać serwis %s.',
			'resend_email' => 'Wyślij ponownie wiadomość e-mail',
			'title' => 'Potwierdzenie adresu e-mail',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Właśnie zarejestrowałeś się w serwisie %s. Aby uzyskać pełen dostęp musisz jeszcze potwierdzić ważność swojego adresu e-mail. Możesz to zrobić klikając na niniejszy odnośnik:',
			'title' => 'Musisz zweryfikować swoje konto',
			'welcome' => 'Cześć, %s,',
		),
	),
	'password' => array(
		'invalid' => 'Hasło nie jest prawidłowe.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Aby się zarejestrować, należy zgodzić się na Warunki użytkowania.',
		),
	),
	'username' => array(
		'invalid' => 'Ta nazwa użytkownika nie jest prawidłowa.',
		'taken' => 'Użytkownik %s już istnieje.',
	),
);

<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'Šis el. pašto adresas netinkamas.',
			'required' => 'Būtina nurodyti el. pašto adresą.',
		),
		'validation' => array(
			'change_email' => 'Savo el. pašto adresą galite pakeisti <a href="%s">profilio puslapyje</a>.',
			'email_sent_to' => 'Išsiuntėme jums laišką adresu <strong>%s</strong>. Norėdami patvirtinti adresą, vadovaukitės jame pateiktais nurodymais.',
			'feedback' => array(
				'email_failed' => 'Nepavyko išsiųsti jums laiško dėl serverio konfigūracijos klaidos.',
				'email_sent' => 'Laiškas išsiųstas jūsų adresu.',
				'error' => 'Nepavyko patvirtinti el. pašto adreso.',
				'ok' => 'Šis el. pašto adresas patvirtintas.',
				'unnecessary' => 'Šis el. pašto adresas jau buvo patvirtintas.',
				'wrong_token' => 'Nepavyko patvirtinti šio el. pašto adreso dėl neteisingo prieigos rakto.',
			),
			'need_to' => 'Prieš pradėdami naudotis %s, turite patvirtinti savo el. pašto adresą.',
			'resend_email' => 'Siųsti laišką pakartotinai',
			'title' => 'El. pašto adreso patvirtinimas',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Ką tik užsiregistravote svetainėje %s, tačiau dar turite patvirtinti savo el. pašto adresą. Tam tiesiog spustelėkite nuorodą:',
			'title' => 'Turite patvirtinti savo paskyrą',
			'welcome' => 'Sveiki, %s,',
		),
	),
	'password' => array(
		'invalid' => 'Slaptažodis netinkamas.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Kad galėtumėte užsiregistruoti, turite sutikti su naudojimosi sąlygomis.',
		),
	),
	'username' => array(
		'invalid' => 'Šis naudotojo vardas netinkamas.',
		'taken' => 'Naudotojo vardas %s jau užimtas.',
	),
);

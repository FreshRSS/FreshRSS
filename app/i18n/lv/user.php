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
			'invalid' => 'Šī e-pasta adrese ir nederīga.',
			'required' => 'Ir jānorāda e-pasta adrese.',
		),
		'validation' => array(
			'change_email' => 'Jūs varat mainīt savu e-pasta adresi <a href="%s">profila lapā</a>.',
			'email_sent_to' => 'Mēs nosūtījām jums e-pastu uz <strong>%s</strong>. Lūdzu, izpildiet tajā sniegtos norādījumus, lai apstiprinātu savu adresi.',
			'feedback' => array(
				'email_failed' => 'Servera konfigurācijas kļūdas dēļ mēs nevarējām jums nosūtīt e-pastu.',
				'email_sent' => 'Uz jūsu adresi tika nosūtīta e-pasta vēstule.',
				'error' => 'E-pasta adreses validācija neizdevās.',
				'ok' => 'Šī e-pasta adrese tika apstiprināta.',
				'unnecessary' => 'Šī e-pasta adrese jau ir apstiprināta.',
				'wrong_token' => 'Šo e-pasta adresi neizdevās apstiprināt kļūdaina žetona dēļ.',
			),
			'need_to' => 'Jums ir jāapstiprina sava e-pasta adrese, lai varētu izmantot %s.',
			'resend_email' => 'Atkārtoti nosūtīt e-pasta vēstuli',
			'title' => 'E-pasta adreses validēšana',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Jūs tikko reģistrējāties vietnē %s, bet jums vēl ir jāapstiprina sava e-pasta adrese. Lai to izdarītu, vienkārši sekojiet šai saitei:',
			'title' => 'Jums ir jāapstiprina savs konts',
			'welcome' => 'Sveicināti, %s,',
		),
	),
	'password' => array(
		'invalid' => 'Parole ir nederīga.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Lai varētu reģistrēties, jums ir jāpiekrīt pakalpojumu sniegšanas noteikumiem.',
		),
	),
	'username' => array(
		'invalid' => 'Šis lietotājvārds ir nederīgs.',
		'taken' => 'Šis lietotājvārds, %s, ir aizņemts.',
	),
);

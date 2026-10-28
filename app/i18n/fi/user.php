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
			'invalid' => 'Sähköpostiosoite on virheellinen.',
			'required' => 'Sähköpostiosoite on pakollinen.',
		),
		'validation' => array(
			'change_email' => 'Voit muuttaa sähköpostiosoitteesi <a href="%s">profiilisivulla</a>.',
			'email_sent_to' => 'Sähköposti on lähetetty osoitteeseen <strong>%s</strong>. Vahvista sähköpostiosoitteesi seuraamalla sen ohjeita.',
			'feedback' => array(
				'email_failed' => 'Sähköpostiviestin lähetys ei onnistunut palvelimen määritysvirheen vuoksi.',
				'email_sent' => 'Sähköpostiviesti on lähetetty osoitteeseesi.',
				'error' => 'Sähköpostiosoitteen vahvistaminen ei onnistunut.',
				'ok' => 'Sähköpostiosoite on vahvistettu.',
				'unnecessary' => 'Sähköpostiosoite on vahvistettu aiemmin.',
				'wrong_token' => 'Sähköpostiosoitteen vahvistus epäonnistui väärän suojaustunnuksen vuoksi.',
			),
			'need_to' => 'Sinun on vahvistettava sähköpostiosoitteesi, ennen kuin voit käyttää sovellusta %s.',
			'resend_email' => 'Lähetä sähköposti uudelleen',
			'title' => 'Sähköpostiosoitteen vahvistus',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Olet juuri rekisteröitynyt sovellukseen %s, mutta sinun on vielä vahvistettava sähköpostiosoitteesi. Seuraa vain linkkiä:',
			'title' => 'Tili on vahvistettava',
			'welcome' => 'Tervetuloa Welcome %s,',
		),
	),
	'password' => array(
		'invalid' => 'Salasana on väärä.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Rekisteröityminen edellyttää palvelun käyttöehtojen hyväksymistä.',
		),
	),
	'username' => array(
		'invalid' => 'Käyttäjätunnus on virheellinen.',
		'taken' => 'Käyttäjätunnus, %s, on jo käytössä.',
	),
);

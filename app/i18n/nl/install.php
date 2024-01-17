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
	'action' => [
		'finish' => 'Completeer installatie',
		'fix_errors_before' => 'Repareer de fouten alvorens naar de volgende stap te gaan.',
		'keep_install' => 'Behoud de vorige installatie',
		'next_step' => 'Ga naar de volgende stap',
		'reinstall' => 'Installeer FreshRSS opnieuw',
	],
	'auth' => [
		'form' => 'Web formulier (traditioneel, benodigd JavaScript)',
		'http' => 'HTTP (voor geavanceerde gebruikers met HTTPS)',
		'none' => 'Geen (gevaarlijk)',
		'password_form' => 'Wachtwoord<br /><small>(voor de Web-formulier log in methode)</small>',
		'password_format' => 'Tenminste 7 tekens',
		'type' => 'Authenticatiemethode',
	],
	'bdd' => [
		'_' => 'Database',	// IGNORE
		'conf' => [
			'_' => 'Database configuratie',
			'ko' => 'Controleer uw database informatie.',
			'ok' => 'Database configuratie is opgeslagen.',
		],
		'host' => 'Host',	// IGNORE
		'password' => 'Database wachtwoord',
		'prefix' => 'Tabel voorvoegsel',
		'type' => 'Type database',
		'username' => 'Database gebruikersnaam',
	],
	'check' => [
		'_' => 'Controles',
		'already_installed' => 'We hebben geconstateerd dat FreshRSS al is geïnstallerd!',
		'cache' => [
			'nok' => 'Controleer permissies van de <em>%s</em> map. HTTP server moet rechten hebben om er in te kunnen schrijven.',
			'ok' => 'Permissies van de cache map zijn goed.',
		],
		'ctype' => [
			'nok' => 'U mist een benodigde bibliotheek voor character type checking (php-ctype).',
			'ok' => 'U hebt de benodigde bibliotheek voor character type checking (ctype).',
		],
		'curl' => [
			'nok' => 'U mist cURL (php-curl package).',
			'ok' => 'U hebt de cURL uitbreiding.',
		],
		'data' => [
			'nok' => 'Controleer permissies van de <em>%s</em> map. HTTP server moet rechten hebben om er in te kunnen schrijven.',
			'ok' => 'Permissies van de data map zijn goed.',
		],
		'dom' => [
			'nok' => 'U mist een benodigde bibliotheek om te bladeren in de DOM.',
			'ok' => 'U hebt de benodigde bibliotheek om te bladeren in de DOM.',
		],
		'favicons' => [
			'nok' => 'Controleer permissies van de <em>%s</em> map. HTTP server moet rechten hebben om er in te kunnen schrijven.',
			'ok' => 'Permissies van de favicons map zijn goed.',
		],
		'fileinfo' => [
			'nok' => 'U mist PHP fileinfo (fileinfo package).',
			'ok' => 'U hebt de fileinfo uitbreiding.',
		],
		'json' => [
			'nok' => 'U mist een benodigede bibliotheek om JSON te gebruiken.',
			'ok' => 'U hebt de benodigde bibliotheek om JSON te gebruiken.',
		],
		'mbstring' => [
			'nok' => 'De voor Unicode aanbevolen bibliotheek mbstring kan niet worden gevonden.',
			'ok' => 'De voor Unicode aanbevolen bibliotheek mbstring is gevonden.',
		],
		'pcre' => [
			'nok' => 'U mist een benodigde bibliotheek voor regular expressions (php-pcre).',
			'ok' => 'U hebt de benodigde bibliotheek voor regular expressions (PCRE).',
		],
		'pdo' => [
			'nok' => 'U mist PDO of één van de ondersteunde (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'U hebt PDO en ten minste één van de ondersteunde drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		],
		'php' => [
			'nok' => 'Uw PHP versie is %s maar FreshRSS benodigd tenminste versie %s.',
			'ok' => 'Uw PHP versie is %s, welke compatibel is met FreshRSS.',
		],
		'reload' => 'Controleer nog eens',
		'tmp' => [
			'nok' => 'Controleer permissies van de <em>%s</em> map. HTTP server moet rechten hebben om er in te kunnen schrijven.',
			'ok' => 'Permissies van de temp-map zijn goed.',
		],
		'unknown_process_username' => 'onbekend',
		'users' => [
			'nok' => 'Controleer permissies van de <em>%s</em> map. HTTP server moet rechten hebben om er in te kunnen schrijven.',
			'ok' => 'Permissies van de users map zijn goed.',
		],
		'xml' => [
			'nok' => 'U mist de benodigde bibliotheek om XML te gebruiken.',
			'ok' => 'U hebt de benodigde bibliotheek om XML te gebruiken.',
		],
	],
	'conf' => [
		'_' => 'Algemene configuratie',
		'ok' => 'Algemene configuratie is opgeslagen.',
	],
	'congratulations' => 'Gefeliciteerd!',
	'default_user' => [
		'_' => 'Gebruikersnaam van de standaardgebruiker',
		'max_char' => 'maximaal 16 alfanumerieke tekens',
	],
	'fix_errors_before' => 'Repareer fouten alvorens U naar de volgende stap gaat.',
	'javascript_is_better' => 'FreshRSS werkt beter JavaScript ingeschakeld',
	'js' => [
		'confirm_reinstall' => 'U zal uw vorige configuratie kwijtraken door FreshRSS opnieuw te installeren. Weet u zeker dat u verder wilt gaan?',
	],
	'language' => [
		'_' => 'Taal',
		'choose' => 'Kies een taal voor FreshRSS',
		'defined' => 'Taal is bepaald.',
	],
	'missing_applied_migrations' => 'Er is iets misgegaan; u zal handmatig een leeg bestand <em>%s</em> aan moeten maken.',
	'ok' => 'De installatieprocedure is geslaagd.',
	'session' => [
		'nok' => 'De webserver lijkt niet goed te zijn geconfigureerd voor de cookies die voor PHP-sessies nodig zijn!',
	],
	'step' => 'stap %d',
	'steps' => 'Stappen',
	'this_is_the_end' => 'Dit is het einde',
	'title' => 'Installatie · FreshRSS',
];

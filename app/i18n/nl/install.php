<?php
/* Dutch translation by Wanabo. http://www.nieuwskop.be */
return array(
	'action' => array(
		'finish' => 'Completeer installatie',
		'fix_errors_before' => 'Repareer de fouten alvorens naar de volgende stap te gaan.',
		'keep_install' => 'Behoud de vorige installatie',
		'next_step' => 'Ga naar de volgende stap',
		'reinstall' => 'Installeer FreshRSS opnieuw',
	),
	'auth' => array(
		'email_persona' => 'Log in mail adres<br /><small>(voor <a href="https://persona.org/" rel="external">Mozilla Persona</a>)</small>',
		'form' => 'Web formulier (traditioneel, benodigd JavaScript)',
		'http' => 'HTTP (voor geavanceerde gebruikers met HTTPS)',
		'none' => 'Geen (gevaarlijk)',
		'password_form' => 'Wachtwoord<br /><small>(voor de Web-formulier log in methode)</small>',
		'password_format' => 'Tenminste 7 tekens',
		'persona' => 'Mozilla Persona (modern, benodigd JavaScript)',
		'type' => 'Authenticatie methode',
	),
	'bdd' => array(
		'_' => 'Database',
		'conf' => array(
			'_' => 'Database configuratie',
			'ko' => 'Controleer uw database informatie.',
			'ok' => 'Database configuratie is opgeslagen.',
		),
		'host' => 'Host',
		'prefix' => 'Tabel voorvoegsel',
		'password' => 'HTTP wachtwoord',
		'type' => 'Type database',
		'username' => 'HTTP gebruikersnaam',
	),
	'check' => array(
		'_' => 'Controles',
		'already_installed' => 'We hebben geconstateerd dat FreshRSS al is geïnstallerd!',
		'cache' => array(
			'nok' => 'Controleer permissies van de <em>./data/cache</em> map. HTTP server moet rechten hebben om er in te kunnen schrijven',
			'ok' => 'Permissies van de cache map zijn goed.',
		),
		'ctype' => array(
			'nok' => 'U mist een benodigde bibliotheek voor character type checking (php-ctype).',
			'ok' => 'U hebt de benodigde bibliotheek voor character type checking (ctype).',
		),
		'curl' => array(
			'nok' => 'U mist cURL (php5-curl package).',
			'ok' => 'U hebt de cURL uitbreiding.',
		),
		'data' => array(
			'nok' => 'Controleer permissies van de <em>./data</em> map. HTTP server moet rechten hebben om er in te kunnen schrijven',
			'ok' => 'Permissies van de data map zijn goed.',
		),
		'dom' => array(
			'nok' => 'U mist een benodigde bibliotheek om te bladeren in de DOM (php-xml package).',
			'ok' => 'U hebt de benodigde bibliotheek om te bladeren in de DOM.',
		),
		'favicons' => array(
			'nok' => 'Controleer permissies van de <em>./data/favicons</em> map. HTTP server moet rechten hebben om er in te kunnen schrijven',
			'ok' => 'Permissies van de favicons map zijn goed.',
		),
		'http_referer' => array(
			'nok' => 'Controleer a.u.b. dat u niet uw HTTP REFERER wijzigd.',
			'ok' => 'Uw HTTP REFERER is bekend en komt overeen met uw server.',
		),
		'minz' => array(
			'nok' => 'U mist het Minz framework.',
			'ok' => 'U hebt het Minz framework.',
		),
		'pcre' => array(
			'nok' => 'U mist een benodigde bibliotheek voor regular expressions (php-pcre).',
			'ok' => 'U hebt de benodigde bibliotheek voor regular expressions (PCRE).',
		),
		'pdo' => array(
			'nok' => 'U mist PDO of één van de ondersteunde (pdo_mysql, pdo_sqlite).',
			'ok' => 'U hebt PDO en ten minste één van de ondersteunde drivers (pdo_mysql, pdo_sqlite).',
		),
		'persona' => array(
			'nok' => 'Controleer permissies van de <em>./data/persona</em> map. HTTP server moet rechten hebben om er in te kunnen schrijven',
			'ok' => 'Permissies van de Mozilla Persona map zijn goed.',
		),
		'php' => array(
			'nok' => 'Uw PHP versie is %s maar FreshRSS benodigd tenminste versie %s.',
			'ok' => 'Uw PHP versie is %s, welke compatibel is met FreshRSS.',
		),
		'users' => array(
			'nok' => 'Controleer permissies van de <em>./data/users</em> map. HTTP server moet rechten hebben om er in te kunnen schrijven',
			'ok' => 'Permissies van de users map zijn goed.',
		),
	),
	'conf' => array(
		'_' => 'Algemene configuratie',
		'ok' => 'Algemene configuratie is opgeslagen.',
	),
	'congratulations' => 'Gefeliciteerd!',
	'default_user' => 'Gebruikersnaam van de standaard gebruiker <small>(maximaal 16 alphanumerieke tekens)</small>',
	'delete_articles_after' => 'Verwijder artikelen na',
	'fix_errors_before' => 'Repareer fouten alvorens U naar de volgende stap gaat.',
	'javascript_is_better' => 'FreshRSS werkt beter JavaScript ingeschakeld',
	'js' => array(
		'confirm_reinstall' => 'U verliest uw vorige configuratie door FreshRSS opnieuw te installeren. Weet u zeker dat u verder wilt gaan?',
	),
	'language' => array(
		'_' => 'Taal',
		'choose' => 'Kies een taal voor FreshRSS',
		'defined' => 'Taal is bepaald.',
	),
	'not_deleted' => 'Er ging iets fout! U moet het bestand <em>%s</em> handmatig verwijderen.',
	'ok' => 'De installatie procedure is geslaagd.',
	'step' => 'stap %d',
	'steps' => 'Stappen',
	'title' => 'Installatie · FreshRSS',
	'this_is_the_end' => 'Dit is het einde',
);

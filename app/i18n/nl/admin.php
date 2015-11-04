<?php
/* Dutch translation by Wanabo. http://www.nieuwskop.be */
return array(
	'auth' => array(
		'allow_anonymous' => 'Sta bezoekers toe om artikelen te lezen van de standaard gebruiker (%s)',
		'allow_anonymous_refresh' => 'Sta bezoekers toe om de artikelen te vernieuwen',
		'api_enabled' => 'Sta <abbr>API</abbr> toegang toe <small>(nodig voor mobiele apps)</small>',
		'form' => 'Web formulier (traditioneel, benodigd JavaScript)',
		'http' => 'HTTP (voor geavanceerde gebruikers met HTTPS)',
		'none' => 'Geen (gevaarlijk)',
		'persona' => 'Mozilla Persona (modern, benodigd JavaScript)',
		'title' => 'Authenticatie',
		'title_reset' => 'Authenticatie terugzetten',
		'token' => 'Authenticatie teken',
		'token_help' => 'Sta toegang toe tot de RSS uitvoer van de standaard gebruiker zonder authenticatie:',
		'type' => 'Authenticatie methode',
		'unsafe_autologin' => 'Sta onveilige automatische log in toe met het volgende formaat: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Controleer de permissies van de <em>./data/cache</em> map. HTTP server moet rechten hebben om hierin te schrijven',
			'ok' => 'Permissies van de cache map zijn goed.',
		),
		'categories' => array(
			'nok' => 'Categorie tabel is slecht geconfigureerd.',
			'ok' => 'Categorie tabel is ok.',
		),
		'connection' => array(
			'nok' => 'Verbinding met de database kan niet worden gemaakt.',
			'ok' => 'Verbinding met de database is ok.',
		),
		'ctype' => array(
			'nok' => 'U mist de benodigde bibliotheek voor character type checking (php-ctype).',
			'ok' => 'U hebt de benodigde bibliotheek voor character type checking (ctype).',
		),
		'curl' => array(
			'nok' => 'U mist de cURL (php5-curl package).',
			'ok' => 'U hebt de cURL uitbreiding.',
		),
		'data' => array(
			'nok' => 'Controleer de permissies op de <em>./data</em> map. HTTP server moet rechten hebben om hierin te schrijven',
			'ok' => 'Permissies op de data map zijn goed.',
		),
		'database' => 'Database installatie',
		'dom' => array(
			'nok' => 'U mist de benodigde bibliotheek voor het bladeren van DOM (php-xml package).',
			'ok' => 'U hebt de benodigde bibliotheek voor het bladeren van DOM.',
		),
		'entries' => array(
			'nok' => 'Invoer tabel is slecht geconfigureerd.',
			'ok' => 'Invoer tabel is ok.',
		),
		'favicons' => array(
			'nok' => 'Controleer de permissies op de <em>./data/favicons</em> map. HTTP server moet rechten hebben om hierin te schrijven',
			'ok' => 'Permissies op de favicons map zijn goed.',
		),
		'feeds' => array(
			'nok' => 'Feed tabel is slecht geconfigureerd.',
			'ok' => 'Feed tabel is ok.',
		),
		'files' => 'Bestanden installatie',
		'json' => array(
			'nok' => 'U mist JSON (php5-json package).',
			'ok' => 'U hebt JSON uitbreiding.',
		),
		'minz' => array(
			'nok' => 'U mist Minz framework.',
			'ok' => 'U hebt Minz framework.',
		),
		'pcre' => array(
			'nok' => 'U mist de benodigde bibliotheek voor regular expressions (php-pcre).',
			'ok' => 'U hebt de benodigde bibliotheek voor regular expressions (PCRE).',
		),
		'pdo' => array(
			'nok' => 'U mist PDO of een van de ondersteunde drivers (pdo_mysql, pdo_sqlite).',
			'ok' => 'U hebt PDO en ten minste één van de ondersteunde drivers (pdo_mysql, pdo_sqlite).',
		),
		'persona' => array(
			'nok' => 'Controleer de permissies op de <em>./data/persona</em> map. HTTP server moet rechten hebben om hierin te schrijven',
			'ok' => 'Permissies op de Mozilla Persona map zijn goed.',
		),
		'php' => array(
			'_' => 'PHP installatie',
			'nok' => 'Uw PHP versie is %s maar FreshRSS benodigd tenminste versie %s.',
			'ok' => 'Uw PHP versie is %s, welke compatibel is met FreshRSS.',
		),
		'tables' => array(
			'nok' => 'Er zijn één of meer ontbrekende tabellen in de database.',
			'ok' => 'Alle tabellen zijn aanwezig in de database.',
		),
		'title' => 'Installatie controle',
		'tokens' => array(
			'nok' => 'Controleer de permissies op de <em>./data/tokens</em> map. HTTP server moet rechten hebben om hierin te schrijven',
			'ok' => 'Permissies op de tokens map zijn goed.',
		),
		'users' => array(
			'nok' => 'Controleer de permissies op de <em>./data/users</em> map. HTTP server moet rechten hebben om hierin te schrijven',
			'ok' => 'Permissies op de users map zijn goed.',
		),
		'zip' => array(
			'nok' => 'U mist ZIP uitbreiding (php5-zip package).',
			'ok' => 'U hebt ZIP uitbreiding.',
		),
	),
	'extensions' => array(
		'disabled' => 'Uitgeschakeld',
		'empty_list' => 'Er zijn geïnstalleerde uitbreidingen',
		'enabled' => 'Ingeschakeld',
		'no_configure_view' => 'Deze uitbreiding kan niet worden geconfigureerd.',
		'system' => array(
			'_' => 'Systeem uitbreidingen',
			'no_rights' => 'Systeem uitbreidingen (U hebt hier geen rechten op)',
		),
		'title' => 'Uitbreidingen',
		'user' => 'Gebruikers uitbreidingen',
	),
	'stats' => array(
		'_' => 'Statistieken',
		'all_feeds' => 'Alle feeds',
		'category' => 'Categorie',
		'entry_count' => 'Invoer aantallen',
		'entry_per_category' => 'Aantallen per categorie',
		'entry_per_day' => 'Aantallen per day (laatste 30 dagen)',
		'entry_per_day_of_week' => 'Per dag of week (gemiddeld: %.2f berichten)',
		'entry_per_hour' => 'Per uur (gemiddeld: %.2f berichten)',
		'entry_per_month' => 'Per maand (gemiddeld: %.2f berichten)',
		'entry_repartition' => 'Invoer verdeling',
		'feed' => 'Feed',
		'feed_per_category' => 'Feeds per categorie',
		'idle' => 'Gepauzeerde feeds',
		'main' => 'Hoofd statistieken',
		'main_stream' => 'Overzicht',
		'menu' => array(
			'idle' => 'Gepauzeerde feeds',
			'main' => 'Hoofd statistieken',
			'repartition' => 'Artikelen verdeling',
		),
		'no_idle' => 'Er is geen gepauzeerde feed!',
		'number_entries' => '%d artikelen',
		'percent_of_total' => '%% van totaal',
		'repartition' => 'Artikelen verdeling',
		'status_favorites' => 'Favorieten',
		'status_read' => 'Gelezen',
		'status_total' => 'Totaal',
		'status_unread' => 'Ongelezen',
		'title' => 'Statistieken',
		'top_feed' => 'Top tien feeds',
	),
	'system' => array(
		'_' => 'System configuration', // @todo translate
		'auto-update-url' => 'Auto-update server URL', // @todo translate
		'instance-name' => 'Instance name', // @todo translate
		'max-categories' => 'Categories per user limit', // @todo translate
		'max-feeds' => 'Feeds per user limit', // @todo translate
		'registration' => array(
			'help' => '0 means that there is no account limit', // @todo translate
			'number' => 'Max number of accounts', // @todo translate
		),
	),
	'update' => array(
		'_' => 'Versie controle',
		'apply' => 'Toepassen',
		'check' => 'Controleer op nieuwe versies',
		'current_version' => 'Uw huidige versie van FreshRSS is %s.',
		'last' => 'Laatste controle: %s',
		'none' => 'Geen nieuwe versie om toe te passen',
		'title' => 'Vernieuw systeem',
	),
	'user' => array(
		'articles_and_size' => '%s artikelen (%s)',
		'create' => 'Creëer  nieuwe gebruiker',
		'email_persona' => 'Log in mail adres<br /><small>(voor <a href="https://persona.org/" rel="external">Mozilla Persona</a>)</small>',
		'language' => 'Taal',
		'number' => 'Er is %d accounts gemaakt',
		'numbers' => 'Er zijn %d accounts gemaakt',
		'password_form' => 'Wachtwoord<br /><small>(voor de Web-formulier log in methode)</small>',
		'password_format' => 'Ten minste 7 tekens',
		'registration' => array(
			'allow' => 'Sta het maken van nieuwe accounts toe',
			'help' => '0 betekent dat er geen account limiet is',
			'number' => 'Max aantal van accounts',
		),
		'title' => 'Beheer gebruikers',
		'user_list' => 'Lijst van gebruikers ',
		'username' => 'Gebruikers naam',
		'users' => 'Gebruikers',
	),
);

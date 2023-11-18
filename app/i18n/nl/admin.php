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
	'auth' => array(
		'allow_anonymous' => 'Sta bezoekers toe om artikelen te lezen van de standaard gebruiker (%s)',
		'allow_anonymous_refresh' => 'Sta bezoekers toe om de artikelen te vernieuwen',
		'api_enabled' => 'Sta <abbr>API</abbr> toegang toe <small>(nodig voor mobiele apps)</small>',
		'form' => 'Web formulier (traditioneel, JavaScript vereist)',
		'http' => 'HTTP (voor gevorderde gebruikers met HTTPS)',
		'none' => 'Geen (gevaarlijk)',
		'title' => 'Authenticatie',
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
			'nok' => 'U mist de cURL (php-curl package).',
			'ok' => 'U hebt de cURL uitbreiding.',
		),
		'data' => array(
			'nok' => 'Controleer de permissies op de <em>./data</em> map. De HTTP server moet rechten hebben om hierin te schrijven',
			'ok' => 'Permissies op de data map zijn in orde.',
		),
		'database' => 'Database installatie',
		'dom' => array(
			'nok' => 'U mist de benodigde bibliotheek voor het bladeren van DOM (php-xml package).',
			'ok' => 'U hebt de benodigde bibliotheek voor het bladeren van DOM.',
		),
		'entries' => array(
			'nok' => 'Invoertabel is slecht geconfigureerd.',
			'ok' => 'Invoertabel is ok.',
		),
		'favicons' => array(
			'nok' => 'Controleer de permissies op de <em>./data/favicons</em> map. HTTP server moet rechten hebben om hierin te schrijven',
			'ok' => 'Permissies op de favicons map zijn goed.',
		),
		'feeds' => array(
			'nok' => 'Feedtabel is slecht geconfigureerd.',
			'ok' => 'Feedtabel is ok.',
		),
		'fileinfo' => array(
			'nok' => 'U mist de PHP fileinfo (fileinfo package).',
			'ok' => 'U hebt de fileinfo uitbreiding.',
		),
		'files' => 'Bestanden installatie',
		'json' => array(
			'nok' => 'U mist JSON (php-json package).',
			'ok' => 'U hebt JSON uitbreiding.',
		),
		'mbstring' => array(
			'nok' => 'De voor Unicode aanbevolen bibliotheek mbstring kan niet worden gevonden.',
			'ok' => 'De voor Unicode aanbevolen bibliotheek mbstring is gevonden.',
		),
		'pcre' => array(
			'nok' => 'U mist de benodigde bibliotheek voor regular expressions (php-pcre).',
			'ok' => 'U hebt de benodigde bibliotheek voor regular expressions (PCRE).',
		),
		'pdo' => array(
			'nok' => 'U mist PDO of een van de ondersteunde drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'U hebt PDO en ten minste één van de ondersteunde drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',
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
			'nok' => 'U mist ZIP uitbreiding (php-zip package).',
			'ok' => 'U hebt ZIP uitbreiding.',
		),
	),
	'extensions' => array(
		'author' => 'Auteur',
		'community' => 'Gebruikersuitbreidingen beschikbaar',
		'description' => 'Beschrijving',
		'disabled' => 'Uitgeschakeld',
		'empty_list' => 'Er zijn geïnstalleerde uitbreidingen',
		'enabled' => 'Ingeschakeld',
		'latest' => 'Geïnstalleerd',
		'name' => 'Naam',
		'no_configure_view' => 'Deze uitbreiding kan niet worden geconfigureerd.',
		'system' => array(
			'_' => 'Systeemuitbreidingen',
			'no_rights' => 'Systeemuitbreidingen (U hebt hier geen rechten op)',
		),
		'title' => 'Uitbreidingen',
		'update' => 'Update beschikbaar',
		'user' => 'Gebruikersuitbreidingen',
		'version' => 'Versie',
	),
	'stats' => array(
		'_' => 'Statistieken',
		'all_feeds' => 'Alle feeds',
		'category' => 'Categorie',
		'entry_count' => 'Invoer aantallen',
		'entry_per_category' => 'Aantallen per categorie',
		'entry_per_day' => 'Aantallen per dag (laatste 30 dagen)',
		'entry_per_day_of_week' => 'Per dag of week (gemiddeld: %.2f berichten)',
		'entry_per_hour' => 'Per uur (gemiddeld: %.2f berichten)',
		'entry_per_month' => 'Per maand (gemiddeld: %.2f berichten)',
		'entry_repartition' => 'Invoer verdeling',
		'feed' => 'Feed',	// IGNORE
		'feed_per_category' => 'Feeds per categorie',
		'idle' => 'Gepauzeerde feeds',
		'main' => 'Hoofd statistieken',
		'main_stream' => 'Overzicht',
		'no_idle' => 'Er is geen gepauzeerde feed!',
		'number_entries' => '%d artikelen',
		'percent_of_total' => '% van totaal',
		'repartition' => 'Artikelverdeling',
		'status_favorites' => 'Favorieten',
		'status_read' => 'Gelezen',
		'status_total' => 'Totaal',
		'status_unread' => 'Ongelezen',
		'title' => 'Statistieken',
		'top_feed' => 'Top tien feeds',
	),
	'system' => array(
		'_' => 'Systeem configuratie',
		'auto-update-url' => 'Automatische update server URL',
		'base-url' => array(
			'_' => 'Basis-url',
			'recommendation' => 'Automatische aanbeveling: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => 'in seconden',
			'number' => 'Tijdsduur om ingelogd te blijven',
		),
		'force_email_validation' => 'Emailadresvalidatie forceren',
		'instance-name' => 'Voorbeeld naam',
		'max-categories' => 'Categorielimiet per gebruiker',
		'max-feeds' => 'Feedlimiet per gebruiker',
		'registration' => array(
			'number' => 'Maximum aantal accounts',
			'select' => array(
				'label' => 'Registratieformulier',
				'option' => array(
					'noform' => 'Uitgeschakeld: geen registratieformulier',
					'nolimit' => 'Ingeschakeld: geen limiet op aantal accounts',
					'setaccountsnumber' => 'Max. aantal accounts instellen',
				),
			),
			'status' => array(
				'disabled' => 'Formulier uitgeschakeld',
				'enabled' => 'Form ingeschakeld',
			),
			'title' => 'Gebruikersregistratieformulier',
		),
		'sensitive-parameter' => 'Kwetsbare parameter. Handmatig te bewerken in <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'is niet ingegeven',
			'enabled' => '<a href="./?a=tos">is ingeschakeld</a>',
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">algemene voorwaarden inschakelen</a>',
		),
		'websub' => array(
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		),
	),
	'update' => array(
		'_' => 'Versie controle',
		'apply' => 'Toepassen',
		'changelog' => 'Changelog',	// IGNORE
		'check' => 'Controleer op nieuwe versies',
		'copiedFromURL' => 'update.php gekopieerd van %s naar ./data',
		'current_version' => 'Uw huidige versie',
		'last' => 'Laatste controle',
		'loading' => 'Updaten…',
		'none' => 'Geen nieuwe versie om toe te passen',
		'releaseChannel' => array(
			'_' => 'Release-kanaal',
			'edge' => 'Rollende release (“edge”)',
			'latest' => 'Stabiele release (“latest”)',
		),
		'title' => 'Vernieuw systeem',
		'viaGit' => 'Update via git and Github.com gestart',
	),
	'user' => array(
		'admin' => 'Beheerder',
		'article_count' => 'Artikelen',
		'back_to_manage' => '← Terug naar gebruikerslijst',
		'create' => 'Creëer nieuwe gebruiker',
		'database_size' => 'Databasegrootte',
		'email' => 'Emailadres',
		'enabled' => 'Ingeschakeld',
		'feed_count' => 'Feeds',	// IGNORE
		'is_admin' => 'Is beheerder',
		'language' => 'Taal',
		'last_user_activity' => 'Laatste gebruikersactiviteit',
		'list' => 'Gebruikerslijst',
		'number' => 'Er is %d accounts gemaakt',
		'numbers' => 'Er zijn %d accounts gemaakt',
		'password_form' => 'Wachtwoord<br /><small>(voor de Web-formulier loginmethode)</small>',
		'password_format' => 'Ten minste 7 tekens',
		'title' => 'Beheer gebruikers',
		'username' => 'Gebruikersnaam',
	),
);

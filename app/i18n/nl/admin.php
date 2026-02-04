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
	'auth' => array(
		'allow_anonymous' => 'Sta bezoekers toe om artikelen te lezen van de standaard gebruiker (%s)',
		'allow_anonymous_refresh' => 'Sta bezoekers toe om de artikelen te vernieuwen',
		'api_enabled' => 'Sta <abbr>API</abbr> toegang toe <small>(nodig voor mobiele apps and sharing user queries)</small>',	// DIRTY
		'form' => 'Web formulier (traditioneel, JavaScript vereist)',
		'http' => 'HTTP (geavanceerd: beheerd door webserver, OIDC, SSO…)',
		'none' => 'Geen (gevaarlijk)',
		'title' => 'Authenticatie',
		'token' => 'Hoofdauthenticatietoken',
		'token_help' => 'Geeft toegang tot alle RSS-uitvoer van de gebruiker en kan feeds verversen zonder authenticatie:',
		'type' => 'Authenticatie methode',
	),
	'extensions' => array(
		'author' => 'Auteur',
		'community' => 'Gebruikersuitbreidingen beschikbaar',
		'description' => 'Beschrijving',
		'disabled' => 'Uitgeschakeld',
		'empty_list' => 'Er zijn geïnstalleerde uitbreidingen',
		'empty_list_help' => 'Controleer de logbestanden om de reden voor de lege extensielijst te achterhalen.',
		'enabled' => 'Ingeschakeld',
		'is_compatible' => 'Is compatibel',
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
		'date_published' => 'Publicatiedatum',
		'date_received' => 'Ontvangstdatum',
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
		'nb_unreads' => 'Aantal ongelezen artikelen',
		'no_idle' => 'Er is geen gepauzeerde feed!',
		'number_entries' => '%d artikelen',
		'overview' => 'Overzicht',
		'percent_of_total' => '% van totaal',
		'repartition' => 'Artikelverdeling: %s',
		'status_favorites' => 'Favorieten',
		'status_read' => 'Gelezen',
		'status_total' => 'Totaal',
		'status_unread' => 'Ongelezen',
		'title' => 'Statistieken',
		'top_feed' => 'Top tien feeds',
		'unread_dates' => 'Data met de meeste ongelezen artikelen',
	),
	'system' => array(
		'_' => 'Systeem configuratie',
		'auto-update-url' => 'Automatische update server URL',
		'base-url' => array(
			'_' => 'Basis-url',
			'recommendation' => 'Automatische aanbeveling: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => 'in seconden',
			'number' => 'Tijdsduur om ingelogd te blijven',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
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
			'help' => 'Over <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
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
		'viaGit' => 'Update via git and GitHub.com gestart',
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

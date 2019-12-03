<?php
/* Dutch translation by Wanabo. http://www.nieuwskop.be */
return array(
	'admin' => array(
		'optimization_complete' => 'Optimalisatie compleet',
	),
	'access' => array(
		'denied' => 'U hebt geen rechten om deze pagina te bekijken.',
		'not_found' => 'Deze pagina bestaat niet',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified', // TODO - Translation
			'updated' => 'Your password has been modified', // TODO - Translation
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'Er is een probleem opgetreden tijdens de controle van de systeemconfiguratie. Probeer het later nog eens.',
			'set' => 'Formulier is nu uw standaard authenticatie systeem.',
		),
		'login' => array(
			'invalid' => 'Login is ongeldig',
			'success' => 'U bent ingelogd',
		),
		'logout' => array(
			'success' => 'U bent uitgelogd',
		),
		'no_password_set' => 'Beheerderswachtwoord is niet ingesteld. Deze mogelijkheid is niet beschikbaar.',
	),
	'conf' => array(
		'error' => 'Er is een fout opgetreden tijdens het opslaan van de configuratie',
		'query_created' => 'Query "%s" is gemaakt.',
		'shortcuts_updated' => 'Verwijzingen zijn vernieuwd',
		'updated' => 'Configuratie is vernieuwd',
	),
	'extensions' => array(
		'already_enabled' => '%s is al ingeschakeld',
		'disable' => array(
			'ko' => '%s kan niet worden uitgeschakeld. <a href="%s">Controleer FreshRSS log bestanden</a> voor details.',
			'ok' => '%s is nu uitgeschakeld',
		),
		'enable' => array(
			'ko' => '%s kan niet worden ingeschakeld. <a href="%s">Controleer FreshRSS log bestanden</a> voor details.',
			'ok' => '%s is nn ingeschakeld',
		),
		'no_access' => 'U hebt geen toegang voor %s',
		'not_enabled' => '%s is nog niet ingeschakeld',
		'not_found' => '%s bestaat niet',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP uitbreiding is niet aanwezig op uw server. Exporteer a.u.b. uw bestanden één voor één.',
		'feeds_imported' => 'Uw feeds zijn geimporteerd en worden nu vernieuwd',
		'feeds_imported_with_errors' => 'Uw feeds zijn geimporteerd maar er zijn enige fouten opgetreden',
		'file_cannot_be_uploaded' => 'Bestand kan niet worden verzonden!',
		'no_zip_extension' => 'ZIP uitbreiding is niet aanwezig op uw server.',
		'zip_error' => 'Er is een fout opgetreden tijdens het imporeren van het ZIP bestand.',
	),
	'profile' => array(
		'error' => 'Uw profiel kan niet worden aangepast',
		'updated' => 'Uw profiel is aangepast',
	),
	'sub' => array(
		'actualize' => 'Actualiseren',
		'articles' => array(
			'marked_read' => 'De geselecteerde artikelen zijn als gelezen gemarkeerd.',
			'marked_unread' => 'De geselecteerde artikelen zijn als ongelezen gemarkeerd.',
		),
		'category' => array(
			'created' => 'Categorie %s is gemaakt.',
			'deleted' => 'Categorie is verwijderd.',
			'emptied' => 'Categorie is leeg gemaakt',
			'error' => 'Categorie kan niet worden vernieuwd',
			'name_exists' => 'Categorie naam bestaat al.',
			'no_id' => 'U moet de id specificeren of de categorie.',
			'no_name' => 'Categorie naam mag niet leeg zijn.',
			'not_delete_default' => 'U kunt de standaard categorie niet verwijderen!',
			'not_exist' => 'De categorie bestaat niet!',
			'over_max' => 'Maximum aantal categorieën bereikt (%d)',
			'updated' => 'Categorie vernieuwd.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> vernieuwd',
			'actualizeds' => 'RSS-feeds vernieuwd',
			'added' => 'RSS feed <em>%s</em> toegevoegd',
			'already_subscribed' => 'Al geabonneerd op <em>%s</em>',
			'deleted' => 'Feed verwijderd',
			'error' => 'Feed kan niet worden vernieuwd',
			'internal_problem' => 'De feed kon niet worden toegevoegd. <a href="%s">Controleer de FreshRSS-logbestanden</a> voor details. Toevoegen forceren kan worden geprobeerd door <code>#force_feed</code> aan de URL toe te voegen.',
			'invalid_url' => 'URL <em>%s</em> is ongeldig',
			'n_actualized' => '%d feeds zijn vernieuwd',
			'n_entries_deleted' => '%d artikelen zijn verwijderd',
			'no_refresh' => 'Er is geen feed om te vernieuwen…',
			'not_added' => '<em>%s</em> kon niet worden toegevoegd',
			'over_max' => 'Maximum aantal feeds bereikt (%d)',
			'updated' => 'Feed is vernieuwd',
		),
		'purge_completed' => 'Opschonen klaar (%d artikelen verwijderd)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS word nu vernieud naar <strong>versie %s</strong>.',
		'error' => 'Het vernieuwingsproces kwam een fout tegen: %s',
		'file_is_nok' => '<strong>Versie %s</strong>. Controleer permissies op <em>%s</em> map. HTTP server moet rechten hebben om er in te schrijven',
		'finished' => 'Vernieuwing compleet!',
		'none' => 'Geen vernieuwing om toe te passen',
		'server_not_found' => 'Vernieuwings server kan niet worden gevonden. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Gebruiker %s is aangemaakt',
			'error' => 'Gebruiker %s kan niet worden aangemaakt',
		),
		'deleted' => array(
			'_' => 'Gebruiker %s is verwijderd',
			'error' => 'Gebruiker %s kan niet worden verwijderd',
		),
		'updated' => array(
			'_' => 'Gebruiker %s is bijgewerkt',
			'error' => 'Gebruiker %s kan niet worden bijgewerkt',
		),
	),
);

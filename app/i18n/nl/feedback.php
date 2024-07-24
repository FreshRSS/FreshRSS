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
	'access' => array(
		'denied' => 'U hebt geen rechten om deze pagina te bekijken.',
		'not_found' => 'Deze pagina bestaat niet',
	),
	'admin' => array(
		'optimization_complete' => 'Optimalisatie compleet',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Het wachtwoord kan niet worden gewijzigd',
			'updated' => 'Het wachtwoord is gewijzigd',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Login is ongeldig',
			'success' => 'U bent ingelogd',
		),
		'logout' => array(
			'success' => 'U bent uitgelogd',
		),
	),
	'conf' => array(
		'error' => 'Er is een fout opgetreden tijdens het opslaan van de configuratie',
		'query_created' => 'Query „%s” is gemaakt.',
		'shortcuts_updated' => 'Verwijzingen zijn vernieuwd',
		'updated' => 'Configuratie is vernieuwd',
	),
	'extensions' => array(
		'already_enabled' => '%s is al ingeschakeld',
		'cannot_remove' => '%s kan niet worden verwijderd',
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
		'removed' => '%s verwijderd',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP uitbreiding is niet aanwezig op uw server. Exporteer a.u.b. uw bestanden één voor één.',
		'feeds_imported' => 'Uw feeds zijn geimporteerd en worden nu vernieuwd / Your feeds have been imported. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'feeds_imported_with_errors' => 'Uw feeds zijn geimporteerd maar er zijn enige fouten opgetreden / Your feeds have been imported, but some errors occurred. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'file_cannot_be_uploaded' => 'Bestand kan niet worden verzonden!',
		'no_zip_extension' => 'ZIP uitbreiding is niet aanwezig op uw server.',
		'zip_error' => 'Er is een fout opgetreden tijdens het imporeren van het ZIP bestand.',	// DIRTY
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
			'cache_cleared' => '<em>%s</em> cache verwijderd',
			'deleted' => 'Feed verwijderd',
			'error' => 'Feed kan niet worden vernieuwd',
			'internal_problem' => 'De feed kon niet worden toegevoegd. <a href="%s">Controleer de FreshRSS-logbestanden</a> voor details. Toevoegen forceren kan worden geprobeerd door <code>#force_feed</code> aan de URL toe te voegen.',
			'invalid_url' => 'URL <em>%s</em> is ongeldig',
			'n_actualized' => '%d feeds zijn vernieuwd',
			'n_entries_deleted' => '%d artikelen zijn verwijderd',
			'no_refresh' => 'Er is geen feed om te vernieuwen…',
			'not_added' => '<em>%s</em> kon niet worden toegevoegd',
			'not_found' => 'Feed niet gevonden',
			'over_max' => 'Maximum aantal feeds bereikt (%d)',
			'reloaded' => '<em>%s</em> is herladen',
			'selector_preview' => array(
				'http_error' => 'Website-inhoud laden mislukt.',
				'no_entries' => 'Er zijn geen artikels in deze feed. Er moet ten minste een artikel zijn om een voorbeeld te tonen.',
				'no_feed' => 'Interne fout (feed kan niet worden gevonden).',
				'no_result' => 'De selector komt met niets overeen. Als een terugval zal de originele feedtekst worden weergegeven.',
				'selector_empty' => 'De selector is leeg. Er moet een selector worden gedefinieerd om een voorbeeld te tonen.',
			),
			'updated' => 'Feed is vernieuwd',
		),
		'purge_completed' => 'Opschonen klaar (%d artikelen verwijderd)',
	),
	'tag' => array(
		'created' => 'Label „%s” aangemaakt.',
		'error' => 'Label kon niet worden bijgewerkt!',
		'name_exists' => 'Label bestaat al.',
		'renamed' => 'Label „%s” hernoemd naar „%s”.',
		'updated' => 'Label bijgewerkt.',
	),
	'update' => array(
		'can_apply' => 'FreshRSS word nu bijgewerkt naar <strong>versie %s</strong>.',
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

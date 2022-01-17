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
	'api' => array(
		'documentation' => 'Kopieer de volgende URL om deze in een externe toepassing te gebruiken.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Sleep deze knop naar je bladwijzerwerkbalk of klik erop met de rechtermuisknop en kies "Deze link aan bladwijzers toevoegen."',
		'label' => 'Abonneren',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Categorie',
		'add' => 'Voeg categorie',
		'archiving' => 'Archiveren',
		'empty' => 'Lege categorie',
		'information' => 'Informatie',
		'position' => 'Weergavepositie',
		'position_help' => 'Om de categorieweergave-sorteervolgorde te controleren',
		'title' => 'Titel',
	),
	'feed' => array(
		'add' => 'Voeg een RSS-feed toe',
		'advanced' => 'Geavanceerd',
		'archiving' => 'Archiveren',
		'auth' => array(
			'configuration' => 'Log in',
			'help' => 'Verbinding toestaan toegang te krijgen tot HTTP beveiligde RSS-feeds',
			'http' => 'HTTP Authenticatie',
			'password' => 'HTTP wachtwoord',
			'username' => 'HTTP gebruikers naam',
		),
		'clear_cache' => 'Cache altijd leegmaken',
		'content_action' => array(
			'_' => 'Inhoudsactie bij ophalen artikelinhoud',
			'append' => 'Na huidige inhoud toevoegen',
			'prepend' => 'Voor huidige inhoud toevoegen',
			'replace' => 'Huidige inhoud vervangen',
		),
		'css_cookie' => 'Cookies gebruiken bij het ophalen van artikelinhoud',
		'css_cookie_help' => 'Voorbeeld: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Haalt onvolledige RSS-feeds op (attentie, heeft meer tijd nodig!)',
		'css_path' => 'CSS-pad van artikelen op originele website',
		'description' => 'Omschrijving',
		'empty' => 'Deze feed is leeg. Controleer of deze nog actueel is.',
		'error' => 'Deze feed heeft problemen. Verifieer a.u.b het doeladres en actualiseer het.',
		'filteractions' => array(
			'_' => 'Filteracties',
			'help' => 'Voer één zoekfilter per lijn in.',
		),
		'information' => 'Informatie',
		'keep_min' => 'Minimum aantal artikelen om te houden',
		'maintenance' => array(
			'clear_cache' => 'Cache leegmaken',
			'clear_cache_help' => 'Cache voor deze feed leegmaken.',
			'reload_articles' => 'Artikels herladen',
			'reload_articles_help' => 'Artikels herladen en complete inhoud ophalen als een selector is gedefinieerd.',
			'title' => 'Onderhoud',
		),
		'moved_category_deleted' => 'Als u een categorie verwijderd, worden de feeds automatisch geclassificeerd onder <em>%s</em>.',
		'mute' => 'demp',
		'no_selected' => 'Geen feed geselecteerd.',
		'number_entries' => '%d artikelen',
		'priority' => array(
			'_' => 'Zichtbaarheid',
			'archived' => 'Niet weergeven (gearchiveerd)',
			'main_stream' => 'Zichtbaar in het overzicht',
			'normal' => 'Toon in categorie',
		),
		'proxy' => 'Proxy instellen om deze feed op te halen',
		'proxy_help' => 'Selecteer een protocol (bv. SOCKS5) en voer een proxy-adres in (b.v. <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Broncode tonen',
			'show_rendered' => 'Inhoud tonen',
		),
		'show' => array(
			'all' => 'Alle feeds tonen',
			'error' => 'Alleen feeds met een foutmelding tonen',
		),
		'showing' => array(
			'error' => 'Alleen feeds met een foutmelding worden getoond',
		),
		'ssl_verify' => 'SSL-veiligheid controleren',
		'stats' => 'Statistieken',
		'think_to_add' => 'Voeg wat feeds toe.',
		'timeout' => 'Time-out in seconden',
		'title' => 'Titel',
		'title_add' => 'Voeg een RSS-feed toe',
		'ttl' => 'Vernieuw automatisch niet vaker dan',
		'url' => 'Feed-url',
		'useragent' => 'Stelt de useragent in om deze feed op te halen',
		'useragent_help' => 'Voorbeeld: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Controleer de geldigheid van de feed',
		'website' => 'Website-url',
		'websub' => 'Directe notificaties met WebSub',
	),
	'import_export' => array(
		'export' => 'Exporteer',
		'export_labelled' => 'Exporteer gelabelde artikels',
		'export_opml' => 'Exporteer lijst van feeds (OPML)',
		'export_starred' => 'Exporteer je favorieten',
		'feed_list' => 'Lijst van %s artikelen',
		'file_to_import' => 'Bestand om te importeren<br />(OPML, JSON of ZIP)',
		'file_to_import_no_zip' => 'Bestand om te importeren<br />(OPML of JSON)',
		'import' => 'Importeer',
		'starred_list' => 'Lijst van favoriete artikelen',
		'title' => 'Importeren / exporteren',
	),
	'menu' => array(
		'add' => 'Feed of categorie toevoegen',
		'import_export' => 'Importeer / exporteer',
		'label_management' => 'Labelbeheer',
		'stats' => array(
			'idle' => 'Gepauzeerde feeds',
			'main' => 'Hoofd statistieken',
			'repartition' => 'Artikelen verdeling',
		),
		'subscription_management' => 'Abonnementenbeheer',
		'subscription_tools' => 'Hulpmiddelen voor abonnementen',
	),
	'tag' => array(
		'name' => 'Naam',
		'new_name' => 'Nieuwe naam',
		'old_name' => 'Oude naam',
	),
	'title' => array(
		'_' => 'Abonnementenbeheer',
		'add' => 'Feed of categorie toevoegen',
		'add_category' => 'Categorie toevoegen',
		'add_feed' => 'Feed toevoegen',
		'add_label' => 'Label toevoegen',
		'delete_label' => 'Label verwijderen',
		'feed_management' => 'RSS-feedbeheer',
		'rename_label' => 'Label hernoemen',
		'subscription_tools' => 'Hulpmiddelen voor abonnementen',
	),
);

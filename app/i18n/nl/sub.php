<?php

return array(
	'add' => 'Het toevoegen van feeds en categorieën is <a href=\'%s\'>hierheen</a> verplaatst. Deze functionaliteit is ook toegankelijk via het menu links en via het ✚ icoon op de hoofdpagina.',
	'api' => array(
		'documentation' => 'Kopieer de volgende URL om deze in een externe toepassing te gebruiken.',
		'title' => 'API',
	),
	'bookmarklet' => array(
		'documentation' => 'Sleep deze knop naar je bladwijzerwerkbalk of klik erop met de rechtermuisknop en kies "Deze link aan bladwijzers toevoegen."',
		'label' => 'Abonneren',
		'title' => 'Bookmarklet',
	),
	'category' => array(
		'_' => 'Categorie',
		'add' => 'Voeg categorie toe',
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
		'css_cookie' => 'Use Cookies when fetching the article content',	// TODO - Translation
		'css_cookie_help' => 'Example: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',	// TODO - Translation
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
		'proxy' => 'Set a proxy for fetching this feed',	// TODO - Translation
		'proxy_help' => 'Select a protocol (e.g: SOCKS5) and enter the proxy address (e.g: <kbd>127.0.0.1:1080</kbd>)',	// TODO - Translation
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
		'validator' => 'Controleer de geldigheid van de feed',
		'website' => 'Website-url',
		'websub' => 'Directe notificaties met WebSub',
	),
	'firefox' => array(
		'documentation' => 'Volg de stappen die <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">hier</a> beschreven worden om FreshRSS aan de Firefox-nieuwslezerlijst toe te voegen.',
		'obsolete_63' => 'Vanaf versie 63 en nieuwer, heeft Firefox de mogelijkheid om zelf niewslezers toe te voegen verwijderd voor online diensten.',
		'title' => 'Firefox-nieuwslezer',
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
		'add_feed' => 'Feed toevoegen',
		'bookmark' => 'Abonneer (FreshRSS bladwijzer)',
		'import_export' => 'Importeer / exporteer',
		'subscription_management' => 'Abonnementenbeheer',
		'subscription_tools' => 'Hulpmiddelen voor abonnementen',
		'tag_management' => 'Tag management',	// TODO - Translation
	),
	'tag' => array(
		'name' => 'Name',	// TODO - Translation
		'new_name' => 'New name',	// TODO - Translation
		'old_name' => 'Old name',	// TODO - Translation
	),
	'title' => array(
		'_' => 'Abonnementenbeheer',
		'add' => 'Feed of categorie toevoegen',
		'add_category' => 'Categorie toevoegen',
		'add_feed' => 'Feed toevoegen',
		'add_tag' => 'Add a tag',	// TODO - Translation
		'delete_tag' => 'Delete a tag',	// TODO - Translation
		'feed_management' => 'RSS-feedbeheer',
		'rename_tag' => 'Rename a tag',	// TODO - Translation
		'subscription_tools' => 'Hulpmiddelen voor abonnementen',
	),
);

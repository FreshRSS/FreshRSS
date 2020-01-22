<?php

return array(
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
		'add' => 'Voeg categorie toe',
		'archiving' => 'Archiveren',
		'empty' => 'Lege categorie',
		'information' => 'Informatie',
		'new' => 'Nieuwe categorie',
		'position' => 'Weergavepositie',
		'position_help' => 'Om de categorieweergave-sorteervolgorde te controleren',
		'title' => 'Titel',
		'_' => 'Categorie',
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
		'css_help' => 'Haalt onvolledige RSS-feeds op (attentie, heeft meer tijd nodig!)',
		'css_path' => 'CSS-pad van artikelen op originele website',
		'description' => 'Omschrijving',
		'empty' => 'Deze feed is leeg. Controleer of deze nog actueel is.',
		'error' => 'Deze feed heeft problemen. Verifieer a.u.b het doeladres en actualiseer het.',
		'filteractions' => array(
			'help' => 'Voer één zoekfilter per lijn in.',
			'_' => 'Filteracties',
		),
		'information' => 'Informatie',
		'keep_min' => 'Minimum aantal artikelen om te houden',
		'maintenance' => array(
			'clear_cache' => 'Clear cache',	// TODO - Translation
			'clear_cache_help' => 'Clear the cache of this feed on disk',	// TODO - Translation
			'reload_articles' => 'Reload articles',	// TODO - Translation
			'reload_articles_help' => 'Reload articles and fetch complete content',	// TODO - Translation
			'title' => 'Maintenance',	// TODO - Translation
		),
		'moved_category_deleted' => 'Als u een categorie verwijderd, worden de feeds automatisch geclassificeerd onder <em>%s</em>.',
		'mute' => 'demp',
		'no_selected' => 'Geen feed geselecteerd.',
		'number_entries' => '%d artikelen',
		'priority' => array(
			'archived' => 'Niet weergeven (gearchiveerd)',
			'main_stream' => 'Zichtbaar in het overzicht',
			'normal' => 'Toon in categorie',
			'_' => 'Zichtbaarheid',
		),
		'selector_preview' => array(
			'show_raw' => 'Show source',	// TODO - Translation
			'show_rendered' => 'Show content',	// TODO - Translation
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
		'bookmark' => 'Abonneer (FreshRSS bladwijzer)',
		'import_export' => 'Importeer / exporteer',
		'subscription_management' => 'Abonnementenbeheer',
		'subscription_tools' => 'Hulpmiddelen voor abonnementen',
	),
	'title' => array(
		'feed_management' => 'RSS-feedbeheer',
		'subscription_tools' => 'Hulpmiddelen voor abonnementen',
		'_' => 'Abonnementenbeheer',
	),
);

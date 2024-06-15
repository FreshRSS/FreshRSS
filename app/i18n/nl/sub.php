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
		'documentation' => 'Sleep deze knop naar je bladwijzerwerkbalk of klik erop met de rechtermuisknop en kies „Deze link aan bladwijzers toevoegen.”',
		'label' => 'Abonneren',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Categorie',
		'add' => 'Voeg categorie',
		'archiving' => 'Archiveren',
		'dynamic_opml' => array(
			'_' => 'Dynamische OPML',
			'help' => 'Geef de URL naar een <a href="http://opml.org/" target="_blank">OPML-bestand</a> om deze categorie dynamisch met feeds te vullen',
		),
		'empty' => 'Lege categorie',
		'information' => 'Informatie',
		'opml_url' => 'OPML URL',	// IGNORE
		'position' => 'Weergavepositie',
		'position_help' => 'Om de categorieweergave-sorteervolgorde te controleren',
		'title' => 'Titel',
	),
	'feed' => array(
		'accept_cookies' => 'Cookies accepteren',
		'accept_cookies_help' => 'De feed-server toestaan cookies te plaatsen (die alleen voor de duur van de aanvraag in het geheugen worden opgeslagen)',
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
		'css_path_filter' => array(
			'_' => 'CSS selector van de elementen om te verwijderen',
			'help' => 'Een CSS selector kan een lijst zijn, zoals: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Omschrijving',
		'empty' => 'Deze feed is leeg. Controleer of deze nog actueel is.',
		'error' => 'Deze feed heeft problemen. Verifieer a.u.b het doeladres en actualiseer het.',
		'export-as-opml' => array(
			'download' => 'Downloaden',
			'help' => 'XML-bestand (data subset. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">See documentation</a>)',	// DIRTY
			'label' => 'Als OPML exporteren',
		),
		'filteractions' => array(
			'_' => 'Filteracties',
			'help' => 'Voer één zoekfilter per lijn in. Operators <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">see documentation</a>.',	// DIRTY
		),
		'information' => 'Informatie',
		'keep_min' => 'Minimum aantal artikelen om te houden',
		'kind' => array(
			'_' => 'Feedbron-type',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'feedtitel',
					'help' => 'Voorbeeld: <code>//title</code> of een statische string: <code>"Mijn aangepaste feed"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> is een standaard querytaal voor geavanceerde gebruikers, die door FreshRSS ondersteund wordt voor web scraping.',
				'item' => array(
					'_' => 'nieuws vinden <strong>berichten</strong><br /><small>(belangrijkste)</small>',
					'help' => 'Voorbeeld: <code>//div[@class="nieuws-bericht"]</code>',
				),
				'item_author' => array(
					'_' => 'auteur van het bericht',
					'help' => 'Kan ook een statische string zijn. Voorbeeld: <code>"Anoniem"</code>',
				),
				'item_categories' => 'tags van bericht',
				'item_content' => array(
					'_' => 'inhoud van bericht',
					'help' => 'Voorbeeld om het volledige bericht over te nemen: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'miniatuur van bericht',
					'help' => 'Voorbeeld: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Aangepast datum-/tijdformaat',
					'help' => 'Optioneel. Een formaat ondersteund door <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> zoals <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'datum van bericht',
					'help' => 'Het resultaat zal worden geparset door <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'titel van bericht',
					'help' => 'Gebruik vooral <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> zoals <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'uniek ID van bericht',
					'help' => 'Optioneel. Voorbeeld: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'link van bericht (URL)',
					'help' => 'Voorbeeld: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (relatief naar bericht) voor:',
				'xpath' => 'XPath voor:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (puntnotatie)',
				'feed_title' => array(
					'_' => 'feed-titel',
					'help' => 'Voorbeeld: <code>meta.titel</code> of een statische reeks tekst: <code>"Mijn aangepaste feed"</code>',
				),
				'help' => 'JSON-puntnotatie gebruikt punten tussen objecten en vierkante haakjes voor arrays (bv. <code>data.items[0].titel</code>)',
				'item' => array(
					'_' => 'nieuws-<strong>items</strong> vinden<br /><small>(het belangrijkst)</small>',
					'help' => 'JSON-puntnotatiepad naar de array met de items, bv. <code>nieuwsItems</code>',
				),
				'item_author' => 'item-auteur',
				'item_categories' => 'item-tags',
				'item_content' => array(
					'_' => 'item-inhoud',
					'help' => 'De sleutel waaronder de inhoude te vinden is, bv. <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'item-miniatuur',
					'help' => 'Voorbeeld: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Aangepast datum-/tijdformaat',
					'help' => 'Optioneel. Een formaat ondersteund door <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> zoals <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'item-datum',
					'help' => 'Het resultaat zal worden geparst door <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'item-titel',
				'item_uid' => 'uniek item-id',
				'item_uri' => array(
					'_' => 'item-link (url)',
					'help' => 'Voorbeeld: <code>permalink</code>',
				),
				'json' => 'puntnotatie voor:',
				'relative' => 'puntnotatiepad (relatief aan item) voor:',
			),
			'jsonfeed' => 'JSON Feed',	// IGNORE
			'rss' => 'RSS / Atom (standaard)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Cache leegmaken',
			'clear_cache_help' => 'Cache voor deze feed leegmaken.',
			'reload_articles' => 'Artikels herladen',
			'reload_articles_help' => 'Artikels herladen en complete inhoud ophalen als een selector is gedefinieerd.',	// DIRTY
			'title' => 'Onderhoud',
		),
		'max_http_redir' => 'Max HTTP redirects',	// IGNORE
		'max_http_redir_help' => 'Stel in op 0 of laat leeg om uit te schakelen, -1 voor ongelimiteerde redirects',
		'method' => array(
			'_' => 'HTTP-methode',
		),
		'method_help' => 'De POST-payload ondersteunt automatisch <code>application/x-www-form-urlencoded</code> en <code>application/json</code>',
		'method_postparams' => 'Payload voor POST',
		'moved_category_deleted' => 'Als u een categorie verwijderd, worden de feeds automatisch geclassificeerd onder <em>%s</em>.',
		'mute' => 'demp',
		'no_selected' => 'Geen feed geselecteerd.',
		'number_entries' => '%d artikelen',
		'priority' => array(
			'_' => 'Zichtbaarheid',
			'archived' => 'Niet weergeven (gearchiveerd)',
			'category' => 'Toon in categorie',
			'important' => 'In belangrijke feeds tonen',
			'main_stream' => 'Zichtbaar in het overzicht',
		),
		'proxy' => 'Proxy instellen om deze feed op te halen',
		'proxy_help' => 'Selecteer een protocol (bv. SOCKS5) en voer een proxy-adres in (b.v. <kbd>127.0.0.1:1080</kbd> or <kbd>username:password@127.0.0.1:1080</kbd>)',	// DIRTY
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
		'auto_label' => 'Dit label aan nieuwe artikelen toevoegen',
		'name' => 'Naam',
		'new_name' => 'Nieuwe naam',
		'old_name' => 'Oude naam',
	),
	'title' => array(
		'_' => 'Abonnementenbeheer',
		'add' => 'Feed of categorie toevoegen',
		'add_category' => 'Categorie toevoegen',
		'add_dynamic_opml' => 'Dynamische OPML toevoegen',
		'add_feed' => 'Feed toevoegen',
		'add_label' => 'Label toevoegen',
		'delete_label' => 'Label verwijderen',
		'feed_management' => 'RSS-feedbeheer',
		'rename_label' => 'Label hernoemen',
		'subscription_tools' => 'Hulpmiddelen voor abonnementen',
	),
);

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
		'documentation' => 'Skopírujte tento odkaz a použite ho v inom programe.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Presunte toto tlačidlo do vašich záložiek, alebo kliknite pravým a zvoľte “Uložiť odkaz do záložiek”. Potom kliknite na tlačidlo “Odoberať” na ktorejkoľvek stránke, ktorú chcete odoberať.',
		'label' => 'Odoberať',
		'title' => 'Záložka',
	),
	'category' => array(
		'_' => 'Kategória',
		'add' => 'Pridať kategória',
		'archiving' => 'Archív',
		'dynamic_opml' => array(
			'_' => 'Dynamické OPML',
			'help' => 'Zadajte URL adresu k <a href="http://opml.org/" target="_blank">OPML súboru</a>, z ktorého sa táto kategória automaticky naplní kanálmi.',
		),
		'empty' => 'Prázdna kategória',
		'information' => 'Informácia',
		'opml_url' => 'OPML URL',	// IGNORE
		'position' => 'Zobrazť pozíciu',
		'position_help' => 'Na kontrolu zoradenia kategórií',
		'title' => 'Názov',
	),
	'feed' => array(
		'accept_cookies' => 'Prijať cookies',
		'accept_cookies_help' => 'Povoliť serveru kanála nastaviť cookies (uložené v pamäti iba počas dopytu)',
		'add' => 'Pridať RSS kanál',
		'advanced' => 'Pokročilé',
		'archiving' => 'Archivovanie',
		'auth' => array(
			'configuration' => 'Prihlásenie',
			'help' => 'Povoliť prístup do kanálov chránených cez HTTP.',
			'http' => 'Prihlásenie cez HTTP',
			'password' => 'Heslo pre HTTP',
			'username' => 'Používateľské meno pre HTTP',
		),
		'clear_cache' => 'Vždy vymazať vyrovnávaciu pamäť',
		'content_action' => array(
			'_' => 'Akcia obsahu pri sťahovaní obsahu článku',
			'append' => 'Pridať za existujúci obsah',
			'prepend' => 'Pridať pred existujúci obsah',
			'replace' => 'Nahradiť existujúci obsh',
		),
		'css_cookie' => 'Pri sťahovaní obsahu článku použiť cookies',
		'css_cookie_help' => 'Príklad: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Stiahnuť skrátenú verziu RSS kanála (pozor, vyžaduje viac času!)',
		'css_path' => 'Pôvodný CSS súbor článku z webovej stránky',
		'css_path_filter' => array(
			'_' => 'CSS selektor elementu na odstránenie',
			'help' => 'CSS selektor môže byť zoznam ako: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Popis',
		'empty' => 'Tento kanál je prázdny. Overte, prosím, či je ešte spravovaný autorom.',
		'error' => 'Vyskytol sa problém s týmto kanálom. Overte, prosím, či kanál stále existuje, potom ho obnovte.',
		'export-as-opml' => array(
			'download' => 'Stiahnuť',
			'help' => 'XML súbor (data subset. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">See documentation</a>)',	// DIRTY
			'label' => 'Exportovať ako OPML',
		),
		'filteractions' => array(
			'_' => 'Filtrovať akcie',
			'help' => 'Napíšte jeden výraz hľadania na riadok. Operators <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">see documentation</a>.',	// DIRTY
		),
		'information' => 'Informácia',
		'keep_min' => 'Minimálny počet článkov na uchovanie',
		'kind' => array(
			'_' => 'Typ zdroja kanála',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'názov kanála',
					'help' => 'Príklad: <code>//title</code> alebo statický text: <code>"Môj vlastný kanál"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> je štandardný dopytovací jazyk pre pokročilých používateľov, ktorý FreshRSS podporuje na umožnenie funkcie Web scraping.',
				'item' => array(
					'_' => 'vyhľadávanie noviniek <strong>položky</strong><br /><small>(najdôležitejšie)</small>',
					'help' => 'Príklad: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'položka autor',
					'help' => 'Môže byť aj statický text. Príklad: <code>"Anonym"</code>',
				),
				'item_categories' => 'položka značky',
				'item_content' => array(
					'_' => 'položka obsah',
					'help' => 'Príklad na zabratie celej položky: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'položka miniatúra',
					'help' => 'Príklad: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Vlastný formát dátumu/času',
					'help' => 'Nepovinné. Formát podporovaný prostredníctvom <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> ako napríklad <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'položka dátum',
					'help' => 'Výsledok spracuje <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',	// DIRTY
				),
				'item_title' => array(
					'_' => 'položka nadpis',
					'help' => 'Použite hlavne <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> like <code>descendant::h2</code>',	// DIRTY
				),
				'item_uid' => array(
					'_' => 'položka unikátny identifikátor',
					'help' => 'Nepovinné. Príklad: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'položka odkaz (URL)',
					'help' => 'Príklad: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (relatívne k položke) pre:',
				'xpath' => 'XPath pre:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (zápis s bodkou)',
				'feed_title' => array(
					'_' => 'Názov kanála',
					'help' => 'Príklad: <code>meta.title</code> alebo ručne zadaná hodnota: <code>"Môj kanál"</code>',
				),
				'help' => 'JSON so zápisom s bodkou používa bodky na oddelenie objekov a zložené zátvorky pre polia (príklad: <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'hľadajú sa <strong>položky</strong> noviniek<br /><small>(najdôležitejšie)</small>',
					'help' => 'JSON cesta k polu obsahujúce položky, príklad: <code>newsItems</code>',
				),
				'item_author' => 'autor položky',
				'item_categories' => 'značky položky',
				'item_content' => array(
					'_' => 'obsah položky',
					'help' => 'Kľúč, pod ktorým je možné nájsť obsah, príklad: <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'miniatúra položky',
					'help' => 'Príklad: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Vlastný formát dátumu/času',
					'help' => 'Nepovinné. Formát podporovaný prostredníctvom <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> ako napríklad <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'dátum položky',
					'help' => 'Výsledok bude spracovaný prostredníctvom <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'nadpis položky',
				'item_uid' => 'jednoznačný identifikátor položky',
				'item_uri' => array(
					'_' => 'odkaz na položku (URL)',
					'help' => 'Príklad: <code>permalink</code>',
				),
				'json' => 'zápis s bodkou pre:',
				'relative' => 'cesta zápisu s bodkou (relatívna k položke) pre:',
			),
			'jsonfeed' => 'JSON kanál',
			'rss' => 'RSS / Atom (prednastavené)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Vymazať vyrovnáciu pamäť',
			'clear_cache_help' => 'Vymazať vyrovnáciu pamäť pre tento kanál.',
			'reload_articles' => 'Obnoviť články',
			'reload_articles_help' => 'Obnoviť články a stiahnuť kompletný obsah, ak je definovaný selektor.',	// DIRTY
			'title' => 'Údržba',
		),
		'max_http_redir' => 'Max HTTP presmerovaní',
		'max_http_redir_help' => 'Nastavte na 0 alebo nechajte prázdne na zakázanie, -1 pre neobmedzené množstvo presmerovaní',
		'method' => array(
			'_' => 'HTTP metóda',
		),
		'method_help' => 'Ako parametre metódy POST sú podporované <code>application/x-www-form-urlencoded</code> a <code>application/json</code>',
		'method_postparams' => 'Parametre metódy POST',
		'moved_category_deleted' => 'Keď vymažete kategóriu, jej kanály sa automaticky zaradia pod <em>%s</em>.',
		'mute' => 'stíšiť',
		'no_selected' => 'Nevybrali ste kanál.',
		'number_entries' => 'Počet článkov: %d',
		'priority' => array(
			'_' => 'Viditeľnosť',
			'archived' => 'Nezobrazovať (archivované)',
			'category' => 'Zobraziť vo svojej kategórii',
			'important' => 'Zobraziť v dôležitých kanáloch',
			'main_stream' => 'Zobraziť v prehľade kanálov',
		),
		'proxy' => 'Na sťahovanie tohto kanálu nastaviť proxy',
		'proxy_help' => 'Vyberte protokol (napr.: SOCKS5) a zadajte adresu proxy servera (napr.: <kbd>127.0.0.1:1080</kbd> or <kbd>username:password@127.0.0.1:1080</kbd>)',	// DIRTY
		'selector_preview' => array(
			'show_raw' => 'Zobraziť zdrojový kód',
			'show_rendered' => 'Zobraziť obsah',
		),
		'show' => array(
			'all' => 'Zobraziť všetky kanály',
			'error' => 'Zobraziť iba kanály s chybou',
		),
		'showing' => array(
			'error' => 'Zobraziť iba kanály s chybou',
		),
		'ssl_verify' => 'Overiť bezpečnosť SSL',
		'stats' => 'Štatistiky',
		'think_to_add' => 'Mali by ste pridať kanály.',
		'timeout' => 'Doba platnosti dá v sekundách',
		'title' => 'Nadpis',
		'title_add' => 'Pridať kanál RSS',
		'ttl' => 'Automaticky neaktualizovať častejšie ako',
		'url' => 'Odkaz kanála',
		'useragent' => 'Nastaviť používateľského agenta na sťahovanie tohto kanála',
		'useragent_help' => 'Príklad: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Skontrolovať platnosť kanála',
		'website' => 'Odkaz webovej stránky',
		'websub' => 'Okamžité oznámenia cez WebSub',
	),
	'import_export' => array(
		'export' => 'Exportovať',
		'export_labelled' => 'Exportovať vaše označené články',
		'export_opml' => 'Exportovať zoznam kanálov (OPML)',
		'export_starred' => 'Exportovať vaše obľúbené',
		'feed_list' => 'Zoznam článkov %s',
		'file_to_import' => 'Súbor na import<br />(OPML, JSON alebo ZIP)',
		'file_to_import_no_zip' => 'Súbor na import<br />(OPML alebo JSON)',
		'import' => 'Importovať',
		'starred_list' => 'Zoznam obľúbených článkov',
		'title' => 'Import / export',	// IGNORE
	),
	'menu' => array(
		'add' => 'Pridať kanál alebo kategóriu',
		'import_export' => 'Import / export',	// IGNORE
		'label_management' => 'Správca štítkov',
		'stats' => array(
			'idle' => 'Neaktívne kanály',
			'main' => 'Hlavné štatistiky',
			'repartition' => 'Rozdelenie článkov',
		),
		'subscription_management' => 'Správa odoberaných kanálov',
		'subscription_tools' => 'Nástroje na odoberanie kanálov',
	),
	'tag' => array(
		'auto_label' => 'Priraď túto menovku novým článkom',
		'name' => 'Názov',
		'new_name' => 'Nový názov',
		'old_name' => 'Starý názov',
	),
	'title' => array(
		'_' => 'Správa odoberaných kanálov',
		'add' => 'Pridať kanál alebo kategóriu',
		'add_category' => 'Pridať kategóriu',
		'add_dynamic_opml' => 'Pridať dynamické OPML',
		'add_feed' => 'Pridať kanál',
		'add_label' => 'Pridať štítok',
		'delete_label' => 'Zmazať štítok',
		'feed_management' => 'Správa RSS kanálov',
		'rename_label' => 'Premenovať štítok',
		'subscription_tools' => 'Nástroje na odoberanie kanálov',
	),
);

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
		'documentation' => 'Zkopírujte následující adresu URL pro její použití v externím nástroji.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Přetáhněte toto tlačítko do svého panelu nástrojů záložek nebo na něj klikněte pravým tlačítkem myši a zvolte „Uložit tento odkaz do záložek“. Pak klikněte na tlačítko „Přihlásit se k odběru“ na kterékoliv stránce, kde se chcete přihlásit k odběru.',
		'label' => 'Přihlásit se k odběru',
		'title' => 'Záložkový aplet',
	),
	'category' => array(
		'_' => 'Kategorie',
		'add' => 'Přidat kategorii',
		'archiving' => 'Archivace',
		'dynamic_opml' => array(
			'_' => 'Dynamický OPML',
			'help' => 'Zadejte adresu URL na <a href="http://opml.org/" target="_blank">OPML soubor</a> k dynamickému naplnění této kategorie RSS kanály',
		),
		'empty' => 'Vyprázdit kategorii',
		'information' => 'Informace',
		'opml_url' => 'ADRESA URL OPML',
		'position' => 'Zobrazit pozici',
		'position_help' => 'Pro ovládání pořadí řazení kategorií',
		'title' => 'Název',
	),
	'feed' => array(
		'accept_cookies' => 'Přijímat soubory cookie',
		'accept_cookies_help' => 'Povolit serveru feedu nastavit soubory cookie (uložené v paměti pouze po dobu trvání požadavku).',
		'add' => 'Přidat kanál RSS',
		'advanced' => 'Rozšířené',
		'archiving' => 'Archivace',
		'auth' => array(
			'configuration' => 'Přihlášení',
			'help' => 'Umožní přístup ke kanálům RSS chráněným HTTP',
			'http' => 'HTTP ověřování',
			'password' => 'HTTP heslo',
			'username' => 'HTTP uživatelské jméno',
		),
		'clear_cache' => 'Vždy vymazat mezipaměť',
		'content_action' => array(
			'_' => 'Akce obsahu při načítání obsahu článku',
			'append' => 'Přidat za existující obsah',
			'prepend' => 'Přidat před existující obsah',
			'replace' => 'Nahradit existující obsah',
		),
		'css_cookie' => 'Použít cookies při načítání obsahu článku',
		'css_cookie_help' => 'Příklad: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Načte oříznuté kanály RSS (pozor, náročnější na čas!)',
		'css_path' => 'Přepínač CSS článku na původních webových stránkách',
		'css_path_filter' => array(
			'_' => 'selektor CSS prvků, které mají být odstraněny',
			'help' => 'Selektor CSS může být seznam, například: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Popis',
		'empty' => 'Tento kanál je prázdný. Ověřte prosím, zda je stále udržován.',
		'error' => 'Vyskytl se problém s kanálem. Ověřte prosím, že je vždy dostupný, pak ho aktualizujte.',
		'filteractions' => array(
			'_' => 'Akce filtrování',
			'help' => 'Zapište jeden filtr hledání na řádek. Operators <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">see documentation</a>.',	// DIRTY
		),
		'information' => 'Informace',
		'keep_min' => 'Minimální počet článků pro ponechání',
		'kind' => array(
			'_' => 'Typ zdroje feedu',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'název zdroje',
					'help' => 'Příklad: <code>//title</code> nebo statický řetězec: <code>"Můj vlastní zdroj"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> je standardní dotazovací jazyk pro pokročilé uživatele, který FreshRSS podporuje, aby umožnil Web scraping.',
				'item' => array(
					'_' => 'vyhledávání <strong>novinek</strong><br /><small>(nejdůležitější)</small>',
					'help' => 'Příklad: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'autor položky',
					'help' => 'Může to být také statický řetězec. Příklad: <code>"Anonymous"</code>',
				),
				'item_categories' => 'štítky položek',
				'item_content' => array(
					'_' => 'obsah položky',
					'help' => 'Příklad pro převzetí celé položky: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'náhled položky',
					'help' => 'Příklad: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Custom date/time format',	// TODO
					'help' => 'Optional. A format supported by <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> such as <code>d-m-Y H:i:s</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'datum položky',
					'help' => 'Výsledek bude zpracován pomocí <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'název položky',
					'help' => 'Použijte zejména <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">osu XPath</a> <code>descendant::</code> jako např. <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'jedinečné ID položky',
					'help' => 'Volitelně. Příklad: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'odkaz na položku (URL)',
					'help' => 'Například: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (vzhledem k položce) pro:',
				'xpath' => 'XPath pro:',
			),
			'json_dotpath' => array(
				'_' => 'JSON (Dotted paths)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>meta.title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => 'A JSON dotted path uses dots between objects and brackets for arrays (e.g. <code>data.items[0].title</code>)',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'JSON path to the array containing the items, e.g. <code>newsItems</code>',	// TODO
				),
				'item_author' => 'item author',	// TODO
				'item_categories' => 'item tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Key under which the content is found, e.g. <code>content</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>image</code>',	// TODO
				),
				'item_timeFormat' => array(
					'_' => 'Custom date/time format',	// TODO
					'help' => 'Optional. A format supported by <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> such as <code>d-m-Y H:i:s</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => 'item title',	// TODO
				'item_uid' => 'item unique ID',	// TODO
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>permalink</code>',	// TODO
				),
				'json' => 'Dotted Path for:',	// TODO
				'relative' => 'Dotted Path (relative to item) for:',	// TODO
			),
			'jsonfeed' => 'JSON Feed',	// TODO
			'rss' => 'RSS / Atom (výchozí)',
			'xml_xpath' => 'XML + XPath',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'Vymazat mezipaměť',
			'clear_cache_help' => 'Vymazat mezipaměť pro tento kanál.',
			'reload_articles' => 'Znovu načíst články',
			'reload_articles_help' => 'Znovu načíst články a získat úplný obsah, pokud je definován selektor.',
			'title' => 'Údržba',
		),
		'max_http_redir' => 'Maximální počet přesměrování HTTP',
		'max_http_redir_help' => 'Nastavte na 0 nebo nechte prázdné pro zakázání, -1 pro neomezené přesměrování.',
		'method' => array(
			'_' => 'HTTP Method',	// TODO
		),
		'method_help' => 'The POST payload has automatic support for <code>application/x-www-form-urlencoded</code> and <code>application/json</code>',	// TODO
		'method_postparams' => 'Payload for POST',	// TODO
		'moved_category_deleted' => 'Když odstraníte kategorii, její kanály jsou automaticky přesunuty do <em>%s</em>.',
		'mute' => 'ztlumit',
		'no_selected' => 'Nejsou vybrány žádné kanály.',
		'number_entries' => '%d článků',
		'priority' => array(
			'_' => 'Viditelnost',
			'archived' => 'Nezobrazovat (archivováno)',
			'category' => 'Zobrazit v jeho kategorii',
			'important' => 'Show in important feeds',	// TODO
			'main_stream' => 'Zobrazit ve hlavním kanálu',
		),
		'proxy' => 'Nastavete proxy pro načítání tohoto kanálu',
		'proxy_help' => 'Vyberte protokol (např.: SOCKS5) a zadejte adresu proxy (např.: <kbd>127.0.0.1:1080</kbd> or <kbd>username:password@127.0.0.1:1080</kbd>)',	// DIRTY
		'selector_preview' => array(
			'show_raw' => 'Zobrazit zdrojový kód',
			'show_rendered' => 'Zobrazit obsah',
		),
		'show' => array(
			'all' => 'Zobrazit všechny kanály',
			'error' => 'Zobrazit pouze kanály s chybami',
		),
		'showing' => array(
			'error' => 'Zobrazení pouze kanálů s chybami',
		),
		'ssl_verify' => 'Ověřit zabezpečení SSL',
		'stats' => 'Statistika',
		'think_to_add' => 'Můžete přidat nějaké kanály.',
		'timeout' => 'Časový limit v sekundách',
		'title' => 'Název',
		'title_add' => 'Přidat kanál RSS',
		'ttl' => 'Neobnovovat automaticky častěji než',
		'url' => 'Adresa URL kanálu',
		'useragent' => 'Nastavte uživatelský agent pro načítání tohoto kanálu',
		'useragent_help' => 'Příklad: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Zkontrolovat platnost kanálu',
		'website' => 'Adresa URL webové stránky',
		'websub' => 'Okamžité oznámení s WebSub',
	),
	'import_export' => array(
		'export' => 'Exportovat',
		'export_labelled' => 'Exportovat články s vašimi popisky',
		'export_opml' => 'Exportovat seznam kanálů (OPML)',
		'export_starred' => 'Exportovat vaše oblíbené',
		'feed_list' => 'Seznam %s článků',
		'file_to_import' => 'Soubor k importu<br />(OPML, JSON nebo ZIP)',
		'file_to_import_no_zip' => 'Soubor k importu<br />(OPML nebo JSON)',
		'import' => 'Importovat',
		'starred_list' => 'Seznam oblíbených článků',
		'title' => 'Importovat / exportovat',
	),
	'menu' => array(
		'add' => 'Přidat kanál nebo kategorii',
		'import_export' => 'Importovat / exportovat',
		'label_management' => 'Správa popisků',
		'stats' => array(
			'idle' => 'Nečinné kanály',
			'main' => 'Hlavní statistika',
			'repartition' => 'Přerozdělení článků',
		),
		'subscription_management' => 'Správa odběrů',
		'subscription_tools' => 'Nástroje odběrů',
	),
	'tag' => array(
		'auto_label' => 'Add this label to new articles',	// TODO
		'name' => 'Název',
		'new_name' => 'Nový název',
		'old_name' => 'Starý název',
	),
	'title' => array(
		'_' => 'Správa odběrů',
		'add' => 'Přidat kanál nebo kategorii',
		'add_category' => 'Přidat kategorii',
		'add_dynamic_opml' => 'Přidání dynamického OPML',
		'add_feed' => 'Přidat kanál',
		'add_label' => 'Přidat popisek',
		'delete_label' => 'Odstranit popisek',
		'feed_management' => 'Správa kanálů RSS',
		'rename_label' => 'Přejmenovat popisek',
		'subscription_tools' => 'Nástroje odběrů',
	),
);

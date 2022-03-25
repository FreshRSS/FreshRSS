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
		'empty' => 'Vyprázdit kategorii',
		'information' => 'Informace',
		'position' => 'Zobrazit pozici',
		'position_help' => 'Pro ovládání pořadí řazení kategorií',
		'title' => 'Název',
	),
	'feed' => array(
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
		'description' => 'Popis',
		'empty' => 'Tento kanál je prázdný. Ověřte prosím, zda je stále udržován.',
		'error' => 'Vyskytl se problém s kanálem. Ověřte prosím, že je vždy dostupný, pak ho aktualizujte.',
		'filteractions' => array(
			'_' => 'Akce filtrování',
			'help' => 'Zapište jeden filtr hledání na řádek.',
		),
		'information' => 'Informace',
		'keep_min' => 'Minimální počet článků pro ponechání',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>//title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'Example: <code>//div[@class="news-item"]</code>',	// TODO
				),
				'item_author' => array(
					'_' => 'item author',	// TODO
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',	// TODO
				),
				'item_categories' => 'items tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Example to take the full item: <code>.</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>descendant::img/@src</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => array(
					'_' => 'item title',	// TODO
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> like <code>descendant::h2</code>',	// TODO
				),
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>descendant::a/@href</code>',	// TODO
				),
				'relative' => 'XPath (relative to item) for:',	// TODO
				'xpath' => 'XPath for:',	// TODO
			),
			'rss' => 'RSS / Atom (default)',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'Vymazat mezipaměť',
			'clear_cache_help' => 'Vymazat mezipaměť pro tento kanál.',
			'reload_articles' => 'Znovu načíst články',
			'reload_articles_help' => 'Znovu načíst články a získat úplný obsah, pokud je definován přepínač.',
			'title' => 'Údržba',
		),
		'moved_category_deleted' => 'Když odstraníte kategorii, její kanály jsou automaticky přesunuty do <em>%s</em>.',
		'mute' => 'ztlumit',
		'no_selected' => 'Nejsou vybrány žádné kanály.',
		'number_entries' => '%d článků',
		'priority' => array(
			'_' => 'Viditelnost',
			'archived' => 'Nezobrazovat (archivováno)',
			'main_stream' => 'Zobrazit ve hlavním kanálu',
			'normal' => 'Zobrazit v jeho kategorii',
		),
		'proxy' => 'Nastavete proxy pro načítání tohoto kanálu',
		'proxy_help' => 'Vyberte protokol (např.: SOCKS5) a zadejte adresu proxy (např.: <kbd>127.0.0.1:1080</kbd>)',
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
		'name' => 'Název',
		'new_name' => 'Nový název',
		'old_name' => 'Starý název',
	),
	'title' => array(
		'_' => 'Správa odběrů',
		'add' => 'Přidat kanál nebo kategorii',
		'add_category' => 'Přidat kategorii',
		'add_feed' => 'Přidat kanál',
		'add_label' => 'Přidat popisek',
		'delete_label' => 'Odstranit popisek',
		'feed_management' => 'Správa kanálů RSS',
		'rename_label' => 'Přejmenovat popisek',
		'subscription_tools' => 'Nástroje odběrů',
	),
);

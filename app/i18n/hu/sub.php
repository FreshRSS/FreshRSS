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
		'documentation' => 'Másold ki az URL-t hogy külső alkalmazásban használhasd.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Húzd ezt a gombot a könyvjelzőid közé vagy jobb gombbal add hozzá. Ezt a gombot megnyomva az éppen látogatott weblapra lehet feliratkozni a FreshRSS-ben.',
		'label' => 'Feliratkozás',
		'title' => 'Feliratkozás gomb',
	),
	'category' => array(
		'_' => 'Kategória',
		'add' => 'Kategória hozzáadása',
		'archiving' => 'Archiválás',
		'dynamic_opml' => array(
			'_' => 'Dinamikus OPML',
			'help' => 'Adj meg egy URL-t <a href="http://opml.org/" target="_blank">OPML fájl</a> hogy automatikusan kitöltődjön ez a kategória hírforrásokkal',
		),
		'empty' => 'Üres kategória',
		'information' => 'Információ',
		'opml_url' => 'OPML URL',	// IGNORE
		'position' => 'Megjelenítési pozíció',
		'position_help' => 'Kategória rendezési sorrend',
		'title' => 'Cím',
	),
	'feed' => array(
		'accept_cookies' => 'Sütik elfogadása',
		'accept_cookies_help' => 'Engedélyezze hogy a hírforrás szerver beállíthasson sütiket (memóriában lesznek tárolva a kapcsolat idejére)',
		'add' => 'RSS hírforrás hozzáadása',
		'advanced' => 'Haladó',
		'archiving' => 'Archiválás',
		'auth' => array(
			'configuration' => 'Bejelentkezés',
			'help' => 'Lehetővé teszi HTTP védelemmel ellátott RSS hírforrások hozzáférését',
			'http' => 'HTTP Hitelesítés',
			'password' => 'HTTP jelszó',
			'username' => 'HTTP felhasználónév',
		),
		'clear_cache' => 'Mindig törölje a cache-t',
		'content_action' => array(
			'_' => 'Tartalom művelet amikor cikk tartalma beszerzésre kerül',
			'append' => 'Hozzáadás a létező tartalom után',
			'prepend' => 'Hozzáadás a létező tartalom elé',
			'replace' => 'Cserélje ki a létező tartalmat',
		),
		'css_cookie' => 'Használjon sütiket a cikkek letöltésénél',
		'css_cookie_help' => 'Példa: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Csonkított RSS hírforrások beszerzése (vigyázz, több időt igényel!)',
		'css_path' => 'Cikk CSS selector az eredeti weblapon',
		'css_path_filter' => array(
			'_' => 'A törlendő elemek CSS selectora',
			'help' => 'Egy CSS selector lehet egy lista például: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Leírás',
		'empty' => 'Ez a hírforrás üres. Ellenőrizd hogy van e tartalom rajta.',
		'error' => 'Ez a hírforrás nem működik. Ellenőrizd az elérhetőségét és frissítsd.',
		'filteractions' => array(
			'_' => 'Szűrő műveletek',
			'help' => 'Írj egy szűrőt soronként. Műveletek <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">a dokumentációban</a>.',
		),
		'information' => 'Információ',
		'keep_min' => 'Megtartandó cikkek minimális száma',
		'kind' => array(
			'_' => 'Hírforrás típusa',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'hírforrás címe',
					'help' => 'Példa: <code>//title</code> vagy statikus szöveg: <code>"Az egyedi hírforrásom"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> egy szabványos lekérdezési nyelv haladó felhasználóknak, amit a FreshRSS támogat (Web scraping).',
				'item' => array(
					'_' => 'hírek keresése <strong>elemek</strong><br /><small>(legfontosabb)</small>',
					'help' => 'Példa: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'elem szerzője',
					'help' => 'Lehet statikus sztring is. Példa: <code>"Anonymous"</code>',
				),
				'item_categories' => 'elem címkék',
				'item_content' => array(
					'_' => 'elem tartalom',
					'help' => 'Példa a teljes elem eléréséhez: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'elem előnézeti kép',
					'help' => 'Példa: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Egyedi dátum/idő formátum',
					'help' => 'Opcionális. PHP által támogatott formátum <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> például <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'elem dátum',
					'help' => 'Az eredményt elemzi a <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'elem cím',
					'help' => 'Használja az <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> mint <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'elem egyedi ID',
					'help' => 'Opcionális. Példa: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'elem link (URL)',
					'help' => 'Példa: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (az elemhez viszonyítva) ehhez:',
				'xpath' => 'XPath ehhez:',
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
			'rss' => 'RSS / Atom (alapértelmezett)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Gyorsítótár törlése',
			'clear_cache_help' => 'Gyorsítótár törlése ehhez a hírforráshoz.',
			'reload_articles' => 'Cikkek újratöltése',
			'reload_articles_help' => 'Újratölt ennyi cikket és teljes tartalmát ha a selector meg van határozva.',
			'title' => 'Karbantartás',
		),
		'max_http_redir' => 'Max HTTP átirányítás',
		'max_http_redir_help' => '0 vagy üresen hagyva kikapcsolt, -1 a végtelen átirányításhoz',
		'method' => array(
			'_' => 'HTTP Method',	// TODO
		),
		'method_help' => 'The POST payload has automatic support for <code>application/x-www-form-urlencoded</code> and <code>application/json</code>',	// TODO
		'method_postparams' => 'Payload for POST',	// TODO
		'moved_category_deleted' => 'Ha kitörölsz egy kategóriát, az alá tartozó hírforrások automatikusan ide kerülnek <em>%s</em>.',
		'mute' => 'némítás',
		'no_selected' => 'Nincsen hírforrás kiválasztva.',
		'number_entries' => '%d cikkek',
		'priority' => array(
			'_' => 'Láthatóság',
			'archived' => 'Ne jelenjen meg (archivált)',
			'category' => 'Jelenjen meg a saját kategóriájában',
			'important' => 'Megjelenítés a fontos hírforrásokban',
			'main_stream' => 'Megjelenítés a Minden cikk között',
		),
		'proxy' => 'Állíts be egy proxy-t a hírforráshoz ',
		'proxy_help' => 'Válassz egy protokollt (pl.: SOCKS5) és add meg a proxy címét (pl.: <kbd>127.0.0.1:1080</kbd> vagy <kbd>felhasználónév:jelszó@127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Forráskód mutatása',
			'show_rendered' => 'Tartalom mutatása',
		),
		'show' => array(
			'all' => 'Minden hírforrás megjelenítése',
			'error' => 'Csak a hibás hírforrások megjelenítése',
		),
		'showing' => array(
			'error' => 'Csak a hibás hírforrások megjelenítése',
		),
		'ssl_verify' => 'SSL biztonság ellenőrzése',
		'stats' => 'Statisztika',
		'think_to_add' => 'Hozzáadhatsz néhány hírforrást.',
		'timeout' => 'Időtúllépés ideje másodpercekben',
		'title' => 'Cím',
		'title_add' => 'RSS hírforrás hozzáadása',
		'ttl' => 'Ne frissítsd automatikusan többször mint',
		'url' => 'Hírforrás URL',
		'useragent' => 'Állíts be egy user agent-et ehhez a hírforráshoz',
		'useragent_help' => 'Példa: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Hírforrás helyességének ellenőrzése',
		'website' => 'Weboldal URL',
		'websub' => 'Azonnali értesítés WebSub-al',
	),
	'import_export' => array(
		'export' => 'Exportálás',
		'export_labelled' => 'Címkézett cikkek exportálása',
		'export_opml' => 'Hírforrások listájának exportálása (OPML)',
		'export_starred' => 'Kedvencek exportálása',
		'feed_list' => 'Cikkek %s listája',
		'file_to_import' => 'Állomány importálása<br />(OPML, JSON vagy ZIP)',
		'file_to_import_no_zip' => 'Állomány importálása<br />(OPML vagy JSON)',
		'import' => 'Importálás',
		'starred_list' => 'Kedvenc cikkek listája',
		'title' => 'Importálás / exportálás',
	),
	'menu' => array(
		'add' => 'Hírforrás vagy kategória hozzáadása',
		'import_export' => 'Importálás / exportálás',
		'label_management' => 'Címkék kezelése',
		'stats' => array(
			'idle' => 'Tétlen hírforrások',
			'main' => 'Fő statisztika',
			'repartition' => 'Cikkek eloszlása',
		),
		'subscription_management' => 'Hírforrások kezelése',
		'subscription_tools' => 'Hírforrás eszközök',
	),
	'tag' => array(
		'auto_label' => 'Add this label to new articles',	// TODO
		'name' => 'Név',
		'new_name' => 'Új név',
		'old_name' => 'Régi név',
	),
	'title' => array(
		'_' => 'Hírforrások kezelése',
		'add' => 'Hírforrás vagy kategória hozzáadása',
		'add_category' => 'Kategória hozzáadása',
		'add_dynamic_opml' => 'Dinamikus OPML hozzáadása',
		'add_feed' => 'Hírforrás hozzáadása',
		'add_label' => 'Címke hozzáadása',
		'delete_label' => 'Címke törlése',
		'feed_management' => 'RSS hírforrások kezelése',
		'rename_label' => 'Címke átnevezése',
		'subscription_tools' => 'Feliratkozási eszközök',
	),
);

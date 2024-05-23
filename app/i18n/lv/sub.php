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
		'documentation' => 'Lai to izmantotu ārējā rīkā, nokopējiet šo URL adresi.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Velciet šo pogu uz grāmatzīmju rīkjoslu vai noklikšķiniet uz tās ar peles labo pogu un izvēlieties "Atzīmēt šo saiti". Pēc tam noklikšķiniet uz pogas "Abonēt" jebkurā lapā, kuru vēlaties abonēt.',
		'label' => 'Abonēt',
		'title' => 'Grāmatzīmes lietotne',
	),
	'category' => array(
		'_' => 'Kategorija',
		'add' => 'Pievienot kategoriju',
		'archiving' => 'Arhivēšana',
		'dynamic_opml' => array(
			'_' => 'Dinamisks OPML',
			'help' => 'Norādiet URL uz <a href="http://opml.org/" target="_blank">OPML failu</a>, lai dinamiski papildinātu šo kategoriju ar barotnēm.',
		),
		'empty' => 'Tukša kategorija',
		'information' => 'Informācija',
		'opml_url' => 'OPML URL',	// IGNORE
		'position' => 'Displeja pozīcija',
		'position_help' => 'Lai pārvaldītu kategoriju šķirošanas secību',
		'title' => 'Tituls',
	),
	'feed' => array(
		'accept_cookies' => 'Pieņemt sīkfailus',
		'accept_cookies_help' => 'Atļaut barotnes serverim iestatīt sīkfailus (atmiņā tiek saglabāti tikai uz pieprasījuma laiku).',
		'add' => 'Pievienot RSS barotni',
		'advanced' => 'Advancēts',
		'archiving' => 'Arhivēšana',
		'auth' => array(
			'configuration' => 'Pieteikšanās',
			'help' => 'Atļauj piekļuvi HTTP aizsargātām RSS barotnēm',
			'http' => 'HTTP Autentifikācija',
			'password' => 'HTTP parole',
			'username' => 'HTTP lietotājvārds',
		),
		'clear_cache' => 'Vienmēr iztīrīt kešatmiņu',
		'content_action' => array(
			'_' => 'Satura darbība, kad tiek iegūts raksta saturs',
			'append' => 'Pievienot pēc esošā satura',
			'prepend' => 'Pievienot pirms esošā satura',
			'replace' => 'Aizstāt esošo saturu',
		),
		'css_cookie' => 'Lietot sīkfailus, kad tiek iegūts raksta saturs',
		'css_cookie_help' => 'Piemērs: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Iegūst saīsinātas RSS plūsmas (uzmanību, prasa vairāk laika!)',
		'css_path' => 'Raksta CSS selektors sākotnējā vietnē',
		'css_path_filter' => array(
			'_' => 'Noņemamo elementu CSS selektors',
			'help' => 'CSS selektors var būt saraksts, piemēram.: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Apraksts',
		'empty' => 'Šī barotne ir tukša. Lūdzu, pārbaudiet, vai tā joprojām tiek uzturēta.',
		'error' => 'Šajā barotnē ir radusies problēma. Lūdzu, pārbaudiet, vai tā vienmēr ir sasniedzama, un pēc tam to atjauniniet.',
		'export-as-opml' => array(
			'download' => 'Download',	// TODO
			'help' => 'XML file (data subset. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">See documentation</a>)',	// TODO
			'label' => 'Export as OPML',	// TODO
		),
		'filteractions' => array(
			'_' => 'Filtra darbības',
			'help' => 'Uzrakstiet vienu meklēšanas filtru katrā rindā. Operators <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">see documentation</a>.',	// DIRTY
		),
		'information' => 'Informācija',
		'keep_min' => 'Minimālais saglabājamo izstrādājumu skaits',
		'kind' => array(
			'_' => 'Barotnes avota veids',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Tīmekļa nolasīšana)',
				'feed_title' => array(
					'_' => 'barotnes tituls',
					'help' => 'Piemērs: <code>//title</code> vai statisku tekstu: <code>"Mana pielāgotā barotne"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> ir standarta vaicājumu valoda pieredzējušiem lietotājiem, ko FreshRSS atbalsta, lai nodrošinātu tīmekļa nolasīšanu.',
				'item' => array(
					'_' => '<strong>jaunumu</strong> meklēšana<br /><small>(vissvarīgākais)</small>',
					'help' => 'Piemērs: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'raksta autors',
					'help' => 'Var arī būt teksts. Piemērs: <code>"Anonīms"</code>',
				),
				'item_categories' => 'item tags',	// TODO
				'item_content' => array(
					'_' => 'raksta saturs',
					'help' => 'Piemērs, lai ņemtu pilnu rakstu: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'raksta sīktēls',
					'help' => 'Example: <code>descendant::img/@src</code>',	// TODO
				),
				'item_timeFormat' => array(
					'_' => 'Pielāgotais datuma/laika formāts',
					'help' => 'Pēc izvēles. <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> atbalstīts formāts, piemēram, <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'raksta datums',
					'help' => 'Rezultāts tiks analizēts ar <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'raksta tituls',
					'help' => 'Īpaši izmantojiet <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code>, piemēram, <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'raksta unikālais ID',
					'help' => 'Pēc izvēles. Piemēram: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'raksta links (URL)',
					'help' => 'Piemērs: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (relatīvs rakstam) priekš:',
				'xpath' => 'XPath priekš:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (dot notation)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>meta.title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => 'A JSON dot notated uses dots between objects and brackets for arrays (e.g. <code>data.items[0].title</code>)',	// TODO
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
				'json' => 'dot notation for:',	// TODO
				'relative' => 'dot notated path (relative to item) for:',	// TODO
			),
			'jsonfeed' => 'JSON Feed',	// TODO
			'rss' => 'RSS / Atom (noklusējums)',
			'xml_xpath' => 'XML + XPath',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'Iztīrīt kešatmiņu',
			'clear_cache_help' => 'Iztīrīt kešatmiņu priekš šīs barotnes.',
			'reload_articles' => 'Pārlādēt rakstus',
			'reload_articles_help' => 'Pārlādēt tik daudzus rakstus un iegūt pilnu saturu, ja ir definēts selektors.',
			'title' => 'Uzturēšana',
		),
		'max_http_redir' => 'Maksimālais HTTP novirzījumu skaits',
		'max_http_redir_help' => 'Iestatiet 0 vai atstājiet tukšu, lai atspējotu, -1 neierobežotai novirzīšanai',
		'method' => array(
			'_' => 'HTTP Method',	// TODO
		),
		'method_help' => 'The POST payload has automatic support for <code>application/x-www-form-urlencoded</code> and <code>application/json</code>',	// TODO
		'method_postparams' => 'Payload for POST',	// TODO
		'moved_category_deleted' => 'Kad dzēšat kategoriju, tās plūsmas automātiski tiek automātiski klasificētas kategorijā <em>%s</em>.',
		'mute' => 'klusināt',
		'no_selected' => 'Barotne nav izvēlēta.',
		'number_entries' => '%d raksti',
		'priority' => array(
			'_' => 'Prioritāte',
			'archived' => 'Nerādīt (arhivēts)',
			'category' => 'Rādīt kategorijā',
			'important' => 'Show in important feeds',	// TODO
			'main_stream' => 'Rādīt galvenajā plūsmā',
		),
		'proxy' => 'Iestatīt starpniekserveri šīs plūsmas iegūšanai',
		'proxy_help' => 'Izvēlieties protokolu (piemēram, SOCKS5) un ievadiet starpniekservera adresi (piemēram, <kbd>127.0.0.0.1:1080</kbd>).',
		'selector_preview' => array(
			'show_raw' => 'Rādīt avota kodu',
			'show_rendered' => 'Rādīt saturu',
		),
		'show' => array(
			'all' => 'Rādīt visas barotnes',
			'error' => 'Tikai rādīt barotnes ar kļūdām',
		),
		'showing' => array(
			'error' => 'Rāda tikai barotnes ar kļūdām',
		),
		'ssl_verify' => 'Pārbaudīt SSL drošību',
		'stats' => 'Statistika',
		'think_to_add' => 'Jūs varat pievienot dažas barotnes.',
		'timeout' => 'Laika limits sekundēs',
		'title' => 'Tituls',
		'title_add' => 'Pievienot RSS barotni',
		'ttl' => 'Automātiski neatjaunināt biežāk par',
		'url' => 'Barotnes URL',
		'useragent' => 'Lietotāja aģenta iestatīšana šīs barotnes iegūšanai',
		'useragent_help' => 'Piemērs: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Pārbaudēt barotnes derīgumu',
		'website' => 'Mājaslapas URL',
		'websub' => 'Tūlītēji paziņojumi ar WebSub',
	),
	'import_export' => array(
		'export' => 'Eksportēt',
		'export_labelled' => 'Eksportēt ar birku marķētus rakstus',
		'export_opml' => 'Eksportēt barotņu sarakstu (OPML)',
		'export_starred' => 'Eksportēt mīļākos',
		'feed_list' => '%s rakstu saraksts',
		'file_to_import' => 'Fails, ko eksportēt<br />(OPML, JSON vai ZIP)',
		'file_to_import_no_zip' => 'Fails, ko eksportēt<br />(OPML vai JSON)',
		'import' => 'Importēt',
		'starred_list' => 'Mīļāko rakstu saraksts',
		'title' => 'Importēt / Eksportēt',
	),
	'menu' => array(
		'add' => 'Pievienot barotni, vai kategoriju',
		'import_export' => 'Importēt / Eksportēt',
		'label_management' => 'Birku pārvaldība',
		'stats' => array(
			'idle' => 'Neaktīvās barotnes',
			'main' => 'Galvenās statistikas',
			'repartition' => 'Rakstu pārdalīšana',
		),
		'subscription_management' => 'Abonementu pārvalde',
		'subscription_tools' => 'Abonamentu rīki',
	),
	'tag' => array(
		'auto_label' => 'Add this label to new articles',	// TODO
		'name' => 'Vārds',
		'new_name' => 'Jaunais vārds',
		'old_name' => 'Vecais vārds',
	),
	'title' => array(
		'_' => 'Abonementu pārvalde',
		'add' => 'Pievienot barotni, vai kategoriju',
		'add_category' => 'Pievienot kategoriju',
		'add_dynamic_opml' => 'Pievienot dinamisku OPML',
		'add_feed' => 'Pievienot barotni',
		'add_label' => 'Pievienot birku',
		'delete_label' => 'Noņemt birku',
		'feed_management' => 'RSS barotņu pārvalde',
		'rename_label' => 'Birkas vārda maiņa',
		'subscription_tools' => 'Abonamentu rīki',
	),
);

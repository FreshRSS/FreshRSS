<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

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
		'error' => 'Šai dinamiskajai OPML kategorijai radās problēma. Pārbaudiet, vai OPML URL joprojām ir sasniedzams un vai nav pārsniegts maksimālais barotņu skaits vienam lietotājam.',
		'expand' => 'Izvērst kategoriju',
		'information' => 'Informācija',
		'open' => 'Atvērt kategoriju',
		'opml_url' => 'OPML URL',	// IGNORE
		'position' => 'Displeja pozīcija',
		'position_help' => 'Lai pārvaldītu kategoriju šķirošanas secību',
		'title' => 'Tituls',
	),
	'feed' => array(
		'accept_cookies' => 'Pieņemt sīkfailus',
		'accept_cookies_help' => 'Atļaut barotnes serverim iestatīt sīkfailus (atmiņā tiek saglabāti tikai uz pieprasījuma laiku).',
		'add' => 'Pievienot barotni',
		'advanced' => 'Advancēts',
		'archiving' => 'Arhivēšana',
		'auth' => array(
			'configuration' => 'Pieteikšanās',
			'help' => 'Atļauj piekļuvi HTTP aizsargātām RSS barotnēm',
			'http' => 'HTTP Autentifikācija',
			'password' => 'HTTP parole',
			'username' => 'HTTP lietotājvārds',
		),
		'change_favicon' => 'Mainīt…',
		'clear_cache' => 'Vienmēr iztīrīt kešatmiņu',
		'content_action' => array(
			'_' => 'Satura darbība, kad tiek iegūts raksta saturs',
			'append' => 'Pievienot pēc esošā satura',
			'prepend' => 'Pievienot pirms esošā satura',
			'replace' => 'Aizstāt esošo saturu',
		),
		'content_retrieval' => 'Satura izgūšana',
		'css_cookie' => 'Lietot sīkfailus, kad tiek iegūts raksta saturs',
		'css_cookie_help' => 'Piemērs: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Iegūst saīsinātas RSS plūsmas (uzmanību, prasa vairāk laika!)',
		'css_path' => 'Raksta CSS selektors sākotnējā vietnē',
		'css_path_filter' => array(
			'_' => 'Noņemamo elementu CSS selektors',
			'help' => 'CSS selektors var būt saraksts, piemēram.: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'Apraksts',
		'empty' => 'Šī barotne ir tukša. Lūdzu, pārbaudiet, vai tā joprojām tiek uzturēta.',
		'error' => 'Šajā barotnē ir radusies problēma. Pārbaudiet, vai tā joprojām ir sasniedzama.',
		'export-as-opml' => array(
			'download' => 'Lejupielādēt',
			'help' => 'XML fails (datu apakškopa. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">Skatīt dokumentāciju</a>)',
			'label' => 'Eksportēt kā OPML',
		),
		'ext_favicon' => 'Iestatīt automātiski',
		'favicon_changed_by_ext' => 'Ikonu ir iestatījis <b>%s</b> paplašinājums.',
		'filteractions' => array(
			'_' => 'Filtra darbības',
			'help' => 'Rakstiet vienu meklēšanas filtru katrā rindā. Operatorus skatiet <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">dokumentācijā</a>.',
			'view_filter' => 'Priekšskatīt filtrus esošajos rakstos (jauns logs)',
		),
		'http_headers' => 'HTTP galvenes',
		'http_headers_help' => 'Galvenes ir atdalītas ar jaunu rindu, un galvenes nosaukums un vērtība ir atdalīti ar kolu (piemēram: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',
		'icon' => 'Ikona',
		'information' => 'Informācija',
		'keep_adding_feed' => 'Pēc tam pievienojiet vēl barotnes',
		'keep_min' => 'Minimālais saglabājamo izstrādājumu skaits',
		'kind' => array(
			'_' => 'Barotnes avota veids',
			'html_json' => array(
				'_' => 'HTML + XPath + JSON punktu notācija (JSON HTML dokumentā)',
				'xpath' => array(
					'_' => 'XPath JSON izgūšanai no HTML',
					'help' => 'Piemērs: <code>normalize-space(//script[@type="application/json"])</code> (viens JSON)<br />vai: <code>//script[@type="application/ld+json"]</code> (viens JSON objekts katram rakstam)',
				),
			),
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
				'item_categories' => 'vienuma tagi',
				'item_content' => array(
					'_' => 'raksta saturs',
					'help' => 'Piemērs, lai ņemtu pilnu rakstu: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'raksta sīktēls',
					'help' => 'Piemērs: <code>descendant::img/@src</code>',
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
				'_' => 'JSON (punktu notācija)',
				'feed_title' => array(
					'_' => 'barotnes tituls',
					'help' => 'Piemērs: <code>meta.title</code> vai statiska virkne: <code>"Mana pielāgotā plūsma"</code>',
				),
				'help' => 'JSON punktu notācija izmanto punktus starp objektiem un iekavas masīviem. (piemēram, <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'jaunumu atrašana <strong>vienumi</strong><br /><small>(visbūtiskākais)</small>',
					'help' => 'JSON ceļš uz masīvu, kas satur vienumus, piemēram, <code>$</code> vai <code>newsItems</code>',
				),
				'item_author' => 'vienuma autors',
				'item_categories' => 'vienuma atslēgasvārdi',
				'item_content' => array(
					'_' => 'vienuma saturs',
					'help' => 'Atslēga, zem kuras atrodas saturs, piemēram, <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'vienuma sīktēls',
					'help' => 'Piemērs: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Pielāgotais datuma/laika formāts',
					'help' => 'Pēc izvēles. Formāts, ko atbalsta <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> piemēram, <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'vienuma datums',
					'help' => 'Rezultātu parsēs <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'vienuma tituls',
				'item_uid' => 'vienuma unikālais ID',
				'item_uri' => array(
					'_' => 'vienuma saite (URL)',
					'help' => 'Piemērs: <code>pastāvīga saite</code>',
				),
				'json' => 'punktu notācija priekš:',
				'relative' => 'punktu notācijas ceļš (relatīvs pret vienumu) priekš:',
			),
			'jsonfeed' => 'JSON Barotne',
			'rss' => 'RSS / Atom (noklusējums)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'last-entry-publication-date' => 'Pēdējais publicētais raksts <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-entry-received-date' => 'Pēdējais saņemtais raksts <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-error-date' => 'Pēdējais kļūdainais atjauninājums <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-update' => 'Pēdējais veiksmīgais atjauninājums <time datetime="%1$s" title="%1$s">%2$s</time>.',
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
			'_' => 'HTTP Metode',
		),
		'method_help' => 'POST dati automātiski atbalsta <code>application/x-www-form-urlencoded</code> un <code>application/json</code>',
		'method_postparams' => 'Nosūtīšanas dati POST metodei',
		'moved_category_deleted' => 'Kad dzēšat kategoriju, tās plūsmas automātiski tiek automātiski klasificētas kategorijā <em>%s</em>.',
		'mute' => array(
			'_' => 'klusināt',
			'state_is_muted' => 'Šī barotne ir apklusināta',
		),
		'no_selected' => 'Barotne nav izvēlēta.',
		'number_entries' => '%d raksti',
		'open_feed' => 'Atvērt barotni %s',
		'path_entries_conditions' => 'Nosacījumi satura izgūšanai',
		'priority' => array(
			'_' => 'Prioritāte',
			'category' => 'Rādīt kategorijā',
			'feed' => 'Rādīt savā barotnē',
			'hidden' => 'Nerādīt',
			'important' => 'Rādīt svarīgajās barotnēs',
			'main_stream' => 'Rādīt galvenajā plūsmā',
		),
		'proxy' => 'Iestatīt starpniekserveri šīs plūsmas iegūšanai',
		'proxy_help' => 'Izvēlieties protokolu (piemēram, SOCKS5) un ievadiet starpniekservera adresi (piemēram, <kbd>127.0.0.1:1080</kbd> vai <kbd>username:password@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'Atiestatīt uz noklusējumu',
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
		'unicityCriteria' => array(
			'_' => 'Rakstu unikalitātes kritēriji',
			'forced' => '<span title="Bloķēt unikalitātes kritērijus, pat tad, ja barotnē ir rakstu dublikāti">piespiests</span>',
			'help' => 'Attiecas uz nederīgām barotnēm.<br />⚠️ Politikas maiņa radīs dublikātus.',
			'id' => 'Standarta ID (noklusējums)',
			'link' => 'Saite',
			'sha1:content' => 'Saturs',
			'sha1:content_published' => 'Saturs + Datums',
			'sha1:link_published' => 'Saite + Datums',
			'sha1:link_published_title' => 'Saite + Datums + Virsraksts',
			'sha1:link_published_title_content' => 'Saite + Datums + Virsraksts + Saturs',
			'sha1:published' => 'Datums',
			'sha1:title' => 'Virsraksts',
			'sha1:title_published' => 'Virsraksts + Datums',
			'sha1:title_published_content' => 'Virsraksts + Datums + Saturs',
		),
		'url' => 'Barotnes URL',
		'useragent' => 'Lietotāja aģenta iestatīšana šīs barotnes iegūšanai',
		'useragent_help' => 'Piemērs: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Pārbaudēt barotnes derīgumu',
		'website' => 'Mājaslapas URL',
		'websub' => 'Tūlītēji paziņojumi ar WebSub',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'Eksportēt',
			'sqlite' => 'Lejupielādēt lietotāju datubāzi kā SQLite',
		),
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
			'unread_dates' => 'Nelasītie datumi',
		),
		'subscription_management' => 'Abonementu pārvalde',
		'subscription_tools' => 'Abonamentu rīki',
	),
	'tag' => array(
		'auto_label' => 'Pievienot šo etiķeti jaunajiem rakstiem',
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
		'add_opml_category' => 'OPML kategorijas nosaukums',
		'delete_label' => 'Noņemt birku',
		'feed_management' => 'RSS barotņu pārvalde',
		'subscription_tools' => 'Abonamentu rīki',
	),
);

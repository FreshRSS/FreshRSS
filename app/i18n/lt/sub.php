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
		'documentation' => 'Nukopijuokite šį URL, kad naudotumėte jį išorinėje priemonėje.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Nutempkite šį mygtuką į adresyno juostą arba spustelėkite jį dešiniuoju pelės klavišu ir pasirinkite „Įtraukti nuorodą į adresyną“. Tada bet kuriame puslapyje, kurį norite prenumeruoti, spustelėkite mygtuką „Prenumeruoti“.',
		'label' => 'Prenumeruoti',
		'title' => 'Adresyno mygtukas (bookmarklet)',
	),
	'category' => array(
		'_' => 'Kategorija',
		'add' => 'Pridėti kategoriją',
		'archiving' => 'Archyvavimas',
		'dynamic_opml' => array(
			'_' => 'Dinaminis OPML',
			'help' => 'Nurodykite <a href="http://opml.org/" target="_blank">OPML failo</a> URL, kad ši kategorija būtų dinamiškai užpildyta kanalais',
		),
		'empty' => 'Ištuštinti kategoriją',
		'error' => 'Su šia dinaminio OPML kategorija iškilo problema. Patikrinkite, ar OPML URL vis dar pasiekiamas ir ar neviršytas didžiausias kanalų skaičius vienam naudotojui.',
		'expand' => 'Išskleisti kategoriją',
		'information' => 'Informacija',
		'open' => 'Atverti kategoriją',
		'opml_url' => 'OPML URL',	// IGNORE
		'position' => 'Rodymo padėtis',
		'position_help' => 'Kategorijų rikiavimo tvarkai valdyti',
		'title' => 'Pavadinimas',
	),
	'feed' => array(
		'accept_cookies' => 'Priimti slapukus',
		'accept_cookies_help' => 'Leisti kanalo serveriui nustatyti slapukus (saugomi atmintyje tik užklausos trukmei)',
		'add' => 'Pridėti kanalą',
		'advanced' => 'Išplėstiniai',
		'archiving' => 'Archyvavimas',
		'auth' => array(
			'configuration' => 'Prisijungimas',
			'help' => 'Leidžia pasiekti HTTP apsaugotus RSS kanalus',
			'http' => 'HTTP tapatybės nustatymas',
			'password' => 'HTTP slaptažodis',
			'username' => 'HTTP naudotojo vardas',
		),
		'change_favicon' => 'Keisti…',
		'clear_cache' => 'Visada išvalyti podėlį',
		'content_action' => array(
			'_' => 'Turinio veiksmas, gaunant straipsnio turinį',
			'append' => 'Pridėti po esamo turinio',
			'prepend' => 'Pridėti prieš esamą turinį',
			'replace' => 'Pakeisti esamą turinį',
		),
		'content_retrieval' => 'Turinio gavimas',
		'css_cookie' => 'Naudoti slapukus, gaunant straipsnio turinį',
		'css_cookie_help' => 'Pavyzdys: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Gauna sutrumpintus RSS kanalus (dėmesio, reikia daugiau laiko!)',
		'css_path' => 'Straipsnio CSS selektorius originalioje svetainėje',
		'css_path_filter' => array(
			'_' => 'Pašalintinų elementų CSS selektorius',
			'help' => 'CSS selektorius gali būti sąrašas, pvz.: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'Aprašymas',
		'empty' => 'Šis kanalas tuščias. Patikrinkite, ar jis vis dar prižiūrimas.',
		'error' => 'Su šiuo kanalu iškilo problema. Jei tai kartojasi, patikrinkite, ar jis vis dar pasiekiamas.',
		'export-as-opml' => array(
			'download' => 'Atsisiųsti',
			'help' => 'XML failas (duomenų poaibis. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">Žr. dokumentaciją</a>)',
			'label' => 'Eksportuoti kaip OPML',
		),
		'ext_favicon' => 'Nustatyti automatiškai',
		'favicon_changed_by_ext' => 'Piktogramą nustatė plėtinys <b>%s</b>.',
		'filteractions' => array(
			'_' => 'Filtravimo veiksmai',
			'help' => 'Rašykite po vieną paieškos filtrą eilutėje. Operatoriai – <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">žr. dokumentaciją</a>.',
			'view_filter' => 'Peržiūrėti filtrus esamiems straipsniams (naujas langas)',
		),
		'global_hint' => 'Naudokite <a href="%s">bendrą vaizdą</a>, kad matytumėte, kiek kiekvieno kanalo straipsnių atitinka būseną ar paieškos išraišką',
		'http_headers' => 'HTTP antraštės',
		'http_headers_help' => 'Antraštės atskiriamos nauja eilute, o antraštės pavadinimas ir reikšmė – dvitaškiu (pvz.: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',
		'icon' => 'Piktograma',
		'information' => 'Informacija',
		'keep_adding_feed' => 'Tada pridėti daugiau kanalų',
		'keep_min' => 'Mažiausias saugotinų straipsnių skaičius',
		'kind' => array(
			'_' => 'Kanalo šaltinio tipas',
			'html_json' => array(
				'_' => 'HTML + XPath + JSON taškinė notacija (JSON HTML viduje)',
				'xpath' => array(
					'_' => 'XPath, skirtas JSON HTML viduje',
					'help' => 'Pavyzdys: <code>normalize-space(//script[@type="application/json"])</code> (vienas JSON)<br />arba: <code>//script[@type="application/ld+json"]</code> (po vieną JSON objektą kiekvienam straipsniui)',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (žiniatinklio duomenų rinkimas)',
				'feed_title' => array(
					'_' => 'kanalo pavadinimas',
					'help' => 'Pavyzdys: <code>//title</code> arba statinė eilutė: <code>"Mano kanalas"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> – tai standartinė užklausų kalba pažengusiems naudotojams, kurią FreshRSS palaiko žiniatinklio duomenų rinkimui (Web scraping).',
				'item' => array(
					'_' => 'naujienų <strong>elementų</strong> radimas<br /><small>(svarbiausia)</small>',
					'help' => 'Pavyzdys: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'elemento autorius',
					'help' => 'Taip pat gali būti statinė eilutė. Pavyzdys: <code>"Anonimas"</code>',
				),
				'item_categories' => 'elemento žymos',
				'item_content' => array(
					'_' => 'elemento turinys',
					'help' => 'Pavyzdys, kaip paimti visą elementą: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'elemento miniatiūra',
					'help' => 'Pavyzdys: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Pasirinktinis datos / laiko formatas',
					'help' => 'Neprivaloma. Formatas, palaikomas <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, pvz. <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'elemento data',
					'help' => 'Rezultatą apdoros <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'elemento pavadinimas',
					'help' => 'Ypač naudokite <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath ašį</a> <code>descendant::</code>, pvz. <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'unikalus elemento ID',
					'help' => 'Neprivaloma. Pavyzdys: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'elemento nuoroda (URL)',
					'help' => 'Pavyzdys: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (santykinis elementui), skirtas:',
				'xpath' => 'XPath, skirtas:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (taškinė notacija)',
				'feed_title' => array(
					'_' => 'kanalo pavadinimas',
					'help' => 'Pavyzdys: <code>meta.title</code> arba statinė eilutė: <code>"Mano kanalas"</code>',
				),
				'help' => 'JSON taškinė notacija naudoja taškus tarp objektų ir laužtinius skliaustus masyvams (pvz. <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'naujienų <strong>elementų</strong> radimas<br /><small>(svarbiausia)</small>',
					'help' => 'JSON kelias iki masyvo su elementais, pvz. <code>$</code> arba <code>newsItems</code>',
				),
				'item_author' => 'elemento autorius',
				'item_categories' => 'elemento žymos',
				'item_content' => array(
					'_' => 'elemento turinys',
					'help' => 'Raktas, po kuriuo randamas turinys, pvz. <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'elemento miniatiūra',
					'help' => 'Pavyzdys: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Pasirinktinis datos / laiko formatas',
					'help' => 'Neprivaloma. Formatas, palaikomas <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, pvz. <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'elemento data',
					'help' => 'Rezultatą apdoros <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'elemento pavadinimas',
				'item_uid' => 'unikalus elemento ID',
				'item_uri' => array(
					'_' => 'elemento nuoroda (URL)',
					'help' => 'Pavyzdys: <code>permalink</code>',
				),
				'json' => 'taškinė notacija, skirta:',
				'relative' => 'taškinės notacijos kelias (santykinis elementui), skirtas:',
			),
			'jsonfeed' => 'JSON Feed',	// IGNORE
			'rss' => 'RSS / Atom (numatytasis)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'last-entry-publication-date' => 'Paskutinis straipsnis paskelbtas <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-entry-received-date' => 'Paskutinis straipsnis gautas <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-error-date' => 'Paskutinis klaidingas atnaujinimas <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-update' => 'Paskutinis sėkmingas atnaujinimas <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'maintenance' => array(
			'clear_cache' => 'Išvalyti podėlį',
			'clear_cache_help' => 'Išvalyti šio kanalo podėlį.',
			'reload_articles' => 'Įkelti straipsnius iš naujo',
			'reload_articles_help' => 'Įkelti iš naujo tiek straipsnių ir gauti visą turinį, jei nurodytas selektorius.',
			'title' => 'Priežiūra',
		),
		'max_http_redir' => 'Didžiausias HTTP peradresavimų skaičius',
		'max_http_redir_help' => 'Nustatykite 0 arba palikite tuščią, kad išjungtumėte, -1 – neribotam peradresavimų skaičiui',
		'method' => array(
			'_' => 'HTTP metodas',
		),
		'method_help' => 'POST siunta automatiškai palaiko <code>application/x-www-form-urlencoded</code> ir <code>application/json</code>',
		'method_postparams' => 'POST siunta',
		'moved_category_deleted' => 'Kai pašalinate kategoriją, jos kanalai automatiškai priskiriami kategorijai <em>%s</em>.',
		'mute' => array(
			'_' => 'nutildyti',
			'state_is_muted' => 'Šis kanalas nutildytas',
		),
		'no_selected' => 'Nepasirinktas nė vienas kanalas.',
		'number_entries' => '%d straipsnių',
		'open_feed' => 'Atverti kanalą %s',
		'path_entries_conditions' => 'Turinio gavimo sąlygos',
		'proxy' => 'Nustatyti tarpinį serverį (proxy) šiam kanalui gauti',
		'proxy_help' => 'Pasirinkite protokolą (pvz.: SOCKS5) ir įveskite tarpinio serverio adresą (pvz.: <kbd>127.0.0.1:1080</kbd> arba <kbd>username:password@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'Atkurti numatytąją',
		'selector_preview' => array(
			'show_raw' => 'Rodyti pirminį kodą',
			'show_rendered' => 'Rodyti turinį',
		),
		'show' => array(
			'all' => 'Visi kanalai',
			'error' => 'Rodyti tik kanalus su klaidomis',
		),
		'showing' => array(
			'error' => 'Rodomi tik kanalai su klaidomis',
		),
		'ssl_verify' => 'Tikrinti SSL saugumą',
		'stats' => 'Statistika',
		'think_to_add' => 'Galite pridėti kanalų.',
		'timeout' => 'Skirtasis laikas sekundėmis',
		'title' => 'Pavadinimas',
		'title_add' => 'Pridėti RSS kanalą',
		'ttl' => 'Automatiškai neatnaujinti dažniau nei',
		'unicityCriteria' => array(
			'_' => 'Straipsnių unikalumo kriterijus',
			'forced' => '<span title="Blokuoti unikalumo kriterijų, net kai kanale yra pasikartojančių straipsnių">priverstinis</span>',
			'help' => 'Aktualu netinkamiems kanalams.<br />⚠️ Pakeitus politiką, atsiras dublikatų.',
			'id' => 'Standartinis ID (numatytasis)',
			'link' => 'Nuoroda',
			'sha1:content' => 'Turinys',
			'sha1:content_published' => 'Turinys + data',
			'sha1:link_published' => 'Nuoroda + data',
			'sha1:link_published_title' => 'Nuoroda + data + pavadinimas',
			'sha1:link_published_title_content' => 'Nuoroda + data + pavadinimas + turinys',
			'sha1:published' => 'Data',
			'sha1:title' => 'Pavadinimas',
			'sha1:title_published' => 'Pavadinimas + data',
			'sha1:title_published_content' => 'Pavadinimas + data + turinys',
		),
		'url' => 'Kanalo URL',
		'useragent' => 'Nustatyti naudotojo agentą (user agent) šiam kanalui gauti',
		'useragent_help' => 'Pavyzdys: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Patikrinti kanalo tinkamumą',
		'website' => 'Svetainės URL',
		'websub' => 'Momentiniai pranešimai su WebSub',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'Eksportuoti',
			'sqlite' => 'Atsisiųsti naudotojo duomenų bazę kaip SQLite',
		),
		'export_labelled' => 'Eksportuoti straipsnius su etiketėmis',
		'export_opml' => 'Eksportuoti kanalų sąrašą (OPML)',
		'export_starred' => 'Eksportuoti mėgstamus',
		'feed_list' => '%s straipsnių sąrašas',
		'file_to_import' => 'Importuotinas failas<br />(OPML, JSON ar ZIP)',
		'file_to_import_no_zip' => 'Importuotinas failas<br />(OPML ar JSON)',
		'import' => 'Importuoti',
		'starred_list' => 'Mėgstamų straipsnių sąrašas',
		'title' => 'Importas / eksportas',
	),
	'menu' => array(
		'add' => 'Pridėti kanalą ar kategoriją',
		'import_export' => 'Importas / eksportas',
		'label_management' => 'Etikečių tvarkymas',
		'stats' => array(
			'idle' => 'Neaktyvūs kanalai',
			'main' => 'Pagrindinė statistika',
			'repartition' => 'Straipsnių pasiskirstymas',
			'unread_dates' => 'Neskaitymo datos',
		),
		'subscription_management' => 'Prenumeratų tvarkymas',
		'subscription_tools' => 'Prenumeratų įrankiai',
	),
	'priority' => array(
		'_' => 'Visibility',	// TODO
		'category' => 'Show in its category',	// TODO
		'feed' => 'Show in its feed',	// TODO
		'hidden' => 'Do not show',	// TODO
		'important' => 'Show in important feeds',	// TODO
		'main_stream' => 'Show in main stream',	// TODO
		'use_category_setting' => array(
			'_' => 'Use category setting',	// TODO
			'help' => 'Category setting: %s',	// TODO
		),
	),
	'tag' => array(
		'auto_label' => 'Pridėti šią etiketę naujiems straipsniams',
		'name' => 'Pavadinimas',
		'new_name' => 'Naujas pavadinimas',
		'old_name' => 'Senas pavadinimas',
	),
	'title' => array(
		'_' => 'Prenumeratų tvarkymas',
		'add' => 'Pridėti kanalą ar kategoriją',
		'add_category' => 'Pridėti kategoriją',
		'add_dynamic_opml' => 'Pridėti dinaminį OPML',
		'add_feed' => 'Pridėti kanalą',
		'add_label' => 'Pridėti etiketę',
		'add_opml_category' => 'OPML kategorijos pavadinimas',
		'delete_label' => 'Ištrinti šią etiketę',
		'feed_management' => 'RSS kanalų tvarkymas',
		'subscription_tools' => 'Prenumeratų įrankiai',
	),
);

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
		'documentation' => 'Kopioi seuraava URL-osoite, niin voit käyttää sitä ulkoisessa työkalussa.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Vedä tämä painike kirjanmerkkien työkalupalkkiin tai napsauta sitä hiiren kakkospainikkeella ja valitse Bookmark This Link (Tallenna linkki kirjanmerkkeihin). Napsauta sitten Tilaa-painiketta millä tahansa sivulla, jonka päivityksiä haluat seurata.',
		'label' => 'Tilaa',
		'title' => 'Kirjanmerkkisovelma',
	),
	'category' => array(
		'_' => 'Luokka',
		'add' => 'Lisää luokka',
		'archiving' => 'Arkistointi',
		'dynamic_opml' => array(
			'_' => 'Dynaaminen OPML',
			'help' => 'Voit tuoda syötteet tähän luokkaan automaattisesti antamalla <a href="http://opml.org/" target="_blank">OPML-tiedoston</a> URL-osoitteen',
		),
		'empty' => 'Tyhjä luokka',
		'expand' => 'Laajenna luokka',
		'information' => 'Tiedot',
		'open' => 'Avaa luokka',
		'opml_url' => 'OPML-tiedoston URL-osoite',
		'position' => 'Näyttöjärjestys',
		'position_help' => 'Määritä luokkien lajittelujärjestys',
		'title' => 'Otsikko',
	),
	'feed' => array(
		'accept_cookies' => 'Hyväksy evästeet',
		'accept_cookies_help' => 'Salli syötepalvelimen määrittää evästeitä (tallennetaan vain pyynnön käsittelyn ajaksi)',
		'add' => 'Lisää syöte',
		'advanced' => 'Lisäasetukset',
		'archiving' => 'Arkistointi',
		'auth' => array(
			'configuration' => 'Sisäänkirjaus',
			'help' => 'Mahdollistaa HTTP-suojattujen RSS-syötteiden käytön',
			'http' => 'HTTP-todennus',
			'password' => 'HTTP-salasana',
			'username' => 'HTTP-käyttäjätunnus',
		),
		'change_favicon' => 'Change…',	// TODO
		'clear_cache' => 'Tyhjennä välimuisti aina',
		'content_action' => array(
			'_' => 'Toiminto noudettaessa artikkelin sisältö',
			'append' => 'Lisää aiemman sisällön perään',
			'prepend' => 'Lisää ennen aiempaa sisältöä',
			'replace' => 'Korvaa aiempi sisältö',
		),
		'content_retrieval' => 'Content retrieval',	// TODO
		'css_cookie' => 'Käytä evästeitä noudettaessa artikkelin sisältö',
		'css_cookie_help' => 'Esimerkki: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Noutaa lyhennetyt RSS-syötteet (huomautus: kestää pidempään!)',
		'css_path' => 'Artikkelin CSS-valitsin alkuperäisellä sivustolla',
		'css_path_filter' => array(
			'_' => 'Poistettavien elementtien CSS-valitsin',
			'help' => 'CSS-valitsin voi olla luettelo, kuten: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'Kuvaus',
		'empty' => 'Syöte on tyhjä. Varmista, että sitä ylläpidetään edelleen.',
		'error' => 'Syötteessä on ilmennyt ongelma. Varmista, että se on aina tavoitettavissa.',	// DIRTY
		'export-as-opml' => array(
			'download' => 'Lataa',
			'help' => 'XML-tiedosto (osa tiedoista. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">Katso ohje</a>)',
			'label' => 'Vie OPML-tiedostoksi',
		),
		'ext_favicon' => 'Set automatically',	// TODO
		'favicon_changed_by_ext' => 'The icon has been set by the <b>%s</b> extension.',	// TODO
		'filteractions' => array(
			'_' => 'Suodatustoiminnot',
			'help' => 'Kirjoita kukin hakusuodatin omalle rivilleen. Lisätietoja operaattoreista <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">ohjeissa</a>.',
		),
		'http_headers' => 'HTTP-otsikot',
		'http_headers_help' => 'Otsikot erotellaan rivinvaihdoin, ja nimi ja arvo erotellaan kaksoispisteellä. Esimerkki: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',
		'icon' => 'Icon',	// TODO
		'information' => 'Tiedot',
		'keep_min' => 'Säilytettävien artikkeleiden vähimmäismäärä',
		'kind' => array(
			'_' => 'Syötteen lähteen laji',
			'html_json' => array(
				'_' => 'HTML + XPath + JSON-pistemerkintä (JSON HTML:ssä)',
				'xpath' => array(
					'_' => 'XPath (JSON HTML:ssä)',
					'help' => 'Esimerkki: <code>normalize-space(//script[@type="application/json"])</code> (single JSON)<br />or: <code>//script[@type="application/ld+json"]</code> (one JSON object per article)',	// DIRTY
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (sivujen haravointi)',
				'feed_title' => array(
					'_' => 'syötteen otsikko',
					'help' => 'Esimerkki: <code>//title</code> tai staattinen merkkijono: <code>"Oma syötteeni"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> on standardinmukainen kyselykieli edistyneille käyttäjille, jonka avulla FreshRSS toteuttaa verkkosivujen haravoinnin.',
				'item' => array(
					'_' => '<strong>uutisten</strong> haku<br /><small>(tärkein)</small>',
					'help' => 'Esimerkki: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'tekstin kirjoittaja',
					'help' => 'Voi olla myös staattinen merkkijono. Esimerkki: <code>"Anonyymi"</code>',
				),
				'item_categories' => 'tekstin avainsanat (tag)',
				'item_content' => array(
					'_' => 'tekstin sisältö',
					'help' => 'Esimerkiksi koko tekstin sisältö: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'tekstin pikkukuva',
					'help' => 'Esimerkki: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Mukautettu päivämäärän/kellonajan muoto',
					'help' => 'Valinnainen. <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>-funktion tukema muoto, kuten <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'tekstin päivämäärä',
					'help' => '<a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>-funktio jäsentää tuloksen',
				),
				'item_title' => array(
					'_' => 'tekstin otsikko',
					'help' => 'Käytä erityisesti <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath-siirtymää</a> <code>descendant::</code>, esimerkiksi <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'tekstin yksilöllinen tunnus',
					'help' => 'Valinnainen. Esimerkki: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'tekstin URL-osoite',
					'help' => 'Esimerkki: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (suhteessa tekstiin) kohteelle:',
				'xpath' => 'XPath kohteelle:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (pistemerkintä)',
				'feed_title' => array(
					'_' => 'syötteen otsikko',
					'help' => 'Esimerkki: <code>meta.title</code> tai staattinen merkkijono: <code>"Mukautettu syötteeni"</code>',
				),
				'help' => 'JSON-pistemerkintä käyttää pisteitä objektien välissä ja hakasulkeita taulukoissa (esimerkki: <code>data.items[0].title</code>)',
				'item' => array(
					'_' => '<strong>uutisten</strong> haku<br /><small>(tärkein)</small>',
					'help' => 'JSON-polku taulukkoon, joka sisältää tekstit, esimerkiksi <code>$</code> tai <code>newsItems</code>',
				),
				'item_author' => 'tekstin kirjoittaja',
				'item_categories' => 'tekstin avainsanat (tag)',
				'item_content' => array(
					'_' => 'tekstin sisältö',
					'help' => 'Tunniste, jossa sisältö on, esimerkiksi <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'tekstin pikkukuva',
					'help' => 'Esimerkki: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Mukautettu päivämäärän/kellonajan muoto',
					'help' => 'Valinnainen. <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>-funktion tukema muoto, kuten <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'tekstin päivämäärä',
					'help' => '<a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>-funktio jäsentää tuloksen',
				),
				'item_title' => 'tekstin otsikko',
				'item_uid' => 'tekstin yksilöllinen tunnus',
				'item_uri' => array(
					'_' => 'tekstin URL-osoite',
					'help' => 'Esimerkki: <code>permalink</code>',
				),
				'json' => 'pistemerkintä kohteelle:',
				'relative' => 'pistemerkitty polku (suhteessa tekstiin) kohteelle:',
			),
			'jsonfeed' => 'JSON-syöte',
			'rss' => 'RSS/Atom (oletus)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Tyhjennä välimuisti',
			'clear_cache_help' => 'Tyhjennä syötteen välimuisti.',
			'reload_articles' => 'Lataa artikkelit uudelleen',
			'reload_articles_help' => 'Lataa määritetty lukumäärä artikkeleita uudelleen ja nouda koko sisältö, jos valitsin on määritetty.',
			'title' => 'Ylläpito',
		),
		'max_http_redir' => 'Enimmäismäärä HTTP-uudelleenohjauksia',
		'max_http_redir_help' => 'Voit määrittää arvoksi myös 0 tai tyhjä (poista käytöstä) tai -1 (rajaton määrä uudelleenohjauksia)',
		'method' => array(
			'_' => 'HTTP-metodi',
		),
		'method_help' => 'POST-tiedot tukevat automaattisesti <code>application/x-www-form-urlencoded</code>- ja <code>application/json</code>-sisältöä',
		'method_postparams' => 'POST-menetelmän tiedot',
		'moved_category_deleted' => 'Kun poistat luokan, sen syötteet siirretään automaattisesti luokkaan <em>%s</em>.',
		'mute' => array(
			'_' => 'vaimenna',
			'state_is_muted' => 'Syöte on vaimennettu',
		),
		'no_selected' => 'Syötettä ei ole valittu.',
		'number_entries' => '%d artikkelia',
		'open_feed' => 'Avaa syöte %s',
		'path_entries_conditions' => 'Conditions for content retrieval',	// TODO
		'priority' => array(
			'_' => 'Näkyvyys',
			'archived' => 'Älä näytä (arkistoitu)',
			'category' => 'Näytä luokassaan',
			'important' => 'Näytä tärkeissä syötteissä',
			'main_stream' => 'Näytä pääsyötevirrassa',
		),
		'proxy' => 'Nouda syöte käyttämällä välityspalvelinta',
		'proxy_help' => 'Valitse protokolla (esimerkki: SOCKS5) ja kirjoita välityspalvelimen osoite (esimerkki: <kbd>127.0.0.1:1080</kbd> tai <kbd>käyttäjätunnus:salasana@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'Reset to default',	// TODO
		'selector_preview' => array(
			'show_raw' => 'Näytä lähdekoodi',
			'show_rendered' => 'Näytä sisältö',
		),
		'show' => array(
			'all' => 'Näytä kaikki syötteet',
			'error' => 'Näytä vain syötteet, joissa on virheitä',
		),
		'showing' => array(
			'error' => 'Näkyvissä vain syötteet, joissa on virheitä',
		),
		'ssl_verify' => 'Varmenna SSL-suojaus',
		'stats' => 'Tilastot',
		'think_to_add' => 'Haluat ehkä lisätä joitakin syötteitä.',
		'timeout' => 'Aikakatkaisu sekunteina',
		'title' => 'Otsikko',
		'title_add' => 'Lisää RSS-syöte',
		'ttl' => 'Älä päivitä automaattisesti useammin kuin',
		'unicityCriteria' => array(
			'_' => 'Artikkelin yksilöivät ehdot',
			'forced' => '<span title="Estä yksilöivät ehdot, vaikka syötteen artikkeleista olisi kaksoiskappaleita">pakotettu</span>',
			'help' => 'Olennainen virheellisille syötteille.<br />⚠️ Käytännön muuttaminen luo kaksoiskappaleita.',
			'id' => 'Perustunnus (oletus)',
			'link' => 'Linkki',
			'sha1:content' => 'Sisältö',
			'sha1:content_published' => 'Sisältö + päiväys',
			'sha1:link_published' => 'Linkki + päiväys',
			'sha1:link_published_title' => 'Linkki + päiväys + otsikko',
			'sha1:link_published_title_content' => 'Linkki + päiväys + otsikko + sisältö',
			'sha1:published' => 'Päiväys',
			'sha1:title' => 'Otsikko',
			'sha1:title_published' => 'Otsikko + päiväys',
			'sha1:title_published_content' => 'Otsikko + päiväys + sisältö',
		),
		'url' => 'Syötteen URL-osoite',
		'useragent' => 'Määritä syötteen noutamiseen käytettävä käyttäjäagentti',
		'useragent_help' => 'Esimerkki: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Tarkista syötteen kelpoisuus',
		'website' => 'Sivuston URL-osoite',
		'websub' => 'Välittömät ilmoitukset WebSubin avulla',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'Vie',
			'sqlite' => 'Lataa käyttäjän tietokanta SQLite-muodossa',
		),
		'export_labelled' => 'Vie merkityt artikkelit',
		'export_opml' => 'Vie syöteluettelo (OPML)',
		'export_starred' => 'Vie suosikit',
		'feed_list' => 'Syötteen %s artikkelit',
		'file_to_import' => 'Tuotava tiedosto<br />(OPML, JSON tai ZIP)',
		'file_to_import_no_zip' => 'Tuotava tiedosto<br />(OPML tai JSON)',
		'import' => 'Tuo tiedostosta',
		'starred_list' => 'Suosikkiartikkelit',
		'title' => 'Tuonti / Vienti',
	),
	'menu' => array(
		'add' => 'Lisää syöte tai luokka',
		'import_export' => 'Tuonti / Vienti',
		'label_management' => 'Tunnisteiden hallinta',
		'stats' => array(
			'idle' => 'Hiljentyneet syötteet',
			'main' => 'Tilastot',
			'repartition' => 'Artikkelien uudelleenjaottelu',
		),
		'subscription_management' => 'Tilausten hallinta',
		'subscription_tools' => 'Tilaustyökalut',
	),
	'tag' => array(
		'auto_label' => 'Lisää merkintä uusiin artikkeleihin',
		'name' => 'Nimi',
		'new_name' => 'Uusi nimi',
		'old_name' => 'Vanha nimi',
	),
	'title' => array(
		'_' => 'Tilausten hallinta',
		'add' => 'Lisää syöte tai luokka',
		'add_category' => 'Lisää luokkaa',
		'add_dynamic_opml' => 'Lisää dynaaminen OPML',
		'add_feed' => 'Lisää syöte',
		'add_label' => 'Lisää tunniste',
		'add_opml_category' => 'OPML category name',	// TODO
		'delete_label' => 'Poista tunniste',
		'feed_management' => 'RSS-syötteiden hallinta',
		'rename_label' => 'Nimeä tunniste uudelleen',
		'subscription_tools' => 'Tilaustyökalut',
	),
);

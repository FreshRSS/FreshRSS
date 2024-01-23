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
		'documentation' => 'Copia il seguente URL per usarlo in un tool esterno.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Trascina questo pulsante nei preferiti o fai click destro e scegli “Inserisci questo link tra i preferiti”. Successivamente clicca il pulsante “Iscriviti” in qualsiasi pagina a cui ti vuoi iscrivere.',
		'label' => 'Iscriviti',
		'title' => 'Segnalibro',
	),
	'category' => array(
		'_' => 'Categoria',
		'add' => 'Aggiungi categoria',
		'archiving' => 'Archiviazione',
		'dynamic_opml' => array(
			'_' => 'OPML dinamico',
			'help' => 'Fornisci l’URL ad un <a href="http://opml.org/" target="_blank">file OPML</a> per popolare dinamicamente questa categoria con i feed',
		),
		'empty' => 'Categoria vuota',
		'information' => 'Informazioni',
		'opml_url' => 'URL OPML',
		'position' => 'Mostra posizione',
		'position_help' => 'Per controllare l’ordinamento della categoria',
		'title' => 'Titolo',
	),
	'feed' => array(
		'accept_cookies' => 'Accetta i cookie',
		'accept_cookies_help' => 'Consenti al server dei feed di impostare dei cookie (salvati in memoria solo per la durata della richiesta)',
		'add' => 'Aggiungi un Feed RSS',
		'advanced' => 'Avanzate',
		'archiving' => 'Archiviazione',
		'auth' => array(
			'configuration' => 'Autenticazione',
			'help' => 'Accesso per feeds protetti',
			'http' => 'Autenticazione HTTP',
			'password' => 'Password HTTP',
			'username' => 'Nome utente HTTP',
		),
		'clear_cache' => 'Cancella sempre la cache',
		'content_action' => array(
			'_' => 'Azione da effettuare quando viene recuperato il contenuto di un articolo',
			'append' => 'Aggiungi dopo il contenuto esistente',
			'prepend' => 'Aggiungi prima del contenuto esistente',
			'replace' => 'Rimpiazza il contenuto esistente',
		),
		'css_cookie' => 'Usa i cookie quando viene recuperato il contenuto di un articolo',
		'css_cookie_help' => 'Esempio: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'In caso di RSS feeds troncati (attenzione, richiede molto tempo!)',
		'css_path' => 'Percorso del foglio di stile CSS del sito di origine',
		'css_path_filter' => array(
			'_' => 'Il selettore CSS degli elementi da rimuovere',
			'help' => 'Il selettore CSS potrebbe essere una lista, ad esempio: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Descrizione',
		'empty' => 'Questo feed non contiene articoli. Per favore verifica il sito direttamente.',
		'error' => 'Questo feed ha generato un errore. Per favore verifica se ancora disponibile.',
		'filteractions' => array(
			'_' => 'Azioni di filtro',
			'help' => 'Scrivi un filtro di ricerca per riga. Operators <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">see documentation</a>.',	// DIRTY
		),
		'information' => 'Informazioni',
		'keep_min' => 'Numero minimo di articoli da mantenere',
		'kind' => array(
			'_' => 'Tipo di sorgente del feed',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'titolo del feed',
					'help' => 'Esempio: <code>//titolo</code> o una stringa statica: <code>"Il mio feed personalizzato"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> è un linguaggio di ricerca standard per utenti avanzati supportato da FreshRSS per abilitare il Web scraping.',
				'item' => array(
					'_' => 'trovare <strong>oggetti</strong><br /><small> notizia (più importanti)</small>',
					'help' => 'Esempio: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'oggetto autore',
					'help' => 'Può anche essere una stringa statica. Esempio: <code>"Anonimo"</code>',
				),
				'item_categories' => 'oggetto tag',
				'item_content' => array(
					'_' => 'oggetto contenuto',
					'help' => 'Esempio per considerare l’oggetto intero: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'oggetto miniatura',
					'help' => 'Esempio: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Formato personalizzato di data/ora',
					'help' => 'Opzionale. Un formato supportato da <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, ad esempio <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'oggetto data',
					'help' => 'Il risultato verrà analizzato da <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'oggetto titolo',
					'help' => 'Usa in particolare l’<a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> like <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'oggetto ID univoco',
					'help' => 'Opzionale. Esempio: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'oggetto link (URL)',
					'help' => 'Esempio: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (relativo all’oggetto) per:',
				'xpath' => 'XPath per:',
			),
			'json_dotpath' => array(
				'_' => 'JSON (path con i punti)',
				'feed_title' => array(
					'_' => 'titolo feed',
					'help' => 'Esempio: <code>meta.title</code> o una stringa statica: <code>"Il mio feed personalizzato"</code>',
				),
				'help' => 'Un JSON con le path divise da punti usa dei punti fra gli oggetti e le parentesi per gli array. (es. <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'ricerca nuovi <strong>elementi</strong><br /><small>(più importante)</small>',
					'help' => 'percorso JSON per l’array contenente gli elementi, es. <code>newsItems</code>',
				),
				'item_author' => 'autore elemento',
				'item_categories' => 'tag elemento',
				'item_content' => array(
					'_' => 'contenuto elemento',
					'help' => 'Chiave sotto la quale trovare il contenuto, es. <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'miniatura elemento',
					'help' => 'Esempio: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Formato data/ora personalizzato',
					'help' => 'Facoltativo. Un formato supportato da <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> come <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'data elemento',
					'help' => 'Il risultato sarà interpretato da <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'titolo elemento',
				'item_uid' => 'ID univoco elemento',
				'item_uri' => array(
					'_' => 'link elemento (URL)',
					'help' => 'Esempio: <code>permalink</code>',
				),
				'json' => 'Percorso con i punti per:',
				'relative' => 'Percorso con i punti (relativo all’elemento) per:',
			),
			'jsonfeed' => 'Feed JSON',
			'rss' => 'RSS / Atom (predefinito)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Svuota cache',
			'clear_cache_help' => 'Svuota la cache per questo feed.',
			'reload_articles' => 'Ricarica articoli',
			'reload_articles_help' => 'Ricarica gli articoli e recupera il contenuto completo se è definito un selettore.',
			'title' => 'Manutenzione',
		),
		'max_http_redir' => 'Numero massimo di redirect HTTP',
		'max_http_redir_help' => 'Imposta a 0 o lascia in bianco per disabilitare, -1 per impostare un numero illimitato di redirect',
		'method' => array(
			'_' => 'Metodo HTTP',
		),
		'method_help' => 'Il payload POST ha il supporto automatico per <code>application/x-www-form-urlencoded</code> e <code>application/json</code>',
		'method_postparams' => 'Payload per POST',
		'moved_category_deleted' => 'Cancellando una categoria i feed al suo interno verranno classificati automaticamente come <em>%s</em>.',
		'mute' => 'muta',
		'no_selected' => 'Nessun feed selezionato.',
		'number_entries' => '%d articoli',
		'priority' => array(
			'_' => 'Visibilità',
			'archived' => 'Non mostrare (archiviato)',
			'category' => 'Mostra nella sua categoria',
			'important' => 'Mostra nei feed importanti',
			'main_stream' => 'Mostra in homepage',
		),
		'proxy' => 'Imposta un proxy per recuperare questo feed',
		'proxy_help' => 'Seleziona un protocollo (e.g: SOCKS5) ed inserisci l’indirizzo del proxy (e.g: <kbd>127.0.0.1:1080</kbd> or <kbd>username:password@127.0.0.1:1080</kbd>)',	// DIRTY
		'selector_preview' => array(
			'show_raw' => 'Mostra codice sorgente',
			'show_rendered' => 'Mostra contenuto',
		),
		'show' => array(
			'all' => 'Mostra tutti i feed',
			'error' => 'Mostra solo feed con errori',
		),
		'showing' => array(
			'error' => 'Vengono mostrati solo i feed con errori',
		),
		'ssl_verify' => 'Verifica sicurezza SSL',
		'stats' => 'Statistiche',
		'think_to_add' => 'Aggiungi feed.',
		'timeout' => 'Timeout in secondi',
		'title' => 'Titolo',
		'title_add' => 'Aggiungi RSS feed',
		'ttl' => 'Non aggiornare automaticamente piu di',
		'url' => 'URL del feed',
		'useragent' => 'Imposta lo user agent per recuperare questo feed',
		'useragent_help' => 'Esempio: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Controlla la validita del feed ',
		'website' => 'URL del sito',
		'websub' => 'Notifica istantanea con WebSub',
	),
	'import_export' => array(
		'export' => 'Esporta',
		'export_labelled' => 'Esporta gli articoli etichettati',
		'export_opml' => 'Esporta tutta la lista dei feed (OPML)',
		'export_starred' => 'Esporta i tuoi preferiti',
		'feed_list' => 'Elenco di %s articoli',
		'file_to_import' => 'File da importare<br />(OPML, JSON o ZIP)',
		'file_to_import_no_zip' => 'File da importare<br />(OPML o JSON)',
		'import' => 'Importa',
		'starred_list' => 'Elenco articoli preferiti',
		'title' => 'Importa / esporta',
	),
	'menu' => array(
		'add' => 'Aggiungi un feed o una categoria',
		'import_export' => 'Importa / esporta',
		'label_management' => 'Gestione etichette',
		'stats' => array(
			'idle' => 'Feeds non aggiornati',
			'main' => 'Statistiche principali',
			'repartition' => 'Ripartizione articoli',
		),
		'subscription_management' => 'Gestione sottoscrizioni',
		'subscription_tools' => 'Strumenti di sottoscrizione',
	),
	'tag' => array(
		'auto_label' => 'Aggiungi questo tag ai nuovi articoli',
		'name' => 'Nome',
		'new_name' => 'Nuovo nome',
		'old_name' => 'Vecchio nome',
	),
	'title' => array(
		'_' => 'Gestione sottoscrizioni',
		'add' => 'Aggiungi un feed o una categoria',
		'add_category' => 'Aggiungi una categoria',
		'add_dynamic_opml' => 'Aggiungi OPML dinamico',
		'add_feed' => 'Aggiungi un feed',
		'add_label' => 'Aggiungi un’etichetta',
		'delete_label' => 'Cancella un’etichetta',
		'feed_management' => 'Gestione RSS feeds',
		'rename_label' => 'Rinomina un’etichetta',
		'subscription_tools' => 'Strumenti di sottoscrizione',
	),
);

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
		'documentation' => 'Copy the following URL to use it within an external tool.',	// TODO
		'title' => 'API',	// TODO
	),
	'bookmarklet' => array(
		'documentation' => 'Drag this button to your bookmarks toolbar or right-click it and choose "Bookmark This Link". Then click the "Subscribe" button in any page you want to subscribe to.',	// TODO
		'label' => 'Subscribe',	// TODO
		'title' => 'Bookmarklet',	// TODO
	),
	'category' => array(
		'_' => 'Categoria',
		'add' => 'Aggiungi categoria',
		'archiving' => 'Archiviazione',
		'empty' => 'Categoria vuota',
		'information' => 'Informazioni',
		'position' => 'Display position',	// TODO
		'position_help' => 'To control category sort order',	// TODO
		'title' => 'Titolo',
	),
	'feed' => array(
		'add' => 'Aggiungi un Feed RSS',
		'advanced' => 'Avanzate',
		'archiving' => 'Archiviazione',
		'auth' => array(
			'configuration' => 'Autenticazione',
			'help' => 'Accesso per feeds protetti',
			'http' => 'Autenticazione HTTP',
			'password' => 'HTTP password',	// TODO
			'username' => 'HTTP username',	// TODO
		),
		'clear_cache' => 'Always clear cache',	// TODO
		'content_action' => array(
			'_' => 'Content action when fetching the article content',	// TODO
			'append' => 'Add after existing content',	// TODO
			'prepend' => 'Add before existing content',	// TODO
			'replace' => 'Replace existing content',	// TODO
		),
		'css_cookie' => 'Use Cookies when fetching the article content',	// TODO
		'css_cookie_help' => 'Example: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',	// TODO
		'css_help' => 'In caso di RSS feeds troncati (attenzione, richiede molto tempo!)',
		'css_path' => 'Percorso del foglio di stile CSS del sito di origine',
		'description' => 'Descrizione',
		'empty' => 'Questo feed non contiene articoli. Per favore verifica il sito direttamente.',
		'error' => 'Questo feed ha generato un errore. Per favore verifica se ancora disponibile.',
		'filteractions' => array(
			'_' => 'Filter actions',	// TODO
			'help' => 'Write one search filter per line.',	// TODO
		),
		'information' => 'Informazioni',
		'keep_min' => 'Numero minimo di articoli da mantenere',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>//title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// TODO
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
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => array(
					'_' => 'item title',	// TODO
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes">XPath axis</a> <code>descendant::</code> like <code>descendant::h2</code>',	// TODO
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
			'clear_cache' => 'Clear cache',	// TODO
			'clear_cache_help' => 'Clear the cache for this feed.',	// TODO
			'reload_articles' => 'Reload articles',	// TODO
			'reload_articles_help' => 'Reload articles and fetch complete content if a selector is defined.',	// TODO
			'title' => 'Maintenance',	// TODO
		),
		'moved_category_deleted' => 'Cancellando una categoria i feed al suo interno verranno classificati automaticamente come <em>%s</em>.',
		'mute' => 'mute',	// TODO
		'no_selected' => 'Nessun feed selezionato.',
		'number_entries' => '%d articoli',
		'priority' => array(
			'_' => 'Visibility',	// TODO
			'archived' => 'Do not show (archived)',	// TODO
			'main_stream' => 'Mostra in homepage',
			'normal' => 'Show in its category',	// TODO
		),
		'proxy' => 'Set a proxy for fetching this feed',	// TODO
		'proxy_help' => 'Select a protocol (e.g: SOCKS5) and enter the proxy address (e.g: <kbd>127.0.0.1:1080</kbd>)',	// TODO
		'selector_preview' => array(
			'show_raw' => 'Show source code',	// TODO
			'show_rendered' => 'Show content',	// TODO
		),
		'show' => array(
			'all' => 'Show all feeds',	// TODO
			'error' => 'Show only feeds with errors',	// TODO
		),
		'showing' => array(
			'error' => 'Showing only feeds with errors',	// TODO
		),
		'ssl_verify' => 'Verify SSL security',	// TODO
		'stats' => 'Statistiche',
		'think_to_add' => 'Aggiungi feed.',
		'timeout' => 'Timeout in seconds',	// TODO
		'title' => 'Titolo',
		'title_add' => 'Aggiungi RSS feed',
		'ttl' => 'Non aggiornare automaticamente piu di',
		'url' => 'Feed URL',	// TODO
		'useragent' => 'Set the user agent for fetching this feed',	// TODO
		'useragent_help' => 'Example: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',	// TODO
		'validator' => 'Controlla la validita del feed ',
		'website' => 'URL del sito',
		'websub' => 'Notifica istantanea con WebSub',
	),
	'import_export' => array(
		'export' => 'Esporta',
		'export_labelled' => 'Export your labelled articles',	// TODO
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
		'add' => 'Add a feed or category',	// TODO
		'import_export' => 'Importa / esporta',
		'label_management' => 'Label management',	// TODO
		'stats' => array(
			'idle' => 'Feeds non aggiornati',
			'main' => 'Statistiche principali',
			'repartition' => 'Ripartizione articoli',
		),
		'subscription_management' => 'Gestione sottoscrizioni',
		'subscription_tools' => 'Subscription tools',	// TODO
	),
	'tag' => array(
		'name' => 'Name',	// TODO
		'new_name' => 'New name',	// TODO
		'old_name' => 'Old name',	// TODO
	),
	'title' => array(
		'_' => 'Gestione sottoscrizioni',
		'add' => 'Add a feed or category',	// TODO
		'add_category' => 'Add a category',	// TODO
		'add_feed' => 'Add a feed',	// TODO
		'add_label' => 'Add a label',	// TODO
		'delete_label' => 'Delete a label',	// TODO
		'feed_management' => 'Gestione RSS feeds',
		'rename_label' => 'Rename a label',	// TODO
		'subscription_tools' => 'Subscription tools',	// TODO
	),
);

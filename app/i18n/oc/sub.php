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
		'documentation' => 'Copiatz l’URL seguenta per l’utilizaire dins d’una aisina extèrna.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Depausatz aqueste boton per la barra de marcapaginas o clicatz-lo a drecha e causissètz « Enregistrar aqueste ligam». Puèi clicatz «S’abonar» sus las paginas que volètz seguir.',
		'label' => 'S’abonar',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Categoria',
		'add' => 'Ajustar categoria',
		'archiving' => 'Archivar',
		'empty' => 'Categoria voida',
		'information' => 'Informacions',
		'position' => 'Mostrar la posicion',
		'position_help' => 'Per contrarotlar l’òrdre de tria de la categoria',
		'title' => 'Títol',
	),
	'feed' => array(
		'add' => 'Ajustar un flux RSS',
		'advanced' => 'Avançat',
		'archiving' => 'Archivar',
		'auth' => array(
			'configuration' => 'Identificacion',
			'help' => 'Permet l’accès als fluxes protegits per una autentificacion HTTP',
			'http' => 'Autentificacion HTTP',
			'password' => 'Senhal HTTP',
			'username' => 'Identificant HTTP',
		),
		'clear_cache' => 'Totjorn escafar lo cache',
		'content_action' => array(
			'_' => 'Accion sul contengut en recuperant lo contengut de l’article',
			'append' => 'Apondre aprèp lo contengut existent',
			'prepend' => 'Apondre abans lo contengut existent',
			'replace' => 'Remplaçar lo contengut existent',
		),
		'css_cookie' => 'Utilizar los cookies en recuperant lo contengut de l’article',
		'css_cookie_help' => 'Exemple : <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Permet de recuperar los fluxes troncats (atencion, demanda mai de temps !)',
		'css_path' => 'Selector CSS dels articles sul site d’origina',
		'description' => 'Descripcion',	// IGNORE
		'empty' => 'Aqueste flux es void. Assegurats-vos qu’es totjorn mantengut.',
		'error' => 'Aqueste flux a rescontrat un problèma. Volgatz verificar que siá totjorn accessible puèi actualizatz-lo.',
		'filteractions' => array(
			'_' => 'Filtre d’accion',
			'help' => 'Escrivètz una recèrca per linha.',
		),
		'information' => 'Informacions',
		'keep_min' => 'Nombre minimum d’articles de servar',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// TODO
				'feed_title' => array(
					'_' => '<small>XPath for:</small> feed title',	// TODO
					'help' => 'Example: <code>//title</code>',	// TODO
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// TODO
				'item' => array(
					'_' => '<small>XPath for:</small> finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'Example: <code>//li[@class="news-item"]</code>',	// TODO
				),
				'item_author' => array(
					'_' => '<small>XPath for:</small> items author<br /><small>(relative to item)</small>',	// TODO
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',	// TODO
				),
				'item_categories' => '<small>XPath for:</small> items tags<br /><small>(relative to item)</small>',	// TODO
				'item_content' => array(
					'_' => '<small>XPath for:</small> items content<br /><small>(relative to item)</small>',	// TODO
					'help' => 'Example: <code>descendant::span[@class="summary"]</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => '<small>XPath for:</small> items thumbnail<br /><small>(relative to item)</small>',	// TODO
					'help' => 'Example: <code>descendant::img/@src</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => '<small>XPath for:</small> items date<br /><small>(relative to item)</small>',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => array(
					'_' => '<small>XPath for:</small> items title<br /><small>(relative to item)</small>',	// TODO
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes">XPath axis</a> <code>descendant::</code>',	// TODO
				),
				'item_uri' => array(
					'_' => '<small>XPath for:</small> items URL / link<br /><small>(relative to item)</small>',	// TODO
					'help' => 'Example: <code>descendant::a/@href</code>',	// TODO
				),
			),
			'rss' => 'RSS / Atom (default)',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'Escafar lo cache',
			'clear_cache_help' => 'Escafar lo cache d’aqueste flux sul disc',
			'reload_articles' => 'Recargar los articles',
			'reload_articles_help' => 'Recargar los articles e recuperar lo contengut complet',
			'title' => 'Mantenença',
		),
		'moved_category_deleted' => 'Quand escafatz una categoria, sos fluxes son automaticament classats dins <em>%s</em>.',
		'mute' => 'mut',
		'no_selected' => 'Cap de flux pas seleccionat.',
		'number_entries' => '%d articles',	// IGNORE
		'priority' => array(
			'_' => 'Visibilitat',
			'archived' => 'Mostrar pas (archivat)',
			'main_stream' => 'Mostar al flux màger',
			'normal' => 'Mostar dins sa categoria',
		),
		'proxy' => 'Definir un servidor proxy per trapar aqueste flux',
		'proxy_help' => 'Seleccionatz un protocòl (ex : SOCKS5) e picatz l’adreça del proxy (ex : <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Veire lo còdi font',
			'show_rendered' => 'Veire lo contengut',
		),
		'show' => array(
			'all' => 'Mostrar totes los fluxes',
			'error' => 'Mostrar pas que los fluxes amb errors',
		),
		'showing' => array(
			'error' => 'Afichatge dels articles amb errors solament',
		),
		'ssl_verify' => 'Verificacion de la seguretat SSL',
		'stats' => 'Estatisticas',
		'think_to_add' => 'Podètz ajustar de fluxes.',
		'timeout' => 'Temps d’espèra en segondas',
		'title' => 'Títol',
		'title_add' => 'Ajustar un flux RSS',
		'ttl' => 'Actualizar pas automaticament mai sovent que',
		'url' => 'Flux URL',
		'useragent' => 'Definir un user agent per recuperar aqueste flux',
		'useragent_help' => 'Exemple : <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Verificar la validitat del flux',
		'website' => 'URL del site',
		'websub' => 'Notificacions instantanèas amb WebSub',
	),
	'import_export' => array(
		'export' => 'Exportar',
		'export_labelled' => 'Exportar los articles etiquetats',
		'export_opml' => 'Exportar la lista de fluxes (OPML)',
		'export_starred' => 'Exportar los favorits',
		'feed_list' => 'Lista dels %s articles',
		'file_to_import' => 'Fichièr d’importar<br />(OPML, JSON o ZIP)',
		'file_to_import_no_zip' => 'Fichièr d’importar<br />(OPML o JSON)',
		'import' => 'Importar',
		'starred_list' => 'Lista dels articles favorits',
		'title' => 'Importar / Exportar',
	),
	'menu' => array(
		'add' => 'Ajustar un flux o una categoria',
		'import_export' => 'Importar / Exportar',
		'label_management' => 'Gestion de las etiquetas',
		'stats' => array(
			'idle' => 'Fluxes inactius',
			'main' => 'Estatisticas principalas',
			'repartition' => 'Reparticion dels articles',
		),
		'subscription_management' => 'Gestion dels abonaments',
		'subscription_tools' => 'Aisinas d’abonament',
	),
	'tag' => array(
		'name' => 'Nom',
		'new_name' => 'Nom novèl',
		'old_name' => 'Nom ancian',
	),
	'title' => array(
		'_' => 'Gestion dels abonaments',
		'add' => 'Apondon de flux o categoria',
		'add_category' => 'Ajustar una categoria',
		'add_feed' => 'Ajustar un flux',
		'add_label' => 'Ajustar una etiqueta',
		'delete_label' => 'Suprimir una etiqueta',
		'feed_management' => 'Gestion dels fluxes RSS',
		'rename_label' => 'Renomenar una etiqueta',
		'subscription_tools' => 'Aisinas d’abonament',
	),
);

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
		'_' => 'Kategorie',
		'add' => 'Přidat kategorie',
		'archiving' => 'Archivace',
		'empty' => 'Vyprázdit kategorii',
		'information' => 'Informace',
		'position' => 'Display position',	// TODO
		'position_help' => 'To control category sort order',	// TODO
		'title' => 'Název',
	),
	'feed' => array(
		'add' => 'Přidat RSS kanál',
		'advanced' => 'Pokročilé',
		'archiving' => 'Archivace',
		'auth' => array(
			'configuration' => 'Přihlášení',
			'help' => 'Umožní přístup k RSS kanálům chráneným HTTP autentizací',
			'http' => 'HTTP přihlášení',
			'password' => 'Heslo',
			'username' => 'Přihlašovací jméno',
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
		'css_help' => 'Stáhne zkrácenou verzi RSS kanálů (pozor, náročnější na čas!)',
		'css_path' => 'Původní CSS soubor článku z webových stránek',
		'description' => 'Popis',
		'empty' => 'Kanál je prázdný. Ověřte prosím zda je ještě autorem udržován.',
		'error' => 'Vyskytl se problém s kanálem. Ověřte že je vždy dostupný, prosím, a poté jej aktualizujte.',
		'filteractions' => array(
			'_' => 'Filter actions',	// TODO
			'help' => 'Write one search filter per line.',	// TODO
		),
		'information' => 'Informace',
		'keep_min' => 'Zachovat tento minimální počet článků',
		'maintenance' => array(
			'clear_cache' => 'Clear cache',	// TODO
			'clear_cache_help' => 'Clear the cache for this feed.',	// TODO
			'reload_articles' => 'Reload articles',	// TODO
			'reload_articles_help' => 'Reload articles and fetch complete content if a selector is defined.',	// TODO
			'title' => 'Maintenance',	// TODO
		),
		'moved_category_deleted' => 'Po smazání kategorie budou v ní obsažené kanály automaticky přesunuty do <em>%s</em>.',
		'mute' => 'mute',	// TODO
		'no_selected' => 'Nejsou označeny žádné kanály.',
		'number_entries' => '%d článků',
		'priority' => array(
			'_' => 'Visibility',	// TODO
			'archived' => 'Do not show (archived)',	// TODO
			'main_stream' => 'Zobrazit ve “Všechny kanály”',
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
		'stats' => 'Statistika',
		'think_to_add' => 'Můžete přidat kanály.',
		'timeout' => 'Timeout in seconds',	// TODO
		'title' => 'Název',
		'title_add' => 'Přidat RSS kanál',
		'ttl' => 'Neobnovovat častěji než',
		'url' => 'URL kanálu',
		'useragent' => 'Set the user agent for fetching this feed',	// TODO
		'useragent_help' => 'Example: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',	// TODO
		'validator' => 'Zkontrolovat platnost kanálu',
		'website' => 'URL webové stránky',
		'websub' => 'Okamžité oznámení s WebSub',
	),
	'import_export' => array(
		'export' => 'Export',	// TODO
		'export_labelled' => 'Export your labelled articles',	// TODO
		'export_opml' => 'Exportovat seznam kanálů (OPML)',
		'export_starred' => 'Exportovat oblíbené',
		'feed_list' => 'Seznam %s článků',
		'file_to_import' => 'Soubor k importu<br />(OPML, JSON nebo ZIP)',
		'file_to_import_no_zip' => 'Soubor k importu<br />(OPML nebo JSON)',
		'import' => 'Import',	// TODO
		'starred_list' => 'Seznam oblíbených článků',
		'title' => 'Import / export',	// TODO
	),
	'menu' => array(
		'add' => 'Add a feed or category',	// TODO
		'import_export' => 'Import / export',	// TODO
		'label_management' => 'Label management',	// TODO
		'stats' => array(
			'idle' => 'Neaktivní kanály',
			'main' => 'Přehled',
			'repartition' => 'Rozdělení článků',
		),
		'subscription_management' => 'Správa subskripcí',
		'subscription_tools' => 'Subscription tools',	// TODO
	),
	'tag' => array(
		'name' => 'Name',	// TODO
		'new_name' => 'New name',	// TODO
		'old_name' => 'Old name',	// TODO
	),
	'title' => array(
		'_' => 'Správa subskripcí',
		'add' => 'Add a feed or category',	// TODO
		'add_category' => 'Add a category',	// TODO
		'add_feed' => 'Add a feed',	// TODO
		'add_label' => 'Add a label',	// TODO
		'delete_label' => 'Delete a label',	// TODO
		'feed_management' => 'Správa RSS kanálů',
		'rename_label' => 'Rename a label',	// TODO
		'subscription_tools' => 'Subscription tools',	// TODO
	),
);

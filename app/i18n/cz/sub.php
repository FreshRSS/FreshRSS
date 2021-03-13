<?php

return array(
	'add' => 'Feed and category creation has been moved <a href=\'%s\'>here</a>. It is also accessible from the menu on the left and from the ✚ icon available on the main page.',	// TODO - Translation
	'api' => array(
		'documentation' => 'Copy the following URL to use it within an external tool.',	// TODO - Translation
		'title' => 'API',	// TODO - Translation
	),
	'bookmarklet' => array(
		'documentation' => 'Drag this button to your bookmarks toolbar or right-click it and choose "Bookmark This Link". Then click the "Subscribe" button in any page you want to subscribe to.',	// TODO - Translation
		'label' => 'Subscribe',	// TODO - Translation
		'title' => 'Bookmarklet',	// TODO - Translation
	),
	'category' => array(
		'_' => 'Kategorie',
		'add' => 'Přidat kategorii',
		'archiving' => 'Archivace',
		'empty' => 'Vyprázdit kategorii',
		'information' => 'Informace',
		'position' => 'Display position',	// TODO - Translation
		'position_help' => 'To control category sort order',	// TODO - Translation
		'title' => 'Název',
	),
	'feed' => array(
		'add' => 'Přidat RSS kanál',
		'advanced' => 'Pokročilé',
		'archiving' => 'Archivace',
		'auth' => array(
			'help' => 'Umožní přístup k RSS kanálům chráneným HTTP autentizací',
			'http' => 'HTTP přihlášení',
			'password' => 'Heslo',
			'username' => 'Přihlašovací jméno',
		),
		'clear_cache' => 'Always clear cache',	// TODO - Translation
		'content_action' => array(
			'_' => 'Content action when fetching the article content',	// TODO - Translation
			'append' => 'Add after existing content',	// TODO - Translation
			'prepend' => 'Add before existing content',	// TODO - Translation
			'replace' => 'Replace existing content',	// TODO - Translation
		),
		'css_cookie' => 'Use Cookies when fetching the article content',	// TODO - Translation
		'css_cookie_help' => 'Example: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',	// TODO - Translation
		'css_help' => 'Stáhne zkrácenou verzi RSS kanálů (pozor, náročnější na čas!)',
		'css_path' => 'Původní CSS soubor článku z webových stránek',
		'description' => 'Popis',
		'empty' => 'Kanál je prázdný. Ověřte prosím zda je ještě autorem udržován.',
		'error' => 'Vyskytl se problém s kanálem. Ověřte že je vždy dostupný, prosím, a poté jej aktualizujte.',
		'filteractions' => array(
			'_' => 'Filter actions',	// TODO - Translation
			'help' => 'Write one search filter per line.',	// TODO - Translation
		),
		'information' => 'Informace',
		'keep_min' => 'Zachovat tento minimální počet článků',
		'maintenance' => array(
			'clear_cache' => 'Clear cache',	// TODO - Translation
			'clear_cache_help' => 'Clear the cache for this feed.',	// TODO - Translation
			'reload_articles' => 'Reload articles',	// TODO - Translation
			'reload_articles_help' => 'Reload articles and fetch complete content if a selector is defined.',	// TODO - Translation
			'title' => 'Maintenance',	// TODO - Translation
		),
		'moved_category_deleted' => 'Po smazání kategorie budou v ní obsažené kanály automaticky přesunuty do <em>%s</em>.',
		'mute' => 'mute',	// TODO - Translation
		'no_selected' => 'Nejsou označeny žádné kanály.',
		'number_entries' => '%d článků',
		'priority' => array(
			'_' => 'Visibility',	// TODO - Translation
			'archived' => 'Do not show (archived)',	// TODO - Translation
			'main_stream' => 'Zobrazit ve “Všechny kanály”',
			'normal' => 'Show in its category',	// TODO - Translation
		),
		'proxy' => 'Set a proxy for fetching this feed',	// TODO - Translation
		'proxy_help' => 'Select a protocol (e.g: SOCKS5) and enter the proxy address (e.g: <kbd>127.0.0.1:1080</kbd>)',	// TODO - Translation
		'selector_preview' => array(
			'show_raw' => 'Show source code',	// TODO - Translation
			'show_rendered' => 'Show content',	// TODO - Translation
		),
		'show' => array(
			'all' => 'Show all feeds',	// TODO - Translation
			'error' => 'Show only feeds with errors',	// TODO - Translation
		),
		'showing' => array(
			'error' => 'Showing only feeds with errors',	// TODO - Translation
		),
		'ssl_verify' => 'Verify SSL security',	// TODO - Translation
		'stats' => 'Statistika',
		'think_to_add' => 'Můžete přidat kanály.',
		'timeout' => 'Timeout in seconds',	// TODO - Translation
		'title' => 'Název',
		'title_add' => 'Přidat RSS kanál',
		'ttl' => 'Neobnovovat častěji než',
		'url' => 'URL kanálu',
		'useragent' => 'Set the user agent for fetching this feed',	// TODO - Translation
		'useragent_help' => 'Example: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',	// TODO - Translation
		'validator' => 'Zkontrolovat platnost kanálu',
		'website' => 'URL webové stránky',
		'websub' => 'Okamžité oznámení s WebSub',
	),
	'firefox' => array(
		'documentation' => 'Follow the steps described <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">here</a> to add FreshRSS to Firefox feed reader list.',	// TODO - Translation
		'obsolete_63' => 'From version 63 and onwards, Firefox has removed the ability to add your own subscription services that are not standalone programs.',	// TODO - Translation
		'title' => 'Firefox feed reader',	// TODO - Translation
	),
	'import_export' => array(
		'export' => 'Export',	// TODO - Translation
		'export_labelled' => 'Export your labelled articles',	// TODO - Translation
		'export_opml' => 'Exportovat seznam kanálů (OPML)',
		'export_starred' => 'Exportovat oblíbené',
		'feed_list' => 'Seznam %s článků',
		'file_to_import' => 'Soubor k importu<br />(OPML, JSON nebo ZIP)',
		'file_to_import_no_zip' => 'Soubor k importu<br />(OPML nebo JSON)',
		'import' => 'Import',	// TODO - Translation
		'starred_list' => 'Seznam oblíbených článků',
		'title' => 'Import / export',	// TODO - Translation
	),
	'menu' => array(
		'add' => 'Add a feed or category',	// TODO - Translation
		'add_feed' => 'Add a feed',	// TODO - Translation
		'bookmark' => 'Přihlásit (FreshRSS bookmark)',
		'import_export' => 'Import / export',	// TODO - Translation
		'label_management' => 'Label management',	// TODO - Translation
		'subscription_management' => 'Správa subskripcí',
		'subscription_tools' => 'Subscription tools',	// TODO - Translation
	),
	'tag' => array(
		'name' => 'Name',	// TODO - Translation
		'new_name' => 'New name',	// TODO - Translation
		'old_name' => 'Old name',	// TODO - Translation
	),
	'title' => array(
		'_' => 'Správa subskripcí',
		'add' => 'Add a feed or category',	// TODO - Translation
		'add_category' => 'Add a category',	// TODO - Translation
		'add_feed' => 'Add a feed',	// TODO - Translation
		'add_label' => 'Add a label',	// TODO - Translation
		'delete_label' => 'Delete a label',	// TODO - Translation
		'feed_management' => 'Správa RSS kanálů',
		'rename_label' => 'Rename a label',	// TODO - Translation
		'subscription_tools' => 'Subscription tools',	// TODO - Translation
	),
);

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
		'documentation' => 'Copy the following URL to use it within an external tool.',	// IGNORE
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Drag this button to your bookmarks toolbar or right-click it and choose "Bookmark This Link". Then click the "Subscribe" button in any page you want to subscribe to.',	// IGNORE
		'label' => 'Subscribe',	// IGNORE
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Category',	// IGNORE
		'add' => 'Add a category',	// IGNORE
		'archiving' => 'Archiving',	// IGNORE
		'empty' => 'Empty category',	// IGNORE
		'information' => 'Information',	// IGNORE
		'position' => 'Display position',	// IGNORE
		'position_help' => 'To control category sort order',	// IGNORE
		'title' => 'Title',	// IGNORE
	),
	'feed' => array(
		'add' => 'Add an RSS feed',	// IGNORE
		'advanced' => 'Advanced',	// IGNORE
		'archiving' => 'Archiving',	// IGNORE
		'auth' => array(
			'configuration' => 'Login',	// IGNORE
			'help' => 'Allows access to HTTP protected RSS feeds',	// IGNORE
			'http' => 'HTTP Authentication',	// IGNORE
			'password' => 'HTTP password',	// IGNORE
			'username' => 'HTTP username',	// IGNORE
		),
		'clear_cache' => 'Always clear cache',	// IGNORE
		'content_action' => array(
			'_' => 'Content action when fetching the article content',	// IGNORE
			'append' => 'Add after existing content',	// IGNORE
			'prepend' => 'Add before existing content',	// IGNORE
			'replace' => 'Replace existing content',	// IGNORE
		),
		'css_cookie' => 'Use Cookies when fetching the article content',	// IGNORE
		'css_cookie_help' => 'Example: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',	// IGNORE
		'css_help' => 'Retrieves truncated RSS feeds (caution, requires more time!)',	// IGNORE
		'css_path' => 'Article CSS selector on original website',	// IGNORE
		'description' => 'Description',	// IGNORE
		'empty' => 'This feed is empty. Please verify that it is still maintained.',	// IGNORE
		'error' => 'This feed has encountered a problem. Please verify that it is always reachable then update it.',	// IGNORE
		'filteractions' => array(
			'_' => 'Filter actions',	// IGNORE
			'help' => 'Write one search filter per line.',	// IGNORE
		),
		'information' => 'Information',	// IGNORE
		'keep_min' => 'Minimum number of articles to keep',	// IGNORE
		'kind' => array(
			'_' => 'Type of feed source',	// IGNORE
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'feed title',	// IGNORE
					'help' => 'Example: <code>//title</code>',	// IGNORE
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// IGNORE
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// IGNORE
					'help' => 'Example: <code>//li[@class="news-item"]</code>',	// IGNORE
				),
				'item_author' => array(
					'_' => 'item author',	// IGNORE
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',	// IGNORE
				),
				'item_categories' => 'items tags',	// IGNORE
				'item_content' => array(
					'_' => 'item content',	// IGNORE
					'help' => 'Example: <code>descendant::span[@class="summary"]</code>',	// IGNORE
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// IGNORE
					'help' => 'Example: <code>descendant::img/@src</code>',	// IGNORE
				),
				'item_timestamp' => array(
					'_' => 'item date',	// IGNORE
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime"><code>strtotime()</code></a>',	// IGNORE
				),
				'item_title' => array(
					'_' => 'item title',	// IGNORE
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes">XPath axis</a> <code>descendant::</code>',	// IGNORE
				),
				'item_uri' => array(
					'_' => 'item link (URL)',	// IGNORE
					'help' => 'Example: <code>descendant::a/@href</code>',	// IGNORE
				),
				'relative' => 'XPath (relative to item) for:',	// IGNORE
				'xpath' => 'XPath for:',	// IGNORE
			),
			'rss' => 'RSS / Atom (default)',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Clear cache',	// IGNORE
			'clear_cache_help' => 'Clear the cache for this feed.',	// IGNORE
			'reload_articles' => 'Reload articles',	// IGNORE
			'reload_articles_help' => 'Reload articles and fetch complete content if a selector is defined.',	// IGNORE
			'title' => 'Maintenance',	// IGNORE
		),
		'moved_category_deleted' => 'When you delete a category, its feeds are automatically classified under <em>%s</em>.',	// IGNORE
		'mute' => 'mute',	// IGNORE
		'no_selected' => 'No feed selected.',	// IGNORE
		'number_entries' => '%d articles',	// IGNORE
		'priority' => array(
			'_' => 'Visibility',	// IGNORE
			'archived' => 'Do not show (archived)',	// IGNORE
			'main_stream' => 'Show in main stream',	// IGNORE
			'normal' => 'Show in its category',	// IGNORE
		),
		'proxy' => 'Set a proxy for fetching this feed',	// IGNORE
		'proxy_help' => 'Select a protocol (e.g: SOCKS5) and enter the proxy address (e.g: <kbd>127.0.0.1:1080</kbd>)',	// IGNORE
		'selector_preview' => array(
			'show_raw' => 'Show source code',	// IGNORE
			'show_rendered' => 'Show content',	// IGNORE
		),
		'show' => array(
			'all' => 'Show all feeds',	// IGNORE
			'error' => 'Show only feeds with errors',	// IGNORE
		),
		'showing' => array(
			'error' => 'Showing only feeds with errors',	// IGNORE
		),
		'ssl_verify' => 'Verify SSL security',	// IGNORE
		'stats' => 'Statistics',	// IGNORE
		'think_to_add' => 'You may add some feeds.',	// IGNORE
		'timeout' => 'Timeout in seconds',	// IGNORE
		'title' => 'Title',	// IGNORE
		'title_add' => 'Add an RSS feed',	// IGNORE
		'ttl' => 'Do not automatically refresh more often than',	// IGNORE
		'url' => 'Feed URL',	// IGNORE
		'useragent' => 'Set the user agent for fetching this feed',	// IGNORE
		'useragent_help' => 'Example: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',	// IGNORE
		'validator' => 'Check the validity of the feed',	// IGNORE
		'website' => 'Website URL',	// IGNORE
		'websub' => 'Instant notification with WebSub',	// IGNORE
	),
	'import_export' => array(
		'export' => 'Export',	// IGNORE
		'export_labelled' => 'Export your labeled articles',
		'export_opml' => 'Export list of feeds (OPML)',	// IGNORE
		'export_starred' => 'Export your favorites',
		'feed_list' => 'List of %s articles',	// IGNORE
		'file_to_import' => 'File to import<br />(OPML, JSON or ZIP)',	// IGNORE
		'file_to_import_no_zip' => 'File to import<br />(OPML or JSON)',	// IGNORE
		'import' => 'Import',	// IGNORE
		'starred_list' => 'List of favorite articles',
		'title' => 'Import / export',	// IGNORE
	),
	'menu' => array(
		'add' => 'Add a feed or category',	// IGNORE
		'import_export' => 'Import / export',	// IGNORE
		'label_management' => 'Label management',	// IGNORE
		'stats' => array(
			'idle' => 'Idle feeds',	// IGNORE
			'main' => 'Main statistics',	// IGNORE
			'repartition' => 'Articles repartition',	// IGNORE
		),
		'subscription_management' => 'Subscription management',	// IGNORE
		'subscription_tools' => 'Subscription tools',	// IGNORE
	),
	'tag' => array(
		'name' => 'Name',	// IGNORE
		'new_name' => 'New name',	// IGNORE
		'old_name' => 'Old name',	// IGNORE
	),
	'title' => array(
		'_' => 'Subscription management',	// IGNORE
		'add' => 'Add a feed or category',	// IGNORE
		'add_category' => 'Add a category',	// IGNORE
		'add_feed' => 'Add a feed',	// IGNORE
		'add_label' => 'Add a label',	// IGNORE
		'delete_label' => 'Delete a label',	// IGNORE
		'feed_management' => 'RSS feeds management',	// IGNORE
		'rename_label' => 'Rename a label',	// IGNORE
		'subscription_tools' => 'Subscription tools',	// IGNORE
	),
);

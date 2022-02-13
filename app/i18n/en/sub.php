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
		'documentation' => 'Copy the following URL to use it within an external tool.',
		'title' => 'API',
	),
	'bookmarklet' => array(
		'documentation' => 'Drag this button to your bookmarks toolbar or right-click it and choose "Bookmark This Link". Then click the "Subscribe" button in any page you want to subscribe to.',
		'label' => 'Subscribe',
		'title' => 'Bookmarklet',
	),
	'category' => array(
		'_' => 'Category',
		'add' => 'Add a category',
		'archiving' => 'Archiving',
		'empty' => 'Empty category',
		'information' => 'Information',
		'position' => 'Display position',
		'position_help' => 'To control category sort order',
		'title' => 'Title',
	),
	'feed' => array(
		'add' => 'Add an RSS feed',
		'advanced' => 'Advanced',
		'archiving' => 'Archiving',
		'auth' => array(
			'configuration' => 'Login',
			'help' => 'Allows access to HTTP protected RSS feeds',
			'http' => 'HTTP Authentication',
			'password' => 'HTTP password',
			'username' => 'HTTP username',
		),
		'clear_cache' => 'Always clear cache',
		'content_action' => array(
			'_' => 'Content action when fetching the article content',
			'append' => 'Add after existing content',
			'prepend' => 'Add before existing content',
			'replace' => 'Replace existing content',
		),
		'css_cookie' => 'Use Cookies when fetching the article content',
		'css_cookie_help' => 'Example: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Retrieves truncated RSS feeds (caution, requires more time!)',
		'css_path' => 'Article CSS selector on original website',
		'description' => 'Description',
		'empty' => 'This feed is empty. Please verify that it is still maintained.',
		'error' => 'This feed has encountered a problem. Please verify that it is always reachable then update it.',
		'filteractions' => array(
			'_' => 'Filter actions',
			'help' => 'Write one search filter per line.',
		),
		'information' => 'Information',
		'keep_min' => 'Minimum number of articles to keep',
		'kind' => array(
			'_' => 'Type of feed source',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',
				'feed_title' => array(
					'_' => 'feed title',
					'help' => 'Example: <code>//title</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',
					'help' => 'Example: <code>//li[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'item author',
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',
				),
				'item_categories' => 'items tags',
				'item_content' => array(
					'_' => 'item content',
					'help' => 'Example: <code>descendant::span[@class="summary"]</code>',
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',
					'help' => 'Example: <code>descendant::img/@src</code>',
				),
				'item_timestamp' => array(
					'_' => 'item date',
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'item title',
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes">XPath axis</a> <code>descendant::</code>',
				),
				'item_uri' => array(
					'_' => 'item link (URL)',
					'help' => 'Example: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (relative to item) for:',
				'xpath' => 'XPath for:',
			),
			'rss' => 'RSS / Atom (default)',
		),
		'maintenance' => array(
			'clear_cache' => 'Clear cache',
			'clear_cache_help' => 'Clear the cache for this feed.',
			'reload_articles' => 'Reload articles',
			'reload_articles_help' => 'Reload articles and fetch complete content if a selector is defined.',
			'title' => 'Maintenance',
		),
		'moved_category_deleted' => 'When you delete a category, its feeds are automatically classified under <em>%s</em>.',
		'mute' => 'mute',
		'no_selected' => 'No feed selected.',
		'number_entries' => '%d articles',
		'priority' => array(
			'_' => 'Visibility',
			'archived' => 'Do not show (archived)',
			'main_stream' => 'Show in main stream',
			'normal' => 'Show in its category',
		),
		'proxy' => 'Set a proxy for fetching this feed',
		'proxy_help' => 'Select a protocol (e.g: SOCKS5) and enter the proxy address (e.g: <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Show source code',
			'show_rendered' => 'Show content',
		),
		'show' => array(
			'all' => 'Show all feeds',
			'error' => 'Show only feeds with errors',
		),
		'showing' => array(
			'error' => 'Showing only feeds with errors',
		),
		'ssl_verify' => 'Verify SSL security',
		'stats' => 'Statistics',
		'think_to_add' => 'You may add some feeds.',
		'timeout' => 'Timeout in seconds',
		'title' => 'Title',
		'title_add' => 'Add an RSS feed',
		'ttl' => 'Do not automatically refresh more often than',
		'url' => 'Feed URL',
		'useragent' => 'Set the user agent for fetching this feed',
		'useragent_help' => 'Example: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Check the validity of the feed',
		'website' => 'Website URL',
		'websub' => 'Instant notification with WebSub',
	),
	'import_export' => array(
		'export' => 'Export',
		'export_labelled' => 'Export your labelled articles',
		'export_opml' => 'Export list of feeds (OPML)',
		'export_starred' => 'Export your favourites',
		'feed_list' => 'List of %s articles',
		'file_to_import' => 'File to import<br />(OPML, JSON or ZIP)',
		'file_to_import_no_zip' => 'File to import<br />(OPML or JSON)',
		'import' => 'Import',
		'starred_list' => 'List of favourite articles',
		'title' => 'Import / export',
	),
	'menu' => array(
		'add' => 'Add a feed or category',
		'import_export' => 'Import / export',
		'label_management' => 'Label management',
		'stats' => array(
			'idle' => 'Idle feeds',
			'main' => 'Main statistics',
			'repartition' => 'Articles repartition',
		),
		'subscription_management' => 'Subscription management',
		'subscription_tools' => 'Subscription tools',
	),
	'tag' => array(
		'name' => 'Name',
		'new_name' => 'New name',
		'old_name' => 'Old name',
	),
	'title' => array(
		'_' => 'Subscription management',
		'add' => 'Add a feed or category',
		'add_category' => 'Add a category',
		'add_feed' => 'Add a feed',
		'add_label' => 'Add a label',
		'delete_label' => 'Delete a label',
		'feed_management' => 'RSS feeds management',
		'rename_label' => 'Rename a label',
		'subscription_tools' => 'Subscription tools',
	),
);

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
		'_' => 'קטגוריה',
		'add' => 'Add a category',	// TODO
		'archiving' => 'ארכוב',
		'empty' => 'Empty category',	// TODO
		'information' => 'מידע',
		'position' => 'Display position',	// TODO
		'position_help' => 'To control category sort order',	// TODO
		'title' => 'כותרת',
	),
	'feed' => array(
		'add' => 'הוספת הזנה',
		'advanced' => 'מתקדם',
		'archiving' => 'ארכוב',
		'auth' => array(
			'configuration' => 'כניסה לחשבון',
			'help' => 'החיבור מתיר לגשת להזנות RSS מוגנות',
			'http' => 'HTTP אימות',
			'password' => 'HTTP סיסמה',
			'username' => 'HTTP שם משתמש',
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
		'css_help' => 'קבלת הזנות RSS קטומות	(זהירות, לוקח זמן רב יותר!)',
		'css_path' => 'נתיב הCSS של המאמר באתר המקורי',
		'description' => 'תיאור',
		'empty' => 'הזנה זו ריקה. אנא ודאו שהיא עדיין מתוחזקת.',
		'error' => 'הזנה זו נתקלה בשגיאה, אנא ודאו שהיא תקינה ואז נסו שנית.',
		'filteractions' => array(
			'_' => 'Filter actions',	// TODO
			'help' => 'Write one search filter per line.',	// TODO
		),
		'information' => 'מידע',
		'keep_min' => 'מסםר מינימלי של מאמרים לשמור',
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
			'clear_cache' => 'Clear cache',	// TODO
			'clear_cache_help' => 'Clear the cache for this feed.',	// TODO
			'reload_articles' => 'Reload articles',	// TODO
			'reload_articles_help' => 'Reload articles and fetch complete content if a selector is defined.',	// TODO
			'title' => 'Maintenance',	// TODO
		),
		'moved_category_deleted' => 'כאשר הקטגוריה נמחקת ההזנות שבתוכה אוטומטית מקוטלגות תחת	<em>%s</em>.',
		'mute' => 'mute',	// TODO
		'no_selected' => 'אף הזנה לא נבחרה.',
		'number_entries' => '%d מאמרים',
		'priority' => array(
			'_' => 'Visibility',	// TODO
			'archived' => 'Do not show (archived)',	// TODO
			'main_stream' => 'הצגה בזרם המרכזי',
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
		'stats' => 'סטטיסטיקות',
		'think_to_add' => 'ניתן להוסיף הזנות חדשות.',
		'timeout' => 'Timeout in seconds',	// TODO
		'title' => 'כותרת',
		'title_add' => 'הוספת הזנה',
		'ttl' => 'אין לרענן אוטומטית יותר מ',
		'url' => 'הזנה URL',
		'useragent' => 'Set the user agent for fetching this feed',	// TODO
		'useragent_help' => 'Example: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',	// TODO
		'validator' => 'בדיקות תקינות ההזנה',
		'website' => 'אתר URL',
		'websub' => 'Instant notification with WebSub',	// TODO
	),
	'import_export' => array(
		'export' => 'ייצוא',
		'export_labelled' => 'Export your labelled articles',	// TODO
		'export_opml' => 'ייצוא רשימת הזנות (OPML)',
		'export_starred' => 'ייצוא מועדפים',
		'feed_list' => 'רשימה של %s מאמרים',
		'file_to_import' => 'קובץ לייבוא<br />(OPML, Json or Zip)',
		'file_to_import_no_zip' => 'קובץ לייבוא<br />(OPML or Json)',
		'import' => 'ייבוא',
		'starred_list' => 'רשימת מאמרים מועדפים',
		'title' => 'יבוא / יצוא ',
	),
	'menu' => array(
		'add' => 'Add a feed or category',	// TODO
		'import_export' => 'יבוא / יצוא ',
		'label_management' => 'Label management',	// TODO
		'stats' => array(
			'idle' => 'הזנות שלא עודכנו',
			'main' => 'סטטיסטיקות ראשיות',
			'repartition' => 'חלוקת המאמרים',
		),
		'subscription_management' => 'ניהול הרשמות',
		'subscription_tools' => 'Subscription tools',	// TODO
	),
	'tag' => array(
		'name' => 'Name',	// TODO
		'new_name' => 'New name',	// TODO
		'old_name' => 'Old name',	// TODO
	),
	'title' => array(
		'_' => 'ניהול הרשמות',
		'add' => 'Add a feed or category',	// TODO
		'add_category' => 'Add a category',	// TODO
		'add_feed' => 'Add a feed',	// TODO
		'add_label' => 'Add a label',	// TODO
		'delete_label' => 'Delete a label',	// TODO
		'feed_management' => 'ניהול הזנות RSS',
		'rename_label' => 'Rename a label',	// TODO
		'subscription_tools' => 'Subscription tools',	// TODO
	),
);

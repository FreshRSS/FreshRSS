<?php

return array(
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
		'_' => 'קטגוריה',
		'add' => 'Add a category', // TODO - Translation
		'archiving' => 'ארכוב',
		'empty' => 'Empty category',	// TODO - Translation
		'information' => 'מידע',
		'position' => 'Display position',	// TODO - Translation
		'position_help' => 'To control category sort order',	// TODO - Translation
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
		'clear_cache' => 'Always clear cache',	// TODO - Translation
		'content_action' => array(
			'_' => 'Content action when fetching the article content',	// TODO - Translation
			'append' => 'Add after existing content',	// TODO - Translation
			'prepend' => 'Add before existing content',	// TODO - Translation
			'replace' => 'Replace existing content',	// TODO - Translation
		),
		'css_cookie' => 'Use Cookies when fetching the article content',	// TODO - Translation
		'css_cookie_help' => 'Example: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',	// TODO - Translation
		'css_help' => 'קבלת הזנות RSS קטומות	(זהירות, לוקח זמן רב יותר!)',
		'css_path' => 'נתיב הCSS של המאמר באתר המקורי',
		'description' => 'תיאור',
		'empty' => 'הזנה זו ריקה. אנא ודאו שהיא עדיין מתוחזקת.',
		'error' => 'הזנה זו נתקלה בשגיאה, אנא ודאו שהיא תקינה ואז נסו שנית.',
		'filteractions' => array(
			'_' => 'Filter actions',	// TODO - Translation
			'help' => 'Write one search filter per line.',	// TODO - Translation
		),
		'information' => 'מידע',
		'keep_min' => 'מסםר מינימלי של מאמרים לשמור',
		'maintenance' => array(
			'clear_cache' => 'Clear cache',	// TODO - Translation
			'clear_cache_help' => 'Clear the cache for this feed.',	// TODO - Translation
			'reload_articles' => 'Reload articles',	// TODO - Translation
			'reload_articles_help' => 'Reload articles and fetch complete content if a selector is defined.',	// TODO - Translation
			'title' => 'Maintenance',	// TODO - Translation
		),
		'mute' => 'mute',	// TODO - Translation
		'no_selected' => 'אף הזנה לא נבחרה.',
		'number_entries' => '%d מאמרים',
		'priority' => array(
			'_' => 'Visibility',	// TODO - Translation
			'archived' => 'Do not show (archived)',	// TODO - Translation
			'main_stream' => 'הצגה בזרם המרכזי',
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
		'stats' => 'סטטיסטיקות',
		'think_to_add' => 'ניתן להוסיף הזנות חדשות.',
		'timeout' => 'Timeout in seconds',	// TODO - Translation
		'title' => 'כותרת',
		'title_add' => 'הוספת הזנה',
		'ttl' => 'אין לרענן אוטומטית יותר מ',
		'url' => 'הזנה URL',
		'useragent' => 'Set the user agent for fetching this feed',	// TODO - Translation
		'useragent_help' => 'Example: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',	// TODO - Translation
		'validator' => 'בדיקות תקינות ההזנה',
		'website' => 'אתר URL',
		'websub' => 'Instant notification with WebSub',	// TODO - Translation
	),
	'import_export' => array(
		'export' => 'ייצוא',
		'export_labelled' => 'Export your labelled articles',	// TODO - Translation
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
		'add' => 'Add a feed or category',	// TODO - Translation
		'import_export' => 'יבוא / יצוא ',
		'label_management' => 'Label management',	// TODO - Translation
		'stats' => array(
			'idle' => 'הזנות שלא עודכנו',
			'main' => 'סטטיסטיקות ראשיות',
			'repartition' => 'חלוקת המאמרים',
		),
		'subscription_management' => 'ניהול הרשמות',
		'subscription_tools' => 'Subscription tools',	// TODO - Translation
	),
	'tag' => array(
		'name' => 'Name',	// TODO - Translation
		'new_name' => 'New name',	// TODO - Translation
		'old_name' => 'Old name',	// TODO - Translation
	),
	'title' => array(
		'_' => 'ניהול הרשמות',
		'add' => 'Add a feed or category',	// TODO - Translation
		'add_category' => 'Add a category',	// TODO - Translation
		'add_feed' => 'Add a feed',	// TODO - Translation
		'add_label' => 'Add a label',	// TODO - Translation
		'delete_label' => 'Delete a label',	// TODO - Translation
		'feed_management' => 'ניהול הזנות RSS',
		'rename_label' => 'Rename a label',	// TODO - Translation
		'subscription_tools' => 'Subscription tools',	// TODO - Translation
	),
);

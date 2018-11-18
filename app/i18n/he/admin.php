<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'הרשאה לאנונימיים לקרוא את מאמרי משתמש ברירת המחדל (%s)',
		'allow_anonymous_refresh' => 'הרשאה לאנונימיים לרענן את רשימת המאמרים',
		'api_enabled' => 'הרשאת גישה ל <abbr>API</abbr> <small>(נדרש ליישומים סלולריים)</small>',
		'form' => 'טופס אינטרנטי (מסורתי, דורש JavaScript)',
		'http' => 'HTTP (למשתמשים מתקדמים עם HTTPS)',
		'none' => 'ללא (מסוכן)',
		'title' => 'Authentication', // @todo
		'title_reset' => 'איפוס אימות',
		'token' => 'מחרוזת אימות',
		'token_help' => 'Allows to access RSS output of the default user without authentication:', // @todo
		'type' => 'שיטת אימות',
		'unsafe_autologin' => 'הרשאה להתחברות אוטומטית בפורמט: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'יש לבדוק את ההרשאות בתיקייה <em>%s</em>. שרת הHTTP חייב להיות בעל הרשאות כתיבה.',
			'ok' => 'ההרשאות בתיקיית המטמון תקינות',
		),
		'categories' => array(
			'nok' => 'Category table is bad configured.', // @todo
			'ok' => 'Category table is ok.', // @todo
		),
		'connection' => array(
			'nok' => 'Connection to the database cannot being established.', // @todo
			'ok' => 'Connection to the database is ok.', // @todo
		),
		'ctype' => array(
			'nok' => 'הספרייה הנדרשת ל character type checking (php-ctype) אינה מותקנת',
			'ok' => 'הספרייה הנדרשת ל character type checking (ctype) מותקנת',
		),
		'curl' => array(
			'nok' => 'בURL לא מותקן (php-curl package)',
			'ok' => 'You have cURL extension.', // @todo
		),
		'data' => array(
			'nok' => 'יש לבדוק את ההרשאות בתיקייה <em>%s</em>. שרת הHTTP חייב להיות בעל הרשאות כתיבה.',
			'ok' => 'ההרשאות בתיקיית הדאטא תקינות',
		),
		'database' => 'Database installation', // @todo
		'dom' => array(
			'nok' => 'הספרייה הנדרשת לסיור ב DOM אינה מותקנת  (php-xml package)',
			'ok' => 'הספרייה הנדרשת לסיור ב DOM מותקנת',
		),
		'entries' => array(
			'nok' => 'Entry table is bad configured.', // @todo
			'ok' => 'Entry table is ok.', // @todo
		),
		'favicons' => array(
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have rights to write into', // @todo
			'ok' => 'ההרשאות בתיקיית הfavicons תקינות',
		),
		'feeds' => array(
			'nok' => 'Feed table is bad configured.', // @todo
			'ok' => 'Feed table is ok.', // @todo
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).', // @todo
			'ok' => 'You have the fileinfo library.', // @todo
		),
		'files' => 'File installation', // @todo
		'json' => array(
			'nok' => 'You lack JSON (php-json package).', // @todo
			'ok' => 'You have JSON extension.', // @todo
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	//TODO
			'ok' => 'You have the recommended library mbstring for Unicode.',	//TODO
		),
		'minz' => array(
			'nok' => 'You lack the Minz framework.', // @todo
			'ok' => 'יש לכם את תשתית Minz',
		),
		'pcre' => array(
			'nok' => 'הספרייה הנדרשת לביטויים רגולריים אינה מותקנת (php-pcre)',
			'ok' => 'הספרייה הנדרשת לביטויים רגולריים מותקנת (PCRE)',
		),
		'pdo' => array(
			'nok' => 'PDO אינו מותקן או שאחד ממנהלי ההתקנים שלו חסר (pdo_mysql, pdo_sqlite)',
			'ok' => 'PDO מותקן ולפחות אחד ממנהלי ההתקן הנתמכים מותקן (pdo_mysql, pdo_sqlite)',
		),
		'php' => array(
			'_' => 'PHP installation', // @todo
			'nok' => 'גירסת PHP שלכם היא %s אך FreshRSS דורש לפחות את גירסה %s',
			'ok' => 'גירסת PHP שלכם היא %s, שתואמת ל FreshRSS',
		),
		'tables' => array(
			'nok' => 'There is one or more lacking tables in the database.', // @todo
			'ok' => 'Tables are existing in the database.', // @todo
		),
		'title' => 'Installation checking', // @todo
		'tokens' => array(
			'nok' => 'Check permissions on <em>./data/tokens</em> directory. HTTP server must have rights to write into', // @todo
			'ok' => 'Permissions on tokens directory are good.', // @todo
		),
		'users' => array(
			'nok' => 'Check permissions on <em>./data/users</em> directory. HTTP server must have rights to write into', // @todo
			'ok' => 'Permissions on users directory are good.', // @todo
		),
		'zip' => array(
			'nok' => 'You lack ZIP extension (php-zip package).', // @todo
			'ok' => 'You have ZIP extension.', // @todo
		),
	),
	'extensions' => array(
		'disabled' => 'Disabled', // @todo
		'empty_list' => 'There is no installed extension', // @todo
		'enabled' => 'Enabled', // @todo
		'no_configure_view' => 'This extension cannot be configured.', // @todo
		'system' => array(
			'_' => 'System extensions', // @todo
			'no_rights' => 'System extension (you have no rights on it)', // @todo
		),
		'title' => 'Extensions', // @todo
		'user' => 'User extensions', // @todo
		'community' => 'Available community extensions', // @todo
		'name' => 'Name', // @todo
		'version' => 'Version', // @todo
		'description' => 'Description', // @todo
		'author' => 'Author', // @todo
		'latest' => 'Installed', // @todo
		'update' => 'Update available', // @todo
	),
	'stats' => array(
		'_' => 'סטטיסטיקות',
		'all_feeds' => 'כל ההזנות',
		'category' => 'קטגוריה',
		'entry_count' => 'סכום המאמרים',
		'entry_per_category' => 'מאמרים על פי קטגוריה',
		'entry_per_day' => 'מספר מאמרים ליום (30 ימים אחרונים)',
		'entry_per_day_of_week' => 'Per day of week (average: %.2f messages)', // @todo
		'entry_per_hour' => 'Per hour (average: %.2f messages)', // @todo
		'entry_per_month' => 'Per month (average: %.2f messages)', // @todo
		'entry_repartition' => 'חלוקת המאמרים',
		'feed' => 'הזנה',
		'feed_per_category' => 'הזנות על פי קטגוריה',
		'idle' => 'הזנות שלא עודכנו',
		'main' => 'סטטיסטיקות ראשיות',
		'main_stream' => 'הזנה ראשית',
		'menu' => array(
			'idle' => 'הזנות שלא עודכנו',
			'main' => 'סטטיסטיקות ראשיות',
			'repartition' => 'חלוקת המאמרים',
		),
		'no_idle' => 'אין הזנות מובטלות!',
		'number_entries' => '%d מאמרים',
		'percent_of_total' => '%% מסך הכל',
		'repartition' => 'חלוקת המאמרים',
		'status_favorites' => 'מועדפים',
		'status_read' => 'נקרא',
		'status_total' => 'סך הכל',
		'status_unread' => 'לא נקרא',
		'title' => 'סטטיסטיקות',
		'top_feed' => 'עשרת ההזנות המובילות',
	),
	'system' => array(
		'_' => 'System configuration', // @todo
		'auto-update-url' => 'Auto-update server URL', // @todo
		'instance-name' => 'Instance name', // @todo
		'max-categories' => 'Categories per user limit', // @todo
		'max-feeds' => 'Feeds per user limit', // @todo
		'cookie-duration' => array(
			'help' => 'in seconds', // @todo translate
			'number' => 'Duration to keep logged in', // @todo translate
		),
		'registration' => array(
			'help' => '0 means that there is no account limit', // @todo
			'number' => 'Max number of accounts', // @todo
		),
	),
	'update' => array(
		'_' => 'מערכת העדכון',
		'apply' => 'החלת העדכון',
		'check' => 'בדיקת עדכונים חדשים',
		'current_version' => 'Your current version of FreshRSS is the %s.', // @todo
		'last' => 'תאריך בדיקה אחרון: %s',
		'none' => 'אין עדכון להחלה',
		'title' => 'מערכת העדכון',
	),
	'user' => array(
		'articles_and_size' => '%s articles (%s)', // @todo
		'create' => 'יצירת משתמש חדש',
		'delete_users' => 'Delete user', // TODO
		'language' => 'שפה',
		'number' => 'There is %d account created', // @todo
		'numbers' => 'There are %d accounts created', // @todo
		'password_form' => 'סיסמה<br /><small>(לשימוש בטפוס ההרשמה)</small>',
		'password_format' => 'At least 7 characters', // @todo
		'selected' => 'Selected user', // TODO
		'title' => 'Manage users', // @todo
		'update_users' => 'Update user', // TODO
		'user_list' => 'רשימת משתמשים',
		'username' => 'שם משתמש',
		'users' => 'משתמשים',
	),
);

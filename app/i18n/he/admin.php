<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

return array(
	'auth' => array(
		'allow_anonymous' => 'הרשאה לאנונימיים לקרוא את מאמרי משתמש ברירת המחדל (%s)',
		'allow_anonymous_refresh' => 'הרשאה לאנונימיים לרענן את רשימת המאמרים',
		'api_enabled' => 'הרשאת גישה ל <abbr>API</abbr> <small>(נדרש ליישומים סלולריים and sharing user queries)</small>',	// DIRTY
		'form' => 'טופס אינטרנטי (מסורתי, דורש JavaScript)',
		'http' => 'HTTP (advanced: managed by Web server, OIDC, SSO…)',	// TODO
		'none' => 'ללא (מסוכן)',
		'title' => 'Authentication',	// TODO
		'token' => 'Master authentication token',	// TODO
		'token_help' => 'Allows access to all RSS outputs of the user as well as refreshing feeds without authentication:',	// TODO
		'type' => 'שיטת אימות',
	),
	'extensions' => array(
		'author' => 'Author',	// TODO
		'community' => 'Available community extensions',	// TODO
		'description' => 'Description',	// TODO
		'disabled' => 'Disabled',	// TODO
		'empty_list' => 'There is no installed extension',
		'empty_list_help' => 'Check the logs to determine the reason behind the empty extension list.',	// TODO
		'enabled' => 'Enabled',	// TODO
		'is_compatible' => 'Is compatible',	// TODO
		'latest' => 'Installed',	// TODO
		'name' => 'Name',	// TODO
		'no_configure_view' => 'This extension cannot be configured.',	// TODO
		'system' => array(
			'_' => 'System extensions',	// TODO
			'no_rights' => 'System extension (you do not have the required permissions)',	// TODO
		),
		'title' => 'Extensions',	// TODO
		'update' => 'Update available',	// TODO
		'user' => 'User extensions',	// TODO
		'version' => 'Version',	// TODO
	),
	'stats' => array(
		'_' => 'סטטיסטיקות',
		'all_feeds' => 'כל ההזנות',
		'category' => 'קטגוריה',
		'date_published' => 'Publication date',	// TODO
		'date_received' => 'Received date',	// TODO
		'entry_count' => 'סכום המאמרים',
		'entry_per_category' => 'מאמרים על פי קטגוריה',
		'entry_per_day' => 'מספר מאמרים ליום (30 ימים אחרונים)',
		'entry_per_day_of_week' => 'Per day of week (average: %.2f messages)',	// TODO
		'entry_per_hour' => 'Per hour (average: %.2f messages)',	// TODO
		'entry_per_month' => 'Per month (average: %.2f messages)',	// TODO
		'entry_repartition' => 'חלוקת המאמרים',
		'feed' => 'הזנה',
		'feed_per_category' => 'הזנות על פי קטגוריה',
		'idle' => 'הזנות שלא עודכנו',
		'main' => 'סטטיסטיקות ראשיות',
		'main_stream' => 'הזנה ראשית',
		'nb_unreads' => 'Number of unread articles',	// TODO
		'no_idle' => 'אין הזנות מובטלות!',
		'number_entries' => '%d מאמרים',
		'overview' => 'Overview',	// TODO
		'percent_of_total' => '% מסך הכל',
		'repartition' => 'חלוקת המאמרים: %s',	// DIRTY
		'status_favorites' => 'מועדפים',
		'status_read' => 'נקרא',
		'status_total' => 'סך הכל',
		'status_unread' => 'לא נקרא',
		'title' => 'סטטיסטיקות',
		'top_feed' => 'עשרת ההזנות המובילות',
		'unread_dates' => 'Dates with most unread articles',	// TODO
	),
	'system' => array(
		'_' => 'System configuration',	// TODO
		'auto-update-url' => 'Auto-update server URL',	// TODO
		'base-url' => array(
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => 'in seconds',	// TODO
			'number' => 'Duration to keep logged in',	// TODO
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
		'force_email_validation' => 'Force email address validation',	// TODO
		'instance-name' => 'Instance name',	// TODO
		'max-categories' => 'Max number of categories per user',	// TODO
		'max-feeds' => 'Max number of feeds per user',	// TODO
		'registration' => array(
			'number' => 'Max number of accounts',	// TODO
			'select' => array(
				'label' => 'Registration form',	// TODO
				'option' => array(
					'noform' => 'Disabled: No registration form',	// TODO
					'nolimit' => 'Enabled: No limit of accounts',	// TODO
					'setaccountsnumber' => 'Set max. number of accounts',	// TODO
				),
			),
			'status' => array(
				'disabled' => 'Form disabled',	// TODO
				'enabled' => 'Form enabled',	// TODO
			),
			'title' => 'User registration form',	// TODO
		),
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => array(
			'disabled' => 'is not given',	// TODO
			'enabled' => '<a href="./?a=tos">is enabled</a>',	// TODO
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">enable the Terms of Service</a>',	// TODO
		),
		'websub' => array(
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		),
	),
	'update' => array(
		'_' => 'מערכת העדכון',
		'apply' => 'החלת העדכון',
		'changelog' => 'Changelog',	// TODO
		'check' => 'בדיקת עדכונים חדשים',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => 'Current installed version',	// TODO
		'last' => 'תאריך בדיקה אחרון',
		'loading' => 'Updating…',	// TODO
		'none' => 'אין עדכון להחלה',
		'releaseChannel' => array(
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		),
		'title' => 'מערכת העדכון',
		'viaGit' => 'Update via git and GitHub.com started',	// TODO
	),
	'user' => array(
		'admin' => 'Administrator',	// TODO
		'article_count' => 'Articles',	// TODO
		'back_to_manage' => '← Return to user list',	// TODO
		'create' => 'יצירת משתמש חדש',
		'database_size' => 'Database size',	// TODO
		'email' => 'Email address',	// TODO
		'enabled' => 'Enabled',	// TODO
		'feed_count' => 'Feeds',	// TODO
		'is_admin' => 'Is admin',	// TODO
		'language' => 'שפה',
		'last_user_activity' => 'Last user activity',	// TODO
		'list' => 'User list',	// TODO
		'number' => 'There is %d account created',	// TODO
		'numbers' => 'There are %d accounts created',	// TODO
		'password_form' => 'סיסמה<br /><small>(לשימוש בטפוס ההרשמה)</small>',
		'password_format' => 'At least 7 characters',	// TODO
		'title' => 'Manage users',	// TODO
		'username' => 'שם משתמש',
	),
);

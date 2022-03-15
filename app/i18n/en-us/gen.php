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
	'action' => array(
		'actualize' => 'Update feeds',	// IGNORE
		'add' => 'Add',	// IGNORE
		'back' => '← Go back',	// IGNORE
		'back_to_rss_feeds' => '← Go back to your RSS feeds',	// IGNORE
		'cancel' => 'Cancel',	// IGNORE
		'create' => 'Create',	// IGNORE
		'demote' => 'Demote',	// IGNORE
		'disable' => 'Disable',	// IGNORE
		'empty' => 'Empty',	// IGNORE
		'enable' => 'Enable',	// IGNORE
		'export' => 'Export',	// IGNORE
		'filter' => 'Filter',	// IGNORE
		'import' => 'Import',	// IGNORE
		'load_default_shortcuts' => 'Load default shortcuts',	// IGNORE
		'manage' => 'Manage',	// IGNORE
		'mark_read' => 'Mark as read',	// IGNORE
		'open_url' => 'Open URL',	// IGNORE
		'promote' => 'Promote',	// IGNORE
		'purge' => 'Purge',	// IGNORE
		'remove' => 'Remove',	// IGNORE
		'rename' => 'Rename',	// IGNORE
		'see_website' => 'See website',	// IGNORE
		'submit' => 'Submit',	// IGNORE
		'truncate' => 'Delete all articles',	// IGNORE
		'update' => 'Update',	// IGNORE
	),
	'auth' => array(
		'accept_tos' => 'I accept the <a href="%s">Terms of Service</a>.',	// IGNORE
		'email' => 'Email address',	// IGNORE
		'keep_logged_in' => 'Keep me logged in <small>(%s days)</small>',	// IGNORE
		'login' => 'Login',	// IGNORE
		'logout' => 'Logout',	// IGNORE
		'password' => array(
			'_' => 'Password',	// IGNORE
			'format' => '<small>At least 7 characters</small>',	// IGNORE
		),
		'registration' => array(
			'_' => 'New account',	// IGNORE
			'ask' => 'Create an account?',	// IGNORE
			'title' => 'Account creation',	// IGNORE
		),
		'username' => array(
			'_' => 'Username',	// IGNORE
			'format' => '<small>Maximum 16 alphanumeric characters</small>',	// IGNORE
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\i\\l',	// IGNORE
		'Aug' => '\\A\\u\\g\\u\\s\\t',	// IGNORE
		'Dec' => '\\D\\e\\c\\e\\m\\b\\e\\r',	// IGNORE
		'Feb' => '\\F\\e\\b\\r\\u\\a\\r\\y',	// IGNORE
		'Jan' => '\\J\\a\\n\\u\\a\\r\\y',	// IGNORE
		'Jul' => '\\J\\u\\l\\y',	// IGNORE
		'Jun' => '\\J\\u\\n\\e',	// IGNORE
		'Mar' => '\\M\\a\\r\\c\\h',	// IGNORE
		'May' => '\\M\\a\\y',	// IGNORE
		'Nov' => '\\N\\o\\v\\e\\m\\b\\e\\r',	// IGNORE
		'Oct' => '\\O\\c\\t\\o\\b\\e\\r',	// IGNORE
		'Sep' => '\\S\\e\\p\\t\\e\\m\\b\\e\\r',	// IGNORE
		'apr' => 'Apr.',	// IGNORE
		'april' => 'April',	// IGNORE
		'aug' => 'Aug.',	// IGNORE
		'august' => 'August',	// IGNORE
		'before_yesterday' => 'Before yesterday',	// IGNORE
		'dec' => 'Dec.',	// IGNORE
		'december' => 'December',	// IGNORE
		'feb' => 'Feb.',	// IGNORE
		'february' => 'February',	// IGNORE
		'format_date' => '%s j\\<\\s\\u\\p\\>S\\<\\/\\s\\u\\p\\> Y',
		'format_date_hour' => '%s j\\<\\s\\u\\p\\>S\\<\\/\\s\\u\\p\\> Y \\a\\t g\\:i a',
		'fri' => 'Fri',	// IGNORE
		'jan' => 'Jan.',	// IGNORE
		'january' => 'January',	// IGNORE
		'jul' => 'July',	// IGNORE
		'july' => 'July',	// IGNORE
		'jun' => 'June',	// IGNORE
		'june' => 'June',	// IGNORE
		'last_2_year' => 'Last two years',	// IGNORE
		'last_3_month' => 'Last three months',	// IGNORE
		'last_3_year' => 'Last three years',	// IGNORE
		'last_5_year' => 'Last five years',	// IGNORE
		'last_6_month' => 'Last six months',	// IGNORE
		'last_month' => 'Last month',	// IGNORE
		'last_week' => 'Last week',	// IGNORE
		'last_year' => 'Last year',	// IGNORE
		'mar' => 'Mar.',	// IGNORE
		'march' => 'March',	// IGNORE
		'may' => 'May',	// IGNORE
		'may_' => 'May',	// IGNORE
		'mon' => 'Mon',	// IGNORE
		'month' => 'months',	// IGNORE
		'nov' => 'Nov.',	// IGNORE
		'november' => 'November',	// IGNORE
		'oct' => 'Oct.',	// IGNORE
		'october' => 'October',	// IGNORE
		'sat' => 'Sat',	// IGNORE
		'sep' => 'Sept.',	// IGNORE
		'september' => 'September',	// IGNORE
		'sun' => 'Sun',	// IGNORE
		'thu' => 'Thu',	// IGNORE
		'today' => 'Today',	// IGNORE
		'tue' => 'Tue',	// IGNORE
		'wed' => 'Wed',	// IGNORE
		'yesterday' => 'Yesterday',	// IGNORE
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'About FreshRSS',	// IGNORE
	),
	'js' => array(
		'category_empty' => 'Empty category',	// IGNORE
		'confirm_action' => 'Are you sure you want to perform this action? It cannot be canceled!',
		'confirm_action_feed_cat' => 'Are you sure you want to perform this action? You will lose related favorites and user queries. It cannot be canceled!',
		'feedback' => array(
			'body_new_articles' => 'There are %%d new articles to read on FreshRSS.',	// IGNORE
			'body_unread_articles' => '(unread: %%d)',	// IGNORE
			'request_failed' => 'A request has failed, it may have been caused by internet connection problems.',	// IGNORE
			'title_new_articles' => 'FreshRSS: new articles!',	// IGNORE
		),
		'new_article' => 'There are new articles available, click to refresh the page.',	// IGNORE
		'should_be_activated' => 'JavaScript must be enabled',	// IGNORE
	),
	'lang' => array(
		'cz' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'About',	// IGNORE
		'account' => 'Account',	// IGNORE
		'admin' => 'Administration',	// IGNORE
		'archiving' => 'Archiving',	// IGNORE
		'authentication' => 'Authentication',	// IGNORE
		'check_install' => 'Installation check',	// IGNORE
		'configuration' => 'Configuration',	// IGNORE
		'display' => 'Display',	// IGNORE
		'extensions' => 'Extensions',	// IGNORE
		'logs' => 'Logs',	// IGNORE
		'queries' => 'User queries',	// IGNORE
		'reading' => 'Reading',	// IGNORE
		'search' => 'Search words or #tags',	// IGNORE
		'sharing' => 'Sharing',	// IGNORE
		'shortcuts' => 'Shortcuts',	// IGNORE
		'stats' => 'Statistics',	// IGNORE
		'system' => 'System configuration',	// IGNORE
		'update' => 'Update',	// IGNORE
		'user_management' => 'Manage users',	// IGNORE
		'user_profile' => 'Profile',	// IGNORE
	),
	'period' => array(
		'days' => 'days',	// IGNORE
		'hours' => 'hours',	// IGNORE
		'months' => 'months',	// IGNORE
		'weeks' => 'weeks',	// IGNORE
		'years' => 'years',	// IGNORE
	),
	'share' => array(
		'Known' => 'Known based sites',	// IGNORE
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Clipboard',	// IGNORE
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Print',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Default system sharing',	// TODO
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Warning!',	// IGNORE
		'blank_to_disable' => 'Leave blank to disable',	// IGNORE
		'by_author' => 'By:',	// IGNORE
		'by_default' => 'By default',	// IGNORE
		'damn' => 'Blast!',	// IGNORE
		'default_category' => 'Uncategorized',	// IGNORE
		'no' => 'No',	// IGNORE
		'not_applicable' => 'Not available',	// IGNORE
		'ok' => 'Okay!',	// IGNORE
		'or' => 'or',	// IGNORE
		'yes' => 'Yes',	// IGNORE
	),
	'stream' => array(
		'load_more' => 'Load more articles',	// IGNORE
		'mark_all_read' => 'Mark all as read',	// IGNORE
		'nothing_to_load' => 'There are no more articles',	// IGNORE
	),
);

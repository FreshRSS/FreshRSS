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
		'actualize' => 'Update feeds',	// TODO
		'add' => 'Add',	// TODO
		'back' => '← Go back',	// TODO
		'back_to_rss_feeds' => '← Go back to your RSS feeds',	// TODO
		'cancel' => 'Cancel',	// TODO
		'create' => 'Create',	// TODO
		'delete_muted_feeds' => 'Delete muted feeds',	// TODO
		'demote' => 'Demote',	// TODO
		'disable' => 'Disable',	// TODO
		'empty' => 'Empty',	// TODO
		'enable' => 'Enable',	// TODO
		'export' => 'Export',	// TODO
		'filter' => 'Filter',	// TODO
		'import' => 'Import',	// TODO
		'load_default_shortcuts' => 'Load default shortcuts',	// TODO
		'manage' => 'Manage',	// TODO
		'mark_read' => 'Mark as read',	// TODO
		'menu' => array(
			'open' => 'Open menu',	// TODO
		),
		'nav_buttons' => array(
			'next' => 'Next article',	// TODO
			'prev' => 'Previous article',	// TODO
			'up' => 'Go up',	// TODO
		),
		'open_url' => 'Open URL',	// TODO
		'promote' => 'Promote',	// TODO
		'purge' => 'Purge',	// TODO
		'refresh_opml' => 'Refresh OPML',	// TODO
		'remove' => 'Remove',	// TODO
		'rename' => 'Rename',	// TODO
		'see_website' => 'See website',	// TODO
		'submit' => 'Submit',	// TODO
		'truncate' => 'Delete all articles',	// TODO
		'update' => 'Update',	// TODO
	),
	'auth' => array(
		'accept_tos' => 'I accept the <a href="%s">Terms of Service</a>.',	// TODO
		'email' => 'Email address',	// TODO
		'keep_logged_in' => 'Keep me logged in <small>(%s days)</small>',	// DIRTY
		'login' => 'Login',	// TODO
		'logout' => 'Logout',	// TODO
		'password' => array(
			'_' => 'Password',	// TODO
			'format' => '<small>At least 7 characters</small>',	// TODO
		),
		'registration' => array(
			'_' => 'New account',	// TODO
			'ask' => 'Create an account?',	// TODO
			'title' => 'Account creation',	// TODO
		),
		'username' => array(
			'_' => 'Username',	// TODO
			'format' => '<small>Maximum 16 alphanumeric characters</small>',	// TODO
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\i\\l',	// TODO
		'Aug' => '\\A\\u\\g\\u\\s\\t',	// TODO
		'Dec' => '\\D\\e\\c\\e\\m\\b\\e\\r',	// TODO
		'Feb' => '\\F\\e\\b\\r\\u\\a\\r\\y',	// TODO
		'Jan' => '\\J\\a\\n\\u\\a\\r\\y',	// TODO
		'Jul' => '\\J\\u\\l\\y',	// TODO
		'Jun' => '\\J\\u\\n\\e',	// TODO
		'Mar' => '\\M\\a\\r\\c\\h',	// TODO
		'May' => '\\M\\a\\y',	// TODO
		'Nov' => '\\N\\o\\v\\e\\m\\b\\e\\r',	// TODO
		'Oct' => '\\O\\c\\t\\o\\b\\e\\r',	// TODO
		'Sep' => '\\S\\e\\p\\t\\e\\m\\b\\e\\r',	// TODO
		'apr' => 'Apr.',	// TODO
		'april' => 'April',	// TODO
		'aug' => 'Aug.',	// TODO
		'august' => 'August',	// TODO
		'before_yesterday' => 'Before yesterday',	// TODO
		'dec' => 'Dec.',	// TODO
		'december' => 'December',	// TODO
		'feb' => 'Feb.',	// TODO
		'february' => 'February',	// TODO
		'format_date' => '%s j\\<\\s\\u\\p\\>S\\<\\/\\s\\u\\p\\> Y',
		'format_date_hour' => '%s j\\<\\s\\u\\p\\>S\\<\\/\\s\\u\\p\\> Y \\a\\t g\\:i a',
		'fri' => 'Fri',	// TODO
		'jan' => 'Jan.',	// TODO
		'january' => 'January',	// TODO
		'jul' => 'July',	// TODO
		'july' => 'July',	// TODO
		'jun' => 'June',	// TODO
		'june' => 'June',	// TODO
		'last_2_year' => 'Last two years',	// TODO
		'last_3_month' => 'Last three months',	// TODO
		'last_3_year' => 'Last three years',	// TODO
		'last_5_year' => 'Last five years',	// TODO
		'last_6_month' => 'Last six months',	// TODO
		'last_month' => 'Last month',	// TODO
		'last_week' => 'Last week',	// TODO
		'last_year' => 'Last year',	// TODO
		'mar' => 'Mar.',	// TODO
		'march' => 'March',	// TODO
		'may' => 'May',	// TODO
		'may_' => 'May',	// TODO
		'mon' => 'Mon',	// TODO
		'month' => 'months',	// TODO
		'nov' => 'Nov.',	// TODO
		'november' => 'November',	// TODO
		'oct' => 'Oct.',	// TODO
		'october' => 'October',	// TODO
		'sat' => 'Sat',	// TODO
		'sep' => 'Sept.',	// TODO
		'september' => 'September',	// TODO
		'sun' => 'Sun',	// TODO
		'thu' => 'Thu',	// TODO
		'today' => 'Today',	// TODO
		'tue' => 'Tue',	// TODO
		'wed' => 'Wed',	// TODO
		'yesterday' => 'Yesterday',	// TODO
	),
	'dir' => 'ltr',	// TODO
	'freshrss' => array(
		'_' => 'FreshRSS',	// TODO
		'about' => 'About FreshRSS',	// TODO
	),
	'js' => array(
		'category_empty' => 'Empty category',	// TODO
		'confirm_action' => 'Are you sure you want to perform this action? It cannot be canceled!',
		'confirm_action_feed_cat' => 'Are you sure you want to perform this action? You will lose related favorites and user queries. It cannot be canceled!',
		'feedback' => array(
			'body_new_articles' => 'There are %%d new articles to read on FreshRSS.',	// TODO
			'body_unread_articles' => '(unread: %%d)',	// TODO
			'request_failed' => 'A request has failed, it may have been caused by internet connection problems.',	// TODO
			'title_new_articles' => 'FreshRSS: new articles!',	// TODO
		),
		'labels_empty' => 'No labels',	// TODO
		'new_article' => 'There are new articles available, click to refresh the page.',	// TODO
		'should_be_activated' => 'JavaScript must be enabled',	// TODO
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
		'zh-tw' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'About',	// TODO
		'account' => 'Account',	// TODO
		'admin' => 'Administration',	// TODO
		'archiving' => 'Archiving',	// TODO
		'authentication' => 'Authentication',	// TODO
		'check_install' => 'Installation check',	// TODO
		'configuration' => 'Configuration',	// TODO
		'display' => 'Display',	// TODO
		'extensions' => 'Extensions',	// TODO
		'logs' => 'Logs',	// TODO
		'queries' => 'User queries',	// TODO
		'reading' => 'Reading',	// TODO
		'search' => 'Search words or #tags',	// TODO
		'search_help' => 'See documentation for advanced <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">search parameters</a>',	// TODO
		'sharing' => 'Sharing',	// TODO
		'shortcuts' => 'Shortcuts',	// TODO
		'stats' => 'Statistics',	// TODO
		'system' => 'System configuration',	// TODO
		'update' => 'Update',	// TODO
		'user_management' => 'Manage users',	// TODO
		'user_profile' => 'Profile',	// TODO
	),
	'period' => array(
		'days' => 'days',	// TODO
		'hours' => 'hours',	// TODO
		'months' => 'months',	// TODO
		'weeks' => 'weeks',	// TODO
		'years' => 'years',	// TODO
	),
	'share' => array(
		'Known' => 'Known based sites',	// TODO
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// TODO
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Clipboard',	// TODO
		'diaspora' => 'Diaspora*',	// TODO
		'email' => 'Email',	// TODO
		'email-webmail-firefox-fix' => 'Email (webmail - fix for Firefox)',	// TODO
		'facebook' => 'Facebook',	// TODO
		'gnusocial' => 'GNU social',	// TODO
		'jdh' => 'Journal du hacker',	// TODO
		'lemmy' => 'Lemmy',	// TODO
		'linkding' => 'Linkding',	// TODO
		'linkedin' => 'LinkedIn',	// TODO
		'mastodon' => 'Mastodon',	// TODO
		'movim' => 'Movim',	// TODO
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// TODO
		'pinterest' => 'Pinterest',	// TODO
		'pocket' => 'Pocket',	// TODO
		'print' => 'Print',	// TODO
		'raindrop' => 'Raindrop.io',	// TODO
		'reddit' => 'Reddit',	// TODO
		'shaarli' => 'Shaarli',	// TODO
		'twitter' => 'Twitter',	// TODO
		'wallabag' => 'wallabag v1',	// TODO
		'wallabagv2' => 'wallabag v2',	// TODO
		'web-sharing-api' => 'System sharing',	// TODO
		'whatsapp' => 'Whatsapp',	// TODO
		'xing' => 'Xing',	// TODO
	),
	'short' => array(
		'attention' => 'Warning!',	// TODO
		'blank_to_disable' => 'Leave blank to disable',	// TODO
		'by_author' => 'By:',	// TODO
		'by_default' => 'By default',	// TODO
		'damn' => 'Blast!',	// TODO
		'default_category' => 'Uncategorized',	// TODO
		'no' => 'No',	// TODO
		'not_applicable' => 'Not available',	// TODO
		'ok' => 'Okay!',	// TODO
		'or' => 'or',	// TODO
		'yes' => 'Yes',	// TODO
	),
	'stream' => array(
		'load_more' => 'Load more articles',	// TODO
		'mark_all_read' => 'Mark all as read',	// TODO
		'nothing_to_load' => 'There are no more articles',	// TODO
	),
);

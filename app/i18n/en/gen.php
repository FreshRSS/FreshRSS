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
		'actualize' => 'Update feeds',
		'add' => 'Add',
		'back' => '← Go back',
		'back_to_rss_feeds' => '← Go back to your RSS feeds',
		'cancel' => 'Cancel',
		'create' => 'Create',
		'delete_muted_feeds' => 'Delete muted feeds',
		'demote' => 'Demote',
		'disable' => 'Disable',
		'empty' => 'Empty',
		'enable' => 'Enable',
		'export' => 'Export',
		'filter' => 'Filter',
		'import' => 'Import',
		'load_default_shortcuts' => 'Load default shortcuts',
		'manage' => 'Manage',
		'mark_read' => 'Mark as read',
		'open_url' => 'Open URL',
		'promote' => 'Promote',
		'purge' => 'Purge',
		'refresh_opml' => 'Refresh OPML',
		'remove' => 'Remove',
		'rename' => 'Rename',
		'see_website' => 'See website',
		'submit' => 'Submit',
		'truncate' => 'Delete all articles',
		'update' => 'Update',
	),
	'auth' => array(
		'accept_tos' => 'I accept the <a href="%s">Terms of Service</a>.',
		'email' => 'Email address',
		'keep_logged_in' => 'Keep me logged in <small>(%s days)</small>',
		'login' => 'Login',
		'logout' => 'Logout',
		'password' => array(
			'_' => 'Password',
			'format' => '<small>At least 7 characters</small>',
		),
		'registration' => array(
			'_' => 'New account',
			'ask' => 'Create an account?',
			'title' => 'Account creation',
		),
		'username' => array(
			'_' => 'Username',
			'format' => '<small>Maximum 16 alphanumeric characters</small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\i\\l',
		'Aug' => '\\A\\u\\g\\u\\s\\t',
		'Dec' => '\\D\\e\\c\\e\\m\\b\\e\\r',
		'Feb' => '\\F\\e\\b\\r\\u\\a\\r\\y',
		'Jan' => '\\J\\a\\n\\u\\a\\r\\y',
		'Jul' => '\\J\\u\\l\\y',
		'Jun' => '\\J\\u\\n\\e',
		'Mar' => '\\M\\a\\r\\c\\h',
		'May' => '\\M\\a\\y',
		'Nov' => '\\N\\o\\v\\e\\m\\b\\e\\r',
		'Oct' => '\\O\\c\\t\\o\\b\\e\\r',
		'Sep' => '\\S\\e\\p\\t\\e\\m\\b\\e\\r',
		'apr' => 'Apr.',
		'april' => 'April',
		'aug' => 'Aug.',
		'august' => 'August',
		'before_yesterday' => 'Before yesterday',
		'dec' => 'Dec.',
		'december' => 'December',
		'feb' => 'Feb.',
		'february' => 'February',
		'format_date' => 'j %s Y',
		'format_date_hour' => 'j %s Y \\a\\t H\\:i',
		'fri' => 'Fri',
		'jan' => 'Jan.',
		'january' => 'January',
		'jul' => 'July',
		'july' => 'July',
		'jun' => 'June',
		'june' => 'June',
		'last_2_year' => 'Last two years',
		'last_3_month' => 'Last three months',
		'last_3_year' => 'Last three years',
		'last_5_year' => 'Last five years',
		'last_6_month' => 'Last six months',
		'last_month' => 'Last month',
		'last_week' => 'Last week',
		'last_year' => 'Last year',
		'mar' => 'Mar.',
		'march' => 'March',
		'may' => 'May',
		'may_' => 'May',
		'mon' => 'Mon',
		'month' => 'months',
		'nov' => 'Nov.',
		'november' => 'November',
		'oct' => 'Oct.',
		'october' => 'October',
		'sat' => 'Sat',
		'sep' => 'Sept.',
		'september' => 'September',
		'sun' => 'Sun',
		'thu' => 'Thu',
		'today' => 'Today',
		'tue' => 'Tue',
		'wed' => 'Wed',
		'yesterday' => 'Yesterday',
	),
	'dir' => 'ltr',
	'freshrss' => array(
		'_' => 'FreshRSS',
		'about' => 'About FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Empty category',
		'confirm_action' => 'Are you sure you want to perform this action? It cannot be cancelled!',
		'confirm_action_feed_cat' => 'Are you sure you want to perform this action? You will lose related favourites and user queries. It cannot be cancelled!',
		'feedback' => array(
			'body_new_articles' => 'There are %%d new articles to read on FreshRSS.',
			'body_unread_articles' => '(unread: %%d)',
			'request_failed' => 'A request has failed, it may have been caused by internet connection problems.',
			'title_new_articles' => 'FreshRSS: new articles!',
		),
		'new_article' => 'There are new articles available, click to refresh the page.',
		'should_be_activated' => 'JavaScript must be enabled',
	),
	'lang' => array(
		'cz' => 'Čeština',
		'de' => 'Deutsch',
		'en' => 'English',
		'en-us' => 'English (United States)',
		'es' => 'Español',
		'fr' => 'Français',
		'he' => 'עברית',
		'id' => 'Bahasa Indonesia',
		'it' => 'Italiano',
		'ja' => '日本語',
		'ko' => '한국어',
		'nl' => 'Nederlands',
		'oc' => 'Occitan',
		'pl' => 'Polski',
		'pt-br' => 'Português (Brasil)',
		'ru' => 'Русский',
		'sk' => 'Slovenčina',
		'tr' => 'Türkçe',
		'zh-cn' => '简体中文',
		'zh-tw' => '正體中文',
	),
	'menu' => array(
		'about' => 'About',
		'account' => 'Account',
		'admin' => 'Administration',
		'archiving' => 'Archiving',
		'authentication' => 'Authentication',
		'check_install' => 'Installation check',
		'configuration' => 'Configuration',
		'display' => 'Display',
		'extensions' => 'Extensions',
		'logs' => 'Logs',
		'queries' => 'User queries',
		'reading' => 'Reading',
		'search' => 'Search words or #tags',
		'sharing' => 'Sharing',
		'shortcuts' => 'Shortcuts',
		'stats' => 'Statistics',
		'system' => 'System configuration',
		'update' => 'Update',
		'user_management' => 'Manage users',
		'user_profile' => 'Profile',
	),
	'period' => array(
		'days' => 'days',
		'hours' => 'hours',
		'months' => 'months',
		'weeks' => 'weeks',
		'years' => 'years',
	),
	'share' => array(
		'Known' => 'Known based sites',
		'archivePH' => 'archive.ph',
		'blogotext' => 'Blogotext',
		'clipboard' => 'Clipboard',
		'diaspora' => 'Diaspora*',
		'email' => 'Email',
		'facebook' => 'Facebook',
		'gnusocial' => 'GNU social',
		'jdh' => 'Journal du hacker',
		'lemmy' => 'Lemmy',
		'linkding' => 'Linkding',
		'linkedin' => 'LinkedIn',
		'mastodon' => 'Mastodon',
		'movim' => 'Movim',
		'pinboard' => 'Pinboard',
		'pinterest' => 'Pinterest',
		'pocket' => 'Pocket',
		'print' => 'Print',
		'raindrop' => 'Raindrop.io',
		'reddit' => 'Reddit',
		'shaarli' => 'Shaarli',
		'twitter' => 'Twitter',
		'wallabag' => 'wallabag v1',
		'wallabagv2' => 'wallabag v2',
		'web-sharing-api' => 'System sharing',
		'whatsapp' => 'Whatsapp',
		'xing' => 'Xing',
	),
	'short' => array(
		'attention' => 'Warning!',
		'blank_to_disable' => 'Leave blank to disable',
		'by_author' => 'By:',
		'by_default' => 'By default',
		'damn' => 'Blast!',
		'default_category' => 'Uncategorized',
		'no' => 'No',
		'not_applicable' => 'Not available',
		'ok' => 'Okay!',
		'or' => 'or',
		'yes' => 'Yes',
	),
	'stream' => array(
		'load_more' => 'Load more articles',
		'mark_all_read' => 'Mark all as read',
		'nothing_to_load' => 'There are no more articles',
	),
);

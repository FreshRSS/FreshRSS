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
	'auth' => array(
		'allow_anonymous' => 'Allow anonymous reading of the default user’s articles (%s)',	// IGNORE
		'allow_anonymous_refresh' => 'Allow anonymous refresh of the articles',	// IGNORE
		'api_enabled' => 'Allow <abbr>API</abbr> access <small>(required for mobile apps)</small>',	// IGNORE
		'form' => 'Web form (traditional, requires JavaScript)',	// IGNORE
		'http' => 'HTTP (for advanced users with HTTPS)',	// IGNORE
		'none' => 'None (dangerous)',	// IGNORE
		'title' => 'Authentication',	// IGNORE
		'token' => 'Authentication token',	// IGNORE
		'token_help' => 'Allows access to RSS output of the default user without authentication:',	// IGNORE
		'type' => 'Authentication method',	// IGNORE
		'unsafe_autologin' => 'Allow unsafe automatic login using the format: ',	// IGNORE
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Check permissions on <em>./data/cache</em> directory. HTTP server must have write permission.',	// IGNORE
			'ok' => 'Permissions on the cache directory are good.',	// IGNORE
		),
		'categories' => array(
			'nok' => 'Category table is improperly configured.',	// IGNORE
			'ok' => 'Category table is okay.',	// IGNORE
		),
		'connection' => array(
			'nok' => 'Connection to the database cannot be established.',	// IGNORE
			'ok' => 'Connection to the database is okay.',	// IGNORE
		),
		'ctype' => array(
			'nok' => 'Cannot find a required library for character type checking (php-ctype).',	// IGNORE
			'ok' => 'You have the required library for character type checking (ctype).',	// IGNORE
		),
		'curl' => array(
			'nok' => 'Cannot find the cURL library (php-curl package).',	// IGNORE
			'ok' => 'You have the cURL library.',	// IGNORE
		),
		'data' => array(
			'nok' => 'Check permissions on <em>./data</em> directory. HTTP server must have write permission.',	// IGNORE
			'ok' => 'Permissions on the data directory are good.',	// IGNORE
		),
		'database' => 'Database installation',	// IGNORE
		'dom' => array(
			'nok' => 'Cannot find a required library to browse the DOM (php-xml package).',	// IGNORE
			'ok' => 'You have the required library to browse the DOM.',	// IGNORE
		),
		'entries' => array(
			'nok' => 'Entry table is improperly configured.',	// IGNORE
			'ok' => 'Entry table is okay.',	// IGNORE
		),
		'favicons' => array(
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have write permission.',	// IGNORE
			'ok' => 'Permissions on the favicons directory are good.',	// IGNORE
		),
		'feeds' => array(
			'nok' => 'Feed table is improperly configured.',	// IGNORE
			'ok' => 'Feed table is okay.',	// IGNORE
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// IGNORE
			'ok' => 'You have the fileinfo library.',	// IGNORE
		),
		'files' => 'File installation',	// IGNORE
		'json' => array(
			'nok' => 'Cannot find JSON (php-json package).',	// IGNORE
			'ok' => 'You have the JSON extension.',	// IGNORE
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended mbstring library for Unicode.',	// IGNORE
			'ok' => 'You have the recommended mbstring library for Unicode.',	// IGNORE
		),
		'pcre' => array(
			'nok' => 'Cannot find a required library for regular expressions (php-pcre).',	// IGNORE
			'ok' => 'You have the required library for regular expressions (PCRE).',	// IGNORE
		),
		'pdo' => array(
			'nok' => 'Cannot find PDO or one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// IGNORE
			'ok' => 'You have PDO and at least one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// IGNORE
		),
		'php' => array(
			'_' => 'PHP installation',	// IGNORE
			'nok' => 'Your PHP version is %s but FreshRSS requires at least version %s.',	// IGNORE
			'ok' => 'Your PHP version (%s) is compatible with FreshRSS.',	// IGNORE
		),
		'tables' => array(
			'nok' => 'There are one or more missing tables in the database.',	// IGNORE
			'ok' => 'The appropriate tables exist in the database.',	// IGNORE
		),
		'title' => 'Installation check',	// IGNORE
		'tokens' => array(
			'nok' => 'Check permissions on <em>./data/tokens</em> directory. HTTP server must have write permission',	// IGNORE
			'ok' => 'Permissions on the tokens directory are good.',	// IGNORE
		),
		'users' => array(
			'nok' => 'Check permissions on <em>./data/users</em> directory. HTTP server must have write permission',	// IGNORE
			'ok' => 'Permissions on the users directory are good.',	// IGNORE
		),
		'zip' => array(
			'nok' => 'Cannot find the ZIP extension (php-zip package).',	// IGNORE
			'ok' => 'You have the ZIP extension.',	// IGNORE
		),
	),
	'extensions' => array(
		'author' => 'Author',	// IGNORE
		'community' => 'Available community extensions',	// IGNORE
		'description' => 'Description',	// IGNORE
		'disabled' => 'Disabled',	// IGNORE
		'empty_list' => 'There are no installed extensions',	// IGNORE
		'enabled' => 'Enabled',	// IGNORE
		'latest' => 'Installed',	// IGNORE
		'name' => 'Name',	// IGNORE
		'no_configure_view' => 'This extension cannot be configured.',	// IGNORE
		'system' => array(
			'_' => 'System extensions',	// IGNORE
			'no_rights' => 'System extension (you do not have the required permissions)',	// IGNORE
		),
		'title' => 'Extensions',	// IGNORE
		'update' => 'Update available',	// IGNORE
		'user' => 'User extensions',	// IGNORE
		'version' => 'Version',	// IGNORE
	),
	'stats' => array(
		'_' => 'Statistics',	// IGNORE
		'all_feeds' => 'All feeds',	// IGNORE
		'category' => 'Category',	// IGNORE
		'entry_count' => 'Entry count',	// IGNORE
		'entry_per_category' => 'Entries per category',	// IGNORE
		'entry_per_day' => 'Entries per day (last 30 days)',	// IGNORE
		'entry_per_day_of_week' => 'Per day of week (average: %.2f messages)',	// IGNORE
		'entry_per_hour' => 'Per hour (average: %.2f messages)',	// IGNORE
		'entry_per_month' => 'Per month (average: %.2f messages)',	// IGNORE
		'entry_repartition' => 'Entries repartition',	// IGNORE
		'feed' => 'Feed',	// IGNORE
		'feed_per_category' => 'Feeds per category',	// IGNORE
		'idle' => 'Idle feeds',	// IGNORE
		'main' => 'Main statistics',	// IGNORE
		'main_stream' => 'Main stream',	// IGNORE
		'no_idle' => 'There are no idle feeds!',	// IGNORE
		'number_entries' => '%d articles',	// IGNORE
		'percent_of_total' => '%% of total',	// IGNORE
		'repartition' => 'Articles repartition',	// IGNORE
		'status_favorites' => 'Favorites',
		'status_read' => 'Read',	// IGNORE
		'status_total' => 'Total',	// IGNORE
		'status_unread' => 'Unread',	// IGNORE
		'title' => 'Statistics',	// IGNORE
		'top_feed' => 'Top ten feeds',	// IGNORE
	),
	'system' => array(
		'_' => 'System configuration',	// IGNORE
		'auto-update-url' => 'Auto-update server URL',	// IGNORE
		'cookie-duration' => array(
			'help' => 'in seconds',	// IGNORE
			'number' => 'Duration to keep logged in',	// IGNORE
		),
		'force_email_validation' => 'Force email address validation',	// IGNORE
		'instance-name' => 'Instance name',	// IGNORE
		'max-categories' => 'Max number of categories per user',	// IGNORE
		'max-feeds' => 'Max number of feeds per user',	// IGNORE
		'registration' => array(
			'number' => 'Max number of accounts',	// IGNORE
			'select' => array(
				'label' => 'Registration form',	// IGNORE
				'option' => array(
					'noform' => 'Disabled: No registration form',	// IGNORE
					'nolimit' => 'Enabled: No limit of accounts',	// IGNORE
					'setaccountsnumber' => 'Set max. number of accounts',	// IGNORE
				),
			),
			'status' => array(
				'disabled' => 'Form disabled',	// IGNORE
				'enabled' => 'Form enabled',	// IGNORE
			),
			'title' => 'User registration form',	// IGNORE
		),
	),
	'update' => array(
		'_' => 'Update system',	// IGNORE
		'apply' => 'Apply',	// IGNORE
		'check' => 'Check for new updates',	// IGNORE
		'current_version' => 'Your current version of FreshRSS is %s.',	// IGNORE
		'last' => 'Last verification: %s',	// IGNORE
		'none' => 'No update to apply',	// IGNORE
		'title' => 'Update system',	// IGNORE
	),
	'user' => array(
		'admin' => 'Administrator',	// IGNORE
		'article_count' => 'Articles',	// IGNORE
		'back_to_manage' => '← Return to user list',	// IGNORE
		'create' => 'Create new user',	// IGNORE
		'database_size' => 'Database size',	// IGNORE
		'email' => 'Email address',	// IGNORE
		'enabled' => 'Enabled',	// IGNORE
		'feed_count' => 'Feeds',	// IGNORE
		'is_admin' => 'Is admin',	// IGNORE
		'language' => 'Language',	// IGNORE
		'last_user_activity' => 'Last user activity',	// IGNORE
		'list' => 'User list',	// IGNORE
		'number' => 'There is %d account created',	// IGNORE
		'numbers' => 'There are %d accounts created',	// IGNORE
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',	// IGNORE
		'password_format' => 'At least 7 characters',	// IGNORE
		'title' => 'Manage users',	// IGNORE
		'username' => 'Username',	// IGNORE
	),
);

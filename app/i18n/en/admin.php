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
		'allow_anonymous' => 'Allow anonymous reading of the default user’s articles (%s)',
		'allow_anonymous_refresh' => 'Allow anonymous refresh of the articles',
		'api_enabled' => 'Allow <abbr>API</abbr> access <small>(required for mobile apps)</small>',
		'form' => 'Web form (traditional, requires JavaScript)',
		'http' => 'HTTP (for advanced users with HTTPS)',
		'none' => 'None (dangerous)',
		'title' => 'Authentication',
		'token' => 'Authentication token',
		'token_help' => 'Allows access to RSS output of the default user without authentication:',
		'type' => 'Authentication method',
		'unsafe_autologin' => 'Allow unsafe automatic login using the format: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Check permissions on <em>./data/cache</em> directory. HTTP server must have write permission.',
			'ok' => 'Permissions on the cache directory are good.',
		),
		'categories' => array(
			'nok' => 'Category table is improperly configured.',
			'ok' => 'Category table is okay.',
		),
		'connection' => array(
			'nok' => 'Connection to the database cannot be established.',
			'ok' => 'Connection to the database is okay.',
		),
		'ctype' => array(
			'nok' => 'Cannot find a required library for character type checking (php-ctype).',
			'ok' => 'You have the required library for character type checking (ctype).',
		),
		'curl' => array(
			'nok' => 'Cannot find the cURL library (php-curl package).',
			'ok' => 'You have the cURL library.',
		),
		'data' => array(
			'nok' => 'Check permissions on <em>./data</em> directory. HTTP server must have write permission.',
			'ok' => 'Permissions on the data directory are good.',
		),
		'database' => 'Database installation',
		'dom' => array(
			'nok' => 'Cannot find a required library to browse the DOM (php-xml package).',
			'ok' => 'You have the required library to browse the DOM.',
		),
		'entries' => array(
			'nok' => 'Entry table is improperly configured.',
			'ok' => 'Entry table is okay.',
		),
		'favicons' => array(
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have write permission.',
			'ok' => 'Permissions on the favicons directory are good.',
		),
		'feeds' => array(
			'nok' => 'Feed table is improperly configured.',
			'ok' => 'Feed table is okay.',
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',
			'ok' => 'You have the fileinfo library.',
		),
		'files' => 'File installation',
		'json' => array(
			'nok' => 'Cannot find JSON (php-json package).',
			'ok' => 'You have the JSON extension.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended mbstring library for Unicode.',
			'ok' => 'You have the recommended mbstring library for Unicode.',
		),
		'pcre' => array(
			'nok' => 'Cannot find a required library for regular expressions (php-pcre).',
			'ok' => 'You have the required library for regular expressions (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Cannot find PDO or one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'You have PDO and at least one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'PHP installation',
			'nok' => 'Your PHP version is %s but FreshRSS requires at least version %s.',
			'ok' => 'Your PHP version (%s) is compatible with FreshRSS.',
		),
		'tables' => array(
			'nok' => 'There are one or more missing tables in the database.',
			'ok' => 'The appropriate tables exist in the database.',
		),
		'title' => 'Installation check',
		'tokens' => array(
			'nok' => 'Check permissions on <em>./data/tokens</em> directory. HTTP server must have write permission',
			'ok' => 'Permissions on the tokens directory are good.',
		),
		'users' => array(
			'nok' => 'Check permissions on <em>./data/users</em> directory. HTTP server must have write permission',
			'ok' => 'Permissions on the users directory are good.',
		),
		'zip' => array(
			'nok' => 'Cannot find the ZIP extension (php-zip package).',
			'ok' => 'You have the ZIP extension.',
		),
	),
	'extensions' => array(
		'author' => 'Author',
		'community' => 'Available community extensions',
		'description' => 'Description',
		'disabled' => 'Disabled',
		'empty_list' => 'There are no installed extensions',
		'enabled' => 'Enabled',
		'latest' => 'Installed',
		'name' => 'Name',
		'no_configure_view' => 'This extension cannot be configured.',
		'system' => array(
			'_' => 'System extensions',
			'no_rights' => 'System extension (you do not have the required permissions)',
		),
		'title' => 'Extensions',
		'update' => 'Update available',
		'user' => 'User extensions',
		'version' => 'Version',
	),
	'stats' => array(
		'_' => 'Statistics',
		'all_feeds' => 'All feeds',
		'category' => 'Category',
		'entry_count' => 'Entry count',
		'entry_per_category' => 'Entries per category',
		'entry_per_day' => 'Entries per day (last 30 days)',
		'entry_per_day_of_week' => 'Per day of week (average: %.2f messages)',
		'entry_per_hour' => 'Per hour (average: %.2f messages)',
		'entry_per_month' => 'Per month (average: %.2f messages)',
		'entry_repartition' => 'Entries repartition',
		'feed' => 'Feed',
		'feed_per_category' => 'Feeds per category',
		'idle' => 'Idle feeds',
		'main' => 'Main statistics',
		'main_stream' => 'Main stream',
		'no_idle' => 'There are no idle feeds!',
		'number_entries' => '%d articles',
		'percent_of_total' => '% of total',
		'repartition' => 'Articles repartition',
		'status_favorites' => 'Favourites',
		'status_read' => 'Read',
		'status_total' => 'Total',
		'status_unread' => 'Unread',
		'title' => 'Statistics',
		'top_feed' => 'Top ten feeds',
	),
	'system' => array(
		'_' => 'System configuration',
		'auto-update-url' => 'Auto-update server URL',
		'base-url' => array(
			'_' => 'Base URL',
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => 'in seconds',
			'number' => 'Duration to keep logged in',
		),
		'force_email_validation' => 'Force email address validation',
		'instance-name' => 'Instance name',
		'max-categories' => 'Max number of categories per user',
		'max-feeds' => 'Max number of feeds per user',
		'registration' => array(
			'number' => 'Max number of accounts',
			'select' => array(
				'label' => 'Registration form',
				'option' => array(
					'noform' => 'Disabled: No registration form',
					'nolimit' => 'Enabled: No limit of accounts',
					'setaccountsnumber' => 'Set max. number of accounts',
				),
			),
			'status' => array(
				'disabled' => 'Form disabled',
				'enabled' => 'Form enabled',
			),
			'title' => 'User registration form',
		),
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'is not given',
			'enabled' => '<a href="./?a=tos">is enabled</a>',
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">enable the Terms of Service</a>',
		),
	),
	'update' => array(
		'_' => 'Update FreshRSS',
		'apply' => 'Start update',
		'changelog' => 'Changelog',
		'check' => 'Check for new updates',
		'copiedFromURL' => 'update.php copied from %s to ./data',
		'current_version' => 'Current installed version',
		'last' => 'Last check',
		'loading' => 'Updating…',
		'none' => 'No update available',
		'releaseChannel' => array(
			'_' => 'Release channel',
			'edge' => 'Rolling release (“edge”)',
			'latest' => 'Stable release (“latest”)',
		),
		'title' => 'Update FreshRSS',
		'viaGit' => 'Update via git and Github.com started',
	),
	'user' => array(
		'admin' => 'Administrator',
		'article_count' => 'Articles',
		'back_to_manage' => '← Return to user list',
		'create' => 'Create new user',
		'database_size' => 'Database size',
		'email' => 'Email address',
		'enabled' => 'Enabled',
		'feed_count' => 'Feeds',
		'is_admin' => 'Is admin',
		'language' => 'Language',
		'last_user_activity' => 'Last user activity',
		'list' => 'User list',
		'number' => 'There is %d account created',
		'numbers' => 'There are %d accounts created',
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',
		'password_format' => 'At least 7 characters',
		'title' => 'Manage users',
		'username' => 'Username',
	),
);

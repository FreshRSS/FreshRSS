<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Allow anonymous reading of the articles of the default user (%s)',
		'allow_anonymous_refresh' => 'Allow anonymous refresh of the articles',
		'api_enabled' => 'Allow <abbr>API</abbr> access <small>(required for mobile apps)</small>',
		'form' => 'Web form (traditional, requires JavaScript)',
		'http' => 'HTTP (for advanced users with HTTPS)',
		'none' => 'None (dangerous)',
		'title' => 'Authentication',
		'title_reset' => 'Authentication reset',
		'token' => 'Authentication token',
		'token_help' => 'Allows access to RSS output of the default user without authentication:',
		'type' => 'Authentication method',
		'unsafe_autologin' => 'Allow unsafe automatic login using the format: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Check permissions on <em>./data/cache</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on cache directory are good.',
		),
		'categories' => array(
			'nok' => 'Category table is improperly configured.',
			'ok' => 'Category table is ok.',
		),
		'connection' => array(
			'nok' => 'Connection to the database cannot be established.',
			'ok' => 'Connection to the database is ok.',
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
			'nok' => 'Check permissions on <em>./data</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on data directory are good.',
		),
		'database' => 'Database installation',
		'dom' => array(
			'nok' => 'Cannot find a required library to browse the DOM (php-xml package).',
			'ok' => 'You have the required library to browse the DOM.',
		),
		'entries' => array(
			'nok' => 'Entry table is improperly configured.',
			'ok' => 'Entry table is ok.',
		),
		'favicons' => array(
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on favicons directory are good.',
		),
		'feeds' => array(
			'nok' => 'Feed table is improperly configured.',
			'ok' => 'Feed table is ok.',
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',
			'ok' => 'You have the fileinfo library.',
		),
		'files' => 'File installation',
		'json' => array(
			'nok' => 'Cannot find JSON (php-json package).',
			'ok' => 'You have JSON extension.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',
			'ok' => 'You have the recommended library mbstring for Unicode.',
		),
		'minz' => array(
			'nok' => 'Cannot find the Minz framework.',
			'ok' => 'You have the Minz framework.',
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
			'ok' => 'Your PHP version is %s, which is compatible with FreshRSS.',
		),
		'tables' => array(
			'nok' => 'There are one or more missing tables in the database.',
			'ok' => 'The appropriate tables exist in the database.',
		),
		'title' => 'Installation checking',
		'tokens' => array(
			'nok' => 'Check permissions on <em>./data/tokens</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on tokens directory are good.',
		),
		'users' => array(
			'nok' => 'Check permissions on <em>./data/users</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on users directory are good.',
		),
		'zip' => array(
			'nok' => 'Cannot find ZIP extension (php-zip package).',
			'ok' => 'You have ZIP extension.',
		),
	),
	'extensions' => array(
		'author' => 'Author',
		'available' => 'Available',
		'community' => 'Available community extensions',
		'description' => 'Description',
		'disabled' => 'Disabled',
		'empty_list' => 'There are no installed extensions',
		'enabled' => 'Enabled',
		'latest' => 'Installed',
		'name' => 'Name',
		'no_configure_view' => 'This extension cannot be configured.',
		'status' => 'Status',
		'system' => array(
			'_' => 'System extensions',
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
		'menu' => array(
			'idle' => 'Idle feeds',
			'main' => 'Main statistics',
			'repartition' => 'Articles repartition',
		),
		'no_idle' => 'There is no idle feed!',
		'number_entries' => '%d articles',
		'percent_of_total' => '%% of total',
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
		'cookie-duration' => array(
			'help' => 'in seconds',
			'number' => 'Duration to keep logged in',
		),
		'force_email_validation' => 'Force email addresses validation',
		'instance-name' => 'Instance name',
		'max-categories' => 'Categories per user limit',
		'max-feeds' => 'Feeds per user limit',
		'registration' => array(
			'help' => '0 means that there is no account limit',
			'number' => 'Max number of accounts',
		),
	),
	'update' => array(
		'_' => 'Update system',
		'apply' => 'Apply',
		'check' => 'Check for new updates',
		'current_version' => 'Your current version of FreshRSS is %s.',
		'last' => 'Last verification: %s',
		'none' => 'No update to apply',
		'title' => 'Update system',
	),
	'user' => array(
		'admin' => 'Administrator',
		'article_count' => 'Articles',
		'articles_and_size' => '%s articles (%s)',
		'back_to_manage' => '← Return to user list',
		'create' => 'Create new user',
		'database_size' => 'Database size',
		'delete_users' => 'Delete user',
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
		'selected' => 'Selected user',
		'title' => 'Manage users',
		'update_users' => 'Update user',
		'user_list' => 'List of users',
		'username' => 'Username',
		'users' => 'Users',
	),
);

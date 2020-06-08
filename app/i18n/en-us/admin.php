<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Allow anonymous reading of the articles of the default user (%s)',	// TODO - Translation
		'allow_anonymous_refresh' => 'Allow anonymous refresh of the articles',	// TODO - Translation
		'api_enabled' => 'Allow <abbr>API</abbr> access <small>(required for mobile apps)</small>',	// TODO - Translation
		'form' => 'Web form (traditional, requires JavaScript)',	// TODO - Translation
		'http' => 'HTTP (for advanced users with HTTPS)',	// TODO - Translation
		'none' => 'None (dangerous)',	// TODO - Translation
		'title' => 'Authentication',	// TODO - Translation
		'title_reset' => 'Authentication reset',	// TODO - Translation
		'token' => 'Authentication token',	// TODO - Translation
		'token_help' => 'Allows access to RSS output of the default user without authentication:',	// TODO - Translation
		'type' => 'Authentication method',	// TODO - Translation
		'unsafe_autologin' => 'Allow unsafe automatic login using the format:	-> todo',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Check permissions on <em>./data/cache</em> directory. HTTP server must have rights to write into',	// TODO - Translation
			'ok' => 'Permissions on cache directory are good.',	// TODO - Translation
		),
		'categories' => array(
			'nok' => 'Category table is improperly configured.',	// TODO - Translation
			'ok' => 'Category table is OK.',
		),
		'connection' => array(
			'nok' => 'Connection to the database cannot be established.',	// TODO - Translation
			'ok' => 'Connection to the database is okay.',
		),
		'ctype' => array(
			'nok' => 'Cannot find a required library for character type checking (php-ctype).',	// TODO - Translation
			'ok' => 'You have the required library for character type checking (ctype).',	// TODO - Translation
		),
		'curl' => array(
			'nok' => 'Cannot find the cURL library (php-curl package).',	// TODO - Translation
			'ok' => 'You have the cURL library.',	// TODO - Translation
		),
		'data' => array(
			'nok' => 'Check permissions on <em>./data</em> directory. HTTP server must have rights to write into',	// TODO - Translation
			'ok' => 'Permissions on data directory are good.',	// TODO - Translation
		),
		'database' => 'Database installation',	// TODO - Translation
		'dom' => array(
			'nok' => 'Cannot find a required library to browse the DOM (php-xml package).',	// TODO - Translation
			'ok' => 'You have the required library to browse the DOM.',	// TODO - Translation
		),
		'entries' => array(
			'nok' => 'Entry table is improperly configured.',	// TODO - Translation
			'ok' => 'Entry table is okay.',
		),
		'favicons' => array(
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have rights to write into',	// TODO - Translation
			'ok' => 'Permissions on favicons directory are good.',	// TODO - Translation
		),
		'feeds' => array(
			'nok' => 'Feed table is improperly configured.',	// TODO - Translation
			'ok' => 'Feed table is okay.',
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// TODO - Translation
			'ok' => 'You have the fileinfo library.',	// TODO - Translation
		),
		'files' => 'File installation',	// TODO - Translation
		'json' => array(
			'nok' => 'Cannot find JSON (php-json package).',	// TODO - Translation
			'ok' => 'You have JSON extension.',	// TODO - Translation
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// TODO - Translation
			'ok' => 'You have the recommended library mbstring for Unicode.',	// TODO - Translation
		),
		'minz' => array(
			'nok' => 'Cannot find the Minz framework.',	// TODO - Translation
			'ok' => 'You have the Minz framework.',	// TODO - Translation
		),
		'pcre' => array(
			'nok' => 'Cannot find a required library for regular expressions (php-pcre).',	// TODO - Translation
			'ok' => 'You have the required library for regular expressions (PCRE).',	// TODO - Translation
		),
		'pdo' => array(
			'nok' => 'Cannot find PDO or one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO - Translation
			'ok' => 'You have PDO and at least one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO - Translation
		),
		'php' => array(
			'_' => 'PHP installation',	// TODO - Translation
			'nok' => 'Your PHP version is %s but FreshRSS requires at least version %s.',	// TODO - Translation
			'ok' => 'Your PHP version is %s, which is compatible with FreshRSS.',	// TODO - Translation
		),
		'tables' => array(
			'nok' => 'There are one or more missing tables in the database.',	// TODO - Translation
			'ok' => 'The appropriate tables exist in the database.',	// TODO - Translation
		),
		'title' => 'Installation checking',	// TODO - Translation
		'tokens' => array(
			'nok' => 'Check permissions on <em>./data/tokens</em> directory. HTTP server must have rights to write into',	// TODO - Translation
			'ok' => 'Permissions on tokens directory are good.',	// TODO - Translation
		),
		'users' => array(
			'nok' => 'Check permissions on <em>./data/users</em> directory. HTTP server must have rights to write into',	// TODO - Translation
			'ok' => 'Permissions on users directory are good.',	// TODO - Translation
		),
		'zip' => array(
			'nok' => 'Cannot find ZIP extension (php-zip package).',	// TODO - Translation
			'ok' => 'You have ZIP extension.',	// TODO - Translation
		),
	),
	'extensions' => array(
		'author' => 'Author',	// TODO - Translation
		'community' => 'Available community extensions',	// TODO - Translation
		'description' => 'Description',	// TODO - Translation
		'disabled' => 'Disabled',	// TODO - Translation
		'empty_list' => 'There are no installed extensions',	// TODO - Translation
		'enabled' => 'Enabled',	// TODO - Translation
		'latest' => 'Installed',	// TODO - Translation
		'name' => 'Name',	// TODO - Translation
		'no_configure_view' => 'This extension cannot be configured.',	// TODO - Translation
		'system' => array(
			'_' => 'System extensions',	// TODO - Translation
			'no_rights' => 'System extension (you have no rights on it)',	// TODO - Translation
		),
		'title' => 'Extensions',	// TODO - Translation
		'update' => 'Update available',	// TODO - Translation
		'user' => 'User extensions',	// TODO - Translation
		'version' => 'Version',	// TODO - Translation
	),
	'stats' => array(
		'_' => 'Statistics',	// TODO - Translation
		'all_feeds' => 'All feeds',	// TODO - Translation
		'category' => 'Category',	// TODO - Translation
		'entry_count' => 'Entry count',	// TODO - Translation
		'entry_per_category' => 'Entries per category',	// TODO - Translation
		'entry_per_day' => 'Entries per day (last 30 days)',	// TODO - Translation
		'entry_per_day_of_week' => 'Per day of week (average: %.2f messages)',	// TODO - Translation
		'entry_per_hour' => 'Per hour (average: %.2f messages)',	// TODO - Translation
		'entry_per_month' => 'Per month (average: %.2f messages)',	// TODO - Translation
		'entry_repartition' => 'Entries repartition',	// TODO - Translation
		'feed' => 'Feed',	// TODO - Translation
		'feed_per_category' => 'Feeds per category',	// TODO - Translation
		'idle' => 'Idle feeds',	// TODO - Translation
		'main' => 'Main statistics',	// TODO - Translation
		'main_stream' => 'Main stream',	// TODO - Translation
		'menu' => array(
			'idle' => 'Idle feeds',	// TODO - Translation
			'main' => 'Main statistics',	// TODO - Translation
			'repartition' => 'Articles repartition',	// TODO - Translation
		),
		'no_idle' => 'There is no idle feed!',	// TODO - Translation
		'number_entries' => '%d articles',	// TODO - Translation
		'percent_of_total' => '%% of total',	// TODO - Translation
		'repartition' => 'Articles repartition',	// TODO - Translation
		'status_favorites' => 'Favorites',
		'status_read' => 'Read',	// TODO - Translation
		'status_total' => 'Total',	// TODO - Translation
		'status_unread' => 'Unread',	// TODO - Translation
		'title' => 'Statistics',	// TODO - Translation
		'top_feed' => 'Top ten feeds',	// TODO - Translation
	),
	'system' => array(
		'_' => 'System configuration',	// TODO - Translation
		'auto-update-url' => 'Auto-update server URL',	// TODO - Translation
		'cookie-duration' => array(
			'help' => 'in seconds',	// TODO - Translation
			'number' => 'Duration to keep logged in',	// TODO - Translation
		),
		'force_email_validation' => 'Force email addresses validation',	// TODO - Translation
		'instance-name' => 'Instance name',	// TODO - Translation
		'max-categories' => 'Categories per user limit',	// TODO - Translation
		'max-feeds' => 'Feeds per user limit',	// TODO - Translation
		'registration' => array(
			'help' => '0 means that there is no account limit',	// TODO - Translation
			'number' => 'Max number of accounts',	// TODO - Translation
		),
	),
	'update' => array(
		'_' => 'Update system',	// TODO - Translation
		'apply' => 'Apply',	// TODO - Translation
		'check' => 'Check for new updates',	// TODO - Translation
		'current_version' => 'Your current version of FreshRSS is %s.',	// TODO - Translation
		'last' => 'Last verification: %s',	// TODO - Translation
		'none' => 'No update to apply',	// TODO - Translation
		'title' => 'Update system',	// TODO - Translation
	),
	'user' => array(
		'admin' => 'Administrator',	// TODO - Translation
		'article_count' => 'Articles',	// TODO - Translation
		'articles_and_size' => '%s articles (%s)',	// TODO - Translation
		'back_to_manage' => '← Return to user list',	// TODO - Translation
		'create' => 'Create new user',	// TODO - Translation
		'database_size' => 'Database size',	// TODO - Translation
		'delete_users' => 'Delete user',	// TODO - Translation
		'email' => 'Email address',	// TODO - Translation
		'feed_count' => 'Feeds',	// TODO - Translation
		'is_admin' => 'Is admin',	// TODO - Translation
		'language' => 'Language',	// TODO - Translation
		'last_user_activity' => 'Last user activity',	// TODO - Translation
		'list' => 'User list',	// TODO - Translation
		'number' => 'There is %d account created',	// TODO - Translation
		'numbers' => 'There are %d accounts created',	// TODO - Translation
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',	// TODO - Translation
		'password_format' => 'At least 7 characters',	// TODO - Translation
		'selected' => 'Selected user',	// TODO - Translation
		'title' => 'Manage users',	// TODO - Translation
		'update_users' => 'Update user',	// TODO - Translation
		'user_list' => 'List of users',	// TODO - Translation
		'username' => 'Username',	// TODO - Translation
		'users' => 'Users',	// TODO - Translation
	),
);

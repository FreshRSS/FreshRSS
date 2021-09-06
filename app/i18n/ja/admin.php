<?php

return array(
	'auth' => array(
		'allow_anonymous' => '標準のユーザーの記事が誰でも読めるようにします。\' (%s)',	// TODO - Translation
		'allow_anonymous_refresh' => '匿名ユーザーが記事を更新できるようにします。',	// TODO - Translation
		'api_enabled' => '許可する<abbr>API</abbr> アクセス <small>(モバイルアプリが必要です)</small>',	// TODO - Translation
		'form' => 'ウェブフォーム (JavaScriptが必要です)',	// TODO - Translation
		'http' => 'HTTP (HTTPSなれている方はご使用できます)',	// TODO - Translation
		'none' => 'なし (危険)',	// TODO - Translation
		'title' => '認証',	// TODO - Translation
		'title_reset' => '認証し直します',	// TODO - Translation
		'token' => '認証トークン',	// TODO - Translation
		'token_help' => '標準ユーザーが承認無しで、RSSを出力できることを許可します。:',	// TODO - Translation
		'type' => '認証メソッド',	// TODO - Translation
		'unsafe_autologin' => '危険な自動ログインを有効にします:	-> todo',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'パーミッション<em>./data/cache</em>ディレクトリを確かめます。HTTP serverはパーミッションが必要です。',	// TODO - Translation
			'ok' => 'キャッシュディレクトリのパーミッションは正しく設定されています。',	// TODO - Translation
		),
		'categories' => array(
			'nok' => 'カテゴリテーブルが不適切な設定をされています。',	// TODO - Translation
			'ok' => 'カテゴリテーブルは正しく設定されています。',	// TODO - Translation
		),
		'connection' => array(
			'nok' => 'データベースへの接続ができませんでした。',	// TODO - Translation
			'ok' => 'データベースへの接続が正しく行われました。',	// TODO - Translation
		),
		'ctype' => array(
			'nok' => '必要とされている文字タイプを確認するライブラリが見つかりませんでした。(php-ctype).',	// TODO - Translation
			'ok' => '必要とされている文字タイプを確認するライブラリが見つかりました。(ctype).',	// TODO - Translation
		),
		'curl' => array(
			'nok' => 'cURLライブラリが見つかりませんでした(php-curl package).',	// TODO - Translation
			'ok' => 'cURLライブラリが見つかりました。',	// TODO - Translation
		),
		'data' => array(
			'nok' => '<em>./data</em>ディレクトリのパーミッションを確認してください。 HTTP serverはパーミッションを必要としています。',	// TODO - Translation
			'ok' => 'ディレクトリのパーミッションは正しく設定されています。',	// TODO - Translation
		),
		'database' => 'データベースインストール',	// TODO - Translation
		'dom' => array(
			'nok' => 'DOMを検索するライブラリが見つかりませんでした。 (php-xml package).',	// TODO - Translation
			'ok' => 'DOMを検索するライブラリが見つかりました。',	// TODO - Translation
		),
		'entries' => array(
			'nok' => 'Entry table is improperly configured.',	// TODO - Translation
			'ok' => 'Entry table is okay.',	// TODO - Translation
		),
		'favicons' => array(
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have write permission.',	// TODO - Translation
			'ok' => 'Permissions on the favicons directory are good.',	// TODO - Translation
		),
		'feeds' => array(
			'nok' => 'Feed table is improperly configured.',	// TODO - Translation
			'ok' => 'Feed table is okay.',	// TODO - Translation
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// TODO - Translation
			'ok' => 'You have the fileinfo library.',	// TODO - Translation
		),
		'files' => 'File installation',	// TODO - Translation
		'json' => array(
			'nok' => 'Cannot find JSON (php-json package).',	// TODO - Translation
			'ok' => 'You have the JSON extension.',	// TODO - Translation
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended mbstring library for Unicode.',	// TODO - Translation
			'ok' => 'You have the recommended mbstring library for Unicode.',	// TODO - Translation
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
			'ok' => 'Your PHP version (%s) is compatible with FreshRSS.',	// TODO - Translation
		),
		'tables' => array(
			'nok' => 'There are one or more missing tables in the database.',	// TODO - Translation
			'ok' => 'The appropriate tables exist in the database.',	// TODO - Translation
		),
		'title' => 'Installation check',	// TODO - Translation
		'tokens' => array(
			'nok' => 'Check permissions on <em>./data/tokens</em> directory. HTTP server must have write permission',	// TODO - Translation
			'ok' => 'Permissions on the tokens directory are good.',	// TODO - Translation
		),
		'users' => array(
			'nok' => 'Check permissions on <em>./data/users</em> directory. HTTP server must have write permission',	// TODO - Translation
			'ok' => 'Permissions on the users directory are good.',	// TODO - Translation
		),
		'zip' => array(
			'nok' => 'Cannot find the ZIP extension (php-zip package).',	// TODO - Translation
			'ok' => 'You have the ZIP extension.',	// TODO - Translation
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
			'no_rights' => 'System extension (you do not have the required permissions)',	// TODO - Translation
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
		'no_idle' => 'There are no idle feeds!',	// TODO - Translation
		'number_entries' => '%d articles',	// TODO - Translation
		'percent_of_total' => '%% of total',	// TODO - Translation
		'repartition' => 'Articles repartition',	// TODO - Translation
		'status_favorites' => 'Favourites',	// TODO - Translation
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
		'force_email_validation' => 'Force email address validation',	// TODO - Translation
		'instance-name' => 'Instance name',	// TODO - Translation
		'max-categories' => 'Max number of categories per user',	// TODO - Translation
		'max-feeds' => 'Max number of feeds per user',	// TODO - Translation
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
		'enabled' => 'Enabled',	// TODO - Translation
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

<?php

return array(
	'action' => array(
		'finish' => 'Complete installation',
		'fix_errors_before' => 'Please fix errors before skipping to the next step.',
		'keep_install' => 'Keep previous configuration',
		'next_step' => 'Go to the next step',
		'reinstall' => 'Reinstall FreshRSS',
	),
	'auth' => array(
		'form' => 'Web form (traditional, requires JavaScript)',
		'http' => 'HTTP (for advanced users with HTTPS)',
		'none' => 'None (dangerous)',
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',
		'password_format' => 'At least 7 characters',
		'type' => 'Authentication method',
	),
	'bdd' => array(
		'_' => 'Database',
		'conf' => array(
			'_' => 'Database configuration',
			'ko' => 'Verify your database information.',
			'ok' => 'Database configuration has been saved.',
		),
		'host' => 'Host',
		'password' => 'Database password',
		'prefix' => 'Table prefix',
		'type' => 'Type of database',
		'username' => 'Database username',
	),
	'check' => array(
		'_' => 'Checks',
		'already_installed' => 'We have detected that FreshRSS is already installed!',
		'cache' => array(
			'nok' => 'Check permissions on <em>./data/cache</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on cache directory are good.',
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
		'dom' => array(
			'nok' => 'Cannot find a required library to browse the DOM.',
			'ok' => 'You have the required library to browse the DOM.',
		),
		'favicons' => array(
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on favicons directory are good.',
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',
			'ok' => 'You have the fileinfo library.',
		),
		'http_referer' => array(
			'nok' => 'Please check that you are not altering your HTTP REFERER.',
			'ok' => 'Your HTTP REFERER is known and corresponds to your server.',
		),
		'json' => array(
			'nok' => 'Cannot find a recommended library to parse JSON.',
			'ok' => 'You have a recommended library to parse JSON.',
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
			'nok' => 'Your PHP version is %s but FreshRSS requires at least version %s.',
			'ok' => 'Your PHP version is %s, which is compatible with FreshRSS.',
		),
		'users' => array(
			'nok' => 'Check permissions on <em>./data/users</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on users directory are good.',
		),
		'xml' => array(
			'nok' => 'Cannot find the required library to parse XML.',
			'ok' => 'You have the required library to parse XML.',
		),
	),
	'conf' => array(
		'_' => 'General configuration',
		'ok' => 'General configuration has been saved.',
	),
	'congratulations' => 'Congratulations!',
	'default_user' => 'Username of the default user <small>(maximum 16 alphanumeric characters)</small>',
	'delete_articles_after' => 'Remove articles after',
	'fix_errors_before' => 'Please fix errors before skipping to the next step.',
	'javascript_is_better' => 'FreshRSS is more pleasant with JavaScript enabled',
	'js' => array(
		'confirm_reinstall' => 'You will lose your previous configuration by reinstalling FreshRSS. Are you sure you want to continue?',
	),
	'language' => array(
		'_' => 'Language',
		'choose' => 'Choose a language for FreshRSS',
		'defined' => 'Language has been defined.',
	),
	'not_deleted' => 'Something went wrong; you must delete the file <em>%s</em> manually.',
	'ok' => 'The installation process was successful.',
	'step' => 'step %d',
	'steps' => 'Steps',
	'title' => 'Installation · FreshRSS',
	'this_is_the_end' => 'This is the end',
);

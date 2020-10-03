<?php

return array(
	'action' => array(
		'finish' => 'Complete installation',	// TODO - Translation
		'fix_errors_before' => 'Please all fix errors before continuing to the next step.',	// TODO - Translation
		'keep_install' => 'Keep previous configuration',	// TODO - Translation
		'next_step' => 'Go to the next step',	// TODO - Translation
		'reinstall' => 'Reinstall FreshRSS',	// TODO - Translation
	),
	'auth' => array(
		'form' => 'Web form (traditional, requires JavaScript)',	// TODO - Translation
		'http' => 'HTTP (for advanced users with HTTPS)',	// TODO - Translation
		'none' => 'None (dangerous)',	// TODO - Translation
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',	// TODO - Translation
		'password_format' => 'At least 7 characters',	// TODO - Translation
		'type' => 'Authentication method',	// TODO - Translation
	),
	'bdd' => array(
		'_' => 'Database',	// TODO - Translation
		'conf' => array(
			'_' => 'Database configuration',	// TODO - Translation
			'ko' => 'Verify your database configuration.',	// TODO - Translation
			'ok' => 'Database configuration has been saved.',	// TODO - Translation
		),
		'host' => 'Host',	// TODO - Translation
		'password' => 'Database password',	// TODO - Translation
		'prefix' => 'Table prefix',	// TODO - Translation
		'type' => 'Type of database',	// TODO - Translation
		'username' => 'Database username',	// TODO - Translation
	),
	'check' => array(
		'_' => 'Checks',	// TODO - Translation
		'already_installed' => 'We have detected that FreshRSS is already installed!',	// TODO - Translation
		'cache' => array(
			'nok' => 'Check permissions on the <em>./data/cache</em> directory. The HTTP server must have write permission.',	// TODO - Translation
			'ok' => 'Permissions on the cache directory are good.',	// TODO - Translation
		),
		'ctype' => array(
			'nok' => 'Cannot find the required library for character type checking (php-ctype).',	// TODO - Translation
			'ok' => 'You have the required library for character type checking (ctype).',	// TODO - Translation
		),
		'curl' => array(
			'nok' => 'Cannot find the cURL library (php-curl package).',	// TODO - Translation
			'ok' => 'You have the cURL library.',	// TODO - Translation
		),
		'data' => array(
			'nok' => 'Check permissions on the <em>./data</em> directory. The HTTP server must have write permission.',	// TODO - Translation
			'ok' => 'Permissions on the data directory are good.',	// TODO - Translation
		),
		'dom' => array(
			'nok' => 'Cannot find the required library to browse the DOM.',	// TODO - Translation
			'ok' => 'You have the required library to browse the DOM.',	// TODO - Translation
		),
		'favicons' => array(
			'nok' => 'Check permissions on the <em>./data/favicons</em> directory. The HTTP server must have write permission.',	// TODO - Translation
			'ok' => 'Permissions on the favicons directory are good.',	// TODO - Translation
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// TODO - Translation
			'ok' => 'You have the fileinfo library.',	// TODO - Translation
		),
		'http_referer' => array(
			'nok' => 'Please check that you are not altering your HTTP REFERER.',	// TODO - Translation
			'ok' => 'Your HTTP REFERER is known and corresponds to your server.',	// TODO - Translation
		),
		'json' => array(
			'nok' => 'Cannot find the recommended library to parse JSON.',	// TODO - Translation
			'ok' => 'You have the recommended library to parse JSON.',	// TODO - Translation
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
			'nok' => 'Cannot find the required library for regular expressions (php-pcre).',	// TODO - Translation
			'ok' => 'You have the required library for regular expressions (PCRE).',	// TODO - Translation
		),
		'pdo' => array(
			'nok' => 'Cannot find PDO or one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO - Translation
			'ok' => 'You have PDO and at least one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO - Translation
		),
		'php' => array(
			'nok' => 'Your PHP version is %s, but FreshRSS requires at least version %s.',	// TODO - Translation
			'ok' => 'Your PHP version, %s, is compatible with FreshRSS.',	// TODO - Translation
		),
		'users' => array(
			'nok' => 'Check permissions on the <em>./data/users</em> directory. The HTTP server must have write permissions',	// TODO - Translation
			'ok' => 'Permissions on the users directory are good.',	// TODO - Translation
		),
		'xml' => array(
			'nok' => 'Cannot find the required library to parse XML.',	// TODO - Translation
			'ok' => 'You have the required library to parse XML.',	// TODO - Translation
		),
	),
	'conf' => array(
		'_' => 'General configuration',	// TODO - Translation
		'ok' => 'General configuration has been saved.',	// TODO - Translation
	),
	'congratulations' => 'Congratulations!',	// TODO - Translation
	'default_user' => 'Username of the default user <small>(maximum 16 alphanumeric characters)</small>',	// TODO - Translation
	'delete_articles_after' => 'Remove articles after',	// TODO - Translation
	'fix_errors_before' => 'Please fix errors before continuing to the next step.',	// TODO - Translation
	'javascript_is_better' => 'FreshRSS is more pleasant with JavaScript enabled',	// TODO - Translation
	'js' => array(
		'confirm_reinstall' => 'You will lose your previous configuration by reinstalling FreshRSS. Are you sure you want to continue?',	// TODO - Translation
	),
	'language' => array(
		'_' => 'Language',	// TODO - Translation
		'choose' => 'Choose a language for FreshRSS',	// TODO - Translation
		'defined' => 'Language has been defined.',	// TODO - Translation
	),
	'not_deleted' => 'Something went wrong; you must delete the file <em>%s</em> manually.',	// TODO - Translation
	'ok' => 'The installation process was successful.',	// TODO - Translation
	'step' => 'step %d',	// TODO - Translation
	'steps' => 'Steps',	// TODO - Translation
	'this_is_the_end' => 'This is the end',	// TODO - Translation
	'title' => 'Installation · FreshRSS',	// TODO - Translation
);

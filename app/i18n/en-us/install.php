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
		'finish' => 'Complete installation',	// IGNORE
		'fix_errors_before' => 'Please all fix errors before continuing to the next step.',	// IGNORE
		'keep_install' => 'Keep previous configuration',	// IGNORE
		'next_step' => 'Go to the next step',	// IGNORE
		'reinstall' => 'Reinstall FreshRSS',	// IGNORE
	),
	'auth' => array(
		'form' => 'Web form (traditional, requires JavaScript)',	// IGNORE
		'http' => 'HTTP (for advanced users with HTTPS)',	// IGNORE
		'none' => 'None (dangerous)',	// IGNORE
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',	// IGNORE
		'password_format' => 'At least 7 characters',	// IGNORE
		'type' => 'Authentication method',	// IGNORE
	),
	'bdd' => array(
		'_' => 'Database',	// IGNORE
		'conf' => array(
			'_' => 'Database configuration',	// IGNORE
			'ko' => 'Verify your database configuration.',	// IGNORE
			'ok' => 'Database configuration has been saved.',	// IGNORE
		),
		'host' => 'Host',	// IGNORE
		'password' => 'Database password',	// IGNORE
		'prefix' => 'Table prefix',	// IGNORE
		'type' => 'Type of database',	// IGNORE
		'username' => 'Database username',	// IGNORE
	),
	'check' => array(
		'_' => 'Checks',	// IGNORE
		'already_installed' => 'We have detected that FreshRSS is already installed!',	// IGNORE
		'cache' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'Permissions on the cache directory are good.',	// IGNORE
		),
		'ctype' => array(
			'nok' => 'Cannot find the required library for character type checking (php-ctype).',	// IGNORE
			'ok' => 'You have the required library for character type checking (ctype).',	// IGNORE
		),
		'curl' => array(
			'nok' => 'Cannot find the cURL library (php-curl package).',	// IGNORE
			'ok' => 'You have the cURL library.',	// IGNORE
		),
		'data' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'Permissions on the data directory are good.',	// IGNORE
		),
		'dom' => array(
			'nok' => 'Cannot find the required library to browse the DOM.',	// IGNORE
			'ok' => 'You have the required library to browse the DOM.',	// IGNORE
		),
		'favicons' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'Permissions on the favicons directory are good.',	// IGNORE
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// IGNORE
			'ok' => 'You have the fileinfo library.',	// IGNORE
		),
		'json' => array(
			'nok' => 'Cannot find the recommended library to parse JSON.',	// IGNORE
			'ok' => 'You have the recommended library to parse JSON.',	// IGNORE
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// IGNORE
			'ok' => 'You have the recommended library mbstring for Unicode.',	// IGNORE
		),
		'pcre' => array(
			'nok' => 'Cannot find the required library for regular expressions (php-pcre).',	// IGNORE
			'ok' => 'You have the required library for regular expressions (PCRE).',	// IGNORE
		),
		'pdo' => array(
			'nok' => 'Cannot find PDO or one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// IGNORE
			'ok' => 'You have PDO and at least one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// IGNORE
		),
		'php' => array(
			'nok' => 'Your PHP version is %s, but FreshRSS requires at least version %s.',	// IGNORE
			'ok' => 'Your PHP version, %s, is compatible with FreshRSS.',	// IGNORE
		),
		'reload' => 'Check again',	// IGNORE
		'tmp' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',	// IGNORE
			'ok' => 'Permissions on the temp directory are good.',	// IGNORE
		),
		'unknown_process_username' => 'unknown',	// IGNORE
		'users' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',	// IGNORE
			'ok' => 'Permissions on the users directory are good.',	// IGNORE
		),
		'xml' => array(
			'nok' => 'Cannot find the required library to parse XML.',	// IGNORE
			'ok' => 'You have the required library to parse XML.',	// IGNORE
		),
	),
	'conf' => array(
		'_' => 'General configuration',	// IGNORE
		'ok' => 'General configuration has been saved.',	// IGNORE
	),
	'congratulations' => 'Congratulations!',	// IGNORE
	'default_user' => 'Username of the default user <small>(maximum 16 alphanumeric characters)</small>',	// IGNORE
	'fix_errors_before' => 'Please fix errors before continuing to the next step.',	// IGNORE
	'javascript_is_better' => 'FreshRSS is more pleasant with JavaScript enabled',	// IGNORE
	'js' => array(
		'confirm_reinstall' => 'You will lose your previous configuration by reinstalling FreshRSS. Are you sure you want to continue?',	// IGNORE
	),
	'language' => array(
		'_' => 'Language',	// IGNORE
		'choose' => 'Choose a language for FreshRSS',	// IGNORE
		'defined' => 'Language has been defined.',	// IGNORE
	),
	'missing_applied_migrations' => 'Something went wrong; you should create an empty file <em>%s</em> manually.',	// IGNORE
	'ok' => 'The installation process was successful.',	// IGNORE
	'session' => array(
		'nok' => 'The web server seems to be incorrectly configured for cookies required for PHP sessions!',	// IGNORE
	),
	'step' => 'step %d',	// IGNORE
	'steps' => 'Steps',	// IGNORE
	'this_is_the_end' => 'This is the end',	// IGNORE
	'title' => 'Installation · FreshRSS',	// IGNORE
);

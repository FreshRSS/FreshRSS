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
		'finish' => 'Complete installation',	// TODO
		'fix_errors_before' => 'Please all fix errors before continuing to the next step.',	// TODO
		'keep_install' => 'Keep previous configuration',	// TODO
		'next_step' => 'Go to the next step',	// TODO
		'reinstall' => 'Reinstall FreshRSS',	// TODO
	),
	'auth' => array(
		'form' => 'Web form (traditional, requires JavaScript)',	// TODO
		'http' => 'HTTP (for advanced users with HTTPS)',	// TODO
		'none' => 'None (dangerous)',	// TODO
		'password_form' => 'Password<br /><small>(for the Web-form login method)</small>',	// TODO
		'password_format' => 'At least 7 characters',	// TODO
		'type' => 'Authentication method',	// TODO
	),
	'bdd' => array(
		'_' => 'Database',	// TODO
		'conf' => array(
			'_' => 'Database configuration',	// TODO
			'ko' => 'Verify your database configuration.',	// TODO
			'ok' => 'Database configuration has been saved.',	// TODO
		),
		'host' => 'Host',	// TODO
		'password' => 'Database password',	// TODO
		'prefix' => 'Table prefix',	// TODO
		'type' => 'Type of database',	// TODO
		'username' => 'Database username',	// TODO
	),
	'check' => array(
		'_' => 'Checks',	// TODO
		'already_installed' => 'We have detected that FreshRSS is already installed!',	// TODO
		'cache' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'Permissions on the cache directory are good.',	// TODO
		),
		'ctype' => array(
			'nok' => 'Cannot find the required library for character type checking (php-ctype).',	// TODO
			'ok' => 'You have the required library for character type checking (ctype).',	// TODO
		),
		'curl' => array(
			'nok' => 'Cannot find the cURL library (php-curl package).',	// TODO
			'ok' => 'You have the cURL library.',	// TODO
		),
		'data' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'Permissions on the data directory are good.',	// TODO
		),
		'dom' => array(
			'nok' => 'Cannot find the required library to browse the DOM.',	// TODO
			'ok' => 'You have the required library to browse the DOM.',	// TODO
		),
		'favicons' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'Permissions on the favicons directory are good.',	// TODO
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// TODO
			'ok' => 'You have the fileinfo library.',	// TODO
		),
		'json' => array(
			'nok' => 'Cannot find the recommended library to parse JSON.',	// TODO
			'ok' => 'You have the recommended library to parse JSON.',	// TODO
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// TODO
			'ok' => 'You have the recommended library mbstring for Unicode.',	// TODO
		),
		'pcre' => array(
			'nok' => 'Cannot find the required library for regular expressions (php-pcre).',	// TODO
			'ok' => 'You have the required library for regular expressions (PCRE).',	// TODO
		),
		'pdo' => array(
			'nok' => 'Cannot find PDO or one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO
			'ok' => 'You have PDO and at least one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO
		),
		'php' => array(
			'nok' => 'Your PHP version is %s, but FreshRSS requires at least version %s.',	// TODO
			'ok' => 'Your PHP version, %s, is compatible with FreshRSS.',	// TODO
		),
		'reload' => 'Sprawdź ponownie',
		'tmp' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',	// TODO
			'ok' => 'Permissions on the temp directory are good.',	// TODO
		),
		'unknown_process_username' => 'unknown',	// TODO
		'users' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',	// TODO
			'ok' => 'Permissions on the users directory are good.',	// TODO
		),
		'xml' => array(
			'nok' => 'Cannot find the required library to parse XML.',	// TODO
			'ok' => 'You have the required library to parse XML.',	// TODO
		),
	),
	'conf' => array(
		'_' => 'General configuration',	// TODO
		'ok' => 'General configuration has been saved.',	// TODO
	),
	'congratulations' => 'Congratulations!',	// TODO
	'default_user' => 'Username of the default user <small>(maximum 16 alphanumeric characters)</small>',	// TODO
	'fix_errors_before' => 'Please fix errors before continuing to the next step.',	// TODO
	'javascript_is_better' => 'FreshRSS is more pleasant with JavaScript enabled',	// TODO
	'js' => array(
		'confirm_reinstall' => 'You will lose your previous configuration by reinstalling FreshRSS. Are you sure you want to continue?',	// TODO
	),
	'language' => array(
		'_' => 'Language',	// TODO
		'choose' => 'Choose a language for FreshRSS',	// TODO
		'defined' => 'Language has been defined.',	// TODO
	),
	'missing_applied_migrations' => 'Something went wrong; you should create an empty file <em>%s</em> manually.',	// TODO
	'ok' => 'The installation process was successful.',	// TODO
	'session' => array(
		'nok' => 'The web server seems to be incorrectly configured for cookies required for PHP sessions!',	// TODO
	),
	'step' => 'step %d',	// TODO
	'steps' => 'Steps',	// TODO
	'this_is_the_end' => 'This is the end',	// TODO
	'title' => 'Installation · FreshRSS',	// TODO
);

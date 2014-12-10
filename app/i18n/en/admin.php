<?php

return array(
	'check_install' => array(
		'cache' => array(
			'nok' => 'Check permissions on <em>./data/cache</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on cache directory are good.',
		),
		'categories' => array(
			'nok' => 'Category table is bad configured.',
			'ok' => 'Category table is ok.',
		),
		'connection' => array(
			'nok' => 'Connection to the database cannot being established.',
			'ok' => 'Connection to the database is ok.',
		),
		'ctype' => array(
			'nok' => 'You lack a required library for character type checking (php-ctype).',
			'ok' => 'You have the required library for character type checking (ctype).',
		),
		'curl' => array(
			'nok' => 'You lack cURL (php5-curl package).',
			'ok' => 'You have cURL extension.',
		),
		'data' => array(
			'nok' => 'Check permissions on <em>./data</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on data directory are good.',
		),
		'database' => 'Database installation',
		'dom' => array(
			'nok' => 'You lack a required library to browse the DOM (php-xml package).',
			'ok' => 'You have the required library to browse the DOM.',
		),
		'entries' => array(
			'nok' => 'Entry table is bad configured.',
			'ok' => 'Entry table is ok.',
		),
		'favicons' => array(
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on favicons directory are good.',
		),
		'feeds' => array(
			'nok' => 'Feed table is bad configured.',
			'ok' => 'Feed table is ok.',
		),
		'files' => 'File installation',
		'json' => array(
			'nok' => 'You lack JSON (php5-json package).',
			'ok' => 'You have JSON extension.',
		),
		'logs' => array(
			'nok' => 'Check permissions on <em>./data/logs</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on logs directory are good.',
		),
		'minz' => array(
			'nok' => 'You lack the Minz framework.',
			'ok' => 'You have the Minz framework.',
		),
		'pcre' => array(
			'nok' => 'You lack a required library for regular expressions (php-pcre).',
			'ok' => 'You have the required library for regular expressions (PCRE).',
		),
		'pdo' => array(
			'nok' => 'You lack PDO or one of the supported drivers (pdo_mysql, pdo_sqlite).',
			'ok' => 'You have PDO and at least one of the supported drivers (pdo_mysql, pdo_sqlite).',
		),
		'persona' => array(
			'nok' => 'Check permissions on <em>./data/persona</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on Mozilla Persona directory are good.',
		),
		'php' => array(
			'_' => 'PHP installation',
			'nok' => 'Your PHP version is %s but FreshRSS requires at least version %s.',
			'ok' => 'Your PHP version is %s, which is compatible with FreshRSS.',
		),
		'tables' => array(
			'nok' => 'There is one or more lacking tables in the database.',
			'ok' => 'Tables are existing in the database.',
		),
		'tokens' => array(
			'nok' => 'Check permissions on <em>./data/tokens</em> directory. HTTP server must have rights to write into',
			'ok' => 'Permissions on tokens directory are good.',
		),
		'zip' => array(
			'nok' => 'You lack ZIP extension (php5-zip package).',
			'ok' => 'You have ZIP extension.',
		),
	),
	'stats' => array(
		'idle' => 'Idle feeds',
		'main' => 'Main statistics',
		'repartition' => 'Articles repartition',
	),
	'users' => array(
		'articles_and_size' => '%s articles (%s)',
	),
);

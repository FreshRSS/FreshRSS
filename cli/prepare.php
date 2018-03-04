#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$dirs = array(
	'/',
	'/cache',
	'/extensions-data',
	'/favicons',
	'/PubSubHubbub',
	'/PubSubHubbub/feeds',
	'/PubSubHubbub/keys',
	'/tokens',
	'/users',
	'/users/_',
);

$ok = true;

foreach ($dirs as $dir) {
	@mkdir(DATA_PATH . $dir, 0770, true);
	$ok &= touch(DATA_PATH . $dir . '/index.html');
}

if (!is_file(DATA_PATH . '/config.php')) {
	$ok &= touch(DATA_PATH . '/do-install.txt');
}

file_put_contents(DATA_PATH . '/.htaccess',
"Order	Allow,Deny\n" .
"Deny	from all\n" .
"Satisfy	all\n"
);

accessRights();

done($ok);

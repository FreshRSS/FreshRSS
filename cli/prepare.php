#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

$dirs = array(
	'/',
	'/cache',
	'/extensions-data',
	'/favicons',
	'/fever',
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
"# Apache 2.2\n" .
"<IfModule !mod_authz_core.c>\n" .
"	Order	Allow,Deny\n" .
"	Deny	from all\n" .
"	Satisfy	all\n" .
"</IfModule>\n" .
"\n" .
"# Apache 2.4\n" .
"<IfModule mod_authz_core.c>\n" .
"	Require all denied\n" .
"</IfModule>\n"
);

accessRights();

done($ok);

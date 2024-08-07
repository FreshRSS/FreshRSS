#!/usr/bin/env php
<?php
declare(strict_types=1);
require(__DIR__ . '/_cli.php');

$dirs = [
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
];

$ok = true;

foreach ($dirs as $dir) {
	@mkdir(DATA_PATH . $dir, 0770, true);
	$ok &= touch(DATA_PATH . $dir . '/index.html');
}

file_put_contents(DATA_PATH . '/.htaccess', <<<'EOF'
# Apache 2.2
<IfModule !mod_authz_core.c>
	Order	Allow,Deny
	Deny	from all
	Satisfy	all
</IfModule>

# Apache 2.4
<IfModule mod_authz_core.c>
	Require all denied
</IfModule>

EOF
);

accessRights();

done((bool)$ok);

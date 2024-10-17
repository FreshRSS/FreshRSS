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
Require all denied

EOF
);

accessRights();

done((bool)$ok);

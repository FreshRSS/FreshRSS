#!/usr/bin/env php
<?php
declare(strict_types=1);

use FreshRss\Controllers\UserController;
use FreshRss\Models\Context;

require __DIR__ . '/_cli.php';

$users = UserController::listUsers();
sort($users);
if (Context::systemConf()->default_user !== ''
	&& in_array(Context::systemConf()->default_user, $users, true)) {
	array_unshift($users, Context::systemConf()->default_user);
	$users = array_unique($users);
}

foreach ($users as $user) {
	echo $user, "\n";
}

done();

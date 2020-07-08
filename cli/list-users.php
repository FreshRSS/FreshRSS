#!/usr/bin/env php
<?php
require(__DIR__ . '/_cli.php');

$users = listUsers();
sort($users);
if (FreshRSS_Context::$system_conf->default_user !== ''
	&& in_array(FreshRSS_Context::$system_conf->default_user, $users, true)) {
	array_unshift($users, FreshRSS_Context::$system_conf->default_user);
	$users = array_unique($users);
}

foreach ($users as $user) {
	echo $user, "\n";
}

done();

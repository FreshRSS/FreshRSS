#!/usr/bin/php
<?php
require('_cli.php');

$users = listUsers();
sort($users);
if ($system_conf->default_user !== '') {
	array_unshift($users, $system_conf->default_user);
	$users = array_unique($users);
}

foreach ($users as $user) {
	echo $user, "\n";
}

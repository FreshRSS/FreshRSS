#!/usr/bin/php
<?php
require(__DIR__ . '/_cli.php');

if (!file_exists(DATA_PATH . '/do-install.txt')) {
	fail('FreshRSS looks to be already installed! Please use `./cli/reconfigure.php` instead.');
}

$params = array(
		'environment:',
		'base_url:',
		'language:',
		'title:',
		'default_user:',
		'allow_anonymous',
		'allow_anonymous_refresh',
		'auth_type:',
		'api_enabled',
		'allow_robots',
		'disable_update',
	);

$dBparams = array(
		'db-type:',
		'db-host:',
		'db-user:',
		'db-password:',
		'db-base:',
		'db-prefix:',
	);

$options = getopt('', array_merge($params, $dBparams));

if (empty($options['default_user'])) {
	fail('Usage: ' . basename(__FILE__) . " --default_user admin ( --auth_type form" .
		" --environment production --base_url https://rss.example.net" .
		" --language en --title FreshRSS --allow_anonymous --api_enabled" .
		" --db-type mysql --db-host localhost:3306 --db-user freshrss --db-password dbPassword123" .
		" --db-base freshrss --db-prefix freshrss_ --disable_update )");
}

fwrite(STDERR, 'FreshRSS install…' . "\n");

$config = array(
		'salt' => generateSalt(),
		'db' => FreshRSS_Context::$system_conf->db,
	);

foreach ($params as $param) {
	$param = rtrim($param, ':');
	if (isset($options[$param])) {
		$config[$param] = $options[$param] === false ? true : $options[$param];
	}
}

if ((!empty($config['base_url'])) && server_is_public($config['base_url'])) {
	$config['pubsubhubbub_enabled'] = true;
}

foreach ($dBparams as $dBparam) {
	$dBparam = rtrim($dBparam, ':');
	if (isset($options[$dBparam])) {
		$param = substr($dBparam, strlen('db-'));
		$config['db'][$param] = $options[$dBparam];
	}
}

performRequirementCheck($config['db']['type']);

if (!FreshRSS_user_Controller::checkUsername($options['default_user'])) {
	fail('FreshRSS error: invalid default username “' . $options['default_user']
		. '”! Must be matching ' . FreshRSS_user_Controller::USERNAME_PATTERN);
}

if (isset($options['auth_type']) && !in_array($options['auth_type'], array('form', 'http_auth', 'none'))) {
	fail('FreshRSS invalid authentication method (auth_type must be one of { form, http_auth, none }): '
		. $options['auth_type']);
}

if (file_put_contents(join_path(DATA_PATH, 'config.php'),
	"<?php\n return " . var_export($config, true) . ";\n") === false) {
	fail('FreshRSS could not write configuration file!: ' . join_path(DATA_PATH, 'config.php'));
}

$config['db']['default_user'] = $config['default_user'];
if (!checkDb($config['db'])) {
	@unlink(join_path(DATA_PATH, 'config.php'));
	fail('FreshRSS database error: ' . (empty($config['db']['error']) ? 'Unknown error' : $config['db']['error']));
}

echo '• Remember to create the default user: ', $config['default_user'] , "\n",
	"\t", './cli/create-user.php --user ', $config['default_user'], " --password 'password' --more-options\n";

accessRights();

if (!deleteInstall()) {
	fail('FreshRSS access right problem while deleting install file!');
}

done();

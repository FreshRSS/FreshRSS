<?php

define('BCRYPT_COST', 9);

Minz_Configuration::register('default_system', join_path(FRESHRSS_PATH, 'config.default.php'));
Minz_Configuration::register('default_user', join_path(FRESHRSS_PATH, 'config-user.default.php'));

function checkRequirements($dbType = '') {
	$php = version_compare(PHP_VERSION, FRESHRSS_MIN_PHP_VERSION) >= 0;
	$curl = extension_loaded('curl');
	$pdo_mysql = extension_loaded('pdo_mysql');
	$pdo_sqlite = extension_loaded('pdo_sqlite');
	$pdo_pgsql = extension_loaded('pdo_pgsql');
	$message = '';
	switch ($dbType) {
		case 'mysql':
			$pdo_sqlite = $pdo_pgsql = true;
			$pdo = $pdo_mysql;
			break;
		case 'sqlite':
			$pdo_mysql = $pdo_pgsql = true;
			$pdo = $pdo_sqlite;
			break;
		case 'pgsql':
			$pdo_mysql = $pdo_sqlite = true;
			$pdo = $pdo_pgsql;
			break;
		case '':
			$pdo = $pdo_mysql || $pdo_sqlite || $pdo_pgsql;
			break;
		default:
			$pdo_mysql = $pdo_sqlite = $pdo_pgsql = true;
			$pdo = false;
			$message = 'Invalid database type!';
			break;
	}
	$pcre = extension_loaded('pcre');
	$ctype = extension_loaded('ctype');
	$fileinfo = extension_loaded('fileinfo');
	$dom = class_exists('DOMDocument');
	$xml = function_exists('xml_parser_create');
	$json = function_exists('json_encode');
	$mbstring = extension_loaded('mbstring');
	$data = DATA_PATH && is_writable(DATA_PATH);
	$cache = CACHE_PATH && is_writable(CACHE_PATH);
	$tmp = TMP_PATH && is_writable(TMP_PATH);
	$users = USERS_PATH && is_writable(USERS_PATH);
	$favicons = is_writable(join_path(DATA_PATH, 'favicons'));
	$http_referer = is_referer_from_same_domain();

	return array(
		'php' => $php ? 'ok' : 'ko',
		'curl' => $curl ? 'ok' : 'ko',
		'pdo-mysql' => $pdo_mysql ? 'ok' : 'ko',
		'pdo-sqlite' => $pdo_sqlite ? 'ok' : 'ko',
		'pdo-pgsql' => $pdo_pgsql ? 'ok' : 'ko',
		'pdo' => $pdo ? 'ok' : 'ko',
		'pcre' => $pcre ? 'ok' : 'ko',
		'ctype' => $ctype ? 'ok' : 'ko',
		'fileinfo' => $fileinfo ? 'ok' : 'ko',
		'dom' => $dom ? 'ok' : 'ko',
		'xml' => $xml ? 'ok' : 'ko',
		'json' => $json ? 'ok' : 'ko',
		'mbstring' => $mbstring ? 'ok' : 'ko',
		'data' => $data ? 'ok' : 'ko',
		'cache' => $cache ? 'ok' : 'ko',
		'tmp' => $tmp ? 'ok' : 'ko',
		'users' => $users ? 'ok' : 'ko',
		'favicons' => $favicons ? 'ok' : 'ko',
		'http_referer' => $http_referer ? 'ok' : 'ko',
		'message' => $message ?: 'ok',
		'all' => $php && $curl && $pdo && $pcre && $ctype && $dom && $xml &&
		         $data && $cache && $tmp && $users && $favicons && $http_referer && $message == '' ? 'ok' : 'ko'
	);
}

function generateSalt() {
	return sha1(uniqid(mt_rand(), true).implode('', stat(__FILE__)));
}

function initDb() {
	$conf = FreshRSS_Context::$system_conf;
	$db = $conf->db;
	if (empty($db['pdo_options'])) {
		$db['pdo_options'] = [];
	}
	$db['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$conf->db = $db;	//TODO: Remove this Minz limitation "Indirect modification of overloaded property"

	//Attempt to auto-create database if it does not already exist
	if ($db['type'] !== 'sqlite') {
		Minz_ModelPdo::$usesSharedPdo = false;
		$dbBase = isset($db['base']) ? $db['base'] : '';
		//For first connection, use default database for PostgreSQL, empty database for MySQL / MariaDB:
		$db['base'] = $db['type'] === 'pgsql' ? 'postgres' : '';
		$conf->db = $db;
		try {
			//First connection without database name to create the database
			$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
		} catch (Exception $ex) {
			$databaseDAO = null;
		}
		//Restore final database parameters for auto-creation and for future connections
		$db['base'] = $dbBase;
		$conf->db = $db;
		if ($databaseDAO != null) {
			//Perfom database auto-creation
			$databaseDAO->create();
		}
	}

	//New connection with the database name
	$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
	Minz_ModelPdo::$usesSharedPdo = true;
	return $databaseDAO->testConnection();
}

function deleteInstall() {
	$path = join_path(DATA_PATH, 'do-install.txt');
	@unlink($path);
	return !file_exists($path);
}

function setupMigrations() {
	$migrations_path = APP_PATH . '/migrations';
	$migrations_version_path = DATA_PATH . '/applied_migrations.txt';

	$migrator = new Minz_Migrator($migrations_path);
	$versions = implode("\n", $migrator->versions());
	return @file_put_contents($migrations_version_path, $versions) !== false;
}

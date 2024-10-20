<?php
declare(strict_types=1);

FreshRSS_SystemConfiguration::register('default_system', join_path(FRESHRSS_PATH, 'config.default.php'));
FreshRSS_UserConfiguration::register('default_user', join_path(FRESHRSS_PATH, 'config-user.default.php'));

/** @return array<string,string> */
function checkRequirements(string $dbType = ''): array {
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
	$data = is_dir(DATA_PATH) && touch(DATA_PATH . '/index.html');	// is_writable() is not reliable for a folder on NFS
	$cache = is_dir(CACHE_PATH) && touch(CACHE_PATH . '/index.html');
	$tmp = is_dir(TMP_PATH) && is_writable(TMP_PATH);
	$users = is_dir(USERS_PATH) && touch(USERS_PATH . '/index.html');
	$favicons = is_dir(DATA_PATH) && touch(DATA_PATH . '/favicons/index.html');

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
		'message' => $message ?: '',
		'all' => $php && $curl && $pdo && $pcre && $ctype && $dom && $xml &&
			$data && $cache && $tmp && $users && $favicons && $message == '' ? 'ok' : 'ko'
	);
}

function generateSalt(): string {
	return sha1(uniqid('' . mt_rand(), true) . implode('', stat(__FILE__) ?: []));
}

/**
 * @throws FreshRSS_Context_Exception
 */
function initDb(): string {
	$db = FreshRSS_Context::systemConf()->db;
	if (empty($db['pdo_options'])) {
		$db['pdo_options'] = [];
	}
	$db['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	FreshRSS_Context::systemConf()->db = $db;	//TODO: Remove this Minz limitation "Indirect modification of overloaded property"

	if (empty($db['type'])) {
		$db['type'] = 'sqlite';
	}

	//Attempt to auto-create database if it does not already exist
	if ($db['type'] !== 'sqlite') {
		Minz_ModelPdo::$usesSharedPdo = false;
		$dbBase = $db['base'] ?? '';
		//For first connection, use default database for PostgreSQL, empty database for MySQL / MariaDB:
		$db['base'] = $db['type'] === 'pgsql' ? 'postgres' : '';
		FreshRSS_Context::systemConf()->db = $db;
		try {
			//First connection without database name to create the database
			$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
		} catch (Exception $ex) {
			$databaseDAO = null;
		}
		//Restore final database parameters for auto-creation and for future connections
		$db['base'] = $dbBase;
		FreshRSS_Context::systemConf()->db = $db;
		if ($databaseDAO != null) {
			//Perform database auto-creation
			$databaseDAO->create();
		}
	}

	//New connection with the database name
	$databaseDAO = FreshRSS_Factory::createDatabaseDAO();
	Minz_ModelPdo::$usesSharedPdo = true;
	return $databaseDAO->testConnection();
}

function setupMigrations(): bool {
	$migrations_path = APP_PATH . '/migrations';
	$migrations_version_path = DATA_PATH . '/applied_migrations.txt';

	$migrator = new Minz_Migrator($migrations_path);
	$versions = implode("\n", $migrator->versions());
	return @file_put_contents($migrations_version_path, $versions) !== false;
}

<?php

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
	// @phpstan-ignore-next-line
	$data = DATA_PATH && @touch(DATA_PATH . '/index.html');	// is_writable() is not reliable for a folder on NFS
	// @phpstan-ignore-next-line
	$cache = CACHE_PATH && @touch(CACHE_PATH . '/index.html');
	// @phpstan-ignore-next-line
	$tmp = TMP_PATH && is_writable(TMP_PATH);
	// @phpstan-ignore-next-line
	$users = USERS_PATH && @touch(USERS_PATH . '/index.html');
	$favicons = @touch(DATA_PATH . '/favicons/index.html');

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

function getProcessUsername(): string {
	if (function_exists('posix_getpwuid') && function_exists('posix_geteuid')) {
		$processUser = posix_getpwuid(posix_geteuid()) ?: [];
		if (!empty($processUser['name'])) {
			return $processUser['name'];
		}
	}

	if (function_exists('exec')) {
		exec('whoami', $output);
		if (!empty($output[0])) {
			return $output[0];
		}
	}

	return _t('install.check.unknown_process_username');
}

function getOwnerOfFile(String $file): Array {
	clearstatcache();
 	$stat_file = @stat($file);
	$owner = [];
 	if(!$stat_file) {
		//Couldnt stat file
		$owner['fileowner'] = 'unknown';
		$owner['filegroup'] = 'unknown';
		return $owner;
	}
 	if (function_exists('posix_getpwuid') && function_exists('posix_getgrgid')) {
		$owner['fileowner'] = @posix_getpwuid($stat_file['uid'])['name'];
		$owner['filegroup'] = @posix_getgrgid($stat_file['gid'])['name'];
		return $owner;
	};
	$owner['fileowner'] = 'UID: ' . $stat_file['uid'];;
	$owner['filegroup'] = 'GID: ' . $stat_file['gid'];;
	return $owner;
}

function file_permissions(String $path): String {
	$perms = fileperms($path);

	switch ($perms & 0xF000) {
		case 0xC000: // socket
			$info = 's';
			break;
		case 0xA000: // symbolic link
			$info = 'l';
			break;
		case 0x8000: // regular
			$info = 'r';
			break;
		case 0x6000: // block special
			$info = 'b';
			break;
		case 0x4000: // directory
			$info = 'd';
			break;
		case 0x2000: // character special
			$info = 'c';
			break;
		case 0x1000: // FIFO pipe
			$info = 'p';
			break;
		default: // unknown
			$info = 'u';
	}
	
	// Owner
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
		(($perms & 0x0800) ? 's' : 'x' ) :
		(($perms & 0x0800) ? 'S' : '-'));
	
	// Group
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
		(($perms & 0x0400) ? 's' : 'x' ) :
		(($perms & 0x0400) ? 'S' : '-'));
	
	// World
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
		(($perms & 0x0200) ? 't' : 'x' ) :
		(($perms & 0x0200) ? 'T' : '-'));

	return $info;
}

function generateSalt(): string {
	return sha1(uniqid('' . mt_rand(), true).implode('', stat(__FILE__) ?: []));
}

function initDb(): string {
	$conf = FreshRSS_Context::$system_conf;
	$db = $conf->db;
	if (empty($db['pdo_options'])) {
		$db['pdo_options'] = [];
	}
	$db['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$conf->db = $db;	//TODO: Remove this Minz limitation "Indirect modification of overloaded property"

	if (empty($db['type'])) {
		$db['type'] = 'sqlite';
	}

	//Attempt to auto-create database if it does not already exist
	if ($db['type'] !== 'sqlite') {
		Minz_ModelPdo::$usesSharedPdo = false;
		$dbBase = $db['base'] ?? '';
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

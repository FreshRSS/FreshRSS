<?php
if (function_exists('opcache_reset')) {
	opcache_reset();
}

define('BCRYPT_COST', 9);

session_name('FreshRSS');
session_set_cookie_params(0, dirname(empty($_SERVER['REQUEST_URI']) ? '/' : dirname($_SERVER['REQUEST_URI'])), null, false, true);
session_start();

if (isset ($_GET['step'])) {
	define ('STEP', (int)$_GET['step']);
} else {
	define ('STEP', 1);
}

define('SQL_CREATE_DB', 'CREATE DATABASE IF NOT EXISTS %1$s DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;');

if (STEP === 3 && isset($_POST['type'])) {
	$_SESSION['bd_type'] = $_POST['type'];
}

if (isset($_SESSION['bd_type'])) {
	switch ($_SESSION['bd_type']) {
		case 'mysql':
			include(APP_PATH . '/SQL/install.sql.mysql.php');
			break;
		case 'sqlite':
			include(APP_PATH . '/SQL/install.sql.sqlite.php');
			break;
	}
}

//<updates>
define('SQL_BACKUP006', 'RENAME TABLE `%1$scategory` TO `%1$scategory006`, `%1$sfeed` TO `%1$sfeed006`, `%1$sentry` TO `%1$sentry006`;');

define('SQL_SHOW_COLUMNS_UPDATEv006', 'SHOW columns FROM `%1$sentry006` LIKE "id2";');

define('SQL_UPDATEv006', '
ALTER TABLE `%1$scategory006` ADD id2 SMALLINT;

SET @i = 0;
UPDATE `%1$scategory006` SET id2=(@i:=@i+1) ORDER BY id;

ALTER TABLE `%1$sfeed006` ADD id2 SMALLINT, ADD category2 SMALLINT;

SET @i = 0;
UPDATE `%1$sfeed006` SET id2=(@i:=@i+1) ORDER BY name;

UPDATE `%1$sfeed006` f
INNER JOIN `%1$scategory006` c ON f.category = c.id
SET f.category2 = c.id2;

INSERT IGNORE INTO `%2$scategory` (name)
SELECT name
FROM `%1$scategory006`
ORDER BY id2;

INSERT IGNORE INTO `%2$sfeed` (url, category, name, website, description, priority, pathEntries, httpAuth, keep_history)
SELECT url, category2, name, website, description, priority, pathEntries, httpAuth, IF(keep_history = 1, -1, -2)
FROM `%1$sfeed006`
ORDER BY id2;

ALTER TABLE `%1$sentry006` ADD id2 bigint;

UPDATE `%1$sentry006` SET id2 = ((date * 1000000) + (rand() * 100000000));

INSERT IGNORE INTO `%2$sentry` (id, guid, title, author, link, date, is_read, is_favorite, id_feed, tags)
SELECT e0.id2, e0.guid, e0.title, e0.author, e0.link, e0.date, e0.is_read, e0.is_favorite, f0.id2, e0.tags
FROM `%1$sentry006` e0
INNER JOIN `%1$sfeed006` f0 ON e0.id_feed = f0.id;
');

define('SQL_CONVERT_SELECTv006', '
SELECT e0.id2, e0.content
FROM `%1$sentry006` e0
INNER JOIN `%2$sentry` e1 ON e0.id2 = e1.id
WHERE e1.content_bin IS NULL');

define('SQL_CONVERT_UPDATEv006', 'UPDATE `%1$sentry` SET '
	. (isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'mysql' ? 'content_bin=COMPRESS(?)' : 'content=?')
	. ' WHERE id=?;');

define('SQL_DROP_BACKUPv006', 'DROP TABLE IF EXISTS `%1$sentry006`, `%1$sfeed006`, `%1$scategory006`;');

define('SQL_UPDATE_CACHED_VALUES', '
UPDATE `%1$sfeed` f
INNER JOIN (
	SELECT e.id_feed,
	COUNT(CASE WHEN e.is_read = 0 THEN 1 END) AS nbUnreads,
	COUNT(e.id) AS nbEntries
	FROM `%1$sentry` e
	GROUP BY e.id_feed
) x ON x.id_feed=f.id
SET f.cache_nbEntries=x.nbEntries, f.cache_nbUnreads=x.nbUnreads
');

define('SQL_UPDATE_HISTORYv007b', 'UPDATE `%1$sfeed` SET keep_history = CASE WHEN keep_history = 0 THEN -2 WHEN keep_history = 1 THEN -1 ELSE keep_history END;');

define('SQL_GET_FEEDS', 'SELECT id, url, website FROM `%1$sfeed`;');
//</updates>

// gestion internationalisation
$translates = array ();
$actual = 'en';
function initTranslate () {
	global $translates;
	global $actual;

	$actual = isset($_SESSION['language']) ? $_SESSION['language'] : getBetterLanguage('en');

	$file = APP_PATH . '/i18n/' . $actual . '.php';
	if (file_exists($file)) {
		$translates = array_merge($translates, include($file));
	}

	$file = APP_PATH . '/i18n/install.' . $actual . '.php';
	if (file_exists($file)) {
		$translates = array_merge($translates, include($file));
	}
}

function getBetterLanguage ($fallback) {
	$available = availableLanguages ();
	$accept = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$language = strtolower (substr ($accept, 0, 2));

	if (isset ($available[$language])) {
		return $language;
	} else {
		return $fallback;
	}
}
function availableLanguages () {
	return array (
		'en' => 'English',
		'fr' => 'Français'
	);
}
function _t ($key) {
	global $translates;
	$translate = $key;
	if (isset ($translates[$key])) {
		$translate = $translates[$key];
	}

	$args = func_get_args ();
	unset($args[0]);

	return vsprintf ($translate, $args);
}

/*** SAUVEGARDES ***/
function saveLanguage () {
	if (!empty ($_POST)) {
		if (!isset ($_POST['language'])) {
			return false;
		}

		$_SESSION['language'] = $_POST['language'];

		header ('Location: index.php?step=1');
	}
}
function saveStep2 () {
	if (!empty ($_POST)) {
		if (empty ($_POST['title']) ||
		    empty ($_POST['old_entries']) ||
		    empty ($_POST['auth_type']) ||
		    empty ($_POST['default_user'])) {
			return false;
		}

		$_SESSION['salt'] = sha1(uniqid(mt_rand(), true).implode('', stat(__FILE__)));
		$_SESSION['title'] = substr(trim($_POST['title']), 0, 25);
		$_SESSION['old_entries'] = $_POST['old_entries'];
		if ((!ctype_digit($_SESSION['old_entries'])) || ($_SESSION['old_entries'] < 1)) {
			$_SESSION['old_entries'] = 3;
		}
		$_SESSION['mail_login'] = filter_var($_POST['mail_login'], FILTER_VALIDATE_EMAIL);
		$_SESSION['default_user'] = substr(preg_replace('/[^a-zA-Z0-9]/', '', $_POST['default_user']), 0, 16);
		$_SESSION['auth_type'] = $_POST['auth_type'];
		if (!empty($_POST['passwordPlain'])) {
			if (!function_exists('password_hash')) {
				include_once(LIB_PATH . '/password_compat.php');
			}
			$passwordHash = password_hash($_POST['passwordPlain'], PASSWORD_BCRYPT, array('cost' => BCRYPT_COST));
			$passwordHash = preg_replace('/^\$2[xy]\$/', '\$2a\$', $passwordHash);	//Compatibility with bcrypt.js
			$_SESSION['passwordHash'] = $passwordHash;
		}

		$token = '';
		if ($_SESSION['mail_login']) {
			$token = sha1($_SESSION['salt'] . $_SESSION['mail_login']);
		}

		$config_array = array (
			'language' => $_SESSION['language'],
			'theme' => $_SESSION['theme'],
			'old_entries' => $_SESSION['old_entries'],
			'mail_login' => $_SESSION['mail_login'],
			'passwordHash' => $_SESSION['passwordHash'],
			'token' => $token,
		);

		$configPath = DATA_PATH . '/' . $_SESSION['default_user'] . '_user.php';
		@unlink($configPath);	//To avoid access-rights problems
		file_put_contents($configPath, "<?php\n return " . var_export($config_array, true) . ';');

		if ($_SESSION['mail_login'] != '') {
			$personaFile = DATA_PATH . '/persona/' . $_SESSION['mail_login'] . '.txt';
			@unlink($personaFile);
			file_put_contents($personaFile, $_SESSION['default_user']);
		}

		header ('Location: index.php?step=3');
	}
}

function saveStep3 () {
	if (!empty ($_POST)) {
		if ($_SESSION['bd_type'] === 'sqlite') {
			$_SESSION['bd_base'] = $_SESSION['default_user'];
			$_SESSION['bd_host'] = '';
			$_SESSION['bd_user'] = '';
			$_SESSION['bd_password'] = '';
			$_SESSION['bd_prefix'] = '';
			$_SESSION['bd_prefix_user'] = '';	//No prefix for SQLite
		} else {
			if (empty ($_POST['type']) ||
			    empty ($_POST['host']) ||
			    empty ($_POST['user']) ||
			    empty ($_POST['base'])) {
				$_SESSION['bd_error'] = 'Missing parameters!';
			}
			$_SESSION['bd_base'] = substr($_POST['base'], 0, 64);
			$_SESSION['bd_host'] = $_POST['host'];
			$_SESSION['bd_user'] = $_POST['user'];
			$_SESSION['bd_password'] = $_POST['pass'];
			$_SESSION['bd_prefix'] = substr($_POST['prefix'], 0, 16);
			$_SESSION['bd_prefix_user'] = $_SESSION['bd_prefix'] . (empty($_SESSION['default_user']) ? '' : ($_SESSION['default_user'] . '_'));
		}

		$ini_array = array(
			'general' => array(
				'environment' => empty($_SESSION['environment']) ? 'production' : $_SESSION['environment'],
				'salt' => $_SESSION['salt'],
				'base_url' => '',
				'title' => $_SESSION['title'],
				'default_user' => $_SESSION['default_user'],
				'allow_anonymous' => isset($_SESSION['allow_anonymous']) ? $_SESSION['allow_anonymous'] : false,
				'allow_anonymous_refresh' => isset($_SESSION['allow_anonymous_refresh']) ? $_SESSION['allow_anonymous_refresh'] : false,
				'auth_type' => $_SESSION['auth_type'],
				'api_enabled' => isset($_SESSION['api_enabled']) ? $_SESSION['api_enabled'] : false,
				'unsafe_autologin_enabled' => isset($_SESSION['unsafe_autologin_enabled']) ? $_SESSION['unsafe_autologin_enabled'] : false,
			),
			'db' => array(
				'type' => $_SESSION['bd_type'],
				'host' => $_SESSION['bd_host'],
				'user' => $_SESSION['bd_user'],
				'password' => $_SESSION['bd_password'],
				'base' => $_SESSION['bd_base'],
				'prefix' => $_SESSION['bd_prefix'],
			),
		);

		@unlink(DATA_PATH . '/config.php');	//To avoid access-rights problems
		file_put_contents(DATA_PATH . '/config.php', "<?php\n return " . var_export($ini_array, true) . ';');

		if (file_exists(DATA_PATH . '/config.php') && file_exists(DATA_PATH . '/application.ini')) {
			@unlink(DATA_PATH . '/application.ini');	//v0.6
		}

		$res = checkBD ();

		if ($res) {
			$_SESSION['bd_error'] = '';
			header ('Location: index.php?step=4');
		} elseif (empty($_SESSION['bd_error'])) {
			$_SESSION['bd_error'] = 'Unknown error!';
		}
	}
	invalidateHttpCache();
}

function updateDatabase($perform = false) {
	$needs = array('bd_type', 'bd_host', 'bd_base', 'bd_user', 'bd_password', 'bd_prefix', 'bd_prefix_user');
	foreach ($needs as $need) {
		if (!isset($_SESSION[$need])) {
			return false;
		}
	}

	try {
		$str = '';
		switch ($_SESSION['bd_type']) {
			case 'mysql':
				$str = 'mysql:host=' . $_SESSION['bd_host'] . ';dbname=' . $_SESSION['bd_base'];
				$driver_options = array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
				);
				break;
			case 'sqlite':
				return false;	//No update for SQLite needed so far
			default:
				return false;
		}

		$c = new PDO($str, $_SESSION['bd_user'], $_SESSION['bd_password'], $driver_options);

		$stm = $c->prepare(SQL_SHOW_TABLES);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		if (!in_array($_SESSION['bd_prefix'] . 'entry006', $res)) {
			return false;
		}

		$sql = sprintf(SQL_SHOW_COLUMNS_UPDATEv006, $_SESSION['bd_prefix']);
		$stm = $c->prepare($sql);
		$stm->execute();
		$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
		if (!in_array('id2', $res)) {
			if (!$perform) {
				return true;
			}
			$sql = sprintf(SQL_UPDATEv006, $_SESSION['bd_prefix'], $_SESSION['bd_prefix_user']);
			$stm = $c->prepare($sql, array(PDO::ATTR_EMULATE_PREPARES => true));
			$stm->execute();
		}

		$sql = sprintf(SQL_CONVERT_SELECTv006, $_SESSION['bd_prefix'], $_SESSION['bd_prefix_user']);
		if (!$perform) {
			$sql .= ' LIMIT 1';
		}
		$stm = $c->prepare($sql);
		$stm->execute();
		if (!$perform) {
			$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
			return count($res) > 0;
		} else {
			@set_time_limit(300);
		}

		$c2 = new PDO($str, $_SESSION['bd_user'], $_SESSION['bd_password'], $driver_options);
		$sql = sprintf(SQL_CONVERT_UPDATEv006, $_SESSION['bd_prefix_user']);
		$stm2 = $c2->prepare($sql);
		while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			$id = $row['id2'];
			$content = unserialize(gzinflate(base64_decode($row['content'])));
			$stm2->execute(array($content, $id));
		}

		return true;
	} catch (PDOException $e) {
		return false;
	}
	return false;
}

function newPdo() {
	switch ($_SESSION['bd_type']) {
		case 'mysql':
			$str = 'mysql:host=' . $_SESSION['bd_host'] . ';dbname=' . $_SESSION['bd_base'];
			$driver_options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
			break;
		case 'sqlite':
			$str = 'sqlite:' . DATA_PATH . '/' . $_SESSION['default_user'] . '.sqlite';
			$driver_options = array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			);
			break;
		default:
			return false;
	}
	return new PDO($str, $_SESSION['bd_user'], $_SESSION['bd_password'], $driver_options);
}

function postUpdate() {
	$c = newPdo();

	if ($_SESSION['bd_type'] !== 'sqlite') {	//No update for SQLite needed yet
		$sql = sprintf(SQL_UPDATE_HISTORYv007b, $_SESSION['bd_prefix_user']);
		$stm = $c->prepare($sql);
		$stm->execute();

		$sql = sprintf(SQL_UPDATE_CACHED_VALUES, $_SESSION['bd_prefix_user']);
		$stm = $c->prepare($sql);
		$stm->execute();
	}

	//<favicons>
	$sql = sprintf(SQL_GET_FEEDS, $_SESSION['bd_prefix_user']);
	$stm = $c->prepare($sql);
	$stm->execute();
	$res = $stm->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $feed) {
		if (empty($feed['url'])) {
			continue;
		}
		$hash = hash('crc32b', $_SESSION['salt'] . $feed['url']);
		@file_put_contents(DATA_PATH . '/favicons/' . $hash . '.txt',
			empty($feed['website']) ? $feed['url'] : $feed['website']);
	}
	//</favicons>
}

function deleteInstall () {
	$res = unlink (DATA_PATH . '/do-install.txt');
	if ($res) {
		header ('Location: index.php');
	}

	$needs = array('bd_type', 'bd_host', 'bd_base', 'bd_user', 'bd_password', 'bd_prefix');
	foreach ($needs as $need) {
		if (!isset($_SESSION[$need])) {
			return false;
		}
	}

	try {
		$c = newPdo();
		$sql = sprintf(SQL_DROP_BACKUPv006, $_SESSION['bd_prefix']);
		$stm = $c->prepare($sql);
		$stm->execute();

		return true;
	} catch (PDOException $e) {
		return false;
	}
	return false;
}

function moveOldFiles() {
	$mvs = array(
		'/app/configuration/application.ini' => '/data/application.ini',	//v0.6
		'/public/data/Configuration.array.php' => '/data/Configuration.array.php',	//v0.6
	);
	$ok = true;
	foreach ($mvs as $fFrom => $fTo) {
		if (file_exists(FRESHRSS_PATH . $fFrom)) {
			if (copy(FRESHRSS_PATH . $fFrom, FRESHRSS_PATH . $fTo)) {
				@unlink(FRESHRSS_PATH . $fFrom);
			} else {
				$ok = false;
			}
		}
	}
	return $ok;
}

function delTree($dir) {	//http://php.net/rmdir#110489
	if (!is_dir($dir)) {
		return true;
	}
	$files = array_diff(scandir($dir), array('.', '..'));
	foreach ($files as $file) {
		$f = $dir . '/' . $file;
		if (is_dir($f)) {
			@chmod($f, 0777);
			delTree($f);
		}
		else unlink($f);
	}
	return rmdir($dir);
}

/*** VÉRIFICATIONS ***/
function checkStep () {
	$s0 = checkStep0 ();
	$s1 = checkStep1 ();
	$s2 = checkStep2 ();
	$s3 = checkStep3 ();
	if (STEP > 0 && $s0['all'] != 'ok') {
		header ('Location: index.php?step=0');
	} elseif (STEP > 1 && $s1['all'] != 'ok') {
		header ('Location: index.php?step=1');
	} elseif (STEP > 2 && $s2['all'] != 'ok') {
		header ('Location: index.php?step=2');
	} elseif (STEP > 3 && $s3['all'] != 'ok') {
		header ('Location: index.php?step=3');
	}
	$_SESSION['actualize_feeds'] = true;
}
function checkStep0 () {
	moveOldFiles();

	if (file_exists(DATA_PATH . '/config.php')) {
		$ini_array = include(DATA_PATH . '/config.php');
	} elseif (file_exists(DATA_PATH . '/application.ini')) {	//v0.6
		$ini_array = parse_ini_file(DATA_PATH . '/application.ini', true);
		$ini_array['general']['title'] = empty($ini_array['general']['title']) ? '' : stripslashes($ini_array['general']['title']);
	} else {
		$ini_array = null;
	}

	if ($ini_array) {
		$ini_general = isset($ini_array['general']) ? $ini_array['general'] : null;
		if ($ini_general) {
			$keys = array('environment', 'salt', 'title', 'default_user', 'allow_anonymous', 'allow_anonymous_refresh', 'auth_type', 'api_enabled', 'unsafe_autologin_enabled');
			foreach ($keys as $key) {
				if ((empty($_SESSION[$key])) && isset($ini_general[$key])) {
					$_SESSION[$key] = $ini_general[$key];
				}
			}
		}
		$ini_db = isset($ini_array['db']) ? $ini_array['db'] : null;
		if ($ini_db) {
			$keys = array('type', 'host', 'user', 'password', 'base', 'prefix');
			foreach ($keys as $key) {
				if ((!isset($_SESSION['bd_' . $key])) && isset($ini_db[$key])) {
					$_SESSION['bd_' . $key] = $ini_db[$key];
				}
			}
		}
	}

	if (isset($_SESSION['default_user']) && file_exists(DATA_PATH . '/' . $_SESSION['default_user'] . '_user.php')) {
		$userConfig = include(DATA_PATH . '/' . $_SESSION['default_user'] . '_user.php');
	} elseif (file_exists(DATA_PATH . '/Configuration.array.php')) {
		$userConfig = include(DATA_PATH . '/Configuration.array.php');	//v0.6
		if (empty($_SESSION['auth_type'])) {
			$_SESSION['auth_type'] = empty($userConfig['mail_login']) ? 'none' : 'persona';
		}
		if (!isset($_SESSION['allow_anonymous'])) {
			$_SESSION['allow_anonymous'] = empty($userConfig['anon_access']) ? false : ($userConfig['anon_access'] === 'yes');
		}
	} else {
		$userConfig = array();
	}
	if (empty($_SESSION['auth_type'])) {	//v0.7b
		$_SESSION['auth_type'] = '';
	}

	$keys = array('language', 'theme', 'old_entries', 'mail_login', 'passwordHash');
	foreach ($keys as $key) {
		if ((!isset($_SESSION[$key])) && isset($userConfig[$key])) {
			$_SESSION[$key] = $userConfig[$key];
		}
	}

	$languages = availableLanguages ();
	$language = isset ($_SESSION['language']) &&
	            isset ($languages[$_SESSION['language']]);

	if (empty($_SESSION['passwordHash'])) {	//v0.7b
		$_SESSION['passwordHash'] = '';
	}
	if (empty($_SESSION['theme'])) {
		$_SESSION['theme'] = 'Origine';
	} else {
		switch (strtolower($_SESSION['theme'])) {
			case 'default':	//v0.7b
				$_SESSION['theme'] = 'Origine';
				break;
			case 'flat-design':	//v0.7b
				$_SESSION['theme'] = 'Flat';
				break;
			case 'default_dark':	//v0.7b
				$_SESSION['theme'] = 'Dark';
				break;
		}
	}

	return array (
		'language' => $language ? 'ok' : 'ko',
		'all' => $language ? 'ok' : 'ko'
	);
}

function checkStep1 () {
	$php = version_compare (PHP_VERSION, '5.2.1') >= 0;
	$minz = file_exists (LIB_PATH . '/Minz');
	$curl = extension_loaded ('curl');
	$pdo_mysql = extension_loaded ('pdo_mysql');
	$pdo_sqlite = extension_loaded ('pdo_sqlite');
	$pdo = $pdo_mysql || $pdo_sqlite;
	$pcre = extension_loaded ('pcre');
	$ctype = extension_loaded ('ctype');
	$dom = class_exists('DOMDocument');
	$data = DATA_PATH && is_writable (DATA_PATH);
	$cache = CACHE_PATH && is_writable (CACHE_PATH);
	$log = LOG_PATH && is_writable (LOG_PATH);
	$favicons = is_writable (DATA_PATH . '/favicons');
	$persona = is_writable (DATA_PATH . '/persona');

	return array (
		'php' => $php ? 'ok' : 'ko',
		'minz' => $minz ? 'ok' : 'ko',
		'curl' => $curl ? 'ok' : 'ko',
		'pdo-mysql' => $pdo_mysql ? 'ok' : 'ko',
		'pdo-sqlite' => $pdo_sqlite ? 'ok' : 'ko',
		'pdo' => $pdo ? 'ok' : 'ko',
		'pcre' => $pcre ? 'ok' : 'ko',
		'ctype' => $ctype ? 'ok' : 'ko',
		'dom' => $dom ? 'ok' : 'ko',
		'data' => $data ? 'ok' : 'ko',
		'cache' => $cache ? 'ok' : 'ko',
		'log' => $log ? 'ok' : 'ko',
		'favicons' => $favicons ? 'ok' : 'ko',
		'persona' => $persona ? 'ok' : 'ko',
		'all' => $php && $minz && $curl && $pdo && $pcre && $ctype && $dom && $data && $cache && $log && $favicons && $persona ? 'ok' : 'ko'
	);
}

function checkStep2 () {
	$conf = !empty($_SESSION['salt']) &&
	        !empty($_SESSION['title']) &&
	        !empty($_SESSION['old_entries']) &&
	        isset($_SESSION['mail_login']) &&
	        !empty($_SESSION['default_user']);
	$defaultUser = empty($_POST['default_user']) ? null : $_POST['default_user'];
	if ($defaultUser === null) {
		$defaultUser = empty($_SESSION['default_user']) ? '' : $_SESSION['default_user'];
	}
	$data = is_writable(DATA_PATH . '/' . $defaultUser . '_user.php');
	if ($data) {
		@unlink(DATA_PATH . '/Configuration.array.php');	//v0.6
	}

	return array (
		'conf' => $conf ? 'ok' : 'ko',
		'data' => $data ? 'ok' : 'ko',
		'all' => $conf && $data ? 'ok' : 'ko'
	);
}
function checkStep3 () {
	$conf = is_writable(DATA_PATH . '/config.php');

	$bd = isset ($_SESSION['bd_type']) &&
	      isset ($_SESSION['bd_host']) &&
	      isset ($_SESSION['bd_user']) &&
	      isset ($_SESSION['bd_password']) &&
	      isset ($_SESSION['bd_base']) &&
	      isset ($_SESSION['bd_prefix']) &&
	      isset ($_SESSION['bd_error']);
	$conn = empty($_SESSION['bd_error']);

	return array (
		'bd' => $bd ? 'ok' : 'ko',
		'conn' => $conn ? 'ok' : 'ko',
		'conf' => $conf ? 'ok' : 'ko',
		'all' => $bd && $conn && $conf ? 'ok' : 'ko'
	);
}

function checkBD () {
	$ok = false;

	try {
		$str = '';
		$driver_options = null;
		switch ($_SESSION['bd_type']) {
			case 'mysql':
				$driver_options = array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
				);

				try {	// on ouvre une connexion juste pour créer la base si elle n'existe pas
					$str = 'mysql:host=' . $_SESSION['bd_host'] . ';';
					$c = new PDO ($str, $_SESSION['bd_user'], $_SESSION['bd_password'], $driver_options);
					$sql = sprintf (SQL_CREATE_DB, $_SESSION['bd_base']);
					$res = $c->query ($sql);
				} catch (PDOException $e) {
				}

				// on écrase la précédente connexion en sélectionnant la nouvelle BDD
				$str = 'mysql:host=' . $_SESSION['bd_host'] . ';dbname=' . $_SESSION['bd_base'];
				break;
			case 'sqlite':
				$str = 'sqlite:' . DATA_PATH . '/' . $_SESSION['default_user'] . '.sqlite';
				$driver_options = array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				);
				break;
			default:
				return false;
		}

		$c = new PDO ($str, $_SESSION['bd_user'], $_SESSION['bd_password'], $driver_options);

		if ($_SESSION['bd_type'] !== 'sqlite') {	//No SQL backup for SQLite
			$stm = $c->prepare(SQL_SHOW_TABLES);
			$stm->execute();
			$res = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
			if (in_array($_SESSION['bd_prefix'] . 'entry', $res) && !in_array($_SESSION['bd_prefix'] . 'entry006', $res)) {
				$sql = sprintf(SQL_BACKUP006, $_SESSION['bd_prefix']);	//v0.6
				$res = $c->query($sql);	//Backup tables
			}
		}

		if (defined('SQL_CREATE_TABLES')) {
			$sql = sprintf(SQL_CREATE_TABLES, $_SESSION['bd_prefix_user'], _t('default_category'));
			$stm = $c->prepare($sql);
			$ok = $stm->execute();
		} else {
			global $SQL_CREATE_TABLES;
			if (is_array($SQL_CREATE_TABLES)) {
				$ok = true;
				foreach ($SQL_CREATE_TABLES as $instruction) {
					$sql = sprintf($instruction, $_SESSION['bd_prefix_user'], _t('default_category'));
					$stm = $c->prepare($sql);
					$ok &= $stm->execute();
				}
			}
		}
	} catch (PDOException $e) {
		$ok = false;
		$_SESSION['bd_error'] = $e->getMessage();
	}

	if (!$ok) {
		@unlink(DATA_PATH . '/config.php');
	}

	return $ok;
}

/*** AFFICHAGE ***/
function printStep0 () {
	global $actual;
?>
	<?php $s0 = checkStep0 (); if ($s0['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('language_defined'); ?></p>
	<?php } ?>

	<form action="index.php?step=0" method="post">
		<legend><?php echo _t ('choose_language'); ?></legend>
		<div class="form-group">
			<label class="group-name" for="language"><?php echo _t ('language'); ?></label>
			<div class="group-controls">
				<select name="language" id="language">
				<?php $languages = availableLanguages (); ?>
				<?php foreach ($languages as $short => $lib) { ?>
				<option value="<?php echo $short; ?>"<?php echo $actual == $short ? ' selected="selected"' : ''; ?>><?php echo $lib; ?></option>
				<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important"><?php echo _t ('save'); ?></button>
				<button type="reset" class="btn"><?php echo _t ('cancel'); ?></button>
				<?php if ($s0['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=1"><?php echo _t ('next_step'); ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function printStep1 () {
	$res = checkStep1 ();
?>
	<noscript><p class="alert alert-warn"><span class="alert-head"><?php echo _t ('attention'); ?></span> <?php echo _t ('javascript_is_better'); ?></p></noscript>

	<?php if ($res['php'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('php_is_ok', PHP_VERSION); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('php_is_nok', PHP_VERSION, '5.2.1'); ?></p>
	<?php } ?>

	<?php if ($res['minz'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('minz_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('minz_is_nok', LIB_PATH . '/Minz'); ?></p>
	<?php } ?>

	<?php if ($res['pdo'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('pdo_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('pdo_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['curl'] == 'ok') { ?>
	<?php $version = curl_version(); ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('curl_is_ok', $version['version']); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('curl_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['pcre'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('pcre_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('pcre_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['ctype'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('ctype_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('ctype_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['dom'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('dom_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('dom_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['data'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('data_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('file_is_nok', DATA_PATH); ?></p>
	<?php } ?>

	<?php if ($res['cache'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('cache_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('file_is_nok', CACHE_PATH); ?></p>
	<?php } ?>

	<?php if ($res['log'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('log_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('file_is_nok', LOG_PATH); ?></p>
	<?php } ?>

	<?php if ($res['favicons'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('favicons_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('file_is_nok', DATA_PATH . '/favicons'); ?></p>
	<?php } ?>

	<?php if ($res['persona'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('persona_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('file_is_nok', DATA_PATH . '/persona'); ?></p>
	<?php } ?>

	<?php if ($res['all'] == 'ok') { ?>
	<a class="btn btn-important next-step" href="?step=2"><?php echo _t ('next_step'); ?></a>
	<?php } else { ?>
	<p class="alert alert-error"><?php echo _t ('fix_errors_before'); ?></p>
	<?php } ?>
<?php
}

function printStep2 () {
?>
	<?php $s2 = checkStep2 (); if ($s2['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('general_conf_is_ok'); ?></p>
	<?php } ?>

	<form action="index.php?step=2" method="post">
		<legend><?php echo _t ('general_configuration'); ?></legend>

		<div class="form-group">
			<label class="group-name" for="title"><?php echo _t ('title'); ?></label>
			<div class="group-controls">
				<input type="text" id="title" name="title" value="<?php echo isset ($_SESSION['title']) ? $_SESSION['title'] : _t ('freshrss'); ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="old_entries"><?php echo _t ('delete_articles_every'); ?></label>
			<div class="group-controls">
				<input type="number" id="old_entries" name="old_entries" required="required" min="1" max="1200" value="<?php echo isset ($_SESSION['old_entries']) ? $_SESSION['old_entries'] : '3'; ?>" /> <?php echo _t ('month'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="default_user"><?php echo _t ('default_user'); ?></label>
			<div class="group-controls">
				<input type="text" id="default_user" name="default_user" required="required" size="16" maxlength="16" pattern="[0-9a-zA-Z]{1,16}" value="<?php echo isset ($_SESSION['default_user']) ? $_SESSION['default_user'] : ''; ?>" placeholder="<?php echo httpAuthUser() == '' ? 'user1' : httpAuthUser(); ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="auth_type"><?php echo _t('auth_type'); ?></label>
			<div class="group-controls">
				<select id="auth_type" name="auth_type" required="required">
					<?php if (!in_array($_SESSION['auth_type'], array('form', 'persona', 'http_auth', 'none'))) { ?>
						<option selected="selected"></option>
					<?php } ?>
					<option value="form"<?php echo $_SESSION['auth_type'] === 'form' ? ' selected="selected"' : '', cryptAvailable() ? '' : ' disabled="disabled"'; ?>><?php echo _t('auth_form'); ?></option>
					<option value="persona"<?php echo $_SESSION['auth_type'] === 'persona' ? ' selected="selected"' : ''; ?>><?php echo _t('auth_persona'); ?></option>
					<option value="http_auth"<?php echo $_SESSION['auth_type'] === 'http_auth' ? ' selected="selected"' : '', httpAuthUser() == '' ? ' disabled="disabled"' : ''; ?>><?php echo _t('http_auth'); ?> (REMOTE_USER = '<?php echo httpAuthUser(); ?>')</option>
					<option value="none"<?php echo $_SESSION['auth_type'] === 'none' ? ' selected="selected"' : ''; ?>><?php echo _t('auth_none'); ?></option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="passwordPlain"><?php echo _t('password_form'); ?></label>
			<div class="group-controls">
				<input type="password" id="passwordPlain" name="passwordPlain" pattern=".{7,}" autocomplete="off" />
				<noscript><b><?php echo _t('javascript_should_be_activated'); ?></b></noscript>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="mail_login"><?php echo _t ('persona_connection_email'); ?></label>
			<div class="group-controls">
				<input type="email" id="mail_login" name="mail_login" value="<?php echo isset ($_SESSION['mail_login']) ? $_SESSION['mail_login'] : ''; ?>" placeholder="alice@example.net" />
				<noscript><b><?php echo _t ('javascript_should_be_activated'); ?></b></noscript>
			</div>
		</div>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important"><?php echo _t ('save'); ?></button>
				<button type="reset" class="btn"><?php echo _t ('cancel'); ?></button>
				<?php if ($s2['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=3"><?php echo _t ('next_step'); ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function printStep3 () {
?>
	<?php $s3 = checkStep3 (); if ($s3['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('bdd_conf_is_ok'); ?></p>
	<?php } elseif ($s3['conn'] == 'ko') { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('bdd_conf_is_ko'), (empty($_SESSION['bd_error']) ? '' : ' : ' . $_SESSION['bd_error']); ?></p>
	<?php } ?>

	<form action="index.php?step=3" method="post">
		<legend><?php echo _t ('bdd_configuration'); ?></legend>
		<div class="form-group">
			<label class="group-name" for="type"><?php echo _t ('bdd_type'); ?></label>
			<div class="group-controls">
				<select name="type" id="type" onchange="mySqlShowHide()">
				<?php if (extension_loaded('pdo_mysql')) {?>
				<option value="mysql"
					<?php echo (isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'mysql') ? 'selected="selected"' : ''; ?>>
					MySQL
				</option>
				<?php }?>
				<?php if (extension_loaded('pdo_sqlite')) {?>
				<option value="sqlite"
					<?php echo (isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'sqlite') ? 'selected="selected"' : ''; ?>>
					SQLite
				</option>
				<?php }?>
				</select>
			</div>
		</div>

		<div id="mysql">
		<div class="form-group">
			<label class="group-name" for="host"><?php echo _t ('host'); ?></label>
			<div class="group-controls">
				<input type="text" id="host" name="host" pattern="[0-9A-Za-z_.-]{1,64}" value="<?php echo isset ($_SESSION['bd_host']) ? $_SESSION['bd_host'] : 'localhost'; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="user"><?php echo _t ('username'); ?></label>
			<div class="group-controls">
				<input type="text" id="user" name="user" maxlength="16" pattern="[0-9A-Za-z_.-]{1,16}" value="<?php echo isset ($_SESSION['bd_user']) ? $_SESSION['bd_user'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="pass"><?php echo _t ('password'); ?></label>
			<div class="group-controls">
				<input type="password" id="pass" name="pass" value="<?php echo isset ($_SESSION['bd_password']) ? $_SESSION['bd_password'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="base"><?php echo _t ('bdd'); ?></label>
			<div class="group-controls">
				<input type="text" id="base" name="base" maxlength="64" pattern="[0-9A-Za-z_]{1,64}" value="<?php echo isset ($_SESSION['bd_base']) ? $_SESSION['bd_base'] : ''; ?>" placeholder="freshrss" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="prefix"><?php echo _t ('prefix'); ?></label>
			<div class="group-controls">
				<input type="text" id="prefix" name="prefix" maxlength="16" pattern="[0-9A-Za-z_]{1,16}" value="<?php echo isset ($_SESSION['bd_prefix']) ? $_SESSION['bd_prefix'] : 'freshrss_'; ?>" />
			</div>
		</div>
		</div>
		<script>
			function mySqlShowHide() {
				document.getElementById('mysql').style.display = document.getElementById('type').value === 'mysql' ? 'block' : 'none';
			}
			mySqlShowHide();
		</script>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important"><?php echo _t ('save'); ?></button>
				<button type="reset" class="btn"><?php echo _t ('cancel'); ?></button>
				<?php if ($s3['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=4"><?php echo _t ('next_step'); ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function printStep4 () {
?>
	<form action="index.php?step=4" method="post">
		<legend><?php echo _t ('version_update'); ?></legend>

		<?php if (updateDatabase(false)) { ?>
		<p class="alert alert-warn"><?php echo _t ('update_long'); ?></p>

		<div class="form-group form-actions">
			<div class="group-controls">
				<input type="hidden" name="updateDatabase" value="1" />
				<button type="submit" class="btn btn-important"><?php echo _t ('update_start'); ?></button>
			</div>
		</div>

		<?php } else { ?>
		<p class="alert alert-warn"><?php echo _t ('update_end'); ?></p>

		<div class="form-group form-actions">
			<div class="group-controls">
				<a class="btn btn-important next-step" href="?step=5"><?php echo _t ('next_step'); ?></a>
			</div>
		</div>
		<?php } ?>
	</form>
<?php
}

function printStep5 () {
?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('congratulations'); ?></span> <?php echo _t ('installation_is_ok'); ?></p>
	<a class="btn btn-important next-step" href="?step=6"><?php echo _t ('finish_installation'); ?></a>
<?php
}

function printStep6 () {
?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('oops'); ?></span> <?php echo _t ('install_not_deleted', DATA_PATH . '/do-install.txt'); ?></p>
<?php
}

checkStep ();

initTranslate ();

switch (STEP) {
case 0:
default:
	saveLanguage ();
	break;
case 1:
	break;
case 2:
	saveStep2 ();
	break;
case 3:
	saveStep3 ();
	break;
case 4:
	if (!empty($_POST['updateDatabase'])) {
		updateDatabase(true);
	}
	break;
case 5:
	postUpdate();
	break;
case 6:
	deleteInstall ();
	break;
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0">
		<title><?php echo _t ('freshrss_installation'); ?></title>
		<link rel="stylesheet" type="text/css" media="all" href="../themes/Origine/template.css" />
		<link rel="stylesheet" type="text/css" media="all" href="../themes/Origine/origine.css" />
	</head>
	<body>

<div class="header">
	<div class="item title">
		<h1><a href="index.php"><?php echo _t ('freshrss'); ?></a></h1>
		<h2><?php echo _t ('installation_step', STEP); ?></h2>
	</div>
</div>

<div id="global">
	<ul class="nav nav-list aside">
		<li class="nav-header"><?php echo _t ('steps'); ?></li>
		<li class="item<?php echo STEP == 0 ? ' active' : ''; ?>"><a href="?step=0"><?php echo _t ('language'); ?></a></li>
		<li class="item<?php echo STEP == 1 ? ' active' : ''; ?>"><a href="?step=1"><?php echo _t ('checks'); ?></a></li>
		<li class="item<?php echo STEP == 2 ? ' active' : ''; ?>"><a href="?step=2"><?php echo _t ('general_configuration'); ?></a></li>
		<li class="item<?php echo STEP == 3 ? ' active' : ''; ?>"><a href="?step=3"><?php echo _t ('bdd_configuration'); ?></a></li>
		<li class="item<?php echo STEP == 4 ? ' active' : ''; ?>"><a href="?step=4"><?php echo _t ('version_update'); ?></a></li>
		<li class="item<?php echo STEP == 5 ? ' active' : ''; ?>"><a href="?step=5"><?php echo _t ('this_is_the_end'); ?></a></li>
	</ul>

	<div class="post">
		<?php
		switch (STEP) {
		case 0:
		default:
			printStep0 ();
			break;
		case 1:
			printStep1 ();
			break;
		case 2:
			printStep2 ();
			break;
		case 3:
			printStep3 ();
			break;
		case 4:
			printStep4 ();
			break;
		case 5:
			printStep5 ();
			break;
		case 6:
			printStep6 ();
			break;
		}
		?>
	</div>
</div>
	</body>
</html>

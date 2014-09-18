<?php
if (function_exists('opcache_reset')) {
	opcache_reset();
}

define('BCRYPT_COST', 9);

session_name('FreshRSS');
session_set_cookie_params(0, dirname(empty($_SERVER['REQUEST_URI']) ? '/' : dirname($_SERVER['REQUEST_URI'])), null, false, true);
session_start();

if (isset($_GET['step'])) {
	define('STEP',(int)$_GET['step']);
} else {
	define('STEP', 0);
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

function param($key, $default = false) {
	if (isset($_POST[$key])) {
		return $_POST[$key];
	} else {
		return $default;
	}
}


// gestion internationalisation
$translates = array();
$actual = 'en';
function initTranslate() {
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

function getBetterLanguage($fallback) {
	$available = availableLanguages();
	$accept = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	$language = strtolower(substr($accept, 0, 2));

	if (isset($available[$language])) {
		return $language;
	} else {
		return $fallback;
	}
}

function availableLanguages() {
	return array(
		'en' => 'English',
		'fr' => 'Français'
	);
}

function _t($key) {
	global $translates;
	$translate = $key;
	if (isset($translates[$key])) {
		$translate = $translates[$key];
	}

	$args = func_get_args();
	unset($args[0]);

	return vsprintf($translate, $args);
}


/*** SAUVEGARDES ***/
function saveLanguage() {
	if (!empty($_POST)) {
		if (!isset($_POST['language'])) {
			return false;
		}

		$_SESSION['language'] = $_POST['language'];

		header('Location: index.php?step=1');
	}
}

function saveStep2() {
	if (!empty($_POST)) {
		$_SESSION['title'] = substr(trim(param('title', _t('freshrss'))), 0, 25);
		$_SESSION['old_entries'] = param('old_entries', 3);
		$_SESSION['auth_type'] = param('auth_type', 'form');
		$_SESSION['default_user'] = substr(preg_replace('/[^a-zA-Z0-9]/', '', param('default_user', '')), 0, 16);
		$_SESSION['mail_login'] = filter_var(param('mail_login', ''), FILTER_VALIDATE_EMAIL);

		$password_plain = param('passwordPlain', false);
		if ($password_plain !== false) {
			if (!function_exists('password_hash')) {
				include_once(LIB_PATH . '/password_compat.php');
			}
			$passwordHash = password_hash($password_plain, PASSWORD_BCRYPT, array('cost' => BCRYPT_COST));
			$passwordHash = preg_replace('/^\$2[xy]\$/', '\$2a\$', $passwordHash);	//Compatibility with bcrypt.js
			$_SESSION['passwordHash'] = $passwordHash;
		}

		if (empty($_SESSION['title']) ||
		    empty($_SESSION['old_entries']) ||
		    empty($_SESSION['auth_type']) ||
		    empty($_SESSION['default_user'])) {
			return false;
		}

		if (($_SESSION['auth_type'] === 'form' && empty($_SESSION['passwordHash'])) ||
				($_SESSION['auth_type'] === 'persona' && empty($_SESSION['mail_login']))) {
			return false;
		}

		$_SESSION['salt'] = sha1(uniqid(mt_rand(), true).implode('', stat(__FILE__)));
		if ((!ctype_digit($_SESSION['old_entries'])) ||($_SESSION['old_entries'] < 1)) {
			$_SESSION['old_entries'] = 3;
		}

		$token = '';
		if ($_SESSION['mail_login']) {
			$token = sha1($_SESSION['salt'] . $_SESSION['mail_login']);
		}

		$config_array = array(
			'language' => $_SESSION['language'],
			'theme' => 'Origine',
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

		header('Location: index.php?step=3');
	}
}

function saveStep3() {
	if (!empty($_POST)) {
		if ($_SESSION['bd_type'] === 'sqlite') {
			$_SESSION['bd_base'] = $_SESSION['default_user'];
			$_SESSION['bd_host'] = '';
			$_SESSION['bd_user'] = '';
			$_SESSION['bd_password'] = '';
			$_SESSION['bd_prefix'] = '';
			$_SESSION['bd_prefix_user'] = '';	//No prefix for SQLite
		} else {
			if (empty($_POST['type']) ||
			    empty($_POST['host']) ||
			    empty($_POST['user']) ||
			    empty($_POST['base'])) {
				$_SESSION['bd_error'] = 'Missing parameters!';
			}
			$_SESSION['bd_base'] = substr($_POST['base'], 0, 64);
			$_SESSION['bd_host'] = $_POST['host'];
			$_SESSION['bd_user'] = $_POST['user'];
			$_SESSION['bd_password'] = $_POST['pass'];
			$_SESSION['bd_prefix'] = substr($_POST['prefix'], 0, 16);
			$_SESSION['bd_prefix_user'] = $_SESSION['bd_prefix'] .(empty($_SESSION['default_user']) ? '' :($_SESSION['default_user'] . '_'));
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

		$res = checkBD();

		if ($res) {
			$_SESSION['bd_error'] = '';
			header('Location: index.php?step=4');
		} elseif (empty($_SESSION['bd_error'])) {
			$_SESSION['bd_error'] = 'Unknown error!';
		}
	}
	invalidateHttpCache();
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

function deleteInstall() {
	$res = unlink(DATA_PATH . '/do-install.txt');

	if (!$res) {
		return false;
	}

	header('Location: index.php');
}


/*** VÉRIFICATIONS ***/
function checkStep() {
	$s0 = checkStep0();
	$s1 = checkStep1();
	$s2 = checkStep2();
	$s3 = checkStep3();
	if (STEP > 0 && $s0['all'] != 'ok') {
		header('Location: index.php?step=0');
	} elseif (STEP > 1 && $s1['all'] != 'ok') {
		header('Location: index.php?step=1');
	} elseif (STEP > 2 && $s2['all'] != 'ok') {
		header('Location: index.php?step=2');
	} elseif (STEP > 3 && $s3['all'] != 'ok') {
		header('Location: index.php?step=3');
	}
	$_SESSION['actualize_feeds'] = true;
}

function checkStep0() {
	$languages = availableLanguages();
	$language = isset($_SESSION['language']) &&
	            isset($languages[$_SESSION['language']]);

	return array(
		'language' => $language ? 'ok' : 'ko',
		'all' => $language ? 'ok' : 'ko'
	);
}

function checkStep1() {
	$php = version_compare(PHP_VERSION, '5.2.1') >= 0;
	$minz = file_exists(LIB_PATH . '/Minz');
	$curl = extension_loaded('curl');
	$pdo_mysql = extension_loaded('pdo_mysql');
	$pdo_sqlite = extension_loaded('pdo_sqlite');
	$pdo = $pdo_mysql || $pdo_sqlite;
	$pcre = extension_loaded('pcre');
	$ctype = extension_loaded('ctype');
	$dom = class_exists('DOMDocument');
	$data = DATA_PATH && is_writable(DATA_PATH);
	$cache = CACHE_PATH && is_writable(CACHE_PATH);
	$log = LOG_PATH && is_writable(LOG_PATH);
	$favicons = is_writable(DATA_PATH . '/favicons');
	$persona = is_writable(DATA_PATH . '/persona');
	$http_referer = is_referer_from_same_domain();

	return array(
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
		'http_referer' => $http_referer ? 'ok' : 'ko',
		'all' => $php && $minz && $curl && $pdo && $pcre && $ctype && $dom &&
		         $data && $cache && $log && $favicons && $persona && $http_referer ?
		         'ok' : 'ko'
	);
}

function checkStep2() {
	$conf = !empty($_SESSION['title']) &&
	        !empty($_SESSION['old_entries']) &&
	        isset($_SESSION['mail_login']) &&
	        !empty($_SESSION['default_user']);

	$form = (
		isset($_SESSION['auth_type']) &&
		($_SESSION['auth_type'] != 'form' || !empty($_SESSION['passwordHash']))
	);

	$persona = (
		isset($_SESSION['auth_type']) &&
		($_SESSION['auth_type'] != 'persona' || !empty($_SESSION['mail_login']))
	);

	$defaultUser = empty($_POST['default_user']) ? null : $_POST['default_user'];
	if ($defaultUser === null) {
		$defaultUser = empty($_SESSION['default_user']) ? '' : $_SESSION['default_user'];
	}
	$data = is_writable(DATA_PATH . '/' . $defaultUser . '_user.php');

	return array(
		'conf' => $conf ? 'ok' : 'ko',
		'form' => $form ? 'ok' : 'ko',
		'persona' => $persona ? 'ok' : 'ko',
		'data' => $data ? 'ok' : 'ko',
		'all' => $conf && $form && $persona && $data ? 'ok' : 'ko'
	);
}

function checkStep3() {
	$conf = is_writable(DATA_PATH . '/config.php');

	$bd = isset($_SESSION['bd_type']) &&
	      isset($_SESSION['bd_host']) &&
	      isset($_SESSION['bd_user']) &&
	      isset($_SESSION['bd_password']) &&
	      isset($_SESSION['bd_base']) &&
	      isset($_SESSION['bd_prefix']) &&
	      isset($_SESSION['bd_error']);
	$conn = empty($_SESSION['bd_error']);

	return array(
		'bd' => $bd ? 'ok' : 'ko',
		'conn' => $conn ? 'ok' : 'ko',
		'conf' => $conf ? 'ok' : 'ko',
		'all' => $bd && $conn && $conf ? 'ok' : 'ko'
	);
}

function checkBD() {
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
				$c = new PDO($str, $_SESSION['bd_user'], $_SESSION['bd_password'], $driver_options);
				$sql = sprintf(SQL_CREATE_DB, $_SESSION['bd_base']);
				$res = $c->query($sql);
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

		$c = new PDO($str, $_SESSION['bd_user'], $_SESSION['bd_password'], $driver_options);

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
function printStep0() {
	global $actual;
?>
	<?php $s0 = checkStep0(); if ($s0['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('language_defined'); ?></p>
	<?php } ?>

	<form action="index.php?step=0" method="post">
		<legend><?php echo _t('choose_language'); ?></legend>
		<div class="form-group">
			<label class="group-name" for="language"><?php echo _t('language'); ?></label>
			<div class="group-controls">
				<select name="language" id="language">
				<?php $languages = availableLanguages(); ?>
				<?php foreach ($languages as $short => $lib) { ?>
				<option value="<?php echo $short; ?>"<?php echo $actual == $short ? ' selected="selected"' : ''; ?>><?php echo $lib; ?></option>
				<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important"><?php echo _t('save'); ?></button>
				<button type="reset" class="btn"><?php echo _t('cancel'); ?></button>
				<?php if ($s0['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=1"><?php echo _t('next_step'); ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function printStep1() {
	$res = checkStep1();
?>
	<noscript><p class="alert alert-warn"><span class="alert-head"><?php echo _t('attention'); ?></span> <?php echo _t('javascript_is_better'); ?></p></noscript>

	<?php if ($res['php'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('php_is_ok', PHP_VERSION); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('php_is_nok', PHP_VERSION, '5.2.1'); ?></p>
	<?php } ?>

	<?php if ($res['minz'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('minz_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('minz_is_nok', LIB_PATH . '/Minz'); ?></p>
	<?php } ?>

	<?php if ($res['pdo'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('pdo_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('pdo_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['curl'] == 'ok') { ?>
	<?php $version = curl_version(); ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('curl_is_ok', $version['version']); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('curl_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['pcre'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('pcre_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('pcre_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['ctype'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('ctype_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('ctype_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['dom'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('dom_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('dom_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['data'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('data_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('file_is_nok', DATA_PATH); ?></p>
	<?php } ?>

	<?php if ($res['cache'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('cache_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('file_is_nok', CACHE_PATH); ?></p>
	<?php } ?>

	<?php if ($res['log'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('log_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('file_is_nok', LOG_PATH); ?></p>
	<?php } ?>

	<?php if ($res['favicons'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('favicons_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('file_is_nok', DATA_PATH . '/favicons'); ?></p>
	<?php } ?>

	<?php if ($res['persona'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('persona_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('file_is_nok', DATA_PATH . '/persona'); ?></p>
	<?php } ?>

	<?php if ($res['http_referer'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('http_referer_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('http_referer_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['all'] == 'ok') { ?>
	<a class="btn btn-important next-step" href="?step=2"><?php echo _t('next_step'); ?></a>
	<?php } else { ?>
	<p class="alert alert-error"><?php echo _t('fix_errors_before'); ?></p>
	<?php } ?>
<?php
}

function printStep2() {
?>
	<?php $s2 = checkStep2(); if ($s2['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('general_conf_is_ok'); ?></p>
	<?php } elseif (!empty($_POST)) { ?>
	<p class="alert alert-error"><?php echo _t('fix_errors_before'); ?></p>
	<?php } ?>

	<form action="index.php?step=2" method="post">
		<legend><?php echo _t('general_configuration'); ?></legend>

		<div class="form-group">
			<label class="group-name" for="title"><?php echo _t('title'); ?></label>
			<div class="group-controls">
				<input type="text" id="title" name="title" value="<?php echo isset($_SESSION['title']) ? $_SESSION['title'] : _t('freshrss'); ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="old_entries"><?php echo _t('delete_articles_every'); ?></label>
			<div class="group-controls">
				<input type="number" id="old_entries" name="old_entries" required="required" min="1" max="1200" value="<?php echo isset($_SESSION['old_entries']) ? $_SESSION['old_entries'] : '3'; ?>" /> <?php echo _t('month'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="default_user"><?php echo _t('default_user'); ?></label>
			<div class="group-controls">
				<input type="text" id="default_user" name="default_user" required="required" size="16" maxlength="16" pattern="[0-9a-zA-Z]{1,16}" value="<?php echo isset($_SESSION['default_user']) ? $_SESSION['default_user'] : ''; ?>" placeholder="<?php echo httpAuthUser() == '' ? 'user1' : httpAuthUser(); ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="auth_type"><?php echo _t('auth_type'); ?></label>
			<div class="group-controls">
				<select id="auth_type" name="auth_type" required="required" onchange="auth_type_change(true)">
					<?php
						function no_auth($auth_type) {
							return !in_array($auth_type, array('form', 'persona', 'http_auth', 'none'));
						}
						$auth_type = isset($_SESSION['auth_type']) ? $_SESSION['auth_type'] : '';
					?>
					<option value="form"<?php echo $auth_type === 'form' || no_auth($auth_type) ? ' selected="selected"' : '', cryptAvailable() ? '' : ' disabled="disabled"'; ?>><?php echo _t('auth_form'); ?></option>
					<option value="persona"<?php echo $auth_type === 'persona' ? ' selected="selected"' : ''; ?>><?php echo _t('auth_persona'); ?></option>
					<option value="http_auth"<?php echo $auth_type === 'http_auth' ? ' selected="selected"' : '', httpAuthUser() == '' ? ' disabled="disabled"' : ''; ?>><?php echo _t('http_auth'); ?>(REMOTE_USER = '<?php echo httpAuthUser(); ?>')</option>
					<option value="none"<?php echo $auth_type === 'none' ? ' selected="selected"' : ''; ?>><?php echo _t('auth_none'); ?></option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="passwordPlain"><?php echo _t('password_form'); ?></label>
			<div class="group-controls">
				<div class="stick">
					<input type="password" id="passwordPlain" name="passwordPlain" pattern=".{7,}" autocomplete="off" <?php echo $auth_type === 'form' ? ' required="required"' : ''; ?> />
					<a class="btn toggle-password" data-toggle="passwordPlain"><?php echo FreshRSS_Themes::icon('key'); ?></a>
				</div>
				<noscript><b><?php echo _t('javascript_should_be_activated'); ?></b></noscript>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="mail_login"><?php echo _t('persona_connection_email'); ?></label>
			<div class="group-controls">
				<input type="email" id="mail_login" name="mail_login" value="<?php echo isset($_SESSION['mail_login']) ? $_SESSION['mail_login'] : ''; ?>" placeholder="alice@example.net" <?php echo $auth_type === 'persona' ? ' required="required"' : ''; ?> />
				<noscript><b><?php echo _t('javascript_should_be_activated'); ?></b></noscript>
			</div>
		</div>

		<script>
			function toggle_password() {
				var button = this;
				var passwordField = document.getElementById(button.getAttribute('data-toggle'));

				passwordField.setAttribute('type', 'text');
				button.className += ' active';

				setTimeout(function() {
					passwordField.setAttribute('type', 'password');
					button.className = button.className.replace(/(?:^|\s)active(?!\S)/g , '');
				}, 2000);

				return false;
			}
			toggles = document.getElementsByClassName('toggle-password');
			for (var i = 0 ; i < toggles.length ; i++) {
				toggles[i].addEventListener('click', toggle_password);
			}

			function auth_type_change(focus) {
				var auth_value = document.getElementById('auth_type').value,
				    password_input = document.getElementById('passwordPlain'),
				    mail_input = document.getElementById('mail_login');

				if (auth_value === 'form') {
					password_input.required = true;
					mail_input.required = false;
					if (focus) {
						password_input.focus();
					}
				} else if (auth_value === 'persona') {
					password_input.required = false;
					mail_input.required = true;
					if (focus) {
						mail_input.focus();
					}
				} else {
					password_input.required = false;
					mail_input.required = false;
				}
			}
			auth_type_change(false);
		</script>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important"><?php echo _t('save'); ?></button>
				<button type="reset" class="btn"><?php echo _t('cancel'); ?></button>
				<?php if ($s2['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=3"><?php echo _t('next_step'); ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function printStep3() {
?>
	<?php $s3 = checkStep3(); if ($s3['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('ok'); ?></span> <?php echo _t('bdd_conf_is_ok'); ?></p>
	<?php } elseif ($s3['conn'] == 'ko') { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('damn'); ?></span> <?php echo _t('bdd_conf_is_ko'),(empty($_SESSION['bd_error']) ? '' : ' : ' . $_SESSION['bd_error']); ?></p>
	<?php } ?>

	<form action="index.php?step=3" method="post">
		<legend><?php echo _t('bdd_configuration'); ?></legend>
		<div class="form-group">
			<label class="group-name" for="type"><?php echo _t('bdd_type'); ?></label>
			<div class="group-controls">
				<select name="type" id="type" onchange="mySqlShowHide()">
				<?php if (extension_loaded('pdo_mysql')) {?>
				<option value="mysql"
					<?php echo(isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'mysql') ? 'selected="selected"' : ''; ?>>
					MySQL
				</option>
				<?php }?>
				<?php if (extension_loaded('pdo_sqlite')) {?>
				<option value="sqlite"
					<?php echo(isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'sqlite') ? 'selected="selected"' : ''; ?>>
					SQLite
				</option>
				<?php }?>
				</select>
			</div>
		</div>

		<div id="mysql">
		<div class="form-group">
			<label class="group-name" for="host"><?php echo _t('host'); ?></label>
			<div class="group-controls">
				<input type="text" id="host" name="host" pattern="[0-9A-Za-z_.-]{1,64}" value="<?php echo isset($_SESSION['bd_host']) ? $_SESSION['bd_host'] : 'localhost'; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="user"><?php echo _t('username'); ?></label>
			<div class="group-controls">
				<input type="text" id="user" name="user" maxlength="16" pattern="[0-9A-Za-z_.-]{1,16}" value="<?php echo isset($_SESSION['bd_user']) ? $_SESSION['bd_user'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="pass"><?php echo _t('password'); ?></label>
			<div class="group-controls">
				<input type="password" id="pass" name="pass" value="<?php echo isset($_SESSION['bd_password']) ? $_SESSION['bd_password'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="base"><?php echo _t('bdd'); ?></label>
			<div class="group-controls">
				<input type="text" id="base" name="base" maxlength="64" pattern="[0-9A-Za-z_]{1,64}" value="<?php echo isset($_SESSION['bd_base']) ? $_SESSION['bd_base'] : ''; ?>" placeholder="freshrss" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="prefix"><?php echo _t('prefix'); ?></label>
			<div class="group-controls">
				<input type="text" id="prefix" name="prefix" maxlength="16" pattern="[0-9A-Za-z_]{1,16}" value="<?php echo isset($_SESSION['bd_prefix']) ? $_SESSION['bd_prefix'] : 'freshrss_'; ?>" />
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
				<button type="submit" class="btn btn-important"><?php echo _t('save'); ?></button>
				<button type="reset" class="btn"><?php echo _t('cancel'); ?></button>
				<?php if ($s3['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=4"><?php echo _t('next_step'); ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function printStep4() {
?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t('congratulations'); ?></span> <?php echo _t('installation_is_ok'); ?></p>
	<a class="btn btn-important next-step" href="?step=5"><?php echo _t('finish_installation'); ?></a>
<?php
}

function printStep5() {
?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t('oops'); ?></span> <?php echo _t('install_not_deleted', DATA_PATH . '/do-install.txt'); ?></p>
<?php
}

checkStep();

initTranslate();

switch (STEP) {
case 0:
default:
	saveLanguage();
	break;
case 1:
	break;
case 2:
	saveStep2();
	break;
case 3:
	saveStep3();
	break;
case 4:
	break;
case 5:
	deleteInstall();
	break;
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0">
		<title><?php echo _t('freshrss_installation'); ?></title>
		<link rel="stylesheet" type="text/css" media="all" href="../themes/base-theme/template.css" />
		<link rel="stylesheet" type="text/css" media="all" href="../themes/Origine/origine.css" />
	</head>
	<body>

<div class="header">
	<div class="item title">
		<h1><a href="index.php"><?php echo _t('freshrss'); ?></a></h1>
		<h2><?php echo _t('installation_step', STEP); ?></h2>
	</div>
</div>

<div id="global">
	<ul class="nav nav-list aside">
		<li class="nav-header"><?php echo _t('steps'); ?></li>
		<li class="item<?php echo STEP == 0 ? ' active' : ''; ?>"><a href="?step=0"><?php echo _t('language'); ?></a></li>
		<li class="item<?php echo STEP == 1 ? ' active' : ''; ?>"><a href="?step=1"><?php echo _t('checks'); ?></a></li>
		<li class="item<?php echo STEP == 2 ? ' active' : ''; ?>"><a href="?step=2"><?php echo _t('general_configuration'); ?></a></li>
		<li class="item<?php echo STEP == 3 ? ' active' : ''; ?>"><a href="?step=3"><?php echo _t('bdd_configuration'); ?></a></li>
		<li class="item<?php echo STEP == 4 ? ' active' : ''; ?>"><a href="?step=5"><?php echo _t('this_is_the_end'); ?></a></li>
	</ul>

	<div class="post">
		<?php
		switch (STEP) {
		case 0:
		default:
			printStep0();
			break;
		case 1:
			printStep1();
			break;
		case 2:
			printStep2();
			break;
		case 3:
			printStep3();
			break;
		case 4:
			printStep4();
			break;
		case 5:
			printStep5();
			break;
		}
		?>
	</div>
</div>
	</body>
</html>

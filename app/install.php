<?php
if (function_exists('opcache_reset')) {
	opcache_reset();
}
header("Content-Security-Policy: default-src 'self'");

require(LIB_PATH . '/lib_install.php');

session_name('FreshRSS');
$forwardedPrefix = empty($_SERVER['HTTP_X_FORWARDED_PREFIX']) ? '' : rtrim($_SERVER['HTTP_X_FORWARDED_PREFIX'], '/ ');
session_set_cookie_params(0, $forwardedPrefix . dirname(empty($_SERVER['REQUEST_URI']) ? '/' : dirname($_SERVER['REQUEST_URI'])), null, false, true);
session_start();

if (isset($_GET['step'])) {
	define('STEP', (int)$_GET['step']);
} else {
	define('STEP', 0);
}

if (STEP === 2 && isset($_POST['type'])) {
	$_SESSION['bd_type'] = $_POST['type'];
}

function param($key, $default = false) {
	if (isset($_POST[$key])) {
		return $_POST[$key];
	} else {
		return $default;
	}
}

// gestion internationalisation
function initTranslate() {
	Minz_Translate::init();
	$available_languages = Minz_Translate::availableLanguages();

	if (!isset($_SESSION['language'])) {
		$_SESSION['language'] = get_best_language();
	}

	if (!in_array($_SESSION['language'], $available_languages)) {
		$_SESSION['language'] = 'en';
	}

	Minz_Translate::reset($_SESSION['language']);
}

function get_best_language() {
	$accept = empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? '' : $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	return strtolower(substr($accept, 0, 2));
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

function saveStep1() {
	if (isset($_POST['freshrss-keep-install']) &&
			$_POST['freshrss-keep-install'] === '1') {
		// We want to keep our previous installation of FreshRSS
		// so we need to make next steps valid by setting $_SESSION vars
		// with values from the previous installation

		// First, we try to get previous configurations
		Minz_Configuration::register('system',
		                             join_path(DATA_PATH, 'config.php'),
		                             join_path(FRESHRSS_PATH, 'config.default.php'));
		$system_conf = Minz_Configuration::get('system');

		$current_user = $system_conf->default_user;
		Minz_Configuration::register('user',
		                             join_path(USERS_PATH, $current_user, 'config.php'),
		                             join_path(FRESHRSS_PATH, 'config-user.default.php'));
		$user_conf = Minz_Configuration::get('user');

		// Then, we set $_SESSION vars
		$_SESSION['title'] = $system_conf->title;
		$_SESSION['auth_type'] = $system_conf->auth_type;
		$_SESSION['default_user'] = $current_user;
		$_SESSION['passwordHash'] = $user_conf->passwordHash;

		$db = $system_conf->db;
		$_SESSION['bd_type'] = $db['type'];
		$_SESSION['bd_host'] = $db['host'];
		$_SESSION['bd_user'] = $db['user'];
		$_SESSION['bd_password'] = $db['password'];
		$_SESSION['bd_base'] = $db['base'];
		$_SESSION['bd_prefix'] = $db['prefix'];
		$_SESSION['bd_error'] = '';

		header('Location: index.php?step=4');
	}
}

function saveStep2() {
	if (!empty($_POST)) {
		if ($_SESSION['bd_type'] === 'sqlite') {
			$_SESSION['bd_base'] = '';
			$_SESSION['bd_host'] = '';
			$_SESSION['bd_user'] = '';
			$_SESSION['bd_password'] = '';
			$_SESSION['bd_prefix'] = '';
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
		}
		if ($_SESSION['bd_type'] === 'pgsql') {
			$_SESSION['bd_base'] = strtolower($_SESSION['bd_base']);
		}

		// We use dirname to remove the /i part
		$base_url = dirname(Minz_Request::guessBaseUrl());
		$config_array = [
			'salt' => generateSalt(),
			'base_url' => $base_url,
			'default_user' => '_',
			'db' => [
				'type' => $_SESSION['bd_type'],
				'host' => $_SESSION['bd_host'],
				'user' => $_SESSION['bd_user'],
				'password' => $_SESSION['bd_password'],
				'base' => $_SESSION['bd_base'],
				'prefix' => $_SESSION['bd_prefix'],
				'pdo_options' => [],
			],
			'pubsubhubbub_enabled' => Minz_Request::serverIsPublic($base_url),
		];
		if (!empty($_SESSION['title'])) {
			$config_array['title'] = $_SESSION['title'];
		}
		if (!empty($_SESSION['auth_type'])) {
			$config_array['auth_type'] = $_SESSION['auth_type'];
		}

		@unlink(DATA_PATH . '/config.php');	//To avoid access-rights problems
		file_put_contents(DATA_PATH . '/config.php', "<?php\n return " . var_export($config_array, true) . ";\n");

		if (function_exists('opcache_reset')) {
			opcache_reset();
		}

		Minz_Configuration::register('system', DATA_PATH . '/config.php', FRESHRSS_PATH . '/config.default.php');
		FreshRSS_Context::$system_conf = Minz_Configuration::get('system');

		$ok = false;
		try {
			$_SESSION['currentUser'] = $config_array['default_user'];
			$error = initDb();
			unset($_SESSION['currentUser']);
			if ($error != '') {
				$_SESSION['bd_error'] = $error;
			} else {
				$ok = true;
			}
		} catch (Exception $ex) {
			$_SESSION['bd_error'] = $ex->getMessage();
			$ok = false;
		}
		if (!$ok) {
			@unlink(join_path(DATA_PATH, 'config.php'));
		}

		if ($ok) {
			$_SESSION['bd_error'] = '';
			header('Location: index.php?step=3');
		} elseif (empty($_SESSION['bd_error'])) {
			$_SESSION['bd_error'] = 'Unknown error!';
		}
	}
	invalidateHttpCache();
}

function saveStep3() {
	$user_default_config = Minz_Configuration::get('default_user');
	if (!empty($_POST)) {
		$system_default_config = Minz_Configuration::get('default_system');
		$_SESSION['title'] = $system_default_config->title;
		$_SESSION['auth_type'] = param('auth_type', 'form');
		if (FreshRSS_user_Controller::checkUsername(param('default_user', ''))) {
			$_SESSION['default_user'] = param('default_user', '');
		}

		if (empty($_SESSION['auth_type']) ||
		    empty($_SESSION['default_user'])) {
			return false;
		}

		$password_plain = param('passwordPlain', false);
		if ($_SESSION['auth_type'] === 'form' && $password_plain == '') {
			return false;
		}

		Minz_Configuration::register('system', DATA_PATH . '/config.php', FRESHRSS_PATH . '/config.default.php');
		FreshRSS_Context::$system_conf = Minz_Configuration::get('system');
		Minz_Translate::init($_SESSION['language']);

		FreshRSS_Context::$system_conf->default_user = $_SESSION['default_user'];
		FreshRSS_Context::$system_conf->save();

		// Create default user files but first, we delete previous data to
		// avoid access right problems.
		recursive_unlink(USERS_PATH . '/' . $_SESSION['default_user']);

		$ok = false;
		try {
			$ok = FreshRSS_user_Controller::createUser(
				$_SESSION['default_user'],
				'',	//TODO: Add e-mail
				$password_plain,
				[
					'language' => $_SESSION['language'],
					'is_admin' => true,
					'enabled' => true,
				]
			);
		} catch (Exception $e) {
			$_SESSION['bd_error'] = $e->getMessage();
			$ok = false;
		}
		if (!$ok) {
			return false;
		}

		header('Location: index.php?step=4');
	}
}

/*** VÉRIFICATIONS ***/
function checkStep() {
	$s0 = checkStep0();
	$s1 = checkRequirements();
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
	$languages = Minz_Translate::availableLanguages();
	$language = isset($_SESSION['language']) &&
	            in_array($_SESSION['language'], $languages);

	return array(
		'language' => $language ? 'ok' : 'ko',
		'all' => $language ? 'ok' : 'ko'
	);
}

function freshrss_already_installed() {
	$conf_path = join_path(DATA_PATH, 'config.php');
	if (!file_exists($conf_path)) {
		return false;
	}

	// A configuration file already exists, we try to load it.
	$system_conf = null;
	try {
		Minz_Configuration::register('system', $conf_path);
		$system_conf = Minz_Configuration::get('system');
	} catch (Minz_FileNotExistException $e) {
		return false;
	}

	// ok, the global conf exists... but what about default user conf?
	$current_user = $system_conf->default_user;
	try {
		Minz_Configuration::register('user', join_path(USERS_PATH, $current_user, 'config.php'));
	} catch (Minz_FileNotExistException $e) {
		return false;
	}

	// ok, ok, default user exists too!
	return true;
}

function checkStep2() {
	$conf = is_writable(join_path(DATA_PATH, 'config.php'));

	$bd = isset($_SESSION['bd_type']) &&
	      isset($_SESSION['bd_host']) &&
	      isset($_SESSION['bd_user']) &&
	      isset($_SESSION['bd_password']) &&
	      isset($_SESSION['bd_base']) &&
	      isset($_SESSION['bd_prefix']) &&
	      isset($_SESSION['bd_error']);
	$conn = empty($_SESSION['bd_error']);

	return [
		'bd' => $bd ? 'ok' : 'ko',
		'conn' => $conn ? 'ok' : 'ko',
		'conf' => $conf ? 'ok' : 'ko',
		'all' => $bd && $conn && $conf ? 'ok' : 'ko',
	];
}

function checkStep3() {
	$conf = !empty($_SESSION['default_user']);

	$form = isset($_SESSION['auth_type']);

	$defaultUser = empty($_POST['default_user']) ? null : $_POST['default_user'];
	if ($defaultUser === null) {
		$defaultUser = empty($_SESSION['default_user']) ? '' : $_SESSION['default_user'];
	}
	$data = is_writable(join_path(USERS_PATH, $defaultUser, 'config.php'));

	return [
		'conf' => $conf ? 'ok' : 'ko',
		'form' => $form ? 'ok' : 'ko',
		'data' => $data ? 'ok' : 'ko',
		'all' => $conf && $form && $data ? 'ok' : 'ko',
	];
}


/*** AFFICHAGE ***/
function printStep0() {
	$actual = Minz_Translate::language();
	$languages = Minz_Translate::availableLanguages();
?>
	<?php $s0 = checkStep0(); if ($s0['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.language.defined') ?></p>
	<?php } ?>

	<form action="index.php?step=0" method="post">
		<legend><?= _t('install.language.choose') ?></legend>
		<div class="form-group">
			<label class="group-name" for="language"><?= _t('install.language') ?></label>
			<div class="group-controls">
				<select name="language" id="language" tabindex="1" >
				<?php foreach ($languages as $lang) { ?>
				<option value="<?= $lang ?>"<?= $actual == $lang ? ' selected="selected"' : '' ?>>
					<?= _t('gen.lang.' . $lang) ?>
				</option>
				<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important" tabindex="2" ><?= _t('gen.action.submit') ?></button>
				<button type="reset" class="btn" tabindex="3" ><?= _t('gen.action.cancel') ?></button>
				<?php if ($s0['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=1" tabindex="4" ><?= _t('install.action.next_step') ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

// @todo refactor this view with the check_install action
function printStep1() {
	$res = checkRequirements();
?>
	<noscript><p class="alert alert-warn"><span class="alert-head"><?= _t('gen.short.attention') ?></span> <?= _t('install.javascript_is_better') ?></p></noscript>

	<?php if ($res['php'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.php.ok', PHP_VERSION) ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.php.nok', PHP_VERSION, '5.6.0') ?></p>
	<?php } ?>

	<?php if ($res['minz'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.minz.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.minz.nok', join_path(LIB_PATH, 'Minz')) ?></p>
	<?php } ?>

	<?php if ($res['pdo'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.pdo.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.pdo.nok') ?></p>
	<?php } ?>

	<?php if ($res['curl'] == 'ok') { ?>
	<?php $version = curl_version(); ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.curl.ok', $version['version']) ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.curl.nok') ?></p>
	<?php } ?>

	<?php if ($res['json'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.json.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.json.nok') ?></p>
	<?php } ?>

	<?php if ($res['pcre'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.pcre.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.pcre.nok') ?></p>
	<?php } ?>

	<?php if ($res['ctype'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.ctype.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.ctype.nok') ?></p>
	<?php } ?>

	<?php if ($res['dom'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.dom.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.dom.nok') ?></p>
	<?php } ?>

	<?php if ($res['xml'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.xml.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.xml.nok') ?></p>
	<?php } ?>

	<?php if ($res['mbstring'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.mbstring.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-warn"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.mbstring.nok') ?></p>
	<?php } ?>

	<?php if ($res['fileinfo'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.fileinfo.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-warn"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.fileinfo.nok') ?></p>
	<?php } ?>

	<?php if ($res['data'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.data.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.data.nok', DATA_PATH) ?></p>
	<?php } ?>

	<?php if ($res['cache'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.cache.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.cache.nok', CACHE_PATH) ?></p>
	<?php } ?>

	<?php if ($res['users'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.users.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.users.nok', USERS_PATH) ?></p>
	<?php } ?>

	<?php if ($res['favicons'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.favicons.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.favicons.nok', DATA_PATH . '/favicons') ?></p>
	<?php } ?>

	<?php if ($res['http_referer'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.check.http_referer.ok') ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.check.http_referer.nok') ?></p>
	<?php } ?>

	<?php if (freshrss_already_installed() && $res['all'] == 'ok') { ?>
	<p class="alert alert-warn"><span class="alert-head"><?= _t('gen.short.attention') ?></span> <?= _t('install.check.already_installed') ?></p>

	<form action="index.php?step=1" method="post">
		<input type="hidden" name="freshrss-keep-install" value="1" />
		<button type="submit" class="btn btn-important next-step" tabindex="1" ><?= _t('install.action.keep_install') ?></button>
		<a class="btn btn-attention next-step confirm" data-str-confirm="<?= _t('install.js.confirm_reinstall') ?>" href="?step=2" tabindex="2" ><?= _t('install.action.reinstall') ?></a>
	</form>

	<?php } elseif ($res['all'] == 'ok') { ?>
	<a class="btn btn-important next-step" href="?step=2" tabindex="1" ><?= _t('install.action.next_step') ?></a>
	<?php } else { ?>
	<p class="alert alert-error"><?= _t('install.action.fix_errors_before') ?></p>
	<?php } ?>
<?php
}

function printStep2() {
	$system_default_config = Minz_Configuration::get('default_system');
?>
	<?php $s2 = checkStep2(); if ($s2['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.bdd.conf.ok') ?></p>
	<?php } elseif ($s2['conn'] == 'ko') { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.bdd.conf.ko'),(empty($_SESSION['bd_error']) ? '' : ' : ' . $_SESSION['bd_error']) ?></p>
	<?php } ?>

	<form action="index.php?step=2" method="post" autocomplete="off">
		<legend><?= _t('install.bdd.conf') ?></legend>
		<div class="form-group">
			<label class="group-name" for="type"><?= _t('install.bdd.type') ?></label>
			<div class="group-controls">
				<select name="type" id="type" tabindex="1">
				<?php if (extension_loaded('pdo_sqlite')) {?>
				<option value="sqlite"
					<?php echo(isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'sqlite') ? 'selected="selected"' : ''; ?>>
					SQLite
				</option>
				<?php }?>
				<?php if (extension_loaded('pdo_mysql')) {?>
				<option value="mysql"
					<?php echo(isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'mysql') ? 'selected="selected"' : ''; ?>>
					MySQL
				</option>
				<?php }?>
				<?php if (extension_loaded('pdo_pgsql')) {?>
				<option value="pgsql"
					<?php echo(isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'pgsql') ? 'selected="selected"' : ''; ?>>
					PostgreSQL
				</option>
				<?php }?>
				</select>
			</div>
		</div>

		<div id="mysql">
		<div class="form-group">
			<label class="group-name" for="host"><?= _t('install.bdd.host') ?></label>
			<div class="group-controls">
				<input type="text" id="host" name="host" pattern="[0-9A-Z/a-z_.-]{1,64}(:[0-9]{2,5})?" value="<?= isset($_SESSION['bd_host']) ? $_SESSION['bd_host'] : $system_default_config->db['host'] ?>" tabindex="2" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="user"><?= _t('install.bdd.username') ?></label>
			<div class="group-controls">
				<input type="text" id="user" name="user" maxlength="64" pattern="[0-9A-Za-z@_.-]{1,64}" value="<?= isset($_SESSION['bd_user']) ? $_SESSION['bd_user'] : '' ?>" tabindex="3" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="pass"><?= _t('install.bdd.password') ?></label>
			<div class="group-controls">
				<input type="password" id="pass" name="pass" value="<?= isset($_SESSION['bd_password']) ? $_SESSION['bd_password'] : '' ?>" tabindex="4" autocomplete="off" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="base"><?= _t('install.bdd') ?></label>
			<div class="group-controls">
				<input type="text" id="base" name="base" maxlength="64" pattern="[0-9A-Za-z_-]{1,64}" value="<?= isset($_SESSION['bd_base']) ? $_SESSION['bd_base'] : '' ?>" tabindex="5" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="prefix"><?= _t('install.bdd.prefix') ?></label>
			<div class="group-controls">
				<input type="text" id="prefix" name="prefix" maxlength="16" pattern="[0-9A-Za-z_]{1,16}" value="<?= isset($_SESSION['bd_prefix']) ? $_SESSION['bd_prefix'] : $system_default_config->db['prefix'] ?>" tabindex="6" />
			</div>
		</div>
		</div>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important" tabindex="7" ><?= _t('gen.action.submit') ?></button>
				<button type="reset" class="btn" tabindex="8" ><?= _t('gen.action.cancel') ?></button>
				<?php if ($s2['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=3" tabindex="9" ><?= _t('install.action.next_step') ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function printStep3() {
	$user_default_config = Minz_Configuration::get('default_user');
?>
	<?php $s3 = checkStep3(); if ($s3['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.conf.ok') ?></p>
	<?php } elseif (!empty($_POST)) { ?>
	<p class="alert alert-error"><?= _t('install.fix_errors_before') ?></p>
	<?php } ?>

	<form action="index.php?step=3" method="post">
		<legend><?= _t('install.conf') ?></legend>

		<div class="form-group">
			<label class="group-name" for="default_user"><?= _t('install.default_user') ?></label>
			<div class="group-controls">
				<input type="text" id="default_user" name="default_user" autocomplete="username" required="required" size="16" pattern="<?= FreshRSS_user_Controller::USERNAME_PATTERN ?>" value="<?= isset($_SESSION['default_user']) ? $_SESSION['default_user'] : '' ?>" placeholder="<?= httpAuthUser() == '' ? 'alice' : httpAuthUser() ?>" tabindex="3" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="auth_type"><?= _t('install.auth.type') ?></label>
			<div class="group-controls">
				<select id="auth_type" name="auth_type" required="required" tabindex="4">
					<?php
						function no_auth($auth_type) {
							return !in_array($auth_type, array('form', 'http_auth', 'none'));
						}
						$auth_type = isset($_SESSION['auth_type']) ? $_SESSION['auth_type'] : '';
					?>
					<option value="form"<?= $auth_type === 'form' || (no_auth($auth_type) && cryptAvailable()) ? ' selected="selected"' : '', cryptAvailable() ? '' : ' disabled="disabled"' ?>><?= _t('install.auth.form') ?></option>
					<option value="http_auth"<?= $auth_type === 'http_auth' ? ' selected="selected"' : '', httpAuthUser() == '' ? ' disabled="disabled"' : '' ?>><?= _t('install.auth.http') ?>(REMOTE_USER = '<?= httpAuthUser() ?>')</option>
					<option value="none"<?= $auth_type === 'none' || (no_auth($auth_type) && !cryptAvailable()) ? ' selected="selected"' : '' ?>><?= _t('install.auth.none') ?></option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="passwordPlain"><?= _t('install.auth.password_form') ?></label>
			<div class="group-controls">
				<div class="stick">
					<input type="password" id="passwordPlain" name="passwordPlain" pattern=".{7,}" autocomplete="off" <?= $auth_type === 'form' ? ' required="required"' : '' ?> tabindex="5" />
					<a class="btn toggle-password" data-toggle="passwordPlain"><?= FreshRSS_Themes::icon('key') ?></a>
				</div>
				<p class="help"><?= _i('help') ?> <?= _t('install.auth.password_format') ?></p>
				<noscript><b><?= _t('gen.js.should_be_activated') ?></b></noscript>
			</div>
		</div>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important" tabindex="7" ><?= _t('gen.action.submit') ?></button>
				<button type="reset" class="btn" tabindex="8" ><?= _t('gen.action.cancel') ?></button>
				<?php if ($s3['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=4" tabindex="9" ><?= _t('install.action.next_step') ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function printStep4() {
?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('install.congratulations') ?></span> <?= _t('install.ok') ?></p>
	<a class="btn btn-important next-step" href="?step=5" tabindex="1"><?= _t('install.action.finish') ?></a>
<?php
}

function printStep5() {
?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.not_deleted', DATA_PATH . '/do-install.txt') ?></p>
<?php
}

initTranslate();

checkStep();

switch (STEP) {
case 0:
default:
	saveLanguage();
	break;
case 1:
	saveStep1();
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
	if (setupMigrations() && deleteInstall()) {
		header('Location: index.php');
	}
	break;
}
?>
<!DOCTYPE html>
<html<?php
if (_t('gen.dir') === 'rtl') {
	echo ' dir="rtl" class="rtl"';
}
?>>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="initial-scale=1.0" />
		<script id="jsonVars" type="application/json">{}</script>
		<title><?= _t('install.title') ?></title>
		<link rel="stylesheet" href="../themes/base-theme/template.css?<?= @filemtime(PUBLIC_PATH . '/themes/base-theme/template.css') ?>" />
		<link rel="stylesheet" href="../themes/Origine/origine.css?<?= @filemtime(PUBLIC_PATH . '/themes/Origine/origine.css') ?>" />
		<meta name="robots" content="noindex,nofollow" />
	</head>
	<body>

<div class="header">
	<div class="item title">
		<h1><a href="index.php"><?= _t('install.title') ?></a></h1>
		<h2><?= _t('install.step', STEP) ?></h2>
	</div>
</div>

<div id="global">
	<ul class="nav nav-list aside">
		<li class="nav-header"><?= _t('install.steps') ?></li>
		<li class="item<?= STEP == 0 ? ' active' : '' ?>"><a href="?step=0"><?= _t('install.language') ?></a></li>
		<li class="item<?= STEP == 1 ? ' active' : '' ?>"><a href="?step=1"><?= _t('install.check') ?></a></li>
		<li class="item<?= STEP == 2 ? ' active' : '' ?>"><a href="?step=2"><?= _t('install.bdd.conf') ?></a></li>
		<li class="item<?= STEP == 3 ? ' active' : '' ?>"><a href="?step=3"><?= _t('install.conf') ?></a></li>
		<li class="item<?= STEP == 4 ? ' active' : '' ?>"><a href="?step=4"><?= _t('install.this_is_the_end') ?></a></li>
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
	<script src="../scripts/install.js?<?= @filemtime(PUBLIC_PATH . '/scripts/install.js') ?>"></script>
	</body>
</html>

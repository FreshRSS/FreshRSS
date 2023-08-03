<?php
if (function_exists('opcache_reset')) {
	opcache_reset();
}
header("Content-Security-Policy: default-src 'self'");

require(LIB_PATH . '/lib_install.php');

Minz_Session::init('FreshRSS');

if (isset($_GET['step'])) {
	define('STEP', (int)$_GET['step']);
} else {
	define('STEP', 0);
}

if (STEP === 2 && isset($_POST['type'])) {
	Minz_Session::_param('bd_type', $_POST['type']);
}

function param(string $key, string $default = ''): string {
	return isset($_POST[$key]) && is_string($_POST[$key]) ? trim($_POST[$key]) : $default;
}

// gestion internationalisation
function initTranslate(): void {
	Minz_Translate::init();
	$available_languages = Minz_Translate::availableLanguages();

	if (Minz_Session::param('language') == '') {
		Minz_Session::_param('language', get_best_language());
	}

	if (!in_array(Minz_Session::param('language'), $available_languages, true)) {
		Minz_Session::_param('language', 'en');
	}

	Minz_Translate::reset(Minz_Session::param('language'));
}

function get_best_language(): string {
	$accept = empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? '' : $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	return strtolower(substr($accept, 0, 2));
}


/*** SAUVEGARDES ***/
function saveLanguage(): bool {
	if (!empty($_POST)) {
		if (!isset($_POST['language'])) {
			return false;
		}

		Minz_Session::_param('language', $_POST['language']);
		Minz_Session::_param('sessionWorking', 'ok');

		header('Location: index.php?step=1');
	}
	return true;
}

function saveStep1(): void {
	if (isset($_POST['freshrss-keep-install']) &&
			$_POST['freshrss-keep-install'] === '1') {
		// We want to keep our previous installation of FreshRSS
		// so we need to make next steps valid by setting $_SESSION vars
		// with values from the previous installation

		// First, we try to get previous configurations
		FreshRSS_Context::initSystem();
		FreshRSS_Context::initUser(FreshRSS_Context::$system_conf->default_user, false);

		// Then, we set $_SESSION vars
		Minz_Session::_params([
				'title' => FreshRSS_Context::$system_conf->title,
				'auth_type' => FreshRSS_Context::$system_conf->auth_type,
				'default_user' => Minz_User::name(),
				'passwordHash' => FreshRSS_Context::$user_conf->passwordHash,
				'bd_type' => FreshRSS_Context::$system_conf->db['type'] ?? '',
				'bd_host' => FreshRSS_Context::$system_conf->db['host'] ?? '',
				'bd_user' => FreshRSS_Context::$system_conf->db['user'] ?? '',
				'bd_password' => FreshRSS_Context::$system_conf->db['password'] ?? '',
				'bd_base' => FreshRSS_Context::$system_conf->db['base'] ?? '',
				'bd_prefix' => FreshRSS_Context::$system_conf->db['prefix'] ?? '',
				'bd_error' => false,
			]);

		header('Location: index.php?step=4');
	}
}

function saveStep2(): void {
	if (!empty($_POST)) {
		if (Minz_Session::param('bd_type') === 'sqlite') {
			Minz_Session::_params([
					'bd_base' => false,
					'bd_host' => false,
					'bd_user' => false,
					'bd_password' => false,
					'bd_prefix' => false,
				]);
		} else {
			if (empty($_POST['type']) ||
				empty($_POST['host']) ||
				empty($_POST['user']) ||
				empty($_POST['base'])) {
				Minz_Session::_param('bd_error', 'Missing parameters!');
			}
			Minz_Session::_params([
					'bd_base' => substr($_POST['base'], 0, 64),
					'bd_host' => $_POST['host'],
					'bd_user' => $_POST['user'],
					'bd_password' => $_POST['pass'],
					'bd_prefix' => substr($_POST['prefix'], 0, 16),
				]);
		}
		if (Minz_Session::param('bd_type') === 'pgsql') {
			Minz_Session::_param('bd_base', strtolower(Minz_Session::param('bd_base')));
		}

		// We use dirname to remove the /i part
		$base_url = dirname(Minz_Request::guessBaseUrl());
		$config_array = [
			'salt' => generateSalt(),
			'base_url' => $base_url,
			'default_user' => '_',
			'db' => [
				'type' => Minz_Session::param('bd_type'),
				'host' => Minz_Session::param('bd_host'),
				'user' => Minz_Session::param('bd_user'),
				'password' => Minz_Session::param('bd_password'),
				'base' => Minz_Session::param('bd_base'),
				'prefix' => Minz_Session::param('bd_prefix'),
				'pdo_options' => [],
			],
			'pubsubhubbub_enabled' => Minz_Request::serverIsPublic($base_url),
		];
		if (Minz_Session::param('title') != '') {
			$config_array['title'] = Minz_Session::param('title');
		}

		$customConfigPath = DATA_PATH . '/config.custom.php';
		if (file_exists($customConfigPath)) {
			$customConfig = include($customConfigPath);
			if (is_array($customConfig)) {
				$config_array = array_merge($customConfig, $config_array);
			}
		}

		@unlink(DATA_PATH . '/config.php');	//To avoid access-rights problems
		file_put_contents(DATA_PATH . '/config.php', "<?php\n return " . var_export($config_array, true) . ";\n");

		if (function_exists('opcache_reset')) {
			opcache_reset();
		}

		FreshRSS_Context::initSystem(true);

		$ok = false;
		try {
			Minz_User::change($config_array['default_user']);
			$error = initDb();
			Minz_User::change();
			if ($error != '') {
				Minz_Session::_param('bd_error', $error);
			} else {
				$ok = true;
			}
		} catch (Exception $ex) {
			Minz_Session::_param('bd_error', $ex->getMessage());
			$ok = false;
		}
		if (!$ok) {
			@unlink(join_path(DATA_PATH, 'config.php'));
		}

		if ($ok) {
			Minz_Session::_param('bd_error');
			header('Location: index.php?step=3');
		} elseif (Minz_Session::param('bd_error') == '') {
			Minz_Session::_param('bd_error', 'Unknown error!');
		}
	}
	invalidateHttpCache();
}

function saveStep3(): bool {
	FreshRSS_Context::initSystem();
	Minz_Translate::init(Minz_Session::param('language'));

	if (!empty($_POST)) {
		if (param('auth_type', 'form') != '') {
			FreshRSS_Context::$system_conf->auth_type = param('auth_type', 'form');
			Minz_Session::_param('auth_type', FreshRSS_Context::$system_conf->auth_type);
		} else {
			return false;
		}

		$password_plain = param('passwordPlain', '');
		if (FreshRSS_Context::$system_conf->auth_type === 'form' && $password_plain == '') {
			return false;
		}

		if (FreshRSS_user_Controller::checkUsername(param('default_user', ''))) {
			FreshRSS_Context::$system_conf->default_user = param('default_user', '');
			Minz_Session::_param('default_user', FreshRSS_Context::$system_conf->default_user);
		} else {
			return false;
		}

		if (FreshRSS_Context::$system_conf->auth_type === 'http_auth' &&
			connectionRemoteAddress() !== '' &&
			empty($_SERVER['REMOTE_USER']) && empty($_SERVER['REDIRECT_REMOTE_USER']) &&	// No safe authentication HTTP headers
			(!empty($_SERVER['HTTP_REMOTE_USER']) || !empty($_SERVER['HTTP_X_WEBAUTH_USER']))	// but has unsafe authentication HTTP headers
		) {
			// Trust by default the remote IP address (e.g. last proxy) used during install to provide remote user name via unsafe HTTP header
			FreshRSS_Context::$system_conf->trusted_sources[] = connectionRemoteAddress();
			FreshRSS_Context::$system_conf->trusted_sources = array_unique(FreshRSS_Context::$system_conf->trusted_sources);
		}

		// Create default user files but first, we delete previous data to
		// avoid access right problems.
		recursive_unlink(USERS_PATH . '/' . Minz_Session::param('default_user'));

		$ok = false;
		try {
			$ok = FreshRSS_user_Controller::createUser(
				Minz_Session::param('default_user'),
				'',	//TODO: Add e-mail
				$password_plain,
				[
					'language' => Minz_Session::param('language'),
					'is_admin' => true,
					'enabled' => true,
				]
			);
		} catch (Exception $e) {
			Minz_Session::_param('bd_error', $e->getMessage());
			$ok = false;
		}
		if (!$ok) {
			return false;
		}

		FreshRSS_Context::$system_conf->save();

		header('Location: index.php?step=4');
	}
	return true;
}

/*** VÉRIFICATIONS ***/
function checkStep(): void {
	$s0 = checkStep0();
	$s1 = checkRequirements();
	$s2 = checkStep2();
	$s3 = checkStep3();
	if (STEP > 0 && $s0['all'] !== 'ok') {
		header('Location: index.php?step=0');
	} elseif (STEP > 1 && $s1['all'] !== 'ok') {
		header('Location: index.php?step=1');
	} elseif (STEP > 2 && $s2['all'] !== 'ok') {
		header('Location: index.php?step=2');
	} elseif (STEP > 3 && $s3['all'] !== 'ok') {
		header('Location: index.php?step=3');
	}
	Minz_Session::_param('actualize_feeds', true);
}

/** @return array<string,string> */
function checkStep0(): array {
	$languages = Minz_Translate::availableLanguages();
	$language = Minz_Session::param('language') != '' && in_array(Minz_Session::param('language'), $languages, true);
	$sessionWorking = Minz_Session::param('sessionWorking') === 'ok';

	return [
		'language' => $language ? 'ok' : 'ko',
		'sessionWorking' => $sessionWorking ? 'ok' : 'ko',
		'all' => $language && $sessionWorking ? 'ok' : 'ko',
	];
}

function freshrss_already_installed(): bool {
	$conf_path = join_path(DATA_PATH, 'config.php');
	if (!file_exists($conf_path)) {
		return false;
	}

	// A configuration file already exists, we try to load it.
	$system_conf = null;
	try {
		$system_conf = FreshRSS_SystemConfiguration::init($conf_path);
	} catch (Minz_ConfigurationNamespaceException $e) {
		return false;
	}

	// ok, the global conf exists… but what about default user conf?
	$current_user = $system_conf->default_user;
	try {
		FreshRSS_UserConfiguration::init(USERS_PATH . '/' . $current_user . '/config.php');
	} catch (Minz_ConfigurationNamespaceException $e) {
		return false;
	}

	// ok, ok, default user exists too!
	return true;
}

/** @return array<string,string> */
function checkStep2(): array {
	$conf = is_writable(join_path(DATA_PATH, 'config.php'));

	$bd = Minz_Session::param('bd_type') != '';
	$conn = Minz_Session::param('bd_error') == '';

	return [
		'bd' => $bd ? 'ok' : 'ko',
		'conn' => $conn ? 'ok' : 'ko',
		'conf' => $conf ? 'ok' : 'ko',
		'all' => $bd && $conn && $conf ? 'ok' : 'ko',
	];
}

/** @return array<string,string> */
function checkStep3(): array {
	$conf = Minz_Session::param('default_user') != '';

	$form = Minz_Session::param('auth_type') != '';

	$defaultUser = empty($_POST['default_user']) ? null : $_POST['default_user'];
	if ($defaultUser === null) {
		$defaultUser = Minz_Session::param('default_user') == '' ? '' : Minz_Session::param('default_user');
	}
	$data = is_writable(join_path(USERS_PATH, $defaultUser, 'config.php'));

	return [
		'conf' => $conf ? 'ok' : 'ko',
		'form' => $form ? 'ok' : 'ko',
		'data' => $data ? 'ok' : 'ko',
		'all' => $conf && $form && $data ? 'ok' : 'ko',
	];
}


/* select language */
function printStep0(): void {
	$actual = Minz_Translate::language();
	$languages = Minz_Translate::availableLanguages();
	$s0 = checkStep0();
?>
	<?php if ($s0['all'] === 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.language.defined') ?></p>
	<?php } elseif (!empty($_POST) && $s0['sessionWorking'] !== 'ok') { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.session.nok') ?></p>
	<?php } ?>

	<div class="form-group">
		<label class="group-name"><?= _t('index.about') ?></label>
		<div class="group-controls">
			<?= _t('index.about.freshrss_description') ?>
		</div>
	</div>

	<div class="form-group">
		<label class="group-name"><?= _t('index.about.project_website') ?></label>
		<div class="group-controls">
			<a href="<?= FRESHRSS_WEBSITE ?>" target="_blank"><?= FRESHRSS_WEBSITE ?></a>
		</div>
	</div>

	<div class="form-group">
		<label class="group-name"><?= _t('index.about.documentation') ?></label>
		<div class="group-controls">
			<a href="<?= FRESHRSS_WIKI ?>" target="_blank"><?= FRESHRSS_WIKI ?></a>
		</div>
	</div>

	<div class="form-group">
		<label class="group-name"><?= _t('index.about.version') ?></label>
		<div class="group-controls">
			<?= FRESHRSS_VERSION ?>
		</div>
	</div>

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
				<?php if ($s0['all'] == 'ok') { ?>
				<a class="next-step" href="?step=1" tabindex="4" ><?= _t('install.action.next_step') ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

/**
 * Alert box template
 * @param array<string> $messageParams
 * */
function printStep1Template(string $key, string $value, array $messageParams = []): void {
	if ('ok' === $value) {
		$message = _t("install.check.{$key}.ok", ...$messageParams);
		?><p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= $message ?></p><?php
	} else {
		$message = _t("install.check.{$key}.nok", ...$messageParams);
		?><p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= $message ?></p><?php
	}
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

// @todo refactor this view with the check_install action
/* check system environment */
function printStep1(): void {
	$res = checkRequirements();
	$processUsername = getProcessUsername();
?>
	<h2><?= _t('admin.check_install.php') ?></h2>
	<noscript><p class="alert alert-warn"><span class="alert-head"><?= _t('gen.short.attention') ?></span> <?= _t('install.javascript_is_better') ?></p></noscript>

	<?php
	$version = function_exists('curl_version') ? curl_version() : [];
	printStep1Template('php', $res['php'], [PHP_VERSION, FRESHRSS_MIN_PHP_VERSION]);
	printStep1Template('pdo', $res['pdo']);
	printStep1Template('curl', $res['curl'], [$version['version'] ?? '']);
	printStep1Template('json', $res['json']);
	printStep1Template('pcre', $res['pcre']);
	printStep1Template('ctype', $res['ctype']);
	printStep1Template('dom', $res['dom']);
	printStep1Template('xml', $res['xml']);
	printStep1Template('mbstring', $res['mbstring']);
	printStep1Template('fileinfo', $res['fileinfo']);
	?>
	<h2><?= _t('admin.check_install.files') ?></h2>
	<?php
	printStep1Template('data', $res['data'], [DATA_PATH, $processUsername]);
	printStep1Template('cache', $res['cache'], [CACHE_PATH, $processUsername]);
	printStep1Template('tmp', $res['tmp'], [TMP_PATH, $processUsername]);
	printStep1Template('users', $res['users'], [USERS_PATH, $processUsername]);
	printStep1Template('favicons', $res['favicons'], [DATA_PATH . '/favicons', $processUsername]);
	?>

	<?php if (freshrss_already_installed() && $res['all'] == 'ok') { ?>
	<p class="alert alert-warn"><span class="alert-head"><?= _t('gen.short.attention') ?></span> <?= _t('install.check.already_installed') ?></p>

	<div class="form-group form-actions">
		<div class="group-controls">
			<form action="index.php?step=1" method="post">
				<input type="hidden" name="freshrss-keep-install" value="1" />
				<button type="submit" class="btn btn-important" tabindex="1"><?= _t('install.action.keep_install') ?></button>
				<a class="btn btn-attention confirm" data-str-confirm="<?= _t('install.js.confirm_reinstall') ?>"
					href="?step=2" tabindex="2"><?= _t('install.action.reinstall') ?></a>
			</form>
		</div>
	</div>

	<?php } elseif ($res['all'] == 'ok') { ?>
	<div class="form-group form-actions">
		<div class="group-controls">
			<a class="btn btn-important" href="?step=2" tabindex="1"><?= _t('install.action.next_step') ?></a>
		</div>
	</div>
	<?php } else { ?>
	<p class="alert alert-error"><?= _t('install.action.fix_errors_before') ?></p>
	<div class="form-group form-actions">
		<div class="group-controls">
			<a id="actualize" class="btn" href="./index.php?step=1" title="<?= _t('install.check.reload') ?>" tabindex="1">
				<img class="icon" src="../themes/icons/refresh.svg" alt="🔃" loading="lazy" />
			</a>
		</div>
	</div>
	<?php } ?>
<?php
}

/* Select database & configuration */
function printStep2(): void {
	$system_default_config = FreshRSS_SystemConfiguration::get('default_system');
	$s2 = checkStep2();
	if ($s2['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.bdd.conf.ok') ?></p>
	<?php } elseif ($s2['conn'] == 'ko') { ?>
	<p class="alert alert-error"><span class="alert-head"><?= _t('gen.short.damn') ?></span> <?= _t('install.bdd.conf.ko'),
		(empty($_SESSION['bd_error']) ? '' : ' : ' . $_SESSION['bd_error']) ?></p>
	<?php } ?>

	<form action="index.php?step=2" method="post" autocomplete="off">
		<legend><?= _t('install.bdd.conf') ?></legend>
		<div class="form-group">
			<label class="group-name" for="type"><?= _t('install.bdd.type') ?></label>
			<div class="group-controls">
				<select name="type" id="type" tabindex="1">
				<?php if (extension_loaded('pdo_sqlite')) {?>
				<option value="sqlite"
					<?= isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'sqlite' ? 'selected="selected"' : '' ?>>
					SQLite
				</option>
				<?php }?>
				<?php if (extension_loaded('pdo_mysql')) {?>
				<option value="mysql"
					<?= isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'mysql' ? 'selected="selected"' : '' ?>>
					MySQL
				</option>
				<?php }?>
				<?php if (extension_loaded('pdo_pgsql')) {?>
				<option value="pgsql"
					<?= isset($_SESSION['bd_type']) && $_SESSION['bd_type'] === 'pgsql' ? 'selected="selected"' : '' ?>>
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
				<input type="text" id="host" name="host" pattern="[0-9A-Z/a-z_.-]{1,64}(:[0-9]{2,5})?" value="<?=
					$_SESSION['bd_host'] ?? $system_default_config->db['host'] ?? '' ?>" tabindex="2" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="user"><?= _t('install.bdd.username') ?></label>
			<div class="group-controls">
				<input type="text" id="user" name="user" maxlength="64" pattern="[0-9A-Za-z@_.-]{1,64}" value="<?=
					$_SESSION['bd_user'] ?? '' ?>" tabindex="3" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="pass"><?= _t('install.bdd.password') ?></label>
			<div class="group-controls">
				<div class="stick">
					<input type="password" id="pass" name="pass" value="<?=
						$_SESSION['bd_password'] ?? '' ?>" tabindex="4" autocomplete="off" />
					<a class="btn toggle-password" data-toggle="pass" tabindex="5"><?= FreshRSS_Themes::icon('key') ?></a>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="base"><?= _t('install.bdd') ?></label>
			<div class="group-controls">
				<input type="text" id="base" name="base" maxlength="64" pattern="[0-9A-Za-z_-]{1,64}" value="<?=
					$_SESSION['bd_base'] ?? '' ?>" tabindex="6" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="prefix"><?= _t('install.bdd.prefix') ?></label>
			<div class="group-controls">
				<input type="text" id="prefix" name="prefix" maxlength="16" pattern="[0-9A-Za-z_]{1,16}" value="<?=
					$_SESSION['bd_prefix'] ?? $system_default_config->db['prefix'] ?? '' ?>" tabindex="7" />
			</div>
		</div>
		</div>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important" tabindex="8" ><?= _t('gen.action.submit') ?></button>
				<button type="reset" class="btn" tabindex="9" ><?= _t('gen.action.cancel') ?></button>
				<?php if ($s2['all'] == 'ok') { ?>
				<a class="next-step" href="?step=3" tabindex="10" ><?= _t('install.action.next_step') ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function no_auth(string $auth_type): bool {
	return !in_array($auth_type, ['form', 'http_auth', 'none'], true);
}

/* Create default user */
function printStep3(): void {
	$auth_type = $_SESSION['auth_type'] ?? '';
	$s3 = checkStep3();
	if ($s3['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('gen.short.ok') ?></span> <?= _t('install.conf.ok') ?></p>
	<?php } elseif (!empty($_POST)) { ?>
	<p class="alert alert-error"><?= _t('install.fix_errors_before') ?></p>
	<?php } ?>

	<form action="index.php?step=3" method="post">
		<legend><?= _t('install.conf') ?></legend>

		<div class="form-group">
			<label class="group-name" for="default_user"><?= _t('install.default_user') ?></label>
			<div class="group-controls">
				<input type="text" id="default_user" name="default_user" autocomplete="username" required="required" size="16"
					pattern="<?= FreshRSS_user_Controller::USERNAME_PATTERN ?>" value="<?= $_SESSION['default_user'] ?? '' ?>"
					placeholder="<?= httpAuthUser(false) == '' ? 'alice' : httpAuthUser(false) ?>" tabindex="1" />
				<p class="help"><?= _i('help') ?> <?= _t('install.default_user.max_char') ?></p>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="auth_type"><?= _t('install.auth.type') ?></label>
			<div class="group-controls">
				<select id="auth_type" name="auth_type" required="required" tabindex="2">
					<option value="form"<?= $auth_type === 'form' || (no_auth($auth_type) && cryptAvailable()) ? ' selected="selected"' : '',
						cryptAvailable() ? '' : ' disabled="disabled"' ?>><?= _t('install.auth.form') ?></option>
					<option value="http_auth"<?= $auth_type === 'http_auth' ? ' selected="selected"' : '',
						httpAuthUser(false) == '' ? ' disabled="disabled"' : '' ?>>
							<?= _t('install.auth.http') ?> (REMOTE_USER = '<?= httpAuthUser(false) ?>')</option>
					<option value="none"<?= $auth_type === 'none' || (no_auth($auth_type) && !cryptAvailable()) ? ' selected="selected"' : ''
						?>><?= _t('install.auth.none') ?></option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="passwordPlain"><?= _t('install.auth.password_form') ?></label>
			<div class="group-controls">
				<div class="stick">
					<input type="password" id="passwordPlain" name="passwordPlain" pattern=".{7,}"
						autocomplete="off" <?= $auth_type === 'form' ? ' required="required"' : '' ?> tabindex="3" />
					<button type="button" class="btn toggle-password" data-toggle="passwordPlain" tabindex="4"><?= FreshRSS_Themes::icon('key') ?></button>
				</div>
				<p class="help"><?= _i('help') ?> <?= _t('install.auth.password_format') ?></p>
				<noscript><b><?= _t('gen.js.should_be_activated') ?></b></noscript>
			</div>
		</div>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important" tabindex="5" ><?= _t('gen.action.submit') ?></button>
				<button type="reset" class="btn" tabindex="6" ><?= _t('gen.action.cancel') ?></button>
				<?php if ($s3['all'] == 'ok') { ?>
				<a class="next-step" href="?step=4" tabindex="7" ><?= _t('install.action.next_step') ?></a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

/* congrats. Installation successful completed */
function printStep4(): void {
?>
	<p class="alert alert-success"><span class="alert-head"><?= _t('install.congratulations') ?></span> <?= _t('install.ok') ?></p>
	<div class="form-group form-actions">
		<div class="group-controls">
			<a class="btn btn-important" href="?step=5" tabindex="1"><?= _t('install.action.finish') ?></a>
		</div>
	</div>
<?php
}

/* failed */
function printStep5(): void {
?>
	<p class="alert alert-error">
		<span class="alert-head"><?= _t('gen.short.damn') ?></span>
		<?= _t('install.missing_applied_migrations', DATA_PATH . '/applied_migrations.txt') ?>
	</p>
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
	if (setupMigrations()) {
		header('Location: index.php');
	}
	break;
}
?>
<!DOCTYPE html>
<html <?php
if (_t('gen.dir') === 'rtl') {
	echo ' dir="rtl" class="rtl"';
}
?>>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="initial-scale=1.0" />
		<script id="jsonVars" type="application/json">{}</script>
		<title><?= _t('install.title') ?>: <?= _t('install.step', STEP + 1) ?></title>
		<link rel="stylesheet" href="../themes/base-theme/frss.css?<?= @filemtime(PUBLIC_PATH . '/themes/base-theme/frss.css') ?>" />
		<link rel="stylesheet" href="../themes/Origine/origine.css?<?= @filemtime(PUBLIC_PATH . '/themes/Origine/origine.css') ?>" />
		<link rel="shortcut icon" id="favicon" type="image/x-icon" sizes="16x16 64x64" href="../favicon.ico" />
		<link rel="icon msapplication-TileImage apple-touch-icon" type="image/png" sizes="256x256" href="../themes/icons/favicon-256.png" />
		<link rel="apple-touch-icon" href="../themes/icons/apple-touch-icon.png" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="apple-mobile-web-app-title" content="FreshRSS">
		<meta name="robots" content="noindex,nofollow" />
	</head>
	<body>

<header class="header">
	<div class="item title">
		<div id="logo-wrapper">
			<a href="./">
				<img class="logo" src="../themes/icons/FreshRSS-logo.svg" alt="" loading="lazy">
			</a>
		</div>
	</div>
	<div class="item"></div>
	<div class="item configure">
		<a class="btn only-mobile" href="#aside"><?= _i('view-normal') ?></a>
	</div>
</header>

<div id="global">
	<nav class="nav nav-list aside" id="aside">
		<a class="toggle_aside" href="#close"><img class="icon" src="../themes/icons/close.svg" loading="lazy" alt="❌"></a>
		<ul>
			<li class="item nav-section">
				<div class="nav-header"><?= _t('install.steps') ?></div>
				<ol>
					<li class="item<?= STEP == 0 ? ' active' : '' ?>">
						<a href="?step=0" title="<?= _t('install.step', 0) ?>: <?= _t('install.language') ?>"><?= _t('install.language') ?></a>
					</li>
					<li class="item<?= STEP == 1 ? ' active' : '' ?>">
						<?php if (STEP > 0) {?>
						<a href="?step=1" title="<?= _t('install.step', 1) ?>: <?= _t('install.check') ?>"><?= _t('install.check') ?></a>
						<?php } else { ?>
						<span><?= _t('install.check') ?></span>
						<?php } ?>
					</li>
					<li class="item<?= STEP == 2 ? ' active' : '' ?>">
						<?php if (STEP > 1) {?>
						<a href="?step=2" title="<?= _t('install.step', 2) ?>: <?= _t('install.bdd.conf') ?>"><?= _t('install.bdd.conf') ?></a>
						<?php } else { ?>
						<span><?= _t('install.bdd.conf') ?></span>
						<?php } ?>
					</li>
					<li class="item<?= STEP == 3 ? ' active' : '' ?>">
						<?php if (STEP > 2) {?>
						<a href="?step=3" title="<?= _t('install.step', 3) ?>: <?= _t('install.conf') ?>"><?= _t('install.conf') ?></a>
						<?php } else { ?>
						<span><?= _t('install.conf') ?></span>
						<?php } ?>
					</li>
					<li class="item<?= STEP == 4 ? ' active' : '' ?>">
						<?php if (STEP > 3) {?>
						<a href="?step=4" title="<?= _t('install.step', 4) ?>: <?= _t('install.this_is_the_end') ?>"><?= _t('install.this_is_the_end') ?></a>
						<?php } else { ?>
						<span><?= _t('install.this_is_the_end') ?></span>
						<?php } ?>
					</li>
				</ol>
			</li>
		</ul>
	</nav>
	<a class="close-aside" href="#close">❌</a>

	<main class="post">
		<h1><?= _t('install.title') ?>: <?= _t('install.step', STEP + 1) ?></h1>
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
	</main>
</div>
	<script src="../scripts/install.js?<?= @filemtime(PUBLIC_PATH . '/scripts/install.js') ?>"></script>
	</body>
</html>

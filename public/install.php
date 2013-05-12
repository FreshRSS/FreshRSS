<?php

session_start ();

if (isset ($_GET['step'])) {
	define ('STEP', $_GET['step']);
} else {
	define ('STEP', 1);
}

define ('SQL_REQ', 'CREATE TABLE IF NOT EXISTS `category` (
  `id` varchar(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `entry` (
  `id` varchar(6) NOT NULL,
  `guid` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `link` text NOT NULL,
  `date` int(11) NOT NULL,
  `is_read` int(11) NOT NULL,
  `is_favorite` int(11) NOT NULL,
  `is_public` int(1) NOT NULL,
  `id_feed` varchar(6) NOT NULL,
  `annotation` text NOT NULL,
  `tags` text NOT NULL,
  `lastUpdate` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_feed` (`id_feed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `feed` (
  `id` varchar(6) NOT NULL,
  `url` text NOT NULL,
  `category` varchar(6) DEFAULT \'000000\',
  `name` varchar(255) NOT NULL,
  `website` text NOT NULL,
  `description` text NOT NULL,
  `lastUpdate` int(11) NOT NULL,
  `priority` int(2) NOT NULL DEFAULT \'10\',
  `pathEntries` varchar(500) DEFAULT NULL,
  `httpAuth` varchar(500) DEFAULT NULL,
  `error` int(1) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `entry`
  ADD CONSTRAINT `entry_ibfk_1` FOREIGN KEY (`id_feed`) REFERENCES `feed` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `feed`
  ADD CONSTRAINT `feed_ibfk_4` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;');

function writeLine ($f, $line) {
	fwrite ($f, $line . "\n");
}
function writeArray ($f, $array) {
	foreach ($array as $key => $val) {
		if (is_array ($val)) {
			writeLine ($f, '\'' . $key . '\' => array (');
			writeArray ($f, $val);
			writeLine ($f, '),');
		} else {
			writeLine ($f, '\'' . $key . '\' => \'' . $val . '\',');
		}
	}
}

// gestion internationalisation
$translates = array ();
$actual = 'en';
function initTranslate () {
	global $translates;
	global $actual;

	$l = getBetterLanguage ('en');
	if (isset ($_SESSION['language'])) {
		$l = $_SESSION['language'];
	}
	$actual = $l;

	$file = APP_PATH . '/i18n/' . $actual . '.php';
	if (file_exists ($file)) {
		$translates = include ($file);
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
		if (empty ($_POST['sel']) ||
		    empty ($_POST['title']) ||
		    empty ($_POST['old_entries'])) {
			return false;
		}

		$_SESSION['sel'] = $_POST['sel'];
		$_SESSION['base_url'] = $_POST['base_url'];
		$_SESSION['title'] = $_POST['title'];
		$_SESSION['old_entries'] = $_POST['old_entries'];
		if (!is_int (intval ($_SESSION['old_entries'])) ||
		    $_SESSION['old_entries'] < 1) {
			$_SESSION['old_entries'] = 3;
		}
		$_SESSION['mail_login'] = $_POST['mail_login'];

		$file_data = PUBLIC_PATH . '/data/Configuration.array.php';

		$f = fopen ($file_data, 'w');
		writeLine ($f, '<?php');
		writeLine ($f, 'return array (');
		writeArray ($f, array (
			'language' => $_SESSION['language'],
			'old_entries' => $_SESSION['old_entries'],
			'mail_login' => $_SESSION['mail_login']
		));
		writeLine ($f, ');');
		fclose ($f);

		header ('Location: index.php?step=3');
	}
}
function saveStep3 () {
	if (!empty ($_POST)) {
		if (empty ($_POST['host']) ||
		    empty ($_POST['user']) ||
		    empty ($_POST['pass']) ||
		    empty ($_POST['base'])) {
			return false;
		}

		$_SESSION['bd_host'] = $_POST['host'];
		$_SESSION['bd_user'] = $_POST['user'];
		$_SESSION['bd_pass'] = $_POST['pass'];
		$_SESSION['bd_name'] = $_POST['base'];

		$file_conf = APP_PATH . '/configuration/application.ini';
		$f = fopen ($file_conf, 'w');
		writeLine ($f, '[general]');
		writeLine ($f, 'environment = "production"');
		writeLine ($f, 'use_url_rewriting = false');
		writeLine ($f, 'sel_application = "' . $_SESSION['sel'] . '"');
		writeLine ($f, 'base_url = "' . $_SESSION['base_url'] . '"');
		writeLine ($f, 'title = "' . $_SESSION['title'] . '"');
		writeLine ($f, '[db]');
		writeLine ($f, 'host = "' . $_SESSION['bd_host'] . '"');
		writeLine ($f, 'user = "' . $_SESSION['bd_user'] . '"');
		writeLine ($f, 'password = "' . $_SESSION['bd_pass'] . '"');
		writeLine ($f, 'base = "' . $_SESSION['bd_name'] . '"');
		fclose ($f);

		$res = checkBD ();

		if ($res) {
			header ('Location: index.php?step=4');
		}
	}
}
function deleteInstall () {
	$res = unlink (PUBLIC_PATH . '/install.php');
	if ($res) {
		header ('Location: index.php');
	}
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
}
function checkStep0 () {
	$languages = availableLanguages ();
	$language = isset ($_SESSION['language']) &&
	            isset ($languages[$_SESSION['language']]);

	return array (
		'language' => $language ? 'ok' : 'ko',
		'all' => $language ? 'ok' : 'ko'
	);
}
function checkStep1 () {
	$php = version_compare (PHP_VERSION, '5.1.0') >= 0;
	$minz = file_exists (LIB_PATH . '/minz');
	$curl = extension_loaded ('curl');
	$pdo = extension_loaded ('pdo_mysql');
	$cache = CACHE_PATH && is_writable (CACHE_PATH);
	$log = LOG_PATH && is_writable (LOG_PATH);
	$conf = APP_PATH && is_writable (APP_PATH . '/configuration');
	$data = is_writable (PUBLIC_PATH . '/data');

	return array (
		'php' => $php ? 'ok' : 'ko',
		'minz' => $minz ? 'ok' : 'ko',
		'curl' => $curl ? 'ok' : 'ko',
		'pdo-mysql' => $pdo ? 'ok' : 'ko',
		'cache' => $cache ? 'ok' : 'ko',
		'log' => $log ? 'ok' : 'ko',
		'configuration' => $conf ? 'ok' : 'ko',
		'data' => $data ? 'ok' : 'ko',
		'all' => $php && $minz && $curl && $pdo && $cache && $log && $conf && $data ? 'ok' : 'ko'
	);
}
function checkStep2 () {
	$conf = isset ($_SESSION['sel']) &&
	        isset ($_SESSION['base_url']) &&
	        isset ($_SESSION['title']) &&
	        isset ($_SESSION['old_entries']) &&
	        isset ($_SESSION['mail_login']);
	$data = file_exists (PUBLIC_PATH . '/data/Configuration.array.php');

	return array (
		'conf' => $conf ? 'ok' : 'ko',
		'data' => $data ? 'ok' : 'ko',
		'all' => $conf && $data ? 'ok' : 'ko'
	);
}
function checkStep3 () {
	$conf = file_exists (APP_PATH . '/configuration/application.ini');
	$bd = isset ($_SESSION['bd_host']) &&
	      isset ($_SESSION['bd_user']) &&
	      isset ($_SESSION['bd_pass']) &&
	      isset ($_SESSION['bd_name']);

	return array (
		'bd' => $bd ? 'ok' : 'ko',
		'conf' => $conf ? 'ok' : 'ko',
		'all' => $bd && $conf ? 'ok' : 'ko'
	);
}
function checkBD () {
	$error = false;

	try {
		$c = new PDO ('mysql:host=' . $_SESSION['bd_host'] . ';dbname=' . $_SESSION['bd_name'],
			      $_SESSION['bd_user'],
			      $_SESSION['bd_pass']);

		$res = $c->query (SQL_REQ);

		if (!$res) {
			$error = true;
		}
	} catch (PDOException $e) {
		$error = true;
	}

	if ($error && file_exists (APP_PATH . '/configuration/application.ini')) {
		unlink (APP_PATH . '/configuration/application.ini');
	}

	return !$error;
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
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('php_is_nok', PHP_VERSION, '5.1.0'); ?></p>
	<?php } ?>

	<?php if ($res['minz'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('minz_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('minz_is_nok', LIB_PATH . '/minz'); ?></p>
	<?php } ?>

	<?php if ($res['curl'] == 'ok') { ?>
	<?php $version = curl_version(); ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('curl_is_ok', $version['version']); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('curl_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['pdo-mysql'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('pdomysql_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('pdomysql_is_nok'); ?></p>
	<?php } ?>

	<?php if ($res['cache'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('cache_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('file_is_nok', PUBLIC_PATH . '/../cache'); ?></p>
	<?php } ?>

	<?php if ($res['log'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('log_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('file_is_nok', PUBLIC_PATH . '/../log'); ?></p>
	<?php } ?>

	<?php if ($res['configuration'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('conf_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('file_is_nok', APP_PATH . '/configuration'); ?></p>
	<?php } ?>

	<?php if ($res['data'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('ok'); ?></span> <?php echo _t ('data_is_ok'); ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('damn'); ?></span> <?php echo _t ('file_is_nok', PUBLIC_PATH . '/data'); ?></p>
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
			<label class="group-name" for="sel"><?php echo _t ('random_string'); ?></label>
			<div class="group-controls">
				<input type="text" id="sel" name="sel" value="<?php echo isset ($_SESSION['sel']) ? $_SESSION['sel'] : '123~abcdefghijklmnopqrstuvwxyz~321'; ?>" /> <i class="icon i_help"></i> <?php echo _t ('change_value'); ?>
			</div>
		</div>

		<?php
			$url = substr ($_SERVER['PHP_SELF'], 0, -10);
		?>
		<div class="form-group">
			<label class="group-name" for="base_url"><?php echo _t ('base_url'); ?></label>
			<div class="group-controls">
				<input type="text" id="base_url" name="base_url" value="<?php echo isset ($_SESSION['base_url']) ? $_SESSION['base_url'] : $url; ?>" /> <i class="icon i_help"></i> <?php echo _t ('do_not_change_if_doubt'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="title"><?php echo _t ('title'); ?></label>
			<div class="group-controls">
				<input type="text" id="title" name="title" value="<?php echo isset ($_SESSION['title']) ? $_SESSION['title'] : _t ('freshrss'); ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="old_entries"><?php echo _t ('delete_articles_every'); ?></label>
			<div class="group-controls">
				<input type="number" id="old_entries" name="old_entries" value="<?php echo isset ($_SESSION['old_entries']) ? $_SESSION['old_entries'] : '3'; ?>" /> <?php echo _t ('month'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="mail_login"><?php echo _t ('persona_connection_email'); ?></label>
			<div class="group-controls">
				<input type="email" id="mail_login" name="mail_login" value="<?php echo isset ($_SESSION['mail_login']) ? $_SESSION['mail_login'] : ''; ?>" placeholder="<?php echo _t ('blank_to_disable'); ?>" />
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
	<?php } ?>

	<form action="index.php?step=3" method="post">
		<legend><?php echo _t ('bdd_configuration'); ?></legend>
		<div class="form-group">
			<label class="group-name" for="host"><?php echo _t ('host'); ?></label>
			<div class="group-controls">
				<input type="text" id="host" name="host" value="<?php echo isset ($_SESSION['bd_host']) ? $_SESSION['bd_host'] : 'localhost'; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="user"><?php echo _t ('username'); ?></label>
			<div class="group-controls">
				<input type="text" id="user" name="user" value="<?php echo isset ($_SESSION['bd_user']) ? $_SESSION['bd_user'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="pass"><?php echo _t ('password'); ?></label>
			<div class="group-controls">
				<input type="password" id="pass" name="pass" value="<?php echo isset ($_SESSION['bd_pass']) ? $_SESSION['bd_pass'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="base"><?php echo _t ('bdd'); ?></label>
			<div class="group-controls">
				<input type="text" id="base" name="base" value="<?php echo isset ($_SESSION['bd_name']) ? $_SESSION['bd_name'] : ''; ?>" />
			</div>
		</div>

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
	<p class="alert alert-success"><span class="alert-head"><?php echo _t ('congratulations'); ?></span> <?php echo _t ('installation_is_ok'); ?></p>
	<a class="btn btn-important next-step" href="?step=5"><?php echo _t ('finish_installation'); ?></a>
<?php
}

function printStep5 () {
?>
	<p class="alert alert-error"><span class="alert-head"><?php echo _t ('oops'); ?></span> <?php echo _t ('install_not_deleted', PUBLIC_PATH . '/install.php'); ?></p>
<?php
}

initTranslate ();

checkStep ();

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
	break;
case 5:
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
		<link rel="stylesheet" type="text/css" media="all" href="theme/fallback.css" />
		<link rel="stylesheet" type="text/css" media="all" href="theme/global.css" />
		<link rel="stylesheet" type="text/css" media="all" href="theme/freshrss.css" />
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
		<li class="item<?php echo STEP == 4 ? ' active' : ''; ?>"><a href="?step=4"><?php echo _t ('this_is_the_end'); ?></a></li>
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
		}
		?>
	</div>
</div>
	</body>
</html>


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

/*** SAUVEGARDES ***/
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

		$conf = array (
			'posts_per_page' => 20,
			'default_view' => 'not_read',
			'display_posts' => 'no',
			'sort_order' => 'low_to_high',
			'old_entries' => $_SESSION['old_entries'],
			'mail_login' => $_SESSION['mail_login'],
			'shortcuts' => array (
				'mark_read' => 'r',
				'mark_favorite' => 'f',
				'go_website' => 'space',
				'next_entry' => 'j',
				'prev_entry' => 'k',
				'next_page' => 'right',
				'prev_page' => 'left',
			),
			'mark_when' => array (
				'article' => 'yes',
				'site' => 'yes',
				'page' => 'no',
			),
		);
		$f = fopen ($file_data, 'w');
		writeLine ($f, '<?php');
		writeLine ($f, 'return array (');
		writeArray ($f, $conf);
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
	if (STEP > 1 && checkStep1 ()['all'] != 'ok') {
		header ('Location: index.php?step=1');
	} elseif (STEP > 2 && checkStep2 ()['all'] != 'ok') {
		header ('Location: index.php?step=2');
	} elseif (STEP > 3 && checkStep3 ()['all'] != 'ok') {
		header ('Location: index.php?step=3');
	}
}
function checkStep1 () {
	$php = version_compare (PHP_VERSION, '5.1.0') >= 0;
	$minz = file_exists (LIB_PATH . '/minz');
	$curl = extension_loaded ('curl');
	$pdo = extension_loaded ('pdo_mysql');
	$cache = CACHE_PATH && is_writable (CACHE_PATH);
	$conf = APP_PATH && is_writable (APP_PATH . '/configuration');
	$data = is_writable (PUBLIC_PATH . '/data');

	return array (
		'php' => $php ? 'ok' : 'ko',
		'minz' => $minz ? 'ok' : 'ko',
		'curl' => $curl ? 'ok' : 'ko',
		'pdo-mysql' => $pdo ? 'ok' : 'ko',
		'cache' => $cache ? 'ok' : 'ko',
		'configuration' => $conf ? 'ok' : 'ko',
		'data' => $data ? 'ok' : 'ko',
		'all' => $php && $minz && $curl && $pdo && $cache && $conf && $data ? 'ok' : 'ko'
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
function printStep1 () {
	$res = checkStep1 ();
?>
	<noscript><p class="alert alert-warn"><span class="alert-head">Attention !</span> FreshRSS est plus agréable à utiliser avec le Javascript d'activé</p></noscript>

	<?php if ($res['php'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head">Ok !</span> Votre version de PHP est la <?php echo PHP_VERSION; ?> et est compatible avec FreshRSS</p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head">Arf !</span> Votre version de PHP est la <?php echo PHP_VERSION; ?>. Vous devriez avoir au moins la version 5.1.0</p>
	<?php } ?>

	<?php if ($res['minz'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head">Ok !</span> Vous disposez du framework Minz</p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head">Arf !</span> Vous ne disposez pas de la librairie Minz. Vous devriez exécuter le script <em>build.sh</em> ou bien <a href="https://github.com/marienfressinaud/MINZ">la télécharger sur Github</a> et installer dans le répertoire <em><?php echo LIB_PATH . '/minz'; ?></em> le contenu de son répertoire <em>/lib</em>.</p>
	<?php } ?>

	<?php $version = curl_version(); ?>
	<?php if ($res['curl'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head">Ok !</span> Vous disposez de cURL dans sa version <?php echo $version['version']; ?></p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head">Arf !</span> Vous ne disposez pas de cURL</p>
	<?php } ?>

	<?php if ($res['pdo-mysql'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head">Ok !</span> Vous disposez de PDO et de son driver pour MySQL</p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head">Arf !</span> Vous ne disposez pas de PDO ou de son driver pour MySQL</p>
	<?php } ?>

	<?php if ($res['cache'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head">Ok !</span> Les droits sur le répertoire de cache sont bons</p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head">Arf !</span> Veuillez vérifier les droits sur le répertoire <em><?php echo PUBLIC_PATH . '/../cache'; ?></em>. Le serveur HTTP doit être capable d'écrire dedans</p>
	<?php } ?>

	<?php if ($res['configuration'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head">Ok !</span> Les droits sur le répertoire de configuration sont bons</p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head">Arf !</span> Veuillez vérifier les droits sur le répertoire <em><?php echo APP_PATH . '/configuration'; ?></em>. Le serveur HTTP doit être capable d'écrire dedans</p>
	<?php } ?>

	<?php if ($res['data'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head">Ok !</span> Les droits sur le répertoire de data sont bons</p>
	<?php } else { ?>
	<p class="alert alert-error"><span class="alert-head">Arf !</span> Veuillez vérifier les droits sur le répertoire <em><?php echo PUBLIC_PATH . '/data'; ?></em>. Le serveur HTTP doit être capable d'écrire dedans</p>
	<?php } ?>

	<?php if ($res['all'] == 'ok') { ?>
	<a class="btn btn-important next-step" href="?step=2">Passer à l'étape suivante</a>
	<?php } else { ?>
	Veuillez corriger les erreurs avant de passer à l'étape suivante.
	<?php } ?>
<?php
}

function printStep2 () {
?>
	<?php if (checkStep2 ()['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head">Ok !</span> La configuration générale a été enregistrée.</p>
	<?php } ?>

	<form action="index.php?step=2" method="post">
		<legend>Configuration générale</legend>
		<div class="form-group">
			<label class="group-name" for="sel">Chaîne aléatoire</label>
			<div class="group-controls">
				<input type="text" id="sel" name="sel" value="<?php echo isset ($_SESSION['sel']) ? $_SESSION['sel'] : '123~abcdefghijklmnopqrstuvwxyz~321'; ?>" /> <i class="icon i_help"></i> Vous devriez changer cette valeur par n'importe quelle autre
			</div>
		</div>

		<?php
			$url = substr ($_SERVER['PHP_SELF'], 0, -10);
		?>
		<div class="form-group">
			<label class="group-name" for="base_url">Base de l'url</label>
			<div class="group-controls">
				<input type="text" id="base_url" name="base_url" value="<?php echo isset ($_SESSION['base_url']) ? $_SESSION['base_url'] : $url; ?>" /> <i class="icon i_help"></i> Laissez tel quel dans le doute
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="title">Titre</label>
			<div class="group-controls">
				<input type="text" id="title" name="title" value="<?php echo isset ($_SESSION['title']) ? $_SESSION['title'] : 'FreshRSS'; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="old_entries">Supprimer les articles tous les</label>
			<div class="group-controls">
				<input type="number" id="old_entries" name="old_entries" value="<?php echo isset ($_SESSION['old_entries']) ? $_SESSION['old_entries'] : '3'; ?>" /> mois
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="mail_login">Adresse mail de connexion (utilise <a href="https://persona.org/">Persona</a>)</label>
			<div class="group-controls">
				<input type="email" id="mail_login" name="mail_login" value="<?php echo isset ($_SESSION['mail_login']) ? $_SESSION['mail_login'] : ''; ?>" placeholder="Laissez vide pour désactiver" />
				<noscript><b>nécessite que javascript soit activé</b></noscript>
			</div>
		</div>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important">Valider</button>
				<button type="reset" class="btn">Annuler</button>
				<?php if (checkStep2 ()['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=3">Passer à l'étape suivante</a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function printStep3 () {
?>
	<?php if (checkStep3 ()['all'] == 'ok') { ?>
	<p class="alert alert-success"><span class="alert-head">Ok !</span> La configuration de la base de données a été enregistrée.</p>
	<?php } ?>

	<form action="index.php?step=3" method="post">
		<legend>Configuration de la base de données</legend>
		<div class="form-group">
			<label class="group-name" for="host">Host</label>
			<div class="group-controls">
				<input type="text" id="host" name="host" value="<?php echo isset ($_SESSION['bd_host']) ? $_SESSION['bd_host'] : 'localhost'; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="user">Username</label>
			<div class="group-controls">
				<input type="text" id="user" name="user" value="<?php echo isset ($_SESSION['bd_user']) ? $_SESSION['bd_user'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="pass">Password</label>
			<div class="group-controls">
				<input type="password" id="pass" name="pass" value="<?php echo isset ($_SESSION['bd_pass']) ? $_SESSION['bd_pass'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="group-name" for="base">Base de données</label>
			<div class="group-controls">
				<input type="text" id="base" name="base" value="<?php echo isset ($_SESSION['bd_name']) ? $_SESSION['bd_name'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group form-actions">
			<div class="group-controls">
				<button type="submit" class="btn btn-important">Valider</button>
				<button type="reset" class="btn">Annuler</button>
				<?php if (checkStep3 ()['all'] == 'ok') { ?>
				<a class="btn btn-important next-step" href="?step=4">Passer à l'étape suivante</a>
				<?php } ?>
			</div>
		</div>
	</form>
<?php
}

function printStep4 () {
?>
	<p class="alert alert-success"><span class="alert-head">Félicitations !</span> L'installation s'est bien passée. Il faut maintenant supprimer le fichier <em>install.php</em> pour pouvoir accéder à FreshRSS... ou simplement cliquer sur le bouton ci-dessous ;)</p>
	<a class="btn btn-important next-step" href="?step=5">Terminer l'installation</a>
<?php
}

function printStep5 () {
?>
	<p class="alert alert-error"><span class="alert-head">Oups !</span> Quelque chose s'est mal passé, vous devriez supprimer le fichier <?php echo PUBLIC_PATH . '/install.php' ?> à la main.</p>
<?php
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0">
		<title>Installation - FreshRSS</title>
		<link rel="stylesheet" type="text/css" media="all" href="theme/global.css" />
		<link rel="stylesheet" type="text/css" media="all" href="theme/freshrss.css" />
	</head>
	<body>

<div class="header">
	<div class="item title">
		<h1><a href="index.php">FreshRSS</a></h1>
		<h2>Installation - étape <?php echo STEP; ?></h2>
	</div>
</div>

<div id="global">
	<ul class="nav nav-list aside">
		<li class="nav-header">Étapes</li>
		<li class="item<?php echo STEP == 1 ? ' active' : ''; ?>"><a href="?step=1">Vérifications</a></li>
		<li class="item<?php echo STEP == 2 ? ' active' : ''; ?>"><a href="?step=2">Configuration générale</a></li>
		<li class="item<?php echo STEP == 3 ? ' active' : ''; ?>"><a href="?step=3">Configuration de la base de données</a></li>
		<li class="item<?php echo STEP == 4 ? ' active' : ''; ?>"><a href="?step=4">This is the end</a></li>
	</ul>

	<div class="post">
		<?php
		checkStep ();

		switch (STEP) {
		case 1:
		default:
			printStep1 ();
			break;
		case 2:
			saveStep2 ();
			printStep2 ();
			break;
		case 3:
			saveStep3 ();
			printStep3 ();
			break;
		case 4:
			printStep4 ();
			break;
		case 5:
			deleteInstall ();
			printStep5 ();
			break;
		}
		?>
	</div>
</div>
	</body>
</html>


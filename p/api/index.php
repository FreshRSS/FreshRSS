<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/constants.php';
require LIB_PATH . '/lib_rss.php';	//Includes class autoloader

FreshRSS_Context::initSystem();
if (!FreshRSS_Context::hasSystemConf()) {
	header('HTTP/1.1 500 Internal Server Error');
	die('Invalid system init!');
}
$frameAncestors = FreshRSS_Context::systemConf()->attributeString('csp.frame-ancestors') ?? "'none'";
header("Content-Security-Policy: default-src 'self'; frame-ancestors $frameAncestors");
header('X-Content-Type-Options: nosniff');

Minz_Translate::init(Minz_Translate::getLanguage(null, Minz_Request::getPreferredLanguages(), null));
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB" lang="en-GB">
<head>
<meta charset="UTF-8" />
<title><?= _t('api.information.title') ?></title>
<meta name="robots" content="noindex" />
<link rel="start" href="../i/" />
<script src="../scripts/api.js" defer="defer"></script>
</head>

<body>
<h1><?= _t('api.information.title') ?></h1>

<h2><?= _t('api.information.title.greader') ?></h2>
<dl>
<dt><?= _t('api.information.address') ?>
</dt>
<dd><kbd><?= Minz_Url::display('/api/greader.php', 'html', true) ?></kbd></dd>
<dt><?= _t('api.information.test.greader') ?></dt>
<dd id="greaderOutput"
	data-api-url="<?= Minz_Url::display('/api/greader.php', 'php', true) ?>"
	data-i18n-pass="<?= _t('api.information.output.pass') ?>"
	data-i18n-encoding-support="<?= _t('api.information.output.encoding-support') ?>"
	data-i18n-invalid-configuration="<?= _t('api.information.output.invalid-configuration') ?>"
	data-i18n-unknown-error="<?= _t('api.information.output.unknown-error') ?>"
>?</dd>
</dl>

<h2><?= _t('api.information.title.fever') ?></h2>
<dl>
<dt><?= _t('api.information.address') ?></dt>
<dd><kbd><?= Minz_Url::display('/api/fever.php', 'html', true) ?></kbd></dd>
<dt><?= _t('api.information.test.fever') ?></dt>
<dd id="feverOutput"
	data-api-url="<?= Minz_Url::display('/api/fever.php', 'php', true) ?>"
	data-i18n-pass="<?= _t('api.information.output.pass') ?>"
	data-i18n-invalid-configuration="<?= _t('api.information.output.invalid-configuration') ?>"
	data-i18n-unknown-error="<?= _t('api.information.output.unknown-error') ?>"
>?</dd>
</dl>

<h2><?= _t('api.information.title.extension') ?></h2>
<dl>
<dt><?= _t('api.information.address') ?></dt>
<dd><kbd><?= Minz_Url::display('/api/misc.php/Extension%20name/', 'html', true) ?></kbd></dd>
</dl>

</body>
</html>

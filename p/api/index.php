<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB" lang="en-GB">
<head>
<meta charset="UTF-8" />
<title>FreshRSS API endpoints</title>
<meta name="robots" content="noindex" />
<link rel="start" href="../i/" />
<script src="../scripts/api.js" defer="defer"></script>
<script id="jsonVars" type="application/json">
<?php
require(__DIR__ . '/../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
Minz_Configuration::register('system', DATA_PATH . '/config.php', FRESHRSS_PATH . '/config.default.php');
echo json_encode(array(
		'greader' =>  Minz_Url::display('/api/greader.php', 'php', true),
		'fever' =>  Minz_Url::display('/api/fever.php', 'php', true),
	));
?>
</script>
</head>

<body>
<h1>FreshRSS API endpoints</h1>

<h2>Google Reader compatible API</h2>
<dl>
<dt>Your API address:</dt>
<dd><?php
echo Minz_Url::display('/api/greader.php', 'html', true);
?></dd>
<dt>Google Reader API configuration test:</dt>
<dd id="greaderOutput">?</dd>
</dl>

<h2>Fever compatible API</h2>
<dl>
<dt>Your API address:</dt>
<dd><?php
echo Minz_Url::display('/api/fever.php', 'html', true);
?></dd>
<dt>Fever API configuration test:</dt>
<dd id="feverOutput">?</dd>
</dl>

</body>
</html>

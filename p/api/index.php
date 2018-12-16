<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB" lang="en-GB">
<head>
<meta charset="UTF-8" />
<title>FreshRSS API endpoints</title>
<meta name="robots" content="noindex" />
<link rel="start" href="../i/" />
</head>

<body>
<h1>FreshRSS API endpoints</h1>

<h2>Google Reader compatible API</h2>
<dl>
<dt>Your API address:</dt>
<dd><?php
require(__DIR__ . '/../../constants.php');
require(LIB_PATH . '/lib_rss.php');	//Includes class autoloader
Minz_Configuration::register('system', DATA_PATH . '/config.php', FRESHRSS_PATH . '/config.default.php');
echo Minz_Url::display('/api/greader.php', 'html', true);
?></dd>
</dl>
<ul>
<li><a href="greader.php/check%2Fcompatibility" rel="nofollow">Check full server configuration</a></li>
<li><a href="greader.php/check/compatibility" rel="nofollow">Check partial server
configuration (without <code>%2F</code> support)</a></li>
</ul>

<h2>Fever compatible API</h2>
<dl>
<dt>Your API address:</dt>
<dd><?php
echo Minz_Url::display('/api/fever.php', 'html', true);
?></dd>
</dl>
<ul>
<li><a href="fever.php?api" rel="nofollow">Test</a></li>
</ul>

</body>
</html>

<?php

const PREFIX_CLI_I18N = 'Cli\\I18n\\';
const PREFIX_CSSXPATH = 'Gt\\CssXPath\\';
const PREFIX_PHPMAILER = 'PHPMailer\\PHPMailer\\';

function includeFreshrssClass($class) {
	$components = explode('_', $class);
	switch (count($components)) {
		case 1:
			include APP_PATH . "/{$components[0]}.php";
			break;
		case 2:
			include APP_PATH . "/Models/{$components[1]}.php";
			break;
		case 3:	//Controllers, Exceptions
			include APP_PATH . "/{$components[2]}s/{$components[1]}{$components[2]}.php";
			break;
	}
}

function requireClass($class, $path, $search, $replace, $prefix = null) {
	if ($prefix !== null) {
		$class = substr($class, strlen($prefix));
	}
	require $path . str_replace($search, $replace, $class) . '.php';
}

function classAutoloader($class) {
	if (str_starts_with($class, 'FreshRSS')) {
		includeFreshrssClass($class);
	} elseif (str_starts_with($class, 'Minz')) {
		requireClass($class, LIB_PATH . '/', '_', '/');
	} elseif (str_starts_with($class, 'SimplePie')) {
		requireClass($class, LIB_PATH . '/SimplePie/', '_', '/');
	} elseif (str_starts_with($class, PREFIX_CLI_I18N)) {
		requireClass($class, CLI_PATH . '/i18n/', '\\', '/', PREFIX_CLI_I18N);
	} elseif (str_starts_with($class, PREFIX_CSSXPATH)) {
		requireClass($class, LIB_PATH . '/phpgt/cssxpath/src/', '\\', '/', PREFIX_CSSXPATH);
	} elseif (str_starts_with($class, PREFIX_PHPMAILER)) {
		requireClass($class, LIB_PATH . '/phpmailer/phpmailer/src/', '\\', '/', PREFIX_PHPMAILER);
	}
}

spl_autoload_register('classAutoloader');

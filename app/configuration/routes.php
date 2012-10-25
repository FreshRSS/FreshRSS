<?php

return array (
	// Index
	array (
		'route'      => '/\?q=([\w\d\-_]+)&p=([\d+])',
		'controller' => 'index',
		'action'     => 'index',
		'params'     => array ('get', 'page')
	),
	array (
		'route'      => '/\?q=([\w\d\-_]+)',
		'controller' => 'index',
		'action'     => 'index',
		'params'     => array ('get')
	),
	array (
		'route'      => '/\?p=([\d]+)',
		'controller' => 'index',
		'action'     => 'index',
		'params'     => array ('page')
	),
	array (
		'route'      => '/login.php',
		'controller' => 'index',
		'action'     => 'login'
	),
	array (
		'route'      => '/logout.php',
		'controller' => 'index',
		'action'     => 'logout'
	),
	array (
		'route'      => '/mode.php\?m=([\w_]+)',
		'controller' => 'index',
		'action'     => 'changeMode',
		'params'     => array ('mode')
	),
	
	// Scripts
	array (
		'route'      => '/scripts/main.js',
		'controller' => 'javascript',
		'action'     => 'main'
	),
	
	// Entry
	array (
		'route'      => '/articles/marquer.php\?lu=([\d]{1})',
		'controller' => 'entry',
		'action'     => 'read',
		'params'     => array ('is_read')
	),
	array (
		'route'      => '/articles/marquer.php\?id=([\w\d\-_]{6})&favori=([\d]{1})',
		'controller' => 'entry',
		'action'     => 'bookmark',
		'params'     => array ('id', 'is_favorite')
	),
	array (
		'route'      => '/articles/marquer.php\?id=([\w\d\-_]{6})&lu=([\d]{1})',
		'controller' => 'entry',
		'action'     => 'read',
		'params'     => array ('id', 'is_read')
	),
	
	
	// Feed
	array (
		'route'      => '/flux/ajouter.php',
		'controller' => 'feed',
		'action'     => 'add'
	),
	array (
		'route'      => '/flux/actualiser.php',
		'controller' => 'feed',
		'action'     => 'actualize'
	),
	array (
		'route'      => '/flux/supprimer.php\?id=([\w\d\-_]{6})',
		'controller' => 'feed',
		'action'     => 'delete',
		'params'     => array ('id')
	),
	
	// Configure
	array (
		'route'      => '/configuration/flux.php',
		'controller' => 'configure',
		'action'     => 'feed'
	),
	array (
		'route'      => '/configuration/flux.php\?id=([\w\d\-_]{6})',
		'controller' => 'configure',
		'action'     => 'feed',
		'params'     => array ('id')
	),
	array (
		'route'      => '/configuration/categories.php',
		'controller' => 'configure',
		'action'     => 'categorize'
	),
	array (
		'route'      => '/configuration/global.php',
		'controller' => 'configure',
		'action'     => 'display'
	),
	array (
		'route'      => '/configuration/import_export.php',
		'controller' => 'configure',
		'action'     => 'importExport'
	),
	array (
		'route'      => '/configuration/import_export.php\?q=([\w]{6})',
		'controller' => 'configure',
		'action'     => 'importExport',
		'params'     => array ('q')
	),
	array (
		'route'      => '/configuration/raccourcis.php',
		'controller' => 'configure',
		'action'     => 'shortcut'
	),
);

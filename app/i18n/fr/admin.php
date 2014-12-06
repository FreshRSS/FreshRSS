<?php

return array(
	'check_install' => array(
		'cache' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data/cache</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire de cache sont bons.',
		),
		'categories' => array(
			'nok' => 'La table category est mal configurée.',
			'ok' => 'La table category est bien configurée.',
		),
		'connection' => array(
			'nok' => 'La connexion à la base de données est impossible.',
			'ok' => 'La connexion à la base de données est bonne.',
		),
		'ctype' => array(
			'nok' => 'Il manque une librairie pour la vérification des types de caractères (php-ctype).',
			'ok' => 'Vous disposez du nécessaire pour la vérification des types de caractères (ctype).',
		),
		'curl' => array(
			'nok' => 'Vous ne disposez pas de cURL (paquet php5-curl).',
			'ok' => 'Vous disposez de cURL.',
		),
		'data' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire de data sont bons.',
		),
		'database' => 'Installation de la base de données',
		'dom' => array(
			'nok' => 'Il manque une librairie pour parcourir le DOM (paquet php-xml).',
			'ok' => 'Vous disposez du nécessaire pour parcourir le DOM.',
		),
		'entries' => array(
			'nok' => 'La table entry est mal configurée.',
			'ok' => 'La table entry est bien configurée.',
		),
		'favicons' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data/favicons</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire des favicons sont bons.',
		),
		'feeds' => array(
			'nok' => 'La table feed est mal configurée.',
			'ok' => 'La table feed est bien configurée.',
		),
		'files' => 'Installation des fichiers',
		'json' => array(
			'nok' => 'Vous ne disposez pas de JSON (paquet php5-json).',
			'ok' => 'Vous disposez de l\'extension JSON.',
		),
		'logs' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data/logs</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire des logs sont bons.',
		),
		'minz' => array(
			'nok' => 'Vous ne disposez pas de la librairie Minz.',
			'ok' => 'Vous disposez du framework Minz',
		),
		'pcre' => array(
			'nok' => 'Il manque une librairie pour les expressions régulières (php-pcre).',
			'ok' => 'Vous disposez du nécessaire pour les expressions régulières (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Vous ne disposez pas de PDO ou d’un des drivers supportés (pdo_mysql, pdo_sqlite).',
			'ok' => 'Vous disposez de PDO et d’au moins un des drivers supportés (pdo_mysql, pdo_sqlite).',
		),
		'persona' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data/persona</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire de Mozilla Persona sont bons.',
		),
		'php' => array(
			'_' => 'Installation de PHP',
			'nok' => 'Votre version de PHP est la %s mais FreshRSS requiert au moins la version %s.',
			'ok' => 'Votre version de PHP est la %s, qui est compatible avec FreshRSS.',
		),
		'tables' => array(
			'nok' => 'Il manque une ou plusieurs tables en base de données.',
			'ok' => 'Les tables sont bien présentes en base de données.',
		),
		'tokens' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data/tokens</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire des tokens sont bons.',
		),
		'zip' => array(
			'nok' => 'Vous ne disposez pas de l\'extension ZIP (paquet php5-zip).',
			'ok' => 'Vous disposez de l\'extension ZIP.',
		),
	),
	'extensions' => array(
		'empty_list' => 'Il n’y a aucune extension installée.',
		'system' => 'Extension système (vous n’avez aucun droit dessus)',
		'title' => 'Extensions',
	),
	'users' => array(
		'articles_and_size' => '%s articles (%s)',
	),
);

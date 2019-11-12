<?php

return array(
	'action' => array(
		'finish' => 'Terminer l’installation',
		'fix_errors_before' => 'Veuillez corriger les erreurs avant de passer à l’étape suivante.',
		'keep_install' => 'Garder l’ancienne configuration',
		'next_step' => 'Passer à l’étape suivante',
		'reinstall' => 'Réinstaller FreshRSS',
	),
	'auth' => array(
		'form' => 'Formulaire (traditionnel, requiert JavaScript)',
		'http' => 'HTTP (pour utilisateurs avancés avec HTTPS)',
		'none' => 'Aucune (dangereux)',
		'password_form' => 'Mot de passe<br /><small>(pour connexion par formulaire)</small>',
		'password_format' => '7 caractères minimum',
		'type' => 'Méthode d’authentification',
	),
	'bdd' => array(
		'_' => 'Base de données',
		'conf' => array(
			'_' => 'Configuration de la base de données',
			'ko' => 'Vérifiez les informations d’accès à la base de données.',
			'ok' => 'La configuration de la base de données a été enregistrée.',
		),
		'host' => 'Hôte',
		'password' => 'Mot de passe pour base de données',
		'prefix' => 'Préfixe des tables',
		'type' => 'Type de base de données',
		'username' => 'Nom d’utilisateur pour base de données',
	),
	'check' => array(
		'_' => 'Vérifications',
		'already_installed' => 'FreshRSS semble avoir déjà été installé !',
		'cache' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data/cache</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire de cache sont bons.',
		),
		'ctype' => array(
			'nok' => 'Impossible de trouver une librairie pour la vérification des types de caractères (php-ctype).',
			'ok' => 'Vous disposez de la librairie pour la vérification des types de caractères (ctype).',
		),
		'curl' => array(
			'nok' => 'Vous ne disposez pas de cURL (paquet php-curl).',
			'ok' => 'Vous disposez de cURL.',
		),
		'data' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire de data sont bons.',
		),
		'dom' => array(
			'nok' => 'Impossible de trouver une librairie pour parcourir le DOM.',
			'ok' => 'Vous disposez de la librairie pour parcourir le DOM.',
		),
		'favicons' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data/favicons</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire des favicons sont bons.',
		),
		'fileinfo' => array(
			'nok' => 'Vous ne disposez pas de PHP fileinfo (paquet fileinfo).',
			'ok' => 'Vous disposez de fileinfo.',
		),
		'http_referer' => array(
			'nok' => 'Veuillez vérifier que vous ne modifiez pas votre HTTP REFERER.',
			'ok' => 'Le HTTP REFERER est connu et semble correspondre à votre serveur.',
		),
		'json' => array(
			'nok' => 'Vous ne disposez pas de l’extension recommendée JSON (paquet php-json).',
			'ok' => 'Vous disposez de l’extension recommendée JSON.',
		),
		'mbstring' => array(
			'nok' => 'Impossible de trouver la librairie recommandée mbstring pour Unicode.',
			'ok' => 'Vouz disposez de la librairie recommandée mbstring pour Unicode.',
		),
		'minz' => array(
			'nok' => 'Vous ne disposez pas de la librairie Minz.',
			'ok' => 'Vous disposez du framework Minz',
		),
		'pcre' => array(
			'nok' => 'Impossible de trouver une librairie pour les expressions régulières (php-pcre).',
			'ok' => 'Vous disposez de la librairie pour les expressions régulières (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Vous ne disposez pas de PDO ou d’un des drivers supportés (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Vous disposez de PDO et d’au moins un des drivers supportés (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'Votre version de PHP est la %s mais FreshRSS requiert au moins la version %s.',
			'ok' => 'Votre version de PHP est la %s, qui est compatible avec FreshRSS.',
		),
		'users' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data/users</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire des utilisateurs sont bons.',
		),
		'xml' => array(
			'nok' => 'Impossible de trouver une librairie requise pour XML.',
			'ok' => 'Vouz disposez de la librairie requise pour XML.',
		),
	),
	'conf' => array(
		'_' => 'Configuration générale',
		'ok' => 'La configuration générale a été enregistrée.',
	),
	'congratulations' => 'Félicitations !',
	'default_user' => 'Nom de l’utilisateur par défaut <small>(16 caractères alphanumériques maximum)</small>',
	'delete_articles_after' => 'Supprimer les articles après',
	'fix_errors_before' => 'Veuillez corriger les erreurs avant de passer à l’étape suivante.',
	'javascript_is_better' => 'FreshRSS est plus agréable à utiliser avec JavaScript activé',
	'js' => array(
		'confirm_reinstall' => 'Réinstaller FreshRSS vous fera perdre la configuration précédente. Êtes-vous sûr de vouloir continuer ?',
	),
	'language' => array(
		'_' => 'Langue',
		'choose' => 'Choisissez la langue pour FreshRSS',
		'defined' => 'La langue a bien été définie.',
	),
	'not_deleted' => 'Quelque chose s’est mal passé, vous devez supprimer le fichier <em>%s</em> à la main.',
	'ok' => 'L’installation s’est bien passée.',
	'step' => 'étape %d',
	'steps' => 'Étapes',
	'title' => 'Installation · FreshRSS',
	'this_is_the_end' => 'This is the end',
);

<?php

/******************************************************************************/
/* Each entry of that file can be associated with a comment to indicate its   */
/* state. When there is no comment, it means the entry is fully translated.   */
/* The recognized comments are (comment matching is case-insensitive):        */
/*   + TODO: the entry has never been translated.                             */
/*   + DIRTY: the entry has been translated but needs to be updated.          */
/*   + IGNORE: the entry does not need to be translated.                      */
/* When a comment is not recognized, it is discarded.                         */
/******************************************************************************/

return [
	'action' => [
		'finish' => 'Terminer l’installation',
		'fix_errors_before' => 'Veuillez corriger les erreurs avant de passer à l’étape suivante.',
		'keep_install' => 'Garder l’ancienne configuration',
		'next_step' => 'Passer à l’étape suivante',
		'reinstall' => 'Réinstaller FreshRSS',
	],
	'auth' => [
		'form' => 'Formulaire (traditionnel, requiert JavaScript)',
		'http' => 'HTTP (pour utilisateurs avancés avec HTTPS)',
		'none' => 'Aucune (dangereux)',
		'password_form' => 'Mot de passe<br /><small>(pour connexion par formulaire)</small>',
		'password_format' => '7 caractères minimum',
		'type' => 'Méthode d’authentification',
	],
	'bdd' => [
		'_' => 'Base de données',
		'conf' => [
			'_' => 'Configuration de la base de données',
			'ko' => 'Vérifiez les informations d’accès à la base de données.',
			'ok' => 'La configuration de la base de données a été enregistrée.',
		],
		'host' => 'Hôte',
		'password' => 'Mot de passe pour base de données',
		'prefix' => 'Préfixe des tables',
		'type' => 'Type de base de données',
		'username' => 'Nom d’utilisateur pour base de données',
	],
	'check' => [
		'_' => 'Vérifications',
		'already_installed' => 'FreshRSS semble avoir déjà été installé !',
		'cache' => [
			'nok' => 'Veuillez vérifier les droits de l’utilisateur <em>%2$s</em> sur le répertoire <em>%1$s</em>. Le serveur HTTP doit être capable d’écrire dedans.',
			'ok' => 'Les droits sur le répertoire de cache sont bons.',
		],
		'ctype' => [
			'nok' => 'Impossible de trouver une librairie pour la vérification des types de caractères (php-ctype).',
			'ok' => 'Vous disposez de la librairie pour la vérification des types de caractères (ctype).',
		],
		'curl' => [
			'nok' => 'Vous ne disposez pas de cURL (paquet php-curl).',
			'ok' => 'Vous disposez de cURL.',
		],
		'data' => [
			'nok' => 'Veuillez vérifier les droits de l’utilisateur <em>%2$s</em> sur le répertoire <em>%1$s</em>. Le serveur HTTP doit être capable d’écrire dedans.',
			'ok' => 'Les droits sur le répertoire de data sont bons.',
		],
		'dom' => [
			'nok' => 'Impossible de trouver une librairie pour parcourir le DOM.',
			'ok' => 'Vous disposez de la librairie pour parcourir le DOM.',
		],
		'favicons' => [
			'nok' => 'Veuillez vérifier les droits de l’utilisateur <em>%2$s</em> sur le répertoire <em>%1$s</em>. Le serveur HTTP doit être capable d’écrire dedans.',
			'ok' => 'Les droits sur le répertoire des favicons sont bons.',
		],
		'fileinfo' => [
			'nok' => 'Vous ne disposez pas de PHP fileinfo (paquet fileinfo).',
			'ok' => 'Vous disposez de fileinfo.',
		],
		'json' => [
			'nok' => 'Vous ne disposez pas de l’extension recommandée JSON (paquet php-json).',
			'ok' => 'Vous disposez de l’extension recommandée JSON.',
		],
		'mbstring' => [
			'nok' => 'Impossible de trouver la librairie recommandée mbstring pour Unicode.',
			'ok' => 'Vouz disposez de la librairie recommandée mbstring pour Unicode.',
		],
		'pcre' => [
			'nok' => 'Impossible de trouver une librairie pour les expressions régulières (php-pcre).',
			'ok' => 'Vous disposez de la librairie pour les expressions régulières (PCRE).',
		],
		'pdo' => [
			'nok' => 'Vous ne disposez pas de PDO ou d’un des drivers supportés (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Vous disposez de PDO et d’au moins un des drivers supportés (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		],
		'php' => [
			'nok' => 'Votre version de PHP est la %s mais FreshRSS requiert au moins la version %s.',
			'ok' => 'Votre version de PHP est la %s, qui est compatible avec FreshRSS.',
		],
		'reload' => 'Revérifier',
		'tmp' => [
			'nok' => 'Veuillez vérifier les droits de l’utilisateur <em>%2$s</em> sur le répertoire <em>%1$s</em>. Le serveur HTTP doit être capable d’écrire dedans.',
			'ok' => 'Les droits sur le répertoire temporaire sont bons.',
		],
		'unknown_process_username' => 'inconnu',
		'users' => [
			'nok' => 'Veuillez vérifier les droits de l’utilisateur <em>%2$s</em> sur le répertoire <em>%1$s</em>. Le serveur HTTP doit être capable d’écrire dedans.',
			'ok' => 'Les droits sur le répertoire des utilisateurs sont bons.',
		],
		'xml' => [
			'nok' => 'Impossible de trouver une librairie requise pour XML.',
			'ok' => 'Vouz disposez de la librairie requise pour XML.',
		],
	],
	'conf' => [
		'_' => 'Configuration générale',
		'ok' => 'La configuration générale a été enregistrée.',
	],
	'congratulations' => 'Félicitations !',
	'default_user' => [
		'_' => 'Nom de l’utilisateur par défaut',
		'max_char' => '16 caractères alphanumériques maximum',
	],
	'fix_errors_before' => 'Veuillez corriger les erreurs avant de passer à l’étape suivante.',
	'javascript_is_better' => 'FreshRSS est plus agréable à utiliser avec JavaScript activé',
	'js' => [
		'confirm_reinstall' => 'Réinstaller FreshRSS vous fera perdre la configuration précédente. Êtes-vous sûr de vouloir continuer ?',
	],
	'language' => [
		'_' => 'Langue',
		'choose' => 'Choisissez la langue pour FreshRSS',
		'defined' => 'La langue a bien été définie.',
	],
	'missing_applied_migrations' => 'Quelque chose s’est mal passé, vous devriez créer le fichier <em>%s</em> à la main.',
	'ok' => 'L’installation s’est bien passée.',
	'session' => [
		'nok' => 'Le serveur Web semble mal configuré pour les cookies nécessaires aux sessions PHP!',
	],
	'step' => 'étape %d',
	'steps' => 'Étapes',
	'this_is_the_end' => 'This is the end',	// IGNORE
	'title' => 'Installation · FreshRSS',	// IGNORE
];

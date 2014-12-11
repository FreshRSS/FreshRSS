<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Autoriser la lecture anonyme des articles de l’utilisateur par défaut (%s)',
		'allow_anonymous_refresh' => 'Autoriser le rafraîchissement anonyme des flux',
		'api_enabled' => 'Autoriser l’accès par <abbr>API</abbr> <small>(nécessaire pour les applis mobiles)</small>',
		'form' => 'Formulaire (traditionnel, requiert JavaScript)',
		'http' => 'HTTP (pour utilisateurs avancés avec HTTPS)',
		'none' => 'Aucune (dangereux)',
		'persona' => 'Mozilla Persona (moderne, requiert JavaScript)',
		'title' => 'Authentification',
		'title_reset' => 'Réinitialisation de l’authentification',
		'token' => 'Jeton d’identification',
		'token_help' => 'Permet d’accéder à la sortie RSS de l’utilisateur par défaut sans besoin de s’authentifier.<br /><kbd>%s?output=rss&token=%s</kbd>',
		'type' => 'Méthode d’authentification',
		'unsafe_autologin' => 'Autoriser les connexions automatiques non-sûres au format : ',
	),
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
		'title' => 'Vérification de l’installation',
		'tokens' => array(
			'nok' => 'Veuillez vérifier les droits sur le répertoire <em>./data/tokens</em>. Le serveur HTTP doit être capable d’écrire dedans',
			'ok' => 'Les droits sur le répertoire des tokens sont bons.',
		),
		'zip' => array(
			'nok' => 'Vous ne disposez pas de l\'extension ZIP (paquet php5-zip).',
			'ok' => 'Vous disposez de l\'extension ZIP.',
		),
	),
	'stats' => array(
		'_' => 'Statistiques',
		'all_feeds' => 'Tous les flux',
		'category' => 'Catégorie',
		'entry_count' => 'Nombre d’articles',
		'entry_per_category' => 'Articles par catégorie',
		'entry_per_day' => 'Nombre d’articles par jour (30 derniers jours)',
		'entry_per_day_of_week' => 'Par jour de la semaine (moyenne : %.2f messages)',
		'entry_per_hour' => 'Par heure (moyenne : %.2f messages)',
		'entry_per_month' => 'Par mois (moyenne : %.2f messages)',
		'entry_repartition' => 'Répartition des articles',
		'feed' => 'Flux',
		'feed_per_category' => 'Flux par catégorie',
		'idle' => 'Flux inactifs',
		'main' => 'Statistiques principales',
		'main_stream' => 'Flux principal',
		'menu' => array(
			'idle' => 'Flux inactifs',
			'main' => 'Statistiques principales',
			'repartition' => 'Répartition des articles',
		),
		'no_idle' => 'Il n’y a aucun flux inactif !',
		'number_entries' => '%d articles',
		'percent_of_total' => '%% du total',
		'repartition' => 'Répartition des articles',
		'status_favorites' => 'favoris',
		'status_read' => 'lus',
		'status_total' => 'total',
		'status_unread' => 'non lus',
		'title' => 'Statistiques',
		'top_feed' => 'Les dix plus gros flux',
	),
	'update' => array(
		'title' => 'Système de mise à jour',
	),
	'user' => array(
		'articles_and_size' => '%s articles (%s)',
		'title' => 'Gestion des utilisateurs',
	),
);

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

return array(
	'action' => array(
		'actualize' => 'Actualiser flux',
		'add' => 'Ajouter',
		'back' => '← Retour',
		'back_to_rss_feeds' => '← Retour à vos flux RSS',
		'cancel' => 'Annuler',
		'create' => 'Créer',
		'demote' => 'Rétrograder',
		'disable' => 'Désactiver',
		'empty' => 'Vider',
		'enable' => 'Activer',
		'export' => 'Exporter',
		'filter' => 'Filtrer',
		'import' => 'Importer',
		'load_default_shortcuts' => 'Utiliser les raccourcis par défaut',
		'manage' => 'Gérer',
		'mark_read' => 'Marquer comme lu',
		'promote' => 'Promouvoir',
		'purge' => 'Purger',
		'remove' => 'Supprimer',
		'rename' => 'Renommer',
		'see_website' => 'Voir le site',
		'submit' => 'Valider',
		'truncate' => 'Supprimer tous les articles',
		'update' => 'Mettre à jour',
	),
	'auth' => array(
		'accept_tos' => 'Accepter les <a href="%s">Conditions Générales d’Utilisation</a>.',
		'email' => 'Adresse courriel',
		'keep_logged_in' => 'Rester connecté <small>(%s jours)</small>',
		'login' => 'Connexion',
		'logout' => 'Déconnexion',
		'password' => array(
			'_' => 'Mot de passe',
			'format' => '<small>7 caractères minimum</small>',
		),
		'registration' => array(
			'_' => 'Nouveau compte',
			'ask' => 'Créer un compte ?',
			'title' => 'Création de compte',
		),
		'username' => array(
			'_' => 'Nom d’utilisateur',
			'format' => '<small>16 caractères alphanumériques maximum</small>',
		),
	),
	'date' => array(
		'Apr' => '\\a\\v\\r\\i\\l',
		'Aug' => '\\a\\o\\û\\t',
		'Dec' => '\\d\\é\\c\\e\\m\\b\\r\\e',
		'Feb' => '\\f\\é\\v\\r\\i\\e\\r',
		'Jan' => '\\j\\a\\n\\v\\i\\e\\r',
		'Jul' => '\\j\\u\\i\\l\\l\\e\\t',
		'Jun' => '\\j\\u\\i\\n',
		'Mar' => '\\m\\a\\r\\s',
		'May' => '\\m\\a\\i',
		'Nov' => '\\n\\o\\v\\e\\m\\b\\r\\e',
		'Oct' => '\\o\\c\\t\\o\\b\\r\\e',
		'Sep' => '\\s\\e\\p\\t\\e\\m\\b\\r\\e',
		'apr' => 'avr.',
		'april' => 'avril',
		'aug' => 'août',
		'august' => 'août',
		'before_yesterday' => 'À partir d’avant-hier',
		'dec' => 'déc.',
		'december' => 'décembre',
		'feb' => 'fév.',
		'february' => 'février',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\à H\\:i',	// IGNORE
		'fri' => 'ven.',
		'jan' => 'jan.',
		'january' => 'janvier',
		'jul' => 'jui.',
		'july' => 'juillet',
		'jun' => 'juin',
		'june' => 'juin',
		'last_2_year' => 'Depuis deux ans',
		'last_3_month' => 'Depuis les trois derniers mois',
		'last_3_year' => 'Depuis trois ans',
		'last_5_year' => 'Depuis cinq ans',
		'last_6_month' => 'Depuis les six derniers mois',
		'last_month' => 'Depuis le mois dernier',
		'last_week' => 'Depuis la semaine dernière',
		'last_year' => 'Depuis l’année dernière',
		'mar' => 'mars',
		'march' => 'mars',
		'may' => 'mai',
		'may_' => 'mai',
		'mon' => 'lun.',
		'month' => 'mois',
		'nov' => 'nov.',
		'november' => 'novembre',
		'oct' => 'oct.',
		'october' => 'octobre',
		'sat' => 'sam.',
		'sep' => 'sep.',
		'september' => 'septembre',
		'sun' => 'dim.',
		'thu' => 'jeu.',
		'today' => 'Aujourd’hui',
		'tue' => 'mar.',
		'wed' => 'mer.',
		'yesterday' => 'Hier',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'À propos de FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Catégorie vide',
		'confirm_action' => 'Êtes-vous sûr(e) de vouloir continuer ? Cette action ne peut être annulée !',
		'confirm_action_feed_cat' => 'Êtes-vous sûr(e) de vouloir continuer ? Vous perdrez les favoris et les filtres associés. Cette action ne peut être annulée !',
		'feedback' => array(
			'body_new_articles' => 'Il y a %%d nouveaux articles à lire sur FreshRSS.',
			'request_failed' => 'Une requête a échoué, cela peut être dû à des problèmes de connexion à Internet.',
			'title_new_articles' => 'FreshRSS : nouveaux articles !',
		),
		'new_article' => 'Il y a de nouveaux articles disponibles, cliquez pour rafraîchir la page.',
		'should_be_activated' => 'Le JavaScript doit être activé.',
	),
	'lang' => array(
		'cz' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'À propos',
		'account' => 'Compte',
		'admin' => 'Administration',	// IGNORE
		'archiving' => 'Archivage',
		'authentication' => 'Authentification',
		'check_install' => 'Vérification de l’installation',
		'configuration' => 'Configuration',	// IGNORE
		'display' => 'Affichage',
		'extensions' => 'Extensions',	// IGNORE
		'logs' => 'Logs',	// IGNORE
		'queries' => 'Filtres utilisateurs',
		'reading' => 'Lecture',
		'search' => 'Rechercher des mots ou des #tags',
		'sharing' => 'Partage',
		'shortcuts' => 'Raccourcis',
		'stats' => 'Statistiques',
		'system' => 'Configuration du système',
		'update' => 'Mise à jour',
		'user_management' => 'Gestion des utilisateurs',
		'user_profile' => 'Profil',
	),
	'pagination' => array(
		'first' => 'Début',
		'last' => 'Fin',
		'load_more' => 'Charger plus d’articles',
		'mark_all_read' => 'Tout marquer comme lu',
		'next' => 'Suivant',
		'nothing_to_load' => 'Fin des articles',
		'previous' => 'Précédent',
	),
	'period' => array(
		'days' => 'jours',
		'hours' => 'heures',
		'months' => 'mois',
		'weeks' => 'semaines',
		'years' => 'années',
	),
	'share' => array(
		'Known' => 'Sites basés sur Known',
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Presse-papier',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Courriel',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Imprimer',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
	),
	'short' => array(
		'attention' => 'Attention !',
		'blank_to_disable' => 'Laissez vide pour désactiver',
		'by_author' => 'Par :',
		'by_default' => 'Par défaut',
		'damn' => 'Arf !',
		'default_category' => 'Sans catégorie',
		'no' => 'Non',
		'not_applicable' => 'Non disponible',
		'ok' => 'Ok !',
		'or' => 'ou',
		'yes' => 'Oui',
	),
);

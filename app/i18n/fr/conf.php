<?php

return array(
	'archiving' => array(
		'_' => 'Archivage',
		'delete_after' => 'Supprimer les articles après',
		'exception' => 'Exception de nettoyage',
		'help' => 'D’autres options sont disponibles dans la configuration individuelle des flux.',
		'keep_favourites' => 'Ne jamais supprimer les articles favoris',
		'keep_labels' => 'Ne jamais supprimer les articles étiquetés',
		'keep_max' => 'Nombre maximum d’articles à conserver',
		'keep_min_by_feed' => 'Nombre minimum d’articles à conserver par flux',
		'keep_period' => 'Âge maximum des articles à conserver',
		'keep_unreads' => 'Ne jamais supprimer les articles non lus',
		'maintenance' => 'Maintenance',
		'optimize' => 'Optimiser la base de données',
		'optimize_help' => 'À faire de temps en temps pour réduire la taille de la BDD',
		'policy' => 'Politique de nettoyage',
		'policy_warning' => 'Si aucune politique de nettoyage n’est sélectionnée, tous les articles seront conservés.',
		'purge_now' => 'Purger maintenant',
		'title' => 'Archivage',
		'ttl' => 'Ne pas automatiquement rafraîchir plus souvent que',
	),
	'display' => array(
		'_' => 'Affichage',
		'icon' => array(
			'bottom_line' => 'Ligne du bas',
			'display_authors' => 'Auteurs',
			'entry' => 'Icônes d’article',
			'publication_date' => 'Date de publication',
			'related_tags' => 'Tags de l’article',
			'sharing' => 'Partage',
			'top_line' => 'Ligne du haut',
		),
		'language' => 'Langue',
		'notif_html5' => array(
			'seconds' => 'secondes (0 signifie aucun timeout)',
			'timeout' => 'Temps d’affichage de la notification HTML5',
		),
		'show_nav_buttons' => 'Afficher les boutons de navigation',
		'theme' => 'Thème',
		'title' => 'Affichage',
		'width' => array(
			'content' => 'Largeur du contenu',
			'large' => 'Large',
			'medium' => 'Moyenne',
			'no_limit' => 'Pas de limite',
			'thin' => 'Fine',
		),
	),
	'profile' => array(
		'_' => 'Gestion du profil',
		'api' => 'Gestion de l’API',
		'delete' => array(
			'_' => 'Suppression du compte',
			'warn' => 'Le compte et toutes les données associées vont être supprimées.',
		),
		'email' => 'Adresse email',
		'password_api' => 'Mot de passe API<br /><small>(ex. : pour applis mobiles)</small>',
		'password_form' => 'Mot de passe<br /><small>(pour connexion par formulaire)</small>',
		'password_format' => '7 caractères minimum',
		'title' => 'Profil',
	),
	'query' => array(
		'_' => 'Filtres utilisateurs',
		'deprecated' => 'Ce filtre n’est plus valide. La catégorie ou le flux concerné a été supprimé.',
		'display' => 'Afficher les résultats du filtre',
		'filter' => array(
			'_' => 'Filtres appliqués :',
			'categories' => 'Afficher par catégorie',
			'feeds' => 'Afficher par flux',
			'order' => 'Tri par date',
			'search' => 'Expression',
			'state' => 'État',
			'tags' => 'Afficher par étiquette',
			'type' => 'Type',
		),
		'get_all' => 'Afficher tous les articles',
		'get_category' => 'Afficher la catégorie "%s"',
		'get_favorite' => 'Afficher les articles favoris',
		'get_feed' => 'Afficher le flux "%s"',
		'get_tag' => 'Afficher l’étiquette "%s"',
		'name' => 'Nom',
		'no_filter' => 'Aucun filtre appliqué',
		'none' => 'Vous n’avez pas encore créé de filtre.',
		'number' => 'Filtre n°%d',
		'order_asc' => 'Afficher les articles les plus anciens en premier',
		'order_desc' => 'Afficher les articles les plus récents en premier',
		'remove' => 'Supprimer le filtre',
		'search' => 'Recherche de "%s"',
		'state_0' => 'Afficher tous les articles',
		'state_1' => 'Afficher les articles lus',
		'state_2' => 'Afficher les articles non lus',
		'state_3' => 'Afficher tous les articles',
		'state_4' => 'Afficher les articles favoris',
		'state_5' => 'Afficher les articles lus et favoris',
		'state_6' => 'Afficher les articles non lus et favoris',
		'state_7' => 'Afficher les articles favoris',
		'state_8' => 'Afficher les articles non favoris',
		'state_9' => 'Afficher les articles lus et non favoris',
		'state_10' => 'Afficher les articles non lus et non favoris',
		'state_11' => 'Afficher les articles non favoris',
		'state_12' => 'Afficher tous les articles',
		'state_13' => 'Afficher les articles lus',
		'state_14' => 'Afficher les articles non lus',
		'state_15' => 'Afficher tous les articles',
		'title' => 'Filtres utilisateurs',
	),
	'reading' => array(
		'_' => 'Lecture',
		'after_onread' => 'Après “marquer tout comme lu”,',
		'always_show_favorites' => 'Afficher par défaut tous les articles dans les favoris',
		'articles_per_page' => 'Nombre d’articles par page',
		'auto_load_more' => 'Charger les articles suivants en bas de page',
		'auto_remove_article' => 'Cacher les articles après lecture',
		'confirm_enabled' => 'Afficher une confirmation lors des actions “marquer tout comme lu”',
		'display_articles_unfolded' => 'Afficher les articles dépliés par défaut',
		'display_categories_unfolded' => 'Catégories à déplier',
		'hide_read_feeds' => 'Cacher les catégories & flux sans article non-lu (ne fonctionne pas avec la configuration “Afficher tous les articles”)',
		'img_with_lazyload' => 'Utiliser le mode “chargement différé” pour les images',
		'jump_next' => 'sauter au prochain voisin non lu (flux ou catégorie)',
		'mark_updated_article_unread' => 'Marquer les articles mis à jour comme non-lus',
		'number_divided_when_reader' => 'Divisé par 2 dans la vue de lecture.',
		'read' => array(
			'article_open_on_website' => 'lorsque l’article est ouvert sur le site d’origine',
			'article_viewed' => 'lorsque l’article est affiché',
			'scroll' => 'au défilement de la page',
			'upon_reception' => 'dès la réception du nouvel article',
			'when' => 'Marquer un article comme lu…',
		),
		'show' => array(
			'_' => 'Articles à afficher',
			'active_category' => 'La catégorie active',
			'adaptive' => 'Adapter l’affichage',
			'all_articles' => 'Afficher tous les articles',
			'all_categories' => 'Toutes les catégories',
			'no_category' => 'Aucune catégorie',
			'remember_categories' => 'Se souvenir des catégories dépliées',
			'unread' => 'Afficher les non lus',
		),
		'show_fav_unread_help' => 'S’applique aussi aux étiquettes',
		'sides_close_article' => 'Cliquer hors de la zone de texte ferme l’article',
		'sort' => array(
			'_' => 'Ordre de tri',
			'newer_first' => 'Plus récents en premier',
			'older_first' => 'Plus anciens en premier',
		),
		'sticky_post' => 'Aligner l’article en haut quand il est ouvert',
		'title' => 'Lecture',
		'view' => array(
			'default' => 'Vue par défaut',
			'global' => 'Vue globale',
			'normal' => 'Vue normale',
			'reader' => 'Vue lecture',
		),
	),
	'sharing' => array(
		'_' => 'Partage',
		'add' => 'Ajouter une méthode de partage',
		'blogotext' => 'Blogotext',
		'diaspora' => 'Diaspora*',
		'email' => 'Courriel',
		'facebook' => 'Facebook',
		'more_information' => 'Plus d’informations',
		'print' => 'Print',
		'raindrop' => 'Raindrop.io', // TODO - Translation
		'remove' => 'Supprimer la méthode de partage',
		'shaarli' => 'Shaarli',
		'share_name' => 'Nom du partage à afficher',
		'share_url' => 'URL du partage à utiliser',
		'title' => 'Partage',
		'twitter' => 'Twitter',
		'wallabag' => 'wallabag',
	),
	'shortcut' => array(
		'_' => 'Raccourcis',
		'article_action' => 'Actions associées à l’article courant',
		'auto_share' => 'Partager',
		'auto_share_help' => 'S’il n’y a qu’un mode de partage, celui-ci est utilisé automatiquement. Sinon ils sont accessibles par leur numéro.',
		'close_dropdown' => 'Fermer les menus',
		'collapse_article' => 'Refermer',
		'first_article' => 'Passer au premier article',
		'focus_search' => 'Accéder à la recherche',
		'global_view' => 'Basculer vers la vue globale',
		'help' => 'Afficher la documentation',
		'javascript' => 'Le JavaScript doit être activé pour pouvoir profiter des raccourcis.',
		'last_article' => 'Passer au dernier article',
		'load_more' => 'Charger plus d’articles',
		'mark_favorite' => 'Basculer l’indicateur de favori',
		'mark_read' => 'Basculer l’indicateur de lecture',
		'navigation' => 'Navigation',
		'navigation_help' => 'Avec le modificateur <kbd>⇧ Maj</kbd>, les raccourcis de navigation s’appliquent aux flux.<br/>Avec le modificateur <kbd>Alt ⎇</kbd>, les raccourcis de navigation s’appliquent aux catégories.',
		'navigation_no_mod_help' => 'Les raccourcis suivant ne supportent pas les modificateurs.',
		'next_article' => 'Passer à l’article suivant',
		'non_standard' => 'Certains raccourcis (<kbd>%s</kbd>) peuvent ne pas fonctionner.',
		'normal_view' => 'Basculer vers la vue normale',
		'other_action' => 'Autres actions',
		'previous_article' => 'Passer à l’article précédent',
		'reading_view' => 'Basculer vers la vue lecture',
		'rss_view' => 'Ouvrir le flux RSS dans un nouvel onglet',
		'see_on_website' => 'Voir sur le site d’origine',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> pour marquer les articles précédents comme lus<br />+ <kbd>⇧ Maj</kbd> pour marquer tous les articles comme lus',
		'skip_next_article' => 'Passer au suivant sans ouvrir',
		'skip_previous_article' => 'Passer au précédent sans ouvrir',
		'title' => 'Raccourcis',
		'toggle_media' => 'Lire/arrêter le média',
		'user_filter' => 'Accéder aux filtres utilisateur',
		'user_filter_help' => 'S’il n’y a qu’un filtre utilisateur, celui-ci est utilisé automatiquement. Sinon ils sont accessibles par leur numéro.',
		'views' => 'Vues',
	),
	'user' => array(
		'articles_and_size' => '%s articles (%s)',
		'current' => 'Utilisateur actuel',
		'is_admin' => 'est administrateur',
		'users' => 'Utilisateurs',
	),
);

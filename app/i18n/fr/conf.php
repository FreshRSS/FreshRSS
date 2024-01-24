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
	'archiving' => array(
		'_' => 'Archivage',
		'exception' => 'Exception de nettoyage',
		'help' => 'D’autres options sont disponibles dans la configuration individuelle des flux.',
		'keep_favourites' => 'Ne jamais supprimer les articles favoris',
		'keep_labels' => 'Ne jamais supprimer les articles étiquetés',
		'keep_max' => 'Nombre maximum d’articles à conserver par flux',
		'keep_min_by_feed' => 'Nombre minimum d’articles à conserver par flux',
		'keep_period' => 'Âge maximum des articles à conserver',
		'keep_unreads' => 'Ne jamais supprimer les articles non lus',
		'maintenance' => 'Maintenance',	// IGNORE
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
		'darkMode' => array(
			'_' => 'Mode sombre automatique (bêta)',
			'auto' => 'Auto',	// IGNORE
			'no' => 'Non',
		),
		'icon' => array(
			'bottom_line' => 'Ligne du bas',
			'display_authors' => 'Auteurs',
			'entry' => 'Icônes d’article',
			'publication_date' => 'Date de publication',
			'related_tags' => 'Tags de l’article',
			'sharing' => 'Partage',
			'summary' => 'Résumé',
			'top_line' => 'Ligne du haut',
		),
		'language' => 'Langue',
		'notif_html5' => array(
			'seconds' => 'secondes (0 signifie aucun timeout)',
			'timeout' => 'Temps d’affichage de la notification HTML5',
		),
		'show_nav_buttons' => 'Afficher les boutons de navigation',
		'theme' => array(
			'_' => 'Thème',
			'deprecated' => array(
				'_' => 'Obsolète',
				'description' => 'Ce thème est obsolète et sera supprimé dans une <a href="https://freshrss.github.io/FreshRSS/fr/users/05_Configuration.html#th%C3%A8me" target="_blank">future version de FreshRSS</a>',
			),
		),
		'theme_not_available' => 'Le thème <em>%s</em> n’est plus disponible. Veuillez choisir un autre thème.',
		'thumbnail' => array(
			'label' => 'Miniature',
			'landscape' => 'Paysage',
			'none' => 'Sans',
			'portrait' => 'Portrait',	// IGNORE
			'square' => 'Carrée',
		),
		'timezone' => 'Fuseau horaire',
		'title' => 'Affichage',
		'website' => array(
			'full' => 'Icône et nom',
			'icon' => 'Icône seulement',
			'label' => 'Site Web',
			'name' => 'Nom seulement',
			'none' => 'Aucun',
		),
		'width' => array(
			'content' => 'Largeur du contenu',
			'large' => 'Large',	// IGNORE
			'medium' => 'Moyenne',
			'no_limit' => 'Pas de limite',
			'thin' => 'Fine',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Niveau de sévérité',
			'message' => 'Message de journal',
			'timestamp' => 'Horodatage',
		),
		'pagination' => array(
			'first' => 'Début',
			'last' => 'Fin',
			'next' => 'Suivant',
			'previous' => 'Précédent',
		),
	),
	'profile' => array(
		'_' => 'Gestion du profil',
		'api' => 'Gestion de l’API',
		'delete' => array(
			'_' => 'Suppression du compte',
			'warn' => 'Le compte et toutes les données associées vont être supprimées.',
		),
		'email' => 'adresse électronique',
		'password_api' => 'Mot de passe API<br /><small>(ex. : pour applis mobiles)</small>',
		'password_form' => 'Mot de passe<br /><small>(pour connexion par formulaire)</small>',
		'password_format' => '7 caractères minimum',
		'title' => 'Profil',
	),
	'query' => array(
		'_' => 'Filtres utilisateurs',
		'deprecated' => 'Ce filtre n’est plus valide. La catégorie ou le flux concerné a été supprimé.',
		'filter' => array(
			'_' => 'Filtres appliqués :',
			'categories' => 'Afficher par catégorie',
			'feeds' => 'Afficher par flux',
			'order' => 'Tri par date',
			'search' => 'Expression',	// IGNORE
			'state' => 'État',
			'tags' => 'Afficher par étiquette',
			'type' => 'Type',	// IGNORE
		),
		'get_all' => 'Afficher tous les articles',
		'get_category' => 'Afficher la catégorie <em>%s<em>',
		'get_favorite' => 'Afficher les articles favoris',
		'get_feed' => 'Afficher le flux <em>%s</em>',
		'name' => 'Nom',
		'no_filter' => 'Aucun filtre appliqué',
		'number' => 'Filtre n°%d',
		'order_asc' => 'Afficher les articles les plus anciens en premier',
		'order_desc' => 'Afficher les articles les plus récents en premier',
		'search' => 'Recherche de « %s »',
		'share' => array(
			'_' => 'Partager ce filtre par lien',
			'help' => 'Donner ce lien pour partager le contenu du filtre avec d’autres personnes',
			'html' => 'Lien partageable de la page HTML',
			'rss' => 'Lien partageable du flux RSS',
		),
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
		'after_onread' => 'Après « Marquer tout comme lu »,',
		'always_show_favorites' => 'Afficher par défaut tous les articles dans les favoris',
		'article' => array(
			'authors_date' => array(
				'_' => 'Auteurs et date',
				'both' => 'En en-tête et en pied d’article',
				'footer' => 'En pied d’article',
				'header' => 'En en-tête',
				'none' => 'Caché',
			),
			'feed_name' => array(
				'above_title' => 'Au-dessus du titre',
				'none' => 'Caché',
				'with_authors' => 'Sur la ligne « Auteurs et date »',
			),
			'feed_title' => 'Titre du flux',
			'tags' => array(
				'_' => 'Tags',	// IGNORE
				'both' => 'En en-tête et en pied d’article',
				'footer' => 'En pied d’article',
				'header' => 'En en-tête',
				'none' => 'Caché',
			),
			'tags_max' => array(
				'_' => 'Nombre maximum de tags affichés',
				'help' => '0 pour afficher tous les tags sans menu déroulant',
			),
		),
		'articles_per_page' => 'Nombre d’articles par page',
		'auto_load_more' => 'Charger les articles suivants en bas de page',
		'auto_remove_article' => 'Cacher les articles après lecture',
		'confirm_enabled' => 'Afficher une confirmation lors des actions « Marquer tout comme lu »',
		'display_articles_unfolded' => 'Afficher les articles dépliés par défaut',
		'display_categories_unfolded' => 'Catégories à déplier',
		'headline' => array(
			'articles' => 'Articles : ouverture/fermeture',
			'articles_header_footer' => 'Articles : en-tête / pied d’article',
			'categories' => 'Navigation de gauche : catégories',
			'mark_as_read' => 'Marquer les articles comme lus',
			'misc' => 'Divers',
			'view' => 'Vue',
		),
		'hide_read_feeds' => 'Cacher les catégories & flux sans article non-lu (ne fonctionne pas avec la configuration « Afficher tous les articles »)',
		'img_with_lazyload' => 'Utiliser le mode <em>chargement différé</em> pour les images',
		'jump_next' => 'sauter au prochain voisin non lu (flux ou catégorie)',
		'mark_updated_article_unread' => 'Marquer les articles mis à jour comme non-lus',
		'number_divided_when_reader' => 'Divisé par 2 dans la vue de lecture.',
		'read' => array(
			'article_open_on_website' => 'lorsque l’article est ouvert sur le site d’origine',
			'article_viewed' => 'lorsque l’article est affiché',
			'focus' => 'lorsque l’article est sélectionné (sauf pour les flux importants)',
			'keep_max_n_unread' => 'Nombre maximum d’articles conservés non lus',
			'scroll' => 'au défilement de la page (sauf pour les flux importants)',
			'upon_gone' => 'lorsqu’il n’est plus dans le flux d’actualités en amont',
			'upon_reception' => 'dès la réception du nouvel article',
			'when' => 'Marquer un article comme lu…',
			'when_same_title' => 'si un même titre existe déjà dans les <i>n</i> articles plus récents',
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
		'blogotext' => 'Blogotext',	// IGNORE
		'deprecated' => 'Ce service est obsolète et sera supprimé dans une <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Voir la documentation" target="_blank">prochaine version de FreshRSS</a>.',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Courriel',
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Plus d’informations',
		'print' => 'Imprimer',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Supprimer la méthode de partage',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Nom du partage à afficher',
		'share_url' => 'URL du partage à utiliser',
		'title' => 'Partage',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
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
		'navigation' => 'Navigation',	// IGNORE
		'navigation_help' => 'Avec le modificateur <kbd>⇧ Maj</kbd>, les raccourcis de navigation s’appliquent aux flux.<br/>Avec le modificateur <kbd>Alt ⎇</kbd>, les raccourcis de navigation s’appliquent aux catégories.',
		'navigation_no_mod_help' => 'Les raccourcis suivant ne supportent pas les modificateurs.',
		'next_article' => 'Passer à l’article suivant',
		'next_unread_article' => 'Passer à l’article non lu suivant',
		'non_standard' => 'Certains raccourcis (<kbd>%s</kbd>) peuvent ne pas fonctionner.',
		'normal_view' => 'Basculer vers la vue normale',
		'other_action' => 'Autres actions',
		'previous_article' => 'Passer à l’article précédent',
		'reading_view' => 'Basculer vers la vue lecture',
		'rss_view' => 'Ouvrir en tant que flux RSS ',
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
		'articles_and_size' => '%s articles (%s)',	// IGNORE
		'current' => 'Utilisateur actuel',
		'is_admin' => 'est administrateur',
		'users' => 'Utilisateurs',
	),
);

<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

return array(
	'about' => array(
		'_' => 'À propos',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Informations système',
				'browser' => 'Navigateur',
				'database' => 'Base de données',
				'server_software' => 'Serveur Web',
				'version_curl' => 'Version de cURL',
				'version_frss' => 'Version de FreshRSS',
				'version_php' => 'Version de PHP',
			),
		),
		'bugs_reports' => 'Rapports de bugs',
		'documentation' => 'Documentation',	// IGNORE
		'freshrss_description' => 'FreshRSS est un agrégateur de flux RSS à auto-héberger. Il se veut léger et facile à prendre en main tout en étant un outil puissant et paramétrable.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">sur GitHub</a>',
		'license' => 'Licence',
		'project_website' => 'Site du projet',
		'title' => 'À propos',
		'version' => 'Version',	// IGNORE
	),
	'feed' => array(
		'empty' => 'Il n’y a aucun article à afficher.',
		'published' => array(
			'_' => 'Publié',
			'future' => 'Publié dans le futur',
			'today' => 'Publié aujourd’hui',
			'yesterday' => 'Publié hier',
		),
		'received' => array(
			'_' => 'Reçu',
			'today' => 'Reçu aujourd’hui',
			'yesterday' => 'Reçu hier',
		),
		'rss_of' => 'Flux RSS de %s',
		'title' => 'Flux principal',
		'title_fav' => 'Favoris',
		'title_global' => 'Vue globale',
		'userModified' => array(
			'_' => 'Modifié par l’utilisateur',
			'today' => 'Modifié par l’utilisateur aujourd’hui',
			'yesterday' => 'Modifié par l’utilisateur hier',
		),
	),
	'log' => array(
		'_' => 'Logs',	// IGNORE
		'clear' => 'Effacer les logs',
		'empty' => 'Les logs sont vides.',
		'title' => 'Logs',	// IGNORE
	),
	'menu' => array(
		'about' => 'À propos de FreshRSS',
		'before_one_day' => 'Antérieurs à 1 jour',
		'before_one_week' => 'Antérieurs à 1 semaine',
		'bookmark_query' => 'Enregistrer la recherche courante',
		'favorites' => 'Articles favoris (%s)',
		'global_view' => 'Vue globale',
		'important' => 'Flux importants',
		'main_stream' => 'Flux principaux',
		'mark_all_read' => 'Tout marquer comme lu',
		'mark_cat_read' => 'Marquer la catégorie comme lue',
		'mark_feed_read' => 'Marquer le flux comme lu',
		'mark_selection_unread' => 'Marquer la sélection comme non-lue',
		'mylabels' => 'Mes étiquettes',
		'non-starred' => 'Afficher les non-favoris',
		'normal_view' => 'Vue normale',
		'queries' => 'Filtres utilisateurs',
		'read' => 'Afficher les lus',
		'reader_view' => 'Vue lecture',
		'rss_view' => 'Flux RSS',
		'search_short' => 'Rechercher',
		'sort' => array(
			'asc' => 'Ascendant',
			'c' => array(
				'name_asc' => 'Catégorie, flux (titres) A→Z',
				'name_desc' => 'Catégorie, flux (titres) Z→A',
			),
			'date_asc' => 'Date de publication 1→9',
			'date_desc' => 'Date de publication 9→1',
			'desc' => 'Descendant',
			'f' => array(
				'name_asc' => 'Flux (titre) A→Z',
				'name_desc' => 'Flux (titre) Z→A',
			),
			'id_asc' => 'Reçus récemment en dernier',
			'id_desc' => 'Reçus récemment en premier',
			'length_asc' => 'Longueur du contenu 1→9',
			'length_desc' => 'Longueur du contenu 9→1',
			'link_asc' => 'Lien A→Z',
			'link_desc' => 'Lien Z→A',
			'primary' => array(
				'_' => 'Critère de tri',
				'help' => 'Le tri par date de <em>réception</em> est recommandé dans la plupart des cas, pour une meilleure cohérence et performance',
			),
			'rand' => 'Ordre aléatoire',
			'secondary' => array(
				'_' => 'Critère de tri secondaire',
				'help' => 'Seulemement pertinent lorsque le critère de tri principal est sur les titres des catégories ou des flux',
			),
			'title_asc' => 'Titre A→Z',
			'title_desc' => 'Titre Z→A',
			'user_modified_asc' => 'Modifié par l’utilisateur 1→9',
			'user_modified_desc' => 'Modifié par l’utilisateur 9→1',
		),
		'starred' => 'Afficher les favoris',
		'stats' => 'Statistiques',
		'subscription' => 'Gestion des abonnements',
		'unread' => 'Afficher les non-lus',
	),
	'share' => 'Partager',
	'tag' => array(
		'related' => 'Tags de l’article',
	),
	'tos' => array(
		'title' => 'Conditions Générales d’Utilisation',
	),
);

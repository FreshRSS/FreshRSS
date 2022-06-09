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
	'api' => array(
		'documentation' => 'Copier l’URL suivante dans l’outil qui utilisera l’API.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Glisser ce bouton dans la barre des favoris ou cliquer droit dessus et choisir "Enregistrer ce lien". Ensuite, cliquer sur le bouton "S’abonner" sur les pages auxquelles vous voulez vous abonner.',
		'label' => 'S’abonner',
		'title' => 'Bookmarklet',	// IGNORE
	),
	'category' => array(
		'_' => 'Catégorie',
		'add' => 'Ajouter catégorie',
		'archiving' => 'Archivage',
		'empty' => 'Catégorie vide',
		'information' => 'Informations',
		'position' => 'Position d’affichage',
		'position_help' => 'Pour contrôler l’ordre de tri des catégories',
		'title' => 'Titre',
	),
	'feed' => array(
		'add' => 'Ajouter un flux RSS',
		'advanced' => 'Avancé',
		'archiving' => 'Archivage',
		'auth' => array(
			'configuration' => 'Identification',
			'help' => 'La connexion permet d’accéder aux flux protégés par une authentification HTTP.',
			'http' => 'Authentification HTTP',
			'password' => 'Mot de passe HTTP',
			'username' => 'Identifiant HTTP',
		),
		'clear_cache' => 'Toujours vider le cache',
		'content_action' => array(
			'_' => 'Action à effectuer pour la réception du contenu des articles',
			'append' => 'Ajouter après le contenu existant',
			'prepend' => 'Ajouter avant le contenu existant',
			'replace' => 'Remplacer le contenu existant',
		),
		'css_cookie' => 'Utiliser des cookies pour la réception du contenu des articles',
		'css_cookie_help' => 'Exemple : <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Permet de récupérer les flux tronqués (attention, demande plus de temps !)',
		'css_path' => 'Sélecteur CSS des articles sur le site d’origine',
		'description' => 'Description',	// IGNORE
		'empty' => 'Ce flux est vide. Veuillez vérifier qu’il est toujours maintenu.',
		'error' => 'Ce flux a rencontré un problème. Veuillez vérifier qu’il est toujours accessible puis actualisez-le.',
		'filteractions' => array(
			'_' => 'Filtres d’action',
			'help' => 'Écrivez une recherche par ligne.',
		),
		'information' => 'Informations',
		'keep_min' => 'Nombre minimum d’articles à conserver',
		'kind' => array(
			'_' => 'Type de source de flux',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Moissonnage du Web)',
				'feed_title' => array(
					'_' => 'titre de flux',
					'help' => 'Exemple : <code>//title</code> ou un text statique : <code>"Mon flux personnalisé"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> est un langage de requête pour les utilisateurs avancés, supporté par FreshRSS pour le moissonnage du Web (Web scraping).',
				'item' => array(
					'_' => 'trouver les <strong>articles</strong>',
					'help' => 'Exemple : <code>//div[@class="article"]</code>',
				),
				'item_author' => array(
					'_' => 'auteur de l’article',
					'help' => 'Peut aussi être une chaîne de texte statique. Exemple : <code>"Anonyme"</code>',
				),
				'item_categories' => 'catégories (tags) de l’article',
				'item_content' => array(
					'_' => 'contenu de l’article',
					'help' => 'Exemple pour prendre l’article complet : <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'miniature de l’article',
					'help' => 'Exemple : <code>descendant::img/@src</code>',
				),
				'item_timestamp' => array(
					'_' => 'date de l’article',
					'help' => 'Le résultat sera passé à la fonction <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'titre de l’article',
					'help' => 'Utiliser en particulier l’<a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">axe XPath</a> <code>descendant::</code> comme <code>descendant::h2</code>',
				),
				'item_uri' => array(
					'_' => 'lien (URL) de l’article',
					'help' => 'Exemple : <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (relatif à l’article) pour :',
				'xpath' => 'XPath pour :',
			),
			'rss' => 'RSS / Atom (par défaut)',
		),
		'maintenance' => array(
			'clear_cache' => 'Vider le cache',
			'clear_cache_help' => 'Supprime le cache de ce flux.',
			'reload_articles' => 'Recharger les articles',
			'reload_articles_help' => 'Recharge cette quantité d’articles et récupère le contenu complet si un sélecteur est défini.',
			'title' => 'Maintenance',	// IGNORE
		),
		'moved_category_deleted' => 'Lors de la suppression d’une catégorie, ses flux seront automatiquement classés dans <em>%s</em>.',
		'mute' => 'muet',
		'no_selected' => 'Aucun flux sélectionné.',
		'number_entries' => '%d articles',	// IGNORE
		'priority' => array(
			'_' => 'Visibilité',
			'archived' => 'Ne pas afficher (archivé)',
			'main_stream' => 'Afficher dans le flux principal',
			'normal' => 'Afficher dans sa catégorie',
		),
		'proxy' => 'Utiliser un proxy pour télécharger ce flux',
		'proxy_help' => 'Sélectionner un protocole (ex : SOCKS5) et entrer l’adresse du proxy (ex. : <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Afficher le code source',
			'show_rendered' => 'Afficher le contenu',
		),
		'show' => array(
			'all' => 'Montrer tous les flux',
			'error' => 'Montrer seulement les flux en erreur',
		),
		'showing' => array(
			'error' => 'Montre seulement les flux en erreur',
		),
		'ssl_verify' => 'Vérification sécurité SSL',
		'stats' => 'Statistiques',
		'think_to_add' => 'Vous pouvez ajouter des flux.',
		'timeout' => 'Délai d’attente en secondes',
		'title' => 'Titre',
		'title_add' => 'Ajouter un flux RSS',
		'ttl' => 'Ne pas automatiquement rafraîchir plus souvent que',
		'url' => 'URL du flux',
		'useragent' => 'Sélectionner l’agent utilisateur pour télécharger ce flux',
		'useragent_help' => 'Exemple : <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Vérifier la validité du flux',
		'website' => 'URL du site',
		'websub' => 'Notification instantanée par WebSub',
	),
	'import_export' => array(
		'export' => 'Exporter',
		'export_labelled' => 'Exporter les articles étiquetés',
		'export_opml' => 'Exporter la liste des flux (OPML)',
		'export_starred' => 'Exporter les favoris',
		'feed_list' => 'Liste des articles de %s',
		'file_to_import' => 'Fichier à importer<br />(OPML, JSON ou ZIP)',
		'file_to_import_no_zip' => 'Fichier à importer<br />(OPML ou JSON)',
		'import' => 'Importer',
		'starred_list' => 'Liste des articles favoris',
		'title' => 'Importer / exporter',
	),
	'menu' => array(
		'add' => 'Ajouter un flux/une catégorie',
		'import_export' => 'Importer / exporter',
		'label_management' => 'Gestion des étiquettes',
		'stats' => array(
			'idle' => 'Flux inactifs',
			'main' => 'Statistiques principales',
			'repartition' => 'Répartition des articles',
		),
		'subscription_management' => 'Gestion des abonnements',
		'subscription_tools' => 'Outils d’abonnement',
	),
	'tag' => array(
		'name' => 'Nom',
		'new_name' => 'Nouveau nom',
		'old_name' => 'Ancien nom',
	),
	'title' => array(
		'_' => 'Gestion des abonnements',
		'add' => 'Ajouter un flux/une catégorie',
		'add_category' => 'Ajouter une catégorie',
		'add_feed' => 'Ajouter un flux',
		'add_label' => 'Ajouter une étiquette',
		'delete_label' => 'Supprimer une étiquette',
		'feed_management' => 'Gestion des flux RSS',
		'rename_label' => 'Renommer une étiquette',
		'subscription_tools' => 'Outils d’abonnement',
	),
);

<?php

return array(
	'archiving' => array(
		'_' => 'Archius',
		'delete_after' => 'Levar los articles aprèp',
		'exception' => 'Excepcion de purga',
		'help' => 'Mai d’opcions son disponiblas dins la configuracion individuala dels fluxes',
		'keep_favourites' => 'Jamai suprimir los favorits',
		'keep_labels' => 'Jamai suprimir las etiquetas',
		'keep_max' => 'Nombre maximum d’articles de gardar',
		'keep_min_by_feed' => 'Nombre minimum d’articles de servar per flux',
		'keep_period' => 'Atge maximum dels articles de gardar',
		'keep_unreads' => 'Jamai suprimir los pas legits',
		'maintenance' => 'Entreten',
		'optimize' => 'Optimizar la basa de donada',
		'optimize_help' => 'De far de temps en temps per redusir la talha de la basa de donadas',
		'policy' => 'Politica de purga',
		'policy_warning' => 'Se cap de politica de purga es pas seleccionada, totes los articles seràn gardats',
		'purge_now' => 'Purgar ara',
		'title' => 'Archius',
		'ttl' => 'Actualizar pas automaticament mai sovent que',
	),
	'display' => array(
		'_' => 'Afichatge',
		'icon' => array(
			'bottom_line' => 'Linha enbàs',
			'display_authors' => 'Autors',
			'entry' => 'Icònas d’article',
			'publication_date' => 'Data de publicacion',
			'related_tags' => 'Etiquetas ligadas',
			'sharing' => 'Partatge',
			'top_line' => 'Linha amont',
		),
		'language' => 'Lenga',
		'notif_html5' => array(
			'seconds' => 'segondas (0 significa cap de timeout)',
			'timeout' => 'Temps d’afichatge de las notificacions HTML5',
		),
		'show_nav_buttons' => 'Mostrar los botons de navigacion',
		'theme' => 'Tèma',
		'title' => 'Afichatge',
		'width' => array(
			'content' => 'Largor del contengut',
			'large' => 'Larga',
			'medium' => 'Mejana',
			'no_limit' => 'Cap de limit',
			'thin' => 'Fina',
		),
	),
	'profile' => array(
		'_' => 'Gestion del perfil',
		'api' => 'Gestion API',
		'delete' => array(
			'_' => 'Supression del compte',
			'warn' => 'Lo compte e totas las donadas ligadas seràn suprimits.',
		),
		'email' => 'Adreça de corrièl',
		'password_api' => 'Senhal API<br /><small>(ex. : per las aplicacions mobil)</small>',
		'password_form' => 'Senhal API<br /><small>(ex. : per la connexion via formulari)</small>',
		'password_format' => 'Almens 7 caractèrs',
		'title' => 'Pefil',
	),
	'query' => array(
		'_' => 'Filtres utilizaires',
		'deprecated' => 'Aqueste filtre es pas valid. La categoria o lo flux concernit es estat suprimit.',
		'display' => 'Mostrar los resultats del filtre',
		'filter' => array(
			'_' => 'Filtres aplicats :',
			'categories' => 'Display by category',	// TODO - Translation
			'feeds' => 'Display by feed',	// TODO - Translation
			'order' => 'Sort by date',	// TODO - Translation
			'search' => 'Expression',	// TODO - Translation
			'state' => 'State',	// TODO - Translation
			'tags' => 'Display by tag',	// TODO - Translation
			'type' => 'Type',	// TODO - Translation
		),
		'get_all' => 'Mostrar totes los articles',
		'get_category' => 'Mostrar la categoria « %s »',
		'get_favorite' => 'Mostrar los articles favorits',
		'get_feed' => 'Mostrar lo flux « %s »',
		'get_tag' => 'Display "%s" label',	// TODO - Translation
		'name' => 'Name',	// TODO - Translation
		'no_filter' => 'Cap de filtre aplicat',
		'none' => 'Avètz pas encara creat cap de filtre.',
		'number' => 'Filtre n°%d',
		'order_asc' => 'Mostrar los articles mai ancians en primièr',
		'order_desc' => 'Mostrar los articles mai recents en primièr',
		'remove' => 'Levar lo filtre utilizaire',
		'search' => 'Recèrca de « %s »',
		'state_0' => 'Mostrar totes los articles',
		'state_1' => 'Mostrar los articles pas legits',
		'state_2' => 'Mostrar los articles pas legits',
		'state_3' => 'Mostrar totes los articles',
		'state_4' => 'Mostrar los articles favorits',
		'state_5' => 'Mostrar los articles legits e en favorits',
		'state_6' => 'Mostrar los articles pas legits e en favorit',
		'state_7' => 'Mostrar los articles favorits',
		'state_8' => 'Mostrar los articles pas en favorit',
		'state_9' => 'Mostrar los articles legits e pas en favorit',
		'state_10' => 'Mostrar los articles pas legits e pas en favorit',
		'state_11' => 'Mostrar los articles pas en favorit',
		'state_12' => 'Mostrar totes los articles',
		'state_13' => 'Mostrar los articles legits',
		'state_14' => 'Mostrar los articles pas legits',
		'state_15' => 'Mostrar totes los articles',
		'title' => 'Filtres utilizaire',
	),
	'reading' => array(
		'_' => 'Lectura',
		'after_onread' => 'Aprèp « marcar coma legit »,',
		'always_show_favorites' => 'Mostrar totes los articles dels favorits per defaut',
		'articles_per_page' => 'Nombre d’articles per pagina',
		'auto_load_more' => 'Cargar los articles seguents enbàs de la pagina',
		'auto_remove_article' => 'Rescondre los articles aprèp lectura',
		'confirm_enabled' => 'Mostrar una confirmacion per las accions del tipe « o marcar tot coma legit »',
		'display_articles_unfolded' => 'Mostrar los articles desplegats per defaut',
		'display_categories_unfolded' => 'Categorias a desplegar',
		'hide_read_feeds' => 'Rescondre las categorias & fluxes sens articles pas legits (fonciona pas amb la configuracion « Mostrar totes los articles »)',
		'img_with_lazyload' => 'Utilizar lo mòde “cargament tardiu” pels imatges',
		'jump_next' => 'sautar al vesin venent pas legit (flux o categoria)',
		'mark_updated_article_unread' => 'Marcar los articles actualizats coma pas legits',
		'number_divided_when_reader' => 'Devisat per 2 dins la vista de lectura.',
		'read' => array(
			'article_open_on_website' => 'quand l’article es dobèrt sul site d’origina',
			'article_viewed' => 'quand l’article es mostrat',
			'keep_max_n_unread' => 'Max number of articles to keep unread',	// TODO - Translation
			'scroll' => 'en davalar la pagina',
			'upon_reception' => 'en recebre un article novèl',
			'when' => 'Marcar un article coma legit…',
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',	// TODO - Translation
		),
		'show' => array(
			'_' => 'Articles de mostrar',
			'active_category' => 'Activar categoria',
			'adaptive' => 'Adaptar l’afichatge',
			'all_articles' => 'Mostrar totes los articles',
			'all_categories' => 'Totas las categorias',
			'no_category' => 'Cap de categoria',
			'remember_categories' => 'Se remembrar de las categorias dobèrtas',
			'unread' => 'Mostrar pas que los pas legits',
		),
		'sides_close_article' => 'Clicar fòra de la zòna de tèxte tampa l’article',
		'sort' => array(
			'_' => 'Òrdre de tria',
			'newer_first' => 'Mai recents en primièr',
			'older_first' => 'Mai ancians en primièr',
		),
		'sticky_post' => 'Gardar l’article amont quand es dobèrt',
		'title' => 'Lectura',
		'view' => array(
			'default' => 'Vista per defaut',
			'global' => 'Vista generala',
			'normal' => 'Vista normala',
			'reader' => 'Vista lectura',
		),
	),
	'sharing' => array(
		'_' => 'Partatge',
		'add' => 'Ajustar un metòde de partatge',
		'blogotext' => 'Blogotext',
		'diaspora' => 'Diaspora*',
		'email' => 'Corrièl',
		'facebook' => 'Facebook',
		'more_information' => 'Mai d’informacions',
		'print' => 'Imprimir',
		'remove' => 'Suprimir lo metòde de partatge',
		'shaarli' => 'Shaarli',
		'share_name' => 'Nom del partatge de mostrar',
		'share_url' => 'URL del partatge d’utilizar',
		'title' => 'Partatge',
		'twitter' => 'Twitter',
		'wallabag' => 'wallabag',
	),
	'shortcut' => array(
		'_' => 'Acorchis',
		'article_action' => 'Accions ligadas a l’article',
		'auto_share' => 'Partejar',
		'auto_share_help' => 'S’i a pas qu’un mòde de partatge, aquel serà utilizat. Autrament los mòdes son accessibles per lor numèro.',
		'close_dropdown' => 'Tampar los menús',
		'collapse_article' => 'Replegar',
		'first_article' => 'Passar al primièr article',
		'focus_search' => 'Accedir a la recèrca',
		'global_view' => 'Passar a la vista generala',
		'help' => 'Mostrar la documentacion',
		'javascript' => 'Devètz activar lo Javascript per utilizar los acorchis',
		'last_article' => 'Passar al darrièr article',
		'load_more' => 'Cargar mai d’articles',
		'mark_favorite' => 'Ajustar als favorits',
		'mark_read' => 'Marcar coma legit',
		'navigation' => 'Navigacion',
		'navigation_help' => 'Amb lo modificador <kbd>⇧ Shift</kbd>, los acorchis de navigacion s’aplican als fluxes.<br/>Amb lo modificador <kbd>Alt ⎇</kbd>, los acorchis de navigacion s’aplican a las categorias.',
		'navigation_no_mod_help' => 'Los acorchis clavièrs de navigacion son pas compatibles amb los modificadors.',
		'next_article' => 'Passar a l’article seguent',
		'normal_view' => 'Passar a la vista normala',
		'other_action' => 'Autras accions',
		'previous_article' => 'Passar a l’article precedent',
		'reading_view' => 'Passar a la vista lectura',
		'rss_view' => 'Dobrir la vista RSS dins un onglet novèl',
		'see_on_website' => 'Veire al site d’origina',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> per marcar l’article precedent coma legit<br />+ <kbd>⇧ Shift</kbd> per marcar los articles coma legits',
		'skip_next_article' => 'Centrar sul seguent sens lo dobrir',
		'skip_previous_article' => 'Centrar sul precedent sens lo dobrir',
		'title' => 'Acorchis',
		'toggle_media' => 'Legir/arrestar mèdia',
		'user_filter' => 'Accedir als filtres utilizaire',
		'user_filter_help' => 'S’i a pas qu’un filtre utilizaire, aquel serà utilizat. Autrament los filtres son accessibles per lor numèro.',
		'views' => 'Vistas',
	),
	'user' => array(
		'articles_and_size' => '%s articles (%s)',
		'current' => 'Utilizaire actual',
		'is_admin' => 'es administrator',
		'users' => 'Utilizaires',
	),
);

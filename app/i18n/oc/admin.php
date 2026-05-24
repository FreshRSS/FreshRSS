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
	'auth' => array(
		'allow_anonymous' => 'Autorizar la lectura anonima dels articles de l’utilizaire per defaut (%s)',
		'allow_anonymous_refresh' => 'Autorizar l’actualizacion anonime dels fluxes',
		'api_enabled' => 'Autorizar l’accès per <abbr>API</abbr><small>(necessari per las aplicacions mobil and sharing user queries)</small>',	// DIRTY
		'form' => 'Formulari (tradicional, demanda JavaScript)',
		'http' => 'HTTP (advanced: managed by Web server, OIDC, SSO…)',	// TODO
		'none' => 'Cap (perilhós)',
		'title' => 'Autentificacion',
		'token' => 'Master authentication token',	// TODO
		'token_help' => 'Allows access to all RSS outputs of the user as well as refreshing feeds without authentication:',	// TODO
		'type' => 'Mòde d’autentification',
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Extensions utilizaires disponiblas',
		'description' => 'Descripcion',
		'disabled' => 'Desactivada',
		'empty_list' => 'Cap d’extensions pas installadas',
		'empty_list_help' => 'Check the logs to determine the reason behind the empty extension list.',	// TODO
		'enabled' => 'Activada',
		'is_compatible' => 'Is compatible',	// TODO
		'latest' => 'Installada',
		'name' => 'Nom',
		'no_configure_view' => 'Aquesta extension se pòt pas configurar.',
		'system' => array(
			'_' => 'Extensions sistèma',
			'no_rights' => 'Extensions sistèma (contrarotlat per l’administrator)',
		),
		'title' => 'Extensions',	// IGNORE
		'update' => 'Mesa a jorn disponibla',
		'user' => 'Extensions utilizaire',
		'version' => 'Version',	// IGNORE
	),
	'stats' => array(
		'_' => 'Estatisticas',
		'all_feeds' => 'Totes los fluxes',
		'category' => 'Categoria',
		'date_published' => 'Publication date',	// TODO
		'date_received' => 'Received date',	// TODO
		'entry_count' => 'Nombre d’articles',
		'entry_per_category' => 'Articles per categoria',
		'entry_per_day' => 'Nombre d’articles per jorn (darrièrs 30 jorns)',
		'entry_per_day_of_week' => 'Per jorn de la setmana (mejana : %.2f messatges)',
		'entry_per_hour' => 'Per ora (mejana : %.2f messatges)',
		'entry_per_month' => 'Per mes (mejana : %.2f messatges)',
		'entry_repartition' => 'Reparticion dels articles',
		'feed' => 'Flux',
		'feed_per_category' => 'Fluxes per categoria',
		'idle' => 'Fluxes inactius',
		'main' => 'Estatisticas principalas',
		'main_stream' => 'Flux màger',
		'nb_unreads' => 'Number of unread articles',	// TODO
		'no_idle' => 'I a pas cap d’article inactiu !',
		'number_entries' => '%d articles',	// IGNORE
		'overview' => 'Overview',	// TODO
		'percent_of_total' => '% del total',
		'repartition' => 'Reparticion dels articles: %s',
		'status_favorites' => 'Favorits',
		'status_read' => 'Legit',
		'status_total' => 'Total',	// IGNORE
		'status_unread' => 'Pas legits',
		'title' => 'Estatisticas',
		'top_feed' => 'Los dètz fluxes mai gròsses',
		'unread_dates' => 'Dates with most unread articles',	// TODO
	),
	'system' => array(
		'_' => 'Configuracion sistèma',
		'auto-update-url' => 'URL del servici de mesa a jorn',
		'base-url' => array(
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => 'en segondas',
			'number' => 'Durada de téner d’ésser connectat',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
		'force_email_validation' => 'Forçar la validacion de las adreças electronicas',
		'instance-name' => 'Nom de l’instància',
		'max-categories' => 'Limita de categoria per utilizaire',
		'max-feeds' => 'Limita de fluxes per utilizaire',
		'registration' => array(
			'number' => 'Nombre max de comptes',
			'select' => array(
				'label' => 'Formulari d’inscripcion',
				'option' => array(
					'noform' => 'Desactivat : cap de formulari d’inscripcion',
					'nolimit' => 'Activat : cap de limit de comptes',
					'setaccountsnumber' => 'Definir lo numbre max. de comptes',
				),
			),
			'status' => array(
				'disabled' => 'Formulari desactivat',
				'enabled' => 'Formulari activat',
			),
			'title' => 'Formulari d’inscripcion utilizaire',
		),
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => array(
			'disabled' => 'is not given',	// TODO
			'enabled' => '<a href="./?a=tos">is enabled</a>',	// TODO
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">enable the Terms of Service</a>',	// TODO
		),
		'websub' => array(
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		),
	),
	'update' => array(
		'_' => 'Sistèma de mesa a jorn',
		'apply' => 'Aplicar',
		'changelog' => 'Changelog',	// TODO
		'check' => 'Verificar las mesas a jorn',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => 'Vòstra version actuala',
		'last' => 'Darrièra verificacion',
		'loading' => 'Updating…',	// TODO
		'none' => 'Cap d’actualizacion d’aplicar',
		'releaseChannel' => array(
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		),
		'title' => 'Sistèma de mesa a jorn',
		'viaGit' => 'Update via git and GitHub.com started',	// TODO
	),
	'user' => array(
		'admin' => 'Administrator',	// IGNORE
		'article_count' => 'Articles',	// IGNORE
		'back_to_manage' => '← Tornar a la lista dels utilizaires',
		'create' => 'Crear un nòu utilizaire',
		'database_size' => 'Talha basa de donadas',
		'email' => 'Adreça electronica',
		'enabled' => 'Activat',
		'feed_count' => 'Flux',
		'is_admin' => 'Es admin',
		'language' => 'Lenga',
		'last_user_activity' => 'Darrièra activitat utilizaire',
		'list' => 'Lista dels utilizaires',
		'number' => '%d compte ja creat',
		'numbers' => '%d comptes ja creats',
		'password_form' => 'Senhal <br /><small>(ex. : per la connexion via formulari)</small>',
		'password_format' => 'Almens 7 caractèrs',
		'title' => 'Gestion dels utilizaires',
		'username' => 'Nom d’utilizaire',
	),
);

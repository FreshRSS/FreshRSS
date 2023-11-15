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
	'auth' => array(
		'allow_anonymous' => 'Autorizar la lectura anonima dels articles de l’utilizaire per defaut (%s)',
		'allow_anonymous_refresh' => 'Autorizar l’actualizacion anonime dels fluxes',
		'api_enabled' => 'Autorizar l’accès per <abbr>API</abbr><small>(necessari per las aplicacions mobil)</small>',
		'form' => 'Formulari (tradicional, demanda JavaScript)',
		'http' => 'HTTP (per utilizaires avançats amb HTTPS)',
		'none' => 'Cap (perilhós)',
		'title' => 'Autentificacion',
		'token' => 'Geton d’autentificacion',
		'token_help' => 'Permetre l’accès a la sortida RSS de l’utilizaire per defaut sens cap d’autentificacion :',
		'type' => 'Mòde d’autentification',
		'unsafe_autologin' => 'Autorizar las connexions automaticas pas seguras al format : ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Volgatz verificar los dreches sul repertòri <em>./data/cache</em>. Lo servidor HTTP deu poder escriure dedins',
			'ok' => 'Los dreches sul cache son bons.',
		),
		'categories' => array(
			'nok' => 'La tabla “category” es mala configurada.',
			'ok' => 'La tabla category es corrèctament configurada.',
		),
		'connection' => array(
			'nok' => 'Connexion impossibla a la basa de donadas.',
			'ok' => 'La connexion a la basa de donadas es bona.',
		),
		'ctype' => array(
			'nok' => 'Impossible de trobar una bibliotèca per la verificacion del tipe de caractèrs (php-ctype).',
			'ok' => 'Avètz la bibliotèca per la verificacion del tipe de caractèrs (ctype).',
		),
		'curl' => array(
			'nok' => 'Impossible de trobar la bibliotèca cURL( paquet php-curl).',
			'ok' => 'Avètz la bibliotèca cURL.',
		),
		'data' => array(
			'nok' => 'Volgatz verificar los dreches sul repertòri <em>./data</em>. Lo servidor HTTP deu poder escriure dedins',
			'ok' => 'Los dreches sul repertòri data son bons.',
		),
		'database' => 'Installacion de la basa de donadas',
		'dom' => array(
			'nok' => 'Impossible de trobar una bibliotèca per percórrer lo DOM (paquet php-xml).',
			'ok' => 'Avètz la bibliotèca per percórrer lo DOM.',
		),
		'entries' => array(
			'nok' => 'La tabla entry es pas configurada coma cal.',
			'ok' => 'La tabla entry es corrèctament configurada.',
		),
		'favicons' => array(
			'nok' => 'Volgatz verificar los dreches sul repertòri <em>./data/favicons</em>. Lo servidor HTTP deu poder escriure dedins',
			'ok' => 'Los dreches sul repertòri dels favicons son bons.',
		),
		'feeds' => array(
			'nok' => 'La tabla feed es pas configurada coma cal.',
			'ok' => 'La tabla feed es corrèctament configurada.',
		),
		'fileinfo' => array(
			'nok' => 'Avètz pas PHP fileinfo (paquet fileinfo).',
			'ok' => 'Avètz la bibliotèca fileinfo.',
		),
		'files' => 'Installacion dels fichièrs',
		'json' => array(
			'nok' => 'Avètz pas l’extension recomandada JSON (paquet php-json).',
			'ok' => 'Avètz l’exension recomandada JSON.',
		),
		'mbstring' => array(
			'nok' => 'Impossible de trobar la bibliotèca recomandada mbstring per Unicode.',
			'ok' => 'Avètz la bibliotèca recomandada mbstring per Unicode.',
		),
		'pcre' => array(
			'nok' => 'Impossible de trobar una bibliotèca per las expressions regulara (php-pcre).',
			'ok' => 'Avètz la bibliotèca per las expressions regularas (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Impossible de trobar PDO o un dels drivers compatibles (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Avètz PDO e almens un des drivers compatibles (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'Installacion PHP',
			'nok' => 'Vòstra version PHP es la %s más FreshRSS demanda almens la versión %s.',
			'ok' => 'Vòstra version PHP es %s, qu’es compatibla amb FreshRSS.',
		),
		'tables' => array(
			'nok' => 'Manca una o mai tabla dins la basa de donadas.',
			'ok' => 'Las tablas que cal existisson ben dins la basa de donadas.',
		),
		'title' => 'Verificacion de l’installacion',
		'tokens' => array(
			'nok' => 'Volgatz verificar los dreches sul repertòri <em>./data/tokens</em>. Lo servidor HTTP deu poder escriure dedins',
			'ok' => 'Los dreches sul repertòri dels getons son bons.',
		),
		'users' => array(
			'nok' => 'Volgatz verificar los dreches sul repertòri <em>./data/users</em>. Lo servidor HTTP deu poder escriure dedins',
			'ok' => 'Los dreches sul repertòri dels utilizaires son bons.',
		),
		'zip' => array(
			'nok' => 'Avètz pas l’extension ZIP (paquet php-zip).',
			'ok' => 'Avètz l’exension ZIP.',
		),
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Extensions utilizaires disponiblas',
		'description' => 'Descripcion',
		'disabled' => 'Desactivada',
		'empty_list' => 'Cap d’extensions pas installadas',
		'enabled' => 'Activada',
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
		'no_idle' => 'I a pas cap d’article inactiu !',
		'number_entries' => '%d articles',	// IGNORE
		'percent_of_total' => '% del total',
		'repartition' => 'Reparticion dels articles',
		'status_favorites' => 'Favorits',
		'status_read' => 'Legit',
		'status_total' => 'Total',	// IGNORE
		'status_unread' => 'Pas legits',
		'title' => 'Estatisticas',
		'top_feed' => 'Los dètz fluxes mai gròsses',
	),
	'system' => array(
		'_' => 'Configuracion sistèma',
		'auto-update-url' => 'URL del servici de mesa a jorn',
		'base-url' => array(
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		),
		'cookie-duration' => array(
			'help' => 'en segondas',
			'number' => 'Durada de téner d’ésser connectat',
		),
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
		'viaGit' => 'Update via git and Github.com started',	// TODO
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

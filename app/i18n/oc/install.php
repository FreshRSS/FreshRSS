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
		'finish' => 'Acabar l’installacion',
		'fix_errors_before' => 'Mercés de corregir las errors seguentas abans de contunhar.',
		'keep_install' => 'Gardar la configuracion precedenta',
		'next_step' => 'Anar a l’estapa seguenta',
		'reinstall' => 'Reïnstallar FreshRSS',
	],
	'auth' => [
		'form' => 'Formulari (tradicional, demanda JavaScript)',
		'http' => 'HTTP (per utilizaires avançats amb HTTPS)',
		'none' => 'Cap (perilhós)',
		'password_form' => 'Senhal API<br /><small>(ex. : per la connexion via formulari)</small>',
		'password_format' => 'Almens 7 caractèrs',
		'type' => 'Mòde d’autentification',
	],
	'bdd' => [
		'_' => 'Basa de donadas',
		'conf' => [
			'_' => 'Configuracion de la basa de donadas',
			'ko' => 'Verificatz las informacions de la basa de donadas.',
			'ok' => 'La configuracion de la basa de donadas es salvagarda.',
		],
		'host' => 'Òste',
		'password' => 'Senhal de la basa de donadas',
		'prefix' => 'Prefixe de tabla',
		'type' => 'Tipe de basa de donadas',
		'username' => 'Nom d’utilizaire de la basa de donadas',
	],
	'check' => [
		'_' => 'Verificacions',
		'already_installed' => 'Sembla que FreshRSS es ja installat !',
		'cache' => [
			'nok' => 'Volgatz verificar los dreches sul repertòri <em>%s</em>. Lo servidor HTTP deu poder escriure dedins.',
			'ok' => 'Los dreches sul cache son bons.',
		],
		'ctype' => [
			'nok' => 'Impossible de trobar una bibliotèca per la verificacion del tipe de caractèrs (php-ctype).',
			'ok' => 'Avètz la bibliotèca per la verificacion del tipe de caractèrs (ctype).',
		],
		'curl' => [
			'nok' => 'Impossible de trobar la bibliotèca curl ( paquet php-curl).',
			'ok' => 'Avètz la bibliotèca cURL.',
		],
		'data' => [
			'nok' => 'Volgatz verificar los dreches sul repertòri <em>%s</em>. Lo servidor HTTP deu poder escriure dedins.',
			'ok' => 'Los dreches sul repertòri data son bons.',
		],
		'dom' => [
			'nok' => 'Impossible de trobar una bibliotèca per percórrer lo DOM.',
			'ok' => 'Avètz la bibliotèca per percórrer lo DOM.',
		],
		'favicons' => [
			'nok' => 'Volgatz verificar los dreches sul repertòri <em>%s</em>. Lo servidor HTTP deu poder escriure dedins.',
			'ok' => 'Los dreches sul repertòri dels favicons son bons.',
		],
		'fileinfo' => [
			'nok' => 'Avètz pas PHP fileinfo (paquet fileinfo).',
			'ok' => 'Avètz la bibliotèca fileinfo.',
		],
		'json' => [
			'nok' => 'Impossible de trobar l’extension recomandada JSON (paquet php-json).',
			'ok' => 'Avètz l’exension recomandada JSON.',
		],
		'mbstring' => [
			'nok' => 'Impossible de trobar la bibliotèca recomandada mbstring per Unicode.',
			'ok' => 'Avètz la bibliotèca recomandada mbstring per Unicode.',
		],
		'pcre' => [
			'nok' => 'Impossible de trobar una bibliotèca per las expressions regulara (php-pcre).',
			'ok' => 'Avètz la bibliotèca per las expressions regularas (PCRE).',
		],
		'pdo' => [
			'nok' => 'Impossible de trobar PDO o un dels drivers compatibles (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Avètz PDO e almens un des drivers compatibles (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		],
		'php' => [
			'nok' => 'Vòstra version PHP es la %s mas FreshRSS demanda almens la version %s.',
			'ok' => 'Vòstra version PHP es %s, qu’es compatibla amb FreshRSS.',
		],
		'reload' => 'Revérifier',
		'tmp' => [
			'nok' => 'Volgatz verificar los dreches sul repertòri <em>%s</em>. Lo servidor HTTP deu poder escriure dedins.',
			'ok' => 'Las permissions sul repertòri temporari son bonas.',
		],
		'unknown_process_username' => 'desconegut',
		'users' => [
			'nok' => 'Volgatz verificar los dreches sul repertòri <em>%s</em>. Lo servidor HTTP deu poder escriure dedins.',
			'ok' => 'Los dreches sul repertòri dels utilizaires son bons.',
		],
		'xml' => [
			'nok' => 'Impossible de trobar una bibliotèca necessària per XML.',
			'ok' => 'Avètz la bibliotèca per percórrer los XML.',
		],
	],
	'conf' => [
		'_' => 'Configuracion generala',
		'ok' => 'La configuracion generala es enregistrada.',
	],
	'congratulations' => 'Òsca !',
	'default_user' => [
		'_' => 'Nom d’utilizaire per defaut',
		'max_char' => '16 caractèrs alfanumerics maximum',
	],
	'fix_errors_before' => 'Mercés de corregir las errors seguentas abans de contunhar.',
	'javascript_is_better' => 'FreshRSS es mai agradable amb lo JavaScript activat',
	'js' => [
		'confirm_reinstall' => 'En reïnstallant FreshRSS perdretz la configuracion precedenta. Volètz vertadièrament contunhar ?',
	],
	'language' => [
		'_' => 'Lenga',
		'choose' => 'Causissètz la lenga per FreshRSS',
		'defined' => 'La lenga es corrèctament definida.',
	],
	'missing_applied_migrations' => 'Quicòm a trucat ; devètz crear un fichièr <em>%s</em> void manualament.',
	'ok' => 'L’installacion s’es corrèctament passada.',
	'session' => [
		'nok' => 'Sembla que lo servidor web siá pas corrèctament configurat pels cookies per las sessions PHP !',
	],
	'step' => 'etapa %d',
	'steps' => 'Etapas',
	'this_is_the_end' => 'Es la fin',
	'title' => 'Installacion · FreshRSS',
];

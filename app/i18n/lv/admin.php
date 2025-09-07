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
		'allow_anonymous' => 'Ļaut anonīmi lasīt noklusējuma lietotāja rakstus (%s)',
		'allow_anonymous_refresh' => 'Atļaut anonīmu rakstu atsvaidzināšanu',
		'api_enabled' => 'Atļaut <abbr>API</abbr> piekļuvi <small>(nepieciešams mobilajām lietotnēm and sharing user queries)</small>',	// DIRTY
		'form' => 'Tīmekļa veidlapa (tradicionālā, nepieciešams JavaScript)',
		'http' => 'HTTP (advanced: managed by Web server, OIDC, SSO…)',	// TODO
		'none' => 'Nav (bīstami)',
		'title' => 'Autentifikācija',
		'token' => 'Master authentication token',	// TODO
		'token_help' => 'Allows access to all RSS outputs of the user as well as refreshing feeds without authentication:',	// TODO
		'type' => 'Autentifikācijas metode',
		'unsafe_autologin' => 'Atļaut nedrošu automātisku pieteikšanos, izmantojot formātu: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Pārbaudiet atļaujas <em>./data/cache</em> mapē. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām.',
			'ok' => 'Kešatmiņas mapes atļaujas ir pareizas.',
		),
		'categories' => array(
			'nok' => 'Kategoriju tabula ir nepareizi konfigurēta.',
			'ok' => 'Kategoriju tabulai viss ir kārtībā.',
		),
		'connection' => array(
			'nok' => 'Nevar izveidot savienojumu ar datubāzi.',
			'ok' => 'Savienojumam ar datubāzi viss ir kārtībā.',
		),
		'ctype' => array(
			'nok' => 'Nevar atrast nepieciešamo bibliotēku rakstzīmju tipa pārbaudei (php-ctype).',
			'ok' => 'Jums ir nepieciešamā bibliotēka rakstzīmju tipa pārbaudei (ctype).',
		),
		'curl' => array(
			'nok' => 'Nevar atrast cURL bibliotēku (php-curl pakotne).',
			'ok' => 'Jums ir cURL bibliotēka.',
		),
		'data' => array(
			'nok' => 'Pārbaudiet atļaujas <em>./data</em> mapē. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām.',
			'ok' => 'Ar datu mapes atļaujām viss ir kārtībā.',
		),
		'database' => 'Datubāzes instalācija',
		'dom' => array(
			'nok' => 'Nevar atrast nepieciešamo bibliotēku, lai pārlūkotu DOM (php-xml pakete).',
			'ok' => 'Jums ir nepieciešamā bibliotēka, lai pārlūkotu DOM.',
		),
		'entries' => array(
			'nok' => 'Ierakstu tabula ir nepareizi konfigurēta.',
			'ok' => 'Ar ierakstu tabulu viss ir kārtībā.',
		),
		'favicons' => array(
			'nok' => 'Pārbaudiet atļaujas <em>./data/favicons</em> mapē. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām.',
			'ok' => 'Ar favikonu mapes atļaujām viss ir kārtībā.',
		),
		'feeds' => array(
			'nok' => 'Nepareizi konfigurēta padeves tabula.',
			'ok' => 'Ar padeves tabulu viss ir kārtībā.',
		),
		'fileinfo' => array(
			'nok' => 'Nevar atrast PHP fileinfo bibliotēku (fileinfo pakotne).',
			'ok' => 'Jums ir fileinfo bibliotēka.',
		),
		'files' => 'Failu instalācija',
		'json' => array(
			'nok' => 'Nevar atrast JSON (php-json pakete).',
			'ok' => 'Jums ir JSON paplašinājums.',
		),
		'mbstring' => array(
			'nok' => 'Nevar atrast ieteikto mbstring bibliotēku priekš Unicode.',
			'ok' => 'Jums ir ieteiktā mbstring bibliotēka priekš Unicode.',
		),
		'pcre' => array(
			'nok' => 'Nevar atrast nepieciešamo bibliotēku regulārajām izteiksmēm (php-pcre).',
			'ok' => 'Jums ir nepieciešamā regulāro izteiksmju bibliotēka (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Nevar atrast PDO vai kādu no atbalstītajiem draiveriem (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Jums ir PDO un vismaz viens no atbalstītajiem draiveriem (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'PHP instalācija',
			'nok' => 'Jūsu PHP versija ir %s, bet FreshRSS nepieciešama vismaz %s versija.',
			'ok' => 'Jūsu PHP versija (%s) ir saderīga ar FreshRSS.',
		),
		'tables' => array(
			'nok' => 'Datubāzē trūkst vienas vai vairāku tabulu.',
			'ok' => 'Datubāzē eksistē atbilstošas tabulas.',
		),
		'title' => 'Instalācijas pārbaude',
		'tokens' => array(
			'nok' => 'Pārbaudiet atļaujas <em>./data/tokens</em> mapē. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām.',
			'ok' => 'Ar žetonu mapes atļaujām viss ir kārtībā.',
		),
		'users' => array(
			'nok' => 'Pārbaudiet atļaujas <em>./data/users</em> mapē. HTTP serverim jābūt piešķirtām rakstīšanas atļaujām.',
			'ok' => 'Ar lietotāju mapes atļaujām viss ir kārtībā.',
		),
		'zip' => array(
			'nok' => 'Nevar atrast ZIP paplašinājumu (php-zip pakete).',
			'ok' => 'Jums ir ZIP paplašinājums.',
		),
	),
	'extensions' => array(
		'author' => 'Autors',
		'community' => 'Pieejamie sabiedrības paplašinājumi',
		'description' => 'Apraksts',
		'disabled' => 'Atspējots',
		'empty_list' => 'Nav instalētu paplašinājumu',
		'empty_list_help' => 'Check the logs to determine the reason behind the empty extension list.',	// TODO
		'enabled' => 'Ieslēgts',
		'latest' => 'Instalēts',
		'name' => 'Vārds',
		'no_configure_view' => 'Šo paplašinājumu nevar konfigurēt.',
		'system' => array(
			'_' => 'Sistēmas paplašinājumi',
			'no_rights' => 'Sistēmas paplašinājums (jums nav vajadzīgo atļauju)',
		),
		'title' => 'Paplašinājumi',
		'update' => 'Pieejams atjauninājums',
		'user' => 'Lietotāja paplašinājumi',
		'version' => 'Versija',
	),
	'stats' => array(
		'_' => 'Statistika',
		'all_feeds' => 'Visas barotnes',
		'category' => 'Kategorija',
		'entry_count' => 'Ierakstu skaits',
		'entry_per_category' => 'Ieraksti katrā kategorijā',
		'entry_per_day' => 'Ieraksti dienā (pēdējās 30 dienas)',
		'entry_per_day_of_week' => 'Katrā nedēļas dienā (vidēji: %.2f ziņojumu)',
		'entry_per_hour' => 'Katrā stundā (vidēji: %.2f ziņojumu)',
		'entry_per_month' => 'Katrā mēnesī (vidēji: %.2f ziņojumu)',
		'entry_repartition' => 'Entries repartition',	// TODO
		'feed' => 'Barotne',
		'feed_per_category' => 'Barotnes pa kategorijām',
		'idle' => 'Neaktīvās barotnes',
		'main' => 'Galvenās statistikas',
		'main_stream' => 'Galvenā plūsma',
		'no_idle' => 'Nav neaktīvu barotņu!',
		'number_entries' => '%d raksti',
		'overview' => 'Overview',	// TODO
		'percent_of_total' => '% no kopsummas',
		'repartition' => 'Rakstu pārdalīšana: %s',	// DIRTY
		'status_favorites' => 'Mīļākie',
		'status_read' => 'Izlasīti',
		'status_total' => 'Kopā',
		'status_unread' => 'Neizlasīti',
		'title' => 'Statistika',
		'top_feed' => 'Top 10 barotnes',
	),
	'system' => array(
		'_' => 'Sistēmas konfigurācija',
		'auto-update-url' => 'Automātiskās atjaunināšanas servera URL',
		'base-url' => array(
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		),
		'cookie-duration' => array(
			'help' => 'sekundēs',
			'number' => 'Pieteikšanās ilgums',
		),
		'force_email_validation' => 'Piespiedu e-pasta adreses validēšana',
		'instance-name' => 'Instances nosaukums',
		'max-categories' => 'Maksimālais kategoriju skaits vienam lietotājam',
		'max-feeds' => 'Maksimālais barotņu skaits vienam lietotājam',
		'registration' => array(
			'number' => 'Maksimālais kontu skaits',
			'select' => array(
				'label' => 'Reģistrācijas veidlapa',
				'option' => array(
					'noform' => 'Atspējots: Nav reģistrācijas veidlapas',
					'nolimit' => 'Ieslēgts: Kontu skaits nav ierobežots',
					'setaccountsnumber' => 'Maksimālā kontu skaita iestatīšana',
				),
			),
			'status' => array(
				'disabled' => 'Veidlapa atspējota',
				'enabled' => 'Veidlapa ieslēgta',
			),
			'title' => 'Lietotāja reģistrācijas veidlapa',
		),
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => array(
			'disabled' => 'nav dots',
			'enabled' => '<a href="./?a=tos">ir ieslēgts</a>',
			'help' => 'Kā iespējot <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">pakalpojumu sniegšanas noteikumus</a>',
		),
		'websub' => array(
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		),
	),
	'update' => array(
		'_' => 'Atjaunināt sistēmu',
		'apply' => 'Pieteikties',
		'changelog' => 'Changelog',	// TODO
		'check' => 'Jaunu atjauninājumu pārbaude',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => 'Jūsu pašreizējā versija',
		'last' => 'Pēdējā verifikācija',
		'loading' => 'Updating…',	// TODO
		'none' => 'Nav jāpiemēro atjauninājums',
		'releaseChannel' => array(
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		),
		'title' => 'Atjaunināt sistēmu',
		'viaGit' => 'Update via git and GitHub.com started',	// TODO
	),
	'user' => array(
		'admin' => 'Administrators',
		'article_count' => 'Raksti',
		'back_to_manage' => '← Atgriezties lietotāju sarakstā',
		'create' => 'Uztaisīt jaunu lietotāju',
		'database_size' => 'Datubāzes izmērs',
		'email' => 'E-pasta adreses',
		'enabled' => 'Ieslēgts',
		'feed_count' => 'Barotnes',
		'is_admin' => 'Ir administrators',
		'language' => 'Valoda',
		'last_user_activity' => 'Pēdējā lietotāja darbība',
		'list' => 'Lietotāju saraksts',
		'number' => 'Ir izveidots %d konts',
		'numbers' => 'Ir izveidoti %d kontu',
		'password_form' => 'Parole<br /><small>(Web-formas pieteikšanās metodei)</small>',
		'password_format' => 'Vismaz 7 rakstzīmes',
		'title' => 'Pārvaldīt lietotājus',
		'username' => 'Lietotājvārds',
	),
);

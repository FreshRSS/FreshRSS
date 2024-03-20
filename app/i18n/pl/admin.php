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
	'auth' => [
		'allow_anonymous' => 'Pozwól na anonimowy odczyt wiadomości domyślnego użytkownika (%s)',
		'allow_anonymous_refresh' => 'Pozwól na anonimowe odświeżanie wiadomości',
		'api_enabled' => 'Pozwól na dostęp przez <abbr>API</abbr> <small>(wymagane dla aplikacji na telefon)</small>',
		'form' => 'Formularz na stronie (tradycyjna, wymagany JavaScript)',
		'http' => 'HTTP (dla zaawansowanych użytkowników, z wykorzystaniem HTTPS)',
		'none' => 'Brak (niebezpieczna)',
		'title' => 'Uwierzytelnianie',
		'token' => 'Master authentication token',	// TODO
		'token_help' => 'Allows access to all RSS outputs of the user as well as refreshing feeds without authentication:',	// TODO
		'type' => 'Metoda uwierzytelniania',
		'unsafe_autologin' => 'Pozwól na niebezpieczne automatyczne logowanie następującym schematem:	-> todo',
	],
	'check_install' => [
		'cache' => [
			'nok' => 'Check permissions on <em>./data/cache</em> directory. HTTP server must have write permission.',	// TODO
			'ok' => 'Permissions on the cache directory are good.',	// TODO
		],
		'categories' => [
			'nok' => 'Category table is improperly configured.',	// TODO
			'ok' => 'Category table is okay.',	// TODO
		],
		'connection' => [
			'nok' => 'Connection to the database cannot be established.',	// TODO
			'ok' => 'Connection to the database is okay.',	// TODO
		],
		'ctype' => [
			'nok' => 'Cannot find a required library for character type checking (php-ctype).',	// TODO
			'ok' => 'You have the required library for character type checking (ctype).',	// TODO
		],
		'curl' => [
			'nok' => 'Cannot find the cURL library (php-curl package).',	// TODO
			'ok' => 'You have the cURL library.',	// TODO
		],
		'data' => [
			'nok' => 'Check permissions on <em>./data</em> directory. HTTP server must have write permission.',	// TODO
			'ok' => 'Permissions on the data directory are good.',	// TODO
		],
		'database' => 'Database installation',	// TODO
		'dom' => [
			'nok' => 'Cannot find a required library to browse the DOM (php-xml package).',	// TODO
			'ok' => 'You have the required library to browse the DOM.',	// TODO
		],
		'entries' => [
			'nok' => 'Entry table is improperly configured.',	// TODO
			'ok' => 'Entry table is okay.',	// TODO
		],
		'favicons' => [
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have write permission.',	// TODO
			'ok' => 'Permissions on the favicons directory are good.',	// TODO
		],
		'feeds' => [
			'nok' => 'Feed table is improperly configured.',	// TODO
			'ok' => 'Feed table is okay.',	// TODO
		],
		'fileinfo' => [
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// TODO
			'ok' => 'You have the fileinfo library.',	// TODO
		],
		'files' => 'File installation',	// TODO
		'json' => [
			'nok' => 'Cannot find JSON (php-json package).',	// TODO
			'ok' => 'You have the JSON extension.',	// TODO
		],
		'mbstring' => [
			'nok' => 'Cannot find the recommended mbstring library for Unicode.',	// TODO
			'ok' => 'You have the recommended mbstring library for Unicode.',	// TODO
		],
		'pcre' => [
			'nok' => 'Cannot find a required library for regular expressions (php-pcre).',	// TODO
			'ok' => 'You have the required library for regular expressions (PCRE).',	// TODO
		],
		'pdo' => [
			'nok' => 'Cannot find PDO or one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO
			'ok' => 'You have PDO and at least one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO
		],
		'php' => [
			'_' => 'PHP installation',	// TODO
			'nok' => 'Your PHP version is %s but FreshRSS requires at least version %s.',	// TODO
			'ok' => 'Your PHP version (%s) is compatible with FreshRSS.',	// TODO
		],
		'tables' => [
			'nok' => 'There are one or more missing tables in the database.',	// TODO
			'ok' => 'The appropriate tables exist in the database.',	// TODO
		],
		'title' => 'Installation check',	// TODO
		'tokens' => [
			'nok' => 'Check permissions on <em>./data/tokens</em> directory. HTTP server must have write permission',	// TODO
			'ok' => 'Permissions on the tokens directory are good.',	// TODO
		],
		'users' => [
			'nok' => 'Check permissions on <em>./data/users</em> directory. HTTP server must have write permission',	// TODO
			'ok' => 'Permissions on the users directory are good.',	// TODO
		],
		'zip' => [
			'nok' => 'Cannot find the ZIP extension (php-zip package).',	// TODO
			'ok' => 'You have the ZIP extension.',	// TODO
		],
	],
	'extensions' => [
		'author' => 'Autor',
		'community' => 'Rozszerzenia stworzone przez społeczność',
		'description' => 'Opis',
		'disabled' => 'Wyłączone',
		'empty_list' => 'Brak zainstalowanych rozszerzeń',
		'enabled' => 'Włączone',
		'latest' => 'Zainstalowane',
		'name' => 'Nazwa',
		'no_configure_view' => 'To rozszerzenie nie jest konfigurowalne.',
		'system' => [
			'_' => 'Rozszerzenia systemowe',
			'no_rights' => 'Rozszerzenie systemowe (brak uprawnień)',
		],
		'title' => 'Rozszerzenia',
		'update' => 'Dostępna jest aktualizacja',
		'user' => 'Rozszerzenia użytkownika',
		'version' => 'Wersja',
	],
	'stats' => [
		'_' => 'Statystyki',
		'all_feeds' => 'Wszystkie kanały',
		'category' => 'Kategoria',
		'entry_count' => 'Liczba wiadomości',
		'entry_per_category' => 'Wiadomości w podziale na kategorie',
		'entry_per_day' => 'Wiadomości na dzień (przez ostatnie 30 dni)',
		'entry_per_day_of_week' => 'Według dnia tygodnia (średnio: %.2f wiadomości)',
		'entry_per_hour' => 'Według godzin (średnio: %.2f wiadomości)',
		'entry_per_month' => 'Według miesięcy (średnio: %.2f wiadomości)',
		'entry_repartition' => 'Podział wiadomości',
		'feed' => 'Kanał',
		'feed_per_category' => 'Kanały w podziale na kategorie',
		'idle' => 'Bezczynne kanały',
		'main' => 'Główne statystyki',
		'main_stream' => 'Kanał główny',
		'no_idle' => 'Brak bezczynnych kanałów!',
		'number_entries' => '%d wiadomości',
		'percent_of_total' => '% wszystkich',
		'repartition' => 'Podział wiadomości',
		'status_favorites' => 'Ulubione',
		'status_read' => 'Przeczytane',
		'status_total' => 'Wszystkie',
		'status_unread' => 'Nieprzeczytane',
		'title' => 'Statystyki',
		'top_feed' => '10 największych kanałów',
	],
	'system' => [
		'_' => 'Konfiguracja serwisu',
		'auto-update-url' => 'Adres serwera automatycznej aktualizacji',
		'base-url' => [
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		],
		'cookie-duration' => [
			'help' => 'w sekundach',
			'number' => 'Czas przez który użytkownik pozostanie zalogowany',
		],
		'force_email_validation' => 'Wymuś weryfikację adresu e-mail',
		'instance-name' => 'Nazwa instancji',
		'max-categories' => 'Maksymalna liczba kategorii na użytkownika',
		'max-feeds' => 'Maksymalna liczba kanałów na użytkownika',
		'registration' => [
			'number' => 'Maksymalna liczba kont',
			'select' => [
				'label' => 'Formularz tworzenia konta',
				'option' => [
					'noform' => 'Wyłączony: formularz niedostępny',
					'nolimit' => 'Włączony: brak limitu liczby kont',
					'setaccountsnumber' => 'Ustaw limit liczby kont',
				],
			],
			'status' => [
				'disabled' => 'Formularz wyłączony',
				'enabled' => 'Formularz włączony',
			],
			'title' => 'Formularz rejestracji użytkowników',
		],
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => [
			'disabled' => 'is not given',	// TODO
			'enabled' => '<a href="./?a=tos">is enabled</a>',	// TODO
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">enable the Terms of Service</a>',	// TODO
		],
		'websub' => [
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		],
	],
	'update' => [
		'_' => 'Aktualizacja',
		'apply' => 'Zastosuj',
		'changelog' => 'Changelog',	// TODO
		'check' => 'Szukaj uaktualnień',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => 'Używana wersja',
		'last' => 'Ostatnie sprawdzenie',
		'loading' => 'Updating…',	// TODO
		'none' => 'Brak nowych aktualizacji',
		'releaseChannel' => [
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		],
		'title' => 'Aktualizacja',
		'viaGit' => 'Update via git and Github.com started',	// TODO
	],
	'user' => [
		'admin' => 'Administrator',	// IGNORE
		'article_count' => 'Liczba wiadomości',
		'back_to_manage' => '← Powrót do listy użytkowników',
		'create' => 'Dodaj nowego użytkownika',
		'database_size' => 'Rozmiar bazy danych',
		'email' => 'Adres e-mail',
		'enabled' => 'Aktywne',
		'feed_count' => 'Kanały',
		'is_admin' => 'Administrator',
		'language' => 'Język',
		'last_user_activity' => 'Ostatnia aktywność',
		'list' => 'Lista użytkowników',
		'number' => 'Liczba aktywnych kont: %d',
		'numbers' => 'Liczba aktywnych kont: %d',
		'password_form' => 'Hasło<br /><small>(dla logowania przez formularz na stronie)</small>',
		'password_format' => 'Przynajmniej 7 znaków',
		'title' => 'Zarządzanie użytkownikami',
		'username' => 'Nazwa użytkownika',
	],
];

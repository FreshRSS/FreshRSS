<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Pozwól na anonimowy odczyt wiadomości domyślnego użytkownika (%s)',
		'allow_anonymous_refresh' => 'Pozwól na anonimowe odświeżanie wiadomości',
		'api_enabled' => 'Pozwól na dostęp przez <abbr>API</abbr> <small>(wymagane dla aplikacji na telefon)</small>',
		'form' => 'Formularz na stronie (tradycyjna, wymagany JavaScript)',
		'http' => 'HTTP (dla zaawansowanych użytkowników, z wykorzystaniem HTTPS)',
		'none' => 'Brak (niebezpieczna)',
		'title' => 'Uwierzytelnianie',
		'token' => 'Token uwierzytelniania',
		'token_help' => 'Pozwala na dostęp do treści RSS domyślnego użytkownika bez uwierzytelnienia:',
		'type' => 'Metoda uwierzytelniania',
		'unsafe_autologin' => 'Pozwól na niebezpieczne automatyczne logowanie następującym schematem:	-> todo',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Check permissions on <em>./data/cache</em> directory. HTTP server must have write permission.',	// TODO - Translation
			'ok' => 'Permissions on the cache directory are good.',	// TODO - Translation
		),
		'categories' => array(
			'nok' => 'Category table is improperly configured.',	// TODO - Translation
			'ok' => 'Category table is okay.',	// TODO - Translation
		),
		'connection' => array(
			'nok' => 'Connection to the database cannot be established.',	// TODO - Translation
			'ok' => 'Connection to the database is okay.',	// TODO - Translation
		),
		'ctype' => array(
			'nok' => 'Cannot find a required library for character type checking (php-ctype).',	// TODO - Translation
			'ok' => 'You have the required library for character type checking (ctype).',	// TODO - Translation
		),
		'curl' => array(
			'nok' => 'Cannot find the cURL library (php-curl package).',	// TODO - Translation
			'ok' => 'You have the cURL library.',	// TODO - Translation
		),
		'data' => array(
			'nok' => 'Check permissions on <em>./data</em> directory. HTTP server must have write permission.',	// TODO - Translation
			'ok' => 'Permissions on the data directory are good.',	// TODO - Translation
		),
		'database' => 'Database installation',	// TODO - Translation
		'dom' => array(
			'nok' => 'Cannot find a required library to browse the DOM (php-xml package).',	// TODO - Translation
			'ok' => 'You have the required library to browse the DOM.',	// TODO - Translation
		),
		'entries' => array(
			'nok' => 'Entry table is improperly configured.',	// TODO - Translation
			'ok' => 'Entry table is okay.',	// TODO - Translation
		),
		'favicons' => array(
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have write permission.',	// TODO - Translation
			'ok' => 'Permissions on the favicons directory are good.',	// TODO - Translation
		),
		'feeds' => array(
			'nok' => 'Feed table is improperly configured.',	// TODO - Translation
			'ok' => 'Feed table is okay.',	// TODO - Translation
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// TODO - Translation
			'ok' => 'You have the fileinfo library.',	// TODO - Translation
		),
		'files' => 'File installation',	// TODO - Translation
		'json' => array(
			'nok' => 'Cannot find JSON (php-json package).',	// TODO - Translation
			'ok' => 'You have the JSON extension.',	// TODO - Translation
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended mbstring library for Unicode.',	// TODO - Translation
			'ok' => 'You have the recommended mbstring library for Unicode.',	// TODO - Translation
		),
		'pcre' => array(
			'nok' => 'Cannot find a required library for regular expressions (php-pcre).',	// TODO - Translation
			'ok' => 'You have the required library for regular expressions (PCRE).',	// TODO - Translation
		),
		'pdo' => array(
			'nok' => 'Cannot find PDO or one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO - Translation
			'ok' => 'You have PDO and at least one of the supported drivers (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO - Translation
		),
		'php' => array(
			'_' => 'PHP installation',	// TODO - Translation
			'nok' => 'Your PHP version is %s but FreshRSS requires at least version %s.',	// TODO - Translation
			'ok' => 'Your PHP version (%s) is compatible with FreshRSS.',	// TODO - Translation
		),
		'tables' => array(
			'nok' => 'There are one or more missing tables in the database.',	// TODO - Translation
			'ok' => 'The appropriate tables exist in the database.',	// TODO - Translation
		),
		'title' => 'Installation check',	// TODO - Translation
		'tokens' => array(
			'nok' => 'Check permissions on <em>./data/tokens</em> directory. HTTP server must have write permission',	// TODO - Translation
			'ok' => 'Permissions on the tokens directory are good.',	// TODO - Translation
		),
		'users' => array(
			'nok' => 'Check permissions on <em>./data/users</em> directory. HTTP server must have write permission',	// TODO - Translation
			'ok' => 'Permissions on the users directory are good.',	// TODO - Translation
		),
		'zip' => array(
			'nok' => 'Cannot find the ZIP extension (php-zip package).',	// TODO - Translation
			'ok' => 'You have the ZIP extension.',	// TODO - Translation
		),
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Rozszerzenia stworzone przez społeczność',
		'description' => 'Opis',
		'disabled' => 'Disabled',	// TODO - Translation
		'empty_list' => 'There are no installed extensions',	// TODO - Translation
		'enabled' => 'Enabled',	// TODO - Translation
		'latest' => 'Zainstalowane',
		'name' => 'Nazwa',
		'no_configure_view' => 'To rozszerzenie nie jest konfigurowalne.',
		'system' => array(
			'_' => 'Rozszerzenia systemowe',
			'no_rights' => 'Rozszerzenie systemowe (brak uprawnień)',
		),
		'title' => 'Rozszerzenia',
		'update' => 'Update available',	// TODO - Translation
		'user' => 'Rozszerzenia użytkownika',
		'version' => 'Wersja',
	),
	'stats' => array(
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
		'percent_of_total' => '%% wszystkich',
		'repartition' => 'Podział wiadomości',
		'status_favorites' => 'Ulubione',
		'status_read' => 'Przeczytane',
		'status_total' => 'Wszystkie',
		'status_unread' => 'Nieprzeczytane',
		'title' => 'Statystyki',
		'top_feed' => '10 największych kanałów',
	),
	'system' => array(
		'_' => 'Konfiguracja serwisu',
		'auto-update-url' => 'Adres serwera automatycznej aktualizacji',
		'cookie-duration' => array(
			'help' => 'w sekundach',
			'number' => 'Czas przez który użytkownik pozostanie zalogowany',
		),
		'force_email_validation' => 'Wymuś weryfikację adresu e-mail',
		'instance-name' => 'Nazwa instancji',
		'max-categories' => 'Maksymalna liczba kategorii na użytkownika',
		'max-feeds' => 'Maksymalna liczba kanałów na użytkownika',
		'registration' => array(
			'help' => '0 oznacza brak limitu liczby kont',
			'number' => 'Maksymalna liczba kont',
			'select' => array(
				'label' => 'Registration form',	// TODO - Translation
				'option' => array(
					'noform' => 'Disabled: No registration form',	// TODO - Translation
					'nolimit' => 'Enabled: No limit of accounts',	// TODO - Translation
					'setaccountsnumber' => 'Set max. number of accounts',	// TODO - Translation
				),
			),
			'status' => array(
				'disabled' => 'Form disabled',	// TODO - Translation
				'enabled' => 'Form enabled',	// TODO - Translation
			),
			'title' => 'User registration form',	// TODO - Translation
		),
	),
	'update' => array(
		'_' => 'Aktualizacja',
		'apply' => 'Zastosuj',
		'check' => 'Szukaj uaktualnień',
		'current_version' => 'Używana wersja FreshRSS to %s.',
		'last' => 'Ostatnie sprawdzenie: %s',
		'none' => 'Brak nowych aktualizacji',
		'title' => 'Aktualizacja',
	),
	'user' => array(
		'admin' => 'Administrator',
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
	),
);

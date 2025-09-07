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
		'allow_anonymous' => 'Pozwól na anonimowy odczyt wiadomości domyślnego użytkownika (%s)',
		'allow_anonymous_refresh' => 'Pozwól na anonimowe odświeżanie wiadomości',
		'api_enabled' => 'Pozwól na dostęp przez <abbr>API</abbr> <small>(wymagane dla aplikacji na telefon i udostępniania zapytań użytkownika)</small>',
		'form' => 'Formularz na stronie (tradycyjna, wymagany JavaScript)',
		'http' => 'HTTP (zaawansowane: zarządzane przez serwer WWW, OIDC, SSO…)',
		'none' => 'Brak (niebezpieczna)',
		'title' => 'Uwierzytelnianie',
		'token' => 'Główny token uwierzytelniania',
		'token_help' => 'Umożliwia dostęp do wszystkich kanałów RSS użytkownika, jak również odświeżanie kanałów bez uwierzytelnienia:',
		'type' => 'Metoda uwierzytelniania',
		'unsafe_autologin' => 'Pozwól na niebezpieczne automatyczne logowanie następującym schematem: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Sprawdz uprawnienia dla katalogu <em>./data/cache</em>. Serwer WWW musi miec uprawnienia do zapisu.',
			'ok' => 'Uprawnienia dla katalogu pamięci podręcznej się zgadzają.',
		),
		'categories' => array(
			'nok' => 'Tabela kategorii jest nieprawidłowo skonfigurowana.',
			'ok' => 'Tabela kategorii jest OK.',
		),
		'connection' => array(
			'nok' => 'Nie udało się połączyć z bazą danych.',
			'ok' => 'Połączenie z bazą danych się powiodło.',
		),
		'ctype' => array(
			'nok' => 'Nie znaleziono wymaganej biblioteki do sprawdzania rodzajów znaków (php-ctype).',
			'ok' => 'Znaleziono wymaganą bibliotekę do sprawdzania rodzajów znaków (ctype).',
		),
		'curl' => array(
			'nok' => 'Nie znaleziono biblioteki cURL (paczka php-curl).',
			'ok' => 'Znaleziono bibliotekę cURL.',
		),
		'data' => array(
			'nok' => 'Sprawdź uprawnienia dla katalogu <em>./data</em>. Użytkownik serwera WWW musi mieć uprawnienia do zapisu.',
			'ok' => 'Uprawienia dla katalogu danych się zgadzają.',
		),
		'database' => 'Instalacja bazy danych',
		'dom' => array(
			'nok' => 'Nie znaleziono wymaganej biblioteki do korzystania z DOM-u (paczka php-xml).',
			'ok' => 'Znaleziono wymaganą bibliotekę do korzystania z DOM-u.',
		),
		'entries' => array(
			'nok' => 'Tabela wpisów jest nieprawidłowo skonfigurowana.',
			'ok' => 'Tabela wpisów jest OK.',
		),
		'favicons' => array(
			'nok' => 'Sprawdź uprawnienia dla katalogu <em>./data/favicons</em>. Użytkownik serwera WWW musi mieć uprawnienia do zapisu.',
			'ok' => 'Uprawnienia dla katalogu ikonek kanałów się zgadzają.',
		),
		'feeds' => array(
			'nok' => 'Tabela kanałów jest nieprawidłowo skonfigurowana.',
			'ok' => 'Tabela kanałów jest OK.',
		),
		'fileinfo' => array(
			'nok' => 'Nie znaleziono biblioteki fileinfo dla PHP (paczka fileinfo).',
			'ok' => 'Znaleziono bibliotekę fileinfo.',
		),
		'files' => 'Instalacja plików',
		'json' => array(
			'nok' => 'Nie znaleziono biblioteki do przetwarzania JSON-a.',
			'ok' => 'Znaleziono bibliotekę do przetwarzania JSON-a.',
		),
		'mbstring' => array(
			'nok' => 'Nie znaleziono wymaganej biblioteki mbstring do obsługi Unicode.',
			'ok' => 'Znaleziono wymaganą bibliotekę mbstring do obsługi Unicode.',
		),
		'pcre' => array(
			'nok' => 'Nie znaleziono wymaganej biblioteki do obsługi wyrażeń regularnych (php-pcre).',
			'ok' => 'Znaleziono wymaganą bibliotekę do obsługi wyrażeń regularnych (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Nie znaleziono PDO ani żadnego wspieranego sterownika bazy danych (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Znaleziono PDO oraz przynajmniej jeden z wspieranych sterowników bazy danych (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'Instalacja PHP',
			'nok' => 'Twoja wersja PHP to %s, lecz FreshRSS wymaga co najmniej wersji %s.',
			'ok' => 'Twoja wersja PHP (%s) jest kompatybilna z FreshRSS.',
		),
		'tables' => array(
			'nok' => 'W bazie danych brakuje jednej bądź więcej wymaganych tabeli.',
			'ok' => 'Odpowiednie tabele znajdują się w bazie danych.',
		),
		'title' => 'Weryfikacja instalacji',
		'tokens' => array(
			'nok' => 'Sprawdź uprawnienia dla katalogu <em>./data/tokens</em>. Użytkownik serwera WWW musi mieć uprawnienia do zapisu.',
			'ok' => 'Uprawnienia dla katalogu tokenów się zgadzają.',
		),
		'users' => array(
			'nok' => 'Sprawdź uprawnienia dla katalogu <em>./data/users</em>. Użytkownik serwera WWW musi mieć uprawnienia do zapisu.',
			'ok' => 'Uprawnienia dla katalogu użytkownika się zgadzają.',
		),
		'zip' => array(
			'nok' => 'Nie znaleziono rozszerzenia ZIP (paczka php-zip).',
			'ok' => 'Znaleziono rozszerzenie ZIP.',
		),
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Rozszerzenia stworzone przez społeczność',
		'description' => 'Opis',
		'disabled' => 'Wyłączone',
		'empty_list' => 'Brak zainstalowanych rozszerzeń',
		'empty_list_help' => 'Sprawdź dziennik, aby ustalić powód pustej listy rozszerzeń.',
		'enabled' => 'Włączone',
		'latest' => 'Zainstalowane',
		'name' => 'Nazwa',
		'no_configure_view' => 'To rozszerzenie nie jest konfigurowalne.',
		'system' => array(
			'_' => 'Rozszerzenia systemowe',
			'no_rights' => 'Rozszerzenie systemowe (brak uprawnień)',
		),
		'title' => 'Rozszerzenia',
		'update' => 'Dostępna jest aktualizacja',
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
		'overview' => 'Podsumowanie',
		'percent_of_total' => '% wszystkich',
		'repartition' => 'Podział wiadomości: %s',
		'status_favorites' => 'Ulubione',
		'status_read' => 'Przeczytane',
		'status_total' => 'Wszystkie',
		'status_unread' => 'Nieprzeczytane',
		'title' => 'Statystyki',
		'top_feed' => '10 największych kanałów',
	),
	'system' => array(
		'_' => 'Konfiguracja serwera',
		'auto-update-url' => 'Adres serwera aktualizacji',
		'base-url' => array(
			'_' => 'Baza URL-a',
			'recommendation' => 'Automatyczne zalecenie: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => 'w sekundach',
			'number' => 'Czas przez który użytkownik pozostanie zalogowany',
		),
		'force_email_validation' => 'Wymuś weryfikację adresu e-mail',
		'instance-name' => 'Nazwa instancji',
		'max-categories' => 'Maksymalna liczba kategorii na użytkownika',
		'max-feeds' => 'Maksymalna liczba kanałów na użytkownika',
		'registration' => array(
			'number' => 'Maksymalna liczba kont',
			'select' => array(
				'label' => 'Formularz tworzenia konta',
				'option' => array(
					'noform' => 'Wyłączony: formularz niedostępny',
					'nolimit' => 'Włączony: brak limitu liczby kont',
					'setaccountsnumber' => 'Ustaw limit liczby kont',
				),
			),
			'status' => array(
				'disabled' => 'Formularz wyłączony',
				'enabled' => 'Formularz włączony',
			),
			'title' => 'Formularz rejestracji użytkowników',
		),
		'sensitive-parameter' => 'Czuły parametr. Należy go ustawić ręcznie w <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'nie zostały ustalone',
			'enabled' => '<a href="./?a=tos">włączone</a>',
			'help' => 'zobacz, jak utworzyć <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">warunki użytkowania</a>',
		),
		'websub' => array(
			'help' => 'O protokole <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => 'Aktualizacja',
		'apply' => 'Zastosuj',
		'changelog' => 'lista zmian',
		'check' => 'Szukaj uaktualnień',
		'copiedFromURL' => 'update.php skopiowany z %s do ./data',
		'current_version' => 'Aktualna wersja',
		'last' => 'Ostatnie sprawdzenie',
		'loading' => 'Aktualizowanie…',
		'none' => 'Brak nowych aktualizacji',
		'releaseChannel' => array(
			'_' => 'Kanał aktualizacji',
			'edge' => 'Wersja rozwojowa (“edge”)',
			'latest' => 'Wersja stabilna (“latest”)',
		),
		'title' => 'Aktualizacja',
		'viaGit' => 'Rozpoczęto aktualizację gitem do najnowszej wersji z GitHuba',
	),
	'user' => array(
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
		'password_form' => 'Hasło<br /><small>(do logowania przez formularz na stronie)</small>',
		'password_format' => 'przynajmniej 7 znaków',
		'title' => 'Zarządzanie użytkownikami',
		'username' => 'Nazwa użytkownika',
	),
);

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
	),
	'extensions' => array(
		'author' => 'Autor',
		'community' => 'Rozszerzenia stworzone przez społeczność',
		'description' => 'Opis',
		'disabled' => 'Wyłączone',
		'empty_list' => 'Brak zainstalowanych rozszerzeń',
		'empty_list_help' => 'Sprawdź dziennik, aby ustalić powód pustej listy rozszerzeń.',
		'enabled' => 'Włączone',
		'is_compatible' => 'Jest kompatybilne',
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
		'date_published' => 'Data publikacji',
		'date_received' => 'Data otrzymania',
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
		'nb_unreads' => 'Ilość nieprzeczytanych artykułów',
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
		'unread_dates' => 'Daty z największą ilością nieprzeczytanych artykułów',
	),
	'system' => array(
		'_' => 'Konfiguracja serwera',
		'auto-update-url' => 'Adres serwera aktualizacji',
		'base-url' => array(
			'_' => 'Baza URL-a',
			'recommendation' => 'Automatyczne zalecenie: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => 'w sekundach',
			'number' => 'Czas przez który użytkownik pozostanie zalogowany',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
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

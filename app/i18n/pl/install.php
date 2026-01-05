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
	'action' => array(
		'finish' => 'Zakończ instalację',
		'fix_errors_before' => 'Proszę naprawić wszystkie błędy przed przystąpieniem do kolejnego kroku.',
		'keep_install' => 'Zachowaj poprzednią konfigurację',
		'next_step' => 'Przejdź do następnego kroku',
		'reinstall' => 'Przeinstaluj FreshRSS',
	),
	'bdd' => array(
		'_' => 'Nazwa bazy danych',
		'conf' => array(
			'_' => 'Konfiguracja bazy danych',
			'ko' => 'Sprawdź swoją konfigurację bazy danych.',
			'ok' => 'Konfiguracja bazy danych została zapisana.',
		),
		'host' => 'Host',	// IGNORE
		'password' => 'Hasło',
		'prefix' => 'Prefiks tabeli',
		'type' => 'Rodzaj bazy danych',
		'username' => 'Nazwa użytkownika',
	),
	'check' => array(
		'_' => 'Weryfikacja instalacji',
		'already_installed' => 'Wykryto że FreshRSS jest już zainstalowany!',
		'cache' => array(
			'nok' => 'Sprawdź uprawnienia użytkownika <em>%2$s</em> dla katalogu <em>%1$s</em>. Użytkownik serwera WWW musi mieć uprawnienia do zapisu.',
			'ok' => 'Uprawnienia dla katalogu pamięci podręcznej się zgadzają.',
		),
		'ctype' => array(
			'nok' => 'Nie znaleziono wymaganej biblioteki do sprawdzania rodzajów znaków (php-ctype).',
			'ok' => 'Znaleziono wymaganą bibliotekę do sprawdzania rodzajów znaków (ctype).',
		),
		'curl' => array(
			'nok' => 'Nie znaleziono biblioteki cURL (php-curl package).',
			'ok' => 'Znaleziono bibliotekę cURL.',
		),
		'data' => array(
			'nok' => 'Sprawdź uprawnienia użytkownika <em>%2$s</em> dla katalogu <em>%1$s</em>. Użytkownik serwera WWW musi mieć uprawnienia do zapisu.',
			'ok' => 'Uprawnienia dla katalogu danych się zgadzają.',
		),
		'dom' => array(
			'nok' => 'Nie znaleziono wymaganej biblioteki do korzystania z DOM-u.',
			'ok' => 'Znaleziono wymaganą bibliotekę do korzystania z DOM-u.',
		),
		'favicons' => array(
			'nok' => 'Sprawdź uprawnienia użytkownika <em>%2$s</em> dla katalogu <em>%1$s</em>. Użytkownik serwera WWW musi mieć uprawnienia do zapisu.',
			'ok' => 'Uprawnienia dla katalogu ikonek kanałów się zgadzają.',
		),
		'fileinfo' => array(
			'nok' => 'Nie znaleziono biblioteki fileinfo dla PHP (paczka fileinfo).',
			'ok' => 'Znaleziono bibliotekę fileinfo.',
		),
		'files' => 'Instalacja plików',
		'intl' => array(
			'nok' => 'Nie znaleziono zalecanej biblioteki php-intl do internacjonalizacji.',
			'ok' => 'Znaleziono zalecaną bibliotekę php-intl do internacjonalizacji.',
		),
		'json' => array(
			'nok' => 'Nie znaleziono zalecanej biblioteki do przetwarzania JSON-a.',
			'ok' => 'Znaleziono zalecaną bibliotekę do przetwarzania JSON-a.',
		),
		'mbstring' => array(
			'nok' => 'Nie znaleziono zalecanej biblioteki mbstring do obsługi Unicode.',
			'ok' => 'Znaleziono zalecaną bibliotekę mbstring do obsługi Unicode.',
		),
		'pcre' => array(
			'nok' => 'Nie znaleziono wymaganej biblioteki do obsługi wyrażeń regularnych (php-pcre).',
			'ok' => 'Znaleziono wymaganą bibliotekę do obsługi wyrażeń regularnych (PCRE).',
		),
		'pdo-mysql' => array(
			'nok' => 'Nie znaleziono wymaganego sterownika PDO dla MySQL/MariaDB.',
		),
		'pdo-pgsql' => array(
			'nok' => 'Nie znaleziono wymaganego sterownika PDO dla PostgreSQL.',
		),
		'pdo-sqlite' => array(
			'nok' => 'Nie znaleziono sterownika PDO dla SQLite.',
			'ok' => 'Znaleziono sterownik PDO dla SQLite.',
		),
		'pdo' => array(
			'nok' => 'Nie znaleziono PDO ani żadnego wspieranego sterownika bazy danych (pdo_sqlite, pdo_pgsql, pdo_mysql).',
			'ok' => 'Znaleziono PDO oraz przynajmniej jeden z wspieranych sterowników bazy danych (pdo_sqlite, pdo_pgsql, pdo_mysql).',
		),
		'php' => array(
			'_' => 'Instalacja PHP',
			'nok' => 'Twoja wersja PHP to %s, lecz FreshRSS wymaga co najmniej wersji %s.',
			'ok' => 'Twoja wersja PHP (%s) jest kompatybilna z FreshRSS.',
		),
		'reload' => 'Sprawdź ponownie',
		'tmp' => array(
			'nok' => 'Sprawdź uprawnienia użytkownika <em>%2$s</em> dla katalogu <em>%1$s</em>. Użytkownik serwera WWW musi mieć uprawnienia do zapisu.',
			'ok' => 'Uprawienia dla katalogu plików tymczasowych się zgadzają.',
		),
		'tokens' => array(
			'nok' => 'Sprawdź uprawnienia dla katalogu <em>./data/tokens</em>. Użytkownik serwera WWW musi mieć uprawnienia do zapisu.',
			'ok' => 'Uprawnienia dla katalogu tokenów się zgadzają.',
		),
		'unknown_process_username' => 'nieznany',
		'users' => array(
			'nok' => 'Sprawdź uprawnienia użytkownika <em>%2$s</em> dla katalogu <em>%1$s</em>. Użytkownik serwera WWW musi mieć uprawnienia do zapisu.',
			'ok' => 'Uprawnienia dla katalogu użytkowników się zgadzają.',
		),
		'xml' => array(
			'nok' => 'Nie znaleziono wymaganej biblioteki do przetwarzania XML-a.',
			'ok' => 'Znaleziono wymaganą bibliotekę do przetwarzania XML-a.',
		),
		'zip' => array(
			'nok' => 'Nie znaleziono rozszerzenia ZIP (paczka php-zip).',
			'ok' => 'Znaleziono rozszerzenie ZIP.',
		),
	),
	'conf' => array(
		'_' => 'Dalsza konfiguracja',
		'ok' => 'Główna konfiguracja została zapisana.',
	),
	'congratulations' => 'Gratulacje!',
	'default_user' => array(
		'_' => 'Nazwa domyślnego użytkownika',
		'max_char' => 'maksymalnie 16 znaków alfanumerycznych',
	),
	'fix_errors_before' => 'Proszę naprawić wszystkie błędy przed przystąpieniem do kolejnego kroku.',
	'javascript_is_better' => 'FreshRSS działa lepiej z włączonym JavaScript-em',
	'js' => array(
		'confirm_reinstall' => 'Stracisz swoją poprzednią konfigurację poprzez przeinstalację FreshRSS. Czy jesteś pewien, że chcesz kontynuowac?',
	),
	'language' => array(
		'_' => 'Język',
		'choose' => 'Wybierz język dla FreshRSS',
		'defined' => 'Język został wybrany.',
	),
	'missing_applied_migrations' => 'Coś poszło nie tak. Powinieneś stworzyć pusty plik o nazwie <em>%s</em> ręcznie.',
	'ok' => 'Instalacja przebiegła pomyślnie.',
	'session' => array(
		'nok' => 'Wygląda na to, że serwer WWW jest nieprawidłowo skonfigurowany do obsługi ciasteczek dla sesji PHP!',
	),
	'step' => 'krok %d',
	'steps' => 'Kroki',
	'this_is_the_end' => 'Koniec',
	'title' => 'Instalacja · FreshRSS',
);

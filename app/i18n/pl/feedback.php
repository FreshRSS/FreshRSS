<?php

return array(
	'access' => array(
		'denied' => 'Nie masz uprawnień dostępu do tej strony',
		'not_found' => 'Strona którą chcesz otworzyć nie istnieje',
	),
	'admin' => array(
		'optimization_complete' => 'Optymizacja ukończona',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Nie można zmienić hasła',
			'updated' => 'Hasło zostało zmienione',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Niepoprawne dane logowania',
			'success' => 'Zalogowałeś się',
		),
		'logout' => array(
			'success' => 'Zostałeś wylogowany',
		),
	),
	'conf' => array(
		'error' => 'Podczas zapisywania konfiguracji wystąpił błąd',
		'query_created' => 'Zapytanie "%s" zostało utworzone.',
		'shortcuts_updated' => 'Skróty zostały zaktualizowane',
		'updated' => 'Ustawienia zostały zaktualizowane',
	),
	'extensions' => array(
		'already_enabled' => 'Rozszerzenie %s jest już włączone',
		'cannot_remove' => 'Rozszerzenie %s nie może zostać usunięte',
		'disable' => array(
			'ko' => 'Rozszerzenie %s nie może zostać wyłączone. <a href="%s">Sprawdź dziennik</a> w celu uzyskania szczegółowych informacji.',
			'ok' => 'Rozszerzenie %s zostało wyłączone',
		),
		'enable' => array(
			'ko' => 'Rozszerzenie %s nie może zostać włączone. <a href="%s">Sprawdź dziennik</a> w celu uzyskania szczegółowych informacji.',
			'ok' => 'Rozszerzenie %s zostało włączone',
		),
		'no_access' => 'Brak dostępu do %s',
		'not_enabled' => 'Rozszerzenie %s nie jest włączone',
		'not_found' => 'Rozszerzenie %s nie istnieje',
		'removed' => 'Rozszerzenie %s zostało usunięte',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'Rozszerzenie ZIP nie jest dostępne na serwerze. Spróbuj eksportować pliki pojedynczo.',
		'feeds_imported' => 'Kanały zostały zaimportowane i zostaną teraz zaktualizowane',
		'feeds_imported_with_errors' => 'Kanały zostały zaimportowane, jednakże wystąpiło kilka błędów',
		'file_cannot_be_uploaded' => 'Plik nie może zostać wgrany!',
		'no_zip_extension' => 'Rozszerzenie ZIP nie jest dostępne na serwerze.',
		'zip_error' => 'Wystąpił błąd podczas importu pliku ZIP.',
	),
	'profile' => array(
		'error' => 'Nie można modyfikować profilu',
		'updated' => 'Profil został zmodyfikowany',
	),
	'sub' => array(
		'actualize' => 'Aktualizacja',
		'articles' => array(
			'marked_read' => 'Wiadomości zostały oznaczone jako przeczytane.',
			'marked_unread' => 'Wiadomości zostały oznaczone jako nieprzeczytane.',
		),
		'category' => array(
			'created' => 'Stworzono kategorię %s.',
			'deleted' => 'Usunięto kategorię.',
			'emptied' => 'Kategoria jest pusta',
			'error' => 'Nie można zaktualizować kategorii',
			'name_exists' => 'Nazwa kategorii już istnieje.',
			'no_id' => 'Należy podać identyfikator kategorii.',
			'no_name' => 'Nazwa kategorii nie może być pusta.',
			'not_delete_default' => 'Nie wolno usunąć domyślnej kategorii!',
			'not_exist' => 'Kategoria nie istnieje!',
			'over_max' => 'Osiągnięto ustawiony limit kategorii (%d)',
			'updated' => 'Zaktualizowano kategorię.',
		),
		'feed' => array(
			'actualized' => 'Zaktualizowano kanał <em>%s</em>',
			'actualizeds' => 'Kanały RSS zostały zaktualizowane',
			'added' => 'Kanał RSS <em>%s</em> został dodany',
			'already_subscribed' => 'Kanał <em>%s</em> znajduje się już na liście subskrybowanych kanałów',
			'cache_cleared' => 'Cache kanału <em>%s</em> zostało wyczyszczone',
			'deleted' => 'Kanał został usunięty',
			'error' => 'Nie można zaktualizować kanału',
			'internal_problem' => 'Wystąpił błąd podczas dodawania kanału. <a href="%s">Sprawdź dziennik</a> w celu uzyskania szczegółowych informacji. Można spróbować wymusić dodanie kanału przez dodanie <code>#force_feed</code> na końcu adresu URL.',
			'invalid_url' => 'Adres URL <em>%s</em> nie jest prawidłowy',
			'n_actualized' => 'Liczba zaktualizowanych kanałów: %d',
			'n_entries_deleted' => 'Liczba usuniętych wiadomości: %d',
			'no_refresh' => 'Brak kanałó do odświeżenia',
			'not_added' => 'Kanał <em>%s</em> nie mógł zostać dodany',
			'not_found' => 'Kanał nie może zostać znaleziony',
			'over_max' => 'Osiągnięto ustawiony limit kanałów (%d)',
			'reloaded' => 'Kanał <em>%s</em> został przeładowany',
			'selector_preview' => array(
				'http_error' => 'Nie udało się załadować zawartości strony.',
				'no_entries' => 'Nie ma wiadomości na tym kanale. Potrzeba przynajmniej jednej wiadomości aby podgląd był dostępny.',
				'no_feed' => 'Błąd wewnętrzny (kanał nie został odnaleziony).',
				'no_result' => 'Selektor nie pasuje do żadnego elementu. W zastępstwie zostanie pokazana pierwotna zawartość kanału.',
				'selector_empty' => 'Selektor jest pusty. Aby podgląd był dostępny selektor musi być zdefiniowany.',
			),
			'updated' => 'Ustawienia kanału zostały zaktualizowane',
		),
		'purge_completed' => 'Oczyszczanie ukończone (liczba skasowanych wiadomości: %d)',
	),
	'tag' => array(
		'created' => 'Etykieta "%s" została stworzona.',
		'name_exists' => 'Etykieta o podanej nazwie już istnieje.',
		'renamed' => 'Etykieta "%s" została zmieniona na "%s".',
	),
	'update' => array(
		'can_apply' => 'FreshRSS zostanie zaktualizowany do <strong>wersji %s</strong>.',
		'error' => 'Proces aktualizacji napotkał błąd: %s',
		'file_is_nok' => 'Nowa <strong>wersja %s</strong> jest dostępna, ale należy sprawdzić uprawnienia katalogu <em>%s</em>. Serwer HTTP musi mieć możliwość zapisu',
		'finished' => 'Aktualizacja ukończona!',
		'none' => 'Brak dostępnych aktualizacji',
		'server_not_found' => 'Serwer aktualizacji nie może zostać odnaleziony. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Stworzono konto użytkownika %s',
			'error' => 'Konto użytkownika %s nie może zostać stworzone',
		),
		'deleted' => array(
			'_' => 'Konto użytkownika %s zostało usunięte',
			'error' => 'Nie można usunąć konta użytkownika %s',
		),
		'updated' => array(
			'_' => 'Konto użytkownika %s zostało zaktualizowane',
			'error' => 'Konto użytkownika %s nie zostało zaktualizowane',
		),
	),
);

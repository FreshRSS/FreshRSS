<?php

return array(
	'add' => 'Dodawanie nowych kanałów i kategorii zostało przeniesione <a href=\'%s\'>tutaj</a>. Jest również dostępne w menu po lewej stronie, a także za pomocą ikony ✚ dostępnej na głównej stronie.',
	'api' => array(
		'documentation' => 'Skopiuj następujący URL, by wykorzystać go w zewnętrznym narzędziu.',
		'title' => 'API',
	),
	'bookmarklet' => array(
		'documentation' => 'Przeciągnij ten guzik na pasek zakładek, albo kliknij go prawym przyciskiem myszy i wybierz opcję dodania odnośnika do listy zakładek. Dzięki temu będziesz mógł kliknąć w guzik „Subskrybuj” na dowolnej stronie, którą będziesz chciał zasubskrybować.',
		'label' => 'Subskrybuj',
		'title' => 'Skryptozakładka',
	),
	'category' => array(
		'_' => 'Kategoria',
		'add' => 'Dodaj kategorię',
		'archiving' => 'Archiwizacja',
		'empty' => 'Pusta kategoria',
		'information' => 'Informacje',
		'position' => 'Miejsce wyświetlania',
		'position_help' => 'Kontrola porządku sortowania kategorii',
		'title' => 'Tytuł',
	),
	'feed' => array(
		'add' => 'Dodaj kanał',
		'advanced' => 'Zaawansowane',
		'archiving' => 'Archiwizacja',
		'auth' => array(
			'help' => 'Pozwala na dostęp do kanałów chronionych hasłem HTTP',
			'http' => 'HTTP Authentication',	// TODO - Translation
			'password' => 'Hasło HTTP',
			'username' => 'Użytkownik HTTP',
		),
		'clear_cache' => 'Zawsze czyść pamięć podręczną',
		'content_action' => array(
			'_' => 'Content action when fetching the article content',	// TODO - Translation
			'append' => 'Add after existing content',	// TODO - Translation
			'prepend' => 'Add before existing content',	// TODO - Translation
			'replace' => 'Replace existing content',	// TODO - Translation
		),
		'css_cookie' => 'Use Cookies when fetching the article content',	// TODO - Translation
		'css_cookie_help' => 'Example: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',	// TODO - Translation
		'css_help' => 'Pozwala na ograniczenie zawartości kanałów (uwaga, wymaga więcej czasu!)',
		'css_path' => 'Selektor CSS dla wiadomości na pierwotnej stronie',
		'description' => 'Opis',
		'empty' => 'Ten kanał jest pusty. Należy sprawdzić czy kanał w dalszym ciągu działa.',
		'error' => 'Napotkano problem podczas dostępu do tego kanału. Należy sprawdzić czy kanał jest zawsze dostępny, a następnie go odświeżyć.',
		'filteractions' => array(
			'_' => 'Akcje filtrowania',
			'help' => 'Jedno zapytanie na linię.',
		),
		'information' => 'Informacja',
		'keep_min' => 'Minimalna liczba wiadomości do do przechowywania',
		'maintenance' => array(
			'clear_cache' => 'Wyczyść pamięć podręczną',
			'clear_cache_help' => 'Czyści pamięć podręczną tego kanału.',
			'reload_articles' => 'Przeładuj wiadomości',
			'reload_articles_help' => 'Ponownie pobiera wiadomości i przetwarza treść ze strony pierwotnej, jeżeli zdefiniowany został selektor CSS.',
			'title' => 'Konserwacja',
		),
		'moved_category_deleted' => 'Po usunięciu kategorii znajdujące się w niej kanały zostaną automatycznie przeniesione do <em>%s</em>.',
		'mute' => 'wycisz',
		'no_selected' => 'No feed selected.',	// TODO - Translation
		'number_entries' => '%d wiadomości',
		'priority' => array(
			'_' => 'Widoczność',
			'archived' => 'Nie pokazuj (zarchiwizowany)',
			'main_stream' => 'Pokaż w kanale głównym',
			'normal' => 'Pokaż w kategorii kanału',
		),
		'proxy' => 'Set a proxy for fetching this feed',	// TODO - Translation
		'proxy_help' => 'Select a protocol (e.g: SOCKS5) and enter the proxy address (e.g: <kbd>127.0.0.1:1080</kbd>)',	// TODO - Translation
		'selector_preview' => array(
			'show_raw' => 'Pokaż źródło',
			'show_rendered' => 'Pokaż zawartość',
		),
		'show' => array(
			'all' => 'Pokaż wszystkie kanały',
			'error' => 'Pokaż tylko kanały z błędami',
		),
		'showing' => array(
			'error' => 'Wyświetlanie tylko kanałów z błędami',
		),
		'ssl_verify' => 'Weryfikuj bezpieczeństwo szyfrowania SSL',
		'stats' => 'Statystyki',
		'think_to_add' => 'Możesz dodać kilka kanałów.',
		'timeout' => 'Limit czasu, w sekundach',
		'title' => 'Tytuł',
		'title_add' => 'Dodaj kanał',
		'ttl' => 'Nie odświeżaj automatycznie częściej niż',
		'url' => 'Adres kanału',
		'useragent' => 'Set the user agent for fetching this feed',	// TODO - Translation
		'useragent_help' => 'Example: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',	// TODO - Translation
		'validator' => 'Sprawdź poprawność kanału',
		'website' => 'Adres strony',
		'websub' => 'Instant notification with WebSub',	// TODO - Translation
	),
	'firefox' => array(
		'documentation' => 'Wykonaj kroki opisane <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">tutaj</a>, by dodać FreshRSS do listy czytników kanałów w przeglądarce Firefox.',
		'obsolete_63' => 'Możliwość dodawania własnych serwisów subskrypcji kanałów, które nie są osobnymi programami, została usunięta w Firefoksie 63.',
		'title' => 'Czytnik kanałów w Firefoksie',
	),
	'import_export' => array(
		'export' => 'Eksport',
		'export_labelled' => 'Eksportuj wiadomości z etykietami',
		'export_opml' => 'Eksportuj listę kanałów (format OPML)',
		'export_starred' => 'Eksportuj ulubione wiadomości',
		'feed_list' => 'List of %s articles',	// TODO - Translation
		'file_to_import' => 'Plik do zaimportowania<br />(formaty OPML, JSON lub ZIP)',
		'file_to_import_no_zip' => 'Plik do zaimportowania<br />(OPML lub JSON)',
		'import' => 'Import',
		'starred_list' => 'List of favourite articles',	// TODO - Translation
		'title' => 'Import / eksport',
	),
	'menu' => array(
		'add' => 'Dodaj kanał lub kategorię',
		'add_feed' => 'Dodaj kanał',
		'bookmark' => 'Subscribe (FreshRSS bookmark)',	// TODO - Translation
		'import_export' => 'Import / eksport',
		'label_management' => 'Zarządzanie etykietami',
		'subscription_management' => 'Zarządzanie subskrypcjami',
		'subscription_tools' => 'Narzędzia subskrypcji',
	),
	'tag' => array(
		'name' => 'Nazwa',
		'new_name' => 'Nowa nazwa',
		'old_name' => 'Poprzednia nazwa',
	),
	'title' => array(
		'_' => 'Zarządzanie subskrypcjami',
		'add' => 'Dodaj kanał lub kategorię',
		'add_category' => 'Dodaj kategorię',
		'add_feed' => 'Dodaj kanał',
		'add_label' => 'Dodaj etykietę',
		'delete_label' => 'Usuń etykietę',
		'feed_management' => 'RSS feeds management',	// TODO - Translation
		'rename_label' => 'Zmień nazwę etykiety',
		'subscription_tools' => 'Narzędzia subskrypcji',
	),
);

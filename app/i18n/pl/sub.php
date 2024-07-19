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
	'api' => array(
		'documentation' => 'Skopiuj następujący URL, by wykorzystać go w zewnętrznym narzędziu.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Przeciągnij ten guzik na pasek zakładek, albo kliknij go prawym przyciskiem myszy i wybierz opcję dodania odnośnika do listy zakładek. Dzięki temu będziesz mógł kliknąć w guzik „Subskrybuj” na dowolnej stronie, którą będziesz chciał zasubskrybować.',
		'label' => 'Subskrybuj',
		'title' => 'Skryptozakładka',
	),
	'category' => array(
		'_' => 'Kategoria',
		'add' => 'Dodaj kategoria',
		'archiving' => 'Archiwizacja',
		'dynamic_opml' => array(
			'_' => 'Dynamiczny OPML',
			'help' => 'Podaj adres <a href="http://opml.org/" target="_blank">pliku OPML</a>, aby dynamicznie zapełnić tę kategorię kanałami',
		),
		'empty' => 'Pusta kategoria',
		'expand' => 'Expand category',	// TODO
		'information' => 'Informacje',
		'open' => 'Open category',	// TODO
		'opml_url' => 'Adres OPML',
		'position' => 'Miejsce wyświetlania',
		'position_help' => 'Kontrola porządku sortowania kategorii',
		'title' => 'Tytuł',
	),
	'feed' => array(
		'accept_cookies' => 'Akceptuj ciasteczka',
		'accept_cookies_help' => 'Pozwól serwerowi kanału na użycie ciasteczek (będą przechowywane w pamięci tylko na czas zapytania)',
		'add' => 'Dodaj kanał',
		'advanced' => 'Zaawansowane',
		'archiving' => 'Archiwizacja',
		'auth' => array(
			'configuration' => 'Uwierzytelnianie',
			'help' => 'Pozwala na dostęp do kanałów chronionych hasłem HTTP',
			'http' => 'Uwierzytelnienie HTTP',
			'password' => 'Hasło HTTP',
			'username' => 'Użytkownik HTTP',
		),
		'clear_cache' => 'Zawsze czyść pamięć podręczną',
		'content_action' => array(
			'_' => 'Sposób zachowania zawartości pobranej z pierwotnej strony',
			'append' => 'Umieść za treścią z kanału',
			'prepend' => 'Umieść przed treścią z kanału',
			'replace' => 'Zastąp treść z kanału',
		),
		'css_cookie' => 'Użyj plików cookie podczas pobierania wiadomości',
		'css_cookie_help' => 'Przykład: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Pozwala na ograniczenie zawartości kanałów (uwaga, wymaga więcej czasu!)',
		'css_path' => 'Selektor CSS dla wiadomości na pierwotnej stronie',
		'css_path_filter' => array(
			'_' => 'Selektor CSS elementów do usunięcia',
			'help' => 'Selector CSS może być listą, na przykład: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Opis',
		'empty' => 'Ten kanał jest pusty. Należy sprawdzić czy kanał w dalszym ciągu działa.',
		'error' => 'Napotkano problem podczas dostępu do tego kanału. Należy sprawdzić czy kanał jest zawsze dostępny, a następnie go odświeżyć.',
		'export-as-opml' => array(
			'download' => 'Pobierz',
			'help' => 'Plik XML (data subset. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">See documentation</a>)',	// DIRTY
			'label' => 'Eksportuj OPML',
		),
		'filteractions' => array(
			'_' => 'Akcje filtrowania',
			'help' => 'Jedno zapytanie na linię. Operatory opisane są w <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">dokumentacji</a>.',
		),
		'information' => 'Informacja',
		'keep_min' => 'Minimalna liczba wiadomości do do przechowywania',
		'kind' => array(
			'_' => 'Rodzaj źródła kanału',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// IGNORE
				'feed_title' => array(
					'_' => 'nazwy kanału',
					'help' => 'Przykład: <code>//title</code>, lub statyczny ciąg: <code>"Mój własny kanał"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> jest standardowym językiem zapytań przeznaczonym dla zaawansowanych użytkowników. FreshRSS wykorzystuje ten język aby wydobywać (scrape’ować) dane ze stron internetowych.',
				'item' => array(
					'_' => 'znajdowania <strong>poszczególnych</strong> wiadomości<br /><small>(najważniejsza opcja)</small>',
					'help' => 'Przykład: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'autora',
					'help' => 'Może również być statycznym ciągiem, na przykład: <code>"Gall Anonim"</code>',
				),
				'item_categories' => 'tagów wiadomości',
				'item_content' => array(
					'_' => 'zawartości',
					'help' => 'Następujące zapytanie uwzględni całą wiadomość: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'miniaturki',
					'help' => 'Przykład: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Własny format daty/czasu',
					'help' => 'Opcjonalne. Format wspierany przez <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, przykładowo <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'daty',
					'help' => 'Wynik zostanie przetworzony za pomocą funkcji <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'tytułu',
					'help' => 'W szczególności warto użyć <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">oś XPath</a> <code>descendant::</code>, na przykład: <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'unikalnego identyfikatora',
					'help' => 'Opcjonalne. Przykład: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'adresu (URL)',
					'help' => 'Przykład: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (względem wiadomości) dla:',
				'xpath' => 'XPath dla:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (dot notation)',	// IGNORE
				'feed_title' => array(
					'_' => 'Tytuł kanału',
					'help' => 'Przykład: <code>meta.title</code>, lub stały ciąg: <code>"Mój kanał"</code>',
				),
				'help' => 'JSON oddzielający obiekty kropkami i używający nawiasów kwadratowych dla tablic (na przykład <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'odnajdywanie <strong>wiadomości</strong><br /><small>(najważniejsze)</small>',
					'help' => 'Ścieżka w JSON-ie do tablicy zawierającej wiadomości, na przykład <code>newsItems</code>',
				),
				'item_author' => 'autor wiadomości',
				'item_categories' => 'tagi wiadomości',
				'item_content' => array(
					'_' => 'zawartość wiadomości',
					'help' => 'Klucz pod którym można znaleźć zawartość, przykładowo <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'miniaturka wiadomości',
					'help' => 'Przykład: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Własny format daty/czasu',
					'help' => 'Opcjonalne. Format wspierany przez <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, przykładowo <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'czas wiadomości',
					'help' => 'Wartość będzie przetwarzana funkcją <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'tytuł wiadomości',
				'item_uid' => 'unikalny identyfikator wiadomości',
				'item_uri' => array(
					'_' => 'adres URL wiadomości',
					'help' => 'Przykład: <code>permalink</code>',
				),
				'json' => 'ścieżka do:',
				'relative' => 'ścieżka do (względem wiadomości):',
			),
			'jsonfeed' => 'Kanał JSON',
			'rss' => 'RSS / Atom (domyślne)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Wyczyść pamięć podręczną',
			'clear_cache_help' => 'Czyści pamięć podręczną tego kanału.',
			'reload_articles' => 'Przeładuj wiadomości',
			'reload_articles_help' => 'Ponownie pobiera zdefiniowaną liczbę wiadomości i przetwarza treść ze strony pierwotnej, jeżeli zdefiniowany został selektor CSS.',
			'title' => 'Konserwacja',
		),
		'max_http_redir' => 'Limit przekierowań HTTP',
		'max_http_redir_help' => 'Ustaw na 0, albo pozostaw puste, by zabronić przekierowywania. Wartość -1 wyłącza limit.',
		'method' => array(
			'_' => 'Medoda HTTP',
		),
		'method_help' => 'Ładunek w POST automatycznie wspiera <code>application/x-www-form-urlencoded</code> oraz <code>application/json</code>',
		'method_postparams' => 'Ładunek w POST',
		'moved_category_deleted' => 'Po usunięciu kategorii znajdujące się w niej kanały zostaną automatycznie przeniesione do <em>%s</em>.',
		'mute' => array(
			'_' => 'wycisz',
			'state_is_muted' => 'This feed is muted',	// TODO
		),
		'no_selected' => 'Brak kanałów.',
		'number_entries' => '%d wiadomości',
		'open_feed' => 'Open feed %s',	// TODO
		'priority' => array(
			'_' => 'Widoczność',
			'archived' => 'Nie pokazuj (zarchiwizowany)',
			'category' => 'Pokaż w kategorii kanału',
			'important' => 'Pokaż w ważnych kanałach',
			'main_stream' => 'Pokaż w kanale głównym',
		),
		'proxy' => 'Użyj mechanizmu proxy podczas pobierania kanału',
		'proxy_help' => 'Wybierz protokół (np. SOCKS5) i podaj adres serwera proxy (np. <kbd>127.0.0.1:1080</kbd> lub <kbd>username:password@127.0.0.1:1080</kbd>)',
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
		'useragent' => 'Ciąg user agent używany podczas pobierania kanału',
		'useragent_help' => 'Przykład: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Sprawdź poprawność kanału',
		'website' => 'Adres strony',
		'websub' => 'Natychmiastowe powiadomienia protokołu WebSub',
	),
	'import_export' => array(
		'export' => 'Eksport',
		'export_labelled' => 'Eksportuj wiadomości z etykietami',
		'export_opml' => 'Eksportuj listę kanałów (format OPML)',
		'export_starred' => 'Eksportuj ulubione wiadomości',
		'feed_list' => 'Lista wiadomości z kanału %s',
		'file_to_import' => 'Plik do zaimportowania<br />(formaty OPML, JSON lub ZIP)',
		'file_to_import_no_zip' => 'Plik do zaimportowania<br />(OPML lub JSON)',
		'import' => 'Import',	// IGNORE
		'starred_list' => 'Lista ulubionych wiadomości',
		'title' => 'Import / eksport',
	),
	'menu' => array(
		'add' => 'Dodaj kanał lub kategorię',
		'import_export' => 'Import / eksport',
		'label_management' => 'Zarządzanie etykietami',
		'stats' => array(
			'idle' => 'Bezczynne kanały',
			'main' => 'Główne statystyki',
			'repartition' => 'Podział wiadomości',
		),
		'subscription_management' => 'Zarządzanie subskrypcjami',
		'subscription_tools' => 'Narzędzia subskrypcji',
	),
	'tag' => array(
		'auto_label' => 'Dodaj tę etykietę do nowych wiadomości',
		'name' => 'Nazwa',
		'new_name' => 'Nowa nazwa',
		'old_name' => 'Poprzednia nazwa',
	),
	'title' => array(
		'_' => 'Zarządzanie subskrypcjami',
		'add' => 'Dodaj kanał lub kategorię',
		'add_category' => 'Dodaj kategorię',
		'add_dynamic_opml' => 'Dodaj dynamiczny OPML',
		'add_feed' => 'Dodaj kanał',
		'add_label' => 'Dodaj etykietę',
		'delete_label' => 'Usuń etykietę',
		'feed_management' => 'Zarządzanie kanałami RSS',
		'rename_label' => 'Zmień nazwę etykiety',
		'subscription_tools' => 'Narzędzia subskrypcji',
	),
);

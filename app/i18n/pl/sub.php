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
		'description' => 'Opis',
		'empty' => 'Ten kanał jest pusty. Należy sprawdzić czy kanał w dalszym ciągu działa.',
		'error' => 'Napotkano problem podczas dostępu do tego kanału. Należy sprawdzić czy kanał jest zawsze dostępny, a następnie go odświeżyć.',
		'filteractions' => array(
			'_' => 'Akcje filtrowania',
			'help' => 'Jedno zapytanie na linię.',
		),
		'information' => 'Informacja',
		'keep_min' => 'Minimalna liczba wiadomości do do przechowywania',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>//title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'Example: <code>//div[@class="news-item"]</code>',	// TODO
				),
				'item_author' => array(
					'_' => 'item author',	// TODO
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',	// TODO
				),
				'item_categories' => 'items tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Example to take the full item: <code>.</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>descendant::img/@src</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => array(
					'_' => 'item title',	// TODO
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> like <code>descendant::h2</code>',	// TODO
				),
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>descendant::a/@href</code>',	// TODO
				),
				'relative' => 'XPath (relative to item) for:',	// TODO
				'xpath' => 'XPath for:',	// TODO
			),
			'rss' => 'RSS / Atom (default)',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'Wyczyść pamięć podręczną',
			'clear_cache_help' => 'Czyści pamięć podręczną tego kanału.',
			'reload_articles' => 'Przeładuj wiadomości',
			'reload_articles_help' => 'Ponownie pobiera wiadomości i przetwarza treść ze strony pierwotnej, jeżeli zdefiniowany został selektor CSS.',
			'title' => 'Konserwacja',
		),
		'moved_category_deleted' => 'Po usunięciu kategorii znajdujące się w niej kanały zostaną automatycznie przeniesione do <em>%s</em>.',
		'mute' => 'wycisz',
		'no_selected' => 'Brak kanałów.',
		'number_entries' => '%d wiadomości',
		'priority' => array(
			'_' => 'Widoczność',
			'archived' => 'Nie pokazuj (zarchiwizowany)',
			'main_stream' => 'Pokaż w kanale głównym',
			'normal' => 'Pokaż w kategorii kanału',
		),
		'proxy' => 'Użyj mechanizmu proxy podczas pobierania kanału',
		'proxy_help' => 'Wybierz protokół (np. SOCKS5) i podaj adres serwera proxy (np. <kbd>127.0.0.1:1080</kbd>)',
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
		'feed_management' => 'Zarządzanie kanałami RSS',
		'rename_label' => 'Zmień nazwę etykiety',
		'subscription_tools' => 'Narzędzia subskrypcji',
	),
);

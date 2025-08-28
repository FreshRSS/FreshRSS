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
	'action' => array(
		'actualize' => 'Aktualizuj kanały',
		'add' => 'Dodaj',
		'back_to_rss_feeds' => '← Wróć do subskrypcji',
		'cancel' => 'Anuluj',
		'close' => 'Zamknij',
		'create' => 'Utwórz',
		'delete_all_feeds' => 'Usuń wszystkie kanały',
		'delete_errored_feeds' => 'Usuń kanały z błędami',
		'delete_muted_feeds' => 'Usuń wyciszone kanały',
		'demote' => 'Zdegraduj',
		'disable' => 'Wyłącz',
		'download' => 'Pobierz',
		'empty' => 'Opróżnij',
		'enable' => 'Włącz',
		'export' => 'Eksportuj',
		'filter' => 'Filtruj',
		'import' => 'Importuj',
		'load_default_shortcuts' => 'Przywróć domyślne skróty',
		'manage' => 'Ustawienia',
		'mark_read' => 'Oznacz jako przeczytane',
		'menu' => array(
			'open' => 'Otwórz menu',
		),
		'nav_buttons' => array(
			'next' => 'Następny artykuł',
			'prev' => 'Poprzedni artykuł',
			'up' => 'Idź do góry',
		),
		'open_url' => 'Otwórz adres',
		'promote' => 'Awansuj',
		'purge' => 'Oczyść',
		'refresh_opml' => 'Odśwież OPML',
		'remove' => 'Usuń',
		'rename' => 'Zmień nazwę',
		'see_website' => 'Przejdź na stronę',
		'submit' => 'Zatwierdź',
		'truncate' => 'Usuń wszystkie wiadomości',
		'update' => 'Aktualizuj',
	),
	'auth' => array(
		'accept_tos' => 'Akceptuję <a href="%s">Warunki użytkowania</a>.',
		'email' => 'Adres e-mail',
		'keep_logged_in' => 'Nie pytaj ponownie o logowanie <small>(przez %s dni)</small>',
		'login' => 'Zaloguj się',
		'logout' => 'Wyloguj',
		'password' => array(
			'_' => 'Hasło',
			'format' => '<small>przynajmniej 7 znaków</small>',
		),
		'reauth' => array(
			'header' => 'Wymagane ponowne logowanie',
			'tip' => 'Nie będziesz proszony o ponowne logowanie przez <u>%d minut</u>',
			'title' => 'Ponowne logowanie',
		),
		'registration' => array(
			'_' => 'Tworzenie konta',
			'ask' => 'Nie masz konta?',
			'title' => 'Tworzenie konta',
		),
		'username' => array(
			'_' => 'Nazwa użytkownika',
			'format' => '<small>nie więcej niż 16 znaków alfanumerycznych</small>',
		),
	),
	'date' => array(
		'Apr' => '\\k\\w\\i\\e\\t\\n\\i\\a',
		'Aug' => '\\s\\i\\e\\r\\p\\n\\i\\a',
		'Dec' => '\\g\\r\\u\\d\\n\\i\\a',
		'Feb' => '\\l\\u\\t\\e\\g\\o',
		'Jan' => '\\s\\t\\y\\c\\z\\n\\i\\a',
		'Jul' => '\\l\\i\\p\\c\\a',
		'Jun' => '\\c\\z\\e\\r\\w\\c\\a',
		'Mar' => '\\m\\a\\r\\c\\a',
		'May' => '\\m\\a\\j\\a',
		'Nov' => '\\l\\i\\s\\t\\o\\p\\a\\d\\a',
		'Oct' => '\\p\\a\\ź\\d\\z\\i\\e\\r\\n\\i\\k\\a',
		'Sep' => '\\w\\r\\z\\e\\ś\\n\\i\\a',
		'apr' => 'Kwi',
		'april' => 'Kwiecień',
		'aug' => 'Sie',
		'august' => 'Sierpień',
		'before_yesterday' => 'Wcześniejsze',
		'dec' => 'Gru',
		'december' => 'Grudzień',
		'feb' => 'Lut',
		'february' => 'Luty',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y\\, H\\:i',	// IGNORE
		'fri' => 'Pt.',
		'jan' => 'Sty.',
		'january' => 'Styczeń',
		'jul' => 'Lip',
		'july' => 'Lipiec',
		'jun' => 'Cze',
		'june' => 'Czerwiec',
		'last_2_year' => 'Ostatnie dwa lata',
		'last_3_month' => 'Ostatnie trzy miesiące',
		'last_3_year' => 'Ostatnie trzy lata',
		'last_5_year' => 'Ostatnie pięć lat',
		'last_6_month' => 'Ostatnie sześć miesięcy',
		'last_month' => 'Ostatni miesiąc',
		'last_week' => 'Ostatni tydzień',
		'last_year' => 'Ostatni rok',
		'mar' => 'Mar',
		'march' => 'Marzec',
		'may' => 'Maj',
		'may_' => 'Maj',
		'mon' => 'Pon.',
		'month' => 'miesięcy',
		'nov' => 'Lis.',
		'november' => 'Listopad',
		'oct' => 'Paź',
		'october' => 'Październik',
		'sat' => 'Sob.',
		'sep' => 'Wrz',
		'september' => 'Wrzesień',
		'sun' => 'Niedz.',
		'thu' => 'Czw.',
		'today' => 'Dzisiejsze',
		'tue' => 'Wt.',
		'wed' => 'Śr.',
		'yesterday' => 'Wczorajsze',
	),
	'dir' => 'ltr',	// IGNORE
	'flag' => '🇵🇱',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'O oprogramowaniu FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Pusta kategoria',
		'confirm_action' => 'Czy jesteś pewien, że chcesz przeprowadzić daną operację? Nie można cofnąć jej rezultatów!',
		'confirm_action_feed_cat' => 'Czy jesteś pewien, że chcesz przeprowadzić daną operację? Stracisz powiązane zapytania i ulubione wiadomości. Tych zmian nie można wycofać!',
		'confirm_exit_slider' => 'Czy na pewno chcesz odrzucić niezapisane ustawienia?',
		'feedback' => array(
			'body_new_articles' => 'W FreshRSS znajduje się %%d wiadomości do przeczytania.',
			'body_unread_articles' => '(Nieprzeczytane: %%d)',
			'request_failed' => 'Zapytanie nie powiodło się. Może to być spowodowane problemami z łącznością z internetem.',
			'title_new_articles' => 'FreshRSS: nowe wiadomości!',
		),
		'labels_empty' => 'Brak tagów',
		'new_article' => 'Dostępne są nowe wiadomości. Kliknij, aby odświeżyć stronę.',
		'should_be_activated' => 'JavaScript musi być włączony',
		'unsafe_csp_header' => 'Używany nagłówek CSP jest niebezpieczny i FreshRSS może być podatny na ataki XSS. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Zobacz dokumentację</a>',
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'pt-pt' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
		'zh-tw' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'O serwisie',
		'account' => 'Konto',
		'admin' => 'Administracja',
		'archiving' => 'Archiwizacja',
		'authentication' => 'Uwierzytelnianie',
		'check_install' => 'Sprawdzenie instalacji',
		'configuration' => 'Konfiguracja',
		'display' => 'Wyświetlanie',
		'extensions' => 'Rozszerzenia',
		'logs' => 'Dziennik',
		'privacy' => 'Prywatność',
		'queries' => 'Zapisane zapytania',
		'reading' => 'Czytanie',
		'search' => 'Wyszukaj wyrazy lub #tagi',
		'search_help' => 'Zaawansowane parametry wyszukiwania opisane są w <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">dokumentacji</a>.',
		'sharing' => 'Udostępnianie',
		'shortcuts' => 'Skróty klawiszowe',
		'stats' => 'Statystyki',
		'system' => 'Konfiguracja serwera',
		'update' => 'Aktualizacja',
		'user_management' => 'Zarządzanie użytkownikami',
		'user_profile' => 'Profil',
	),
	'period' => array(
		'days' => 'dni',
		'hours' => 'godziny',
		'months' => 'miesiące',
		'weeks' => 'tygodnie',
		'years' => 'lata',
	),
	'share' => array(
		'Known' => 'Strony bazujące na usłudze Known',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Schowek',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-mail',
		'email-webmail-firefox-fix' => 'Email (webmail - poprawka dla Firefoksa)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Wydruk',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Udostępnianie natywne',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Uwaga!',
		'blank_to_disable' => 'Pozostaw puste, by wyłączyć',
		'by_author' => 'Autor:',
		'by_default' => 'Domyślnie',
		'damn' => 'Niech to!',
		'default_category' => 'Brak kategorii',
		'no' => 'Nie',
		'not_applicable' => 'Niedostępne',
		'ok' => 'Okej!',
		'or' => 'lub',
		'yes' => 'Tak',
	),
	'stream' => array(
		'load_more' => 'Załaduj więcej wiadomości',
		'mark_all_read' => 'Oznacz wszystkie jako przeczytane',
		'nothing_to_load' => 'Koniec listy wiadomości',
	),
);

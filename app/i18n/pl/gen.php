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
		'actualize' => 'Aktualizuj kanałów',
		'add' => 'Dodaj',
		'back' => '← Wróć',
		'back_to_rss_feeds' => '← Wróć do subskrybowanych kanałów RSS',
		'cancel' => 'Anuluj',
		'create' => 'Stwórz',
		'demote' => 'Zdegraduj',
		'disable' => 'Wyłącz',
		'empty' => 'Opróżnij',
		'enable' => 'Włącz',
		'export' => 'Eksportuj',
		'filter' => 'Filtruj',
		'import' => 'Importuj',
		'load_default_shortcuts' => 'Ustaw domyślne skróty',
		'manage' => 'Ustawienia',
		'mark_read' => 'Oznacz jako przeczytane',
		'promote' => 'Awansuj',
		'purge' => 'Oczyść',
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
		'login' => 'Logowanie',
		'logout' => 'Wyloguj',
		'password' => array(
			'_' => 'Hasło',
			'format' => '<small>Przynajmniej 7 znaków</small>',
		),
		'registration' => array(
			'_' => 'Nowe konto',
			'ask' => 'Stworzyć nowe konto?',
			'title' => 'Tworzenie konta',
		),
		'username' => array(
			'_' => 'Nazwa użytkownika',
			'format' => '<small>Nie więcej niż 16 znaków alfanumerycznych</small>',
		),
	),
	'date' => array(
		'Apr' => '\\K\\w\\i\\e\\t\\n\\i\\a',
		'Aug' => '\\S\\i\\e\\r\\p\\n\\i\\a',
		'Dec' => '\\G\\r\\u\\d\\n\\i\\a',
		'Feb' => '\\L\\u\\t\\e\\g\\o',
		'Jan' => '\\S\\t\\y\\c\\z\\n\\i\\a',
		'Jul' => '\\L\\i\\p\\c\\a',
		'Jun' => '\\C\\z\\e\\r\\w\\c\\a',
		'Mar' => '\\M\\a\\r\\c\\a',
		'May' => '\\M\\a\\j\\a',
		'Nov' => '\\L\\i\\s\\t\\o\\p\\a\\d\\a',
		'Oct' => '\\P\\a\\ź\\d\\z\\i\\e\\r\\n\\i\\k\\a',
		'Sep' => '\\W\\r\\z\\e\\ś\\n\\i\\a',
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
	'dir' => 'ltr',	// TODO
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'O serwisie FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Pusta kategoria',
		'confirm_action' => 'Czy jesteś pewien, że chcesz przeprowadzić daną operację? Nie można cofnąć jej rezultatów!',
		'confirm_action_feed_cat' => 'czy jesteś pewien, że chcesz przeprowadzić daną operację? Stracisz powiązane zapytania i ulubione wiadomości. Tych zmian nie można wycofać!',
		'feedback' => array(
			'body_new_articles' => 'Na FreshRSS znajduje się %%d wiadomości do przeczytania.',
			'request_failed' => 'Zapytanie nie powiodło się. Może to być spowodowane problemami z łącznością z internetem.',
			'title_new_articles' => 'FreshRSS: nowe wiadomości!',
		),
		'new_article' => 'Dostępne są nowe wiadomości. Kliknij, aby odświeżyć stronę.',
		'should_be_activated' => 'JavaScript musi być włączony',
	),
	'lang' => array(
		'cz' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
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
		'queries' => 'Zapisane zapytania',
		'reading' => 'Czytanie',
		'search' => 'Wyszukaj wyrazy lub #tagi',
		'sharing' => 'Podawanie dalej',
		'shortcuts' => 'Skróty klawiszowe',
		'stats' => 'Statystyki',
		'system' => 'Konfiguracja serwisu',
		'update' => 'Aktualizacja',
		'user_management' => 'Zarządzanie użytkownikami',
		'user_profile' => 'Profil',
	),
	'pagination' => array(
		'first' => 'Początek',
		'last' => 'Koniec',
		'next' => 'Następne',
		'previous' => 'Poprzednie',
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
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Schowek',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-mail',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Wydruk',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
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
		'ok' => 'Okay!',	// IGNORE
		'or' => 'lub',
		'yes' => 'Tak',
	),
	'stream' => array (
		'load_more' => 'Załaduj więcej wiadomości',
		'mark_all_read' => 'Oznacz wszystkie jako przeczytane',
		'nothing_to_load' => 'Koniec listy wiadomości',
	),
);

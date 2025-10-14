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
		'actualize' => 'Atjaunināt barotnes',
		'add' => 'Pievienot',
		'back_to_rss_feeds' => '← Atgriezieties pie RSS barotnēm',
		'cancel' => 'Atcelt',
		'close' => 'Close',	// TODO
		'create' => 'Uztaisīt',
		'delete_all_feeds' => 'Delete all feeds',	// TODO
		'delete_errored_feeds' => 'Delete feeds with errors',	// TODO
		'delete_muted_feeds' => 'Izdzēst izslēgtās barotnes',
		'demote' => 'Pazemināt amatu',
		'disable' => 'Izslēgt',
		'download' => 'Download',	// TODO
		'empty' => 'Iztukšot',
		'enable' => 'Ieslēgt',
		'export' => 'Eksportēt',
		'filter' => 'Filtrēt',
		'import' => 'Importēt',
		'load_default_shortcuts' => 'Ielādēt noklusējuma saīsnes',
		'manage' => 'Pārvaldīt',
		'mark_read' => 'Atzīmēt kā izlasītu',
		'menu' => array(
			'open' => 'Open menu',	// TODO
		),
		'nav_buttons' => array(
			'next' => 'Next article',	// TODO
			'prev' => 'Previous article',	// TODO
			'up' => 'Go up',	// TODO
		),
		'open_url' => 'Atvērt URL',
		'promote' => 'Paaugstināt amatu',
		'purge' => 'Iztīrīt',
		'refresh_opml' => 'Pārlādēt OPML',
		'remove' => 'Noņemt',
		'rename' => 'Pārdēvēt',
		'see_website' => 'Skatīt mājaslapu',
		'submit' => 'Iesniegt',
		'truncate' => 'Izdzēst visus rakstus',
		'update' => 'Atjaunināt',
	),
	'auth' => array(
		'accept_tos' => 'Es piekrītu <a href="%s">Pakalpojuma noteikumiem</a>.',
		'email' => 'E-pasta adrese',
		'keep_logged_in' => 'Turiet mani autorizētu <small>(%dienas)</small>',
		'login' => 'Autorizēties',
		'logout' => 'Izrakstīties',
		'password' => array(
			'_' => 'Parole',
			'format' => '<small>Vismaz 7 rakstzīmes</small>',
		),
		'reauth' => array(
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
		),
		'registration' => array(
			'_' => 'Jauns konts',
			'ask' => 'Uztaisīt kontu?',
			'title' => 'Konta izveide',
		),
		'username' => array(
			'_' => 'Lietotājvārds',
			'format' => '<small>Maksimums 16 burtu un ciparu zīmes</small>',
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\ī\\l\\i\\s',
		'Aug' => '\\A\\u\\g\\u\\s\\t\\s',
		'Dec' => '\\D\\e\\c\\e\\m\\b\\r\\i\\s',
		'Feb' => '\\F\\e\\b\\r\\u\\ā\\r\\i\\s',
		'Jan' => '\\J\\a\\n\\v\\ā\\r\\i\\s',
		'Jul' => '\\J\\ū\\l\\i\\j\\s',
		'Jun' => '\\J\\ū\\n\\i\\j\\s',
		'Mar' => '\\M\\a\\r\\t\\s',
		'May' => '\\M\\a\\i\\j\\s',
		'Nov' => '\\N\\o\\v\\e\\m\\b\\r\\i\\s',
		'Oct' => '\\O\\k\\t\\o\\b\\r\\i\\s',
		'Sep' => '\\S\\e\\p\\t\\e\\m\\b\\r\\i\\s',
		'apr' => 'Apr.',	// IGNORE
		'april' => 'Aprīlis',
		'aug' => 'Aug.',	// IGNORE
		'august' => 'Augusts',
		'before_yesterday' => 'Aizvakar',
		'dec' => 'Dec.',	// IGNORE
		'december' => 'Decembris',
		'feb' => 'Feb.',	// IGNORE
		'february' => 'Februāris',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\a\\t H\\:i',	// IGNORE
		'fri' => 'Pk',
		'jan' => 'Jan.',	// IGNORE
		'january' => 'Janvāris',
		'jul' => 'Jūlijs',
		'july' => 'Jūlijs',
		'jun' => 'Jūnijs',
		'june' => 'Jūnijs',
		'last_2_year' => 'Pēdējie divi gadi',
		'last_3_month' => 'Pēdējie trīs mēneši',
		'last_3_year' => 'Pēdējie trīs gadi',
		'last_5_year' => 'Pēdējie pieci gadi',
		'last_6_month' => 'Pēdējie seši mēneši',
		'last_month' => 'Pēdējais mēnesis',
		'last_week' => 'Pēdējā nedēļa',
		'last_year' => 'Pēdējais gads',
		'mar' => 'Mar.',	// IGNORE
		'march' => 'Marts',
		'may' => 'Maijs',
		'may_' => 'Maijs',
		'mon' => 'Mēn',
		'month' => 'mēneši',
		'nov' => 'Nov.',	// IGNORE
		'november' => 'Novembris',
		'oct' => 'Okt.',
		'october' => 'Oktobris',
		'sat' => 'S',
		'sep' => 'Sept.',	// IGNORE
		'september' => 'Septembris',
		'sun' => 'Sv',
		'thu' => 'C',
		'today' => 'Šodien',
		'tue' => 'O',
		'wed' => 'T',
		'yesterday' => 'Vakar',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// TODO
		'about' => 'Par FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Tukša kategorija',
		'confirm_action' => 'Vai esat pārliecināts, ka vēlaties veikt šo darbību? To nevar atcelt!',
		'confirm_action_feed_cat' => 'Vai esat pārliecināts, ka vēlaties veikt šo darbību? Jūs zaudēsiet saistītos mīļākos rakstus un lietotāja pieprasījumus. To nevar atcelt!',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => 'FreshRSS ir %%d jauni raksti lasīšanai.',
			'body_unread_articles' => '(neizlasīti: %%d)',
			'request_failed' => 'Pieprasījums nav izdevies, iespējams, to izraisījušas interneta savienojuma problēmas.',
			'title_new_articles' => 'FreshRSS: jauni raksti!',
		),
		'labels_empty' => 'No labels',	// TODO
		'new_article' => 'Ir pieejami jauni raksti, noklikšķiniet, lai atsvaidzinātu lapu..',
		'should_be_activated' => 'JavaScript jābūt ieslēgtam',
		'unsafe_csp_header' => 'The CSP header in use is unsafe and FreshRSS may be vulnerable to XSS attacks. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">See documentation</a>',	// TODO
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
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
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Par',
		'account' => 'Konts',
		'admin' => 'Administrācija',
		'advanced_search' => 'Advanced Search',	// TODO
		'archiving' => 'Arhivēšana',
		'authentication' => 'Autentifikācija',
		'check_install' => 'Uzstādīšanas pārbaude',
		'configuration' => 'Konfigurācija',
		'display' => 'Display',	// TODO
		'extensions' => 'Paplašinājumi',
		'logs' => 'Žurnāls',
		'privacy' => 'Privacy',	// TODO
		'queries' => 'Lietotāja pieprasījumi',
		'reading' => 'Lasīšana',
		'search' => 'Meklēt vārdus vai #birkas',
		'search_help' => 'Skatiet dokumentāciju par papildu <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">meklēšanas parametriem</a>',
		'sharing' => 'Dalīšana',
		'shortcuts' => 'Īsceļi',
		'stats' => 'Statistika',
		'system' => 'Sistēmas konfigurācija',
		'update' => 'Atjaunināt',
		'user_management' => 'Lietotāju pārvaldība',
		'user_profile' => 'Profils',
	),
	'period' => array(
		'days' => 'dienas',
		'hours' => 'stundas',
		'months' => 'mēneši',
		'weeks' => 'nedēļas',
		'years' => 'gadi',
	),
	'readme' => array(
		'contribute' => 'contribute',	// IGNORE
		'language' => 'Language',	// IGNORE
		'translated' => 'Progress',	// IGNORE
	),
	'search' => array(
		'advanced_search_help' => 'This form helps construct search queries, but manual queries are even more powerful.',	// TODO
		'authors' => 'Authors',	// TODO
		'categories' => 'Categories',	// TODO
		'content' => 'Content',	// TODO
		'date_from' => 'From',	// TODO
		'date_past' => 'In the past',	// TODO
		'date_published' => 'Publication Date',	// TODO
		'date_range' => 'Date Range',	// TODO
		'date_received' => 'Received Date',	// TODO
		'date_to' => 'To',	// TODO
		'feeds' => 'Feeds',	// TODO
		'free_text' => 'Free Text',	// TODO
		'free_text_help' => 'Search both in title and content',	// TODO
		'full_documentation' => 'View <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">full search documentation</a>',	// TODO
		'labels' => 'My Labels',	// TODO
		'multiple_help' => 'Select one or more (hold <kbd>Ctrl</kbd> or <kbd>Cmd</kbd>)',	// TODO
		'sources' => 'Sources',	// TODO
		'tags' => 'Article Tags',	// TODO
		'text' => 'Text Search',	// TODO
		'text_help' => 'Multiple lines are combined by a logical <i>or</i>. Also supports <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">regular expressions</a>.',	// TODO
		'text_placeholder' => 'Keyword',	// TODO
		'title' => 'Title',	// TODO
		'url' => 'URL',	// TODO
		'user_queries' => 'User Queries',	// TODO
	),
	'share' => array(
		'Known' => 'Zināmas vietnes',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Starpliktuve',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'E-pasts',
		'email-webmail-firefox-fix' => 'E-pasts (Webmail - labojums Firefox)',
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
		'print' => 'Drukāt',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Sistēmas koplietošana',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Brīdinājums!',
		'blank_to_disable' => 'Atstāj tukšu, lai atspējotu',
		'by_author' => 'No:',
		'by_default' => 'Pēc noklusējuma',
		'damn' => 'Velns!',
		'default_category' => 'Neklasificēts',
		'no' => 'Nē',
		'not_applicable' => 'Nav pieejams',
		'ok' => 'Labi!',
		'or' => 'vai',
		'yes' => 'Jā',
	),
	'stream' => array(
		'load_more' => 'Ielādēt vairāk rakstus',
		'mark_all_read' => 'Atzīmēt visus kā izlasītus',
		'nothing_to_load' => 'Vairāk rakstu vairs nav',
	),
);

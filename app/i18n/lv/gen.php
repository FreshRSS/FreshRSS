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
		'close' => 'Aizvērt',
		'create' => 'Uztaisīt',
		'delete_all_feeds' => 'Dzēst visas barotnes',
		'delete_errored_feeds' => 'Dzēst barotnes ar kļūdām',
		'delete_muted_feeds' => 'Izdzēst izslēgtās barotnes',
		'demote' => 'Pazemināt amatu',
		'disable' => 'Izslēgt',
		'download' => 'Lejupielādēt',
		'empty' => 'Iztukšot',
		'enable' => 'Ieslēgt',
		'export' => 'Eksportēt',
		'filter' => 'Filtrēt',
		'import' => 'Importēt',
		'load_default_shortcuts' => 'Ielādēt noklusējuma saīsnes',
		'manage' => 'Pārvaldīt',
		'mark_read' => 'Atzīmēt kā izlasītu',
		'menu' => array(
			'open' => 'Atvērt izvēlni',
		),
		'nav_buttons' => array(
			'next' => 'Nākamais raksts',
			'prev' => 'Iepriekšējais raksts',
			'up' => 'Doties uz augšu',
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
		'keep_logged_in' => 'Palikt pieteicies <small>(%s dienas)</small>',
		'login' => 'Autorizēties',
		'logout' => 'Izrakstīties',
		'password' => array(
			'_' => 'Parole',
			'format' => '<small>Vismaz 7 rakstzīmes</small>',
		),
		'reauth' => array(
			'header' => 'Nepieciešama atkārtota autentifikācija',
			'tip' => 'Jums netiks prasīts atkārtoti pieteikties <u>%d minūtes</u>',
			'title' => 'Atkārtota autentifikācija',
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
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Par FreshRSS',
	),
	'interval' => array(
		'day' => array(
			0 => 'pirms %d diena',
			1 => 'pirms %d dienas',
			2 => 'pirms %d dienu',
		),
		'hour' => array(
			0 => 'pirms %d stunda',
			1 => 'pirms %d stundas',
			2 => 'pirms %d stundu',
		),
		'justnow' => 'tikko',
		'minute' => array(
			0 => 'pirms %d minūte',
			1 => 'pirms %d minūtes',
			2 => 'pirms %d minūšu',
		),
		'month' => array(
			0 => 'pirms %d mēnesis',
			1 => 'pirms %d mēneši',
			2 => 'pirms %d mēnešu',
		),
		'second' => array(
			0 => 'pirms %d sekunde',
			1 => 'pirms %d sekundes',
			2 => 'pirms %d sekunžu',
		),
		'year' => array(
			0 => 'pirms %d gads',
			1 => 'pirms %d gadi',
			2 => 'pirms %d gadu',
		),
	),
	'js' => array(
		'category_empty' => 'Tukša kategorija',
		'confirm_action' => 'Vai esat pārliecināts, ka vēlaties veikt šo darbību? To nevar atcelt!',
		'confirm_action_feed_cat' => 'Vai esat pārliecināts, ka vēlaties veikt šo darbību? Jūs zaudēsiet saistītos mīļākos rakstus un lietotāja pieprasījumus. To nevar atcelt!',
		'confirm_exit_slider' => 'Vai tiešām vēlaties atmest nesaglabātos iestatījumus?',
		'feedback' => array(
			'body_new_articles' => 'FreshRSS ir %%d jauni raksti lasīšanai.',
			'body_unread_articles' => '(neizlasīti: %%d)',
			'request_failed' => 'Pieprasījums nav izdevies, iespējams, to izraisījušas interneta savienojuma problēmas.',
			'title_new_articles' => 'FreshRSS: jauni raksti!',
		),
		'labels_empty' => 'Bez birku',
		'new_article' => 'Ir pieejami jauni raksti, noklikšķiniet, lai atsvaidzinātu lapu..',
		'should_be_activated' => 'JavaScript jābūt ieslēgtam',
		'unsafe_csp_header' => 'Izmantotā CSP galvene nav droša, un FreshRSS var būt neaizsargāta pret XSS uzbrukumiem. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Skatiet dokumentāciju</a>',
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
		'advanced_search' => 'Paplašinātā meklēšana',
		'archiving' => 'Arhivēšana',
		'authentication' => 'Autentifikācija',
		'check_install' => 'Uzstādīšanas pārbaude',
		'configuration' => 'Konfigurācija',
		'display' => 'Displejs',
		'extensions' => 'Paplašinājumi',
		'logs' => 'Žurnāls',
		'privacy' => 'Privātums',
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
		'advanced_search_help' => 'Šī veidlapa palīdz veidot meklēšanas pieprasījumus, bet manuāli pieprasījumi ir vēl spēcīgāki.',
		'authors' => 'Autori',
		'categories' => 'Kategorijas',
		'content' => 'Saturs',
		'date_from' => 'No',
		'date_modified' => 'Servera modificēšanas datums',
		'date_past' => 'Pagātnē',
		'date_published' => 'Publicēšanas datums',
		'date_range' => 'Datumu diapazons',
		'date_received' => 'Saņemšanas datums',
		'date_to' => 'Līdz',
		'date_user' => 'Lietotāja modificēšanas datums',
		'feeds' => 'Barotnes',
		'free_text' => 'Brīvs teksts',
		'free_text_help' => 'Meklēt gan virsrakstā, gan saturā',
		'full_documentation' => 'Skatiet <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">pilnu meklēšanas dokumentāciju</a>',
		'labels' => 'Manas birkas',
		'multiple_help' => 'Izvēlieties vienu vai vairākus (turiet <kbd>Ctrl</kbd> vai <kbd>Cmd</kbd>)',
		'sources' => 'Avoti',
		'tags' => 'Raksta birkas',
		'text' => 'Teksta meklēšana',
		'text_help' => 'Vairākas rindas ir apvienotas ar loģisko <i>VAI</i>. Atbalsta arī <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">regulārās izteiksmes</a>.',
		'text_placeholder' => 'Atslēgvārds',
		'title' => 'Virsraksts',
		'url' => 'URL',	// IGNORE
		'user_queries' => 'Lietotāju pieprasījumi',
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
		'print' => 'Drukāt',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'X (Twitter)',	// IGNORE
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

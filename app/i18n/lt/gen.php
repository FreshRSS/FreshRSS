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
		'actualize' => 'Atnaujinti kanalus',
		'add' => 'Pridėti',
		'back_to_rss_feeds' => '← Grįžti į savo RSS kanalus',
		'cancel' => 'Atšaukti',
		'close' => 'Užverti',
		'create' => 'Sukurti',
		'delete_all_feeds' => 'Ištrinti visus kanalus',
		'delete_errored_feeds' => 'Ištrinti kanalus su klaidomis',
		'delete_muted_feeds' => 'Ištrinti nutildytus kanalus',
		'demote' => 'Pažeminti',
		'disable' => 'Išjungti',
		'download' => 'Atsisiųsti',
		'empty' => 'Ištuštinti',
		'enable' => 'Įjungti',
		'export' => 'Eksportuoti',
		'filter' => 'Filtruoti',
		'import' => 'Importuoti',
		'load_default_shortcuts' => 'Įkelti numatytuosius sparčiuosius klavišus',
		'manage' => 'Tvarkyti',
		'mark_read' => 'Žymėti skaitytu',
		'menu' => array(
			'open' => 'Atverti meniu',
		),
		'nav_buttons' => array(
			'next' => 'Kitas straipsnis',
			'prev' => 'Ankstesnis straipsnis',
			'up' => 'Aukštyn',
		),
		'open_url' => 'Atverti URL',
		'promote' => 'Paaukštinti',
		'purge' => 'Išvalyti',
		'refresh_opml' => 'Atnaujinti OPML',
		'remove' => 'Pašalinti',
		'rename' => 'Pervadinti',
		'see_website' => 'Žiūrėti svetainę',
		'submit' => 'Pateikti',
		'truncate' => 'Ištrinti visus straipsnius',
		'update' => 'Atnaujinti',
	),
	'auth' => array(
		'accept_tos' => 'Sutinku su <a href="%s">naudojimosi sąlygomis</a>.',
		'email' => 'El. pašto adresas',
		'keep_logged_in' => 'Neatjungti manęs <small>(%s d.)</small>',
		'login' => 'Prisijungti',
		'logout' => 'Atsijungti',
		'password' => array(
			'_' => 'Slaptažodis',
			'format' => '<small>Bent 7 simboliai</small>',
		),
		'reauth' => array(
			'header' => 'Reikia iš naujo patvirtinti tapatybę',
			'tip' => 'Prisijungti iš naujo neprašysime <u>%d min.</u>',
			'title' => 'Pakartotinis tapatybės nustatymas',
		),
		'registration' => array(
			'_' => 'Nauja paskyra',
			'ask' => 'Sukurti paskyrą?',
			'title' => 'Paskyros kūrimas',
		),
		'username' => array(
			'_' => 'Naudotojo vardas',
			'format' => '<small>1–39 simboliai: raidės, skaitmenys ir <code>. _ @ -</code></small>',
		),
	),
	'date' => array(
		'Apr' => '\\b\\a\\l\\a\\n\\d\\ž\\i\\o',
		'Aug' => '\\r\\u\\g\\p\\j\\ū\\č\\i\\o',
		'Dec' => '\\g\\r\\u\\o\\d\\ž\\i\\o',
		'Feb' => '\\v\\a\\s\\a\\r\\i\\o',
		'Jan' => '\\s\\a\\u\\s\\i\\o',
		'Jul' => '\\l\\i\\e\\p\\o\\s',
		'Jun' => '\\b\\i\\r\\ž\\e\\l\\i\\o',
		'Mar' => '\\k\\o\\v\\o',
		'May' => '\\g\\e\\g\\u\\ž\\ė\\s',
		'Nov' => '\\l\\a\\p\\k\\r\\i\\č\\i\\o',
		'Oct' => '\\s\\p\\a\\l\\i\\o',
		'Sep' => '\\r\\u\\g\\s\\ė\\j\\o',
		'apr' => 'Bal.',
		'april' => 'Balandis',
		'aug' => 'Rugp.',
		'august' => 'Rugpjūtis',
		'before_yesterday' => 'Užvakar',
		'dec' => 'Gruod.',
		'december' => 'Gruodis',
		'feb' => 'Vas.',
		'february' => 'Vasaris',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y H\\:i',
		'fri' => 'Pn',
		'jan' => 'Saus.',
		'january' => 'Sausis',
		'jul' => 'Liep.',
		'july' => 'Liepa',
		'jun' => 'Birž.',
		'june' => 'Birželis',
		'last_2_year' => 'Paskutiniai dveji metai',
		'last_3_month' => 'Paskutiniai trys mėnesiai',
		'last_3_year' => 'Paskutiniai treji metai',
		'last_5_year' => 'Paskutiniai penkeri metai',
		'last_6_month' => 'Paskutiniai šeši mėnesiai',
		'last_month' => 'Paskutinis mėnuo',
		'last_week' => 'Paskutinė savaitė',
		'last_year' => 'Paskutiniai metai',
		'mar' => 'Kov.',
		'march' => 'Kovas',
		'may' => 'Geg.',
		'may_' => 'Gegužė',
		'mon' => 'Pr',
		'month' => 'mėnesiai',
		'nov' => 'Lapkr.',
		'november' => 'Lapkritis',
		'oct' => 'Spal.',
		'october' => 'Spalis',
		'sat' => 'Št',
		'sep' => 'Rugs.',
		'september' => 'Rugsėjis',
		'sun' => 'Sk',
		'thu' => 'Kt',
		'today' => 'Šiandien',
		'tue' => 'An',
		'wed' => 'Tr',
		'yesterday' => 'Vakar',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Apie FreshRSS',
	),
	'interval' => array(
		'day' => array(
			0 => 'prieš %d dieną',
			1 => 'prieš %d dienas',
			2 => 'prieš %d dienų',
		),
		'hour' => array(
			0 => 'prieš %d valandą',
			1 => 'prieš %d valandas',
			2 => 'prieš %d valandų',
		),
		'justnow' => 'ką tik',
		'minute' => array(
			0 => 'prieš %d minutę',
			1 => 'prieš %d minutes',
			2 => 'prieš %d minučių',
		),
		'month' => array(
			0 => 'prieš %d mėnesį',
			1 => 'prieš %d mėnesius',
			2 => 'prieš %d mėnesių',
		),
		'second' => array(
			0 => 'prieš %d sekundę',
			1 => 'prieš %d sekundes',
			2 => 'prieš %d sekundžių',
		),
		'year' => array(
			0 => 'prieš %d metus',
			1 => 'prieš %d metus',
			2 => 'prieš %d metų',
		),
	),
	'js' => array(
		'category_empty' => 'Tuščia kategorija',
		'confirm_action' => 'Ar tikrai norite atlikti šį veiksmą? Jo negalima atšaukti!',
		'confirm_action_feed_cat' => 'Ar tikrai norite atlikti šį veiksmą? Prarasite susijusius mėgstamus straipsnius ir naudotojo užklausas. Jo negalima atšaukti!',
		'confirm_exit_slider' => 'Ar tikrai norite atsisakyti neišsaugotų nustatymų?',
		'feedback' => array(
			'body_new_articles' => array(
				0 => 'FreshRSS yra %d naujas straipsnis.',
				1 => 'FreshRSS yra %d nauji straipsniai.',
				2 => 'FreshRSS yra %d naujų straipsnių.',
			),
			'body_unread_articles' => array(
				0 => '(neskaityta: %d)',
				1 => '(neskaityta: %d)',
				2 => '(neskaityta: %d)',
			),
			'request_failed' => 'Užklausa nepavyko; tai galėjo lemti interneto ryšio problemos.',
			'title_new_articles' => 'FreshRSS: nauji straipsniai!',
		),
		'labels_empty' => 'Etikečių nėra',
		'new_article' => 'Yra naujų straipsnių; spustelėkite, kad atnaujintumėte puslapį.',
		'should_be_activated' => 'Turi būti įjungtas „JavaScript“',
		'unsafe_csp_header' => 'Naudojama CSP antraštė yra nesaugi, ir FreshRSS gali būti pažeidžiama XSS atakų. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Žr. dokumentaciją</a>',
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
		'lt' => 'Lietuvių',	// IGNORE
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
		'about' => 'Apie',
		'account' => 'Paskyra',
		'admin' => 'Administravimas',
		'advanced_search' => 'Išplėstinė paieška',
		'archiving' => 'Archyvavimas',
		'authentication' => 'Tapatybės nustatymas',
		'check_install' => 'Diegimo patikra',
		'configuration' => 'Konfigūracija',
		'display' => 'Rodymas',
		'extensions' => 'Plėtiniai',
		'logs' => 'Žurnalai',
		'privacy' => 'Privatumas',
		'queries' => 'Naudotojo užklausos',
		'reading' => 'Skaitymas',
		'search' => 'Ieškoti žodžių ar #žymų',
		'search_help' => 'Išplėstinių <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">paieškos parametrų</a> ieškokite dokumentacijoje',
		'sharing' => 'Dalijimasis',
		'shortcuts' => 'Spartieji klavišai',
		'stats' => 'Statistika',
		'system' => 'Sistemos konfigūracija',
		'update' => 'Atnaujinti',
		'user_management' => 'Tvarkyti naudotojus',
		'user_profile' => 'Profilis',
	),
	'period' => array(
		'days' => 'dienos',
		'hours' => 'valandos',
		'months' => 'mėnesiai',
		'weeks' => 'savaitės',
		'years' => 'metai',
	),
	'readme' => array(
		'contribute' => 'prisidėti',
		'language' => 'Kalba',
		'translated' => 'Pažanga',
	),
	'search' => array(
		'advanced_search_help' => 'Ši forma padeda sudaryti paieškos užklausas, tačiau rankiniu būdu sudarytos užklausos dar galingesnės.',
		'authors' => 'Autoriai',
		'categories' => 'Kategorijos',
		'content' => 'Turinys',
		'date_from' => 'Nuo',
		'date_modified' => 'Serverio keitimo data',
		'date_past' => 'Praeityje',
		'date_published' => 'Paskelbimo data',
		'date_range' => 'Datų intervalas',
		'date_received' => 'Gavimo data',
		'date_to' => 'Iki',
		'date_user' => 'Naudotojo keitimo data',
		'feeds' => 'Kanalai',
		'free_text' => 'Laisvas tekstas',
		'free_text_help' => 'Ieškoti ir pavadinime, ir turinyje',
		'full_documentation' => 'Žr. <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">visą paieškos dokumentaciją</a>',
		'labels' => 'Mano etiketės',
		'multiple_help' => 'Pasirinkite vieną ar kelis (laikykite <kbd>Ctrl</kbd> arba <kbd>Cmd</kbd>)',
		'sources' => 'Šaltiniai',
		'tags' => 'Straipsnio žymos',
		'text' => 'Teksto paieška',
		'text_help' => 'Kelios eilutės jungiamos loginiu <i>arba</i>. Taip pat palaikomi <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">reguliarieji reiškiniai</a>.',
		'text_placeholder' => 'Raktažodis',
		'title' => 'Pavadinimas',
		'url' => 'URL',	// IGNORE
		'user_queries' => 'Naudotojo užklausos',
	),
	'share' => array(
		'Known' => 'Žinomos svetainės',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Iškarpinė',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'El. paštas',
		'email-webmail-firefox-fix' => 'El. paštas (žiniatinklio paštas – pataisa „Firefox“)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkace' => 'LinkAce',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'nextcloud-bookmarks' => 'Nextcloud Bookmarks',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'print' => 'Spausdinti',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Sistemos dalijimasis',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Dėmesio!',
		'blank_to_disable' => 'Palikite tuščią, kad išjungtumėte',
		'by_author' => 'Autorius:',
		'by_default' => 'Pagal numatymą',
		'damn' => 'Po galais!',
		'default_category' => 'Be kategorijos',
		'no' => 'Ne',
		'not_applicable' => 'Neprieinama',
		'ok' => 'Gerai!',
		'or' => 'arba',
		'yes' => 'Taip',
	),
	'stream' => array(
		'load_more' => 'Įkelti daugiau straipsnių',
		'mark_all_read' => 'Žymėti visus skaitytais',
		'nothing_to_load' => 'Daugiau straipsnių nėra',
	),
);

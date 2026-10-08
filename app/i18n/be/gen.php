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
		'actualize' => 'Абнавіць стужкі',
		'add' => 'Дадаць',
		'back_to_rss_feeds' => '← Вярнуцца да RSS-стужак',
		'cancel' => 'Скасаваць',
		'close' => 'Закрыць',
		'create' => 'Стварыць',
		'delete_all_feeds' => 'Выдаліць усе стужкі',
		'delete_errored_feeds' => 'Выдаліць стужкі з памылкамі',
		'delete_muted_feeds' => 'Выдаліць прыглушаныя стужкі',
		'demote' => 'Панізіць',
		'disable' => 'Адключыць',
		'download' => 'Спампаваць',
		'empty' => 'Апаражніць',
		'enable' => 'Уключыць',
		'export' => 'Экспартаваць',
		'filter' => 'Фільтр',
		'import' => 'Імпартаваць',
		'load_default_shortcuts' => 'Загрузіць прадвызначаныя спалучэнні клавіш',
		'manage' => 'Наладзіць',
		'mark_read' => 'Пазначыць як прачытанае',
		'menu' => array(
			'open' => 'Адкрыць меню',
		),
		'nav_buttons' => array(
			'next' => 'Перайсці да наступнага артыкула',
			'prev' => 'Перайсці да папярэдняга артыкула',
			'up' => 'Перайсці ўверх',
		),
		'open_url' => 'Адкрыць URL-адрас',
		'promote' => 'Павысіць',
		'purge' => 'Ачысціць',
		'refresh_opml' => 'Абнавіць OPML',
		'remove' => 'Выдаліць',
		'rename' => 'Перайменаваць',
		'see_website' => 'Праглядзець сайт',
		'submit' => 'Адправіць',
		'truncate' => 'Выдаліць усе артыкулы',
		'update' => 'Абнавіць',
	),
	'auth' => array(
		'accept_tos' => 'Я прымаю <a href="%s">ўмовы выкарыстання</a>.',
		'email' => 'Адрас электроннай пошты',
		'keep_logged_in' => 'Не выходзіць з уліковага запісу <small>(%s сут)</small>',
		'login' => 'Увайсці',
		'logout' => 'Выйсці',
		'password' => array(
			'_' => 'Пароль',
			'format' => '<small>Не менш за 7 сімвалаў</small>',
		),
		'reauth' => array(
			'header' => 'Патрабуецца паўторная аўтэнтыфікацыя',
			'tip' => 'Паўторны ўваход не спатрэбіцца на працягу <u>%d хв</u>',
			'title' => 'Паўторная аўтэнтыфікацыя',
		),
		'registration' => array(
			'_' => 'Новы ўліковы запіс',
			'ask' => 'Стварыць уліковы запіс?',
			'title' => 'Стварэнне ўліковага запісу',
		),
		'username' => array(
			'_' => 'Імя карыстальніка',
			'format' => '<small>1-39 сімвалаў: літары, лічбы і <code>. _ @ -</code></small>',
		),
	),
	'date' => array(
		'Apr' => '\\к\\р\\а\\с\\а\\в\\і\\к\\а',
		'Aug' => '\\ж\\н\\і\\ў\\н\\я',
		'Dec' => '\\с\\н\\е\\ж\\н\\я',
		'Feb' => '\\л\\ю\\т\\а\\г\\а',
		'Jan' => '\\с\\т\\у\\д\\з\\е\\н\\я',
		'Jul' => '\\л\\і\\п\\е\\н\\я',
		'Jun' => '\\ч\\э\\р\\в\\е\\н\\я',
		'Mar' => '\\с\\а\\к\\а\\в\\і\\к\\а',
		'May' => '\\м\\а\\я',
		'Nov' => '\\л\\і\\с\\т\\а\\п\\а\\д\\а',
		'Oct' => '\\к\\а\\с\\т\\р\\ы\\ч\\н\\і\\к\\а',
		'Sep' => '\\в\\е\\р\\а\\с\\н\\я',
		'apr' => 'кра',
		'april' => 'Красавік',
		'aug' => 'жні',
		'august' => 'Жнівень',
		'before_yesterday' => 'Пазаўчора',
		'dec' => 'сне',
		'december' => 'Снежань',
		'feb' => 'лют',
		'february' => 'Люты',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\у H\\:i',
		'fri' => 'Пт',
		'jan' => 'сту',
		'january' => 'Студзень',
		'jul' => 'ліп',
		'july' => 'Ліпень',
		'jun' => 'чэр',
		'june' => 'Чэрвень',
		'last_2_year' => 'Апошнія два гады',
		'last_3_month' => 'Апошнія тры месяцы',
		'last_3_year' => 'Апошнія тры гады',
		'last_5_year' => 'Апошнія пяць гадоў',
		'last_6_month' => 'Апошнія шэсць месяцаў',
		'last_month' => 'Апошні месяц',
		'last_week' => 'Апошні тыдзень',
		'last_year' => 'Мінулы год',
		'mar' => 'сак',
		'march' => 'Сакавік',
		'may' => 'мая',
		'may_' => 'май',
		'mon' => 'Пн',
		'month' => 'мес',
		'nov' => 'ліс',
		'november' => 'Лістапад',
		'oct' => 'кас',
		'october' => 'Кастрычнік',
		'sat' => 'Сб',
		'sep' => 'вер',
		'september' => 'Верасень',
		'sun' => 'Нд',
		'thu' => 'Чц',
		'today' => 'Сёння',
		'tue' => 'Аў',
		'wed' => 'Ср',
		'yesterday' => 'Учора',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Пра FreshRSS',
	),
	'interval' => array(
		'day' => array(
			0 => '%d дзень таму',
			1 => '%d дні таму',
			2 => '%d дзён таму',
		),
		'hour' => array(
			0 => '%d гадзіну таму',
			1 => '%d гадзіны таму',
			2 => '%d гадзін таму',
		),
		'justnow' => 'толькі што',
		'minute' => array(
			0 => '%d хвіліну таму',
			1 => '%d хвіліны таму',
			2 => '%d хвілін таму',
		),
		'month' => array(
			0 => '%d месяц таму',
			1 => '%d месяцы таму',
			2 => '%d месяцаў таму',
		),
		'second' => array(
			0 => '%d секунду таму',
			1 => '%d секунды таму',
			2 => '%d секунд таму',
		),
		'year' => array(
			0 => '%d год таму',
			1 => '%d гады таму',
			2 => '%d гадоў таму',
		),
	),
	'js' => array(
		'category_empty' => 'Пустая катэгорыя',
		'confirm_action' => 'Вы ўпэўненыя, што хочаце выканаць гэта дзеянне? Яго нельга скасаваць!',
		'confirm_action_feed_cat' => 'Вы ўпэўненыя, што хочаце выканаць гэта дзеянне? Вы страціце звязанае абранае і карыстальніцкія запыты. Яго нельга скасаваць!',
		'confirm_exit_slider' => 'Вы ўпэўненыя, што хочаце скасаваць незахаваныя налады?',
		'feedback' => array(
			'body_new_articles' => array(
				0 => 'На FreshRSS ёсць %d новы артыкул для чытання.',
				1 => 'На FreshRSS ёсць %d новыя артыкулы для чытання.',
				2 => 'На FreshRSS ёсць %d новых артыкулаў для чытання.',
			),
			'body_unread_articles' => array(
				0 => '(непрачытана: %d)',
				1 => '(непрачытана: %d)',
				2 => '(непрачытана: %d)',
			),
			'request_failed' => 'Запыт не атрымаўся; магчыма, прычынай былі праблемы з падключэннем да інтэрнэту.',
			'title_new_articles' => 'FreshRSS: новыя артыкулы!',
		),
		'labels_empty' => 'Няма метак',
		'new_article' => 'Даступныя новыя артыкулы, націсніце, каб абнавіць старонку.',
		'should_be_activated' => 'Неабходна ўключыць JavaScript',
		'unsafe_csp_header' => 'Загаловак CSP, які выкарыстоўваецца, небяспечны, і FreshRSS можа быць уразлівай да атак XSS. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Паглядзіце дакументацыю</a>',
	),
	'lang' => array(
		'az' => 'Azərbaycanca',	// IGNORE
		'be' => 'Беларуская',	// IGNORE
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
		'about' => 'Пра праграму',
		'account' => 'Уліковы запіс',
		'admin' => 'Адміністраванне',
		'advanced_search' => 'Пашыраны пошук',
		'archiving' => 'Архіваванне',
		'authentication' => 'Аўтэнтыфікацыя',
		'check_install' => 'Праверка ўсталявання',
		'configuration' => 'Канфігурацыя',
		'display' => 'Выгляд',
		'extensions' => 'Пашырэнні',
		'logs' => 'Журнал',
		'privacy' => 'Прыватнасць',
		'queries' => 'Карыстальніцкія запыты',
		'reading' => 'Чытанне',
		'search' => 'Пошук слоў або #тэгаў',
		'search_help' => 'Глядзіце дакументацыю па пашыраных <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">параметрах пошуку</a>',
		'sharing' => 'Абагульванне',
		'shortcuts' => 'Спалучэнні клавіш',
		'stats' => 'Статыстыка',
		'system' => 'Канфігурацыя сістэмы',
		'update' => 'Абнаўленне',
		'user_management' => 'Кіраванне карыстальнікамі',
		'user_profile' => 'Профіль',
	),
	'period' => array(
		'days' => 'сут',
		'hours' => 'гадз',
		'months' => 'мес',
		'weeks' => 'тыд',
		'years' => 'г',
	),
	'readme' => array(
		'contribute' => 'Унесці ўклад',
		'language' => 'Мова',
		'translated' => 'Прагрэс',
	),
	'search' => array(
		'advanced_search_help' => 'Гэта форма дапамагае ствараць пошукавыя запыты, але ручныя запыты яшчэ больш магутныя.',
		'authors' => 'Аўтары',
		'categories' => 'Катэгорыі',
		'content' => 'Змесціва',
		'date_from' => 'Ад',
		'date_modified' => 'Дата змянення на серверы',
		'date_past' => 'За апошнія',
		'date_published' => 'Дата публікацыі',
		'date_range' => 'Дыяпазон дат',
		'date_received' => 'Дата атрымання',
		'date_to' => 'Да',
		'date_user' => 'Дата змянення карыстальнікам',
		'feeds' => 'Стужкі',
		'free_text' => 'Вольны тэкст',
		'free_text_help' => 'Шукае і ў загалоўку, і ў змесціве',
		'full_documentation' => 'Праглядзець <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">поўную дакументацыю па пошуку</a>',
		'labels' => 'Мае меткі',
		'multiple_help' => 'Выберыце адзін або некалькі варыянтаў (утрымлівайце <kbd>Ctrl</kbd> або <kbd>Cmd</kbd>)',
		'sources' => 'Крыніцы',
		'tags' => 'Тэгі артыкулаў',
		'text' => 'Пошук па тэксце',
		'text_help' => 'Некалькі радкоў аб’ядноўваюцца лагічным <i>або</i>. Таксама падтрымліваюцца <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">рэгулярныя выразы</a>.',
		'text_placeholder' => 'Ключавое слова',
		'title' => 'Загаловак',
		'url' => 'URL-адрас',
		'user_queries' => 'Карыстальніцкія запыты',
	),
	'share' => array(
		'Known' => 'Вядомыя сайты',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Буфер абмену',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Электронная пошта',
		'email-webmail-firefox-fix' => 'Пошта (вэб-пошта — выпраўленне для Firefox)',
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
		'print' => 'Друк',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Сістэмнае абагульванне',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Увага!',
		'blank_to_disable' => 'Пакіньце пустым, каб адключыць',
		'by_author' => 'Аўтар:',
		'by_default' => 'Прадвызначана',
		'damn' => 'Трасца!',
		'default_category' => 'Без катэгорыі',
		'no' => 'Не',
		'not_applicable' => 'Недаступна',
		'ok' => 'Добра!',
		'or' => 'або',
		'yes' => 'Так',
	),
	'stream' => array(
		'load_more' => 'Паказаць яшчэ артыкулы',
		'mark_all_read' => 'Пазначыць усё як прачытанае',
		'nothing_to_load' => 'Больш няма артыкулаў',
	),
);

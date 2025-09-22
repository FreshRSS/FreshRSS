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
		'actualize' => 'Оновити стрічки',
		'add' => 'Додати',
		'back_to_rss_feeds' => '← Повернутися до RSS-стрічок',
		'cancel' => 'Скасувати',
		'close' => 'Закрити',
		'create' => 'Створити',
		'delete_all_feeds' => 'Видалити всі стрічки',
		'delete_errored_feeds' => 'Видалити стрічки з помилками',
		'delete_muted_feeds' => 'Видалити зупинені стрічки',
		'demote' => 'Забрати повноваження',
		'disable' => 'Вимкнути',
		'download' => 'Завантажити',
		'empty' => 'Спорожнити',
		'enable' => 'Увімкнути',
		'export' => 'Експортувати',
		'filter' => 'Фільтрувати',
		'import' => 'Імпортувати',
		'load_default_shortcuts' => 'Відновити типові клавіші',
		'manage' => 'Керувати',
		'mark_read' => 'Позначити прочитаними',
		'menu' => array(
			'open' => 'Відкрити меню',
		),
		'nav_buttons' => array(
			'next' => 'Наступна стаття',
			'prev' => 'Попередня стаття',
			'up' => 'Вгору',
		),
		'open_url' => 'Відкрити URL-адресу',
		'promote' => 'Підвищити',
		'purge' => 'Застосувати політику видалення',
		'refresh_opml' => 'Оновити OPML',
		'remove' => 'Вилучити',
		'rename' => 'Перейменувати',
		'see_website' => 'Переглянути вебсайт',
		'submit' => 'Надіслати',
		'truncate' => 'Видалити всі статті',
		'update' => 'Оновити',
	),
	'auth' => array(
		'accept_tos' => 'Погоджуюся з <a href="%s">умовами надання послуг</a>.',
		'email' => 'Адреса електронної пошти',
		'keep_logged_in' => 'Памʼятати мене <small>(%s днів)</small>',
		'login' => 'Увійти',
		'logout' => 'Вийти',
		'password' => array(
			'_' => 'Пароль',
			'format' => '<small>Принаймні 7 символів</small>',
		),
		'reauth' => array(
			'header' => 'Слід перезайти',
			'tip' => 'Система не проситиме вас перезаходити найближчі <u>%d хвилин</u>',
			'title' => 'Повторний вхід',
		),
		'registration' => array(
			'_' => 'Новий обліковий запис',
			'ask' => 'Створити обліковий запис?',
			'title' => 'Створення облікового запису',
		),
		'username' => array(
			'_' => 'Користувацьке імʼя',
			'format' => '<small>Максимум 16 латинських літер або цифер</small>',
		),
	),
	'date' => array(
		'Apr' => '\\к\\в\\і\\т\\н\\я',
		'Aug' => '\\с\\е\\р\\п\\н\\я',
		'Dec' => '\\г\\р\\у\\д\\н\\я',
		'Feb' => '\\л\\ю\\т\\о\\г\\о',
		'Jan' => '\\с\\і\\ч\\н\\я',
		'Jul' => '\\л\\и\\п\\н\\я',
		'Jun' => '\\ч\\е\\р\\в\\н\\я',
		'Mar' => '\\б\\е\\р\\е\\з\\н\\я',
		'May' => '\\т\\р\\а\\в\\н\\я',
		'Nov' => '\\л\\и\\с\\т\\о\\п\\а\\д\\а',
		'Oct' => '\\ж\\о\\в\\т\\н\\я',
		'Sep' => '\\в\\е\\р\\е\\с\\н\\я',
		'apr' => 'кві',
		'april' => 'квітня',
		'aug' => 'сер',
		'august' => 'серпня',
		'before_yesterday' => 'Раніше за вчора',
		'dec' => 'гру',
		'december' => 'грудня',
		'feb' => 'лют',
		'february' => 'лютого',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\о H\\:i',
		'fri' => 'Пт',
		'jan' => 'січ',
		'january' => 'січня',
		'jul' => 'лип',
		'july' => 'липня',
		'jun' => 'чер',
		'june' => 'червня',
		'last_2_year' => 'Минулі два роки',
		'last_3_month' => 'Минулі три місяці',
		'last_3_year' => 'Минулі три роки',
		'last_5_year' => 'Минулі пʼять років',
		'last_6_month' => 'Минулі шість місяців',
		'last_month' => 'Минулий місяць',
		'last_week' => 'Минулий тиждень',
		'last_year' => 'Минулий рік',
		'mar' => 'бер',
		'march' => 'березня',
		'may' => 'тра',
		'may_' => 'травня',
		'mon' => 'Пн',
		'month' => 'місяці',
		'nov' => 'лис',
		'november' => 'листопада',
		'oct' => 'жов',
		'october' => 'жовтня',
		'sat' => 'Сб',
		'sep' => 'вер',
		'september' => 'вересня',
		'sun' => 'Нд',
		'thu' => 'Чт',
		'today' => 'Сьогодні',
		'tue' => 'Вт',
		'wed' => 'Ср',
		'yesterday' => 'Вчора',
	),
	'dir' => 'ltr',	// IGNORE
	'flag' => '🇺🇦',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Про FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Порожня категорія',
		'confirm_action' => 'Точно виконати цю дію? Її неможливо скасувати!',
		'confirm_action_feed_cat' => 'Точно виконати цю дію? Ви втратите повʼязані вподобання й користувацькі запити. Дію неможливо скасувати!',
		'confirm_exit_slider' => 'Точно відкинути незбережені параметри?',
		'feedback' => array(
			'body_new_articles' => 'Наявні нові статті (%%d) у FreshRSS.',
			'body_unread_articles' => '(непрочитано: %%d)',
			'request_failed' => 'Не вдалося виконати запит. Можливо, інтернет-зʼєднання нестабільне.',
			'title_new_articles' => 'FreshRSS: нові статті!',
		),
		'labels_empty' => 'Міток нема',
		'new_article' => 'Наявні нові статті. Натисніть, щоб оновити сторінку.',
		'should_be_activated' => 'Слід увімкнути JavaScript',
		'unsafe_csp_header' => 'Через використовуваний CSP-заголовок FreshRSS під загрозою XSS-атак. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Переглянути документацію</a>',
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
		'uk' => 'Українська',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
		'zh-tw' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Про програму',
		'account' => 'Обліковий запис',
		'admin' => 'Адміністрування',
		'archiving' => 'Архівування',
		'authentication' => 'Вхід',
		'check_install' => 'Перевірка встановлення',
		'configuration' => 'Налаштування',
		'display' => 'Оформлення',
		'extensions' => 'Розширення',
		'logs' => 'Журнали',
		'privacy' => 'Приватність',
		'queries' => 'Користувацькі запити',
		'reading' => 'Читання',
		'search' => 'Шукати слова або #теги',
		'search_help' => 'Перегляньте документацію складніших <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">параметрів пошуку</a>',
		'sharing' => 'Поширення',
		'shortcuts' => 'Клавіші',
		'stats' => 'Статистика',
		'system' => 'Налаштування системи',
		'update' => 'Оновити',
		'user_management' => 'Керувати користувачами',
		'user_profile' => 'Профіль',
	),
	'period' => array(
		'days' => 'д.',
		'hours' => 'год',
		'months' => 'міс.',
		'weeks' => 'тижд',
		'years' => 'р.',
	),
	'share' => array(
		'Known' => 'Сайти на Known',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Копіювати посилання',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Електронна пошта',
		'email-webmail-firefox-fix' => 'Електронна пошта (веб-версія — виправлення для Firefox)',
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
		'print' => 'Друк',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Системне поширення',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Увага!',
		'blank_to_disable' => 'Щоб вимкнути, залиште порожнім',
		'by_author' => 'Від:',
		'by_default' => 'Типово',
		'damn' => 'Йой!',
		'default_category' => 'Без категорії',
		'no' => 'Ні',
		'not_applicable' => 'Недоступно',
		'ok' => 'Гаразд!',
		'or' => 'чи',
		'yes' => 'Так',
	),
	'stream' => array(
		'load_more' => 'Завантажити більше статей',
		'mark_all_read' => 'Позначити всі прочитаними',
		'nothing_to_load' => 'Більше статей нема',
	),
);

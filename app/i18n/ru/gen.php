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
		'actualize' => 'Обновить ленту',
		'add' => 'Добавить',
		'back_to_rss_feeds' => '← Вернуться к вашим RSS-лентам',
		'cancel' => 'Отменить',
		'close' => 'Close',	// TODO
		'create' => 'Создать',
		'delete_all_feeds' => 'Delete all feeds',	// TODO
		'delete_errored_feeds' => 'Delete feeds with errors',	// TODO
		'delete_muted_feeds' => 'Удалить заглушенные ленты',
		'demote' => 'Понизить',
		'disable' => 'Отключить',
		'download' => 'Download',	// TODO
		'empty' => 'Опустошить',
		'enable' => 'Включить',
		'export' => 'Экспортировать',
		'filter' => 'Отфильтровать',
		'import' => 'Импортировать',
		'load_default_shortcuts' => 'Загрузить горячие клавиши по умолчанию',
		'manage' => 'Настроить',
		'mark_read' => 'Отметить прочитанным',
		'menu' => array(
			'open' => 'Open menu',	// TODO
		),
		'nav_buttons' => array(
			'next' => 'Next article',	// TODO
			'prev' => 'Previous article',	// TODO
			'up' => 'Go up',	// TODO
		),
		'open_url' => 'Открыть URL',
		'promote' => 'Продвинуть',
		'purge' => 'Запустить очистку',
		'refresh_opml' => 'Обновить OPML',
		'remove' => 'Удалить',
		'rename' => 'Переименовать',
		'see_website' => 'Посмотреть на сайте',
		'submit' => 'Отправить',
		'truncate' => 'Удалить все статьи',
		'update' => 'Изменить',
	),
	'auth' => array(
		'accept_tos' => 'Я принимаю <a href="%s">Условия предоставления услуг</a>.',
		'email' => 'Адрес электронной почты',
		'keep_logged_in' => 'Не выходить из системы <small>(%s дней)</small>',
		'login' => 'Войти',
		'logout' => 'Выйти',
		'password' => array(
			'_' => 'Пароль',
			'format' => '<small>Не менее 7 символов</small>',
		),
		'reauth' => array(
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
		),
		'registration' => array(
			'_' => 'Новый аккаунт',
			'ask' => 'Создать аккаунт?',
			'title' => 'Создание аккаунта',
		),
		'username' => array(
			'_' => 'Имя пользователя',
			'format' => '<small>Не более 16 буквенно-цифровых символов</small>',
		),
	),
	'date' => array(
		'Apr' => '\\а\\п\\р\\е\\л\\я',
		'Aug' => '\\а\\в\\г\\у\\с\\т\\а',
		'Dec' => '\\д\\е\\к\\а\\б\\р\\я',
		'Feb' => '\\ф\\е\\в\\р\\а\\л\\я',
		'Jan' => '\\я\\н\\в\\а\\р\\я',
		'Jul' => '\\и\\ю\\л\\я',
		'Jun' => '\\и\\ю\\н\\я',
		'Mar' => '\\м\\а\\р\\т\\а',
		'May' => '\\м\\а\\я',
		'Nov' => '\\н\\о\\я\\б\\р\\я',
		'Oct' => '\\о\\к\\т\\я\\б\\р\\я',
		'Sep' => '\\с\\е\\н\\т\\я\\б\\р\\я',
		'apr' => 'апр',
		'april' => 'апреля',
		'aug' => 'авг',
		'august' => 'августа',
		'before_yesterday' => 'До вчерашнего дня',
		'dec' => 'дек',
		'december' => 'декабря',
		'feb' => 'фев',
		'february' => 'февраля',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\в H\\:i',	// IGNORE
		'fri' => 'Пт',
		'jan' => 'янв',
		'january' => 'января',
		'jul' => 'июл',
		'july' => 'июля',
		'jun' => 'июн',
		'june' => 'июня',
		'last_2_year' => 'Последние два года',
		'last_3_month' => 'Последние три месяца',
		'last_3_year' => 'Последние три года',
		'last_5_year' => 'Последние пять лет',
		'last_6_month' => 'Последние шесть месяцев',
		'last_month' => 'Последний месяц',
		'last_week' => 'Последняя неделя',
		'last_year' => 'Последний год',
		'mar' => 'мар',
		'march' => 'марта',
		'may' => 'мая',
		'may_' => 'май',
		'mon' => 'Пн',
		'month' => 'месяцы',
		'nov' => 'ноя',
		'november' => 'ноября',
		'oct' => 'окт',
		'october' => 'октября',
		'sat' => 'Сб',
		'sep' => 'сен',
		'september' => 'сентября',
		'sun' => 'Вс',
		'thu' => 'Чт',
		'today' => 'Сегодня',
		'tue' => 'Вт',
		'wed' => 'Ср',
		'yesterday' => 'Вчера',
	),
	'dir' => 'ltr',	// IGNORE
	'flag' => '🇷🇺',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'О FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Пустая категория',
		'confirm_action' => 'Вы уверены, что хотите выполнить это действие? Это нельзя отменить!',
		'confirm_action_feed_cat' => 'Вы уверены, что хотите выполнить это действие? Вы потеряете связанные избранные статьи и пользовательские запросы. Это нельзя отменить!',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => '%%d новых статей в FreshRSS.',
			'body_unread_articles' => '(Непрочитанные: %%d)',
			'request_failed' => 'Запрос не удался. Возможно, это вызвано проблемами с подключением к Интернет.',
			'title_new_articles' => 'FreshRSS: новые статьи!',
		),
		'labels_empty' => 'Нет меток',
		'new_article' => 'Появились новые статьи. Нажмите, чтобы обновить страницу.',
		'should_be_activated' => 'JavaScript должен быть включён',
		'unsafe_csp_header' => 'The CSP header in use is unsafe and FreshRSS may be vulnerable to XSS attacks. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">See documentation</a>',	// TODO
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
		'about' => 'О проекте',
		'account' => 'Аккаунт',
		'admin' => 'Администрирование',
		'archiving' => 'Архивирование',
		'authentication' => 'Аутентификация',
		'check_install' => 'Проверка установки',
		'configuration' => 'Конфигурация',
		'display' => 'Отображение',
		'extensions' => 'Расширения',
		'logs' => 'Журнал',
		'privacy' => 'Privacy',	// TODO
		'queries' => 'Пользовательские запросы',
		'reading' => 'Чтение',
		'search' => 'Искать слова или #теги',
		'search_help' => 'Дополнительные <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">параметры поиска</a> приведены в документации',
		'sharing' => 'Обмен',
		'shortcuts' => 'Горячие клавиши',
		'stats' => 'Статистика',
		'system' => 'Системные настройки',
		'update' => 'Обновление системы',
		'user_management' => 'Управление пользователями',
		'user_profile' => 'Профиль',
	),
	'period' => array(
		'days' => 'дней',
		'hours' => 'часов',
		'months' => 'месяцев',
		'weeks' => 'недель',
		'years' => 'лет',
	),
	'share' => array(
		'Known' => 'Сайты на Known',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Буфер обмена',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Электронная почта',
		'email-webmail-firefox-fix' => 'Электронная почта (webmail - правка для Firefox)',
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
		'print' => 'Распечатать',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Системный обмен',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Предупреждение!',
		'blank_to_disable' => 'Оставьте поле пустым, чтобы отключить',
		'by_author' => 'От:',
		'by_default' => 'По умолчанию',
		'damn' => 'О нет!',
		'default_category' => 'Без категории',
		'no' => 'Нет',
		'not_applicable' => 'Недоступно',
		'ok' => 'Отлично!',
		'or' => 'или',
		'yes' => 'Да',
	),
	'stream' => array(
		'load_more' => 'Загрузить больше статей',
		'mark_all_read' => 'Отметить всё прочитанным',
		'nothing_to_load' => 'Больше нет статей',
	),
);

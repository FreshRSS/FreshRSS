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
		'actualize' => 'Актуализировать ленту',
		'add' => 'Добавить',
		'back' => '← Вернуться',
		'back_to_rss_feeds' => '← Вернуться к вашим RSS-лентам',
		'cancel' => 'Отменить',
		'create' => 'Создать',
		'demote' => 'Понизить',
		'disable' => 'Отключить',
		'empty' => 'Пусто',
		'enable' => 'Включить',
		'export' => 'Экспортировать',
		'filter' => 'Фильтровать',
		'import' => 'Импортировать',
		'load_default_shortcuts' => 'Загрузить горячие клавиши по умолчанию',
		'manage' => 'Настроить',
		'mark_read' => 'Отметить прочитанным',
		'open_url' => 'Open URL',	// TODO
		'promote' => 'Продвинуть',
		'purge' => 'Запустить очистку',
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
		'Jan' => '\\я\\н\\в\\а\\р\\я\\y',
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
		'may' => 'май',
		'may_' => 'мая',
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
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'О FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Пустая категория',
		'confirm_action' => 'Вы уверены, что хотите выполнить это действие? Это нельзя отменить!',
		'confirm_action_feed_cat' => 'Вы уверены, что хотите выполнить это действие? Вы потеряете связанные избранные статьи и пользовательские запросы. Это нельзя отменить!',
		'feedback' => array(
			'body_new_articles' => '%%d новых статей в FreshRSS.',
			'body_unread_articles' => '(Непрочитанные: %%d)',
			'request_failed' => 'Запрос не удался. Возможно, это вызвано проблемами с подключением к Интернет.',
			'title_new_articles' => 'FreshRSS: новые статьи!',
		),
		'new_article' => 'Появились новые статьи. Нажмите, чтобы обновить страницу.',
		'should_be_activated' => 'JavaScript должен быть включён',
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
		'about' => 'О проекте',
		'account' => 'Аккаунт',
		'admin' => 'Администрирование',
		'archiving' => 'Архивирование',
		'authentication' => 'Аутентификация',
		'check_install' => 'Проверка установки',
		'configuration' => 'Конфигурация',
		'display' => 'Отображение',
		'extensions' => 'Расширения',
		'logs' => 'Логи',
		'queries' => 'Пользовательские запросы',
		'reading' => 'Чтение',
		'search' => 'Искать слова или #теги',
		'sharing' => 'Поделиться',
		'shortcuts' => 'Горячие клавиши',
		'stats' => 'Статистика',
		'system' => 'Системные настройки',
		'update' => 'Обновление системы',
		'user_management' => 'Управление пользователями',
		'user_profile' => 'Профиль',
	),
	'pagination' => array(
		'first' => 'Первая',
		'last' => 'Последняя',
		'next' => 'Следующая',
		'previous' => 'Предыдущая',
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
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Буфер обмена',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Электронная почта',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'Распечатать',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
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

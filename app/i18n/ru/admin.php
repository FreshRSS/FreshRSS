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
	'auth' => array(
		'allow_anonymous' => 'Разрешить анонимное чтение статей пользователя по умолчанию (%s)',
		'allow_anonymous_refresh' => 'Разрешить анонимное обновление статей',
		'api_enabled' => 'Позволить <abbr>API</abbr> доступ <small>(необходимо для мобильных приложений and sharing user queries)</small>',
		'form' => 'Веб-форма (традиционный, необходим JavaScript)',
		'http' => 'HTTP (продвинутый: управляется веб-сервером, OIDC, SSO…)',
		'none' => 'Без аутентификации (небезопасно)',
		'title' => 'Аутентификации',
		'token' => 'Главный токен аутентификации',
		'token_help' => 'Обеспечивает доступ ко всем выходным данным RSS пользователя, а также к обновлению лент без проверки подлинности:',
		'type' => 'Способ аутентификации',
	),
	'extensions' => array(
		'author' => 'Автор',
		'community' => 'Доступные расширения сообщества',
		'description' => 'Описание',
		'disabled' => 'Отключены',
		'empty_list' => 'Нет установленных расширений',
		'empty_list_help' => 'Проверьте логи, чтобы определить причину пустого списка расширений.',
		'enabled' => 'Включены',
		'is_compatible' => 'Совместимо',
		'latest' => 'Установлено',
		'name' => 'Название',
		'no_configure_view' => 'Это расширение не требует настройки.',
		'system' => array(
			'_' => 'Системные расширения',
			'no_rights' => 'Системное расширение (у вас нет необходимых разрешений)',
		),
		'title' => 'Расширения',
		'update' => 'Доступно обновление',
		'user' => 'Расширения пользователя',
		'version' => 'Версия',
	),
	'stats' => array(
		'_' => 'Статистика',
		'all_feeds' => 'Все подписки',
		'category' => 'Категория',
		'date_published' => 'Дата публикации',
		'date_received' => 'Дата получения',
		'entry_count' => 'Количество статей',
		'entry_per_category' => 'Статей в категории',
		'entry_per_day' => 'Статей за день (за последние 30 дней)',
		'entry_per_day_of_week' => 'За неделю (в среднем %.2f сообщений)',
		'entry_per_hour' => 'За час (в среднем %.2f сообщений)',
		'entry_per_month' => 'За месяц (в среднем %.2f сообщений)',
		'entry_repartition' => 'Расределение статей',
		'feed' => 'Лента',
		'feed_per_category' => 'Лент в категории',
		'idle' => 'Неактивные ленты',
		'main' => 'Основная статистика',
		'main_stream' => 'Основной поток',
		'nb_unreads' => 'Количество непрочитанных статей',
		'no_idle' => 'Нет неактивных лент!',
		'number_entries' => 'статей: %d',
		'overview' => 'Обзор',
		'percent_of_total' => '% от всего',
		'repartition' => 'Распределение статей: %s',
		'status_favorites' => 'В избранном',
		'status_read' => 'Прочитано',
		'status_total' => 'Всего',
		'status_unread' => 'Не прочитано',
		'title' => 'Статистика',
		'top_feed' => '10 лучших лент',
		'unread_dates' => 'Даты с наибольшим количеством непрочитанных статей',
	),
	'system' => array(
		'_' => 'Системные настройки',
		'auto-update-url' => 'URL сервера для автоматического обновления',
		'base-url' => array(
			'_' => 'Основной URL-адрес',
			'recommendation' => 'Автоматическая рекомендация: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => 'в секундах',
			'number' => 'Оставаться в системе на протяжении',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
		'force_email_validation' => 'Обязать подтверждать адрес электронной почты',
		'instance-name' => 'Название экземпляра',
		'max-categories' => 'Максимальное количество категорий на пользователя',
		'max-feeds' => 'Максимальное количество лент на пользователя',
		'registration' => array(
			'number' => 'Максимальное количество аккаунтов',
			'select' => array(
				'label' => 'Форма регистрации',
				'option' => array(
					'noform' => 'Отключено: Нет формы регистрации',
					'nolimit' => 'Включено: Нет ограничения аккаунтов',
					'setaccountsnumber' => 'Установить максимальное количество аккаунтов',
				),
			),
			'status' => array(
				'disabled' => 'Форма отключена',
				'enabled' => 'Форма включена',
			),
			'title' => 'Форма регистрации пользователей',
		),
		'sensitive-parameter' => 'Важный параметр. Отредактируйте вручную в <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'не указан',
			'enabled' => '<a href="./?a=tos">включен</a>',
			'help' => 'Как <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">включить Условия предоставления услуг</a>',
		),
		'websub' => array(
			'help' => 'О <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => 'Обновление системы',
		'apply' => 'Применить',
		'changelog' => 'Список изменений',
		'check' => 'Проверить обновления',
		'copiedFromURL' => 'update.php скопирован из %s в ./data',
		'current_version' => 'Ваша текущая версия',
		'last' => 'Последняя проверка',
		'loading' => 'Обновление…',
		'none' => 'Нет обновлений',
		'releaseChannel' => array(
			'_' => 'Релизный канал',
			'edge' => 'Плавающий релиз (“edge”)',
			'latest' => 'Стабильный релиз (“latest”)',
		),
		'title' => 'Обновить систему',
		'viaGit' => 'Обновление с помощью git и GitHub.com запущено',
	),
	'user' => array(
		'admin' => 'Администратор',
		'article_count' => 'Статей',
		'back_to_manage' => '← Вернуться к списку пользователей',
		'create' => 'Создать нового пользователя',
		'database_size' => 'Размер базы данных',
		'email' => 'Адрес электронной почты',
		'enabled' => 'Включён',
		'feed_count' => 'Лент',
		'is_admin' => 'Является администратором',
		'language' => 'Язык',
		'last_user_activity' => 'Последняя активность',
		'list' => 'Список пользователей',
		'number' => 'Имеется %d созданный аккаунт',
		'numbers' => 'Имеется %d созданных аккаунтов',
		'password_form' => 'Пароль<br /><small>(для входа через веб-форму)</small>',
		'password_format' => 'Не менее 7 символов',
		'title' => 'Управление пользователями',
		'username' => 'Имя пользователя',
	),
);

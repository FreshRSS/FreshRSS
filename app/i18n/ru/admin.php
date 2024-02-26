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

return [
	'auth' => [
		'allow_anonymous' => 'Разрешить анонимное чтение статей пользователя по умолчанию (%s)',
		'allow_anonymous_refresh' => 'Разрешить анонимное обновление статей',
		'api_enabled' => 'Позволить <abbr>API</abbr> доступ <small>(необходимо для мобильных приложений)</small>',
		'form' => 'Веб-форма (традиционный, необходим JavaScript)',
		'http' => 'HTTP (для опытных пользователей с HTTPS)',
		'none' => 'Без аутентификации (небезопасно)',
		'title' => 'Аутентификации',
		'token' => 'Master authentication token',	// TODO
		'token_help' => 'Allows access to all RSS outputs of the user as well as refreshing feeds without authentication:',	// TODO
		'type' => 'Способ аутентификации',
		'unsafe_autologin' => 'Разрешить небезопасный автоматический вход с использованием следующего формата: ',
	],
	'check_install' => [
		'cache' => [
			'nok' => 'Проверьте права доступа к папке <em>./data/cache</em>. Веб-сервер должен иметь право на запись в эту папку',
			'ok' => 'Права на <em>./data/cache</em> в порядке.',
		],
		'categories' => [
			'nok' => 'Таблица категорий настроена неправильно.',
			'ok' => 'Таблица категорий настроена правильно.',
		],
		'connection' => [
			'nok' => 'Подключение к базе данных не может быть установлено.',
			'ok' => 'Подключение к базе данных в порядке.',
		],
		'ctype' => [
			'nok' => 'У вас не установлена библиотека для проверки типов символов (php-ctype).',
			'ok' => 'У вас не установлена библиотека для проверки типов символов (ctype).',
		],
		'curl' => [
			'nok' => 'У вас не установлено расширение cURL (пакет php-curl).',
			'ok' => 'У вас установлено расширение cURL.',
		],
		'data' => [
			'nok' => 'Проверьте права доступа к папке <em>./data</em> . Веб-сервер должен иметь право на запись в эту папку.',
			'ok' => 'Права на <em>./data/</em> в порядке.',
		],
		'database' => 'Установка базы данных',
		'dom' => [
			'nok' => 'У вас не установлена библиотека для просмотра DOM (пакет php-xml).',
			'ok' => 'У вас установлена библиотека для просмотра DOM.',
		],
		'entries' => [
			'nok' => 'Таблица статей (entry) неправильно настроена.',
			'ok' => 'Таблица статей (entry) настроена правильно.',
		],
		'favicons' => [
			'nok' => 'Проверьте права доступа к папке <em>./data/favicons</em> . Веб-сервер должен иметь право на запись в эту папку.',
			'ok' => 'Права на папку значков в порядке.',
		],
		'feeds' => [
			'nok' => 'Таблица подписок (feed) неправильно настроена.',
			'ok' => 'Таблица подписок (feed) настроена правильно.',
		],
		'fileinfo' => [
			'nok' => 'У вас не установлено расширение PHP fileinfo (пакет fileinfo).',
			'ok' => 'У вас установлено расширение fileinfo.',
		],
		'files' => 'Установка файлов',
		'json' => [
			'nok' => 'У вас не установлена библиотека для работы с JSON (пакет php-json).',
			'ok' => 'У вас установлена библиотека для работы с JSON.',
		],
		'mbstring' => [
			'nok' => 'У вас не установлена рекомендуемая библиотека mbstring для Unicode.',
			'ok' => 'У вас установлена рекомендуемая библиотека mbstring для Unicode.',
		],
		'pcre' => [
			'nok' => 'У вас не установлена необходимая библиотека для работы с регулярными выражениями (php-pcre).',
			'ok' => 'У вас установлена необходимая библиотека для работы с регулярными выражениями (PCRE).',
		],
		'pdo' => [
			'nok' => 'У вас не установлен PDO или один из необходимых драйверов (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'У вас установлен PDO и как минимум один из поддерживаемых драйверов (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		],
		'php' => [
			'_' => 'Инсталляция PHP',
			'nok' => 'У вас установлен PHP версии %s, но FreshRSS необходима версия не ниже %s.',
			'ok' => 'У вас установлен PHP версии %s, который совместим с FreshRSS.',
		],
		'tables' => [
			'nok' => 'В базе данных отсуствует одна или больше таблица.',
			'ok' => 'Все таблицы есть в базе данных.',
		],
		'title' => 'Проверка установки и настройки',
		'tokens' => [
			'nok' => 'Проверьте права доступа к папке <em>./data/tokens</em> . Веб-сервер должен иметь право на запись в эту папку.',
			'ok' => 'Права на папку tokens в порядке.',
		],
		'users' => [
			'nok' => 'Проверьте права доступа к папке <em>./data/users</em> . Веб-сервер должен иметь право на запись в эту папку.',
			'ok' => 'Права на папку users в порядке.',
		],
		'zip' => [
			'nok' => 'У вас не установлено расширение ZIP (пакет php-zip).',
			'ok' => 'У вас установлено расширение ZIP.',
		],
	],
	'extensions' => [
		'author' => 'Автор',
		'community' => 'Доступные расширения сообщества',
		'description' => 'Описание',
		'disabled' => 'Отключены',
		'empty_list' => 'Нет установленных расширений',
		'enabled' => 'Включены',
		'latest' => 'Установлено',
		'name' => 'Название',
		'no_configure_view' => 'Это расширение не требует настройки.',
		'system' => [
			'_' => 'Системные расширения',
			'no_rights' => 'Системное расширение (у вас нет необходимых разрешений)',
		],
		'title' => 'Расширения',
		'update' => 'Доступно обновление',
		'user' => 'Расширения пользователя',
		'version' => 'Версия',
	],
	'stats' => [
		'_' => 'Статистика',
		'all_feeds' => 'Все подписки',
		'category' => 'Категория',
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
		'no_idle' => 'Нет неактивных лент!',
		'number_entries' => 'статей: %d',
		'percent_of_total' => '% от всего',
		'repartition' => 'Распределение статей',
		'status_favorites' => 'В избранном',
		'status_read' => 'Прочитано',
		'status_total' => 'Всего',
		'status_unread' => 'Не прочитано',
		'title' => 'Статистика',
		'top_feed' => '10 лучших лент',
	],
	'system' => [
		'_' => 'Системные настройки',
		'auto-update-url' => 'URL сервера для автоматического обновления',
		'base-url' => [
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		],
		'cookie-duration' => [
			'help' => 'в секундах',
			'number' => 'Оставаться в системе на протяжении',
		],
		'force_email_validation' => 'Обязать подтверждать адрес электронной почты',
		'instance-name' => 'Название экземпляра',
		'max-categories' => 'Максимальное количество категорий на пользователя',
		'max-feeds' => 'Максимальное количество лент на пользователя',
		'registration' => [
			'number' => 'Максимальное количество аккаунтов',
			'select' => [
				'label' => 'Форма регистрации',
				'option' => [
					'noform' => 'Отключено: Нет формы регистрации',
					'nolimit' => 'Включено: Нет ограничения аккаунтов',
					'setaccountsnumber' => 'Установить максимальное количество аккаунтов',
				],
			],
			'status' => [
				'disabled' => 'Форма отключена',
				'enabled' => 'Форма включена',
			],
			'title' => 'Форма регистрации пользователей',
		],
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => [
			'disabled' => 'is not given',	// TODO
			'enabled' => '<a href="./?a=tos">is enabled</a>',	// TODO
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">enable the Terms of Service</a>',	// TODO
		],
		'websub' => [
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		],
	],
	'update' => [
		'_' => 'Обновление системы',
		'apply' => 'Применить',
		'changelog' => 'Changelog',	// TODO
		'check' => 'Проверить обновления',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => 'Ваша текущая версия',
		'last' => 'Последняя проверка',
		'loading' => 'Updating…',	// TODO
		'none' => 'Нет обновлений',
		'releaseChannel' => [
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		],
		'title' => 'Обновить систему',
		'viaGit' => 'Update via git and Github.com started',	// TODO
	],
	'user' => [
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
	],
];

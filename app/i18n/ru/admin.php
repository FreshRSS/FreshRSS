<?php

return array(
	'auth' => array(
		'allow_anonymous' => 'Разрешить анонимное чтение статей для пользователя по умолчанию (%s)',
		'allow_anonymous_refresh' => 'Разрешить анонимное обновление статей',
		'api_enabled' => 'Включить доступ к <abbr>API</abbr> <small>(необходимо для мобильных приложений)</small>',
		'form' => 'На основе веб-формы (традиционный, необходим JavaScript)',
		'http' => 'HTTP (для продвинутых пользователей - по HTTPS)',
		'none' => 'Без аутентификации (небезопасный)',
		'title' => 'Аутентификации',
		'title_reset' => 'Сброс аутентицикации',
		'token' => 'Токен аутентификации',
		'token_help' => 'Разрешает доступ к RSS ленте пользователя по умолчанию без аутентификации:',
		'type' => 'Метод аутентификации',
		'unsafe_autologin' => 'Разрешить небезопасный автоматический вход с использованием следующего формата: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Проверьте права доступа к папке <em>./data/cache</em>. Сервер HTTP должен иметь права на запись в эту папку',
			'ok' => 'Права на <em>./data/cache</em> в порядке.',
		),
		'categories' => array(
			'nok' => 'Таблица категорий настроена неправильно.',
			'ok' => 'Таблица категорий настроена правильно.',
		),
		'connection' => array(
			'nok' => 'Подключение к базе данных не может быть установлено.',
			'ok' => 'Подключение к базе данных в порядке.',
		),
		'ctype' => array(
			'nok' => 'У вас не установлена библиотека для проверки типов символов (php-ctype).',
			'ok' => 'У вас не установлена библиотека для проверки типов символов (ctype).',
		),
		'curl' => array(
			'nok' => 'У вас не установлено расширение cURL (пакет php-curl).',
			'ok' => 'У вас установлено расширение cURL.',
		),
		'data' => array(
			'nok' => 'Проверьте права доступа к папке <em>./data</em> . Сервер HTTP должен иметь права на запись в эту папку.',
			'ok' => 'Права на <em>./data/</em> в порядке.',
		),
		'database' => 'Установка базы данных',
		'dom' => array(
			'nok' => 'У вас не установлена библиотека для просмотра DOM (пакет php-xml).',
			'ok' => 'У вас установлена библиотека для просмотра DOM.',
		),
		'entries' => array(
			'nok' => 'Таблица статей (entry) неправильно настроена.',
			'ok' => 'Таблица статей (entry) настроена правильно.',
		),
		'favicons' => array(
			'nok' => 'Проверьте права доступа к папке <em>./data/favicons</em> . Сервер HTTP должен иметь права на запись в эту папку.',
			'ok' => 'Права на папку значков в порядке.',
		),
		'feeds' => array(
			'nok' => 'Таблица подписок (feed) неправильно настроена.',
			'ok' => 'Таблица подписок (feed) настроена правильно.',
		),
		'fileinfo' => array(
			'nok' => 'У вас не установлено расширение PHP fileinfo (пакет fileinfo).',
			'ok' => 'У вас установлено расширение fileinfo.',
		),
		'files' => 'Установка файлов',
		'json' => array(
			'nok' => 'У вас не установлена библиотека для работы с JSON (пакет php-json).',
			'ok' => 'У вас установлена библиотека для работы с JSON.',
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended mbstring library for Unicode.',	// TODO - Translation
			'ok' => 'You have the recommended mbstring library for Unicode.',	// TODO - Translation
		),
		'minz' => array(
			'nok' => 'У вас не установлен фрейворк Minz.',
			'ok' => 'У вас установлен фрейворк Minz.',
		),
		'pcre' => array(
			'nok' => 'У вас не установлена необходимая библиотека для работы с регулярными выражениями (php-pcre).',
			'ok' => 'У вас установлена необходимая библиотека для работы с регулярными выражениями (PCRE).',
		),
		'pdo' => array(
			'nok' => 'У вас не установлен PDO или один из необходимых драйверов (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'У вас установлен PDO и как минимум один из поддерживаемых драйверов (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'PHP installation',	// TODO - Translation
			'nok' => 'У вас установлен PHP версии %s, но FreshRSS необходима версия не ниже %s.',
			'ok' => 'У вас установлен PHP версии %s, который совместим с FreshRSS.',
		),
		'tables' => array(
			'nok' => 'В базе данных отсуствует одна или больше таблица.',
			'ok' => 'Все таблицы есть в базе данных.',
		),
		'title' => 'Проверка установки и настройки',
		'tokens' => array(
			'nok' => 'Проверьте права доступа к папке <em>./data/tokens</em> . Сервер HTTP должен иметь права на запись в эту папку.',
			'ok' => 'Права на папку tokens в порядке.',
		),
		'users' => array(
			'nok' => 'Проверьте права доступа к папке <em>./data/users</em> . Сервер HTTP должен иметь права на запись в эту папку.',
			'ok' => 'Права на папку users в порядке.',
		),
		'zip' => array(
			'nok' => 'You lack ZIP extension (php-zip package).',
			'ok' => 'You have ZIP extension.',	// TODO - Translation
		),
	),
	'extensions' => array(
		'author' => 'Author',	// TODO - Translation
		'community' => 'Available community extensions',	// TODO - Translation
		'description' => 'Description',	// TODO - Translation
		'disabled' => 'Отключены',
		'empty_list' => 'Расширения не установлены',
		'enabled' => 'Включены',
		'latest' => 'Installed',	// TODO - Translation
		'name' => 'Name',	// TODO - Translation
		'no_configure_view' => 'Это расширение нельзя настроить.',
		'system' => array(
			'_' => 'Системные расширения',
			'no_rights' => 'Системные расширения (у вас нет к ним доступа)',
		),
		'title' => 'Расширения',
		'update' => 'Update available',	// TODO - Translation
		'user' => 'Расширения пользователя',
		'version' => 'Version',	// TODO - Translation
	),
	'stats' => array(
		'_' => 'Статистика',
		'all_feeds' => 'Все подписки',
		'category' => 'Категория',
		'entry_count' => 'Количество статей',
		'entry_per_category' => 'Статей в категории',
		'entry_per_day' => 'Статей за день (за последние 30 дней)',
		'entry_per_day_of_week' => 'За неделю (в среднем - %.2f сообщений)',
		'entry_per_hour' => 'За час (в среднем - %.2f сообщений)',
		'entry_per_month' => 'За месяц (в среднем - %.2f сообщений)',
		'entry_repartition' => 'Перерасределение статей',
		'feed' => 'Подписка',
		'feed_per_category' => 'Подписок в категории',
		'idle' => 'Неактивные подписки',
		'main' => 'Основная статистика',
		'main_stream' => 'Основной поток',
		'menu' => array(
			'idle' => 'Неактивные подписки',
			'main' => 'Основная статистика',
			'repartition' => 'Перерасределение статей',
		),
		'no_idle' => 'Нет неактивных подписок!',
		'number_entries' => 'статей: %d',
		'percent_of_total' => '%% от всего',
		'repartition' => 'Перераспределение статей',
		'status_favorites' => 'Избранное',
		'status_read' => 'Читать',
		'status_total' => 'Всего',
		'status_unread' => 'Не прочитано',
		'title' => 'Статистика',
		'top_feed' => '10 лучших подписок',
	),
	'system' => array(
		'_' => 'Системные настройки',
		'auto-update-url' => 'Адрес сервера для автоматического обновления',
		'cookie-duration' => array(
			'help' => 'in seconds',	// TODO - Translation
			'number' => 'Duration to keep logged in',	// TODO - Translation
		),
		'force_email_validation' => 'Force email address validation',	// TODO - Translation
		'instance-name' => 'Название этого сервера',
		'max-categories' => 'Количество категорий на пользователя',
		'max-feeds' => 'Количество статей на пользователя',
		'registration' => array(
			'help' => '0 означает неограниченное количество пользователей',
			'number' => 'Максимальное количество пользователей',
		),
	),
	'update' => array(
		'_' => 'Обновление системы',
		'apply' => 'Применить',
		'check' => 'Проверить обновления',
		'current_version' => 'Ваша текущая версия FreshRSS: %s.',
		'last' => 'Последняя проверка: %s',
		'none' => 'Нечего обновлять',
		'title' => 'Обновить систему',
	),
	'user' => array(
		'admin' => 'Administrator',	// TODO - Translation
		'article_count' => 'Articles',	// TODO - Translation
		'articles_and_size' => '%s статей (%s)',
		'back_to_manage' => '← Return to user list',	// TODO - Translation
		'create' => 'Создать нового пользователя',
		'database_size' => 'Database size',	// TODO - Translation
		'delete_users' => 'Delete user',	// TODO - Translation
		'email' => 'Email address',	// TODO - Translation
		'enabled' => 'Enabled',	// TODO - Translation
		'feed_count' => 'Feeds',	// TODO - Translation
		'is_admin' => 'Is admin',	// TODO - Translation
		'language' => 'Язык',
		'last_user_activity' => 'Last user activity',	// TODO - Translation
		'list' => 'User list',	// TODO - Translation
		'number' => 'На данный момент создан %d аккаунт',
		'numbers' => 'На данный момент аккаунтов создано:	%d',
		'password_form' => 'Пароль<br /><small>(для входа через Веб-форму)</small>',
		'password_format' => 'Минимум 7 символов',
		'selected' => 'Selected user',	// TODO - Translation
		'title' => 'Управление пользователями',
		'update_users' => 'Update user',	// TODO - Translation
		'user_list' => 'Список пользователей',
		'username' => 'Имя пользователя',
		'users' => 'Пользователи',
	),
);

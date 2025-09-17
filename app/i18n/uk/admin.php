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
	'auth' => array(
		'allow_anonymous' => 'Дозволити анонімне читання статей типового користувача (%s)',
		'allow_anonymous_refresh' => 'Дозволити анонімне оновлення статей',
		'api_enabled' => 'Дозволити доступ через <abbr>API</abbr> <small>(треба для мобільних програм і поширення користувацьких запитів)</small>',
		'form' => 'Вебформа (традиційно, треба JavaScript)',
		'http' => 'HTTP (складно: за допомогою вебсервера, OIDC, SSO…)',
		'none' => 'Нема (небезпечно)',
		'title' => 'Вхід',
		'token' => 'Головний токен входу',
		'token_help' => 'Надає доступ до всіх RSS-видач користувача, а також дає змогу оновлювати стрічки без входу:',
		'type' => 'Тип входу',
		'unsafe_autologin' => 'Дозволити небезпечний автоматичний вхід у форматі: ',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => 'Перевірте доступ до каталога <em>./data/cache</em>. HTTP-серверу треба дозвіл на запис.',
			'ok' => 'Доступ до каталога кешу працює.',
		),
		'categories' => array(
			'nok' => 'Таблицю категорій хибно налаштовано.',
			'ok' => 'З таблицею категорій усе гаразд.',
		),
		'connection' => array(
			'nok' => 'Не вдалося зʼєднатися з базою даних.',
			'ok' => 'Доступ до бази даних працює.',
		),
		'ctype' => array(
			'nok' => 'Не вдалося знайти необхідну бібліотеку перевірки типу символа (php-ctype).',
			'ok' => 'У вас є необхідна бібліотека перевірки типу символа (ctype).',
		),
		'curl' => array(
			'nok' => 'Не вдалося знайти бібліотеку cURL (пакунок php-curl).',
			'ok' => 'У вас є бібліотека cURL.',
		),
		'data' => array(
			'nok' => 'Перевірте доступ до каталога <em>./data</em>. HTTP-серверу треба дозвіл на запис.',
			'ok' => 'Доступ до каталога даних працює.',
		),
		'database' => 'Встановлення бази даних',
		'dom' => array(
			'nok' => 'Не вдалося знайти необхідну бібліотеку роботи з DOM (пакунок php-xml).',
			'ok' => 'У вас є необхідна бібліотека роботи з DOM.',
		),
		'entries' => array(
			'nok' => 'Таблицю новин хибно налаштовано.',
			'ok' => 'З таблицею новин усе гаразд.',
		),
		'favicons' => array(
			'nok' => 'Перевірте доступ до каталога <em>./data/favicons</em>. HTTP-серверу треба дозвіл на запис.',
			'ok' => 'Доступ до каталога піктограм працює.',
		),
		'feeds' => array(
			'nok' => 'Таблицю стрічок хибно налаштовано.',
			'ok' => 'З таблицею стрічок усе гаразд.',
		),
		'fileinfo' => array(
			'nok' => 'Не вдалося знайти бібліотеку PHP fileinfo (пакунок fileinfo).',
			'ok' => 'У вас є бібліотека fileinfo.',
		),
		'files' => 'Встановлення файлів',
		'json' => array(
			'nok' => 'Не вдалося знайти розширення JSON (пакунок php-json).',
			'ok' => 'У вас є розширення JSON.',
		),
		'mbstring' => array(
			'nok' => 'Не вдалося знайти бажаної бібліотеки mbstring для Юнікоду.',
			'ok' => 'У вас є бажана бібліотека mbstring для Юнікоду.',
		),
		'pcre' => array(
			'nok' => 'Не вдалося знайти необхідної бібліотеки регулярних виразів (php-pcre).',
			'ok' => 'У вас є необхідна бібліотека регулярних виразів (PCRE).',
		),
		'pdo' => array(
			'nok' => 'Не вдалося знайти PDO чи одного з підтримуваних драйверів (pdo_mysql, pdo_sqlite чи pdo_pgsql).',
			'ok' => 'У вас є PDO та принаймні один підтримуваний драйвер (pdo_mysql, pdo_sqlite чи pdo_pgsql).',
		),
		'php' => array(
			'_' => 'Встановлення PHP',
			'nok' => 'У вас PHP версії %s, але для FreshRSS треба принаймні %s.',
			'ok' => 'Версія PHP (%s) сумісна з FreshRSS.',
		),
		'tables' => array(
			'nok' => 'У базі даних бракує принаймні одної таблиці.',
			'ok' => 'Відповідні таблиці наявні в базі даних.',
		),
		'title' => 'Перевірка встановлення',
		'tokens' => array(
			'nok' => 'Перевірте доступ до каталога <em>./data/tokens</em>. HTTP-серверу треба дозвіл на запис',
			'ok' => 'Доступ до каталога токенів працює.',
		),
		'users' => array(
			'nok' => 'Перевірте доступ до каталога <em>./data/users</em>. HTTP-серверу треба дозвіл на запис',
			'ok' => 'Доступ до користувацького каталога працює.',
		),
		'zip' => array(
			'nok' => 'Не вдалося знайти ZIP-розширення (пакунок php-zip).',
			'ok' => 'У вас є ZIP-розширення.',
		),
	),
	'extensions' => array(
		'author' => 'Автор',
		'community' => 'Доступні розширення спільноти',
		'description' => 'Опис',
		'disabled' => 'Вимкнено',
		'empty_list' => 'Розширень не встановлено',
		'empty_list_help' => 'Щоб виявити причину порожнього списку розширень, перегляньте журнали.',
		'enabled' => 'Увімкнено',
		'latest' => 'Встановлено',
		'name' => 'Назва',
		'no_configure_view' => 'Розширення не налаштовується.',
		'system' => array(
			'_' => 'Системні розширення',
			'no_rights' => 'Системне розширення (вам бракує дозволу)',
		),
		'title' => 'Розширення',
		'update' => 'Наявне оновлення',
		'user' => 'Користувацькі розширення',
		'version' => 'Версія',
	),
	'stats' => array(
		'_' => 'Статистика',
		'all_feeds' => 'Всі стрічки',
		'category' => 'Категорія',
		'entry_count' => 'Кількість статей',
		'entry_per_category' => 'Статей у категорії',
		'entry_per_day' => 'Статей за день (минулі 30 днів)',
		'entry_per_day_of_week' => 'За день тижня (в середньому повідомлень: %.2f)',
		'entry_per_hour' => 'За годину (в середньому статей: %.2f)',
		'entry_per_month' => 'За місяць (у середньому статей: %.2f)',
		'entry_repartition' => 'Перерозподіл статей',
		'feed' => 'Стрічка',
		'feed_per_category' => 'Стрічок у категорії',
		'idle' => 'Неактивні стрічки',
		'main' => 'Основна статистика',
		'main_stream' => 'Головний потік',
		'no_idle' => 'Неактивних стрічок нема!',
		'number_entries' => 'Статей: %d',
		'overview' => 'Огляд',
		'percent_of_total' => '% від загальної кількості',
		'repartition' => 'Перерозподіл статей: %s',
		'status_favorites' => 'Вподобано',
		'status_read' => 'Прочитано',
		'status_total' => 'Усього',
		'status_unread' => 'Непрочитано',
		'title' => 'Статистика',
		'top_feed' => 'Десять найактивніших стрічок',
	),
	'system' => array(
		'_' => 'Налаштування системи',
		'auto-update-url' => 'URL-адреса сервера автоматичного оновлення',
		'base-url' => array(
			'_' => 'Базова URL-адреса',
			'recommendation' => 'Автоматична порада: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => 'секунд',
			'number' => 'Тривалість сеансу',
		),
		'force_email_validation' => 'Підтверджувати адресу електронної пошти',
		'instance-name' => 'Назва сервера',
		'max-categories' => 'Максимум категорій у користувача',
		'max-feeds' => 'Максимум стрічок у користувача',
		'registration' => array(
			'number' => 'Максимум облікових записів',
			'select' => array(
				'label' => 'Форма реєстрації',
				'option' => array(
					'noform' => 'Вимкнено: форма реєстрації недоступна',
					'nolimit' => 'Увімкнено: кількість облікових записів необмежена',
					'setaccountsnumber' => 'Обмежити кількість облікових записів',
				),
			),
			'status' => array(
				'disabled' => 'Форму вимкнено',
				'enabled' => 'Форму ввімкнено',
			),
			'title' => 'Форма користувацької реєстрації',
		),
		'sensitive-parameter' => 'Чутливий параметр. Відредагуйте вручну в <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => 'вимкнено',
			'enabled' => '<a href="./?a=tos">налаштовано</a>',
			'help' => 'Як <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">налаштувати умови надання послуг</a>',
		),
		'websub' => array(
			'help' => 'Про <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => 'Оновити FreshRSS',
		'apply' => 'Почати оновлення',
		'changelog' => 'Журнал змін',
		'check' => 'Пошукати оновлення',
		'copiedFromURL' => 'update.php скопійовано з %s до ./data',
		'current_version' => 'Поточна встановлена версія',
		'last' => 'Минула перевірка',
		'loading' => 'Оновлення…',
		'none' => 'Нема доступних оновлень',
		'releaseChannel' => array(
			'_' => 'Канал випусків',
			'edge' => 'Крайній випуск («edge»)',
			'latest' => 'Стабільний випуск («latest»)',
		),
		'title' => 'Оновити FreshRSS',
		'viaGit' => 'Розпочато оновлення за допомогою git і GitHub.com',
	),
	'user' => array(
		'admin' => 'Адміністратор',
		'article_count' => 'Статей',
		'back_to_manage' => '← Повернутися до списку користувачів',
		'create' => 'Створити користувача',
		'database_size' => 'Розмір бази даних',
		'email' => 'Адреса електронної пошти',
		'enabled' => 'Увімкнено',
		'feed_count' => 'Стрічок',
		'is_admin' => 'Адміністратор',
		'language' => 'Мова',
		'last_user_activity' => 'Найновіша активність',
		'list' => 'Список користувачів',
		'number' => 'Створено %d обліковий запис',
		'numbers' => 'Створено облікових записів: %d',
		'password_form' => 'Пароль<br /><small>(для входу через вебформу)</small>',
		'password_format' => 'Принаймні 7 символів',
		'title' => 'Керувати користувачами',
		'username' => 'Користувацьке імʼя',
	),
);

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
		'finish' => 'Завершити встановлення',
		'fix_errors_before' => 'Перш ніж почати наступний крок, слід виправити всі помилки.',
		'keep_install' => 'Зберегти попереднє налаштування',
		'next_step' => 'Почати наступний крок',
		'reinstall' => 'Перевстановити FreshRSS',
	),
	'bdd' => array(
		'_' => 'База даних',
		'conf' => array(
			'_' => 'Налаштування бази даних',
			'ko' => 'Перевірте налаштування бази даних.',
			'ok' => 'Налаштування бази даних збережено.',
		),
		'host' => 'Хост',
		'password' => 'Пароль до бази даних',
		'prefix' => 'Префікс таблиць',
		'type' => 'Тип бази даних',
		'username' => 'Користувацьке імʼя бази даних',
	),
	'check' => array(
		'_' => 'Перевірки',
		'already_installed' => 'Виявлено вже встановлену FreshRSS!',
		'cache' => array(
			'nok' => 'Перевірте доступ до каталога <em>%1$s</em> для користувача <em>%2$s</em>. HTTP-серверу потрібен дозвіл на запис.',
			'ok' => 'Доступ до каталога кешу працює.',
		),
		'ctype' => array(
			'nok' => 'Не вдалося знайти необхідної бібліотеки перевірки типу символа (php-ctype).',
			'ok' => 'У вас є необхідна бібліотека перевірки типу символа (ctype).',
		),
		'curl' => array(
			'nok' => 'Не вдалося знайти бібліотеку cURL (пакунок php-curl).',
			'ok' => 'У вас є бібліотека cURL.',
		),
		'data' => array(
			'nok' => 'Перевірте доступ до каталога <em>%1$s</em> для користувача <em>%2$s</em>. HTTP-серверу потрібен дозвіл на запис.',
			'ok' => 'Доступ до каталога даних працює.',
		),
		'dom' => array(
			'nok' => 'Не вдалося знайти необхідну бібліотеку роботи з DOM.',
			'ok' => 'У вас є необхідна бібліотека роботи з DOM.',
		),
		'favicons' => array(
			'nok' => 'Перевірте доступ до каталога <em>%1$s</em> для користувача <em>%2$s</em>. HTTP-серверу потрібен дозвіл на запис.',
			'ok' => 'Доступ до каталога favicons працює.',
		),
		'fileinfo' => array(
			'nok' => 'Не вдалося знайти бібліотеку PHP fileinfo (пакунок fileinfo).',
			'ok' => 'У вас є бібліотека fileinfo.',
		),
		'files' => 'Встановлення файлів',
		'intl' => array(
			'nok' => 'Cannot find the recommended library php-intl for internationalisation.',	// TODO
			'ok' => 'You have the recommended library php-intl for internationalisation.',	// TODO
		),
		'json' => array(
			'nok' => 'Не вдалося знайти бажану бібліотеку розпізнання JSON.',
			'ok' => 'У вас є бажана бібліотека розпізнання JSON.',
		),
		'mbstring' => array(
			'nok' => 'Не вдалося знайти бажану бібліотеку mbstring для Юнікоду.',
			'ok' => 'У вас є бажана бібліотека mbstring для Юнікоду.',
		),
		'pcre' => array(
			'nok' => 'Не вдалося знайти необхідну бібліотеку регулярних виразів (php-pcre).',
			'ok' => 'У вас є необхідна бібліотека регулярних виразів (PCRE).',
		),
		'pdo-mysql' => array(
			'nok' => 'Cannot find the required PDO driver for MySQL/MariaDB.',	// TODO
		),
		'pdo-pgsql' => array(
			'nok' => 'Cannot find the required PDO driver for PostgreSQL.',	// TODO
		),
		'pdo-sqlite' => array(
			'nok' => 'Cannot find the PDO driver for SQLite.',	// TODO
			'ok' => 'You have the PDO driver for SQLite.',	// TODO
		),
		'pdo' => array(
			'nok' => 'Не вдалося знайти PDO чи один із підтримуваних драйверів (pdo_mysql, pdo_sqlite чи pdo_pgsql).',
			'ok' => 'У вас є PDO та принаймні один із підтримуваних драйверів (pdo_mysql, pdo_sqlite чи pdo_pgsql).',
		),
		'php' => array(
			'_' => 'Встановлення PHP',
			'nok' => 'У вас PHP версії %s, але для FreshRSS треба принаймні %s.',
			'ok' => 'Версія PHP (%s) сумісна з FreshRSS.',
		),
		'reload' => 'Повторити перевірку',
		'tmp' => array(
			'nok' => 'Перевірте доступ до каталога <em>%1$s</em> для користувача <em>%2$s</em>. HTTP-серверу потрібен дозвіл на запис.',
			'ok' => 'Доступ до тимчасового каталога працює.',
		),
		'tokens' => array(
			'nok' => 'Перевірте доступ до каталога <em>./data/tokens</em>. HTTP-серверу треба дозвіл на запис',
			'ok' => 'Доступ до каталога токенів працює.',
		),
		'unknown_process_username' => 'невідомо',
		'users' => array(
			'nok' => 'Перевірте доступ до каталога <em>%1$s</em> для користувача <em>%2$s</em>. HTTP-серверу потрібен дозвіл на запис.',
			'ok' => 'Доступ до користувацького каталога працює.',
		),
		'xml' => array(
			'nok' => 'Не вдалося знайти необхідну бібліотеку розпізнання XML.',
			'ok' => 'У вас є необхідна бібліотека розпізнання XML.',
		),
		'zip' => array(
			'nok' => 'Не вдалося знайти ZIP-розширення (пакунок php-zip).',
			'ok' => 'У вас є ZIP-розширення.',
		),
	),
	'conf' => array(
		'_' => 'Загальне налаштування',
		'ok' => 'Загальне налаштування збережено.',
	),
	'congratulations' => 'Вітаємо!',
	'default_user' => array(
		'_' => 'Імʼя типового користувача',
		'max_char' => 'максимум 16 латинських літер і цифр',
	),
	'fix_errors_before' => 'Перш ніж перейти до наступного кроку, слід виправити помилки.',
	'javascript_is_better' => 'FreshRSS зручніше, коли JavaScript увімкнено',
	'js' => array(
		'confirm_reinstall' => 'Перевстановлення FreshRSS призведе до втрати налаштувань. Точно продовжити?',
	),
	'language' => array(
		'_' => 'Мова',
		'choose' => 'Оберіть мову FreshRSS',
		'defined' => 'Мову визначено.',
	),
	'missing_applied_migrations' => 'Щось пішло не так; створіть порожній файл <em>%s</em> вручну.',
	'ok' => 'Встановлення успішне.',
	'session' => array(
		'nok' => 'Схоже, вебсервер має хибні налаштування кукі для PHP-сеансів!',
	),
	'step' => 'крок %d',
	'steps' => 'Кроки',
	'this_is_the_end' => 'Готово',
	'title' => 'Встановлення · FreshRSS',
);

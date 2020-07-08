<?php

return array(
	'action' => array(
		'finish' => 'Завершить установку',
		'fix_errors_before' => 'Пожалуйста, исправьте ошибки прежде чем переходить	к следующему этапу.',
		'keep_install' => 'Сохранить предыдущую установку',
		'next_step' => 'Перейти к следующему этапу',
		'reinstall' => 'Переустановить FreshRSS',
	),
	'auth' => array(
		'form' => 'Вэб-форма (традиционный, необходим JavaScript)',
		'http' => 'HTTP (для продвинутых пользователей с HTTPS)',
		'none' => 'Никакого (опасно)',
		'password_form' => 'Пароль<br /><small>(для метода аутентификации на Вэб-формах)</small>',
		'password_format' => 'Как минимум 7 букв',
		'type' => 'Метод аутентификации',
	),
	'bdd' => array(
		'_' => 'База данных',
		'conf' => array(
			'_' => 'Конфигурация базы данныхDatabase configuration',
			'ko' => 'Проверьте конфигурацию базы данных.',
			'ok' => 'Конфигурация базы данных сохранена.',
		),
		'host' => 'Хост',
		'password' => 'Пароль базы данных',
		'prefix' => 'Префикс таблицы',
		'type' => 'Тип базы данных',
		'username' => 'Имя пользователя базы данных',
	),
	'check' => array(
		'_' => 'Проверки',
		'already_installed' => 'Обнаружена предыдущая установка FreshRSS!',
		'cache' => array(
			'nok' => 'Проверьте права доступа к папке <em>./data/cache</em> . Сервер HTTP должен иметь права на запись в эту папку.',
			'ok' => 'Права на папку кэша в порядке.',
		),
		'ctype' => array(
			'nok' => 'У вас не установлена необходимая библиотека для проверки типов символов (php-ctype).',
			'ok' => 'У вас установлена необходимая библиотека для проверки типов символов (ctype).',
		),
		'curl' => array(
			'nok' => 'У вас нет расширения cURL (пакет php-curl).',
			'ok' => 'У вас установлено расширение cURL.',
		),
		'data' => array(
			'nok' => 'Проверьте права доступа к папке <em>./data</em> . Сервер HTTP должен иметь права на запись в эту папку.',
			'ok' => 'Права на <em>./data/</em> в порядке.',
		),
		'dom' => array(
			'nok' => 'У вас не установлена необходимая библиотека для просмотра DOM (пакет php-xml).',
			'ok' => 'У вас установлена необходимая библиотека для просмотра DOM.',
		),
		'favicons' => array(
			'nok' => 'Проверьте права доступа к папке <em>./data/favicons</em> . Сервер HTTP должен иметь права на запись в эту папку.',
			'ok' => 'Права на папку значков в порядке.',
		),
		'fileinfo' => array(
			'nok' => 'У вас нет расширения PHP fileinfo (пакет fileinfo).',
			'ok' => 'У вас установлено расширение fileinfo.',
		),
		'http_referer' => array(
			'nok' => 'Убедитесь, что вы не изменяете ваш HTTP REFERER.',
			'ok' => 'Ваш HTTP REFERER известен и соотвествует вашему серверу.',
		),
		'json' => array(
			'nok' => 'Cannot find a recommended library to parse JSON.',	// TODO - Translation
			'ok' => 'You have a recommended library to parse JSON.',	// TODO - Translation
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// TODO - Translation
			'ok' => 'You have the recommended library mbstring for Unicode.',	// TODO - Translation
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
			'nok' => 'У вас установлен PHP версии %s, но FreshRSS необходима версия не ниже %s.',
			'ok' => 'У вас установлен PHP версии %s, который совместим с FreshRSS.',
		),
		'users' => array(
			'nok' => 'Проверьте права доступа к папке <em>./data/users</em> . Сервер HTTP должен иметь права на запись в эту папку.',
			'ok' => 'Права на папку users в порядке.',
		),
		'xml' => array(
			'nok' => 'Cannot find the required library to parse XML.',	// TODO - Translation
			'ok' => 'You have the required library to parse XML.',	// TODO - Translation
		),
	),
	'conf' => array(
		'_' => 'Общие настройки',
		'ok' => 'Общие настройки были сохранены.',
	),
	'congratulations' => 'Поздравляем!',
	'default_user' => 'Имя пользователя по умолчанию <small>(максимум 16 латинских букв и/или цифр)</small>',
	'delete_articles_after' => 'Удалять статьи после',
	'fix_errors_before' => 'Пожалуйста, исправьте ошибки прежде чем переходить	к следующему этапу..',
	'javascript_is_better' => 'FreshRSS принесёт больше удовольствия, если включить JavaScript',
	'js' => array(
		'confirm_reinstall' => 'Переустанавливая FreshRSS, вы потеряете предыдущую конфигурацию. Вы хотите продолжить?',
	),
	'language' => array(
		'_' => 'Язык',
		'choose' => 'Выберите язык для FreshRSS',
		'defined' => 'Язык выбран.',
	),
	'not_deleted' => 'Что-то пошло не так; удалите файл <em>%s</em> вручную.',
	'ok' => 'Установка успешна.',
	'step' => '%d этап',
	'steps' => 'Этапы',
	'this_is_the_end' => 'Это конец',
	'title' => 'Установка · FreshRSS',
);

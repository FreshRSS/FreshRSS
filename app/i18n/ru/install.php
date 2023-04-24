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
		'finish' => 'Завершить установку',
		'fix_errors_before' => 'Пожалуйста, исправьте все ошибки, прежде чем перейти к следующему шагу.',
		'keep_install' => 'Сохранить предыдущую конфигурацию',
		'next_step' => 'Перейти к следующему шагу',
		'reinstall' => 'Переустановить FreshRSS',
	),
	'auth' => array(
		'form' => 'Веб-форма (традиционный, необходим JavaScript)',
		'http' => 'HTTP (для опытных пользователей с HTTPS)',
		'none' => 'Без аутентификации (небезопасно)',
		'password_form' => 'Пароль<br /><small>(для входа через веб-форму)</small>',
		'password_format' => 'Не менее 7 символов',
		'type' => 'Способ аутентификации',
	),
	'bdd' => array(
		'_' => 'База данных',
		'conf' => array(
			'_' => 'Настройки базы данных',
			'ko' => 'Проверьте настройки базы данных.',
			'ok' => 'Настройки базы данных сохранены.',
		),
		'host' => 'Хост',
		'password' => 'Пароль базы данных',
		'prefix' => 'Префикс таблицы',
		'type' => 'Тип базы данных',
		'username' => 'Имя пользователя базы данных',
	),
	'check' => array(
		'_' => 'Проверки',
		'already_installed' => 'Мы обнаружили, что FreshRSS уже установлен!',
		'cache' => array(
			'nok' => 'Проверьте права доступа к папке <em>%s</em> (Owner: %s, Group: %s, Rights: %s).<br /> Веб-сервер (User name: %s) должен иметь право на запись в эту папку.',	// DIRTY
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
			'nok' => 'Проверьте права доступа к папке <em>%s</em> (Owner: %s, Group: %s, Rights: %s).<br /> Веб-сервер (User name: %s) должен иметь право на запись в эту папку.',	// DIRTY
			'ok' => 'Права на <em>./data/</em> в порядке.',
		),
		'dom' => array(
			'nok' => 'У вас не установлена необходимая библиотека для просмотра DOM (пакет php-xml).',
			'ok' => 'У вас установлена необходимая библиотека для просмотра DOM.',
		),
		'favicons' => array(
			'nok' => 'Проверьте права доступа к папке <em>%s</em> (Owner: %s, Group: %s, Rights: %s).<br /> Веб-сервер (User name: %s) должен иметь право на запись в эту папку.',	// DIRTY
			'ok' => 'Права на папку значков в порядке.',
		),
		'fileinfo' => array(
			'nok' => 'У вас нет расширения PHP fileinfo (пакет fileinfo).',
			'ok' => 'У вас установлено расширение fileinfo.',
		),
		'json' => array(
			'nok' => 'У вас нет рекомендуемой библиотеки для разбора JSON.',
			'ok' => 'У вас установлена необходимая библиотека для разбора JSON.',
		),
		'mbstring' => array(
			'nok' => 'У вас не установлена рекомендуемая библиотека mbstring для Unicode.',
			'ok' => 'У вас установлена рекомендуемая библиотека mbstring для Unicode.',
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
		'reload' => 'Проверьте еще раз',
		'tmp' => array(
			'nok' => 'Проверьте права доступа к папке <em>%s</em> (Owner: %s, Group: %s, Rights: %s).<br /> Веб-сервер (User name: %s) должен иметь право на запись в эту папку.',	// DIRTY
			'ok' => 'Права на папку temp в порядке.',
		),
		'unknown_process_username' => 'неизвестно',
		'users' => array(
			'nok' => 'Проверьте права доступа к папке <em>%s</em> (Owner: %s, Group: %s, Rights: %s).<br /> Веб-сервер (User name: %s) должен иметь право на запись в эту папку.',	// DIRTY
			'ok' => 'Права на папку users в порядке.',
		),
		'xml' => array(
			'nok' => 'У вас нет необходимой библиотеки для разбора XML.',
			'ok' => 'У вас установлена необходимая библиотека для разбора XML.',
		),
	),
	'conf' => array(
		'_' => 'Общие настройки',
		'ok' => 'Общие настройки сохранены.',
	),
	'congratulations' => 'Поздравляем!',
	'default_user' => array(
		'_' => 'Имя пользователя по умолчанию',
		'max_char' => 'не более 16 буквенно-цифровых символов',
	),
	'fix_errors_before' => 'Пожалуйста, исправьте ошибки, прежде чем перейти к следующему шагу.',
	'javascript_is_better' => 'Пользоваться FreshRSS приятнее с включённым JavaScript',
	'js' => array(
		'confirm_reinstall' => 'Переустанавливая FreshRSS, вы потеряете предыдущую конфигурацию. Вы уверены, что хотите продолжить?',
	),
	'language' => array(
		'_' => 'Язык',
		'choose' => 'Выберите язык для FreshRSS',
		'defined' => 'Язык выбран.',
	),
	'missing_applied_migrations' => 'Что-то пошло не так; вам следует создать пустой файл <em>%s</em> вручную.',
	'ok' => 'Установка успешно завершена.',
	'session' => array(
		'nok' => 'Похоже, веб-сервер имеет неправильные настройки кук! Куки нужны для сессий PHP.',
	),
	'step' => 'шаг %d',
	'steps' => 'Шаги',
	'this_is_the_end' => 'Завершение',
	'title' => 'Установка · FreshRSS',
);

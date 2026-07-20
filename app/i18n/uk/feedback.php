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
	'access' => array(
		'denied' => 'Бракує дозволу на доступ до цієї сторінки',
		'not_found' => 'Шуканої сторінки не існує',
	),
	'admin' => array(
		'optimization_complete' => 'Оптимізацію завершено',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Не вдалося змінити пароль',
			'updated' => 'Пароль змінено',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'Не вдалось увійти',
			'success' => 'Вхід успішний',
		),
		'logout' => array(
			'success' => 'Вихід успішний',
		),
	),
	'conf' => array(
		'error' => 'Не вдалося зберегти налаштування',
		'query_created' => 'Запит «%s» створено.',
		'shortcuts_updated' => 'Клавіші оновлено',
		'updated' => 'Налаштування оновлено',
	),
	'extensions' => array(
		'already_enabled' => '%s уже ввімкнено',
		'cannot_remove' => 'Неможливо вилучити %s',
		'disable' => array(
			'ko' => 'Неможливо вимкнути %s. <a href="%s">Докладніше в журналах FreshRSS</a>.',
			'ok' => '%s тепер вимкнено',
		),
		'enable' => array(
			'ko' => 'Неможливо ввімкнути %s. <a href="%s">Докладніше в журналах FreshRSS</a>.',
			'ok' => '%s тепер увімкнено',
		),
		'invalid_view_mode' => 'Хибний режим показу «%s»! Повернутися до «звичайного показу».',
		'no_access' => 'Бракує доступу до %s',
		'not_enabled' => '%s вимкнено',
		'not_found' => '%s не існує',
		'removed' => '%s вилучено',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP-розширення не встановлено на вашому сервері. Спробуйте експортувати файли поодинці.',
		'feeds_imported' => 'Стрічки імпортовано. Якщо більше не потрібно нічого імпортувати, натисніть кнопку <i>Оновити стрічки</i>.',
		'feeds_imported_with_errors' => 'Стрічки імпортовано, проте виникли помилки. Якщо більше не потрібно нічого імпортувати, натисніть кнопку <i>Оновити стрічки</i>.',
		'file_cannot_be_uploaded' => 'Не вдалося вивантажити файл!',
		'no_zip_extension' => 'На сервері бракує ZIP-розширення.',
		'zip_error' => 'При обробці ZIP виникла помилка.',
	),
	'profile' => array(
		'error' => 'Не вдалось оновити профіль',
		'passwords_dont_match' => 'Паролі не збігаються',
		'updated' => 'Профіль оновлено',
	),
	'sub' => array(
		'actualize' => 'Оновлення',
		'articles' => array(
			'marked_read' => 'Вибрані статті позначено прочитаними.',
			'marked_unread' => 'Статті позначено непрочитаними.',
		),
		'category' => array(
			'created' => 'Створено категорію %s.',
			'deleted' => 'Категорію видалено.',
			'emptied' => 'Категорію спорожнено',
			'error' => 'Не вдалося оновити категорію',
			'name_exists' => 'Категорія з такою назвою вже існує.',
			'no_id' => 'Слід вказати ідентифікатор категорії.',
			'no_name' => 'Категорії слід мати назву.',
			'not_delete_default' => 'Неможливо видалити типову категорію!',
			'not_exist' => 'Категорія не існує!',
			'over_max' => 'Ви вже маєте максимум дозволених категорій (%d)',
			'updated' => 'Категорію оновлено.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> оновлено',
			'actualizeds' => 'RSS-стрічки оновлено',
			'added' => 'Додано RSS-стрічку <em>%s</em>',
			'already_subscribed' => 'Ви вже підписані на <em>%s</em>',
			'cache_cleared' => 'Кеш <em>%s</em> очищено',
			'deleted' => 'Стрічку видалено',
			'error' => 'Не вдалося оновити стрічку',
			'favicon' => array(
				'too_large' => 'Завантажена піктограма завелика. Максимальний розмір файлу <em>%s</em>.',
				'unsupported_format' => 'Формат зображення не підтримується!',
			),
			'internal_problem' => 'Не вдалося додати стрічку новин. <a href="%s">Докладніше в журналах FreshRSS</a>. Щоб спробувати примусове додання, допишіть <code>#force_feed</code> до URL-адреси.',
			'invalid_url' => 'URL-адреса <em>%s</em> хибна',
			'n_actualized' => 'Стрічки оновлено (%d)',
			'n_entries_deleted' => 'Статті видалено (%d)',
			'no_refresh' => 'Нема стрічок, які можна було б оновити',
			'not_added' => 'Не вдалося додати <em>%s</em>',
			'not_found' => 'Стрічки не знайдено',
			'over_max' => 'Ви вже маєте максимум дозволених стрічок (%d)',
			'reloaded' => '<em>%s</em> перезавантажено',
			'selector_preview' => array(
				'http_error' => 'Не вдалося завантажити сайт.',
				'no_entries' => 'У стрічці нема статей. Щоб створити попередній перегляд, треба принаймні одна стаття.',
				'no_feed' => 'Внутрішня помилка (стрічки не знайдено).',
				'no_result' => 'Селектору ніщо не відповідає. Натомість буде показано початковий текст стрічки.',
				'selector_empty' => 'Селектор порожній. Щоб створити попередній перегляд, налаштуйте селектор.',
			),
			'updated' => 'Стрічку оновлено',
		),
		'purge_completed' => 'Видалення завершено (видалено статей: %d)',
	),
	'tag' => array(
		'created' => 'Мітку «%» створено.',
		'error' => 'Не вдалося оновити мітку!',
		'name_exists' => 'Мітка з такою назвою вже існує.',
		'renamed' => 'Мітку «%s» перейменовано на «%s».',
		'updated' => 'Мітку оновлено.',
	),
	'update' => array(
		'can_apply' => 'Наявне оновлення FreshRSS: <strong>версія %s</strong>.',
		'error' => 'При оновленні виникла помилка: %s',
		'file_is_nok' => 'Наявне оновлення FreshRSS (<strong>версія %s</strong>), але перевірте доступи до каталога <em>%s</em>. HTTP-серверу потрібен дозвіл на запис',
		'finished' => 'Оновлення завершено!',
		'none' => 'Нема доступних оновлень',
		'server_not_found' => 'Не вдалося знайти сервер оновлень. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'Користувача %s створено',
			'error' => 'Не вдалося створити користувача %s',
		),
		'deleted' => array(
			'_' => 'Користувача %s видалено',
			'error' => 'Не вдалося видалити користувача %s',
		),
		'updated' => array(
			'_' => 'Користувача %s оновлено',
			'error' => 'Не вдалося оновити користувача %s',
		),
	),
);

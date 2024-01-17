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
	'access' => [
		'denied' => 'У вас нет разрешения на доступ к этой странице',
		'not_found' => 'Данной страницы не существует',
	],
	'admin' => [
		'optimization_complete' => 'Оптимизация завершена',
	],
	'api' => [
		'password' => [
			'failed' => 'Ваш пароль не может быть изменён',
			'updated' => 'Ваш пароль изменён',
		],
	],
	'auth' => [
		'login' => [
			'invalid' => 'Неверный логин',
			'success' => 'Вы вошли',
		],
		'logout' => [
			'success' => 'Вы вышли',
		],
	],
	'conf' => [
		'error' => 'Во время сохранения конфигурации возникла ошибка',
		'query_created' => 'Запрос “%s” создан.',
		'shortcuts_updated' => 'Горячие клавиши изменены',
		'updated' => 'Конфигурация изменена',
	],
	'extensions' => [
		'already_enabled' => '%s уже включено',
		'cannot_remove' => '%s не может быть удалено',
		'disable' => [
			'ko' => '%s не может быть отключено. <a href="%s">Проверьте логи FreshRSS</a> для подробностей.',
			'ok' => '%s теперь отключено',
		],
		'enable' => [
			'ko' => '%s не может быть включено. <a href="%s">Проверьте логи FreshRSS</a> для подробностей.',
			'ok' => '%s теперь включено',
		],
		'no_access' => 'У вас нет доступа к %s',
		'not_enabled' => '%s не включено',
		'not_found' => '%s не существует',
		'removed' => '%s удалено',
	],
	'import_export' => [
		'export_no_zip_extension' => 'На вашем сервере нет расширения ZIP. Пожалуйста, попробуйте экспортировать файлы один за другим.',
		'feeds_imported' => 'Ваши ленты импортированы и теперь будут обновлены / Your feeds have been imported. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'feeds_imported_with_errors' => 'Ваши ленты импортированы, но возникли ошибки / Your feeds have been imported, but some errors occurred. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'file_cannot_be_uploaded' => 'Файл не может быть загружен!',
		'no_zip_extension' => 'На вашем сервере нет расширения ZIP.',
		'zip_error' => 'Ошибка возникла при импорте ZIP.',	// DIRTY
	],
	'profile' => [
		'error' => 'Ваш профиль не может быть изменён',
		'updated' => 'Ваш профиль изменён',
	],
	'sub' => [
		'actualize' => 'Обновляется',
		'articles' => [
			'marked_read' => 'Выбранные статьи отмечены прочитанными.',
			'marked_unread' => 'Статьи отмечены непрочитанными.',
		],
		'category' => [
			'created' => 'Категория %s создана.',
			'deleted' => 'Категория удалена.',
			'emptied' => 'Категория очищена',
			'error' => 'Категория не может быть изменена',
			'name_exists' => 'Категория с таким названием уже существует.',
			'no_id' => 'Вы должны задать id категории.',
			'no_name' => 'Название категории не может быть пустым.',
			'not_delete_default' => 'Вы не можете удалить стандартную категорию!',
			'not_exist' => 'Категории не существует!',
			'over_max' => 'Вы достигли вашего лимита категорий (%d)',
			'updated' => 'Категория изменена.',
		],
		'feed' => [
			'actualized' => '<em>%s</em> обновлена',
			'actualizeds' => 'RSS-ленты обновлены',
			'added' => 'RSS-лента <em>%s</em> добавлена',
			'already_subscribed' => 'Вы уже подписаны на <em>%s</em>',
			'cache_cleared' => 'Кэш <em>%s</em> очищен',
			'deleted' => 'Лента удалена',
			'error' => 'Лента не может быть изменена',
			'internal_problem' => 'Новостная лента не может быть добавлена. <a href="%s">Проверьте логи FreshRSS</a> для подробностей. Вы можете попробовать принудительно добавить ленту, добавив <code>#force_feed</code> к URL.',
			'invalid_url' => 'URL <em>%s</em> неверный',
			'n_actualized' => '%d лент обновлено',
			'n_entries_deleted' => '%d лент удалено',
			'no_refresh' => 'Нет лент для обновления',
			'not_added' => '<em>%s</em> не может быть добавлена',
			'not_found' => 'Лента не найдена',
			'over_max' => 'Вы достигли ограничения на количество лент (%d)',
			'reloaded' => '<em>%s</em> перезагружена',
			'selector_preview' => [
				'http_error' => 'Не удалось загрузить содержимое сайта.',
				'no_entries' => 'В этой ленте нет статей. Требуется хотя бы одна статья, чтобы создать предпросмотр.',
				'no_feed' => 'Внутренняя ошибка (лента не найдена).',
				'no_result' => 'Нет совпадений с селектором. В качестве запасного варианта, вместо этого отображается оригинальный текст ленты.',
				'selector_empty' => 'Селектор пуст. Необходимо задать селектор, чтобы создать предпросмотр.',
			],
			'updated' => 'Лента изменена',
		],
		'purge_completed' => 'Очистка выполнена (%d статей удалено)',
	],
	'tag' => [
		'created' => 'Метка “%s” создана.',
		'error' => 'Label could not be updated!',	// TODO
		'name_exists' => 'Метка с таким названием уже существует.',
		'renamed' => 'Метка “%s” переименована в “%s”.',
		'updated' => 'Label has been updated.',	// TODO
	],
	'update' => [
		'can_apply' => 'FreshRSS будет обновлён до <strong>версии %s</strong>.',
		'error' => 'Процесс обновления столкнулся с ошибкой: %s',
		'file_is_nok' => 'Новая <strong>версия %s</strong> доступна, но проверьте права к директории <em>%s</em>. У веб-сервера должно быть право на запись',
		'finished' => 'Обновление завершено!',
		'none' => 'Нет обновлений',
		'server_not_found' => 'Сервер обновлений не найден. [%s]',
	],
	'user' => [
		'created' => [
			'_' => 'Пользователь %s создан',
			'error' => 'Пользователь %s не может быть создан',
		],
		'deleted' => [
			'_' => 'Пользователь %s удалён',
			'error' => 'Пользователь %s не может быть удалён',
		],
		'updated' => [
			'_' => 'Пользователь %s изменён',
			'error' => 'Пользователь %s не был изменён',
		],
	],
];

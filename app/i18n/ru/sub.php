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
	'api' => array(
		'documentation' => 'Скопируйте URL для использования во внешнем инструменте.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Перетяните эту кнопку на вашу панель закладок, или нажмите правой кнопкой мыши и выберите "Добавить ссылку в закладки". Нажимайте кнопку "Подписаться" на любой странице, на которую вы хотите подписаться.<br>',
		'label' => 'Подписаться',
		'title' => 'Букмарклет',
	),
	'category' => array(
		'_' => 'Категория',
		'add' => 'Добавить категория',
		'archiving' => 'Архивирование',
		'empty' => 'Пустая категория',
		'information' => 'Информация',
		'position' => 'Положение отображения',
		'position_help' => 'Влияет на порядок отображения категорий',
		'title' => 'Заголовок',
	),
	'feed' => array(
		'add' => 'Добавить RSS-ленту',
		'advanced' => 'Дополнительно',
		'archiving' => 'Архивирование',
		'auth' => array(
			'configuration' => 'Логин',
			'help' => 'Разрешить доступ к HTTP защищённым RSS-лентам',
			'http' => 'HTTP аутентификация',
			'password' => 'Пароль HTTP',
			'username' => 'Имя пользователя HTTP',
		),
		'clear_cache' => 'Всегда очищать кэш',
		'content_action' => array(
			'_' => 'Действие с содержимым, когда извлекается содержимое статьи',
			'append' => 'Добавить после существующего содержимого',
			'prepend' => 'Добавить перед существующим содержимым',
			'replace' => 'Заменить существующее содержимое',
		),
		'css_cookie' => 'Использовать куки при извлечении содержимого статьи',
		'css_cookie_help' => 'Пример: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Получает усечённые RSS-ленты (осторожно, требует больше времени!)',
		'css_path' => 'CSS селектор статьи на сайте',
		'description' => 'Описание',
		'empty' => 'Лента пустая. Пожалуйста, убедитесь, что её до сих пор обслуживают.',
		'error' => 'С этой лентой возникла проблема. Пожалуйста, убедитесь, что она всегда досягаема. Затем снова актуализируйте её.',
		'filteractions' => array(
			'_' => 'Действия фильтрации',
			'help' => 'Введите по одному поисковому фильтру в строке.',
		),
		'information' => 'Информация',
		'keep_min' => 'Оставлять статей не менее',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>//title</code>',	// TODO
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'Example: <code>//li[@class="news-item"]</code>',	// TODO
				),
				'item_author' => array(
					'_' => 'item author',	// TODO
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',	// TODO
				),
				'item_categories' => 'items tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Example: <code>descendant::span[@class="summary"]</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>descendant::img/@src</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => array(
					'_' => 'item title',	// TODO
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes">XPath axis</a> <code>descendant::</code>',	// TODO
				),
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>descendant::a/@href</code>',	// TODO
				),
				'relative' => 'XPath (relative to item) for:',	// TODO
				'xpath' => 'XPath for:',	// TODO
			),
			'rss' => 'RSS / Atom (default)',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'Очистить кэш',
			'clear_cache_help' => 'Очистить кэш для этой ленты.',
			'reload_articles' => 'Снова загрузить статьи',
			'reload_articles_help' => 'Снова загрузить статьи и извлечь полное содержимое, если задан селектор.',
			'title' => 'Обслуживание',
		),
		'moved_category_deleted' => 'Когда вы удаляете категорию, ленты категории автоматически попадают в категорию <em>%s</em>.',
		'mute' => 'заглушить',
		'no_selected' => 'Ленты не выбраны.',
		'number_entries' => '%d статей',
		'priority' => array(
			'_' => 'Видимость',
			'archived' => 'Не показывать (архивировано)',
			'main_stream' => 'Показывать в основном потоке',
			'normal' => 'Показывать в категории ленты',
		),
		'proxy' => 'Указать прокси для извлечения этой ленты',
		'proxy_help' => 'Выберите протокол (например, SOCKS5) и введите адрес прокси (например, <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'Показать исходный код',
			'show_rendered' => 'Показать содержимое',
		),
		'show' => array(
			'all' => 'Показать все ленты',
			'error' => 'Показать только ленты с ошибками',
		),
		'showing' => array(
			'error' => 'Показываются только ленты с ошибками',
		),
		'ssl_verify' => 'Проверять безопасность SSL',
		'stats' => 'Статистика',
		'think_to_add' => 'Вы можете добавить ленты.',
		'timeout' => 'Таймаут в секундах',
		'title' => 'Заголовок',
		'title_add' => 'Добавить RSS-ленту',
		'ttl' => 'Не актуализировать автоматически чаще чем',
		'url' => 'URL ленты',
		'useragent' => 'Указать юзерагент для извлечения лент',
		'useragent_help' => 'Пример: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Проверить валидность ленты',
		'website' => 'URL сайта',
		'websub' => 'Моментальные оповещения посредством WebSub',
	),
	'import_export' => array(
		'export' => 'Экспорт',
		'export_labelled' => 'Экспортировать ваши помеченные статьи',
		'export_opml' => 'Экспортировать список лент (OPML)',
		'export_starred' => 'Экспортировать ваше избранное',
		'feed_list' => 'Список из %s статей',
		'file_to_import' => 'Файл для импорта<br />(OPML, JSON or ZIP)',
		'file_to_import_no_zip' => 'Файл для импорта<br />(OPML or JSON)',
		'import' => 'Импорт',
		'starred_list' => 'Список избранных статей',
		'title' => 'Импорт / экспорт',
	),
	'menu' => array(
		'add' => 'Добавить ленту или категорию',
		'import_export' => 'Импорт / экспорт',
		'label_management' => 'Управление метками',
		'stats' => array(
			'idle' => 'Неактивные ленты',
			'main' => 'Основная статистика',
			'repartition' => 'Перерасределение статей',
		),
		'subscription_management' => 'Управление подписками',
		'subscription_tools' => 'Инструменты подписки',
	),
	'tag' => array(
		'name' => 'Название',
		'new_name' => 'Новое название',
		'old_name' => 'Старое название',
	),
	'title' => array(
		'_' => 'Управление подписками',
		'add' => 'Добавить ленту или категорию',
		'add_category' => 'Добавить категорию',
		'add_feed' => 'Добавить ленту',
		'add_label' => 'Добавить метку',
		'delete_label' => 'Удалить метку',
		'feed_management' => 'Управление RSS-лентами',
		'rename_label' => 'Переименовать метку',
		'subscription_tools' => 'Инструменты подписки',
	),
);

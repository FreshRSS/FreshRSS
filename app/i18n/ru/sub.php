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
		'documentation' => 'Перетяните эту кнопку на вашу панель закладок, или нажмите правой кнопкой мыши и выберите "Добавить ссылку в закладки". Нажимайте кнопку "Подписаться" на любой странице, на которую вы хотите подписаться.<br />',
		'label' => 'Подписаться',
		'title' => 'Букмарклет',
	),
	'category' => array(
		'_' => 'Категория',
		'add' => 'Добавить категория',
		'archiving' => 'Архивирование',
		'dynamic_opml' => array(
			'_' => 'Динамичный OPML',
			'help' => 'Предоставьте ссылку на <a href="http://opml.org/" target="_blank">OPML файл</a> чтобы динамично заполнять эту категорию лентами',
		),
		'empty' => 'Пустая категория',
		'expand' => 'Expand category',	// TODO
		'information' => 'Информация',
		'open' => 'Open category',	// TODO
		'opml_url' => 'OPML ссылка',
		'position' => 'Положение отображения',
		'position_help' => 'Влияет на порядок отображения категорий',
		'title' => 'Заголовок',
	),
	'feed' => array(
		'accept_cookies' => 'Разрешить файлы cookies',
		'accept_cookies_help' => 'Разрешить серверу ленты использовать cookies (файлы будут храниться в памяти лишь в течение запроса)',
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
		'css_path_filter' => array(
			'_' => 'CSS селектор элемента для удаления',
			'help' => 'CSS селектор может быть списком как: <kbd>.footer, .aside</kbd>',
		),
		'description' => 'Описание',
		'empty' => 'Лента пустая. Пожалуйста, убедитесь, что её до сих пор обслуживают.',
		'error' => 'С этой лентой возникла проблема. Пожалуйста, убедитесь, что она всегда досягаема. Затем снова обновите её.',
		'export-as-opml' => array(
			'download' => 'Скачать',
			'help' => 'XML файл (data subset. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">See documentation</a>)',	// DIRTY
			'label' => 'Экспортировать как OPML',
		),
		'filteractions' => array(
			'_' => 'Действия фильтрации',
			'help' => 'Введите по одному поисковому фильтру в строке. См. <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">документацию</a>.',
		),
		'information' => 'Информация',
		'keep_min' => 'Оставлять статей не менее',
		'kind' => array(
			'_' => 'Тип источника ленты',
			'html_xpath' => array(
				'_' => 'HTML + XPath (парсинг веб-страниц)',
				'feed_title' => array(
					'_' => 'заголовка ленты',
					'help' => 'Пример: <code>//title</code> или статичная строка: <code>"Моя пользовательская лента"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> – стандартный язык запросов для опытных пользователей, который поддерживается в FreshRSS для парсинга веб-страниц.',
				'item' => array(
					'_' => 'поиска новых <strong>элементов</strong><br /><small>(самое важное)</small>',
					'help' => 'Пример: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'автора элемента',
					'help' => 'Может также быть статической строкой. Пример: <code>"Аноним"</code>',
				),
				'item_categories' => 'тегов элемента',
				'item_content' => array(
					'_' => 'содержимого элемента',
					'help' => 'Пример, чтобы взять элемент целиком: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'эскиза элемента',
					'help' => 'Пример: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Пользовательский формат даты/времени',
					'help' => 'Выборочно. Формат поддерживается <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> как <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'даты элемента',
					'help' => 'Результат будет распарсен с <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'заголовка элемента',
					'help' => 'Используйте, в частности, <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">ось XPath</a> <code>descendant::</code>, наподобие <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'уникальный ID элемента',
					'help' => 'Выборочно. Пример: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'ссылки элемента (URL)',
					'help' => 'Пример: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (относительно элемента) для:',
				'xpath' => 'XPath для:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (точечная нотация)',
				'feed_title' => array(
					'_' => 'название ленты',
					'help' => 'Пример: <code>meta.title</code> или статический текст: <code>"Моя пользовательская лента"</code>',
				),
				'help' => 'JSON с точечной нотацией использует точки между объектами и квадратные скобки для массивов (например: <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'Найти новые <strong>элементы</strong><br /><small>(самое важное)</small>',
					'help' => 'JSON-путь к массиву, содержащему элементы, например: <code>newsItems</code>',
				),
				'item_author' => 'автор элемента',
				'item_categories' => 'теги элемента',
				'item_content' => array(
					'_' => 'содержимое элемента',
					'help' => 'Ключ, по которому найден контент, например: <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'эскиз элемента',
					'help' => 'Пример: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Пользовательский формат даты/времени',
					'help' => 'Выборочно. Формат, поддерживаемый <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, например <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'дата элемента',
					'help' => 'Результат будет распарсен используя <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'название элемента',
				'item_uid' => 'уникальный ID элемента',
				'item_uri' => array(
					'_' => 'ссылка на элемент (URL)',
					'help' => 'Пример: <code>permalink</code>',
				),
				'json' => 'точечная нотация для:',
				'relative' => 'JSON-путь (относительный до элемента) для:',
			),
			'jsonfeed' => 'JSON Лента',
			'rss' => 'RSS / Atom (по умолчанию)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Очистить кэш',
			'clear_cache_help' => 'Очистить кэш для этой ленты.',
			'reload_articles' => 'Перезагрузить статьи',
			'reload_articles_help' => 'Перезагрузить столько статей и извлечь полное содержимое, если задан селектор.',
			'title' => 'Обслуживание',
		),
		'max_http_redir' => 'Максимум HTTP переводов',
		'max_http_redir_help' => 'Установите 0 или оставьте пустым, чтобы отключить, -1 для бесконечных переводов',
		'method' => array(
			'_' => 'HTTP метод',
		),
		'method_help' => 'Полезная нагрузка POST автоматически поддерживает <code>application/x-www-form-urlencoded</code> и <code>application/json</code>',
		'method_postparams' => 'Полезная нагрузка POST',
		'moved_category_deleted' => 'Когда вы удаляете категорию, ленты категории автоматически попадают в категорию <em>%s</em>.',
		'mute' => array(
			'_' => 'заглушить',
			'state_is_muted' => 'This feed is muted',	// TODO
		),
		'no_selected' => 'Ленты не выбраны.',
		'number_entries' => '%d статей',
		'open_feed' => 'Open feed %s',	// TODO
		'priority' => array(
			'_' => 'Видимость',
			'archived' => 'Не показывать (архивировано)',
			'category' => 'Показывать в категории ленты',
			'important' => 'Показывать в важных лентах',
			'main_stream' => 'Показывать в основном потоке',
		),
		'proxy' => 'Указать прокси для извлечения этой ленты',
		'proxy_help' => 'Выберите протокол (например, SOCKS5) и введите адрес прокси (например, <kbd>127.0.0.1:1080</kbd> или <kbd>username:password@127.0.0.1:1080</kbd>)',	// DIRTY
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
		'ttl' => 'Не обновлять автоматически чаще, чем каждые',
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
			'repartition' => 'Расределение статей',
		),
		'subscription_management' => 'Управление подписками',
		'subscription_tools' => 'Инструменты подписки',
	),
	'tag' => array(
		'auto_label' => 'Добавьте это название к новым статьям',
		'name' => 'Название',
		'new_name' => 'Новое название',
		'old_name' => 'Старое название',
	),
	'title' => array(
		'_' => 'Управление подписками',
		'add' => 'Добавить ленту или категорию',
		'add_category' => 'Добавить категорию',
		'add_dynamic_opml' => 'Добавить динамичный OPML',
		'add_feed' => 'Добавить ленту',
		'add_label' => 'Добавить метку',
		'delete_label' => 'Удалить метку',
		'feed_management' => 'Управление RSS-лентами',
		'rename_label' => 'Переименовать метку',
		'subscription_tools' => 'Инструменты подписки',
	),
);

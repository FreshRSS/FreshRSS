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
		'documentation' => 'Скопіюйте наступну URL-адресу для використання зі сторонньою програмою.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Посуньте цю кнопку до вашої панелі закладок або натисніть її правою кнопкою мишки та оберіть «Додати посилання до закладок». Тоді натисніть закладку «Підписатися» на будь-якій сторінці, на яку бажаєте підписатись.',
		'label' => 'Підписатися',
		'title' => 'Закладка-скрипт',
	),
	'category' => array(
		'_' => 'Категорія',
		'add' => 'Додати категорію',
		'archiving' => 'Архівування',
		'dynamic_opml' => array(
			'_' => 'Динамічний OPML',
			'help' => 'Щоб динамічно заповнювати цю категорію стрічками, вкажіть URL-адресу <a href="http://opml.org/" target="_blank">OPML-файлу</a>',
		),
		'empty' => 'Порожня категорія',
		'expand' => 'Розгорнути категорію',
		'information' => 'Інформація',
		'open' => 'Відкрити категорію',
		'opml_url' => 'URL-адреса OPML',
		'position' => 'Пріоритет показу',
		'position_help' => 'Визначає порядок категорій',
		'title' => 'Заголовок',
	),
	'feed' => array(
		'accept_cookies' => 'Приймати кукі',
		'accept_cookies_help' => 'Дозволити серверу стрічки призначати кукі (зберігаються в памʼяті лише на час запиту)',
		'add' => 'Додати стрічку',
		'advanced' => 'Особливості',
		'archiving' => 'Архівування',
		'auth' => array(
			'configuration' => 'Авторизація',
			'help' => 'Дає змогу читати RSS-стрічки, захищені за допомогою HTTP-авторизації',
			'http' => 'HTTP-автентифікація',
			'password' => 'Пароль HTTP',
			'username' => 'Користувацьке імʼя HTTP',
		),
		'change_favicon' => 'Змінити…',
		'clear_cache' => 'Завжди чистити кеш',
		'content_action' => array(
			'_' => 'Дія з текстом при завантаженні тексту статті',
			'append' => 'Додати після наявного тексту',
			'prepend' => 'Додати перед наявним текстом',
			'replace' => 'Замінити наявний текст',
		),
		'content_retrieval' => 'Завантаження тексту',
		'css_cookie' => 'Використовувати кукі при завантаженні тексту статті',
		'css_cookie_help' => 'Наприклад, <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Завантажує скорочені RSS-стрічки (обережно, це повільніше!)',
		'css_path' => 'CSS-селектор статті на вебсайті',
		'css_path_filter' => array(
			'_' => 'CSS-селектор видалення елементів',
			'help' => 'CSS-селектор може бути списком, наприклад <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'Опис',
		'empty' => 'Стрічка порожня. Перевірте, чи її все ще ведуть.',
		'error' => 'Зі стрічкою виникла проблема. Якщо це повторюватиметься, перевірте, чи стрічка все ще доступна.',
		'export-as-opml' => array(
			'download' => 'Завантажити',
			'help' => 'XML-файл (підмножина даних. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">Перегляньте документацію</a>)',
			'label' => 'Експорт у форматі OPML',
		),
		'ext_favicon' => 'Налаштувати автоматично',
		'favicon_changed_by_ext' => 'Піктограму налаштовано розширенням <b>%s</b>.',
		'filteractions' => array(
			'_' => 'Автоматичний фільтр',
			'help' => 'По одному фільтру на рядок. Перегляньте <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">документацію операторів</a>.',
		),
		'http_headers' => 'HTTP-заголовки',
		'http_headers_help' => 'По заголовку на рядок. Назву й значення відокремлено двокрапкою (наприклад, <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer деякий-токен</code></kbd>).',
		'icon' => 'Піктограма',
		'information' => 'Інформація',
		'keep_min' => 'Мінімум збережених статей',
		'kind' => array(
			'_' => 'Тип джерела стрічки',
			'html_json' => array(
				'_' => 'HTML + XPath + JSON із крапковою нотацією (JSON в HTML)',
				'xpath' => array(
					'_' => 'XPath-селектор JSON в HTML',
					'help' => 'Приклад: <code>normalize-space(//script[@type="application/json"])</code> (єдиний JSON)<br />або: <code>//script[@type="application/ld+json"]</code> (по одному JSON-обʼєкту на статтю)',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (скрейпінг)',
				'feed_title' => array(
					'_' => 'заголовка стрічки',
					'help' => 'Наприклад, <code>//title</code> або статичний рядок <code>"Моя власна стрічка"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> — це стандартна мова запитів, за допомогою яких FreshRSS може скрейпити вебсайти.',
				'item' => array(
					'_' => 'знаходження <strong>новин</strong><br /><small>(найважливіше)</small>',
					'help' => 'Наприклад, <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'автора новини',
					'help' => 'Може також бути статичним рядком, наприклад <code>"Anonymous"</code>',
				),
				'item_categories' => 'тегів новини',
				'item_content' => array(
					'_' => 'тексту новини',
					'help' => 'Приклад для виділення цілої новини: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'ілюстрації новини',
					'help' => 'Наприклад, <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Особливий формат дати й часу',
					'help' => 'Необовʼязково. Формат мусить підтримуватись <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, наприклад <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'дати новини',
					'help' => 'Результат буде розпізнано за допомогою <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'заголовка новини',
					'help' => 'Використовуйте зокрема <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">вісь XPath</a> <code>descendant::</code>, наприклад <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'унікального ідентифікатора новини',
					'help' => 'Необовʼязково. Наприклад, <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'URL-адреси новини',
					'help' => 'Наприклад, <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (відносно новини) до:',
				'xpath' => 'XPath для:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (крапкова нотація)',
				'feed_title' => array(
					'_' => 'назви стрічки',
					'help' => 'Наприклад, <code>meta.title</code> або статичний рядок: <code>"Моя власна стрічка"</code>',
				),
				'help' => 'У JSON-розмітці з крапковою нотацією між обʼєктами стоять крапки, а масиви позначаються квадратними дужками (наприклад, <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'знаходження <strong>новин</strong><br /><small>(найважливіше)</small>',
					'help' => 'JSON-шлях до масива, що містить новини, наприклад <code>$</code> чи <code>newsItems</code>',
				),
				'item_author' => 'автора новини',
				'item_categories' => 'тегів новини',
				'item_content' => array(
					'_' => 'тексту новини',
					'help' => 'Ключ, за яким знаходиться текст, наприклад <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'ілюстрації новини',
					'help' => 'Наприклад, <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Особливий формат дати й часу',
					'help' => 'Необовʼязково. Формат мусить підтримуватись <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, наприклад <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'дати новини',
					'help' => 'Результат буде розпізнано за допомогою <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'заголовка новини',
				'item_uid' => 'унікального ідентифікатора новини',
				'item_uri' => array(
					'_' => 'URL-адреси новини',
					'help' => 'Наприклад, <code>permalink</code>',
				),
				'json' => 'крапкова нотація для:',
				'relative' => 'шлях у крапковій нотації (відносно новини) до:',
			),
			'jsonfeed' => 'JSON-стрічка',
			'rss' => 'RSS/Atom (типово)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'Очистити кеш',
			'clear_cache_help' => 'Спорожнити кеш стрічки.',
			'reload_articles' => 'Перезавантажити статті',
			'reload_articles_help' => 'Перезавантажити стільки статей і завантажити повний текст, якщо визначено селектор.',
			'title' => 'Супровід',
		),
		'max_http_redir' => 'Максимум HTTP-переспрямувань',
		'max_http_redir_help' => '0 або порожнє поле — вимкнути; щоб не обмежувати переспрямувань, -1',
		'method' => array(
			'_' => 'HTTP-метод',
		),
		'method_help' => 'POST-тіло автоматично набуває формату <code>application/x-www-form-urlencoded</code> чи <code>application/json</code>',
		'method_postparams' => 'Тіло POST-запиту',
		'moved_category_deleted' => 'При видаленні категорії її стрічки переходять до списку «<em>%s</em>».',
		'mute' => array(
			'_' => 'зупинено',
			'state_is_muted' => 'Стрічку зупинено',
		),
		'no_selected' => 'Стрічки не обрано.',
		'number_entries' => 'Статей: %d',
		'open_feed' => 'Відкрити стрічку %s',
		'path_entries_conditions' => 'Умови завантаження тексту',
		'priority' => array(
			'_' => 'Видимість',
			'archived' => 'Не показувати (архівовано)',
			'category' => 'Показати в категорії',
			'important' => 'Показати у важливих стрічках',
			'main_stream' => 'Показати в головному потоці',
		),
		'proxy' => 'Налаштувати проксі для завантаження стрічки',
		'proxy_help' => 'Оберіть протокол (наприклад, SOCKS5) і введіть адресу проксі (наприклад, <kbd>127.0.0.1:1080</kbd> чи <kbd>логін:пароль@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'Відновити типову',
		'selector_preview' => array(
			'show_raw' => 'Показати початковий код',
			'show_rendered' => 'Показати текст',
		),
		'show' => array(
			'all' => 'Усі стрічки',
			'error' => 'Лише стрічки з помилками',
		),
		'showing' => array(
			'error' => 'Показано лише стрічки з помилками',
		),
		'ssl_verify' => 'Перевіряти SSL-захист',
		'stats' => 'Статистика',
		'think_to_add' => 'Можете додати кілька стрічок.',
		'timeout' => 'Тайм-аут у секундах',
		'title' => 'Заголовок',
		'title_add' => 'Додати RSS-стрічку',
		'ttl' => 'Частота автоматичного оновлення',
		'unicityCriteria' => array(
			'_' => 'Критерій унікальності статей',
			'forced' => '<span title="Заблокувати критерій унікальності, навіть якщо в стрічці є дублі статей">примусово</span>',
			'help' => 'Стосується некоректних стрічок.<br />⚠️ Зміна політики призведе до появи дублів.',
			'id' => 'Стандартний ідентифікатор (типово)',
			'link' => 'Посилання',
			'sha1:content' => 'Текст',
			'sha1:content_published' => 'Текст і дата',
			'sha1:link_published' => 'Посилання й дата',
			'sha1:link_published_title' => 'Посилання, дата й заголовок',
			'sha1:link_published_title_content' => 'Посилання, дата, заголовок і текст',
			'sha1:published' => 'Дата',
			'sha1:title' => 'Заголовок',
			'sha1:title_published' => 'Заголовок і дата',
			'sha1:title_published_content' => 'Заголовок, дата й текст',
		),
		'url' => 'URL-адреса стрічки',
		'useragent' => 'Налаштувати користувацький агент для завантаження стрічки',
		'useragent_help' => 'Наприклад, <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Перевірити коректність стрічки',
		'website' => 'URL-адреса вебсайту',
		'websub' => 'Негайні сповіщення за допомогою WebSub',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'Експорт',
			'sqlite' => 'Завантажити користувацьку базу даних у форматі SQLite',
		),
		'export_labelled' => 'Статті з мітками',
		'export_opml' => 'Перелік стрічок (OPML)',
		'export_starred' => 'Вподобані',
		'feed_list' => 'Список статей %s',
		'file_to_import' => 'Файл для імпорту<br />(OPML, JSON або ZIP)',
		'file_to_import_no_zip' => 'Файл для імпорту<br />(OPML або JSON)',
		'import' => 'Імпорт',
		'starred_list' => 'Список вподобаних статей',
		'title' => 'Імпорт/експорт',
	),
	'menu' => array(
		'add' => 'Додати стрічку чи категорію',
		'import_export' => 'Імпорт/експорт',
		'label_management' => 'Керування мітками',
		'stats' => array(
			'idle' => 'Неактивні стрічки',
			'main' => 'Основна статистика',
			'repartition' => 'Перерозподіл статей',
		),
		'subscription_management' => 'Керування підписками',
		'subscription_tools' => 'Засоби підписки',
	),
	'tag' => array(
		'auto_label' => 'Додавати мітку до нових статей',
		'name' => 'Назва',
		'new_name' => 'Нова назва',
		'old_name' => 'Стара назва',
	),
	'title' => array(
		'_' => 'Керування підписками',
		'add' => 'Додати стрічку чи категорію',
		'add_category' => 'Додати категорію',
		'add_dynamic_opml' => 'Додати динамічний OPML',
		'add_feed' => 'Додати стрічку',
		'add_label' => 'Додати мітку',
		'add_opml_category' => 'Назва категорії OPML',
		'delete_label' => 'Видалити мітку',
		'feed_management' => 'Керування RSS-стрічками',
		'subscription_tools' => 'Засоби підписки',
	),
);

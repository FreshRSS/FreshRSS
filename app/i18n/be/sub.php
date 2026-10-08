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
	'api' => array(
		'documentation' => 'Скапіруйце наступны URL-адрас, каб выкарыстоўваць яго ў знешнім інструменце.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'Перацягніце гэту кнопку на панэль закладак або націсніце на яе правай кнопкай мышы і выберыце «Дадаць спасылку ў закладкі». Затым націсніце кнопку «Падпісацца» на любой старонцы, на якую хочаце падпісацца.',
		'label' => 'Падпісацца',
		'title' => 'Закладка-скрыпт',
	),
	'category' => array(
		'_' => 'Катэгорыя',
		'add' => 'Дадаць катэгорыю',
		'archiving' => 'Архіваванне',
		'dynamic_opml' => array(
			'_' => 'Дынамічны OPML',
			'help' => 'Укажыце URL-адрас <a href="https://opml.org/" target="_blank">файла OPML</a>, каб дынамічна напоўніць гэту катэгорыю стужкамі',
		),
		'empty' => 'Пустая катэгорыя',
		'error' => 'У гэтай дынамічнай катэгорыі OPML узнікла праблема. Праверце, ці па-ранейшаму даступны URL-адрас OPML і ці не перавышана максімальная колькасць стужак на карыстальніка.',
		'expand' => 'Разгарнуць катэгорыю',
		'information' => 'Інфармацыя',
		'open' => 'Адкрыць катэгорыю',
		'opml_url' => 'URL-адрас OPML',
		'position' => 'Пазіцыя паказу',
		'position_help' => 'Для кіравання парадкам сартавання катэгорый',
		'title' => 'Назва',
	),
	'feed' => array(
		'accept_cookies' => 'Прымаць кукі',
		'accept_cookies_help' => 'Дазваляе серверу стужкі ўсталёўваць кукі (захоўваюцца ў памяці толькі на час запыту)',
		'add' => 'Дадаць стужку',
		'advanced' => 'Дадатковыя',
		'archiving' => 'Архіваванне',
		'auth' => array(
			'configuration' => 'Уваход',
			'help' => 'Забяспечвае доступ да абароненых праз HTTP RSS-стужак',
			'http' => 'Аўтэнтыфікацыя HTTP',
			'password' => 'Пароль HTTP',
			'username' => 'Імя карыстальніка HTTP',
		),
		'change_favicon' => 'Змяніць…',
		'clear_cache' => 'Заўсёды ачышчаць кэш',
		'content_action' => array(
			'_' => 'Дзеянне са змесцівам пры атрыманні змесціва артыкула',
			'append' => 'Дадаць пасля наяўнага змесціва',
			'prepend' => 'Дадаць перад наяўным змесцівам',
			'replace' => 'Замяніць наяўнае змесціва',
		),
		'content_retrieval' => 'Атрыманне змесціва',
		'css_cookie' => 'Кукі пры атрыманні змесціва артыкула',
		'css_cookie_help' => 'Прыклад: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'Атрымлівае скарочаныя RSS-стужкі (увага, патрабуе больш часу!)',
		'css_path' => 'CSS-селектар артыкула на арыгінальным вэб-сайце',
		'css_path_filter' => array(
			'_' => 'CSS-селектар элементаў для выдалення',
			'help' => 'CSS-селектар можа быць спісам, напрыклад: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'Апісанне',
		'empty' => 'Гэта стужка пустая. Праверце, ці па-ранейшаму падтрымліваецца яна.',
		'error' => 'У гэтай стужцы ўзнікла праблема. Калі сітуацыя не зменіцца, праверце, ці па-ранейшаму даступная яна.',
		'export-as-opml' => array(
			'download' => 'Спампаваць',
			'help' => 'Файл XML (падмноства даных. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">Глядзіце дакументацыю</a>)',
			'label' => 'Экспартаваць у OPML',
		),
		'ext_favicon' => 'Задаваць аўтаматычна',
		'favicon_changed_by_ext' => 'Значок зададзены пашырэннем <b>%s</b>.',
		'filteractions' => array(
			'_' => 'Дзеянні фільтрацыі',
			'help' => 'Запісвайце па адным пошукавым фільтры ў радку. Аператары: <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">глядзіце дакументацыю</a>.',
			'view_filter' => 'Перадпрагляд фільтраў на наяўных артыкулах (новае акно)',
		),
		'global_hint' => 'Выкарыстоўвайце <a href="%s">глабальны выгляд</a>, каб убачыць, колькі артыкулаў у кожнай стужцы адпавядае стану або пошукаваму выразу',
		'http_headers' => 'Загалоўкі HTTP',
		'http_headers_help' => 'Загалоўкі аддзяляюцца сімвалам новага радка, а назва і значэнне загалоўка — двукроп\'ем (напрыклад: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',
		'icon' => 'Значок',
		'information' => 'Інфармацыя',
		'keep_adding_feed' => 'Дадаць потым яшчэ стужкі',
		'keep_min' => 'Мінімальная колькасць артыкулаў для захавання',
		'kind' => array(
			'_' => 'Тып крыніцы стужкі',
			'html_json' => array(
				'_' => 'HTML + XPath + кропкавая натацыя JSON (JSON у HTML)',
				'xpath' => array(
					'_' => 'XPath для JSON у HTML',
					'help' => 'Прыклад: <code>normalize-space(//script[@type="application/json"])</code> (адзін JSON)<br />або: <code>//script[@type="application/ld+json"]</code> (па адным аб\'екце JSON на артыкул)',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (вэб-скрэйпінг)',
				'feed_title' => array(
					'_' => 'Назва стужкі',
					'help' => 'Прыклад: <code>//title</code> або статычны радок: <code>"My custom feed"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> — стандартная мова запытаў для дасведчаных карыстальнікаў, якую FreshRSS падтрымлівае для вэб-скрэйпінгу.',
				'item' => array(
					'_' => 'Пошук <strong>элементаў</strong> навін<br /><small>(найважнейшае)</small>',
					'help' => 'Прыклад: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'Аўтар элемента',
					'help' => 'Можа быць і статычным радком. Прыклад: <code>"Anonymous"</code>',
				),
				'item_categories' => 'Тэгі элемента',
				'item_content' => array(
					'_' => 'Змесціва элемента',
					'help' => 'Прыклад атрымання элемента цалкам: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'Мініяцюра элемента',
					'help' => 'Прыклад: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Карыстальніцкі фармат даты і часу',
					'help' => 'Неабавязкова. Фармат, што падтрымліваецца <a href="https://www.php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, напрыклад <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'Дата элемента',
					'help' => 'Вынік будзе разабраны з дапамогай <a href="https://www.php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'Назва элемента',
					'help' => 'Ужывайце, у прыватнасці, <a href="https://developer.mozilla.org/docs/Web/XML/XPath/Reference/Axes" target="_blank">вось XPath</a> <code>descendant::</code>, напрыклад <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'Унікальны ідэнтыфікатар элемента',
					'help' => 'Неабавязкова. Прыклад: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'Спасылка элемента (URL)',
					'help' => 'Прыклад: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (адносна элемента) для:',
				'xpath' => 'XPath для:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON з кропкавай натацыяй',
				'feed_title' => array(
					'_' => 'Назва стужкі',
					'help' => 'Прыклад: <code>meta.title</code> або статычны радок: <code>"My custom feed"</code>',
				),
				'help' => 'У кропкавай натацыі JSON кропкі выкарыстоўваюцца паміж аб\'ектамі, а квадратныя дужкі — для масіваў (напрыклад, <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'Пошук <strong>элементаў</strong> навін<br /><small>(найважнейшае)</small>',
					'help' => 'Шлях JSON да масіву, які змяшчае элементы, напрыклад <code>$</code> або <code>newsItems</code>',
				),
				'item_author' => 'Аўтар элемента',
				'item_categories' => 'Тэгі элемента',
				'item_content' => array(
					'_' => 'Змесціва элемента',
					'help' => 'Ключ, пад якім знаходзіцца змесціва, напрыклад <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'Мініяцюра элемента',
					'help' => 'Прыклад: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Карыстальніцкі фармат даты і часу',
					'help' => 'Неабавязкова. Фармат, што падтрымліваецца <a href="https://www.php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>, напрыклад <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'Дата элемента',
					'help' => 'Вынік будзе разабраны з дапамогай <a href="https://www.php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'Назва элемента',
				'item_uid' => 'Унікальны ідэнтыфікатар элемента',
				'item_uri' => array(
					'_' => 'Спасылка элемента (URL)',
					'help' => 'Прыклад: <code>permalink</code>',
				),
				'json' => 'кропкавая натацыя для:',
				'relative' => 'шлях у кропкавай натацыі (адносна элемента) для:',
			),
			'jsonfeed' => 'JSON Feed',	// IGNORE
			'rss' => 'RSS / Atom (прадвызначаны)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'last-entry-publication-date' => 'Апошні апублікаваны артыкул <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-entry-received-date' => 'Апошні атрыманы артыкул <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-error-date' => 'Апошняе памылковае абнаўленне <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-update' => 'Апошняе паспяховае абнаўленне <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'maintenance' => array(
			'clear_cache' => 'Ачысціць кэш',
			'clear_cache_help' => 'Ачышчае кэш гэтай стужкі.',
			'reload_articles' => 'Перазагрузіць артыкулы',
			'reload_articles_help' => 'Перазагружае зададзеную колькасць артыкулаў і атрымлівае поўнае змесціва, калі вызначаны селектар.',
			'title' => 'Абслугоўванне',
		),
		'max_http_redir' => 'Максімальная колькасць перанакіраванняў HTTP',
		'max_http_redir_help' => 'Задайце 0 або пакіньце поле пустым, каб адключыць перанакіраванні; -1 — для безліміту перанакіраванняў',
		'method' => array(
			'_' => 'Метад HTTP',
		),
		'method_help' => 'Цела запыту POST аўтаматычна падтрымлівае <code>application/x-www-form-urlencoded</code> і <code>application/json</code>',
		'method_postparams' => 'Цела запыту POST',
		'moved_category_deleted' => 'Пасля выдалення катэгорыі яе стужкі аўтаматычна класіфікуюцца ў <em>%s</em>.',
		'mute' => array(
			'_' => 'заглушыць',
			'state_is_muted' => 'Гэта стужка заглушана',
		),
		'no_selected' => 'Стужка не выбрана.',
		'number_entries' => '%d артыкулаў',
		'open_feed' => 'Адкрыць стужку %s',
		'path_entries_conditions' => 'Умовы атрымання змесціва',
		'priority' => array(
			'_' => 'Бачнасць',
			'category' => 'Паказваць у катэгорыі',
			'feed' => 'Паказваць у стужцы',
			'hidden' => 'Не паказваць',
			'important' => 'Паказваць у важных стужках',
			'main_stream' => 'Паказваць у галоўнай стужцы',
		),
		'proxy' => 'Проксі для атрымання гэтай стужкі',
		'proxy_help' => 'Выберыце пратакол (напрыклад: SOCKS5) і ўвядзіце адрас проксі (напрыклад: <kbd>127.0.0.1:1080</kbd> або <kbd>username:password@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'Скінуць да прадвызначанага',
		'selector_preview' => array(
			'show_raw' => 'Паказаць зыходны код',
			'show_rendered' => 'Паказваць змесціва',
		),
		'show' => array(
			'all' => 'Усе стужкі',
			'error' => 'Паказаць толькі стужкі з памылкамі',
		),
		'showing' => array(
			'error' => 'Паказваюцца толькі стужкі з памылкамі',
		),
		'ssl_verify' => 'Правяраць бяспеку SSL',
		'stats' => 'Статыстыка',
		'think_to_add' => 'Дадайце некалькі стужак.',
		'timeout' => 'Час чакання ў секундах',
		'title' => 'Назва',
		'title_add' => 'Дадаць RSS-стужку',
		'ttl' => 'Мінімальны інтэрвал аўтаматычнага абнаўлення',
		'unicityCriteria' => array(
			'_' => 'Крытэрый унікальнасці артыкулаў',
			'forced' => '<span title="Заблакіраваць крытэрый унікальнасці, нават калі ў стужцы ёсць дублікаты артыкулаў">Прымусова</span>',
			'help' => 'Актуальна для праблемных стужак.<br />⚠️ Змяненне палітыкі створыць дублікаты.',
			'id' => 'Стандартны ID (прадвызначаны)',
			'link' => 'Спасылка',
			'sha1:content' => 'Змесціва',
			'sha1:content_published' => 'Змесціва + дата',
			'sha1:link_published' => 'Спасылка + дата',
			'sha1:link_published_title' => 'Спасылка + дата + назва',
			'sha1:link_published_title_content' => 'Спасылка + дата + назва + змесціва',
			'sha1:published' => 'Дата',
			'sha1:title' => 'Назва',
			'sha1:title_published' => 'Назва + дата',
			'sha1:title_published_content' => 'Назва + дата + змесціва',
		),
		'url' => 'URL-адрас стужкі',
		'useragent' => 'User agent для атрымання гэтай стужкі',
		'useragent_help' => 'Прыклад: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'Праверыць сапраўднасць стужкі',
		'website' => 'URL-адрас вэб-сайта',
		'websub' => 'Імгненныя апавяшчэнні праз WebSub',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'Экспарт',
			'sqlite' => 'Спампаваць базу даных карыстальніка як SQLite',
		),
		'export_labelled' => 'Экспартаваць пазначаныя артыкулы',
		'export_opml' => 'Экспартаваць спіс стужак (OPML)',
		'export_starred' => 'Экспартаваць абраныя',
		'feed_list' => 'Спіс артыкулаў %s',
		'file_to_import' => 'Файл для імпарту<br />(OPML, JSON або ZIP)',
		'file_to_import_no_zip' => 'Файл для імпарту<br />(OPML або JSON)',
		'import' => 'Імпарт',
		'starred_list' => 'Спіс абраных артыкулаў',
		'title' => 'Імпарт / экспарт',
	),
	'menu' => array(
		'add' => 'Дадаць стужку або катэгорыю',
		'import_export' => 'Імпарт / экспарт',
		'label_management' => 'Меткі',
		'stats' => array(
			'idle' => 'Неактыўныя стужкі',
			'main' => 'Асноўная статыстыка',
			'repartition' => 'Размеркаванне артыкулаў',
			'unread_dates' => 'Даты непрачытаных',
		),
		'subscription_management' => 'Падпіскі',
		'subscription_tools' => 'Інструменты падпіскі',
	),
	'tag' => array(
		'auto_label' => 'Дадаваць гэту метку да новых артыкулаў',
		'name' => 'Назва',
		'new_name' => 'Новая назва',
		'old_name' => 'Старая назва',
	),
	'title' => array(
		'_' => 'Падпіскі',
		'add' => 'Дадаць стужку або катэгорыю',
		'add_category' => 'Дадаць катэгорыю',
		'add_dynamic_opml' => 'Дадаць дынамічны OPML',
		'add_feed' => 'Дадаць стужку',
		'add_label' => 'Дадаць метку',
		'add_opml_category' => 'Назва катэгорыі OPML',
		'delete_label' => 'Выдаліць гэту метку',
		'feed_management' => 'Падпіскі',
		'subscription_tools' => 'Інструменты падпіскі',
	),
);

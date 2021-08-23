<?php

return array(
	'archiving' => array(
		'_' => 'Архивирование',
		'delete_after' => 'Удалять статьи после',
		'exception' => 'Исключения при очистке',
		'help' => 'В индивидуальных настройках лент есть больше опций',
		'keep_favourites' => 'Никогда не удалять избранное',
		'keep_labels' => 'Никогда не удалять метки',
		'keep_max' => 'Максимальное количество статей',
		'keep_min_by_feed' => 'Минимальное количество статей в ленте',
		'keep_period' => 'Максимальный возраст статей',
		'keep_unreads' => 'Никогда не удалять непрочитанные статьи',
		'maintenance' => 'Обслуживание',
		'optimize' => 'Оптимизировать базу данных',
		'optimize_help' => 'Выполняйте время от времени, чтобы уменьшить размер базы данных',
		'policy' => 'Политика очистки',
		'policy_warning' => 'Если ни одна политика очистки не выбрана, все статьи будут оставлены.',
		'purge_now' => 'Запустить очистку сейчас',
		'title' => 'Архивирование',
		'ttl' => 'Не актуализировать автоматически чаще чем',
	),
	'display' => array(
		'_' => 'Отображение',
		'icon' => array(
			'bottom_line' => 'Нижняя линия',
			'display_authors' => 'Авторы',
			'entry' => 'Иконки статей',
			'publication_date' => 'Дата публикации',
			'related_tags' => 'Связанные метки',
			'sharing' => 'Поделиться',
			'top_line' => 'Верхняя линия',
		),
		'language' => 'Язык',
		'notif_html5' => array(
			'seconds' => 'секунд (0 - нет таймаута)',
			'timeout' => 'Таймаут уведомлений HTML5',
		),
		'show_nav_buttons' => 'Показать кнопки навигации',
		'theme' => 'Тема',
		'title' => 'Отображение',
		'width' => array(
			'content' => 'Ширина содержимого',
			'large' => 'Широкое',
			'medium' => 'Среднее',
			'no_limit' => 'Во всю ширину',
			'thin' => 'Узкое',
		),
	),
	'profile' => array(
		'_' => 'Настройки профиля',
		'api' => 'Настройки API',
		'delete' => array(
			'_' => 'Удаление аккаунта',
			'warn' => 'Ваш аккаунт и вся связанная с ним информация будут удалены.',
		),
		'email' => 'Адрес электронной почты',
		'password_api' => 'Пароль API<br /><small>(например, для мобильных приложений)</small>',
		'password_form' => 'Пароль<br /><small>(для входа через веб-форму)</small>',
		'password_format' => 'Не менее 7 символов',
		'title' => 'Профиль',
	),
	'query' => array(
		'_' => 'Пользовательские запросы',
		'deprecated' => 'Этот запрос больше не действителен. Связанная категория или лента была удалена.',
		'display' => 'Показать результаты пользовательского запроса',
		'filter' => array(
			'_' => 'Применённые фильтры:',
			'categories' => 'Отображение по категории',
			'feeds' => 'Отображение по ленте',
			'order' => 'Сортировать по дате',
			'search' => 'Выражение',
			'state' => 'Состояние',
			'tags' => 'Отображение по метке',
			'type' => 'Тип',
		),
		'get_all' => 'Показать все статьи',
		'get_category' => 'Показать категорию "%s"',
		'get_favorite' => 'Показать избранные статьи',
		'get_feed' => 'Показать ленту "%s"',
		'get_tag' => 'Показать метку "%s"',
		'name' => 'Название',
		'no_filter' => 'Нет фильтров',
		'none' => 'Вы ещё не создавали пользовательские запросы.',
		'number' => 'Запрос №%d',
		'order_asc' => 'Показывать сначала старые статьи',
		'order_desc' => 'Показывать сначала новые статьи',
		'remove' => 'Удалить пользовательский запрос',
		'search' => 'Искать "%s"',
		'state_0' => 'Показать все статьи',
		'state_1' => 'Показать прочитанные статьи',
		'state_2' => 'Показать непрочитанные статьи',
		'state_3' => 'Показать все статьи',
		'state_4' => 'Показать избранные статьи',
		'state_5' => 'Показать прочитанные избранные статьи',
		'state_6' => 'Показать непрочитанные избранные статьи',
		'state_7' => 'Показать избранные статьи',
		'state_8' => 'Показать неизбранные статьи',
		'state_9' => 'Показать прочитанные неизбранные статьи',
		'state_10' => 'Показать непрочитанные неизбранные статьи',
		'state_11' => 'Показать неизбранные статьи',
		'state_12' => 'Показать все статьи',
		'state_13' => 'Показать прочитанные статьи',
		'state_14' => 'Показать непрочитанные статьи',
		'state_15' => 'Показать все статьи',
		'title' => 'Пользовательские запросы',
	),
	'reading' => array(
		'_' => 'Чтение',
		'after_onread' => 'После «отметить всё прочитанным»',
		'always_show_favorites' => 'Показывать все статьи в избранном по умолчанию',
		'articles_per_page' => 'Количество статей на странице',
		'auto_load_more' => 'Загружать больше статей при достижении низа страницы',
		'auto_remove_article' => 'Скрывать статьи по прочтении',
		'confirm_enabled' => 'Показывать диалог подтверждения при выпыполнении действия «отметить всё прочитанным»',
		'display_articles_unfolded' => 'Показывать статьи развёрнутыми по умолчанию',
		'display_categories_unfolded' => 'Какие категории развёртывать',
		'hide_read_feeds' => 'Скрывать категории и ленты без непрочитанных статей (не работает с «Показывать все статьи»)',
		'img_with_lazyload' => 'Использовать режим "ленивой загрузки" для загрузки картинок',
		'jump_next' => 'перейти к следующей ленте или категории',
		'mark_updated_article_unread' => 'Отмечать обновлённые статьи непрочитанными',
		'number_divided_when_reader' => 'Делится на 2 в виде для чтения.',
		'read' => array(
			'article_open_on_website' => 'когда статья открывается на её сайте',
			'article_viewed' => 'когда статья просматривается',
			'scroll' => 'во время прокрутки',
			'upon_reception' => 'по получении статьи',
			'when' => 'Отмечать статью прочитанной…',
		),
		'show' => array(
			'_' => 'Какие статьи отображать',
			'active_category' => 'Активная категория',
			'adaptive' => 'Адаптивно',
			'all_articles' => 'Показывать все статьи',
			'all_categories' => 'Все категории',
			'no_category' => 'Никаких категорий',
			'remember_categories' => 'Запоминать открытые категории',
			'unread' => 'Только непрочитанные',
		),
		'show_fav_unread_help' => 'Также относится к меткам',
		'sides_close_article' => 'Нажатия мышью за пределами текста статьи закрывают статью',
		'sort' => array(
			'_' => 'Порядок сортировки',
			'newer_first' => 'Сначала новые',
			'older_first' => 'Сначала старые',
		),
		'sticky_post' => 'Прикрепить статью к верху при открытии',
		'title' => 'Чтение',
		'view' => array(
			'default' => 'Вид по умолчанию',
			'global' => 'Глобальный вид',
			'normal' => 'Обычный вид',
			'reader' => 'Вид для чтения',
		),
	),
	'sharing' => array(
		'_' => 'Поделиться',
		'add' => 'Добавить способ поделиться',
		'diaspora' => 'Diaspora*',	// TODO - Translation
		'email' => 'Электронная почта',
		'facebook' => 'Facebook',	// TODO - Translation
		'more_information' => 'Больше информации',
		'print' => 'Распечатать',
		'raindrop' => 'Raindrop.io',
		'remove' => 'Удалить способ поделиться',
		'shaarli' => 'Shaarli',	// TODO - Translation
		'share_name' => 'Отображаемое имя',
		'share_url' => 'Используемый URL',
		'title' => 'Sharing',	// TODO - Translation
		'twitter' => 'Twitter',	// TODO - Translation
		'wallabag' => 'wallabag',	// TODO - Translation
	),
	'shortcut' => array(
		'_' => 'Горячие клавиши',
		'article_action' => 'Действия со статьями',
		'auto_share' => 'Поделиться',
		'auto_share_help' => 'Если способ единственный, он будет вызван. Иначе способы доступны по их номеру.',
		'close_dropdown' => 'Закрыть меню',
		'collapse_article' => 'Схлопнуть',
		'first_article' => 'Открыть первую статью',
		'focus_search' => 'К строке поиска',
		'global_view' => 'Переключиться на глобальный вид',
		'help' => 'Показать документацию',
		'javascript' => 'JavaScript должен быть включён для использования горячих клавиш',
		'last_article' => 'Открыть последнюю статью',
		'load_more' => 'Загрузить больше статей',
		'mark_favorite' => 'Отметить избранной',
		'mark_read' => 'Отметить прочитанной',
		'navigation' => 'Навигация',
		'navigation_help' => 'С модификатором <kbd>⇧ Shift</kbd> навигационные горячие клавиши применяются к лентам.<br/>С модификатором <kbd>Alt ⎇</kbd> навигационные горячие клавиши применяются к категориям.',
		'navigation_no_mod_help' => 'Следующие навигационные горячие клавиши не поддерживают модификаторы.',
		'next_article' => 'Открыть следующую статью',
		'non_standard' => 'Некоторые клавиши (<kbd>%s</kbd>) не могут быть использованы как горячие клавиши.',
		'normal_view' => 'Переключиться на обычный вид',
		'other_action' => 'Другие действия',
		'previous_article' => 'Открыть предыдущую статью',
		'reading_view' => 'Переключиться на вид для чтения',
		'rss_view' => 'Открыть вид RSS в новой вкладке',
		'see_on_website' => 'Посмотреть на сайте',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd>, чтобы отметить предыдущие статьи прочитанными<br />+ <kbd>⇧ Shift</kbd>, чтобы отметить все статьи прочитанными',
		'skip_next_article' => 'Перейти к следующей, не раскрывая',
		'skip_previous_article' => 'Перейти к предыдущей, не раскрывая',
		'title' => 'Горячие клавиши',
		'toggle_media' => 'Играть/приостановить медиаконтент',
		'user_filter' => 'К пользовательским запросам',
		'user_filter_help' => 'Если запрос единственный, он будет вызван. Иначе запросы доступны по их номеру.',
		'views' => 'Виды',
	),
	'user' => array(
		'articles_and_size' => '%s статей (%s)',
		'current' => 'Текущий пользователь',
		'is_admin' => 'является администратором',
		'users' => 'Пользователи',
	),
);

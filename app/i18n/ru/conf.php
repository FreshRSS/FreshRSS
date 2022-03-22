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
	'archiving' => array(
		'_' => 'Архивирование',
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
			'summary' => 'Резюме',
			'top_line' => 'Верхняя линия',
		),
		'language' => 'Язык',
		'notif_html5' => array(
			'seconds' => 'секунд (0 - нет таймаута)',
			'timeout' => 'Таймаут уведомлений HTML5',
		),
		'show_nav_buttons' => 'Показать кнопки навигации',
		'theme' => 'Тема',
		'theme_not_available' => 'Тема “%s” больше не доступна. Пожалуйста выберите другю тему.',
		'thumbnail' => array(
			'label' => 'Миниатюра',
			'landscape' => 'Альбомная ориентация',
			'none' => 'Пусто',
			'portrait' => 'Книжная ориентация',
			'square' => 'Площадь',
		),
		'title' => 'Отображение',
		'width' => array(
			'content' => 'Ширина содержимого',
			'large' => 'Широкое',
			'medium' => 'Среднее',
			'no_limit' => 'Во всю ширину',
			'thin' => 'Узкое',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Log Level',	// TODO
			'message' => 'Log Message',	// TODO
			'timestamp' => 'Timestamp',	// TODO
		),
		'pagination' => array(
			'first' => 'Первая',
			'last' => 'Последняя',
			'next' => 'Следующая',
			'previous' => 'Предыдущая',
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
		'name' => 'Название',
		'no_filter' => 'Нет фильтров',
		'number' => 'Запрос №%d',
		'order_asc' => 'Показывать сначала старые статьи',
		'order_desc' => 'Показывать сначала новые статьи',
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
		'headline' => array(
			'articles' => 'Articles: Open/Close',	// TODO
			'categories' => 'Left navigation: Categories',	// TODO
			'mark_as_read' => 'Mark article as read',	// TODO
			'misc' => 'Miscellaneous',	// TODO
			'view' => 'View',	// TODO
		),
		'hide_read_feeds' => 'Скрывать категории и ленты без непрочитанных статей (не работает с «Показывать все статьи»)',
		'img_with_lazyload' => 'Использовать режим "ленивой загрузки" для загрузки картинок',
		'jump_next' => 'перейти к следующей ленте или категории',
		'mark_updated_article_unread' => 'Отмечать обновлённые статьи непрочитанными',
		'number_divided_when_reader' => 'Делится на 2 в виде для чтения.',
		'read' => array(
			'article_open_on_website' => 'когда статья открывается на её сайте',
			'article_viewed' => 'когда статья просматривается',
			'keep_max_n_unread' => 'Максимальное количество непрочитанных статей',
			'scroll' => 'во время прокрутки',
			'upon_reception' => 'по получении статьи',
			'when' => 'Отмечать статью прочитанной…',
			'when_same_title' => 'если идентичный заголовок уже существует в верхних <i>n</i> новейших статьях',
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
		'blogotext' => 'Blogotext',	// IGNORE
		'deprecated' => 'This service is deprecated and will be removed from FreshRSS in a <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Open documentation for more information" target="_blank">future release</a>.',	// TODO
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Электронная почта',
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'Больше информации',
		'print' => 'Распечатать',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Удалить способ поделиться',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'Отображаемое имя',
		'share_url' => 'Используемый URL',
		'title' => 'Поделиться',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
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
		'next_unread_article' => 'Открыть следующую непрочитанную статью',
		'non_standard' => 'Некоторые клавиши (<kbd>%s</kbd>) не могут быть использованы как горячие клавиши.',
		'normal_view' => 'Переключиться на обычный вид',
		'other_action' => 'Другие действия',
		'previous_article' => 'Открыть предыдущую статью',
		'reading_view' => 'Переключиться на вид для чтения',
		'rss_view' => 'Открыть как RSS-канал',
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

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
	'about' => array(
		'_' => 'О проекте',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Информация о системе',
				'browser' => 'Браузер',
				'database' => 'База данных',
				'server_software' => 'ПО сервера',
				'version_curl' => 'Версия cURL',
				'version_frss' => 'Версия FreshRSS',
				'version_php' => 'Версия PHP',
			),
		),
		'bugs_reports' => 'Баг репорты',
		'documentation' => 'Документация',
		'freshrss_description' => 'FreshRSS — агрегатор RSS-лент для размещения на своём сервере. Лёгкий и простой в использовании, будучи при этом мощным и настраиваемым инструментом.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">в GitHub</a>',
		'license' => 'Лицензия',
		'project_website' => 'Сайт проекта',
		'title' => 'О проекте',
		'version' => 'Версия',
	),
	'feed' => array(
		'empty' => 'Нет статей для отображения.',
		'published' => array(
			'_' => 'Опубликовано',
			'future' => 'Опубликовано в будущем',
			'today' => 'Опубликовано сегодня',
			'yesterday' => 'Опубликовано вчера',
		),
		'received' => array(
			'_' => 'Получено',
			'today' => 'Получено сегодня',
			'yesterday' => 'Получено вчера',
		),
		'rss_of' => 'RSS-лента %s',
		'title' => 'Основной поток',
		'title_fav' => 'Избранное',
		'title_global' => 'Глобальный вид',
		'userModified' => array(
			'_' => 'Изменено пользователем',
			'today' => 'Изменено пользователем сегодня',
			'yesterday' => 'Изменено пользователем вчера',
		),
	),
	'log' => array(
		'_' => 'Журнал',
		'clear' => 'Очистить журнал',
		'empty' => 'Файл журнала пуст',
		'title' => 'Журнал',
	),
	'menu' => array(
		'about' => 'О FreshRSS',
		'before_one_day' => 'Старше одного дня',
		'before_one_week' => 'Старше одной недели',
		'bookmark_query' => 'Сохранить текущий запрос',
		'favorites' => 'Избранное (%s)',
		'global_view' => 'Глобальный вид',
		'important' => 'Важные ленты',
		'main_stream' => 'Основной поток',
		'mark_all_read' => 'Отметить всё прочитанным',
		'mark_cat_read' => 'Отметить категорию прочитанной',
		'mark_feed_read' => 'Отметить ленту прочитанной',
		'mark_selection_unread' => 'Отметить выделение прочитанным',
		'mylabels' => 'Мои метки',
		'non-starred' => 'Показать неизбранное',
		'normal_view' => 'Обычный вид',
		'queries' => 'Запросы',
		'read' => 'Показать прочитанное',
		'reader_view' => 'Вид для чтения',
		'rss_view' => 'RSS-лента',
		'search_short' => 'Поиск',
		'sort' => array(
			'asc' => 'Ascending',	// TODO
			'c' => array(
				'name_asc' => 'Категории, названия лент А→Я',
				'name_desc' => 'Категории, названия лент Я→А',
			),
			'date_asc' => 'Дата публикации 1→9',
			'date_desc' => 'Дата публикации 9→1',
			'desc' => 'Descending',	// TODO
			'f' => array(
				'name_asc' => 'Названия лент А→Я',
				'name_desc' => 'Названия лент Я→А',
			),
			'id_asc' => 'Недавно полученные последними',
			'id_desc' => 'Недавно полученные первыми',
			'length_asc' => 'Длина контента 1→9',
			'length_desc' => 'Длина контента 9→1',
			'link_asc' => 'Ссылка А→Я',
			'link_desc' => 'Ссылка Я→А',
			'primary' => array(
				'_' => 'Sorting criterion',	// TODO
				'help' => 'Sorting by <em>received</em> date is recommended in most cases, for consistency and performance',	// TODO
			),
			'rand' => 'Случайный порядок',
			'secondary' => array(
				'_' => 'Secondary sorting criterion',	// TODO
				'help' => 'Only relevant when the primary sorting criterion is categories or feeds titles',	// TODO
			),
			'title_asc' => 'Заголовок А→Я',
			'title_desc' => 'Заголовок Я→А',
			'user_modified_asc' => 'Изменено пользователем 1→9',
			'user_modified_desc' => 'Изменено пользователем 9→1',
		),
		'starred' => 'Показать избранное',
		'stats' => 'Статистика',
		'subscription' => 'Управление подписками',
		'unread' => 'Показать непрочитанное',
	),
	'share' => 'Обмен',
	'tag' => array(
		'related' => 'Теги статьи',
	),
	'tos' => array(
		'title' => 'Условия предоставления услуг',
	),
);

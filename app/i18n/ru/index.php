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
	'about' => array(
		'_' => 'О проекте',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'System information',	// TODO
				'browser' => 'Browser',	// TODO
				'database' => 'Database',	// TODO
				'server_software' => 'Server software',	// TODO
				'version_curl' => 'cURL version',	// TODO
				'version_frss' => 'FreshRSS version',	// TODO
				'version_php' => 'PHP version',	// TODO
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
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => 'RSS-лента %s',
		'title' => 'Основной поток',
		'title_fav' => 'Избранное',
		'title_global' => 'Глобальный вид',
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
		'newer_first' => 'Сначала новые',
		'non-starred' => 'Показать неизбранное',
		'normal_view' => 'Обычный вид',
		'older_first' => 'Сначала старые',
		'queries' => 'Запросы',
		'read' => 'Показать прочитанное',
		'reader_view' => 'Вид для чтения',
		'rss_view' => 'RSS-лента',
		'search_short' => 'Поиск',
		'sort' => array(
			'_' => 'Sorting criteria',	// TODO
			'c' => array(
				'name_asc' => 'Category, feed titles A→Z',	// TODO
				'name_desc' => 'Category, feed titles Z→A',	// TODO
			),
			'date_asc' => 'Publication date 1→9',	// TODO
			'date_desc' => 'Publication date 9→1',	// TODO
			'f' => array(
				'name_asc' => 'Feed title A→Z',	// TODO
				'name_desc' => 'Feed title Z→A',	// TODO
			),
			'id_asc' => 'Freshly received last',	// TODO
			'id_desc' => 'Freshly received first',	// TODO
			'link_asc' => 'Link A→Z',	// TODO
			'link_desc' => 'Link Z→A',	// TODO
			'rand' => 'Random order',	// TODO
			'title_asc' => 'Title A→Z',	// TODO
			'title_desc' => 'Title Z→A',	// TODO
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

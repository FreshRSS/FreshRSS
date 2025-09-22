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
		'_' => 'Про програму',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Дані про систему',
				'browser' => 'Браузер',
				'database' => 'База даних',
				'server_software' => 'Серверне ПЗ',
				'version_curl' => 'Версія cURL',
				'version_frss' => 'Версія FreshRSS',
				'version_php' => 'Версія PHP',
			),
		),
		'bugs_reports' => 'Звіти про вади',
		'documentation' => 'Документація',
		'freshrss_description' => 'FreshRSS — це агрегатор і читач RSS-стрічок, який можна встановити на власному сервері. Це надає змогу підписуватись на декілька сайтів новин і читати їх в одній стрічці, не перемикаючись між сайтами. FreshRSS — ощадлива й проста у використанні програма, гнучка в налаштуванні.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">на GitHub</a>',
		'license' => 'Ліцензія',
		'project_website' => 'Сайт проєкту',
		'title' => 'Про програму',
		'version' => 'Версія',
	),
	'feed' => array(
		'empty' => 'Нема статей для показу.',
		'received' => array(
			'before_yesterday' => 'Отримано раніше за вчора',
			'today' => 'Отримано сьогодні',
			'yesterday' => 'Отримано вчора',
		),
		'rss_of' => 'RSS-стрічка %s',
		'title' => 'Головний потік',
		'title_fav' => 'Вподобані',
		'title_global' => 'Глобальний показ',
	),
	'log' => array(
		'_' => 'Журнали',
		'clear' => 'Очистити журнали',
		'empty' => 'Файл журналів порожній',
		'title' => 'Журнали',
	),
	'menu' => array(
		'about' => 'Про FreshRSS',
		'before_one_day' => 'Старіші за день',
		'before_one_week' => 'Старіші за тиждень',
		'bookmark_query' => 'Додати поточний запит у закладки',
		'favorites' => 'Вподобані (%s)',
		'global_view' => 'Загальний показ',
		'important' => 'Важливі стрічки',
		'main_stream' => 'Головний потік',
		'mark_all_read' => 'Позначити всі прочитаними',
		'mark_cat_read' => 'Позначити категорію прочитаною',
		'mark_feed_read' => 'Позначити стрічку прочитаною',
		'mark_selection_unread' => 'Позначити вибрані непрочитаними',
		'mylabels' => 'Мої мітки',
		'newer_first' => 'Спершу новіші',
		'non-starred' => 'Показати невподобані',
		'normal_view' => 'Звичайний показ',
		'older_first' => 'Спершу старіші',
		'queries' => 'Користувацькі запити',
		'read' => 'Показати прочитані',
		'reader_view' => 'Читацький показ',
		'rss_view' => 'RSS-стрічка',
		'search_short' => 'Пошук',
		'sort' => array(
			'_' => 'Критерії впорядкування',
			'c' => array(
				'name_asc' => 'Заголовки категорії та стрічки А→Я',
				'name_desc' => 'Заголовки категорії та стрічки Я→А',
			),
			'date_asc' => 'Дата оприлюднення 1→9',
			'date_desc' => 'Дата оприлюднення 9→1',
			'f' => array(
				'name_asc' => 'Назва стрічки A→Z',
				'name_desc' => 'Назва стрічки Z→A',
			),
			'id_asc' => 'Спершу найдавніше отримані',
			'id_desc' => 'Спершу щойно отримані',
			'link_asc' => 'Посилання А→Я',
			'link_desc' => 'Посилання Я→А',
			'rand' => 'Довільний порядок',
			'title_asc' => 'Заголовок А→Я',
			'title_desc' => 'Заголовок Я→А',
		),
		'starred' => 'Показати вподобані',
		'stats' => 'Статистика',
		'subscription' => 'Керування підписками',
		'unread' => 'Показати непрочитані',
	),
	'share' => 'Поширити',
	'tag' => array(
		'related' => 'Теги статей',
	),
	'tos' => array(
		'title' => 'Умови надання послуг',
	),
);

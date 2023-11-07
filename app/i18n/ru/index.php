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
		'bugs_reports' => 'Баг репорты',
		'credits' => 'Авторство',
		'credits_content' => 'Некоторые элементы дизайна взяты из <a href="http://twitter.github.io/bootstrap/">Bootstrap</a>, хотя FreshRSS не использует этот фреймворк. <a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">Иконки</a> взяты из <a href="https://www.gnome.org/">проекта GNOME</a>. Шрифт <em>Open Sans</em> создан <a href="https://fonts.google.com/specimen/Open+Sans">Стивом Мэттесоном</a>. FreshRSS основан на <a href="https://framagit.org/marienfressinaud/MINZ">Minz</a>, PHP-фреймворке.',
		'documentation' => 'Документация',
		'freshrss_description' => 'FreshRSS — агрегатор RSS-лент для размещения на своём сервере. Лёгкий и простой в использовании, будучи при этом мощным и настраиваемым инструментом.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">в Github</a>',
		'license' => 'Лицензия',
		'project_website' => 'Сайт проекта',
		'title' => 'О проекте',
		'version' => 'Версия',
	),
	'feed' => array(
		'empty' => 'Нет статей для отображения.',
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
		'important' => 'Important feeds',	// TODO
		'main_stream' => 'Основной поток',
		'mark_all_read' => 'Отметить всё прочитанным',
		'mark_cat_read' => 'Отметить категорию прочитанной',
		'mark_feed_read' => 'Отметить ленту прочитанной',
		'mark_selection_unread' => 'Отметить выделение прочитанным',
		'newer_first' => 'Сначала новые',
		'non-starred' => 'Показать неизбранное',
		'normal_view' => 'Обычный вид',
		'older_first' => 'Сначала старые',
		'queries' => 'Запросы',
		'read' => 'Показать прочитанное',
		'reader_view' => 'Вид для чтения',
		'rss_view' => 'RSS-лента',
		'search_short' => 'Поиск',
		'starred' => 'Показать избранное',
		'stats' => 'Статистика',
		'subscription' => 'Управление подписками',
		'tags' => 'Мои метки',
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

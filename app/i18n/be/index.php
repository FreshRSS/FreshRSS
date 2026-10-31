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
		'_' => 'Пра праграму',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'Сістэмная інфармацыя',
				'browser' => 'Браўзер',
				'database' => 'База даных',
				'server_software' => 'Сервернае праграмнае забеспячэнне',
				'version_curl' => 'Версія cURL',
				'version_frss' => 'Версія FreshRSS',
				'version_php' => 'Версія PHP',
			),
		),
		'bugs_reports' => 'Паведамленні пра памылкі',
		'documentation' => 'Дакументацыя',
		'freshrss_description' => 'FreshRSS — гэта агрэгатар і чытальнік RSS, які можна ўсталяваць на ўласным серверы. Ён дазваляе чытаць і сачыць за некалькімі навінавымі сайтамі адначасова, не пераходзячы з аднаго на іншы. FreshRSS — лёгкая праграма, простая ў выкарыстанні і наладжванні.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">на GitHub</a>',
		'license' => 'Ліцэнзія',
		'project_website' => 'Вэб-сайт праекта',
		'title' => 'Пра праграму',
		'version' => 'Версія',
	),
	'feed' => array(
		'empty' => 'Няма артыкулаў для паказу.',
		'published' => array(
			'_' => 'Апублікавана',
			'future' => 'Апублікавана ў будучыні',
			'today' => 'Апублікавана сёння',
			'yesterday' => 'Апублікавана ўчора',
		),
		'received' => array(
			'_' => 'Атрымана',
			'today' => 'Атрымана сёння',
			'yesterday' => 'Атрымана ўчора',
		),
		'rss_of' => 'RSS-стужка %s',
		'title' => 'Асноўная стужка',
		'title_fav' => 'Абранае',
		'title_global' => 'Глабальны выгляд',
		'userModified' => array(
			'_' => 'Зменена карыстальнікам',
			'today' => 'Зменена карыстальнікам сёння',
			'yesterday' => 'Зменена карыстальнікам учора',
		),
	),
	'log' => array(
		'_' => 'Журнал',
		'clear' => 'Ачысціць журнал',
		'empty' => 'Файл журнала пусты',
		'title' => 'Журнал',
	),
	'menu' => array(
		'about' => 'Пра FreshRSS',
		'before_one_day' => 'Старэйшыя за адзін дзень',
		'before_one_week' => 'Старэйшыя за адзін тыдзень',
		'bookmark_query' => 'Дадаць бягучы запыт у закладкі',
		'favorites' => 'Абранае (%s)',
		'global_view' => 'Глабальны выгляд',
		'important' => 'Важныя стужкі',
		'main_stream' => 'Асноўная стужка',
		'mark_all_read' => 'Пазначыць усё як прачытанае',
		'mark_cat_read' => 'Пазначыць катэгорыю як прачытаную',
		'mark_feed_read' => 'Пазначыць стужку як прачытаную',
		'mark_selection_unread' => 'Пазначыць выбранае як непрачытанае',
		'mylabels' => 'Мае меткі',
		'non-starred' => 'Паказваць неабранае',
		'normal_view' => 'Звычайны выгляд',
		'queries' => 'Карыстальніцкія запыты',
		'read' => 'Паказваць прачытанае',
		'reader_view' => 'Рэжым чытання',
		'rss_view' => 'RSS-стужка',
		'search_short' => 'Пошук',
		'sort' => array(
			'asc' => 'Па ўзрастанні',
			'c' => array(
				'name_asc' => 'Катэгорыя, назвы стужак A→Z',
				'name_desc' => 'Катэгорыя, назвы стужак Z→A',
			),
			'date_asc' => 'Дата публікацыі 1→9',
			'date_desc' => 'Дата публікацыі 9→1',
			'desc' => 'Па ўбыванні',
			'f' => array(
				'name_asc' => 'Назва стужкі A→Z',
				'name_desc' => 'Назва стужкі Z→A',
			),
			'id_asc' => 'Апошнія атрыманыя — у канцы',
			'id_desc' => 'Апошнія атрыманыя — спачатку',
			'length_asc' => 'Даўжыня змесціва 1→9',
			'length_desc' => 'Даўжыня змесціва 9→1',
			'link_asc' => 'Спасылка A→Z',
			'link_desc' => 'Спасылка Z→A',
			'primary' => array(
				'_' => 'Крытэрый сартавання',
				'help' => 'Сартаванне па даце <em>атрымання</em> рэкамендуецца ў большасці выпадкаў для ўзгодненасці і прадукцыйнасці',
			),
			'rand' => 'Выпадковы парадак',
			'secondary' => array(
				'_' => 'Другасны крытэрый сартавання',
				'help' => 'Мае значэнне толькі тады, калі асноўным крытэрыем сартавання з\'яўляюцца катэгорыі або назвы стужак',
			),
			'title_asc' => 'Назва A→Z',
			'title_desc' => 'Назва Z→A',
			'user_modified_asc' => 'Зменены карыстальнікам 1→9',
			'user_modified_desc' => 'Зменены карыстальнікам 9→1',
		),
		'starred' => 'Паказваць абранае',
		'stats' => 'Статыстыка',
		'subscription' => 'Кіраванне падпіскамі',
		'unread' => 'Паказваць непрачытанае',
	),
	'share' => 'Абагуліць',
	'tag' => array(
		'related' => 'Тэгі артыкула',
	),
	'tos' => array(
		'title' => 'Умовы выкарыстання',
	),
);

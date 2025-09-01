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
		'_' => '关于',
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
		'bugs_reports' => '报告错误',
		'documentation' => '文档',
		'freshrss_description' => 'FreshRSS 是一个自托管的 RSS 聚合服务。 它不仅轻快易用，并且强大又易于配置。',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">GitHub Issues</a>',
		'license' => '授权',
		'project_website' => '项目网站',
		'title' => '关于',
		'version' => '版本',
	),
	'feed' => array(
		'empty' => '没有文章可以显示。',
		'received' => array(
			'before_yesterday' => 'Received before yesterday',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => '%s 的订阅源',
		'title' => '首页',
		'title_fav' => '收藏',
		'title_global' => '全局视图',
	),
	'log' => array(
		'_' => '日志',
		'clear' => '清除日志',
		'empty' => '日志文件为空',
		'title' => '日志',
	),
	'menu' => array(
		'about' => '关于 FreshRSS',
		'before_one_day' => '一天前',
		'before_one_week' => '一周前',
		'bookmark_query' => '收藏当前查询',
		'favorites' => '收藏（%s）',
		'global_view' => '全局视图',
		'important' => '重要的订阅',
		'main_stream' => '首页',
		'mark_all_read' => '全部设为已读',
		'mark_cat_read' => '此分类设为已读',
		'mark_feed_read' => '此订阅源设为已读',
		'mark_selection_unread' => '选中设为已读',
		'mylabels' => '我的标签',
		'newer_first' => '由新至旧',
		'non-starred' => '显示未收藏',
		'normal_view' => '普通视图',
		'older_first' => '由旧至新',
		'queries' => '自定义查询',
		'read' => '显示已读',
		'reader_view' => '阅读视图',
		'rss_view' => '订阅源',
		'search_short' => '搜索',
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
		'starred' => '显示收藏',
		'stats' => '统计',
		'subscription' => '订阅管理',
		'unread' => '显示未读',
	),
	'share' => '分享',
	'tag' => array(
		'related' => '文章标签',
	),
	'tos' => array(
		'title' => '服务条款',
	),
);

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
		'_' => '关于',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => '系统信息',
				'browser' => '浏览器',
				'database' => '数据库',
				'server_software' => '服务器软件',
				'version_curl' => 'cURL 版本',
				'version_frss' => 'FreshRSS 版本',
				'version_php' => 'PHP 版本',
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
		'published' => array(
			'_' => '已发布',
			'future' => '未来发布',
			'today' => '今日发布',
			'yesterday' => '昨日发布',
		),
		'received' => array(
			'_' => '已接收',
			'today' => '今日接收',
			'yesterday' => '昨日接收',
		),
		'rss_of' => '%s 的订阅源',
		'title' => '首页',
		'title_fav' => '收藏',
		'title_global' => '全局视图',
		'userModified' => array(
			'_' => '用户已修改',
			'today' => '用户今日修改',
			'yesterday' => '用户昨日修改',
		),
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
		'mark_selection_unread' => '将筛选结果标记为未读',
		'mylabels' => '我的标签',
		'non-starred' => '显示未收藏',
		'normal_view' => '普通视图',
		'queries' => '自定义查询',
		'read' => '显示已读',
		'reader_view' => '阅读视图',
		'rss_view' => '订阅源',
		'search_short' => '搜索',
		'sort' => array(
			'asc' => 'Ascending',	// TODO
			'c' => array(
				'name_asc' => '分类、订阅源标题 A→Z',
				'name_desc' => '分类、订阅源标题 Z→A',
			),
			'date_asc' => '发布日期 1→9',
			'date_desc' => '发布日期 9→1',
			'desc' => 'Descending',	// TODO
			'f' => array(
				'name_asc' => '订阅源标题 A→Z',
				'name_desc' => '订阅源标题 Z→A',
			),
			'id_asc' => '最新接收在后',
			'id_desc' => '最新接收在前',
			'length_asc' => '内容长度 1→9',
			'length_desc' => '内容长度 9→1',
			'link_asc' => '链接 A→Z',
			'link_desc' => '链接 Z→A',
			'primary' => array(
				'_' => 'Sorting criterion',	// TODO
				'help' => 'Sorting by <em>received</em> date is recommended in most cases, for consistency and performance',	// TODO
			),
			'rand' => '随机顺序',
			'secondary' => array(
				'_' => 'Secondary sorting criterion',	// TODO
				'help' => 'Only relevant when the primary sorting criterion is categories or feeds titles',	// TODO
			),
			'title_asc' => '标题 A→Z',
			'title_desc' => '标题 Z→A',
			'user_modified_asc' => '用户修改 1→9',
			'user_modified_desc' => '用户修改 9→1',
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

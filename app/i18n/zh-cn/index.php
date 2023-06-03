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
		'bugs_reports' => '报告错误',
		'credits' => '致谢',
		'credits_content' => '某些设计元素来自于 <a href="http://twitter.github.io/bootstrap/">Bootstrap</a> ，尽管 FreshRSS 并没有使用此框架。<a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">图标</a> 来自于 <a href="https://www.gnome.org/">GNOME 项目</a>。<em>Open Sans</em> 字体出自 <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a> 之手。FreshRSS 基于 PHP 框架 <a href="https://framagit.org/marienfressinaud/MINZ">Minz</a>。',
		'documentation' => 'Documentation',	// TODO
		'freshrss_description' => 'FreshRSS 是一个自托管的 RSS 聚合服务。 它不仅轻快易用，并且强大又易于配置。',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">Github Issues</a>',
		'license' => '授权',
		'project_website' => '项目网站',
		'title' => '关于',
		'version' => '版本',
	),
	'feed' => array(
		'add' => '请添加一些订阅源。',
		'empty' => '没有文章可以显示。',
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
		'main_stream' => '首页',
		'mark_all_read' => '全部设为已读',
		'mark_cat_read' => '此分类设为已读',
		'mark_feed_read' => '此订阅源设为已读',
		'mark_selection_unread' => '选中设为已读',
		'newer_first' => '由新至旧',
		'non-starred' => '显示未收藏',
		'normal_view' => '普通视图',
		'older_first' => '由旧至新',
		'queries' => '自定义查询',
		'read' => '显示已读',
		'reader_view' => '阅读视图',
		'rss_view' => '订阅源',
		'search_short' => '搜索',
		'starred' => '显示收藏',
		'stats' => '统计',
		'subscription' => '订阅管理',
		'tags' => '我的标签',
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

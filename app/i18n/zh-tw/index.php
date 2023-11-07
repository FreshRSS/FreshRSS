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
		'_' => '關於',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bugs_reports' => '報告錯誤',
		'credits' => '致謝',
		'credits_content' => '某些設計元素來自於 <a href="http://twitter.github.io/bootstrap/">Bootstrap</a> ，盡管 FreshRSS 並沒有使用此框架。<a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">圖標</a> 來自於 <a href="https://www.gnome.org/">GNOME 項目</a>。<em>Open Sans</em> 字體出自 <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson</a> 之手。FreshRSS 基于 PHP 框架 <a href="https://framagit.org/marienfressinaud/MINZ">Minz</a>。',
		'documentation' => 'Documentation',	// TODO
		'freshrss_description' => 'FreshRSS 是一個自托管的 RSS 聚合服務。 它不僅輕快又易用，而且強大又易於配置。',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">Github Issues</a>',
		'license' => '授權',
		'project_website' => '項目網站',
		'title' => '關於',
		'version' => '版本',
	),
	'feed' => array(
		'empty' => '暫時沒有文章可顯示。',
		'rss_of' => '%s 的訂閱源',
		'title' => '首頁',
		'title_fav' => '收藏',
		'title_global' => '全局視圖',
	),
	'log' => array(
		'_' => '日誌',
		'clear' => '清除日誌',
		'empty' => '日誌文件為空',
		'title' => '日誌',
	),
	'menu' => array(
		'about' => '關於 FreshRSS',
		'before_one_day' => '一天前',
		'before_one_week' => '一週前',
		'bookmark_query' => '收藏當前查詢',
		'favorites' => '收藏（%s）',
		'global_view' => '全局視圖',
		'important' => 'Important feeds',	// TODO
		'main_stream' => '首頁',
		'mark_all_read' => '全部設為已讀',
		'mark_cat_read' => '此分類設為已讀',
		'mark_feed_read' => '此訂閱源設為已讀',
		'mark_selection_unread' => '選中設為已讀',
		'newer_first' => '由新至舊',
		'non-starred' => '顯示未收藏',
		'normal_view' => '普通視圖',
		'older_first' => '由舊至新',
		'queries' => '自定義查詢',
		'read' => '顯示已讀',
		'reader_view' => '閱讀視圖',
		'rss_view' => '訂閱源',
		'search_short' => '搜尋',
		'starred' => '顯示收藏',
		'stats' => '統計',
		'subscription' => '訂閱管理',
		'tags' => '我的標簽',
		'unread' => '顯示未讀',
	),
	'share' => '分享',
	'tag' => array(
		'related' => '文章標簽',
	),
	'tos' => array(
		'title' => '服務條款',
	),
);

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
		'_' => '關於',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => '系統資訊',
				'browser' => '瀏覽器',
				'database' => '資料庫',
				'server_software' => '伺服器軟體',
				'version_curl' => 'cURL 版本',
				'version_frss' => 'FreshRSS 版本',
				'version_php' => 'PHP 版本',
			),
		),
		'bugs_reports' => '漏洞報告',
		'documentation' => '說明文件',
		'freshrss_description' => 'FreshRSS 是個可自託管的 RSS 聚合器和閱讀器。它允許您一次閱讀和追蹤多個新聞網站而無需在不同網站之間切換。FreshRSS 輕量、可配置且易於使用。',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">在 GitHub 上</a>',
		'license' => '授權',
		'project_website' => '專案網站',
		'title' => '關於',
		'version' => '版本',
	),
	'feed' => array(
		'empty' => '無文章可顯示。',
		'published' => array(
			'_' => 'Published',	// TODO
			'future' => 'Published in the future',	// TODO
			'today' => 'Published today',	// TODO
			'yesterday' => 'Published yesterday',	// TODO
		),
		'received' => array(
			'_' => 'Received',	// TODO
			'today' => 'Received today',	// TODO
			'yesterday' => 'Received yesterday',	// TODO
		),
		'rss_of' => '%s 的 RSS 訂閱源',
		'title' => '主資訊流',
		'title_fav' => '收藏',
		'title_global' => '全域檢視',
		'userModified' => array(
			'_' => 'Modified by user',	// TODO
			'today' => 'Modified by user today',	// TODO
			'yesterday' => 'Modified by user yesterday',	// TODO
		),
	),
	'log' => array(
		'_' => '紀錄',
		'clear' => '清除紀錄',
		'empty' => '紀錄檔案為空',
		'title' => '紀錄',
	),
	'menu' => array(
		'about' => '關於 FreshRSS',
		'before_one_day' => '一天前',
		'before_one_week' => '一週前',
		'bookmark_query' => '收藏當前查詢',
		'favorites' => '收藏 (%s)',
		'global_view' => '全域檢視',
		'important' => '重要訂閱源',
		'main_stream' => '主資訊流',
		'mark_all_read' => '標記全部為已讀',
		'mark_cat_read' => '標記類別為已讀',
		'mark_feed_read' => '標記訂閱源為已讀',
		'mark_selection_unread' => '標記選取條目為已讀',
		'mylabels' => '我的標籤',
		'non-starred' => '顯示未收藏',
		'normal_view' => '普通檢視',
		'queries' => '使用者查詢',
		'read' => '顯示已讀',
		'reader_view' => '閱讀檢視',
		'rss_view' => 'RSS 訂閱源',
		'search_short' => '搜尋',
		'sort' => array(
			'asc' => '升序',
			'c' => array(
				'name_asc' => '類別、訂閱源標題 A→Z',
				'name_desc' => '類別、訂閱源標題 Z→A',
			),
			'date_asc' => 'Publication date 1→9',	// TODO
			'date_desc' => 'Publication date 9→1',	// TODO
			'desc' => '降序',
			'f' => array(
				'name_asc' => '訂閱源標題 A→Z',
				'name_desc' => '訂閱源標題 Z→A',
			),
			'id_asc' => 'Freshly received last',	// TODO
			'id_desc' => 'Freshly received first',	// TODO
			'length_asc' => '內容長度 1→9',
			'length_desc' => '內容長度 9→1',
			'link_asc' => '連結 A→Z',
			'link_desc' => '連結 Z→A',
			'primary' => array(
				'_' => '排序標準',
				'help' => 'Sorting by <em>received</em> date is recommended in most cases, for consistency and performance',	// TODO
			),
			'rand' => '隨機順序',
			'secondary' => array(
				'_' => '次要排序標準',
				'help' => 'Only relevant when the primary sorting criterion is categories or feeds titles',	// TODO
			),
			'title_asc' => '標題 A→Z',
			'title_desc' => '標題 Z→A',
			'user_modified_asc' => 'User modified 1→9',	// TODO
			'user_modified_desc' => 'User modified 9→1',	// TODO
		),
		'starred' => '顯示收藏',
		'stats' => '統計',
		'subscription' => '訂閱管理',
		'unread' => '顯示未讀',
	),
	'share' => '分享',
	'tag' => array(
		'related' => '文章標籤',
	),
	'tos' => array(
		'title' => '服務條款',
	),
);

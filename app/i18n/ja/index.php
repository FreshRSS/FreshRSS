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
		'_' => 'FreshRSSについて',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'システム情報',
				'browser' => 'ブラウザ',
				'database' => 'データベース',
				'server_software' => 'サーバーソフトウェア',
				'version_curl' => 'cURL version',	// TODO
				'version_frss' => 'FreshRSSバージョン',
				'version_php' => 'PHPバージョン',
			),
		),
		'bugs_reports' => 'バグレポート',
		'documentation' => 'ドキュメント',
		'freshrss_description' => 'FreshRSSはセルフホストできるRSSフィード収集ツールです。強力なツールで、軽量で簡単に使え、豊富な設定が特徴です。',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">Githubへお願いします</a>',
		'license' => 'ライセンス',
		'project_website' => 'プロジェクトのwebサイト',
		'title' => 'FreshRSSについて',
		'version' => 'バージョン',
	),
	'feed' => array(
		'empty' => '表示できる記事がありません',
		'published' => array(
			'_' => 'Published',	// TODO
			'future' => 'Published in the future',	// TODO
			'today' => 'Published today',	// TODO
			'yesterday' => 'Published yesterday',	// TODO
		),
		'received' => array(
			'_' => 'Received',	// TODO
			'today' => '今日',
			'yesterday' => '昨日',
		),
		'rss_of' => '%s のRSSフィード',
		'title' => 'メイン',
		'title_fav' => 'お気に入り',
		'title_global' => 'グローバルビュー',
		'userModified' => array(
			'_' => 'Modified by user',	// TODO
			'today' => 'Modified by user today',	// TODO
			'yesterday' => 'Modified by user yesterday',	// TODO
		),
	),
	'log' => array(
		'_' => 'ログ',
		'clear' => 'ログを消去する',
		'empty' => 'ログファイルは空です',
		'title' => 'ログ',
	),
	'menu' => array(
		'about' => 'FreshRSSについて',
		'before_one_day' => '一日以上前',
		'before_one_week' => '一週間以上前',
		'bookmark_query' => '現在のブックマーククエリ',
		'favorites' => 'お気に入り (%s)',
		'global_view' => 'グローバルビュー',
		'important' => '重要なフィード',
		'main_stream' => 'メイン',
		'mark_all_read' => 'すべての記事を既読にする',
		'mark_cat_read' => 'カテゴリを既読にする',
		'mark_feed_read' => 'フィードを既読にする',
		'mark_selection_unread' => '選択した記事を未読にする',
		'mylabels' => 'ラベル',
		'non-starred' => 'お気に入りに登録されてない記事を表示する',
		'normal_view' => 'ノーマルビュー',
		'queries' => 'ユーザークエリ',
		'read' => '既読の記事を表示する',
		'reader_view' => 'リーディングビュー',
		'rss_view' => 'RSSフィード',
		'search_short' => '検索',
		'sort' => array(
			'asc' => 'Ascending',	// TODO
			'c' => array(
				'name_asc' => 'Category, feed titles A→Z',	// TODO
				'name_desc' => 'Category, feed titles Z→A',	// TODO
			),
			'date_asc' => '公開日順 1→9',
			'date_desc' => '公開日順 9→1',
			'desc' => 'Descending',	// TODO
			'f' => array(
				'name_asc' => 'Feed title A→Z',	// TODO
				'name_desc' => 'Feed title Z→A',	// TODO
			),
			'id_asc' => '新着を最後に並べる',
			'id_desc' => '新着を最初に並べる',
			'length_asc' => 'Content length 1→9',	// TODO
			'length_desc' => 'Content length 9→1',	// TODO
			'link_asc' => 'リンクURL順 A→Z',
			'link_desc' => 'リンクURL順 Z→A',
			'primary' => array(
				'_' => 'Sorting criterion',	// TODO
				'help' => 'Sorting by <em>received</em> date is recommended in most cases, for consistency and performance',	// TODO
			),
			'rand' => 'ランダムに並べる',
			'secondary' => array(
				'_' => 'Secondary sorting criterion',	// TODO
				'help' => 'Only relevant when the primary sorting criterion is categories or feeds titles',	// TODO
			),
			'title_asc' => 'タイトル順 A→Z',
			'title_desc' => 'タイトル順 Z→A',
			'user_modified_asc' => 'User modified 1→9',	// TODO
			'user_modified_desc' => 'User modified 9→1',	// TODO
		),
		'starred' => 'お気に入りを表示する',
		'stats' => '統計',
		'subscription' => '購読フィードの管理',
		'unread' => '未読の記事を表示する',
	),
	'share' => '共有',
	'tag' => array(
		'related' => '記事のタグ',
	),
	'tos' => array(
		'title' => '利用規約',
	),
);

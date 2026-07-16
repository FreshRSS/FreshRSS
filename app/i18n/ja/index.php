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
				'version_curl' => 'cURLバージョン',
				'version_frss' => 'FreshRSSバージョン',
				'version_php' => 'PHPバージョン',
			),
		),
		'bugs_reports' => 'バグレポート',
		'documentation' => 'ドキュメント',
		'freshrss_description' => 'FreshRSSはセルフホストできるRSSフィード収集ツールです。強力なツールで、軽量で簡単に使え、豊富な設定が特徴です。',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">GitHubで報告する</a>',
		'license' => 'ライセンス',
		'project_website' => 'プロジェクトのwebサイト',
		'title' => 'FreshRSSについて',
		'version' => 'バージョン',
	),
	'feed' => array(
		'empty' => '表示できる記事がありません',
		'published' => array(
			'_' => '公開日',
			'future' => '未来の日付で公開',
			'today' => '本日公開',
			'yesterday' => '昨日公開',
		),
		'received' => array(
			'_' => '受信日',
			'today' => '今日',
			'yesterday' => '昨日',
		),
		'rss_of' => '%s のRSSフィード',
		'title' => 'メイン',
		'title_fav' => 'お気に入り',
		'title_global' => 'グローバルビュー',
		'userModified' => array(
			'_' => 'ユーザーによる変更',
			'today' => '本日ユーザーが変更',
			'yesterday' => '昨日ユーザーが変更',
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
		'favorites' => 'お気に入り（%s）',
		'global_view' => 'グローバルビュー',
		'important' => '重要なフィード',
		'main_stream' => 'メイン',
		'mark_all_read' => 'すべての記事を既読にする',
		'mark_cat_read' => 'カテゴリを既読にする',
		'mark_feed_read' => 'フィードを既読にする',
		'mark_selection_unread' => '選択した記事を未読にする',
		'mylabels' => 'ラベル',
		'non-starred' => 'お気に入りに登録されてない記事を表示',
		'normal_view' => 'ノーマルビュー',
		'queries' => 'ユーザークエリ',
		'read' => '既読の記事を表示',
		'reader_view' => 'リーディングビュー',
		'rss_view' => 'RSSフィード',
		'search_short' => '検索',
		'sort' => array(
			'asc' => '昇順',
			'c' => array(
				'name_asc' => 'カテゴリ→フィードタイトル（昇順）',
				'name_desc' => 'カテゴリ→フィードタイトル（降順）',
			),
			'date_asc' => '公開日時（古い順）',
			'date_desc' => '公開日時（新しい順）',
			'desc' => '降順',
			'f' => array(
				'name_asc' => 'フィードタイトル（昇順）',
				'name_desc' => 'フィードタイトル（降順）',
			),
			'id_asc' => '受信日時（古い順）',
			'id_desc' => '受信日時（新しい順）',
			'length_asc' => '本文の長さ（昇順）',
			'length_desc' => '本文の長さ（降順）',
			'link_asc' => 'リンクURL（昇順）',
			'link_desc' => 'リンクURL（降順）',
			'primary' => array(
				'_' => '並べ替え基準',
				'help' => '一貫性とパフォーマンスの観点から、通常は<em>受信</em>日時での並べ替えを推奨します。',
			),
			'rand' => 'ランダムに並べる',
			'secondary' => array(
				'_' => '第2並べ替え基準',
				'help' => '並べ替え基準がカテゴリ名またはフィード名の場合にのみ有効です',
			),
			'title_asc' => 'タイトル（昇順）',
			'title_desc' => 'タイトル（降順）',
			'user_modified_asc' => 'ユーザーによる変更（昇順）',
			'user_modified_desc' => 'ユーザーによる変更（降順）',
		),
		'starred' => 'お気に入りを表示',
		'stats' => '統計',
		'subscription' => '購読フィードの管理',
		'unread' => '未読記事を表示',
	),
	'share' => '共有',
	'tag' => array(
		'related' => '記事のタグ',
	),
	'tos' => array(
		'title' => '利用規約',
	),
);

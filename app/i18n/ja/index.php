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
		'_' => 'FreshRSSについて',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bugs_reports' => 'バグレポート',
		'credits' => 'クレジット',
		'credits_content' => 'いくつかのデザイン要素は <a href="http://twitter.github.io/bootstrap/">Bootstrap</a>から来ています。しかしFreshRSSはこのフレームワークを使用していません。 <a href="https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic">アイコン</a> は <a href="https://www.gnome.org/">GNOME プロジェクトから作られています</a>。 <em>Open Sans</em> フォントは <a href="https://fonts.google.com/specimen/Open+Sans">Steve Matteson によって作成されました</a>。 FreshRSS は<a href="https://framagit.org/marienfressinaud/MINZ">Minz</a>,PHP フレームワークをもとにしています。',
		'documentation' => '文書',
		'freshrss_description' => 'FreshRSSは なセルフホストできるRSSフィード収集ツールです。強力なツールになっており、軽量で簡単に使え、豊富な設定が特徴です。',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">GitHubへお願いします</a>',
		'license' => 'ライセンス',
		'project_website' => 'プロジェクトのwebサイト',
		'title' => 'FreshRSSについて',
		'version' => 'バージョン',
	),
	'feed' => array(
		'empty' => '表示できる記事がありません',
		'rss_of' => '%s のRSSフィード',
		'title' => 'メイン',
		'title_fav' => 'お気に入り',
		'title_global' => 'グローバルビュー',
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
		'mark_all_read' => 'すべての記事に既読をつける',
		'mark_cat_read' => 'カテゴリーに既読をつける',
		'mark_feed_read' => 'フィードに既読をつける',
		'mark_selection_unread' => '選択したものに未読をつける',
		'newer_first' => '最新のものを先にする',
		'non-starred' => 'お気に入りに登録されてないものを表示する',
		'normal_view' => 'ノーマルビュー',
		'older_first' => '最古のものを先にする',
		'queries' => 'ユーザークエリ',
		'read' => '読み取りを表示する',
		'reader_view' => 'リーディングビュー',
		'rss_view' => 'RSSフィード',
		'search_short' => '検索',
		'starred' => 'お気に入りを表示する',
		'stats' => '統計',
		'subscription' => '購読されたものの管理',
		'tags' => 'ラベル',
		'unread' => '未読のものを表示する',
	),
	'share' => '共有',
	'tag' => array(
		'related' => '記事のタグ',
	),
	'tos' => array(
		'title' => '利用規約',
	),
);

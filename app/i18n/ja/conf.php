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
	'archiving' => array(
		'_' => 'アーカイブ',
		'exception' => '例外を除く',
		'help' => '個々のフィード設定内で、より多くの設定をしていただけます。',
		'keep_favourites' => 'お気に入りを消去しない',
		'keep_labels' => 'ラベルを消去しない',
		'keep_max' => '記事を保存する最大数',	// DIRTY
		'keep_min_by_feed' => '記事をフィードに残す最小数',
		'keep_period' => '記事を保存する最大時間',
		'keep_unreads' => '未読の記事を消去しない',
		'maintenance' => 'メンテナンス',
		'optimize' => 'データベースを整理する',
		'optimize_help' => 'データベースサイズを減らすため、時々実行されます',
		'policy' => '不要なデータを削除する',
		'policy_warning' => 'すべての記事が、不要なデータを削除する設定がなされてないときは保存されます。',
		'purge_now' => '不要なデータをまとめて削除する',
		'title' => 'アーカイブ',
		'ttl' => '自動的に更新される時間',
	),
	'display' => array(
		'_' => '表示',
		'darkMode' => array(
			'_' => 'Automatic dark mode (beta)',	// TODO
			'auto' => 'Auto',	// TODO
			'no' => 'No',	// TODO
		),
		'icon' => array(
			'bottom_line' => '行の下部',
			'display_authors' => '著者',
			'entry' => '記事のアイコン',
			'publication_date' => '出版された日',
			'related_tags' => '記事のタグ',
			'sharing' => '共有',
			'summary' => '要約',
			'top_line' => '行の先頭',
		),
		'language' => '言語',
		'notif_html5' => array(
			'seconds' => '秒 (0秒だとタイムアウトしません)',
			'timeout' => 'HTML5 の通知タイムアウト時間',
		),
		'show_nav_buttons' => 'ナビゲーションボタンを表示する',
		'theme' => array(
			'_' => 'テーマ',
			'deprecated' => array(
				'_' => 'Deprecated',	// TODO
				'description' => 'This theme is no longer supported and will be not available anymore in a <a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">future release of FreshRSS</a>',	// TODO
			),
		),
		'theme_not_available' => '“%s”テーマはご利用いただけません。他のテーマをお選びください。',
		'thumbnail' => array(
			'label' => 'サムネイル',
			'landscape' => 'ランドスケープ',
			'none' => 'なし',
			'portrait' => 'ポートレート',
			'square' => '四角',
		),
		'timezone' => 'Time zone',	// TODO
		'title' => 'ディスプレイ',
		'website' => array(
			'full' => 'Icon and name',	// TODO
			'icon' => 'Icon only',	// TODO
			'label' => 'Website',	// TODO
			'name' => 'Name only',	// TODO
			'none' => 'None',	// TODO
		),
		'width' => array(
			'content' => 'コンテンツ幅',
			'large' => '広い',
			'medium' => '中',
			'no_limit' => '最大幅',
			'thin' => '狭い',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'ログのレベル',
			'message' => 'ログのメッセージ',
			'timestamp' => 'タイムスタンプ',
		),
		'pagination' => array(
			'first' => '先頭',
			'last' => '最後',
			'next' => 'つぎへ',
			'previous' => '前へ',
		),
	),
	'profile' => array(
		'_' => 'プロフィール',
		'api' => 'API管理',
		'delete' => array(
			'_' => 'アカウント消去',
			'warn' => 'あなたのアカウントとそれに関連したデータが消去されます。',
		),
		'email' => 'Eメールアドレス',
		'password_api' => 'APIのパスワード<br /><small>(モバイルアプリなど)</small>',
		'password_form' => 'パスワード<br /><small>(Web-formのログイン時に使われます)</small>',
		'password_format' => '最低7文字必要です',
		'title' => 'プロフィール',
	),
	'query' => array(
		'_' => 'ユーザークエリ',
		'deprecated' => 'このクエリは有効ではありません。参照されているカテゴリあるいはフィードはすでに消去されました。',
		'filter' => array(
			'_' => 'フィルターを適用:',
			'categories' => 'カテゴリごとに表示する',
			'feeds' => 'フィードごとに表示する',
			'order' => '日付ごとにソートする',
			'search' => '式',
			'state' => '状態',
			'tags' => 'タグごとに表示する',
			'type' => 'タイプ',
		),
		'get_all' => 'すべての著者を表示する',
		'get_all_labels' => 'Display articles with any label',	// TODO
		'get_category' => '“%s”カテゴリを表示する',
		'get_favorite' => 'お気に入りの著者を表示する',
		'get_feed' => '“%s”フィードを表示する',
		'get_important' => 'Display articles from important feeds',	// TODO
		'get_label' => 'Display articles with “%s” label',	// TODO
		'name' => '名前',
		'no_filter' => 'フィルターはありません',
		'number' => 'クエリ n°%d',
		'order_asc' => '古い著者を最初に表示する',
		'order_desc' => '新しい著者を最初に表示する',
		'search' => '“%s”で検索する',
		'share' => array(
			'_' => 'Share this query by link',	// TODO
			'help' => 'Give this link if you want to share this query with anyone',	// TODO
			'html' => 'Shareable link to the HTML page',	// TODO
			'rss' => 'Shareable link to the RSS feed',	// TODO
		),
		'state_0' => 'すべての記事を表示する',
		'state_1' => '既読の記事を表示する',
		'state_2' => '未読の記事を表示する',
		'state_3' => 'すべての記事を表示する',
		'state_4' => 'お気に入りの記事を表示する',
		'state_5' => 'お気に入りの既読の記事を表示する',
		'state_6' => 'お気に入りの未読の記事を表示する',
		'state_7' => 'お気に入りの記事を表示する',
		'state_8' => 'お気に入りでない記事を表示する',
		'state_9' => 'お気に入りでない既読の記事を表示する',
		'state_10' => 'お気に入りでない未読の記事を表示する',
		'state_11' => 'お気に入りでない記事を表示する',
		'state_12' => 'すべての記事を表示する',
		'state_13' => 'すべての既読の記事を表示する',
		'state_14' => '未読の記事を表示する',
		'state_15' => 'すべての記事を表示する',
		'title' => 'ユーザークエリ',
	),
	'reading' => array(
		'_' => 'リーディング',
		'after_onread' => 'あとで “すべてに既読を付ける”,',
		'always_show_favorites' => 'デフォルトですべてのお気に入りの記事を表示する',
		'article' => array(
			'authors_date' => array(
				'_' => '著者と日付',
				'both' => 'ヘッダーとフッター',
				'footer' => 'フッター',
				'header' => 'ヘッダー',
				'none' => 'なし',
			),
			'feed_name' => array(
				'above_title' => '上のタイトル/タグ',
				'none' => 'なし',
				'with_authors' => '著者と日付の行',
			),
			'feed_title' => 'フィードのタイトル',
			'tags' => array(
				'_' => 'タグ',
				'both' => 'ヘッダーとフッター',
				'footer' => 'フッター',
				'header' => 'ヘッダー',
				'none' => 'なし',
			),
			'tags_max' => array(
				'_' => '表示されるタグの数の上限',
				'help' => '0は:すべてのタグを表示し、折り畳めまれないことを意味します。',
			),
		),
		'articles_per_page' => '1ページ当たりの記事の数',
		'auto_load_more' => 'ページの下にもっと記事を読み込む',
		'auto_remove_article' => '記事を読んだら非表示にする',
		'confirm_enabled' => '“すべてに既読を付ける” を押したとき確認ダイアログを表示する',
		'display_articles_unfolded' => 'デフォルトでフォルダーに入れてない記事を表示する',
		'display_categories_unfolded' => '展開されていない記事',
		'headline' => array(
			'articles' => '記事: 開く/閉じる',
			'articles_header_footer' => '記事: ヘッダー/フッター',
			'categories' => '左のナビゲーション: カテゴリ',
			'mark_as_read' => 'チェックをつけた記事を既読にする',
			'misc' => 'その他',
			'view' => 'ビュー',
		),
		'hide_read_feeds' => 'カテゴリーを非表示 & 未読の記事がないフィード ("すべてに既読を付ける”では適用しません)',
		'img_with_lazyload' => '<em>lazy load</em>を写真の読み込み時に使う',
		'jump_next' => '次の未読の姉妹記事へ移る (フィードあるいはカテゴリー)',
		'mark_updated_article_unread' => '更新された記事を未読とする',
		'number_divided_when_reader' => 'reading viewを二分割する',
		'read' => array(
			'article_open_on_website' => '記事を元のwebサイトで開いたとき',
			'article_viewed' => '記事を読んだとき',
			'focus' => 'when focused (except for important feeds)',	// TODO
			'keep_max_n_unread' => '未読の記事として残す最大数',
			'scroll' => 'スクロールしているとき (except for important feeds)',	// DIRTY
			'upon_gone' => 'ニュースフィードの提供元がなくなったとき',
			'upon_reception' => '記事を受け取ったとき',
			'when' => '記事を既読にする…',
			'when_same_title' => '同一タイトルの新しい記事があるときには、上部へ表示する',
		),
		'show' => array(
			'_' => '記事を表示する',
			'active_category' => 'アクティブなカテゴリ',
			'adaptive' => '表示を調整する',
			'all_articles' => 'すべての記事を表示する',
			'all_categories' => 'すべてのカテゴリ',
			'no_category' => 'カテゴリがありません',
			'remember_categories' => '開いたカテゴリを保存する',
			'unread' => '未読のみ表示する',
		),
		'show_fav_unread_help' => 'ラベルも適用する',
		'sides_close_article' => '記事の外をクリックすると記事を閉じるようにする',
		'sort' => array(
			'_' => '順序',
			'newer_first' => '最新のものを先頭にする',
			'older_first' => '最古のものを先頭にする',
		),
		'sticky_post' => '開いたときにトップを記事にする',
		'title' => 'リーディング',
		'view' => array(
			'default' => 'デフォルトビュー',
			'global' => 'グローバルビュー',
			'normal' => '標準ビュー',
			'reader' => 'リーディングビュー',
		),
	),
	'sharing' => array(
		'_' => '共有',
		'add' => '共有方法を追加する',
		'blogotext' => 'Blogotext',	// IGNORE
		'deprecated' => 'このサービスは非推奨でFreshRSSから削除される予定です<a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Open documentation for more information" target="_blank">future release</a>.',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Eメール',
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'もっと多くの情報',
		'print' => '印刷',	// IGNORE
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => '共有方法を削除する',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => '共有する方法',
		'share_url' => 'URLを共有する',
		'title' => '共有',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'ショートカット',
		'article_action' => '記事のアクション',
		'auto_share' => '共有',
		'auto_share_help' => '共有方法が一つしか設定されていないときにはそれが使われます。そうではなければ、番号によって共有方法にアクセスできます。',
		'close_dropdown' => 'メニューを閉じる',
		'collapse_article' => '折りたたむ',
		'first_article' => '初めの記事を開く',
		'focus_search' => '共有ボックスにアクセスする',
		'global_view' => 'グローバルビューに変更する',
		'help' => 'ドキュメントを表示する',
		'javascript' => 'JavaScriptはショートカットを使うときに必要です',
		'last_article' => '最近の記事を表示する',
		'load_more' => 'もっと記事を読み込む',
		'mark_favorite' => 'お気に入りを切り替える',
		'mark_read' => '読みを切り替える',
		'navigation' => 'ナビゲーション',
		'navigation_help' => '<kbd>⇧ Shift</kbd>キーを使うと, フィードにショートカットナビが表示されます。<br/><kbd>Alt ⎇</kbd> キーを使うと、カテゴリにショートカットナビが表示されます。',
		'navigation_no_mod_help' => '次のショートカットナビは、キーボードショートカットには対応していません。',
		'next_article' => '次の記事を開く',
		'next_unread_article' => '次に未読の記事を開く',
		'non_standard' => '(<kbd>%s</kbd>)のキーはショートカットにはなりません。',
		'normal_view' => 'ノーマルビューに切り替える',
		'other_action' => 'ほかのアクション',
		'previous_article' => '前の記事を表示する',
		'reading_view' => 'リーディングビューに切り替える',
		'rss_view' => 'RSSフィードとして開く',
		'see_on_website' => '元のwebサイトを開く',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd>で前の記事を既読にし、<br />+ <kbd>⇧ Shift</kbd>ですべての記事を既読にします。',
		'skip_next_article' => '次を開かないで飛ばす',
		'skip_previous_article' => '前の記事を開かないで飛ばす',
		'title' => 'ショートカット',
		'toggle_media' => 'メディアの 再生/停止',
		'user_filter' => 'ユーザーのクエリにアクセスする',
		'user_filter_help' => '一つのユーザークエリしかないとき、それが使われます。そうではなければ、番号によってクエリにアクセスできます。',
		'views' => 'ビュー',
	),
	'user' => array(
		'articles_and_size' => '%s 記事 (%s)',
		'current' => '現在のユーザー',
		'is_admin' => 'は管理者です',
		'users' => 'ユーザー',
	),
);

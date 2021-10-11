<?php

return array(
	'archiving' => array(
		'_' => 'アーカイブ',
		'exception' => '例外を除く',
		'help' => '個々のフィード設定内で、より多くの設定をしていただけます。',
		'keep_favourites' => 'お気に入りを消去しない',
		'keep_labels' => 'ラベルを消去しない',
		'keep_max' => '記事を保存する最大数',
		'keep_min_by_feed' => '記事をフィードに残す最小数',
		'keep_period' => '記事を保存する最大時間',
		'keep_unreads' => '未読の記事を消去しない',
		'maintenance' => 'メンテナンス',
		'optimize' => 'データベースを整理する',
		'optimize_help' => '時々データベースサイズを減らすため実行されます',
		'policy' => '不要なデータを削除する',
		'policy_warning' => 'すべての記事が、不要なデータを削除する方法が選択されてないときは保存されます。',
		'purge_now' => '不要なデータをまとめて削除する',
		'title' => 'アーカイブ',
		'ttl' => '自動的に更新される時間',
	),
	'display' => array(
		'_' => 'ディスプレイ',
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
			'seconds' => '秒 (0 はタイムアウトなしです)',
			'timeout' => 'HTML5 の通知タイムアウト時間',
		),
		'show_nav_buttons' => 'ナビゲーションボタンを表示する',
		'theme' => 'テーマ',
		'theme_not_available' => 'The "%s" theme is not available anymore. Please choose another theme.', // TODO - Translation
		'thumbnail' => array(
			'label' => 'サムネイル',
			'landscape' => 'ランドスケープ',
			'none' => 'なし',
			'portrait' => 'ポートレート',
			'square' => '四角',
		),
		'title' => 'ディスプレイ',
		'width' => array(
			'content' => 'コンテンツ幅',
			'large' => '広い',
			'medium' => '中',
			'no_limit' => '最大幅',
			'thin' => '狭い',
		),
	),
	'profile' => array(
		'_' => 'プロフィール',
		'api' => 'API管理',
		'delete' => array(
			'_' => 'アカウント消去',
			'warn' => 'あなたのアカウントとそれに関連したデーターが消去されます。',
		),
		'email' => 'Eメールアドレス',
		'password_api' => 'APIのパスワード<br /><small>(モバイルアプリなど)</small>',
		'password_form' => 'パスワード<br /><small>(Web-formのログイン時に使われます)</small>',
		'password_format' => '最低限7文字必要です',
		'title' => 'プロフィール',
	),
	'query' => array(
		'_' => 'ユーザークエリ',
		'deprecated' => 'このクエリはもう有効ではありません。参照されているカテゴリあるいはフィードは消去されました。',
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
		'get_category' => '"%s"カテゴリを表示する',
		'get_favorite' => 'お気に入りの著者を表示する',
		'get_feed' => '"%s"フィードを表示する',
		'name' => '名前',
		'no_filter' => 'フィルターはありません',
		'number' => 'クエリ n°%d',
		'order_asc' => '古い著者を最初に表示する',
		'order_desc' => '新しい著者を最初に表示する',
		'search' => '"%s"で検索する',
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
		'articles_per_page' => 'ページ当たりの記事の数',
		'auto_load_more' => 'ページの下にもっと記事を読み込む',
		'auto_remove_article' => '記事を読んだら非表示にする',
		'confirm_enabled' => '“すべてに既読を付ける” を押したとき確認ダイアログを表示する',
		'display_articles_unfolded' => 'デフォルトでフォルダーに入れてない記事を表示する',
		'display_categories_unfolded' => '展開されていない記事',
		'hide_read_feeds' => 'カテゴリーを非表示 & 未読の記事がないフィード ("すべてに既読を付ける”では適用しません)',
		'img_with_lazyload' => '"lazy load"を写真の読み込み時に使う',
		'jump_next' => '次の未読の姉妹記事へ移る (フィードあるいはカテゴリー)',
		'mark_updated_article_unread' => '更新された記事を未読とする',
		'number_divided_when_reader' => 'reading viewを二分割する',
		'read' => array(
			'article_open_on_website' => '記事を元のwebサイトで開いたとき',
			'article_viewed' => '記事を読んだとき',
			'keep_max_n_unread' => 'Max number of articles to keep unread',	// TODO - Translation
			'scroll' => 'スクロールしているとき',
			'upon_reception' => '記事を受け取ったとき',
			'when' => '記事を既読にする…',
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',	// TODO - Translation
		),
		'show' => array(
			'_' => '記事を表示する',
			'active_category' => '活発なカテゴリ',
			'adaptive' => '表示を調整する',
			'all_articles' => 'すべての記事を見せる',
			'all_categories' => 'すべてのカテゴリ',
			'no_category' => 'カテゴリがありません',
			'remember_categories' => '開いたカテゴリを保存する',
			'unread' => '未読のみ表示する',
		),
		'show_fav_unread_help' => 'ラベルも適用する',
		'sides_close_article' => '記事の外をクリックすると記事を閉じるようにする',
		'sort' => array(
			'_' => '順序',
			'newer_first' => '最新のものが先頭',
			'older_first' => '最古のものが先頭',
		),
		'sticky_post' => '開いたときトップに記事を貼り付ける',
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
		'blogotext' => 'Blogotext',
		'diaspora' => 'Diaspora*',
		'email' => 'Eメール',
		'facebook' => 'Facebook',
		'more_information' => 'もっと多くの情報',
		'print' => '印刷',
		'raindrop' => 'Raindrop.io',
		'remove' => '共有方法を削除する',
		'shaarli' => 'Shaarli',
		'share_name' => '表示する共有方法の名前',
		'share_url' => '使用するURLを共有する',
		'title' => '共有',
		'twitter' => 'Twitter',
		'wallabag' => 'wallabag',
	),
	'shortcut' => array(
		'_' => 'ショートカット',
		'article_action' => '記事のアクション',
		'auto_share' => '共有',
		'auto_share_help' => 'もしも、共有方法が一つしかないとき、それが使われます。さもなければ、番号によって共有方法にアクセスできます。',
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
		'non_standard' => '(<kbd>%s</kbd>)のキーはショートカットにはなりません。',
		'normal_view' => 'ノーマルビューに切り替える',
		'other_action' => 'ほかのアクション',
		'previous_article' => '前の記事を表示する',
		'reading_view' => 'リーディングビューに切り替える',
		'rss_view' => 'RSSビューを新しいタブで開く',
		'see_on_website' => '元のwebサイトを開く',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd>で前の記事を既読にし、<br />+ <kbd>⇧ Shift</kbd>ですべての記事を既読にします。',
		'skip_next_article' => '次を開かないで飛ばす',
		'skip_previous_article' => '前の記事を開かないで飛ばす',
		'title' => 'ショートカット',
		'toggle_media' => 'メディアの 再生/停止',
		'user_filter' => 'ユーザーのクエリにアクセスする',
		'user_filter_help' => '一つのユーザークエリしかないとき、それが使われます。さもなければ、番号によってクエリにアクセスできます。',
		'views' => 'ビュー',
	),
	'user' => array(
		'articles_and_size' => '%s 記事 (%s)',
		'current' => '現在のユーザー',
		'is_admin' => 'は管理者です',
		'users' => 'ユーザー',
	),
);

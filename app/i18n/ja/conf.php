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
	'archiving' => array(
		'_' => 'アーカイブ',
		'exception' => '削除対象外',//DIRTY
		'help' => '個別のフィード内設定で、より詳細な設定ができます。',
		'keep_favourites' => 'お気に入りを消去しない',
		'keep_labels' => 'ラベルを消去しない',
		'keep_max' => '各フィードに保存する記事数の上限',//DIRTY
		'keep_min_by_feed' => '各フィードに保存する記事数の下限',//DIRTY
		'keep_period' => '記事を保存する最長期間',//DIRTY
		'keep_unreads' => '未読の記事を消去しない',
		'maintenance' => 'メンテナンス',
		'optimize' => 'データベースを整理',
		'optimize_help' => 'データベース容量を削減するため、定期的に実行してください。',//DIRTY
		'policy' => '不要なデータを削除する',
		'policy_warning' => '削除ポリシーを選択しない場合、すべての記事が保存されます。',//DIRTY
		'purge_now' => '不要なデータをまとめて削除する',
		'title' => 'アーカイブ',
		'ttl' => '自動更新する間隔',
	),
	'display' => array(
		'_' => '表示',
		'darkMode' => array(
			'_' => '自動ダークモード',
			'auto' => '有効',
			'help' => '対応テーマのみ',
			'no' => '無効',
		),
		'icon' => array(
			'bottom_line' => '下段',//DIRTY
			'display_authors' => '著者',
			'entry' => '記事アイコン',//DIRTY
			'publication_date' => '公開日時',
			'related_tags' => 'タグ',
			'sharing' => '共有',
			'summary' => '要約',
			'top_line' => '上段',//DIRTY
		),
		'language' => '言語',
		'notif_html5' => array(
			'seconds' => '秒（0秒だとタイムアウトしません）',
			'timeout' => 'HTML5通知のタイムアウト時間',
		),
		'show_nav_buttons' => 'ナビゲーションボタンを表示',
		'show_title_unread' => 'タイトルに未読記事数を表示',
		'show_unread_count' => array(
			'_' => 'サイドバーに未読記事数を表示',
			'all' => 'すべてのカテゴリとフィード',
			'important' => '重要なフィードのみ',
			'important_locked' => '重要なフィードでは未読記事数が常に表示されます。',
			'none' => '表示しない',
		),
		'sidebar_hidden_by_default' => 'デフォルトでサイドバーを非表示',
		'theme' => array(
			'_' => 'テーマ',
			'deprecated' => array(
				'_' => '非推奨',
				'description' => 'このテーマのサポートは終了しており、<a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">FreshRSSの将来のリリース</a>では利用できなくなります。',//DIRTY
			),
		),
		'theme_not_available' => 'テーマ「%s」は利用できません。他のテーマを選択してください。',
		'thumbnail' => array(
			'label' => 'サムネイル',
			'landscape' => 'ランドスケープ',
			'none' => 'なし',
			'portrait' => 'ポートレート',
			'square' => '四角',
		),
		'timezone' => 'タイムゾーン',
		'title' => '表示',
		'website' => array(
			'full' => 'アイコンと名前',
			'icon' => 'アイコンのみ',
			'label' => 'Webサイト',
			'name' => '名前のみ',
			'none' => 'なし',
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
			'next' => '次へ',
			'previous' => '前へ',
		),
	),
	'mark_read_button' => array(
		'_' => '「すべて既読にする」ボタン',	// DIRTY
		'big' => '大',
		'none' => 'なし',
		'small' => '小',
	),
	'notification' => array(
		'html5_enable_notif' => '通知を有効にする',
	),
	'notification_timeout' => array(
		'bad' => array(
			'label' => '警告バナーの表示時間',
			'seconds' => '秒（1以上）',
		),
		'good' => array(
			'label' => '確認バナーの表示時間',
			'seconds' => '秒（0で非表示）',
		),
	),
	'privacy' => array(
		'_' => 'プライバシー',
		'retrieve_extension_list' => '拡張機能リストを取得する',
		'send_referrer_allowlist' => 'サーバーアドレスの送信を許可するサイト（%s）',
	),
	'profile' => array(
		'_' => 'プロフィール',
		'api' => array(
			'_' => 'API管理',
			'api_not_set' => 'APIパスワード未設定',
			'api_set' => 'APIパスワード設定済み',
			'check_link' => 'APIステータスを確認する：<kbd><a href="../api/" target="_blank">%s</a></kbd>',
			'disabled' => 'APIアクセスは無効です。',
			'documentation_link' => '既知のアプリの一覧は<a href="https://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html#access-via-mobile-app" target="_blank">ドキュメント</a>を参照してください',//DIRTY
			'help' => '<a href="http://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html#access-via-mobile-app" target="_blank">ドキュメント</a>を参照してください',
			'security_warning' => 'HTTPSを使用してください。APIパスワードは平文で送信され、GETで送信した場合はサーバーログに記録される可能性があります。',
		),
		'change_password' => 'パスワードを変更',
		'confirm_new_password' => '新しいパスワード（確認）',
		'current_password' => '現在のパスワード<br /><small>（Webフォームログイン用）</small>',
		'delete' => array(
			'_' => 'アカウント削除',
			'warn' => 'このアカウントと関連データが削除されます。',
		),
		'email' => 'メールアドレス',
		'new_password' => '新しいパスワード',
		'password_api' => 'APIのパスワード<br /><small>（モバイルアプリなどで必要）</small>',
		'password_format' => '7文字以上必要です。',
		'title' => 'プロフィール',
	),
	'query' => array(
		'_' => 'ユーザークエリ',
		'create' => '新しいユーザークエリを作成',
		'deprecated' => 'このクエリは有効ではありません。参照されているカテゴリやフィードはすでに消去されました。',
		'description' => '説明',
		'filter' => array(
			'_' => 'フィルターを適用：',
			'categories' => 'カテゴリごとに表示する',
			'feeds' => 'フィードごとに表示する',
			'order' => '日付ごとにソートする',
			'publish_labels_instead_of_tags' => '共有RSSでは<i>フィードタグ</i>の代わりに<i>ユーザーラベル</i>を使用する',
			'search' => '検索式',//DIRTY
			'shareOpml' => 'カテゴリとフィードのOPMLによる共有を有効にする',
			'shareRss' => 'HTMLとRSSによる共有を有効にする',
			'state' => '状態',
			'tags' => 'タグごとに表示する',
			'type' => 'タイプ',
		),
		'get_A' => 'カテゴリで表示するものも含め、すべてのフィードを表示する',
		'get_Z' => 'アーカイブも含め、すべてのフィードを表示する',
		'get_all' => 'すべての記事を表示する',
		'get_all_labels' => 'いずれかのラベルが付いた記事を表示する',
		'get_category' => 'カテゴリ「%s」を表示する',
		'get_favorite' => 'お気に入りの記事を表示する',
		'get_feed' => 'フィード「%s」を表示する',
		'get_important' => '重要なフィードからの記事を表示する',
		'get_label' => 'ラベル「%s」が付いた記事を表示する',
		'help' => 'HTML/RSS/OPMLによるユーザークエリと再共有については <a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank">こちら</a>をご覧ください',
		'image_url' => '画像のURL',
		'name' => '名前',
		'no_filter' => 'フィルターはありません',
		'no_queries' => array(
			'_' => 'まだユーザークエリは保存されていません。',
			'help' => '<a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank">ドキュメント</a>を参照してください',
		),
		'number' => 'クエリ No. °%d',//DIRTY
		'order_asc' => '古い記事を最初に表示する',
		'order_desc' => '新しい記事を最初に表示する',
		'search' => '「%s」で検索する',
		'share' => array(
			'_' => 'このクエリをリンクで共有する',
			'disabled' => array(
				'_' => '無効',
				'title' => '共有',
			),
			'greader' => 'GReader用JSONファイルへの共有リンク',
			'help' => 'このクエリを誰かと共有したい場合は、このリンクを共有してください',
			'html' => 'HTMLページへの共有リンク',
			'opml' => 'フィードのOPMLリストへの共有リンク',
			'rss' => 'RSSフィードへの共有リンク',
		),
		'state_0' => 'すべての記事を表示',
		'state_1' => '既読の記事を表示',
		'state_2' => '未読の記事を表示',
		'state_3' => 'すべての記事を表示',
		'state_4' => 'お気に入りの記事を表示',
		'state_5' => 'お気に入りの既読の記事を表示',
		'state_6' => 'お気に入りの未読の記事を表示',
		'state_7' => 'お気に入りの記事を表示',
		'state_8' => 'お気に入りでない記事を表示',
		'state_9' => 'お気に入りでない既読の記事を表示',
		'state_10' => 'お気に入りでない未読の記事を表示',
		'state_11' => 'お気に入りでない記事を表示',
		'state_12' => 'すべての記事を表示',
		'state_13' => 'すべての既読の記事を表示',
		'state_14' => '未読の記事を表示',
		'state_15' => 'すべての記事を表示',
		'title' => 'ユーザークエリ',
	),
	'reading' => array(
		'_' => '閲覧',
		'after_onread' => '「すべて既読にする」の実行後、',
		'always_show_favorites' => 'デフォルトですべてのお気に入りの記事を表示する',//DIRTY
		'apply_to_individual_feed' => '個々のフィードに適用する',
		'article' => array(
			'authors_date' => array(
				'_' => '著者と日時',
				'both' => 'ヘッダーとフッター',
				'footer' => 'フッター',
				'header' => 'ヘッダー',
				'none' => 'なし',
			),
			'feed_name' => array(
				'above_title' => 'タイトルとタグの上',
				'none' => 'なし',
				'with_authors' => '著者と日時の隣',
			),
			'feed_title' => 'フィード名',
			'icons' => array(
				'_' => '記事アイコンの位置<br /><small>（リーディングビューのみ）</small>',
				'above_title' => 'タイトルの上',
				'with_authors' => '著者と日時の隣',
			),
			'tags' => array(
				'_' => 'タグ',
				'both' => 'ヘッダーとフッター',
				'footer' => 'フッター',
				'header' => 'ヘッダー',
				'none' => 'なし',
			),
			'tags_max' => array(
				'_' => '表示するタグの数の上限',
				'help' => '0に設定すると、折りたたまずにすべてのタグを表示します。',
			),
		),
		'articles_per_page' => '1ページあたりの記事の数',
		'auto_load_more' => 'ページ下部で記事をさらに読み込む',//DIRTY
		'auto_remove_article' => '記事を読んだら非表示にする',
		'confirm_enabled' => '既読を付けるボタンを押したとき確認ダイアログを表示する',
		'display_articles_unfolded' => 'デフォルトで記事を展開する',
		'display_categories_unfolded' => '展開するカテゴリ',
		'headline' => array(
			'articles' => '記事：開く/閉じる',
			'articles_header_footer' => '記事：ヘッダー/フッター',
			'categories' => '左のナビゲーション：カテゴリ',
			'mark_as_read' => 'チェックをつけた記事を既読にする',
			'misc' => 'その他',
			'view' => 'ビュー',
		),
		'hide_read_feeds' => '未読記事のないカテゴリとフィードを非表示（「すべての記事を表示」設定では機能しません）',//DIRTY
		'img_with_lazyload' => '画像の読み込みに<em>lazy load</em>を使用する',
		'jump_next' => '次の未読記事へ移動する',
		'mark_updated_article_unread' => '更新された記事を未読とする',
		'number_divided_when_reader' => 'リーディングビューでは記事数を2分の1にする',
		'read' => array(
			'article_open_on_website' => '記事を元のWebサイトで開いたとき',
			'article_viewed' => '記事を読んだとき',
			'focus' => 'フォーカスしたとき（重要なフィードを除く）',
			'keep_max_n_unread' => '未読の記事として残す最大数',
			'scroll' => 'スクロールしているとき（重要なフィードを除く）',
			'upon_gone' => 'ニュースフィードの提供元がなくなったとき',
			'upon_reception' => '記事を受け取ったとき',
			'when' => '記事を既読にする…',//DIRTY
			'when_same_guid_in_category' => 'カテゴリの最新記事上位<i>n</i>件に同一のGUIDを持つ記事が存在する場合',
			'when_same_title_in_category' => 'カテゴリの最新記事上位<i>n</i>件に同一タイトルの記事が存在する場合',
			'when_same_title_in_feed' => 'フィードの最新記事上位<i>n</i>件に同一タイトルの記事が存在する場合',
		),
		'show' => array(
			'_' => '記事を表示する',
			'active_category' => 'アクティブなカテゴリ',
			'adaptive' => '未読を表示し、無ければすべての記事を表示する',
			'all_articles' => 'すべての記事を表示する',
			'all_categories' => 'すべてのカテゴリ',
			'no_category' => '未分類',
			'remember_categories' => '前回開いたカテゴリ',
			'unread' => '未読のみ表示する',
			'unread_or_favorite' => '未読とお気に入りを表示する',
		),
		'show_fav_unread_help' => 'ラベルも適用する',
		'sides_close_article' => '記事本文の外側をクリックしたときに記事を閉じる',
		'star' => array(
			'when' => '記事をお気に入りに登録する。',
		),
		'sticky_post' => '開いた記事を先頭に固定する',
		'sticky_sort' => 'ナビゲーション中も手動の並び順を保持する',	// DIRTY
		'sticky_sort_help' => '最後に指定した手動の並び順を保持するか、各カテゴリーやフィードが常に独自の既定または全体設定を使用するかを決めます。',	// DIRTY
		'title' => '閲覧',
		'view' => array(
			'default' => 'デフォルトビュー',
			'global' => 'グローバルビュー',
			'normal' => 'ノーマルビュー',
			'reader' => 'リーディングビュー',
		),
	),
	'sharing' => array(
		'_' => '共有',
		'add' => '共有先を追加',
		'bluesky' => 'Bluesky',	// IGNORE
		'deprecated' => 'このサービスは非推奨でFreshRSSの<a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Open documentation for more information" target="_blank">将来のリリース</a>から削除される予定です。',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'メール',
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => '詳細',
		'print' => '印刷',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => '共有先を削除する',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => '共有先',
		'share_url' => '共有URL',
		'title' => '共有',
		'twitter' => 'X (Twitter)',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'ショートカット',
		'article_action' => '記事のアクション',
		'auto_share' => '共有',
		'auto_share_help' => '共有方法が1つだけ設定されている場合はそれを使用します。複数ある場合は番号で選択します。',
		'close_menus' => 'メニューを閉じる',
		'collapse_article' => '折りたたむ',
		'first_article' => '初めの記事を開く',
		'focus_search' => '検索ボックスにフォーカスする',
		'global_view' => 'グローバルビューに変更する',
		'help' => 'ドキュメントを表示する',
		'javascript' => 'JavaScriptはショートカットを使うときに必要です',
		'last_article' => '最後の記事を開く',
		'load_more' => 'もっと記事を読み込む',
		'mark_favorite' => 'お気に入りを切り替える',
		'mark_read' => '既読/未読を切り替える',
		'navigation' => 'ナビゲーション',
		'navigation_help' => '<kbd>⇧ Shift</kbd>キーとの組み合わせで、フィードをナビゲーションします。<br/><kbd>Alt ⎇</kbd> キーとの組み合わせで、カテゴリをナビゲーションします。',
		'navigation_no_mod_help' => '以下のナビゲーションショートカットは、修飾キーをサポートしません。',
		'next_article' => '次の記事を開く',
		'next_unread_article' => '次の未読の記事を開く',
		'non_standard' => '一部のキー（<kbd>%s</kbd>）はショートカットとして機能しない場合があります。',
		'normal_view' => 'ノーマルビューに切り替える',
		'other_action' => 'ほかのアクション',
		'previous_article' => '前の記事を開く',
		'reading_view' => 'リーディングビューに切り替える',
		'rss_view' => 'RSSフィードとして開く',
		'see_on_website' => '元のWebサイトを開く',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd>で前の記事を既読にし、<br />+ <kbd>⇧ Shift</kbd>ですべての記事を既読にします。',
		'skip_next_article' => '次の記事を開かずにフォーカスする',
		'skip_previous_article' => '前の記事を開かずにフォーカスする',
		'title' => 'ショートカット',
		'toggle_aside' => 'サイドバーの表示/非表示を切り替える',
		'toggle_media' => 'メディアを再生／一時停止する',
		'user_filter' => 'ユーザークエリにアクセスする',
		'user_filter_help' => 'ユーザークエリが1件だけの場合はそれを使用し、複数ある場合は番号で選択します。',//DIRTY
		'views' => 'ビュー',
	),
	'user' => array(
		'articles_and_size' => '%s件の記事（%s）',//DIRTY
		'current' => '現在のユーザー',
		'is_admin' => '管理者権限',
		'users' => 'ユーザー',
	),
);

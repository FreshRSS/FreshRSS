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
	'action' => array(
		'actualize' => 'フィードを更新する',
		'add' => '追加',
		'back_to_rss_feeds' => '← RSSフィードに戻る',
		'cancel' => 'キャンセル',
		'close' => '閉じる',
		'create' => '作成',
		'delete_all_feeds' => 'すべてのフィードを削除する',
		'delete_errored_feeds' => 'エラーが発生しているフィードを削除',
		'delete_muted_feeds' => 'ミュートにしているフィードを削除する',
		'demote' => '降格',
		'disable' => '無効',
		'download' => 'ダウンロード',
		'empty' => '空',
		'enable' => '有効',
		'export' => 'エクスポート',
		'filter' => 'フィルター',
		'import' => 'インポート',
		'load_default_shortcuts' => 'デフォルトのショートカットを読み込む',
		'manage' => '管理',
		'mark_read' => '既読にする',
		'menu' => array(
			'open' => 'メニューを開く',
		),
		'nav_buttons' => array(
			'next' => '次の記事',
			'prev' => '前の記事',
			'up' => '先頭へ',
		),
		'open_url' => 'URLを開く',
		'promote' => '昇格',
		'purge' => '不要なデータの削除',
		'refresh_opml' => 'OPMLを更新する',
		'remove' => '消去',
		'rename' => '名前を変更する',
		'see_website' => 'Webサイトを開く',
		'submit' => '保存',
		'truncate' => 'すべての記事を消去する',
		'update' => '更新',
	),
	'auth' => array(
		'accept_tos' => '<a href="%s">利用規約</a>に同意します。',
		'email' => 'メールアドレス',
		'keep_logged_in' => 'ログイン状態を保持する<small>（%s日間）</small>',
		'login' => 'ログイン',
		'logout' => 'ログアウト',
		'password' => array(
			'_' => 'パスワード',
			'format' => '<small>7文字以上必要です</small>',
		),
		'reauth' => array(
			'header' => '再認証が必要です',
			'tip' => '今後<u>%d分間</u>は再ログインを求められません',
			'title' => '再認証',
		),
		'registration' => array(
			'_' => '新規アカウント',
			'ask' => 'アカウントを作成しますか？',
			'title' => 'アカウント作成',
		),
		'username' => array(
			'_' => 'ユーザー名',
			'format' => '<small>16文字以内の英数字</small>',
		),
	),
	'date' => array(
		'Apr' => '4\\月',
		'Aug' => '8\\月',
		'Dec' => '12\\月',
		'Feb' => '2\\月',
		'Jan' => '1\\月',
		'Jul' => '7\\月',
		'Jun' => '6\\月',
		'Mar' => '3\\月',
		'May' => '5\\月',
		'Nov' => '11\\月',
		'Oct' => '10\\月',
		'Sep' => '9\\月',
		'apr' => '4月',
		'april' => '4月',
		'aug' => '8月',
		'august' => '8月',
		'before_yesterday' => '一昨日',
		'dec' => '12月',
		'december' => '12月',
		'feb' => '2月',
		'february' => '2月',
		'format_date' => 'Y\\年n\\月j\\日',
		'format_date_hour' => 'Y\\年n\\月j\\日	H\\:i',
		'fri' => '金',
		'jan' => '1月',
		'january' => '1月',
		'jul' => '7月',
		'july' => '7月',
		'jun' => '6月',
		'june' => '6月',
		'last_2_year' => '直近2年間',
		'last_3_month' => '直近3ヶ月間',
		'last_3_year' => '直近3年間',
		'last_5_year' => '直近5年間',
		'last_6_month' => '直近6ヶ月間',
		'last_month' => '先月',
		'last_week' => '先週',
		'last_year' => '去年',
		'mar' => '3月',
		'march' => '3月',
		'may' => '5月',
		'may_' => '5月',
		'mon' => '月',
		'month' => '月',
		'nov' => '11月',
		'november' => '11月',
		'oct' => '10月',
		'october' => '10月',
		'sat' => '土',
		'sep' => '9月',
		'september' => '9月',
		'sun' => '日',
		'thu' => '木',
		'today' => '今日',
		'tue' => '火',
		'wed' => '水',
		'yesterday' => '昨日',
	),
	'dir' => 'ディレクトリ',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'FreshRSSについて',
	),
	'interval' => array(
		'day' => array(
			0 => '%d日前',
		),
		'hour' => array(
			0 => '%d時間前',
		),
		'justnow' => 'たった今',
		'minute' => array(
			0 => '%d分前',
		),
		'month' => array(
			0 => '%dか月前',
		),
		'second' => array(
			0 => '%d秒前',
		),
		'year' => array(
			0 => '%d年前',
		),
	),
	'js' => array(
		'category_empty' => '空のカテゴリ',
		'confirm_action' => '本当に実行しますか？この操作は取り消せません。',
		'confirm_action_feed_cat' => '本当に実行しますか？関連するお気に入りとユーザークエリも削除されます。この操作は取り消せません。',
		'confirm_exit_slider' => '保存していない設定を破棄してもよろしいですか',
		'feedback' => array(
			'body_new_articles' => array(
				0 => '新着記事が%d件あります。',
			),
			'body_unread_articles' => array(
				0 => '（未読：%d件）',
			),
			'request_failed' => 'おそらくインターネット接続に問題があるため、リクエストは失敗しました。',
			'title_new_articles' => 'FreshRSS：新着記事',
		),
		'labels_empty' => 'ラベルがありません',
		'new_article' => '新しい記事があります。クリックしてページを更新してください。',
		'should_be_activated' => 'JavaScriptを有効にする必要があります。',
		'unsafe_csp_header' => '使用中のCSPヘッダーは安全ではないため、FreshRSSがXSS攻撃に対して脆弱になる可能性があります。<a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">ドキュメント</a>を参照してください。',
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'FreshRSSについて',
		'account' => 'アカウント',
		'admin' => '管理者',
		'advanced_search' => '高度な検索',
		'archiving' => 'アーカイブ',
		'authentication' => '認証',
		'check_install' => 'インストール時のチェック',
		'configuration' => '設定',
		'display' => '表示',
		'extensions' => '拡張機能',
		'logs' => 'ログ',
		'privacy' => 'プライバシー',
		'queries' => 'ユーザークエリ',
		'reading' => '閲覧',
		'search' => '単語で検索するかハッシュタグで検索する',
		'search_help' => '高度な検索パラメータについては <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">こちら</a>を参照してください',
		'sharing' => '共有',
		'shortcuts' => 'ショートカット',
		'stats' => '統計',
		'system' => 'システム設定',
		'update' => '更新',
		'user_management' => 'ユーザー管理',
		'user_profile' => 'プロフィール',
	),
	'period' => array(
		'days' => '日間',
		'hours' => '時間',
		'months' => 'ヶ月',
		'weeks' => '週間',
		'years' => '年間',
	),
	'readme' => array(
		'contribute' => 'contribute',	// IGNORE
		'language' => 'Language',	// IGNORE
		'translated' => 'Progress',	// IGNORE
	),
	'search' => array(
		'advanced_search_help' => 'このフォームで検索クエリを作成できますが、手動で記述するクエリではさらに高度な検索が可能です。',
		'authors' => '著者',
		'categories' => 'カテゴリ',
		'content' => '本文',
		'date_from' => '開始日',
		'date_modified' => 'サーバー上の変更日時',
		'date_past' => '直近',
		'date_published' => '公開日時',
		'date_range' => '期間を指定',
		'date_received' => '受信日時',
		'date_to' => '終了日',
		'date_user' => 'ユーザーによる変更日時',
		'feeds' => 'フィード',
		'free_text' => 'フリーワード',
		'free_text_help' => 'タイトルと本文の両方を検索します。',
		'full_documentation' => '<a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">検索機能の詳しいドキュメント</a>を表示',
		'labels' => 'ラベル',
		'multiple_help' => '1つ以上選択してください（複数選択するには<kbd>Ctrl</kbd>または<kbd>Cmd</kbd>を押しながらクリック）',
		'sources' => '検索対象',
		'tags' => 'タグ',
		'text' => 'テキスト検索',
		'text_help' => '複数行は論理<i>OR</i>で結合されます。<a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">正規表現</a>も使用できます。',
		'text_placeholder' => 'キーワード',
		'title' => 'タイトル',
		'url' => 'URL',	// IGNORE
		'user_queries' => 'ユーザークエリ',
	),
	'share' => array(
		'Known' => 'よく使われるサイト',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'クリップボード',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'メール',
		'email-webmail-firefox-fix' => 'メール（Firefox対応）',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkace' => 'LinkAce',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'nextcloud-bookmarks' => 'Nextcloud ブックマーク',	// DIRTY
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'print' => '印刷',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'X (Twitter)',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'システム共有',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => '警告！',
		'blank_to_disable' => '空白のままにすると無効になります',
		'by_author' => '著者：',
		'by_default' => 'デフォルト',
		'damn' => 'しまった！',
		'default_category' => '未分類',
		'no' => 'いいえ',
		'not_applicable' => '利用できません',
		'ok' => 'OK！',
		'or' => 'または',
		'yes' => 'はい',
	),
	'stream' => array(
		'load_more' => '記事を追加で読み込む',
		'mark_all_read' => 'すべての記事を既読にする',
		'nothing_to_load' => 'これ以上記事はありません',
	),
);

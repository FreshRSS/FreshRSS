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
		'delete_errored_feeds' => 'エラーのフィードを削除する',
		'delete_muted_feeds' => 'ミュートにしているフィードを削除する',
		'demote' => '寄付',
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
		'promote' => 'プロモート',
		'purge' => '不要なデータの削除',
		'refresh_opml' => 'OPMLをリフレッシュする',
		'remove' => '消去',
		'rename' => '名前を変更する',
		'see_website' => 'Webサイトを開く',
		'submit' => '保存',
		'truncate' => 'すべての記事を消去する',
		'update' => '更新',
	),
	'auth' => array(
		'accept_tos' => '私は <a href="%s">Terms of Service</a>を承認します。',
		'email' => 'Eメールアドレス',
		'keep_logged_in' => 'ログインを保持する <small>%s日後にログアウトする</small>',
		'login' => 'ログイン',
		'logout' => 'ログアウト',
		'password' => array(
			'_' => 'パスワード',
			'format' => '<small>最低７文字必要です</small>',
		),
		'reauth' => array(
			'header' => '再認証が必要です',
			'tip' => '今後<u>%d分間</u>は再ログインを求められません',
			'title' => '再認証',
		),
		'registration' => array(
			'_' => '新規アカウント',
			'ask' => 'アカウントを作りますか?',
			'title' => 'アカウント作成',
		),
		'username' => array(
			'_' => 'ユーザー名',
			'format' => '<small>最大16文字の英数字</small>',
		),
	),
	'date' => array(
		'Apr' => '\\四\\月',
		'Aug' => '\\八\\月',
		'Dec' => '\\十\\二\\月',
		'Feb' => '\\二\\月',
		'Jan' => '\\一\\月',
		'Jul' => '\\七\\月',
		'Jun' => '\\六\\月',
		'Mar' => '\\三\\月',
		'May' => '\\五\\月',
		'Nov' => '\\十\\一\\月',
		'Oct' => '\\十\\月',
		'Sep' => '\\九\\月',
		'apr' => '四月',
		'april' => '四月',
		'aug' => '八月',
		'august' => '八月',
		'before_yesterday' => 'おととい',
		'dec' => '十二月',
		'december' => '十二月',
		'feb' => '二月',
		'february' => '二月',
		'format_date' => 'Y\\年n\\月j\\日',
		'format_date_hour' => 'Y\\年n\\月j\\日	H\\:i',
		'fri' => '金',
		'jan' => '一月',
		'january' => '一月',
		'jul' => '七月',
		'july' => '七月',
		'jun' => '六月',
		'june' => '六月',
		'last_2_year' => '直近二年間',
		'last_3_month' => '直近三か月',
		'last_3_year' => '直近三年間',
		'last_5_year' => '直近五年間',
		'last_6_month' => '直近六か月',
		'last_month' => '先月',
		'last_week' => '先週',
		'last_year' => '去年',
		'mar' => '三月',
		'march' => '三月',
		'may' => '五月',
		'may_' => '五月',
		'mon' => '月',
		'month' => '月',
		'nov' => '十一月',
		'november' => '十一月',
		'oct' => '十月',
		'october' => '十月',
		'sat' => '土',
		'sep' => '九月',
		'september' => '九月',
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
		'category_empty' => '空白のカテゴリ',
		'confirm_action' => '本当に実行してもいいですか?キャンセルはできません!',
		'confirm_action_feed_cat' => '本当に実行してもいいですか? あなたは関連するお気に入りとユーザークエリを失います。キャンセルできません!',
		'confirm_exit_slider' => '保存していない設定を破棄してもよろしいですか',
		'feedback' => array(
			'body_new_articles' => array(
				0 => '%d の新規記事がFreshRSSにはあります。',	// DIRTY
			),
			'body_unread_articles' => array(
				0 => '(未読: %d)',	// DIRTY
			),
			'request_failed' => 'おそらくインターネット接続に問題があるため、リクエストは失敗しました。',
			'title_new_articles' => 'FreshRSS: 新規記事!',
		),
		'labels_empty' => 'ラベルがありません',
		'new_article' => '新しい記事があるのでクリックしてページをリフレッシュしてください。',
		'should_be_activated' => 'JavaScriptは有効になっている必要があります。',
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
		'display' => 'ディスプレイ',
		'extensions' => '拡張機能',
		'logs' => 'ログ',
		'privacy' => 'プライバシー',
		'queries' => 'ユーザークエリ',
		'reading' => 'リーディング',
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
		'email' => 'Eメール',
		'email-webmail-firefox-fix' => 'Eメール（Firefox用に修正）',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
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
		'attention' => '警告!',
		'blank_to_disable' => '空白のままにすると無効になります',
		'by_author' => '著者:',
		'by_default' => 'デフォルト',
		'damn' => '終了!',
		'default_category' => '未分類',
		'no' => 'いいえ',
		'not_applicable' => '利用不可能',
		'ok' => 'OK!',
		'or' => 'または',
		'yes' => 'はい',
	),
	'stream' => array(
		'load_more' => '記事をもっと読み込む',
		'mark_all_read' => 'すべての記事を既読にする',
		'nothing_to_load' => 'これ以上の記事はありません',
	),
);

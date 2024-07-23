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
	'action' => array(
		'actualize' => 'フィードを更新する',
		'add' => '追加',
		'back' => '← 戻る',
		'back_to_rss_feeds' => '← RSSフィードに戻る',
		'cancel' => 'キャンセル',
		'create' => '作成',
		'delete_muted_feeds' => 'ミュートにしているフィードを削除する',
		'demote' => '寄付',
		'disable' => '無効',
		'empty' => '空',
		'enable' => '有効',
		'export' => 'エクスポート',
		'filter' => 'フィルター',
		'import' => 'インポート',
		'load_default_shortcuts' => 'デフォルトのショートカットを読み込む',
		'manage' => '管理',
		'mark_read' => '既読にする',
		'menu' => array(
			'open' => 'Open menu',	// TODO
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
	'js' => array(
		'category_empty' => '空白のカテゴリ',
		'confirm_action' => '本当に実行してもいいですか?キャンセルはできません!',
		'confirm_action_feed_cat' => '本当に実行してもいいですか? あなたは関連するお気に入りとユーザークエリを失います。キャンセルできません!',
		'feedback' => array(
			'body_new_articles' => '%%d の新規記事がFreshRSSにはあります。',
			'body_unread_articles' => '(未読: %%d)',
			'request_failed' => 'おそらくインターネット接続に問題があるため、リクエストは失敗しました。',
			'title_new_articles' => 'FreshRSS: 新規記事!',
		),
		'labels_empty' => 'ラベルがありません',
		'new_article' => '新しい記事があるのでクリックしてページをリフレッシュしてください。',
		'should_be_activated' => 'JavaScriptは有効になっている必要があります。',
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
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
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
		'zh-tw' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'FreshRSSについて',
		'account' => 'アカウント',
		'admin' => '管理者',
		'archiving' => 'アーカイブ',
		'authentication' => '認証',
		'check_install' => 'インストール時のチェック',
		'configuration' => '設定',
		'display' => 'ディスプレイ',
		'extensions' => '拡張機能',
		'logs' => 'ログ',
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
	'share' => array(
		'Known' => 'よく使われるサイト',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
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
		'pocket' => 'Pocket',	// IGNORE
		'print' => '印刷',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
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

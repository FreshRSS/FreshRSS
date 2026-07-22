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
	'auth' => array(
		'allow_anonymous' => 'ログインしていないユーザーにもデフォルトユーザー（%s）の記事の閲覧を許可する',
		'allow_anonymous_refresh' => 'ログインしていないユーザーにも記事の更新を許可する',
		'api_enabled' => '<abbr>API</abbr>アクセスを許可する<small>（モバイルアプリやユーザークエリの共有に必要）</small>',
		'default_theme' => array(
			'_' => 'Default theme',	// TODO
			'help' => 'Theme used on pages shown before login, such as the login page.',	// TODO
			'installation_default' => 'Installation default theme',	// TODO
		),
		'form' => 'ウェブフォーム（JavaScriptが必要です）',
		'http' => 'HTTP（上級者向け：Webサーバー、OIDC、SSOなどで管理）',
		'none' => 'なし（危険）',
		'title' => '認証',
		'token' => 'マスター認証用トークン',
		'token_help' => 'ユーザーのすべてのRSS出力へのアクセスと、認証なしでのフィード更新を許可します：',
		'type' => '認証メソッド',
	),
	'extensions' => array(
		'author' => '作成者',
		'community' => '利用可能なコミュニティ拡張機能',
		'description' => '説明',
		'disabled' => '無効',
		'empty_list' => 'インストールされている拡張機能はありません',
		'empty_list_help' => '拡張機能リストが表示されない原因を特定するために、ログを確認してください。',
		'enabled' => '有効',
		'is_compatible' => '互換性あり',
		'latest' => 'インストール済み',
		'name' => '名前',
		'no_configure_view' => 'この拡張機能は設定できません。',
		'system' => array(
			'_' => 'システム拡張機能',
			'no_rights' => 'システム拡張機能（必要な権限がありません）',
		),
		'title' => '拡張機能',
		'update' => 'アップデート可能',
		'user' => 'ユーザー拡張機能',
		'version' => 'バージョン',
	),
	'stats' => array(
		'_' => '統計',
		'all_feeds' => 'すべてのフィード',
		'category' => 'カテゴリ',
		'date_published' => '公開日ごと',
		'date_received' => '受信日ごと',
		'entry_count' => 'エントリの統計',
		'entry_per_category' => 'カテゴリごとのエントリ',
		'entry_per_day' => '日にちごとのエントリ（直近30日間）',
		'entry_per_day_of_week' => '曜日ごと（平均エントリ：%.2f件）',
		'entry_per_hour' => '時間ごと（平均エントリ：%.2f件）',
		'entry_per_month' => '月ごと（平均エントリ：%.2f件）',
		'entry_repartition' => 'エントリの割合',
		'feed' => 'フィード',
		'feed_per_category' => 'カテゴリごとのフィード',
		'idle' => '休止中のフィード',
		'main' => '主な統計',
		'main_stream' => 'メインストリーム',
		'nb_unreads' => '未読記事数',
		'no_idle' => '休止中のフィードはありません。',
		'number_entries' => '%d 記事',
		'overview' => '概要',
		'percent_of_total' => '割合（%）',
		'repartition' => '記事の分布：%s',
		'status_favorites' => 'お気に入り',
		'status_read' => '既読',
		'status_total' => 'すべて',
		'status_unread' => '未読',
		'title' => '統計',
		'top_feed' => '上位10フィード',
		'unread_dates' => '未読記事数が多い日付',
	),
	'system' => array(
		'_' => 'システム設定',
		'auto-update-url' => '自動更新サーバーのURL',
		'base-url' => array(
			'_' => 'ベースURL',
			'recommendation' => '自動検出された推奨URL：<kbd>%s</kbd>',
		),
		'closed_registration_message' => '新規でユーザー登録できない時のメッセージ',
		'cookie-duration' => array(
			'help' => '秒',
			'number' => 'ログイン状態維持時間',
		),
		'default_closed_registration_message' => '現在新しいユーザー登録を受け付けていません。',
		'force_email_validation' => 'メールアドレスの確認を必須にします。',
		'instance-name' => 'インスタンス名',
		'internal-host-allowlist' => array(
			'_' => '内部ホストの許可リスト',
			'help' => '1行につき1件を指定します：<ul><li><code>host:port</code>形式。例：<code>127.0.0.1:8080</code>、<code>rss-bridge:80</code></li><li>CIDR表記。例：すべてのIPv4アドレスを許可する<code>0.0.0.0/0</code>、すべてのIPv6アドレスを許可する<code>::/0</code></li><li>すべてのホストを許可する<code>*</code>（非推奨）</li></ul>',
		),
		'max-categories' => 'ユーザーごとの最大カテゴリ数',
		'max-feeds' => 'ユーザーごとの最大フィード数',
		'override-by-env-var' => '<kbd>%s</kbd> は環境変数によって上書きされます',
		'registration' => array(
			'number' => 'アカウント数の上限',
			'select' => array(
				'label' => '登録フォーム',
				'option' => array(
					'noform' => '無効：登録フォームはありません',
					'nolimit' => '有効：アカウントの上限はありません',
					'setaccountsnumber' => '有効：アカウントの上限を設定',
				),
			),
			'status' => array(
				'disabled' => 'フォームは無効です',
				'enabled' => 'フォームは有効です',
			),
			'title' => 'ユーザー登録',
		),
		'sensitive-parameter' => 'センシティブなパラメーターです。<kbd>./data/config.php</kbd> を手動で編集してください',
		'tos' => array(
			'disabled' => '無効',
			'enabled' => '<a href="./?a=tos">有効</a>',
			'help' => '<a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">利用規約を有効にする方法</a>',
		),
		'websub' => array(
			'help' => '<a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSubについて</a>',
		),
	),
	'update' => array(
		'_' => 'システムアップデート',
		'apply' => '適用',
		'changelog' => '変更履歴',
		'check' => 'アップデートを確認する',
		'copiedFromURL' => 'update.phpが%sから./dataにコピーされました。',
		'current_version' => '現在のバージョン',
		'last' => '前回の確認',
		'loading' => '更新中…',
		'none' => '更新を適用できません',
		'releaseChannel' => array(
			'_' => 'リリースチャンネル',
			'edge' => 'ローリングリリース（edge）',
			'latest' => '安定版リリース（latest）',
		),
		'title' => 'アップデートシステム',
		'viaGit' => 'gitおよびGitHub.com経由でアップデートを開始しました。',
	),
	'user' => array(
		'admin' => '管理者',
		'article_count' => '記事',
		'back_to_manage' => '← ユーザーリストに戻る',
		'create' => '新規ユーザーを作成',
		'database_size' => 'データベースサイズ',
		'email' => 'メールアドレス',
		'enabled' => '有効',
		'feed_count' => 'フィード',
		'is_admin' => '管理者',
		'language' => '言語',
		'last_user_activity' => '最近のユーザーアクティビティ',
		'list' => 'ユーザーリスト',
		'number' => '%d件のアカウントが作成されています。',
		'numbers' => '%d件のアカウントが作成されています。',
		'password_form' => 'パスワード<br /><small>（Webフォームログイン用）</small>',
		'password_format' => '7文字以上必要です。',
		'title' => 'ユーザー管理',
		'username' => 'ユーザー名',
	),
);

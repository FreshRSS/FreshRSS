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
	'auth' => array(
		'allow_anonymous' => 'デフォルトのユーザーの記事がログインしていないときでも読めるようにします。 (%s)',
		'allow_anonymous_refresh' => '未ログインユーザーでも記事を更新できるようにします。',
		'api_enabled' => '<abbr>API</abbr>からのアクセスを許可する <small>(モバイルアプリが必要です)</small>',
		'form' => 'ウェブフォーム (JavaScriptが必要です)',
		'http' => 'HTTP (上級者はHTTPSでも)',
		'none' => 'なし (危険)',
		'title' => '認証',
		'token' => '認証トークン',
		'token_help' => 'ユーザーが承認無しで、RSSを出力できるようにします。:',
		'type' => '認証メソッド',
		'unsafe_autologin' => '危険な自動ログインを有効にします',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => '<em>./data/cache</em>ディレクトリのパーミッションを確認してください。 HTTP serverは編集権限を必要としています。',
			'ok' => 'キャッシュディレクトリのパーミッションは正しく設定されています。',
		),
		'categories' => array(
			'nok' => 'カテゴリテーブルが不適切な設定をされています。',
			'ok' => 'カテゴリテーブルは正しく設定されています。',
		),
		'connection' => array(
			'nok' => 'データベースへの接続ができませんでした。',
			'ok' => 'データベースへの接続が正しく行われました。',
		),
		'ctype' => array(
			'nok' => '必要とされている文字タイプを確認するライブラリが見つかりませんでした。(php-ctype)',
			'ok' => '必要とされている文字タイプを確認するライブラリが見つかりました。(ctype)',
		),
		'curl' => array(
			'nok' => 'cURLライブラリが見つかりませんでした(php-curl package)',
			'ok' => 'cURLライブラリが見つかりました。',
		),
		'data' => array(
			'nok' => '<em>./data</em>ディレクトリのパーミッションを確認してください。 HTTP serverは編集パーミッションを必要としています。',
			'ok' => 'ディレクトリのパーミッションは正しく設定されています。',
		),
		'database' => 'データベースインストール',
		'dom' => array(
			'nok' => 'DOMを検索するライブラリが見つかりませんでした。 (php-xml package).',
			'ok' => 'DOMを検索するライブラリが見つかりました。',
		),
		'entries' => array(
			'nok' => 'エントリテーブルが不適切な設定をされています。',
			'ok' => 'エントリテーブルは正しく設定されています。',
		),
		'favicons' => array(
			'nok' => '<em>./data/favicons</em>ディレクトリのパーミッションを確認してください。 HTTP serverは編集パーミッションを必要としています。',
			'ok' => 'ファビコンディレクトリのパーミッションは正しく設定されています。',
		),
		'feeds' => array(
			'nok' => 'フィードテーブルが不適切な設定をされています。',
			'ok' => 'フィードテーブルは正しく設定されています。',
		),
		'fileinfo' => array(
			'nok' => 'PHP fileinfoライブラリが見つかりませんでした。 (fileinfo package).',
			'ok' => 'fileinfoライブラリは正しく設定されています。',
		),
		'files' => 'ファイルインストール',
		'json' => array(
			'nok' => 'JSONをパースするライブラリが見つかりませんでした。 (php-json package).',
			'ok' => 'JSONをパースするライブラリはインストールされています。',
		),
		'mbstring' => array(
			'nok' => 'mbstringライブラリが見つかりませんでした。',
			'ok' => 'mbstringライブラリはインストールされています。',
		),
		'pcre' => array(
			'nok' => '正規表現ライブラリが見つかりませんでした。 (php-pcre).',
			'ok' => '正規表現ライブラリはインストールされています。 (PCRE).',
		),
		'pdo' => array(
			'nok' => 'PD0あるいはサポートされているドライバーが見つかりませんでした。 (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'PD0とサポートされているドライバーはインストールされています。 (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'_' => 'PHPインストール',
			'nok' => 'あなたのPHPのバージョンは %s ですが、FreshRSSが動作する最低限のバージョンは %s です。',
			'ok' => 'あなたのPHPのバージョン (%s) はFreshRSSが動作することができるバージョンです。',
		),
		'tables' => array(
			'nok' => 'データベースには1つ以上の失われたテーブルが存在します。',
			'ok' => '適切なテーブルがデータベースに存在します。',
		),
		'title' => 'インストールチェック',
		'tokens' => array(
			'nok' => '<em>./data/tokens</em>ディレクトリのパーミッションを確認してください。HTTP serverは編集パーミッションを必要としています。',
			'ok' => 'tokensディレクトリのパーミッションは正しく設定されています。',
		),
		'users' => array(
			'nok' => '<em>./data/users</em>ディレクトリのパーミッションを確認してください。HTTP serverは編集パーミッションを必要としています。',
			'ok' => 'usersディレクトリのパーミッションは正しく設定されています。',
		),
		'zip' => array(
			'nok' => 'ZIP拡張が見つかりませんでした。 (php-zip package).',
			'ok' => 'ZIP拡張はインストールされています。',
		),
	),
	'extensions' => array(
		'author' => '作者',
		'community' => 'コミュニティ製の拡張機能',
		'description' => '説明',
		'disabled' => '無効',
		'empty_list' => 'インストールされている拡張機能はありません',
		'enabled' => '有効',
		'latest' => 'インストール済み',
		'name' => '名前',
		'no_configure_view' => 'この拡張機能は設定できません.',
		'system' => array(
			'_' => 'システムの拡張機能',
			'no_rights' => 'システムの拡張機能 (あなたは権限を所持していません',
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
		'entry_count' => 'エントリの統計',
		'entry_per_category' => 'カテゴリのエントリ',
		'entry_per_day' => '日にちごとのエントリ (直近30日間)',
		'entry_per_day_of_week' => '週あたり (平均: %.2f メッセージ)',
		'entry_per_hour' => '時間当たり (平均: %.2f メッセージ)',
		'entry_per_month' => '月あたり (平均: %.2f メッセージ)',
		'entry_repartition' => 'エントリの仕切り',
		'feed' => 'フィード',
		'feed_per_category' => 'カテゴリごとのフィード',
		'idle' => '未使用のフィード',
		'main' => '主な統計',
		'main_stream' => '主なストリーム',
		'no_idle' => '未使用のフィードはありません!',
		'number_entries' => '%d 記事',
		'percent_of_total' => '% 総計',
		'repartition' => '記事の仕切り',
		'status_favorites' => 'お気に入り',
		'status_read' => '既読',
		'status_total' => 'すべて',
		'status_unread' => '未読',
		'title' => '仕切り',
		'top_feed' => '上位10位のフィード',
	),
	'system' => array(
		'_' => 'システム設定',
		'auto-update-url' => '自動アップグレードするサーバーのURL',
		'base-url' => array(
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		),
		'cookie-duration' => array(
			'help' => '秒',
			'number' => 'ログを残す間隔',
		),
		'force_email_validation' => 'Eメールアドレスの検証を強制します',
		'instance-name' => 'インスタンス名',
		'max-categories' => '1ユーザーごとのカテゴリの最大値',
		'max-feeds' => '1ユーザーごとのフィードの最大値',
		'registration' => array(
			'number' => 'アカウントの最大値',
			'select' => array(
				'label' => '登録フォーム',
				'option' => array(
					'noform' => '無効: 登録されたフォームはありません',
					'nolimit' => '有効: アカウントの上限はありません',
					'setaccountsnumber' => 'アカウントの上限数に達しました',
				),
			),
			'status' => array(
				'disabled' => 'フォームは無効です',
				'enabled' => 'フォームは有効です',
			),
			'title' => 'ユーザー登録',
		),
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => array(
			'disabled' => 'is not given',	// TODO
			'enabled' => '<a href="./?a=tos">is enabled</a>',	// TODO
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">enable the Terms of Service</a>',	// TODO
		),
	),
	'update' => array(
		'_' => 'システムアップデート',
		'apply' => '適用',
		'changelog' => 'Changelog',	// TODO
		'check' => 'アップデートを確認する',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => '現在のバージョンは',
		'last' => '最近の検証',
		'loading' => 'Updating…',	// TODO
		'none' => '更新を適用できません',
		'releaseChannel' => array(
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		),
		'title' => 'アップデートシステム',
		'viaGit' => 'Update via git and Github.com started',	// TODO
	),
	'user' => array(
		'admin' => '管理者',
		'article_count' => '記事',
		'back_to_manage' => '← ユーザーリストに戻る',
		'create' => '新規ユーザーを作成',
		'database_size' => 'データベースサイズ',
		'email' => 'Eメールアドレス',
		'enabled' => '有効',
		'feed_count' => 'フィード',
		'is_admin' => '管理者',
		'language' => '言語',
		'last_user_activity' => '最近のユーザーアクティビティ',
		'list' => 'ユーザーリスト',
		'number' => '%d 人のアカウントがあります',
		'numbers' => '%d 人のアカウントが作られました',
		'password_form' => 'パスワード<br /><small>(Web-formログインメソッド)</small>',
		'password_format' => '最低限7文字必要です',
		'title' => '管理するユーザー',
		'username' => 'ユーザー名',
	),
);

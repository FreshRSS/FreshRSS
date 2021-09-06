<?php

return array(
	'auth' => array(
		'allow_anonymous' => '標準のユーザーの記事が匿名のユーザーでも読めるようにします。\' (%s)',	// TODO - Translation
		'allow_anonymous_refresh' => '匿名ユーザーが記事を更新できるようにします。',	// TODO - Translation
		'api_enabled' => '<abbr>API</abbr> アクセスを許可する <small>(モバイルアプリが必要です)</small>',	// TODO - Translation
		'form' => 'ウェブフォーム (JavaScriptが必要です)',	// TODO - Translation
		'http' => 'HTTP (上級者向けのHTTPS)',	// TODO - Translation
		'none' => 'なし (危険)',	// TODO - Translation
		'title' => '認証',	// TODO - Translation
		'title_reset' => '認証し直します',	// TODO - Translation
		'token' => '認証トークン',	// TODO - Translation
		'token_help' => '標準ユーザーが承認無しで、RSSを出力できることを許可します。:',	// TODO - Translation
		'type' => '認証メソッド',	// TODO - Translation
		'unsafe_autologin' => '危険な自動ログインを有効にします:	-> todo',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => '<em>./data/cache</em>ディレクトリのパーミッションを確認してください。 HTTP serverは編集パーミッションを必要としています。',	// TODO - Translation
			'ok' => 'キャッシュディレクトリのパーミッションは正しく設定されています。',	// TODO - Translation
		),
		'categories' => array(
			'nok' => 'カテゴリテーブルが不適切な設定をされています。',	// TODO - Translation
			'ok' => 'カテゴリテーブルは正しく設定されています。',	// TODO - Translation
		),
		'connection' => array(
			'nok' => 'データベースへの接続ができませんでした。',	// TODO - Translation
			'ok' => 'データベースへの接続が正しく行われました。',	// TODO - Translation
		),
		'ctype' => array(
			'nok' => '必要とされている文字タイプを確認するライブラリが見つかりませんでした。(php-ctype).',	// TODO - Translation
			'ok' => '必要とされている文字タイプを確認するライブラリが見つかりました。(ctype).',	// TODO - Translation
		),
		'curl' => array(
			'nok' => 'cURLライブラリが見つかりませんでした(php-curl package).',	// TODO - Translation
			'ok' => 'cURLライブラリが見つかりました。',	// TODO - Translation
		),
		'data' => array(
			'nok' => '<em>./data</em>ディレクトリのパーミッションを確認してください。 HTTP serverは編集パーミッションを必要としています。',	// TODO - Translation
			'ok' => 'ディレクトリのパーミッションは正しく設定されています。',	// TODO - Translation
		),
		'database' => 'データベースインストール',	// TODO - Translation
		'dom' => array(
			'nok' => 'DOMを検索するライブラリが見つかりませんでした。 (php-xml package).',	// TODO - Translation
			'ok' => 'DOMを検索するライブラリが見つかりました。',	// TODO - Translation
		),
		'entries' => array(
			'nok' => 'エントリテーブルが不適切な設定をされています。',	// TODO - Translation
			'ok' => 'エントリテーブルは正しく設定されています。',	// TODO - Translation
		),
		'favicons' => array(
			'nok' => '<em>./data/favicons</em>ディレクトリのパーミッションを確認してください。 HTTP serverは編集パーミッションを必要としています。',	// TODO - Translation
			'ok' => 'ファビコンディレクトリのパーミッションは正しく設定されています。',	// TODO - Translation
		),
		'feeds' => array(
			'nok' => 'フィードテーブルが不適切な設定をされています。',	// TODO - Translation
			'ok' => 'フィードテーブルは正しく設定されています。',	// TODO - Translation
		),
		'fileinfo' => array(
			'nok' => 'PHP fileinfoライブラリが見つかりませんでした。 (fileinfo package).',	// TODO - Translation
			'ok' => 'fileinfoライブラリは正しく設定されています。',	// TODO - Translation
		),
		'files' => 'ファイルインストール',	// TODO - Translation
		'json' => array(
			'nok' => 'JSONが見つかりませんでした。  (php-json package).',	// TODO - Translation
			'ok' => 'JSONはインストールされています。',	// TODO - Translation
		),
		'mbstring' => array(
			'nok' => 'mbstringライブラリが見つかりませんでした。',	// TODO - Translation
			'ok' => 'mbstringライブラリはインストールされています。',	// TODO - Translation
		),
		'pcre' => array(
			'nok' => '正規表現ライブラリが見つかりませんでした。 (php-pcre).',	// TODO - Translation
			'ok' => '正規表現ライブラリはインストールされています。 (PCRE).',	// TODO - Translation
		),
		'pdo' => array(
			'nok' => 'PD0あるいはサポートされているドライバーが見つかりませんでした。 (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO - Translation
			'ok' => 'PD0とサポートされているドライバーはインストールされています。 (pdo_mysql, pdo_sqlite, pdo_pgsql).',	// TODO - Translation
		),
		'php' => array(
			'_' => 'PHPインストール',	// TODO - Translation
			'nok' => 'あなたのPHPのバージョンは %s ですが、FreshRSSが動作する最低限のバージョンは %s です。',	// TODO - Translation
			'ok' => 'あなたのPHPのバージョン (%s) はFreshRSSが動作することができるバージョンです。',	// TODO - Translation
		),
		'tables' => array(
			'nok' => 'データベースには1つ以上の失われたテーブルが存在します。',	// TODO - Translation
			'ok' => '適切なテーブルがデータベースに存在します。',	// TODO - Translation
		),
		'title' => 'インストールチェック',	// TODO - Translation
		'tokens' => array(
			'nok' => '<em>./data/tokens</em>ディレクトリのパーミッションを確認してください。HTTP serverは編集パーミッションを必要としています。',	// TODO - Translation
			'ok' => 'tokensディレクトリのパーミッションは正しく設定されています。',	// TODO - Translation
		),
		'users' => array(
			'nok' => '<em>./data/users</em>ディレクトリのパーミッションを確認してください。HTTP serverは編集パーミッションを必要としています。',	// TODO - Translation
			'ok' => 'usersディレクトリのパーミッションは正しく設定されています。',	// TODO - Translation
		),
		'zip' => array(
			'nok' => 'ZIP拡張が見つかりませんでした。 (php-zip package).',	// TODO - Translation
			'ok' => 'ZIP拡張はインストールされています。',	// TODO - Translation
		),
	),
	'extensions' => array(
		'author' => '作者',	// TODO - Translation
		'community' => 'コミュニティ製の拡張',	// TODO - Translation
		'description' => '説明',	// TODO - Translation
		'disabled' => '無効',	// TODO - Translation
		'empty_list' => 'インストールされている拡張はありません',	// TODO - Translation
		'enabled' => '有効',	// TODO - Translation
		'latest' => 'インストール済み',	// TODO - Translation
		'name' => '名前',	// TODO - Translation
		'no_configure_view' => 'この拡張は設定できません.',	// TODO - Translation
		'system' => array(
			'_' => 'システム拡張',	// TODO - Translation
			'no_rights' => 'システム拡張 (あなたには権限がありません)',	// TODO - Translation
		),
		'title' => '拡張',	// TODO - Translation
		'update' => 'アップデート可能',	// TODO - Translation
		'user' => 'ユーザー拡張',	// TODO - Translation
		'version' => 'バージョン',	// TODO - Translation
	),
	'stats' => array(
		'_' => '統計',	// TODO - Translation
		'all_feeds' => 'すべてのフィード',	// TODO - Translation
		'category' => 'カテゴリ',	// TODO - Translation
		'entry_count' => 'エントリの統計',	// TODO - Translation
		'entry_per_category' => 'カテゴリのエントリ',	// TODO - Translation
		'entry_per_day' => '日にちあたりのエントリ (直近30日間)',	// TODO - Translation
		'entry_per_day_of_week' => '週あたり (平均: %.2f メッセージ)',	// TODO - Translation
		'entry_per_hour' => '時間当たり (平均: %.2f メッセージ)',	// TODO - Translation
		'entry_per_month' => '月あたり (平均: %.2f メッセージ)',	// TODO - Translation
		'entry_repartition' => 'エントリの仕切り',	// TODO - Translation
		'feed' => 'フィード',	// TODO - Translation
		'feed_per_category' => 'カテゴリごとのフィード',	// TODO - Translation
		'idle' => '未使用のフィード',	// TODO - Translation
		'main' => '主な統計',	// TODO - Translation
		'main_stream' => '主なストリーム',	// TODO - Translation
		'menu' => array(
			'idle' => '未使用のフィード',	// TODO - Translation
			'main' => '主な統計',	// TODO - Translation
			'repartition' => '記事の仕切り',	// TODO - Translation
		),
		'no_idle' => '未使用のフィードはありません!',	// TODO - Translation
		'number_entries' => '%d 記事',	// TODO - Translation
		'percent_of_total' => '%% 総計',	// TODO - Translation
		'repartition' => '記事の仕切り',	// TODO - Translation
		'status_favorites' => 'お気に入り',	// TODO - Translation
		'status_read' => '既読',	// TODO - Translation
		'status_total' => 'すべて',	// TODO - Translation
		'status_unread' => '未読',	// TODO - Translation
		'title' => '仕切り',	// TODO - Translation
		'top_feed' => '上位10位のフィード',	// TODO - Translation
	),
	'system' => array(
		'_' => 'システム設定',	// TODO - Translation
		'auto-update-url' => '自動アップグレードするサーバーのURL',	// TODO - Translation
		'cookie-duration' => array(
			'help' => '秒',	// TODO - Translation
			'number' => 'ログを残す間隔',	// TODO - Translation
		),
		'force_email_validation' => 'emailアドレスの検証を強制します',	// TODO - Translation
		'instance-name' => 'インスタンス名',	// TODO - Translation
		'max-categories' => '1ユーザーごとのカテゴリの最大値',	// TODO - Translation
		'max-feeds' => '1ユーザーごとのフィードの最大値',	// TODO - Translation
		'registration' => array(
			'help' => '0 はアカウントの上限がないことを意味しています',	// TODO - Translation
			'number' => 'アカウントの最大値',	// TODO - Translation
		),
	),
	'update' => array(
		'_' => 'システムアップデート',	// TODO - Translation
		'apply' => '適用',	// TODO - Translation
		'check' => 'アップデートを確認する',	// TODO - Translation
		'current_version' => 'FreshRSS の現在のバージョンは %s です。',	// TODO - Translation
		'last' => '最近の検証: %s',	// TODO - Translation
		'none' => '適用できないアップデート',	// TODO - Translation
		'title' => 'アップデートシステム',	// TODO - Translation
	),
	'user' => array(
		'admin' => '管理者',	// TODO - Translation
		'article_count' => '記事',	// TODO - Translation
		'articles_and_size' => '%s 記事 (%s)',	// TODO - Translation
		'back_to_manage' => '← ユーザーリストに戻る',	// TODO - Translation
		'create' => '新規ユーザーを作成',	// TODO - Translation
		'database_size' => 'データベースサイズ',	// TODO - Translation
		'delete_users' => 'ユーザーを消去',	// TODO - Translation
		'email' => 'Emailアドレス',	// TODO - Translation
		'enabled' => '有効',	// TODO - Translation
		'feed_count' => 'フィード',	// TODO - Translation
		'is_admin' => '管理者',	// TODO - Translation
		'language' => '言語',	// TODO - Translation
		'last_user_activity' => '最近のユーザーアクティビティ',	// TODO - Translation
		'list' => 'User list',	// TODO - Translation
		'number' => '%d 人のアカウントが作られました',	// TODO - Translation
		'numbers' => '%d 人のアカウントが作られました',	// TODO - Translation
		'password_form' => 'パスワード<br /><small>(Web-formログインメソッド)</small>',	// TODO - Translation
		'password_format' => '最低限7文字必要です',	// TODO - Translation
		'selected' => '選択されたユーザー',	// TODO - Translation
		'title' => '管理するユーザー',	// TODO - Translation
		'update_users' => '更新されるユーザー',	// TODO - Translation
		'user_list' => 'ユーザーの人数',	// TODO - Translation
		'username' => 'ユーザー名',	// TODO - Translation
		'users' => 'ユーザー',	// TODO - Translation
	),
);

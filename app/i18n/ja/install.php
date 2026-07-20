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
		'finish' => 'インストールを完了する',
		'fix_errors_before' => '次のステップへ移る前にエラーを修正してください。',
		'keep_install' => '前の設定を保持する',
		'next_step' => '次のステップへ進む',
		'reinstall' => 'FreshRSSを再インストールする',
	),
	'bdd' => array(
		'_' => 'データベース',
		'conf' => array(
			'_' => 'データベース設定',
			'ko' => 'データベース設定を確認してください。',
			'ok' => 'データベース設定を保存しました。',
		),
		'host' => 'ホスト',
		'password' => 'データベースパスワード',
		'prefix' => 'テーブルプレフィックス',
		'type' => 'データベースの型',
		'username' => 'データベースのユーザー名',
	),
	'check' => array(
		'_' => '環境確認',
		'already_installed' => 'FreshRSSはすでにインストールされています！',
		'cache' => array(
			'nok' => '<em>%1$s</em>ディレクトリに対する<em>%2$s</em>ユーザーの権限を確認してください。HTTPサーバーには書き込み権限が必要です。',
			'ok' => 'キャッシュディレクトリの権限は正しく設定されています。',
		),
		'ctype' => array(
			'nok' => '文字種の判定に必要なライブラリが見つかりませんでした（php-ctype）。',
			'ok' => '文字種の判定に必要なライブラリが見つかりました（ctype）。',
		),
		'curl' => array(
			'nok' => 'cURLライブラリが見つかりませんでした（php-curlパッケージ）。',
			'ok' => 'cURLライブラリが見つかりました。',
		),
		'data' => array(
			'nok' => '<em>%1$s</em>ディレクトリに対する<em>%2$s</em>ユーザーの権限を確認してください。HTTPサーバーには書き込み権限が必要です。',
			'ok' => 'dataディレクトリの権限は正しく設定されています。',
		),
		'database-connection' => array(
			'nok' => 'データベース接続に失敗しました。',
			'ok' => 'データベース接続は正常です。',
		),
		'database-table' => array(
			'nok' => 'データベーステーブル「%s」に不備があります。',
			'ok' => 'データベーステーブル「%s」は正常です。',
		),
		'database-tables' => array(
			'nok' => 'データベーステーブルの一部が存在しません。',
			'ok' => 'データベーステーブルはすべて存在します。',
		),
		'database-title' => 'データベース',
		'docroot' => array(
			'nok' => 'Your web server document root does not seem to point to the <code>./p/</code> folder. Other folders such as <code>./data/</code> may be publicly accessible.',	// TODO
			'ok' => 'Your web server document root correctly points to the <code>./p/</code> folder.',	// TODO
		),
		'dom' => array(
			'nok' => 'DOMの操作に必要なライブラリが見つかりませんでした。',
			'ok' => 'DOMの操作に必要なライブラリが見つかりました。',
		),
		'favicons' => array(
			'nok' => '<em>%1$s</em>ディレクトリに対する<em>%2$s</em>ユーザーの権限を確認してください。HTTPサーバーには書き込み権限が必要です。',
			'ok' => 'faviconsディレクトリの権限は正しく設定されています。',
		),
		'fileinfo' => array(
			'nok' => 'PHP fileinfoライブラリが見つかりませんでした（fileinfoパッケージ）。',
			'ok' => 'fileinfoライブラリは正しく設定されています。',
		),
		'files' => 'ファイルインストール',
		'gmp' => array(
			'nok' => 'Cannot find the required GMP extension for 32-bit PHP (php-gmp package).',	// TODO
			'ok' => 'You have the GMP extension required for 32-bit PHP.',	// TODO
		),
		'intl' => array(
			'nok' => '多言語・地域対応用のphp-intlライブラリが見つかりませんでした。',
			'ok' => '多言語・地域対応用のphp-intlライブラリはインストールされています。',
		),
		'json' => array(
			'nok' => 'JSON解析ライブラリが見つかりませんでした。',
			'ok' => 'JSON解析ライブラリはインストールされています。',
		),
		'mbstring' => array(
			'nok' => 'mbstringライブラリが見つかりませんでした。',
			'ok' => 'mbstringライブラリはインストールされています。',
		),
		'pcre' => array(
			'nok' => '正規表現ライブラリが見つかりませんでした（php-pcre）。',
			'ok' => '正規表現ライブラリはインストールされています（PCRE）。',
		),
		'pdo-mysql' => array(
			'nok' => 'MySQL/MariaDBに必要なPDOドライバーが見つかりませんでした。',
		),
		'pdo-pgsql' => array(
			'nok' => 'PostgreSQLに必要なPDOドライバーが見つかりませんでした。',
		),
		'pdo-sqlite' => array(
			'nok' => 'SQLiteに必要なPDOドライバーが見つかりませんでした。',
			'ok' => 'SQLiteに必要なPDOドライバーはインストールされています。',
		),
		'pdo' => array(
			'nok' => 'PDOまたはサポートされているドライバーが見つかりませんでした（pdo_sqlite, pdo_pgsql, pdo_mysql）。',
			'ok' => 'PDOと、対応するドライバーのいずれかがインストールされています（pdo_sqlite、pdo_pgsql、pdo_mysql）。',
		),
		'php' => array(
			'_' => 'PHPインストール',
			'nok' => 'PHPのバージョンは%sですが、FreshRSSには%s以降が必要です。',
			'ok' => 'PHPのバージョン（%s）はFreshRSSに対応しています。',
		),
		'reload' => '再確認',
		'tmp' => array(
			'nok' => '<em>%1$s</em>ディレクトリに対する<em>%2$s</em>ユーザーの権限を確認してください。HTTPサーバーには書き込み権限が必要です。',
			'ok' => 'tempディレクトリの権限は正しく設定されています。',
		),
		'tokens' => array(
			'nok' => '<em>./data/tokens</em>ディレクトリの権限を確認してください。HTTPサーバーには書き込み権限が必要です。',
			'ok' => 'tokensディレクトリの権限は正しく設定されています。',
		),
		'unknown_process_username' => '不明',
		'users' => array(
			'nok' => '<em>%1$s</em>ディレクトリに対する<em>%2$s</em>ユーザーの権限を確認してください。HTTPサーバーには書き込み権限が必要です。',
			'ok' => 'usersディレクトリの権限は正しく設定されています。',
		),
		'xml' => array(
			'nok' => 'XML解析ライブラリが見つかりませんでした。',
			'ok' => 'XML解析ライブラリが見つかりました。',
		),
		'zip' => array(
			'nok' => 'ZIP拡張機能が見つかりませんでした（php-zipパッケージ）。',
			'ok' => 'ZIP拡張はインストールされています。',
		),
	),
	'conf' => array(
		'_' => '一般設定',
		'ok' => '一般設定を保存しました。',
	),
	'congratulations' => 'おめでとうございます！',
	'default_user' => array(
		'_' => 'デフォルトのユーザー名',
		'max_char' => '1-39 characters: letters, digits, and <code>. _ @ -</code>',	// TODO
	),
	'fix_errors_before' => '次のステップへ移る前にエラーを修正してください。',
	'javascript_is_better' => 'JavaScriptを有効にすると、FreshRSSをより快適に利用できます。',
	'js' => array(
		'confirm_reinstall' => '再インストールするとFreshRSSの設定が削除されます。続行しますか？',
	),
	'language' => array(
		'_' => '言語',
		'choose' => 'FreshRSSで使用する言語を選択してください',
		'defined' => '言語を設定しました。',
	),
	'missing_applied_migrations' => '問題が発生しました。空のファイル<em>%s</em>を手動で作成してください。',
	'ok' => 'インストールに成功しました。',
	'session' => array(
		'nok' => 'PHPセッションに必要なCookieについて、Webサーバーの設定に問題があるようです。',
	),
	'step' => 'ステップ %d',
	'steps' => 'ステップ',
	'this_is_the_end' => '完了',
	'title' => 'FreshRSSのインストール',
);

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
		'finish' => 'インストール作業を終わりにする',
		'fix_errors_before' => '次のステップへ移る前にエラーを修正してください。',
		'keep_install' => '前の設定を保持する',
		'next_step' => '次のステップへ進む',
		'reinstall' => 'FreshRSSを再インストールする',
	),
	'auth' => array(
		'form' => 'Webフォーム (Javascriptが必要です)',
		'http' => 'HTTP (上級者向けのHTTPS)',
		'none' => 'なし (危険)',
		'password_form' => 'パスワード<br /><small>(fWeb-formログインメソッド)</small>',
		'password_format' => '最低限7文字必要です',
		'type' => '認証メソッド',
	),
	'bdd' => array(
		'_' => 'データベース',
		'conf' => array(
			'_' => 'データベース設定',
			'ko' => 'あなたのデータベース設定を確認します。',
			'ok' => 'データベース設定は保存されました。',
		),
		'host' => 'ホスト',
		'password' => 'データベースパスワード',
		'prefix' => 'テーブルプレフィックス',
		'type' => 'データベースの型',
		'username' => 'データベースのユーザー名',
	),
	'check' => array(
		'_' => '環境確認',
		'already_installed' => 'FreshRSS が、すでにインストールされています!',
		'cache' => array(
			'nok' => ' <em>%1$s</em> ディレクトリ <em>%2$s</em> ユーザーのアクセス権限を確認してください。HTTPサーバーを書き込むには権限が必要です。',
			'ok' => 'キャッシュディレクトリの権限は正しく設定されています。',
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
			'nok' => 'この <em>%1$s</em> ディレクトリの <em>%2$s</em> ユーザーのアクセス権限を確認してください。HTTPサーバーは編集権限を必要としています。',
			'ok' => 'ディレクトリのパーミッションは正しく設定されています。',
		),
		'dom' => array(
			'nok' => 'DOMを検索するライブラリが見つかりませんでした。',
			'ok' => 'DOMを検索するライブラリが見つかりました。',
		),
		'favicons' => array(
			'nok' => 'この <em>%1$s</em> ディレクトリの <em>%2$s</em> ユーザーのアクセス権限を確認してください。HTTPサーバーは編集権限を必要としています。',
			'ok' => 'ディレクトリのパーミッションは正しく設定されています。',
		),
		'fileinfo' => array(
			'nok' => 'PHP fileinfoライブラリが見つかりませんでした。 (fileinfo package).',
			'ok' => 'fileinfoライブラリは正しく設定されています。',
		),
		'json' => array(
			'nok' => 'JSONをパースするライブラリが見つかりませんでした。',
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
			'nok' => 'PDOまたはサポートされているドライバーが見つかりませんでした。 (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'PDOとサポートされているドライバーはインストールされています。 (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'あなたのPHPのバージョンは %s ですが、FreshRSSが動作する最低限のバージョンは %s です。',
			'ok' => 'あなたのPHPのバージョンは、 %s でFreshRSSと互換性があるバージョンです。',
		),
		'reload' => '再度確かめる',
		'tmp' => array(
			'nok' => 'この <em>%1$s</em> ディレクトリの <em>%2$s</em> ユーザーのアクセス権限を確認してください。HTTPサーバーは編集権限を必要としています。',
			'ok' => 'tempディレクトリの権限は正しく設定されています。',
		),
		'unknown_process_username' => '不明',
		'users' => array(
			'nok' => 'この <em>%1$s</em> ディレクトリの <em>%2$s</em> ユーザーのアクセス権限を確認してください。 HTTPサーバーは編集権限を必要としています。',
			'ok' => 'usersディレクトリの権限は正しく設定されています。',
		),
		'xml' => array(
			'nok' => 'XMLをパースするライブラリが見つかりませんでした。',
			'ok' => 'XMLをパースするライブラリが見つかりました。',
		),
	),
	'conf' => array(
		'_' => '一般設定',
		'ok' => '一般設定は保存されました。',
	),
	'congratulations' => 'おめでとうございます!',
	'default_user' => array(
		'_' => 'デフォルトのユーザー名',
		'max_char' => '最大16文字の英数字',
	),
	'fix_errors_before' => 'エラーを次のステップへ移る前に修正してください。',
	'javascript_is_better' => 'FreshRSS はJavascriptが有効だとより快適にご利用いただけます。',
	'js' => array(
		'confirm_reinstall' => 'もし再インストールするとFreshRSSの設定は削除されます。それでも続けますか?',
	),
	'language' => array(
		'_' => '言語',
		'choose' => 'FreshRSSで使う言語を選んでください',
		'defined' => '言語の設定ができました。',
	),
	'missing_applied_migrations' => '何かが誤っています; 空のファイルを手動で作ることができます <em>%s</em>',
	'ok' => 'インストール作業は成功しました。',
	'session' => array(
		'nok' => 'Webサーバーは、不正な設定がされておりPHPセッションが必要とされているクッキーの設定が誤っています!',
	),
	'step' => 'ステップ %d',
	'steps' => 'ステップ',
	'this_is_the_end' => '終了',
	'title' => 'インストール · FreshRSS',
);

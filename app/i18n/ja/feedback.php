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
	'access' => array(
		'denied' => 'このページにアクセスする権限がありません。',
		'not_found' => 'お探しのページは見つかりませんでした。',
	),
	'admin' => array(
		'optimization_complete' => '最適化が完了しました',
	),
	'api' => array(
		'password' => array(
			'failed' => 'パスワードは変更できませんでした',
			'updated' => 'パスワードは変更されました',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'ログインできませんでした',
			'success' => 'ログインしました',
		),
		'logout' => array(
			'success' => 'ログアウトしました',
		),
	),
	'conf' => array(
		'error' => '設定の保存中にエラーが発生しました。',
		'query_created' => 'クエリ「%s」を作成しました。',
		'shortcuts_updated' => 'ショートカットを更新しました。',
		'updated' => '設定が更新されました。',
	),
	'extensions' => array(
		'already_enabled' => '「%s」はすでに有効です',
		'cannot_remove' => '「%s」は削除できません',
		'disable' => array(
			'ko' => '「%s」を無効にできません。詳細は<a href="%s">FreshRSSのログ</a>を確認してください。',
			'ok' => '「%s」は無効になっています。',
		),
		'enable' => array(
			'ko' => '%sを有効にできません。詳細は<a href="%s">FreshRSSのログ</a>を確認してください。',
			'ok' => '%sは有効です。',
		),
		'invalid_view_mode' => '無効なビューモード「%s」です。ノーマルビューに戻します。',
		'no_access' => '%sにアクセスする権限がありません',
		'not_enabled' => '%sは有効ではありません',
		'not_found' => '%sが見つかりませんでした',
		'removed' => '%sは削除されました',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'ZIP拡張機能がサーバーに存在しません。ファイルを個別にエクスポートしてください。',
		'feeds_imported' => 'フィードがインポートされました。インポートが完了したら<i>フィードを更新する</i>ボタンをクリックしてください。',
		'feeds_imported_with_errors' => 'フィードをインポートしましたが、一部でエラーが発生しました。インポートが完了したら<i>フィードを更新する</i>ボタンをクリックしてください。',
		'file_cannot_be_uploaded' => 'ファイルをアップロードできません',
		'no_zip_extension' => 'ZIP拡張機能がサーバーに存在しません。',
		'zip_error' => 'ZIPの処理中にエラーが発生しました。',
	),
	'profile' => array(
		'error' => 'プロフィールを変更できません',
		'passwords_dont_match' => 'パスワードが一致しません',
		'updated' => 'プロフィールが更新されました',
	),
	'sub' => array(
		'actualize' => '更新中',
		'articles' => array(
			'marked_read' => '選択した記事を既読にしました',
			'marked_unread' => '選択した記事を未読にしました',
		),
		'category' => array(
			'created' => 'カテゴリ「%s」を作成しました',
			'deleted' => 'カテゴリ「%s」を削除しました',
			'emptied' => 'カテゴリ「%s」を空にしました',
			'error' => 'カテゴリを更新できません',
			'name_exists' => '同名のカテゴリが既に存在します',
			'no_id' => 'カテゴリIDを指定する必要があります',
			'no_name' => 'カテゴリ名は空にできません',
			'not_delete_default' => 'デフォルトカテゴリは消去できません',
			'not_exist' => 'カテゴリが存在しません',
			'over_max' => 'カテゴリ数の上限（%d）に達しました',
			'updated' => 'カテゴリが更新されました',
		),
		'feed' => array(
			'actualized' => '<em>%s</em>は更新されました',
			'actualizeds' => 'RSSフィードは更新されました',
			'added' => 'RSSフィード<em>%s</em>が追加されました',
			'already_subscribed' => 'すでに<em>%s</em>を購読しています',
			'cache_cleared' => '<em>%s</em>のキャッシュを消去しました',
			'deleted' => 'フィードを削除しました',
			'error' => 'フィードを更新できません',
			'favicon' => array(
				'too_large' => 'アップロードしたアイコンサイズが大きすぎます。上限は <em>%s</em> です。',
				'unsupported_format' => '対応していない画像ファイル形式です',
			),
			'internal_problem' => 'ニュースフィードを追加できませんでした。詳細は<a href="%s">FreshRSSのログ</a>を確認してください。URLの末尾に<code>#force_feed</code>を追加すると強制的に追加できます。',
			'invalid_url' => 'URL <em>%s</em>は無効です',
			'n_actualized' => '%d件のフィードを更新しました',
			'n_entries_deleted' => '%d件の記事を削除しました',
			'no_refresh' => '更新するフィードがありません',
			'not_added' => '<em>%s</em> は追加できません',
			'not_found' => 'フィードが見つかりませんでした',
			'over_max' => 'フィード数の上限（%d）に達しました',
			'reloaded' => '<em>%s</em> は再読み込みされました',
			'selector_preview' => array(
				'http_error' => 'Webサイトの読み込みに失敗しました',
				'no_entries' => 'このフィードには記事がありません。プレビューを作成するには少なくとも1件の記事が必要です。',
				'no_feed' => '内部エラー（フィードが見つかりませんでした）。',
				'no_result' => '一致するものがありませんでした。代わりに元のフィード本文を表示します。', // DIRTY
				'selector_empty' => 'セレクターが空です。プレビューを作成するにはセレクターを指定してください。', // DIRTY
			),
			'updated' => 'フィードを更新しました。',
		),
		'purge_completed' => '不要データの削除が完了しました（%d件の記事を削除しました）', // DIRTY
	),
	'tag' => array(
		'created' => 'ラベル「%s」を作成しました',
		'error' => 'ラベルを更新できませんでした',
		'name_exists' => 'このラベル名は既に存在します',
		'renamed' => 'ラベル「%s」の名前を「%s」に変更しました', // DIRTY
		'updated' => 'ラベルが更新されました',
	),
	'update' => array(
		'can_apply' => 'FreshRSSは<strong>バージョン %s</strong>に更新されます。',
		'error' => 'アップデート中にエラーが発生しました：%s', // DIRTY
		'file_is_nok' => 'FreshRSSのアップデート（<strong>バージョン %s</strong>）を利用できますが、<em>%s</em>ディレクトリの権限を確認してください。HTTPサーバーに書き込み権限が必要です。', // DIRTY
		'finished' => 'アップデートが完了しました',
		'none' => '適用できるアップデートはありません',
		'server_not_found' => 'アップデートサーバーが見つかりません。[%s]', // DIRTY
	),
	'user' => array(
		'created' => array(
			'_' => '%ユーザー「%s」を作成しました', // DIRTY
			'error' => '%ユーザー「%s」を作成できません', // DIRTY
		),
		'deleted' => array(
			'_' => '%ユーザー「%s」を削除しました', // DIRTY
			'error' => ユーザー「%s」を削除できません', // DIRTY
		),
		'updated' => array(
			'_' => ユーザー「%s」を更新しました', // DIRTY
			'error' => ユーザー「%s」を更新できませんでした', // DIRTY
		),
	),
);

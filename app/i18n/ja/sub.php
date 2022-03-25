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
	'api' => array(
		'documentation' => '外部ツール内で使うURLをコピーします。',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'このボタンをブックマークツールバーへドラッグするか、右クリックして、「このリンクをブックマークする」を選択します。そうすることでどのページでも購読できるようになります。',
		'label' => '購読',
		'title' => 'ブックマーク',
	),
	'category' => array(
		'_' => 'カテゴリ',
		'add' => 'カテゴリを追加する',
		'archiving' => 'アーカイブ',
		'empty' => 'からのカテゴリ',
		'information' => 'インフォメーション',
		'position' => '表示位置',
		'position_help' => 'カテゴリの表示順を操作する',
		'title' => 'タイトル',
	),
	'feed' => array(
		'add' => 'RSSフィードに追加する',
		'advanced' => '応用的な設定',
		'archiving' => 'アーカイブ',
		'auth' => array(
			'configuration' => 'ログイン',
			'help' => 'RSSフィードへのHTTPアクセスを許可する',
			'http' => 'HTTP認証',
			'password' => 'HTTP パスワード',
			'username' => 'HTTP ユーザー名',
		),
		'clear_cache' => 'いつでもキャッシュをクリアする',
		'content_action' => array(
			'_' => '記事のコンテンツを読み出したとき、コンテンツアクションを実行する',
			'append' => '既に存在するコンテンツの後に追加する',
			'prepend' => '既に存在するコンテンツの前に追加する',
			'replace' => '既に存在するコンテンツを置換する',
		),
		'css_cookie' => '記事のコンテンツを読み出したとき、クッキーを使用する',
		'css_cookie_help' => '例: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'あきらめられたRSSフィードを取得します (注意してください、より多くの時間が必要になるでしょう!)',
		'css_path' => '元のwebサイトの記事のCSS',
		'description' => '説明',
		'empty' => 'このフィードは空です。運営されているかどうかを確認してみてください。',
		'error' => 'このフィードに問題が発生しました。ここにいつでもアクセスできるかどうかを確認して更新してみてください。',
		'filteractions' => array(
			'_' => 'フィルターアクション',
			'help' => '1行に1つの検索フィルターを設定してください',
		),
		'information' => 'インフォメーション',
		'keep_min' => '最小数の記事は保持されます',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web scraping)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>//title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> is a standard query language for advanced users, and which FreshRSS supports to enable Web scraping.',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'Example: <code>//div[@class="news-item"]</code>',	// TODO
				),
				'item_author' => array(
					'_' => 'item author',	// TODO
					'help' => 'Can also be a static string. Example: <code>"Anonymous"</code>',	// TODO
				),
				'item_categories' => 'items tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Example to take the full item: <code>.</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>descendant::img/@src</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => array(
					'_' => 'item title',	// TODO
					'help' => 'Use in particular the <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath axis</a> <code>descendant::</code> like <code>descendant::h2</code>',	// TODO
				),
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>descendant::a/@href</code>',	// TODO
				),
				'relative' => 'XPath (relative to item) for:',	// TODO
				'xpath' => 'XPath for:',	// TODO
			),
			'rss' => 'RSS / Atom (default)',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => 'キャッシュのクリア',
			'clear_cache_help' => 'このフィードのキャッシュをクリアします。',
			'reload_articles' => '記事を再読み込みする',
			'reload_articles_help' => '記事を再読み込みして、セレクターが定義したコンテンツを完全に取得します。',
			'title' => 'メンテナンス',
		),
		'moved_category_deleted' => 'カテゴリを削除したとき、フィードは自動的に<em>%s</em>下に分類されます。',
		'mute' => 'ミュート',
		'no_selected' => 'どのフィードも選択されていません',
		'number_entries' => '%d 記事数',
		'priority' => array(
			'_' => '表示する場所',
			'archived' => '非表示にする(アーカイブ)',
			'main_stream' => 'メインストリームで表示する',
			'normal' => 'カテゴリで表示する',
		),
		'proxy' => 'フィードを読み込み時にproxyを設定してください',
		'proxy_help' => 'プロトコルを選択し (例: SOCKS5) proxyアドレスを入力してください (例: <kbd>127.0.0.1:1080</kbd>)',
		'selector_preview' => array(
			'show_raw' => 'ソースコードを表示する',
			'show_rendered' => 'コンテンツを表示する',
		),
		'show' => array(
			'all' => 'すべてのフィードを表示する',
			'error' => 'エラーがあるフィードを表示する',
		),
		'showing' => array(
			'error' => 'エラーがあるフィードを表示する',
		),
		'ssl_verify' => 'SSL セキュリティを管理する',
		'stats' => '統計',
		'think_to_add' => 'あなたはフィードを追加できるでしょう。',
		'timeout' => 'タイムアウトする時間(秒)',
		'title' => 'タイトル',
		'title_add' => 'RSS フィードを追加する',
		'ttl' => '自動更新の頻度',
		'url' => 'フィードのURL',
		'useragent' => 'フィードを読み込む際のユーザーエージェントを設定してください',
		'useragent_help' => '例: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'フィードが有効であるかどうかを確認してください',
		'website' => 'WebサイトのURL',
		'websub' => 'WebSubとの即時通知',
	),
	'import_export' => array(
		'export' => 'エクスポート',
		'export_labelled' => 'ラベル付けされた記事をエクスポートする',
		'export_opml' => 'フィードリストをエクスポートする (OPML)',
		'export_starred' => 'お気に入りをエクスポートする',
		'feed_list' => '%s 記事のリスト',
		'file_to_import' => 'インポートするファイル<br />(OPML, JSON あるいは ZIP)',
		'file_to_import_no_zip' => 'インポートするファイル<br />(OPML あるいは JSON)',
		'import' => 'インポート',
		'starred_list' => 'お気に入りの記事',
		'title' => 'インポート / エクスポート',
	),
	'menu' => array(
		'add' => 'フィード化カテゴリを追加します',
		'import_export' => 'インポート / エクスポート',
		'label_management' => 'ラベル管理',
		'stats' => array(
			'idle' => '未使用のフィード',
			'main' => '主な統計',
			'repartition' => '記事の仕切り',
		),
		'subscription_management' => '購読されたものの管理',
		'subscription_tools' => '購読ツール',
	),
	'tag' => array(
		'name' => '名前',
		'new_name' => '新しい名前',
		'old_name' => '古い名前',
	),
	'title' => array(
		'_' => '購読されたものの管理',
		'add' => 'フィードあるいはカテゴリを追加します',
		'add_category' => 'カテゴリの追加',
		'add_feed' => 'フィードの追加',
		'add_label' => 'ラベルの追加',
		'delete_label' => 'ラベルの削除',
		'feed_management' => 'RSSフィードの管理',
		'rename_label' => 'ラベルの名前変更',
		'subscription_tools' => '購読ツール',
	),
);

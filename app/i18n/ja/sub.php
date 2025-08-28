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
		'dynamic_opml' => array(
			'_' => 'ダイナミックOPML',
			'help' => 'このカテゴリに動的フィードを追加するための<a href="http://opml.org/" target="_blank">OPMLファイル</a>のURLを指定します。',
		),
		'empty' => '空のカテゴリ',
		'expand' => 'カテゴリを展開する',
		'information' => 'インフォメーション',
		'open' => 'カテゴリを開く',
		'opml_url' => 'OPMLのURL',
		'position' => '表示位置',
		'position_help' => 'カテゴリの表示順を操作する',
		'title' => 'タイトル',
	),
	'feed' => array(
		'accept_cookies' => 'クッキーを受け入れる',
		'accept_cookies_help' => 'クッキーをこのサーバーから受け入れます(このリクエストだけにメモリへ保存されます)',
		'add' => 'フィードに追加する',
		'advanced' => '高度な設定',
		'archiving' => 'アーカイブ',
		'auth' => array(
			'configuration' => 'ログイン',
			'help' => 'RSSフィードへのHTTPアクセスを許可する',
			'http' => 'HTTP認証',
			'password' => 'HTTP パスワード',
			'username' => 'HTTP ユーザー名',
		),
		'change_favicon' => 'Change…',	// TODO
		'clear_cache' => '常にキャッシュをクリアする',
		'content_action' => array(
			'_' => '記事のコンテンツを取得するときの動作',
			'append' => '既に存在するコンテンツの後に追加する',
			'prepend' => '既に存在するコンテンツの前に追加する',
			'replace' => '既に存在するコンテンツを置換する',
		),
		'content_retrieval' => 'コンテンツ取得',
		'css_cookie' => '記事のコンテンツを取得するとき、クッキーを使用する',
		'css_cookie_help' => '例: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => '省略されたRSSフィードを復元します (ただし、時間がかかります)',
		'css_path' => '元のWebサイトから記事を抽出するCSSセレクタ',
		'css_path_filter' => array(
			'_' => '要素を削除するCSSセレクタ',
			'help' => 'CSSセレクタは次のようなリストです: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => '説明',
		'empty' => 'このフィードは空です。サイトが運営されているかどうかを確認してみてください。',
		'error' => 'このフィードで問題が発生しました。この状況が続く場合は、まだアクセスできるか確認してください。',
		'export-as-opml' => array(
			'download' => 'ダウンロード',
			'help' => 'XMLファイル (データのサブセット。<a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">ドキュメントを参照してください</a>。)',
			'label' => 'OPMLとしてエクスポート',
		),
		'ext_favicon' => 'Set automatically',	// TODO
		'favicon_changed_by_ext' => 'The icon has been set by the <b>%s</b> extension.',	// TODO
		'filteractions' => array(
			'_' => 'フィルターアクション',
			'help' => '1行に1つの検索フィルターを設定してください。演算子は<a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">ドキュメントを参照してください</a>。',
		),
		'http_headers' => 'HTTPヘッダ',
		'http_headers_help' => 'ヘッダは開業で区切られ、ヘッダの名前と値はコロンで区切られます (例: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',
		'icon' => 'Icon',	// TODO
		'information' => 'インフォメーション',
		'keep_min' => '最小数の記事は保持されます',
		'kind' => array(
			'_' => 'フィードソースの種類',
			'html_json' => array(
				'_' => 'HTML + XPath + JSONドット記法 (HTML内のJSON)',
				'xpath' => array(
					'_' => 'HTML内のJSONを指すXPath',
					'help' => '例: <code>normalize-space(//script[@type="application/json"])</code> (single JSON)<br />or: <code>//script[@type="application/ld+json"]</code> (one JSON object per article)',	// DIRTY
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (ウェブスクレイピング)',
				'feed_title' => array(
					'_' => 'フィードタイトル',
					'help' => '例: <code>//title</code> または文字列定数: <code>"カスタムフィード"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> は上級者向けのクエリ型言語で、FreshRSSでスクレイピングをサポートしている言語です。',
				'item' => array(
					'_' => 'ニュース<strong>項目</strong>を探す<br /><small>(最も重要)</small>',
					'help' => '例: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => '項目の著者',
					'help' => 'これもまた、文字定数が使えます。例: <code>"匿名"</code>',
				),
				'item_categories' => '項目のタグ',
				'item_content' => array(
					'_' => '項目のコンテンツ',
					'help' => 'すべての項目を取得する方法例: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => '項目のサムネイル',
					'help' => '例: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'カスタム日時フォーマット',
					'help' => 'オプションです。<a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>でサポートされている書式で、<code>d-m-Y H:i:s</code>のように指定します',
				),
				'item_timestamp' => array(
					'_' => '項目の日付',
					'help' => '結果は<a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>で解析されます',
				),
				'item_title' => array(
					'_' => '項目のタイトル',
					'help' => '特に<a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath Axis</a>の <code>descendant::</code> を <code>descendant::h2</code> のように使います',
				),
				'item_uid' => array(
					'_' => '項目のユニークID',
					'help' => 'オプションです。例: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => '項目のリンク(URL)',
					'help' => '例: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (項目からの相対パス):',
				'xpath' => 'XPath:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON（ドット記法）',
				'feed_title' => array(
					'_' => 'フィード名',
					'help' => '例: <code>meta.title</code> または静的文字列: <code>"My custom feed"</code>',
				),
				'help' => 'JSONのドット記法は、オブジェクトの間にドットを使用し、配列には括弧を使用します。例: <code>data.items[0].title</code>',
				'item' => array(
					'_' => 'ニュース<strong>項目</strong>を探す<br /><small>(最重要)</small>',
					'help' => '項目を含む配列へのJSONパス。 例: <code>$</code> or <code>newsItems</code>',
				),
				'item_author' => '項目の著者',
				'item_categories' => '項目のタグ',
				'item_content' => array(
					'_' => '項目のコンテンツ',
					'help' => 'コンテンツが存在するキー。例: <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => '項目のサムネイル',
					'help' => '例: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'カスタム日時フォーマット',
					'help' => 'オプションです。<a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>でサポートされている書式で、<code>d-m-Y H:i:s</code>のように指定します',
				),
				'item_timestamp' => array(
					'_' => '項目の日付',
					'help' => '結果は<a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>で解析されます',
				),
				'item_title' => '項目のタイトル',
				'item_uid' => '項目のユニークID',
				'item_uri' => array(
					'_' => '項目のリンク（URL）',
					'help' => '例: <code>permalink</code>',
				),
				'json' => 'ドット記法:',
				'relative' => 'ドット記法（項目からの相対パス）:',
			),
			'jsonfeed' => 'JSONフィード',
			'rss' => 'RSS / Atom (標準)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'maintenance' => array(
			'clear_cache' => 'キャッシュのクリア',
			'clear_cache_help' => 'このフィードのキャッシュをクリアします。',
			'reload_articles' => '記事を再読み込みする',
			'reload_articles_help' => '指定した数の記事を再読み込みし、セレクターが定義されていればコンテンツを完全に取得します。',
			'title' => 'メンテナンス',
		),
		'max_http_redir' => 'HTTPのリダイレクトの上限',
		'max_http_redir_help' => '0を設定するか、空白のままにすると無効になり、-1を設定するとリダイレクト数が無制限になります。',
		'method' => array(
			'_' => 'HTTPメソッド',
		),
		'method_help' => 'POSTペイロードは <code>application/x-www-form-urlencoded</code> と <code>application/json</code> を自動的にサポートしています',
		'method_postparams' => 'POST用ペイロード',
		'moved_category_deleted' => 'カテゴリを削除したとき、フィードは自動的に<em>%s</em>下に分類されます。',
		'mute' => array(
			'_' => 'ミュート',
			'state_is_muted' => 'このフィードはミュートです',
		),
		'no_selected' => 'どのフィードも選択されていません',
		'number_entries' => '%d 記事数',
		'open_feed' => 'フィードを開く %s',
		'path_entries_conditions' => 'コンテンツを取得する条件',
		'priority' => array(
			'_' => '表示する場所',
			'archived' => '非表示にする(アーカイブ)',
			'category' => 'カテゴリで表示する',
			'important' => '重要なフィードに表示する',
			'main_stream' => 'メインストリームで表示する',
		),
		'proxy' => 'フィードを取得するときのプロキシ',
		'proxy_help' => 'プロトコルを選択し (例: SOCKS5) プロキシアドレスを入力してください (例: <kbd>127.0.0.1:1080</kbd> や <kbd>username:password@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'Reset to default',	// TODO
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
		'think_to_add' => 'フィードを追加できます。',
		'timeout' => 'タイムアウトする時間(秒)',
		'title' => 'タイトル',
		'title_add' => 'RSS フィードを追加する',
		'ttl' => '自動更新の頻度',
		'unicityCriteria' => array(
			'_' => '記事の同一判定',
			'forced' => '<span title="フィードに重複した記事が存在しても、同一判定を抑制します">強制する</span>',
			'help' => '不正なフィードに対処します。<br />⚠️ ポリシーを変更すると重複が発生します。',
			'id' => '標準的なID (デフォルト)',
			'link' => 'リンク',
			'sha1:content' => 'Content',	// TODO
			'sha1:content_published' => 'Content + Date',	// TODO
			'sha1:link_published' => 'リンク + 日付',
			'sha1:link_published_title' => 'リンク + 日付 + タイトル',
			'sha1:link_published_title_content' => 'リンク + 日付 + タイトル + コンテンツ',
			'sha1:published' => 'Date',	// TODO
			'sha1:title' => 'Title',	// TODO
			'sha1:title_published' => 'Title + Date',	// TODO
			'sha1:title_published_content' => 'Title + Date + Content',	// TODO
		),
		'url' => 'フィードのURL',
		'useragent' => 'フィードを取得するときのユーザーエージェント',
		'useragent_help' => '例: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'フィードが有効であるかどうかを確認してください',
		'website' => 'WebサイトのURL',
		'websub' => 'WebSubとの即時通知',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'エクスポート',
			'sqlite' => 'ユーザーデータベースをSQLiteとしてダウンロードする',
		),
		'export_labelled' => 'ラベル付けされた記事をエクスポートする',
		'export_opml' => 'フィードリストをエクスポートする (OPML)',
		'export_starred' => 'お気に入りをエクスポートする',
		'feed_list' => '%s 記事のリスト',
		'file_to_import' => 'インポートするファイル<br />(OPML, JSON または ZIP)',
		'file_to_import_no_zip' => 'インポートするファイル<br />(OPML または JSON)',
		'import' => 'インポート',
		'starred_list' => 'お気に入りの記事',
		'title' => 'インポート / エクスポート',
	),
	'menu' => array(
		'add' => 'フィードやカテゴリを追加',
		'import_export' => 'インポート / エクスポート',
		'label_management' => 'ラベル管理',
		'stats' => array(
			'idle' => '休止中のフィード',
			'main' => '主な統計',
			'repartition' => '記事の割合',
		),
		'subscription_management' => '購読フィードの管理',
		'subscription_tools' => '購読ツール',
	),
	'tag' => array(
		'auto_label' => 'このラベルを新しい記事に追加する',
		'name' => '名前',
		'new_name' => '新しい名前',
		'old_name' => '古い名前',
	),
	'title' => array(
		'_' => '購読フィードの管理',
		'add' => 'フィードやカテゴリを追加',
		'add_category' => 'カテゴリの追加',
		'add_dynamic_opml' => '動的なOPMLを追加する',
		'add_feed' => 'フィードの追加',
		'add_label' => 'ラベルの追加',
		'add_opml_category' => 'OPMLカテゴリ名',
		'delete_label' => 'ラベルの削除',
		'feed_management' => 'RSSフィードの管理',
		'rename_label' => 'ラベルの名前変更',
		'subscription_tools' => '購読ツール',
	),
);

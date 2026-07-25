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
	'api' => array(
		'documentation' => '外部ツール内で使うURLをコピーします。',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'このボタンをブックマークツールバーにドラッグするか、右クリックして「このリンクをブックマーク」を選択してください。その後、購読したいページで「購読」ボタンをクリックします。',
		'label' => '購読',
		'title' => 'ブックマーク',
	),
	'category' => array(
		'_' => 'カテゴリ',
		'add' => 'カテゴリを追加する',
		'archiving' => 'アーカイブ',
		'dynamic_opml' => array(
			'_' => '動的OPML',
			'help' => 'このカテゴリに動的フィードを追加するための<a href="http://opml.org/" target="_blank">OPMLファイル</a>のURLを指定します。',
		),
		'empty' => '空のカテゴリ',
		'error' => '動的OPMLカテゴリで問題が発生しました。OPMLのURLに引き続きアクセスできることと、ユーザーごとの最大フィード数を超えていないことを確認してください。',
		'expand' => 'カテゴリを展開する',
		'information' => '情報',
		'open' => 'カテゴリを開く',
		'opml_url' => 'OPMLのURL',
		'position' => '表示位置',
		'position_help' => 'カテゴリの表示順を指定します',
		'title' => 'タイトル',
	),
	'feed' => array(
		'accept_cookies' => 'クッキーを受け入れる',
		'accept_cookies_help' => 'フィードサーバーからのクッキーを受け入れます（クッキーはこのリクエスト中のみメモリに保存されます）',
		'add' => 'フィードを追加する',
		'advanced' => '高度な設定',
		'archiving' => 'アーカイブ',
		'auth' => array(
			'configuration' => '認証情報',
			'help' => 'HTTP認証で保護されたRSSフィードへのアクセスを許可します',
			'http' => 'HTTP認証',
			'password' => 'HTTPパスワード',
			'username' => 'HTTPユーザー名',
		),
		'change_favicon' => '変更…',
		'clear_cache' => '常にキャッシュをクリアする',
		'content_action' => array(
			'_' => '記事の本文を取得するときの動作',
			'append' => '既に存在する本文の後に追加する',
			'prepend' => '既に存在する本文の前に追加する',
			'replace' => '既に存在する本文を置換する',
		),
		'content_retrieval' => '本文取得',
		'css_cookie' => '記事の本文を取得するとき、クッキーを使用する',
		'css_cookie_help' => '例：<kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => '省略された記事本文を取得します（時間がかかります）',
		'css_path' => '元のWebサイトから記事を抽出するCSSセレクタ',
		'css_path_filter' => array(
			'_' => '要素を削除するCSSセレクタ',
			'help' => 'CSSセレクタは次のようなリストです：<kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => '説明',
		'empty' => 'このフィードは空です。配信元サイトが現在も運営されているか確認してください。',
		'error' => 'このフィードで問題が発生しました。この状況が続く場合は、まだアクセスできるか確認してください。',
		'export-as-opml' => array(
			'download' => 'ダウンロード',
			'help' => 'XMLファイル（データのサブセット。<a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">ドキュメントを参照</a>）',
			'label' => 'OPMLとしてエクスポート',
		),
		'ext_favicon' => '自動設定',
		'favicon_changed_by_ext' => '<b>%s</b>拡張機能によってアイコンが設定されました。',
		'filteractions' => array(
			'_' => 'フィルターアクション',
			'help' => '1行に1つの検索フィルターを設定してください。演算子は<a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">ドキュメントを参照してください</a>。',
			'view_filter' => '既存の記事でフィルターをプレビュー（新しいウィンドウ）',
		),
		'global_hint' => 'Use <a href="%s">the global view</a> to see how many articles in each feed are matching a state or a search expression',	// TODO
		'http_headers' => 'HTTPヘッダ',
		'http_headers_help' => 'ヘッダは改行で区切られ、ヘッダの名前と値はコロンで区切られます（例：<kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>）。',
		'icon' => 'アイコン',
		'information' => '情報',
		'keep_adding_feed' => '続けてフィードを追加',
		'keep_min' => '保持する記事数の下限',
		'kind' => array(
			'_' => 'フィードソースの種類',
			'html_json' => array(
				'_' => 'HTML + XPath + JSONドット記法（HTML内のJSON）',
				'xpath' => array(
					'_' => 'HTML内のJSONを指すXPath',
					'help' => '例：<code>normalize-space(//script[@type="application/json"])</code>（単一のJSON）<br />または：<code>//script[@type="application/ld+json"]</code>（記事ごとに1つのJSONオブジェクト）',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath（ウェブスクレイピング）',
				'feed_title' => array(
					'_' => 'フィードタイトル',
					'help' => '例：<code>//title</code> または文字列定数：<code>"カスタムフィード"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> は上級者向けのクエリ型言語で、FreshRSSでスクレイピングをサポートしている言語です。',
				'item' => array(
					'_' => 'ニュースの<strong>項目</strong>を検索する<br /><small>（最も重要）</small>',
					'help' => '例：<code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => '著者',
					'help' => '固定文字定数も使用できます。例：<code>"匿名"</code>',
				),
				'item_categories' => 'タグ',
				'item_content' => array(
					'_' => '本文',
					'help' => 'すべての項目を取得する方法例：<code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'サムネイル',
					'help' => '例：<code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'カスタム日時フォーマット',
					'help' => 'オプションです。<a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>でサポートされている書式で、<code>d-m-Y H:i:s</code>のように指定します',
				),
				'item_timestamp' => array(
					'_' => '日時',
					'help' => '結果は<a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>で解析されます',
				),
				'item_title' => array(
					'_' => 'タイトル',
					'help' => '特に<a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath Axis</a>の <code>descendant::</code> を <code>descendant::h2</code> のように使います',
				),
				'item_uid' => array(
					'_' => 'ユニークID',
					'help' => 'オプションです。例：<code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'リンク（URL）',
					'help' => '例：<code>descendant::a/@href</code>',
				),
				'relative' => 'XPath（項目からの相対パス）：',
				'xpath' => 'XPath:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON（ドット記法）',
				'feed_title' => array(
					'_' => 'フィード名',
					'help' => '例：<code>meta.title</code>、または固定文字列：<code>"カスタムフィード"</code>',
				),
				'help' => 'JSONのドット記法は、オブジェクトの間にドットを使用し、配列には括弧を使用します。例：<code>data.items[0].title</code>',
				'item' => array(
					'_' => 'ニュース<strong>項目</strong>を探す<br /><small>（最重要）</small>',
					'help' => '項目を含む配列へのJSONパス。例：<code>$</code>または<code>newsItems</code>',
				),
				'item_author' => '項目の著者',
				'item_categories' => '項目のタグ',
				'item_content' => array(
					'_' => '本文',
					'help' => '本文が存在するキー。例：<code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'サムネイル',
					'help' => '例：<code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'カスタム日時フォーマット',
					'help' => 'オプションです。<a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a>でサポートされている書式で、<code>d-m-Y H:i:s</code>のように指定します',
				),
				'item_timestamp' => array(
					'_' => '日時',
					'help' => '結果は<a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>で解析されます',
				),
				'item_title' => 'タイトル',
				'item_uid' => 'ユニークID',
				'item_uri' => array(
					'_' => 'リンク（URL）',
					'help' => '例：<code>permalink</code>',
				),
				'json' => 'ドット記法：',
				'relative' => 'ドット記法（項目からの相対パス）：',
			),
			'jsonfeed' => 'JSONフィード',
			'rss' => 'RSS／Atom（標準）',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'last-entry-publication-date' => '最新記事の公開日時：<time datetime="%1$s" title="%1$s">%2$s</time>。',
		'last-entry-received-date' => '最新記事の受信日時：<time datetime="%1$s" title="%1$s">%2$s</time>。',
		'last-error-date' => '最後に更新エラーが発生した日時：<time datetime="%1$s" title="%1$s">%2$s</time>。',
		'last-update' => '最後に正常に更新した日時：<time datetime="%1$s" title="%1$s">%2$s</time>。',
		'maintenance' => array(
			'clear_cache' => 'キャッシュのクリア',
			'clear_cache_help' => 'フィードのキャッシュをクリアします。',
			'reload_articles' => '記事を再読み込みする',
			'reload_articles_help' => '指定した数の記事を再読み込みし、セレクターが定義されていればコンテンツを完全に取得します。',
			'title' => 'メンテナンス',
		),
		'max_http_redir' => 'HTTPリダイレクト数の上限',
		'max_http_redir_help' => '0を設定するか、空白のままにすると無効になり、-1を設定するとリダイレクト数が無制限になります。',
		'method' => array(
			'_' => 'HTTPメソッド',
		),
		'method_help' => 'POSTペイロードでは<code>application/x-www-form-urlencoded</code>と<code>application/json</code>が自動的にサポートされます',
		'method_postparams' => 'POST用ペイロード',
		'moved_category_deleted' => 'カテゴリを削除すると、そのフィードは自動的に<em>%s</em>へ移動します。',
		'mute' => array(
			'_' => 'ミュート',
			'state_is_muted' => 'このフィードはミュートされています',
		),
		'no_selected' => 'どのフィードも選択されていません',
		'number_entries' => '記事数：%d件',
		'open_feed' => 'フィード「%s」を開く',
		'path_entries_conditions' => 'コンテンツを取得する条件',
		'priority' => array(
			'_' => '表示範囲',
			'category' => 'カテゴリで表示',
			'feed' => 'フィード内に表示',
			'hidden' => '非表示',
			'important' => '重要なフィードに表示',
			'main_stream' => 'メインストリームで表示',
		),
		'proxy' => 'フィードを取得するときのプロキシ',
		'proxy_help' => 'プロトコルを選択し（例：SOCKS5）プロキシアドレスを入力してください（例：<kbd>127.0.0.1:1080</kbd> や <kbd>username:password@127.0.0.1:1080</kbd>）',
		'reset_favicon' => 'デフォルトに戻す',
		'selector_preview' => array(
			'show_raw' => 'ソースコードを表示する',
			'show_rendered' => 'コンテンツを表示する',
		),
		'show' => array(
			'all' => 'すべてのフィードを表示する',
			'error' => 'エラーが発生しているフィードを表示する',
		),
		'showing' => array(
			'error' => 'エラーが発生しているフィードのみを表示しています',
		),
		'ssl_verify' => 'SSL証明書を検証する',
		'stats' => '統計',
		'think_to_add' => 'フィードを追加してみましょう。',
		'timeout' => 'タイムアウトする時間（秒）',
		'title' => 'タイトル',
		'title_add' => 'RSSフィードを追加する',
		'ttl' => '自動更新の頻度',
		'unicityCriteria' => array(
			'_' => '記事の重複判定基準',
			'forced' => '<span title="重複記事が存在しても、選択した重複判定基準を自動変更しません">選択した基準を固定する</span>',
			'help' => '仕様に準拠していないフィードへの対処に使用します。<br />⚠️ 基準を変更すると重複記事が作成される可能性があります。',
			'id' => '標準ID（デフォルト）',
			'link' => 'リンク',
			'sha1:content' => '本文',
			'sha1:content_published' => '本文 + 公開日時',
			'sha1:link_published' => 'リンク + 公開日時',
			'sha1:link_published_title' => 'リンク + 公開日時 + タイトル',
			'sha1:link_published_title_content' => 'リンク + 公開日時 + タイトル + 本文',
			'sha1:published' => '公開日時',
			'sha1:title' => 'タイトル',
			'sha1:title_published' => 'タイトル + 公開日時',
			'sha1:title_published_content' => 'タイトル + 公開日時 + 本文',
		),
		'url' => 'フィードのURL',
		'useragent' => 'フィードを取得する際のユーザーエージェント',
		'useragent_help' => '例：<kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'フィードが有効かどうかを確認する',
		'website' => 'WebサイトのURL',
		'websub' => 'WebSubとの即時通知',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'エクスポート',
			'sqlite' => 'ユーザーデータベースをSQLiteとしてダウンロードする',
		),
		'export_labelled' => 'ラベル付けされた記事をエクスポートする',
		'export_opml' => 'フィードリストをエクスポートする（OPML）',
		'export_starred' => 'お気に入りをエクスポートする',
		'feed_list' => '%s 記事のリスト',
		'file_to_import' => 'インポートするファイル<br />（OPML, JSON または ZIP）',
		'file_to_import_no_zip' => 'インポートするファイル<br />（OPML または JSON）',
		'import' => 'インポート',
		'starred_list' => 'お気に入りの記事',
		'title' => 'インポート・エクスポート',
	),
	'menu' => array(
		'add' => 'フィードやカテゴリを追加',
		'import_export' => 'インポート・エクスポート',
		'label_management' => 'ラベル管理',
		'stats' => array(
			'idle' => '休止中のフィード',
			'main' => '主な統計',
			'repartition' => '記事の割合',
			'unread_dates' => '未読記事数が多い日付',
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
		'add_dynamic_opml' => '動的OPMLを追加する',
		'add_feed' => 'フィードの追加',
		'add_label' => 'ラベルの追加',
		'add_opml_category' => 'OPMLカテゴリ名',
		'delete_label' => 'ラベルの削除',
		'feed_management' => 'RSSフィードの管理',
		'subscription_tools' => '購読ツール',
	),
);

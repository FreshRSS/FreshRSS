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
		'documentation' => '複製以下地址，以供外部工具使用',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => '拖動此書簽到你的書簽欄或者右鍵選擇「收藏此連結」，然後在你想要訂閱的頁面上點擊「訂閱」按鈕',
		'label' => '訂閱',
		'title' => '書簽應用',
	),
	'category' => array(
		'_' => '分類',
		'add' => '添加分類',
		'archiving' => '歸檔',
		'dynamic_opml' => array(
			'_' => '動態訂閱',
			'help' => '使用地址上的 <a href="http://opml.org/" target="_blank">OPML 文件</a> 中的訂閱源填充這一分類',
		),
		'empty' => '空分類',
		'information' => '信息',
		'opml_url' => 'OPML 地址',
		'position' => '顯示位置',
		'position_help' => '控制分類排列順序',
		'title' => '標題',
	),
	'feed' => array(
		'accept_cookies' => '接受 Cookies',
		'accept_cookies_help' => '允許提要伺服器設置 Cookies（僅在請求期間存儲在內存中）',
		'add' => '添加訂閱源',
		'advanced' => '高級',
		'archiving' => '歸檔',
		'auth' => array(
			'configuration' => '認證',
			'help' => '用於連接啟用 HTTP 認證的訂閱源',
			'http' => 'HTTP 認證',
			'password' => 'HTTP 密碼',
			'username' => 'HTTP 用戶名',
		),
		'clear_cache' => '總是清除暫存',
		'content_action' => array(
			'_' => '獲取原文後的操作',
			'append' => '添加在現有內容後部',
			'prepend' => '添加在現有內容前部',
			'replace' => '替換現有內容',
		),
		'css_cookie' => '獲取原文時的 Cookies',
		'css_cookie_help' => '例：<kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => '用於獲取全文（注意，這將耗費更多時間！）',
		'css_path' => '原文的 CSS 選擇器',
		'css_path_filter' => array(
			'_' => '需移除元素的 CSS 選擇器',
			'help' => '可設置多個 CSS 選擇器，例如：<kbd>.footer, .aside</kbd>',
		),
		'description' => '描述',
		'empty' => '此源為空。請確認它是否正常更新。',
		'error' => '此源遇到一些問題。請在確認是否能正常訪問後重試。',
		'filteractions' => array(
			'_' => '過濾動作',
			'help' => '每行寫一條過濾搜尋 Operators <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">see documentation</a>.',	// DIRTY
		),
		'information' => '信息',
		'keep_min' => '至少保存的文章數',
		'kind' => array(
			'_' => '訂閱源類型',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web 抓取)',
				'feed_title' => array(
					'_' => '提要標題',
					'help' => '如 <code>//title</code> 或是靜態字元串如 <code>"My custom feed"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> 是為資深用戶準備的標準查詢語言，FreshRSS 用以實現 Web 抓取.',
				'item' => array(
					'_' => '以尋找 <strong>文章</strong><br /><small>(很重要)</small>',
					'help' => '例如 <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => '文章作者',
					'help' => '可以是靜態字元串，例如 <code>"Anonymous"</code>',
				),
				'item_categories' => '文章標簽',
				'item_content' => array(
					'_' => '文章內容',
					'help' => '例如使用 <code>.</code> 將整個對象作為文章內容',
				),
				'item_thumbnail' => array(
					'_' => '文章縮圖',
					'help' => '例如 <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'Custom date/time format',	// TODO
					'help' => 'Optional. A format supported by <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> such as <code>d-m-Y H:i:s</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => '文章日期：',
					'help' => '結果將被 <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a> 解析',
				),
				'item_title' => array(
					'_' => '文章標題',
					'help' => '注意使用 <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath 軸</a> <code>descendant::</code>，例如 <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => '文章唯一標識',
					'help' => '可選，例如: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => '文章鏈接 (URL)',
					'help' => '例如 <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath（文章）：',
				'xpath' => 'XPath 定位：',
			),
			'json_dotpath' => array(
				'_' => 'JSON (Dotted paths)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>meta.title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => 'A JSON dotted path uses dots between objects and brackets for arrays (e.g. <code>data.items[0].title</code>)',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'JSON path to the array containing the items, e.g. <code>newsItems</code>',	// TODO
				),
				'item_author' => 'item author',	// TODO
				'item_categories' => 'item tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Key under which the content is found, e.g. <code>content</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>image</code>',	// TODO
				),
				'item_timeFormat' => array(
					'_' => 'Custom date/time format',	// TODO
					'help' => 'Optional. A format supported by <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> such as <code>d-m-Y H:i:s</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => 'item title',	// TODO
				'item_uid' => 'item unique ID',	// TODO
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>permalink</code>',	// TODO
				),
				'json' => 'Dotted Path for:',	// TODO
				'relative' => 'Dotted Path (relative to item) for:',	// TODO
			),
			'jsonfeed' => 'JSON Feed',	// TODO
			'rss' => 'RSS / Atom (默認)',
			'xml_xpath' => 'XML + XPath',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => '清理暫存',
			'clear_cache_help' => '清除該feed的暫存',
			'reload_articles' => '重載文章',
			'reload_articles_help' => '重載 n 篇文章並抓取內容（若設置了 CSS 選擇器）',
			'title' => '維護',
		),
		'max_http_redir' => '最大 HTTP 重定向',
		'max_http_redir_help' => '設置為 0 或留空以禁用，-1 表示無限重定向',
		'method' => array(
			'_' => 'HTTP Method',	// TODO
		),
		'method_help' => 'The POST payload has automatic support for <code>application/x-www-form-urlencoded</code> and <code>application/json</code>',	// TODO
		'method_postparams' => 'Payload for POST',	// TODO
		'moved_category_deleted' => '刪除分類時，其中的訂閱源會自動歸類到 <em>%s</em>',
		'mute' => '暫停',
		'no_selected' => '未選擇訂閱源',
		'number_entries' => '%d 篇文章',
		'priority' => array(
			'_' => '可見性',
			'archived' => '不顯示（歸檔）',
			'category' => '在分類中顯示',
			'important' => 'Show in important feeds',	// TODO
			'main_stream' => '在首頁中顯示',
		),
		'proxy' => '獲取訂閱源時的代理',
		'proxy_help' => '選擇協議（例：SOCKS5）和代理地址（例：<kbd>127.0.0.1:1080</kbd> or <kbd>username:password@127.0.0.1:1080</kbd>）',	// DIRTY
		'selector_preview' => array(
			'show_raw' => '顯示源碼',
			'show_rendered' => '顯示內容',
		),
		'show' => array(
			'all' => '顯示所有訂閱源',
			'error' => '僅顯示有錯誤的訂閱源',
		),
		'showing' => array(
			'error' => '正在顯示有錯誤的訂閱源',
		),
		'ssl_verify' => '驗證 SSL 證書安全',
		'stats' => '統計',
		'think_to_add' => '你可以添加一些訂閱源。',
		'timeout' => '超時時間（秒）',
		'title' => '標題',
		'title_add' => '添加訂閱源',
		'ttl' => '最小自動更新間隔',
		'url' => '源地址',
		'useragent' => '設置用於獲取此源的 User Agent',
		'useragent_help' => '例：<kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => '檢查訂閱源有效性',
		'website' => '網站地址',
		'websub' => 'WebSub 即時通知',
	),
	'import_export' => array(
		'export' => '導出',
		'export_labelled' => '導出有標簽的文章',
		'export_opml' => '導出訂閱源列表（OPML）',
		'export_starred' => '導出你的收藏',
		'feed_list' => '%s 文章列表',
		'file_to_import' => '需要導入的文件<br />（OPML、JSON 或 ZIP）',
		'file_to_import_no_zip' => '需要導入的文件<br />（OPML 或 JSON）',
		'import' => '導入',
		'starred_list' => '收藏文章列表',
		'title' => '導入/導出',
	),
	'menu' => array(
		'add' => '添加訂閱源或分類',
		'import_export' => '導入/導出',
		'label_management' => '標簽管理',
		'stats' => array(
			'idle' => '長期無更新訂閱源',
			'main' => '主要統計',
			'repartition' => '文章分布',
		),
		'subscription_management' => '訂閱管理',
		'subscription_tools' => '訂閱工具',
	),
	'tag' => array(
		'auto_label' => 'Add this label to new articles',	// TODO
		'name' => '名稱',
		'new_name' => '新名稱',
		'old_name' => '舊名稱',
	),
	'title' => array(
		'_' => '訂閱管理',
		'add' => '添加訂閱源或分類',
		'add_category' => '添加分類',
		'add_dynamic_opml' => '添加訂閱源動態列表',
		'add_feed' => '添加訂閱源',
		'add_label' => '添加標簽',
		'delete_label' => '刪除標簽',
		'feed_management' => '訂閱源管理',
		'rename_label' => '重命名標簽',
		'subscription_tools' => '訂閱工具',
	),
);

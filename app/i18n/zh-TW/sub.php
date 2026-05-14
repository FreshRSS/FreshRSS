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
		'documentation' => '複製下方的 URL 以供外部工具使用',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => '拖放此按鈕到您的書籤工具列或右鍵點擊它並選擇 "收藏此連結"。然後在您想要訂閱的任何頁面上點擊 "訂閱" 按鈕。',
		'label' => '訂閱',
		'title' => '書籤小程式',
	),
	'category' => array(
		'_' => '類別',
		'add' => '新增類別',
		'archiving' => '歸檔',
		'dynamic_opml' => array(
			'_' => '動態 OPML',
			'help' => '提供指向 <a href="http://opml.org/" target="_blank">OPML 檔案</a> 的 URL 以便動態地為此類別填充訂閱',
		),
		'empty' => '空類別',
		'error' => 'This dynamic OPML category has encountered a problem. Check that the OPML URL is still reachable and that the maximum number of feeds per user has not been exceeded.',	// TODO
		'expand' => '展開類別',
		'information' => '資訊',
		'open' => '開啟類別',
		'opml_url' => 'OPML URL',	// IGNORE
		'position' => '顯示位置',
		'position_help' => '用於控制類別排序',
		'title' => '標題',
	),
	'feed' => array(
		'accept_cookies' => '接受 Cookies',
		'accept_cookies_help' => '允許訂閱源伺服器設定 cookies (僅請求期間儲存在記憶體中)',
		'add' => '新增訂閱源',
		'advanced' => '進階',
		'archiving' => '歸檔',
		'auth' => array(
			'configuration' => '登入',
			'help' => '允許存取 HTTP 保護的 RSS 訂閱源',
			'http' => 'HTTP 身份驗證',
			'password' => 'HTTP 密碼',
			'username' => 'HTTP 使用者名稱',
		),
		'change_favicon' => '變更…',
		'clear_cache' => '總是清除快取',
		'content_action' => array(
			'_' => '取得文章內容後的動作',
			'append' => '新增在現有內容後面',
			'prepend' => '新增在現有內容前面',
			'replace' => '取代現有內容',
		),
		'content_retrieval' => 'Content retrieval',	// TODO
		'css_cookie' => '在取得文章內容時使用 Cookies',
		'css_cookie_help' => '範例: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => '取得截斷的 RSS 訂閱源 (請注意，會需要更多時間)',
		'css_path' => '原始網站上的文章 CSS 選擇器',
		'css_path_filter' => array(
			'_' => '用於移除元素的 CSS 選擇器',
			'help' => 'CSS 選擇器可以是清單，例如: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => '描述',
		'empty' => '此訂閱源是空的。請驗證其是否仍在維護。',
		'error' => '此訂閱源遇到問題。如果情況持續存在，請確認其是否仍然可存取。',
		'export-as-opml' => array(
			'download' => '下載',
			'help' => 'XML 檔案 (資料子集合<a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">請參閱說明文件</a>)',
			'label' => '匯出為 OPML',
		),
		'ext_favicon' => '自動設定',
		'favicon_changed_by_ext' => 'The icon has been set by the <b>%s</b> extension.',	// TODO
		'filteractions' => array(
			'_' => '過濾動作',
			'help' => '每行一個搜尋過濾器。運算子<a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">請參閱說明文件</a>。',
			'view_filter' => 'Preview filters on existing articles (new window)',	// TODO
		),
		'http_headers' => 'HTTP 標頭',
		'http_headers_help' => 'Headers are separated by a newline, and the name and value of a header are separated by a colon (e.g: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',	// TODO
		'icon' => '圖示',
		'information' => '資訊',
		'keep_adding_feed' => '繼續新增更多訂閱源',
		'keep_min' => '保留的最小文章數',
		'kind' => array(
			'_' => '訂閱源來源類型',
			'html_json' => array(
				'_' => 'HTML + XPath + JSON 點表示法 (HTML 中的 JSON)',
				'xpath' => array(
					'_' => 'XPath for JSON in HTML',	// TODO
					'help' => '範例: <code>normalize-space(//script[@type="application/json"])</code> (單個 JSON)<br />或者: <code>//script[@type="application/ld+json"]</code> (每篇文章一個 JSON 物件)',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web 抓取)',
				'feed_title' => array(
					'_' => '訂閱源標題',
					'help' => '範例: <code>//title</code> 或靜態字串: <code>"My custom feed"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> 是個適用於進階使用者的標準查詢語言，FreshRSS 支援它以啟用 Web 抓取',
				'item' => array(
					'_' => '尋找新聞 <strong>項目</strong><br /><small>(最重要)</small>',
					'help' => '範例: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => '項目作者',
					'help' => '也可以是個靜態字串。範例: <code>"Anonymous"</code>',
				),
				'item_categories' => '項目標籤',
				'item_content' => array(
					'_' => '項目內容',
					'help' => '例如使用 <code>.</code> 將整個對象作為文章內容',
				),
				'item_thumbnail' => array(
					'_' => '項目縮圖',
					'help' => '範例: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => '自訂日期/時間格式',
					'help' => '可選。被 <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> 支援的格式，例如 <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => '項目日期',
					'help' => '結果將被 <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a> 解析',
				),
				'item_title' => array(
					'_' => '項目標題',
					'help' => '注意使用 <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath 軸</a> <code>descendant::</code>，例如 <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => '項目唯一 ID',
					'help' => '可選。例如: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => '項目連結 (URL)',
					'help' => '範例: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (相對於項目) 用於:',
				'xpath' => 'XPath 用於:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (點表示法)',
				'feed_title' => array(
					'_' => '訂閱源標題',
					'help' => '範例: <code>meta.title</code> 或靜態字串: <code>"My custom feed"</code>',
				),
				'help' => 'A JSON dot notated uses dots between objects and brackets for arrays (e.g. <code>data.items[0].title</code>)',	// TODO
				'item' => array(
					'_' => '尋找新聞<strong>項目</strong><br /><small>(最重要的)</small>',
					'help' => 'JSON path to the array containing the items, e.g. <code>$</code> or <code>newsItems</code>',	// TODO
				),
				'item_author' => '項目作者',
				'item_categories' => '項目標籤',
				'item_content' => array(
					'_' => '項目內容',
					'help' => '可以在其下方找到內容的關鍵字，例如 <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => '項目縮圖',
					'help' => '範例: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => '自訂日期/時間格式',
					'help' => '可選。被 <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> 支援的格式，例如 <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => '項目日期',
					'help' => '結果將被 <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a> 解析',
				),
				'item_title' => '項目標題',
				'item_uid' => '項目唯一 ID',
				'item_uri' => array(
					'_' => '項目連結 (URL)',
					'help' => '範例: <code>permalink</code>',
				),
				'json' => '點表示法用於:',
				'relative' => '點表示法標記路徑 (相對於項目) 用於:',
			),
			'jsonfeed' => 'JSON 訂閱源',
			'rss' => 'RSS / Atom (預設)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'last-entry-publication-date' => 'Last article published <time datetime="%1$s" title="%1$s">%2$s</time>.',	// TODO
		'last-entry-received-date' => 'Last article received <time datetime="%1$s" title="%1$s">%2$s</time>.',	// TODO
		'last-error-date' => '上次錯誤更新 <time datetime="%1$s" title="%1$s">%2$s</time>。',
		'last-update' => '上次成功更新 <time datetime="%1$s" title="%1$s">%2$s</time>。',
		'maintenance' => array(
			'clear_cache' => '清理快取',
			'clear_cache_help' => '清除此訂閱源的快取',
			'reload_articles' => '重新載入文章',
			'reload_articles_help' => '重新載入 n 篇文章，並在指定選擇器存在時載入完整內容。',
			'title' => '維護',
		),
		'max_http_redir' => '最大 HTTP 重新導向數',
		'max_http_redir_help' => '設為 0 或留空以停用，-1 表示無限制重新導向',
		'method' => array(
			'_' => 'HTTP 方法',
		),
		'method_help' => 'POST 負載自動支援 <code>application/x-www-form-urlencoded</code> 和 <code>application/json</code>',
		'method_postparams' => 'POST 負載',
		'moved_category_deleted' => '刪除類別時，其中的訂閱源會自動歸類到 <em>%s</em>',
		'mute' => array(
			'_' => '暫停',
			'state_is_muted' => '此訂閱源被靜音',
		),
		'no_selected' => '未選擇訂閱源。',
		'number_entries' => '%d 篇文章',
		'open_feed' => '開啟訂閱源 %s',
		'path_entries_conditions' => 'Conditions for content retrieval',	// TODO
		'priority' => array(
			'_' => '可見度',
			'category' => '在類別中顯示',
			'feed' => 'Show in its feed',	// TODO
			'hidden' => '不要顯示',
			'important' => '顯示在重要訂閱源',
			'main_stream' => '顯示在主資訊流',
		),
		'proxy' => '取得訂閱源時的代理',
		'proxy_help' => '選擇協定 (例如: SOCKS5) 並輸入代理位址 (例如: <kbd>127.0.0.1:1080</kbd> 或 <kbd>使用者名稱:密碼@127.0.0.1:1080</kbd>)',
		'reset_favicon' => '重設至預設',
		'selector_preview' => array(
			'show_raw' => '顯示原始碼',
			'show_rendered' => '顯示內容',
		),
		'show' => array(
			'all' => '所有訂閱源',
			'error' => '僅顯示有錯誤的訂閱源',
		),
		'showing' => array(
			'error' => '正在顯示有錯誤的訂閱源',
		),
		'ssl_verify' => '驗證 SSL 安全',
		'stats' => '統計',
		'think_to_add' => '你可以新增一些訂閱源。',
		'timeout' => '逾時 (秒)',
		'title' => '標題',
		'title_add' => '新增 RSS 訂閱源',
		'ttl' => '最小自動刷新間隔',
		'unicityCriteria' => array(
			'_' => '文章唯一性標準',
			'forced' => '<span title="Block the unicity criteria, even when the feed has duplicate articles">forced</span>',	// TODO
			'help' => 'Relevant for invalid feeds.<br />⚠️ Changing the policy will create duplicates.',	// TODO
			'id' => '標準 ID (預設)',
			'link' => '連結',
			'sha1:content' => '內容',
			'sha1:content_published' => '內容 + 日期',
			'sha1:link_published' => '連結 + 日期',
			'sha1:link_published_title' => '連結 + 日期 + 標題',
			'sha1:link_published_title_content' => '連結 + 日期 + 標題 + 內容',
			'sha1:published' => '日期',
			'sha1:title' => '標題',
			'sha1:title_published' => '標題 + 日期',
			'sha1:title_published_content' => '標題 + 日期 + 內容',
		),
		'url' => '訂閱源 URL',
		'useragent' => '設定用於取得此訂閱源的 user agent',
		'useragent_help' => '範例: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => '檢查訂閱源有效性',
		'website' => '網站 URL',
		'websub' => 'WebSub 即時通知',
	),
	'import_export' => array(
		'export' => array(
			'_' => '匯出',
			'sqlite' => '下載使用者資料庫為 SQLite 檔案',
		),
		'export_labelled' => '匯出有標籤的文章',
		'export_opml' => '匯出訂閱源清單 (OPML)',
		'export_starred' => '匯出你的收藏',
		'feed_list' => '%s 文章清單',
		'file_to_import' => '要匯入的檔案<br />(OPML、JSON 或 ZIP)',
		'file_to_import_no_zip' => '要匯入的檔案<br />(OPML 或 JSON)',
		'import' => '匯入',
		'starred_list' => '收藏文章清單',
		'title' => '匯入 / 匯出',
	),
	'menu' => array(
		'add' => '新增訂閱源或類別',
		'import_export' => '匯入 / 匯出',
		'label_management' => '標籤管理',
		'stats' => array(
			'idle' => '長期無更新訂閱源',
			'main' => '主要統計',
			'repartition' => '文章分配',
			'unread_dates' => '未讀日期',
		),
		'subscription_management' => '訂閱管理',
		'subscription_tools' => '訂閱工具',
	),
	'tag' => array(
		'auto_label' => '新增標籤至新文章',
		'name' => '名稱',
		'new_name' => '新名稱',
		'old_name' => '舊名稱',
	),
	'title' => array(
		'_' => '訂閱管理',
		'add' => '新增訂閱源或類別',
		'add_category' => '新增類別',
		'add_dynamic_opml' => '新增動態 OPML',
		'add_feed' => '新增訂閱源',
		'add_label' => '新增標籤',
		'add_opml_category' => 'OPML 類別名稱',
		'delete_label' => '刪除此標籤',
		'feed_management' => 'RSS 訂閱源管理',
		'subscription_tools' => '訂閱工具',
	),
);

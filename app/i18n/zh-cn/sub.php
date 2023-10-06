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
		'documentation' => '复制以下地址，以供外部工具使用',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => '拖动此书签到你的书签栏或者右键选择「收藏此链接」，然后在你想要订阅的页面上点击「订阅」按钮。',
		'label' => '订阅',
		'title' => '书签',
	),
	'category' => array(
		'_' => '分类',
		'add' => '添加分类',
		'archiving' => '归档',
		'dynamic_opml' => array(
			'_' => '动态订阅',
			'help' => '使用 URL 上的 <a href="http://opml.org/" target="_blank">OPML 文件</a> 中的订阅源填充这一分类',
		),
		'empty' => '空分类',
		'information' => '信息',
		'opml_url' => 'OPML URL',	// IGNORE
		'position' => '显示位置',
		'position_help' => '控制分类排列顺序',
		'title' => '标题',
	),
	'feed' => array(
		'accept_cookies' => '接受 Cookies',
		'accept_cookies_help' => '允许订阅源服务器设置 Cookies（仅在请求期间存储在内存中）',
		'add' => '添加订阅源',
		'advanced' => '高级',
		'archiving' => '归档',
		'auth' => array(
			'configuration' => '认证',
			'help' => '用于连接启用 HTTP 认证的订阅源',
			'http' => 'HTTP 认证',
			'password' => 'HTTP 密码',
			'username' => 'HTTP 用户名',
		),
		'clear_cache' => '总是清除缓存',
		'content_action' => array(
			'_' => '获取原文后的操作',
			'append' => '添加在现有内容后部',
			'prepend' => '添加在现有内容前部',
			'replace' => '替换现有内容',
		),
		'css_cookie' => '获取原文时的 Cookies',
		'css_cookie_help' => '例：<kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => '用于获取全文（注意，这将耗费更多时间！）',
		'css_path' => '原文的 CSS 选择器',
		'css_path_filter' => array(
			'_' => '需移除元素的 CSS 选择器',
			'help' => '可设置多个 CSS 选择器，例如：<kbd>.footer, .aside</kbd>',
		),
		'description' => '描述',
		'empty' => '此源为空。请确认它是否正常更新。',
		'error' => '此源遇到一些问题。请在确认是否能正常访问后重试。',
		'filteractions' => array(
			'_' => '过滤动作',
			'help' => '每行写一条过滤搜索 Operators <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">see documentation</a>.',	// DIRTY
		),
		'information' => '信息',
		'keep_min' => '至少保存的文章数',
		'kind' => array(
			'_' => '订阅源类型',
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web 抓取)',
				'feed_title' => array(
					'_' => '订阅源标题',
					'help' => '如 <code>//title</code> 或是静态字符串如： <code>"My custom feed"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> 是为资深用户准备的标准查询语言，FreshRSS 用以实现 Web 抓取.',
				'item' => array(
					'_' => '以寻找 <strong>文章</strong><br /><small>(很重要)</small>',
					'help' => '例如 <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => '文章作者',
					'help' => '可以是静态字符串，例如 <code>"Anonymous"</code>',
				),
				'item_categories' => '文章标签',
				'item_content' => array(
					'_' => '文章内容',
					'help' => '例如使用 <code>.</code> 将整个对象作为文章内容',
				),
				'item_thumbnail' => array(
					'_' => '文章缩略图',
					'help' => '例如 <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => '自定义日期/时间格式',
					'help' => '可选项， 格式参见 <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> 例如 <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => '文章日期：',
					'help' => '结果将被 <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a> 解析',
				),
				'item_title' => array(
					'_' => '文章标题',
					'help' => '注意使用 <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">XPath 轴</a> <code>descendant::</code>，例如 <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => '文章唯一 ID',
					'help' => '可选，例如: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => '文章链接 (URL)',
					'help' => '例如 <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath（文章）：',
				'xpath' => 'XPath 定位：',
			),
			'rss' => 'RSS / Atom (默认)',
			'xml_xpath' => 'XML + XPath',	// TODO
		),
		'maintenance' => array(
			'clear_cache' => '清理缓存',
			'clear_cache_help' => '清除该feed的缓存',
			'reload_articles' => '重载文章',
			'reload_articles_help' => '重载 n 篇文章并抓取内容（若设置了 CSS 选择器）',
			'title' => '维护',
		),
		'max_http_redir' => '最大 HTTP 重定向',
		'max_http_redir_help' => '设置为 0 或留空以禁用，-1 表示无限重定向',
		'moved_category_deleted' => '删除分类时，其中的订阅源会自动归类到 <em>%s</em>',
		'mute' => '暂停',
		'no_selected' => '未选择订阅源',
		'number_entries' => '%d 篇文章',
		'priority' => array(
			'_' => '可见性',
			'archived' => '不显示（归档）',
			'main_stream' => '在首页中显示',
			'normal' => '在分类中显示',
		),
		'proxy' => '获取订阅源时的代理',
		'proxy_help' => '选择协议（例：SOCKS5）和代理地址（例：<kbd>127.0.0.1:1080</kbd>）',
		'selector_preview' => array(
			'show_raw' => '显示源码',
			'show_rendered' => '显示内容',
		),
		'show' => array(
			'all' => '显示所有订阅源',
			'error' => '仅显示有错误的订阅源',
		),
		'showing' => array(
			'error' => '正在显示有错误的订阅源',
		),
		'ssl_verify' => '验证 SSL 证书安全',
		'stats' => '统计',
		'think_to_add' => '你可以添加一些订阅源。',
		'timeout' => '超时时间（秒）',
		'title' => '标题',
		'title_add' => '添加订阅源',
		'ttl' => '最小自动更新间隔',
		'url' => '源地址',
		'useragent' => '设置用于获取此源的 User Agent',
		'useragent_help' => '例：<kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => '检查订阅源有效性',
		'website' => '网站地址',
		'websub' => 'WebSub 即时通知',
	),
	'import_export' => array(
		'export' => '导出',
		'export_labelled' => '导出有标签的文章',
		'export_opml' => '导出订阅源列表（OPML）',
		'export_starred' => '导出你的收藏',
		'feed_list' => '%s 文章列表',
		'file_to_import' => '需要导入的文件 <br />（OPML、JSON 或 ZIP）',
		'file_to_import_no_zip' => '需要导入的文件 <br />（OPML 或 JSON）',
		'import' => '导入',
		'starred_list' => '收藏文章列表',
		'title' => '导入/导出',
	),
	'menu' => array(
		'add' => '添加订阅源或分类',
		'import_export' => '导入/导出',
		'label_management' => '标签管理',
		'stats' => array(
			'idle' => '长期无更新订阅源',
			'main' => '主要统计',
			'repartition' => '文章分布',
		),
		'subscription_management' => '订阅管理',
		'subscription_tools' => '订阅工具',
	),
	'tag' => array(
		'name' => '名称',
		'new_name' => '新名称',
		'old_name' => '旧名称',
	),
	'title' => array(
		'_' => '订阅管理',
		'add' => '添加订阅源或分类',
		'add_category' => '添加分类',
		'add_dynamic_opml' => '添加订阅源动态列表',
		'add_feed' => '添加订阅源',
		'add_label' => '添加标签',
		'delete_label' => '删除标签',
		'feed_management' => '订阅源管理',
		'rename_label' => '重命名标签',
		'subscription_tools' => '订阅工具',
	),
);

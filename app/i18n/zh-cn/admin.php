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
		'documentation' => '拖动此书签到你的书签栏或者右键选择「收藏此链接」，然后在你想要订阅的页面上点击「订阅」按钮',
		'label' => '订阅',
		'title' => '书签应用',
	),
	'category' => array(
		'_' => '分类',
		'add' => '添加分类',
		'archiving' => '归档',
		'empty' => '空分类',
		'information' => '信息',
		'position' => '显示位置',
		'position_help' => '控制分类排列顺序',
		'title' => '标题',
	),
	'feed' => array(
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
		'description' => '描述',
		'empty' => '此源为空。请确认它是否正常更新。',
		'error' => '此源遇到一些问题。请在确认是否能正常访问后重试。',
		'filteractions' => array(
			'_' => '过滤动作',
			'help' => '每行写一条过滤搜索',
		),
		'information' => '信息',
		'keep_min' => '至少保存的文章数',
		'kind' => array(
			'_' => 'Type of feed source',	// TODO
			'html_xpath' => array(
				'_' => 'HTML + XPath (Web抓取)',
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
			'rss' => 'RSS / Atom (默认)',
		),
		'maintenance' => array(
			'clear_cache' => '清理缓存',
			'clear_cache_help' => '清除该feed的缓存',
			'reload_articles' => '重载文章',
			'reload_articles_help' => '重新加载文章并获取完整内容',
			'title' => '维护',
		),
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
		'file_to_import' => '需要导入的文件<br />（OPML、JSON 或 ZIP）',
		'file_to_import_no_zip' => '需要导入的文件<br />（OPML 或 JSON）',
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
		'add_feed' => '添加订阅源',
		'add_label' => '添加标签',
		'delete_label' => '删除标签',
		'feed_management' => '订阅源管理',
		'rename_label' => '重命名标签',
		'subscription_tools' => '订阅工具',
	),
);

<?php

return array(
	'api' => array(
		'documentation' => '复制以下地址，以供外部工具使用',
		'title' => 'API',
	),
	'bookmarklet' => array(
		'documentation' => '拖动此书签到你的书签栏或者右键选择「收藏此链接」，然后在你想要订阅的页面上点击「订阅」按钮',
		'label' => '订阅',
		'title' => '书签应用',
	),
	'category' => array(
		'add' => '添加分类',
		'archiving' => '归档',
		'empty' => '空分类',
		'information' => '信息',
		'new' => '新分类',
		'position' => '显示位置',
		'position_help' => '控制分类排列顺序',
		'title' => '标题',
		'_' => '分类',
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
		'css_help' => '用于获取全文（注意，这将耗费更多时间！）',
		'css_path' => '原文的 CSS 选择器',
		'description' => '描述',
		'empty' => '此源为空。请确认它是否正常更新。',
		'error' => '此源遇到一些问题。请在确认是否能正常访问后重试。',
		'filteractions' => array(
			'help' => '每行写一条过滤搜索',
			'_' => '过滤动作',
		),
		'information' => '信息',
		'keep_min' => '至少保存的文章数',
		'maintenance' => array(
			'clear_cache' => 'Clear cache',	// TODO - Translation
			'clear_cache_help' => 'Clear the cache of this feed on disk',	// TODO - Translation
			'reload_articles' => 'Reload articles',	// TODO - Translation
			'reload_articles_help' => 'Reload articles and fetch complete content',	// TODO - Translation
			'title' => 'Maintenance',	// TODO - Translation
		),
		'moved_category_deleted' => '删除分类时，其中的订阅源会自动归类到 <em>%s</em>',
		'mute' => '暂停',
		'no_selected' => '未选择订阅源',
		'number_entries' => '%d 篇文章',
		'priority' => array(
			'archived' => '不显示（归档）',
			'main_stream' => '在首页中显示',
			'normal' => '在分类中显示',
			'_' => '可见性',
		),
		'selector_preview' => array(
			'show_raw' => 'Show source',	// TODO - Translation
			'show_rendered' => 'Show content',	// TODO - Translation
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
		'validator' => '检查订阅源有效性',
		'website' => '网站地址',
		'websub' => 'WebSub 即时通知',
	),
	'firefox' => array(
		'documentation' => '按照 <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">这里</a> 描述的步骤可将 FreshRSS 添加到火狐阅读器列表',
		'obsolete_63' => '从火狐63版本开始取消了添加自己非独立程序的订阅服务功能',
		'title' => '火狐 RSS 阅读器',
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
		'bookmark' => '订阅（FreshRSS 书签）',
		'import_export' => '导入/导出',
		'subscription_management' => '订阅管理',
		'subscription_tools' => '订阅工具',
	),
	'title' => array(
		'feed_management' => '订阅源管理',
		'subscription_tools' => '订阅工具',
		'_' => '订阅管理',
	),
);

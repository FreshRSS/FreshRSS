<?php

return array(
	'api' => array(
		'documentation' => '复制以下地址，可供外部工具使用',
		'title' => 'API',
	),
	'bookmarklet' => array(
		'documentation' => '拖动此书签到你的书签栏或者右键选择“收藏此链接”，然后在你想要订阅的页面上点击“订阅”按钮',
		'label' => '订阅',
		'title' => '书签应用',
	),
	'category' => array(
		'_' => '分类',
		'add' => '添加分类',
		'archiving' => '存档',
		'empty' => '空分类',
		'information' => '信息',
		'new' => '新分类',
		'position' => 'Display position',	//TODO - Translation
		'position_help' => 'To control category sort order',	//TODO - Translation
		'title' => '标题',
	),
	'feed' => array(
		'add' => '添加 RSS 源',
		'advanced' => '高级',
		'archiving' => '存档',
		'auth' => array(
			'configuration' => '认证',
			'help' => '用于连接启用 HTTP 认证的 RSS 源',
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
			'_' => 'Filter actions',	//TODO - Translation
			'help' => 'Write one search filter per line.',	//TODO - Translation
		),
		'information' => '信息',
		'keep_min' => '至少保存的文章数',
		'moved_category_deleted' => '删除分类时，其中的 RSS 源会自动归类到 <em>%s</em>',
		'mute' => '暂停',
		'no_selected' => '未选择 RSS 源。',
		'number_entries' => '%d 篇文章',
		'priority' => array(
			'_' => '可见性',
			'archived' => '不显示 (存档)',
			'main_stream' => '在首页中显示',
			'normal' => '在分类中显示',
		),
		'websub' => 'WebSub 即时通知',
		'show' => array(
			'all' => '显示所有 RSS 源',
			'error' => '仅显示有错误的 RSS 源',
		),
		'showing' => array(
			'error' => '正在显示有错误的 RSS 源',
		),
		'ssl_verify' => '验证 SSL 安全',
		'stats' => '统计',
		'think_to_add' => '你可以添加一些 RSS 源。',
		'timeout' => '超时时间（秒）',
		'title' => '标题',
		'title_add' => '添加 RSS 源',
		'ttl' => '最小自动更新时间',
		'url' => '源 URL',
		'validator' => '检查 RSS 源有效性',
		'website' => '网站 URL',
	),
	'firefox' => array(
		'documentation' => '按照 <a href="https://developer.mozilla.org/en-US/Firefox/Releases/2/Adding_feed_readers_to_Firefox#Adding_a_new_feed_reader_manually">这里</a> 描述的步骤可将 FreshRSS 添加到 Firefox 阅读器列表',
		'title' => 'Firefox RSS 阅读器',
	),
	'import_export' => array(
		'export' => '导出',
		'export_opml' => '导出 RSS 源列表 (OPML)',
		'export_starred' => '导出你的收藏',
		'export_labelled' => '导出有标签的文章',
		'feed_list' => '%s 文章列表',
		'file_to_import' => '需要导入的文件<br />(OPML, JSON 或 ZIP)',
		'file_to_import_no_zip' => '需要导入的文件<br />(OPML 或 JSON)',
		'import' => '导入',
		'starred_list' => '收藏文章列表',
		'title' => '导入/导出',
	),
	'menu' => array(
		'bookmark' => '订阅 (FreshRSS 书签)',
		'import_export' => '导入/导出',
		'subscription_management' => '订阅管理',
		'subscription_tools' => '订阅工具',
	),
	'title' => array(
		'_' => '订阅管理',
		'feed_management' => 'RSS 源管理',
		'subscription_tools' => '订阅工具',
	),
);

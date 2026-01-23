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
	'auth' => array(
		'allow_anonymous' => '允许匿名阅读默认用户（%s）的文章',
		'allow_anonymous_refresh' => '允许匿名刷新文章',
		'api_enabled' => '允许 <abbr>API</abbr> 访问 <small>（用于手机应用和分享用户查询）</small>',
		'form' => '网页表单（传统方式, 需要 JavaScript)',
		'http' => 'HTTP（高级：由 Web 服务器、OIDC、SSO 管理…）',
		'none' => '无（危险）',
		'title' => '认证',
		'token' => '主验证 token',
		'token_help' => '允许不验证而访问用户的全部 RSS 输出以及刷新订阅源：',
		'type' => '认证方式',
	),
	'extensions' => array(
		'author' => '作者',
		'community' => '可用的社区扩展',
		'description' => '描述',
		'disabled' => '已禁用',
		'empty_list' => '没有已安装的扩展',
		'empty_list_help' => '检查日志以确定扩展列表为空的原因。',
		'enabled' => '已启用',
		'is_compatible' => '兼容',	// DIRTY
		'latest' => '已安装',
		'name' => '名称',
		'no_configure_view' => '此扩展无法配置。',
		'system' => array(
			'_' => '系统扩展',
			'no_rights' => '系统扩展（你没有所需权限）',
		),
		'title' => '扩展',
		'update' => '更新可用',
		'user' => '用户扩展',
		'version' => '版本',
	),
	'stats' => array(
		'_' => '统计数据',
		'all_feeds' => '所有订阅源',
		'category' => '分类',
		'date_published' => '发布日期',
		'date_received' => '接收日期',
		'entry_count' => '文章数',
		'entry_per_category' => '各分类文章数',
		'entry_per_day' => '每日文章数（近三十日）',
		'entry_per_day_of_week' => '一周中（平均：%.2f 条消息）',
		'entry_per_hour' => '各小时（平均：%.2f 条消息）',
		'entry_per_month' => '各月（平均：%.2f 条消息）',
		'entry_repartition' => '文章分布',
		'feed' => '订阅源',
		'feed_per_category' => '各分类订阅源数',
		'idle' => '长期无更新订阅源',
		'main' => '主要统计数据',
		'main_stream' => '首页',
		'nb_unreads' => '未读文章数',
		'no_idle' => '订阅源近期皆有更新！',
		'number_entries' => '%d 篇文章',
		'overview' => '概览',
		'percent_of_total' => '%',
		'repartition' => '文章分布: %s',	// DIRTY
		'status_favorites' => '收藏',
		'status_read' => '已读',
		'status_total' => '总计',
		'status_unread' => '未读',
		'title' => '统计',
		'top_feed' => '前十订阅源',
		'unread_dates' => '未读文章最多的日期',
	),
	'system' => array(
		'_' => '系统配置',
		'auto-update-url' => '自动更新服务器 URL',
		'base-url' => array(
			'_' => '基础 URL',
			'recommendation' => '推荐: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => '单位：秒',
			'number' => '保持登录的时长',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
		'force_email_validation' => '强制验证邮箱地址',
		'instance-name' => '实例名称',
		'max-categories' => '各用户分类数限制',
		'max-feeds' => '各用户订阅源数限制',
		'registration' => array(
			'number' => '最大用户数',
			'select' => array(
				'label' => '注册表单',
				'option' => array(
					'noform' => '禁用，无注册表单',
					'nolimit' => '启用，且无账户限制',
					'setaccountsnumber' => '设置用户数的最大值',
				),
			),
			'status' => array(
				'disabled' => '注册表单已禁用',
				'enabled' => '注册表单已启用',
			),
			'title' => '用户注册表单',
		),
		'sensitive-parameter' => '敏感参数。在 <kbd>./data/config.php</kbd> 中手动修改',
		'tos' => array(
			'disabled' => '没有提供',
			'enabled' => '<a href="./?a=tos">已启用</a>',
			'help' => '如何<a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">启用服务条款</a>',
		),
		'websub' => array(
			'help' => '关于 <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => '更新系统',
		'apply' => '应用',
		'changelog' => '更新记录',
		'check' => '检查更新',
		'copiedFromURL' => '从 %s 复制 update.php 到 ./data',
		'current_version' => '当前 版本为',
		'last' => '上次检查',
		'loading' => '更新中…',
		'none' => '没有可用更新',
		'releaseChannel' => array(
			'_' => '发布通道',
			'edge' => '滚动发布 (“edge”)',
			'latest' => '稳定版本 (“latest”)',
		),
		'title' => '更新系统',
		'viaGit' => '开始通过 git 和 GitHub.com 更新',
	),
	'user' => array(
		'admin' => '管理员',
		'article_count' => '文章数',
		'back_to_manage' => '← 返回用户列表',
		'create' => '创建新用户',
		'database_size' => '数据库大小',
		'email' => '邮箱地址',
		'enabled' => '已启用',
		'feed_count' => '订阅源数',
		'is_admin' => '管理员',
		'language' => '语言',
		'last_user_activity' => '上次用户活跃',
		'list' => '用户列表',
		'number' => '已有 %d 个用户',
		'numbers' => '已有 %d 个用户',
		'password_form' => '密码<br /><small>（用于网页表单登录方式）</small>',
		'password_format' => '至少 7 个字符',
		'title' => '用户管理',
		'username' => '用户名',
	),
);

<?php

return array(
	'auth' => array(
		'allow_anonymous' => '允许匿名阅读默认用户 (%s) 的文章',
		'allow_anonymous_refresh' => '允许匿名刷新文章',
		'api_enabled' => '允许 <abbr>API</abbr> 访问 <small>(用于手机 APP)</small>',
		'form' => 'Web form (传统方式, 需要 JavaScript)',
		'http' => 'HTTP (面向启用 HTTPS 的高级用户)',
		'none' => '无 (危险)',
		'title' => '认证',
		'title_reset' => '密码重置',
		'token' => '认证口令',
		'token_help' => '用于不经认证访问默认用户的 RSS 输出：',
		'type' => '认证方式',
		'unsafe_autologin' => '允许不安全的自动登陆方式：',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => '请检查 <em>./data/cache</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'cache 目录权限正常。',
		),
		'categories' => array(
			'nok' => 'Category 表配置错误。',
			'ok' => 'Category 表正常。',
		),
		'connection' => array(
			'nok' => '数据库连接失败。',
			'ok' => '数据库连接正常。',
		),
		'ctype' => array(
			'nok' => '找不到字符类型检测库 (php-ctype) 。',
			'ok' => '已找到字符类型检测库 (ctype) 。',
		),
		'curl' => array(
			'nok' => '找不到 cURL 库 (php-curl package) 。',
			'ok' => '已找到 cURL 库。',
		),
		'data' => array(
			'nok' => '请检查 <em>./data</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'data 目录权限正常。',
		),
		'database' => '数据库相关',
		'dom' => array(
			'nok' => '找不到用于浏览 DOM 的库 (php-xml) 。',
			'ok' => '已找到用于浏览 DOM 的库。',
		),
		'entries' => array(
			'nok' => 'Entry 表配置错误。',
			'ok' => 'Entry 表正常。',
		),
		'favicons' => array(
			'nok' => '请检查 <em>./data/favicons</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'favicons 目录权限正常。',
		),
		'feeds' => array(
			'nok' => 'Feed 表配置错误。',
			'ok' => 'Feed 表正常。',
		),
		'fileinfo' => array(
			'nok' => '找不到 PHP fileinfo 库 (fileinfo) 。',
			'ok' => '已找到 fileinfo 库。',
		),
		'files' => '文件相关',
		'json' => array(
			'nok' => '找不到 JSON 扩展 (php-json ) 。',
			'ok' => '已找到 JSON 扩展。',
		),
		'mbstring' => array(
			'nok' => '找不到推荐的 Unicode 解析库 (mbstring)。',
			'ok' => '已找到推荐的 Unicode 解析库 (mbstring)。',
		),
		'minz' => array(
			'nok' => '找不到 Minz 框架。',
			'ok' => '已找到 Minz 框架。',
		),
		'pcre' => array(
			'nok' => '找不到正则表达式解析库 (php-pcre) 。',
			'ok' => '已找到正则表达式解析库 (PCRE) 。',
		),
		'pdo' => array(
			'nok' => '找不到 PDO 或支持的驱动 (pdo_mysql, pdo_sqlite, pdo_pgsql) 。',
			'ok' => '已找到 PDO 和支持的至少一种驱动 (pdo_mysql, pdo_sqlite, pdo_pgsql) 。',
		),
		'php' => array(
			'nok' => '你的 PHP 版本为 %s，但 FreshRSS 最低需要 %s。',
			'ok' => '你的 PHP 版本为 %s，与 FreshRSS 兼容。',
			'_' => 'PHP 相关',
		),
		'tables' => array(
			'nok' => '数据库中缺少一个或多个表。',
			'ok' => '数据库中相关表存在。',
		),
		'title' => '环境检查',
		'tokens' => array(
			'nok' => '请检查 <em>./data/tokens</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'tokens 目录权限正常。',
		),
		'users' => array(
			'nok' => '请检查 <em>./data/users</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'users 目录权限正常。',
		),
		'zip' => array(
			'nok' => '找不到 ZIP 扩展 (php-zip) 。',
			'ok' => '已找到 ZIP 扩展。',
		),
	),
	'extensions' => array(
		'author' => '作者',
		'community' => '可用的社区扩展',
		'description' => '描述',
		'disabled' => '已禁用',
		'empty_list' => '没有已安装的扩展',
		'enabled' => '已启用',
		'latest' => '已安装',
		'name' => '名称',
		'no_configure_view' => '此扩展不能配置。',
		'system' => array(
			'no_rights' => '系统扩展 (你不能修改它)',
			'_' => '系统扩展',
		),
		'title' => '扩展',
		'update' => '更新可用',
		'user' => '用户扩展',
		'version' => '版本',
	),
	'stats' => array(
		'all_feeds' => '所有 RSS 源',
		'category' => '分类',
		'entry_count' => '条目数',
		'entry_per_category' => '每分类条目数',
		'entry_per_day' => '每天条目数 (最近 30 天)',
		'entry_per_day_of_week' => '周内每天 (平均: %.2f 条消息)',
		'entry_per_hour' => '每小时 (平均: %.2f 条消息)',
		'entry_per_month' => '每月 (平均: %.2f 条消息)',
		'entry_repartition' => '条目分布',
		'feed' => 'RSS 源',
		'feed_per_category' => '每分类 RSS 源',
		'idle' => '闲置 RSS 源',
		'main' => '主要统计',
		'main_stream' => '首页',
		'menu' => array(
			'idle' => '闲置 RSS 源',
			'main' => '主要统计',
			'repartition' => '文章分布',
		),
		'no_idle' => '无闲置 RSS 源!',
		'number_entries' => '%d 篇文章',
		'percent_of_total' => '%%',
		'repartition' => '文章分布',
		'status_favorites' => '收藏',
		'status_read' => '已读',
		'status_total' => '总计',
		'status_unread' => '未读',
		'title' => '统计',
		'top_feed' => '前十 RSS 源',
		'_' => '统计',
	),
	'system' => array(
		'auto-update-url' => '自动升级服务器 URL',
		'cookie-duration' => array(
			'help' => '单位（秒）',
			'number' => '保持登录的时长',
		),
		'force_email_validation' => 'Force email addresses validation',	// TODO - Translation
		'instance-name' => '实例名称',
		'max-categories' => '每用户分类限制',
		'max-feeds' => '每用户 RSS 源限制',
		'registration' => array(
			'help' => '0 表示无账户数限制',
			'number' => '最大账户数',
		),
		'_' => '系统配置',
	),
	'update' => array(
		'apply' => '应用',
		'check' => '检查更新',
		'current_version' => '当前 FreshRSS 版本为 %s.',
		'last' => '上一次检查: %s',
		'none' => '没有可用更新',
		'title' => '更新系统',
		'_' => '更新系统',
	),
	'user' => array(
		'articles_and_size' => '%s 篇文章 (%s)',
		'article_count' => 'Articles',	// TODO - Translation
		'back_to_manage' => '← Return to user list',	// TODO - Translation
		'create' => '创建新用户',
		'database_size' => 'Database size',	// TODO - Translation
		'delete_users' => '删除用户',
		'feed_count' => 'Feeds',	// TODO - Translation
		'language' => '语言',
		'list' => 'User list',	// TODO - Translation
		'number' => '已有 %d 个用户',
		'numbers' => '已有 %d 个用户',
		'password_form' => '密码<br /><small>(用于 Web-form 登录方式)</small>',
		'password_format' => '至少 7 个字符',
		'selected' => '已选中用户',
		'title' => '用户管理',
		'update_users' => '更新用户',
		'username' => '用户名',
		'users' => '用户',
		'user_list' => '用户列表',
	),
);

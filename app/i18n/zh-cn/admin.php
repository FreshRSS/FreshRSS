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
	'auth' => array(
		'allow_anonymous' => '允许匿名阅读默认用户（%s）的文章',
		'allow_anonymous_refresh' => '允许匿名刷新文章',
		'api_enabled' => '允许 <abbr>API</abbr> 访问 <small>（用于手机应用）</small>',
		'form' => '网页表单（传统方式, 需要 JavaScript)',
		'http' => 'HTTP（面向启用 HTTPS 的高级用户)',
		'none' => '无认证（危险）',
		'title' => '认证',
		'token' => '认证口令',
		'token_help' => '用于不经认证访问默认用户的 RSS 输出：',
		'type' => '认证方式',
		'unsafe_autologin' => '允许不安全的自动登陆方式：',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => '请检查 <em>./data/cache</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'cache 目录权限正常',
		),
		'categories' => array(
			'nok' => 'Category 表配置错误',
			'ok' => 'Category 表正常',
		),
		'connection' => array(
			'nok' => '数据库连接失败',
			'ok' => '数据库连接正常',
		),
		'ctype' => array(
			'nok' => '找不到字符类型检测库（php-ctype）',
			'ok' => '已找到字符类型检测库 （ctype）',
		),
		'curl' => array(
			'nok' => '找不到 cURL 库（php-curl）',
			'ok' => '已找到 cURL 库',
		),
		'data' => array(
			'nok' => '请检查 <em>./data</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'data 目录权限正常',
		),
		'database' => '数据库相关',
		'dom' => array(
			'nok' => '找不到用于浏览 DOM 的库（php-xml）',
			'ok' => '已找到用于浏览 DOM 的库',
		),
		'entries' => array(
			'nok' => 'Entry 表配置错误',
			'ok' => 'Entry 表正常',
		),
		'favicons' => array(
			'nok' => '请检查 <em>./data/favicons</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'favicons 目录权限正常',
		),
		'feeds' => array(
			'nok' => 'Feed 表配置错误',
			'ok' => 'Feed 表正常',
		),
		'fileinfo' => array(
			'nok' => '找不到 PHP fileinfo 库（fileinfo）',
			'ok' => '已找到 fileinfo 库',
		),
		'files' => '文件相关',
		'json' => array(
			'nok' => '找不到 JSON 扩展（php-json ）',
			'ok' => '已找到 JSON 扩展',
		),
		'mbstring' => array(
			'nok' => '找不到推荐的 Unicode 解析库（mbstring)',
			'ok' => '已找到推荐的 Unicode 解析库（mbstring)',
		),
		'pcre' => array(
			'nok' => '找不到正则表达式解析库（php-pcre）',
			'ok' => '已找到正则表达式解析库（PCRE）',
		),
		'pdo' => array(
			'nok' => '找不到 PDO 或支持的驱动（pdo_mysql、pdo_sqlite、pdo_pgsql）',
			'ok' => '已找到 PDO 和支持的至少一种驱动（pdo_mysql、pdo_sqlite、pdo_pgsql）',
		),
		'php' => array(
			'_' => 'PHP 相关',
			'nok' => '你的 PHP 版本为 %s，但 FreshRSS 最低需要 %s',
			'ok' => '你的 PHP 版本为 %s，与 FreshRSS 兼容',
		),
		'tables' => array(
			'nok' => '数据库中缺少一个或多个表',
			'ok' => '数据库中相关表存在',
		),
		'title' => '环境检查',
		'tokens' => array(
			'nok' => '请检查 <em>./data/tokens</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'tokens 目录权限正常',
		),
		'users' => array(
			'nok' => '请检查 <em>./data/users</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'users 目录权限正常',
		),
		'zip' => array(
			'nok' => '找不到 ZIP 扩展（php-zip）',
			'ok' => '已找到 ZIP 扩展',
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
			'_' => '系统扩展',
			'no_rights' => '系统扩展（你无权修改）',
		),
		'title' => '扩展',
		'update' => '更新可用',
		'user' => '用户扩展',
		'version' => '版本',
	),
	'stats' => array(
		'_' => '统计',
		'all_feeds' => '所有订阅源',
		'category' => '分类',
		'entry_count' => '文章数',
		'entry_per_category' => '各分类文章数',
		'entry_per_day' => '近三十日每日文章数',
		'entry_per_day_of_week' => '一周各日（平均：%.2f 条消息)',
		'entry_per_hour' => '各小时（平均：%.2f 条消息)',
		'entry_per_month' => '各月（平均：%.2f 条消息)',
		'entry_repartition' => '文章分布',
		'feed' => '订阅源',
		'feed_per_category' => '各分类订阅源数',
		'idle' => '长期无更新订阅源',
		'main' => '主要统计',
		'main_stream' => '首页',
		'no_idle' => '订阅源近期皆有更新！',
		'number_entries' => '%d 篇文章',
		'percent_of_total' => '%%',
		'repartition' => '文章分布',
		'status_favorites' => '收藏',
		'status_read' => '已读',
		'status_total' => '总计',
		'status_unread' => '未读',
		'title' => '统计',
		'top_feed' => '前十订阅源',
	),
	'system' => array(
		'_' => '系统配置',
		'auto-update-url' => '自动升级服务器地址',
		'cookie-duration' => array(
			'help' => '单位（秒）',
			'number' => '保持登录的时长',
		),
		'force_email_validation' => '强制验证邮箱地址',
		'instance-name' => '实例名称',
		'max-categories' => '各用户分类数限制',
		'max-feeds' => '各用户订阅源数限制',
		'registration' => array(
			'number' => '最大用户数',
			'select' => array(
				'label' => 'Registration form',	// TODO
				'option' => array(
					'noform' => 'Disabled: No registration form',	// TODO
					'nolimit' => 'Enabled: No limit of accounts',	// TODO
					'setaccountsnumber' => 'Set max. number of accounts',	// TODO
				),
			),
			'status' => array(
				'disabled' => 'Form disabled',	// TODO
				'enabled' => 'Form enabled',	// TODO
			),
			'title' => 'User registration form',	// TODO
		),
	),
	'update' => array(
		'_' => '更新系统',
		'apply' => '应用',
		'check' => '检查更新',
		'current_version' => '当前 FreshRSS 版本为 %s。',
		'last' => '上一次检查：%s',
		'none' => '没有可用更新',
		'title' => '更新系统',
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

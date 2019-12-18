<?php

return array(
	'action' => array(
		'finish' => '完成安装',
		'fix_errors_before' => '请在继续下一步前修复错误。',
		'keep_install' => '保留以前配置',
		'next_step' => '下一步',
		'reinstall' => '重新安装 FreshRSS',
	),
	'auth' => array(
		'form' => 'Web form (传统方式, 需要 JavaScript)',
		'http' => 'HTTP (面向启用 HTTPS 的高级用户)',
		'none' => '无 (危险)',
		'password_form' => '密码<br /><small>(用于 Web-form 登录方式)</small>',
		'password_format' => '至少 7 个字符',
		'type' => '认证方式',
	),
	'bdd' => array(
		'conf' => array(
			'ko' => '请验证你的数据库信息。',
			'ok' => '数据库配置已保存。',
			'_' => '数据库配置',
		),
		'host' => '主机',
		'password' => '密码',
		'prefix' => '表前缀',
		'type' => '数据库类型',
		'username' => '用户名',
		'_' => '数据库',
	),
	'check' => array(
		'already_installed' => '我们检测到 FreshRSS 已经安装！',
		'cache' => array(
			'nok' => '请检查 <em>./data/cache</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'cache 目录权限正常。',
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
		'dom' => array(
			'nok' => '找不到用于浏览 DOM 的库 (php-xml) 。',
			'ok' => '已找到用于浏览 DOM 的库。',
		),
		'favicons' => array(
			'nok' => '请检查 <em>./data/favicons</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'favicons 目录权限正常。',
		),
		'fileinfo' => array(
			'nok' => '找不到 PHP fileinfo 库 (fileinfo) 。',
			'ok' => '已找到 fileinfo 库。',
		),
		'http_referer' => array(
			'nok' => '请检查你是否修改了 HTTP REFERER。',
			'ok' => '你的 HTTP REFERER 已知且与服务器一致。',
		),
		'json' => array(
			'nok' => '找不到推荐的 JSON 解析库。',
			'ok' => '已找到推荐的 JSON 解析库。',
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
		),
		'users' => array(
			'nok' => '请检查 <em>./data/users</em> 目录权限。HTTP 服务器必须有其写入权限。',
			'ok' => 'users 目录权限正常。',
		),
		'xml' => array(
			'nok' => '找不到用于 XML 解析库。',
			'ok' => '已找到 XML 解析库。',
		),
		'_' => '检查',
	),
	'conf' => array(
		'ok' => '常规配置已保存。',
		'_' => '常规配置',
	),
	'congratulations' => '恭喜！',
	'default_user' => '默认用户名 <small>(最大 16 个数字或字母)</small>',
	'delete_articles_after' => '保留文章',
	'fix_errors_before' => '请在继续下一步前修复错误。',
	'javascript_is_better' => '启用 JavaScript 会使 FreshRSS 工作得更好',
	'js' => array(
		'confirm_reinstall' => '重新安装 FreshRSS 将会重置之前的配置。你确定要继续吗？',
	),
	'language' => array(
		'choose' => '为 FreshRSS 选择语言',
		'defined' => '语言已指定。',
		'_' => '语言',
	),
	'not_deleted' => '出错！你必须手动删除文件 <em>%s</em>。',
	'ok' => '安装成功。',
	'step' => '步骤 %d',
	'steps' => '步骤',
	'this_is_the_end' => '最后一步',
	'title' => '安装 FreshRSS',
);

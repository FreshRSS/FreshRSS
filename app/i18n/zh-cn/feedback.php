<?php

return array(
	'access' => array(
		'denied' => '你无权访问此页面',
		'not_found' => '你寻找的页面不存在',
	),
	'admin' => array(
		'optimization_complete' => '优化完成',
	),
	'api' => array(
		'password' => array(
			'failed' => '您的密码无法修改',
			'updated' => '您的密码已修改完成',
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => '配置认证方式时出错，请稍后重试。',
			'set' => '网页表单是你当前默认的认证方式。',
		),
		'login' => array(
			'invalid' => '用户名或密码无效',
			'success' => '登录成功',
		),
		'logout' => array(
			'success' => '登出成功',
		),
		'no_password_set' => '管理员密码尚未设置。此特性不可用。',
	),
	'conf' => array(
		'error' => '保存配置时出错',
		'query_created' => '查询 "%s" 已创建。',
		'shortcuts_updated' => '快捷键已更新',
		'updated' => '配置已更新',
	),
	'extensions' => array(
		'already_enabled' => '%s 已启用',
		'cannot_remove' => '无法删除 %s',
		'disable' => array(
			'ko' => '禁用 %s 失败。<a href="%s">检查 FreshRSS 日志</a> 查看详情。',
			'ok' => '%s 现已禁用',
		),
		'enable' => array(
			'ko' => '%s 启用失败。<a href="%s">检查 FreshRSS 日志</a> 查看详情。',
			'ok' => '%s 现已禁用',
		),
		'no_access' => '你无权访问 %s',
		'not_enabled' => '%s 未启用',
		'not_found' => '%s 不存在',
		'removed' => '%s 已删除',
	),
	'import_export' => array(
		'export_no_zip_extension' => '服务器未启用 ZIP 扩展。请尝试逐个导出文件。',
		'feeds_imported' => '你的订阅已导入，即将刷新',
		'feeds_imported_with_errors' => '你的订阅源已导入，但发生错误',
		'file_cannot_be_uploaded' => '文件未能上传！',
		'no_zip_extension' => '服务器未启用 ZIP 扩展。',
		'zip_error' => '导入 ZIP 文件时出错',
	),
	'profile' => array(
		'error' => '你的帐户修改失败',
		'updated' => '你的帐户已修改成功',
	),
	'sub' => array(
		'actualize' => '获取',
		'articles' => array(
			'marked_read' => '文章已标记为已读',
			'marked_unread' => '文章已标记为未读',
		),
		'category' => array(
			'created' => '已创建分类 %s',
			'deleted' => '已删除分类',
			'emptied' => '已清空分类',
			'error' => '更新分类失败',
			'name_exists' => '分类名已存在',
			'no_id' => '你必须明确分类编号',
			'no_name' => '分类名不能为空',
			'not_delete_default' => '你不能删除默认分类！',
			'not_exist' => '分类不存在！',
			'over_max' => '你已达到分类数上限（%d）',
			'updated' => '已更新分类',
		),
		'feed' => array(
			'actualized' => '已更新 <em>%s</em>',
			'actualizeds' => '已更新订阅源',
			'added' => '订阅源 <em>%s</em> 已添加',
			'already_subscribed' => '你已订阅 <em>%s</em>',
			'cache_cleared' => '<em>%s</em> 缓存已清理',
			'deleted' => '已删除订阅源',
			'error' => '订阅源更新失败',
			'internal_problem' => '订阅源添加失败。<a href="%s">检查 FreshRSS 日志</a> 查看详情。你可以在地址链接后附加 <code>#force_feed</code> 从而尝试强制添加。',
			'invalid_url' => '地址链接 <em>%s</em> 无效',
			'n_actualized' => '已更新 %d 个订阅源',
			'n_entries_deleted' => '已删除 %d 篇文章',
			'no_refresh' => '没有可刷新的订阅源…',
			'not_added' => '<em>%s</em> 添加失败',
			'not_found' => '无法找到订阅',
			'over_max' => '你已达到订阅源数上限（%d）',
			'reloaded' => '<em>%s</em> 已重置',
			'selector_preview' => array(
				'http_error' => '无法加载网站内容。',
				'no_entries' => '您的订阅中没有任何条目。您至少需要一个条目来创建一个预览。',
				'no_feed' => '网络错误（订阅源不存在）',
				'no_result' => '选择器没有匹配到任何东西。作为备用，原始的feed文本将被显示出来。',
				'selector_empty' => '选择器是空的。你需要一个来创建预览。',
			),
			'updated' => '已更新订阅源',
		),
		'purge_completed' => '清除完成（已删除 %d 篇文章）',
	),
	'tag' => array(
		'created' => '标签 "%s" 已创建。',
		'name_exists' => '标签名已存在。',
		'renamed' => '标签 "%s" 已被重命名为 "%s"。',
	),
	'update' => array(
		'can_apply' => 'FreshRSS 将更新到 <strong>版本 %s</strong>.',
		'error' => '更新出错：%s',
		'file_is_nok' => '请检查 <em>%s</em> 目录权限。HTTP 服务器必须有其写入权限。',
		'finished' => '更新完成！',
		'none' => '没有可用更新',
		'server_not_found' => '找不到更新服务器 [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => '已创建用户 %s',
			'error' => '创建用户 %s 失败',
		),
		'deleted' => array(
			'_' => '已删除用户 %s',
			'error' => '删除用户 %s 失败',
		),
		'updated' => array(
			'_' => '已更新用户 %s',
			'error' => '更新用户 %s 失败',
		),
	),
);

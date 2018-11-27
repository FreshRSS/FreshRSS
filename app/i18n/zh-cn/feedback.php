<?php

return array(
	'admin' => array(
		'optimization_complete' => '优化完成',
	),
	'access' => array(
		'denied' => '你无权访问此页面',
		'not_found' => '你寻找的页面不存在',
	),
	'auth' => array(
		'form' => array(
			'not_set' => '配置认证方式时出错。请稍后重试。',
			'set' => 'Form 是你当前默认的认证方式。',
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
		'disable' => array(
			'ko' => '%s 禁用失败。<a href="%s">检查 FreshRSS 日志</a> 查看详情。',
			'ok' => '%s 现已禁用',
		),
		'enable' => array(
			'ko' => '%s 启用失败。<a href="%s">检查 FreshRSS 日志</a> 查看详情。',
			'ok' => '%s 现已禁用',
		),
		'no_access' => '你无权访问 %s',
		'not_enabled' => '%s 未启用',
		'not_found' => '%s 不存在',
	),
	'import_export' => array(
		'export_no_zip_extension' => '服务器未启用 ZIP 扩展。请尝试逐个导出文件。',
		'feeds_imported' => '你的 RSS 源已导入，即将更新',
		'feeds_imported_with_errors' => '你的 RSS 源已导入，但发生错误',
		'file_cannot_be_uploaded' => '文件未能上传！',
		'no_zip_extension' => '服务器未启用 ZIP 扩展。',
		'zip_error' => '导入 ZIP 文件时出错',
	),
	'profile' => array(
		'error' => '你的帐户修改失败',
		'updated' => '你的帐户已修改',
	),
	'sub' => array(
		'actualize' => '获取',
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',	//TODO - Translation
			'marked_unread' => 'The articles have been marked as unread.',	//TODO - Translation
		),
		'category' => array(
			'created' => '分类 %s 已创建。',
			'deleted' => '分类已删除。',
			'emptied' => '分类已清空。',
			'error' => '分类更新失败。',
			'name_exists' => '分类名已存在。',
			'no_id' => '你必须明确分类 ID',
			'no_name' => '分类名不能为空。',
			'not_delete_default' => '你不能删除默认分类！',
			'not_exist' => '分类不存在！',
			'over_max' => '你已达到分类数限制 (%d)',
			'updated' => '分类已更新。',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> 已更新',
			'actualizeds' => 'RSS 源已更新',
			'added' => 'RSS 源 <em>%s</em> 已添加',
			'already_subscribed' => '你已订阅 <em>%s</em>',
			'deleted' => 'RSS 源已删除',
			'error' => 'RSS 源更新失败',
			'internal_problem' => 'RSS 源添加失败。<a href="%s">检查 FreshRSS 日志</a> 查看详情。',	//TODO - Translation
			'invalid_url' => 'URL <em>%s</em> 无效',
			'n_actualized' => '%d 个 RSS 源已更新',
			'n_entries_deleted' => '%d 篇文章已删除',
			'no_refresh' => '没有可刷新的 RSS 源…',
			'not_added' => '<em>%s</em> 添加失败',
			'over_max' => '你已达到 RSS 源数限制 (%d)',
			'updated' => 'RSS 源已更新',
		),
		'purge_completed' => '清除完成 (%d 篇文章已删除)',
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
			'_' => '用户 %s 已创建',
			'error' => '用户 %s 创建失败',
		),
		'deleted' => array(
			'_' => '用户 %s 已删除',
			'error' => '用户 %s 删除失败',
		),
		'updated' => array(
			'_' => 'User %s has been updated',	//TODO - Translation
			'error' => 'User %s has not been updated',	//TODO - Translation
		),
	),
);

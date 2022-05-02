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
	'action' => array(
		'actualize' => '更新提要',
		'add' => '添加',
		'back' => '← 返回',
		'back_to_rss_feeds' => '← 返回订阅源',
		'cancel' => '取消',
		'create' => '创建',
		'demote' => '撤销管理员',
		'disable' => '禁用',
		'empty' => '清空',
		'enable' => '启用',
		'export' => '导出',
		'filter' => '过滤',
		'import' => '导入',
		'load_default_shortcuts' => '重置快捷键',
		'manage' => '管理',
		'mark_read' => '标记已读',
		'open_url' => '打开链接',
		'promote' => '设为管理员',
		'purge' => '清理',
		'remove' => '删除',
		'rename' => '重命名',
		'see_website' => '网站中查看',
		'submit' => '提交',
		'truncate' => '删除所有文章',
		'update' => '更新订阅',
	),
	'auth' => array(
		'accept_tos' => '我接受 <a href="%s">服务条款</a>',
		'email' => 'Email 地址',
		'keep_logged_in' => '<small>%s</small> 天内保持登录',
		'login' => '登录',
		'logout' => '登出',
		'password' => array(
			'_' => '密码',
			'format' => '<small>至少 7 个字符</small>',
		),
		'registration' => array(
			'_' => '新用户',
			'ask' => '创建新用户？',
			'title' => '用户创建',
		),
		'username' => array(
			'_' => '用户名',
			'format' => '<small>最多 16 个数字或字母</small>',
		),
	),
	'date' => array(
		'Apr' => '\\四\\月',
		'Aug' => '\\八\\月',
		'Dec' => '\\十\\二\\月',
		'Feb' => '\\二\\月',
		'Jan' => '\\一\\月',
		'Jul' => '\\七\\月',
		'Jun' => '\\六\\月',
		'Mar' => '\\三\\月',
		'May' => '\\五\\月',
		'Nov' => '\\十\\一\\月',
		'Oct' => '\\十\\月',
		'Sep' => '\\九\\月',
		'apr' => '四月',
		'april' => '四月',
		'aug' => '八月',
		'august' => '八月',
		'before_yesterday' => '昨天以前',
		'dec' => '十二月',
		'december' => '十二月',
		'feb' => '二月',
		'february' => '二月',
		'format_date' => 'Y\\年n\\月j\\日',
		'format_date_hour' => 'Y\\年n\\月j\\日	H\\:i',
		'fri' => '周五',
		'jan' => '一月',
		'january' => '一月',
		'jul' => '七月',
		'july' => '七月',
		'jun' => '六月',
		'june' => '六月',
		'last_2_year' => '过去两年',
		'last_3_month' => '最近三个月',
		'last_3_year' => '过去三年',
		'last_5_year' => '过去五年',
		'last_6_month' => '最近六个月',
		'last_month' => '上月',
		'last_week' => '上周',
		'last_year' => '去年',
		'mar' => '三月',
		'march' => '三月',
		'may' => '五月',
		'may_' => '五月',
		'mon' => '周一',
		'month' => '个月',
		'nov' => '十一月',
		'november' => '十一月',
		'oct' => '十月',
		'october' => '十月',
		'sat' => '周六',
		'sep' => '九月',
		'september' => '九月',
		'sun' => '周日',
		'thu' => '周四',
		'today' => '今天',
		'tue' => '周二',
		'wed' => '周三',
		'yesterday' => '昨天',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => '关于 FreshRSS',
	),
	'js' => array(
		'category_empty' => '清空分类',
		'confirm_action' => '你确定要执行此操作吗？这将不可撤销！',
		'confirm_action_feed_cat' => '你确定要执行此操作吗？你将丢失相关的收藏和自定义查询。这将不可撤销！',
		'feedback' => array(
			'body_new_articles' => 'FreshRSS 中有 %%d 篇文章等待阅读。',
			'body_unread_articles' => '(未读: %%d)',
			'request_failed' => '请求失败，这可能是因为网络连接问题。',
			'title_new_articles' => 'FreshRSS: 新文章！',
		),
		'new_article' => '发现新文章，点击刷新页面。',
		'should_be_activated' => '必须启用 JavaScript',
	),
	'lang' => array(
		'cz' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
	),
	'menu' => array(
		'about' => '关于',
		'account' => '账户',
		'admin' => '管理',
		'archiving' => '归档',
		'authentication' => '认证',
		'check_install' => '环境检查',
		'configuration' => '配置',
		'display' => '显示',
		'extensions' => '扩展',
		'logs' => '日志',
		'queries' => '自定义查询',
		'reading' => '阅读',
		'search' => '搜索内容或#标签',
		'sharing' => '分享',
		'shortcuts' => '快捷键',
		'stats' => '统计',
		'system' => '系统配置',
		'update' => '更新',
		'user_management' => '用户管理',
		'user_profile' => '用户帐户',
	),
	'period' => array(
		'days' => '天',
		'hours' => '时',
		'months' => '月',
		'weeks' => '周',
		'years' => '年',
	),
	'share' => array(
		'Known' => '基于 Known 的站点',
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => '剪贴板',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => '邮箱',	// IGNORE
		'facebook' => '脸书',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => '打印',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => '推特',	// IGNORE
		'wallabag' => 'Wallabag v1',	// IGNORE
		'wallabagv2' => 'Wallabag v2',	// IGNORE
		'web-sharing-api' => 'Web分享',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => '警告!',
		'blank_to_disable' => '留空以禁用',
		'by_author' => '作者',
		'by_default' => '默认',
		'damn' => '错误！',
		'default_category' => '未分类',
		'no' => '否',
		'not_applicable' => '不可用',
		'ok' => '正常！',
		'or' => '或',
		'yes' => '是',
	),
	'stream' => array(
		'load_more' => '载入更多文章',
		'mark_all_read' => '全部设为已读',
		'nothing_to_load' => '没有更多文章',
	),
);

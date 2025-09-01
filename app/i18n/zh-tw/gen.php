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
		'add' => '新增',
		'back_to_rss_feeds' => '← 返回訂閱源',
		'cancel' => '取消',
		'close' => 'Close',	// TODO
		'create' => '創建',
		'delete_all_feeds' => 'Delete all feeds',	// TODO
		'delete_errored_feeds' => 'Delete feeds with errors',	// TODO
		'delete_muted_feeds' => '刪除已暫停的訂閱源',
		'demote' => '撤銷管理員',
		'disable' => '禁用',
		'download' => 'Download',	// TODO
		'empty' => '清空',
		'enable' => '啟用',
		'export' => '導出',
		'filter' => '過濾',
		'import' => '導入',
		'load_default_shortcuts' => '重置快捷鍵',
		'manage' => '管理',
		'mark_read' => '標記已讀',
		'menu' => array(
			'open' => '開啟選單',
		),
		'nav_buttons' => array(
			'next' => '下一篇文章',
			'prev' => '預覽文章',
			'up' => '回上一篇',
		),
		'open_url' => '打開連結',
		'promote' => '設為管理員',
		'purge' => '清理',
		'refresh_opml' => '更新訂閱源動態列表',
		'remove' => '刪除',
		'rename' => '重命名',
		'see_website' => '網站中查看',
		'submit' => '提交',
		'truncate' => '刪除所有文章',
		'update' => '更新訂閱',
	),
	'auth' => array(
		'accept_tos' => '我接受 <a href="%s">服務條款</a>',
		'email' => 'Email 地址',
		'keep_logged_in' => '<small>%s</small> 天內保持登入',
		'login' => '登入',
		'logout' => '登出',
		'password' => array(
			'_' => '密碼',
			'format' => '<small>至少 7 個字元</small>',
		),
		'reauth' => array(
			'header' => 'Reauthentication is required',	// TODO
			'tip' => 'You won’t be asked to sign in again for <u>%d minutes</u>',	// TODO
			'title' => 'Reauthentication',	// TODO
		),
		'registration' => array(
			'_' => '新使用者',
			'ask' => '創建新使用者？',
			'title' => '使用者創建',
		),
		'username' => array(
			'_' => '帳號',
			'format' => '<small>最多 16 個數字或字母</small>',
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
		'fri' => '週五',
		'jan' => '一月',
		'january' => '一月',
		'jul' => '七月',
		'july' => '七月',
		'jun' => '六月',
		'june' => '六月',
		'last_2_year' => '過去兩年',
		'last_3_month' => '最近三個月',
		'last_3_year' => '過去三年',
		'last_5_year' => '過去五年',
		'last_6_month' => '最近六個月',
		'last_month' => '上月',
		'last_week' => '上週',
		'last_year' => '去年',
		'mar' => '三月',
		'march' => '三月',
		'may' => '五月',
		'may_' => '五月',
		'mon' => '週一',
		'month' => '個月',
		'nov' => '十一月',
		'november' => '十一月',
		'oct' => '十月',
		'october' => '十月',
		'sat' => '週六',
		'sep' => '九月',
		'september' => '九月',
		'sun' => '週日',
		'thu' => '週四',
		'today' => '今天',
		'tue' => '週二',
		'wed' => '週三',
		'yesterday' => '昨天',
	),
	'dir' => 'ltr',	// IGNORE
	'flag' => '🇹🇼',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => '關於 FreshRSS',
	),
	'js' => array(
		'category_empty' => '清空分類',
		'confirm_action' => '你確定要執行此操作嗎？這將不可撤銷！',
		'confirm_action_feed_cat' => '你確定要執行此操作嗎？你將丟失相關的收藏和自定義查詢。這將不可撤銷！',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => 'FreshRSS 中有 %%d 篇文章等待閱讀。',
			'body_unread_articles' => '(未讀: %%d)',
			'request_failed' => '請求失敗，這可能是因為網絡連接問題。',
			'title_new_articles' => 'FreshRSS: 新文章！',
		),
		'labels_empty' => '沒有標籤',
		'new_article' => '發現新文章，點擊刷新頁面。',
		'should_be_activated' => '必須啟用 JavaScript',
		'unsafe_csp_header' => 'The CSP header in use is unsafe and FreshRSS may be vulnerable to XSS attacks. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">See documentation</a>',	// TODO
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'pt-pt' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '簡體中文',	// IGNORE
		'zh-tw' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => '關於',
		'account' => '帳號',
		'admin' => '管理',
		'archiving' => '歸檔',
		'authentication' => '認證',
		'check_install' => '環境檢查',
		'configuration' => '配置',
		'display' => '顯示',
		'extensions' => '擴充功能',
		'logs' => '日誌',
		'privacy' => 'Privacy',	// TODO
		'queries' => '自定義查詢',
		'reading' => '閱讀',
		'search' => '搜尋內容或#標簽',
		'search_help' => '請見文檔內的進階的<a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">搜尋參數</a>',
		'sharing' => '分享',
		'shortcuts' => '快捷鍵',
		'stats' => '統計',
		'system' => '系統配置',
		'update' => '更新',
		'user_management' => '使用者管理',
		'user_profile' => '使用者資訊',
	),
	'period' => array(
		'days' => '天',
		'hours' => '時',
		'months' => '月',
		'weeks' => '週',
		'years' => '年',
	),
	'share' => array(
		'Known' => '基於 Known 的站點',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => '剪貼板',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => '郵箱',	// IGNORE
		'email-webmail-firefox-fix' => 'Email (webmail - Firefox專用修正)',
		'facebook' => '臉書',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => '打印',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
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
		'by_default' => '預設',
		'damn' => '錯誤！',
		'default_category' => '未分類',
		'no' => '否',
		'not_applicable' => '不可用',
		'ok' => '正常！',
		'or' => '或',
		'yes' => '是',
	),
	'stream' => array(
		'load_more' => '載入更多文章',
		'mark_all_read' => '全部設為已讀',
		'nothing_to_load' => '沒有更多文章',
	),
);

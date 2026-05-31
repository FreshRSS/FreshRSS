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
	'action' => array(
		'actualize' => '更新訂閱源',
		'add' => '新增',
		'back_to_rss_feeds' => '← 返回到您的 RSS 訂閱源',
		'cancel' => '取消',
		'close' => '關閉',
		'create' => '建立',
		'delete_all_feeds' => '刪除所有訂閱源',
		'delete_errored_feeds' => '刪除有錯誤的訂閱源',
		'delete_muted_feeds' => '刪除已靜音的訂閱源',
		'demote' => '降級為使用者',
		'disable' => '停用',
		'download' => '下載',
		'empty' => '清空',
		'enable' => '啟用',
		'export' => '匯出',
		'filter' => '過濾',
		'import' => '匯入',
		'load_default_shortcuts' => '載入預設快速鍵',
		'manage' => '管理',
		'mark_read' => '標記為已讀',
		'menu' => array(
			'open' => '開啟選單',
		),
		'nav_buttons' => array(
			'next' => '下篇文章',
			'prev' => '上篇文章',
			'up' => '回到上方',
		),
		'open_url' => '開啟 URL',
		'promote' => '升級為管理員',
		'purge' => '清理',
		'refresh_opml' => '刷新 OPML',
		'remove' => '移除',
		'rename' => '重新命名',
		'see_website' => '查看網站',
		'submit' => '提交',
		'truncate' => '刪除所有文章',
		'update' => '更新',
	),
	'auth' => array(
		'accept_tos' => '我接受 <a href="%s">服務條款</a>',
		'email' => '電子郵件位址',
		'keep_logged_in' => '<small>%s</small> 天內保持登入',
		'login' => '登入',
		'logout' => '登出',
		'password' => array(
			'_' => '密碼',
			'format' => '<small>至少 7 個字元</small>',
		),
		'reauth' => array(
			'header' => '需要重新驗證',
			'tip' => '您在 <u>%d 分鐘</u> 內不會再被要求重新登入',
			'title' => '重新驗證',
		),
		'registration' => array(
			'_' => '新帳號',
			'ask' => '建立帳號？',
			'title' => '帳號建立',
		),
		'username' => array(
			'_' => '使用者名稱',
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
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => '關於 FreshRSS',
	),
	'interval' => array(
		'day' => array(
			0 => '%d 天前',
		),
		'hour' => array(
			0 => '%d 小時前',
		),
		'justnow' => '剛剛',
		'minute' => array(
			0 => '%d 分鐘前',
		),
		'month' => array(
			0 => '%d 個月前',
		),
		'second' => array(
			0 => '%d 秒前',
		),
		'year' => array(
			0 => '%d 年前',
		),
	),
	'js' => array(
		'category_empty' => '清空類別',
		'confirm_action' => '您確定要執行此動作嗎？這無法被取消！',
		'confirm_action_feed_cat' => '您確定要執行此操作嗎？您將丟失相關的收藏和使用者查詢。這無法被取消！',
		'confirm_exit_slider' => '您確定要丟棄所有未儲存的設定嗎？',
		'feedback' => array(
			'body_new_articles' => 'FreshRSS 中有 %%d 篇文章待閱讀。',
			'body_unread_articles' => '(未讀: %%d)',
			'request_failed' => '請求失敗，有可能是網路連線問題造成的。',
			'title_new_articles' => 'FreshRSS: 新文章！',
		),
		'labels_empty' => '無標籤',
		'new_article' => '有新文章可用，點擊以刷新頁面。',
		'should_be_activated' => '必須啟用 JavaScript',
		'unsafe_csp_header' => '目前使用的 CSP 標頭不安全，FreshRSS 可能會受到 XSS 攻擊。<a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">請參閱說明文件</a>',
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
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
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => '關於',
		'account' => '帳號',
		'admin' => '管理',
		'advanced_search' => '進階搜尋',
		'archiving' => '歸檔',
		'authentication' => '驗證',
		'check_install' => '安裝檢查',
		'configuration' => '配置',
		'display' => '顯示',
		'extensions' => '擴充功能',
		'logs' => '紀錄',
		'privacy' => '隱私',
		'queries' => '使用者查詢',
		'reading' => '閱讀',
		'search' => '搜尋內容或#標籤',
		'search_help' => '請參閱說明文件內的進階<a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">搜尋參數</a>',
		'sharing' => '分享',
		'shortcuts' => '快速鍵',
		'stats' => '統計',
		'system' => '系統配置',
		'update' => '更新',
		'user_management' => '管理使用者',
		'user_profile' => '使用者設定檔',
	),
	'period' => array(
		'days' => '天',
		'hours' => '時',
		'months' => '月',
		'weeks' => '週',
		'years' => '年',
	),
	'readme' => array(
		'contribute' => 'contribute',	// IGNORE
		'language' => 'Language',	// IGNORE
		'translated' => 'Progress',	// IGNORE
	),
	'search' => array(
		'advanced_search_help' => '此表單旨在輔助建立搜尋查詢，但手動查詢效果更好。',
		'authors' => '作者',
		'categories' => '類別',
		'content' => '內容',
		'date_from' => '從',
		'date_modified' => '伺服器修改日期',
		'date_past' => 'In the past',	// TODO
		'date_published' => '發表日期',
		'date_range' => '日期範圍',
		'date_received' => '接收日期',
		'date_to' => '到',
		'date_user' => '使用者修改日期',
		'feeds' => '訂閱源',
		'free_text' => 'Free Text',	// TODO
		'free_text_help' => 'Search both in title and content',	// TODO
		'full_documentation' => '檢視 <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">完整搜尋說明文件</a>',
		'labels' => '我的標籤',
		'multiple_help' => '選擇一個或更多 (按住 <kbd>Ctrl</kbd> 或 <kbd>Cmd</kbd>)',
		'sources' => '來源',
		'tags' => '文章標籤',
		'text' => '文字搜尋',
		'text_help' => 'Multiple lines are combined by a logical <i>or</i>. Also supports <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">regular expressions</a>.',	// TODO
		'text_placeholder' => '關鍵字',
		'title' => '標題',
		'url' => 'URL',	// IGNORE
		'user_queries' => '使用者查詢',
	),
	'share' => array(
		'Known' => '基於已知的站點',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => '剪貼簿',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'Email',	// IGNORE
		'email-webmail-firefox-fix' => '電子郵件 (webmail - Firefox 專用修正)',
		'facebook' => 'Facebook',	// IGNORE
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
		'print' => '列印',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'Wallabag v1',	// IGNORE
		'wallabagv2' => 'Wallabag v2',	// IGNORE
		'web-sharing-api' => '系統分享',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => '警告！',
		'blank_to_disable' => '留空以停用',
		'by_author' => '作者:',
		'by_default' => '預設',
		'damn' => '錯誤！',
		'default_category' => '未分類',
		'no' => '否',
		'not_applicable' => '不可用',
		'ok' => '沒問題！',
		'or' => '或',
		'yes' => '是',
	),
	'stream' => array(
		'load_more' => '載入更多文章',
		'mark_all_read' => '標記全部為已讀',
		'nothing_to_load' => '沒有更多文章了',
	),
);

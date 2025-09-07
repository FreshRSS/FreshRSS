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
		'allow_anonymous' => '允許匿名閱讀預設使用者（%s）的文章',
		'allow_anonymous_refresh' => '允許匿名刷新文章',
		'api_enabled' => '允許 <abbr>API</abbr> 訪問 <small>（用於手機應用 and sharing user queries）</small>',	// DIRTY
		'form' => '網頁表單（傳統方式, 需要 JavaScript)',
		'http' => 'HTTP (advanced: managed by Web server, OIDC, SSO…)',	// TODO
		'none' => '無認證（危險）',
		'title' => '認證',
		'token' => '主要驗證權杖',
		'token_help' => '允許存取使用者的所有 RSS 輸出以及重整源而無需身份驗證:',
		'type' => '認證方式',
		'unsafe_autologin' => '允許不安全的自動登入方式：',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => '請檢查 <em>./data/cache</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
			'ok' => 'cache 目錄權限正常',
		),
		'categories' => array(
			'nok' => 'Category 表配置錯誤',
			'ok' => 'Category 表正常',
		),
		'connection' => array(
			'nok' => '資料庫連接失敗',
			'ok' => '資料庫連接正常',
		),
		'ctype' => array(
			'nok' => '找不到字元類型檢測庫（php-ctype）',
			'ok' => '已找到字元類型檢測庫 （php-ctype）',
		),
		'curl' => array(
			'nok' => '找不到 cURL 庫(php-cURL)',
			'ok' => '已找到 cURL 庫(php-cURL)',
		),
		'data' => array(
			'nok' => '請檢查 <em>./data</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
			'ok' => 'data 目錄權限正常',
		),
		'database' => '資料庫相關',
		'dom' => array(
			'nok' => '找不到用於瀏覽 DOM 的庫（php-xml）',
			'ok' => '已找到用於瀏覽 DOM 的庫(php-xml)',
		),
		'entries' => array(
			'nok' => 'Entry 表配置錯誤',
			'ok' => 'Entry 表正常',
		),
		'favicons' => array(
			'nok' => '請檢查 <em>./data/favicons</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
			'ok' => 'favicons 目錄權限正常',
		),
		'feeds' => array(
			'nok' => 'Feed 表配置錯誤',
			'ok' => 'Feed 表正常',
		),
		'fileinfo' => array(
			'nok' => '找不到 fileinfo 庫（php-fileinfo）',
			'ok' => '已找到 fileinfo 庫(php-fileinfo)',
		),
		'files' => '文件相關',
		'json' => array(
			'nok' => '找不到 JSON 擴展（php-json ）',
			'ok' => '已找到 JSON 擴展(php-json)',
		),
		'mbstring' => array(
			'nok' => '找不到推薦的 Unicode 解析庫（mbstring)',
			'ok' => '已找到推薦的 Unicode 解析庫（mbstring)',
		),
		'pcre' => array(
			'nok' => '找不到正則表達式解析庫（php-pcre）',
			'ok' => '已找到正則表達式解析庫（php-pcre）',
		),
		'pdo' => array(
			'nok' => '找不到 PDO 或支持的驅動（pdo_mysql、pdo_sqlite、pdo_pgsql）',
			'ok' => '已找到 PDO 和支持的至少一種驅動（pdo_mysql、pdo_sqlite、pdo_pgsql）',
		),
		'php' => array(
			'_' => 'PHP 相關',
			'nok' => '你的 PHP 版本為 %s，但 FreshRSS 最低需要 %s',
			'ok' => '你的 PHP 版本為 %s，與 FreshRSS 相容',
		),
		'tables' => array(
			'nok' => '資料庫中缺少一個或多個表',
			'ok' => '資料庫中相關表存在',
		),
		'title' => '環境檢查',
		'tokens' => array(
			'nok' => '請檢查 <em>./data/tokens</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
			'ok' => 'tokens 目錄權限正常',
		),
		'users' => array(
			'nok' => '請檢查 <em>./data/users</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
			'ok' => 'users 目錄權限正常',
		),
		'zip' => array(
			'nok' => '找不到 ZIP 擴展（php-zip）',
			'ok' => '已找到 ZIP 擴展',
		),
	),
	'extensions' => array(
		'author' => '作者',
		'community' => '可用的社群擴充功能',
		'description' => '描述',
		'disabled' => '已禁用',
		'empty_list' => '沒有已安裝的擴充功能',
		'empty_list_help' => 'Check the logs to determine the reason behind the empty extension list.',	// TODO
		'enabled' => '已啟用',
		'latest' => '已安裝',
		'name' => '名稱',
		'no_configure_view' => '此擴充功能不能配置。',
		'system' => array(
			'_' => '系統擴充功能',
			'no_rights' => '系統擴充功能（你無權修改）',
		),
		'title' => '擴充功能',
		'update' => '更新可用',
		'user' => '用戶擴充功能',
		'version' => '版本',
	),
	'stats' => array(
		'_' => '統計',
		'all_feeds' => '所有訂閱源',
		'category' => '分類',
		'entry_count' => '文章數',
		'entry_per_category' => '各分類文章數',
		'entry_per_day' => '近三十日每日文章數',
		'entry_per_day_of_week' => '一週各日（平均：%.2f 條消息)',
		'entry_per_hour' => '各小時（平均：%.2f 條消息)',
		'entry_per_month' => '各月（平均：%.2f 條消息)',
		'entry_repartition' => '文章分布',
		'feed' => '訂閱源',
		'feed_per_category' => '各分類訂閱源數',
		'idle' => '長期無更新訂閱源',
		'main' => '主要統計',
		'main_stream' => '首頁',
		'no_idle' => '訂閱源近期皆有更新！',
		'number_entries' => '%d 篇文章',
		'overview' => 'Overview',	// TODO
		'percent_of_total' => '%',
		'repartition' => '文章分布: %s',	// DIRTY
		'status_favorites' => '收藏',
		'status_read' => '已讀',
		'status_total' => '總計',
		'status_unread' => '未讀',
		'title' => '統計',
		'top_feed' => '前十訂閱源',
	),
	'system' => array(
		'_' => '系統配置',
		'auto-update-url' => '自動升級伺服器地址',
		'base-url' => array(
			'_' => '基本URL',
			'recommendation' => '自動推薦: <kbd>%s</kbd>',
		),
		'cookie-duration' => array(
			'help' => '單位（秒）',
			'number' => '保持登錄的時長',
		),
		'force_email_validation' => '強制驗證郵箱地址',
		'instance-name' => '實例名稱',
		'max-categories' => '各使用者分類數限制',
		'max-feeds' => '各使用者訂閱源數限制',
		'registration' => array(
			'number' => '最大使用者數',
			'select' => array(
				'label' => '註冊表單',
				'option' => array(
					'noform' => '禁用，無註冊表單',
					'nolimit' => '啟用，且無帳號限制',
					'setaccountsnumber' => '設置使用者數的最大值',
				),
			),
			'status' => array(
				'disabled' => '註冊表單禁用',
				'enabled' => '註冊表單啟用',
			),
			'title' => '使用者註冊表單',
		),
		'sensitive-parameter' => '敏感參數。手動編輯於 <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => '未被給予',
			'enabled' => '<a href="./?a=tos">為啟用的</a>',
			'help' => '如何 <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">啟用服務條款</a>',
		),
		'websub' => array(
			'help' => '關於 <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => '更新系統',
		'apply' => '應用',
		'changelog' => '更新紀錄',
		'check' => '檢查更新',
		'copiedFromURL' => 'update.php 複製從 %s 至 ./data',
		'current_version' => '當前 版本為',
		'last' => '上次檢查',
		'loading' => '更新中…',
		'none' => '沒有可用更新',
		'releaseChannel' => array(
			'_' => '發佈通道',
			'edge' => '滾動式發佈(“edge”)',
			'latest' => '穩定式發佈(“latest”)',
		),
		'title' => '系統更新',
		'viaGit' => '從git並由GitHub.com開始',
	),
	'user' => array(
		'admin' => '管理員',
		'article_count' => '文章數',
		'back_to_manage' => '← 返回使用者列表',
		'create' => '新增使用者',
		'database_size' => '資料庫大小',
		'email' => '郵箱地址',
		'enabled' => '已啟用',
		'feed_count' => '訂閱源數',
		'is_admin' => '管理員',
		'language' => '語言',
		'last_user_activity' => '上次使用者活躍',
		'list' => '使用者列表',
		'number' => '已有 %d 個使用者',
		'numbers' => '已有 %d 個使用者',
		'password_form' => '密碼<br /><small>（用於網頁表單登錄方式）</small>',
		'password_format' => '至少 7 個字元',
		'title' => '使用者管理',
		'username' => '使用者名稱',
	),
);

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
		'finish' => '完成安裝',
		'fix_errors_before' => '請在繼續下一步前修復所有錯誤',
		'keep_install' => '保留之前的配置',
		'next_step' => '下一步',
		'reinstall' => '重新安裝 FreshRSS',
	),
	'bdd' => array(
		'_' => '資料庫',
		'conf' => array(
			'_' => '資料庫配置',
			'ko' => '驗證您的資料庫配置。',
			'ok' => '資料庫配置已儲存。',
		),
		'host' => '主機',
		'password' => '密碼',
		'prefix' => '表格前綴',
		'type' => '資料庫類型',
		'username' => '使用者名稱',
	),
	'check' => array(
		'_' => '檢查',
		'already_installed' => '我們偵測到 FreshRSS 已被安裝！',
		'cache' => array(
			'nok' => '請檢查 <em>%2$s</em> 使用者的 <em>%1$s</em> 目錄權限。HTTP 伺服器必須具有寫入權限。',
			'ok' => 'cache 目錄權限正常',
		),
		'ctype' => array(
			'nok' => '無法找到字元型別檢查所需的函式庫 (php-ctype)。',
			'ok' => '您擁有字元型別檢查所需的函式庫 (ctype)。',
		),
		'curl' => array(
			'nok' => '無法找到所需的 cURL 函式庫 (php-curl 套件)。',
			'ok' => '您擁有所需的 cURL 函式庫。',
		),
		'data' => array(
			'nok' => '請檢查 <em>%2$s</em> 使用者的 <em>%1$s</em> 目錄權限。HTTP 伺服器必須具有寫入權限。',
			'ok' => 'data 目錄權限正常',
		),
		'database-connection' => array(
			'nok' => '資料庫連線錯誤。',
			'ok' => '資料庫連線狀態良好',
		),
		'database-table' => array(
			'nok' => 'Database table "%s" is incomplete.',	// TODO
			'ok' => 'Database table "%s" is good.',	// TODO
		),
		'database-tables' => array(
			'nok' => 'Some database tables are missing.',	// TODO
			'ok' => 'All database tables exist.',	// TODO
		),
		'database-title' => '資料庫',
		'dom' => array(
			'nok' => '無法找到瀏覽 DOM 所需的函式庫。',
			'ok' => '您擁有瀏覽 DOM 所需的函式庫。',
		),
		'favicons' => array(
			'nok' => '請檢查 <em>%2$s</em> 使用者的 <em>%1$s</em> 目錄權限。HTTP 伺服器必須具有寫入權限。',
			'ok' => 'favicons 目錄權限正常',
		),
		'fileinfo' => array(
			'nok' => '無法找到推薦的 PHP fileinfo 函式庫 (fileinfo 套件)。',
			'ok' => '您擁有推薦的 PHP fileinfo 函式庫 (fileinfo 套件)。',
		),
		'files' => '檔案安裝',
		'intl' => array(
			'nok' => '無法找到推薦用於國際化的 php-intl 函式庫。',
			'ok' => '您擁有推薦用於國際化的 php-intl 函式庫。',
		),
		'json' => array(
			'nok' => '無法找到解析 JSON 所需的函式庫。',
			'ok' => '您擁有解析 JSON 所需的函式庫。',
		),
		'mbstring' => array(
			'nok' => '無法找到推薦用於 Unicode 處理的 mbstring 函式庫。',
			'ok' => '您擁有推薦用於 Unicode 處理的 mbstring 函式庫。',
		),
		'pcre' => array(
			'nok' => '無法找到處理正規表達式所需的函式庫 (php-pcre)。',
			'ok' => '您擁有處理正規表達式所需的函式庫 (PCRE)。',
		),
		'pdo-mysql' => array(
			'nok' => '無法找到 MySQL/MariaDB 所需的 PDO 驅動程式。',
		),
		'pdo-pgsql' => array(
			'nok' => '無法找到 PostgreSQL 所需的 PDO 驅動程式。',
		),
		'pdo-sqlite' => array(
			'nok' => '無法找到 SQLite 的 PDO 驅動程式。',
			'ok' => '您擁有 SQLite 的 PDO 驅動程式。',
		),
		'pdo' => array(
			'nok' => '無法找到 PDO 或任何支援的驅動程式 (pdo_sqlite, pdo_pgsql, pdo_mysql)。',
			'ok' => '您擁有 PDO 或至少一個支援的驅動程式 (pdo_sqlite, pdo_pgsql, pdo_mysql)。',
		),
		'php' => array(
			'_' => 'PHP 安裝',
			'nok' => '您的 PHP 版本為 %s 但 FreshRSS 需要至少 %s。',
			'ok' => '您的 PHP 版本為 %s 相容於 FreshRSS。',
		),
		'reload' => '再次檢查',
		'tmp' => array(
			'nok' => '請檢查 <em>%2$s</em> 使用者的 <em>%1$s</em> 目錄權限。HTTP 伺服器必須具有寫入權限。',
			'ok' => 'temp 目錄權限正常。',
		),
		'tokens' => array(
			'nok' => '請檢查 <em>./data/tokens</em> 目錄權限。HTTP 伺服器必須具有寫入權限。',
			'ok' => 'tokens 目錄權限正常',
		),
		'unknown_process_username' => '未知',
		'users' => array(
			'nok' => '請檢查 <em>%2$s</em> 使用者的 <em>%1$s</em> 目錄權限。HTTP 伺服器必須具有寫入權限。',
			'ok' => 'users 目錄權限正常',
		),
		'xml' => array(
			'nok' => '無法找到解析 XML 所需的函式庫。',
			'ok' => '您擁有解析 XML 所需的函式庫。',
		),
		'zip' => array(
			'nok' => '無法找到推薦的 ZIP 擴充功能 (php-zip 套件)。',
			'ok' => '您擁有推薦的 ZIP 擴充功能 (php-zip 套件)。',
		),
	),
	'conf' => array(
		'_' => '一般配置',
		'ok' => '一般配置已儲存',
	),
	'congratulations' => '恭喜！',
	'default_user' => array(
		'_' => '預設使用者名稱',
		'max_char' => '最多 16 個數字或字母',
	),
	'fix_errors_before' => '請在繼續下一步前修復錯誤',
	'javascript_is_better' => '啟用 JavaScript 會使 FreshRSS 使用體驗更佳',
	'js' => array(
		'confirm_reinstall' => '重新安裝 FreshRSS 將會導致您丟失之前的配置。您確定要繼續嗎？',
	),
	'language' => array(
		'_' => '語言',
		'choose' => '為 FreshRSS 選擇語言',
		'defined' => '語言已被定義',
	),
	'missing_applied_migrations' => '出現錯誤，您應該建立一個空白檔案 <em>%s</em>。',
	'ok' => '安裝成功',
	'session' => array(
		'nok' => 'Web 伺服器似乎未正確配置 PHP 工作階段所需的 cookie！',
	),
	'step' => '步驟 %d',
	'steps' => '步驟',
	'this_is_the_end' => '最後一步',
	'title' => '安裝 FreshRSS',
);

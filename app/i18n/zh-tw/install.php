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
		'finish' => '完成安裝',
		'fix_errors_before' => '請在繼續下一步前修復錯誤',
		'keep_install' => '保留當前配置',
		'next_step' => '下一步',
		'reinstall' => '重新安裝 FreshRSS',
	),
	'auth' => array(
		'form' => '網頁表單（傳統方式, 依賴 JavaScript）',
		'http' => 'HTTP（對於啟用 HTTPS 的進階使用者）',
		'none' => '無認證（危險）',
		'password_form' => '密碼<br /><small>（用於網頁表單登入方式）</small>',
		'password_format' => '至少 7 個字符',
		'type' => '認證方式',
	),
	'bdd' => array(
		'_' => '資料庫',
		'conf' => array(
			'_' => '資料庫配置',
			'ko' => '請驗證你的資料庫資訊',
			'ok' => '數據庫配置已保存',
		),
		'host' => '主機',
		'password' => '密碼',
		'prefix' => '表前綴',
		'type' => '資料庫類型',
		'username' => '使用者名',
	),
	'check' => array(
		'_' => '檢查',
		'already_installed' => '我們檢測到 FreshRSS 已經安裝！',
		'cache' => array(
			'nok' => '請檢查 <em>%s</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
			'ok' => 'cache 目錄權限正常',
		),
		'ctype' => array(
			'nok' => '找不到字符類型檢測庫（php-ctype）',
			'ok' => '已找到字符類型檢測庫',
		),
		'curl' => array(
			'nok' => '找不到 cURL 庫（php-curl）',
			'ok' => '已找到 cURL 庫',
		),
		'data' => array(
			'nok' => '請檢查 <em>%s</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
			'ok' => 'data 目錄權限正常',
		),
		'dom' => array(
			'nok' => '找不到用於瀏覽 DOM 的庫（php-xml）',
			'ok' => '已找到用於瀏覽 DOM 的庫',
		),
		'favicons' => array(
			'nok' => '請檢查 <em>%s</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
			'ok' => 'favicons 目錄權限正常',
		),
		'fileinfo' => array(
			'nok' => '找不到 PHP fileinfo 庫（php-fileinfo）',
			'ok' => '已找到 fileinfo 庫',
		),
		'json' => array(
			'nok' => '找不到推薦的 JSON 解析庫',
			'ok' => '已找到推薦的 JSON 解析庫',
		),
		'mbstring' => array(
			'nok' => '找不到推薦的 Unicode 解析庫（mbstring)',
			'ok' => '已找到推薦的 Unicode 解析庫',
		),
		'pcre' => array(
			'nok' => '找不到正則表達式解析庫（php-pcre）',
			'ok' => '已找到正則表達式解析庫',
		),
		'pdo' => array(
			'nok' => '找不到 PDO 或支持的驅動（pdo_mysql、pdo_sqlite、pdo_pgsql）',
			'ok' => '已找到 PDO 和支持的至少一種驅動（pdo_mysql、pdo_sqlite、pdo_pgsql）',
		),
		'php' => array(
			'nok' => '你的 PHP 版本為 %s，但 FreshRSS 最低需要 %s',
			'ok' => '你的 PHP 版本為 %s，與 FreshRSS 兼容',
		),
		'reload' => '再檢查一遍',
		'tmp' => array(
			'nok' => '請檢查 <em>%s</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
			'ok' => '緩存目錄權限正常。',
		),
		'unknown_process_username' => '未知',
		'users' => array(
			'nok' => '請檢查 <em>%s</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
			'ok' => 'users 目錄權限正常',
		),
		'xml' => array(
			'nok' => '找不到用於 XML 解析庫',
			'ok' => '已找到 XML 解析庫',
		),
	),
	'conf' => array(
		'_' => '常規配置',
		'ok' => '常規配置已保存',
	),
	'congratulations' => '恭喜！',
	'default_user' => array(
		'_' => '預設使用者名',
		'max_char' => '最多 16 個數字或字母',
	),
	'fix_errors_before' => '請在繼續下一步前修復錯誤',
	'javascript_is_better' => '啟用 JavaScript 會使 FreshRSS 工作得更好',
	'js' => array(
		'confirm_reinstall' => '重新安裝 FreshRSS 將會重置之前的配置。你確定要繼續嗎？',
	),
	'language' => array(
		'_' => '語言',
		'choose' => '為 FreshRSS 選擇語言',
		'defined' => '語言已指定',
	),
	'missing_applied_migrations' => '出現錯誤，你需要手動創建一個空白檔案 <em>%s</em>。',
	'ok' => '安裝成功',
	'session' => array(
		'nok' => 'Web 伺服器似乎未正確配置 PHP 會話所需的 cookie！',
	),
	'step' => '步驟 %d',
	'steps' => '步驟',
	'this_is_the_end' => '最後一步',
	'title' => '安裝 FreshRSS',
);

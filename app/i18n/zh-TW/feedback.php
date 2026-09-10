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
	'access' => array(
		'denied' => '您沒有權限存取此頁面',
		'not_found' => '您正在尋找的頁面不存在',
	),
	'admin' => array(
		'optimization_complete' => '最佳化完成',
	),
	'api' => array(
		'password' => array(
			'failed' => '您的密碼無法修改',
			'updated' => '您的密碼已修改',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => '登入無效',
			'success' => '您已連線',
		),
		'logout' => array(
			'success' => '您已斷線',
		),
	),
	'conf' => array(
		'error' => '儲存配置時發生錯誤',
		'query_created' => '查詢 “%s” 已被建立。',
		'shortcuts_updated' => '快速鍵已被更新',
		'updated' => '配置已被更新',
	),
	'extensions' => array(
		'already_enabled' => '%s 已啟用',
		'cannot_remove' => '%s 無法被移除',
		'disable' => array(
			'ko' => '%s 無法被停用。<a href="%s">檢查 FreshRSS 紀錄</a> 了解詳情。',
			'ok' => '%s 現在已停用',
		),
		'enable' => array(
			'ko' => '%s 無法被啟用。<a href="%s">檢查 FreshRSS 紀錄</a> 了解詳情。',
			'ok' => '%s 現在已啟用',
		),
		'invalid_view_mode' => '無效檢視模式 “%s”！回退至 “普通檢視”。',
		'no_access' => '你沒有權限存取 %s',
		'not_enabled' => '%s 未啟用',
		'not_found' => '%s 不存在',
		'removed' => '%s 已移除',
	),
	'import_export' => array(
		'export_no_zip_extension' => '您的伺服器上沒有安裝 ZIP 擴充功能。請嘗試逐一匯出檔案。',
		'feeds_imported' => '您的訂閱源已匯入。如果已完成匯入，您現在可以點擊 <i>更新訂閱源</i> 按鈕。',
		'feeds_imported_with_errors' => '您的訂閱源已匯入，但發生一些錯誤。如果已完成匯入，您現在可以點擊 <i>更新訂閱源</i> 按鈕。',
		'file_cannot_be_uploaded' => '檔案無法上傳！',
		'no_zip_extension' => '您的伺服器上沒有安裝 ZIP 擴充功能。',
		'zip_error' => 'ZIP 處理期間發生錯誤。',
	),
	'profile' => array(
		'error' => '您的設定檔無法修改',
		'passwords_dont_match' => '密碼不相符',
		'updated' => '您的設定檔已修改',
	),
	'sub' => array(
		'actualize' => '更新',
		'articles' => array(
			'marked_read' => '選取的文章已標記為已讀',
			'marked_unread' => '文章已標記為未讀。',
		),
		'category' => array(
			'created' => '已建立類別 %s。',
			'deleted' => '已刪除類別',
			'emptied' => '已清空類別',
			'error' => '無法更新類別',
			'name_exists' => '類別名稱已存在。',
			'no_id' => '您必須指定類別 ID。',
			'no_name' => '類別名稱不能為空。',
			'not_delete_default' => '您無法刪除預設類別！',
			'not_exist' => '類別不存在！',
			'over_max' => '您已達到類別數限制 (%d)',
			'updated' => '已更新類別。',
		),
		'feed' => array(
			'actualized' => '已更新 <em>%s</em>',
			'actualizeds' => '已更新 RSS 訂閱源',
			'added' => '已新增 RSS 訂閱源 <em>%s</em>',
			'already_subscribed' => '您已訂閱 <em>%s</em>',
			'cache_cleared' => '已清除 <em>%s</em> 快取',
			'deleted' => '已刪除訂閱源',
			'error' => '無法更新訂閱源',
			'favicon' => array(
				'too_large' => '上傳的圖示過大。最大檔案大小是 <em>%s</em>。',
				'unsupported_format' => '不支援的影像檔案格式！',
			),
			'internal_problem' => '無法新增此訂閱源。<a href="%s">檢查 FreshRSS 紀錄</a> 了解詳情。您可以嘗試透過附加 <code>#force_feed</code> 到 URL 強制新增。',
			'invalid_url' => 'URL <em>%s</em> 無效',
			'n_actualized' => '已更新 %d 個訂閱源',
			'n_entries_deleted' => '已刪除 %d 篇文章',
			'no_refresh' => '無訂閱源可重新整理',
			'not_added' => '無法新增 <em>%s</em>',
			'not_found' => '無法找到訂閱源',
			'over_max' => '你已達到訂閱源數限制 (%d)',
			'reloaded' => '已重新載入 <em>%s</em>',
			'selector_preview' => array(
				'http_error' => '無法載入網站內容。',
				'no_entries' => '此訂閱源中無文章。您需要至少一篇文章來建立預覽。',
				'no_feed' => '內部錯誤 (無法找到訂閱源)。',
				'no_result' => '',
				'selector_empty' => '選擇器為空。您必須至少定義一個來建立預覽。',
			),
			'updated' => '已更新訂閱源',
		),
		'purge_completed' => '清理完成 (刪除了 %d 篇文章)',
	),
	'tag' => array(
		'created' => '已建立標籤 "%s"。',
		'error' => '無法更新標籤！',
		'name_exists' => '標籤名稱已存在。',
		'renamed' => '標籤 "%s" 已被重新命名至 "%s"。',
		'updated' => '已更新標籤',
	),
	'update' => array(
		'can_apply' => 'FreshRSS 更新可用: <strong>版本 %s</strong>。',
		'error' => '更新過程遇到錯誤: %s',
		'file_is_nok' => 'FreshRSS 更新可用 (<strong>版本 %s</strong>)，但請檢查 <em>%s</em> 目錄的權限。HTTP 伺服器必須具有寫入權限。',
		'finished' => '更新完成！',
		'none' => '無更新可用',
		'server_not_found' => '無法找到更新伺服器。[%s]',
	),
	'user' => array(
		'created' => array(
			'_' => '已建立使用者 %s',
			'error' => '無法建立使用者 %s',
		),
		'deleted' => array(
			'_' => '已刪除使用者 %s',
			'error' => '無法刪除使用者 %s',
		),
		'updated' => array(
			'_' => '已更新使用者 %s',
			'error' => '無法更新使用者 %s',
		),
	),
);

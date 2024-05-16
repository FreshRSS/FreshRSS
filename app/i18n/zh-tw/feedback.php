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
	'access' => array(
		'denied' => '你無權訪問此頁面',
		'not_found' => '你尋找的頁面不存在',
	),
	'admin' => array(
		'optimization_complete' => '優化完成',
	),
	'api' => array(
		'password' => array(
			'failed' => '您的密碼無法修改',
			'updated' => '您的密碼已修改',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => '使用者名或密碼無效',
			'success' => '登入成功',
		),
		'logout' => array(
			'success' => '已登出',
		),
	),
	'conf' => array(
		'error' => '保存配置時出錯',
		'query_created' => '查詢 “%s” 已創建。',
		'shortcuts_updated' => '快捷鍵已更新',
		'updated' => '配置已更新',
	),
	'extensions' => array(
		'already_enabled' => '%s 已啟用',
		'cannot_remove' => '無法刪除 %s',
		'disable' => array(
			'ko' => '禁用 %s 失敗。<a href="%s">檢查 FreshRSS 日誌</a> 查看詳情。',
			'ok' => '%s 現已禁用',
		),
		'enable' => array(
			'ko' => '%s 啟用失敗。<a href="%s">檢查 FreshRSS 日誌</a> 查看詳情。',
			'ok' => '%s 現已啟用',
		),
		'no_access' => '你無權訪問 %s',
		'not_enabled' => '%s 未啟用',
		'not_found' => '%s 不存在',
		'removed' => '%s 已刪除',
	),
	'import_export' => array(
		'export_no_zip_extension' => '伺服器未啟用 ZIP 擴展。請嘗試逐個導出文件。',
		'feeds_imported' => '你的訂閱已導入，即將刷新 / Your feeds have been imported. If you are done importing, you can now click the <i>Update feeds</i> button.',
		'feeds_imported_with_errors' => '你的訂閱源已導入，但發生錯誤 / Your feeds have been imported, but some errors occurred. If you are done importing, you can now click the <i>Update feeds</i> button.',
		'file_cannot_be_uploaded' => '文件未能上傳！',
		'no_zip_extension' => '伺服器未啟用 ZIP 擴展。',
		'zip_error' => '導入 ZIP 文件時出錯',	// DIRTY
	),
	'profile' => array(
		'error' => '你的帳戶修改失敗',
		'updated' => '你的帳戶已修改',
	),
	'sub' => array(
		'actualize' => '獲取',
		'articles' => array(
			'marked_read' => '文章已標記為已讀',
			'marked_unread' => '文章已標記為未讀',
		),
		'category' => array(
			'created' => '已創建分類 %s',
			'deleted' => '已刪除分類',
			'emptied' => '已清空分類',
			'error' => '更新分類失敗',
			'name_exists' => '分類名已存在',
			'no_id' => '你必須明確分類編號',
			'no_name' => '分類名不能為空',
			'not_delete_default' => '你不能刪除默認分類！',
			'not_exist' => '分類不存在！',
			'over_max' => '你已達到分類數上限（%d）',
			'updated' => '已更新分類',
		),
		'feed' => array(
			'actualized' => '已更新 <em>%s</em>',
			'actualizeds' => '已更新訂閱源',
			'added' => '訂閱源 <em>%s</em> 已添加',
			'already_subscribed' => '你已訂閱 <em>%s</em>',
			'cache_cleared' => '<em>%s</em> 緩存已清理',
			'deleted' => '已刪除訂閱源',
			'error' => '訂閱源更新失敗',
			'internal_problem' => '訂閱源添加失敗。<a href="%s">檢查 FreshRSS 日誌</a> 查看詳情。你可以在地址連結後附加 <code>#force_feed</code> 從而嘗試強制添加。',
			'invalid_url' => '地址鏈接 <em>%s</em> 無效',
			'n_actualized' => '已更新 %d 個訂閱源',
			'n_entries_deleted' => '已刪除 %d 篇文章',
			'no_refresh' => '沒有可刷新的訂閱源…',
			'not_added' => '<em>%s</em> 添加失敗',
			'not_found' => '無法找到訂閱',
			'over_max' => '你已達到訂閱源數上限（%d）',
			'reloaded' => '<em>%s</em> 已重置',
			'selector_preview' => array(
				'http_error' => '無法加載網站內容。',
				'no_entries' => '您的訂閱中沒有任何條目。您至少需要一個條目來創建一個預覽。',
				'no_feed' => '網絡錯誤（訂閱源不存在）',
				'no_result' => '選擇器沒有匹配到任何東西。作為備用，原始的feed文本將被顯示出來。',
				'selector_empty' => '選擇器是空的。你需要一個來創建預覽。',
			),
			'updated' => '已更新訂閱源',
		),
		'purge_completed' => '清除完成（已刪除 %d 篇文章）',
	),
	'tag' => array(
		'created' => '標籤 “%s” 已創建。',
		'error' => '無法更新標籤!',
		'name_exists' => '標籤名已存在。',
		'renamed' => '標籤 “%s” 已被重命名為 “%s”。',
		'updated' => '已更新標籤。',
	),
	'update' => array(
		'can_apply' => 'FreshRSS 將更新到 <strong>版本 %s</strong>。',
		'error' => '更新出錯：%s',
		'file_is_nok' => '請檢查 <em>%s</em> 目錄權限。HTTP 伺服器必須有其寫入權限。',
		'finished' => '更新完成！',
		'none' => '沒有可用更新',
		'server_not_found' => '找不到更新伺服器 [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => '已創建使用者 %s',
			'error' => '創建使用者 %s 失敗',
		),
		'deleted' => array(
			'_' => '已刪除使用者 %s',
			'error' => '刪除使用者 %s 失敗',
		),
		'updated' => array(
			'_' => '已更新使用者 %s',
			'error' => '更新使用者 %s 失敗',
		),
	),
);

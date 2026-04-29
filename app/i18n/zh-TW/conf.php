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
	'archiving' => array(
		'_' => '歸檔',
		'exception' => '清理例外',
		'help' => '更多選項在個別訂閱源設定中可用',
		'keep_favourites' => '不清理收藏',
		'keep_labels' => '永不刪除標籤',
		'keep_max' => '每個訂閱源保留的最大文章數',
		'keep_min_by_feed' => '每個訂閱源保留的最小文章數',
		'keep_period' => '文章最大保留時間',
		'keep_unreads' => '永不刪除未讀文章',
		'maintenance' => '維護',
		'optimize' => '最佳化資料庫',
		'optimize_help' => '偶爾執行以減少資料庫大小',
		'policy' => '清理策略',
		'policy_warning' => '如果未選擇清理策略，則將保留全部文章。',
		'purge_now' => '立即清除',
		'title' => '存檔',
		'ttl' => '最小自動刷新間隔',
	),
	'display' => array(
		'_' => '顯示',
		'darkMode' => array(
			'_' => '自動黑暗模式',
			'auto' => '自動',
			'help' => '僅適用於相容主題',
			'no' => '否',
		),
		'icon' => array(
			'bottom_line' => '底部',
			'display_authors' => '作者',
			'entry' => '文章圖示',
			'publication_date' => '發表日期',
			'related_tags' => '相關標籤',
			'sharing' => '分享',
			'summary' => '摘要',
			'top_line' => '頂部',
		),
		'language' => '語言',
		'notif_html5' => array(
			'seconds' => '秒 (0 代表無逾時)',
			'timeout' => 'HTML5 通知逾時',
		),
		'show_nav_buttons' => '顯示導覽按鈕',
		'sidebar_hidden_by_default' => '預設隱藏側邊欄',
		'theme' => array(
			'_' => '主題',
			'deprecated' => array(
				'_' => '已棄用',
				'description' => '此主題不再支援，並且在 <a href="https://freshrss.github.io/FreshRSS/en/users/05_Configuration.html#theme" target="_blank">FreshRSS 的未來版本</a> 中將不再可用',
			),
		),
		'theme_not_available' => '“%s” 主題不再可用，請選擇另一個主題。',
		'thumbnail' => array(
			'label' => '縮圖',
			'landscape' => '風景',
			'none' => '無',
			'portrait' => '人像',
			'square' => '方形',
		),
		'timezone' => '時區',
		'title' => '顯示',
		'website' => array(
			'full' => '圖示及名稱',
			'icon' => '僅圖示',
			'label' => '網站',
			'name' => '僅名稱',
			'none' => '無',
		),
		'width' => array(
			'content' => '內容寬度',
			'large' => '寬',
			'medium' => '中',
			'no_limit' => '全寬',
			'thin' => '窄',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => '紀錄等級',
			'message' => '紀錄訊息',
			'timestamp' => '時間戳',
		),
		'pagination' => array(
			'first' => '第一頁',
			'last' => '最後一頁',
			'next' => '下一頁',
			'previous' => '上一頁',
		),
	),
	'mark_read_button' => array(
		'_' => '“標記全部為已讀” 按鈕',
		'big' => '大',
		'none' => '無',
		'small' => '小',
	),
	'notification' => array(
		'html5_enable_notif' => '啟用通知',
	),
	'notification_timeout' => array(
		'bad' => array(
			'label' => 'Show warning banner',	// TODO
			'seconds' => '秒 (至少為 1)',
		),
		'good' => array(
			'label' => 'Show acknowledgement banner',	// TODO
			'seconds' => '秒 (0 代表不顯示)',
		),
	),
	'privacy' => array(
		'_' => '隱私',
		'retrieve_extension_list' => 'Retrieve extension list',	// TODO
		'send_referrer_allowlist' => 'Sites allowed to see your server address (%s)',	// TODO
	),
	'profile' => array(
		'_' => '設定檔管理',
		'api' => array(
			'_' => '透過 API 進行外部存取',
			'api_not_set' => 'API password not set',	// TODO
			'api_set' => 'API password set',	// TODO
			'check_link' => 'Check API status via: <kbd><a href="../api/" target="_blank">%s</a></kbd>',	// TODO
			'disabled' => 'API 存取已停用',
			'documentation_link' => 'See the <a href="https://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html#access-via-mobile-app" target="_blank">documentation and list of known apps</a>',	// TODO
			'help' => '請參閱 <a href="http://freshrss.github.io/FreshRSS/en/users/06_Mobile_access.html#access-via-mobile-app" target=_blank>說明文件</a>',
		),
		'change_password' => '變更密碼',
		'confirm_new_password' => '確認新密碼',
		'current_password' => '目前密碼<br /><small>(用於 Web 表單登入方式)</small>',
		'delete' => array(
			'_' => '帳號刪除',
			'warn' => '你的帳號及所有相關資料將被刪除。',
		),
		'email' => '電子郵件位址',
		'new_password' => '新密碼',
		'password_api' => 'API 密碼<br /><small>(例如用於移動端應用程式)</small>',
		'password_format' => '至少 7 個字元',
		'title' => '設定檔',
	),
	'query' => array(
		'_' => '使用者查詢',
		'create' => '建立新使用者查詢',
		'deprecated' => '此查詢不再有效。相關的類別或訂閱源已被刪除。',
		'description' => '描述',
		'filter' => array(
			'_' => '套用的過濾器:',
			'categories' => '按類別顯示',
			'feeds' => '按訂閱源顯示',
			'order' => '按日期排序',
			'publish_labels_instead_of_tags' => 'Replace <i>feed tags</i> by <i>user labels</i> in the shared RSS',	// TODO
			'search' => '表達式',
			'shareOpml' => '啟用透過對應類別和訂閱源的 OPML 分享',
			'shareRss' => '啟用透過 HTML 分享 &amp; RSS',
			'state' => '狀態',
			'tags' => '按標籤顯示',
			'type' => '類型',
		),
		'get_A' => 'Show all feeds, also those shown in their category',	// TODO
		'get_Z' => 'Show all feeds, also archived ones',	// TODO
		'get_all' => '顯示所有文章',
		'get_all_labels' => '顯示任何標籤的文章',
		'get_category' => '顯示類別 “%s”',
		'get_favorite' => '顯示收藏的文章',
		'get_feed' => '顯示訂閱源 “%s”',
		'get_important' => '顯示來自重要訂閱源的文章',
		'get_label' => '顯示帶有標籤 “%s” 的文章',
		'help' => '請參閱 <a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank">說明文件以了解使用者查詢和透過 HTML / RSS / OPML 重新分享</a>。',
		'image_url' => '影像 URL',
		'name' => '名稱',
		'no_filter' => '無過濾器',
		'no_queries' => array(
			'_' => 'No user queries are saved yet.',	// TODO
			'help' => '請參閱 <a href="https://freshrss.github.io/FreshRSS/en/users/user_queries.html" target="_blank">說明文件</a>',
		),
		'number' => '查詢 n°%d',
		'order_asc' => '先顯示最舊文章',
		'order_desc' => '先顯示最新文章',
		'search' => '搜尋 “%s”',
		'share' => array(
			'_' => '透過連結分享此查詢',
			'disabled' => array(
				'_' => '已停用',
				'title' => '分享',
			),
			'greader' => 'GReader JSON 的可分享連結',
			'help' => '如果您想與任何人分享此查詢，請提供此連結',
			'html' => 'HTML 頁面的可分享連結',
			'opml' => 'OPML 訂閱源清單的可分享連結',
			'rss' => 'RSS 訂閱源的可分享連結',
		),
		'state_0' => '顯示所有文章',
		'state_1' => '顯示已讀文章',
		'state_2' => '顯示未讀文章',
		'state_3' => '顯示所有文章',
		'state_4' => '顯示收藏文章',
		'state_5' => '顯示已讀的收藏文章',
		'state_6' => '顯示未讀的收藏文章',
		'state_7' => '顯示收藏文章',
		'state_8' => '顯示未收藏文章',
		'state_9' => '顯示已讀的未收藏文章',
		'state_10' => '顯示未讀的未收藏文章',
		'state_11' => '顯示未收藏文章',
		'state_12' => '顯示所有文章',
		'state_13' => '顯示已讀文章',
		'state_14' => '顯示未讀文章',
		'state_15' => '顯示所有文章',
		'title' => '使用者查詢',
	),
	'reading' => array(
		'_' => '閱讀',
		'after_onread' => '在 “mark all as read” 之後，',
		'always_show_favorites' => '預設顯示收藏中所有的文章',
		'apply_to_individual_feed' => '個別套用到訂閱源',
		'article' => array(
			'authors_date' => array(
				'_' => '作者和日期',
				'both' => '兩者都顯示',
				'footer' => '僅頁腳顯示',
				'header' => '僅頁眉顯示',
				'none' => '不顯示',
			),
			'feed_name' => array(
				'above_title' => '標題/標籤之上',
				'none' => '不顯示',
				'with_authors' => '在作者和日期那列',
			),
			'feed_title' => '訂閱源標題',
			'icons' => array(
				'_' => '文章圖示位置<br /><small>(僅閱讀檢視)</small>',
				'above_title' => '標題之上',
				'with_authors' => '在作者和日期那列',
			),
			'tags' => array(
				'_' => '標籤',
				'both' => '兩者都顯示',
				'footer' => '僅頁腳顯示',
				'header' => '僅頁眉顯示',
				'none' => '不顯示',
			),
			'tags_max' => array(
				'_' => '標籤最大顯示數量',
				'help' => '0 代表顯示所有標籤並且不折疊它們',
			),
		),
		'articles_per_page' => '每頁文章數',
		'auto_load_more' => '在頁面底部載入更多文章',
		'auto_remove_article' => '閱讀後隱藏文章',
		'confirm_enabled' => '"標記全部為已讀" 動作時顯示確認對話框',
		'display_articles_unfolded' => '預設不折疊文章',
		'display_categories_unfolded' => '要不折疊的類別',
		'headline' => array(
			'articles' => '文章: 開啟/關閉',
			'articles_header_footer' => '文章: 頁首/頁尾',
			'categories' => '左側導覽: 類別',
			'mark_as_read' => '標記文章為已讀',
			'misc' => '雜項',
			'view' => '檢視',
		),
		'hide_read_feeds' => '隱藏無未讀文章的類別和訂閱源 ("顯示所有文章" 配置下不起作用)',
		'img_with_lazyload' => '使用 <em>lazy load</em> 模式來載入圖片',
		'jump_next' => '跳到下一個未讀項目',
		'mark_updated_article_unread' => '標記已更新文章為未讀',
		'number_divided_when_reader' => '在閱讀檢視中顯示一半。',
		'read' => array(
			'article_open_on_website' => '當文章的原始網站已被開啟',
			'article_viewed' => '當文章已被檢視',
			'focus' => '聚焦時 (重要訂閱源除外)',
			'keep_max_n_unread' => '未讀保留的最大文章數',
			'scroll' => '滾動時 (重要訂閱源除外)',
			'upon_gone' => '當它不再出現在上游新聞訂閱源時',
			'upon_reception' => '在接收文章時',
			'when' => '標記文章為已讀…',
			'when_same_guid_in_category' => '如果在類別最新的前 <i>n</i> 篇文章中已存在相同 GUID',
			'when_same_title_in_category' => '如果在類別最新的前 <i>n</i> 篇文章中已存在相同標題',
			'when_same_title_in_feed' => '如果在訂閱源最新的前 <i>n</i> 篇文章中已存在相同標題',
		),
		'show' => array(
			'_' => '要顯示的文章',
			'active_category' => '啟用的類別',
			'adaptive' => 'Show unreads if any, all articles otherwise',	// TODO
			'all_articles' => '顯示所有文章',
			'all_categories' => '所有類別',
			'no_category' => '無類別',
			'remember_categories' => '記住開啟的類別',
			'unread' => '顯示未讀',
			'unread_or_favorite' => '顯示未讀和收藏',
		),
		'show_fav_unread_help' => '同樣適用於標籤',
		'sides_close_article' => '點擊文章區域外以關閉',
		'star' => array(
			'when' => '標記文章為最愛…',
		),
		'sticky_post' => '開啟文章時將其固定於頁首',
		'title' => '閱讀',
		'view' => array(
			'default' => '預設檢視',
			'global' => '全域檢視',
			'normal' => '普通檢視',
			'reader' => '閱讀檢視',
		),
	),
	'sharing' => array(
		'_' => '分享',
		'add' => '新增分享方式',
		'bluesky' => 'Bluesky',	// IGNORE
		'deprecated' => '此服務已被棄用，並將從 <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="開啟說明文件以取得更多資訊" target="_blank">未來版本</a> 的 FreshRSS 中被移除。',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => '電子郵件',
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => '更多資訊',
		'print' => '列印',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => '移除分享方式',
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => '要顯示的分享名稱',
		'share_url' => '要使用的分享 URL',
		'title' => '分享',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'Wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => '快速鍵',
		'article_action' => '文章操作',
		'auto_share' => '分享',
		'auto_share_help' => '如果只有一種分享模式，則會直接使用。否則，可透過編號存取每個模式。',
		'close_menus' => '關閉選單',
		'collapse_article' => '折疊',
		'first_article' => '開啟第一篇文章',
		'focus_search' => '存取搜尋框',
		'global_view' => '切換到全域檢視',
		'help' => '顯示說明文件',
		'javascript' => '必須啟用 JavaScript 才能使用快速鍵',
		'last_article' => '開啟最後一篇文章',
		'load_more' => '載入更多文章',
		'mark_favorite' => '切換收藏',
		'mark_read' => '切換已讀',
		'navigation' => '導覽',
		'navigation_help' => '搭配 <kbd>⇧ Shift</kbd> 修飾鍵時，導覽快速鍵會套用在訂閱源上。<br/>搭配 <kbd>Alt ⎇</kbd> 修飾鍵時，導覽快速鍵會套用在類別上。',
		'navigation_no_mod_help' => '以下導覽快速鍵不支援修飾鍵。',
		'next_article' => '開啟下一篇文章',
		'next_unread_article' => '開啟下一篇未讀文章',
		'non_standard' => '有些按鍵 (<kbd>%s</kbd>) 可能不能作為快速鍵。',
		'normal_view' => '切換到普通檢視',
		'other_action' => '其它操作',
		'previous_article' => '開啟上一篇文章',
		'reading_view' => '切換到閱讀檢視',
		'rss_view' => '作為 RSS 訂閱源開啟',
		'see_on_website' => '在原始網站上查看',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> 標記之前的文章為已讀<br />+ <kbd>⇧ Shift</kbd> 標記所有文章為已讀',
		'skip_next_article' => '跳轉到下一篇文章而不開啟',
		'skip_previous_article' => '跳轉到上一篇文章而不開啟',
		'title' => '快速鍵',
		'toggle_aside' => '切換側邊欄',
		'toggle_media' => '播放/暫停媒體',
		'user_filter' => '存取使用者查詢',
		'user_filter_help' => '如果有多個自定義過濾器，則會按照它們的序號依次訪問。',
		'views' => '檢視',
	),
	'user' => array(
		'articles_and_size' => '%s 篇文章 (%s)',
		'current' => '目前使用者',
		'is_admin' => '是否為管理員',
		'users' => '使用者',
	),
);

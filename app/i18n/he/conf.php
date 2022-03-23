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
	'archiving' => array(
		'_' => 'ארכוב',
		'exception' => 'Purge exception',	// TODO
		'help' => 'אפשרויות נוספות זמינות בזרמים ספציפיים',
		'keep_favourites' => 'Never delete favourites',	// TODO
		'keep_labels' => 'Never delete labels',	// TODO
		'keep_max' => 'Maximum number of articles to keep',	// TODO
		'keep_min_by_feed' => 'Minimum number of articles to keep per feed',	// TODO
		'keep_period' => 'Maximum age of articles to keep',	// TODO
		'keep_unreads' => 'Never delete unread articles',	// TODO
		'maintenance' => 'Maintenance',	// TODO
		'optimize' => 'מיטוב בסיס הנתונים',
		'optimize_help' => 'ביצוע לעיתים קרובות על מנת למטב את בסיס הנתונים',
		'policy' => 'Purge policy',	// TODO
		'policy_warning' => 'If no purge policy is selected, every article will be kept.',	// TODO
		'purge_now' => 'ניקוי עכשיו',
		'title' => 'ארכוב',
		'ttl' => 'אין לרענן אוטומטית יותר מ',
	),
	'display' => array(
		'_' => 'תצוגה',
		'icon' => array(
			'bottom_line' => 'שורה תחתונה',
			'display_authors' => 'Authors',	// TODO
			'entry' => 'סמלילי מאמרים',
			'publication_date' => 'תאריך הפרסום',
			'related_tags' => 'תגיות קשורות',
			'sharing' => 'שיתוף',
			'summary' => 'Summary',	// TODO
			'top_line' => 'שורה עליונה',
		),
		'language' => 'שפה',
		'notif_html5' => array(
			'seconds' => 'שניות (0 משמעותה ללא פג תוקף)',
			'timeout' => 'HTML5 התראה פג תוקף',
		),
		'show_nav_buttons' => 'Show the navigation buttons',	// TODO
		'theme' => 'ערכת נושא',
		'theme_not_available' => 'The “%s” theme is not available anymore. Please choose another theme.',	// TODO
		'thumbnail' => array(
			'label' => 'Thumbnail',	// TODO
			'landscape' => 'Landscape',	// TODO
			'none' => 'None',	// TODO
			'portrait' => 'Portrait',	// TODO
			'square' => 'Square',	// TODO
		),
		'title' => 'תצוגה',
		'width' => array(
			'content' => 'רוחב התוכן',
			'large' => 'גדול',
			'medium' => 'בינוני',
			'no_limit' => 'ללא הגבלה',
			'thin' => 'צר',
		),
	),
	'logs' => array(
		'loglist' => array(
			'level' => 'Log Level',	// TODO
			'message' => 'Log Message',	// TODO
			'timestamp' => 'Timestamp',	// TODO
		),
		'pagination' => array(
			'first' => 'הראשון',
			'last' => 'אחרון',
			'next' => 'הבא',
			'previous' => 'הקודם',
		),
	),
	'profile' => array(
		'_' => 'Profile management',	// TODO
		'api' => 'API management',	// TODO
		'delete' => array(
			'_' => 'Account deletion',	// TODO
			'warn' => 'Your account and all related data will be deleted.',	// TODO
		),
		'email' => 'Email address',	// TODO
		'password_api' => 'סיסמת API<br /><small>(לדוגמה ליישומים סלולריים)</small>',
		'password_form' => 'סיסמה<br /><small>(לשימוש בטפוס ההרשמה)</small>',
		'password_format' => 'At least 7 characters',	// TODO
		'title' => 'Profile',	// TODO
	),
	'query' => array(
		'_' => 'שאילתות',
		'deprecated' => 'שאילתה זו אינה בתוקף יותר, הפיד או הקטגוריה לייחוס נמחקו.',
		'filter' => array(
			'_' => 'מסננים בשימוש:',
			'categories' => 'Display by category',	// TODO
			'feeds' => 'Display by feed',	// TODO
			'order' => 'Sort by date',	// TODO
			'search' => 'Expression',	// TODO
			'state' => 'State',	// TODO
			'tags' => 'Display by tag',	// TODO
			'type' => 'Type',	// TODO
		),
		'get_all' => 'הצגת כל המאמרים',
		'get_category' => 'הצגת קטגוריה "%s"',
		'get_favorite' => 'הצגת מאמרים מועדפים',
		'get_feed' => 'הצגת הזנה %s',
		'name' => 'Name',	// TODO
		'no_filter' => 'ללא סינון',
		'number' => 'שאילתה מספר °%d',
		'order_asc' => 'הצגת מאמרים ישנים בראש',
		'order_desc' => 'הצגת מאמרים חדשים בראש',
		'search' => 'חיפוש "%s"',
		'state_0' => 'הצגת כל המאמרים',
		'state_1' => 'הצגת מאמרים שנקראו',
		'state_2' => 'הצגת מאמרים שלא נקראו',
		'state_3' => 'הצגת כל המאמרים',
		'state_4' => 'הצגת מאמרים מועדפים',
		'state_5' => 'הצגת מאמרים מועדפים שנקראו',
		'state_6' => 'הצגת מאמרים מועדפים שלא נקראו',
		'state_7' => 'הצגת מאמרים מועדפים',
		'state_8' => 'הצגת מאמרים שאינם מועדפים',
		'state_9' => 'הצגת מאמרים שנקראו ואינם מועדפים',
		'state_10' => 'הצגת מאמרים שלא נקראו ואינם מועדפים',
		'state_11' => 'הצגת מאמרים לא מועדפים',
		'state_12' => 'הצגת כל המאמרים',
		'state_13' => 'הצגת מאמרים שנקראו',
		'state_14' => 'הצגת מאמרים שלא נקראו',
		'state_15' => 'הצגת	כל המאמרים',
		'title' => 'שאילתות',
	),
	'reading' => array(
		'_' => 'קריאה',
		'after_onread' => 'לאחר “סימון הכל כנקרא”,',
		'always_show_favorites' => 'Show all articles in favourites by default',	// TODO
		'articles_per_page' => 'מספר המאמרים בעמוד',
		'auto_load_more' => 'טעינת המאמר הבא סוף העמוד',
		'auto_remove_article' => 'Hide articles after reading',	// TODO
		'confirm_enabled' => 'הצגת דו-שיח לאישור “סימון הכל כנקרא” ',
		'display_articles_unfolded' => 'הצגת מאמרים בשלמותם כברירת מחדל',
		'display_categories_unfolded' => 'Categories to unfold',	// TODO
		'headline' => array(
			'articles' => 'Articles: Open/Close',	// TODO
			'categories' => 'Left navigation: Categories',	// TODO
			'mark_as_read' => 'Mark article as read',	// TODO
			'misc' => 'Miscellaneous',	// TODO
			'view' => 'View',	// TODO
		),
		'hide_read_feeds' => 'הסתרת קטגוריות &amp; הזנות ללא מאמרים שלא נקראו (לא עובד יחד עם “הצגת כל המאמרים”)',
		'img_with_lazyload' => 'שימוש ב "טעינה עצלה" על מנת לטעון תמונות',
		'jump_next' => 'קפיצה לפריט הבא שלא נקרא (הזנה או קטגוריה)',
		'mark_updated_article_unread' => 'Mark updated articles as unread',	// TODO
		'number_divided_when_reader' => 'חלוקה ב2 במצב קריאה.',
		'read' => array(
			'article_open_on_website' => 'כאשר מאמר נפתח באתר המקורי',
			'article_viewed' => 'כאשר מאמר נצפה',
			'keep_max_n_unread' => 'Max number of articles to keep unread',	// TODO
			'scroll' => 'כאשר גוללים',
			'upon_reception' => 'כאשר המאמר מתקבל',
			'when' => 'סימון מאמרים כנקראו…',
			'when_same_title' => 'if an identical title already exists in the top <i>n</i> newest articles',	// TODO
		),
		'show' => array(
			'_' => 'מאמרים להצגה',
			'active_category' => 'Active category',	// TODO
			'adaptive' => 'תצוגה מתעדכנת',
			'all_articles' => 'הצגת כל המאמרים',
			'all_categories' => 'All categories',	// TODO
			'no_category' => 'No category',	// TODO
			'remember_categories' => 'Remember open categories',	// TODO
			'unread' => 'הצגת מאמרים שלא נקראו בלבד',
		),
		'show_fav_unread_help' => 'Applies also on labels',	// TODO
		'sides_close_article' => 'Clicking outside of article text area closes the article',	// TODO
		'sort' => array(
			'_' => 'סדר המיון',
			'newer_first' => 'חדשים בראש',
			'older_first' => 'ישנים יותר בראש',
		),
		'sticky_post' => 'הצמדת המאמר לחלק העליון כאשר הוא פתוח',
		'title' => 'קריאה',
		'view' => array(
			'default' => 'תצוגת ברירת המחדל',
			'global' => 'תצוגה גלובלית',
			'normal' => 'תצוגה רגילה',
			'reader' => 'תצוגת קריאה',
		),
	),
	'sharing' => array(
		'_' => 'שיתוף',
		'add' => 'Add a sharing method',	// TODO
		'blogotext' => 'Blogotext',	// IGNORE
		'deprecated' => 'This service is deprecated and will be removed from FreshRSS in a <a href="https://freshrss.github.io/FreshRSS/en/users/08_sharing_services.html" title="Open documentation for more information" target="_blank">future release</a>.',	// TODO
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'דואר אלקטרוני',
		'facebook' => 'Facebook',	// IGNORE
		'more_information' => 'מידע נוסף',
		'print' => 'הדפסה',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'remove' => 'Remove sharing method',	// TODO
		'shaarli' => 'Shaarli',	// IGNORE
		'share_name' => 'שיתוף שם לתצוגה',
		'share_url' => 'לשימוש שתפו URL',
		'title' => 'שיתוף',
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag',	// IGNORE
	),
	'shortcut' => array(
		'_' => 'קיצורי דרך',
		'article_action' => 'פעולות על מאמרים',
		'auto_share' => 'שיתוף',
		'auto_share_help' => 'אם יש רק מצב שיתוף אחד, הוא מופעל. אחרת המצבים נבחרים על בסיס המספר שלהם.',
		'close_dropdown' => 'Close menus',	// TODO
		'collapse_article' => 'כיווץ',
		'first_article' => 'דילוג למאמר הראשון',
		'focus_search' => 'גישה לתיבת החיפוש',
		'global_view' => 'Switch to global view',	// TODO
		'help' => 'הצגת התיעוד',
		'javascript' => 'חובה להפעיל JavaScript על מנת לעשות שימוש בקיצורי דרך',
		'last_article' => 'דילוג למאמר האחרון',
		'load_more' => 'טעינת מאמרים נוספים',
		'mark_favorite' => 'סימון כמועדף',
		'mark_read' => 'סימון כנקרא',
		'navigation' => 'ניווט',
		'navigation_help' => 'בעזרת מקש השיפט קיצורי דרך חלים על הזנות .<br/>עם מקש האלט הם חלים על קטגוריות.',
		'navigation_no_mod_help' => 'The following navigation shortcuts do not support modifiers.',	// TODO
		'next_article' => 'דילוג למאמר הבא',
		'next_unread_article' => 'Open the next unread article',	// TODO
		'non_standard' => 'Some keys (<kbd>%s</kbd>) may not work as shortcuts.',	// TODO
		'normal_view' => 'Switch to normal view',	// TODO
		'other_action' => 'פעולות אחרות',
		'previous_article' => 'דילוג למאמר הקודם',
		'reading_view' => 'Switch to reading view',	// TODO
		'rss_view' => 'Open as RSS feed',	// TODO
		'see_on_website' => 'ראו את המקור באתר',
		'shift_for_all_read' => '+ <kbd>Alt ⎇</kbd> to mark previous articles as read<br />+ <kbd>⇧ Shift</kbd> to mark all articles as read',	// TODO
		'skip_next_article' => 'Focus next without opening',	// TODO
		'skip_previous_article' => 'Focus previous without opening',	// TODO
		'title' => 'קיצורי דרך',
		'toggle_media' => 'Play/pause media',	// TODO
		'user_filter' => 'גישה למססנים',
		'user_filter_help' => 'אם יש רק מזנן אחד הוא יהיה בשימוש. אחרת המסננים ישמשו על בסיס המספר שלהם.',
		'views' => 'Views',	// TODO
	),
	'user' => array(
		'articles_and_size' => '%s articles (%s)',	// TODO
		'current' => 'משתמש נוכחי',
		'is_admin' => 'מנהל',
		'users' => 'משתמשים',
	),
);

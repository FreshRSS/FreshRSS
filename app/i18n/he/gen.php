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
		'actualize' => 'מימוש',
		'add' => 'Add',	// TODO
		'back' => '← Go back',	// TODO
		'back_to_rss_feeds' => '← חזרה להזנות הRSS שלך',
		'cancel' => 'ביטול',
		'create' => 'יצירה',
		'demote' => 'Demote',	// TODO
		'disable' => 'Disable',	// TODO
		'empty' => 'Empty',	// TODO
		'enable' => 'Enable',	// TODO
		'export' => 'ייצוא',
		'filter' => 'מסנן',
		'import' => 'ייבוא',
		'load_default_shortcuts' => 'Load default shortcuts',	// TODO
		'manage' => 'ניהול',
		'mark_read' => 'סימון כנקרא',
		'promote' => 'Promote',	// TODO
		'purge' => 'Purge',	// TODO
		'remove' => 'Remove',	// TODO
		'rename' => 'Rename',	// TODO
		'see_website' => 'ראו אתר',
		'submit' => 'אישור',
		'truncate' => 'מחיקת כל המאמרים',
		'update' => 'Update',	// TODO
	),
	'auth' => array(
		'accept_tos' => 'I accept the <a href="%s">Terms of Service</a>.',	// TODO
		'email' => 'Email address',	// TODO
		'keep_logged_in' => 'השאר מחובר <small>חודש</small>',
		'login' => 'כניסה לחשבון',
		'logout' => 'יציאה מהחשבון',
		'password' => array(
			'_' => 'סיסמה',
			'format' => '<small>At least 7 characters</small>',	// TODO
		),
		'registration' => array(
			'_' => 'New account',	// TODO
			'ask' => 'Create an account?',	// TODO
			'title' => 'Account creation',	// TODO
		),
		'username' => array(
			'_' => 'שם משתמש',
			'format' => '<small>Maximum 16 alphanumeric characters</small>',	// TODO
		),
	),
	'date' => array(
		'Apr' => '\\A\\p\\r\\i\\l',	// TODO
		'Aug' => '\\A\\u\\g\\u\\s\\t',	// TODO
		'Dec' => '\\D\\e\\c\\e\\m\\b\\e\\r',	// TODO
		'Feb' => '\\F\\e\\b\\r\\u\\a\\r\\y',	// TODO
		'Jan' => '\\J\\a\\n\\u\\a\\r\\y',	// TODO
		'Jul' => '\\J\\u\\l\\y',	// TODO
		'Jun' => '\\J\\u\\n\\e',	// TODO
		'Mar' => '\\M\\a\\r\\c\\h',	// TODO
		'May' => '\\M\\a\\y',	// TODO
		'Nov' => '\\N\\o\\v\\e\\m\\b\\e\\r',	// TODO
		'Oct' => '\\O\\c\\t\\o\\b\\e\\r',	// TODO
		'Sep' => '\\S\\e\\p\\t\\e\\m\\b\\e\\r',	// TODO
		'apr' => 'apr',
		'april' => 'Apr',
		'aug' => 'aug',
		'august' => 'Aug',
		'before_yesterday' => 'ישן יותר',
		'dec' => 'dec',
		'december' => 'Dec',
		'feb' => 'feb',
		'february' => 'Feb',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\a\\t H\\:i',	// IGNORE
		'fri' => 'Fri',	// TODO
		'jan' => 'jan',
		'january' => 'Jan',
		'jul' => 'jul',
		'july' => 'Jul',
		'jun' => 'jun',
		'june' => 'Jun',
		'last_2_year' => 'Last two years',	// TODO
		'last_3_month' => 'בשלושת החודשים האחרונים',
		'last_3_year' => 'Last three years',	// TODO
		'last_5_year' => 'Last five years',	// TODO
		'last_6_month' => 'בששת החודשים האחרונים',
		'last_month' => 'בחודש שעבר',
		'last_week' => 'בשבוע שעבר',
		'last_year' => 'בשנה האחרונה',
		'mar' => 'mar',
		'march' => 'Mar',
		'may' => 'May',	// TODO
		'may_' => 'May',	// TODO
		'mon' => 'Mon',	// TODO
		'month' => 'חודשים',
		'nov' => 'nov',
		'november' => 'Nov',
		'oct' => 'oct',
		'october' => 'Oct',
		'sat' => 'Sat',	// TODO
		'sep' => 'sep',
		'september' => 'Sep',
		'sun' => 'Sun',	// TODO
		'thu' => 'Thu',	// TODO
		'today' => 'היום',
		'tue' => 'Tue',	// TODO
		'wed' => 'Wed',	// TODO
		'yesterday' => 'אתמול',
	),
	'dir' => 'rtl',
	'freshrss' => array(
		'_' => 'FreshRSS',	// TODO
		'about' => 'אודות FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Empty category',	// TODO
		'confirm_action' => 'האם אתם בטוחים שברצונכם לבצע פעולה זו? אין אפשרות לבטל אותה!',
		'confirm_action_feed_cat' => 'האם אתם בטוחים שברצוניכם לבצע פעולה זו? מועדפים ושאילתות עשויות לאבוד. אין אפשרות לבטל אותה!',
		'feedback' => array(
			'body_new_articles' => 'ישנם	\\d מאמרים חדשים לקרוא ב FreshRSS.',
			'body_unread_articles' => '(unread: %%d)',	// TODO
			'request_failed' => 'A request has failed, it may have been caused by internet connection problems.',	// TODO
			'title_new_articles' => 'FreshRSS: מאמרים חדשים!',
		),
		'new_article' => 'מאמרים חדשים זמינים, לחצו לרענון העמוד.',
		'should_be_activated' => 'חובה להפעיל JavaScript',
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
		'about' => 'אודות',
		'account' => 'Account',	// TODO
		'admin' => 'ניהול',
		'archiving' => 'ארכוב',
		'authentication' => 'Authentication',	// TODO
		'check_install' => 'Installation check',	// TODO
		'configuration' => 'הגדרות',
		'display' => 'תצוגה',
		'extensions' => 'Extensions',	// TODO
		'logs' => 'לוגים',
		'queries' => 'שאילתות',
		'reading' => 'קריאה',
		'search' => 'חיפוש מילים או #תגים',
		'sharing' => 'שיתוף',
		'shortcuts' => 'קיצורי דרך',
		'stats' => 'סטטיסטיקות',
		'system' => 'System configuration',	// TODO
		'update' => 'עדכון',
		'user_management' => 'Manage users',	// TODO
		'user_profile' => 'Profile',	// TODO
	),
	'pagination' => array(
		'first' => 'הראשון',
		'last' => 'אחרון',
		'next' => 'הבא',
		'previous' => 'הקודם',
	),
	'period' => array(
		'days' => 'days',	// TODO
		'hours' => 'hours',	// TODO
		'months' => 'months',	// TODO
		'weeks' => 'weeks',	// TODO
		'years' => 'years',	// TODO
	),
	'share' => array(
		'Known' => 'Known based sites',	// TODO
		'blogotext' => 'Blogotext',	// IGNORE
		'clipboard' => 'Clipboard',	// TODO
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'דואר אלקטרוני',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'pocket' => 'Pocket',	// IGNORE
		'print' => 'הדפסה',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Default System Sharing',	// TODO
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'זהירות!',
		'blank_to_disable' => 'יש להשאיר ריק על מנת לנטרל',
		'by_author' => 'מאת :',
		'by_default' => 'ברירת מחדל',
		'damn' => 'הו לא!',
		'default_category' => 'ללא קטגוריה',
		'no' => 'לא',	// IGNORE
		'not_applicable' => 'Not available',	// TODO
		'ok' => 'כן!',
		'or' => 'או',
		'yes' => 'כן',
	),
	'stream' => array(
		'load_more' => 'טעינת מאמרים נוספים',
		'mark_all_read' => 'סימון הכל כנקרא',
		'nothing_to_load' => 'אין מאמרים נוספים',
	),
);

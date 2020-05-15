<?php

return array(
	'access' => array(
		'denied' => 'אין לך הרשאות לצפות בדף זה',
		'not_found' => 'הדף הזה לא נמצא',
	),
	'admin' => array(
		'optimization_complete' => 'המיטוב הושלם',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified',	// TODO - Translation
			'updated' => 'Your password has been modified',	// TODO - Translation
		),
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'אירעה שגיאה במהלך הגדרת מערכת האימיות. אנא נסו שוב מאוחר יותר.',
			'set' => 'טופס הוא כרגע מערכת האימות כברירת מחדל.',
		),
		'login' => array(
			'invalid' => 'הכניסה לחשבון שגויה',
			'success' => 'You are connected',	// TODO - Translation
		),
		'logout' => array(
			'success' => 'You are disconnected',	// TODO - Translation
		),
		'no_password_set' => 'לא הוגדרה סיסמת מנהל. תכונה זו אינה זמינה.',
	),
	'conf' => array(
		'error' => 'An error occurred during configuration saving',	// TODO - Translation
		'query_created' => 'השאילתה "%s" נוצרה.',
		'shortcuts_updated' => 'קיצורי הדרך עודכנו',
		'updated' => 'ההגדרות עודכנו',
	),
	'extensions' => array(
		'already_enabled' => '%s is already enabled',	// TODO - Translation
		'disable' => array(
			'ko' => '%s cannot be disabled. <a href="%s">Check FreshRSS logs</a> for details.',	// TODO - Translation
			'ok' => '%s is now disabled',	// TODO - Translation
		),
		'enable' => array(
			'ko' => '%s cannot be enabled. <a href="%s">Check FreshRSS logs</a> for details.',	// TODO - Translation
			'ok' => '%s is now enabled',	// TODO - Translation
		),
		'no_access' => 'You have no access on %s',	// TODO - Translation
		'not_enabled' => '%s is not enabled yet',
		'not_found' => '%s does not exist',	// TODO - Translation
	),
	'import_export' => array(
		'export_no_zip_extension' => 'הרחבת ZIP אינה מותקנת על השרת.',
		'feeds_imported' => 'ההזנות שלך יובאו וכעת יעודכנו',
		'feeds_imported_with_errors' => 'ההזנות שלך יובאו אך אירעו מספר שגיאות',
		'file_cannot_be_uploaded' => 'אין אפשרות להעלות את הקובץ!',
		'no_zip_extension' => 'הרחבת ZIP אינה מותקנת על השרת.',
		'zip_error' => 'אירעה שגיאה במהלך ייבוא קובץ הZIP.',
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified',	// TODO - Translation
		'updated' => 'Your profile has been modified',	// TODO - Translation
	),
	'sub' => array(
		'actualize' => 'מימוש',
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',	// TODO - Translation
			'marked_unread' => 'The articles have been marked as unread.',	// TODO - Translation
		),
		'category' => array(
			'created' => 'Category %s has been created.',	// TODO - Translation
			'deleted' => 'Category has been deleted.',	// TODO - Translation
			'emptied' => 'הקטגוריה רוקנה',
			'error' => 'Category cannot be updated',	// TODO - Translation
			'name_exists' => 'Category name already exists.',	// TODO - Translation
			'no_id' => 'You must precise the id of the category.',
			'no_name' => 'Category name cannot be empty.',	// TODO - Translation
			'not_delete_default' => 'You cannot delete the default category!',	// TODO - Translation
			'not_exist' => 'The category does not exist!',	// TODO - Translation
			'over_max' => 'You have reached your limit of categories (%d)',	// TODO - Translation
			'updated' => 'Category has been updated.',	// TODO - Translation
		),
		'feed' => array(
			'actualized' => '<em>%s</em> עודכן',
			'actualizeds' => 'הזנות RSS עודכנו',
			'added' => 'RSS הזנת <em>%s</em> נוספה',
			'already_subscribed' => 'אתה כבר רשום ל <em>%s</em>',
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO - Translation
			'deleted' => 'ההזנה נמחקה',
			'error' => 'Feed cannot be updated',	// TODO - Translation
			'internal_problem' => 'אין אפשרות להוסיף את ההזנה. <a href="%s">בדקו את הלוגים</a> לפרטים.',
			'invalid_url' => 'URL <em>%s</em> אינו תקין',
			'n_actualized' => '%d הזנות עודכנו',
			'n_entries_deleted' => '%d המאמרים נמחקו',
			'no_refresh' => 'אין הזנה שניתן לרענן…',
			'not_added' => '<em>%s</em> אין אפשרות להוסיף את',
			'not_found' => 'Feed cannot be found',	// TODO - Translation
			'over_max' => 'You have reached your limit of feeds (%d)',	// TODO - Translation
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO - Translation
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',	// TODO - Translation
				'no_entries' => 'There are no articles in this feed. You need at least one article to create a preview.',	// TODO - Translation
				'no_feed' => 'Internal error (feed can’t be found).',	// TODO - Translation
				'no_result' => 'The selector didn\'t match anything. As a fallback the original feed text will be displayed instead.',	// TODO - Translation
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO - Translation
			),
			'updated' => 'ההזנה התעדכנה',
		),
		'purge_completed' => 'הניקוי הושלם (%d מאמרים נמחקו)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS will be now updated to the <strong>version %s</strong>.',
		'error' => 'תהליך העדכון נתקל בשגיאה: %s',
		'file_is_nok' => 'יש לבדוק את ההרשאות בתיקייה <em>%s</em>. שרת הHTTP חייב להיות בעל הרשאות כתיבה.',
		'finished' => 'העדכון הושלם!',
		'none' => 'אין עדכון להחלה',
		'server_not_found' => 'לא ניתן למצוא את שרת העדכון. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'המשתמש %s נוצר',
			'error' => 'User %s cannot be created',	// TODO - Translation
		),
		'deleted' => array(
			'_' => 'המשתמש %s נמחק',
			'error' => 'User %s cannot be deleted',	// TODO - Translation
		),
		'updated' => array(
			'_' => 'User %s has been updated',	// TODO - Translation
			'error' => 'User %s has not been updated',	// TODO - Translation
		),
	),
);

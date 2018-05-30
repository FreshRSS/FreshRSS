<?php

return array(
	'admin' => array(
		'optimization_complete' => 'המיטוב הושלם',
	),
	'access' => array(
		'denied' => 'אין לך הרשאות לצפות בדף זה',
		'not_found' => 'הדף הזה לא נמצא',
	),
	'auth' => array(
		'form' => array(
			'not_set' => 'אירעה שגיאה במהלך הגדרת מערכת האימיות. אנא נסו שוב מאוחר יותר.',
			'set' => 'טופס הוא כרגע מערכת האימות כברירת מחדל.',
		),
		'login' => array(
			'invalid' => 'הכניסה לחשבון שגויה',
			'success' => 'You are connected', // @todo
		),
		'logout' => array(
			'success' => 'You are disconnected', // @todo
		),
		'no_password_set' => 'לא הוגדרה סיסמת מנהל. תכונה זו אינה זמינה.',
		'not_persona' => 'ניתן לאפס את מערכת הפרסונה בלבד.',
	),
	'conf' => array(
		'error' => 'An error occurred during configuration saving', // @todo
		'query_created' => 'השאילתה "%s" נוצרה.',
		'shortcuts_updated' => 'קיצורי הדרך עודכנו',
		'updated' => 'ההגדרות עודכנו',
	),
	'extensions' => array(
		'already_enabled' => '%s is already enabled', // @todo
		'disable' => array(
			'ko' => '%s cannot be disabled. <a href="%s">Check FreshRSS logs</a> for details.', // @todo
			'ok' => '%s is now disabled', // @todo
		),
		'enable' => array(
			'ko' => '%s cannot be enabled. <a href="%s">Check FreshRSS logs</a> for details.', // @todo
			'ok' => '%s is now enabled', // @todo
		),
		'no_access' => 'You have no access on %s', // @todo
		'not_enabled' => '%s is not enabled yet', // @todo
		'not_found' => '%s does not exist', // @todo
	),
	'import_export' => array(
		'export_no_zip_extension' => 'הרחבת ZIP אינה מותקנת על השרת.',
		'feeds_imported' => 'ההזנות שלך יובאו וכעת יעודכנו',
		'feeds_imported_with_errors' => 'ההזנות שלך יובאו אך אירעו מספר שגיאות',
		'file_cannot_be_uploaded' => 'אין אפשרות להעלות את הקובץ!',
		'no_zip_extension' => 'הרחבת ZIP אינה מותקנת על השרת.',
		'zip_error' => 'אירעה שגיאה במהלך ייבוא קובץ הZIP.',
	),
	'sub' => array(
		'actualize' => 'מימוש',
		'category' => array(
			'created' => 'Category %s has been created.', // @todo
			'deleted' => 'Category has been deleted.', // @todo
			'emptied' => 'הקטגוריה רוקנה',
			'error' => 'Category cannot be updated', // @todo
			'name_exists' => 'Category name already exists.', // @todo
			'no_id' => 'You must precise the id of the category.', // @todo
			'no_name' => 'Category name cannot be empty.', // @todo
			'not_delete_default' => 'You cannot delete the default category!', // @todo
			'not_exist' => 'The category does not exist!', // @todo
			'over_max' => 'You have reached your limit of categories (%d)', // @todo
			'updated' => 'Category has been updated.', // @todo
		),
		'feed' => array(
			'actualized' => '<em>%s</em> עודכן',
			'actualizeds' => 'הזנות RSS עודכנו',
			'added' => 'RSS הזנת <em>%s</em> נוספה',
			'already_subscribed' => 'אתה כבר רשום ל <em>%s</em>',
			'deleted' => 'ההזנה נמחקה',
			'error' => 'Feed cannot be updated', // @todo
			'internal_problem' => 'אין אפשרות להוסיף את ההזנה. <a href="%s">בדקו את הלוגים</a> לפרטים.', // @todo
			'invalid_url' => 'URL <em>%s</em> אינו תקין',
			'marked_read' => 'הזנות סומנו כנקראו',
			'n_actualized' => '%d הזנות עודכנו',
			'n_entries_deleted' => '%d המאמרים נמחקו',
			'no_refresh' => 'אין הזנה שניתן לרענן…',
			'not_added' => '<em>%s</em> אין אפשרות להוסיף את',
			'over_max' => 'You have reached your limit of feeds (%d)', // @todo
			'updated' => 'ההזנה התעדכנה',
		),
		'purge_completed' => 'הניקוי הושלם (%d מאמרים נמחקו)',
	),
	'update' => array(
		'can_apply' => 'FreshRSS will be now updated to the <strong>version %s</strong>.', // @todo
		'error' => 'תהליך העדכון נתקל בשגיאה: %s',
		'file_is_nok' => 'יש לבדוק את ההרשאות בתיקייה <em>%s</em>. שרת הHTTP חייב להיות בעל הרשאות כתיבה.',
		'finished' => 'העדכון הושלם!',
		'none' => 'אין עדכון להחלה',
		'server_not_found' => 'לא ניתן למצוא את שרת העדכון. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'המשתמש %s נוצר',
			'error' => 'User %s cannot be created', // @todo
		),
		'deleted' => array(
			'_' => 'המשתמש %s נמחק',
			'error' => 'User %s cannot be deleted', // @todo
		),
		'updated' => array(
			'_' => 'User %s has been updated', // TODO
			'error' => 'User %s has not been updated', // TODO
		),
	),
	'profile' => array(
		'error' => 'Your profile cannot be modified', // @todo
		'updated' => 'Your profile has been modified', // @todo
	),
);

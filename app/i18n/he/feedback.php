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
		'denied' => 'אין לך הרשאות לצפות בדף זה',
		'not_found' => 'הדף הזה לא נמצא',
	),
	'admin' => array(
		'optimization_complete' => 'המיטוב הושלם',
	),
	'api' => array(
		'password' => array(
			'failed' => 'Your password cannot be modified',	// TODO
			'updated' => 'Your password has been modified',	// TODO
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'הכניסה לחשבון שגויה',
			'success' => 'You are connected',	// TODO
		),
		'logout' => array(
			'success' => 'You are disconnected',	// TODO
		),
	),
	'conf' => array(
		'error' => 'An error occurred while saving configuration',	// TODO
		'query_created' => 'השאילתה "%s" נוצרה.',
		'shortcuts_updated' => 'קיצורי הדרך עודכנו',
		'updated' => 'ההגדרות עודכנו',
	),
	'extensions' => array(
		'already_enabled' => '%s is already enabled',	// TODO
		'cannot_remove' => '%s cannot be removed',	// TODO
		'disable' => array(
			'ko' => '%s cannot be disabled. <a href="%s">Check FreshRSS logs</a> for details.',	// TODO
			'ok' => '%s is now disabled',	// TODO
		),
		'enable' => array(
			'ko' => '%s cannot be enabled. <a href="%s">Check FreshRSS logs</a> for details.',	// TODO
			'ok' => '%s is now enabled',	// TODO
		),
		'no_access' => 'You have no access on %s',	// TODO
		'not_enabled' => '%s is not enabled yet',
		'not_found' => '%s does not exist',	// TODO
		'removed' => '%s removed',	// TODO
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
		'error' => 'Your profile cannot be modified',	// TODO
		'updated' => 'Your profile has been modified',	// TODO
	),
	'sub' => array(
		'actualize' => 'מימוש',
		'articles' => array(
			'marked_read' => 'The selected articles have been marked as read.',	// TODO
			'marked_unread' => 'The articles have been marked as unread.',	// TODO
		),
		'category' => array(
			'created' => 'Category %s has been created.',	// TODO
			'deleted' => 'Category has been deleted.',	// TODO
			'emptied' => 'הקטגוריה רוקנה',
			'error' => 'Category cannot be updated',	// TODO
			'name_exists' => 'Category name already exists.',	// TODO
			'no_id' => 'You must precise the id of the category.',
			'no_name' => 'Category name cannot be empty.',	// TODO
			'not_delete_default' => 'You cannot delete the default category!',	// TODO
			'not_exist' => 'The category does not exist!',	// TODO
			'over_max' => 'You have reached your limit of categories (%d)',	// TODO
			'updated' => 'Category has been updated.',	// TODO
		),
		'feed' => array(
			'actualized' => '<em>%s</em> עודכן',
			'actualizeds' => 'הזנות RSS עודכנו',
			'added' => 'RSS הזנת <em>%s</em> נוספה',
			'already_subscribed' => 'אתה כבר רשום ל <em>%s</em>',
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO
			'deleted' => 'ההזנה נמחקה',
			'error' => 'Feed cannot be updated',	// TODO
			'internal_problem' => 'אין אפשרות להוסיף את ההזנה. <a href="%s">בדקו את הלוגים</a> לפרטים.',
			'invalid_url' => 'URL <em>%s</em> אינו תקין',
			'n_actualized' => '%d הזנות עודכנו',
			'n_entries_deleted' => '%d המאמרים נמחקו',
			'no_refresh' => 'אין הזנה שניתן לרענן…',
			'not_added' => '<em>%s</em> אין אפשרות להוסיף את',
			'not_found' => 'Feed cannot be found',	// TODO
			'over_max' => 'You have reached your limit of feeds (%d)',	// TODO
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO
			'selector_preview' => array(
				'http_error' => 'Failed to load website content.',	// TODO
				'no_entries' => 'There are no articles in this feed. You need at least one article to create a preview.',	// TODO
				'no_feed' => 'Internal error (feed cannot be found).',	// TODO
				'no_result' => 'The selector didn\'t match anything. As a fallback the original feed text will be displayed instead.',	// TODO
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO
			),
			'updated' => 'ההזנה התעדכנה',
		),
		'purge_completed' => 'הניקוי הושלם (%d מאמרים נמחקו)',
	),
	'tag' => array(
		'created' => 'Tag "%s" has been created.',	// TODO
		'name_exists' => 'Tag name already exists.',	// TODO
		'renamed' => 'Tag "%s" has been renamed to "%s".',	// TODO
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
			'error' => 'User %s cannot be created',	// TODO
		),
		'deleted' => array(
			'_' => 'המשתמש %s נמחק',
			'error' => 'User %s cannot be deleted',	// TODO
		),
		'updated' => array(
			'_' => 'User %s has been updated',	// TODO
			'error' => 'User %s has not been updated',	// TODO
		),
	),
);

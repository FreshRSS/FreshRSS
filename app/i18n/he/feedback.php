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

return [
	'access' => [
		'denied' => 'אין לך הרשאות לצפות בדף זה',
		'not_found' => 'הדף הזה לא נמצא',
	],
	'admin' => [
		'optimization_complete' => 'המיטוב הושלם',
	],
	'api' => [
		'password' => [
			'failed' => 'Your password cannot be modified',	// TODO
			'updated' => 'Your password has been modified',	// TODO
		],
	],
	'auth' => [
		'login' => [
			'invalid' => 'הכניסה לחשבון שגויה',
			'success' => 'You are connected',	// TODO
		],
		'logout' => [
			'success' => 'You are disconnected',	// TODO
		],
	],
	'conf' => [
		'error' => 'An error occurred while saving configuration',	// TODO
		'query_created' => 'השאילתה “%s” נוצרה.',
		'shortcuts_updated' => 'קיצורי הדרך עודכנו',
		'updated' => 'ההגדרות עודכנו',
	],
	'extensions' => [
		'already_enabled' => '%s is already enabled',	// TODO
		'cannot_remove' => '%s cannot be removed',	// TODO
		'disable' => [
			'ko' => '%s cannot be disabled. <a href="%s">Check FreshRSS logs</a> for details.',	// TODO
			'ok' => '%s is now disabled',	// TODO
		],
		'enable' => [
			'ko' => '%s cannot be enabled. <a href="%s">Check FreshRSS logs</a> for details.',	// TODO
			'ok' => '%s is now enabled',	// TODO
		],
		'no_access' => 'You have no access on %s',	// TODO
		'not_enabled' => '%s is not enabled yet',
		'not_found' => '%s does not exist',	// TODO
		'removed' => '%s removed',	// TODO
	],
	'import_export' => [
		'export_no_zip_extension' => 'הרחבת ZIP אינה מותקנת על השרת.',
		'feeds_imported' => 'ההזנות שלך יובאו וכעת יעודכנו / Your feeds have been imported. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'feeds_imported_with_errors' => 'ההזנות שלך יובאו אך אירעו מספר שגיאות / Your feeds have been imported, but some errors occurred. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'file_cannot_be_uploaded' => 'אין אפשרות להעלות את הקובץ!',
		'no_zip_extension' => 'הרחבת ZIP אינה מותקנת על השרת.',
		'zip_error' => 'אירעה שגיאה במהלך ייבוא קובץ הZIP.',	// DIRTY
	],
	'profile' => [
		'error' => 'Your profile cannot be modified',	// TODO
		'updated' => 'Your profile has been modified',	// TODO
	],
	'sub' => [
		'actualize' => 'מימוש',
		'articles' => [
			'marked_read' => 'The selected articles have been marked as read.',	// TODO
			'marked_unread' => 'The articles have been marked as unread.',	// TODO
		],
		'category' => [
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
		],
		'feed' => [
			'actualized' => '<em>%s</em> עודכן',
			'actualizeds' => 'הזנות RSS עודכנו',
			'added' => 'RSS הזנת <em>%s</em> נוספה',
			'already_subscribed' => 'אתה כבר רשום ל <em>%s</em>',
			'cache_cleared' => '<em>%s</em> cache has been cleared',	// TODO
			'deleted' => 'ההזנה נמחקה',
			'error' => 'Feed cannot be updated',	// TODO
			'internal_problem' => 'אין אפשרות להוסיף את ההזנה. <a href="%s">בדקו את הלוגים</a> לפרטים. You can try force adding by appending <code>#force_feed</code> to the URL.',	// DIRTY
			'invalid_url' => 'URL <em>%s</em> אינו תקין',
			'n_actualized' => '%d הזנות עודכנו',
			'n_entries_deleted' => '%d המאמרים נמחקו',
			'no_refresh' => 'אין הזנה שניתן לרענן…',
			'not_added' => '<em>%s</em> אין אפשרות להוסיף את',
			'not_found' => 'Feed cannot be found',	// TODO
			'over_max' => 'You have reached your limit of feeds (%d)',	// TODO
			'reloaded' => '<em>%s</em> has been reloaded',	// TODO
			'selector_preview' => [
				'http_error' => 'Failed to load website content.',	// TODO
				'no_entries' => 'There are no articles in this feed. You need at least one article to create a preview.',	// TODO
				'no_feed' => 'Internal error (feed cannot be found).',	// TODO
				'no_result' => 'The selector didn’t match anything. As a fallback the original feed text will be displayed instead.',	// TODO
				'selector_empty' => 'The selector is empty. You need to define one to create a preview.',	// TODO
			],
			'updated' => 'ההזנה התעדכנה',
		],
		'purge_completed' => 'הניקוי הושלם (%d מאמרים נמחקו)',
	],
	'tag' => [
		'created' => 'Label “%s” has been created.',	// TODO
		'error' => 'Label could not be updated!',	// TODO
		'name_exists' => 'Label name already exists.',	// TODO
		'renamed' => 'Label “%s” has been renamed to “%s”.',	// TODO
		'updated' => 'Label has been updated.',	// TODO
	],
	'update' => [
		'can_apply' => 'FreshRSS will be now updated to the <strong>version %s</strong>.',
		'error' => 'תהליך העדכון נתקל בשגיאה: %s',
		'file_is_nok' => 'יש לבדוק את ההרשאות בתיקייה <em>%s</em>. שרת הHTTP חייב להיות בעל הרשאות כתיבה.',
		'finished' => 'העדכון הושלם!',
		'none' => 'אין עדכון להחלה',
		'server_not_found' => 'לא ניתן למצוא את שרת העדכון. [%s]',
	],
	'user' => [
		'created' => [
			'_' => 'המשתמש %s נוצר',
			'error' => 'User %s cannot be created',	// TODO
		],
		'deleted' => [
			'_' => 'המשתמש %s נמחק',
			'error' => 'User %s cannot be deleted',	// TODO
		],
		'updated' => [
			'_' => 'User %s has been updated',	// TODO
			'error' => 'User %s has not been updated',	// TODO
		],
	],
];

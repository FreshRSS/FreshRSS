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
		'finish' => 'השלמת ההתקנה',
		'fix_errors_before' => 'יש לתקן את השגיאות לפני המעבר לשלב הבא.',
		'keep_install' => 'Keep previous configuration',	// TODO
		'next_step' => 'לשלב הבא',
		'reinstall' => 'Reinstall FreshRSS',	// TODO
	),
	'auth' => array(
		'form' => 'טופס אינטרנטי (מסורתי, דורש JavaScript)',
		'http' => 'HTTP (למשתמשים מתקדמים עם HTTPS)',
		'none' => 'ללא (מסוכן)',
		'password_form' => 'סיסמה<br /><small>(לשימוש בטפוס ההרשמה)</small>',
		'password_format' => 'At least 7 characters',	// TODO
		'type' => 'שיטת אימות',
	),
	'bdd' => array(
		'_' => 'בסיס נתונים',
		'conf' => array(
			'_' => 'הגדרות בסיס נתונים',
			'ko' => 'נא לוודא את הגדרות בסיס הנתונים.',
			'ok' => 'הגדרות בסיס הנתונים נשמרו.',
		),
		'host' => 'מארח',
		'password' => 'HTTP סיסמה',
		'prefix' => 'קידומת הטבלה',
		'type' => 'סוג בסיס הנתונים',
		'username' => 'HTTP שם משתמש',
	),
	'check' => array(
		'_' => 'בדיקות',
		'already_installed' => 'We have detected that FreshRSS is already installed!',	// TODO
		'cache' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'ההרשאות בתיקיית המטמון תקינות',
		),
		'ctype' => array(
			'nok' => 'הספרייה הנדרשת ל character type checking (php-ctype) אינה מותקנת',
			'ok' => 'הספרייה הנדרשת ל character type checking (ctype) מותקנת',
		),
		'curl' => array(
			'nok' => 'בURL לא מותקן (php-curl package)',
			'ok' => 'יש לכם את גירסת %s של cURL',
		),
		'data' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'ההרשאות בתיקיית הדאטא תקינות',
		),
		'dom' => array(
			'nok' => 'הספרייה הנדרשת לסיור ב DOM אינה מותקנת	(php-xml package)',
			'ok' => 'הספרייה הנדרשת לסיור ב DOM מותקנת',
		),
		'favicons' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'ההרשאות בתיקיית הfavicons תקינות',
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// TODO
			'ok' => 'You have the fileinfo library.',	// TODO
		),
		'json' => array(
			'nok' => 'Cannot find the recommended library to parse JSON.',	// TODO
			'ok' => 'You have the recommended library to parse JSON.',	// TODO
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// TODO
			'ok' => 'You have the recommended library mbstring for Unicode.',	// TODO
		),
		'pcre' => array(
			'nok' => 'הספרייה הנדרשת לביטויים רגולריים אינה מותקנת (php-pcre)',
			'ok' => 'הספרייה הנדרשת לביטויים רגולריים מותקנת (PCRE)',
		),
		'pdo' => array(
			'nok' => 'PDO אינו מותקן או שאחד ממנהלי ההתקנים שלו חסר (pdo_mysql, pdo_sqlite)',
			'ok' => 'PDO מותקן ולפחות אחד ממנהלי ההתקן הנתמכים מותקן (pdo_mysql, pdo_sqlite)',
		),
		'php' => array(
			'nok' => 'גירסת PHP שלכם היא %s אך FreshRSS דורש לפחות את גירסה %s',
			'ok' => 'גירסת PHP שלכם היא %s, שתואמת ל FreshRSS',
		),
		'reload' => 'בדוק שוב',
		'tmp' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',	// TODO
			'ok' => 'Permissions on the temp directory are good.',	// TODO
		),
		'unknown_process_username' => 'unknown',	// TODO
		'users' => array(
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',	// TODO
			'ok' => 'Permissions on the users directory are good.',	// TODO
		),
		'xml' => array(
			'nok' => 'Cannot find the required library to parse XML.',	// TODO
			'ok' => 'You have the required library to parse XML.',	// TODO
		),
	),
	'conf' => array(
		'_' => 'הגדרות כלליות',
		'ok' => 'ההגדרות הכלליות נשמרו.',
	),
	'congratulations' => 'מזל טוב!',
	'default_user' => 'שם המשתמש של משתמש ברירת המחדל <small>(לכל היותר 16 תווים אלפאנומריים)</small>',
	'fix_errors_before' => 'יש לתקן את השגיאות לפני המעבר לשלב הבא.',
	'javascript_is_better' => 'FreshRSS מעדיף שתאפשרו JavaScript',
	'js' => array(
		'confirm_reinstall' => 'You will lose your previous configuration by reinstalling FreshRSS. Are you sure you want to continue?',	// TODO
	),
	'language' => array(
		'_' => 'שפה',
		'choose' => 'בחירת שפה ל FreshRSS',
		'defined' => 'השפה הוגדרה.',
	),
	'missing_applied_migrations' => 'Something went wrong; you should create an empty file <em>%s</em> manually.',	// TODO
	'ok' => 'The installation process was successful.',	// TODO
	'session' => array(
		'nok' => 'The web server seems to be incorrectly configured for cookies required for PHP sessions!',	// TODO
	),
	'step' => 'step %d',	// TODO
	'steps' => 'שלבים',
	'this_is_the_end' => 'סיום',
	'title' => 'התקנה · FreshRSS',
);

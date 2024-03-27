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
	'action' => [
		'finish' => 'השלמת ההתקנה',
		'fix_errors_before' => 'יש לתקן את השגיאות לפני המעבר לשלב הבא.',
		'keep_install' => 'Keep previous configuration',	// TODO
		'next_step' => 'לשלב הבא',
		'reinstall' => 'Reinstall FreshRSS',	// TODO
	],
	'auth' => [
		'form' => 'טופס אינטרנטי (מסורתי, דורש JavaScript)',
		'http' => 'HTTP (למשתמשים מתקדמים עם HTTPS)',
		'none' => 'ללא (מסוכן)',
		'password_form' => 'סיסמה<br /><small>(לשימוש בטפוס ההרשמה)</small>',
		'password_format' => 'At least 7 characters',	// TODO
		'type' => 'שיטת אימות',
	],
	'bdd' => [
		'_' => 'בסיס נתונים',
		'conf' => [
			'_' => 'הגדרות בסיס נתונים',
			'ko' => 'נא לוודא את הגדרות בסיס הנתונים.',
			'ok' => 'הגדרות בסיס הנתונים נשמרו.',
		],
		'host' => 'מארח',
		'password' => 'HTTP סיסמה',
		'prefix' => 'קידומת הטבלה',
		'type' => 'סוג בסיס הנתונים',
		'username' => 'HTTP שם משתמש',
	],
	'check' => [
		'_' => 'בדיקות',
		'already_installed' => 'We have detected that FreshRSS is already installed!',	// TODO
		'cache' => [
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'ההרשאות בתיקיית המטמון תקינות',
		],
		'ctype' => [
			'nok' => 'הספרייה הנדרשת ל character type checking (php-ctype) אינה מותקנת',
			'ok' => 'הספרייה הנדרשת ל character type checking (ctype) מותקנת',
		],
		'curl' => [
			'nok' => 'בURL לא מותקן (php-curl package)',
			'ok' => 'יש לכם את גירסת %s של cURL',
		],
		'data' => [
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'ההרשאות בתיקיית הדאטא תקינות',
		],
		'dom' => [
			'nok' => 'הספרייה הנדרשת לסיור ב DOM אינה מותקנת	(php-xml package)',
			'ok' => 'הספרייה הנדרשת לסיור ב DOM מותקנת',
		],
		'favicons' => [
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',
			'ok' => 'ההרשאות בתיקיית הfavicons תקינות',
		],
		'fileinfo' => [
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// TODO
			'ok' => 'You have the fileinfo library.',	// TODO
		],
		'json' => [
			'nok' => 'Cannot find the recommended library to parse JSON.',	// TODO
			'ok' => 'You have the recommended library to parse JSON.',	// TODO
		],
		'mbstring' => [
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// TODO
			'ok' => 'You have the recommended library mbstring for Unicode.',	// TODO
		],
		'pcre' => [
			'nok' => 'הספרייה הנדרשת לביטויים רגולריים אינה מותקנת (php-pcre)',
			'ok' => 'הספרייה הנדרשת לביטויים רגולריים מותקנת (PCRE)',
		],
		'pdo' => [
			'nok' => 'PDO אינו מותקן או שאחד ממנהלי ההתקנים שלו חסר (pdo_mysql, pdo_sqlite)',
			'ok' => 'PDO מותקן ולפחות אחד ממנהלי ההתקן הנתמכים מותקן (pdo_mysql, pdo_sqlite)',
		],
		'php' => [
			'nok' => 'גירסת PHP שלכם היא %s אך FreshRSS דורש לפחות את גירסה %s',
			'ok' => 'גירסת PHP שלכם היא %s, שתואמת ל FreshRSS',
		],
		'reload' => 'בדוק שוב',
		'tmp' => [
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',	// TODO
			'ok' => 'Permissions on the temp directory are good.',	// TODO
		],
		'unknown_process_username' => 'unknown',	// TODO
		'users' => [
			'nok' => 'Check permissions on the <em>%1$s</em> directory for <em>%2$s</em> user. The HTTP server must have write permissions.',	// TODO
			'ok' => 'Permissions on the users directory are good.',	// TODO
		],
		'xml' => [
			'nok' => 'Cannot find the required library to parse XML.',	// TODO
			'ok' => 'You have the required library to parse XML.',	// TODO
		],
	],
	'conf' => [
		'_' => 'הגדרות כלליות',
		'ok' => 'ההגדרות הכלליות נשמרו.',
	],
	'congratulations' => 'מזל טוב!',
	'default_user' => [
		'_' => 'שם המשתמש של משתמש ברירת המחדל',
		'max_char' => 'לכל היותר 16 תווים אלפאנומריים',
	],
	'fix_errors_before' => 'יש לתקן את השגיאות לפני המעבר לשלב הבא.',
	'javascript_is_better' => 'FreshRSS מעדיף שתאפשרו JavaScript',
	'js' => [
		'confirm_reinstall' => 'You will lose your previous configuration by reinstalling FreshRSS. Are you sure you want to continue?',	// TODO
	],
	'language' => [
		'_' => 'שפה',
		'choose' => 'בחירת שפה ל FreshRSS',
		'defined' => 'השפה הוגדרה.',
	],
	'missing_applied_migrations' => 'Something went wrong; you should create an empty file <em>%s</em> manually.',	// TODO
	'ok' => 'The installation process was successful.',	// TODO
	'session' => [
		'nok' => 'The web server seems to be incorrectly configured for cookies required for PHP sessions!',	// TODO
	],
	'step' => 'step %d',	// TODO
	'steps' => 'שלבים',
	'this_is_the_end' => 'סיום',
	'title' => 'התקנה · FreshRSS',
];

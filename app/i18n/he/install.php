<?php

return array(
	'action' => array(
		'finish' => 'השלמת ההתקנה',
		'fix_errors_before' => 'יש לתקן את השגיאות לפני המעבר לשלב הבא.',
		'keep_install' => 'Keep previous configuration',	// TODO - Translation
		'next_step' => 'לשלב הבא',
		'reinstall' => 'Reinstall FreshRSS',	// TODO - Translation
	),
	'auth' => array(
		'form' => 'טופס אינטרנטי (מסורתי, דורש JavaScript)',
		'http' => 'HTTP (למשתמשים מתקדמים עם HTTPS)',
		'none' => 'ללא (מסוכן)',
		'password_form' => 'סיסמה<br /><small>(לשימוש בטפוס ההרשמה)</small>',
		'password_format' => 'At least 7 characters',	// TODO - Translation
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
		'already_installed' => 'We have detected that FreshRSS is already installed!',	// TODO - Translation
		'cache' => array(
			'nok' => 'Check permissions on the <em>%s</em> directory. The HTTP server must have write permission.',	// TODO - Translation
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
			'nok' => 'Check permissions on the <em>%s</em> directory. The HTTP server must have write permission.',	// TODO - Translation
			'ok' => 'ההרשאות בתיקיית הדאטא תקינות',
		),
		'dom' => array(
			'nok' => 'הספרייה הנדרשת לסיור ב DOM אינה מותקנת	(php-xml package)',
			'ok' => 'הספרייה הנדרשת לסיור ב DOM מותקנת',
		),
		'favicons' => array(
			'nok' => 'Check permissions on the <em>%s</em> directory. The HTTP server must have write permission.',	// TODO - Translation
			'ok' => 'ההרשאות בתיקיית הfavicons תקינות',
		),
		'fileinfo' => array(
			'nok' => 'Cannot find the PHP fileinfo library (fileinfo package).',	// TODO - Translation
			'ok' => 'You have the fileinfo library.',	// TODO - Translation
		),
		'http_referer' => array(
			'nok' => 'נא לדבוק שאינך פוגעת ב HTTP REFERER שלך.',
			'ok' => 'הHTTP REFERER ידוע ותאם לשרת שלך.',
		),
		'json' => array(
			'nok' => 'Cannot find the recommended library to parse JSON.',	// TODO - Translation
			'ok' => 'You have the recommended library to parse JSON.',	// TODO - Translation
		),
		'mbstring' => array(
			'nok' => 'Cannot find the recommended library mbstring for Unicode.',	// TODO - Translation
			'ok' => 'You have the recommended library mbstring for Unicode.',	// TODO - Translation
		),
		'minz' => array(
			'nok' => 'You lack the Minz framework.',
			'ok' => 'יש לכם את תשתית Minz',
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
		'tmp' => array(
			'nok' => 'Check permissions on the <em>%s</em> directory. The HTTP server must have write permissions.',	// TODO - Translation
			'ok' => 'Permissions on the temp directory are good.',	// TODO - Translation
		),
		'users' => array(
			'nok' => 'Check permissions on the <em>%s</em> directory. The HTTP server must have write permissions.',	// TODO - Translation
			'ok' => 'Permissions on the users directory are good.',	// TODO - Translation
		),
		'xml' => array(
			'nok' => 'Cannot find the required library to parse XML.',	// TODO - Translation
			'ok' => 'You have the required library to parse XML.',	// TODO - Translation
		),
	),
	'conf' => array(
		'_' => 'הגדרות כלליות',
		'ok' => 'ההגדרות הכלליות נשמרו.',
	),
	'congratulations' => 'מזל טוב!',
	'default_user' => 'שם המשתמש של משתמש ברירת המחדל <small>(לכל היותר 16 תווים אלפאנומריים)</small>',
	'delete_articles_after' => 'מחיקת מאמרים לאחר',
	'fix_errors_before' => 'יש לתקן את השגיאות לפני המעבר לשלב הבא.',
	'javascript_is_better' => 'FreshRSS מעדיף שתאפשרו JavaScript',
	'js' => array(
		'confirm_reinstall' => 'You will lose your previous configuration by reinstalling FreshRSS. Are you sure you want to continue?',	// TODO - Translation
	),
	'language' => array(
		'_' => 'שפה',
		'choose' => 'בחירת שפה ל FreshRSS',
		'defined' => 'השפה הוגדרה.',
	),
	'not_deleted' => 'משהו נכשל; יש צורך למחוק את הקובץ <em>%s</em> ידנית.',
	'ok' => 'The installation process was successful.',	// TODO - Translation
	'step' => 'step %d',	// TODO - Translation
	'steps' => 'שלבים',
	'this_is_the_end' => 'סיום',
	'title' => 'התקנה · FreshRSS',
);

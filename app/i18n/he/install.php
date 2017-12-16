<?php

return array(
	'action' => array(
		'finish' => 'השלמת ההתקנה',
		'fix_errors_before' => 'יש לתקן את השגיאות לפני המעבר לשלב הבא.',
		'next_step' => 'לשלב הבא',
	),
	'auth' => array(
		'email_persona' => 'כתובת דואר אלקטרוני להרשמה<br /><small>(לצורך <a href="https://persona.org/" rel="external">מוזילה פרסונה</a>)</small>',
		'form' => 'טופס אינטרנטי (מסורתי, דורש JavaScript)',
		'http' => 'HTTP (למשתמשים מתקדמים עם HTTPS)',
		'none' => 'ללא (מסוכן)',
		'password_form' => 'סיסמה<br /><small>(לשימוש בטפוס ההרשמה)</small>',
		'password_format' => 'At least 7 characters', // @todo
		'persona' => 'מוזילה פרסונה (מודרני, דורש JavaScript)',
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
		'prefix' => 'קידומת הטבלה',
		'password' => 'HTTP סיסמה',
		'type' => 'סוג בסיס הנתונים',
		'username' => 'HTTP שם משתמש',
	),
	'check' => array(
		'_' => 'בדיקות',
		'cache' => array(
			'nok' => 'Check permissions on <em>./data/cache</em> directory. HTTP server must have rights to write into', // @todo
			'ok' => 'ההרשאות בתיקיית המטמון תקינות',
		),
		'ctype' => array(
			'nok' => 'הספרייה הנדרשת ל character type checking (php-ctype) אינה מותקנת',
			'ok' => 'הספרייה הנדרשת ל character type checking (ctype) מותקנת',
		),
		'curl' => array(
			'nok' => 'בURL לא מותקן (php5-curl package)',
			'ok' => 'יש לכם את גירסת %s של cURL',
		),
		'data' => array(
			'nok' => 'Check permissions on <em>./data</em> directory. HTTP server must have rights to write into', // @todo
			'ok' => 'ההרשאות בתיקיית הדאטא תקינות',
		),
		'dom' => array(
			'nok' => 'הספרייה הנדרשת לסיור ב DOM אינה מותקנת  (php-xml package)',
			'ok' => 'הספרייה הנדרשת לסיור ב DOM מותקנת',
		),
		'favicons' => array(
			'nok' => 'Check permissions on <em>./data/favicons</em> directory. HTTP server must have rights to write into', // @todo
			'ok' => 'ההרשאות בתיקיית הfavicons תקינות',
		),
		'http_referer' => array(
			'nok' => 'נא לדבוק שאינך פוגעת ב HTTP REFERER שלך.',
			'ok' => 'הHTTP REFERER ידוע ותאם לשרת שלך.',
		),
		'minz' => array(
			'nok' => 'You lack the Minz framework.', // @todo
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
		'persona' => array(
			'nok' => 'Check permissions on <em>./data/persona</em> directory. HTTP server must have rights to write into', // @todo
			'ok' => 'ההרשאות בתיקיית מוזילה פרסונה תקינות',
		),
		'php' => array(
			'nok' => 'גירסת PHP שלכם היא %s אך FreshRSS דורש לפחות את גירסה %s',
			'ok' => 'גירסת PHP שלכם היא %s, שתואמת ל FreshRSS',
		),
		'users' => array(
			'nok' => 'Check permissions on <em>./data/users</em> directory. HTTP server must have rights to write into', // @todo
			'ok' => 'Permissions on users directory are good.', // @todo
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
	'language' => array(
		'_' => 'שפה',
		'choose' => 'בחירת שפה ל FreshRSS',
		'defined' => 'השפה הוגדרה.',
	),
	'not_deleted' => 'משהו נכשל; יש צורך למחוק את הקובץ <em>%s</em> ידנית.',
	'ok' => 'The installation process was successful.', // @todo
	'step' => 'step %d', // @todo
	'steps' => 'שלבים',
	'title' => 'התקנה · FreshRSS',
	'this_is_the_end' => 'סיום',
);

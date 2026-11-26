<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

return array(
	'action' => array(
		'finish' => 'إكمال التثبيت',
		'fix_errors_before' => 'يرجى إصلاح جميع الأخطاء قبل المتابعة إلى الخطوة التالية.',
		'keep_install' => 'الاحتفاظ بالإعدادات السابقة',
		'next_step' => 'الانتقال إلى الخطوة التالية',
		'reinstall' => 'إعادة تثبيت FreshRSS',
	),
	'bdd' => array(
		'_' => 'قاعدة البيانات',
		'conf' => array(
			'_' => 'إعدادات قاعدة البيانات',
			'ko' => 'تحقق من إعدادات قاعدة البيانات الخاصة بك.',
			'ok' => 'تم حفظ إعدادات قاعدة البيانات.',
		),
		'host' => 'المضيف',
		'password' => 'كلمة مرور قاعدة البيانات',
		'prefix' => 'بادئة الجداول',
		'type' => 'نوع قاعدة البيانات',
		'username' => 'اسم مستخدم قاعدة البيانات',
	),
	'check' => array(
		'_' => 'الفحوصات',
		'already_installed' => 'لقد اكتشفنا أن FreshRSS مثبت بالفعل!',
		'cache' => array(
			'nok' => 'تحقق من الأذونات على دليل <em>%1$s</em> للمستخدم <em>%2$s</em>. يجب أن يكون لخادم HTTP إذن الكتابة.',
			'ok' => 'أذونات دليل ذاكرة التخزين المؤقت جيدة.',
		),
		'ctype' => array(
			'nok' => 'لا يمكن العثور على المكتبة المطلوبة للتحقق من أنواع الأحرف (php-ctype).',
			'ok' => 'لديك المكتبة المطلوبة للتحقق من أنواع الأحرف (ctype).',
		),
		'curl' => array(
			'nok' => 'لا يمكن العثور على مكتبة cURL المطلوبة (حزمة php-curl).',
			'ok' => 'لديك مكتبة cURL المطلوبة.',
		),
		'data' => array(
			'nok' => 'تحقق من الأذونات على دليل <em>%1$s</em> للمستخدم <em>%2$s</em>. يجب أن يكون لخادم HTTP إذن الكتابة.',
			'ok' => 'أذونات دليل البيانات جيدة.',
		),
		'database-connection' => array(
			'nok' => 'خطأ في الاتصال بقاعدة البيانات.',
			'ok' => 'الاتصال بقاعدة البيانات جيد.',
		),
		'database-table' => array(
			'nok' => 'جدول قاعدة البيانات "%s" غير مكتمل.',
			'ok' => 'جدول قاعدة البيانات "%s" جيد.',
		),
		'database-tables' => array(
			'nok' => 'بعض جداول قاعدة البيانات مفقودة.',
			'ok' => 'جميع جداول قاعدة البيانات موجودة.',
		),
		'database-title' => 'قاعدة البيانات',
		'docroot' => array(
			'nok' => 'لا يبدو أن جذر مستندات خادم الويب يشير إلى مجلد <code>./p/</code>. قد تكون مجلدات أخرى مثل <code>./data/</code> متاحة للعامة.',
			'ok' => 'يشير جذر مستندات خادم الويب بشكل صحيح إلى مجلد <code>./p/</code>.',
		),
		'dom' => array(
			'nok' => 'لا يمكن العثور على المكتبة المطلوبة لتصفح DOM.',
			'ok' => 'لديك المكتبة المطلوبة لتصفح DOM.',
		),
		'favicons' => array(
			'nok' => 'تحقق من الأذونات على دليل <em>%1$s</em> للمستخدم <em>%2$s</em>. يجب أن يكون لخادم HTTP إذن الكتابة.',
			'ok' => 'أذونات دليل الأيقونات المفضلة جيدة.',
		),
		'fileinfo' => array(
			'nok' => 'لا يمكن العثور على مكتبة PHP fileinfo الموصى بها (حزمة fileinfo).',
			'ok' => 'لديك مكتبة PHP fileinfo الموصى بها (حزمة fileinfo).',
		),
		'files' => 'تثبيت الملفات',
		'gmp' => array(
			'nok' => 'لا يمكن العثور على إضافة GMP المطلوبة لـ PHP بنظام 32 بت (حزمة php-gmp).',
			'ok' => 'لديك إضافة GMP المطلوبة لـ PHP بنظام 32 بت.',
		),
		'intl' => array(
			'nok' => 'لا يمكن العثور على المكتبة الموصى بها php-intl للتدويل.',
			'ok' => 'لديك المكتبة الموصى بها php-intl للتدويل.',
		),
		'json' => array(
			'nok' => 'لا يمكن العثور على المكتبة المطلوبة لتحليل JSON.',
			'ok' => 'لديك المكتبة المطلوبة لتحليل JSON.',
		),
		'mbstring' => array(
			'nok' => 'لا يمكن العثور على المكتبة الموصى بها mbstring لـ Unicode.',
			'ok' => 'لديك المكتبة الموصى بها mbstring لـ Unicode.',
		),
		'pcre' => array(
			'nok' => 'لا يمكن العثور على المكتبة المطلوبة للتعابير النمطية (php-pcre).',
			'ok' => 'لديك المكتبة المطلوبة للتعابير النمطية (PCRE).',
		),
		'pdo-mysql' => array(
			'nok' => 'لا يمكن العثور على برنامج تشغيل PDO المطلوب لـ MySQL/MariaDB.',
		),
		'pdo-pgsql' => array(
			'nok' => 'لا يمكن العثور على برنامج تشغيل PDO المطلوب لـ PostgreSQL.',
		),
		'pdo-sqlite' => array(
			'nok' => 'لا يمكن العثور على برنامج تشغيل PDO لـ SQLite.',
			'ok' => 'لديك برنامج تشغيل PDO لـ SQLite.',
		),
		'pdo' => array(
			'nok' => 'لا يمكن العثور على PDO أو أحد برامج التشغيل المدعومة (pdo_sqlite، pdo_pgsql، pdo_mysql).',
			'ok' => 'لديك PDO وواحد على الأقل من برامج التشغيل المدعومة (pdo_sqlite، pdo_pgsql، pdo_mysql).',
		),
		'php' => array(
			'_' => 'تثبيت PHP',
			'nok' => 'إصدار PHP الخاص بك هو %s لكن FreshRSS يتطلب الإصدار %s على الأقل.',
			'ok' => 'إصدار PHP الخاص بك (%s) متوافق مع FreshRSS.',
		),
		'reload' => 'التحقق مرة أخرى',
		'tmp' => array(
			'nok' => 'تحقق من الأذونات على دليل <em>%1$s</em> للمستخدم <em>%2$s</em>. يجب أن يكون لخادم HTTP أذونات الكتابة.',
			'ok' => 'أذونات الدليل المؤقت جيدة.',
		),
		'tokens' => array(
			'nok' => 'تحقق من الأذونات على دليل <em>./data/tokens</em>. يجب أن يكون لخادم HTTP إذن الكتابة',
			'ok' => 'أذونات دليل الرموز جيدة.',
		),
		'unknown_process_username' => 'غير معروف',
		'users' => array(
			'nok' => 'تحقق من الأذونات على دليل <em>%1$s</em> للمستخدم <em>%2$s</em>. يجب أن يكون لخادم HTTP أذونات الكتابة.',
			'ok' => 'أذونات دليل المستخدمين جيدة.',
		),
		'xml' => array(
			'nok' => 'لا يمكن العثور على المكتبة المطلوبة لتحليل XML.',
			'ok' => 'لديك المكتبة المطلوبة لتحليل XML.',
		),
		'zip' => array(
			'nok' => 'لا يمكن العثور على الإضافة الموصى بها لـ ZIP (حزمة php-zip).',
			'ok' => 'لديك الإضافة الموصى بها لـ ZIP (حزمة php-zip).',
		),
	),
	'conf' => array(
		'_' => 'الإعدادات العامة',
		'ok' => 'تم حفظ الإعدادات العامة.',
	),
	'congratulations' => 'تهانينا!',
	'default_user' => array(
		'_' => 'اسم مستخدم المستخدم الافتراضي',
		'max_char' => '1-39 حرفًا: أحرف وأرقام و <code>. _ @ -</code>',
	),
	'fix_errors_before' => 'يرجى إصلاح الأخطاء قبل المتابعة إلى الخطوة التالية.',
	'javascript_is_better' => 'يكون FreshRSS أكثر متعة مع تفعيل JavaScript',
	'js' => array(
		'confirm_reinstall' => 'ستفقد إعداداتك السابقة بإعادة تثبيت FreshRSS. هل أنت متأكد من رغبتك في المتابعة؟',
	),
	'language' => array(
		'_' => 'اللغة',
		'choose' => 'اختر لغة لـ FreshRSS',
		'defined' => 'تم تعريف اللغة.',
	),
	'missing_applied_migrations' => 'حدث خطأ ما؛ يجب عليك إنشاء ملف فارغ <em>%s</em> يدويًا.',
	'ok' => 'كانت عملية التثبيت ناجحة.',
	'session' => array(
		'nok' => 'يبدو أن خادم الويب مهيأ بشكل غير صحيح لملفات تعريف الارتباط المطلوبة لجلسات PHP!',
	),
	'step' => 'الخطوة %d',
	'steps' => 'الخطوات',
	'this_is_the_end' => 'هذه هي النهاية',
	'title' => 'التثبيت · FreshRSS',
);

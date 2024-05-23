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
	'auth' => array(
		'allow_anonymous' => ' اجازه خواندن ناشناس مقالات کاربر پیش‌فرض (%s)',
		'allow_anonymous_refresh' => ' اجازه بازخوانی ناشناس مقالات را بدهید',
		'api_enabled' => ' اجازه دسترسی به <abbr>API</abbr> <small>(الزامی برای برنامه های تلفن همراه)</small>',
		'form' => ' فرم وب (سنتی',
		'http' => ' HTTP (برای کاربران پیشرفته با HTTPS)',
		'none' => ' هیچ (خطرناک)',
		'title' => ' احراز هویت',
		'token' => 'Master authentication token',	// TODO
		'token_help' => 'Allows access to all RSS outputs of the user as well as refreshing feeds without authentication:',	// TODO
		'type' => ' روش احراز هویت',
		'unsafe_autologin' => ' اجازه ورود خودکار ناامن را با استفاده از قالب:',
	),
	'check_install' => array(
		'cache' => array(
			'nok' => ' مجوزهای دایرکتوری <em>./data/cache</em> را بررسی کنید. سرور HTTP باید مجوز نوشتن داشته باشد.',
			'ok' => ' مجوزهای دایرکتوری کش خوب است.',
		),
		'categories' => array(
			'nok' => ' جدول دسته بندی به درستی پیکربندی نشده است.',
			'ok' => ' جدول رده درست است.',
		),
		'connection' => array(
			'nok' => ' اتصال به پایگاه داده نمی تواند برقرار شود.',
			'ok' => ' اتصال به پایگاه داده مشکلی ندارد.',
		),
		'ctype' => array(
			'nok' => ' نمی توان یک کتابخانه مورد نیاز برای بررسی نوع کاراکتر (php-ctype) پیدا کرد.',
			'ok' => ' شما کتابخانه مورد نیاز برای بررسی نوع کاراکتر (ctype) دارید.',
		),
		'curl' => array(
			'nok' => ' نمی توان کتابخانه cURL (بسته php-curl) را پیدا کرد.',
			'ok' => ' شما کتابخانه cURL را دارید.',
		),
		'data' => array(
			'nok' => ' مجوزهای دایرکتوری <em>./data</em> را بررسی کنید. سرور HTTP باید مجوز نوشتن داشته باشد.',
			'ok' => ' مجوزهای دایرکتوری داده ها خوب است.',
		),
		'database' => ' نصب پایگاه داده',
		'dom' => array(
			'nok' => ' نمی توان یک کتابخانه مورد نیاز برای مرور DOM (بسته php-xml) پیدا کرد.',
			'ok' => ' شما کتابخانه مورد نیاز برای مرور DOM را دارید.',
		),
		'entries' => array(
			'nok' => ' جدول ورودی به درستی پیکربندی نشده است.',
			'ok' => ' جدول ورودی اشکالی ندارد.',
		),
		'favicons' => array(
			'nok' => ' مجوزهای دایرکتوری <em>./data/favicons</em> را بررسی کنید. سرور HTTP باید مجوز نوشتن داشته باشد.',
			'ok' => ' مجوزهای موجود در فهرست فاویکون ها خوب است.',
		),
		'feeds' => array(
			'nok' => ' جدول خوراک به درستی پیکربندی نشده است.',
			'ok' => ' جدول خوراک درست است.',
		),
		'fileinfo' => array(
			'nok' => ' نمی توان کتابخانه اطلاعات فایل PHP (بسته اطلاعات فایل) را پیدا کرد.',
			'ok' => ' شما کتابخانه fileinfo را دارید.',
		),
		'files' => ' نصب فایل',
		'json' => array(
			'nok' => ' JSON (بسته php-json) را نمی توان پیدا کرد.',
			'ok' => ' شما پسوند JSON دارید.',
		),
		'mbstring' => array(
			'nok' => ' نمی توان کتابخانه mbstring توصیه شده برای یونیکد را پیدا کرد.',
			'ok' => ' شما کتابخانه mbstring توصیه شده برای یونیکد را دارید.',
		),
		'pcre' => array(
			'nok' => ' نمی توان یک کتابخانه مورد نیاز برای عبارات منظم (php-pcre) پیدا کرد.',
			'ok' => ' شما کتابخانه مورد نیاز برای عبارات منظم (PCRE) را دارید.',
		),
		'pdo' => array(
			'nok' => ' PDO یا یکی از درایورهای پشتیبانی شده (pdo_mysql',
			'ok' => ' شما دارای PDO و حداقل یکی از درایورهای پشتیبانی شده (pdo_mysql',
		),
		'php' => array(
			'_' => ' نصب پی اچ پی',
			'nok' => ' نسخه PHP شما %s است اما FreshRSS حداقل به نسخه %s نیاز دارد.',
			'ok' => ' نسخه PHP شما (%s) با FreshRSS سازگار است.',
		),
		'tables' => array(
			'nok' => ' یک یا چند جدول مفقود در پایگاه داده وجود دارد.',
			'ok' => ' جداول مناسب در پایگاه داده وجود دارد.',
		),
		'title' => ' بررسی نصب',
		'tokens' => array(
			'nok' => ' مجوزهای دایرکتوری <em>./data/tokens</em> را بررسی کنید. سرور HTTP باید مجوز نوشتن داشته باشد',
			'ok' => ' مجوزهای دایرکتوری توکن ها خوب است.',
		),
		'users' => array(
			'nok' => ' مجوزهای فهرست <em>./data/users</em> را بررسی کنید. سرور HTTP باید مجوز نوشتن داشته باشد',
			'ok' => ' مجوزهای دایرکتوری کاربران خوب است.',
		),
		'zip' => array(
			'nok' => ' نمی توان پسوند ZIP (بسته php-zip) را پیدا کرد.',
			'ok' => ' شما پسوند ZIP را دارید.',
		),
	),
	'extensions' => array(
		'author' => ' نویسنده',
		'community' => ' پسوندهای جامعه موجود',
		'description' => ' توضیحات',
		'disabled' => ' معلول',
		'empty_list' => ' هیچ برنامه افزودنی نصب شده ای وجود ندارد',
		'enabled' => ' فعال است',
		'latest' => ' نصب شده است',
		'name' => ' نام',
		'no_configure_view' => ' این برنامه افزودنی قابل پیکربندی نیست.',
		'system' => array(
			'_' => ' پسوندهای سیستم',
			'no_rights' => ' پسوند سیستم (شما مجوزهای لازم را ندارید)',
		),
		'title' => ' برنامه های افزودنی',
		'update' => ' به روز رسانی موجود است',
		'user' => ' پسوندهای کاربر',
		'version' => ' نسخه',
	),
	'stats' => array(
		'_' => 'آمار',
		'all_feeds' => ' همه فیدها',
		'category' => ' دسته',
		'entry_count' => ' تعداد ورودی',
		'entry_per_category' => ' ورودی در هر دسته',
		'entry_per_day' => ' ورودی در روز (30 روز گذشته)',
		'entry_per_day_of_week' => ' در هر روز هفته (میانگین: %2f پیام)',
		'entry_per_hour' => ' در ساعت (میانگین: %2f پیام)',
		'entry_per_month' => ' در هر ماه (میانگین: %2f پیام)',
		'entry_repartition' => ' پارتیشن مجدد ورودی ها',
		'feed' => ' خوراک',
		'feed_per_category' => ' فید در هر دسته',
		'idle' => ' تغذیه بیکار',
		'main' => ' آمار اصلی',
		'main_stream' => ' جریان اصلی',
		'no_idle' => ' هیچ فید بیکار وجود ندارد!',
		'number_entries' => ' %d مقاله',
		'percent_of_total' => ' درصد از کل',
		'repartition' => ' تقسیم مجدد مقالات',
		'status_favorites' => ' موارد دلخواه',
		'status_read' => ' بخوانید',
		'status_total' => ' مجموع',
		'status_unread' => ' خوانده نشده',
		'title' => 'آمار',
		'top_feed' => ' ده فید برتر',
	),
	'system' => array(
		'_' => ' پیکربندی سیستم',
		'auto-update-url' => ' به روز رسانی خودکار URL سرور',
		'base-url' => array(
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		),
		'cookie-duration' => array(
			'help' => ' در ثانیه',
			'number' => ' مدت زمان ورود به سیستم',
		),
		'force_email_validation' => ' اعتبارسنجی آدرس ایمیل اجباری',
		'instance-name' => ' نام نمونه',
		'max-categories' => ' حداکثر تعداد دسته ها برای هر کاربر',
		'max-feeds' => ' حداکثر تعداد فید برای هر کاربر',
		'registration' => array(
			'number' => ' حداکثر تعداد حساب ها',
			'select' => array(
				'label' => ' فرم ثبت نام',
				'option' => array(
					'noform' => ' معلولین: بدون فرم ثبت نام',
					'nolimit' => ' فعال: بدون محدودیت حساب',
					'setaccountsnumber' => ' حداکثر تنظیم کنید. تعداد حساب ها',
				),
			),
			'status' => array(
				'disabled' => ' فرم غیرفعال است',
				'enabled' => ' فرم فعال است',
			),
			'title' => 'فرم ثبت نام کاربر',
		),
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => array(
			'disabled' => ' داده نشده است',
			'enabled' => ' <a href="./?a=tos">فعال است</a>',
			'help' => ' نحوه <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">فعال کردن شرایط خدمات </a>',
		),
		'websub' => array(
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		),
	),
	'update' => array(
		'_' => ' FreshRSS را به روز کنید',
		'apply' => ' شروع به روز رسانی',
		'changelog' => ' تغییرات',
		'check' => ' به روز رسانی های جدید را بررسی کنید',
		'copiedFromURL' => 'update.php از %s به ./data کپی شد',
		'current_version' => ' نسخه نصب شده فعلی',
		'last' => ' آخرین بررسی',
		'loading' => ' به روز رسانی…',
		'none' => ' به روز رسانی در دسترس نیست',
		'releaseChannel' => array(
			'_' => ' کانال انتشار',
			'edge' => ' انتشار نورد ("لبه")',
			'latest' => ' انتشار پایدار ("آخرین")',
		),
		'title' => ' FreshRSS را به روز کنید',
		'viaGit' => ' به روز رسانی از طریق git و GitHub.com شروع شد',
	),
	'user' => array(
		'admin' => ' مدیر',
		'article_count' => ' مقالات',
		'back_to_manage' => ' ← بازگشت به لیست کاربران',
		'create' => ' ایجاد کاربر جدید',
		'database_size' => ' اندازه پایگاه داده',
		'email' => ' آدرس ایمیل',
		'enabled' => ' فعال است',
		'feed_count' => ' فیدها',
		'is_admin' => ' مدیر است',
		'language' => ' زبان',
		'last_user_activity' => ' آخرین فعالیت کاربر',
		'list' => ' لیست کاربران',
		'number' => ' %d حساب ایجاد شده است',
		'numbers' => ' %d حساب ایجاد شده است',
		'password_form' => ' رمز عبور<br /><small>(برایروش ورود به فرم وب)</small>',
		'password_format' => ' حداقل 7 کاراکتر',
		'title' => ' مدیریت کاربران',
		'username' => ' نام کاربری',
	),
);

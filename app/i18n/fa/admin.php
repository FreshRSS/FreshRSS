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
	'auth' => array(
		'allow_anonymous' => ' اجازه خواندن ناشناس مقالات کاربر پیش‌فرض (%s)',
		'allow_anonymous_refresh' => ' اجازه بازخوانی ناشناس مقالات را بدهید',
		'api_enabled' => ' اجازه دسترسی به <abbr>API</abbr> <small>(الزامی برای برنامه های تلفن همراه and sharing user queries and sharing user queries)</small>',	// DIRTY
		'form' => ' فرم وب (سنتی',
		'http' => 'یک پروتکل ارتباطی است که برای انتقال داده‌ها ',
		'none' => ' هیچ (خطرناک)',
		'title' => ' احراز هویت',
		'token' => 'به نوعی دارایی دیجیتال اشاره دارد که از ویژگی حفظ ارزش و انتقال به دیگران برخوردار است. توکن ابزار دیجیتالی است که بر روی بلاک چین رمزگذاری می‌شود. می‌توان گفت که توکن همان ارزدیجیتال با ویژگی‌های منحصر به فرد است.',
		'token_help' => 'اجازه دسترسی به تمام خروجی های ار اس اس کاربر و همچنین به روزرسانی فید ها را بدون احراز هویت می دهد',
		'type' => ' روش احراز هویت',
	),
	'extensions' => array(
		'author' => ' نویسنده',
		'community' => ' پسوندهای جامعه موجود',
		'description' => ' توضیحات',
		'disabled' => ' معلول',
		'empty_list' => ' هیچ برنامه افزودنی نصب شده ای وجود ندارد',
		'empty_list_help' => 'لاگ‌ها را بررسی کنید تا دلیل خالی بودن لیست افزونه‌ها مشخص شود',
		'enabled' => ' فعال است',
		'is_compatible' => 'Is compatible',	// TODO
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
		'date_published' => 'Publication date',	// TODO
		'date_received' => 'Received date',	// TODO
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
		'nb_unreads' => 'Number of unread articles',	// TODO
		'no_idle' => ' هیچ فید بیکار وجود ندارد!',
		'number_entries' => ' %d مقاله',
		'overview' => 'بررسی اجمالی',
		'percent_of_total' => ' درصد از کل',
		'repartition' => 'تقسیم‌بندی مجدد',
		'status_favorites' => ' موارد دلخواه',
		'status_read' => ' بخوانید',
		'status_total' => ' مجموع',
		'status_unread' => ' خوانده نشده',
		'title' => 'آمار',
		'top_feed' => ' ده فید برتر',
		'unread_dates' => 'Dates with most unread articles',	// TODO
	),
	'system' => array(
		'_' => ' پیکربندی سیستم',
		'auto-update-url' => ' به روز رسانی خودکار URL سرور',
		'base-url' => array(
			'_' => 'آدرس پایه',
			'recommendation' => 'توصیه: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'Message if registrations are closed',	// TODO
		'cookie-duration' => array(
			'help' => ' در ثانیه',
			'number' => ' مدت زمان ورود به سیستم',
		),
		'default_closed_registration_message' => 'This server does not accept new registrations at the moment.',	// TODO
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
		'sensitive-parameter' => 'پارامتر حساس. Edit manually in <kbd>./data/config.php</kbd>',
		'tos' => array(
			'disabled' => ' داده نشده است',
			'enabled' => ' <a href="./?a=tos">فعال است</a>',
			'help' => ' نحوه <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">فعال کردن شرایط خدمات </a>',
		),
		'websub' => array(
			'help' => ' در مورد <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">وب سایت</a>',
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

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
		'api_enabled' => 'اجازه دسترسی به <abbr>API</abbr> <small>(برای برنامه‌های موبایل و اشتراک‌گذاری پرس‌وجوهای کاربر لازم است)</small>',
		'form' => 'فرم وب (سنتی، نیازمند JavaScript)',
		'http' => 'HTTP (پیشرفته: مدیریت‌شده توسط وب‌سرور، OIDC، SSO و...)',
		'none' => ' هیچ (خطرناک)',
		'title' => ' احراز هویت',
		'token' => 'توکن اصلی احراز هویت',
		'token_help' => 'اجازه دسترسی به همه خروجی‌های RSS کاربر و به‌روزرسانی فیدها را بدون احراز هویت می‌دهد:',
		'type' => ' روش احراز هویت',
	),
	'extensions' => array(
		'author' => ' نویسنده',
		'community' => ' افزونه‌های جامعه کاربری موجود',
		'description' => ' توضیحات',
		'disabled' => 'غیرفعال',
		'empty_list' => 'هیچ افزونه‌ای نصب نشده است',
		'empty_list_help' => 'لاگ‌ها را بررسی کنید تا دلیل خالی بودن لیست افزونه‌ها مشخص شود',
		'enabled' => ' فعال است',
		'is_compatible' => 'سازگار است',
		'latest' => 'نصب‌شده',
		'name' => ' نام',
		'no_configure_view' => ' این برنامه افزودنی قابل پیکربندی نیست.',
		'system' => array(
			'_' => 'افزونه‌های سیستم',
			'no_rights' => 'افزونه سیستم (شما مجوزهای لازم را ندارید)',
		),
		'title' => 'افزونه‌ها',
		'update' => 'به‌روزرسانی موجود است',
		'user' => 'افزونه‌های کاربر',
		'version' => ' نسخه',
	),
	'stats' => array(
		'_' => 'آمار',
		'all_feeds' => ' همه فیدها',
		'category' => ' دسته',
		'date_published' => 'تاریخ انتشار',
		'date_received' => 'تاریخ دریافت',
		'entry_count' => ' تعداد ورودی',
		'entry_per_category' => ' ورودی در هر دسته',
		'entry_per_day' => ' ورودی در روز (30 روز گذشته)',
		'entry_per_day_of_week' => 'در هر روز هفته (میانگین: %.2f پیام)',
		'entry_per_hour' => 'در هر ساعت (میانگین: %.2f پیام)',
		'entry_per_month' => 'در هر ماه (میانگین: %.2f پیام)',
		'entry_repartition' => 'توزیع مقاله‌ها',
		'feed' => ' خوراک',
		'feed_per_category' => ' فید در هر دسته',
		'idle' => 'فیدهای غیرفعال',
		'main' => ' آمار اصلی',
		'main_stream' => ' جریان اصلی',
		'nb_unreads' => 'تعداد مقاله‌های خوانده‌نشده',
		'no_idle' => 'هیچ فید غیرفعالی وجود ندارد!',
		'number_entries' => ' %d مقاله',
		'overview' => 'بررسی اجمالی',
		'percent_of_total' => 'درصد از کل',
		'repartition' => 'توزیع مقاله‌ها: %s',
		'status_favorites' => ' موارد دلخواه',
		'status_read' => 'خوانده‌شده',
		'status_total' => ' مجموع',
		'status_unread' => 'خوانده‌نشده',
		'title' => 'آمار',
		'top_feed' => ' ده فید برتر',
		'unread_dates' => 'تاریخ‌هایی با بیشترین مقاله خوانده‌نشده',
	),
	'system' => array(
		'_' => ' پیکربندی سیستم',
		'auto-update-url' => 'نشانی سرور به‌روزرسانی خودکار',
		'base-url' => array(
			'_' => 'آدرس پایه',
			'recommendation' => 'توصیه: <kbd>%s</kbd>',
		),
		'closed_registration_message' => 'پیام هنگام بسته بودن ثبت‌نام',
		'cookie-duration' => array(
			'help' => ' در ثانیه',
			'number' => ' مدت زمان ورود به سیستم',
		),
		'default_closed_registration_message' => 'این سرور در حال حاضر ثبت‌نام جدید نمی‌پذیرد.',
		'force_email_validation' => ' اعتبارسنجی آدرس ایمیل اجباری',
		'instance-name' => ' نام نمونه',
		'internal-host-allowlist' => array(
			'_' => 'Internal host allowlist',	// TODO
			'help' => 'One entry per line:<ul><li>A <code>host:port</code>. For instance <code>127.0.0.1:8080</code> or <code>rss-bridge:80</code></li><li>A CIDR notation. For instance <code>0.0.0.0/0</code> to allow any IPv4, <code>::/0</code> to allow any IPv6</li><li>A <code>*</code> to allow any host (unsafe)</li></ul>',	// TODO
		),
		'max-categories' => ' حداکثر تعداد دسته ها برای هر کاربر',
		'max-feeds' => ' حداکثر تعداد فید برای هر کاربر',
		'override-by-env-var' => 'This setting is set by the environment variable <kbd>%s</kbd>.',	// TODO
		'registration' => array(
			'number' => ' حداکثر تعداد حساب ها',
			'select' => array(
				'label' => ' فرم ثبت نام',
				'option' => array(
					'noform' => 'غیرفعال: بدون فرم ثبت‌نام',
					'nolimit' => 'فعال: بدون محدودیت تعداد حساب‌ها',
					'setaccountsnumber' => 'فعال: با حداکثر تعداد حساب‌ها',
				),
			),
			'status' => array(
				'disabled' => ' فرم غیرفعال است',
				'enabled' => ' فرم فعال است',
			),
			'title' => 'فرم ثبت نام کاربر',
		),
		'sensitive-parameter' => 'پارامتر حساس. به صورت دستی در <kbd>./data/config.php</kbd> ویرایش کنید',
		'tos' => array(
			'disabled' => ' داده نشده است',
			'enabled' => ' <a href="./?a=tos">فعال است</a>',
			'help' => ' نحوه <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">فعال کردن شرایط خدمات </a>',
		),
		'websub' => array(
			'help' => 'درباره <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',
		),
	),
	'update' => array(
		'_' => 'به‌روزرسانی FreshRSS',
		'apply' => 'شروع به‌روزرسانی',
		'changelog' => ' تغییرات',
		'check' => 'بررسی به‌روزرسانی‌های جدید',
		'copiedFromURL' => 'update.php از %s به ./data کپی شد',
		'current_version' => ' نسخه نصب شده فعلی',
		'last' => ' آخرین بررسی',
		'loading' => 'در حال به‌روزرسانی…',
		'none' => 'به‌روزرسانی در دسترس نیست',
		'releaseChannel' => array(
			'_' => ' کانال انتشار',
			'edge' => 'انتشار پیوسته («edge»)',
			'latest' => 'انتشار پایدار («latest»)',
		),
		'title' => 'به‌روزرسانی FreshRSS',
		'viaGit' => 'به‌روزرسانی از طریق git و GitHub.com شروع شد',
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
		'password_form' => 'رمز عبور<br /><small>(برای روش ورود با فرم وب)</small>',
		'password_format' => ' حداقل 7 کاراکتر',
		'title' => ' مدیریت کاربران',
		'username' => ' نام کاربری',
	),
);

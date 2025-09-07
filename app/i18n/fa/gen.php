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
		'actualize' => ' فیدها را به روز کنید',
		'add' => ' اضافه کنید',
		'back_to_rss_feeds' => '← به فیدهای RSS خود برگردید',
		'cancel' => ' لغو',
		'close' => 'بستن',
		'create' => ' ایجاد کنید',
		'delete_all_feeds' => 'حذف تمام فیدها',
		'delete_errored_feeds' => 'فیدهای دارای خطا را حذف کن',
		'delete_muted_feeds' => ' فیدهای خاموش را حذف کنید',
		'demote' => ' تنزل دادن',
		'disable' => ' غیر فعال کردن',
		'download' => 'دانلود',
		'empty' => ' خالی',
		'enable' => ' فعال کنید',
		'export' => ' صادرات',
		'filter' => ' فیلتر',
		'import' => ' واردات',
		'load_default_shortcuts' => ' میانبرهای پیش فرض را بارگیری کنید',
		'manage' => ' مدیریت',
		'mark_read' => ' علامت گذاری به عنوان خوانده شده',
		'menu' => array(
			'open' => 'باز کردن منو',
		),
		'nav_buttons' => array(
			'next' => 'مقاله بعدی',
			'prev' => 'مقاله قبلی',
			'up' => 'برو بالا',
		),
		'open_url' => ' URL را باز کنید',
		'promote' => ' ترویج',
		'purge' => ' پاکسازی',
		'refresh_opml' => ' OPML را بازخوانی کنید',
		'remove' => ' حذف کنید',
		'rename' => ' تغییر نام',
		'see_website' => ' به وب سایت مراجعه کنید',
		'submit' => ' ارسال کنید',
		'truncate' => ' تمام مقالات را حذف کنید',
		'update' => ' به روز رسانی',
	),
	'auth' => array(
		'accept_tos' => ' من <a href="%s">شرایط خدمات</a> را می پذیرم.',
		'email' => ' آدرس ایمیل',
		'keep_logged_in' => ' مرا به سیستم <small>(%s روز)</small> نگه دارید',
		'login' => ' ورود',
		'logout' => ' خروج',
		'password' => array(
			'_' => ' رمز عبور',
			'format' => '<small>حداقل 7 نویسه</small>',
		),
		'reauth' => array(
			'header' => 'احراز هویت مجدد لازم است',
			'tip' => 'دیگر از شما خواسته نمی‌شود که دوباره وارد شوید <u>%d دقیقه</u>',
			'title' => 'ورود مجدد',
		),
		'registration' => array(
			'_' => ' حساب جدید',
			'ask' => ' یک حساب کاربری ایجاد کنید؟',
			'title' => ' ایجاد حساب',
		),
		'username' => array(
			'_' => ' نام کاربری',
			'format' => '<small>حداکثر 16 نویسه الفبای عددی</small>',
		),
	),
	'date' => array(
		'Apr' => 'آ/و/ر/ی/ل//',
		'Aug' => 'آ/گ/و/س/ت//',
		'Dec' => 'د/س/ا/م/ب/ر//',
		'Feb' => 'ف/و/ر/ی/ه//',
		'Jan' => 'ژ/ا/ن/و/ی/ه//',
		'Jul' => 'ژ/و/ئ/ی/ه//',
		'Jun' => 'ژ/و/ئ/ن//',
		'Mar' => 'م/ا/ر/س//',
		'May' => 'م/ی//',
		'Nov' => 'ن/و/ا/م/ب/ر//',
		'Oct' => 'ا/ک/ت/ب/ر//',
		'Sep' => 'س/پ/ت/ا/م/ب/ر//',
		'apr' => ' آوریل',
		'april' => ' آوریل',
		'aug' => ' آگوست',
		'august' => ' آگوست',
		'before_yesterday' => ' قبل از دیروز',
		'dec' => ' دسامبر',
		'december' => ' دسامبر',
		'feb' => ' فوریه',
		'february' => ' فوریه',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\a\\t H\\:i',	// IGNORE
		'fri' => ' جمعه',
		'jan' => ' ژانویه',
		'january' => ' ژانویه',
		'jul' => ' ژوئیه',
		'july' => ' ژوئیه',
		'jun' => ' ژوئن',
		'june' => ' ژوئن',
		'last_2_year' => ' دو سال گذشته',
		'last_3_month' => ' سه ماه گذشته',
		'last_3_year' => ' سه سال گذشته',
		'last_5_year' => ' پنج سال گذشته',
		'last_6_month' => ' شش ماه گذشته',
		'last_month' => ' ماه گذشته',
		'last_week' => ' هفته گذشته',
		'last_year' => ' سال گذشته',
		'mar' => ' مارس.',
		'march' => ' مارس',
		'may' => ' مه',
		'may_' => ' مه',
		'mon' => ' دوشنبه',
		'month' => ' ماه',
		'nov' => ' نوامبر',
		'november' => ' نوامبر',
		'oct' => ' اکتبر',
		'october' => ' اکتبر',
		'sat' => ' شنبه',
		'sep' => ' سپتامبر.',
		'september' => ' سپتامبر',
		'sun' => ' یکشنبه',
		'thu' => ' پنجشنبه',
		'today' => ' امروز',
		'tue' => ' سه شنبه',
		'wed' => ' چهارشنبه',
		'yesterday' => ' دیروز',
	),
	'dir' => 'rtl',
	'flag' => '🇮🇷',
	'freshrss' => array(
		'_' => ' FreshRSS',
		'about' => 'درباره FreshRSS',
	),
	'js' => array(
		'category_empty' => ' دسته خالی',
		'confirm_action' => ' آیا مطمئن هستید که می خواهید این عمل را انجام دهید؟ نمی توان آن را لغو کرد!',
		'confirm_action_feed_cat' => ' آیا مطمئن هستید که می خواهید این عمل را انجام دهید؟ موارد دلخواه و درخواست های کاربر مرتبط را از دست خواهید داد. نمی توان آن را لغو کرد!',
		'confirm_exit_slider' => 'Are you sure you want to discard unsaved settings?',	// TODO
		'feedback' => array(
			'body_new_articles' => ' %%d مقاله جدید برای خواندن در FreshRSS وجود دارد.',
			'body_unread_articles' => ' (خوانده نشده: %%d)',
			'request_failed' => ' یک درخواست شکست خورده است',
			'title_new_articles' => ' FreshRSS: مقالات جدید!',
		),
		'labels_empty' => 'بدون برچسب',
		'new_article' => 'مقالات جدیدی موجود است',
		'should_be_activated' => ' جاوا اسکریپت باید فعال باشد',
		'unsafe_csp_header' => 'The CSP header in use is unsafe and FreshRSS may be vulnerable to XSS attacks. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">See documentation</a>',	// TODO
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-us' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-br' => 'Português (Brasil)',	// IGNORE
		'pt-pt' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'zh-cn' => '简体中文',	// IGNORE
		'zh-tw' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => ' در مورد',
		'account' => ' حساب',
		'admin' => ' اداره',
		'archiving' => ' آرشیو',
		'authentication' => ' احراز هویت',
		'check_install' => ' بررسی نصب',
		'configuration' => ' پیکربندی',
		'display' => 'نمایش',
		'extensions' => ' برنامه های افزودنی',
		'logs' => ' سیاهههای مربوط',
		'privacy' => 'حریم خصوصی',
		'queries' => ' پرس و جوهای کاربر',
		'reading' => ' خواندن',
		'search' => ' کلمات یا #برچسب ها را جستجو کنید',
		'search_help' => ' به مستندات <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">پارامترهای جستجوی پیشرفته</a مراجعه کنید >',
		'sharing' => ' اشتراک گذاری',
		'shortcuts' => ' میانبرها',
		'stats' => 'آمار',
		'system' => ' پیکربندی سیستم',
		'update' => ' به روز رسانی',
		'user_management' => ' مدیریت کاربران',
		'user_profile' => ' نمایه',
	),
	'period' => array(
		'days' => ' روز',
		'hours' => ' ساعت',
		'months' => ' ماه',
		'weeks' => ' هفته',
		'years' => ' سال',
	),
	'share' => array(
		'Known' => ' سایت های مبتنی بر شناخته شده',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => ' archive.org',
		'archivePH' => ' archive.ph',
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => ' بافر',
		'clipboard' => ' کلیپ بورد',
		'diaspora' => ' دیاسپورا*',
		'email' => ' ایمیل',
		'email-webmail-firefox-fix' => ' ایمیل (وب میل - تعمیر برای فایرفاکس)',
		'facebook' => ' فیس بوک',
		'gnusocial' => ' گنو اجتماعی',
		'jdh' => 'ژورنال دو هکر',
		'lemmy' => ' لمی',
		'linkding' => ' پیوند دادن',
		'linkedin' => ' لینکدین',
		'mastodon' => ' ماستودون',
		'movim' => ' Movim',
		'omnivore' => ' همه چیزخوار',
		'pinboard' => ' پینبرد',
		'pinterest' => ' پینترست',
		'pocket' => ' جیبی',
		'print' => ' چاپ',
		'raindrop' => ' Raindrop.io',
		'reddit' => ' Reddit',
		'shaarli' => ' شعرلی',
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => ' توییتر',
		'wallabag' => ' wallabag نسخه 1',
		'wallabagv2' => ' wallabag نسخه 2',
		'web-sharing-api' => ' اشتراک گذاری سیستم',
		'whatsapp' => ' واتساپ',
		'xing' => ' زینگ',
	),
	'short' => array(
		'attention' => ' هشدار!',
		'blank_to_disable' => ' برای غیرفعال کردن',
		'by_author' => ' توسط:',
		'by_default' => ' به طور پیش فرض',
		'damn' => ' انفجار!',
		'default_category' => ' دسته بندی نشده',
		'no' => ' شماره',
		'not_applicable' => ' در دسترس نیست',
		'ok' => ' باشه!',
		'or' => ' یا',
		'yes' => ' بله',
	),
	'stream' => array(
		'load_more' => ' بارگذاری مقالات بیشتر',
		'mark_all_read' => ' همه را به عنوان خوانده شده علامت گذاری کنید',
		'nothing_to_load' => ' مقاله دیگری وجود ندارد',
	),
);

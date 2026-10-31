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
		'actualize' => 'تحديث الخلاصات',
		'add' => 'إضافة',
		'back_to_rss_feeds' => '← العودة إلى خلاصات RSS',
		'cancel' => 'إلغاء',
		'close' => 'إغلاق',
		'create' => 'إنشاء',
		'delete_all_feeds' => 'حذف كل الخلاصات',
		'delete_errored_feeds' => 'حذف الخلاصات التي بها أخطاء',
		'delete_muted_feeds' => 'حذف الخلاصات المكتومة',
		'demote' => 'خفض الرتبة',
		'disable' => 'تعطيل',
		'download' => 'تنزيل',
		'empty' => 'إفراغ',
		'enable' => 'تفعيل',
		'export' => 'تصدير',
		'filter' => 'تصفية',
		'import' => 'استيراد',
		'load_default_shortcuts' => 'تحميل الاختصارات الافتراضية',
		'manage' => 'إدارة',
		'mark_read' => 'وضع علامة كمقروء',
		'menu' => array(
			'open' => 'فتح القائمة',
		),
		'nav_buttons' => array(
			'next' => 'المقال التالي',
			'prev' => 'المقال السابق',
			'up' => 'الانتقال إلى الأعلى',
		),
		'open_url' => 'فتح URL',
		'promote' => 'ترقية',
		'purge' => 'تطهير',
		'refresh_opml' => 'تحديث OPML',
		'remove' => 'إزالة',
		'rename' => 'إعادة تسمية',
		'see_website' => 'زيارة الموقع',
		'submit' => 'إرسال',
		'truncate' => 'حذف كل المقالات',
		'update' => 'تحديث',
	),
	'auth' => array(
		'accept_tos' => 'أوافق على <a href="%s">شروط الخدمة</a>.',
		'email' => 'عنوان البريد الإلكتروني',
		'keep_logged_in' => 'إبقائي مسجل الدخول <small>(%s أيام)</small>',
		'login' => 'تسجيل الدخول',
		'logout' => 'تسجيل الخروج',
		'password' => array(
			'_' => 'كلمة المرور',
			'format' => '<small>7 أحرف على الأقل</small>',
		),
		'reauth' => array(
			'header' => 'يلزم إعادة المصادقة',
			'tip' => 'لن يُطلب منك تسجيل الدخول مرة أخرى لمدة <u>%d دقيقة</u>',
			'title' => 'إعادة المصادقة',
		),
		'registration' => array(
			'_' => 'حساب جديد',
			'ask' => 'إنشاء حساب؟',
			'title' => 'إنشاء الحساب',
		),
		'username' => array(
			'_' => 'اسم المستخدم',
			'format' => '<small>من 1 إلى 39 حرفًا: حروف وأرقام و <code>. _ @ -</code></small>',
		),
	),
	'date' => array(
		'Apr' => 'أبريل',
		'Aug' => 'أغسطس',
		'Dec' => 'ديسمبر',
		'Feb' => 'فبراير',
		'Jan' => 'يناير',
		'Jul' => 'يوليو',
		'Jun' => 'يونيو',
		'Mar' => 'مارس',
		'May' => 'مايو',
		'Nov' => 'نوفمبر',
		'Oct' => 'أكتوبر',
		'Sep' => 'سبتمبر',
		'apr' => 'أبريل',
		'april' => 'أبريل',
		'aug' => 'أغسطس',
		'august' => 'أغسطس',
		'before_yesterday' => 'أول أمس',
		'dec' => 'ديسمبر',
		'december' => 'ديسمبر',
		'feb' => 'فبراير',
		'february' => 'فبراير',
		'format_date' => 'j %s Y',	// IGNORE
		'format_date_hour' => 'j %s Y \\a\\t H\\:i',	// IGNORE
		'fri' => 'الجمعة',
		'jan' => 'يناير',
		'january' => 'يناير',
		'jul' => 'يوليو',
		'july' => 'يوليو',
		'jun' => 'يونيو',
		'june' => 'يونيو',
		'last_2_year' => 'آخر سنتين',
		'last_3_month' => 'آخر ثلاثة أشهر',
		'last_3_year' => 'آخر ثلاث سنوات',
		'last_5_year' => 'آخر خمس سنوات',
		'last_6_month' => 'آخر ستة أشهر',
		'last_month' => 'الشهر الماضي',
		'last_week' => 'الأسبوع الماضي',
		'last_year' => 'السنة الماضية',
		'mar' => 'مارس',
		'march' => 'مارس',
		'may' => 'مايو',
		'may_' => 'مايو',
		'mon' => 'الاثنين',
		'month' => 'أشهر',
		'nov' => 'نوفمبر',
		'november' => 'نوفمبر',
		'oct' => 'أكتوبر',
		'october' => 'أكتوبر',
		'sat' => 'السبت',
		'sep' => 'سبتمبر',
		'september' => 'سبتمبر',
		'sun' => 'الأحد',
		'thu' => 'الخميس',
		'today' => 'اليوم',
		'tue' => 'الثلاثاء',
		'wed' => 'الأربعاء',
		'yesterday' => 'أمس',
	),
	'dir' => 'rtl',
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'حول FreshRSS',
	),
	'interval' => array(
		'day' => array(
			0 => 'قبل %d يوم',
			1 => 'قبل %d يوم',
			2 => 'قبل %d يومين',
			3 => 'قبل %d أيام',
			4 => 'قبل %d يومًا',
			5 => 'قبل %d يوم',
		),
		'hour' => array(
			0 => 'قبل %d ساعة',
			1 => 'قبل %d ساعة',
			2 => 'قبل %d ساعتين',
			3 => 'قبل %d ساعات',
			4 => 'قبل %d ساعةً',
			5 => 'قبل %d ساعة',
		),
		'justnow' => 'الآن',
		'minute' => array(
			0 => 'قبل %d دقيقة',
			1 => 'قبل %d دقيقة',
			2 => 'قبل %d دقيقتين',
			3 => 'قبل %d دقائق',
			4 => 'قبل %d دقيقةً',
			5 => 'قبل %d دقيقة',
		),
		'month' => array(
			0 => 'قبل %d شهر',
			1 => 'قبل %d شهر',
			2 => 'قبل %d شهرين',
			3 => 'قبل %d أشهر',
			4 => 'قبل %d شهرًا',
			5 => 'قبل %d شهر',
		),
		'second' => array(
			0 => 'قبل %d ثانية',
			1 => 'قبل %d ثانية',
			2 => 'قبل %d ثانيتين',
			3 => 'قبل %d ثوانٍ',
			4 => 'قبل %d ثانيةً',
			5 => 'قبل %d ثانية',
		),
		'year' => array(
			0 => 'قبل %d سنة',
			1 => 'قبل %d سنة',
			2 => 'قبل %d سنتين',
			3 => 'قبل %d سنوات',
			4 => 'قبل %d سنةً',
			5 => 'قبل %d سنة',
		),
	),
	'js' => array(
		'category_empty' => 'تصنيف فارغ',
		'confirm_action' => 'هل أنت متأكد أنك تريد تنفيذ هذا الإجراء؟ لا يمكن التراجع عنه!',
		'confirm_action_feed_cat' => 'هل أنت متأكد أنك تريد تنفيذ هذا الإجراء؟ ستفقد المفضلات واستعلامات المستخدم ذات الصلة. لا يمكن التراجع عنه!',
		'confirm_exit_slider' => 'هل أنت متأكد أنك تريد تجاهل الإعدادات غير المحفوظة؟',
		'feedback' => array(
			'body_new_articles' => array(
				0 => 'يوجد %d مقال جديد للقراءة على FreshRSS.',
				1 => 'يوجد %d مقال جديد للقراءة على FreshRSS.',
				2 => 'يوجد %d مقالان جديدان للقراءة على FreshRSS.',
				3 => 'يوجد %d مقالات جديدة للقراءة على FreshRSS.',
				4 => 'يوجد %d مقالًا جديدًا للقراءة على FreshRSS.',
				5 => 'يوجد %d مقال جديد للقراءة على FreshRSS.',
			),
			'body_unread_articles' => array(
				0 => '(غير مقروء: %d)',
				1 => '(غير مقروء: %d)',
				2 => '(غير مقروء: %d)',
				3 => '(غير مقروء: %d)',
				4 => '(غير مقروء: %d)',
				5 => '(غير مقروء: %d)',
			),
			'request_failed' => 'فشل أحد الطلبات، وقد يكون ذلك بسبب مشكلات في الاتصال بالإنترنت.',
			'title_new_articles' => 'FreshRSS: مقالات جديدة!',
		),
		'labels_empty' => 'لا توجد تسميات',
		'new_article' => 'توجد مقالات جديدة متاحة، انقر لتحديث الصفحة.',
		'should_be_activated' => 'يجب تفعيل JavaScript',
		'unsafe_csp_header' => 'ترويسة CSP المستخدمة غير آمنة وقد يكون FreshRSS عرضة لهجمات XSS. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">اطلع على الوثائق</a>',
	),
	'lang' => array(
		'ar' => 'العربية',	// IGNORE
		'az' => 'Azərbaycanca',	// IGNORE
		'be' => 'Беларуская',	// IGNORE
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
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
		'lt' => 'Lietuvių',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'حول',
		'account' => 'الحساب',
		'admin' => 'الإدارة',
		'advanced_search' => 'البحث المتقدم',
		'archiving' => 'الأرشفة',
		'authentication' => 'المصادقة',
		'check_install' => 'فحص التثبيت',
		'configuration' => 'الإعدادات',
		'display' => 'العرض',
		'extensions' => 'الإضافات',
		'logs' => 'السجلات',
		'privacy' => 'الخصوصية',
		'queries' => 'استعلامات المستخدم',
		'reading' => 'القراءة',
		'search' => 'ابحث عن كلمات أو #وسوم',
		'search_help' => 'اطلع على الوثائق لمعرفة معلمات <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">البحث المتقدم</a>',
		'sharing' => 'المشاركة',
		'shortcuts' => 'الاختصارات',
		'stats' => 'الإحصاءات',
		'system' => 'تهيئة النظام',
		'update' => 'التحديث',
		'user_management' => 'إدارة المستخدمين',
		'user_profile' => 'الملف الشخصي',
	),
	'period' => array(
		'days' => 'أيام',
		'hours' => 'ساعات',
		'months' => 'أشهر',
		'weeks' => 'أسابيع',
		'years' => 'سنوات',
	),
	'readme' => array(
		'contribute' => 'المساهمة',
		'language' => 'اللغة',
		'translated' => 'التقدم',
	),
	'search' => array(
		'advanced_search_help' => 'يساعدك هذا النموذج في إنشاء استعلامات البحث، لكن الاستعلامات اليدوية أكثر قوة.',
		'authors' => 'المؤلفون',
		'categories' => 'التصنيفات',
		'content' => 'المحتوى',
		'date_from' => 'من',
		'date_modified' => 'تاريخ تعديل الخادم',
		'date_past' => 'في الماضي',
		'date_published' => 'تاريخ النشر',
		'date_range' => 'النطاق الزمني',
		'date_received' => 'تاريخ الاستلام',
		'date_to' => 'إلى',
		'date_user' => 'تاريخ تعديل المستخدم',
		'feeds' => 'الخلاصات',
		'free_text' => 'نص حر',
		'free_text_help' => 'البحث في العنوان والمحتوى معًا',
		'full_documentation' => 'عرض <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">وثائق البحث الكاملة</a>',
		'labels' => 'تسمياتي',
		'multiple_help' => 'حدد واحدًا أو أكثر (اضغط باستمرار على <kbd>Ctrl</kbd> أو <kbd>Cmd</kbd>)',
		'sources' => 'المصادر',
		'tags' => 'وسوم المقالات',
		'text' => 'البحث النصي',
		'text_help' => 'تُجمع الأسطر المتعددة باستخدام <i>أو</i> المنطقية. يدعم أيضًا <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">التعابير النمطية</a>.',
		'text_placeholder' => 'كلمة مفتاحية',
		'title' => 'العنوان',
		'url' => 'URL',	// IGNORE
		'user_queries' => 'استعلامات المستخدم',
	),
	'share' => array(
		'Known' => 'المواقع المعتمدة على Known',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'الحافظة',
		'diaspora' => 'Diaspora*',	// IGNORE
		'email' => 'البريد الإلكتروني',
		'email-webmail-firefox-fix' => 'البريد الإلكتروني (بريد الويب - إصلاح لـ Firefox)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkace' => 'LinkAce',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'nextcloud-bookmarks' => 'الإشارات المرجعية في Nextcloud',
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'print' => 'طباعة',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'مشاركة النظام',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'تحذير!',
		'blank_to_disable' => 'اتركه فارغًا للتعطيل',
		'by_author' => 'بواسطة:',
		'by_default' => 'افتراضيًا',
		'damn' => 'تبًا!',
		'default_category' => 'غير مصنف',
		'no' => 'لا',
		'not_applicable' => 'غير متاح',
		'ok' => 'حسنًا!',
		'or' => 'أو',
		'yes' => 'نعم',
	),
	'stream' => array(
		'load_more' => 'تحميل مزيد من المقالات',
		'mark_all_read' => 'وضع علامة على الكل كمقروء',
		'nothing_to_load' => 'لا توجد مقالات أخرى',
	),
);

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
	'about' => array(
		'_' => 'حول',
		'agpl3' => '<a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',	// IGNORE
		'bug_reports' => array(
			'environment_information' => array(
				'_' => 'معلومات النظام',
				'browser' => 'المتصفح',
				'database' => 'قاعدة البيانات',
				'server_software' => 'برنامج الخادم',
				'version_curl' => 'إصدار cURL',
				'version_frss' => 'إصدار FreshRSS',
				'version_php' => 'إصدار PHP',
			),
		),
		'bugs_reports' => 'تقارير الأخطاء',
		'documentation' => 'التوثيق',
		'freshrss_description' => 'FreshRSS هو مجمّع وقارئ خلاصات RSS قابل للاستضافة الذاتية. يتيح لك قراءة ومتابعة العديد من مواقع الأخبار بنظرة واحدة دون الحاجة إلى التنقل من موقع إلى آخر. FreshRSS خفيف وقابل للتخصيص وسهل الاستخدام.',
		'github' => '<a href="https://github.com/FreshRSS/FreshRSS/issues">على GitHub</a>',
		'license' => 'الترخيص',
		'project_website' => 'موقع المشروع',
		'title' => 'حول',
		'version' => 'الإصدار',
	),
	'feed' => array(
		'empty' => 'لا توجد مقالات لعرضها.',
		'published' => array(
			'_' => 'نُشر',
			'future' => 'نُشر في المستقبل',
			'today' => 'نُشر اليوم',
			'yesterday' => 'نُشر أمس',
		),
		'received' => array(
			'_' => 'تم الاستلام',
			'today' => 'تم الاستلام اليوم',
			'yesterday' => 'تم الاستلام أمس',
		),
		'rss_of' => 'خلاصة RSS الخاصة بـ %s',
		'title' => 'التدفق الرئيسي',
		'title_fav' => 'المفضلة',
		'title_global' => 'العرض الشامل',
		'userModified' => array(
			'_' => 'عدّله المستخدم',
			'today' => 'عدّله المستخدم اليوم',
			'yesterday' => 'عدّله المستخدم أمس',
		),
	),
	'log' => array(
		'_' => 'السجلات',
		'clear' => 'مسح السجلات',
		'empty' => 'ملف السجل فارغ',
		'title' => 'السجلات',
	),
	'menu' => array(
		'about' => 'حول FreshRSS',
		'before_one_day' => 'أقدم من يوم واحد',
		'before_one_week' => 'أقدم من أسبوع واحد',
		'bookmark_query' => 'حفظ الاستعلام الحالي في المفضلة',
		'favorites' => 'المفضلة (%s)',
		'global_view' => 'العرض الشامل',
		'important' => 'الخلاصات المهمة',
		'main_stream' => 'التدفق الرئيسي',
		'mark_all_read' => 'تعليم الكل كمقروء',
		'mark_cat_read' => 'تعليم التصنيف كمقروء',
		'mark_feed_read' => 'تعليم الخلاصة كمقروءة',
		'mark_selection_unread' => 'تعليم التحديد كغير مقروء',
		'mylabels' => 'تسمياتي',
		'non-starred' => 'إظهار غير المفضلة',
		'normal_view' => 'العرض العادي',
		'queries' => 'استعلامات المستخدم',
		'read' => 'إظهار المقروءة',
		'reader_view' => 'عرض القراءة',
		'rss_view' => 'خلاصة RSS',
		'search_short' => 'بحث',
		'sort' => array(
			'asc' => 'تصاعدي',
			'c' => array(
				'name_asc' => 'التصنيف، عناوين الخلاصات A→Z',
				'name_desc' => 'التصنيف، عناوين الخلاصات Z→A',
			),
			'date_asc' => 'تاريخ النشر 1→9',
			'date_desc' => 'تاريخ النشر 9→1',
			'desc' => 'تنازلي',
			'f' => array(
				'name_asc' => 'عنوان الخلاصة A→Z',
				'name_desc' => 'عنوان الخلاصة Z→A',
			),
			'id_asc' => 'المستلمة حديثًا أخيرًا',
			'id_desc' => 'المستلمة حديثًا أولًا',
			'length_asc' => 'طول المحتوى 1→9',
			'length_desc' => 'طول المحتوى 9→1',
			'link_asc' => 'الرابط A→Z',
			'link_desc' => 'الرابط Z→A',
			'primary' => array(
				'_' => 'معيار الفرز',
				'help' => 'يُنصح بالفرز حسب تاريخ <em>الاستلام</em> في معظم الحالات، من أجل الاتساق والأداء',
			),
			'rand' => 'ترتيب عشوائي',
			'secondary' => array(
				'_' => 'معيار الفرز الثانوي',
				'help' => 'ذو صلة فقط عندما يكون معيار الفرز الأساسي هو التصنيفات أو عناوين الخلاصات',
			),
			'title_asc' => 'العنوان A→Z',
			'title_desc' => 'العنوان Z→A',
			'user_modified_asc' => 'تعديل المستخدم 1→9',
			'user_modified_desc' => 'تعديل المستخدم 9→1',
		),
		'starred' => 'إظهار المفضلة',
		'stats' => 'الإحصائيات',
		'subscription' => 'إدارة الاشتراكات',
		'unread' => 'إظهار غير المقروءة',
	),
	'share' => 'مشاركة',
	'tag' => array(
		'related' => 'وسوم المقال',
	),
	'tos' => array(
		'title' => 'شروط الخدمة',
	),
);

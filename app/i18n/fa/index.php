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
		'_' => ' در مورد',
		'agpl3' => ' <a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPL 3</a>',
		'bug_reports' => array(
			'environment_information' => array(
				'_' => ' اطلاعات سیستم',
				'browser' => 'مرورگر',
				'database' => 'پایگاه داده',
				'server_software' => 'نرم‌افزار سرور',
				'version_curl' => 'نسخه cURL',
				'version_frss' => 'نسخه FreshRSS',
				'version_php' => 'نسخه PHP',
			),
		),
		'bugs_reports' => ' گزارش اشکال',
		'documentation' => ' اسناد و مدارک',
		'freshrss_description' => 'FreshRSS یک گردآورنده و خواننده RSS خودمیزبان است. با آن می‌توانید بدون رفتن از یک وب‌سایت به وب‌سایت دیگر، محتوای تازه را دنبال کنید.',
		'github' => ' <a href="https://github.com/FreshRSS/FreshRSS/issues">در GitHub</a>',
		'license' => ' مجوز',
		'project_website' => 'وب‌سایت پروژه',
		'title' => ' در مورد',
		'version' => ' نسخه',
	),
	'feed' => array(
		'empty' => ' هیچ مقاله ای برای نمایش وجود ندارد.',
		'published' => array(
			'_' => 'منتشر شده',
			'future' => 'منتشر شده در آینده',
			'today' => 'امروز منتشر شده',
			'yesterday' => 'دیروز منتشر شده',
		),
		'received' => array(
			'_' => 'دریافت شده',
			'today' => 'امروز دریافت شد',
			'yesterday' => 'دیروز دریافت شد',
		),
		'rss_of' => ' فید RSS %s',
		'title' => ' جریان اصلی',
		'title_fav' => ' موارد دلخواه',
		'title_global' => ' نمای جهانی',
		'userModified' => array(
			'_' => 'ویرایش شده توسط کاربر',
			'today' => 'امروز توسط کاربر ویرایش شده',
			'yesterday' => 'دیروز توسط کاربر ویرایش شده',
		),
	),
	'log' => array(
		'_' => 'گزارش‌ها',
		'clear' => 'گزارش‌ها را پاک کنید',
		'empty' => ' فایل لاگ خالی است',
		'title' => 'گزارش‌ها',
	),
	'menu' => array(
		'about' => ' درباره FreshRSS',
		'before_one_day' => 'قدیمی‌تر از یک روز',
		'before_one_week' => 'قدیمی‌تر از یک هفته',
		'bookmark_query' => ' درخواست فعلی را نشانک‌گذاری کنید',
		'favorites' => ' موارد دلخواه (%s)',
		'global_view' => ' نمای جهانی',
		'important' => 'فیدهای مهم',
		'main_stream' => ' جریان اصلی',
		'mark_all_read' => ' همه را به عنوان خوانده شده علامت گذاری کنید',
		'mark_cat_read' => ' دسته را به عنوان خوانده شده علامت گذاری کنید',
		'mark_feed_read' => ' فید را به عنوان خوانده شده علامت گذاری کنید',
		'mark_selection_unread' => ' انتخاب را به عنوان خوانده نشده علامت گذاری کنید',
		'mylabels' => ' برچسب های من',
		'non-starred' => ' موارد غیر مورد علاقه را نشان دهید',
		'normal_view' => ' نمای عادی',
		'queries' => ' پرس و جوهای کاربر',
		'read' => ' نمایش خوانده شده',
		'reader_view' => ' مشاهده خواندن',
		'rss_view' => ' خوراک RSS',
		'search_short' => ' جستجو',
		'sort' => array(
			'asc' => 'صعودی',
			'c' => array(
				'name_asc' => 'دسته‌بندی، عنوان‌های فید A→Z',
				'name_desc' => 'دسته‌بندی، عنوان‌های فید Z→A',
			),
			'date_asc' => 'تاریخ انتشار ۱→۹',
			'date_desc' => 'تاریخ انتشار ۹→۱',
			'desc' => 'نزولی',
			'f' => array(
				'name_asc' => 'عنوان فید A→Z',
				'name_desc' => 'عنوان فید Z→A',
			),
			'id_asc' => 'قدیمی‌ترین دریافت‌شده',
			'id_desc' => 'تازه‌ترین دریافت‌شده',
			'length_asc' => 'طول محتوا ۱→۹',
			'length_desc' => 'طول محتوا ۹→۱',
			'link_asc' => 'لینک A→Z',
			'link_desc' => 'لینک Z→A',
			'primary' => array(
				'_' => 'معیار مرتب‌سازی',
				'help' => 'در بیشتر موارد، مرتب‌سازی بر اساس تاریخ <em>دریافت</em> برای سازگاری و کارایی بهتر پیشنهاد می‌شود',
			),
			'rand' => 'ترتیب تصادفی',
			'secondary' => array(
				'_' => 'معیار مرتب‌سازی دوم',
				'help' => 'فقط زمانی کاربرد دارد که معیار اصلی مرتب‌سازی، عنوان دسته‌ها یا فیدها باشد',
			),
			'title_asc' => 'عنوان A→Z',
			'title_desc' => 'عنوان Z→A',
			'user_modified_asc' => 'ویرایش کاربر ۱→۹',
			'user_modified_desc' => 'ویرایش کاربر ۹→۱',
		),
		'starred' => ' نمایش موارد دلخواه',
		'stats' => ' آمار',
		'subscription' => ' مدیریت اشتراک',
		'unread' => ' نمایش خوانده نشده',
	),
	'share' => ' به اشتراک بگذارید',
	'tag' => array(
		'related' => ' برچسب های مقاله',
	),
	'tos' => array(
		'title' => ' شرایط خدمات',
	),
);

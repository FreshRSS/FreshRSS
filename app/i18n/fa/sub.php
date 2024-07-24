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
	'api' => array(
		'documentation' => ' URL زیر را برای استفاده از آن در یک ابزار خارجی کپی کنید.',
		'title' => ' API',
	),
	'bookmarklet' => array(
		'documentation' => ' این دکمه را به نوار ابزار نشانک‌های خود بکشید یا روی آن راست کلیک کرده و «Bookmark This Link» را انتخاب کنید. سپس روی دکمه "اشتراک" در هر صفحه ای که می خواهید مشترک شوید کلیک کنید.',
		'label' => ' مشترک شوید',
		'title' => ' Bookmarklet',
	),
	'category' => array(
		'_' => ' دسته',
		'add' => ' یک دسته اضافه کنید',
		'archiving' => ' بایگانی',
		'dynamic_opml' => array(
			'_' => ' OPML پویا',
			'help' => ' URL را به <a href="http://opml.org/" target="_blank">فایل OPML</a> ارائه دهید تا به صورت پویا این دسته با فیدها پر شود.',
		),
		'empty' => ' دسته خالی',
		'expand' => 'Expand category',	// TODO
		'information' => ' اطلاعات',
		'open' => 'Open category',	// TODO
		'opml_url' => ' URL OPML',
		'position' => ' موقعیت نمایش',
		'position_help' => ' برای کنترل ترتیب مرتب سازی دسته بندی',
		'title' => ' عنوان',
	),
	'feed' => array(
		'accept_cookies' => ' کوکی ها را بپذیرید',
		'accept_cookies_help' => ' به سرور فید اجازه دهید تا کوکی ها را تنظیم کند (فقط برای مدت زمان درخواست در حافظه ذخیره می شود)',
		'add' => ' یک فید RSS اضافه کنید',
		'advanced' => ' پیشرفته',
		'archiving' => ' بایگانی',
		'auth' => array(
			'configuration' => ' ورود',
			'help' => ' دسترسی به فیدهای RSS محافظت شده HTTP را می دهد',
			'http' => ' احراز هویت HTTP',
			'password' => ' رمز عبور HTTP',
			'username' => ' نام کاربری HTTP',
		),
		'clear_cache' => ' همیشه حافظه پنهان را پاک کنید',
		'content_action' => array(
			'_' => ' اقدام محتوا هنگام واکشی محتوای مقاله',
			'append' => ' پس از محتوای موجود اضافه کنید',
			'prepend' => ' قبل از محتوای موجود اضافه کنید',
			'replace' => ' محتوای موجود را جایگزین کنید',
		),
		'css_cookie' => ' هنگام واکشی محتوای مقاله از کوکی ها استفاده کنید',
		'css_cookie_help' => ' مثال: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => ' فیدهای RSS کوتاه شده را بازیابی می کند (احتیاط',
		'css_path' => ' انتخاب کننده CSS مقاله در وب سایت اصلی',
		'css_path_filter' => array(
			'_' => ' انتخابگر CSS از عناصر برای حذف',
			'help' => ' یک انتخابگر CSS ممکن است لیستی باشد مانند: <kbd>.footer',
		),
		'description' => ' توضیحات',
		'empty' => ' این فید خالی است. لطفاً بررسی کنید که هنوز نگهداری می شود.',
		'error' => ' این فید با مشکل مواجه شده است. لطفاً بررسی کنید که همیشه در دسترس است و سپس آن را به روز کنید.',
		'export-as-opml' => array(
			'download' => 'Download',	// TODO
			'help' => 'XML file (data subset. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">See documentation</a>)',	// TODO
			'label' => 'Export as OPML',	// TODO
		),
		'filteractions' => array(
			'_' => ' اعمال فیلتر',
			'help' => ' در هر خط یک فیلتر جستجو بنویسید. اپراتورها <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">مستندات را ببینید</a>.',
		),
		'information' => ' اطلاعات',
		'keep_min' => ' حداقل تعداد مقالات برای نگهداری',
		'kind' => array(
			'_' => ' نوع منبع خوراک',
			'html_xpath' => array(
				'_' => ' HTML + XPath (خراش دادن وب)',
				'feed_title' => array(
					'_' => ' عنوان خوراک',
					'help' => ' مثال: <code>//title</code> یا یک رشته ثابت: <code>"فید سفارشی من"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> یک زبان جستجوی استاندارد برای پیشرفته است کاربران',
				'item' => array(
					'_' => ' یافتن اخبار <strong>اقلام</strong><br /><small>(مهمترین)</small>',
					'help' => ' مثال: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => ' نویسنده مورد',
					'help' => ' همچنین می تواند یک رشته ثابت باشد. مثال: <code>"ناشناس"</code>',
				),
				'item_categories' => ' برچسب های آیتم',
				'item_content' => array(
					'_' => ' محتوای مورد',
					'help' => ' مثالی برای گرفتن کامل مورد: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => ' تصویر کوچک مورد',
					'help' => ' مثال: <code>فرزند::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => ' فرمت تاریخ/زمان سفارشی',
					'help' => ' اختیاری. قالبی که توسط <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> پشتیبانی می‌شود',
				),
				'item_timestamp' => array(
					'_' => ' تاریخ مورد',
					'help' => ' نتیجه با <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a> تجزیه خواهد شد',
				),
				'item_title' => array(
					'_' => ' عنوان مورد',
					'help' => ' به طور خاص از <a href="https://developer.mozilla.org/docs/Web/XPath/Axes" target="_blank">محور XPath</a> <code>فرزند::</code استفاده کنید > مانند <code>فرزند::h2</code>',
				),
				'item_uid' => array(
					'_' => ' شناسه منحصر به فرد مورد',
					'help' => ' اختیاری. مثال: <code>فرزند::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => ' پیوند مورد (URL)',
					'help' => ' مثال: <code>فرزند::a/@href</code>',
				),
				'relative' => 'XPath (نسبت به مورد) برای:',
				'xpath' => ' XPath برای:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (dot notation)',	// TODO
				'feed_title' => array(
					'_' => 'feed title',	// TODO
					'help' => 'Example: <code>meta.title</code> or a static string: <code>"My custom feed"</code>',	// TODO
				),
				'help' => 'A JSON dot notated uses dots between objects and brackets for arrays (e.g. <code>data.items[0].title</code>)',	// TODO
				'item' => array(
					'_' => 'finding news <strong>items</strong><br /><small>(most important)</small>',	// TODO
					'help' => 'JSON path to the array containing the items, e.g. <code>newsItems</code>',	// TODO
				),
				'item_author' => 'item author',	// TODO
				'item_categories' => 'item tags',	// TODO
				'item_content' => array(
					'_' => 'item content',	// TODO
					'help' => 'Key under which the content is found, e.g. <code>content</code>',	// TODO
				),
				'item_thumbnail' => array(
					'_' => 'item thumbnail',	// TODO
					'help' => 'Example: <code>image</code>',	// TODO
				),
				'item_timeFormat' => array(
					'_' => 'Custom date/time format',	// TODO
					'help' => 'Optional. A format supported by <a href="https://php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> such as <code>d-m-Y H:i:s</code>',	// TODO
				),
				'item_timestamp' => array(
					'_' => 'item date',	// TODO
					'help' => 'The result will be parsed by <a href="https://php.net/strtotime" target="_blank"><code>strtotime()</code></a>',	// TODO
				),
				'item_title' => 'item title',	// TODO
				'item_uid' => 'item unique ID',	// TODO
				'item_uri' => array(
					'_' => 'item link (URL)',	// TODO
					'help' => 'Example: <code>permalink</code>',	// TODO
				),
				'json' => 'dot notation for:',	// TODO
				'relative' => 'dot notated path (relative to item) for:',	// TODO
			),
			'jsonfeed' => 'JSON Feed',	// TODO
			'rss' => ' RSS / Atom (پیش‌فرض)',
			'xml_xpath' => ' XML + XPath',
		),
		'maintenance' => array(
			'clear_cache' => ' کش را پاک کنید',
			'clear_cache_help' => ' کش این فید را پاک کنید.',
			'reload_articles' => ' بارگذاری مجدد مقالات',
			'reload_articles_help' => ' تعداد زیادی مقاله را بارگیری مجدد کنید و در صورت تعریف انتخابگر',
			'title' => ' تعمیر و نگهداری',
		),
		'max_http_redir' => ' حداکثر تغییر مسیر HTTP',
		'max_http_redir_help' => ' روی 0 تنظیم کنید یا برای غیرفعال کردن آن را خالی بگذارید',
		'method' => array(
			'_' => 'HTTP Method',	// TODO
		),
		'method_help' => 'The POST payload has automatic support for <code>application/x-www-form-urlencoded</code> and <code>application/json</code>',	// TODO
		'method_postparams' => 'Payload for POST',	// TODO
		'moved_category_deleted' => ' هنگامی که یک دسته را حذف می کنید',
		'mute' => array(
			'_' => ' بی صدا',
			'state_is_muted' => 'This feed is muted',	// TODO
		),
		'no_selected' => ' هیچ خوراکی انتخاب نشده است.',
		'number_entries' => ' %d مقاله',
		'open_feed' => 'Open feed %s',	// TODO
		'priority' => array(
			'_' => ' دید',
			'archived' => ' نشان داده نشود (بایگانی شده)',
			'category' => ' نمایش در دسته بندی خود',
			'important' => 'Show in important feeds',	// TODO
			'main_stream' => ' نمایش در جریان اصلی',
		),
		'proxy' => ' یک پروکسی برای واکشی این فید تنظیم کنید',
		'proxy_help' => ' یک پروتکل (به عنوان مثال: SOCKS5) انتخاب کنید و آدرس پراکسی را وارد کنید (به عنوان مثال: <kbd>127.0.0.1:1080</kbd> or <kbd>username:password@127.0.0.1:1080</kbd>)',	// DIRTY
		'selector_preview' => array(
			'show_raw' => ' نمایش کد منبع',
			'show_rendered' => 'نمایش محتوا',
		),
		'show' => array(
			'all' => ' نمایش همه فیدها',
			'error' => ' نمایش فقط فیدهای دارای خطا',
		),
		'showing' => array(
			'error' => ' نمایش فقط فیدهای دارای خطا',
		),
		'ssl_verify' => ' امنیت SSL را تأیید کنید',
		'stats' => ' آمار',
		'think_to_add' => ' می توانید چند فید اضافه کنید.',
		'timeout' => ' تایم اوت در ثانیه',
		'title' => ' عنوان',
		'title_add' => ' یک فید RSS اضافه کنید',
		'ttl' => ' به‌طور خودکار بیشتر از آن رفرش نکنید',
		'url' => ' URL فید',
		'useragent' => ' عامل کاربر را برای واکشی این فید تنظیم کنید',
		'useragent_help' => ' مثال: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => ' اعتبار خوراک را بررسی کنید',
		'website' => ' آدرس وب سایت',
		'websub' => ' اطلاع رسانی فوری با WebSub',
	),
	'import_export' => array(
		'export' => ' صادرات',
		'export_labelled' => ' مقالات برچسب دار خود را صادر کنید',
		'export_opml' => ' لیست صادرات فیدها (OPML)',
		'export_starred' => ' موارد دلخواه خود را صادر کنید',
		'feed_list' => ' فهرست %s مقاله',
		'file_to_import' => ' فایل برای وارد کردن<br />(OPML',
		'file_to_import_no_zip' => ' فایل برای وارد کردن<br /> (OPML یا JSON)',
		'import' => 'واردات',
		'starred_list' => ' فهرست مقالات مورد علاقه',
		'title' => ' واردات / صادرات',
	),
	'menu' => array(
		'add' => ' یک فید یا دسته اضافه کنید',
		'import_export' => ' واردات / صادرات',
		'label_management' => ' مدیریت برچسب',
		'stats' => array(
			'idle' => ' تغذیه بیکار',
			'main' => ' آمار اصلی',
			'repartition' => ' تقسیم مجدد مقالات',
		),
		'subscription_management' => ' مدیریت اشتراک',
		'subscription_tools' => 'ابزارهای اشتراک',
	),
	'tag' => array(
		'auto_label' => 'Add this label to new articles',	// TODO
		'name' => ' نام',
		'new_name' => ' نام جدید',
		'old_name' => ' نام قدیمی',
	),
	'title' => array(
		'_' => ' مدیریت اشتراک',
		'add' => ' یک فید یا دسته اضافه کنید',
		'add_category' => ' یک دسته اضافه کنید',
		'add_dynamic_opml' => ' OPML پویا را اضافه کنید',
		'add_feed' => ' یک فید اضافه کنید',
		'add_label' => ' یک برچسب اضافه کنید',
		'delete_label' => ' یک برچسب را حذف کنید',
		'feed_management' => ' فیدهای RSS را مدیریت می کندment',
		'rename_label' => ' نام یک برچسب را تغییر دهید',
		'subscription_tools' => 'ابزارهای اشتراک',
	),
);

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
	'api' => array(
		'documentation' => 'انسخ عنوان URL التالي لاستخدامه داخل أداة خارجية.',
		'title' => 'API',	// IGNORE
	),
	'bookmarklet' => array(
		'documentation' => 'اسحب هذا الزر إلى شريط أدوات الإشارات المرجعية أو انقر عليه بزر الفأرة الأيمن واختر «وضع إشارة مرجعية على هذا الرابط». ثم انقر على زر «اشتراك» في أي صفحة تريد الاشتراك فيها.',
		'label' => 'اشتراك',
		'title' => 'أداة الإشارة المرجعية',
	),
	'category' => array(
		'_' => 'تصنيف',
		'add' => 'إضافة تصنيف',
		'archiving' => 'الأرشفة',
		'dynamic_opml' => array(
			'_' => 'OPML ديناميكي',
			'help' => 'قدّم عنوان URL لملف <a href="https://opml.org/" target="_blank">OPML</a> لملء هذا التصنيف بالخلاصات ديناميكيًا',
		),
		'empty' => 'تصنيف فارغ',
		'error' => 'واجه هذا التصنيف الديناميكي OPML مشكلة. تحقق من أن عنوان OPML ما يزال متاحًا، ومن أن الحد الأقصى لعدد الخلاصات لكل مستخدم لم يتم تجاوزه.',
		'expand' => 'توسيع التصنيف',
		'information' => 'معلومات',
		'open' => 'فتح التصنيف',
		'opml_url' => 'عنوان OPML',
		'position' => 'موضع العرض',
		'position_help' => 'للتحكم في ترتيب فرز التصنيفات',
		'title' => 'العنوان',
	),
	'feed' => array(
		'accept_cookies' => 'قبول ملفات تعريف الارتباط',
		'accept_cookies_help' => 'السماح لخادم الخلاصة بتعيين ملفات تعريف الارتباط (تُحفظ في الذاكرة لمدة الطلب فقط)',
		'add' => 'إضافة خلاصة',
		'advanced' => 'متقدم',
		'archiving' => 'الأرشفة',
		'auth' => array(
			'configuration' => 'تسجيل الدخول',
			'help' => 'يتيح الوصول إلى خلاصات RSS المحمية عبر HTTP',
			'http' => 'مصادقة HTTP',
			'password' => 'كلمة مرور HTTP',
			'username' => 'اسم مستخدم HTTP',
		),
		'change_favicon' => 'تغيير…',
		'clear_cache' => 'مسح ذاكرة التخزين المؤقت دائمًا',
		'content_action' => array(
			'_' => 'إجراء المحتوى عند جلب محتوى المقال',
			'append' => 'الإضافة بعد المحتوى الحالي',
			'prepend' => 'الإضافة قبل المحتوى الحالي',
			'replace' => 'استبدال المحتوى الحالي',
		),
		'content_retrieval' => 'استرجاع المحتوى',
		'css_cookie' => 'استخدام ملفات تعريف الارتباط عند جلب محتوى المقال',
		'css_cookie_help' => 'مثال: <kbd>foo=bar; gdpr_consent=true; cookie=value</kbd>',
		'css_help' => 'يستعيد خلاصات RSS المقتطعة (تنبيه: يتطلب وقتًا أطول!)',
		'css_path' => 'محدد CSS للمقال على الموقع الأصلي',
		'css_path_filter' => array(
			'_' => 'محدد CSS للعناصر المراد إزالتها',
			'help' => 'قد يكون محدد CSS قائمة مثل: <kbd>footer, aside, p[data-sanitized-class~="menu"]</kbd>',
		),
		'description' => 'الوصف',
		'empty' => 'هذه الخلاصة فارغة. يرجى التحقق من أنها ما تزال قائمة.',
		'error' => 'واجهت هذه الخلاصة مشكلة. إذا استمرت هذه الحالة، يرجى التحقق من أنها ما تزال متاحة.',
		'export-as-opml' => array(
			'download' => 'تنزيل',
			'help' => 'ملف XML (مجموعة فرعية من البيانات. <a href="https://freshrss.github.io/FreshRSS/en/developers/OPML.html" target="_blank">اطّلع على الوثائق</a>)',
			'label' => 'التصدير بصيغة OPML',
		),
		'ext_favicon' => 'التعيين تلقائيًا',
		'favicon_changed_by_ext' => 'تم تعيين الأيقونة بواسطة إضافة <b>%s</b>.',
		'filteractions' => array(
			'_' => 'إجراءات التصفية',
			'help' => 'اكتب عامل تصفية بحث واحدًا في كل سطر. العوامل <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">اطّلع على الوثائق</a>.',
			'view_filter' => 'معاينة عوامل التصفية على المقالات الحالية (نافذة جديدة)',
		),
		'global_hint' => 'استخدم <a href="%s">العرض الشامل</a> لمعرفة عدد المقالات في كل خلاصة التي تطابق حالة أو عبارة بحث',
		'http_headers' => 'ترويسات HTTP',
		'http_headers_help' => 'تُفصل الترويسات بسطر جديد، ويُفصل اسم الترويسة وقيمتها بنقطتين رأسيتين (مثال: <kbd><code>Accept: application/atom+xml<br />Authorization: Bearer some-token</code></kbd>).',
		'icon' => 'أيقونة',
		'information' => 'معلومات',
		'keep_adding_feed' => 'ثم أضف مزيدًا من الخلاصات',
		'keep_min' => 'الحد الأدنى لعدد المقالات المراد الاحتفاظ به',
		'kind' => array(
			'_' => 'نوع مصدر الخلاصة',
			'html_json' => array(
				'_' => 'HTML + XPath + تدوين JSON بالنقاط (JSON في HTML)',
				'xpath' => array(
					'_' => 'XPath لـ JSON في HTML',
					'help' => 'مثال: <code>normalize-space(//script[@type="application/json"])</code> (JSON واحد)<br />أو: <code>//script[@type="application/ld+json"]</code> (كائن JSON واحد لكل مقال)',
				),
			),
			'html_xpath' => array(
				'_' => 'HTML + XPath (استخلاص من الويب)',
				'feed_title' => array(
					'_' => 'عنوان الخلاصة',
					'help' => 'مثال: <code>//title</code> أو سلسلة ثابتة: <code>"My custom feed"</code>',
				),
				'help' => '<dfn><a href="https://www.w3.org/TR/xpath-10/" target="_blank">XPath 1.0</a></dfn> هي لغة استعلام قياسية للمستخدمين المتقدمين، ويدعمها FreshRSS لتمكين الاستخلاص من الويب.',
				'item' => array(
					'_' => 'العثور على <strong>عناصر</strong> الأخبار<br /><small>(الأهم)</small>',
					'help' => 'مثال: <code>//div[@class="news-item"]</code>',
				),
				'item_author' => array(
					'_' => 'كاتب العنصر',
					'help' => 'يمكن أن يكون أيضًا سلسلة ثابتة. مثال: <code>"Anonymous"</code>',
				),
				'item_categories' => 'وسوم العنصر',
				'item_content' => array(
					'_' => 'محتوى العنصر',
					'help' => 'مثال لأخذ العنصر كاملاً: <code>.</code>',
				),
				'item_thumbnail' => array(
					'_' => 'الصورة المصغرة للعنصر',
					'help' => 'مثال: <code>descendant::img/@src</code>',
				),
				'item_timeFormat' => array(
					'_' => 'تنسيق مخصص للتاريخ/الوقت',
					'help' => 'اختياري. تنسيق يدعمه <a href="https://www.php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> مثل <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'تاريخ العنصر',
					'help' => 'سيتم تحليل النتيجة بواسطة <a href="https://www.php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => array(
					'_' => 'عنوان العنصر',
					'help' => 'استخدم على وجه الخصوص <a href="https://developer.mozilla.org/docs/Web/XML/XPath/Reference/Axes" target="_blank">محور XPath</a> <code>descendant::</code> مثل <code>descendant::h2</code>',
				),
				'item_uid' => array(
					'_' => 'المعرف الفريد للعنصر',
					'help' => 'اختياري. مثال: <code>descendant::div/@data-uri</code>',
				),
				'item_uri' => array(
					'_' => 'رابط العنصر (URL)',
					'help' => 'مثال: <code>descendant::a/@href</code>',
				),
				'relative' => 'XPath (نسبي إلى العنصر) لـ:',
				'xpath' => 'XPath لـ:',
			),
			'json_dotnotation' => array(
				'_' => 'JSON (تدوين بالنقاط)',
				'feed_title' => array(
					'_' => 'عنوان الخلاصة',
					'help' => 'مثال: <code>meta.title</code> أو سلسلة ثابتة: <code>"My custom feed"</code>',
				),
				'help' => 'يستخدم تدوين JSON بالنقاط النقاط بين الكائنات والأقواس المعقوفة للمصفوفات (مثال: <code>data.items[0].title</code>)',
				'item' => array(
					'_' => 'العثور على <strong>عناصر</strong> الأخبار<br /><small>(الأهم)</small>',
					'help' => 'مسار JSON إلى المصفوفة التي تحتوي على العناصر، مثال: <code>$</code> أو <code>newsItems</code>',
				),
				'item_author' => 'كاتب العنصر',
				'item_categories' => 'وسوم العنصر',
				'item_content' => array(
					'_' => 'محتوى العنصر',
					'help' => 'المفتاح الذي يوجد تحته المحتوى، مثال: <code>content</code>',
				),
				'item_thumbnail' => array(
					'_' => 'الصورة المصغرة للعنصر',
					'help' => 'مثال: <code>image</code>',
				),
				'item_timeFormat' => array(
					'_' => 'تنسيق مخصص للتاريخ/الوقت',
					'help' => 'اختياري. تنسيق يدعمه <a href="https://www.php.net/datetime.createfromformat" target="_blank"><code>DateTime::createFromFormat()</code></a> مثل <code>d-m-Y H:i:s</code>',
				),
				'item_timestamp' => array(
					'_' => 'تاريخ العنصر',
					'help' => 'سيتم تحليل النتيجة بواسطة <a href="https://www.php.net/strtotime" target="_blank"><code>strtotime()</code></a>',
				),
				'item_title' => 'عنوان العنصر',
				'item_uid' => 'المعرف الفريد للعنصر',
				'item_uri' => array(
					'_' => 'رابط العنصر (URL)',
					'help' => 'مثال: <code>permalink</code>',
				),
				'json' => 'تدوين بالنقاط لـ:',
				'relative' => 'مسار بتدوين بالنقاط (نسبي إلى العنصر) لـ:',
			),
			'jsonfeed' => 'JSON Feed',	// IGNORE
			'rss' => 'RSS / Atom (الافتراضي)',
			'xml_xpath' => 'XML + XPath',	// IGNORE
		),
		'last-entry-publication-date' => 'آخر مقال نُشر <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-entry-received-date' => 'آخر مقال تم استلامه <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-error-date' => 'آخر تحديث خاطئ <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'last-update' => 'آخر تحديث ناجح <time datetime="%1$s" title="%1$s">%2$s</time>.',
		'maintenance' => array(
			'clear_cache' => 'مسح ذاكرة التخزين المؤقت',
			'clear_cache_help' => 'مسح ذاكرة التخزين المؤقت لهذه الخلاصة.',
			'reload_articles' => 'إعادة تحميل المقالات',
			'reload_articles_help' => 'إعادة تحميل هذا العدد من المقالات وجلب المحتوى الكامل إذا تم تحديد محدد.',
			'title' => 'الصيانة',
		),
		'max_http_redir' => 'الحد الأقصى لإعادة توجيه HTTP',
		'max_http_redir_help' => 'عيّن 0 أو اتركه فارغًا للتعطيل، و-1 لإعادة توجيه غير محدودة',
		'method' => array(
			'_' => 'طريقة HTTP',
		),
		'method_help' => 'تدعم حمولة POST تلقائيًا <code>application/x-www-form-urlencoded</code> و<code>application/json</code>',
		'method_postparams' => 'حمولة POST',
		'moved_category_deleted' => 'عند إزالة تصنيف، تُصنّف خلاصاته تلقائيًا تحت <em>%s</em>.',
		'mute' => array(
			'_' => 'كتم',
			'state_is_muted' => 'هذه الخلاصة مكتومة',
		),
		'no_selected' => 'لم يتم تحديد أي خلاصة.',
		'number_entries' => '%d مقال',
		'open_feed' => 'فتح الخلاصة %s',
		'path_entries_conditions' => 'شروط استرجاع المحتوى',
		'priority' => array(
			'_' => 'الظهور',
			'category' => 'الإظهار في تصنيفها',
			'feed' => 'الإظهار في خلاصتها',
			'hidden' => 'عدم الإظهار',
			'important' => 'الإظهار في الخلاصات المهمة',
			'main_stream' => 'الإظهار في التدفق الرئيسي',
		),
		'proxy' => 'تعيين وكيل لجلب هذه الخلاصة',
		'proxy_help' => 'اختر بروتوكولاً (مثال: SOCKS5) وأدخل عنوان الوكيل (مثال: <kbd>127.0.0.1:1080</kbd> أو <kbd>username:password@127.0.0.1:1080</kbd>)',
		'reset_favicon' => 'إعادة التعيين إلى الافتراضي',
		'selector_preview' => array(
			'show_raw' => 'إظهار الشيفرة المصدرية',
			'show_rendered' => 'إظهار المحتوى',
		),
		'show' => array(
			'all' => 'كل الخلاصات',
			'error' => 'إظهار الخلاصات ذات الأخطاء فقط',
		),
		'showing' => array(
			'error' => 'إظهار الخلاصات ذات الأخطاء فقط',
		),
		'ssl_verify' => 'التحقق من أمان SSL',
		'stats' => 'الإحصاءات',
		'think_to_add' => 'يمكنك إضافة بعض الخلاصات.',
		'timeout' => 'المهلة بالثواني',
		'title' => 'العنوان',
		'title_add' => 'إضافة خلاصة RSS',
		'ttl' => 'عدم التحديث تلقائيًا أكثر من كل',
		'unicityCriteria' => array(
			'_' => 'معايير تفرد المقال',
			'forced' => '<span title="فرض معايير التفرد، حتى عندما تحتوي الخلاصة على مقالات مكررة">مفروضة</span>',
			'help' => 'ذات صلة بالخلاصات غير الصالحة.<br />⚠️ سيؤدي تغيير السياسة إلى إنشاء نسخ مكررة.',
			'id' => 'المعرف القياسي (الافتراضي)',
			'link' => 'الرابط',
			'sha1:content' => 'المحتوى',
			'sha1:content_published' => 'المحتوى + التاريخ',
			'sha1:link_published' => 'الرابط + التاريخ',
			'sha1:link_published_title' => 'الرابط + التاريخ + العنوان',
			'sha1:link_published_title_content' => 'الرابط + التاريخ + العنوان + المحتوى',
			'sha1:published' => 'التاريخ',
			'sha1:title' => 'العنوان',
			'sha1:title_published' => 'العنوان + التاريخ',
			'sha1:title_published_content' => 'العنوان + التاريخ + المحتوى',
		),
		'url' => 'عنوان URL للخلاصة',
		'useragent' => 'تعيين وكيل المستخدم لجلب هذه الخلاصة',
		'useragent_help' => 'مثال: <kbd>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0)</kbd>',
		'validator' => 'التحقق من صحة الخلاصة',
		'website' => 'عنوان URL للموقع',
		'websub' => 'إشعارات فورية عبر WebSub',
		'websub_pending' => 'تم الاشتراك في WebSub. في انتظار الإشعار الأول.',
	),
	'import_export' => array(
		'export' => array(
			'_' => 'تصدير',
			'sqlite' => 'تنزيل قاعدة بيانات المستخدم بصيغة SQLite',
		),
		'export_labelled' => 'تصدير مقالاتك الموسومة',
		'export_opml' => 'تصدير قائمة الخلاصات (OPML)',
		'export_starred' => 'تصدير مفضلتك',
		'feed_list' => 'قائمة مقالات %s',
		'file_to_import' => 'ملف للاستيراد<br />(OPML أو JSON أو ZIP)',
		'file_to_import_no_zip' => 'ملف للاستيراد<br />(OPML أو JSON)',
		'import' => 'استيراد',
		'starred_list' => 'قائمة المقالات المفضلة',
		'title' => 'استيراد / تصدير',
	),
	'menu' => array(
		'add' => 'إضافة خلاصة أو تصنيف',
		'import_export' => 'استيراد / تصدير',
		'label_management' => 'إدارة التسميات',
		'stats' => array(
			'idle' => 'الخلاصات الخاملة',
			'main' => 'الإحصاءات الرئيسية',
			'repartition' => 'توزيع المقالات',
			'unread_dates' => 'تواريخ غير المقروءة',
		),
		'subscription_management' => 'إدارة الاشتراكات',
		'subscription_tools' => 'أدوات الاشتراك',
	),
	'tag' => array(
		'auto_label' => 'إضافة هذه التسمية إلى المقالات الجديدة',
		'name' => 'الاسم',
		'new_name' => 'الاسم الجديد',
		'old_name' => 'الاسم القديم',
	),
	'title' => array(
		'_' => 'إدارة الاشتراكات',
		'add' => 'إضافة خلاصة أو تصنيف',
		'add_category' => 'إضافة تصنيف',
		'add_dynamic_opml' => 'إضافة OPML ديناميكي',
		'add_feed' => 'إضافة خلاصة',
		'add_label' => 'إضافة تسمية',
		'add_opml_category' => 'اسم تصنيف OPML',
		'delete_label' => 'حذف هذه التسمية',
		'feed_management' => 'إدارة خلاصات RSS',
		'subscription_tools' => 'أدوات الاشتراك',
	),
);

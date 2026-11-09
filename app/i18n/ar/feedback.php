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
	'access' => array(
		'denied' => 'ليس لديك إذن للوصول إلى هذه الصفحة',
		'not_found' => 'أنت تبحث عن صفحة غير موجودة',
	),
	'admin' => array(
		'optimization_complete' => 'اكتمل التحسين',
	),
	'api' => array(
		'password' => array(
			'failed' => 'لا يمكن تعديل كلمة المرور الخاصة بك',
			'updated' => 'تم تعديل كلمة المرور الخاصة بك',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => 'بيانات تسجيل الدخول غير صالحة',
			'success' => 'أنت متصل الآن',
		),
		'logout' => array(
			'success' => 'تم تسجيل خروجك',
		),
	),
	'conf' => array(
		'error' => 'حدث خطأ أثناء حفظ الإعدادات',
		'query_created' => 'تم إنشاء الاستعلام “%s”.',
		'shortcuts_updated' => 'تم تحديث الاختصارات بنجاح',
		'updated' => 'تم تحديث الإعدادات بنجاح',
	),
	'extensions' => array(
		'already_enabled' => '%s مفعّل بالفعل',
		'cannot_remove' => 'لا يمكن إزالة %s',
		'disable' => array(
			'ko' => 'لا يمكن تعطيل %s. <a href="%s">راجع سجلات FreshRSS</a> لمزيد من التفاصيل.',
			'ok' => 'تم تعطيل %s الآن',
		),
		'enable' => array(
			'ko' => 'لا يمكن تفعيل %s. <a href="%s">راجع سجلات FreshRSS</a> لمزيد من التفاصيل.',
			'ok' => 'تم تفعيل %s الآن',
		),
		'invalid_view_mode' => 'وضع العرض “%s” غير صالح! تم الرجوع إلى “العرض العادي”.',
		'no_access' => 'ليس لديك حق الوصول إلى %s',
		'not_enabled' => '%s غير مفعّل',
		'not_found' => '%s غير موجود',
		'removed' => 'تمت إزالة %s',
	),
	'import_export' => array(
		'export_no_zip_extension' => 'امتداد ZIP غير موجود على الخادم الخاص بك. يرجى محاولة تصدير الملفات واحدًا تلو الآخر.',
		'feeds_imported' => 'تم استيراد خلاصاتك بنجاح. إذا انتهيت من الاستيراد، يمكنك الآن النقر على زر <i>تحديث الخلاصات</i>.',
		'feeds_imported_with_errors' => 'تم استيراد خلاصاتك، ولكن حدثت بعض الأخطاء. إذا انتهيت من الاستيراد، يمكنك الآن النقر على زر <i>تحديث الخلاصات</i>.',
		'file_cannot_be_uploaded' => 'لا يمكن رفع الملف!',
		'no_zip_extension' => 'امتداد ZIP غير موجود على الخادم الخاص بك.',
		'zip_error' => 'حدث خطأ أثناء معالجة ZIP.',
	),
	'profile' => array(
		'error' => 'لا يمكن تعديل ملفك الشخصي',
		'passwords_dont_match' => 'كلمتا المرور غير متطابقتين',
		'updated' => 'تم تعديل ملفك الشخصي بنجاح',
	),
	'sub' => array(
		'actualize' => 'جارٍ التحديث',
		'articles' => array(
			'marked_read' => 'تم تعليم المقالات المحددة كمقروءة.',
			'marked_unread' => 'تم تعليم المقالات كغير مقروءة.',
		),
		'category' => array(
			'created' => 'تم إنشاء التصنيف %s بنجاح.',
			'deleted' => 'تم حذف التصنيف بنجاح.',
			'emptied' => 'تم إفراغ التصنيف',
			'error' => 'لا يمكن تحديث التصنيف',
			'name_exists' => 'اسم التصنيف موجود بالفعل.',
			'no_id' => 'يجب تحديد معرّف التصنيف.',
			'no_name' => 'لا يمكن أن يكون اسم التصنيف فارغًا.',
			'not_delete_default' => 'لا يمكنك حذف التصنيف الافتراضي!',
			'not_exist' => 'التصنيف غير موجود!',
			'over_max' => 'لقد وصلت إلى الحد الأقصى من التصنيفات (%d)',
			'updated' => 'تم تحديث التصنيف بنجاح.',
		),
		'feed' => array(
			'actualized' => 'تم تحديث <em>%s</em> بنجاح',
			'actualizeds' => 'تم تحديث خلاصات RSS بنجاح',
			'added' => 'تمت إضافة خلاصة RSS <em>%s</em> بنجاح',
			'already_subscribed' => 'أنت مشترك بالفعل في <em>%s</em>',
			'cache_cleared' => 'تم مسح ذاكرة التخزين المؤقت لـ <em>%s</em>',
			'deleted' => 'تم حذف الخلاصة بنجاح',
			'error' => 'لا يمكن تحديث الخلاصة',
			'favicon' => array(
				'too_large' => 'الأيقونة المرفوعة كبيرة جدًا. الحد الأقصى لحجم الملف هو <em>%s</em>.',
				'unsupported_format' => 'تنسيق ملف الصورة غير مدعوم!',
			),
			'internal_problem' => 'تعذرت إضافة خلاصة الأخبار. <a href="%s">راجع سجلات FreshRSS</a> لمزيد من التفاصيل. يمكنك محاولة الإضافة القسرية بإضافة <code>#force_feed</code> إلى الرابط.',
			'invalid_url' => 'الرابط <em>%s</em> غير صالح',
			'n_actualized' => 'تم تحديث %d خلاصة',
			'n_entries_deleted' => 'تم حذف %d مقال',
			'no_refresh' => 'لا توجد خلاصات لتحديثها',
			'not_added' => 'تعذرت إضافة <em>%s</em>',
			'not_found' => 'تعذر العثور على الخلاصة',
			'over_max' => 'لقد وصلت إلى الحد الأقصى من الخلاصات (%d)',
			'reloaded' => 'تمت إعادة تحميل <em>%s</em>',
			'selector_preview' => array(
				'http_error' => 'فشل تحميل محتوى الموقع.',
				'no_entries' => 'لا توجد مقالات في هذه الخلاصة. تحتاج إلى مقال واحد على الأقل لإنشاء معاينة.',
				'no_feed' => 'خطأ داخلي (تعذر العثور على الخلاصة).',
				'no_result' => 'لم يطابق المحدد أي شيء. كبديل، سيتم عرض نص الخلاصة الأصلي بدلًا من ذلك.',
				'selector_empty' => 'المحدد فارغ. تحتاج إلى تعريف محدد لإنشاء معاينة.',
			),
			'updated' => 'تم تحديث الخلاصة بنجاح',
		),
		'purge_completed' => 'اكتمل التطهير (تم حذف %d مقال)',
	),
	'tag' => array(
		'created' => 'تم إنشاء التسمية “%s” بنجاح.',
		'error' => 'تعذر تحديث التسمية!',
		'name_exists' => 'اسم التسمية موجود بالفعل.',
		'renamed' => 'تمت إعادة تسمية التسمية “%s” إلى “%s”.',
		'updated' => 'تم تحديث التسمية بنجاح.',
	),
	'update' => array(
		'can_apply' => 'يتوفر تحديث لـ FreshRSS: <strong>الإصدار %s</strong>.',
		'error' => 'واجهت عملية التحديث خطأ: %s',
		'file_is_nok' => 'يتوفر تحديث لـ FreshRSS (<strong>الإصدار %s</strong>)، ولكن تحقق من الأذونات على مجلد <em>%s</em>. يجب أن يتمتع خادم HTTP بإذن الكتابة',
		'finished' => 'اكتمل التحديث!',
		'none' => 'لا يتوفر أي تحديث',
		'server_not_found' => 'تعذر العثور على خادم التحديث. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => 'تم إنشاء المستخدم %s بنجاح',
			'error' => 'لا يمكن إنشاء المستخدم %s',
		),
		'deleted' => array(
			'_' => 'تم حذف المستخدم %s بنجاح',
			'error' => 'لا يمكن حذف المستخدم %s',
		),
		'updated' => array(
			'_' => 'تم تحديث المستخدم %s بنجاح',
			'error' => 'لم يتم تحديث المستخدم %s',
		),
	),
);

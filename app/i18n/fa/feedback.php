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
	'access' => array(
		'denied' => ' شما اجازه دسترسی به این صفحه را ندارید',
		'not_found' => ' شما به دنبال صفحه ای هستید که وجود ندارد',
	),
	'admin' => array(
		'optimization_complete' => ' بهینه سازی کامل شد',
	),
	'api' => array(
		'password' => array(
			'failed' => ' رمز عبور شما قابل تغییر نیست',
			'updated' => ' رمز عبور شما اصلاح شده است',
		),
	),
	'auth' => array(
		'login' => array(
			'invalid' => ' ورود نامعتبر است',
			'success' => ' شما متصل هستید',
		),
		'logout' => array(
			'success' => ' شما قطع شده اید',
		),
	),
	'conf' => array(
		'error' => ' هنگام ذخیره پیکربندی خطایی روی داد',
		'query_created' => ' پرس و جو "%s" ایجاد شده است.',
		'shortcuts_updated' => ' میانبرها به روز شده اند',
		'updated' => ' پیکربندی به روز شده است',
	),
	'extensions' => array(
		'already_enabled' => '%s قبلاً فعال شده است',
		'cannot_remove' => ' %s قابل حذف نیست',
		'disable' => array(
			'ko' => '%s را نمی توان غیرفعال کرد. برای جزئیات <a href="%s">گزارش‌های FreshRSS</a> را بررسی کنید.',
			'ok' => ' %s اکنون غیرفعال است',
		),
		'enable' => array(
			'ko' => ' %s را نمی توان فعال کرد. برای جزئیات <a href="%s">گزارش‌های FreshRSS</a> را بررسی کنید.',
			'ok' => ' %s اکنون فعال است',
		),
		'no_access' => ' شما به %s دسترسی ندارید',
		'not_enabled' => '%s فعال نیست',
		'not_found' => '%s وجود ندارد',
		'removed' => '%s حذف شد',
	),
	'import_export' => array(
		'export_no_zip_extension' => ' پسوند ZIP در سرور شما وجود ندارد. لطفا سعی کنید فایل ها را یکی یکی صادر کنید.',
		'feeds_imported' => ' فیدهای شما وارد شده اند و اکنون به روز خواهند شد / Your feeds have been imported. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'feeds_imported_with_errors' => ' فیدهای شما وارد شده است / Your feeds have been imported, but some errors occurred. If you are done importing, you can now click the <i>Update feeds</i> button.',	// DIRTY
		'file_cannot_be_uploaded' => ' فایل قابل آپلود نیست!',
		'no_zip_extension' => ' پسوند ZIP در سرور شما وجود ندارد.',
		'zip_error' => ' در حین پردازش ZIP خطایی روی داد.',
	),
	'profile' => array(
		'error' => ' نمایه شما قابل تغییر نیست',
		'updated' => ' نمایه شما اصلاح شده است',
	),
	'sub' => array(
		'actualize' => ' به روز رسانی',
		'articles' => array(
			'marked_read' => ' مقالات انتخاب شده به عنوان خوانده شده علامت گذاری شده اند.',
			'marked_unread' => ' مقالات به عنوان خوانده نشده علامت گذاری شده اند.',
		),
		'category' => array(
			'created' => ' رده %s ایجاد شده است.',
			'deleted' => ' دسته حذف شده است.',
			'emptied' => ' رده خالی شده است',
			'error' => ' دسته را نمی توان به روز کرد',
			'name_exists' => ' نام دسته از قبل وجود دارد.',
			'no_id' => ' شما باید شناسه دسته را مشخص کنید.',
			'no_name' => ' نام دسته نمی تواند خالی باشد.',
			'not_delete_default' => ' شما نمی توانید دسته بندی پیش فرض را حذف کنید!',
			'not_exist' => ' دسته بندی وجود ندارد!',
			'over_max' => ' شما به حد مجاز دسته بندی خود رسیده اید (%d)',
			'updated' => ' رده به روز شده است.',
		),
		'feed' => array(
			'actualized' => '<em>%s</em> به روز شده است',
			'actualizeds' => ' فیدهای RSS به روز شده اند',
			'added' => ' فید RSS <em>%s</em> اضافه شده است',
			'already_subscribed' => ' شما قبلاً در <em>%s</em> مشترک شده اید',
			'cache_cleared' => '<em>%s</em> کش پاک شده است',
			'deleted' => ' فید حذف شده است',
			'error' => ' فید را نمی توان به روز کرد',
			'internal_problem' => ' فید خبری اضافه نشد. برای جزئیات <a href="%s">گزارش‌های FreshRSS</a> را بررسی کنید. می‌توانید با اضافه کردن <code>#force_feed</code> به URL',
			'invalid_url' => ' URL <em>%s</em> نامعتبر است',
			'n_actualized' => ' %d فید به روز شده است',
			'n_entries_deleted' => ' %d مقاله حذف شده است',
			'no_refresh' => ' هیچ فید برای تازه کردن وجود ندارد',
			'not_added' => '<em>%s</em> اضافه نشد',
			'not_found' => ' فید یافت نمی شود',
			'over_max' => ' شما به حد مجاز فید خود رسیده اید (%d)',
			'reloaded' => '<em>%s</em> دوباره بارگیری شده است',
			'selector_preview' => array(
				'http_error' => ' محتوای وب سایت بارگیری نشد.',
				'no_entries' => ' هیچ مقاله ای در این فید وجود ندارد. برای ایجاد پیش نمایش به حداقل یک مقاله نیاز دارید.',
				'no_feed' => ' خطای داخلی (فید یافت نمی شود).',
				'no_result' => ' انتخابگر با چیزی مطابقت نداشت. به عنوان یک بازگشت',
				'selector_empty' => ' انتخابگر خالی است. برای ایجاد پیش نمایش باید یکی را تعریف کنید.',
			),
			'updated' => ' فید به روز شده است',
		),
		'purge_completed' => ' پاکسازی کامل شد (%d مقاله حذف شد)',
	),
	'tag' => array(
		'created' => ' برچسب "%s" ایجاد شده است.',
		'error' => 'Label could not be updated!',	// TODO
		'name_exists' => ' نام برچسب از قبل وجود دارد.',
		'renamed' => ' برچسب "%s" به "%s" تغییر نام داده است.',
		'updated' => 'Label has been updated.',	// TODO
	),
	'update' => array(
		'can_apply' => ' به‌روزرسانی FreshRSS موجود است: <strong>نسخه %s</strong>.',
		'error' => ' فرآیند به روز رسانی با خطا مواجه شده است: %s',
		'file_is_nok' => ' به‌روزرسانی FreshRSS موجود است (<strong>نسخه %s</strong>)',
		'finished' => ' به روز رسانی کامل شد!',
		'none' => ' به روز رسانی در دسترس نیست',
		'server_not_found' => ' سرور به روز رسانی یافت نمی شود. [%s]',
	),
	'user' => array(
		'created' => array(
			'_' => ' کاربر %s ایجاد شده است',
			'error' => ' کاربر %s نمی تواند ایجاد شود',
		),
		'deleted' => array(
			'_' => ' کاربر %s حذف شده است',
			'error' => ' کاربر %s قابل حذف نیست',
		),
		'updated' => array(
			'_' => ' کاربر %s به روز شده است',
			'error' => ' کاربر %s به روز نشده است',
		),
	),
);

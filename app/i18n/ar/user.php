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
	'email' => array(
		'feedback' => array(
			'invalid' => 'عنوان البريد الإلكتروني هذا غير صالح.',
			'required' => 'عنوان البريد الإلكتروني مطلوب.',
		),
		'validation' => array(
			'change_email' => 'يمكنك تغيير عنوان بريدك الإلكتروني <a href="%s">في صفحة الملف الشخصي</a>.',
			'email_sent_to' => 'أرسلنا إليك رسالة بريد إلكتروني على <strong>%s</strong>. يرجى اتباع تعليماتها للتحقق من عنوانك.',
			'feedback' => array(
				'email_failed' => 'تعذر إرسال رسالة بريد إلكتروني إليك بسبب خطأ في إعدادات الخادم.',
				'email_sent' => 'تم إرسال رسالة بريد إلكتروني إلى عنوانك.',
				'error' => 'فشل التحقق من عنوان البريد الإلكتروني.',
				'ok' => 'تم التحقق من عنوان البريد الإلكتروني هذا.',
				'unnecessary' => 'تم التحقق من عنوان البريد الإلكتروني هذا بالفعل.',
				'wrong_token' => 'فشل التحقق من عنوان البريد الإلكتروني هذا بسبب رمز غير صحيح.',
			),
			'need_to' => 'تحتاج إلى التحقق من عنوان بريدك الإلكتروني قبل أن تتمكن من استخدام %s.',
			'resend_email' => 'إعادة إرسال البريد الإلكتروني',
			'title' => 'التحقق من عنوان البريد الإلكتروني',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'لقد سجلت للتو في %s، ولكنك ما زلت بحاجة إلى التحقق من عنوان بريدك الإلكتروني. للقيام بذلك، ما عليك سوى اتباع الرابط:',
			'title' => 'تحتاج إلى التحقق من حسابك',
			'welcome' => 'مرحبًا %s،',
		),
	),
	'password' => array(
		'invalid' => 'كلمة المرور غير صالحة.',
		'provided_password_too_long' => 'The provided password is too long.',	// TODO
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'يجب قبول شروط الخدمة لتتمكن من التسجيل.',
		),
	),
	'username' => array(
		'invalid' => 'اسم المستخدم هذا غير صالح.',
		'taken' => 'اسم المستخدم هذا، %s، محجوز.',
	),
);
